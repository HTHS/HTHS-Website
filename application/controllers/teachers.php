<?php

class Teachers extends CI_Controller {

	function __construct()
	{
		//Call controller constructor
		parent::__construct();
		
		$this->load->model('teachermod');
		$this->load->model('loginmod');
	}
	
	public function index()
	{
		if(!$this->loginmod->checkLogin('teacher'))
			redirect('teachers/login');
		
		$data = array();
		
		$this->load->view('wrapper/teacher/header');
		$this->load->view('teacher/index',$data);
		$this->load->view('wrapper/teacher/footer');
	}
	
	public function login()
	{
		$data['loginFailed'] = false;
		
		if($this->loginmod->checkLogin('teacher'))
			redirect('teachers');
			
		if(count($_POST) > 0)
		{
			if($this->loginmod->checkPassword('teacher', $this->loginmod->getUserId('teacher'))) 
			{
				$this->loginmod->addSession('teacher');
				redirect('teachers');
			}
			else
				$data['loginFailed'] = true;
		}
		
		$this->load->view('wrapper/teacher/header');
		$this->load->view('teacher/login', $data);
		$this->load->view('wrapper/teacher/footer');
	}
	
	public function logout()
	{
		if(!$this->loginmod->checkLogin('teacher'))
			redirect('teachers/login');
		
		$this->session->sess_destroy();
		$this->load->view('wrapper/teacher/header');
		$this->load->view('teacher/logout');
		$this->load->view('wrapper/teacher/footer');
	}
	
	public function change_password()
	{
		if(!$this->loginmod->checkLogin('teacher'))
			redirect('teachers/login');
		
		if(count($_POST) > 0)
			if($this->loginmod->changePassword('teacher'))
		
		$this->load->view('wrapper/teacher/header');
		$this->load->view('teacher/change_password');
		$this->load->view('wrapper/teacher/footer');
	}
	
	
	public function edit_page()
	{
		if(!$this->loginmod->checkLogin('teacher'))
			redirect('teachers');

		if(count($_POST) > 0)
			$this->teachermod->editPage();
		
		$data['contents'] = $this->teachermod->getPage();
		
		$this->load->view('wrapper/teacher/header');
		$this->load->view('teacher/editPage');
		$this->load->view('wrapper/teacher/footer');
	}
	
	public function add_blog_entry()
	{
		if(!$this->loginmod->checkLogin('teacher'))
			redirect('teachers');
			
		if(count($_POST) > 0)
			$this->teachermod->addBlogEntry();

		$this->load->view('wrapper/teacher/header');
		$this->load->view('teacher/add_blog');
		$this->load->view('wrapper/teacher/footer');
	}
	
	public function manage_blog()
	{
		if(!$this->loginmod->checkLogin('teacher'))
			redirect('teachers');
			
		$data['entries'] = $this->teachermod->getBlogEntries($this->session->userdata('id'),0,0,true);
		
		$this->load->view('wrapper/teacher/header');
		$this->load->view('teacher/manage_blog',$data);
		$this->load->view('wrapper/teacher/footer');
	}
	
	public function edit_blog($id)
	{
		if(!$this->loginmod->checkLogin('teacher'))
			redirect('teachers');
		
		if(count($_POST) > 0)
			$this->teachermod->editBlogEntry($id);

		$data['entry'] = $this->teachermod->getBlogById($id);
		
		$this->load->view('wrapper/teacher/header');
		$this->load->view('teacher/edit_blog',$data);
		$this->load->view('wrapper/teacher/footer');
	}
		

	public function delete_blog($id)
	{
		if(!$this->loginmod->checkLogin('teacher'))
			redirect('teachers');
		
		if(count($_POST) > 0)
			$this->teachermod->deleteBlogEntry($id);

		$this->load->view('wrapper/teacher/header');
		$this->load->view('teacher/delete_blog');
		$this->load->view('wrapper/teacher/footer');
	}
}