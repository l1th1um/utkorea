<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Auth
	 * 
	 * @package Helpdesk
	 * @author Andri Fachrur Rozie
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
                
      			$intersect = array_intersect($this->CI->session->userdata('role'),$permission);
                
                if (count($intersect) > 0) {
      				return TRUE;                      
      			} else {
      				redirect('permission_error');
      			}
      		}
      
      	}
      }
      
      function login_process($login = NULL) {
	      $password = $login['password'];
          $password = hashPassword($password);  
		  
		  		  	
		  $this->CI->db->where('password',$password);
			  
	      if (is_numeric($login['username'])) {
	      	  $this->CI->db->where('nim', $login['username']);
              $this->CI->db->where('status', '1');
	      	  $query = $this->CI->db->get('mahasiswa');
	      } else {
	      	  $this->CI->db->where('username', $login['username']);	
		      $query = $this->CI->db->get('staff');		      
	      }
		  
		  $remarks = "Username = '".$login['username']."' ";
	
	      if ($query->num_rows() >= 1) {
	      		$row = $query->row_array();
			  
			  if (is_numeric($login['username'])) {
	                $newdata = array(
	                   'username'  => $login['username'],
	                   'role'  => array(9),
	                   'major'  => $row['major'],
	                   'logged_in' => TRUE
	               );              
			  } else {
			        $role = explode(',',$row['group_id']);
			  		$newdata = array(
	                   'username'  => $login['username'],
	                   'id'  => $row['staff_id'],
	                   'role'  => $role,
	                   'major'  => $row['major_id'],
	                   'logged_in' => TRUE
	               );
			  }	
               
               $this->CI->session->set_userdata($newdata);
               $result = "success";
               echo "1";		      			      	
	      } else {
	      	  $result = "failure";
	           echo "0";
		  }
		  
		  $logs_data = array('activity' => 'login',
		  					 'result' => $result,
							 'remarks' => $remarks,
							 'user_agent' => check_user_agent());
							 
		 insert_logs($logs_data);	  
    }
      
	
	function logout() {
      	$this->CI->session->sess_destroy();
		redirect('');
      	return TRUE;
    }
}
?>