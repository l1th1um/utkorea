<?php
class announcement_model extends CI_Model {
    

    function __construct()
    {        
        parent::__construct();
    }
	
	public function get_recent_news() {
		$this->db->order_by('publish_date','desc');
		$query = $this->db->get('announcements',10,0);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
}