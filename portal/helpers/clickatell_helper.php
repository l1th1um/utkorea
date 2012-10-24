<?php

function get_balance() 
{
	$CI =& get_instance();
	$url = "http://api.clickatell.com/http/getbalance?api_id=".$CI->config->item('clickatell_api')."&user=".$CI->config->item('clickatell_username')."&password=".$CI->config->item('clickatell_password');
	$balance = file($url);
	return $balance[0];
}

function send_message($to,$message) {	
	$CI =& get_instance();
    $baseurl ="https://api.clickatell.com/";
 
    $text = urlencode($message);
    $to = $to;
 
    $url = $baseurl."http/auth?user=".$CI->config->item('clickatell_username')."&password=".$CI->config->item('clickatell_password')."&api_id=".$CI->config->item('clickatell_api');
    
	
    $ret = file($url);
 
    $sess = explode(":",$ret[0]);
    if ($sess[0] == "OK") { 
        $sess_id = trim($sess[1]); // remove any whitespace
        $url = $baseurl."http/sendmsg?session_id=".$sess_id."&to=".$to."&text=".$text; 
        // do sendmsg call
        
        
        $ret = file($url);
		
		$send = explode(":",$ret[0]);
		$apimsgid = trim($send[1]);
		
		return $apimsgid;
		/*
		if (strpos(" ", $apimsgid) < 32) {
			return false;
		} else {
			return $apimsgid;
		}*/		
    } else {
        return false;
    }
}