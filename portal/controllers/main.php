<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
    {
        parent::__construct();
        #$this->output->enable_profiler(TRUE);
    }
    
    public function index()
	{
		if ($this->session->userdata('logged_in') == TRUE) {
            /*    
		    $content['page'] = $this->load->view('humas/user_grid','',TRUE);
            $this->load->view('dashboard',$content);*/
            redirect('sms');
		} else {
		    redirect('login');  
		}
        
	}
    
    public function login()
    {
        $this->load->view('login');
    }
    
    function check_login() {
        return $this->auth->login_process($_POST);        
    }
    
	function logout() {
		$this->session->sess_destroy();
		redirect(base_url()."login");
	}
    function _validate_login()
	{
	   $this->form_validation->set_rules('username','lang:study_id','trim|required|numeric');
       $this->form_validation->set_rules('password','lang:date_of_baseline_ct','trim|required');
        
       $delimiter_prefix = "<ul class='message error grid_12'><li>";
       $delimiter_suffix = "</li><li class='close-bt'></li></ul>";
        
	   $this->form_validation->set_error_delimiters($delimiter_prefix,$delimiter_suffix);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */