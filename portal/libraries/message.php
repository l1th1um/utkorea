<?php

class message{
	
	function message()
    {   
		$this->CI =& get_instance();	
		$this->CI->auth->check_auth();
    }
	
	function post_to_member($to,$from,$message){
		$this->CI->message_model->insert_message(array('to'=>$to,'from'=>$from,'message'=>htmlentities($message)));
	}
	
	function get_unread_message($username)
	{
		return $this->CI->message_model->get_user_unread_message($username);		
	}
	
	function delete_message($id)
	{
		
			$logs_data = array('activity' => 'login',
		  					 'result' => $this->CI->message_model->delete_message($id),
							 'remarks' => 'Deleting Message ID '.implode(",",$id),
							 'user_agent' => check_user_agent());
							 
		 	insert_logs($logs_data);			
			
		
	}
}

?>