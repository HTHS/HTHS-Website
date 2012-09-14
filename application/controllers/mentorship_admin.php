<?

class Mentorship_admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('loginmod');
		$this->load->model('mentorshipmod');
		
		if(!$this->loginmod->checkLogin('teacher') || !$this->session->userdata('mentorship_admin'))
			redirect('teachers/dashboard');
	}
	
	public function index()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('year', 'Year', 'trim|required|min_length[4]|max_length[4]');
		
		if(count($_POST) > 0) 
		{
			if($this->form_validation->run())
				$this->mentorshipmod->updateSettings();
		}
		
		$data['settings'] = $this->mentorshipmod->getSettings();
		$data['problemUsers'] = $this->mentorshipmod->getStudentsWithNoLogs();
		$data['currentStudents'] = $this->mentorshipmod->getStudents($data['settings']['year'], $data['settings']['semester']);
		$data['visits'] = $this->mentorshipmod->getSiteVisits(mktime(0,0,0,date('n',time()),date('j',time()),date('Y',time())), mktime(0,0,0,date('n',time()),date('j',time()),date('Y',time())));
		
		$this->output->display_output('mentorship_admin/index', $data, array('section' => 'teacher'));
	}
	
	public function add_student()
	{
		$this->load->library('form_validation');
		$this->load->library('email');
		
		$this->form_validation->set_rules('name', 'Name', 'trim|required|is_unique[mentorship_users.name]');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('firm', 'Firm', 'trim|required');
		$this->form_validation->set_rules('mentor', 'Mentor', 'trim|required');
		$this->form_validation->set_rules('tags', 'Tags', 'trim');
		$this->form_validation->set_rules('year', 'Year', 'trim|required|min_length[4]|max_length[4]');
		$this->form_validation->set_message('is_unique', 'That student already exists.');
		
		if(count($_POST) > 0)
		{
			if($this->form_validation->run())
			{
				$username = explode(' ', $this->input->post('name'));
				$username = substr($username[0], 0, 1).$username[1];
				
				$password = $this->mentorshipmod->addStudent($username);
				$this->email->subject('HTHS Website Mentorship Login');
				$this->email->to($this->input->post('email'));
				$this->email->from('noreply@hths.mcvsd.org', 'HTHS Security Robot');
				$this->email->message('Your High Technology High School website mentorship logs account has been successfully created.

Username: '.$username.'
Password: '.$password.'

Please use the link below to access and update your logs, once you login you can change your password there.
'.site_url('mentorship').'

Thank You,
The HTHS Web Team');

				$this->email->send();
				
				redirect('teachers/dashboard/mentorship/students');
			}
		}
		
		$this->output->display_output('mentorship_admin/add_student', array(), array('section' => 'teacher'));
	}

	public function students()
	{
		$year = $this->input->get('year',TRUE);
		$semester = $this->input->get('semester',TRUE);
		
		if($year == 0 || $semester == 0)
			$defaults = $this->mentorshipmod->getSettings();
		
		if($year == 0)
			$year = $defaults['year'];
		if($semester == 0)
			$semester = $defaults['semester'];
		
		$data['students'] = $this->mentorshipmod->getStudents($year, $semester);
		$data['year'] = $year;
		$data['semester'] = $semester;
		
		$this->output->display_output('mentorship_admin/manage_students', $data, array('section' => 'teacher'));
	}
	
	public function edit_student($id)
	{
		$this->load->library('form_validation');
		$this->load->helper('date');
		
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('firm', 'Firm', 'trim|required');
		$this->form_validation->set_rules('mentor', 'Mentor', 'trim|required');
		$this->form_validation->set_rules('tags', 'Tags', 'trim');
		$this->form_validation->set_rules('year', 'Year', 'trim|required|min_length[4]|max_length[4]');
		$this->form_validation->set_rules('site_visit', 'Site Visit', 'trim');

		if(count($_POST) > 0)
		{
			if($this->form_validation->run()) {
				$this->mentorshipmod->updateAccount($id);
				redirect('teachers/dashboard/mentorship/students');
			}
		}
		
		$data['user'] = $this->mentorshipmod->getUserInfo($id);
		
		$this->output->display_output('mentorship_admin/edit_student', $data, array('section' => 'teacher'));
	}
	
	public function delete_student($id)
	{
		$this->mentorshipmod->deleteAccount($id);
		redirect('teachers/dashboard/mentorship/students');
	}
	
	public function reset_password($id)
	{
		$newPassword = $this->loginmod->changePassword('mentorship_users', $id);
		$user = $this->mentorshipmod->getUserInfo($id);
		$this->load->library('email');
		
		$this->email->subject('HTHS Website Mentorship Login');
		$this->email->to($user->email);
		$this->email->from('noreply@hths.mcvsd.org', 'HTHS Security Robot');
		$this->email->message('Your High Technology High School website mentorship logs account password has been reset. Your new login information is as follows.

Username: '.$user->username.'
Password: '.$newPassword.'

Please use the link below to access and update your logs. Please change your password when you login.
'.site_url('mentorship').'

Thank You,
The HTHS Web Team');

		$this->email->send();
		
		redirect('teachers/dashboard/mentorship/students');
	}
		
	
	public function view($id, $offset = 1)
	{			
		$this->load->library('pagination');
		$config['base_url'] = $this->config->item('base_url').'teachers/dashboard/mentorship/view/'.$id.'/';
		$config['total_rows'] =  $this->mentorshipmod->countEntries($id);
		$config['per_page'] = 5;
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		$config['full_tag_open'] = '<p style="text-align:center;">';
		$config['use_page_numbers'] = true;
		$config['uri_segment'] = 6;
		$this->pagination->initialize($config);
		$data['pageLinks'] = $this->pagination->create_links();
		
		$data['log'] = $this->mentorshipmod->getEntries($id, 5, (($offset - 1) * $config['per_page']));
		$data['user'] = $this->mentorshipmod->getUserInfo($id);
		
		$this->output->display_output('mentorship_admin/view', $data, array('section' => 'teacher'));
	}
	
	public function view_times($id)
	{
		$data['log'] = $this->mentorshipmod->getTimes($id);
		$data['user'] = $this->mentorshipmod->getUserInfo($id);
		
		$this->output->display_output('mentorship_admin/time_sheets', $data, array('section' => 'teacher'));
	}
	
	public function search()
	{
		$field = intval($this->input->get('field',TRUE));
		$query = $this->input->get('query',TRUE);
		
		$allowedFields = array('name','email','firm','mentor','tags');
		
		if($field != '' && $query != '' && $field >= 0 && $field <= 4) {
			$data['results'] = $this->mentorshipmod->search($allowedFields[$field], $query);
			if($data['results']->num_rows() == 0)
				$data['results'] = '';
		}
		else
			$data['results'] = '';
		
		$this->output->display_output('mentorship_admin/search', $data, array('section' => 'teacher'));
	}
	
	public function site_visits($year = 0, $month = 0)
	{
		if($year == 0)
			$year = date('Y',time());
		if($month == 0)
			$month = date('n',time());
		
		$startTime = mktime(0,0,0,$month,1,$year);
		$endTime = mktime(0,0,0,$month + 1,0,$year);
		
		$siteVisits = $this->mentorshipmod->getSiteVisits($startTime, $endTime);
		$dates = array();
		
		foreach($siteVisits->result() as $visit) {
			$dates[date('j',$visit->site_visit)] = 'javascript:showDetails('.date('j',$visit->site_visit).');';
		}
		
		$prefs = array (
               'show_next_prev'  => TRUE,
               'next_prev_url'   => site_url('teachers/dashboard/mentorship/site_visits/')
             );

		$this->load->library('calendar', $prefs);

		$data['calendar'] = $this->calendar->generate($year, $month, $dates);
		$data['visits'] = $siteVisits;
				
		$this->output->display_output('mentorship_admin/site_visits', $data, array('section' => 'teacher'));
	}
	
	public function presentations()
	{
		$this->load->helper('date');
		
		if(count($_POST) > 0) {
			$this->mentorshipmod->saveScheduleDates();
		}
		
		$data = $this->mentorshipmod->getSchedule();
		$data['slots'] = $this->mentorshipmod->getScheduleDates();
		
		$data['sl'] = array();
		$temp_date = '';
		$i = 0;
		foreach($data['slots']->result() as $value) {
			if($value->date != $temp_date) {
				$temp_date = $value->date;
			}
			$data['sl'][$temp_date][$i] = $value;
			$i++;
		}
		
		$temp_date = '';
		$data['sch'] = array();
		$i = 0;
		foreach($data['schedule']->result() as $value) {
			if($value->date != $temp_date) {
				$temp_date = $value->date;
			}
			$data['sch'][$temp_date][$i] = $value;
			$i++;
		}
		
		$this->output->display_output('mentorship_admin/presentations', $data, array('section' => 'teacher'));
	}
	
	public function backup()
	{
		$this->load->library('zip');
		$systemData = $this->mentorshipmod->getAllData();
		$userdata = 'id|name|username|email|firm|mentor|tags|semester|year\n';
		foreach($systemData['users']->result() as $user) 
			$userdata .= $user->id.'|'.$user->name.'|'.$user->username.'|'.$user->email.'|'.$user->firm.'|'.$user->mentor.'|'.$user->tags.'|'.$user->semester.'|'.$user->year.'\n';
		$this->zip->add_data('backup_time.txt', 'Backup run at: '.date('m/d/Y', time()));
		$this->zip->add_data('user_manifest.txt', $userdata);
		$this->zip->add_data('log_template.txt', 'user_id|date|time_in|time_out|activities|comments');
		foreach($systemData['logs']->result() as $log) {
			$logData = $log->user_id.'|'.$log->date.'|'.$log->in_time.'|'.$log->out_time.'|'.$log->activities.'|'.$log->comments.'\n';
			$this->zip->add_data('logs/'.$log->id.'.txt', $logData);
		}
		
		$this->zip->archive('application/cache/mentorship_backup.zip');
		$this->zip->download('application/cache/mentorship_backup.zip');
	}
}