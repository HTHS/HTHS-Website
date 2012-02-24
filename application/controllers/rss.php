<?php
if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

class Rss extends CI_Controller {
    
    public function feed($category = 'news', $num_of_items = 10) {
        if ($category == 'news') {
            $this->load->model('newsmod');
            
            $data['title'] = "HTHS Latest News";
            $data['description'] = "The latest news postings from High Technology High School.";
            $data['link'] = base_url();
            $data['items'] = $this->newsmod->getNews($num_of_items);
            
            foreach ($data['items'] as &$item) {
                $item->link = site_url('news/view/' . $item->id);
            }
        } else {
            $this->load->model('teachermod');
            
            $teacher_id = $this->teachermod->getTeacherId($category);
            $teacher_info = $this->teachermod->getTeacherInfo($teacher_id);
            
            $data['title'] = $teacher_info->name . '\'s Latest Blog Posts';
            $data['description'] = "The latest blog posts by " . $teacher_info->name;
            $data['link'] = site_url('teachers/' . $teacher_info->username);
            $data['items'] = $this->teachermod->getBlogEntries($teacher_id, $num_of_items);
            
            foreach ($data['items'] as &$item) {
                $item->link = site_url('teachers/' . $teacher_info->username . '/blog/view' . $item->id);
            }
        }
        
        header('Content-Type: application/rss+xml');
        $this->load->view('rss/feed', $data);
		
		$this->output->enable_profiler(false);
    }
    
}