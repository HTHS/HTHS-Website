<?php
if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Teacher_dashboard extends CI_Controller {

	protected $isLoggedIn = false;
	
	function __construct()
	{
		//Call controller constructor
		parent::__construct();
        
		$this->load->model('teachermod');
		$this->load->model('loginmod');
        
        if ($this->loginmod->checkLogin('teacher'))
            $this->isLoggedIn = true; 
	}
	
	public function index()
	{
		if(!$this->isLoggedIn)
			redirect('teacher_dashboard/login');
		
		$this->output->display_output('teacher_dashboard/index', array(), array('section' => 'teacher'));
	}
    
	public function login()
	{
		if ($this->isLoggedIn) {
            redirect('teacher_dashboard');
        }
		
		$this->load->library('form_validation');
			
		if(count($_POST) > 0)
		{
			$this->form_validation->set_rules('username', 'Username', 'trim|required|is_not_unique[teacher.username]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_password');
			$this->form_validation->set_message('is_not_unique','Your username was not found.');
			$this->form_validation->set_message('check_password','Your password was incorrect.');
			if($this->form_validation->run()) {
				$this->loginmod->addSession('teacher');
				redirect('teacher_dashboard');
			}
		}
		
        $this->output->display_output('teacher_dashboard/login', array());
	}
	
	public function check_password()
	{
		return $this->loginmod->checkPassword('teacher', $this->loginmod->getUserId('teacher'));
	}
	
	public function logout()
	{
		if(!$this->isLoggedIn)
			redirect('teacher_dashboard/login');
		
		$this->session->sess_destroy();       
		redirect();
	}
	
	public function change_password()
	{
		if(!$this->isLoggedIn)
			redirect('teacher_dashboard/login');

		$this->load->library('form_validation');
		
		if(count($_POST) > 0)
		{
			$this->form_validation->set_rules('password', 'Current Password Password', 'trim|required|callback_check_password');
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]');
			$this->form_validation->set_rules('confirm', 'Confirm New Password', 'trim|required|matches[new_password]');
			$this->form_validation->set_message('check_password','Your password was incorrect.');
			if($this->form_validation->run()) {
				$this->loginmod->changePassword('teacher');
				redirect('teacher');
			}
		}
		
		$this->output->display_output('teacher_dashboard/change_password', array(), array('section' => 'teacher'));
	}
	
	public function add_page()
	{
		if(!$this->isLoggedIn)
			redirect('teacher_dashboard/login');
			
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[5]|is_unique[teacher_pages.page_title]');
		$this->form_validation->set_rules('url', 'URL', 'trim|required|min_length[4]|is_unique[teacher_pages.page_url]');
		$this->form_validation->set_message('is_unique','A page with that title or URL already exists.');
		$this->form_validation->set_rules('contents', 'Page Contents', 'trim|required');
		
		if(count($_POST) > 0) {
			if($this->form_validation->run()) {
				$this->teachermod->addPage();
				redirect('teacher_dashboard/pages');
			}
		}
				
		
		$this->output->display_output('teacher_dashboard/add_page', array(), array('section' => 'teacher'));
	}
	
	
	public function pages()
	{
		if(!$this->isLoggedIn)
			redirect('teacher_dashboard/login');
			
		$data['pages'] = $this->teachermod->getPageList($this->session->userdata('id'));
		
		$this->output->display_output('teacher_dashboard/manage_pages', $data, array('section' => 'teacher'));
	}
	
	public function edit_page($id)
	{
		if(!$this->isLoggedIn)
			redirect('teacher_dashboard/login');
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[5]');
		$this->form_validation->set_rules('url', 'URL', 'trim|required|min_length[4]');
		$this->form_validation->set_rules('contents', 'Page Contents', 'trim|required');
		
		if(count($_POST) > 0) {
			if($this->form_validation->run()) {
				$this->teachermod->editPage($id);
				redirect('teacher_dashboard/pages');
			}
		}

		$data['page'] = $this->teachermod->getPageById($id);
		
		$this->output->display_output('teacher_dashboard/edit_page', $data, array('section' => 'teacher'));
	}
	
	public function delete_page($id)
	{
		if(!$this->isLoggedIn)
			redirect('teacher_dashboard/login');
			
		$this->teachermod->deletePage($id);
		redirect('teacher_dashboard/pages');
	}
	
	/*public function add_blog_entry()
	{
		if(!$this->loginmod->checkLogin('teacher'))
			redirect('teachers');
			
		if(count($_POST) > 0)
			$this->teachermod->addBlogEntry();

        $this->output->display_output('teacher/add_blog', null, array('section' => 'teacher'));
	}
	
	public function manage_blog()
	{
		if(!$this->loginmod->checkLogin('teacher'))
			redirect('teachers');
			
		$data['entries'] = $this->teachermod->getBlogEntries($this->session->userdata('id'),0,0,true);
		
        $this->output->display_output('teacher/manage_blog', $data, array('section' => 'teacher'));
	}
	
	public function edit_blog($id)
	{
		if(!$this->loginmod->checkLogin('teacher'))
			redirect('teachers');
		
		if(count($_POST) > 0)
			$this->teachermod->editBlogEntry($id);

		$data['entry'] = $this->teachermod->getBlogById($id);
		
        $this->output->display_output('teacher/edit_blog', $data, array('section' => 'teacher'));
	}
		

	public function delete_blog($id)
	{
		if(!$this->loginmod->checkLogin('teacher'))
			redirect('teachers');
		
		if(count($_POST) > 0)
			$this->teachermod->deleteBlogEntry($id);
        
        $this->output->display_output('teacher/delete_blog', null, array('section' => 'teacher'));
	}*/
    
}