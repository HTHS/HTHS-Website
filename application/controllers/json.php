<?php

class Json extends CI_Controller {

	function __contruct()
	{
		//Call parent contructor
		parent::__contruct();
	}
	
	function index()
	{
		show_404();
	}
	
	public function send_email()
	{		
		if(count($_POST) == 0)
			redirect();
		
		$this->load->model('teachermod');
		$this->load->model('emailmod');
		$this->load->library('email');
		$this->load->library('form_validation');
		$this->email->clear();
		
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('subject', 'Subject', 'trim|required|min_length[10]');
		$this->form_validation->set_rules('message', 'Messsage', 'trim|required');
		$this->form_validation->set_rules('verify', 'Security Code', 'required|callback_check_captcha|callback_check_flood');
		$this->form_validation->set_message('check_captcha', 'You must enter the security code correctly.');
		$this->form_validation->set_message('check_flood', 'You may only send one email every 5 minutes. Please wait and try again.');
		if($this->form_validation->run())
		{
			$id = $this->input->post('teacher_id');
		
$messageFooter = '

-----------------------

This email was sent via. the High Technology High School Website Emailer.
Replying to this email will reply to the sender at: '.$this->input->post('email_address').'

All use of this form is logged, to report abuse please contact the webmaster.';
		
			$this->email->to($this->teachermod->getTeacherInfo($id)->email);
			$this->email->from('noreply@hths.mcvsd.org','HTHS Web Emailer');
			$this->email->reply_to($this->input->post('email_address'));
			$this->email->subject($this->input->post('subject'));
			$this->email->message($this->input->post('message').$messageFooter);

			$this->email->send();
			
			$this->emailmod->logEmail();
			$this->emailmod->addFlood();
		
			print "TRUE";
		}
		else
			print validation_errors();
		
		$this->output->enable_profiler(false);
	}
	
	public function check_captcha($word)
	{
		$this->load->model('captcha');
		return $this->captcha->checkCaptcha($word);
	}
	
	public function check_flood($nothing)
	{
		return $this->emailmod->checkFlood();
	}
	
	public function add_log()
	{
		$this->load->model('loginmod');
		$this->load->model('mentorshipmod');
		
		if(count($_POST) == 0)
			redirect('mentorship');
			
		if(!$this->loginmod->checkLogin('mentorship_users')) 
			die('<div class="error"><p>You are no longer logged in.</p></div><br />');
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('date', 'Date', 'required');
		$this->form_validation->set_rules('activities', 'Activities', 'required');
		$this->form_validation->set_rules('comments', 'Comments', 'required');
		if($this->form_validation->run()) {
			$this->mentorshipmod->logEntry();
			die("TRUE");
		}
		else
			die(validation_errors());
			
		$this->output->enable_profiler(false);
	}

	public function edit_log($id)
	{
		$this->load->model('loginmod');
		$this->load->model('mentorshipmod');
		
		if(count($_POST) == 0)
			redirect('mentorship');
			
		if(!$this->loginmod->checkLogin('mentorship_users')) 
			die('<div class="error"><p>You are no longer logged in.</p></div><br />');
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('activities', 'Activities', 'required');
		$this->form_validation->set_rules('comments', 'Comments', 'required');
		if($this->form_validation->run()) {
			$this->mentorshipmod->editLog($id);
			die("TRUE");
		}
		else
			die(validation_errors());
			
		$this->output->enable_profiler(false);
	}
	
	public function delete_log($id)
	{
		$this->load->model('loginmod');
		$this->load->model('mentorshipmod');
		
		if(!$this->loginmod->checkLogin('mentorship_users')) 
			die("FALSE");
		
		$this->mentorshipmod->deleteLog($id);
		die("TRUE");
		
		$this->output->enable_profiler(false);
	}
}
		