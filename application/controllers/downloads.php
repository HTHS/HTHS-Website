<?php
if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Downloads extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->load->model('pagesmod');
	}
	
	public function index($filename = null)
	{
		if ($filename != null) {
			$this->load->helper('file');
			$this->load->helper('download');
			
			$data = read_file($this->config->item('downloads_directory') . '/' . $filename);
			if ($data == false) {
				show_404();
			}
			
			$status = $this->pagesmod->incrementFormDownloadCount($filename);
			if ($status == false) {
				show_404();
			}
			
			force_download($filename, $data);
		} else {
			$data['types'] = $this->pagesmod->listFormTypes();
			foreach($data['types'] as $type)
				$data['forms'][$type->type] = $this->pagesmod->getFormList($type->id);
		
			$this->output->display_output('downloads', $data);
		}
	}
	
}

?>