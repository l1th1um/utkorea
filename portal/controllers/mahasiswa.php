<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mahasiswa extends CI_Controller {	

	public function __construct()
    {
        parent::__construct();								
    	//$this->output->enable_profiler(TRUE);
        $this->load->model('person_model','person');
    }	
	
	public function index()
	{
		$this->auth->check_auth();	
		   
	}	
	
	
	
	function daftar_ulang() {
		$this->auth->check_auth();		
		$data = array();
		$data['empty_val'] = $this->person->check_null_field($this->session->userdata('username'));	
		
		if(!$this->input->post('formhdn')){
			$val_rule = array(
				'passport'=>'trim|required|min_length[5]',
				'place_of_birth'=>'trim|required|min_length[3]',
				'address_id'=>'trim|required|min_length[10]',
				'address_kr'=>'trim|required|min_length[10]',			
				'mother_name'=>'trim|required',
				'ijasah_image'=>'trim|required',
				'passport_image'=>'trim|required',
				'photo_image'=>'trim|required',
				'last_education_major'=>'trim|required',
				'marital_status'=>'trim|required',
				'employment'=>'trim|required',
				'last_education'=>'trim|required',
				'year_graduate'=>'trim|required',
				'birth_date'=>'trim|required',
				'religion'=>'trim|required'				
			);
			
			foreach($data['empty_val'] as $row) {
				$this->form_validation->set_rules($row,$this->lang->line($row),$val_rule[$row]);
			}
			
			$delimiter_prefix = "<div class='error'>";
			$delimiter_suffix = "</div>";
			$this->form_validation->set_error_delimiters($delimiter_prefix,$delimiter_suffix);
		}else{
			$this->form_validation->set_rules('payment_date',$this->lang->line('payment_date'),'trim|required');
			$this->form_validation->set_rules('bank_name',$this->lang->line('bank_name'),'trim|required');
			$this->form_validation->set_rules('account_no',$this->lang->line('account_no'),'trim|required|number');
			$this->form_validation->set_rules('sender_name',$this->lang->line('sender_name'),'trim|required');
		}
		
		if ($this->form_validation->run()){
			if(!$this->input->post('formhdn')){
				$col = array();
				foreach($data['empty_val'] as $row) {
					$col[$row] = $this->input->post($row);
				}					
				
				$this->person->update_mahasiswa($this->session->userdata('username'),$col);
				$data['empty_val'] = '';
			}else{
				$this->load->model('finance_model','finance');
				$datapembayaran = $this->input->post();
				$datapembayaran['nim'] = $this->session->userdata('username');
				unset($datapembayaran['formhdn']);
				
				$conf_number = $this->finance->insert_konfirmasi_pembayaran($datapembayaran);
				
				$msg = 'Konfirmasi pembayaran telah disimpan disistem. Nomor konfirmasi pembayaran anda adalah : <strong>'.$conf_number.'</strong><br />Untuk pertanyaan silahkan kirimkan email melalui <i>humas@utkorea.org</i>';
				
				$this->message->post_to_member($this->session->userdata('username'),'system',$msg);
				redirect('main');
			}
		}else{
			//validation false
		}
		
		$content['page'] = $this->load->view('mahasiswa/daftar_ulang',$data,TRUE);
        $this->load->view('dashboard',$content);		
	}	
	
	function edu_list()
	{
		$this->load->helper('data_helper');
		$data['list'] = edu_list();
		$this->load->view('pendaftaran/edu_list',$data);
	}
	
}