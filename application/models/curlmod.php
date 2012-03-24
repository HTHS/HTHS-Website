<?php

class Curlmod extends CI_Model {

	function __contruct()
	{
		//Call parent constructor
		parent::__construct();
	}
	
	private function doCurl($url) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_URL, $url);
		
		$returnedData = curl_exec($curl);
		
		return $returnedData;
	}
	
	public function fetchBlogEntries($url)
	{
		$this->load->helper('date');
		
		$returnedData = $this->doCurl($url);
		
		$blogPosts = explode('<div class="asset-header">', $returnedData);
		
		foreach($blogPosts as $key => $value) {
			$blogPosts[$key] = explode('<div class="asset-footer">', $value);
		}
		
		$data['links'] = array();
		$data['titles'] = array();
		$data['dates'] = array();
		$count = 0;
		
		foreach($blogPosts as $key => $value) {
			if($key != 0 && $key <= 6) {
				$count++;
				$value = $value[0];
				$link = explode('<a href="', $value);
				$link = explode('" rel="bookmark">', $link[1]);
				$data['links'][] = $link[0];
				$title = explode('" rel="bookmark">', $value);
				$title = explode('</a></h2>', $title[1]);
				$data['titles'][] = $title[0];
				$date = explode('<abbr class="published" title="', $value);
				$date = explode('">', $date[1]);
				$data['dates'][] = blog_to_unix($date[0]);
			}
		}
		
		$return = array();
		
		for($i = 0; $i < $count; $i++)
		{
			$return[$i]->date = $data['dates'][$i];
			$return[$i]->link = $data['links'][$i];
			$return[$i]->title = $data['titles'][$i];
			$return[$i]->id = '';
			$return[$i]->urgent = 0;
		}
		
		return $return;
	}
}