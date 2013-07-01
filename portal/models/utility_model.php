<?php
class utility_model extends CI_Model {
    

    function __construct()
    {        
        parent::__construct();
    }
	
	function get_Table($table,$where="",$select="*")
	{
		if($select!="*"){
			$this->db->select($select);}
		if($where!=""){
			$this->db->where($where);}
		return $this->db->get($table);		
	}	
	
	function find_Receipt($nim,$period,$type){
		$this->db->like('subject',$nim,'both');
		$this->db->where('receipt_period',$period);
		if($type=='du'){
			$this->db->not_like('remarks','Biaya Studi','both');
		}else{
			$this->db->like('remarks','Biaya Studi','both');
		}
		return $this->db->get('receipt');
	}
	
	function get_Table_like($table,$field,$like,$wildcard='both'){
		$this->db->like($field,$like,$wildcard);
		return $this->db->get($table);
		
	}	
	

}