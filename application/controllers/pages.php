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
		$url = implode('/', func_get_args());
		$data = $this->pagesmod->getPageByUrl($url);
		
		if ($data == false) {
			show_404();
		}
		
		display_output('pages/index', $data);
	}
}

/* End of file pages.php */
/* Location: ./application/controllers/pages.php */