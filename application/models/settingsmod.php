<?php
if (!defined('BASEPATH')) { exit('No direct script access allowed.'); }

class Settingsmod extends CI_Model {
    
    function get_all() {
        $query = $this->db->get('settings');
        return $query->result();
    }
    
    function add($setting) {
        $this->db->insert('settings', $setting);
    }
    
    function edit($setting) {
        $this->db->where('id', $setting->id);
        $this->db->update('settings', $setting);
    }
    
}

?>