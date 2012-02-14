<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct()
    {
        // Call the Controller constructor
        parent::__construct();
		
		$this->load->model('adminmod');
		$this->load->model('loginmod');
		$this->load->model('newsmod');
		$this->load->model('pagesmod');
    }
	
	public function index()
	{
		if(!$this->loginmod->checkLogin('admin'))
			redirect('admin/login');
			
		$data['news'] = $this->newsmod->getNews();
		$settings = $this->adminmod->getSettings()->result_array();
		$data['settings'] = array();
		foreach($settings as $setting)
			$data['settings'][$setting['setting_name']] = $setting['setting_value'];
		
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
			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|is_unique[admin.username]');
			$this->form_validation->set_message('is_unique','An admin with that username already exists.');
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
			$this->form_validation->set_rules('first', 'First Name', 'trim|required');
			$this->form_validation->set_rules('last', 'Last Name', 'trim|required');
			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
			$this->form_validation->set_rules('subject', 'Subject', 'trim|required');
			if($this->form_validation->run()) {
				$username = substr($this->input->post('first'), 0, 1).$this->input->post('last');
				$newPass = $this->adminmod->addTeacher($username);
				$this->load->library('email');
				$this->email->subject('HTHS Website Account Activation');
				$this->email->to($this->input->post('email'));
				$this->email->from('noreply@hths.mcvsd.org', 'HTHS Security Robot');
				$this->email->message('Your High Technology High School website teacher account has been successfully created.

Username: '.$username.'
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
	
	public function teachers()
	{
		if(!$this->loginmod->checkLogin('admin'))
			redirect('admin/login');
			
		$data['teachers'] = $this->adminmod->getTeacherList();
		
		$this->load->view('wrapper/admin/header');
		$this->load->view('admin/manage_teachers',$data);
		$this->load->view('wrapper/admin/footer');
	}
	
	public function edit_teacher($id)
	{
		if(!$this->loginmod->checkLogin('admin'))
			redirect('admin/logout');
			
		$this->load->library('form_validation');

		if(count($_POST) > 0) {
			$this->form_validation->set_rules('first', 'First Name', 'trim|required');
			$this->form_validation->set_rules('last', 'Last Name', 'trim|required');
			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
			$this->form_validation->set_rules('subject', 'Subject', 'trim|required');
			if($this->form_validation->run()) {
				$username = substr($this->input->post('first'), 0, 1).$this->input->post('last');
				$this->adminmod->editTeacher($id, $username);
				redirect('admin/teachers');
			}
			else
				redirect('admin/teachers?error');
		}
		
		redirect('admin/teachers?error');
	}
	
	public function delete_teacher($id)
	{		
		if(!$this->loginmod->checkLogin('admin'))
			redirect('admin/login');
			
		$this->adminmod->deleteTeacher($id);
		redirect('admin/teachers');
	}
	
	public function add_page()
	{
		if(!$this->loginmod->checkLogin('admin'))
			redirect('admin/login');
			
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[5]|is_unique[pages.title]');
		$this->form_validation->set_message('is_unique','A page with that title already exists.');
		$this->form_validation->set_rules('contents', 'Page Contents', 'trim|required');
		
		if(count($_POST) > 0) {
			if($this->form_validation->run()) {
				$this->pagesmod->addPage();
				redirect('admin/pages');
			}
		}
				
		
		$this->load->view('wrapper/admin/header');
		$this->load->view('admin/add_page');
		$this->load->view('wrapper/admin/footer');
	}
	
	public function pages()
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
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[5]');
		$this->form_validation->set_rules('contents', 'Page Contents', 'trim|required');
		
		if(count($_POST) > 0) {
			if($this->form_validation->run()) {
				$this->pagesmod->updatePage($id);
				redirect('admin/pages');
			}
		}

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
		
		$this->pagesmod->deletePage($id);
		redirect('admin/pages');
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
				$this->newsmod->addNews();
				
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
		$data['news'] = $this->newsmod->getNews(true, 0, true);
		
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
				$this->newsmod->editNews($id);
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
		
		$this->newsmod->deleteNews($id);	
		redirect('admin/news');
	}
	
	public function settings()
	{
		if(!$this->loginmod->checkLogin('admin'))
			redirect('admin/login');
			
		$this->load->library('form_validation');
		
		if(count($_POST) > 0)
			$this->adminmod->saveSettings();
		
		$settings = $this->adminmod->getSettings()->result_array();
		$data['settings'] = array();
		foreach($settings as $setting)
			$data['settings'][$setting['setting_name']] = $setting['setting_value'];
		
		$this->load->view('wrapper/admin/header');
		$this->load->view('admin/settings',$data);
		$this->load->view('wrapper/admin/footer');
	}
	
}