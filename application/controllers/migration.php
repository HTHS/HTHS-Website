<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration extends CI_Controller {
    
    public function index() {
        $this->version('current');
    }
    
    public function version($version) {
        $this->load->library('migration');
        if ($version == 'current') {
            $migration = $this->migration->current();
        } else {
            $migration = $this->migration->version($version);
        }
        
        if (!$migration) {
            show_error($this->migration->error_string());
        } else {
            echo "Migration to version $version was successful.";
        }
    }
    
}