<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Auth
	 * 
	 * @package Helpdesk
	 * @author ohyeah
	 * @copyright 2010
	 * @version $Id$
	 * @access public
	 */
	class Auth {
     
	  function Auth() {
      	$this->CI =& get_instance();      	
      }
	  
      /*
      function check_auth($role) {        
        if(!$this->CI->session->userdata('logged_in')) {
            $this->logout();
        } else {
            $role = explode(",",$role);
            if (!in_array($this->role(),$role)) {
                show_404();                        
            }
        }    
      }*/
      
      
      function check_auth() {
      	if($this->CI->session->userdata('logged_in') != 1) {
      		$this->logout();      		
      	} else {
      		$url = $this->CI->uri->segment(1);
      		$func = $this->CI->uri->segment(2);
      
      		if (! empty($func)) {
      			$url .= "/".$this->CI->uri->segment(2);
      		}
      
      		$where = array("url" => $url);
      
      		$query = $this->CI->db->get_where('permissions',$where);
      
      		if ($query->num_rows() > 0) {
      			$row = $query->row_array();
      			
      			$permission = json_decode($row['permission']);
      			
	      		if (!in_array($this->CI->session->userdata('role'),$permission)) {
      				redirect('permission_error');
      			} else {
      				return TRUE;
      			}
      		}
      
      	}
      }
      
      function login_process($login = NULL) {
	      $password = $login['password'];
          $password = hashPassword($password);  

	      $this->CI->db->where('username', $login['username']); 
		  	
	      $this->CI->db->where('password',$password);
	
	      $query = $this->CI->db->get('staff');
	      $row = $query->row_array();
	
	      if ($query->num_rows() >= 1) {
                $newdata = array(
                   'username'  => $login['username'],
                   'role'  => $row['group_id'],
                   'logged_in' => TRUE
               );              
               
                
               $this->CI->session->set_userdata($newdata);
               
               echo "1";		      			      	
	      } else {
	           echo "0";
	      }
		      	  
    	  	  
    }
      
	
	function logout() {
      	$this->CI->session->sess_destroy();
		redirect('');
      	return TRUE;
    }
}
?>