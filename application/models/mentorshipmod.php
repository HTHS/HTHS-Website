<?

class Mentorshipmod extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function checkKey($key, $id)
	{
		$this->db->where('id', $id);
		$this->db->where('private_key', $key);
		return $this->db->get('mentorship_users')->num_rows > 0;
	}

	public function addStudent($username)
	{
	
		$salt = random_string('alnum', 16);
		$password = random_string('alnum', 16);
		$hash = md5($this->config->item('hardsalt') . $password . $salt);
		$key = random_string('numeric', 9);
		
		$data = array (
				'name' => $this->input->post('name'),
				'username' => $username,
				'email' => $this->input->post('email'),
				'hash' => $hash,
				'salt' => $salt,
				'firm' => $this->input->post('firm'),
				'mentor' => $this->input->post('mentor'),
				'tags' => $this->input->post('tags'),
				'semester' => $this->input->post('semester'),
				'year' => $this->input->post('year'),
				'private_key' => $key
			);
			
		$this->db->insert('mentorship_users', $data);
		
		return $password;
	}
	
	public function updateAccount($id)
	{
		$data = array (
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'firm' => $this->input->post('firm'),
				'mentor' => $this->input->post('mentor'),
				'tags' => $this->input->post('tags'),
				'semester' => $this->input->post('semester'),
				'year' => $this->input->post('year'),
				'site_visit' => friendly_to_unix($this->input->post('site_visit'))
			);
			
		$this->db->where('id', $id);
		$this->db->update('mentorship_users', $data);
	}
	
	public function deleteAccount($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('mentorship_users');
		
		$this->db->where('id', $id);
		$this->db->delete('mentorship_logs');
	}
	
	public function getSettings()
	{
		$query = $this->db->get('mentorship_settings')->result();
		$vals = array();
		foreach($query as $row)
			$vals[$row->setting_name] = $row->setting_value;
		
		return $vals;
	}
	
	public function updateSettings()
	{
		$data = array (
				'setting_value' => $this->input->post('year')
			);
		
		$this->db->where('setting_name', 'year');
		$this->db->update('mentorship_settings', $data);
		
		$data = array (
				'setting_value' => $this->input->post('semester')
			);
		
		$this->db->where('setting_name', 'semester');
		$this->db->update('mentorship_settings', $data);
	}
	
	public function getStudentsWithNoLogs($weeks = 2)
	{
		$query = $this->db->get('mentorship_settings')->result();
		$vals = array();
		foreach($query as $row)
			$vals[$row->setting_name] = $row->setting_value;
			
		return $this->db->query('SELECT *
			FROM `mentorship_users`
			LEFT OUTER JOIN `mentorship_logs`
			ON `mentorship_logs`.`user_id` = `mentorship_users`.`id`
			WHERE 
				( 
					(`mentorship_logs`.`date` + '.( 604800 * $weeks ).') <= '.time().'
					OR `mentorship_logs`.`date` IS NULL 
				)
				AND `mentorship_users`.`year` = '.$vals['year'].'
				AND `mentorship_users`.`semester` = '.$vals['semester'].'
			GROUP BY `mentorship_users`.`id`
			ORDER BY `mentorship_users`.`name` ASC');
	}
		
	public function logEntry()
	{
		$data = array (
				'user_id' => $this->session->userdata('id'),
				'date' => friendly_to_unix($this->input->post('date')),
				'activities' => $this->input->post('activities', TRUE), //XSS clean this input
				'comments' => $this->input->post('comments', TRUE) //XSS clean this input
			);
		
		$this->db->insert('mentorship_logs', $data);
	}
	
	public function editLog($id)
	{
		$data = array (
				'activities' => $this->input->post('activities'), //XSS clean this input
				'comments' => $this->input->post('comments') //XSS clean this input
			);
		
		$this->db->where('id', $id);
		$this->db->update('mentorship_logs', $data);
	}
	
	public function deleteLog($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('mentorship_logs');
	}
	
	public function getEntryById($id)
	{
		$this->db->where('id',$id);
		return $this->db->get('mentorship_logs')->row();
	}
	
	public function getEntries($id, $number = 5, $offset = 0, $all = false)
	{
		$this->db->where('user_id', $id);
		if(!$all)
			$this->db->limit($number, $offset);
		$this->db->order_by('date', 'desc');
		return $this->db->get('mentorship_logs');
	}
	
	public function getUserInfo($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('mentorship_users')->row();
	}
	
	public function getStudents($year = 0, $semester = 0)
	{
		if($year != 0)
			$this->db->where('year', $year);
		if($semester != 0)
			$this->db->where('semester', $semester);
		
		$this->db->order_by('name', 'ASC');
		return $this->db->get('mentorship_users');
	}
	
	public function search($field, $query)
	{
		$this->db->like($field, $query);
		$this->db->order_by('name', 'ASC');
		return $this->db->get('mentorship_users');
	}
	
	public function getSiteVisits($startDate, $endDate)
	{
		$this->db->where('site_visit >=',$startDate);
		$this->db->where('site_visit <=',$endDate);
		
		return $this->db->get('mentorship_users');
	}
}