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
			$this->form_validation->set_rules('password', 'Current Password', 'trim|required|callback_check_password');
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
'.site_url('teachers/dashboard').'

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
				if(file_exists('images/teachers/'.$this->input->post('old_username',TRUE).'.png'))
					rename('images/teachers/'.$this->input->post('old_username',TRUE).'.png', 'images/teachers/'.$username.'.png');
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
'.site_url('teachers/dashboard').'

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
	
	public function edit_menu($command = 'editor') {
		if(!$this->isLoggedIn)
			redirect('admin/login');
		
		$this->load->library('menu');
		if ($command == 'get') {
			$data['text'] = $this->menu->get_menu_data(true, 'menu');
			$this->output->enable_profiler(false);
			$this->load->view('raw_text', $data);
		} else if ($command == 'save') {
			$this->menu->save_menu_data($_POST['menu'], true, 'menu');
			$data['text'] = 'Saved successfuly.';
			$this->output->enable_profiler(false);
			$this->load->view('raw_text', $data);
		} else {
			$this->output->display_output('admin/edit_menu', null, array('section' => 'admin'));
		}
	} 
	
	public function update()
	{
		if(!$this->isLoggedIn)
			redirect('admin/login');
			
		$this->load->model('curlmod');
		
		if(count($_POST) > 0) {
			if($this->input->post('submit') == 'Check For Updates') {
				$data['update'] = $this->curlmod->checkForUpdates($this->input->post('url',TRUE));
				$this->output->display_output('admin/update', $data, array('section' => 'admin'));
			}
			else if($this->input->post('submit') == 'Install Update') {
				$data['changes'] = 'No changelog supplied.';
				$this->curlmod->fetchUpdate($this->input->post('url',TRUE));
				$zip = zip_open('application/cache/update.zip');
				while($file = zip_read($zip)) {
					if(zip_entry_name($file) == '1database.txt') {
						zip_entry_open($zip, $file);
						$this->db->query(zip_entry_read($file, zip_entry_filesize($file)));
						zip_entry_close($file);
					}
					else if(zip_entry_name($file) == '2convert.php') {
						zip_entry_open($zip, $file);
						$fh = fopen('convert.php', 'w');
						fwrite($fh, zip_entry_read($file, zip_entry_filesize($file)));
						fclose($fh);
						$this->curlmod->runUpdateScript();
						unlink('convert.php');
						zip_entry_close($file);
					}
					else if(zip_entry_name($file) == '3changelog.txt') {
						zip_entry_open($zip, $file);
						$data['changes'] = zip_entry_read($file, zip_entry_filesize($file));
						zip_entry_close($file);
					}	
					else if(strpos(zip_entry_name($file), '4files') !== false) {
						zip_entry_open($zip, $file);
						$name = zip_entry_name($file);
						if($name[strlen($name)-1] != '/') {
							$fh = fopen(str_replace('4files/', '', zip_entry_name($file)), 'w');
							fwrite($fh, zip_entry_read($file, zip_entry_filesize($file)));
							fclose($fh);
						}
						zip_entry_close($file);
					}
					else if(zip_entry_name($file) == '5deletions.txt') {
						zip_entry_open($zip, $file);
						$dels = explode(',', zip_entry_read($file, zip_entry_filesize($file)));
						foreach($dels as $del)
							unlink($del);
						zip_entry_close($file);
					}
				}
				zip_close($zip);
				unlink('application/cache/update.zip');
				$this->adminmod->setNewVersion($this->curlmod->checkForUpdates($this->input->post('url',TRUE)));
				$this->output->display_output('admin/update_success', $data, array('section' => 'admin'));
			}
		}
		else
			$this->output->display_output('admin/update_check', null, array('section' => 'admin'));
	}
}