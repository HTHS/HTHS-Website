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
			redirect('teachers/dashboard/login');
		
		$this->output->display_output('teacher_dashboard/index', array(), array('section' => 'teacher'));
	}
    
	public function login()
	{
		if ($this->isLoggedIn) {
            redirect('teachers/dashboard');
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
				redirect('teachers/dashboard');
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
			redirect('teachers/dashboard/login');
		
		$this->session->sess_destroy();       
		redirect();
	}
	
	public function change_password()
	{
		if(!$this->isLoggedIn)
			redirect('teachers/dashboard/login');

		$this->load->library('form_validation');
		
		if(count($_POST) > 0)
		{
			$this->form_validation->set_rules('password', 'Current Password Password', 'trim|required|callback_check_password');
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]');
			$this->form_validation->set_rules('confirm', 'Confirm New Password', 'trim|required|matches[new_password]');
			$this->form_validation->set_message('check_password','Your password was incorrect.');
			if($this->form_validation->run()) {
				$this->loginmod->changePassword('teacher');
				redirect('teachers/dashboard');
			}
		}
		
		$this->output->display_output('teacher_dashboard/change_password', array(), array('section' => 'teacher'));
	}
	
	public function add_page()
	{
		if(!$this->isLoggedIn)
			redirect('teachers/dashboard/login');
			
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[5]|is_unique[teacher_pages.page_title]');
		$this->form_validation->set_rules('url', 'URL', 'trim|required|min_length[4]|is_unique[teacher_pages.page_url]');
		$this->form_validation->set_message('is_unique','A page with that title or URL already exists.');
		$this->form_validation->set_rules('contents', 'Page Contents', 'trim|required');
		
		if(count($_POST) > 0) {
			if($this->form_validation->run()) {
				$this->teachermod->addPage();
				redirect('teachers/dashboard/pages');
			}
		}
				
		
		$this->output->display_output('teacher_dashboard/add_page', array(), array('section' => 'teacher'));
	}
	
	
	public function pages()
	{
		if(!$this->isLoggedIn)
			redirect('teachers/dashboard/login');
			
		$data['pages'] = $this->teachermod->getPageList($this->session->userdata('id'));
		
		$this->output->display_output('teacher_dashboard/manage_pages', $data, array('section' => 'teacher'));
	}
	
	public function edit_page($id)
	{
		if(!$this->isLoggedIn)
			redirect('teachers/dashboard/login');
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[5]');
		$this->form_validation->set_rules('url', 'URL', 'trim|required|min_length[4]');
		$this->form_validation->set_rules('contents', 'Page Contents', 'trim|required');
		
		if(count($_POST) > 0) {
			if($this->form_validation->run()) {
				$this->teachermod->editPage($id);
				redirect('teachers/dashboard/pages');
			}
		}

		$data['page'] = $this->teachermod->getPageById($id);
		
		$this->output->display_output('teacher_dashboard/edit_page', $data, array('section' => 'teacher'));
	}
	
	public function delete_page($id)
	{
		if(!$this->isLoggedIn)
			redirect('teachers/dashboard/login');
			
		$this->teachermod->deletePage($id);
		redirect('teachers/dashboard/pages');
	}
    
	public function about()
	{
		if(!$this->isLoggedIn)
			redirect('teachers/dashboard/login');
		
		$this->load->library('form_validation');
			
		if(count($_POST) > 0) {
			$this->form_validation->set_rules('description', 'About Me', 'trim|required');
			if($this->form_validation->run()) {
				$this->teachermod->updateInfo();
				redirect('teachers/dashboard');
			}
		}
		
		$data['about'] = $this->teachermod->getTeacherInfo($this->session->userdata('id'));
		
		$this->output->display_output('teacher_dashboard/edit_about', $data, array('section' => 'teacher'));
	}
	
	public function photo()
	{
		if(!$this->isLoggedIn)
			redirect('teachers/dashboard/login');
			
		$data['teacher'] = $this->teachermod->getTeacherInfo($this->session->userdata('id'));
		
		$config['upload_path'] = 'images/teachers/';
		$config['overwrite'] = true;
		$config['max_size'] = 2000;
		$config['file_name'] = $data['teacher']->username;
		$config['allowed_types'] = 'png';
		$this->load->library('upload', $config);
		
		if(count($_POST) > 0) {
			if($this->input->post('submit') == 'Upload') {
				if($this->upload->do_upload('photo'))
					redirect('teachers/dashboard/photo');
			} else if($this->input->post('submit') == 'Delete Photo') {
				unlink('images/teachers/'.$data['teacher']->username.'.png');
				redirect('teachers/dashboard');
			}
		}
		
		$this->output->display_output('teacher_dashboard/upload_photo', $data, array('section' => 'teacher'));
	}
}