<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ProductweightModel extends CI_Model
{
    public function lists()
    {
        $query = "SELECT *, (SELECT COUNT(*) FROM brandproducts AS BP WHERE BP.pwid = PW.id) AS bcount FROM productweights AS PW ORDER BY sizeinmm";
        $query = $this->db->query($query);
        return $query->result();
    }   

    public function listAll()
    {
        $query = "SELECT * FROM productweights ORDER BY sizeinmm";
        $query = $this->db->query($query);
        return $query->result();
    }   

    public function save()
    {
        $id = 0;
        if ($this->checkifsizeexist($this->input->post('pid'), $this->input->post('sizeinmm'), $this->input->post('id'))) {
            return "false";
        }
        $field = array(
            'pid' => $this->input->post('pid'),
            'sizeinmm' => trim($this->input->post('sizeinmm')),
            'weight' => trim($this->input->post('weight')),
            'srno' => $this->input->post('srno'),
        );
        if ($this->input->post('id') == 0) {            
            $this->db->insert('productweights', $field);
            $id = $this->db->insert_id();
        } 
        else {
            $id = $this->input->post('id');           
            $this->db->where('id', $id);
            $this->db->update('productweights', $field);
        }
        $count = $this->input->post('bcount');
        for($i = 1; $i <= $count; $i++)
        {
            $bid = $this->input->post('bid' . $i);
            $query = "DELETE FROM brandproducts WHERE bid = " . $bid . " AND pwid = " . $id;
            $this->db->query($query);
            if($this->input->post('brand' . $i))
            {
                $query = "INSERT INTO brandproducts(bid, pwid) VALUES(" . $bid . ", " . $id . ")";
                $this->db->query($query);
            }
        }
        return "success" ;
    }

    public function getbyid($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('productweights');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function productweightlistbypid($pid)
    {
        $query = "SELECT *, (SELECT COUNT(*) FROM brandproducts AS BP WHERE BP.pwid = PW.id) AS bcount, ";
        $query .= "(SELECT products.product FROM products WHERE products.id = PW.pid) AS categoryname ";
        $query .= "FROM productweights AS PW ";
        if($pid != 0)
            $query .= "WHERE pid = ". $pid  . " ";
        $query .= "ORDER BY PW.sizeinmm";
        $result = $this->db->query($query);
        return $result->result();
    }
   
    public function checkifsizeexist($pid, $size, $id)
    {
        $query = "SELECT * FROM productweights WHERE pid = " . $pid . " AND sizeinmm = '" . $size . "' AND id <> " . $id;        
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function brandwiseproductweights($id)
    {
        $query = "SELECT B.*, (SELECT COUNT(*) FROM brandproducts AS BP WHERE BP.bid = B.id AND BP.pwid = " . $id . ") AS presentcount ";
        $query .= "FROM brands AS B ORDER BY B.srno";
        $result = $this->db->query($query);
        return $result->result();
    }

    public function delete($id)
    {
       
        $this->db->where('id', $id);
        $this->db->delete('productweights');
    }
}
