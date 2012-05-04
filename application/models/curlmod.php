<?php

class Curlmod extends CI_Model {

	function __contruct()
	{
		//Call parent constructor
		parent::__construct();
	}
	
	private function doCurl($url, $cacheId, $nocache = false) {
		$this->load->driver('cache', array('adapter' => 'file'));
		
		if($nocache || !$returnedData = $this->cache->get($cacheId)) {
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_URL, $url);
			$returnedData = curl_exec($curl);
			
			if(curl_getinfo($curl, CURLINFO_HTTP_CODE) == 404) 
				return false;

			$this->cache->save($cacheId, $returnedData, 3600);
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
	
	public function checkForUpdates($url)
	{
		$this->load->model('adminmod');
		$returnedData = $this->doCurl($url.'/update.txt', 'UpdateCheck', true);
		if($returnedData != $this->adminmod->getVersion() && $returnedData != false)
			return $returnedData;
		else
			return false;
	}
	
	public function fetchUpdate($url)
	{
		$returnedData = $this->doCurl($url.'/update.zip', 'UpdateFetch', true);
		$fh = fopen('application/cache/update.zip', 'w');
		fwrite($fh, $returnedData);
		fclose($fh);
	}
	
	public function runUpdateScript()
	{
		$url = $this->config->item('base_url').'convert.php';
		$this->doCurl($url, 'UpdateScriptRun', true);
	}
}