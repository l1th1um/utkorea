<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pendaftaran extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		//$this->output->enable_profiler(TRUE);		
	}
	
	public function index()	
	{
		//$content['page'] = $this->load->view('humas/sms','',TRUE);
        $this->load->view('pendaftaran/front');
	}
	
	public function registrasi()
	{
		//$content['page'] = $this->load->view('humas/sms','',TRUE);
		$this->load->view('pendaftaran/registrasi');
	}
}