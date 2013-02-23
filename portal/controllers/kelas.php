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
	   
	    $data['gb'] = array();
		$gb = $this->class_model->get_list_gabung_kelas(true);
		if($gb){
			$data['gb'] = $gb->result_array();			
		}
	   //check registration or/and get list
        if(is_numeric($this->session->userdata('username'))){
            $res = $this->tutor_model->get_list_classes_for_student($this->session->userdata('username'));
            
            if(!$res)
            {
		         $data = array_merge($data,$this->register_class());				 
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
        if(! empty($uid)){
            $this->session->set_userdata('course',$uid);
            
            $id = $this->class_model->id_to_uuid($uid);
            
			$class_settings = $this->tutor_model->get_class_by_id($id);
            
			if($class_settings){				

				$this->scribd->my_user_id = 'asg_'.$id;		
				try{

					$datas = $this->scribd->getList(array('api_key'=>$this->config->item('scribd_key')));	
				}catch(exception $e){					
					$datas = false;
				}
							
				$data['file'] = $datas;					
			}
            				
			$data['class_settings'] = $class_settings;
			//$data['pengumuman'] = $this->tutor_model->get_valid_pengumuman($id);
            $data['announcement'] = $this->class_model->list_announce_class($uid,5);
            $data['question'] = $this->class_model->list_question($uid,5);
            $data['task'] = $this->class_model->list_task($uid,5);
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
				$this->form_validation->set_rules('tugas_'.$row->id_assignment.'_'.$row->nim.'_partisipasi','Partisipasi '.$row->nim,'xss_clean');	
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
						'tugas3' => $this->input->post('tugas_'.$row->id_assignment.'_'.$row->nim.'_3'),
						'partisipasi' => $this->input->post('tugas_'.$row->id_assignment.'_'.$row->nim.'_partisipasi')
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
		$this->scribd->my_user_id = 'asg_'.$id;		
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
    			$this->form_validation->set_rules('chatango'.$row->id,'Chatango Group','xss_clean|trim');
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
    						'chatango'=>$this->input->post('chatango'.$row->id),
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
			redirect(site_url('kelas'),'redirect');			
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
			$this->scribd->my_user_id = 'asg_'.$id_assignment;
			$doc_type = null;
			$access = "public";
			$rev_id = null;
			
			
			
			$res = $this->scribd->upload($_FILES['upload']['tmp_name'], $doc_type, $access, $rev_id,file_get_contents($_FILES['upload']['tmp_name']),$_FILES['upload']['name']);
			$this->scribd->changeSettings($res['doc_id'],array('download_formats'=>'original'),$_FILES['upload']['name']);
			echo json_encode(array('doc_id'=>$res['doc_id'],'access_key'=>$res['access_key'],'id'=>$id_assignment));
			
			
		}		
	}
	
	public function arsip_download($doc_id,$assignment_id){
		$this->scribd->my_user_id = 'asg_'.$assignment_id;
		//print_r($this->scribd->getDownloadLink($doc_id));
		$res = $this->scribd->getDownloadLink($doc_id);
		redirect($res['download_link'],'refresh');
	}
	
	public function arsip_delete($doc_id,$assignment_id){
		$this->scribd->my_user_id = 'asg_'.$assignment_id;
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
        
        $data['list'] = $this->class_model->list_announce_class($id);
		$data['id'] = $id;
        
        if ($this->session->flashdata('message') != '') {
            $data['message'] = success_form($this->session->flashdata('message'));
        } 
        
		$content['page'] = $this->load->view('kelas/announcement',$data,TRUE);        
        $this->load->view('dashboard',$content);
    }
    
    function create_announcement($assignment_id,$announce_id=null) {
        $this->auth->check_auth();
        
        $data = array();
		
		if (isset($_POST['title'])) {
			$this->_validate_announcements();
			
			if ($this->form_validation->run() == FALSE) {
				$data['message'] = error_form(validation_errors());				
			} else {
			     $update = false;
                 
                 if ($announce_id <> NULL) {
                    $update = $announce_id;
                 }
                 
				 if ($this->class_model->save_announce_class($_POST,$assignment_id,$update)) {
				    $this->session->set_flashdata('message',$this->lang->line('announcement')." ".$this->lang->line('saved'));					
                    redirect('kelas/announcement/'.$assignment_id);
				} else {
					$data['message'] = 	error_form($this->lang->line('db_error'));
				}
			}
		}
        
        $data['detail'] = false;
        $data['icon'] = false;
        
        if ($announce_id <> NULL) {
            $data['detail'] = $this->class_model->announce_class_detail($assignment_id,$announce_id);
            $attach = $this->class_model->get_attachment($announce_id,1);
                        
            if ($attach <> false) {
                $ext = pathinfo($attach->filename);        
                $data['icon'] = $ext['extension'];
                $data['attach'] = $attach;    
            }
        }
               
        $data['id'] = $assignment_id;
		$content['page'] = $this->load->view('kelas/create_announcement',$data,TRUE);        
        $this->load->view('dashboard',$content);
    }
    
    public function _validate_announcements()
	{
		$this->form_validation->set_rules('title',$this->lang->line('title'),'trim|required|min_length[4]');
		$this->form_validation->set_rules('content',$this->lang->line('announcement'),'trim|required|min_length[4]');		
	}
    
    public function _validate_task()
	{
		$this->form_validation->set_rules('title',$this->lang->line('title'),'trim|required|min_length[4]');
		$this->form_validation->set_rules('content',$this->lang->line('task'),'trim|required|min_length[4]');		
        $this->form_validation->set_rules('deadline_date',$this->lang->line('deadline'),'trim|required|min_length[10]|max_length[10]');
	}
    
    public function show_announce_class() {
		$assignment_id = $this->input->post('assignment_id');
        $id = $this->input->post('id');
        $row = $this->class_model->announce_class_detail($assignment_id, $id);
        
        $attach = $this->class_model->get_attachment($row->id,1);
        $data['row'] = $row;
        
        $data['icon'] = false;
        
        if ($attach <> false) {
            $ext = pathinfo($attach->filename);        
            $data['icon'] = $ext['extension'];
            $data['attach'] = $attach;    
        }
        
		echo $this->load->view('kelas/announce_class',$data,TRUE);
	}
    
    function question($id) {
        //$this->auth->check_auth();
        $data['list'] = $this->class_model->list_question($id);
		$data['id'] = $id;
        if ($this->session->flashdata('message') != '') {
            $data['message'] = success_form($this->session->flashdata('message'));
        }
		$content['page'] = $this->load->view('kelas/question',$data,TRUE);        
        $this->load->view('dashboard',$content);
    } 
    
     function create_question($assignment_id,$announce_id=null) {
        $this->auth->check_auth();
        
        $data = array();
		
		if (isset($_POST['title'])) {
			$this->_validate_announcements();
			
			if ($this->form_validation->run() == FALSE) {
				$data['message'] = error_form(validation_errors());				
			} else {
				if ($this->class_model->save_question($_POST,$assignment_id)) {
				    $this->session->set_flashdata('message',$this->lang->line('question')." ".$this->lang->line('saved'));					
                    redirect('kelas/question/'.$assignment_id);
					//$data['message'] = success_form($this->lang->line('question')." ".$this->lang->line('saved'));
				} else {
					$data['message'] = 	error_form($this->lang->line('db_error'));
				}
			}
		}
               
        $data['id'] = $assignment_id;
		$content['page'] = $this->load->view('kelas/create_question',$data,TRUE);        
        $this->load->view('dashboard',$content);
    }
    
     public function display_detail_question() {
		$assignment_id = $this->input->post('assignment_id');
        $id = $this->input->post('id');
        $data['question_id'] = $id;
		$data['row'] = $this->class_model->display_detail_question($assignment_id,$id);
        $data['response'] = $this->class_model->display_question_response($id);
		
		echo $this->load->view('kelas/question_detail',$data,TRUE);
	}
    
     function task($id) {
        $this->auth->check_auth();
        
        $data['list'] = $this->class_model->list_task($id);
		$data['id'] = $id;
        
        if ($this->session->flashdata('message') != '') {
            $data['message'] = success_form($this->session->flashdata('message'));
        }
        
        if (in_array(8,$this->session->userdata('role'))) {
           $data['total_student'] = $this->class_model->student_per_class($id);
		   $content['page'] = $this->load->view('kelas/task',$data,TRUE);
        }        
        $this->load->view('dashboard',$content);
    }   
    
    function create_task($assignment_id,$announce_id=null) {
        $this->auth->check_auth();
        
        $data = array();
		
		if (isset($_POST['title'])) {
			$this->_validate_task();
			
			if ($this->form_validation->run() == FALSE) {
				$data['message'] = error_form(validation_errors());				
			} else {
			     $update = false;
                 
                 if ($announce_id <> NULL) {
                    $update = $announce_id;
                 } 
				if ($this->class_model->save_task($_POST,$assignment_id,$update)) {
					$this->session->set_flashdata('message',$this->lang->line('task')." ".$this->lang->line('saved'));					
                    redirect('kelas/task/'.$assignment_id);
				} else {
					$data['message'] = 	error_form($this->lang->line('db_error'));
				}
			}
		}
        
        $data['detail'] = false;
        $data['icon'] = false;
        
         if ($announce_id <> NULL) {
            $data['detail'] = $this->class_model->task_detail($assignment_id,$announce_id);
            $attach = $this->class_model->get_attachment($announce_id,2);
            
            if ($attach <> false) {
                $ext = pathinfo($attach->filename);        
                $data['icon'] = $ext['extension'];
                $data['attach'] = $attach;    
            }
        }
        
        $data['id'] = $assignment_id;
		$content['page'] = $this->load->view('kelas/create_task',$data,TRUE);        
        $this->load->view('dashboard',$content);
    }
    
    public function do_upload_kelas($field_name,$folder)
	{
		//$newname = $addfilename;
        
        $config['upload_path'] = 'assets/uploads/'.$folder;
        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx|ppt|pptx|zip|rar';
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
            
            if ($folder == 'pengumuman')
            {
                $category = 1;
            }
            else if ($folder == 'tugas')
            {
                $category = 2;
            }
            
            $attach = array('original_file'=>$data['orig_name'],
                            'filename'=>$data['file_name'],
                            'subfolder' => $folder,
                            'category_id' => $category);
            
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
    
    public function del_announcement()
    {
        if ($this->class_model->del_announcement($this->session->userdata('course'),$this->input->post('id'))) 
        {
            echo "1";
        }
        else
        {
            echo "0";
        } 
        
    }
    
    public function edit_announcement($uid,$id)
    {
        if ($this->class_model->is_my_assignment($uid)) 
        {
            $this->create_announcement($uid,$id);    
        }
        else
        {
            redirect('permission_error');
        }
    }
    
    
    public function edit_task($uid,$id)
    {
        if ($this->class_model->is_my_assignment($uid)) 
        {
            $this->create_task($uid,$id);    
        }
        else
        {
            redirect('permission_error');
        }
    }
    
    public function del_attachment()
    {
        if ($this->class_model->del_attachment($this->session->userdata('course'),$this->input->post('id'))) 
        {
            echo "1";
        }
        else
        {
            echo "0";
        } 
        
    }
    
    public function question_response()
    {
        $response = $this->input->post('response');
        $id = $this->input->post('id');
        
        if ($this->class_model->save_question_response($response,$id)) 
        {
            echo "1";
        }
        else
        {
            echo "0";
        }
        
    }
	
	public function mymark($uid){
		 if(! empty($uid)){
            $this->session->set_userdata('course',$uid);
            
            $id = $this->class_model->id_to_uuid($uid);
            
			$res = $this->class_model->get_my_class($this->session->userdata('username'),$id);
			
			if($res){
				$data['absensi'] = array();
				if($res->absensi!=''){
					$data['absensi'] = explode(',',$res->absensi);
				}
				$data['tugas1'] = $res->tugas1;
				$data['tugas2'] = $res->tugas2;
				$data['tugas3'] = $res->tugas3;
				$data['partisipasi'] = $res->partisipasi;	
				$data['classname'] = $res->title;
				$data['classcode'] = $res->code;
			}
			
            $data['id'] = $uid;
			$content['page'] = $this->load->view('kelas/mymark',$data,TRUE);
		}
        
        $this->load->view('dashboard',$content);
	}
	
    public function del_task()
    {
        if ($this->class_model->del_task($this->session->userdata('course'),$this->input->post('id'))) 
        {
            echo "1";
        }
        else
        {
            echo "0";
        } 
        
    }
    
}
