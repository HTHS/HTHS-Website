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
	
	function listFormTypes($includeUnused = false, $includeUnusedOnly = false)
	{
		$doFormsExist = $this->db->get('forms')->num_rows();
		
		$this->db->select('form_types.*');
		if($doFormsExist != 0) {
			if(!$includeUnused)
				$this->db->join('forms', 'forms.type = form_types.id', 'inner');
			if($includeUnusedOnly)
				$this->db->join('forms', 'forms.type != form_types.id', 'inner');
		}
		$this->db->order_by('type', 'asc');
		return $this->db->get('form_types');
	}
	
	function addCategory()
	{
		$data = array( 
			'type' => $this->input->post('category')
		);
		
		$this->db->insert('form_types',$data);
	}
	
	function deleteCategory($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('form_types');
	}
	
	function addForm($filename)
	{	
		$data = array( 
			'name' => $this->input->post('name'),
			'filename' => $filename,
			'time' => time(),
			'archived' => 0,
			'type' => $this->input->post('type')
		);
		
		$this->db->insert('forms', $data);
	}
	
	function archive($add, $id)
	{
		if($add) $data = array ('archived' => 1);
		if(!$add) $data = array ('archived' => 0);
		
		$this->db->where('id',$id);
		$this->db->update('forms', $data);
	}
	
	function deleteForm($id)
	{
		$this->db->where('id',$id);
		$data = $this->db->get('forms')->row();
		
		unlink('downloads/'.$data->filename);
		$this->db->where('id',$id);
		$this->db->delete('forms');
	}
	
	function getPageFilename($title)
	{
		$this->db->where('title', $title);
		$page = $this->db->get('pages');
		
		return $page;
	}
	
	function addPage()
	{
		$data = array( 
			'last_updated' => time(),
			'url' => $this->input->post('url'),
			'title' => $this->input->post('title'),
			'contents' => $this->input->post('contents')
		);
		
		$this->db->insert('pages', $data);
		return true;
	}
	
	function updatePage($id)
	{
		$data = array(
			'last_updated' => time(),
			'url' => $this->input->post('url'),
			'title' => $this->input->post('title'),
			'contents' => $this->input->post('contents'),
		);
		
		$this->db->where('id', $id);
		$this->db->update('pages', $data);
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
	
	function getPageByUrl($url) {
		$this->db->where('url', $url);
		$this->db->from('pages');
		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			return false;
		}
		return $query->row();
	}
}

?>