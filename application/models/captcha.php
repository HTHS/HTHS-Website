<?

class Captcha extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
	
	public function addCaptcha($cap)
	{
		$data = array(
			'captcha_time'	=> $cap['time'],
			'ip_address'	=> $this->input->ip_address(),
			'word'	 		=> $cap['word']
			);
		
		$this->db->insert('captcha', $data);
	}
	
	public function checkCaptcha($word)
	{
		$this->db->where('captcha_time', time()-'7200');
		$this->db->delete('captcha');
		
		$this->db->where('word', $word);
		$this->db->where('ip_address', $this->input->ip_address());
		return $this->db->get('captcha')->num_rows() > 0;
	}
}