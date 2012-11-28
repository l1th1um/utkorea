<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class bendahara extends CI_Controller {

	public function __construct()
    {
        parent::__construct();								
    	//$this->output->enable_profiler(TRUE);
        $this->load->model('person_model','person');
		$this->load->model('finance_model','finance');
    }	
	
	public function index()
	{
	       
	}
	
	public function daftar_ulang() 
	{
		$this->auth->check_auth();
		$data = array();					
		$content['page'] = $this->load->view('bendahara/daftar_ulang',$data,TRUE);
        $this->load->view('dashboard',$content);	
	}
	
	public function getlistJQGRID()
	{
		$page = $this->input->post("page", TRUE );
		if(!$page)$page=1;
		
		$rows = $this->input->post("rows", TRUE );
		if(!$rows)$rows=20;
		
		$sort_by = $this->input->post( "sidx", TRUE );
		if(!$sort_by)$sort_by='id';
		
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
		$data->records = count ($this->finance->get_list_JQGRID($req_param,"all")->result_array());		
		$records = $this->finance->get_list_JQGRID($req_param,"current")->result_array();
		
		$data->total = ceil($data->records /$rows );
		$data->rows = $records;

		echo json_encode ($data );
		exit( 0 );
	}
	
	function verify_daftar_ulang(){
		$this->form_validation->set_rules('id','id','trim|required');
		if($this->form_validation->run())
		{
			// update tabel reregistration
			$this->finance->update_daftar_ulang($this->input->post('id'),array('is_verified'=>1,'verified_by'=>$this->session->userdata('id'),'verified_time'=>date("Y-m-d H:i:s")));
			echo "";
		}else{
			echo validation_errors();
		}
	}
	
	
}