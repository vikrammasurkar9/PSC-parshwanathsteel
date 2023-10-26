<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ContactsModel extends CI_Model
{


	public function __construct(){				
		$this->load->database();			
		$this->load->model('FirebaseModel', 'firebaseModel');
		$this->load->model('UserModel', 'userModel');
    }
    
    public function lists()
    {
        
       

        $query = "SELECT * FROM contacts  WHERE id <> 0 ";
        if(isset($_GET['state']))
			$query .= "AND state = '" . $_GET['state'] . "' ";

        if(isset($_GET['state']))
        $query .= "AND state = '" . $_GET['state'] . "' ";

        if(isset($_GET['profession']))
        {
            $profession = urldecode($_GET['profession']);
        $query .= "AND profession = '" . $profession . "' ";
        }


        $result = $this->db->query($query);
        return $result->result();
    }

    public function states()
    {
        $query = "SELECT * FROM states WHERE display='Yes'";
        
        $result = $this->db->query($query);
        return $result->result();
    }
    public function cities($state)
    {
        $query = "SELECT S.name, C.city FROM states AS S, cities AS C  WHERE S.id = C.state_id AND  S.name = '$state'";
        $result = $this->db->query($query);
        return $result->result();
    }



    public function save()
    {
        $id = 0;
        date_default_timezone_set('Asia/Kolkata');
        $now = date('Y-m-d H:i:s'); 
        $field = array(
            'name' => $this->input->post('name'), 
            'firmname' => $this->input->post('firmname'), 
            'address' => $this->input->post('address'), 
            'city' => $this->input->post('city'), 
            'email' => $this->input->post('email'), 
            'state'=> $this->input->post('state'), 
            'mobileno1'=> $this->input->post('mobileno1'), 
            'mobileno2'=> $this->input->post('mobileno2'), 
            'profession'=> $this->input->post('profession'), 
            'createdon' => $now,
        );
        if ($this->input->post('id') == 0) {            
            $this->db->insert('contacts', $field);
            $id = $this->db->insert_id();
        } else {
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('contacts', $field);
        }
        
        return "success" ;
    }

    public function savefromleads($userid)
    {
        date_default_timezone_set('Asia/Kolkata');
        $now = date('Y-m-d H:i:s');
        $data = $this->userModel->getbyid($userid);
        $reply = $this->exists($data->firmname);
        $field = array(
            'name' => $data->name, 
            'firmname' => $data->firmname, 
            'address' => $data->address, 
            'city' => $data->city, 
            'state'=> $data->state, 
            'mobileno1'=> $data->mobileno, 
            'gstno'=> $data->gstno, 
            'profession'=> $data->profession, 
            'createdon' => $now,
        );        
        if ($reply == false)
        { 
            $this->db->insert('contacts', $field);

            $query = "UPDATE users SET savedincontacts = 'yes' WHERE id = " . $userid . "";
            $this->db->query($query);
        }
       
        return "success";

    }

    public function updatecontact()
    {
        
        $field = array(
            'name' => $this->input->post('name'), 
            'firmname' => $this->input->post('firmname'), 
            'address' => $this->input->post('address'),  
            'city' => $this->input->post('city'), 
            'state'=> $this->input->post('state'), 
            'mobileno1'=> $this->input->post('mobileno'), 
            'gstno'=> $this->input->post('gstno'), 
            'profession'=> $this->input->post('profession'), 
        );

        

            $id = $this->input->post('contactid');
            $this->db->where('id', $id);
            $this->db->update('contacts', $field);
            
            return "success";
    }

    public function getbyid($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('contacts');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('contacts');
    }

    public function exists($firmname){
		$query = "SELECT * FROM contacts WHERE firmname = '" . $firmname . "'";		
		$data = $this->db->query($query);
		$result = $data->result();
		if(sizeof($result) > 0)
			return true;
		else
			return false;
    }

    public function uploadexcel($filename)
    {
        $filepath = '././excels/' . $filename;
        include("SimpleXLSX.php");
        if ($xlsx = SimpleXLSX::parse($filepath)) {
            $i = 0;
            foreach ($xlsx->rows() as $elt) {
                $firmname = $elt[0];
                $address1 = $elt[1];
                $address2 = $elt[2];
                $name = $elt[4];
                $contact = $elt[5];
                $gstno = $elt[6];
                $state = $elt[7];

                $phonenos = explode("/", $contact);
                $phoneno1 = "";
                $phoneno2 = "";
                if(count($phonenos) > 1)
                {
                    $phoneno1 = preg_replace("/[^0-9]/", "", trim($phonenos[0]));
                    $phoneno2 = preg_replace("/[^0-9]/", "", trim($phonenos[1]));
                }
                else
                {
                    $phoneno1 = preg_replace("/[^0-9]/", "", trim($phonenos[0]));
                }

                //echo $firmname . " " . $address1 . " " . $address2 . " " . $name . " " . $phoneno1 . " " . $phoneno2 . " " . $gstno . " " . $state . "<br />";
                date_default_timezone_set('Asia/Kolkata');
                $now = date('Y-m-d H:i:s'); 
                $address = $address1 ." ". $address2;

                $firmname = str_replace("'", "''", $firmname);
                $reply = $this->exists($firmname);
                if ($reply == false)
                {
                    $field = array(
                        'name' => $name, 
                        'firmname' => $firmname, 
                        'address' => $address, 
                        // 'city' => $this->input->post('city'), 
                        'state'=> $state, 
                        'mobileno1'=> $phoneno1, 
                        'mobileno2'=> $phoneno2, 
                        'gstno'=> $gstno, 
                        'createdon' => $now,
                    );          
                    $this->db->insert('contacts', $field);
                }
                
            }
        }
        else{
            echo "Error";
        }
    }  
}
