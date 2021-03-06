<?php
if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class News extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('newsmod');
    }
    
    public function index($page = 1)
    {
        $this->page($page);
    }
    
	public function page($page = 1)
	{
		$this->load->library('pagination');
		$config['base_url'] = $this->config->item('base_url').'news/page/';
		$config['total_rows'] =  $this->newsmod->countNewsItems();
		$config['per_page'] = 5;
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		$config['full_tag_open'] = '<p style="text-align:center;">';
        $config['use_page_numbers'] = true;
		$this->pagination->initialize($config);
		
		$data['posts'] = $this->newsmod->getNews(5, (($page - 1) * $config['per_page']));
		$data['pageLinks'] = $this->pagination->create_links();
		
		$this->output->display_output('news/archive', $data);
	}
    
    public function view($id = null)
    {
        if ($id == null) {
            redirect('news');
        }
        
        $data['item'] = $this->newsmod->getNewsItem($id);
        
        $this->output->display_output('news/view', $data);
    }
    
    public function subscribe()
	{
		$this->load->model('emailmod');
        $this->load->library('form_validation');
		
		if(count($_POST) > 0)
		{
			if($this->input->post('submit') == 'Subscribe') { 
				$this->form_validation->set_rules('email_address', 'Email Address', 'trim|valid_email|required|is_unique[parent_emails.email_address]');
				$this->form_validation->set_message('is_unique','The email address you entered is already subscribed.');
				if($this->form_validation->run()) {
					$this->emailmod->registerEmail();
					$this->load->view('news/subscribe_add_success');
				}
				else
					$this->output->display_output('news/subscribe');
			}
			else if($this->input->post('submit') == 'Unsubscribe') {
				$this->form_validation->set_rules('email_address', 'Email Address', 'trim|valid_email|required|is_not_unique[parent_emails.email_address]');
				$this->form_validation->set_message('is_not_unique','The email address you entered is not currently subscribed.');
				if($this->form_validation->run()) {
					$this->emailmod->removeEmail();
					$this->output->display_output('news/subscribe_remove_success');
				}
				else
					$this->output->display_output('news/subscribe');
			}
		}
		else
			$this->output->display_output('news/subscribe');
	}
    
}