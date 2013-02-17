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
    
    public function get_attachment($id) {
	   $query = $this->db->get_where('attachment',array('announcement_id' => $id));
		
		if ($query->num_rows() > 0) {
			return $query->row();			
		} else {
			return FALSE;
		}
	}
    
    public function get_attachment_uid($id) {
	   $query = $this->db->get_where('attachment',array('uuid' => $id));
		
		if ($query->num_rows() > 0) {
			return $query->row();			
		} else {
			return FALSE;
		}
	}
    
    public function announce_class_detail($assignment_id,$id) {
		$this->db->where('assignment_id',$assignment_id);
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
    
    public function save_announce_class($data,$id,$update) {
		$insert = populate_form($data, 'announce_class');
        
        if ($update == false) 
        {
            $this->db->set('created', 'now()', FALSE);
            $this->db->set('assignment_id',$id);        
    		
    		$query = $this->db->insert('announce_class',$insert);    
        }
        else
        {
            $where = array('assignment_id' =>$id,'id'=>$update);
            $this->db->where($where);
            $query = $this->db->update('announce_class',$insert);
        }
		
		
		if ($this->db->affected_rows() > 0) 
        {
			if (! empty($data['attach_uid'])) {
			     $data_announcement = array('announcement_id' => $this->db->insert_id());
                 $this->db->where('uuid', $data['attach_uid']);
			     $this->db->update('attachment',$data_announcement);
			}
            
            return true;
		} 
        else 
        {
			return false;
		}
	}
    
    public function list_announce_class($assignment_id,$limit=null) {
		$this->db->where('assignment_id',$assignment_id);
		$this->db->order_by('id','desc');
        if (!empty($limit))
            $this->db->limit($limit);
		$query = $this->db->get('announce_class');
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function del_announcement($id,$staff_id)
    {
        $where = array('id' => $id,
                        'staff_id' => $staff_id);
                        
        $query = $this->db->delete('announce_class', $where);
        if ($this->db->affected_rows() > 0) 
        {
			return true;
		} 
        else 
        {
			return false;
		}
    }
    
    public function del_attachment($id)
    {
        $where = array('uuid' => $id);
                        
        $query = $this->db->delete('attachment', $where);
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