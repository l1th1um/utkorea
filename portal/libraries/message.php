<?php

class message{
	
	function message()
    {   
		$this->CI =& get_instance();	
    }
	
	function post_to_member($to,$from,$message){
		$this->CI->message_model->insert_message(array('to'=>$to,'from'=>$from,'message'=>htmlentities($message)));
	}
	
	function get_unread_message($username)
	{
		return $this->CI->message_model->get_user_unread_message($username);		
	}
}

?>