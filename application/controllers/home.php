<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
    {
        // Call the Controller constructor
        parent::__construct();
		
		$this->load->model('newsmod');
		$this->load->model('teachermod');
		$this->load->model('emailmod');
		$this->load->model('pagesmod');
    }
	
	public function index()
	{
		$data['news'] = $this->newsmod->getNews(4);
		
		$this->output->display_output('home/index', $data);
	}
	
	public function faculty()
	{
		$this->load->helper('captcha');
		$this->load->model('captcha');
		$data['teachers'] = $this->teachermod->getTeacherList();
		
		$vals = array(
			'img_path'	 => 'images/verification/',
			'img_url'	 => site_url('images/verification').'/',
			'img_width'	 => 150,
			'img_height' => 50,
			);

		$data['cap'] = create_captcha($vals);
		$this->captcha->addCaptcha($data['cap']);
		
		$this->output->display_output('home/faculty',$data);
	}
	
	public function teacher_pages($id = 0)
	{
		if($id == 0)
			show_404();
			
		$data['page'] = $this->teachermod->getPage($id);
		$data['teacher'] = $this->teachermod->getTeacherInfo($id);
		
		$this->output->display_output('home/teacher_pages',$data);
	}
	
	public function blogs($id = 0, $entryNum = 0)
	{
		if($id == 0)
			show_404();
			
		$data['blog'] = $this->teachermod->getBlogEntries($id, 10, $entryNum);
		$data['teacher'] = $this->teachermod->getTeacherInfo($id);
			
		$this->load->library('pagination');
		$config['base_url'] = $this->config->item('base_url').'home/blogs/'.$id.'/';
		$config['total_rows'] =  $this->teachermod->countBlogEntries($id);
		$config['per_page'] = 10;
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		$config['full_tag_open'] = '<p style="text-align:center;">';
		$this->pagination->initialize($config);
		$data['page_links'] = $this->pagination->create_links();
		
		$this->output->display_output('home/blogs',$data);
	}
	
	public function search()
	{
		$this->output->display_output('home/search');
	}

	public function groups()
	{
		$this->load->library('form_validation');
		$page = 'home/groups';
		$data = array();
		
		if(count($_POST) > 0) {
			if($this->input->post('step') == '1')
			{
				$this->form_validation->set_rules('studentCount', 'Number of Students', 'trim|required|numeric');
				$this->form_validation->set_rules('groups', 'Number of Groups', 'trim|required|numeric');
				if($this->form_validation->run()) {
					$data['count'] = $this->input->post('studentCount');
					$data['groups'] = $this->input->post('groups');
					$page = 'home/groups2';
				}
			} elseif ($this->input->post('step') == '2') {
				$rules = array();
				for($i = 1; $i <= $this->input->post('count'); $i++){
					$rules[] = array(
						'field' => 'student'.$i,
						'label' => 'Student '.$i,
						'rules' => 'trim|required');
				}
				$this->form_validation->set_rules($rules);
				if($this->form_validation->run()) {
					$sequence = array();
					for($i = 1; $i <= $this->input->post('count'); ) {
						$randomNum = rand(1, $this->input->post('count'));
						if(!in_array($randomNum, $sequence)) {
							$sequence[$i] = $randomNum;
							$i++;
						}
					}

					$groups = array();
					$i = 1;
					for($j = 1; $j <= $this->input->post('groups'); $j++) {
						$groups[$j] = array();
						for($k = 1; $k <= $this->input->post('count') / $this->input->post('groups'); $k++) {
							$groups[$j][$k] = $this->input->post('student'.$sequence[$i]);
							$i++;
						}
					}
					
					$data['groups'] = $groups;
					$page = 'home/groups3';
				} else {
					$page = 'home/groups2';
					$data['count'] = $this->input->post('count');
					$data['groups'] = $this->input->post('groups');
				}
			}
		}
		
		$this->output->display_output($page, $data);
	}
}