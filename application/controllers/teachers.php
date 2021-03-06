<?php

class Teachers extends CI_Controller {

	function __construct()
	{
		//Call controller constructor
		parent::__construct();
        
		$this->load->model('teachermod');
		$this->load->model('loginmod');
		$this->load->model('curlmod');
        
        if ($this->loginmod->checkLogin('teacher')) {
            $isAuthorized = true; 
        } else {
            $isAuthorized = false;
        }
	}
	
	public function index()
	{
        // Displays a list of teachers, with links to their pages, blogs, and contact forms. 		
		$data['teachers'] = $this->teachermod->getTeacherList()->result();
		
		$this->output->display_output('teachers/index',$data);
	}
	
    public function about($username) {
        // Run by default when the user goes to /teachers/SomeTeacher, displays some biographical info and a photo, links to pages and blog
		
        $teacher_id = $this->teachermod->getTeacherId($username);
		
        $data['teacher'] = $this->teachermod->getTeacherInfo($teacher_id);
		
		// Remove empty elements from the list of pages. 
        $pages = $this->teachermod->getPageList($teacher_id)->result();
		$data['pages'] = array();
		for ($i = count($pages) - 1; $i >= 0; $i--) {
			if ($pages[$i]->page_url != '') {
				$data['pages'] = $pages[$i];
			}
		}
		$data['pages'] = array_reverse($data['pages']);
		
		if($data['teacher']->blog != '')
			$data['entries'] = $this->curlmod->fetchBlogEntries($data['teacher']->blog.'/atom.xml', 6, $teacher_id);
        
        $this->output->display_output('teachers/about', $data);
    }
    
    public function page($username, $page_url) {
        // Accessed via URL: /teachers/$username/page/$page_url
        // Displays the specified page for the teacher.
        
        $teacher_id = $this->teachermod->getTeacherId($username);
        if ($teacher_id == false) {
            show_404();
        }
        
        $page_id = $this->teachermod->getPageId($teacher_id, $page_url);
        if ($page_id == false) {
            show_404();
        }
        
        $data['page'] = $this->teachermod->getPageById($page_id);
        $data['teacher'] = $this->teachermod->getTeacherInfo($teacher_id);
        
        $this->output->display_output('teachers/pages', $data);
    }
	
	public function contact($username) {
		// Accessed via URL: /teachers/$username/contact
		// Displays a contact form. 
		
		$teacher_id = $this->teachermod->getTeacherId($username);
		
		$data['teacher'] = $this->teachermod->getTeacherInfo($teacher_id);
		$data['email_display_allowed'] = $this->teachermod->check_email_display_allowed($teacher_id);
		
		$this->load->helper('captcha');
		$this->load->model('captcha');
		$data['teachers'] = $this->teachermod->getTeacherList();
		
		$vals = array(
			'img_path'	 => 'images/verification/',
			'img_url'	 => site_url('images/verification').'/',
			'img_width'	 => 150,
			'img_height' => 50,
			);

		$data['cap'] = create_captcha($vals);
		$this->captcha->addCaptcha($data['cap']);
		
		$this->output->display_output('teachers/contact', $data);
	}
	
	public function contact_send($username) {
		$id = $this->teachermod->getTeacherId($username);
		
		if(count($_POST) == 0)
			redirect();
		
		$this->load->model('teachermod');
		$this->load->model('emailmod');
		$this->load->library('email');
		$this->load->library('form_validation');
		$this->email->clear();
		
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('subject', 'Subject', 'trim|required');
		$this->form_validation->set_rules('contents', 'Messsage', 'trim|required');
		$this->form_validation->set_rules('verify', 'Security Code', 'required|callback_check_captcha|callback_check_flood');
		$this->form_validation->set_message('check_captcha', 'You must enter the security code correctly.');
		$this->form_validation->set_message('check_flood', 'You may only send one email every 5 minutes. Please wait and try again.');
		if ($this->form_validation->run())
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
			$this->email->message($this->input->post('contents').$messageFooter);

			$this->email->send();
			
			$this->emailmod->logEmail();
			$this->emailmod->addFlood();
		
			$this->output->display_output('text', array('text' => '<div class="fancybox"><div class="success">Email Sent!</div></div>'));
		} else {
			$this->output->display_output('text', array('text' => '<div class="fancybox"><div class="error">Your message was not sent due to the following errors: </div><br />' . validation_errors() . '<br /><hr /><br /><p>The message that would have been sent was: '.$this->input->post('contents', TRUE).'</p></div>'));
		}
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
}