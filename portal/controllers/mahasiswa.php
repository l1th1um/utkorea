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
		
		
		$bucket = $this->utility_model->get_Table('major');
		 
		 $major_arr = array();
		 foreach($bucket->result_array() as $row){
			$major_arr[] = $row;
		 }
		 $region_arr = array();
		 $region_arr['K'] = 'KBRI Seoul';
		 $region_arr['A'] = 'Ansan';
		 $region_arr['G'] = 'Guro';
		 $region_arr['U'] = 'Ujiongbu';
		 $region_arr['D'] = 'Daegu';
		 $region_arr['C'] = 'Cheonan';
		 $region_arr['J'] = 'Gwangju';
		 $region_arr['B'] = 'Busan';		 
		 
		
		 $content['page'] = $this->load->view('kemahasiswaan/mahasiswa',array('major_arr'=>$major_arr,'region_arr'=>$region_arr),TRUE);		 
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
		
		$this->jqgrid_export->exportCurrent('mahasiswa',$req_param);
	}
	
	public function CRUD(){
		$response = "";
		if(isset($_POST['oper'])){
			$col = array();
			$this->load->library('form_validation');
			switch($_POST['oper']){
				case 'edit':
					$this->form_validation->set_rules('id', 'NIM', 'required|numeric');
					$this->form_validation->set_rules('name', 'Name', 'required');
					$this->form_validation->set_rules('major', 'Major', 'required|numeric');
					$this->form_validation->set_rules('region', 'Region', 'required');
					$this->form_validation->set_rules('phone', 'Phone', 'required|numeric');
					$this->form_validation->set_rules('status', 'Status', 'required');
					$this->form_validation->set_rules('period', 'Period', 'required|numeric');
					$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
					$this->form_validation->set_rules('birth_date', 'Birth', 'xss_clean');
					$this->form_validation->set_rules('religion', 'Religion', 'xss_clean');
					$this->form_validation->set_rules('address_id', 'Address', 'required|xss_clean');
					$this->form_validation->set_rules('gender', 'gender', 'required');
					$this->form_validation->set_rules('marital_status', 'Marital Status', 'required');	
					$col = $this->input->post();
					break;
				case 'add':
					$this->form_validation->set_rules('nim', 'NIM', 'required|numeric|callback__check_nim');
					$this->form_validation->set_rules('name', 'Name', 'required');
					$this->form_validation->set_rules('major', 'Major', 'required|numeric');
					$this->form_validation->set_rules('region', 'Region', 'required');
					$this->form_validation->set_rules('phone', 'Phone', 'required|numeric');
					$this->form_validation->set_rules('status', 'Status', 'required');
					$this->form_validation->set_rules('period', 'Period', 'required|numeric');
					$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
					$this->form_validation->set_rules('birth_date', 'Birth', 'xss_clean');
					$this->form_validation->set_rules('religion', 'Religion', 'xss_clean');
					$this->form_validation->set_rules('address_id', 'Address', 'required|xss_clean');
					$this->form_validation->set_rules('gender', 'gender', 'required');
					$this->form_validation->set_rules('marital_status', 'Marital Status', 'required');					
					$col = $this->input->post();
					break;
				case 'del':
					$this->form_validation->set_rules('id', 'NIM', 'required|numeric');	
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
							$this->person->update_mahasiswa($id,$col);
							break;
						case 'add':
							unset($col['oper']);
							unset($col['id']);							
							$this->person->add_mahasiswa($col);
							break;
						case 'del':
							$this->person->delete_mahasiswa($col['id']);
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
	
	function _check_nim($nim)
	{
		if($this->person->check_nim($nim)){
			$this->form_validation->set_message('_check_nim', 'Nomor NIM sudah digunakan');
			return false;
		}else{
			return true;
		}
	}

}