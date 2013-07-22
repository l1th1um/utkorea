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
	
		$this->db->select('a.id, a.period, IF( a.nim <100000, CONCAT(  "UTKOR", a.nim ) , a.nim ) as nim,
						   a.account_no,DATE_FORMAT(a.payment_date,"%e %M %Y") as payment_date,a.bank_name,a.sender_name,
						   a.verified_by,a.verified_time, a.is_verified,IF(a.is_verified = 1,a.receipt_sent,"2"  ) as receipt_sent,b.entry_period',FALSE);
		$this->db->from('reregistration a');	
		$this->db->join('mahasiswa b','a.nim = b.nim','left');	
		
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

	function check_payment_status($nim,$table='reregistration',$period) 
	{
		$this->db->select('verified_by');
		$query = $this->db->get_where($table,array('nim' => $nim, 'period' => $period ));
		
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
	
		$this->db->select('a.id,a.nim,a.period,b.entry_period,a.account_no,a.payment_date,a.bank_name,a.sender_name,a.amount,a.verified_by,
                            a.verified_time,a.is_verified,IF(a.is_verified = 1,a.receipt_sent,"2"  ) as receipt_sent ', FALSE);
		$this->db->from('payment a');		
		$this->db->join('mahasiswa b','a.nim = b.nim','left');
		
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
	
	public function get_userid_payment($id,$table = 'reregistration') {
		$this->db->select('nim');
		
		$query = $this->db->get_where($table,array('id'=>$id));
		
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
	
	function get_rekap_mahasiswa_lama($params = "" , $page = "all",$type="all",$period = 20132)
	{
		$this->db->select('a.nim,b.is_verified as semesterpayment,c.is_verified as registrationpayment');
		$this->db->from('mahasiswa a');
		$this->db->where('a.period',$period);
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

	public function get_my_transport($id){
		$this->db->from('transport');
		$this->db->where('staff_id',$id);
		$this->db->order_by('created','DESC');
		$res = $this->db->get();
		if($res->num_rows()>0){
			return $res;
		}else{
			return false;
		}
	}
	
	public function save_transport($data){
		return $this->db->insert('transport',$data);
	}

	function get_transport_list($params = "" , $page = "all",$is_export=false)
	{	
	
		$this->db->select('*');
		$this->db->from('transport');
		$this->db->join('staff','transport.staff_id = staff.staff_id');		
		
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

	function update_transport($id,$data){
		$this->db->where("id",$id);
		$this->db->update('transport',$data);
		
		if ($this->db->affected_rows() > 0) return TRUE; else return FALSE;
	}
	
	function get_last_transport($staff_id){
		$this->db->where('staff_id',$staff_id);
		$this->db->order_by('created','desc');
		$this->db->limit(1);
		$res = $this->db->get('transport');
		if($res->num_rows()>0){
			return $res->row();
		}else{
			return false;
		}
	}

	function rekap_maba_bendahara_kemahasiswaan($params = "" , $page = "all",$is_export=false)
	{
		if(!$is_export){
			$this->db->select('a.reg_code,a.name,a.verified,b.is_verified as duver,c.is_verified as bsver,c.amount ');
		}else{
			$this->db->select('a.*,b.is_verified as duver,c.is_verified as bsver,c.amount ');
		}
		
		$this->db->from('mahasiswa_baru a');
		$this->db->join('reregistration b','a.reg_code = b.nim','left');
		$this->db->join('payment c','a.reg_code = c.nim','left');
		$this->db->group_by('reg_code');
		
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