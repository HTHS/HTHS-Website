<?php
if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Menu {
    
    public function get_menu_data($raw = false) {
    	$CI = &get_instance();
		
        $CI->db->from('site_settings');
        $CI->db->where('setting_name', 'menu');
        $menu = $CI->db->get()->row()->setting_value;
		
		if (!$raw) {
			$menu = json_decode($menu);
		}
        
        return $menu;
    }
    
    public function save_menu_data($menu, $raw = false) {
    	$CI = &get_instance();
		
    	if (!$raw) {
    		$menu = json_encode($menu);
    	}
        $data['setting_value'] = $menu;
        $CI->db->where('setting_name', 'menu');
        $CI->db->update('site_settings', $data);
    }
	
	private function generate_url($url) {
		if (substr($url, 0, 4) == "http") {
			return $url;
		} else {
			return site_url($url);
		}
	}
    
    public function render() {		
        $menu = $this->get_menu_data();
        $output = '<ul>';
        
        foreach ($menu as $column) { // Loop through all the columns in the $menu array
            $output .= '<li><a href="' . $this->generate_url($column[0]->url) . '">' . $column[0]->title . '</a>'; // Make the first item in the column a button on the navbar
            
            if (count($column) > 1) { // If there's more than one item in the column, then add the rest as a dropdown menu
                $output .= '<ul>';
                
                for ($i=1; $i<count($column); $i++) {
                    $output .= '<li><a href="' . $this->generate_url($column[$i]->url) . '">' . $column[$i]->title . '</a></li>';
                }
                
                $output .= '</ul>';
            }
            
            $output .= '</li>';
        }
        
        $output .= '</ul>';
        
        return $output;
    }
}
?>