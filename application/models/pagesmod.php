<?php

class Pagesmod extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		
		$this->load->helper('file');
    }
	
	function getFormList($type, $includeArchived = false)
	{
		$this->db->where('type', $type);
		if(!$includeArchived)
			$this->db->where('archived', '0');
		$this->db->order_by('name', 'asc');
		return $this->db->get('forms');
	}
	
	function listFormTypes($includeUnused = false)
	{
		$this->db->select('form_types.*');
		if(!$includeUnused)
			$this->db->join('forms', 'forms.type = form_types.id', 'inner');
		$this->db->order_by('type', 'asc');
		return $this->db->get('form_types');
	}
	
	function getPageFilename($title)
	{
		$this->db->where('title', $title);
		$page = $this->db->get('pages');
		
		return $page;
	}
	
	function addPage()
	{
		$this->db->where("`filename` = '".$this->input->post('filename')."' OR `title` = '".$this->input->post('title')."'");
		if($this->db->get('pages')->num_rows() > 0)
			return false;
		
		$data = array ( 
			'filename' => $this->input->post('filename'),
			'last_updated' => time(),
			'title' => $this->input->post('title')
		);
		
		$this->db->insert('pages', $data);
		$this->createPageFile();
		
		return true;
	}
	
	function createPageFile()
	{
		write_file('html/'.$this->input->post('filename'), $this->input->post('contents'));
	}
	
	function updatePage($id)
	{
		$data = array ( 
			'filename' => $this->input->post('filename'),
			'last_updated' => time(),
			'title' => $this->input->post('title')
		);
		
		$this->db->where('id', $id);
		$this->db->update('pages', $data);
		$this->createPageFile();
	}
	
	function deletePage($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('pages');
	}

	function getPageList()
	{
		return $this->db->get('pages');
	}
	
	function getPageById($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('pages')->row();
	}
}

?>