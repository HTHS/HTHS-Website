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
		$filename = str_replace(' ','_',$this->input->post('title')).'.htm';
		
		$data = array ( 
			'filename' => $filename,
			'last_updated' => time(),
			'title' => $this->input->post('title')
		);
		
		$this->db->insert('pages', $data);
		$this->createPageFile($filename);
		
		return true;
	}
	
	function createPageFile($filename)
	{
		write_file('html/'.$filename, $this->input->post('contents'));
	}
	
	function updatePage($id)
	{
		$filename = str_replace(' ','_',$this->input->post('title')).'.htm';
		
		$data = array ( 
			'filename' => $filename,
			'last_updated' => time(),
			'title' => $this->input->post('title')
		);
		
		$this->db->where('id', $id);
		$this->db->update('pages', $data);
		$this->createPageFile($filename);
	}
	
	function deletePage($id)
	{
		$this->db->where('id', $id);
		$filename = $this->db->get('pages')->row()->filename;
		unlink('html/'.$filename);
		
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