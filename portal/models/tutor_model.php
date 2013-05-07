<?php
class tutor_model extends CI_Model {
    

    function __construct()
    {        
        parent::__construct();
    }
	
	function get_current_class_composition_list($time_period = ''){
		if($time_period == ''){
			$time_period = get_settings('time_period');
		}
		
		$this->db->select('*,a.region as sregion,a.id as sid');
		$this->db->from('assignment a');
		$this->db->join('courses c','a.course_id = c.course_id');
		$this->db->join('staff s','a.staff_id = s.staff_id');
		$this->db->where('a.time_period',$time_period);
		
		$this->db->order_by('sregion','ASC');
		$this->db->order_by('title','ASC');
		$this->db->order_by('name','ASC');
		
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query;
		}
		
	}
	
	function course_list($major,$region)
	{
		/*
        SELECT c.*,a.staff_id,a.region FROM utkor_courses c
        left JOIN utkor_assignment a
        ON c.course_id = a.course_id and time_period = '20131' AND region = '1'
        WHERE major = '54'
        */
        $assign_param = 'c.course_id = a.course_id ';
        $assign_param .= 'and time_period = "'.get_settings('time_period').'"';
        $assign_param .= 'AND region = '.$region;
        
        $this->db->select('c.*,a.staff_id,a.region');
        $this->db->from('courses c');
        $this->db->join('assignment a', $assign_param,'left');

        $this->db->where('c.major',$major);
        $this->db->group_by('c.course_id');
		//$this->db->order_by("course_id asc,semester asc");
		$query = $this->db->get('courses');
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} 
	}
	
	function tutor_by_major($major) {
		$this->db->select('staff_id,name,');
		$this->db->where('major_id',$major);
		$this->db->order_by('name');
        
		$query = $this->db->get('staff');
		
		if ($query->num_rows() > 0) {
			$data = array();
			
			foreach($query->result() as $row) {
				$data[$row->staff_id] = $row->name;
			}
			
			return $data;
		}
	}
	
	function save_assignment($staff_id, $course_id,$region) 
	{
		$where = array('course_id'=>$course_id,
                       'time_period'=>setting_val('time_period'),
                       'region'=>$region);
        $this->db->set('assignment_uid', 'uuid()', FALSE);
        
		$query = $this->db->get_where('assignment',$where);	
		
        
		$data = array('staff_id'=>$staff_id);
		
		if ($query->num_rows() > 0) {
			//update
			$this->db->where($where);
			$this->db->update('assignment',$data);
		} else {
			//insert
			$data = $data + $where;
			$this->db->insert('assignment',$data);
		}
		
		
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}		
	}
	
	function get_available_class($major,$semester,$region)
	{
			$this->db->select('*,a.id as asgmntid');
			$this->db->from('assignment a');
			$this->db->join('settings c','a.time_period = c.time_period');
			$this->db->join('staff d','a.staff_id = d.staff_id');
			if($semester<7){
				$this->db->join('courses b','a.course_id = b.course_id');	
				$this->db->where('b.semester',$semester);
			}else{
				$this->db->join('courses b','a.course_id = b.course_id');				
			}			
			
			
			$this->db->where('b.major',$major);
			if($region==1||$region=='K'||$region=='G'||$region=='A'){
				$this->db->where('a.region',1);
			}else{
				$this->db->where('a.region',2);
			}
			
			$res = $this->db->get();
			if($res->num_rows()>0){
				return $res;
			}else{
				return false;
			}	

	}
	
	function save_class($nim,$classid)
	{
		$data = array();		
		if(!is_array($classid)){
					$classid = explode(",",$classid);
		}
		
		foreach($classid as $row){
			$data[] = array(
				'id_assignment'=>$row,
				'id_student'=>$nim
			);
		}
		return $this->db->insert_batch('class', $data);	 
		
	}

	function get_class_by_tutor($staff_id){
		$this->db->from('assignment a');
		$this->db->join('courses b','a.course_id = b.course_id');
		$this->db->where('a.staff_id',$staff_id);
		$res = $this->db->get();
        if($res->num_rows() > 0){
			return $res;
		}else{
			return false;
		}
	}
	
	function get_class_by_id($id){
		$this->db->from('assignment a');
		$this->db->join('courses b','a.course_id = b.course_id');
		$this->db->join('major m','m.major_id = b.major');
		$this->db->join('staff s','s.staff_id = a.staff_id');
		$this->db->where('a.id',$id);
		$res = $this->db->get();
		if($res->num_rows()>0){
			return $res->row();
		}else{
			return false;
		}
	}
	
	function update_batch_assignment($data,$filter){
		return $this->db->update_batch('assignment', $data, $filter); 
	}
	
	function get_list_classes_for_student($nim){
		$this->db->select('*,b.assignment_uid as asgnmtid,b.id as realid');
		$this->db->from('class a');
		$this->db->join('assignment b','a.id_assignment = b.id');
		$this->db->join('settings d','b.time_period = d.time_period');
		$this->db->join('courses c','b.course_id = c.course_id');
		$this->db->join('staff e','b.staff_id = e.staff_id');
		$this->db->where('a.id_student',$nim);
		$res = $this->db->get();
		if($res->num_rows()>0){
			return $res;
		}else{
			return false;
		}		
	}

	function get_list_classes_for_tutor($staff_id){
		$this->db->select('*,b.assignment_uid as asgnmtid,b.id as realid');		
		$this->db->from('assignment b');
		$this->db->join('settings d','b.time_period = d.time_period');
		$this->db->join('courses c','b.course_id = c.course_id');
		$this->db->join('staff e','b.staff_id = e.staff_id');
		
		$this->db->where('b.staff_id',$staff_id);
		$res = $this->db->get();
		if($res->num_rows()>0){
			return $res;
		}else{
			return false;
		}		
	}
	
	function get_tutor_student($staff_id){
		$this->db->from('class a');
		$this->db->join('assignment b','a.id_assignment = b.id');
		$this->db->join('settings d','b.time_period = d.time_period');
		$this->db->join('courses c','b.course_id = c.course_id');
		$this->db->join('mahasiswa m','m.nim = a.id_student');
		
		$this->db->where('b.staff_id',$staff_id);
		
		$this->db->order_by('a.id_assignment','asc');
		$res = $this->db->get();
		if($res->num_rows()>0){
			return $res;
		}else{
			return false;
		}	
	}
	
	function update_absnilai($data){
		$this->db->where('id_assignment',$data['id_assignment']);
		$this->db->where('id_student',$data['id_student']);
		unset($data['id_assignment']);
		unset($data['id_student']);
		$this->db->update('class',$data);
	}
	
	function get_list_JQGRID($type,$params = "" , $page = "all",$is_export=false,$assignment_id="")
	{	
		if($type=='pengumuman_kelas'){			
			$this->db->from("announce_class");					
		}
		
		if($assignment_id!=""){
			$this->db->where('assignment_id',$assignment_id);
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

	function delete_pengumuman_kelas($id)
	{
		return $this->db->delete('announce_class',array('id'=>$id));
	}
	
	function update_pengumuman_kelas($id,$col)
	{
		$this->db->where('id',$id);
		return $this->db->update('announce_class',$col);
	}
	
	function add_pengumuman_kelas($col)
	{
		return $this->db->insert('announce_class',$col);
	}

	function get_valid_pengumuman($id)
	{
		$this->db->where('until >=','now()',FALSE);
		$this->db->where('assignment_id',$id);
		return $this->db->get('announce_class');
	}
	
	function get_active_tutor(){
		$this->db->from('staff');
		$this->db->join('major','staff.major_id = major.major_id');
		$this->db->where('staff.status','Aktif');
		return $this->db->get();
	}
	
	function get_tutor($id){
		$this->db->from('staff');
		$this->db->where('staff_id',$id);
		$res = $this->db->get();
		
		if($res->num_rows()>0){
			return $res->row_array();
		}else{
			return false;
		}
	}
	
	function get_assignment($time_period){
		$this->db->from('assignment a');
		$this->db->join('courses b','a.course_id = b.course_id');
		$this->db->where('a.time_period',$time_period);
		
		$res = $this->db->get();
		if($res->num_rows()>0){
			return $res;
		}else{
			return false;
		}
	}
}