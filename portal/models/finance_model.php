<?php
class finance_model extends CI_Model {

	function __construct()
    {        
        parent::__construct();
    }

	function insert_konfirmasi_pembayaran($data){
		$affected = $this->db->insert('reregistration',$data);
		
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();	
		} else {
			return FALSE;
		}
		
	}
	
	function update_daftar_ulang($id,$data){
		$this->db->where("id",$id);
		$this->db->update('reregistration',$data);
	}
	
	function get_list_JQGRID($params = "" , $page = "all",$is_export=false)
	{	
	
		$this->db->select('id,nim,account_no,payment_date,bank_name,sender_name,verified_by,verified_time,is_verified');
		$this->db->from('reregistration');		
		
		if (!empty($params))		{			
			if ( (($params["rows"]*$params["page"]) >= 0 && $params ["rows"] > 0))
			{
				$ops = array (
							"eq" => "=",
							"ne" => "<>",
							"lt" => "<",
							"le" => "<=",
							"gt" => ">",
							"ge" => ">="
				);										
				
				if(!empty($params['search_field'])){
					if($params['search_operator']=='cn'||$params['search_operator']=='nc'){
						if($params['search_operator']=='cn'){
							$this->db->like($params['search_field'],$params['search_str']);
						}else{
							$this->db->not_like($params['search_field'],$params['search_str']);
						}
					}else{
						$this->db->where ($params['search_field'].' '.$params['search_operator'], $params['search_str']);
					}
					
				}
				
				$this->db->order_by($params['sort_by'], $params ["sort_direction"] );


				if ($page != "all")
				{
					$this->db->limit ($params ["rows"], $params ["rows"] *  ($params ["page"] - 1) );
				}

				$query = $this->db->get();
				

			}
		}
		else
		{			
				$this->db->limit (5);
				$query = $this->db->get();

		}

		return $query;
	}

	function check_payment_status($nim,$table='reregistration') 
	{
		$this->db->select('verified_by');
		$query = $this->db->get_where($table,array('nim' => $nim));
		
		if ( $query->num_rows() > 0 ) 
		{
			$row = $query->row();
			
			if (empty($row->verified_by)) return 1;
			else return 2;
		} else {
			return 0;
		} 
	}
	
	function save_payment($data){
		$affected = $this->db->insert('payment',$data);
		
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();	
		} else {
			return FALSE;
		}
		
	}
	
	function get_payment_list($params = "" , $page = "all",$is_export=false)
	{	
	
		$this->db->select('id,nim,account_no,payment_date,bank_name,sender_name,amount,verified_by,verified_time,is_verified');
		$this->db->from('payment');		
		
		if (!empty($params))		{			
			if ( (($params["rows"]*$params["page"]) >= 0 && $params ["rows"] > 0))
			{
				$ops = array (
							"eq" => "=",
							"ne" => "<>",
							"lt" => "<",
							"le" => "<=",
							"gt" => ">",
							"ge" => ">="
				);										
				
				if(!empty($params['search_field'])){
					if($params['search_operator']=='cn'||$params['search_operator']=='nc'){
						if($params['search_operator']=='cn'){
							$this->db->like($params['search_field'],$params['search_str']);
						}else{
							$this->db->not_like($params['search_field'],$params['search_str']);
						}
					}else{
						$this->db->where ($params['search_field'].' '.$params['search_operator'], $params['search_str']);
					}
					
				}
				
				$this->db->order_by($params['sort_by'], $params ["sort_direction"] );


				if ($page != "all")
				{
					$this->db->limit ($params ["rows"], $params ["rows"] *  ($params ["page"] - 1) );
				}

				$query = $this->db->get();
				

			}
		}
		else
		{			
				$this->db->limit (25);
				$query = $this->db->get();

		}

		return $query;
	}

	function update_payment($id,$data){
		$this->db->where("id",$id);
		$this->db->update('payment',$data);
	}
}
?>