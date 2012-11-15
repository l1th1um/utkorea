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
	$ci->db->like('permission',$role);
	$ci->db->WHERE('parent','0');
	$query = $ci->db->get('permissions');
	
	if ($query->num_rows() > 0) {
		$menu = array();
		$i = 0;
		foreach ($query->result() as $row) {
			$menu[$i]['page'] = $row->page;
			
			$ci->db->like('permission',$role);
			$ci->db->WHERE('parent',$row->id);
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
	$menu = menu($role);
	
	if ($menu != FALSE) {
		$list = "<nav id='main-nav'> \n <ul> \n";
		foreach ($menu as $key => $val) {
			$list .=  "<li><a href='#' title='' class='projects'>".$val['page']."</a> \n <ul>";
			
			if (isset($val['child'])) {
				foreach ($val['child'] as $key2 => $val2) {
					$list .= "<li><a href='".base_url().$val2['url']."' title='' class='pnc_link'>".$val2['page']."</a></li>";
				}	
			}			
			
			$list .= "</ul> \n </li>";
		}
		$list .= "</ul>\n </nav>";
		
		return $list;
	}
	
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
	$ci->db->where('usergroup_id',$role);
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

function convertHumanDate($date) {
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
    	
    	/*
    	$date_arr = $ci->lang->line('month_arr');
    	$month = intval($date[1]);
        
        return $date[2]." ".$date_arr[$month]." ".$date[0]." ".$time;
    	*/
        return date("F dS, Y", mktime(0, 0, 0, $date[1], $date[2], $date[0]));    	   
	}    
}

function convertToMysqlDate($date) {
	$date = explode("/",$date);
		
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

function user_detail($field,$id,$table='staff') {
    $ci =& get_instance();
	$ci->db->select($field);
    $ci->db->where('username',$id);
    $query = $ci->db->get('staff');
    $row = $query->row();	
	
	return $row->$field;
}

function user_details($id,$table='staff') {
    $ci =& get_instance();
    $ci->db->where('username',$id);
    $query = $ci->db->get('staff');
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
    $query = $ci->db->get('setting');    
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

function create_breadcrumb(){
	$ci =& get_instance();
	
	$url = $ci->uri->segment(1);
	$func = $ci->uri->segment(2);
	
	$link = "<ul id='breadcrumbs'> \n
				 <li><a href='".base_url()."' title='Back to Homepage'>Back to Home</a></li> \n";
				 
	if (!empty($url)) {
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