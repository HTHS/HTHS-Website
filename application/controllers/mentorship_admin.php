<?

class Mentorship_admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('mentorshipmod');
		
		if(!$this->loginmod->checkLogin('teacher') || !$this->session->userdata('mentorship_admin'))
			redirect('teachers/dashboard');
	}
	
	public function index()
	{
	
	}
	
}