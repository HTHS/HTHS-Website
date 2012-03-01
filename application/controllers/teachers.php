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
		
		$this->output->display_output('teachers/index',$data);
	}
	
    public function about($username) {
        // Run by default when the user goes to /teachers/SomeTeacher, displays some biographical info and a photo, links to pages and blog
        
        $teacher_id = $this->teachermod->getTeacherId($username);
        $data['teacher'] = $this->teachermod->getTeacherInfo($teacher_id);
        $data['entries'] = $this->teachermod->getBlogEntries($teacher_id, 5);
        $data['pages'] = $this->teachermod->getPageList($teacher_id)->result();
        
        $this->output->display_output('teachers/about', $data);
    }
    
    public function page($username, $page_url) {
        // Accessed via URL: /teachers/$username/page/$page_url
        // Displays the specified page for the teacher.
        
        $teacher_id = $this->teachermod->getTeacherId($username);
        if ($teacher_id == false) {
            show_404();
        }
        
        $page_id = $this->teachermod->getPageId($teacher_id, $page_url);
        if ($page_id == false) {
            show_404();
        }
        
        $data['page'] = $this->teachermod->getPageById($page_id);
        $data['teacher'] = $this->teachermod->getTeacherInfo($teacher_id);
        
        $this->output->display_output('teachers/pages', $data);
    }
    
    public function blog_home($username, $page = 1) {
        // Accessed via URL: /teachers/$username/blog [/page/1]
        // Displays a list of recent posts with summaries and links to the full posts. 
        
        $teacher_id = $this->teachermod->getTeacherId($username);
        if ($teacher_id == false) {
            show_404();
        }
        
		$this->load->library('pagination');
		$config['base_url'] = $this->config->item('base_url') . 'teachers/' . $username . '/blog/page/';
		$config['total_rows'] = $this->teachermod->countBlogEntries($teacher_id);
		$config['per_page'] = 10;
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		$config['full_tag_open'] = '<p style="text-align:center;">';
        $config['use_page_numbers'] = true;
		$this->pagination->initialize($config);
		$data['page_links'] = $this->pagination->create_links();
        
        $data['entries'] = $this->teachermod->getBlogEntries($teacher_id, $config['per_page'], (($page - 1) * $config['per_page']));
		$data['teacher'] = $this->teachermod->getTeacherInfo($teacher_id);
		
		$this->output->display_output('teachers/blog_home', $data);
    }
    
    public function blog_entry($username, $post_id) {
        // Accessed via URL: /teachers/$username/blog/view/$post_id
        // Retrieves a blog post by the post's id. 
        // If the requested post's id wasn't posted by the specfied teacher, then don't show it.
        
        $teacher_id = $this->teachermod->getTeacherId($username);
        if ($teacher_id == false) {
            show_404();
        }
        
        $data['item'] = $this->teachermod->getBlogById($post_id);
        
        if ($data['item']->teacher_id != $teacher_id) {
            show_404();
        }
        
        $this->output->display_output('teachers/blog_entry', $data);
    }

}