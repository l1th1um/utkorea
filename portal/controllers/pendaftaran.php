<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pendaftaran extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		//$this->output->enable_profiler(TRUE);	
		$this->load->model('person_model','person');
		$this->load->model('finance_model','finance');

        //$config['charset'] = 'iso-8859-1';
        //$config['mailtype'] = 'html';
       	
        $this->load->library('email');
		$this->email->set_newline("\r\n");
	}
	
	public function index()	
	{
		//$content['page'] = $this->load->view('humas/sms','',TRUE);
        $this->load->view('pendaftaran/front');
	}
	
	public function registrasi()
	{
		if (isset($_POST['submitRegBtn'])) {
			$this->_validate_registration();
			
			if ($this->form_validation->run() == FALSE) {
				$data['message'] = validation_errors();
				$content['page'] = $this->load->view('pendaftaran/form',$data,TRUE);
			} else {
				
				if ( ($reg_code = $this->registration_process($_POST)) == FALSE) {
					$data['message'] = $this->lang->line('db_error');
					$content['page'] = $this->load->view('pendaftaran/form',$data,TRUE);
				} else {
					$this->generate_registration_pdf($reg_code['id']);
					
					$this->mail_new_registrant($reg_code['name'], $reg_code['email'],$reg_code['id']);					
					
					$data['message'] = $reg_code;
					
					$content['page'] = $this->load->view('pendaftaran/success',$data,TRUE);
				}

				
			}
			
		} else {
			$content['page'] = $this->load->view('pendaftaran/form','',TRUE);
		}		
		
		$this->load->view('pendaftaran/registrasi',$content);
	}
	
	public function do_upload($field_name)
	{
		$config['upload_path'] = 'assets/uploads/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = '10000';
		$config['max_width'] = '10240';
		$config['max_height'] = '76800';
		$config['encrypt_name'] = TRUE;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload($field_name))
		{
			echo $this->upload->display_errors('<p>', '</p>');
		}
		else
		{
			$data = $this->upload->data();
			$name = $data['file_name'];
			
			$config['new_image'] = $config['upload_path'];
            $config['image_library'] = 'gd2';
            $config['source_image'] = $config['upload_path'] . $name;
            //$config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 800;
			$config['height'] = 600;
            
			/*$this->load->library('image_lib', $config);

            $this->image_lib->resize();*/
			$this->image_lib->initialize($config);                           
            $this->image_lib->resize();
			
			$config['create_thumb'] = TRUE;
            $config['width'] = 100;
            $config['height'] = 100;
            $config['maintain_ratio'] = TRUE;
            $config['thumb_marker'] = '_thumb';
                
            $this->image_lib->initialize($config); 
                
            $this->image_lib->resize(); 

            $thumb_file = $data['raw_name']."_thumb".$data['file_ext'];
			$info = new stdClass();
            
            $info->name = $name;
            $info->size = $data['file_size'];
            $info->type = $data['file_type'];
			$info->url = $config['upload_path'] . "assets/uploads" . $name;
            $info->thumbnail_url = base_url().$config['upload_path'] . $thumb_file; 
            $info->delete_url = $config['upload_path'] . $name;
			
            $info->delete_type = 'DELETE';
			
			 if (IS_AJAX) { 
                echo json_encode(array($info));
            } else {
                $file_data['upload_data'] = $this->upload->data();
                echo json_encode(array($info));
            }
		}
	}
	
	public function registration_process($data) {
		return $this->person->registration_process($data);
	}
	
	public function _validate_registration()
	{
		$this->form_validation->set_rules('name','Nama','trim|required|min_length[4]');
		$this->form_validation->set_rules('passport','Passport','trim|required|min_length[5]');
		$this->form_validation->set_rules('place_of_birth','Tempat Lahir','trim|required|min_length[3]');
		$this->form_validation->set_rules('address_id','Alamat di Indonesia','trim|required|min_length[10]');
		$this->form_validation->set_rules('address_kr','Alamat di Korea','trim|required|min_length[10]');
		$this->form_validation->set_rules('phone','No Telepon','trim|required|min_length[8]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|callback__check_email');
		$this->form_validation->set_rules('last_education_major','Kode Jurusan','trim|required');
		$this->form_validation->set_rules('mother_name','Kode Jurusan','trim|required');
		$this->form_validation->set_rules('ijasah_image','Scan Ijasah','trim|required');
		$this->form_validation->set_rules('photo_image','Foto','trim|required');
	
		$delimiter_prefix = "<div class='error'>";
		$delimiter_suffix = "</div>";
	
		$this->form_validation->set_error_delimiters($delimiter_prefix,$delimiter_suffix);
	}
	
	public function edu_list($page = 1)
	{
		$this->load->helper('data_helper');
		$data['list'] = edu_list();
		$this->load->view('pendaftaran/edu_list',$data);
	}

	public function mail_new_registrant($name,$email,$reg_id) {
	    $from_name = $this->config->item('mail_from_name');
        $from_email = $this->config->item('mail_from');
	    $subject = "Registrasi Mahasiswa Baru Universitas Terbuka";
        $message = $this->lang->line('new_student_email_content');
		$message = sprintf($message,$name);
        $filename = $this->config->item('absolute_path')."assets/core/pdf/registrasi_".$reg_id.".pdf";
        
        native_mail($email,$from_name,$from_email,$subject,$message,$filename);
		        
		//to kemahasiswaan (rengganis)        
		$message2 = "Kepada Tim Kemahasiswaan, <br /><br />
		Pendaftaran Mahasiswa Baru Nomor Registrasi : ".$reg_id."<br /><br />
				
		Silahkan cek dokumen pendaftaran yang terlampir bersama email ini.
		
		Terima Kasih,
		Portal Akademik UT Korea Selatan";		
        
        native_mail('kemahasiswaan@utkorea.org',$from_name,$from_email,
                    $subject,$message2,$filename);
	}
	
	function show_and_replace_pdf($id){
		$this->generate_registration_pdf($id);
		$this->show_pdf($id,true);
	}
	
	function show_pdf($uuid,$isusingregcode = false) {
		
		if(!$isusingregcode){
			$id = uuid_to_id($uuid, 'reg_code');
		}else{
			$id = $uuid;
		}		
		$file = $this->config->item('absolute_path')."assets/core/pdf/registrasi_".$id.".pdf";
		$filename = 'form_registrasi.pdf';
		
		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename="' . $filename . '"');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . filesize($file));
		header('Accept-Ranges: bytes');
		
		@readfile($file);
	}
	
	function generate_registration_pdf($id) 	{
	    $this->load->helper(array('dompdf', 'file'));
		
		//$id = uuid_to_id($uuid, 'reg_code');
		
		$path = $this->config->item('absolute_path')."assets/core/pdf/registrasi_".$id;
		$data = array();
		$data['id'] = $id;
		$data['row'] = $this->person->get_new_student_details($id);
		
		
	     
		if ($data['row'] != FALSE) {
			
			$html = $this->load->view('pendaftaran/form_pdf', $data, true);
			
			$data = pdf_create($html, $path.".pdf", false);		
			
			if(read_file($path)){
				delete_files($path);
			}	
			write_file($path.".pdf", $data);			
		 //	pdf_create($html, $path);
		}
     
	}
	
	function check_registration_status() {
		$reg_code = substr($this->input->post('reg_code'),5,4);
		$payment_status = $this->finance->check_payment_status($reg_code,'reregistration',get_settings('time_period'));
		$reg_status = $this->person->check_registration_status($reg_code);
		
		if ($payment_status == 1) {
			$payment_status = "Sedang Menunggu Verifikasi dari Bendahara";
		} else if ($payment_status == 2) {
			$payment_status = "Anda Telah Melakukan Pembayaran";
		} else {
			$payment_status = "Anda Belum Melakukan Pembayaran";
		}
		
		
		if (!($reg_status)) {
			return false;
		} else {
			echo  $reg_status."<br />".$payment_status;	
		}
		
	}

	public function pembayaran() {
		$data = array();
		$data['show_form'] = true;
		
		if (isset($_POST['sender_name'])) {		
			
			$this->_validate_pembayaran();
			
			if ($this->form_validation->run() == FALSE) {
				$data['message'] = validation_errors();				
			} else {				
				$insert_data = populate_form($this->input->post(), 'reregistration');
				$insert_data['nim'] = substr($this->input->post('nim'),5,4);
				$insert_data['payment_date'] = convertToMysqlDate($this->input->post('payment_date'));
				$insert_data['period'] = get_settings('time_period');
				
				if ($this->finance->insert_konfirmasi_pembayaran($insert_data) == FALSE) {
					$data['message'] = $this->lang->line('db_error');
				} else {
					$data['message'] = "<h2>".$this->lang->line('payment_success')."</h2>";
					$data['show_form'] = false;
				}				
			}			
		}
		
		$content['page'] = $this->load->view('pendaftaran/pembayaran',$data,TRUE);
		$this->load->view('pendaftaran/registrasi',$content);
	}
	
	public function _validate_pembayaran() {
		$this->form_validation->set_rules('nim',$this->lang->line('nim'),'trim|required');
		$this->form_validation->set_rules('payment_date',$this->lang->line('payment_date'),'trim|required');
		$this->form_validation->set_rules('bank_name',$this->lang->line('bank_name'),'trim|required');
		$this->form_validation->set_rules('account_no',$this->lang->line('account_no'),'trim|required|number');
		$this->form_validation->set_rules('sender_name',$this->lang->line('sender_name'),'trim|required');
		
		$delimiter_prefix = "<div class='error'>";
		$delimiter_suffix = "</div>";
	
		$this->form_validation->set_error_delimiters($delimiter_prefix,$delimiter_suffix);
	}
	
	function check_payment_status() {
		$reg_code = substr($this->input->post('nim'),5,4);
		echo  $this->finance->check_payment_status($reg_code,'reregistration',get_settings('time_period'));
	}
	
	public function prosedur() {		
		$content['page'] = $this->load->view('pendaftaran/prosedur','',TRUE);
		$this->load->view('pendaftaran/registrasi',$content);
	}
	
	public function mail_all_students() {
		$this->load->library('email');    
	    $this->email->set_newline("\r\n");
		
		$this->email->from($this->config->item('mail_from'), $this->config->item('mail_from_name'));
		
		$this->email->subject('Portal Akademik Universitas Terbuka Korea Selatan');
		$list = $this->person->get_list_mahasiswa();
		$i = 0;
		foreach ($list as $row) {
			$name = $row->name;
			$username = $row->nim;
			$password = $row->nim;
			$email = $row->email;
			
			$message = $this->lang->line('mail_portal_info');			
			$message = sprintf($message,$name,$username,$password);
			
			$this->email->to($email);
			
			$this->email->message($message);
			
			if($this->email->send() == FALSE) {
				echo $nim." - ".$name." - ".$email."<br />";	
			}
			
			$i++;	
		}			
	}

	public function mail_all_tutor() {
	    $this->load->library('email');    
	    $this->email->set_newline("\r\n");
		
		$this->email->from($this->config->item('mail_from'), $this->config->item('mail_from_name'));
		
		$this->email->subject('Account Portal Akademik Universitas Terbuka Korea Selatan');
		//$list = $this->person->get_list_mahasiswa();
		$this->load->model('tutor_model');
		$list = $this->tutor_model->get_active_tutor();
		
		$i = 0;
		
		foreach ($list->result() as $row) {
			$name = $row->name;
			$username = $row->username;
			$password = $row->username;
			$email = $row->email;
			
			$message = $this->lang->line('mail_portal_info_tutor');			
			$message = sprintf($message,$name,$username,$password);
			
			$this->email->to($email);
			
			$this->email->message($message);
			
			if($this->email->send() == FALSE) {
				echo $nim." - ".$name." - ".$email."<br />";	
			}
			
			$i++;	
		}			
	}

	public function _check_email($email){
		
		if($this->person->check_email($email)){
			$this->form_validation->set_message('_check_email', 'Email sudah digunakan, harap gunakan email lain');
			return false;
		}else{
			return true;
		}
	}
}