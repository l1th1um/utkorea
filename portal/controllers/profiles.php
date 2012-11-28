<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class profiles extends CI_Controller {

	public function __construct()
    {
        parent::__construct();								
    	//$this->output->enable_profiler(TRUE);
        $this->load->model('person_model','person');
    }	
	
	public function index()
	{
		$this->auth->check_auth();
		
		$this->form_validation->set_rules('address',$this->lang->line('address'),'trim|required|min_length[10]');
		$this->form_validation->set_rules('name',$this->lang->line('name'),'trim|required');
		$this->form_validation->set_rules('phone',$this->lang->line('phone'),'required|numeric');
		$this->form_validation->set_rules('email',$this->lang->line('email'),'trim|required|valid_email');	
		if(!is_numeric($this->session->userdata('username'))){
			$this->form_validation->set_rules('bank','Nama Bank','trim|required');
			$this->form_validation->set_rules('account','Nomor Account','required|xss_clean|trim');
			$this->form_validation->set_rules('affiliation','Afiliasi','trim|required|xss_clean');	
		}
		
		$delimiter_prefix = "<div class='error'>";
		$delimiter_suffix = "</div>";
		$this->form_validation->set_error_delimiters($delimiter_prefix,$delimiter_suffix);
		$success = false;
		
		if($this->form_validation->run())
		{
			if(!is_numeric($this->session->userdata('username'))){
					$col = array(
						'name' => $this->input->post('name'),
						'address' => $this->input->post('address'),
						'phone' => $this->input->post('phone'),
						'email' => $this->input->post('email'),
						'photo' => $this->input->post('photo'),	
						'account' => $this->input->post('account'),
						'bank' => $this->input->post('bank'),
						'affiliation' => $this->input->post('affiliation')
					);
					$this->person->update_tutor($this->session->userdata('username'),$col);
					
			}else{
					$col = array(
						'name' => $this->input->post('name'),
						'address_kr' => $this->input->post('address'),
						'phone' => $this->input->post('phone'),
						'email' => $this->input->post('email'),
						'photo_image' => $this->input->post('photo')
					);
					$this->person->update_mahasiswa($this->session->userdata('username'),$col);
			}		
			$success = true;
		}
		
		if(!is_numeric($this->session->userdata('username'))){
			$data = $this->person->get_staff_by_username($this->session->userdata('username'));
			$col = array(
				'photo'=>$data['photo'],
				'name'=>$data['name'],
				'email'=>$data['email'],
				'address'=>$data['address'],
				'phone'=>$data['phone'],
				'bank'=>$data['bank'],
				'account'=>$data['account'],
				'affiliation'=>$data['affiliation']
			);
		}else{
			$data = $this->person->get_mahasiswa_by_id($this->session->userdata('username'));
			$col = array(
				'photo'=>$data['photo_image'],
				'name'=>$data['name'],
				'email'=>$data['email'],
				'address'=>$data['address_kr'],
				'phone'=>$data['phone']
			);
		}	
		
		$content['page'] = $this->load->view('profiles/personal',array('data'=>$col,'success'=>$success),TRUE);
        $this->load->view('dashboard',$content);       
	}
	
	public function change_password()
	{
		$this->auth->check_auth();
		$data = array();
		
		if (isset($_POST['password'])) {
			$this->_validate_change_password();
				
			if ($this->form_validation->run() == FALSE) {
				$data['message'] = validation_errors();				
			} else {
				if ($this->session->userdata('role') <= 7) {
					$table = 'staff';
				} else {
					$table = 'mahasiswa';
				}
				
				if ($this->person->change_password($table,$this->input->post('new_password'))) {
					$data['message'] = success_form($this->lang->line('change_password_success'));
				} else {
					$data['message'] = error_form($this->lang->line('db_error'));						
				}
			}
		}
		
		$content['page'] = $this->load->view('profiles/change_password',$data,TRUE);
        $this->load->view('dashboard',$content);
	}
	
	public function _validate_change_password()
	{
		$this->form_validation->set_rules('password',$this->lang->line('old_password'),'trim|required|htmlspecialchars|callback_password_check');
		$this->form_validation->set_rules('new_password',$this->lang->line('new_password'),'trim|required|min_length[6]|htmlspecialchars|');
		$this->form_validation->set_rules('new_password2',$this->lang->line('new_password_verify'),'trim|required|matches[new_password]|htmlspecialchars|');
		
	
		$delimiter_prefix = '<div class="notification error">
				<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
				<p><strong>';
		$delimiter_suffix = '</strong></p></div>';
	
		$this->form_validation->set_error_delimiters($delimiter_prefix,$delimiter_suffix);
	}
	
	function password_check($password) {
		if ($this->session->userdata('role') <= 7) {
			$table = 'staff';
		} else {
			$table = 'mahasiswa';
		}
		
		if ($this->person->password_check($table,$password)) {
			return TRUE;
		} else
		{
			$this->form_validation->set_message("password_check", $this->lang->line('old_password')." Salah");
			return FALSE;
		}	
	}
	
	

}