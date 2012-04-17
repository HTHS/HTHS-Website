<?

class Mentorshipmod extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function getAllData()
	{
		$data['logs'] = $this->db->get('mentorship_logs');
		$data['users'] = $this->db->get('mentorship_users');
		return $data;
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
			
		return $this->db->query("SELECT `name`, `date`
			FROM (
				SELECT `mentorship_users`.`name` AS name, `mentorship_logs`.`date` AS date
				FROM `mentorship_users`
				LEFT OUTER JOIN `mentorship_logs`
				ON `mentorship_logs`.`user_id` = `mentorship_users`.`id` 
				AND `mentorship_users`.`year` = '".$vals['year']."'
				AND `mentorship_users`.`semester` = '".$vals['semester']."'
				GROUP BY `mentorship_users`.`name`
				HAVING `mentorship_logs`.`date` = MAX(`mentorship_logs`.`date`)
				) AS SUBQUEREY
			WHERE (
				(`date` + ".( 604800 * $weeks ).") <= ".time()."
				OR `date` IS NULL )
			ORDER BY `name` ASC");
	}
		
	public function logEntry()
	{
		$data = array (
				'user_id' => $this->session->userdata('id'),
				'date' => friendly_to_unix($this->input->post('date')),
				'in_time' => $this->input->post('in', TRUE), //XSS clean this input
				'out_time' => $this->input->post('out', TRUE), //XSS clean this input
				'activities' => $this->input->post('activities', TRUE), //XSS clean this input
				'comments' => $this->input->post('comments', TRUE) //XSS clean this input
			);
		
		$this->db->insert('mentorship_logs', $data);
	}
	
	public function editLog($id)
	{
		$data = array (
				'in_time' => $this->input->post('in', TRUE), //XSS clean this input
				'out_time' => $this->input->post('out', TRUE), //XSS clean this input
				'activities' => $this->input->post('activities', TRUE), //XSS clean this input
				'comments' => $this->input->post('comments', TRUE) //XSS clean this input
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
	
	public function countEntries($id)
	{
		$this->db->where('user_id', $id);
		return $this->db->get('mentorship_logs')->num_rows();
	}
	
	public function getTimes($id)
	{
		$this->db->select('date, in_time, out_time');
		$this->db->from('mentorship_logs');
		$this->db->where('user_id', $id);
		$this->db->order_by('date', 'desc');
		
		return $this->db->get();
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