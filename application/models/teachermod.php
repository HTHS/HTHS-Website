<?php

class Teachermod extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function getTeacherInfo($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('teacher')->row();
	}
	
	function updateInfo()
	{
		$data = array(
			'description' => $this->input->post('description'),
			'blog' => $this->input->post('blog'),
			'email_display_allowed' => $this->input->post('publicEmail')
		);
		
		$this->db->where('id', $this->session->userdata('id'));
		$this->db->update('teacher', $data);
		
		//Delete any cached blog entries
		$this->load->driver('cache', array('adapter' => 'file'));
		$this->cache->delete('TeacherBlogsFeed-TeacherID-'.$this->session->userdata('id'));
	}
    
    function getTeacherId($username) {
        $this->db->from('teacher');
        $this->db->where('username', $username);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        }
        $teacher = $query->row();
        return $teacher->id;
    }
	
	function getTeacherList()
	{
		$this->db->order_by('name', 'ASC');
		$entries = $this->db->get('teacher');
		return $entries;
	}
	
    function getPageList($teacher_id) {
        $this->db->from('teacher_pages');
        $this->db->where('teacher_id', $teacher_id);
        $query = $this->db->get();
        return $query;
    }
    
    function getPageId($teacher_id, $page_url) {
        $this->db->from('teacher_pages');
        $this->db->where('teacher_id', $teacher_id);
        $this->db->where('page_url', $page_url);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $row = $query->row();
            return $row->id;
        } else {
            return false;
        }
    }
	
	function getPageById($id)
	{
		$this->db->where('id',$id);
		return $this->db->get('teacher_pages')->row();
	}
	
	function addPage()
	{
		$data = array( 
			'teacher_id' => $this->session->userdata('id'),
			'page_url' => $this->input->post('url'),
			'page_title' => $this->input->post('title'),
			'page_contents' => $this->input->post('contents')
		);
		
		$this->db->insert('teacher_pages', $data);
		return true;
	}
	
	function editPage($id)
	{
		$data = array( 
			'teacher_id' => $this->session->userdata('id'),
			'page_url' => $this->input->post('url'),
			'page_title' => $this->input->post('title'),
			'page_contents' => $this->input->post('contents')
		);
		
		$this->db->where('id',$id);
		$owner = $this->db->get('teacher_pages')->row()->teacher_id;
		
		if($owner == $this->session->userdata('id'))
		{
			$this->db->where('id', $id);
			$this->db->update('teacher_pages', $data);
		}
	}
	
	function deletePage($id)
	{
		$this->db->where('id',$id);
		$owner = $this->db->get('teacher_pages')->row()->teacher_id;
		
		if($owner == $this->session->userdata('id'))
		{
			$this->db->where('id',$id);
			$this->db->delete('teacher_pages');
		}
	}
	
	function check_email_display_allowed($id) {
		$this->db->where('id',$id);
		$email_display_allowed = $this->db->get('teacher')->row()->email_display_allowed;
		if ($email_display_allowed == "1") {
			return true;
		} else {
			return false;
		}
	}
}

?>