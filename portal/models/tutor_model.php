<?php
class tutor_model extends CI_Model {
    

    function __construct()
    {        
        parent::__construct();
    }
	
	function course_list($major)
	{
		$this->db->where('major',$major);
		$this->db->order_by("course_id asc,semester asc");
		$query = $this->db->get('courses');
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} 
	}
	
	function tutor_by_major($major) {
		$this->db->select('staff_id,name,');
		$this->db->where('major_id',$major);
		
		$query = $this->db->get('staff');
		
		if ($query->num_rows() > 0) {
			$data = array();
			
			foreach($query->result() as $row) {
				$data[$row->staff_id] = $row->name;
			}
			
			return $data;
		}
	}
	
	function save_assignment($staff_id, $course_id) 
	{
		$where = array('course_id'=>$course_id,'time_period'=>setting_val('time_period'));
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
}