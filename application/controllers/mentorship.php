<?

class Mentorship extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('mentorshipmod');
		$this->load->model('loginmod');
		$this->load->helper('date');
	}
	
	public function index($offset = 0)
	{
		if(!$this->loginmod->checkLogin('mentorship_users'))
			redirect('mentorship/login');
		
		$id = $this->session->userdata('id');
		
		$data['log'] = $this->mentorshipmod->getEntries($id, 10, $offset);
		$data['user'] = $this->mentorshipmod->getUserInfo($id);
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('date', 'Date', 'trim|required');
		$this->form_validation->set_rules('activities', 'Activities', 'trim|required');
		$this->form_validation->set_rules('comments', 'Comments', 'trim|required');
		
		if(count($_POST) > 0) {
			if($this->form_validation->run()) {
				$this->mentorshipmod->logEntry();
				redirect('mentorship');
			}
		}
			
		$this->load->library('pagination');
		$config['base_url'] = $this->config->item('base_url').'mentorship/';
		$config['total_rows'] =  $data['log']->num_rows();
		$config['per_page'] = 10;
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		$config['full_tag_open'] = '<p style="text-align:center;">';
		$this->pagination->initialize($config);
		$data['pageLinks'] = $this->pagination->create_links();
		
		$this->load->view('wrapper/header');
		$this->load->view('mentorship/index',$data);
		$this->load->view('wrapper/footer');
	}
	
	public function edit($id)
	{
		if(!$this->loginmod->checkLogin('mentorship_users'))
			redirect('mentorship/login');
			
		$this->load->library('form_validation');
		$this->form_validation->set_rules('activities', 'Activities', 'trim|required');
		$this->form_validation->set_rules('comments', 'Comments', 'trim|required');
		if(count($_POST) > 0) {
			if($this->form_validation->run()) {
				$this->mentorshipmod->editLog($id);
				redirect('mentorship');
			}
		}
		
		$data['entry'] = $this->mentorshipmod->getEntryById($id);
		
		$this->load->view('wrapper/header');
		$this->load->view('mentorship/edit',$data);
		$this->load->view('wrapper/footer');
	}
	
	public function delete($id)
	{
		if(!$this->loginmod->checkLogin('mentorship_users'))
			redirect('mentorship/login');
		
		$this->mentorshipmod->deleteLog($id);
		redirect('mentorship');
	}
	
	public function login()
	{
		if($this->loginmod->checkLogin('mentorship_users'))
			redirect('mentorship');
			
		$this->load->view('wrapper/header');
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
			else
				$this->load->view('mentorship/login');
		}
		else
			$this->load->view('mentorship/login');
			
		$this->load->view('wrapper/footer');
	}
	
	public function logout()
	{
		if(!$this->loginmod->checkLogin('mentorship_users'))
			redirect('mentorship/login');
		
		$this->session->sess_destroy();
		redirect();
	}
	
	public function change_password()
	{
		if(!$this->loginmod->checkLogin('mentorship_users'))
			redirect('mentorship/login');
		
		$this->load->view('wrapper/header');
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
			else
				$this->load->view('mentorship/change_password');
		}
		else
			$this->load->view('mentorship/change_password');
		
		$this->load->view('wrapper/footer');
	}
	
	public function view($id = 0, $key = 0, $offset = 0)
	{
		if($id == 0 || $key == 0)
			redirect();
			
		if(!$this->mentorshipmod->checkKey($key, $id))
			redirect();
			
		$data['log'] = $this->mentorshipmod->getEntries($id, 10, $offset);
		$data['user'] = $this->mentorshipmod->getUserInfo($id);
			
		$this->load->library('pagination');
		$config['base_url'] = $this->config->item('base_url').'mentorship/view/'.$id.'/'.$key.'/';
		$config['total_rows'] =  $data['log']->num_rows();
		$config['per_page'] = 10;
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		$config['full_tag_open'] = '<p style="text-align:center;">';
		$this->pagination->initialize($config);
		$data['pageLinks'] = $this->pagination->create_links();
		
		$this->load->view('wrapper/header');
		$this->load->view('mentorship/view',$data);
		$this->load->view('wrapper/footer');
	}
	
	public function check_password()
	{
		return $this->loginmod->checkPassword('mentorship_users', $this->loginmod->getUserId('mentorship_users'));
	}
}