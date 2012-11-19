<?php
	
	function edu_list($page = 1)
	{
		$ci =& get_instance();	
		$ci->load->model('person_model','person'); 
		return $ci->person->education_list();								
	}
?>