<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pendaftaran extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		//$this->output->enable_profiler(TRUE);	
		$this->load->model('person_model','person');
	}
	
	public function index()	
	{
		//$content['page'] = $this->load->view('humas/sms','',TRUE);
        $this->load->view('pendaftaran/front');
	}
	
	public function registrasi()
	{
		if (isset($_POST['submitRegBtn'])) {
			$this->_validate_registration();
			
			if ($this->form_validation->run() == FALSE) {
				$data['message'] = validation_errors();
				$content['page'] = $this->load->view('pendaftaran/form',$data,TRUE);
			} else {
				if ( ($reg_code = $this->registration_process($_POST)) == FALSE) {
					$data['message'] = $message;
					$content['page'] = $this->load->view('pendaftaran/form',$data,TRUE);
				} else {
					$data['message'] = $message;
					$content['page'] = $this->load->view('pendaftaran/success',$data,TRUE);
				}	
			}
			
		} else {
			$content['page'] = $this->load->view('pendaftaran/form','',TRUE);
		}		
		
		$this->load->view('pendaftaran/registrasi',$content);
	}
	
	public function do_upload($field_name)
	{
		$config['upload_path'] = 'assets/uploads/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = '10000';
		$config['max_width'] = '10240';
		$config['max_height'] = '76800';
		$config['encrypt_name'] = TRUE;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload($field_name))
		{
			//$error = array('error' => $this->upload->display_errors());
			//print_r($error);
			echo $this->upload->display_errors();
		}
		else
		{
			$data = $this->upload->data();
			$name = $data['file_name'];
			
			$config['new_image'] = $config['upload_path'];
            $config['image_library'] = 'gd2';
            $config['source_image'] = $config['upload_path'] . $name;
            //$config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 800;
			$config['height'] = 600;
            
			/*$this->load->library('image_lib', $config);

            $this->image_lib->resize();*/
			$this->image_lib->initialize($config);                           
            $this->image_lib->resize();
			
			$config['create_thumb'] = TRUE;
            $config['width'] = 100;
            $config['height'] = 100;
            $config['maintain_ratio'] = TRUE;
            $config['thumb_marker'] = '_thumb';
                
            $this->image_lib->initialize($config); 
                
            $this->image_lib->resize(); 

            $thumb_file = $data['raw_name']."_thumb".$data['file_ext'];
			$info = new stdClass();
            
            $info->name = $name;
            $info->size = $data['file_size'];
            $info->type = $data['file_type'];
			$info->url = $config['upload_path'] . "assets/uploads" . $name;
            $info->thumbnail_url = base_url().$config['upload_path'] . $thumb_file; 
            $info->delete_url = $config['upload_path'] . $name;
			
            $info->delete_type = 'DELETE';
			
			 if (IS_AJAX) { 
                echo json_encode(array($info));
            } else {
                $file_data['upload_data'] = $this->upload->data();
                echo json_encode(array($info));
            }
		}
	}
	
	public function registration_process($data) {
		return $this->person->registration_process($data);
	}
	
	public function _validate_registration()
	{
		$this->form_validation->set_rules('name','Nama','trim|required|min_length[4]');
		$this->form_validation->set_rules('ktp','KTP','trim|required|min_length[10]');
		$this->form_validation->set_rules('passport','Passport','trim|required|min_length[5]');
		$this->form_validation->set_rules('ktp','KTP','trim|required|min_length[10]');
		$this->form_validation->set_rules('place_of_birth','Tempat Lahir','trim|required|min_length[3]');
		$this->form_validation->set_rules('address_id','Alamat di Indonesia','trim|required|min_length[10]');
		$this->form_validation->set_rules('address_kr','Alamat di Korea','trim|required|min_length[10]');
		$this->form_validation->set_rules('phone','No Telepon','trim|required|min_length[8]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('last_education_major','Kode Jurusan','trim|required');
		$this->form_validation->set_rules('mother_name','Kode Jurusan','trim|required');
	
		$delimiter_prefix = "<div class='error'>";
		$delimiter_suffix = "</div>";
	
		$this->form_validation->set_error_delimiters($delimiter_prefix,$delimiter_suffix);
	}
	
	public function edu_list($page = 1)
	{
		/*
		$this->load->library('pagination');
		$config['base_url'] = base_url().'pendaftaran/edu_list/';
		$config['total_rows'] = $this->person->total_education_list();
		$config['per_page'] = 30;
		$config['anchor_class'] = ' class="pagination" ';		
		$limit = $config['per_page'];
		$offset = ( intval($page) - 1 ) *  $limit;
		$this->pagination->initialize($config); 
		$data['links'] = $this->pagination->create_links();
		
		$data['list'] = $this->person->education_list($limit,$offset);
		*/
		
		$data['list'] = $this->person->education_list();
						
		$this->load->view('pendaftaran/edu_list',$data);
	}
	
}