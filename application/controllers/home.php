<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
    {
        // Call the Controller constructor
        parent::__construct();
		
		$this->load->model('newsmod');
		$this->load->model('teachermod');
		$this->load->model('emailmod');
		$this->load->model('pagesmod');
    }
	
	public function index()
	{
		$data['news'] = $this->newsmod->getNews();
		
		$this->load->view('wrapper/header');
		$this->load->view('home/index',$data);
		$this->load->view('wrapper/footer');
	}
	
	public function subscribe()
	{
		$this->load->view('wrapper/header');
		$this->load->library('form_validation');
				
		if(count($_POST) > 0)
		{
			if($this->input->post('submit') == 'Subscribe') { 
				$this->form_validation->set_rules('email_address', 'Email Address', 'trim|valid_email|required|is_unique[parent_emails.email_address]');
				$this->form_validation->set_message('is_unique','The email address you entered is already subscribed.');
				if($this->form_validation->run()) {
					$this->emailmod->registerEmail();
					$this->load->view('home/register_success');
				}
				else
					$this->load->view('home/subscribe');
			}
			else if($this->input->post('submit') == 'Unsubscribe') {
				$this->form_validation->set_rules('email_address', 'Email Address', 'trim|valid_email|required|is_not_unique[parent_emails.email_address]');
				$this->form_validation->set_message('is_not_unique','The email address you entered is not currently subscribed.');
				if($this->form_validation->run()) {
					$this->emailmod->removeEmail();
					$this->load->view('home/unregister_success');
				}
				else
					$this->load->view('home/subscribe');
			}
		}
		else
			$this->load->view('home/subscribe');
	
		$this->load->view('wrapper/footer');
	}
	
	public function faculty()
	{
		$this->load->helper('captcha');
		$this->load->model('captcha');
		$data['teachers'] = $this->teachermod->getTeacherList();
		
		$vals = array(
			'img_path'	 => 'images/verification/',
			'img_url'	 => site_url('images/verification').'/',
			'img_width'	 => 150,
			'img_height' => 50,
			);

		$data['cap'] = create_captcha($vals);
		$this->captcha->addCaptcha($data['cap']);
		
		$this->load->view('wrapper/header');
		$this->load->view('home/faculty',$data);
		$this->load->view('wrapper/footer');
	}
	
	public function teacher_pages($id = 0)
	{
		if($id == 0)
			show_404();
			
		$data['page'] = $this->teachermod->getPage($id);
		$data['teacher'] = $this->teachermod->getTeacherInfo($id);
		
		$this->load->view('wrapper/header');
		$this->load->view('home/teacher_pages',$data);
		$this->load->view('wrapper/footer');
	}
	
	public function blogs($id = 0, $entryNum = 0)
	{
		if($id == 0)
			show_404();
			
		$data['blog'] = $this->teachermod->getBlogEntries($id, 10, $entryNum);
		$data['teacher'] = $this->teachermod->getTeacherInfo($id);
			
		$this->load->library('pagination');
		$config['base_url'] = $this->config->item('base_url').'home/blogs/'.$id.'/';
		$config['total_rows'] =  $this->teachermod->countBlogEntries($id);
		$config['per_page'] = 10;
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		$config['full_tag_open'] = '<p style="text-align:center;">';
		$this->pagination->initialize($config);
		$data['page_links'] = $this->pagination->create_links();
		
		$this->load->view('wrapper/header');
		$this->load->view('home/blogs',$data);
		$this->load->view('wrapper/footer');
	}
	
	public function downloads()
	{
		$data['types'] = $this->pagesmod->listFormTypes();
		foreach($data['types']->result() as $type)
			$data['forms'][$type->type] = $this->pagesmod->getFormList($type->id);
	
		$this->load->view('wrapper/header');
		$this->load->view('home/downloads',$data);
		$this->load->view('wrapper/footer');
	}
	
	public function search()
	{
		$this->load->view('wrapper/header');
		$this->load->view('home/search');
		$this->load->view('wrapper/footer');
	}

}