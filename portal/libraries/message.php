<?php

class message{
	
	function message()
    {   
		$this->CI =& get_instance();	
		
    }	
	
	function set_read($id){
		
		$logs_data = array('activity' => 'read message',
		  					 'result' => $this->CI->message_model->update_message($id,array('is_read'=>1)),
							 'remarks' => $id,
							 'user_agent' => check_user_agent());
							 
		 insert_logs($logs_data);
	}
	
	function post_to_member($to,$from,$message){
		
		    $logs_data = array('activity' => 'write message',
		  					 'result' => $this->CI->message_model->insert_message(array('to'=>$to,'from'=>$from,'message'=>htmlentities($message))),
							 'remarks' => get_last_insert_id(),
							 'user_agent' => check_user_agent());
							 
		 	insert_logs($logs_data);	
	}
	
	function get_unread_message($username,$is_system_only = false)
	{
		return $this->CI->message_model->get_user_unread_message($username,$is_system_only);		
	}
	
	function delete_message($id)
	{
		
			$logs_data = array('activity' => 'delete message',
		  					 'result' => $this->CI->message_model->delete_message($id),
							 'remarks' => 'Deleting Message ID '.implode(",",$id),
							 'user_agent' => check_user_agent());
							 
		 	insert_logs($logs_data);			
			
		
	}
	
	function validate_and_get($id)
	{
		
		$data = $this->CI->message_model->get_message_by_id($id);
		if($this->CI->session->userdata('username')==$data->to){
			return $data;
		}else{
			return false;
		}
	}
}

?>