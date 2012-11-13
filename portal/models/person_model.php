<?php
class person_model extends CI_Model {
    

    function __construct()
    {        
        parent::__construct();
    }
	

	function delete_mahasiswa($id)
	{
		return $this->db->delete('mahasiswa',array('nim'=>$id));
	}
	
	function update_mahasiswa($nim,$col)
	{
		$this->db->where('nim',$nim);
		return $this->db->update('mahasiswa',$col);
	}
	
	function add_mahasiswa($col)
	{
		return $this->db->insert('mahasiswa',$col);
	}
	

	function get_list_mahasiswa()
	{
		$sql = 'SELECT * from mahasiswa order by name asc'; 
		$res = $this->db->query($sql);
		return $res;
	}		
	

	function check_nim($nim)
	{
		$result = $this->db->query('SELECT 1 FROM mahasiswa WHERE nim = '.$nim);
		if($result->num_rows())return true;
		return false;
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
	

	function get_list_JQGRID($type,$params = "" , $page = "all")
	{	
		if($type=='staff'){
			$this->db->select("name,nip,phone");
			$this->db->from("staff");
			$this->db->where("group_id IS NOT ","NULL",false);
		}elseif($type=='tutor'){
			$this->db->select("name,phone,email,affiliation,region,major_id,birth,staff_id");
			$this->db->from("staff");
			$this->db->where("major_id IS NOT ","NULL",false);
		}else{
			$this->db->select("name,nim,phone,major,region,status,gender,period,email,birth_date,address_id,religion,marital_status");
			$this->db->from("mahasiswa");
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
				$this->db->limit (5);
				$query = $this->db->get();

		}

		return $query;
	}
	
	function registration_process($data) {
		$insert = populate_form($data, 'mahasiswa_baru');
		
		$insert['birth_date'] = $data['year_birth']."-".$data['month_birth']."-".$data['day_birth'];
		$insert['phone'] = "82".$data['phone'];
		//$insert['reg_code'] = "UTKOR".rand(11283,92341);
		
		$this->db->insert('mahasiswa_baru',$insert);
		
		if ($this->db->affected_rows() > 0) {
			$row = array('id'=>$this->db->insert_id(), 'name'=>$data['name'], 'email'=>$data['email']);
			return $row;
		} else {
			return FALSE;
		}
	}

	function education_list($limit=NULL,$offset=NULL) 
	{
		//$this->db->limit($limit,$offset);
		$query = $this->db->get('education_list');
		
		if($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	
	function total_education_list() 
	{
		$query = $this->db->get('education_list');
		
		return $query->num_rows();
	}
	
	function password_check($table,$password,$username='')
	{
		if (empty($username)) {
			$username = $this->session->userdata('username');
		}
	
		$where = array ('password'=>hashPassword($password),'username'=>$username);
		$query = $this->db->get_where($table,$where);
	
		if ($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}
	
	function change_password($table,$password,$username='') {
		if (empty($username)) {
			$username = $this->session->userdata('username');
		}
		
		$set = array ('password'=>hashPassword($password));
		$where = array ('username'=>$username);
	
		$query = $this->db->update($table,$set,$where);
	
		if ($this->db->affected_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}
	
	function delete_tutor($id)
	{
		return $this->db->delete('staff',array('staff_id'=>$id));
	}
	
	function update_tutor($nim,$col)
	{
		$this->db->where('staff_id',$nim);
		return $this->db->update('staff',$col);
	}
	
	function add_tutor($col)
	{
		return $this->db->insert('staff',$col);
	}
	
}