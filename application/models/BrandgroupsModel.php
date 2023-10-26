<?php

defined('BASEPATH') or exit('No direct script access allowed');

class BrandgroupsModel extends CI_Model
{
	public function __construct(){				
		$this->load->database();
    }
    
    public function lists()
    {
        $query = $this->db->get('brandgroups');
        return $query->result();
    }

   

    public function save()
    {
        $id = 0;
        $field = array(
            'name' => $this->input->post('name'),
        );
        if ($this->input->post('id') == 0) {            
            $this->db->insert('brandgroups', $field);
            $id = $this->db->insert_id();
        } else {
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('brandgroups', $field);
        }
        return "success" ;
    }

    public function getbyid($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('brandgroups');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    

    public function delete($id)
    {
       
        $this->db->where('id', $id);
        $this->db->delete('brandgroups');
    }
}
