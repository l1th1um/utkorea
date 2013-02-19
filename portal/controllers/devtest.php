<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Devtest extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
    }
    
    public function index()
	{
			echo '<form method="POST" enctype="multipart/form-data"><input type="file" name="upload" /><input type="submit" /></form>';
			echo file_get_contents($_FILES['upload']['tmp_name']);
	}
	
	public function scribddel($id,$asg_id){
		$this->load->library('scribd',array('api_key'=>$this->config->item('scribd_key'),'secret'=>$this->config->item('scribd_secret')));
		$this->scribd->my_user_id = 'asg_'.$asg_id;
		$res = $this->scribd->delete($id);
	}
}