<?php
class finance_model extends CI_Model {

	function __construct()
    {        
        parent::__construct();
    }

	function insert_konfirmasi_pembayaran($data){
		$affected = $this->db->insert('reregistration',$data);
		return $this->db->insert_id();
	}
}
?>