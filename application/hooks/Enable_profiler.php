<?php 

class Enable_profiler {
	
	protected $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	public function profile()
	{
		$this->CI->output->enable_profiler( $this->CI->config->item('enable_profiler') );
	}
}