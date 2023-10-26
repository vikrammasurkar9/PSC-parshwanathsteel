<?php

defined('BASEPATH') or exit('No direct script access allowed');

class EnquiryModel extends CI_Model
{
    public function __construct(){				
		$this->load->database();			
		$this->load->model('FirebaseModel', 'firebaseModel');
        $this->load->model('UserModel', 'user');
        $this->load->model('DBModel', 'dbModel');
        $this->load->model('QuotationsModel', 'quotation');
    }

    public function totalrecords()
    {
        return $this->db->count_all("enquiries");
    }
    public function save()
    {        
        $eid = $this->input->post('id');
        $userid = $this->input->post('userid');

        $mobileno = $this->input->post('mobileno');
		$name = $this->input->post('firmname');
		$reply = $this->user->getuserdatafornameandmobileno($name, $mobileno);
       
        $field = array(
            'firmname'=>$this->input->post('firmname'),
            'name'=>$this->input->post('name'),
			'address'=>$this->input->post('address'),
            'city'=>$this->input->post('city'),
			'mobileno'=>$this->input->post('mobileno'),
            'gstno'=>$this->input->post('gstno'),
            'state'=>$this->input->post('state'),
			'password'=>'123',
            'profession'=>$this->input->post('profession'),
            'source'=>'web',
        );
        if ($reply == false) {            
            $this->db->insert('users', $field);
            $userid = $this->db->insert_id();
              
        } else {    
            $userid = $reply->id;        
            $this->db->where('id', $userid);
            $this->db->update('users', $field);
        }
        $name = $this->input->post('firmname');   
        date_default_timezone_set('Asia/Kolkata');
        $now = date('Y-m-d H:i:s');
        $field = array(
            'userid' => $userid,
            'firmid' => 1,
            'qname' => $name,
            'createdon' => $now,
            'createdby' => $_COOKIE['name'],
            'adminid'=> $_COOKIE['adminid'],
            'description' => $this->input->post('description'),   
        );
        if ($eid == 0) {            
            $this->db->insert('enquiries', $field);
            $eid = $this->db->insert_id(); 
        } else 
        {            
            $this->db->where('id', $eid);
            $this->db->update('enquiries', $field);
        }
        if($_FILES["pic"]["tmp_name"] !== "")
		{
			$query = "SELECT filename AS svalue FROM enquiries WHERE id = " . $eid;
			$imagename = $this->dbmodel->getsinglevalue($query);    
			$target_dir = '././enquirypics/' . $imagename  .'.png';
			if(file_exists($target_dir))
				unlink($target_dir);
			$imagename = mt_rand(10000000, 99999999);
			$target_dir = '././enquirypics/' . $imagename  .'.png';

			move_uploaded_file($_FILES["pic"]["tmp_name"], $target_dir);
			$query = "UPDATE enquiries SET filename = '" . $imagename . "' WHERE id = " . $eid;
			$this->db->query($query);
		}
        
        return $eid;
    }

    public function get_data_for_enquiries($limit, $start) 
    {
        $query = "SELECT *, (SELECT name FROM users WHERE users.id = userid) AS username, ";
        $query .= "(SELECT firmname FROM users WHERE users.id = userid) AS firmname, ";
        $query .= "(SELECT city FROM users WHERE users.id = userid) AS city, ";
        $query .= "(SELECT savedincontacts FROM users WHERE users.id = userid) AS savedincontacts, ";
        $query .= "(SELECT mobileno FROM users WHERE users.id = userid) AS mobileno ";
        $query .= "FROM enquiries WHERE id <> 0 ";
        
        $query .= " ORDER BY createdon DESC , id ";
        $query .= "LIMIT " . $limit . " OFFSET " . $start;
        $result = $this->db->query($query);
        return $result->result();
    }

    public function getbyid($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('enquiries');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getenquirybyid($id)
    {
        $query = "SELECT *, (SELECT name FROM users WHERE users.id = userid) AS username, ";
        $query .= "(SELECT firmname FROM users WHERE users.id = userid) AS firmname, ";
        $query .= "(SELECT city FROM users WHERE users.id = userid) AS city, ";
        $query .= "(SELECT address FROM users WHERE users.id = userid) AS address, ";
        $query .= "(SELECT savedincontacts FROM users WHERE users.id = userid) AS savedincontacts, ";
        $query .= "(SELECT email FROM users WHERE users.id = userid) AS email, ";
        $query .= "(SELECT mobileno FROM users WHERE users.id = userid) AS mobileno ,";
        $query .= "(SELECT profession FROM users WHERE users.id = userid) AS profession ";
        $query .= "FROM enquiries WHERE id = " . $id;
        $result = $this->db->query($query);
        return $result->result()[0];
    }
    public function delete($id)
    {       
        $this->db->where('id', $id);
        $this->db->delete('enquiries');
        
    }
}
