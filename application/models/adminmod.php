<?php

class Adminmod extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function isSiteOnline()
	{
		$this->db->select('setting_value AS online');
		$this->db->where('setting_name', 'online');
		$result = $this->db->get('site_settings')->row();
		return $result->online == 1;
	}
    
	function addAdmin()
	{
		$this->db->where('username', $this->input->post('username'));
		if($this->db->get('admin')->num_rows() > 0)
			return false;
		
		$salt = random_string('alnum', 16);
		$hash = md5($this->config->item('hardsalt') . $this->input->post('password') . $salt);
		
		$data = array (
			'hash' => $hash,
			'salt' => $salt,
			'username' => $this->input->post('username')
		);
		
		$this->db->insert('admin', $data);
		
		return true;
	}
	
	function deleteAdmin($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('admin');
	}
	
	function getAdminList()
	{
		return $this->db->get('admin');
	}
	
	function addTeacher()
	{
		$this->db->where('username', $this->input->post('username'));
		if($this->db->get('teacher')->num_rows() > 0)
			return false;
			
		$salt = random_string('alnum', 16);
		$hash = md5($this->config->item('hardsalt') . $this->input->post('password') . $salt);
		
		$data = array (
			'name' => $this->input->post('name'),
			'email' => $this->input->post('email'),
			'hash' => $hash,
			'salt' => $salt,
			'username' => $this->input->post('username'),
			'subject' => $this->input->post('subject'),
			'voicemail' => $this->input->post('voicemail')
		);
		
		$this->db->insert('teacher', $data);
		
		$data = array (
			'teacher_id' => $this->db->insert_id(),
			'page_contents' => ''
		);
		
		$this->db->insert('teacher_pages', $data);
	}
	
	function editTeacher($id)
	{
		$data = array (
			'name' => $this->input->post('name'),
			'email' => $this->input->post('email'),
			'subject' => $this->input->post('subject'),
			'voicemail' => $this->input->post('voicemail')
		);
		
		$this->db->where('id', $id);
		$this->db->update('teacher');
	}
	
	function getTeacher($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('teacher')->row();
	}
	
	function deleteTeacher($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('teacher');
		
		$this->db->where('teacher_id', $id);
		$this->db->delete('teacher_blogs');
		
		$this->db->where('teacher_id', $id);
		$this->db->delete('teacher_pages');
	}
	
	function getTeacherList()
	{
		return $this->db->get('teacher');
	}
}

?>