<?php
class class_model extends CI_Model {
    

    function __construct()
    {        
        parent::__construct();
    }
	
	public function save_attachment($data) {
	   $this->db->set('uuid', 'uuid()', FALSE);						
       $this->db->set('upload_time', 'now()', FALSE);
	   $this->db->insert('attachment',$data);
		
		if ($this->db->affected_rows() > 0) {
			$uuid = id_to_uuid($this->db->insert_id(),'attach_id','uuid','attachment');
            return $uuid;			
		} else {
			return FALSE;
		}
        
	}
    
    public function get_attachment($uid) {
	   $query = $this->db->get_where('attachment',array('uuid' => $uid));
		
		if ($query->num_rows() > 0) {
			return $query->row();			
		} else {
			return FALSE;
		}
	}
    
    public function announce_class_detail($id) {
		$this->db->where('id',$id);		
        $query = $this->db->get('announce_class');
		
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}
    
    public function id_to_uuid($uuid)
    {
        $this->db->select('id');
    	$this->db->where('assignment_uid',$uuid);
        $query = $this->db->get('assignment');    
            
        if ($query->num_rows() > 0) {
        	$row = $query->row(); 
        	return $row->id;	
        }
    }
    
    public function save_announce_class($data,$id) {
		$insert = populate_form($data, 'announce_class');
		$this->db->set('created', 'now()', FALSE);
        $this->db->set('assignment_id',$id);        
		
		$query = $this->db->insert('announce_class',$insert);
		
		if ($this->db->affected_rows() > 0) 
        {
			return true;
		} 
        else 
        {
			return false;
		}
	}
}