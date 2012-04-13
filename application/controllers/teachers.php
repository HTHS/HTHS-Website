<?php

class Teachers extends CI_Controller {

	function __construct()
	{
		//Call controller constructor
		parent::__construct();
        
		$this->load->model('teachermod');
		$this->load->model('loginmod');
		$this->load->model('curlmod');
        
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
        $data['pages'] = $this->teachermod->getPageList($teacher_id)->result();
		if($data['teacher']->blog != '')
			$data['entries'] = $this->curlmod->fetchBlogEntries($data['teacher']->blog.'/atom.xml', 6, $teacher_id);
        
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
}