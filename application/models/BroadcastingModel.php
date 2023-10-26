<?php

defined('BASEPATH') or exit('No direct script access allowed');

class BroadcastingModel extends CI_Model
{


	public function __construct(){				
		$this->load->database();			
		$this->load->model('FirebaseModel', 'firebaseModel');
		$this->load->model('UserModel', 'userModel');
    }
    
    public function lists()
    {
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('broadcasting');

        return $query->result();
    }

   

    public function save()
    {
        $id = 0;
        $field = array(
            'message' => $this->input->post('text'),
        );
        $this->db->set('date', 'NOW()', FALSE);
        $this->db->insert('broadcasting', $field);
        $id = $this->db->insert_id();
        
        $title = "News by Parashwanath Steel Center";
        $message = $this->input->post('text');
        $users = $this->userModel->lists();
        foreach ($users as $user) {
            if($user->firebaseid != ""){
                $this->firebaseModel->sendNotification($user->firebaseid, $title, $message);
            }
        }
        return "success" ;
    }

    public function getbyid($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('broadcasting');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    

    public function delete($id)
    {
       
        $this->db->where('id', $id);
        $this->db->delete('broadcasting');
    }
}
