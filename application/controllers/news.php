<?php
if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class News extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('newsmod');
    }
    
	public function index($entryNum = 0)
	{
		$this->load->library('pagination');
		$config['base_url'] = $this->config->item('base_url').'home/archive/';
		$config['total_rows'] =  $this->newsmod->countNewsItems();
		$config['per_page'] = 5;
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		$config['full_tag_open'] = '<p style="text-align:center;">';
		$this->pagination->initialize($config);
		
		$data['posts'] = $this->newsmod->getNews(5, $entryNum);
		$data['pageLinks'] = $this->pagination->create_links();
		
		$this->load->view('wrapper/header');
		$this->load->view('news/archive',$data);
		$this->load->view('wrapper/footer');
	}
    
    public function view($id = null)
    {
        if ($id == null) {
            redirect('news');
        }
        
        $data['item'] = $this->newsmod->getNewsItem($id);
        
        $this->load->view('wrapper/header');
        $this->load->view('news/view', $data);
        $this->load->view('wrapper/footer');
    }
    
}