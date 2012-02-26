<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	protected $isLoggedIn = false;
	
	function __construct()
    {
        // Call the Controller constructor
        parent::__construct();
		
		$this->load->model('adminmod');
		$this->load->model('loginmod');
		$this->load->model('newsmod');
		$this->load->model('pagesmod');
		
		if($this->loginmod->checkLogin('admin'))
			$this->isLoggedIn = true;
    }
	
	public function index()
	{
		if(!$this->isLoggedIn)
			redirect('admin/login');
			
		$data['news'] = $this->newsmod->getNews();
		$settings = $this->adminmod->getSettings()->result_array();
		$data['settings'] = array();
		foreach($settings as $setting)
			$data['settings'][$setting['setting_name']] = $setting['setting_value'];
		
		$this->output->display_output('admin/index', $data, array('section' => 'admin'));
	}
	
	public function login()
	{
		if($this->isLoggedIn)
			redirect('admin');
			
		$this->load->library('form_validation');
		
		if(count($_POST) > 0)
		{
			$this->form_validation->set_rules('username', 'Username', 'trim|required|is_not_unique[admin.username]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_password');
			$this->form_validation->set_message('is_not_unique','Your username was not found.');
			$this->form_validation->set_message('check_password','Your password was incorrect.');
			if($this->form_validation->run()) {
				$this->loginmod->addSession('admin');
				redirect('admin');
			}
		}
		
		$this->output->display_output('admin/login');
	}
	
	public function check_password()
	{
		return $this->loginmod->checkPassword('admin', $this->loginmod->getUserId('admin'));
	}
	
	public function logout()
	{
		if(!$this->isLoggedIn)
			redirect('admin/login');
			
		$this->session->sess_destroy();
		redirect();
	}
	
	public function change_password()
	{
		if(!$this->isLoggedIn)
			redirect('admin/login');

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
		}
		
		$this->output->display_output('admin/change_password', array(), array('section' => 'admin'));
	}
	
	public function add_admin()
	{
		if(!$this->isLoggedIn)
			redirect('admin/login');
			
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
		}
		
		$this->output->display_output('admin/add_admin', array(), array('section' => 'admin'));
	}
	
	public function admins()
	{
		if(!$this->isLoggedIn)
			redirect('admin/login');
			
		$data['admins'] = $this->adminmod->getAdminList();
		
		$this->output->display_output('admin/manage_admins', $data, array('section' => 'admin'));
	}

	public function delete_admin($id)
	{
		if(!$this->isLoggedIn)
			redirect('admin/login');
		
		$this->adminmod->deleteAdmin($id);
		redirect('admin/admins');
	}
	
	public function add_teacher()
	{
		if(!$this->isLoggedIn)
			redirect('admin/login');
			
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
'.site_url('teacher').'

Thank You,
The HTHS Web Team');

				$this->email->send();
				
				redirect('admin/teachers');
			}
		}
		
		$this->output->display_output('admin/add_teacher', array(), array('section' => 'admin'));
	}
	
	public function teachers()
	{
		if(!$this->isLoggedIn)
			redirect('admin/login');
			
		$data['teachers'] = $this->adminmod->getTeacherList();
		
		$this->output->display_output('admin/manage_teachers', $data, array('section' => 'admin'));
	}
	
	public function edit_teacher($id)
	{
		if(!$this->isLoggedIn)
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
	
	public function reset_teacher_password($id)
	{
		if(!$this->isLoggedIn)
			redirect('admin/logout');
		
		$newPass = $this->loginmod->changePassword('teacher',$id);
		$teacher = $this->adminmod->getTeacher($id);
		
		$this->load->library('email');
		$this->email->subject('HTHS Website Account Password Reset');
		$this->email->to($teacher->email);
		$this->email->from('noreply@hths.mcvsd.org', 'HTHS Security Robot');
		$this->email->message('Your High Technology High School website teacher account password has been successfully reset.

Username: '.$teacher->username.'
Password: '.$newPass.'

Please use the link below to access the administrator panel, one you login you can change your password within the panel.
'.site_url('teacher').'

Thank You,
The HTHS Web Team');

		$this->email->send();
		redirect('admin/teachers');
	}
	
	public function delete_teacher($id)
	{		
		if(!$this->isLoggedIn)
			redirect('admin/login');
			
		$this->adminmod->deleteTeacher($id);
		redirect('admin/teachers');
	}
	
	public function add_page()
	{
		if(!$this->isLoggedIn)
			redirect('admin/login');
			
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[5]|is_unique[pages.title]');
		$this->form_validation->set_rules('url', 'URL', 'trim|required|min_length[4]|is_unique[pages.url]');
		$this->form_validation->set_message('is_unique','A page with that title or URL already exists.');
		$this->form_validation->set_rules('contents', 'Page Contents', 'trim|required');
		
		if(count($_POST) > 0) {
			if($this->form_validation->run()) {
				$this->pagesmod->addPage();
				redirect('admin/pages');
			}
		}
				
		
		$this->output->display_output('admin/add_page', array(), array('section' => 'admin'));
	}
	
	public function pages()
	{
		if(!$this->isLoggedIn)
			redirect('admin/login');
		
		$data['pages'] = $this->pagesmod->getPageList();
		
		$this->output->display_output('admin/manage_pages', $data, array('section' => 'admin'));
	}
	
	public function edit_page($id)
	{
		if(!$this->isLoggedIn)
			redirect('admin/login');
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[5]');
		$this->form_validation->set_rules('url', 'URL', 'trim|required|min_length[4]');
		$this->form_validation->set_rules('contents', 'Page Contents', 'trim|required');
		
		if(count($_POST) > 0) {
			if($this->form_validation->run()) {
				$this->pagesmod->updatePage($id);
				redirect('admin/pages');
			}
		}

		$data['page'] = $this->pagesmod->getPageById($id);
		
		$this->output->display_output('admin/edit_page', $data, array('section' => 'admin'));
	}
	
	public function delete_page($id)
	{
		if(!$this->isLoggedIn)
			redirect('admin/login');
		
		$this->pagesmod->deletePage($id);
		redirect('admin/pages');
	}
	
	public function add_news()
	{
		if(!$this->isLoggedIn)
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
	
		$this->output->display_output('admin/add_news', array(), array('section' => 'admin'));
	}
	
	public function news()
	{
		if(!$this->isLoggedIn)
			redirect('admin/login');
			
		$this->load->helper('date');
		$data['news'] = $this->newsmod->getNews(true, 0, true);
		
		$this->output->display_output('admin/manage_news', $data, array('section' => 'admin'));
	}
	
	public function edit_news($id)
	{
		if(!$this->isLoggedIn)
			redirect('admin/login');
			
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
		}
		
		$this->output->display_output('admin/edit_news', array(), array('section' => 'admin'));
	}
	
	public function delete_news($id)
	{
		if(!$this->isLoggedIn)
			redirect('admin/login');
		
		$this->newsmod->deleteNews($id);	
		redirect('admin/news');
	}
	
	public function settings()
	{
		if(!$this->isLoggedIn)
			redirect('admin/login');
			
		$this->load->library('form_validation');
		
		if(count($_POST) > 0)
			$this->adminmod->saveSettings();
		
		$settings = $this->adminmod->getSettings()->result_array();
		$data['settings'] = array();
		foreach($settings as $setting)
			$data['settings'][$setting['setting_name']] = $setting['setting_value'];
		
		$this->output->display_output('admin/settings', $data, array('section' => 'admin'));
	}
	
	public function download_categories()
	{
		if(!$this->isLoggedIn)
			redirect('admin/login');
		
		if(count($_POST) > 0) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('category', 'Category', 'trim|required');
			if($this->form_validation->run())
				$this->pagesmod->addCategory();
		}
		
		$data['unusedTypes'] = $this->pagesmod->listFormTypes(true,true);
		$data['usedTypes'] = $this->pagesmod->listFormTypes();
		
		$this->output->display_output('admin/download_categories', $data, array('section' => 'admin'));
	}
	
	public function delete_category($id)
	{
		if(!$this->isLoggedIn)
			redirect('admin/login');
		
		$this->pagesmod->deleteCategory($id);
		redirect('admin/download_categories');
	}
	
	public function downloads()
	{
		if(!$this->isLoggedIn)
			redirect('admin/login');
			
		$this->load->library('form_validation');
		
		if(count($_POST) > 0) {
			$config['upload_path'] = 'downloads/';
			$config['allowed_types'] = 'doc|docx|xls|xlsx|ppt|pptx|pdf';
			$this->load->library('upload',$config);
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			if($this->form_validation->run()){
				$this->upload->do_upload('form');
				$data['errors'] = $this->upload->display_errors();
				$uploadData = $this->upload->data();
				if($data['errors'] == '')
					$this->pagesmod->addForm($uploadData['file_name']);
			}
		}
		$data['types'] = $this->pagesmod->listFormTypes(true);
		foreach($data['types']->result() as $type)
			$data['forms'][$type->type] = $this->pagesmod->getFormList($type->id, true);
			
		$this->output->display_output('admin/downloads', $data, array('section' => 'admin'));
	}
	
	public function archive($id)
	{	
		if(!$this->isLoggedIn)
			redirect('admin/login');
		
		$this->pagesmod->archive(true, $id);
		redirect('admin/downloads');
	}
	
	public function unarchive($id)
	{	
		if(!$this->isLoggedIn)
			redirect('admin/login');
		
		$this->pagesmod->archive(false, $id);
		redirect('admin/downloads');
	}
	
	public function delete_form($id)
	{	
		if(!$this->isLoggedIn)
			redirect('admin/login');
		
		$this->pagesmod->deleteForm($id);
		redirect('admin/downloads');
	}
	
	public function edit_menu($command = 'editor') {
		$this->load->library('menu');
		if ($command == 'get') {
			$data['text'] = $this->menu->get_menu_data(true);
			$this->output->enable_profiler(false);
			$this->load->view('raw_text', $data);
		} else if ($command == 'save') {
			$this->menu->save_menu_data($_POST['menu'], true);
			$data['text'] = 'Saved successfuly.';
			$this->output->enable_profiler(false);
			$this->load->view('raw_text', $data);
		} else {
			$this->output->display_output('admin/edit_menu', null, array('section' => 'admin'));
		}
	} 
}