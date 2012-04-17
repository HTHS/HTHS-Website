<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {

	function __construct()
    {
        // Call the Controller constructor
        parent::__construct();
		
		$this->load->model('pagesmod');
    }
	
	public function index()
	{
		$url = str_replace('pages/', '', $this->uri->uri_string());
		$data = $this->pagesmod->getPageByUrl($url);
		
		if ($data == false) {
			show_404();
		}
		
		$this->output->display_output('pages/index', $data, array('title' => $data->title));
	}
}

/* End of file pages.php */
/* Location: ./application/controllers/pages.php */