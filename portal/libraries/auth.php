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
        Role 1 => Super Administrator
        Role 2 => IT Support
        Role 3 => Registered User
      */ 
      function role() {
        if ($this->CI->session->userdata('nip') == 1) {
            return "1";
        } else if ($this->CI->session->userdata('division') == 1) {
            return "2";
        }  else {
            return "3";
        }
      }
      	 
      function check_auth($role) {        
        if(!$this->CI->session->userdata('logged_in')) {
            $this->logout();
        } else {
            $role = explode(",",$role);
            if (!in_array($this->role(),$role)) {
                show_404();                        
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
                   /*'role'  => $row['division'],*/
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