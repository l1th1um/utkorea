<?php

function get_balance() 
{
	$CI =& get_instance();
	$url = "http://api.clickatell.com/http/getbalance?api_id=".$CI->config->item('clickatell_api')."&user=".$CI->config->item('clickatell_username')."&password=".$CI->config->item('clickatell_password');
    //http://api.clickatell.com/http/getbalance?api_id=3385991&user=l1th1um&password=HRccfdREAYTgZA
    /*
    $balance = file($url);
	return $balance[0];
    */
    
    return getRemoteFile($url);      
}

function send_message($to,$message) {	
	$CI =& get_instance();
    $baseurl ="https://api.clickatell.com/";
 
    $text = urlencode($message);
    $to = $to;
 
    $url = $baseurl."http/auth?user=".$CI->config->item('clickatell_username')."&password=".$CI->config->item('clickatell_password')."&api_id=".$CI->config->item('clickatell_api');
    
	
    //$ret = file($url);
    $ret = getRemoteFile($url);
    //echo "RET1 : '".$ret."'";
    $sess = explode(":",$ret);
    if ($sess[0] == "OK") { 
        $sess_id = trim($sess[1]); // remove any whitespace
        $url = $baseurl."http/sendmsg?session_id=".$sess_id."&to=".$to."&text=".$text; 
        // do sendmsg call
                
        //$ret = file($url);
        $ret = getRemoteFile($url);
		//echo "RET2 : ".$ret;
		$send = explode(":",$ret);
		$apimsgid = trim($send[1]);
		
		return $apimsgid;
		
    } else {
        return false;
    }
}