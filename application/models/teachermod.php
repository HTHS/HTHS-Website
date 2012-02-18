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
	
	function getBlogEntries($id = 0, $number = 5, $offset = 0, $all = false)
	{	
		if($id == 0)
			$id = $this->session->userdata('id');
			
		$this->db->select('*');
		$this->db->from('teacher_blogs');
		$this->db->where('teacher_id', $id);
		if(!$all)
			$this->db->limit($number, $offset);
		$this->db->order_by('id', 'desc');
		
		$entries = $this->db->get();
		
		return $entries->result();
	}
	
	function getBlogById($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('teacher_blogs')->row();
	}
	
	function addBlogEntry()
	{
		$data = array (
			'teacher_id' => $this->session->userdata('id'),
			'title' => $this->input->post('title'),
			'contents' => $this->input->post('contents'),
			'date' => time()
		);
		
		$this->db->insert('teacher_blogs', $data);
	}
	
	function editBlogEntry($id)
	{
		$data = array (
			'title' => $this->input->post('title'),
			'contents' => $this->input->post('contents')
		);
		
		$this->db->where('id', $id);
		$this->db->update('teacher_blogs', $data);
	}
	
	function deleteBlogEntry($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('teacher_blogs');
	}
	
	function countBlogEntries($id)
	{	
		$this->db->where('teacher_id', $id);
		return $this->db->get('teacher_blogs')->num_rows();
	}
	
    function getPageList($teacher_id) {
        $this->db->from('teacher_pages');
        $this->db->where('teacher_id', $teacher_id);
        $query = $this->db->get();
        return $query->result();
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
    
	function getPage($id = 0)
	{
		if($id == 0)
			$id = $this->session->userdata('id');
			
		$this->db->where('teacher_id', $id);
		return $this->db->get('teacher_pages')->row();
	}
	
	function editPage()
	{
		$id = $this->session->userdata('id');
		
		$data = array (
			'page_contents' => $this->input->post('contents')
		);
		
		$this->db->where('teacher_id', $id);
		$this->db->update('teacher');
	}
}

?>