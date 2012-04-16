<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Initial_setup extends CI_Controller {

	function __construct()
    {
        // Call the Controller constructor
        parent::__construct();
    }
	
	public function index()
	{
		$newPasswords = array();
		$hashes = array();
		$salts = array();
		
		$output = 'Initalizing Setup';
		
		$output .= '<br />Reading teacher list... ';
		
		$teachers = $this->db->query('SELECT * FROM `teacher`')->result_array();
		
		$output .= 'Done!<br />Creating new passwords... ';
		
		foreach($teachers as $teacher) {
			$password = random_string('alnum', 16);
			$newPasswords[$teacher->id] = $password;
		}
		
		$output .= 'Done!<br />Hashing new passwords... ';
		
		foreach($teachers as $teacher) {
			$salts[$teacher->id] = random_string('alnum', 16);
			$hashes[$teacher->id] = md5($this->config->item('hardsalt') . $newPasswords[$teaher->id] . $salts[$teacher->id]);
		}
		
		$output .= 'Done!<br />Writing new passwords to database... ';
		
		foreach($teachers as $teacher) {
			$data = array (
				'hash' => $hashes[$teacher->id],
				'salt' => $salts[$teacher->id]
			);
			$this->db->where('id', $teacher->id);
			$this->db->update('teacher', $data);
		}
		
		$output .= 'Done!<br />Emailing new passwords... ';
		
		$this->load->library('email');
		foreach($teachers as $teacher) {
			$this->email->clear();
			$this->email->subject('HTHS Website Account Activation');
			$this->email->to($teacher->email);
			$this->email->from('noreply@hths.mcvsd.org', 'HTHS Security Robot');
			$this->email->message('Your High Technology High School website teacher account has been successfully created.

Username: '.$teacher->username.'
Password: '.$newPasswords[$teacher->id].'

Please use the link below to access the teacher dashboard, one you login you can change your password there.
'.site_url('teacher').'

Thank You,
The HTHS Web Team');

			$this->email->send();
		}
		
		$output .= 'Done!';
		
		$this->output->set_output($output);
	}
}		