<?php
class message_model extends CI_Model {

	function __construct()
    {        
        parent::__construct();
    }

	function insert_message($data){
		return $this->db->insert('message',$data);
	}
	
	function get_user_unread_message($username)
	{
		$this->db->where('is_read',0);
		$this->db->where('to',$username);
		$result = $this->db->get('message');
		if($result->num_rows()>0)
		{
			return $result;
		}else{
			return '';
		}
	}
	
	function delete_message($id){
		$this->db->where_in('id',$id);
		$this->db->update('message',array('is_read'=>99));
	}
	
	function get_user_inboxJQGRID($params = "" , $page = "all",$username)
	{	
	
		$this->db->select('message.from,mahasiswa.name as mname,staff.name as sname,message.timestamp,message.id,message.is_read');
		$this->db->from('message');	
		$this->db->join('mahasiswa', 'mahasiswa.nim = message.from','left');
		$this->db->join('staff', 'staff.staff_id = message.from','left');	
		$this->db->where('to',$username);
		$this->db->where('is_read !=',99);
		
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
}
?>