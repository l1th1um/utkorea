<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class humas extends CI_Controller {
	
	public function __construct()
    {
        parent::__construct();								
    	//$this->output->enable_profiler(TRUE);
        $this->load->model('person_model','person');        
		$this->load->model('announcement_model','announcement');
    }	
	
	public function index()
	{	
		$this->auth->check_auth();
		$content['page'] = $this->load->view('humas/sms','',TRUE);
        $this->load->view('dashboard',$content);        
	}	
	
    function send_sms() {
		$student_select = "nim as userid,phone";
        $staff_select = "staff_id as userid,phone";
		
		switch($this->input->post('radio')) {	
				case "all_student": 
									$people = $this->person->get_mahasiswa_sms($student_select);
									break;
				case "student":
									$people = $this->person->get_mahasiswa_sms($student_select,$this->input->post('who'));
									break;
				case "all_tutor": 
									$people = $this->person->get_staff_sms($staff_select);
									break;
				case "tutor":
									$people = $this->person->get_staff_sms($staff_select,$this->input->post('who'));
									break;
                case "all_staff": 
									$people = $this->person->get_staff_sms($staff_select);
									break;
				case "staff":
									$people = $this->person->get_staff_sms($staff_select,$this->input->post('who'));
									break;
				case "manual":
									$people = explode(",",$this->input->post('who'));
									break;
                default :
									return false;
		}
		
		$message = $this->input->post('message');
		
		$success = 0;
		$failed = 0;
		
		if($this->input->post('radio')=='manual'){
			foreach ($people as $row) {
				$apimsgid = send_message($row,$message);
				if($apimsgid != FALSE) {
					$this->person->save_history_sms(99999,$apimsgid,$row,$message);				
					$success++;
				} else {
					$failed++;
				}
			}
		}else{
			foreach ($people as $row) {		
				//Send Message and return the ID of message
				$apimsgid = send_message($row->phone,$message);
				if($apimsgid != FALSE) {
					$this->person->save_history_sms($row->userid,$apimsgid,$row->phone,$message);				
					$success++;
				} else {
					$failed++;
				}	
			}
		}
		
		$message = "Sent Message : ".$success." sent";
			
			if ($failed > 0 ) {
				$message .= "; ".$failed." failed";
			}
		echo $message;
	}
	
	public function sms_history() {
		$this->auth->check_auth();
		
		$message['data'] = $this->person->get_sms_history();
		$content['page'] = $this->load->view('humas/history_sms',$message,TRUE);
        $this->load->view('dashboard',$content);        
	}
	
	public function getlist()
	{
		$res = $this->person->get_list_mahasiswa();
		$this->load->view('include/form_person_select',array('res'=>$res));
	}
	
	public function getlistJQGRID($type='student')
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
		if($type=='student'){

			$data->records = count ($this->person->get_list_JQGRID('mahasiswa',$req_param,"all")->result_array());		
			$records = $this->person->get_list_JQGRID('mahasiswa',$req_param,"current")->result_array();
			$newrecords = array();
			foreach($records as $row){
				//$row['entry_period'] = calculate_semester($row['entry_period']);
				$newrecords[] = $row;
			}
			$records = $newrecords;
		}elseif($type=='tutor'){
			$data->records = count ($this->person->get_list_JQGRID('tutor',$req_param,"all")->result_array());		
			$records = $this->person->get_list_JQGRID('tutor',$req_param,"current")->result_array();
		}elseif($type=='staff'){
			$data->records = count ($this->person->get_list_JQGRID('staff',$req_param,"all")->result_array());		
			$records = $this->person->get_list_JQGRID('staff',$req_param,"current")->result_array();
		}
		
		$data->total = ceil($data->records /$rows );
		$data->rows = $records;

		echo json_encode ($data );
		exit( 0 );
	}
	
	public function announcements() {
		$this->auth->check_auth();
		
		$data = array();
		
		if (isset($_POST['title'])) {
			$this->_validate_announcements();
			
			if ($this->form_validation->run() == FALSE) {
				$data['message'] = error_form(validation_errors());				
			} else {
				if ($this->announcement->save_announcement($_POST)) {
					$data['message'] = success_form($this->lang->line('announcement')." ".$this->lang->line('saved'));
				} else {
					$data['message'] = 	error_form($this->lang->line('db_error'));
				}
			}
		}
		$content['page'] = $this->load->view('humas/announcements',$data,TRUE);
        $this->load->view('dashboard',$content);
	}
	
	
	public function _validate_announcements()
	{
		$this->form_validation->set_rules('title',$this->lang->line('title'),'trim|required|min_length[4]');
		$this->form_validation->set_rules('news',$this->lang->line('announcement'),'trim|required|min_length[4]');		
	}
	
	public function display_announcement() {
		$id = $this->input->post('id');
		$data['row'] = $this->announcement->display($id);
		
		echo $this->load->view('announcement/display',$data,TRUE);
	}
		
}