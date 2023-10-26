<?php

defined('BASEPATH') or exit('No direct script access allowed');

class EnquirysourcesModel extends CI_Model
{
    public function lists()
    {
        $query = 'SELECT * FROM enquirysources ORDER BY id';
        $query = $this->db->query($query);

        return $query->result();
    }

    public function save()
    {
        $field = array(
            'name' => $this->input->post('name'),
        );
        if ($this->input->post('id') == 0) {            
            $this->db->insert('enquirysources', $field);
            $id = $this->db->insert_id();
        } else {
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('enquirysources', $field);
        }
        return $id;
    }

    public function getbyid($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('enquirysources');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }



    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('enquirysources');
    }
}