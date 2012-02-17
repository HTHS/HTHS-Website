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

}