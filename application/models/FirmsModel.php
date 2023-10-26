<?php

defined('BASEPATH') or exit('No direct script access allowed');

class FirmsModel extends CI_Model
{


	public function __construct(){				
		$this->load->database();			
		$this->load->model('FirebaseModel', 'firebaseModel');
		$this->load->model('UserModel', 'userModel');
    }
    
    public function lists()
    {
        // $this->db->order_by('id', 'DESC');
        $query = $this->db->get('firms');

        return $query->result();
    }

   

    public function save()
    {
        $id = 0;
        date_default_timezone_set('Asia/Kolkata');
        $now = date('Y-m-d H:i:s'); 
        $field = array(
            'firm' => $this->input->post('firm'), 
            'address' => $this->input->post('address'), 
            'email' => $this->input->post('email'), 
            'telephone' => $this->input->post('telephone'), 
            'mobileno' => $this->input->post('mobileno'), 
            'gst' => $this->input->post('gst'), 
            'accholder' => $this->input->post('accholder'), 
            'accno' => $this->input->post('accno'), 
            'ifsc' => $this->input->post('ifsc'), 
            'bank' => $this->input->post('bank'), 
            'branch' => $this->input->post('branch'), 
            
        );
        if ($this->input->post('id') == 0) {            
            $this->db->insert('firms', $field);
            $id = $this->db->insert_id();
        } else {
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('firms', $field);
        }

       

        
        
        
        return "success" ;
    }

    public function getbyid($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('firms');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    

    public function delete($id)
    {
       
        $this->db->where('id', $id);
        $this->db->delete('firms');
    }
}
