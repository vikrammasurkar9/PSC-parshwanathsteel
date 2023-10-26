<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ProfessionModel extends CI_Model
{
    public function lists()
    {
        $query = 'SELECT * FROM professions ORDER BY id';
        $query = $this->db->query($query);

        return $query->result();
    }

    public function save()
    {
        $field = array(
            'name' => $this->input->post('name'),
        );
        if ($this->input->post('id') == 0) {            
            $this->db->insert('professions', $field);
            $id = $this->db->insert_id();
        } else {
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('professions', $field);
        }
        return $id;
    }

    public function getbyid($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('professions');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }



    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('professions');
    }
}