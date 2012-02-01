<?

class Site_status {

	private $CI;
	
	function __construct()
	{
		$this->CI =& get_instance();
	}
	
	public function checkStatus()
	{
		$this->CI->db->where('setting_name', 'online');
		$status = $this->CI->db->get('site_settings')->row();
		
		if($status->setting_value == 0 && $this->CI->uri->segment(1) != 'admin') 
		{
			$this->CI->db->where('setting_name', 'offline_message');
			$offline_message = $this->CI->db->get('site_settings')->row()->setting_value;
			
			show_error($offline_message);
		}
	}
}