<?php

defined('BASEPATH') or exit('No direct script access allowed');

class SliderModel extends CI_Model
{
    public function lists()
    {
        $query = 'SELECT * FROM slider ORDER BY id';
        $query = $this->db->query($query);

        return $query->result();
    }

    public function save()
    {

        $urltitle = $this->input->post('title');
        $urltitle = str_replace(' ', '_', $urltitle);
        $urltitle = str_replace('/', '_', $urltitle);
        $urltitle = str_replace("'", '_', $urltitle);

        $field = array(

            'title' => $this->input->post('title'),
            'urltitle' => $urltitle,

        );
        $this->db->insert('slider', $field);
        $id = $this->db->insert_id();

        if (isset($_FILES['pic']) && is_uploaded_file($_FILES['pic']['tmp_name'])) {
            $target_dir = '././sliderpics/' . $id . '.png';
            if (file_exists($target_dir)) {
                unlink($target_dir);
            }

            move_uploaded_file($_FILES['pic']['tmp_name'], $target_dir);
        }

        return $id;
    }

    public function getbyid($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('slider');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }



    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('slider');
    }
}