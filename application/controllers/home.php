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