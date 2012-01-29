<?php

class Emailmod extends CI_Model {

	function __contruct()
	{
		//Call parent constructor
		parent::__construct();
	}
	
	public function logEmail()
	{
		$data = array (
			'target_teacher_id' => $this->input->post('teacher_id'),
			'email_address' => $this->input->post('email_address'),
			'ip_address' => $this->input->ip_address(),
			'subject' => $this->input->post('subject'),
			'contents' => $this->input->post('message'),
			'time' => time()
		);
		
		$this->db->insert('email_log', $data);
	}
	
	public function getEmails()
	{
		return $this->db->get('parent_emails');
	}
	
	public function registerEmail()
	{
		$data = array (
			'email_address' => $this->input->post('email_address'),
			'ip_address' => $this->input->ip_address()
		);
		
		$this->db->insert('parent_emails', $data);
	}
	
	public function removeEmail()
	{	
		$this->db->where('email_address', $this->input->post('email_address'));
		$this->db->delete('parent_emails');
	}
	
	public function checkFlood()
	{
		$this->db->where('time <', time() - 300);
		$this->db->delete('email_flood');
		
		$this->db->where('ip_address', $this->input->ip_address());
		return $this->db->get('email_flood')->num_rows() == 0;
	}
	
	public function addFlood()
	{
		$data = array (
				'ip_address' => $this->input->ip_address(),
				'time' => time()
		);
		
		$this->db->insert('email_flood', $data);
	}
}