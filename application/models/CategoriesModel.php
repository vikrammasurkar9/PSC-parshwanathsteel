<?php

defined('BASEPATH') or exit('No direct script access allowed');

class CategoriesModel extends CI_Model
{


	public function __construct(){				
		$this->load->database();
    }
    
    public function lists()
    {
        $query = "SELECT C.*, (SELECT COUNT(categoryid) FROM products AS P WHERE C.id = P.categoryid) AS productcount FROM categories AS C";
        $result = $this->db->query($query);
        return $result->result();
    }
    

   

    public function save()
    {
        $id = 0;
        $urltitle = preg_replace("/[^a-zA-Z0-9]/", "-", $this->input->post('name'));
        $urltitle = preg_replace('!\-+!', '-', $urltitle);
        $field = array(
            'name' => $this->input->post('name'),
            'title' => $urltitle,
            'showonwebsite' => $this->input->post('showonwebsite'),
        );
        if ($this->input->post('id') == 0) {            
            $this->db->insert('categories', $field);
            $id = $this->db->insert_id();
        } else {
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('categories', $field);
        }
        if (isset($_FILES['pic']) && is_uploaded_file($_FILES['pic']['tmp_name'])) {
			$target_dir = '././categorypics/' . $id . '.png';			
            if (file_exists($target_dir)) {
                unlink($target_dir);
            }
			move_uploaded_file($_FILES['pic']['tmp_name'], $target_dir);
        }
        return "success";
    }

    public function getbyid($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('categories');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    

    public function delete($id)
    {
       
        $this->db->where('id', $id);
        $this->db->delete('categories');
    }
}
