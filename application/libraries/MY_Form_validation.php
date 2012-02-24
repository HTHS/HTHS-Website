<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Form Validation Class Extension
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Validation
 * @author		Jeffery Mooneyham
 */
 
/**Changes: 
 
 *Added support for is_not_unique[table.field] rule
 *Changed the error delimiters
 
 */
 
 class MY_Form_validation extends CI_Form_validation {
 
	public function __construct()
	{
		//Call parent constructor
		parent::__construct();
		
		$this->CI =& get_instance();
		
		$this->_error_prefix = '<div class="error"><p>';
		$this->_error_suffix = '</p></div>';
	}
	
	/**
	 * Match one field against another, opposite of is_unique
	 *
	 * @access	public
	 * @param	string
	 * @param	field
	 * @return	bool
	 */
	public function is_not_unique($str, $field)
	{
		list($table, $field)=explode('.', $field);
		$query = $this->CI->db->limit(1)->get_where($table, array($field => $str));
		
		return $query->num_rows() !== 0;
    }
	
}

?>