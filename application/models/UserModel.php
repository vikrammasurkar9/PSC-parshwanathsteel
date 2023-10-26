<?php
  class UserModel extends CI_Model {
       
	public function __construct(){				
		$this->load->database();			
		// $this->load->model('FirebaseModel', 'firebaseModel');
		// $this->load->model('AdminModel', 'adminModel');
	}     
	public function lists(){
	    $query = "SELECT * FROM users ";
	    if(isset($_GET['type']))
	    {
	        $query .= "WHERE source = '" . $_GET['type'] . "' ";
	    }
	    $query .= "ORDER BY createdon DESC";
	    
		return $this->db->query($query)->result();

// 		$query = "SELECT * FROM users WHERE source = 'app'";
$query = "SELECT * FROM users ORDER BY id DESC";
		$data = $this->db->query($query);
		//$result = $data->result();
		return $data->result();		
	}
  	public function register(){
		$field = array(
			'name'=>$this->input->post('name'),
			'email'=>$this->input->post('email'),
			'mobileno'=>$this->input->post('mobileno'),
			'password'=>$this->input->post('password'),
			'profession'=>$this->input->post('profession'),
			'source'=>'app',
		);
		$this->db->insert('users', $field);
		$id = $this->db->insert_id();
		return $id;
	}

public function save()
    {
        $id = 0;

		if(isset($_POST['firmname']))
		{
			$firmname = $this->input->post('firmname');
		}
		else{
			$firmname = $this->input->post('name');
		}

        $field = array(
            'name' => $this->input->post('name'),
			'firmname' => $firmname,
            'email' => $this->input->post('email'),
            'mobileno' => $this->input->post('mobileno'),
            'profession' => $this->input->post('profession'),
        );
        if ($this->input->post('id') == 0) {            
            $this->db->insert('users', $field);
            $id = $this->db->insert_id();
        } else {
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('users', $field);
        }
        return "success";
        //return $id;
    }
	
	public function exists(){
		$mobileno = $this->input->post("mobileno");
		$query = "SELECT * FROM users WHERE mobileno = '" . $mobileno . "'";		
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
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
	}
	
	public function getuserdataforlogin($mobileno, $password)
	{
		$mobileno = str_replace("'", "''", $mobileno);
		$password = str_replace("'", "''", $password);
		$query = "SELECT *, DATE_FORMAT(createdon,'%d/%m/%Y') AS joiningdate FROM users ";
		$query .= "WHERE mobileno = '" . $mobileno . "' AND password = '" . $password . "' AND source = 'app' ";
		$data = $this->db->query($query);
		$result = $data->result();
		if(sizeof($result) > 0)
		{
			foreach($result as $row){
				$data = $row;
			}
			return $data;
		}
		else{
			return false;		
		}	
	}

	public function getuserdataformobileno($mobileno)
	{
		$mobileno = str_replace("'", "''", $mobileno);
		$query = "SELECT * FROM users WHERE mobileno = '" . $mobileno . "'";
		$data = $this->db->query($query);
		$result = $data->result();
		if(sizeof($result) > 0)
		{
			foreach($result as $row){
				$data = $row;
			}
			return $data;
		}
		else
			return false;		
	}

	public function getuserdatafornameandmobileno($name, $mobileno)
	{
		$name = str_replace("'", "''", $name);
		$mobileno = str_replace("'", "''", $mobileno);
		$query = "SELECT * FROM users WHERE name = '" . $name . "' AND mobileno = '" . $mobileno . "'";
		$data = $this->db->query($query);
		$result = $data->result();
		if(sizeof($result) > 0)
		{
			foreach($result as $row){
				$data = $row;
			}
			return $data;
		}
		else
			return false;		
	}
}