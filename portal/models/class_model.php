<?php
class class_model extends CI_Model {
    

    function __construct()
    {        
        parent::__construct();
    }
	
	public function save_attachment($data) {
	   $this->db->set('uuid', 'uuid()', FALSE);						
       $this->db->set('upload_time', 'now()', FALSE);
	   $this->db->insert('attachment',$data);
		
		if ($this->db->affected_rows() > 0) {
			$uuid = id_to_uuid($this->db->insert_id(),'attach_id','uuid','attachment');
            return $uuid;			
		} else {
			return FALSE;
		}
        
	}
    
    public function get_attachment($reference_id, $category_id) {
        $where = array('reference_id' => $reference_id,
                       'category_id' =>  $category_id);
	   $query = $this->db->get_where('attachment', $where);
		
		if ($query->num_rows() > 0) {
		    return $query->result();			
		} else {
			return FALSE;
		}
	}
    
    public function get_attachment_uid($id) {
	   $query = $this->db->get_where('attachment',array('uuid' => $id));
		
		if ($query->num_rows() > 0) {
			return $query->row();			
		} else {
			return FALSE;
		}
	}
    
    public function announce_class_detail($assignment_id,$id) {
		$this->db->where('id',$id);
        $query = $this->db->get('announce_class');
		
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}
    
    public function display_detail_question($assignment_id,$id) {
        $this->db->where('assignment_id',$assignment_id);
		$this->db->where('id',$id);		
        $query = $this->db->get('question');
		
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}
    
    public function id_to_uuid($uuid)
    {
        $this->db->select('id');
    	$this->db->where('assignment_uid',$uuid);
        $query = $this->db->get('assignment');    
            
        if ($query->num_rows() > 0) {
        	$row = $query->row(); 
        	return $row->id;	
        }
    }

        
    public function save_announce_class($data,$id,$update) {
		$insert = populate_form($data, 'announce_class');
        
        if ($update == false) 
        {
            $this->db->set('created', 'now()', FALSE);
            $this->db->set('assignment_id',$id);        
    		
    		$query = $this->db->insert('announce_class',$insert);    
        }
        else
        {
            $where = array('assignment_id' =>$id,'id'=>$update);
            $this->db->where($where);
            $query = $this->db->update('announce_class',$insert);
        }
        
        $affected = $this->db->affected_rows();
		
		if ($update == false)
        {
            if ( $affected  > 0 ) 
            {
                $data_announcement = array('reference_id' => $this->db->insert_id());
                $this->db->where('uuid', $data['attach_uid']);
			    $this->db->update('attachment',$data_announcement);
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            if (! empty($data['attach_uid'])) {
                $data_announcement = array('reference_id' => $update);
                
                $this->db->where('uuid', $data['attach_uid']);
			    $this->db->update('attachment',$data_announcement);
			}
            
            return true;
        }
        		
	}
    
    public function save_question($data,$id) {
		$insert = populate_form($data, 'question');
		$this->db->set('created', 'now()', FALSE);
        $this->db->set('user_id',$this->session->userdata('username'));
        $this->db->set('assignment_id',$id);
		
		$query = $this->db->insert('question',$insert);
		
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
    
    public function list_announce_class($assignment_id,$limit=null) {
		$this->db->where('assignment_id',$assignment_id);
		$this->db->order_by('id','desc');
        if (!empty($limit))
            $this->db->limit($limit);
		$query = $this->db->get('announce_class');
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
    
    public function list_question($assignment_id,$limit=null) {
        $this->db->where('assignment_id',$assignment_id);
		$this->db->order_by('id','desc');
        if (!empty($limit))
            $this->db->limit($limit);
		$query = $this->db->get('question');
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}       
    }
    
    public function del_announcement($assignment_id,$id)
    {
        
        if ($this->is_my_assignment($assignment_id)) {
            $where = array('id' => $id);
                        
            $query = $this->db->delete('announce_class', $where);
            if ($this->db->affected_rows() > 0) 
            {
    			return true;
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
    
    public function del_attachment($assignment_id,$id)
    {
        if ($this->is_my_assignment($assignment_id)) {
            $where = array('uuid' => $id);
            $get_file  = $this->db->get_where('attachment', $where);
            
            if ($get_file->num_rows() > 0) {
                $row  = $get_file->row();
                
                $query = $this->db->delete('attachment', $where);
                if ($this->db->affected_rows() > 0) 
                {
        			$path = $this->config->item('absolute_path')."assets/uploads/".$row->subfolder."/".$row->filename;
                    unlink($path);
                    return true;
        		} 
                else 
                {
        			return false;
        		}
            } 
                                        
            
       } 
        else
        {
            return false;
        }
    }
    
    public function save_question_response($response,$id) 
    {
		$data = array('response' => $response, 
                      'question_id' => $id, 
                      'user_id' => $this->session->userdata('username'));
		$this->db->set('created', 'now()', FALSE);
        
		$query = $this->db->insert('question_response',$data);
		
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
    
    public function display_question_response($id)
    {
        $this->db->where('question_id',$id);		
        $query = $this->db->get('question_response');
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}       
    }

	
	public function get_my_class($nim,$id){
		$this->db->where('id_student',$nim);
		$this->db->where('id_assignment',$id);
		$this->db->from('class');
		$this->db->join('assignment','assignment.id = class.id_assignment');
		$this->db->join('courses','assignment.course_id = courses.course_id');
		
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}else{
			return false;
		}
		
	}
    
    public function list_task($id,$limit=null) {
        /*
        SELECT t.*,COUNT(s.nim) as submitted_student
        FROM utkor_task t
        LEFT JOIN utkor_task_student s ON t.id = s.task_id
        */
        //$this->db->SELECT('t.id,t.title,t.content,t.created,t.deadline,t.assignment_id,COUNT(s.nim) as submitted_student');
        $this->db->SELECT('t.*,COUNT(s.nim) as submitted_student');
        $this->db->from('task t');
        $this->db->join('task_student s', 't.id = s.task_id', 'left');
        $this->db->where('assignment_id',$id);
		$this->db->order_by('t.id','desc');
        $this->db->group_by('t.id');
		//$this->db->group_by(array('t.id','t.title','t.content','t.created','t.assignment_id','s.nim'));
        if (!empty($limit))
            $this->db->limit($limit);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}       
    }
    
    
    public function list_task_by_student($nim,$id,$limit=null) {
        //$this->db->SELECT('t.id,t.title,t.content,t.created,t.deadline,t.assignment_id,COUNT(s.nim) as submitted_student');
        $this->db->SELECT('t.*, IF (s.nim = "'.$nim.'",1,0) as submitted',FALSE);
        $this->db->from('task t');
        $this->db->join('task_student s', 't.id = s.task_id', 'left');
        $this->db->where('assignment_id',$id);
		$this->db->order_by('t.id','desc');
        $this->db->group_by('t.id');
		//$this->db->group_by(array('t.id','t.title','t.content','t.created','t.assignment_id','s.nim'));
        if (!empty($limit))
            $this->db->limit($limit);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}       
    }
    
    public function save_task($data,$id,$update=false) {
        $insert = populate_form($data, 'question');
        $this->db->set('deadline',convertToMysqlDate($data['deadline_date']));
        
        if ($update == false) 
        {
            $this->db->set('created', 'now()', FALSE);
            $this->db->set('assignment_id',$id);        
    		
    		$query = $this->db->insert('task',$insert);    
        }
        else
        {
            $where = array('assignment_id' =>$id,'id'=>$update);
            $this->db->where($where);
            $query = $this->db->update('task',$insert);
        }
        
        $affected = $this->db->affected_rows();
        
        if ($update == false)
        {
            if ( $affected  > 0 ) 
            {
                $data_announcement = array('reference_id' => $this->db->insert_id());
                $this->db->where('uuid', $data['attach_uid']);
			    $this->db->update('attachment',$data_announcement);
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            if (! empty($data['attach_uid'])) {
                $data_announcement = array('reference_id' => $update);
                
                $this->db->where('uuid', $data['attach_uid']);
			    $this->db->update('attachment',$data_announcement);
			}
            
            return true;
        }
        
	}
    
    public function del_task($assignment_id,$id)
    {
        if ($this->is_my_assignment($assignment_id)) 
        {
            $where = array('id' => $id);
                            
            $query = $this->db->delete('task', $where);
            if ($this->db->affected_rows() > 0) 
            {
    			return true;
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
    
    public function is_my_assignment($assignment_id, $staff_id = "")
    {
        if (empty ($staff_id))
        {
            $staff_id = $this->session->userdata('id');
        }
        $where = array ('assignment_uid' => $assignment_id,
                        'staff_id' => $staff_id);
                        
        $query = $this->db->get_where('assignment',$where);
        
        if ($query->num_rows() > 0) 
        {
			return true;
		} 
        else 
        {
			return false;
		}
        
    }
    
    public function task_detail($assignment_id,$id) {
		$this->db->where('id',$id);
        $query = $this->db->get('task');
		
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}


	public function get_list_gabung_kelas($linkonly = false){
		$this->db->from('gabung_kelas a');
		$this->db->join('assignment b','b.id = a.from_assignment');
		$this->db->join('assignment c','c.id = a.to_assignment');
		$this->db->join('courses d','d.course_id = b.course_id');
		$this->db->join('courses e','e.course_id = c.course_id');
		
		$this->db->select('a.from_assignment,a.to_assignment,d.title as from_title,e.title as to_title,b.region as from_region,c.region as to_region,is_active');
		$this->db->where('is_active !=',2);
		
		if($linkonly){
			$this->db->where('is_active',1);
		}
		
		$res = $this->db->get();
		if($res->num_rows()>0){
			return $res;
		}else{
			return false;
		}
	}
	
	public function add_gabung_kelas($col){
		$this->db->insert('gabung_kelas',$col);
		
		$this->db->where('id_assignment', $col['from_assignment']);
		$this->db->update('class', array('id_assignment'=>$col['to_assignment'])); 	
	}
	
	

    
    public function student_per_class($assignment_uid) 
    {
        $query = $this->db->get_where('assignment',array('assignment_uid' => $assignment_uid));
        
        if ($query->num_rows() > 0)
        {
            $row = $query->row();
            
            $this->db->select("count(*) as total_student");
            $this->db->where("id_assignment",$row->id);
            
            $query2 = $this->db->get('class');
            
            if ($query2->num_rows() > 0)
            {
                $row2 = $query2->row();
                return $row2->total_student;
            }
        }
        else
        {
            return false;
        }
    }
    
    public function submitted_task($data) {
        $insert = populate_form($data, 'task_student');
        
        $update = false;
        
        $where_task = array('task_id' =>$data['task_id'],'nim'=>$data['nim']);
        $query = $this->db->get_where('task_student',$where_task);
        
        if ($query->num_rows() > 0)
        {
            $row_student = $query->row();
            $update = $row_student->id;
        }
        
        if ($update == false) 
        {
            $this->db->set('created', 'now()', FALSE);
    		$query = $this->db->insert('task_student',$insert);    
        }
        else
        {
            $where = array('id' =>$update,'nim'=>$data['nim']);
            $this->db->where($where);
            $query = $this->db->update('task_student',$insert);
        }
        
        $affected = $this->db->affected_rows();
        
        if ($update == false)
        {
            if ( $affected  > 0 ) 
            {
                $data_task = array('reference_id' => $this->db->insert_id());
                $this->db->where('uuid', $data['attach_uid']);
			    $this->db->update('attachment',$data_task);
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            if (! empty($data['attach_uid'])) {
                $data_task = array('reference_id' => $update);
                
                $this->db->where('uuid', $data['attach_uid']);
			    $this->db->update('attachment',$data_task);
			}
            
            return true;
        }
        
    }
    
    public function task_response($where) {
		$this->db->where($where);
        $query = $this->db->get('task_student');
		
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}
    
    public function list_submitted_task($task_id)
    {
        $query = $this->db->get_where('task_student',array('task_id' => $task_id));
        
        if ($query->num_rows() > 0)
        {
            return $query->result();            
        }
        else
        {
            return false;
        }
    }
}