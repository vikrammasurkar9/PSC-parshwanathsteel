<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ProductsModel extends CI_Model
{
    public function lists()
    {
        $query = "SELECT P.*, C.name AS categoryname, (SELECT COUNT(pid) FROM productweights AS PW WHERE P.id = PW.pid) AS pweightcount FROM products AS P, categories AS C WHERE P.categoryid = C.id ORDER BY P.srno";
        $result = $this->db->query($query);
        return $result->result();
    }

    public function save()
    {
        $id = 0;

        if($this->checkifproductexist($this->input->post('product'),$this->input->post('id'))){
            return "false";
        }
        $field = array(
            'categoryid' => $this->input->post('categoryid'),
            'product' => $this->input->post('product'),
            'type' => $this->input->post('type'),
            'billingin' => $this->input->post('billingin'),
            'srno' => $this->input->post('srno'),
        );
        if ($this->input->post('id') == 0) {            
            $this->db->insert('products', $field);
            $id = $this->db->insert_id();
        } else {
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('products', $field);
        }

        if (isset($_FILES['pic']) && is_uploaded_file($_FILES['pic']['tmp_name'])) {
			$target_dir = '././productpics/' . $id . '.png';			
            if (file_exists($target_dir)) {
                unlink($target_dir);
            }
			move_uploaded_file($_FILES['pic']['tmp_name'], $target_dir);
        }
        return "success";
        //return $id;
    }

    public function getbyid($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('products');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    
    public function checkifproductexist($product, $id)
    {
        $query = "SELECT * FROM products WHERE product = '" . $product . "' AND id <> " . $id;
        
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
       
        $this->db->where('id', $id);
        $this->db->delete('products');
    }
}
