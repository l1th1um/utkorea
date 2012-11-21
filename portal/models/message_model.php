<?php
class message_model extends CI_Model {

	function __construct()
    {        
        parent::__construct();
    }

	function insert_message($data){
		return $this->db->insert('message',$data);
	}
	
	function get_user_unread_message($username)
	{
		$this->db->where('is_read',0);
		$this->db->where('to',$username);
		$result = $this->db->get('message');
		if($result->num_rows()>0)
		{
			return $result;
		}else{
			return '';
		}
	}
}
?>