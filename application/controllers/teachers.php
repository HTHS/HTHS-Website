<?php

class Teachers extends CI_Controller {

	function __construct()
	{
		//Call controller constructor
		parent::__construct();
        
		$this->load->model('teachermod');
		$this->load->model('loginmod');
        
        if ($this->loginmod->checkLogin('teacher')) {
            $isAuthorized = true; 
        } else {
            $isAuthorized = false;
        }
	}
	
	public function index()
	{
        // Displays a list of teachers, with links to their pages, blogs, and contact forms. 
        
		$data['teachers'] = $this->teachermod->getTeacherList();
		
		display_output('teachers/index',$data);
	}
	
    public function about($username) {
        // Run by default when the user goes to /teachers/SomeTeacher, displays some biographical info and a photo, links to pages and blog
        
        $id = $this->teachermod->getTeacherId($username);
        $data['teacher'] = $this->teachermod->getTeacherInfo($id);
        
        display_output('teachers/about', $data);
    }
    
    public function page($username, $page_url) {
        $teacher_id = $this->teachermod->getTeacherId($username);
        if ($teacher_id == false) {
            show_404();
        }
        
        $page_id = $this->teachermod->getPageId($teacher_id, $page_url)
        if ($page_id == false) {
            show_404();
        }
        
        $data['page'] = $this->teachermod->getPage($page_id);
        $data['teacher'] = $this->teachermod->getTeacherInfo($teacher_id);
        
        display_output('teachers/pages', $data);
    }
    
    public function blog_home($username) {
        $teacher_id = $this->teachermod->getTeacherId($username);
        if ($teacher_id == false) {
            show_404();
        }
        
		$data['blog'] = $this->teachermod->getBlogEntries($id, 10, $entryNum);
		$data['teacher'] = $this->teachermod->getTeacherInfo($teacher_id);
        
		$this->load->library('pagination');
		$config['base_url'] = $this->config->item('base_url') . 'teachers/' . $username . '/blog';
		$config['total_rows'] =  $this->teachermod->countBlogEntries($teacher_id);
		$config['per_page'] = 10;
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		$config['full_tag_open'] = '<p style="text-align:center;">';
		$this->pagination->initialize($config);
		$data['page_links'] = $this->pagination->create_links();
		
		display_output('teachers/blog_home', $data);
    }
    
    public function blog_entry($username, $post_id) {
        $teacher_id = $this->teachermod->getTeacherId($username);
        if ($teacher_id == false) {
            show_404();
        }
        
        $data['item'] = $this->teachermod->getBlogById($post_id);
        
        if ($data['item']->teacher_id != $teacher_id) {
            show_404();
        }
        
        display_output('teachers/blog_entry', $data);
    }

}