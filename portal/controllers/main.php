<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
        
        $this->load->library('email');
		$this->email->set_newline("\r\n");
        
        $this->load->model('person_model');
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
        
        $data = $this->class_model->get_attachment_uid($uid);
        
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
    
    public function forgot_password()
    {
        $username = $this->input->post('username');
        
        $state = false;
        
        if (is_numeric($username)) {
	      	  if ($this->person_model->check_nim($username)) 
 	              $state = true;	      	  
	      } else {
	      	  if ($this->person_model->check_username($username))
	      	      $state = true;
	      }
       
       
       if ($state == false)
       {
            echo "0";
       }
       else
       {
            $email = user_detail('email',$username);
            $key = md5($email.microtime().$username);
            $url = base_url()."recover_password/".$key;
            
            if ($this->person_model->check_recover_active($username))
            {                
                $this->person_model->activationKey($username,$key);
                $this->email_recovery_password($email,$url);
                echo "2";
            } 
            else
            {
                echo "1";    
            }
            
            
       }
       
    }
    
    function email_recovery_password($email,$url) {
		$this->email->from($this->config->item('mail_from'), $this->config->item('mail_from_name'));
		$this->email->to("$email");	
		
		$this->email->subject($this->lang->line('activation_key_email_subject'));
		$message = $this->lang->line('activation_key_email_content');
		$message = sprintf($message,$url);
		$this->email->message($message);
		
		$this->email->send();
	}
    
    function recover_password($activation_key) {
		 $row = $this->person_model->recover_information($activation_key);
		
		if ( $row == FALSE) {
			$data['content'] = $this->lang->line('activation_key_not_exist');			
		} else {
			$this->load->helper('date');
			if ($row['active'] == '0') {
				$data['content'] = $this->lang->line('activation_key_already_used')."</h2>";
			} else if ($row['expire'] >=  now() ) {
				$newpass = randomPassword();
                $email = user_detail('email',$row['username']);
                 
				if ( is_numeric($row['username']) ) {
				    $this->person_model->setRandomPass($row['username'],'nim','mahasiswa',$newpass);				
				} else {	
					$this->person_model->setRandomPass($row['username'],'username','staff',$newpass);                    
				}
                
				$this->email_new_pass($email,$newpass);
				$this->person_model->changeStatusRecovery($activation_key);
					
				$data['content'] = $this->lang->line('activation_key_success')."</h2>";				
			} else {	
				$data['content'] = $this->lang->line('activation_key_expire')."</h2>";				
			}	
		}
		$this->load->view('recover_password',$data);
		
	}
    
    function email_new_pass($email,$newpass) {
		$this->email->from($this->config->item('mail_from'), $this->config->item('mail_from_name'));
		$this->email->to("$email");	
		
		$this->email->subject($this->lang->line('new_password_subject'));
		$message = $this->lang->line('new_password_content');
		$message = sprintf($message,$newpass);
		$this->email->message($message);
		
		$this->email->send();
	}
}