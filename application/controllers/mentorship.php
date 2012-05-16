<?

class Mentorship extends CI_Controller {

	protected $isLoggedIn = false;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('mentorshipmod');
		$this->load->model('loginmod');
		$this->load->helper('date');
		
		if($this->loginmod->checkLogin('mentorship_users'))
			$this->isLoggedIn = true;
	}
	
	public function index($offset = 1)
	{
		if(!$this->isLoggedIn)
			redirect('mentorship/login');
		
		$id = $this->session->userdata('id');
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('date', 'Date', 'trim|required');
		$this->form_validation->set_rules('in', 'Time In', 'trim|required');
		$this->form_validation->set_rules('out', 'Time Out', 'trim|required');
		$this->form_validation->set_rules('activities', 'Activities', 'trim|required');
		$this->form_validation->set_rules('comments', 'Comments', 'trim|required');
		
		if(count($_POST) > 0) {
			if($this->form_validation->run()) {
				$this->mentorshipmod->logEntry();
				redirect('mentorship');
			}
		}
		
		$this->load->library('pagination');
		$config['base_url'] = $this->config->item('base_url').'mentorship/page/';
		$config['total_rows'] =  $this->mentorshipmod->countEntries($id);
		$config['per_page'] = 5;
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		$config['full_tag_open'] = '<p style="text-align:center;">';
		$config['use_page_numbers'] = true;
		$this->pagination->initialize($config);
		$data['pageLinks'] = $this->pagination->create_links();
		
		$data['log'] = $this->mentorshipmod->getEntries($id, 5, (($offset - 1) * $config['per_page']));
		$data['user'] = $this->mentorshipmod->getUserInfo($id);
		$data['settings'] = $this->mentorshipmod->getSettings();
		
		$this->output->display_output('mentorship/index', $data);
	}
	
	public function edit($id)
	{
		if(!$this->isLoggedIn)
			redirect('mentorship/login');
			
		$this->load->library('form_validation');
		$this->form_validation->set_rules('in', 'Time In', 'trim|required');
		$this->form_validation->set_rules('out', 'Time Out', 'trim|required');
		$this->form_validation->set_rules('activities', 'Activities', 'trim|required');
		$this->form_validation->set_rules('comments', 'Comments', 'trim|required');
		if(count($_POST) > 0) {
			if($this->form_validation->run()) {
				$this->mentorshipmod->editLog($id);
				redirect('mentorship');
			}
		}
			
		$data['entry'] = $this->mentorshipmod->getEntryById($id);
		
		//Make sure the person is editing a log that they have access to
		if($data['entry']->user_id != $this->session->userdata('id'))
			redirect('mentorship');
		
		$this->output->display_output('mentorship/edit', $data);
	}
	
	public function delete($id)
	{
		if(!$this->isLoggedIn)
			redirect('mentorship/login');
		
		$data['entry'] = $this->mentorshipmod->getEntryById($id);
		
		//Make sure the person is deleting a log that they have access to
		if($data['entry']->user_id != $this->session->userdata('id'))
			redirect('mentorship');
			
		$this->mentorshipmod->deleteLog($id);
		redirect('mentorship');
	}
	
	public function login()
	{
		if($this->isLoggedIn)
			redirect('mentorship');
			
		$this->load->library('form_validation');
		
		if(count($_POST) > 0)
		{
			$this->form_validation->set_rules('username', 'Username', 'trim|required|is_not_unique[mentorship_users.username]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_password');
			$this->form_validation->set_message('is_not_unique','Your username was not found.');
			$this->form_validation->set_message('check_password','Your password was incorrect.');
			if($this->form_validation->run()) {
				$this->loginmod->addSession('mentorship_users');
				redirect('mentorship');
			}
		}
		
		$this->output->display_output('mentorship/login');
	}
	
	public function logout()
	{
		if(!$this->isLoggedIn)
			redirect('mentorship/login');
		
		$this->session->sess_destroy();
		redirect();
	}
	
	public function change_password()
	{
		if(!$this->isLoggedIn)
			redirect('mentorship/login');
		
		$this->load->library('form_validation');
		
		if(count($_POST) > 0)
		{
			$this->form_validation->set_rules('password', 'Current Password Password', 'trim|required|callback_check_password');
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]');
			$this->form_validation->set_rules('confirm', 'Confirm New Password', 'trim|required|matches[new_password]');
			$this->form_validation->set_message('check_password','Your password was incorrect.');
			if($this->form_validation->run()) {
				$this->loginmod->changePassword('mentorship_users');
				redirect('mentorship');
			}
		}
		
		$this->output->display_output('mentorship/change_password');
	}
	
	public function view($id = 0, $key = 0, $offset = 1)
	{
		if($id == 0 || $key == 0)
			redirect();
			
		if(!$this->mentorshipmod->checkKey($key, $id))
			redirect();
			
		$this->load->library('pagination');
		$config['base_url'] = $this->config->item('base_url').'mentorship/view/'.$id.'/'.$key;
		$config['total_rows'] =  $this->mentorshipmod->countEntries($id);
		$config['per_page'] = 5;
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		$config['full_tag_open'] = '<p style="text-align:center;">';
		$config['use_page_numbers'] = true;
		$config['uri_segment'] = 5;
		$this->pagination->initialize($config);
		$data['pageLinks'] = $this->pagination->create_links();
		
		$data['log'] = $this->mentorshipmod->getEntries($id, 5, (($offset - 1) * $config['per_page']));
		$data['user'] = $this->mentorshipmod->getUserInfo($id);
		
		$this->output->display_output('mentorship/view', $data);
	}
	
	public function presentations()
	{
		$settings = $this->mentorshipmod->getSettings();
		$user = $this->mentorshipmod->getUserInfo($this->session->userdata('id'));
		
		if($settings['schedule_open'] != 1 || $settings['year'] != $user->year || $settings['semester'] != $user->semester)
			redirect('mentorship');
		
		$this->load->helper('date');
		
		if(count($_POST) > 0) {
			$this->mentorshipmod->saveSchedule($this->session->userdata('id'));
			redirect('mentorship');
		}
		
		$data['dates'] = $this->mentorshipmod->getFreeDates();
		$data['user'] = $user;
		
		$this->output->display_output('mentorship/presentations', $data);
	}
	
	public function check_password()
	{
		return $this->loginmod->checkPassword('mentorship_users', $this->loginmod->getUserId('mentorship_users'));
	}
}