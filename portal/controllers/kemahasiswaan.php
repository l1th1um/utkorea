<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class kemahasiswaan extends CI_Controller {

	public function __construct()
    {
        parent::__construct();								
    	//$this->output->enable_profiler(TRUE);
        $this->load->model('person_model','person');
    }	
	
	public function index()
    {
        $this->auth->check_auth();        
        $data = array();
        
        foreach (major_list() as $key => $value)
        {
            $data[$key]['major'] = $value;
            
            $entry_period_arr = $this->person->get_active_semester($key);
            $i = 0;
            foreach ($entry_period_arr as $row) {
                $data[$key]['details'][$i]['entry'] = $row->entry_period;
                $data[$key]['details'][$i]['total_utara'] = $this->person->get_total_student($key,$row->entry_period,'1');
                $data[$key]['details'][$i]['total_selatan'] = $this->person->get_total_student($key,$row->entry_period,'2');
                
                $i++;
            }
        }
        
        $page['data'] = $data;
        $content['page'] = $this->load->view('kemahasiswaan/index',$page,TRUE);
        $this->load->view('dashboard',$content);
    }
    
    public function data($major,$semester,$region)
	{
		$this->auth->check_auth();
		
		
		$bucket = $this->utility_model->get_Table('major');
		 
		 $major_arr = array();
		 foreach($bucket->result_array() as $row){
			$major_arr[] = $row;
		 }
		 $region_arr = array();
		 $region_arr['K'] = 'Seoul';
		 $region_arr['A'] = 'Ansan';
		 $region_arr['G'] = 'Guro';
		 $region_arr['U'] = 'Ujiongbu';
		 $region_arr['D'] = 'Daegu';
		 $region_arr['C'] = 'Cheonan';
		 $region_arr['J'] = 'Gwangju';
		 $region_arr['B'] = 'Busan';
         
         $data = array('major_arr'=>$major_arr,
                       'region_arr'=>$region_arr,
                       'major' => $major,
                       'semester' => $semester,
                       'region' => $region);
         		 
		 
		
		 $content['page'] = $this->load->view('kemahasiswaan/mahasiswa',$data,TRUE);		 
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
					$this->form_validation->set_rules('entry_period', 'Entry Period', 'required|numeric');
					$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
					$this->form_validation->set_rules('birth_date', 'Birth', 'xss_clean');
					$this->form_validation->set_rules('religion', 'Religion', 'xss_clean');
					$this->form_validation->set_rules('address_id', 'Address', 'required|xss_clean');
					$this->form_validation->set_rules('address_kr', 'Address KR', 'required|xss_clean');
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
					$this->form_validation->set_rules('entry_period', 'Entry Period', 'required|numeric');
					$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
					$this->form_validation->set_rules('birth_date', 'Birth', 'xss_clean');
					$this->form_validation->set_rules('religion', 'Religion', 'xss_clean');
					$this->form_validation->set_rules('address_id', 'Address', 'required|xss_clean');
					$this->form_validation->set_rules('address_kr', 'Address KR', 'required|xss_clean');
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
							$col['password'] = hashPassword($col['nim']);
							
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

	public function CRUD_baru(){
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
					$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
					$this->form_validation->set_rules('birth_date', 'Birth', 'xss_clean');
					$this->form_validation->set_rules('religion', 'Religion', 'xss_clean');
					$this->form_validation->set_rules('address_id', 'Address', 'required|xss_clean');
					$this->form_validation->set_rules('address_kr', 'Address KR', 'required|xss_clean');
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
					$this->form_validation->set_rules('entry_period', 'Entry Period', 'required|numeric');
					$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
					$this->form_validation->set_rules('birth_date', 'Birth', 'xss_clean');
					$this->form_validation->set_rules('religion', 'Religion', 'xss_clean');
					$this->form_validation->set_rules('address_id', 'Address', 'required|xss_clean');
					$this->form_validation->set_rules('address_kr', 'Address KR', 'required|xss_clean');
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
							$this->person->edit_mahasiswa_baru($id,$col);
							break;
						case 'add':
							unset($col['oper']);
							unset($col['id']);							
							$col['password'] = hashPassword($col['nim']);
							
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
	
	function mahasiswa_baru(){
		$this->auth->check_auth();
		$data = array();
		$data['list'] = $this->person->new_student_list();	
		
		$bucket = $this->utility_model->get_Table('major');
		 
		 $major_arr = array();
		 foreach($bucket->result_array() as $row){
			$major_arr[] = $row;
		 }
		 $region_arr = array();
		 $region_arr['K'] = 'Seoul';
		 $region_arr['A'] = 'Ansan';
		 $region_arr['G'] = 'Guro';
		 $region_arr['U'] = 'Ujiongbu';
		 $region_arr['D'] = 'Daegu';
		 $region_arr['C'] = 'Cheonan';
		 $region_arr['J'] = 'Gwangju';
		 $region_arr['B'] = 'Busan';
         
         $data = array('major_arr'=>$major_arr,
                       'region_arr'=>$region_arr);
		
		$content['page'] = $this->load->view('kemahasiswaan/mahasiswa_baru',$data,TRUE);
        $this->load->view('dashboard',$content);
	}
	
	function mahasiswa_all() {
		$this->auth->check_auth();
		$data = array();
		//$data['list'] = $this->person->new_student_list();	
		
		$bucket = $this->utility_model->get_Table('major');
		 
		 $major_arr = array();
		 foreach($bucket->result_array() as $row){
			$major_arr[] = $row;
		 }
		 $region_arr = array();
		 $region_arr['K'] = 'Seoul';
		 $region_arr['A'] = 'Ansan';
		 $region_arr['G'] = 'Guro';
		 $region_arr['U'] = 'Ujiongbu';
		 $region_arr['D'] = 'Daegu';
		 $region_arr['C'] = 'Cheonan';
		 $region_arr['J'] = 'Gwangju';
		 $region_arr['B'] = 'Busan';
         
         $data = array('major_arr'=>$major_arr,
                       'region_arr'=>$region_arr);
						
		$content['page'] = $this->load->view('kemahasiswaan/mahasiswa_all',$data,TRUE);
        $this->load->view('dashboard',$content);		
	}
	
	function data_mhs_all() {
		$page = $this->input->post("page", TRUE );
		if(!$page)$page=1;
		
		$rows = $this->input->post("rows", TRUE );
		if(!$rows)$rows=10;
		
		$sort_by = $this->input->post( "sidx", TRUE );
		if(!$sort_by)$sort_by='name';
		
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
		
        $data->records = count ($this->person->get_list_JQGRID('mahasiswa',$req_param,"all")->result_array());		
		$records = $this->person->get_list_JQGRID('mahasiswa',$req_param,"current")->result_array();
		$newrecords = array();
		foreach($records as $row){
		  //$row['entry_period'] = calculate_semester($row['entry_period']);
		  $newrecords[] = $row;
		}
		$records = $newrecords;
		
		
		$data->total = ceil($data->records /$rows );
		$data->rows = $records;

		echo json_encode ($data );
		exit( 0 );
	}
		
	public function export_data() {
		$this->auth->check_auth();
		
		$data = array();
		
		if (isset($_POST['major'])) {
			$export_data = $this->person->export_data();
			$column = count($_POST['row']);
			$this->export_to_excel($export_data,$column);
			$data['message'] =  $export_data;
		}
		
		
		$major = array("Semua");
		
		$distinct_semester = $this->person->distinct_semester();
		
		$period =  array("Semua");
		$data['period'] = $period + $distinct_semester;
				
		$data['major'] = $major + major_list();
		$data['status'] = array('Semua','Aktif','Cuti');
		$data['field'] = $this->person->field_export_data();
							
		$content['page'] = $this->load->view('kemahasiswaan/export_data',$data,TRUE);
        $this->load->view('dashboard',$content);
	}
	
	public function export_to_excel($data,$column) 
	{
		
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		
		$current_period = get_settings('time_period');
		$current_period_year = substr($current_period,0,4);
		$current_period_semester = substr($current_period, 4,1);
		
		
		$style_table_header = array(
					'font' => array(
						'bold' => true,
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					),
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
						),
					),					
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'argb' => 'CCCCCCCC',
						)
					)
				);
				
		$style_table = array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					),
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
						),
					)
				);
				
						
		if ($current_period_semester == 1) $semester = "Ganjil"; else $semester = "Genap";  
		
		for ($i = 1;$i <= $column;$i++) {
			$this->excel->getActiveSheet()->getColumnDimension(num_to_letter($i))->setAutoSize(true);	
		}
		
		
		$title1 = "Data Mahasiswa Universitas Terbuka Korea Selatan";
		$title2 = "Semester ". $semester ." Tahun ".$current_period_year;
		
		$this->excel->getDefaultStyle()->getFont()->setName('Arial');
		$this->excel->getDefaultStyle()->getFont()->setSize(9);
		
		$this->excel->getActiveSheet()->setTitle('Data Mahasiswa');
		
		$this->excel->getActiveSheet()->setCellValue('A1', $title1);
		$this->excel->getActiveSheet()->setCellValue('A2', $title2);
		
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);		
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		
		$this->excel->getActiveSheet()->mergeCells('A1:'.num_to_letter($column).'1');				
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12);		
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		
		$this->excel->getActiveSheet()->mergeCells('A2:'.num_to_letter($column).'2');				
		$this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		$table_row = 5;
		foreach ($data as $key_period => $val_period) {			
			foreach ($val_period as $key_major => $val_major) {
				$table_title = "Semester : ".calculate_semester($key_period)." Jurusan : ".get_major($key_major);
				$this->excel->getActiveSheet()->setCellValue('A'.$table_row, $table_title);
				$this->excel->getActiveSheet()->mergeCells('A'.$table_row.":".num_to_letter($column).$table_row);
				$table_row++;
				
				$table_header = array_shift(array_values($val_major));
				//print_r($table_header);
				$init_column = 1;
				$ignore = array('major','entry_period');
				
				foreach ($table_header as $key_header => $val_header) {		
					if (! in_array($key_header, $ignore)) {						
						$this->excel->getActiveSheet()->setCellValue(num_to_letter($init_column).$table_row, $this->lang->line($key_header));
						$this->excel->getActiveSheet()->getStyle(num_to_letter($init_column).$table_row)->applyFromArray($style_table_header);						
						$init_column++;
					}					
				}
				
				
				$table_row++;
				
								
				foreach ($val_major as $key2 => $val2) {
						$init_column = 1;
						foreach ($val2 as $key => $val) {
							if (! in_array($key, $ignore)) {
								if ($key == 'phone') {
									$this->excel->getActiveSheet()->setCellValueExplicit(num_to_letter($init_column).$table_row, "+".$val, PHPExcel_Cell_DataType::TYPE_STRING);									
								} else if ($key == 'birth_date') {
									//$this->excel->getActiveSheet()->setCellValue(num_to_letter($init_column).$table_row, convertHumanDate($val));									
									$this->excel->getActiveSheet()->setCellValue(num_to_letter($init_column).$table_row, $val);
								} else {
									$this->excel->getActiveSheet()->setCellValue(num_to_letter($init_column).$table_row, $val);	
								}
								
								$this->excel->getActiveSheet()->getStyle(num_to_letter($init_column).$table_row)->applyFromArray($style_table);
								$init_column++;
							}															
						}

						$table_row++;	
					
					
				}
				
				$table_row++;
			}
			
			$table_row++;
		} 
		
				 
		$filename='data_mahasiswa.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		     
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');		
		$objWriter->save('php://output');
		 
	}
    
    function list_mahasiswa($major,$entry_period,$region) 
    {
        $page = $this->input->post("page", TRUE );
		if(!$page)$page=1;
		
		$rows = $this->input->post("rows", TRUE );
		if(!$rows)$rows=10;
		
		$sort_by = $this->input->post( "sidx", TRUE );
		if(!$sort_by)$sort_by='name';
		
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
		
        $data->records = count ($this->person->get_list_JQGRID('mahasiswa',$req_param,"all",false,$major,$entry_period,$region,false)->result_array());		
		$records = $this->person->get_list_JQGRID('mahasiswa',$req_param,"current",false,$major,$entry_period,$region,false)->result_array();
		$newrecords = array();
		foreach($records as $row){
		  //$row['entry_period'] = calculate_semester($row['entry_period']);
		  $newrecords[] = $row;
		}
		$records = $newrecords;
		
		
		$data->total = ceil($data->records /$rows );
		$data->rows = $records;

		echo json_encode ($data );
		exit( 0 );
    }
    
	function reupload($type){
		$data['message'] = '';
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('reg_code', 'Nomor Registrasi', 'required|numeric');
		$this->form_validation->set_rules('jenis', 'Jenis', 'required');
		
		if(isset($_FILES['filename'])){
			if($this->form_validation->run()){
				$config['upload_path'] = 'assets/uploads/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
				$config['max_size'] = '10000';
				$config['max_width'] = '10240';
				$config['max_height'] = '76800';
				$config['encrypt_name'] = TRUE;
		
				$this->load->library('upload', $config);
		
				if ( ! $this->upload->do_upload('filename'))
				{
					$data['message'] = $this->upload->display_errors();		
				}
				else{
					$upload_arr = $this->upload->data();
					$this->person->edit_mahasiswa_baru($this->input->post('reg_code'),array($this->input->post('jenis')=>$upload_arr['file_name']));
					$data['message'] = 'File Berhasil di upload';
				}
			}
		}
		
		$content['page'] = $this->load->view('kemahasiswaan/reupload',$data,TRUE);
        $this->load->view('dashboard',$content);
	}
	
}