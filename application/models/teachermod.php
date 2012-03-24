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
		$this->db->select('teacher.*, teacher_pages.page_contents, CASE WHEN `teacher_blogs`.`id` IS NULL THEN 0 ELSE COUNT(*) END AS blog_count',false);
		$this->db->from('teacher');
		$this->db->join('teacher_pages', 'teacher_pages.teacher_id = teacher.id', 'left outer');
		$this->db->join('teacher_blogs', 'teacher_blogs.teacher_id = teacher.id', 'left outer');
		$entries = $this->db->get();
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
}

?>