<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class bendahara extends CI_Controller {

	public function __construct()
    {
        parent::__construct();								
    	//$this->output->enable_profiler(TRUE);
        $this->load->model('person_model','person');
    }	
	
	public function index()
	{
	       
	}
	
	public function daftar_ulang() 
	{
		$this->auth->check_auth();
		$data = array();
		$data['list'] = $this->person->new_student_list();					
		$content['page'] = $this->load->view('bendahara/daftar_ulang',$data,TRUE);
        $this->load->view('dashboard',$content);	
	}
	
	
}