<?php

class Newsmod extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	function getNews($number = 3, $offset = 0, $all = false)
	{
		$this->db->select('*');
		$this->db->from('news');
		if(!$all) {
			$this->db->where('`start` <= '.time().' AND (`expires` >= '.time().' OR `expires` = 0)');
			$this->db->limit($number, $offset);
		}
		$this->db->order_by('id', 'desc');
		
		$entries = $this->db->get()->result();
		
        foreach ($entries as &$entry) {
            $entry->date = $entry->start;
        }
        
		return $entries;
	}
	
	function getNewsItem($id)
	{
		$this->db->where('id', $id);
        $this->db->from('news');
		$result = $this->db->get();
        $row = $result->row();
        $row->date = $row->start;
        
        return $row;
	}
	
	function addNews()
	{
		$this->load->helper('date');
		if($this->input->post('expires') == '')
			$expires = 0;
		else
			$expires = friendly_to_unix($this->input->post('expires'));
			
		$data = array (
			'title' => $this->input->post('title'),
			'contents' => $this->input->post('contents'),
			'start' => friendly_to_unix($this->input->post('start')),
			'expires' => $expires,
			'urgent' => $this->input->post('urgent')
		);
		
		$this->db->insert('news', $data);
	}
	
	function editNews($id)
	{
		$this->load->helper('date');
		if($this->input->post('expires') == '')
			$expires = 0;
		else
			$expires = friendly_to_unix($this->input->post('expires'));
			
		$data = array (
			'title' => $this->input->post('title'),
			'contents' => $this->input->post('contents'),
			'start' => friendly_to_unix($this->input->post('start')),
			'expires' => $this->input->post('expires'),
			'urgent' => $this->input->post('urgent')
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