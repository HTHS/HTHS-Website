<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {

	function __construct()
    {
        // Call the Controller constructor
        parent::__construct();
		
		$this->load->model('pagesmod');
		$this->load->helper('file');
    }
	
	public function index($page = '')
	{
		if($page == '')
			redirect();
			
		$fileData = $this->pagesmod->getPageFilename($page);
		
		if($fileData->num_rows() == 0)
			show_404($page);
			
		$filename = 'html/'.$fileData->filename;
		
		if(!file_exists($filename)) 
			show_404($page);
		
		$data['contents'] = read_file($filename);
		$this->load->view('wrapper/header');
		$this->load->view('pages/index',$data);
		$this->load->view('wrapper/footer');
	}
}

/* End of file pages.php */
/* Location: ./application/controllers/pages.php */