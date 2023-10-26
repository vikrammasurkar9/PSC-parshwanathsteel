<?php

defined('BASEPATH') or exit('No direct script access allowed');

class QuotationRequestModel extends CI_Model
{
    public function __construct(){				
		$this->load->database();			
		$this->load->model('FirebaseModel', 'firebaseModel');
        $this->load->model('UserModel', 'user');
        $this->load->model('DBModel', 'dbModel');
        $this->load->model('QuotationsModel', 'quotation');
    }
    public function save()
    {        
        $qid = $this->input->post('id');
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
		$eid = "0";
        $name = $this->input->post('firmname');   


        

        date_default_timezone_set('Asia/Kolkata');
        $now = date('Y-m-d H:i:s');
        
        $field = array(
            'userid' => $userid,
            'qname' => $name,
            'eid' => $eid,
            'requestdate' => $now,
            'status'=>'Lead',
            'filename'=>'',
            'firmid' => $this->input->post('firmid'),
            'createdby' => $_COOKIE['name'],
            'adminid'=> $_COOKIE['adminid'],
            'narration'=>$this->input->post('narration'),
            'enquirysource'=>$this->input->post('enquirysource'),
            'enquirydetails'=>$this->input->post('enquirydetails'),
            //'leadno'=>$leadno,
               // 'financialyear'=>$financialyear,
        );
        if ($qid == 0) {            
            $this->db->insert('quotations', $field);
            $qid = $this->db->insert_id(); 

            $month = date('m');
            $year = date('Y');
            
            $financialyear = $year . "-" . ($year + 1);
            if($month < 4)
            $financialyear = ($year - 1) . "-" . $year;

            $query = "SELECT * FROM quotations WHERE id = " . $qid . " AND leadno IS NULL";
            if($this->dbmodel->checkifexists($query)){
                $leadno = $this->getnextleadno($financialyear);
                $field = array(                    
                    'leadno'=>$leadno,
                    'financialyear'=>$financialyear,
                ); 
                $this->db->where('id', $qid);
                $this->db->update('quotations', $field);
            }

        } else {            
            $this->db->where('id', $qid);
            $this->db->update('quotations', $field);
        }

        if($_FILES["pic"]["tmp_name"] !== "")
		{
			$query = "SELECT enquirypic AS svalue FROM quotations WHERE id = " . $qid;
			$imagename = $this->dbmodel->getsinglevalue($query);    
			$target_dir = '././enquirypics/' . $imagename  .'.png';
			if(file_exists($target_dir))
				unlink($target_dir);
			$imagename = mt_rand(10000000, 99999999);
			$target_dir = '././enquirypics/' . $imagename  .'.png';

			move_uploaded_file($_FILES["pic"]["tmp_name"], $target_dir);
			$query = "UPDATE quotations SET enquirypic = '" . $imagename . "' WHERE id = " . $qid;
			$this->db->query($query);
		}
        if($_FILES["pic1"]["tmp_name"] !== "")
		{
			$query = "SELECT enquirypic1 AS svalue FROM quotations WHERE id = " . $qid;
			$imagename = $this->dbmodel->getsinglevalue($query);    
			$target_dir = '././enquirypics/' . $imagename  .'.png';
			if(file_exists($target_dir))
				unlink($target_dir);
			$imagename = mt_rand(10000000, 99999999);
			$target_dir = '././enquirypics/' . $imagename  .'.png';

			move_uploaded_file($_FILES["pic1"]["tmp_name"], $target_dir);
			$query = "UPDATE quotations SET enquirypic1 = '" . $imagename . "' WHERE id = " . $qid;
			$this->db->query($query);
		}
        
        $bid=1;
        $count = $this->input->post('count');
        for($i = 1; $i < $count; $i++)
        {
            if(!$this->input->post('pid'.$i)==""){
                $field = array(
                    'qid' => $qid,
                    'pwid' => $this->input->post('pwid' . $i),
                    'pid' => $this->input->post('pid' . $i),
                    'bid' =>$bid,
                    'estimationin' => $this->input->post('unit' . $i),
                    'quantities' => $this->input->post('quantities' . $i),
                    'singleweight' => $this->input->post('singleweight' . $i),
                    'weight' => $this->input->post('weight'.$i),
                    'narration' => $this->input->post('narration' . $i),
                );
                if ($this->input->post('id') == 0) {            
                    $this->db->insert('quotationdetails', $field);                
                } 
                else {       
                    if($i<=1){
                        $query = "DELETE FROM quotationdetails WHERE qid = " . $qid;
                        $this->db->query($query);    
                        $this->db->insert('quotationdetails', $field);  
                    }
                    else{
                        $this->db->insert('quotationdetails', $field);             
                    }
                }
            }
        }
        return $qid;
    }

    public function delete($id)
    {       
        $this->db->where('id', $id);
        $this->db->delete('quotations');

        $this->db->where('qid', $id);
        $this->db->delete('quotationdetails');
    }

    public function getnextleadno($financialyear)
    {
        $query = "SELECT IFNULL(MAX(leadno), 0) AS svalue FROM quotations WHERE financialyear = '" . $financialyear . "'";
        $leadno= $this->dbModel->getsinglevalue($query);
        return $leadno + 1;
    }
}
