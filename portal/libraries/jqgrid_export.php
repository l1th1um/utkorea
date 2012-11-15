<?php

class jqgrid_export{

	function exportCurrent($type,$param){
		$ci =& get_instance();	
		$ci->load->model('person_model','person'); 
		query_to_csv($ci->person->get_list_JQGRID($type,$param,"all",TRUE),TRUE,"currentGrid_".$type."_".time().".csv");
	}
}

?>