<?php

defined('BASEPATH') or exit('No direct script access allowed');

class BrandsModel extends CI_Model
{
    public function lists()
    {
        $query = "SELECT *, (SELECT COUNT(*) FROM productweights AS PW, brandproducts AS BP WHERE PW.id = BP.pwid AND BP.bid = brands.id) AS productcount, ";
        $query .= "(SELECT name FROM producers AS P WHERE P.id = producerid) AS producername, ";
        $query .= "(SELECT IFNULL(name, '') FROM brandgroups AS BG WHERE BG.id = bgid) AS bgname, ";
        $query .= "(SELECT COUNT(*) FROM paritygroups AS PG WHERE brands.id = PG.brandid) AS paritygroupcount ";
        $query .= "FROM brands ORDER BY srno";
        $result = $this->db->query($query);
        return $result->result();
    }

    public function producers()
    {
        $query = "SELECT * FROM producers";
        $result = $this->db->query($query);
        return $result->result();
    }
    
    public function onlyproducts($brandid)
    {
        $query = "SELECT *, C.name AS categoryname, P.product productname, BP.id AS bpid, PW.id AS bpwid ";
        $query .= "FROM categories AS C INNER JOIN products AS P ON C.id = P.categoryid ";
        $query .= "INNER JOIN productweights AS PW ON P.id = PW.pid ";
        $query .= "INNER JOIN brandproducts AS BP ON PW.id = BP.pwid ";
        $query .= "AND BP.bid = " . $brandid . " ";
        if(isset($_GET['category']))
        {
            $query .= "WHERE PW.pid = " . $_GET['category'] . " ";
        }
        $query .= "ORDER BY C.id, P.srno, PW.sizeinmm";

        // echo $query;
        // exit;
        $result = $this->db->query($query);
        return $result->result();
    }

    public function products($brandid)
    {
        $query = "SELECT *, C.name AS categoryname, P.product productname, BP.id AS bpid, PW.id AS bpwid ";
        $query .= "FROM categories AS C INNER JOIN products AS P ON C.id = P.categoryid ";
        $query .= "INNER JOIN productweights AS PW ON P.id = PW.pid ";
        $query .= "LEFT OUTER JOIN brandproducts AS BP ON PW.id = BP.pwid ";
        $query .= "AND BP.bid = " . $brandid . " ";
        if(isset($_GET['category']))
        {
            $query .= "WHERE PW.pid = " . $_GET['category'] . " ";
        }
        $query .= "ORDER BY C.id, P.srno, PW.srno";

        // echo $query;
        // exit;
        $result = $this->db->query($query);
        return $result->result();
    }

    public function brandproducts()
    {
        $query = "SELECT * FROM brandproducts";
        $result = $this->db->query($query);
        return $result->result();
    }

    public function save()
    {
        $id = 0;

        if($this->checkifproductexist($this->input->post('name'), $this->input->post('id'))){
            return "false";
        }
        $field = array(
            'bgid' => 0,
            'name' => $this->input->post('name'),
            'producerid' => $this->input->post('producerid'),
            'showonwebsite' => $this->input->post('showonwebsite'),
            'srno' => $this->input->post('srno'),
        );
        if ($this->input->post('id') == 0) {            
            $this->db->insert('brands', $field);
            $id = $this->db->insert_id();
        } else {
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('brands', $field);
        }

        if (isset($_FILES['pic']) && is_uploaded_file($_FILES['pic']['tmp_name'])) {
			$target_dir = '././brandpics/' . $id . '.png';			
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
        $query = $this->db->get('brands');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function checkifproductexist($name, $id)
    {
        $query = "SELECT * FROM brands WHERE name = '" . $name . "' AND id <> " . $id;        
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
        $this->db->delete('brands');
    }
}
