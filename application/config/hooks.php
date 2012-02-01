<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['post_controller_constructor'] = array(
                                'class'    => 'Enable_profiler',
                                'function' => 'profile',
                                'filename' => 'Enable_profiler.php',
                                'filepath' => 'hooks',
                                'params'   => array()
                                );
							
$hook['post_controller'] = array(
                                'class'    => 'Site_status',
                                'function' => 'checkStatus',
                                'filename' => 'Site_status.php',
                                'filepath' => 'hooks',
                                'params'   => array()
                                );

/* End of file hooks.php */
/* Location: ./application/config/hooks.php */