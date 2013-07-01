<?php

class jqgrid_export{

	function exportCurrent($type,$param){
		$ci =& get_instance();	
		$ci->load->model('person_model','person'); 
		query_to_csv($ci->person->get_list_JQGRID($type,$param,"all",TRUE),TRUE,"currentGrid_".$type."_".time().".csv");
	}
	
	function exportCurrent_rekap_maba($param){
		$ci =& get_instance();
		$ci->load->model('finance_model','finance');
		query_to_csv($ci->finance->rekap_maba_bendahara_kemahasiswaan($param,"all",TRUE),TRUE,"rekap_maba_currentGrid_".time().".csv"); 
	}
}

?>