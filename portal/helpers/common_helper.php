<?php
function sitename() {
	$ci =& get_instance();
    $ci->db->select('sitename');
    $query = $ci->db->get('config');    
    $row = $query->row();
    return $row->sitename;    
}

function admin_tpl_path() {
    $CI =& get_instance();
    return $CI->config->item('base_url')."assets/".$CI->config->item('admin_tpl')."/";
}

function template_path($name) {
	$CI =& get_instance();
	return $CI->config->item('base_url')."assets/".$name."/";
}

function assets_path() {
    $ci =& get_instance();
    return base_url()."assets/";
}

function menu($role) {
	$ci =& get_instance();
	//$ci->db->like('permission',$role);
    
    $i = 1;
    $where_param = "(";
    foreach ($role as $val) {
        $where_param .= "`permission` LIKE '%".$val."%'";
        
        if ($i != count($role)) {
            $where_param .= " OR  ";
        }
        
        $i++;
    }
    
    $where_param .= ")";
    $ci->db->WHERE($where_param);
	$ci->db->WHERE('parent','0');
    $ci->db->WHERE('menu','1');
	$query = $ci->db->get('permissions');
	//echo $this->db->last_query();
    
	if ($query->num_rows() > 0) {
		$menu = array();
		$i = 0;
		foreach ($query->result() as $row) {
			$menu[$i]['page'] = $row->page;
			$menu[$i]['icons'] = $row->icons;
			
			$j = 1;
            $where_param_child = "(";            
            foreach ($role as $val) {
                $where_param_child .= "`permission` LIKE '%".$val."%'";
                
                if ($j != count($role)) {
                    $where_param_child .= " OR  ";
                }
                
                $j++;
            }
            
            $where_param_child .= ")";
            
            $ci->db->WHERE($where_param_child);    
			$ci->db->WHERE('parent',$row->id);
            $ci->db->WHERE('menu','1');
			$query2 = $ci->db->get('permissions');
			
			if ($query2->num_rows() > 0) {
				$j = 0;
				
				foreach ($query2->result() as $row2) {
					$child = array('page'=>$row2->page,'url'=>$row2->url);
					$menu[$i]['child'][$j] = $child; 
					$j++;
				}
				
				 
			}
			$i++;
		}
		
		return $menu;
	} else {
		return FALSE;
	}
}


function generate_menu($role) {
	$ci =& get_instance();
	$menu = menu($role);
	
	$list = "<nav id='main-nav'> \n <ul> \n";
	$list .= "<li><a href='".base_url()."' title='' class='dashboard no-submenu'>Home</a></li>";
		
	if ($menu != FALSE) {
		
		foreach ($menu as $key => $val) {
			$list .=  "<li><a href='#' title='' class='".$val['icons']."'>".$val['page']."</a>";
			if($val['page']=='Messaging'){
				$col = $ci->message->get_unread_message($ci->session->userdata('username'));
				if($col){
					$list .= "<span title='Jumlah Pesan Belum Terbaca'>".$col->num_rows()."</span>";	
				}				
			}
			$list .=  "\n <ul>";
			
			if (isset($val['child'])) {
				foreach ($val['child'] as $key2 => $val2) {
					$list .= "<li><a href='".base_url().$val2['url']."' title='' class='pnc_link'>".$val2['page']."</a></li>";
				}	
			}			
			
			$list .= "</ul> \n </li>";
		}
	} 
	
	$list .= "</ul>\n </nav>";
	return $list;
	
} 

function get_active_menu($url) {
	$ci =& get_instance();
	
	if ($ci->uri->segment(1) == $url) {
		return "current";		
	} else {
		return "";
	}	
	
}

function dateArray() {
	$date = array();
    for ($i=1;$i<=31;$i++) {
      	$date[$i] = $i;
    }
    
    return $date;
}

function monthArray() {
	$ci =& get_instance();
	$montharr = $ci->lang->line('month_array');
	
	foreach ($montharr as $v => $k) {
    	$months[$v+1] = $k;
    }
    
    return $months;
}

function lang_list($list) {
	$ci =& get_instance();
	$list = $ci->lang->line($list);
	
	$lists = array();
	
	foreach ($list as $v => $k) {
		$lists[$v] = $k;
	}

	return $lists;
}

function year_array() {
    $ci =& get_instance();
	$query = $ci->db->query("SELECT min(year(created)) as minyear, max(year(created)) as maxyear FROM inspections");
        
    $row = $query->row_array();
        
    $year = array();
    for ($i=$row['minyear'];$i<=$row['maxyear'];$i++) {
      	$year[$i] = $i;
    }
    
    return $year;
}

function getCountry() {
	$ci =& get_instance();
	$query = $ci->db->get('countries');
	
	$countryarr = array();
	foreach ($query->result() as $row)
	{
	    $countryarr[$row->id] = $row->country;
	}
	
	return $countryarr;
}

function get_role($role) {
	$ci =& get_instance();
	$ci->db->select('group');
	$ci->db->where('usergroup_id',$role[0]);
    $query = $ci->db->get('usergroups');    
        
    if ($query->num_rows() > 0) {
    	$row = $query->row(); 
    	return $row->group;	
    } 
}

function get_page_title() {
	$ci =& get_instance();
	
	$url = $ci->uri->segment(1);
	$func = $ci->uri->segment(2);
	
	if (! empty($url)) {
		if (! empty($func)) {
			$url .= "/".$ci->uri->segment(2);
		}
		
		$where = array("url" => $url);
		$ci->db->select('page');
		$query = $ci->db->get_where('permissions',$where);
		
		if ($query->num_rows() > 0 ) {
			$row = $query->row(); 
	    	return $row->page; 
		}	
	} else {
		return "Selamat Datang . . . ";
	}
	
}

function getStates($all=FALSE) {
	$ci =& get_instance();
	$query = $ci->db->get('states');
	
	if ($all) {
        $data = array('0'=>'-- ALL -- ');
    } else {
        $data = array('0'=>' ');    
    }
    
	foreach ($query->result() as $row)
	{
	    $data[$row->state_code] = $row->state_name;
	}
	
	return $data;
}

function arrayToJS($array, $baseName) {
   echo ($baseName . " = new Array(); \r\n ");    
   reset ($array);

   while (list($key, $value) = each($array)) {
      echo ($baseName . "[" . $key . "] = '" . $value . "'; \r\n ");
   }
}

function alert($msg) {
	echo "<script>alert('$msg')</script>";
}


function randomPassword() {
	$digit = 6;
	$karakter = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghjklmnpqrstuvwxyz";
 
	srand((double)microtime()*1000000);
	$i = 0;
	$pass = "";
	while ($i <= $digit-1) {
		$num = rand() % 32;
		$tmp = substr($karakter,$num,1);
		$pass = $pass.$tmp;
		$i++;
	}
	return $pass;
}

function convertDate($date,$datepicker=FALSE) {
	if (! empty($date)) {
	    $check = explode(" ",$date);
    	$ci =& get_instance();
    	
    	$time = '';
    	if (count($check) == '2') {
    		$date = explode("-",$check[0]);
    		$time = $check[1];
    	} else {
    		$date = explode("-",$date);	
    	}
    	
    	
    	if ($datepicker) {
    	   return $date[2]."-".$date[1]."-".$date[0];  
    	} else {
    	   return $date[2]."/".$date[1]."/".$date[0];
    	}  
	}     
}

function convertHumanDate($date,$display_time = true) {
	if ( (! empty($date)) || ($date <> '0000-00-00 00:00:00') )  {
	    $check = explode(" ",$date);
    	$ci =& get_instance();
    	
    	$time = '';
    	if (count($check) == '2') {
    		$date = explode("-",$check[0]);
    		$time = $check[1];
    	} else {
    		$date = explode("-",$date);	
    	}
    	
		$month = $ci->lang->line('month_array');
		$month_idx = intval($date[1]);
		
		if($month_idx != 0) {
			$show_date = $date[2]." ".$month[$month_idx]." ".$date[0];  
		
			if ((count($check) == '2') && ($display_time)) {
				return $show_date. "  ".$check[1]; 
			} else {
				return $show_date;
			}	
		}
		
	}    
}

function convertToMysqlDate($date,$delimiter = "/") {
	$date = explode($delimiter,$date);
		
	return $date[2]."-".$date[1]."-".$date[0];
}

function convertMysqlToPHPDate($date) {
	$date = explode("-",$date);
		
	return date("U", mktime(0,0,0,$date[1],$date[2],$date[0]));    
}

function header_site() {
	$ci =& get_instance();
    $query = $ci->db->get('setting');    
    $row = $query->row();
    $header = "<title>".$row->site_title."</title> \n";
	$header .= "<meta name='keywords' content='".$row->meta_keywords."' /> \n"; 
	$header .= "<meta name='description' content='".$row->meta_description."' /> \n";
	return $header;
}

function alert_redirect($msg,$url) {
	echo "<script>alert('$msg');window.location='$url';</script>";
}

function getExt($filename) {
	$filename = explode(".",$filename);
	
	return end($filename);
}

function dialogUI($title,$message) {
    $text =  "<script>$(function() {
            		$('#dialog').dialog({
            			bgiframe: true,
            			height: 30,
            			modal: true,
                        buttons: {
        				Ok: function() {
        					$(this).dialog('close');
        				    }
        			    }
            		});
            	});</script>
            ";            
        $text .= "<div id='dialog' title='".$title."'>".$message."</div>";
        
        return $text;
}

function widgetHighlight($message) {
    $text = "<div class='ui-widget'>
			 <div class='ui-state-highlight ui-corner-all' style='margin-top: 20px; padding: 0 .7em;'> 
				<p><span class='ui-icon ui-icon-info' style='float: left; margin-right: .3em;'>
                </span>".$message."</p>
			</div>
		     </div>";
     return $text;
}

function hashPassword($pass) {
    $ci =& get_instance();
	$password = $ci->config->item("pass_salt").$pass.$ci->config->item("pass_salt");
    $password = md5($password);
    
    return $password;
}

function base64_url_encode($input) {
    return strtr(base64_encode($input), '+/=', '-_~');
}

function base64_url_decode($input) {
    return base64_decode(strtr($input, '-_~', '+/='));
}

function create_unique_slug($string, $table)
{
    $ci =& get_instance();    
    $slug = url_title($string);
    $slug = strtolower($slug);
    $i = 0;
    $params = array();
    $params['slug'] = $slug;
    
    while ($ci->db->where($params)->get($table)->num_rows()) {
        if (!preg_match ('/-{1}[0-9]+$/', $slug )) {
            $slug .= '-' . ++$i;
        } else {
            $slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
        }
        $params ['slug'] = $slug;
    }
    return $slug;
}

function user_detail($field,$id) {
    $ci =& get_instance();
	$ci->db->select($field);
    
	if (is_numeric($id)) {
		$ci->db->where('nim',$id);	
    	$query = $ci->db->get('mahasiswa');
	} else {
		$ci->db->where('username',$id);
    	$query = $ci->db->get('staff');	
	}
	    
    $row = $query->row();	
	
	return $row->$field;
}

function user_details($id) {
    $ci =& get_instance();
    
	if (is_numeric($id)) {
		$ci->db->where('nim',$id);	
    	$query = $ci->db->get('mahasiswa');
	} else {
		$ci->db->where('username',$id);	
    	$query = $ci->db->get('staff');	
	}
    
    return $query->row_array();
}

function formval($field=NULL,$dbval=NULL) {
    $ci =& get_instance();
    $uri = $ci->uri->segment(3);
        
    if ((substr_count($uri,'create_') > 0 ) || (substr_count($uri,'add_') > 0 )){
        return "";
    } else {
        return $dbval;
    }
}

function formval_radio($checkval=NULL,$dbval=NULL,$default=FALSE) {
    $ci =& get_instance();
    $uri = $ci->uri->segment(3);
        
    if ((substr_count($uri,'create_') > 0 ) || (substr_count($uri,'add_') > 0 )){
        return $default;
    } else {
        if ($checkval == $dbval) {
            return TRUE;
        }
    }
}   

function get_name($userid) {
    $ci =& get_instance();
    $ci->db->select('name');
    $ci->db->where('id',$userid);
    $query = $ci->db->get('users');    
    $row = $query->row();
    
    return $row->name;

}

function user_array() {
	$ci =& get_instance();
    $ci->db->where('userid !=',1);
	$query = $ci->db->get('users');
	
	$userarr = array();
	foreach ($query->result() as $row)
	{
	    $userarr[$row->userid] = $row->name;
	}
	
	return $userarr;
}


function datepicker_to_mysql($date) {
    $date = explode('/',$date);
    
    return $date[2]."-".$date[1]."-".$date[0];
}

function mysql_to_datepicker($date) {
    if (empty($date)) {
        return NULL;
    } else {
        $date = explode('-',$date);
    
        return $date[2]."/".$date[1]."/".$date[0];    
    }
    
}


function setting_val($val) {
    $ci =& get_instance();
    $ci->db->select($val);
    $query = $ci->db->get('settings');    
    $row = $query->row();
    
    return $row->$val;
}

    function error_dialog($message) {
        return "<p id='error' class='info'>\n
                <span class='info_inner'>"
                    .$message.
                "</span>
             </p>";
    }
    
    function success_dialog($message) {
        return "<p id='success' class='info'>\n
                <span class='info_inner'>"
                    .$message.
                "</span>
             </p>";
    }
    
function remove_extension($filename) {
  return preg_replace('/(.+)\..*$/', '$1', $filename);
} 

function error_form($message) {
	return '<div class="notification error">
			<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
			<p><strong>'.$message.'</strong></p></div>';
    
}

function success_form($message) {
    return '<div class="notification success">
				<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
				<p><strong>'.$message.'</strong></p></div>';
}

function info_form($message) {
    return '<div class="notification information">
				<a href="#" class="close-notification" title="Hide Notification" rel="tooltip">x</a>
				<p><strong>'.$message.'</strong></p></div>';
}

function create_breadcrumb(){
	$ci =& get_instance();
	
	$url = $ci->uri->segment(1);
	$func = $ci->uri->segment(2);
	
	$link = "<ul id='breadcrumbs'> \n
				 <li><a href='".base_url()."' title='Back to Homepage'>Back to Home</a></li> \n";
    
	if (!empty($url)) {
	   if ($url == 'kelas')
        {
            $assignment_id = $ci->uri->segment(3);
            $link .= "<li><a href='".base_url()."kelas'>Kelas</a></li> \n";
            $link .= "<li><a href='".base_url()."kelas/course/".$assignment_id."'>".assignment_to_courses($assignment_id)."</a></li> \n";
        }
        else 
        {
            if (! empty($func)) {
    			$url .= "/".$func;
    		}
    		
            $where = array("url" => $url);
    		$query = $ci->db->get_where('permissions',$where);
    		
    		if ($query->num_rows() > 0 ) {
    			$row = $query->row();
    			$current = $row->page; 
    			$query2 = $ci->db->get_where('permissions',array('id'=>$row->parent));
    			
    			$row2 = $query2->row();
    			//$current = $row->page;
    			
    			$link .= "<li><a href='#'>".$row2->page."</a></li> \n		
    					<li>".$row->page."</li> \n";
    		
    		}    
        }		 
	} 
	
	$link .= "</ul>";
	
    return $link;
}

function remove_zero($val) {
    $val = rtrim($val, '0');
    
    if (substr($val,-1) == '.') {
        $val = rtrim($val, '.');
    }
    
    return $val;
}

function split_group_concat_link($str,$mrn) {
    $split = explode(',',$str);
    
    $split2 = "";
    foreach ($split as $k => $value) {
        $split2 .= "<div style='line-height:2em'><a href='".base_url()."evaluation/".$mrn."/".$value."'>".$value."</a> </div>";    
    }
    
    return $split2;
}

function split_group_concat_date($str) {
    $split = explode(',',$str);
    
    $split2 = "";
    foreach ($split as $k => $value) {
        $split2 .= "<div style='line-height:2em'>".convertHumanDate($value)."</div>";    
    }
    
    return $split2;
}

function populate_form($data,$table_name) 
{
	$ci =& get_instance();
	$field = $ci->db->list_fields($table_name);
	
	$serialize = array();
	foreach ($data as $key => $value) 
	{
		if (in_array($key, $field)) 
		{
			$serialize[$key] = $value;	
		}
	}
	
	return $serialize;
}

function get_major($major_id) {
	$ci =& get_instance();
	
	$ci->db->select('major');
	$ci->db->where('major_id',$major_id);
	$query = $ci->db->get('major');
		
	if ($query->num_rows() > 0) {
		$row = $query->row(); 
	    return $row->major;	
    }
}

function major_list() {
	$ci =& get_instance();
	
	$query = $ci->db->get('major');
	
	if ($query->num_rows() > 0) {
	
		$major = array();
		foreach ($query->result() as $row) {
			$key = $row->major_id;
			$major[$key] = $row->major; 
		}
		
		return $major;
	}
}

function get_region($id) {
	$ci =& get_instance();
	$ci->db->select('region');
	$ci->db->where('region_id',$id);
    $query = $ci->db->get('region');    
        
    if ($query->num_rows() > 0) {
    	$row = $query->row(); 
    	return $row->region;	
    } 
}

function uuid_to_id($uuid,$id_field,$table='mahasiswa_baru') {
	$ci =& get_instance();
	$ci->db->select($id_field);
	$ci->db->where('uid',$uuid);
    $query = $ci->db->get($table);    
        
    if ($query->num_rows() > 0) {
    	$row = $query->row(); 
    	return $row->$id_field;	
    }
}


function id_to_uuid($id,$id_field='reg_code',$uuid_field='uid',$table='mahasiswa_baru') {
	$ci =& get_instance();
	$ci->db->select($uuid_field);
	$ci->db->where($id_field,$id);
    $query = $ci->db->get($table);    
        
    if ($query->num_rows() > 0) {
    	$row = $query->row(); 
    	return $row->$uuid_field;	
    }
}

function highlight_notif($message) {
    return '<div class="ui-state-highlight">				
				<p>'.$message.'</p></div>';
}

function get_settings($field) {
	$ci =& get_instance();
	$ci->db->select($field);
	$query = $ci->db->get('settings');    
        
    if ($query->num_rows() > 0) {
    	$row = $query->row(); 
    	return $row->$field;	
    }	
}

function calculate_semester($user_period,$current_period = '') {
	if (empty($current_period)) {
		$current_period = get_settings('time_period');
		
		$current_period_year = substr($current_period,0,4);
		$current_period_semester = substr($current_period, 4,1);	
	}	
	
			
	$user_entry_year = substr($user_period,0,4);
	$user_entry_semester = substr($user_period,4,1);
			
	$semester = ( intval($current_period_year) - intval($user_entry_year) ) * 2;
			
	if ($current_period_semester == $user_entry_semester) $semester = $semester + 1;
	else if ($current_period_semester > $user_entry_semester) $semester = $semester + 2;
			
	return $semester;
}

function num_to_letter($num, $uppercase = TRUE)
{
	$num -= 1;

	$letter = 	chr(($num % 26) + 97);
	$letter .= 	(floor($num/26) > 0) ? str_repeat($letter, floor($num/26)) : '';
	return 		($uppercase ? strtoupper($letter) : $letter); 
}

function insert_logs($data)
{
	$ci =& get_instance();
	$ci->db->set('activity_time', 'now()', FALSE);
    $ci->db->insert('logs',$data);
    
	if ($ci->db->affected_rows() > 0) {
		return TRUE;	
	}  else {
		return FALSE;
	}
}

function get_last_insert_id()
{
	$ci =& get_instance();
	return $ci->db->insert_id();   
	
}

function check_user_agent() 
{
	$ci =& get_instance();
		
	$ci->load->library('user_agent');

	if ($ci->agent->is_browser())
	{
	    $agent = $ci->agent->browser().' '.$ci->agent->version();
	}
	elseif ($ci->agent->is_robot())
	{
	    $agent = $ci->agent->robot();
	}
	elseif ($ci->agent->is_mobile())
	{
	    $agent = $ci->agent->mobile();
	}
	else
	{
	    $agent = 'Unidentified User Agent';
	}
	
	return $agent." | ".$ci->agent->platform();
}

function numberToRoman($num) 
{
     $n = intval($num);
     $result = '';
 
     // Declare a lookup array that we will use to traverse the number:
     $lookup = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
     'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
     'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
 
     foreach ($lookup as $roman => $value) 
     {
         // Determine the number of matches
         $matches = intval($n / $value);
 
         // Store that many characters
         $result .= str_repeat($roman, $matches);
 
         // Substract that from the number
         $n = $n % $value;
     }
 
     // The Roman numeral should be built, return it
     return $result;
}

function assignment_to_courses($id)
{
    $ci =& get_instance();
	$ci->db->select('course_id');
    $ci->db->where('assignment_uid',$id);
	$query = $ci->db->get('assignment');    
        
    if ($query->num_rows() > 0) 
    {
    	$row = $query->row(); 
    	
        $ci->db->select('title');
        $ci->db->where('course_id',$row->course_id);
        
        $query2 = $ci->db->get('courses');
        
        if ($query2->num_rows() > 0) 
        {
            $row2 = $query2->row();
            return $row2->title;
        }
        else 
        {
            return false;
        }
        
    }
    else 
    {
        return false;
    }   
}