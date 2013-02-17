<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
    }
    
    public function index()
	{
			
		if ($this->config->item('live_site') == 1) {
			if ( (base_url() == 'http://www.utkorea.org/portal/') || (base_url() == 'http://utkorea.org/portal/') ) {
				redirect('http://portal.utkorea.org');
			} 
		}
		
		
		if ($this->session->userdata('logged_in') == TRUE) {
			$this->load->model('announcement_model','announcement');
			
			$data = array();
			
			$data['message'] = $this->message->get_unread_message($this->session->userdata('username'),true);
            
			if ($this->announcement->get_recent_news() == false) {
				$data['news'] = false;	
			} else {
				$content['list'] = $this->announcement->get_recent_news();
				$data['news'] = $this->load->view('announcement/list',$content,TRUE);
			}
			
			$content['page'] = $this->load->view('welcome',$data,TRUE);
        	$this->load->view('dashboard',$content);
					
		} else {
		    redirect('login','refresh');  
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
	
    public function attach($uid)
    {
        $this->load->model('class_model');
        $this->load->helper('file');
        
        $data = $this->class_model->get_attachment($uid);
        
        if ($data <> false)
        {
            $file = $data->filename;        
            $mime = get_mime_by_extension($file);
            
            $absolute_path = $this->config->item('absolute_path')."assets/uploads/".$data->subfolder."/";
            
            header('Content-type: '.$mime);
            header('Content-Disposition: attachment; filename="'.$data->original_file.'"');
            readfile($absolute_path.$file);    
        }
        else
        {
            echo $uid;
        }
        
    }
}