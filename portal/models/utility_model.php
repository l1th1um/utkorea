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
	

}