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
		}else{
			$this->form_validation->set_rules('birth_date','Tanggal Lahir','trim|required');
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
						'photo_image' => $this->input->post('photo'),
						'birth_date' => $this->input->post('birth_date')
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
				'phone'=>$data['phone'],
				'birth_date' => $data['birth_date']
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
				$role = $this->session->userdata('role');
                
		        if ($role[0] <= 8) {
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
	    $role = $this->session->userdata('role');
		if ($role[0] <= 8) {
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
	
	function inbox($message = ''){
		$this->auth->check_auth();
		$data = array('message'=>$message);
		$content['page'] = $this->load->view('profiles/inbox',$data,TRUE);
        $this->load->view('dashboard',$content);
	}
	
	public function getinboxJQGRID($username)
	{
		$page = $this->input->post("page", TRUE );
		if(!$page)$page=1;
		
		$rows = $this->input->post("rows", TRUE );
		if(!$rows)$rows=20;
		
		$sort_by = $this->input->post( "sidx", TRUE );
		if(!$sort_by)$sort_by='id';
		
		$sort_direction = $this->input->post( "sord", TRUE );
		if(!$sort_direction)$sort_direction='ASC';
		
		$req_param = array (
            "sort_by" => $sort_by,
			"sort_direction" => $sort_direction,
			"page" => $page,
			"rows" => $rows,
			"search" => $this->input->post( "_search", TRUE ),
			"search_field" => $this->input->post( "searchField", TRUE ),
			"search_operator" => $this->input->post( "searchOper", TRUE ),
			"search_str" => $this->input->post( "searchString", TRUE )
		);

		$data->page = $page;
		$data->records = count ($this->message_model->get_user_inboxJQGRID($req_param,"all",$username)->result_array());		
		$records = $this->message_model->get_user_inboxJQGRID($req_param,"current",$username)->result_array();

		$data->total = ceil($data->records /$rows );
		$data->rows = $records;

		echo json_encode ($data );
		exit( 0 );
	}
	
	function delete_msg(){
		$this->form_validation->set_rules('msgid','ID','required');
		if($this->form_validation->run())
		{
			$this->message->delete_message($this->input->post('msgid'));	
		}
	}
	
	function read_message($id){
		$this->form_validation->set_rules('message','Pesan','required|xss_clean');
		$this->form_validation->set_rules('to','Kepada','required');
		if($this->form_validation->run()){
			$this->message->post_to_member($this->input->post('to'),$this->session->userdata('username'),$this->input->post('message'));
			$this->inbox('Pesan anda berhasil dikirim');
			
		}else{
			$data = $this->message->validate_and_get($id);
			if($data){
				if(!$data->is_read)
					$this->message->set_read($id);			
				$content['page'] = $this->load->view('profiles/read_message',$data,TRUE);
		        $this->load->view('dashboard',$content);
			}else{
				echo 'Anda tidak dapat membaca pesan ini';
			}
		}
		
		
	}
	
	function write_new(){
		$this->form_validation->set_rules('message','Pesan','required|xss_clean');
		$this->form_validation->set_rules('to','Kepada','required');
		if($this->form_validation->run()){
			$to_arr = explode(",",$this->input->post('to'));
			foreach($to_arr as $row){
				$this->message->post_to_member($row,$this->session->userdata('username'),$this->input->post('message'));
			}			
			$this->inbox('Pesan anda berhasil dikirim');
			
		}else{
			$data = array();
			$content['page'] = $this->load->view('profiles/write_new',$data,TRUE);
	   		 $this->load->view('dashboard',$content);
		}
		
	}

	function reset_pwd($nim,$table='mahasiswa'){
		$this->person->change_password($table,$nim,$nim);
	}

}