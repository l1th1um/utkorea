<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        #$this->output->enable_profiler(TRUE);
    }
    
    public function index()
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			$this->load->model('announcement_model','announcement');
			
			$data = array();
			
			if ($this->announcement->get_recent_news() == false) {
				$data['news'] = false;	
			} else {
				$data['news'] = $this->announcement->get_recent_news();
			}
			
			$content['page'] = $this->load->view('welcome',$data,TRUE);
        	$this->load->view('dashboard',$content);
			/*
            if ($this->session->userdata('role') == 4) {
            	redirect('sms');
            } else if ($this->session->userdata('role') == 6) {
            	redirect('mahasiswa');
            } else if ($this->session->userdata('role') == 5){
				redirect('tutor');
			}*/			
		} else {
		    redirect('login');  
		}
        
	}
	
	public function login()
    {
        $this->load->view('login');
    }
	
	
    public function check_login() {
        return $this->auth->login_process($_POST);        
    }
    
	public function logout() {
		$this->session->sess_destroy();
		redirect(base_url()."login");
	}
    private function _validate_login()
	{
	   $this->form_validation->set_rules('username','lang:study_id','trim|required|numeric');
       $this->form_validation->set_rules('password','lang:date_of_baseline_ct','trim|required');
        
       $delimiter_prefix = "<ul class='message error grid_12'><li>";
       $delimiter_suffix = "</li><li class='close-bt'></li></ul>";
        
	   $this->form_validation->set_error_delimiters($delimiter_prefix,$delimiter_suffix);
	}
	
	public function permission_error() {
		$this->load->view('permission_error');
	}	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */