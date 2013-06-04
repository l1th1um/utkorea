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
		 $this->form_validation->set_rules('masukan', 'Masukan TTM', 'xss_clean');
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
	
	function export_nilai(){
		$q = $this->tutor_model->get_current_class_composition_list();
		
		$data['list'] = $q;
		$content['page'] = $this->load->view('tutor/export_nilai',$data,TRUE);
		$this->load->view('dashboard',$content);
	}
	
	public function export_to_excel($sid) 
	{
		
		$class = $this->tutor_model->get_class_by_id($sid);
		
		$this->load->model('class_model','cls');
		$students = $this->cls->list_class_student($sid);
		
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		
		$current_period = get_settings('time_period');
		
		$style_title = array(					
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					),
					'font' => array(
						'bold' => true,
					)
				);
				
		$style_table_header = array(					
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					),
					'borders' => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
						),
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
				
		$this->excel->getDefaultStyle()->getFont()->setName('Verdana');
		$this->excel->getDefaultStyle()->getFont()->setSize(10);
		
		// Add an image to the worksheet
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('UT LOGO');		
		$objDrawing->setPath('assets/core/images/logo_ut.jpg');
		$objDrawing->setWidth(40);
		$objDrawing->setHeight(40);
		$objDrawing->setCoordinates('B1');
		$objDrawing->setWorksheet($this->excel->getActiveSheet());
		
		$this->excel->getActiveSheet()->setTitle('Nilai');
		
		$this->excel->getActiveSheet()->setCellValue('D1', 'REKAPITULASI NILAI TUTORIAL NON PENDAS '.substr($current_period, 0,4).'.'.substr($current_period, 4,1));		
		$this->excel->getActiveSheet()->mergeCells('D1:H1');
		
		$this->excel->getActiveSheet()->setCellValue('A2', 'UPBJJ-UT:');
		$this->excel->getActiveSheet()->mergeCells('A2:B2');	
		$this->excel->getActiveSheet()->setCellValue('A3', 'Jurusan:');
		$this->excel->getActiveSheet()->mergeCells('A3:B3');
		$this->excel->getActiveSheet()->setCellValue('A4', 'Kode/Mata Kuliah:');
		$this->excel->getActiveSheet()->mergeCells('A4:B4');
		
		$this->excel->getActiveSheet()->setCellValue('C2', '21/Jakarta');
		$this->excel->getActiveSheet()->setCellValue('C3', $class->major);
		$this->excel->getActiveSheet()->setCellValue('C4', $class->code.'/'.$class->title);
		
		$this->excel->getActiveSheet()->setCellValue('H2', 'Semester:');
		$this->excel->getActiveSheet()->setCellValue('H3', 'Nama Tutor:');
		$this->excel->getActiveSheet()->setCellValue('H4', 'Kelas:');
		
		$this->excel->getActiveSheet()->setCellValue('I2', substr($current_period, 0,4).'.'.substr($current_period, 4,1).' (Semester '.$class->semester.')');
		$this->excel->getActiveSheet()->setCellValue('I3', $class->name);
		$this->excel->getActiveSheet()->setCellValue('I4', $class->title.'-'.$class->region);
		
		//Header Table
		$this->excel->getActiveSheet()->setCellValue('A7', 'No');
		$this->excel->getActiveSheet()->getStyle('A7')->applyFromArray($style_table_header);
		$this->excel->getActiveSheet()->setCellValue('B7', 'NIM');
		$this->excel->getActiveSheet()->getStyle('B7')->applyFromArray($style_table_header);
		$this->excel->getActiveSheet()->setCellValue('C7', 'Nama Mahasiswa');
		$this->excel->getActiveSheet()->getStyle('C7')->applyFromArray($style_table_header);
		$this->excel->getActiveSheet()->setCellValue('D7', 'Tugas(TA)');
		$this->excel->getActiveSheet()->getStyle('D7:G7')->applyFromArray($style_table_header);	
		$this->excel->getActiveSheet()->mergeCells('D7:G7');			
		$this->excel->getActiveSheet()->setCellValue('H7', 'Nilai Partisipasi(P)');
		$this->excel->getActiveSheet()->getStyle('H7')->applyFromArray($style_table_header);
		$this->excel->getActiveSheet()->setCellValue('I7', 'Nilai Akhir');
		$this->excel->getActiveSheet()->getStyle('I7')->applyFromArray($style_table_header);
		
		$this->excel->getActiveSheet()->getStyle('A8')->applyFromArray($style_table_header);
		$this->excel->getActiveSheet()->getStyle('B8')->applyFromArray($style_table_header);
		$this->excel->getActiveSheet()->getStyle('C8')->applyFromArray($style_table_header);
		$this->excel->getActiveSheet()->setCellValue('D8', 'Tugas(TA) 1');
		$this->excel->getActiveSheet()->getStyle('D8')->applyFromArray($style_table_header);
		$this->excel->getActiveSheet()->setCellValue('E8', 'Tugas(TA) 2');
		$this->excel->getActiveSheet()->getStyle('E8')->applyFromArray($style_table_header);
		$this->excel->getActiveSheet()->setCellValue('F8', 'Tugas(TA) 3');
		$this->excel->getActiveSheet()->getStyle('F8')->applyFromArray($style_table_header);
		$this->excel->getActiveSheet()->setCellValue('G8', 'Tugas Akhir');
		$this->excel->getActiveSheet()->getStyle('G8')->applyFromArray($style_table_header);
		$this->excel->getActiveSheet()->getStyle('H8')->applyFromArray($style_table_header);
		$this->excel->getActiveSheet()->getStyle('I8')->applyFromArray($style_table_header);
						
		$c=9;$i=1;	
					
		foreach($students->result() as $row){
			$this->excel->getActiveSheet()->setCellValue('A'.$c, $i);
			$this->excel->getActiveSheet()->getStyle('A'.$c)->applyFromArray($style_table);
			
			//NIM
			$this->excel->getActiveSheet()->setCellValue('B'.$c, $row->nim);
			$this->excel->getActiveSheet()->getStyle('B'.$c)->applyFromArray($style_table_header);
			
			//Nama Mahasiswa
			$this->excel->getActiveSheet()->setCellValue('C'.$c, $row->name);
			$this->excel->getActiveSheet()->getStyle('C'.$c)->applyFromArray($style_table);
			
			//TUGAS 1
			$this->excel->getActiveSheet()->setCellValue('D'.$c, $row->tugas1);
			$this->excel->getActiveSheet()->getStyle('D'.$c)->applyFromArray($style_table_header);
			$this->excel->getActiveSheet()->getStyle('D'.$c)->getNumberFormat()->setFormatCode('0.00'); 
			
			//TUGAS 2
			$this->excel->getActiveSheet()->setCellValue('E'.$c, $row->tugas2);
			$this->excel->getActiveSheet()->getStyle('E'.$c)->applyFromArray($style_table_header);
			$this->excel->getActiveSheet()->getStyle('E'.$c)->getNumberFormat()->setFormatCode('0.00'); 
			
			//TUGAS 3
			$this->excel->getActiveSheet()->setCellValue('F'.$c, $row->tugas3);
			$this->excel->getActiveSheet()->getStyle('F'.$c)->applyFromArray($style_table_header);
			$this->excel->getActiveSheet()->getStyle('F'.$c)->getNumberFormat()->setFormatCode('0.00'); 
			
			//AVG TUGAS
			$this->excel->getActiveSheet()->setCellValue('G'.$c, '=AVERAGE(D'.$c.':F'.$c.')');
			$this->excel->getActiveSheet()->getStyle('G'.$c)->applyFromArray($style_table);
			$this->excel->getActiveSheet()->getStyle('G'.$c)->getNumberFormat()->setFormatCode('0.00'); 
			
			//NILAI PARTISIPASI
			$this->excel->getActiveSheet()->setCellValue('H'.$c, $row->partisipasi);
			$this->excel->getActiveSheet()->getStyle('H'.$c)->applyFromArray($style_table);
			$this->excel->getActiveSheet()->getStyle('H'.$c)->getNumberFormat()->setFormatCode('0.00'); 
			
			//NILAI AKHIR
			$this->excel->getActiveSheet()->setCellValue('I'.$c, '=0.7*G'.$c.'+0.3*H'.$c);
			$this->excel->getActiveSheet()->getStyle('I'.$c)->applyFromArray($style_table);
			$this->excel->getActiveSheet()->getStyle('I'.$c)->getNumberFormat()->setFormatCode('0.00'); 
			
			$i++;
			$c++;
		}
		
		$this->excel->getActiveSheet()->setCellValue('A'.($c+2), 'Mengetahui');
		$this->excel->getActiveSheet()->setCellValue('A'.($c+3), 'Ka. UPBJJ-UT. Jakarta ');
		
		$this->excel->getActiveSheet()->setCellValue('G'.($c+2), 'Jakarta, '.date('j F Y'));
		$this->excel->getActiveSheet()->setCellValue('G'.($c+3), 'Tutor,');
		
		$this->excel->getActiveSheet()->setCellValue('A'.($c+8), 'Ir. Adi Winata M.Si');
		$this->excel->getActiveSheet()->setCellValue('A'.($c+9), 'Nip: 19610728 198602 1 002');
		
		$this->excel->getActiveSheet()->setCellValue('G'.($c+8), $class->name);
		
		
		//====================Absensi===========================================================
		$this->excel->createSheet();
		$this->excel->setActiveSheetIndex(1);
		$this->excel->getActiveSheet()->setTitle('Absensi');
		
		// Add an image to the worksheet
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('UT LOGO');		
		$objDrawing->setPath('assets/core/images/logo_ut.jpg');
		$objDrawing->setWidth(40);
		$objDrawing->setHeight(40);
		$objDrawing->setCoordinates('C1');
		$objDrawing->setWorksheet($this->excel->getActiveSheet());
		
		$this->excel->getActiveSheet()->setCellValue('D2', 'DAFTAR HADIR MATA KULIAH');		
		$this->excel->getActiveSheet()->mergeCells('D2:L2');
		$this->excel->getActiveSheet()->getStyle('D2:L2')->applyFromArray($style_title);	
		
		$this->excel->getActiveSheet()->setCellValue('C4', 'Negara:');$this->excel->getActiveSheet()->setCellValue('D4', 'Korea Selatan');
		$this->excel->getActiveSheet()->setCellValue('H4', 'Semester:');$this->excel->getActiveSheet()->setCellValue('I4', $class->semester);
		
		$this->excel->getActiveSheet()->setCellValue('C5', 'Jurusan:');$this->excel->getActiveSheet()->setCellValue('D5', $class->major);
		$this->excel->getActiveSheet()->setCellValue('H5', 'Nama Tutor:');$this->excel->getActiveSheet()->setCellValue('I5', $class->name);
		
		$this->excel->getActiveSheet()->setCellValue('C6', 'Kode/Nama Mtk:');$this->excel->getActiveSheet()->setCellValue('D6', $class->code);
		$this->excel->getActiveSheet()->setCellValue('H6', 'Kelas:');$this->excel->getActiveSheet()->setCellValue('I6', $class->title);
		
		$this->excel->getActiveSheet()->setCellValue('B8', 'No.');
		$this->excel->getActiveSheet()->mergeCells('B8:B9');
		$this->excel->getActiveSheet()->getStyle('B8:B9')->applyFromArray($style_table_header);	
		
		$this->excel->getActiveSheet()->setCellValue('C8', 'NIM');
		$this->excel->getActiveSheet()->mergeCells('C8:C9');
		$this->excel->getActiveSheet()->getStyle('C8:C9')->applyFromArray($style_table_header);	
		
		$this->excel->getActiveSheet()->setCellValue('D8', 'Nama Mahasiswa');
		$this->excel->getActiveSheet()->mergeCells('D8:D9');
		$this->excel->getActiveSheet()->getStyle('D8:D9')->applyFromArray($style_table_header);
		
		$this->excel->getActiveSheet()->setCellValue('E8', 'Pertemuan Ke-');
		$this->excel->getActiveSheet()->mergeCells('E8:L8');
		$this->excel->getActiveSheet()->getStyle('E8:L8')->applyFromArray($style_table_header);
		
		$this->excel->getActiveSheet()->setCellValue('E9', 'I');
		$this->excel->getActiveSheet()->getStyle('E9')->applyFromArray($style_table_header);
		$this->excel->getActiveSheet()->setCellValue('F9', 'II');
		$this->excel->getActiveSheet()->getStyle('F9')->applyFromArray($style_table_header);
		$this->excel->getActiveSheet()->setCellValue('G9', 'III');
		$this->excel->getActiveSheet()->getStyle('G9')->applyFromArray($style_table_header);
		$this->excel->getActiveSheet()->setCellValue('H9', 'IV');
		$this->excel->getActiveSheet()->getStyle('H9')->applyFromArray($style_table_header);
		$this->excel->getActiveSheet()->setCellValue('I9', 'V');
		$this->excel->getActiveSheet()->getStyle('I9')->applyFromArray($style_table_header);
		$this->excel->getActiveSheet()->setCellValue('J9', 'VI');
		$this->excel->getActiveSheet()->getStyle('J9')->applyFromArray($style_table_header);
		$this->excel->getActiveSheet()->setCellValue('K9', 'VII');
		$this->excel->getActiveSheet()->getStyle('K9')->applyFromArray($style_table_header);
		$this->excel->getActiveSheet()->setCellValue('L9', 'VIII');
		$this->excel->getActiveSheet()->getStyle('L9')->applyFromArray($style_table_header);
		
		
		
		//content absen
		$i = 1;
		$startrow = 9;
		foreach($students->result() as $row){
			$this->excel->getActiveSheet()->setCellValue('B'.($startrow+$i), $i);
			$this->excel->getActiveSheet()->getStyle('B'.($startrow+$i))->applyFromArray($style_table_header);
			
			$this->excel->getActiveSheet()->setCellValue('C'.($startrow+$i), $row->nim);
			$this->excel->getActiveSheet()->getStyle('C'.($startrow+$i))->applyFromArray($style_table_header);	
			
			$this->excel->getActiveSheet()->setCellValue('D'.($startrow+$i), $row->name);
			$this->excel->getActiveSheet()->getStyle('D'.($startrow+$i))->applyFromArray($style_table_header);		
			
			$temparr = explode(',',$row->absensi);
			if(!empty($temparr)){
				foreach($temparr as $abs){
					switch($abs){
						case 1:
							$this->excel->getActiveSheet()->setCellValue('E'.($startrow+$i), '√');
							break;
						
						case 2:
							$this->excel->getActiveSheet()->setCellValue('F'.($startrow+$i), '√');
							break;
							
						case 3:
							$this->excel->getActiveSheet()->setCellValue('G'.($startrow+$i), '√');
							break;
							
						case 4:
							$this->excel->getActiveSheet()->setCellValue('H'.($startrow+$i), '√');
							break;
						
						case 5:
							$this->excel->getActiveSheet()->setCellValue('I'.($startrow+$i), '√');
							break;
						
						case 6:
							$this->excel->getActiveSheet()->setCellValue('J'.($startrow+$i), '√');
							break;
						
						case 7:
							$this->excel->getActiveSheet()->setCellValue('K'.($startrow+$i), '√');
							break;
						
						case 8:
							$this->excel->getActiveSheet()->setCellValue('L'.($startrow+$i), '√');
							break;					
					}			
						
				}
			}
			
			$this->excel->getActiveSheet()->getStyle('E'.($startrow+$i))->applyFromArray($style_table_header);
			$this->excel->getActiveSheet()->getStyle('F'.($startrow+$i))->applyFromArray($style_table_header);
			$this->excel->getActiveSheet()->getStyle('G'.($startrow+$i))->applyFromArray($style_table_header);
			$this->excel->getActiveSheet()->getStyle('H'.($startrow+$i))->applyFromArray($style_table_header);
			$this->excel->getActiveSheet()->getStyle('I'.($startrow+$i))->applyFromArray($style_table_header);
			$this->excel->getActiveSheet()->getStyle('J'.($startrow+$i))->applyFromArray($style_table_header);
			$this->excel->getActiveSheet()->getStyle('K'.($startrow+$i))->applyFromArray($style_table_header);
			$this->excel->getActiveSheet()->getStyle('L'.($startrow+$i))->applyFromArray($style_table_header);
			
			$i++;
		}
		//==end content
		
		$this->excel->getActiveSheet()->setCellValue('D'.($startrow+$i+2), 'Nama Tutor');$this->excel->getActiveSheet()->setCellValue('D'.($startrow+$i+3), $class->name);
		$this->excel->getActiveSheet()->setCellValue('E'.($startrow+$i+2), 'Paraf Tutor');
		$this->excel->getActiveSheet()->mergeCells('E'.($startrow+$i+2).':L'.($startrow+$i+2));
		
		$this->excel->getActiveSheet()->getStyle('D'.($startrow+$i+3))->applyFromArray($style_table_header);
		$this->excel->getActiveSheet()->getStyle('E'.($startrow+$i+3))->applyFromArray($style_table_header);
		$this->excel->getActiveSheet()->getStyle('F'.($startrow+$i+3))->applyFromArray($style_table_header);
		$this->excel->getActiveSheet()->getStyle('G'.($startrow+$i+3))->applyFromArray($style_table_header);
		$this->excel->getActiveSheet()->getStyle('H'.($startrow+$i+3))->applyFromArray($style_table_header);
		$this->excel->getActiveSheet()->getStyle('I'.($startrow+$i+3))->applyFromArray($style_table_header);
		$this->excel->getActiveSheet()->getStyle('J'.($startrow+$i+3))->applyFromArray($style_table_header);
		$this->excel->getActiveSheet()->getStyle('K'.($startrow+$i+3))->applyFromArray($style_table_header);
		$this->excel->getActiveSheet()->getStyle('L'.($startrow+$i+3))->applyFromArray($style_table_header);
		
		$this->excel->getActiveSheet()->setCellValue('D'.($startrow+$i+6), 'Mengetahui');
		$this->excel->getActiveSheet()->setCellValue('D'.($startrow+$i+7), 'Ka. UPBJJ-UT. Jakarta ');
		
		$this->excel->getActiveSheet()->setCellValue('I'.($startrow+$i+6), 'Tutor');
		$this->excel->getActiveSheet()->setCellValue('I'.($startrow+$i+7), $class->name);
		
				 
		$filename='REKAP_'.$class->title.'_'.$current_period.'_'.$class->name.'.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		     
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');		
		$objWriter->save('php://output');
		 
	}

	public function hasil_survey(){
		$q = $this->tutor_model->get_current_class_composition_list(20131);
		
		$data['list'] = $q;
		$content['page'] = $this->load->view('tutor/hasil_survey',$data,TRUE);
		$this->load->view('dashboard',$content);
	}
	
	public function hasil_survey_detail($id_assignment){
		$this->load->model('class_model','cls');
		$q = $this->cls->get_survey_result($id_assignment);
		$class = $this->tutor_model->get_class_by_id($id_assignment);
		
		if($q){
			$data['surveyques'] = array(
				array('Bagian Pendahuluan','A'),
				array('Keterampilan menarik perhatian mahasiswa (ice breaking, kuis, games)',true),
				array('Keterampilan memotivasi mahasiswa',true),	
				array('Keterampilan menjelaskan ruang lingkup materi yang akan dibahas',true),
				array('Keterampilan menyampaikan relevansidanmanfaatmateri yang dibahas',true),
				array('Keterampilan menjelaskan kompetensi mahasiswa dalam mengikuti tutorial ',true),
				array('Bagian Penyajian ','B'),
				array('Sistematika penyampaian materi tutorial',true),
				array('Keterampilan menjelaskan materi tutorial',true),
				array('Keterampilan membimbing mahasiswa berlatih',true),
				array('Keterampilan mengajukan pertanyaan',true),
				array('Keterampilan memberikan umpan balik terhadap pertanyaan mahasiswa',true),
				array('Keterampilan menyebarkan pertanyaan kepada mahasiswa',true),
				array('Keterampilan mengaktifkan mahasiswa dalam tutorial',true),
				array('Keterampilan menggunakan media dan  alat pembelajaran',true),
				array('Keterampilan menggunakan beragam metode/model tutorial',true),
				array('Bagian Penutup','C'),
				array('Keterampilan menyimpulkan materi tutorial',true),
				array('Keterampilan mengevaluasi hasil belajar mahasiswa dalam tutorial',true),
				array('Keterampilan memberikan umpan balik terhadap hasil belajar mahasiswa dalam tutorial',true),
				array('Keterampilam memberikan informasi tentang kegiatan tindak lanjut',true),
				array('Keterampilan mengelola waktu tutorial ',true),
				array('Keseluruhan',true),
			);
			
			$total = array();
			//initializing
			foreach($data['surveyques'] as $key=>$p){
				$total[$key] = 0;
			}
			
			$comment = array();
			

			$numresponden = $q->num_rows();
			
			foreach($q->result_array() as $row){
				$temp1 = explode(",",$row['survey']);
				$cmnt = '';				
				foreach($temp1 as $key=>$tr){						
					if(is_numeric($tr)){
						$total[$key] =  $total[$key] + $tr;	
					}else{
						$cmnt .= $tr;
					}					
				}				
				
				$cmnt .= $row['comment'];
				if(trim($cmnt)!=''){
					$comment[] = $cmnt;	
				}				
			}

			$overall = array_sum($total)/$numresponden/count($data['surveyques']);
			
			
			$data['total'] = $total;
			$data['comment'] = $comment;
			$data['numresponden'] = $numresponden;
			$data['overall'] = $overall;
			$data['class'] = $class;
			
			$content['page'] = $this->load->view('tutor/hasil_survey_detail',$data,TRUE);
			$this->load->view('dashboard',$content);
		}
	}
	
}


