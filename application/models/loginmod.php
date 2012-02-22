<?php

class Loginmod extends CI_Model {
	
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	function getUserId($table)
	{
		$this->db->where('username', $this->input->post('username'));
		$user = $this->db->get($table);
		
		if($user->num_rows() == 0)
			return 0;
		else
			return $user->row()->id;
	}
	
	function getSalt($table, $id)
	{
		$this->db->where('id', $id);
		$salt = $this->db->get($table);
		
		if($salt->num_rows() == 0)
			return 0;
		else
			return $salt->row()->salt;
	}
	
	function checkPassword($table, $id)
	{
		$salt = $this->getSalt($table, $id);
		$hash = md5($this->config->item('hardsalt') . $this->input->post('password') . $salt);
		
		$this->db->where('id', $id);
		$this->db->where('hash', $hash);
		$data = $this->db->get($table);
		
		if($data->num_rows() == 0)
			return false;
		else
			return true;
	}
	
	function addSession($table)
	{
		$user_id = $this->getUserId($table);
		
		if($table == 'teacher') {
			$this->db->where('id', $user_id);
			$mentorshipAdmin = $this->db->get($table)->row()->mentorship_admin == 1;
		}
		else
			$mentorshipAdmin = false;
			
		$this->session->set_userdata(array('login' => true, 'id' => $user_id, 'area' => $table, 'username' => $this->input->post('username'), 'mentorship_admin' => $mentorshipAdmin));
	}
	
	function checkLogin($table)
	{
		if($this->session->userdata('login') == true) 
			if($this->session->userdata('area') == $table) 
				return true;
			else
				$this->session->sess_destroy();
		
		return false;
	}
	
	function changePassword($table, $id = 0)
	{
		if($id == 0)
			$id = $this->session->userdata('id');
			
		$salt = random_string('alnum', 16);
		if(!$this->input->post('new_password'))
			$newPass = random_string('alnum', 10);
		else
			$newPass = $this->input->post('new_password');
			
		$hash = md5($this->config->item('hardsalt') . $newPass . $salt);
		
		$data = array (
			'hash' => $hash,
			'salt' => $salt
		);
		
		$this->db->where('id', $id);
		$this->db->update($table, $data);
		return $newPass;
	}
}

?>