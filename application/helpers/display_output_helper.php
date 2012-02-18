<?php
if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

function display_output($view, $data = null, $options = array()) {
	$CI =& get_instance();
	
    if (!isset($options['section'])) {
        $templatedir = 'wrapper';
    } else {
        $templatedir = 'wrapper/' . $options->section;
    }
    
    $CI->load->view($templatedir  . '/header');
    $CI->load->view($view, $data);
    $CI->load->view($templatedir  . '/footer');
}
?>