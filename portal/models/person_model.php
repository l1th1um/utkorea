<?php
class person_model extends CI_Model {
    

    function __construct()
    {        
        parent::__construct();
    }
	
	function get_list_mahasiswa()
	{
		$sql = 'SELECT * from mahasiswa order by name asc'; 
		$res = $this->db->query($sql);
		return $res;
	}		
	
	function get_mahasiswa_sms($select='*', $where = NULL)
	{
		$this->db->distinct();
		$this->db->select($select);
		if (!is_null($where)) {
			$this->db->where_in('nim',$where);
		}
		$this->db->where("phone IS NOT ", "NULL",false); 
		
		$query = $this->db->get('mahasiswa');
		
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}
    
    function get_staff_sms($select='*', $where = NULL)
	{
		$this->db->distinct();
		$this->db->select($select);
		if (!is_null($where)) {
			$this->db->where_in('staff_id',$where);
		}
		$this->db->where("phone IS NOT ", "NULL",false); 
		$query = $this->db->get('staff');
		
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}
    
	
	function save_history_sms($userid,$apimsgid,$phone,$message) {
		$data = array('userid'=>$userid,
					  'apimsgid' => $apimsgid,
					  'phone' => $phone,
					  'message' => $message		
		);
		
		$this->db->insert('history_sms',$data);
		
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function get_sms_history() {
		$this->db->order_by("history_id", "desc"); 
		$query = $this->db->get('history_sms');
		
		if($query->num_rows() > 0) {
			return $query->result();
		}
	}
	
	function get_list_staff_JQGRID($params = "" , $page = "all")
	{	

		$this->db->select("name,staff_id,phone");
		$this->db->from("staff");
        $this->db->where("group_id IS NOT ","NULL",false);
		
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
    
    function get_list_tutor_JQGRID($params = "" , $page = "all")
	{	

		$this->db->select("name,staff_id,phone");
		$this->db->from("staff");
        $this->db->where("major_id IS NOT ","NULL",false);
		
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
    
	
	function get_list_mahasiswa_JQGRID($params = "" , $page = "all")
	{	

		$this->db->select("name,nim,phone");
		$this->db->from("mahasiswa");
		
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

}