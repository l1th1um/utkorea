<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class kelas extends CI_Controller {

	public function __construct()
    {
        parent::__construct();								
		//$this->output->enable_profiler(TRUE);
        $this->load->model('person_model','person');
		$this->load->model('tutor_model');
		$this->load->library('scribd',array('api_key'=>$this->config->item('scribd_key'),'secret'=>$this->config->item('scribd_secret')));
    }	
	
	public function index($id=''){
		
		if($id!=''){			
			$class_settings = $this->tutor_model->get_class_by_id($id);
			if($class_settings){				
				$this->scribd->my_user_id = 'assignment_'.$id;		
				$datas = $this->scribd->getList(array('api_key'=>$this->config->item('scribd_key')));			
				$data['file'] = $datas;					
			}				
			$data['class_settings'] = $class_settings;
			
			$content['page'] = $this->load->view('kelas/main',$data,TRUE);
		}else{
			//check registration or/and get list
			if(is_numeric($this->session->userdata('username'))){
				$res = $this->tutor_model->get_list_classes_for_student($this->session->userdata('username'));
				if(!$res){
					$this->register_class();					
				}else{
					$data['list'] = $res;					
				}
			}else{
				$res = $this->tutor_model->get_list_classes_for_tutor($this->session->userdata('id'));
				$data['list'] = $res;				
			}	
			$content['page'] = $this->load->view('kelas/list',$data,TRUE);
		}				
		
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
		
		$content['page'] = $this->load->view('kelas/register',$data,TRUE);
        $this->load->view('dashboard',$content);
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
	
	
	
}

