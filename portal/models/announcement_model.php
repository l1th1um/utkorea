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
}