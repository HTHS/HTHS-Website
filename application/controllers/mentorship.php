<?php

class Mentorship extends CI_Controller {

	protected $isLoggedIn = false;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('mentorshipmod');
		$this->load->model('loginmod');
		$this->load->helper('date');
		
		$this->ensure_login();
	}

    /**
     * Enforces a login requirement on all pages in this controller, except the login method.
     * Redirects to the login page if not currently logged in.
     * Saves any POST data first, and restores it when returning away from the login page.
     *
     * @return bool true if logged in, false if not logged in, null if on login page
     */
    private function ensure_login()
    {
        if ($this->router->method == 'login') {
            // Don't do any checks on the login page
            // Persist the flashdata POST until next page load
            $this->session->keep_flashdata('POST');
            return null;
        } else if ($this->loginmod->checkLogin('mentorship_users')) {
            // Retrieve saved POST data, if any
            $saved_POST = $this->session->flashdata('POST');
            if ($saved_POST) {
                global $_POST;
                $_POST = $saved_POST;
            }
            return true;
        } else {
            // Save any current POST data
            if (count($_POST) > 0) {
                $this->session->set_flashdata('POST', $_POST);
            }
            // Save redirect URL
            $this->session->set_flashdata('redirect', uri_string());
            // Redirect to login
            redirect('mentorship/login');
            return false;
        }
    }
	
	public function index($offset = 1)
	{
		$id = $this->session->userdata('id');
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('date', 'Date', 'trim|required');
		$this->form_validation->set_rules('in', 'Time In', 'trim|required');
		$this->form_validation->set_rules('out', 'Time Out', 'trim|required');
		$this->form_validation->set_rules('activities', 'Activities', 'trim|required');
		$this->form_validation->set_rules('comments', 'Comments', 'trim|required');
		
		if(count($_POST) > 0) {
			if($this->form_validation->run()) {
				$this->mentorshipmod->logEntry();
				redirect('mentorship');
			}
		}
		
		$this->load->library('pagination');
		$config['base_url'] = $this->config->item('base_url').'mentorship/page/';
		$config['total_rows'] =  $this->mentorshipmod->countEntries($id);
		$config['per_page'] = 5;
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		$config['full_tag_open'] = '<p style="text-align:center;">';
		$config['use_page_numbers'] = true;
		$this->pagination->initialize($config);
		$data['pageLinks'] = $this->pagination->create_links();
		
		$data['log'] = $this->mentorshipmod->getEntries($id, 5, (($offset - 1) * $config['per_page']));
		$data['user'] = $this->mentorshipmod->getUserInfo($id);
		$data['settings'] = $this->mentorshipmod->getSettings();
		
		$this->output->display_output('mentorship/index', $data);
	}
	
	public function edit($id)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('in', 'Time In', 'trim|required');
		$this->form_validation->set_rules('out', 'Time Out', 'trim|required');
		$this->form_validation->set_rules('activities', 'Activities', 'trim|required');
		$this->form_validation->set_rules('comments', 'Comments', 'trim|required');
		if(count($_POST) > 0) {
			if($this->form_validation->run()) {
				$this->mentorshipmod->editLog($id);
				redirect('mentorship');
			}
		}
			
		$data['entry'] = $this->mentorshipmod->getEntryById($id);
		
		//Make sure the person is editing a log that they have access to
		if($data['entry']->user_id != $this->session->userdata('id'))
			redirect('mentorship');
		
		$this->output->display_output('mentorship/edit', $data);
	}
	
	public function delete($id)
	{
		$data['entry'] = $this->mentorshipmod->getEntryById($id);
		
		//Make sure the person is deleting a log that they have access to
		if($data['entry']->user_id != $this->session->userdata('id'))
			redirect('mentorship');
			
		$this->mentorshipmod->deleteLog($id);
		redirect('mentorship');
	}
	
	public function login()
	{
		// No need to log in if already logged in
        if ($this->loginmod->checkLogin('mentorship_users')) redirect('mentorship');

		$this->load->library('form_validation');
		
		if(count($_POST) > 0)
		{
			$this->form_validation->set_rules('username', 'Username', 'trim|required|is_not_unique[mentorship_users.username]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_password');
			$this->form_validation->set_message('is_not_unique','Your username was not found.');
			$this->form_validation->set_message('check_password','Your password was incorrect.');
			if($this->form_validation->run()) {
				$this->loginmod->addSession('mentorship_users');

                // If a saved redirect URI is set, redirect to it, otherwise go to mentorship home page
				if ($this->session->flashdata('redirect')) {
                    redirect($this->session->flashdata('redirect'));
                } else {
                    redirect('mentorship');
                }

                return;
			}
		}

        // Persist the redirect URI, since it was not yet used
        $this->session->keep_flashdata('redirect');
		$this->output->display_output('mentorship/login', array(
            'redirect' => $this->session->flashdata('redirect')
        ));
        return;
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect();
	}
	
	public function change_password()
	{
		$this->load->library('form_validation');
		
		if(count($_POST) > 0)
		{
			$this->form_validation->set_rules('password', 'Current Password Password', 'trim|required|callback_check_password');
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]');
			$this->form_validation->set_rules('confirm', 'Confirm New Password', 'trim|required|matches[new_password]');
			$this->form_validation->set_message('check_password','Your password was incorrect.');
			if($this->form_validation->run()) {
				$this->loginmod->changePassword('mentorship_users');
				redirect('mentorship');
			}
		}
		
		$this->output->display_output('mentorship/change_password');
	}
	
	public function view($id = 0, $key = 0, $offset = 1)
	{
		if($id == 0 || $key == 0)
			redirect();
			
		if(!$this->mentorshipmod->checkKey($key, $id))
			redirect();
			
		$this->load->library('pagination');
		$config['base_url'] = $this->config->item('base_url').'mentorship/view/'.$id.'/'.$key;
		$config['total_rows'] =  $this->mentorshipmod->countEntries($id);
		$config['per_page'] = 5;
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		$config['full_tag_open'] = '<p style="text-align:center;">';
		$config['use_page_numbers'] = true;
		$config['uri_segment'] = 5;
		$this->pagination->initialize($config);
		$data['pageLinks'] = $this->pagination->create_links();
		
		$data['log'] = $this->mentorshipmod->getEntries($id, 5, (($offset - 1) * $config['per_page']));
		$data['user'] = $this->mentorshipmod->getUserInfo($id);
		
		$this->output->display_output('mentorship/view', $data);
	}
	
	public function presentations()
	{
		$settings = $this->mentorshipmod->getSettings();
		$user = $this->mentorshipmod->getUserInfo($this->session->userdata('id'));
		
		if($settings['schedule_open'] != 1 || $settings['year'] != $user->year || $settings['semester'] != $user->semester)
			redirect('mentorship');
		
		$this->load->helper('date');
		
		if(count($_POST) > 0) {
			$this->mentorshipmod->saveSchedule($this->session->userdata('id'));
			redirect('mentorship');
		}
		
		$data['dates'] = $this->mentorshipmod->getFreeDates();
		$data['user'] = $user;
		
		$this->output->display_output('mentorship/presentations', $data);
	}
	
	public function check_password()
	{
		return $this->loginmod->checkPassword('mentorship_users', $this->loginmod->getUserId('mentorship_users'));
	}
}