<?php
if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Teachers_dashboard extends CI_Controller {

	function __construct()
	{
		//Call controller constructor
		parent::__construct();
        
		$this->load->model('teachermod');
		$this->load->model('loginmod');
        
        if ($this->loginmod->checkLogin('teacher')) {
            $isAuthorized = true; 
        } else {
            $isAuthorized = false;
        }
	}
    
	public function login()
	{
		$data['loginFailed'] = false;
		
		if ($isLoggedIn) {
            redirect('teachers');
        }
			
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
		
        display_output('teacher/login', $data, ['section' => 'teacher']);
	}
	
	public function logout()
	{
		if(!$this->loginmod->checkLogin('teacher'))
			redirect('teachers/login');
		
		$this->session->sess_destroy();
        
        display_output('teacher/logout', null, ['section' => 'teacher']);
	}
	
	public function change_password()
	{
		if(!$this->loginmod->checkLogin('teacher'))
			redirect('teachers/login');
		
		if(count($_POST) > 0)
			if($this->loginmod->changePassword('teacher'))
		
        display_output('teacher/change_password', null, ['section' => 'teacher']);
	}
	
	
	public function edit_page()
	{
		if(!$this->loginmod->checkLogin('teacher'))
			redirect('teachers');

		if(count($_POST) > 0)
			$this->teachermod->editPage();
		
		$data['contents'] = $this->teachermod->getPage();
		
        display_output('teacher/editPage', null, ['section' => 'teacher']);
	}
	
	public function add_blog_entry()
	{
		if(!$this->loginmod->checkLogin('teacher'))
			redirect('teachers');
			
		if(count($_POST) > 0)
			$this->teachermod->addBlogEntry();

        display_output('teacher/add_blog', null, ['section' => 'teacher']);
	}
	
	public function manage_blog()
	{
		if(!$this->loginmod->checkLogin('teacher'))
			redirect('teachers');
			
		$data['entries'] = $this->teachermod->getBlogEntries($this->session->userdata('id'),0,0,true);
		
        display_output('teacher/manage_blog', $data, ['section' => 'teacher']);
	}
	
	public function edit_blog($id)
	{
		if(!$this->loginmod->checkLogin('teacher'))
			redirect('teachers');
		
		if(count($_POST) > 0)
			$this->teachermod->editBlogEntry($id);

		$data['entry'] = $this->teachermod->getBlogById($id);
		
        display_output('teacher/edit_blog', $data, ['section' => 'teacher']);
	}
		

	public function delete_blog($id)
	{
		if(!$this->loginmod->checkLogin('teacher'))
			redirect('teachers');
		
		if(count($_POST) > 0)
			$this->teachermod->deleteBlogEntry($id);
        
        display_output('teacher/delete_blog', null, ['section' => 'teacher']);
	}
    
}