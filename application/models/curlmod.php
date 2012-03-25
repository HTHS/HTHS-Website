<?php

class Curlmod extends CI_Model {

	function __contruct()
	{
		//Call parent constructor
		parent::__construct();
	}
	
	private function doCurl($url, $cacheId) {
		$this->load->driver('cache', array('adapter' => 'file'));
		
		if(!$cata = $this->cache->get($cacheId)) {
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_URL, $url);
			$returnedData = curl_exec($curl);
			$this->cache->save($cacheId, $returnedData, 7200);
		} else {
			$returnedData = $this->cache->get($cacheId);
		}
		
		return $returnedData;
	}
	
	public function fetchBlogEntries($url, $limit, $teacher_id)
	{
		$this->load->helper('date');
	
		$returnedData = $this->doCurl($url, 'TeacherBlogsFeed-TeacherID-'.$teacher_id);
		$xml = simplexml_load_string($returnedData);
		
		$return = array();
		$i = 0;
		
		foreach($xml->entry as $entry)
		{
			if($i > ($limit - 1))
				break;
				
			$return[$i]->date = blog_to_unix($entry->published);
			$return[$i]->link = $entry->link->attributes()->href;
			$return[$i]->title = $entry->title;
			$return[$i]->id = '';
			$return[$i]->urgent = 0;
			$i++;
		}
	
		return $return;
	}
}