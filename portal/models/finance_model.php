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
		
		if ($this->db->affected_rows() > 0) return TRUE; else return FALSE;
	}
	
	function get_list_JQGRID($params = "" , $page = "all",$is_export=false)
	{	
	
		$this->db->select('id, IF( nim <100000, CONCAT(  "UTKOR", nim ) , nim ) as nim,
						   account_no,DATE_FORMAT(payment_date,"%e %M %Y") as payment_date,bank_name,sender_name,
						   verified_by,verified_time, is_verified,IF(is_verified = 1,receipt_sent,"2"  ) as receipt_sent',FALSE);
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
		
		if ($this->db->affected_rows() > 0) return TRUE; else return FALSE;
	}
	
	public function change_receipt_status($id,$table){
		$this->db->where("id",$id);
		$this->db->update($table,array('receipt_sent' => '1'));
		
		if ($this->db->affected_rows() > 0) return TRUE; else return FALSE;
	}
	
	public function get_userid_reregistration($id) {
		$this->db->select('nim');
		
		$query = $this->db->get_where('reregistration',array('id'=>$id));
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->nim;
		} else {
			return FALSE;
		}
	}
	
	public function save_receipt($data) {
		$this->db->select_max('receipt_order');
		$this->db->where('receipt_period',$data['receipt_period']);
		$query = $this->db->get('receipt');
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$receipt_order = $row->receipt_order + 1;	
		} else {
			$receipt_order = 1;
		}
		
		$data = array('receipt_order' => $receipt_order,
					  'receipt_period'	=> $data['receipt_period'],
					  'receipt_status'	=> $data['receipt_status'],
					  'remarks'	=> $data['remarks'],
					  'subject'	=> $data['subject'],
					 );
		$this->db->insert('receipt',$data);
		
		if ($this->db->affected_rows() > 0 ) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}
	
	function get_rekap_mahasiswa_lama($params = "" , $page = "all",$type="all")
	{
		$this->db->select('a.nim,b.is_verified as semesterpayment,c.is_verified as registrationpayment');
		$this->db->from('mahasiswa a');
		$this->db->join('payment b', 'a.nim = b.nim','left');
		$this->db->join('reregistration c', 'a.nim = c.nim','left');
		if($type==1){
			$this->db->where('b.is_verified = 1 AND c.is_verified = 1');
		}else if($type==2){
			$this->db->where('c.is_verified = 1 AND (b.is_verified = 0 OR b.is_verified IS NULL)');
		}else if($type==3){
			$this->db->where('c.is_verified = 0');
		}
		
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