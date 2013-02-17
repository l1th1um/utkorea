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
}