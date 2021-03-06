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
	
	function getVersion()
	{
		$this->db->select('setting_value AS version');
		$this->db->where('setting_name', 'version');
		$result = $this->db->get('site_settings')->row();
		return $result->version;
	}
	
	function setNewVersion($vs)
	{
		$data = array('setting_value' => $vs);
		$this->db->where('setting_name', 'version');
		$this->db->update('site_settings', $data);
	}
    
	function addAdmin()
	{
		$salt = random_string('alnum', 16);
		$password = random_string('alnum', 16);
		$hash = md5($this->config->item('hardsalt') . $password . $salt);
		
		$data = array (
			'hash' => $hash,
			'salt' => $salt,
			'username' => $this->input->post('username')
		);
		
		$this->db->insert('admin', $data);
		return $password;
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
	
	function addTeacher($username)
	{		
		$salt = random_string('alnum', 16);
		$password = random_string('alnum', 16);
		$hash = md5($this->config->item('hardsalt') . $password . $salt);
		
		$data = array (
			'first_name' => $this->input->post('first'),
			'last_name' => $this->input->post('last'),
			'prefix' => $this->input->post('prefix'),
			'suffix' => $this->input->post('suffix'),
			'email' => $this->input->post('email'),
			'hash' => $hash,
			'salt' => $salt,
			'username' => $username,
			'subject' => $this->input->post('subject'),
			'voicemail' => $this->input->post('voicemail'),
			'mentorship_admin' => $this->input->post('mentorship')
		);
		
		$this->db->insert('teacher', $data);
		
		return $password;
	}
	
	function editTeacher($id, $username)
	{
		$data = array (
			'first_name' => $this->input->post('first'),
			'last_name' => $this->input->post('last'),
			'prefix' => $this->input->post('prefix'),
			'suffix' => $this->input->post('suffix'),
			'email' => $this->input->post('email'),
			'subject' => $this->input->post('subject'),
			'voicemail' => $this->input->post('voicemail'),
			'mentorship_admin' => $this->input->post('mentorship'),
			'username' => $username
		);
		
		$this->db->where('id', $id);
		$this->db->update('teacher', $data);
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
		$this->db->delete('teacher_pages');
	}
	
	function getTeacherList()
	{
		$this->db->order_by('last_name', 'ASC');
		return $this->db->get('teacher');
	}
	
	function saveSettings()
	{
		$data = array ('setting_value' => $this->input->post('online') );
		$this->db->where('setting_name', 'online');
		$this->db->update('site_settings', $data);
		
		if($this->input->post('message') != false)
		{
			$data = array ('setting_value' => $this->input->post('message') );
			$this->db->where('setting_name', 'offline_message');
			$this->db->update('site_settings', $data);
		}
	}
	
	function getSettings()
	{
		return $this->db->get('site_settings');
	}
}

?>