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
	
	function get_mahasiswa_by_nim($nim,$output="json"){
		$res = $this->person->get_mahasiswa_by_id($nim);
		if($res){
			switch ($output){
				case "json":
						echo json_encode($res);
						break;
				case "html":
						$region_arr = array();
						$region_arr['K'] = 'KBRI Seoul';
						$region_arr['A'] = 'Ansan';
						$region_arr['G'] = 'Guro';
						$region_arr['U'] = 'Ujiongbu';
						$region_arr['D'] = 'Daegu';
						$region_arr['C'] = 'Cheonan';
						$region_arr['J'] = 'Gwangju';
						$region_arr['B'] = 'Busan';
						
						$this->load->view('mahasiswa/person_table_view',array('data'=>$res,'region_arr'=>$region_arr));
						break;
			}
			
		}
	}
	
	function get_mahasiswa_baru_by_reg_code($reg_code,$output="json"){
		$res = $this->person->get_mahasiswa_baru_by_reg_code($reg_code);
		if($res){
			switch ($output){
				case "json":
						echo json_encode($res);
						break;
				case "html":
						$region_arr = array();
						$region_arr['K'] = 'KBRI Seoul';
						$region_arr['A'] = 'Ansan';
						$region_arr['G'] = 'Guro';
						$region_arr['U'] = 'Ujiongbu';
						$region_arr['D'] = 'Daegu';
						$region_arr['C'] = 'Cheonan';
						$region_arr['J'] = 'Gwangju';
						$region_arr['B'] = 'Busan';
						
						$this->load->view('mahasiswa/person_table_view',array('data'=>$res,'region_arr'=>$region_arr));
						break;
			}
			
		}
	}
	
	function getlistJQGRID($type='lama')
	{
		$page = $this->input->post("page", TRUE );
		if(!$page)$page=1;
		
		$rows = $this->input->post("rows", TRUE );
		if(!$rows)$rows=20;
		
		$sort_by = $this->input->post( "sidx", TRUE );
		if(!$sort_by)$sort_by='name';
		
		$sort_direction = $this->input->post( "sord", TRUE );
		if(!$sort_direction)$sort_direction='DESC';
		
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
		if($type=='lama'){
			$data->records = count ($this->person->get_list_JQGRID('mahasiswa',$req_param,"all")->result_array());		
			$records = $this->person->get_list_JQGRID('mahasiswa',$req_param,"current")->result_array();
		}else{
			$data->records = count ($this->person->get_list_JQGRID('baru',$req_param,"all")->result_array());		
			$records = $this->person->get_list_JQGRID('baru',$req_param,"current")->result_array();
		}
		
		
		$data->total = ceil($data->records /$rows );
		$data->rows = $records;

		echo json_encode ($data );
		exit( 0 );
	}
	
	function verify_mahasiswa_baru()
	{
		$this->form_validation->set_rules('reg_code','reg_code','trim|required');
		if($this->form_validation->run())
		{
			// update tabel reregistration
			$this->person->edit_mahasiswa_baru($this->input->post('reg_code'),array('verified'=>1,'verified_by'=>$this->session->userdata('username'),'verified_time'=>date("Y-m-d H:i:s")));
			echo "";
		}else{
			echo validation_errors();
		}
	}
	
}