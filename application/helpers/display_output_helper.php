<?php
if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

function display_output($view, $data = null, $options = array()) {
    if (!defined($options->section)) {
        $templatedir = 'wrapper';
    } else {
        $templatedir = 'wrapper/' . $options->section;
    }
    
    $this->load->view($templatedir  . '/header');
    $this->load->view($view, $data);
    $this->load->view($templatedir  . '/footer');
}
?>