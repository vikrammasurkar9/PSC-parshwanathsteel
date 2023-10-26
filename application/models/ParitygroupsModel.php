<?php
  class ParitygroupsModel extends CI_Model {
       
	public function __construct(){				
		$this->load->database();	
        $this->load->model('DBModel', 'dbmodel');
	}     

	public function lists($brandid){
        $query = "SELECT *, (SELECT name FROM brands AS B WHERE B.id = brandid) AS brandname, ";
        $query .= "(SELECT COUNT(*) FROM paritygroupproducts WHERE pgroupid = PG.id) AS productscount ";
        $query .= "FROM paritygroups AS PG ";
        if($brandid != 0)
            $query .= "WHERE brandid = " . $brandid . " ";
        $query .= "ORDER BY id";
        return $this->dbmodel->getdata($query);
	}
    
  	public function save(){	
		$field = array(
            'brandid'=>$this->input->post('brandid'),
			'name'=>$this->input->post('name'),
		);
		if ($this->input->post('id') == 0) {            
            $this->db->insert('paritygroups', $field);
            $id = $this->db->insert_id();
        } else {
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('paritygroups', $field);
		}
		return "success";		
	}
	
	public function getbyid($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('paritygroups');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
	}
	public function delete($id)
    {       
        $this->db->where('id', $id);
        $this->db->delete('paritygroups');
    }
}