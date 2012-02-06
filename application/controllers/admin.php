<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct()
    {
        // Call the Controller constructor
        parent::__construct();
		
		$this->load->model('adminmod');
		$this->load->model('loginmod');
		$this->load->model('news');
		$this->load->model('pagesmod');
    }
	
	public function index()
	{
		if(!$this->loginmod->checkLogin('admin'))
			redirect('admin/login');
			
		$data['news'] = $this->news->getNews();
		$data['settings'] = $this->adminmod->getSettings()->result_array();
		
		$this->load->view('wrapper/admin/header');
		$this->load->view('admin/index',$data);
		$this->load->view('wrapper/admin/footer');
	}
	
	public function login()
	{
		if($this->loginmod->checkLogin('admin'))
			redirect('admin');
			
		$this->load->view('wrapper/header');
		$this->load->library('form_validation');
		
		if(count($_POST) > 0)
		{
			$this->form_validation->set_rules('username', 'Username', 'trim|required|is_not_unique[mentorship_users.username]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_password');
			$this->form_validation->set_message('is_not_unique','Your username was not found.');
			$this->form_validation->set_message('check_password','Your password was incorrect.');
			if($this->form_validation->run()) {
				$this->loginmod->addSession('admin');
				redirect('admin');
			}
			else
				$this->load->view('admin/login');
		}
		else
			$this->load->view('admin/login');
			
		$this->load->view('wrapper/footer');
	}
	
	public function check_password()
	{
		return $this->loginmod->checkPassword('admin', $this->loginmod->getUserId('admin'));
	}
	
	public function logout()
	{
		if(!$this->loginmod->checkLogin('admin'))
			redirect('admin/login');
			
		$this->session->sess_destroy();
		redirect();
	}
	
	public function change_password()
	{
		if(!$this->loginmod->checkLogin('admin'))
			redirect('admin/login');

		$this->load->view('wrapper/admin/header');
		$this->load->library('form_validation');
		
		if(count($_POST) > 0)
		{
			$this->form_validation->set_rules('password', 'Current Password Password', 'trim|required|callback_check_password');
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]');
			$this->form_validation->set_rules('confirm', 'Confirm New Password', 'trim|required|matches[new_password]');
			$this->form_validation->set_message('check_password','Your password was incorrect.');
			if($this->form_validation->run()) {
				$this->loginmod->changePassword('admin');
				redirect('admin');
			}
			else
				$this->load->view('admin/change_password');
		}
		else
			$this->load->view('admin/change_password');
		
		$this->load->view('wrapper/admin/footer');
	}
	
	public function add_admin()
	{
		if(!$this->loginmod->checkLogin('admin'))
			redirect('admin/login');
			
		$this->load->view('wrapper/admin/header');
		$this->load->library('form_validation');

		if(count($_POST) > 0) {
			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]');
			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
			if($this->form_validation->run()) {
				$newPass = $this->adminmod->addAdmin();
				$this->load->library('email');
				$this->email->subject('HTHS Website Account Activation');
				$this->email->to($this->input->post('email'));
				$this->email->from('noreply@hths.mcvsd.org', 'HTHS Security Robot');
				$this->email->message('Your High Technology High School website administrator account has been successfully created.

Username: '.$this->input->post('username').'
Password: '.$newPass.'

Please use the link below to access the administrator panel, one you login you can change your password within the panel.
'.site_url('admin').'

Thank You,
The HTHS Web Team');

				$this->email->send();
				
				redirect('admin/admins');
			}
			else
				$this->load->view('admin/add_admin');
		}
		else
			$this->load->view('admin/add_admin');
		
		$this->load->view('wrapper/admin/footer');
	}
	
	public function admins()
	{
		if(!$this->loginmod->checkLogin('admin'))
			redirect('admin/login');
			
		$data['admins'] = $this->adminmod->getAdminList();
		
		$this->load->view('wrapper/admin/header');
		$this->load->view('admin/manage_admins',$data);
		$this->load->view('wrapper/admin/footer');
	}

	public function delete_admin($id)
	{
		if(!$this->loginmod->checkLogin('admin'))
			redirect('admin/login');
		
		$this->adminmod->deleteAdmin($id);
		redirect('admin/admins');
	}
	
	public function add_teacher()
	{
		if(!$this->loginmod->checkLogin('admin'))
			redirect('admin/login');
			
		$this->load->view('wrapper/admin/header');
		$this->load->library('form_validation');

		if(count($_POST) > 0) {
			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]');
			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
			if($this->form_validation->run()) {
				$newPass = $this->adminmod->addTeacher();
				$this->load->library('email');
				$this->email->subject('HTHS Website Account Activation');
				$this->email->to($this->input->post('email'));
				$this->email->from('noreply@hths.mcvsd.org', 'HTHS Security Robot');
				$this->email->message('Your High Technology High School website teacher account has been successfully created.

Username: '.$this->input->post('username').'
Password: '.$newPass.'

Please use the link below to access the administrator panel, one you login you can change your password within the panel.
'.site_url('admin').'

Thank You,
The HTHS Web Team');

				$this->email->send();
				
				redirect('admin/teachers');
			}
			else
				$this->load->view('admin/add_teacher');
		}
		else
			$this->load->view('admin/add_teacher');
		
		$this->load->view('wrapper/admin/footer');
	}
	
	public function manage_teachers()
	{
		if(!$this->loginmod->checkLogin('admin'))
			redirect('admin/login');
			
		$data['admins'] = $this->adminmod->getTeacherList();
		
		$this->load->view('wrapper/admin/header');
		$this->load->view('admin/manage_teachers',$data);
		$this->load->view('wrapper/admin/footer');
	}
	
	public function edit_teacher($id)
	{
		if(!$this->loginmod->checkLogin('admin'))
			redirect('admin/logout');

		if(count($_POST) > 0)
			$this->adminmod->editTeacher($id);
	
		$data['teacher'] = $this->adminmod->getTeacher($id);
		
		$this->load->view('wrapper/admin/header');
		$this->load->view('admin/edit_teacher',$data);
		$this->load->view('wrapper/admin/footer');
	}
	
	public function delete_teacher($id)
	{
		if(!$this->loginmod->checkLogin('admin'))
			redirect('admin/login');
			
		if(count($_POST) > 0)
			$this->adminmod->deleteTeacher($id);
		
		$this->load->view('wrapper/admin/header');
		$this->load->view('admin/delete_teacher');
		$this->load->view('wrapper/admin/footer');
	}
	
	public function add_page()
	{
		if(!$this->loginmod->checkLogin('admin'))
			redirect('admin/login');
			
		$data = Array('failed' => false, 'success' => false, 'contents' => '');
		if(count($_POST) > 0)
		{
			$data['contents'] = $this->input->post('contents');
			
			if($this->pagesmod->addPage()) 
				$data['success'] = true;
			else
				$data['failed'] = true;
		}
		
		$this->load->view('wrapper/admin/header');
		$this->load->view('admin/add_page',$data);
		$this->load->view('wrapper/admin/footer');
	}
	
	public function manage_pages()
	{
		if(!$this->loginmod->checkLogin('admin'))
			redirect('admin/login');
		
		$data['pages'] = $this->pagesmod->getPageList();
		
		$this->load->view('wrapper/admin/header');
		$this->load->view('admin/manage_pages',$data);
		$this->load->view('wrapper/admin/footer');
	}
	
	public function edit_page($id)
	{
		if(!$this->loginmod->checkLogin('admin'))
			redirect('admin/login');
		
		if(count($_POST) > 0)
			$this->pagesmod->updatePage($id);

		$data['page'] = $this->pagesmod->getPageById($id);
		$data['contents'] = read_file('html/'.$data['page']->filename);
		
		$this->load->view('wrapper/admin/header');
		$this->load->view('admin/edit_page',$data);
		$this->load->view('wrapper/admin/footer');
	}
	
	public function delete_page($id)
	{
		if(!$this->loginmod->checkLogin('admin'))
			redirect('admin/login');
		
		if(count($_POST) > 0)
			$this->pagesmod->deletePage($id);
		
		$this->load->view('wrapper/admin/header');
		$this->load->view('admin/delete_page');
		$this->load->view('wrapper/admin/footer');
	}
	
	public function add_news()
	{
		if(!$this->loginmod->checkLogin('admin'))
			redirect('admin/login');

		$this->load->library('form_validation');
		
		if(count($_POST) > 0)
		{		
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('contents', 'Contents', 'required');
			$this->form_validation->set_rules('start', 'Begins On', 'trim|required');
			$this->form_validation->set_rules('expires', 'Ends On', 'trim');
			
			if($this->form_validation->run()) {
				$this->news->addNews();
				
				if($this->input->post('email') == 1) {
				
					$this->load->library('email');
					$this->load->model('emailmod');
					
					$emailList = $this->emailmod->getEmails();
					
$emailSuffix = '

------------

This email was sent automatically from the High Technology High School Website.

To unsubscribe please go to: http://www.hths.mcvsd.org/home/subscribe';
				
					foreach($emailList->result() as $email)
					{
						$this->email->clear();
						
						$this->email->to($email->email_address);
						$this->email->from('noreply@hths.mcvsd.org','High Technology High School');
						$this->email->subject($this->input->post('title'));
						$this->email->message($this->input->post('contents').$emailSuffix);
						
						$this->email->send();
					}
				}
				redirect('admin/news');
			}
		}
	
		$this->load->view('wrapper/admin/header');
		$this->load->view('admin/add_news');
		$this->load->view('wrapper/admin/footer');
	}
	
	public function news()
	{
		if(!$this->loginmod->checkLogin('admin'))
			redirect('admin/login');
			
		$this->load->helper('date');
		$data['news'] = $this->news->getNews(true, 0, true);
		
		$this->load->view('wrapper/admin/header');
		$this->load->view('admin/manage_news',$data);
		$this->load->view('wrapper/admin/footer');
	}
	
	public function edit_news($id)
	{
		if(!$this->loginmod->checkLogin('admin'))
			redirect('admin/login');
			
		$this->load->view('wrapper/admin/header');
		$this->load->library('form_validation');
			
		if(count($_POST) > 0)
		{
			$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('contents', 'Contents', 'required');
			$this->form_validation->set_rules('start', 'Begins On', 'trim|required');
			$this->form_validation->set_rules('expires', 'Ends On', 'trim');
			if($this->form_validation->run())
			{
				$this->news->editNews($id);
				redirect('admin/news');
			}
			else
				$this->load->view('admin/edit_news');
		}
		else
			$this->load->view('admin/edit_news');
			
		$this->load->view('wrapper/admin/footer');
	}
	
	public function delete_news($id)
	{
		if(!$this->loginmod->checkLogin('admin'))
			redirect('admin/login');
		
		$this->news->deleteNews($id);	
		redirect('admin/news');
	}
	
	public function settings()
	{
		if(!$this->loginmod->checkLogin('admin'))
			redirect('admin/login');
			
		$this->load->library('form_validation');
		
		if(count($_POST) > 0)
			if($this->form_validation->run())
				$this->adminmod->saveSettings();
		
		$this->load->view('wrapper/admin/header');
		$this->load->view('admin/settings');
		$this->load->view('wrapper/admin/footer');
	}
	
}