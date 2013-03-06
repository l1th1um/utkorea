<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tutor extends CI_Controller {

	public function __construct()
    {
        parent::__construct();								
		//$this->output->enable_profiler(TRUE);
        $this->load->model('person_model','person');
		$this->load->model('tutor_model');
    }	
	
	public function index()
	{
		$this->auth->check_auth();
		
        $bucket = $this->utility_model->get_Table('major');
		 
		$major_arr = array();
		foreach($bucket->result_array() as $row){
		  $major_arr[] = $row;
		}
		
        $region_arr = array();
		$region_arr['Utara'] = 'Utara';
		$region_arr['Selatan'] = 'Selatan';
		
		$content['page'] = $this->load->view('tutor/tutor',array('major_arr'=>$major_arr,'region_arr'=>$region_arr),TRUE);		 
        $this->load->view('dashboard',$content);       
	}
	
	public function exportCurrentCRUD(){
		$page = $this->input->get("page", TRUE );
		if(!$page)$page=1;
		
		$rows = $this->input->get("rows", TRUE );
		if(!$rows)$rows=10;
		
		$sort_by = $this->input->get( "sidx", TRUE );
		if(!$sort_by)$sort_by='name';
		
		$sort_direction = $this->input->get( "sord", TRUE );
		if(!$sort_direction)$sort_direction='ASC';
		
		$req_param = array (
            "sort_by" => $sort_by,
			"sort_direction" => $sort_direction,
			"page" => $page,
			"rows" => $rows,
			"search" => $this->input->get( "_search", TRUE ),
			"search_field" => $this->input->get( "searchField", TRUE ),
			"search_operator" => $this->input->get( "searchOper", TRUE ),
			"search_str" => $this->input->get( "searchString", TRUE )
		);
		
		$this->jqgrid_export->exportCurrent('tutor',$req_param);
	}
	
	public function CRUD(){
		$response = "";
		if(isset($_POST['oper'])){
			$col = array();
			$this->load->library('form_validation');
			
			switch($_POST['oper']){				
				case 'edit':
					$this->form_validation->set_rules('id', 'Staff ID', 'required|numeric');
					$this->form_validation->set_rules('name', 'Name', 'required');
					$this->form_validation->set_rules('major_id', 'Major', 'required|numeric');
					$this->form_validation->set_rules('region', 'Region', 'required');
					$this->form_validation->set_rules('phone', 'Phone', 'required|numeric|trim|xss_clean');					
					$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
					$this->form_validation->set_rules('birth', 'Birth', 'xss_clean');
					$this->form_validation->set_rules('affiliation', 'affiliation', 'xss_clean');					
					$col = $this->input->post();
					break;
				case 'add':
					$this->form_validation->set_rules('name', 'Name', 'required');
					$this->form_validation->set_rules('major_id', 'Major', 'required|numeric');
					$this->form_validation->set_rules('region', 'Region', 'required');
					$this->form_validation->set_rules('phone', 'Phone', 'required|numeric|trim|xss_clean');					
					$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
					$this->form_validation->set_rules('birth', 'Birth', 'xss_clean');
					$this->form_validation->set_rules('affiliation', 'affiliation', 'xss_clean');		
					$col = $this->input->post();
					break;
				case 'del':
					$this->form_validation->set_rules('id', 'Staff ID', 'required|numeric');	
					$col = $this->input->post();
					break;
				default:
					exit;
			}
			if ($this->form_validation->run())
			{
					switch($col['oper']){
						case 'edit':
							unset($col['oper']);
							$id = $col['id'];
							unset($col['id']);
							$this->person->update_tutor($id,$col);
							break;
						case 'add':
							unset($col['oper']);
							unset($col['id']);							
							$this->person->add_tutor($col);
							break;
						case 'del':
							$this->person->delete_tutor($col['id']);
							break;
						default:
							exit;
					}
			}else{
					$response = validation_errors();
			}
		}				
		
		echo $response;		
	}	

	public function assignment() {
		$this->auth->check_auth();
		$data = array();
		
		$major = array(0 => "-- Pilih Jurusan --");
		$data['major'] = $major + major_list();		
		
		$region = array(0 => "-- Pilih Lokasi --","Utara","Selatan");
		$data['region'] = $region;
		
		$content['page'] = $this->load->view('tutor/assignment',$data,TRUE);
        $this->load->view('dashboard',$content);		
	}
	
	public function assignment_major($id,$region) {
		//$this->auth->check_auth();
		$data = array();
		$i = 1;
			
		$courses = array();
		
		foreach ($this->tutor_model->course_list($id,$region) as $row) {
			if ($row->semester <> $i) {
				$i = $row->semester;				
			}
			
			$courses[$i][] = $row;
		}				
		$tutor = array(0 => "-- Pilih Tutor --");
		$data['tutor'] = $tutor + $this->tutor_model->tutor_by_major($id);
		$data['course'] = $courses;
		$data['region'] = $region;
		$this->load->view('tutor/assignment_major',$data);
	}
	
	public function save_assignment() {
		$region = $this->input->post('region');
		
		$i = 0;
		$data = explode('&',$this->input->post('frmdata'));
		foreach ($data as $key => $val) {
			$val = explode('=',$val);
			if (! empty($val[1])) {
				$course_id = str_replace('tutor', '', $val[0]);
				
				$insert = $this->tutor_model->save_assignment($val[1], $course_id,$region);
				
				if ($insert) {
					$i++;	
				}
			}	
		}
		
		echo ($i > 0)? '1' : '0';
	}
    
    public function transport(){
		 $this->auth->check_auth();
		 
		 $this->load->library('form_validation');
		 $this->form_validation->set_rules('tanggalttm', 'Tanggal TTM', 'required');
		 $this->form_validation->set_rules('total', 'Total Pengeluaran', 'required|numeric');
		 $this->form_validation->set_rules('deskripsi', 'Deskripsi Perjalanan', 'required');
		 $this->form_validation->set_rules('waktudibayar', 'Waktu Dibayar', 'required');
		 
		 $this->load->model('finance_model');
		 $data['success'] = 0;
		 
		 if($this->form_validation->run()){
		 	$data = array();
		 	$data = $this->input->post();
			unset($data['simprev']);
			$data['staff_id'] = $this->session->userdata('id');
			$this->finance_model->save_transport($data);
			
			$data['success'] = 1;
			$data['error'] = '';
		 }else{
			$data['error'] = validation_errors();
		}
					
		 
		 $data['transport'] = $this->finance_model->get_my_transport($this->session->userdata('id'));
		  
		 $content['page'] = $this->load->view('tutor/transport',$data,TRUE);
		 $this->load->view('dashboard',$content);
	}
	
	function get_tutor($id,$output="json"){
		$res = $this->tutor_model->get_tutor($id);
		if($res){
			switch ($output){
				case "json":
						echo json_encode($res);
						break;
				case "html":												
						$this->load->view('tutor/person_table_view',array('data'=>$res));
						break;
			}
			
		}
	}

	function gabung_kelas(){
		$this->auth->check_auth();	
		$this->load->model('class_model');
		
		$data['asgnmt_list'] = $this->tutor_model->get_assignment(setting_val('time_period'));
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('from_assignment', 'From Assignment', 'required');
		$this->form_validation->set_rules('to_assignment', 'To Assignment', 'required');
		
		if($this->form_validation->run()){
				$col = $this->input->post();
				
				$this->class_model->add_gabung_kelas($col);
								
		}
		
		
		$data['list'] = $this->class_model->get_list_gabung_kelas();
		
		$content['page'] = $this->load->view('tutor/gabung_kelas',$data,TRUE);
		$this->load->view('dashboard',$content);
	}
	
	function verify_transport(){
		$this->form_validation->set_rules('id','id','trim|required');
		if($this->form_validation->run())
		{
			$this->load->model('finance_model','finance');		
			$this->finance->update_transport($this->input->post('id'),array('is_verified'=>2,'verified_by'=>$this->session->userdata('id'),'verified_time'=>date("Y-m-d H:i:s")));
			echo "";
		}else{
			echo validation_errors();
		}
	}
}


