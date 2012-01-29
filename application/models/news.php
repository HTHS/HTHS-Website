<?php

class News extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	function getNews($number = 3, $offset = 0, $startDate = 0, $endDate = NULL, $all = false)
	{
		if($endDate == NULL) { $endDate = time(); }

		$this->db->select('*');
		$this->db->from('news');
		if(!$all)
		{
			$this->db->where('start >=', $startDate);
			$this->db->where('expires <=', $endDate);
		}
		$this->db->limit($number, $offset);
		$this->db->order_by('id', 'desc');
		
		$entries = $this->db->get();
		
		return $entries;
	}
	
	function getNewsItem($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('news');
	}
	
	function addNews()
	{
		$data = array (
			'title' => $this->input->post('title'),
			'contents' => $this->input->post('contents'),
			'start' => $this->input->post('start'),
			'expires' => $this->input->post('expires')
		);
		
		$this->db->insert('news', $data);
	}
	
	function editNews($id)
	{
		$data = array (
			'title' => $this->input->post('title'),
			'contents' => $this->input->post('contents'),
			'start' => $this->input->post('start'),
			'expires' => $this->input->post('expires')
		);
		
		$this->db->where('id', $id);
		$this->db->update('news', $data);
	}
	
	function deleteNews($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('news');
	}
	
	function countNewsItems()
	{
		return $this->db->get('news')->num_rows();
	}
}

?>