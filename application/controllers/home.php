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
		
		$this->output->display_output('home/index', $data);
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
		
		$this->output->display_output('home/faculty',$data);
	}
	
	public function teacher_pages($id = 0)
	{
		if($id == 0)
			show_404();
			
		$data['page'] = $this->teachermod->getPage($id);
		$data['teacher'] = $this->teachermod->getTeacherInfo($id);
		
		$this->output->display_output('home/teacher_pages',$data);
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
		
		$this->output->display_output('home/blogs',$data);
	}
	
	public function search()
	{
		$this->output->display_output('home/search');
	}

}