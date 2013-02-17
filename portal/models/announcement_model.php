<?php
class announcement_model extends CI_Model {
    

    function __construct()
    {        
        parent::__construct();
    }
	
	public function get_recent_news() {
		$this->db->order_by('created_time','desc');
		$this->db->where('publish','1');
		$query = $this->db->get('announcements',10,0);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
	public function save_announcement($data) {
		$insert = populate_form($data, 'announcements');
		$this->db->set('created_time', 'now()', FALSE);
		
		$query = $this->db->insert('announcements',$insert);
		
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function display($id) {
		$this->db->where('id',$id);
		$this->db->where('publish','1');
		$query = $this->db->get('announcements');
		
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}
    
    public function display_announce_class($assignment_id,$limit=null) {
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
    
    public function list_question($id,$limit=null) {
        $this->db->where('assignment_id',$id);
		$this->db->order_by('id','desc');
        if (!empty($limit))
            $this->db->limit($limit);
		$query = $this->db->get('question');
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}       
    }
    
     public function save_question($data,$id) {
		$insert = populate_form($data, 'question');
		$this->db->set('created', 'now()', FALSE);
        $this->db->set('user_id',$this->session->userdata('username'));
        $this->db->set('assignment_id',$id);
		
		$query = $this->db->insert('question',$insert);
		
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
    
    public function display_detail_question($id) {
		$this->db->where('id',$id);		
        $query = $this->db->get('question');
		
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}
    
    public function list_task($id,$limit=null) {
        $this->db->where('assignment_id',$id);
		$this->db->order_by('id','desc');
        if (!empty($limit))
            $this->db->limit($limit);
		$query = $this->db->get('task');
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}       
    }
}