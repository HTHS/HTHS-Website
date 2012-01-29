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

	public function registerAccount()
	{
	
		$salt = random_string('alnum', 16);
		$hash = md5($this->config->item('hardsalt') . $this->input->post('password') . $salt);
		$key = random_string('numeric', 11);
		
		$data = array (
				'name' => $this->input->post('name'),
				'username' => $this->input->post('username'),
				'hash' => $hash,
				'salt' => $salt,
				'firm' => $this->input->post('firm'),
				'mentor' => $this->input->post('mentor'),
				'contact' => $this->input->post('contact'),
				'semester' => $this->input->post('semester'),
				'year' => $this->input->post('year'),
				'private_key' => $key
			);
			
		$this->db->insert('mentorship_users', $data);
	}
	
	public function updateAccount($id)
	{
		$data = array (
				'name' => $this->input->post('name'),
				'firm' => $this->input->post('firm'),
				'mentor' => $this->input->post('mentor'),
				'contact' => $this->input->post('contact'),
				'semester' => $this->input->post('semester'),
				'year' => $this->input->post('year')
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
	
	public function logEntry()
	{
		$data = array (
				'user_id' => $this->session->userdata('id'),
				'date' => $this->input->post('date'),
				'activities' => $this->input->post('activities'),
				'comments' => $this->input->post('comments')
			);
		
		$this->db->insert('mentorship_logs', $data);
	}
	
	public function editLog($id)
	{
		$data = array (
				'activities' => $this->input->post('activities'),
				'comments' => $this->input->post('comments')
			);
		
		$this->db->where('id', $id);
		$this->db->update('mentorship_logs', $data);
	}
	
	public function deleteLog($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('mentorship_logs');
	}
	
	public function getEntries($id, $number = 10, $offset = 0, $all = false)
	{
		$this->db->where('user_id', $id);
		if(!$all)
			$this->db->limit($number, $offset);
		return $this->db->get('mentorship_logs');
	}
	
	public function getUserInfo($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('mentorship_users');
	}
	
	public function getUsers()
	{
		return $this->db->get('mentorship_users');
	}
}