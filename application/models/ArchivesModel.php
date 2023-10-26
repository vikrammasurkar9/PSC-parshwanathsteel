<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ArchivesModel extends CI_Model
{


	public function __construct(){				
		$this->load->database();			
		$this->load->model('FirebaseModel', 'firebaseModel');
		$this->load->model('UserModel', 'userModel');
    }
    
    public function lists()
    {
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('archives');

        return $query->result();
    }

   

    public function save()
    {
        $id = 0;
        date_default_timezone_set('Asia/Kolkata');
        $now = date('Y-m-d H:i:s'); 
        $field = array(
            'title' => $this->input->post('title'), 
            'description' => $this->input->post('description'), 
            'createdon' => $now,
        );
        if ($this->input->post('id') == 0) {            
            $this->db->insert('archives', $field);
            $id = $this->db->insert_id();
        } else {
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('archives', $field);
        }

       

        if (isset($_FILES['file']) && is_uploaded_file($_FILES['file']['tmp_name'])) {

            $urltitle = preg_replace("/[^a-zA-Z0-9]/", "-", $this->input->post('title'));
            $urltitle = preg_replace('!\-+!', '-', $urltitle);

            $target_dir = '././archives/' . $urltitle . '.pdf';
            if (file_exists($target_dir)) {
                unlink($target_dir);
            }
            move_uploaded_file($_FILES['file']['tmp_name'], $target_dir);
            $field = array(
                'link'=>$urltitle,
            );
            $this->db->where('id', $id);
            $this->db->update('archives', $field);
        }
        
        
        return "success" ;
    }

    public function getbyid($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('archives');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    

    public function delete($id)
    {
       
        $this->db->where('id', $id);
        $this->db->delete('archives');
    }
}
