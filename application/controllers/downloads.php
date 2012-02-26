<?php
if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Downloads extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->load->model('pagesmod');
	}
	
	public function index()
	{
		$data['types'] = $this->pagesmod->listFormTypes();
		foreach($data['types'] as $type)
			$data['forms'][$type->type] = $this->pagesmod->getFormList($type->id);
	
		$this->output->display_output('downloads',$data);
	}
	
}

?>