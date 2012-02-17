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
	

}