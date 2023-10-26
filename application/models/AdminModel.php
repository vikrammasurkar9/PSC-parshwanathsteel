<?php
  class AdminModel extends CI_Model {
       
	public function __construct(){				
		$this->load->database();	
	}     
	public function lists(){
		$this->db->order_by('id');
		$query = $this->db->get('admins');
		return $query->result();		
	}
  	public function save(){

		date_default_timezone_set('Asia/Kolkata');
		$now = date('Y-m-d H:i:s');
		
		
		
		$field = array(
			'name'=>$this->input->post('name'),
			'position'=>$this->input->post('position'),
			'username'=>$this->input->post('username'),
			'password'=>$this->input->post('password'),
			'mobileno'=>$this->input->post('mobileno'),
			'wakey'=>$this->input->post('wakey'),
			'createdon'=>$now,
		);
		if ($this->input->post('id') == 0) {    
			if($this->exists($this->input->post('username'))){
				return "false";
			}
			else{        
            $this->db->insert('admins', $field);
            $id = $this->db->insert_id();
			}
        } else {
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('admins', $field);
		}
		return "success";
		
	}
	
	public function exists($username){
		$query = "SELECT * FROM admins WHERE username = '" . $username . "'";		
		$data = $this->db->query($query);
		$result = $data->result();
		if(sizeof($result) > 0)
			return true;
		else
			return false;
    }
	
	public function getbyid($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('admins');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
	}
	public function delete($id)
    {       
        $this->db->where('id', $id);
        $this->db->delete('admins');
    }
}