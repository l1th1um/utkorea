<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class kelas extends CI_Controller {

	public function __construct()
    {
        parent::__construct();								
		//$this->output->enable_profiler(TRUE);
        $this->load->model('person_model','person');
		$this->load->model('tutor_model');
        $this->load->model('class_model');
        $this->load->model('announcement_model','announce');
		$this->load->library('scribd',array('api_key'=>$this->config->item('scribd_key'),'secret'=>$this->config->item('scribd_secret')));
        $this->load->helper('html');
        
        

    }	
	
    public function index($id=''){
		
	   $this->auth->check_auth();	
		
	   //check registration or/and get list
        if(is_numeric($this->session->userdata('username'))){
            $res = $this->tutor_model->get_list_classes_for_student($this->session->userdata('username'));
            
            if(!$res)
            {
		         $data = $this->register_class();	
			     $content['page'] = $this->load->view('kelas/register',$data,TRUE);				
            }
            else
            {
                $data['list'] = $res;	
                $content['page'] = $this->load->view('kelas/list',$data,TRUE);				
            }
		}
        else
        {
            $res = $this->tutor_model->get_list_classes_for_tutor($this->session->userdata('id'));
		    $data['list'] = $res;				
            $content['page'] = $this->load->view('kelas/list',$data,TRUE);
        }				
						
		
        $this->load->view('dashboard',$content);
	}
    
    public function course($uid)
    {
        if($uid!=''){
            $id = $this->class_model->id_to_uuid($uid);
            
			$class_settings = $this->tutor_model->get_class_by_id($id);
            
			if($class_settings){				
				$this->scribd->my_user_id = 'assignment_'.$id;		
				try{
					$datas = $this->scribd->getList(array('api_key'=>$this->config->item('scribd_key')));	
				}catch(exception $e){
					//$datas = $e->getMessage();
					$datas = false;
				}
							
				$data['file'] = $datas;					
			}
            				
			$data['class_settings'] = $class_settings;
			//$data['pengumuman'] = $this->tutor_model->get_valid_pengumuman($id);
            $data['announcement'] = $this->announce->display_announce_class($id,5);
            $data['question'] = $this->announce->list_question($id,5);
            $data['task'] = false;
            $data['id'] = $uid;
			$content['page'] = $this->load->view('kelas/main',$data,TRUE);
		}
        
        $this->load->view('dashboard',$content);
    }
    
	public function absnilai($assignment_id=''){
		$this->auth->check_auth();	
		$data['success'] = 0;
		
		$res = $this->tutor_model->get_tutor_student($this->session->userdata('id'));
        
        if($res){
			foreach($res->result() as $row){
				$this->form_validation->set_rules('abs_'.$row->id_assignment.'_'.$row->nim,'Absensi '.$row->nim,'xss_clean');
				for($i=1;$i<=3;$i++){
					$this->form_validation->set_rules('tugas_'.$row->id_assignment.'_'.$row->nim.'_'.$i,'Tugas '.$row->nim.'_'.$i,'xss_clean');	
				}				
			}
			if($this->form_validation->run()){				
				foreach($res->result() as $row){
					if(is_array($this->input->post('abs_'.$row->id_assignment.'_'.$row->nim))){
						$abs = implode(",",$this->input->post('abs_'.$row->id_assignment.'_'.$row->nim)); 
					}else{
						$abs = $this->input->post('abs_'.$row->id_assignment.'_'.$row->nim);
					}					
					
					$update = array(
						'id_student' => $row->id_student,
						'id_assignment' => $row->id_assignment,
						'absensi' => $abs,
						'tugas1' => $this->input->post('tugas_'.$row->id_assignment.'_'.$row->nim.'_1'),
						'tugas2' => $this->input->post('tugas_'.$row->id_assignment.'_'.$row->nim.'_2'),
						'tugas3' => $this->input->post('tugas_'.$row->id_assignment.'_'.$row->nim.'_3')
					);
					$this->tutor_model->update_absnilai($update);
				}				
				$res = $this->tutor_model->get_tutor_student($this->session->userdata('id'));				
			}
            
			$data['list'] = $res;
		}		
		
		$content['page'] = $this->load->view('kelas/absnilai',$data,TRUE);
		$this->load->view('dashboard',$content);
	}

	public function get_class_archive($id){
		$this->scribd->my_user_id = 'assignment_'.$id;		
		$data = $this->scribd->getList(array('api_key'=>$this->config->item('scribd_key')));
		if($data){
			$res = '';
			foreach($data as $row){
				$res .= '<tr>';
				$res .= '<td><a href="#" class="docarsip" alt="'.$row['doc_id'].'"><input type="hidden" value="'.$row['access_key'].'" /> '.$row['title'].'</a></td><td>'.$row['when_uploaded'].'</td>';
				$res .= '</tr>';
			}
			echo $res;
		}else{
			echo "<tr><td></td><td style='font-size:12pt;'><b>Tidak Ada Arsip</b></td></tr>";
		}
	}
	
	public function pengaturan(){
		
		$this->auth->check_auth();		
		
		$classes = $this->tutor_model->get_class_by_tutor($this->session->userdata('id'));
        $data['is_class'] = true;
        
		if ($classes != false) {
    		foreach($classes->result() as $row){
    			$this->form_validation->set_rules('status'.$row->id,'Status','required|xss_clean');
    			$this->form_validation->set_rules('linkvid'.$row->id,'Status','xss_clean');
    			$this->form_validation->set_rules('radio'.$row->id,'Live Provider','required|xss_clean');
    			$this->form_validation->set_rules('ustreamch'.$row->id,'Ustream Channel','xss_clean');
    			$this->form_validation->set_rules('justinch'.$row->id,'Justin Channel','xss_clean');
    			$this->form_validation->set_rules('bambuserch'.$row->id,'Bambuser Channel','xss_clean');
    			$this->form_validation->set_rules('lsch'.$row->id,'Livestream Channel','xss_clean');
    		}
    		$data['success'] = 0;
    		
    		if($this->form_validation->run()){
    			$datas = array();
    			foreach($classes->result() as $row){
    					$datas[] = array(
    						'status'=>$this->input->post('status'.$row->id),
    						'linkvid'=>$this->input->post('linkvid'.$row->id),
    						'chopt'=>$this->input->post('radio'.$row->id),
    						'ustreamch'=>$this->input->post('ustreamch'.$row->id),
    						'justinch'=>$this->input->post('justinch'.$row->id),
    						'bambuserch'=>$this->input->post('bambuserch'.$row->id),
    						'lsch'=>$this->input->post('lsch'.$row->id),
    						'id'=>$row->id
    					);
    			}
    			$this->tutor_model->update_batch_assignment($datas,'id');
    			$data['success'] = 1;
    			$classes = $this->tutor_model->get_class_by_tutor($this->session->userdata('id'));
    		}
            
            $data['classes'] = $classes;
		} else {
		    $data['is_class'] = false;
		    $data['message'] = $this->lang->line("no_access");
		}
		
		$content['page'] = $this->load->view('kelas/pengaturan',$data,TRUE);
        $this->load->view('dashboard',$content);
	}
	
	public function register_class(){
		$this->auth->check_auth();
		
		$this->form_validation->set_rules('classid','Kelas','required');
		if($this->form_validation->run()){
			
			$logs_data = array('activity' => 'save class',
		  					 'result' => $this->tutor_model->save_class($this->session->userdata('username'),$this->input->post('classid')),
							 'remarks' => 'class initiation',
							 'user_agent' => check_user_agent());
							 
		 	insert_logs($logs_data);
			$this->index();			
		}
			
		$student = $this->person->get_mahasiswa_by_id($this->session->userdata('username'));
		
		$data['semester'] = calculate_semester($student['entry_period']);
		$classes = $this->tutor_model->get_available_class($student['major'],$data['semester'],$student['region']);		
				
		$data['classes'] = $classes;
		
		return $data;        
	}
	
	public function arsip(){
		$this->auth->check_auth();
		
		$res = $this->tutor_model->get_list_classes_for_tutor($this->session->userdata('id'));
		$data['list'] = $res;
		
		$content['page'] = $this->load->view('kelas/arsip',$data,TRUE);
        $this->load->view('dashboard',$content);
	}
	
	public function do_upload($id_assignment){
		
		if(isset($_FILES['upload'])){
			$this->scribd->my_user_id = 'assignment_'.$id_assignment;
			$doc_type = null;
			$access = null;
			$rev_id = null;
			$res = $this->scribd->upload($_FILES['upload']['tmp_name'], $doc_type, $access, $rev_id);
			$this->scribd->changeSettings($res['doc_id'],array('download_formats'=>'original'),$_FILES['upload']['name']);
			echo json_encode(array('doc_id'=>$res['doc_id'],'access_key'=>$res['access_key'],'id'=>$id_assignment));
		}		
	}
	
	public function arsip_download($doc_id,$assignment_id){
		$this->scribd->my_user_id = 'assignment_'.$assignment_id;
		//print_r($this->scribd->getDownloadLink($doc_id));
		$res = $this->scribd->getDownloadLink($doc_id);
		redirect($res['download_link'],'refresh');
	}
	
	public function arsip_delete($doc_id,$assignment_id){
		$this->scribd->my_user_id = 'assignment_'.$assignment_id;
		$res = $this->scribd->delete($doc_id);
	}
	
	/*public function debug_get_settings($doc_id){
		$this->scribd->my_user_id = 'assignment_1';
		print_r($this->scribd->getConversionStatus($doc_id));
	}*/
	
	public function pengumuman(){
		$this->auth->check_auth();
		
		$res = $this->tutor_model->get_list_classes_for_tutor($this->session->userdata('id'));
		$data['list'] = $res;
		
		$content['page'] = $this->load->view('kelas/pengumuman',$data,TRUE);
        $this->load->view('dashboard',$content);
	}
	
	function data_pengumuman($assignment_id)
	{
		$page = $this->input->post("page", TRUE );
		if(!$page)$page=1;
		
		$rows = $this->input->post("rows", TRUE );
		if(!$rows)$rows=20;
		
		$sort_by = $this->input->post( "sidx", TRUE );
		if(!$sort_by)$sort_by='created';
		
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
		$data->records = count ($this->tutor_model->get_list_JQGRID('pengumuman_kelas',$req_param,"all",false,$assignment_id)->result_array());		
			$records = $this->tutor_model->get_list_JQGRID('pengumuman_kelas',$req_param,"current",false,$assignment_id)->result_array();
		
		
		$data->total = ceil($data->records /$rows );
		$data->rows = $records;

		echo json_encode ($data );
		exit( 0 );
	}

	public function data_pengumuman_CRUD(){
		$response = "";
		if(isset($_POST['oper'])){
			$col = array();
			$this->load->library('form_validation');
			switch($_POST['oper']){
				case 'edit':					
					$this->form_validation->set_rules('content', 'Content', 'required');					
					$this->form_validation->set_rules('until', 'Until', 'required');	
					$col = $this->input->post();
					break;
				case 'add':
					$this->form_validation->set_rules('content', 'Content', 'required');					
					$this->form_validation->set_rules('until', 'Until', 'required');	
					$this->form_validation->set_rules('assignment_id', 'Assignment ID', 'required');				
					$col = $this->input->post();
					break;
				case 'del':
					$this->form_validation->set_rules('id', 'ID', 'required|numeric');	
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
							$this->tutor_model->update_pengumuman_kelas($id,$col);
							break;
						case 'add':
							unset($col['oper']);
							unset($col['id']);							
							
							$this->tutor_model->add_pengumuman_kelas($col);
							break;
						case 'del':
							$this->tutor_model->delete_pengumuman_kelas($col['id']);
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

	public function scribd_docview($doc_id,$access_key,$class_id){
		$data = array(
			'doc_id' => $doc_id,
			'access_key' => $access_key,
			'class_id' => $class_id
		);
		
		$this->load->view('kelas/scribd_docview',$data);
	}
	
    function announcement($id) {
        $this->auth->check_auth();
        
        $data['list'] = $this->announce->display_announce_class($id);
		$data['id'] = $id;
        
        if ($this->session->flashdata('message') != '') {
            $data['message'] = success_form($this->session->flashdata('message'));
        } 
        
		$content['page'] = $this->load->view('kelas/announcement',$data,TRUE);        
        $this->load->view('dashboard',$content);
    }
    
    function create_announcement($id) {
        $this->auth->check_auth();
        
        $data = array();
		
		if (isset($_POST['title'])) {
			$this->_validate_announcements();
			
			if ($this->form_validation->run() == FALSE) {
				$data['message'] = error_form(validation_errors());				
			} else {
			     $post_data = $_POST;
                 $post_data['staff_id'] = $this->session->userdata('id');
                 
				if ($this->class_model->save_announce_class($post_data,$id)) {
				    $this->session->set_flashdata('message',$this->lang->line('announcement')." ".$this->lang->line('saved'));
					//$data['message'] = success_form($this->lang->line('announcement')." ".$this->lang->line('saved'));
                    redirect('kelas/announcement/'.$id);
				} else {
					$data['message'] = 	error_form($this->lang->line('db_error'));
				}
			}
		}
               
        $data['id'] = $id;
		$content['page'] = $this->load->view('kelas/create_announcement',$data,TRUE);        
        $this->load->view('dashboard',$content);
    }
    
    public function _validate_announcements()
	{
		$this->form_validation->set_rules('title',$this->lang->line('title'),'trim|required|min_length[4]');
		$this->form_validation->set_rules('content',$this->lang->line('announcement'),'trim|required|min_length[4]');		
	}
    
    public function show_announce_class() {
		$id = $this->input->post('id');
        $row = $this->class_model->announce_class_detail($id);
        $attach = $this->class_model->get_attachment($row->attach_uid);
        $data['row'] = $row;
        
        $ext = $path_parts = pathinfo($attach->filename);
        
        $data['icon'] = $ext['extension'];
        $data['attach'] = $attach;
		
		echo $this->load->view('kelas/announce_class',$data,TRUE);
	}
    /*
    function list_question($id,$limit=null) {
        $data['list'] = $this->announce->list_question($id,$limit);
		$data['id'] = $id;
		$content['page'] = $this->load->view('kelas/announcement',$data,TRUE);        
        $this->load->view('dashboard',$content);
    } 
    */
    function question($id) {
        $this->auth->check_auth();
        
        $data['list'] = $this->announce->list_question($id);
		$data['id'] = $id;
		$content['page'] = $this->load->view('kelas/question',$data,TRUE);        
        $this->load->view('dashboard',$content);
    } 
    
     function create_question($id) {
        $this->auth->check_auth();
        
        $data = array();
		
		if (isset($_POST['title'])) {
			$this->_validate_announcements();
			
			if ($this->form_validation->run() == FALSE) {
				$data['message'] = error_form(validation_errors());				
			} else {
				if ($this->announce->save_question($_POST,$id)) {
					$data['message'] = success_form($this->lang->line('question')." ".$this->lang->line('saved'));
				} else {
					$data['message'] = 	error_form($this->lang->line('db_error'));
				}
			}
		}
               
        $data['id'] = $id;
		$content['page'] = $this->load->view('kelas/create_question',$data,TRUE);        
        $this->load->view('dashboard',$content);
    }
    
     public function display_detail_question() {
		$id = $this->input->post('id');
		$data['row'] = $this->announce->display_detail_question($id);
		
		echo $this->load->view('kelas/question_detail',$data,TRUE);
	}
    
     function task($id) {
        $this->auth->check_auth();
        
        $data['list'] = $this->announce->list_task($id);
		$data['id'] = $id;
		$content['page'] = $this->load->view('kelas/task',$data,TRUE);        
        $this->load->view('dashboard',$content);
    }   
    
    function create_task($id) {
        $this->auth->check_auth();
        
        $data = array();
		
		if (isset($_POST['title'])) {
			$this->_validate_announcements();
			
			if ($this->form_validation->run() == FALSE) {
				$data['message'] = error_form(validation_errors());				
			} else {
				if ($this->announce->save_question($_POST,$id)) {
					$data['message'] = success_form($this->lang->line('question')." ".$this->lang->line('saved'));
				} else {
					$data['message'] = 	error_form($this->lang->line('db_error'));
				}
			}
		}
               
        $data['id'] = $id;
		$content['page'] = $this->load->view('kelas/create_task',$data,TRUE);        
        $this->load->view('dashboard',$content);
    }
    
    public function do_upload_kelas($field_name,$folder)
	{
		//$newname = $addfilename;
        
        $config['upload_path'] = 'assets/uploads/'.$folder;
        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx|ppt|pptx';
		$config['max_size'] = '10000';
		$config['max_width'] = '10240';
		$config['max_height'] = '76800';
        //$config['file_name']	= $addfilename;
		$config['encrypt_name'] = TRUE;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload($field_name))
		{
			echo $this->upload->display_errors('<p>', '</p>');
		}
		else
		{
			$data = $this->upload->data();

            $attach = array('original_file'=>$data['orig_name'],
                            'filename'=>$data['file_name'],
                            'subfolder' => $folder);
            
            $save_attach  = $this->class_model->save_attachment($attach);
            
            if ($save_attach == false ) 
            {
                echo "0";
            } 
            else 
            {
                $info = new stdClass();
                $info->name = $data['orig_name'];
                $info->id = $save_attach;
                
                echo json_encode(array($info));                                
            }
		}
	}
}
