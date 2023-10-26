<?php
  class RequestModel extends CI_Model {
	
	var $baseRequests = 100;

	public function __construct(){				
		$this->load->database();			
		$this->load->model('FirebaseModel', 'firebaseModel');
		$this->load->model('UserModel', 'userModel');
		$this->load->model('AdminModel', 'adminModel');
		$this->load->model('SpotsModel', 'spotsModel');
	}

	public function pickupRequests(){
		$volunteerid = $this->input->post('volunteerid');
		$donorid = $this->input->post('donorid');
		$query = "SELECT R.id, D.id AS donorid, D.name AS donorname, D.mobileno AS donormobileno, ";
		$query .= "IFNULL(V.id, 0) AS volunteerid, IFNULL(V.name, '') AS volunteername, IFNULL(V.mobileno, '') AS volunteermobileno, ";
		$query .= "R.latitude, R.longitude, R.pickuptime,  DATE_FORMAT(R.createdon, '%d %M %Y') AS requesteddate, R.menus, R.status, R.persons, ";				
		$query .= "R.vremark, R.dremark FROM requests AS R LEFT OUTER JOIN users AS D ON R.donorid = D.id ";
		$query .= "LEFT OUTER JOIN users AS V ON R.volunteerid = V.id WHERE R.id <> 0 ";
		if($donorid != 0)
			$query .= "AND R.donorid = " . $donorid . " ";
		if($volunteerid != 0)
			$query .= "AND R.volunteerid IN(0, " . $volunteerid . ") ";
		$query .= "ORDER BY R.id DESC";

		$data = $this->db->query($query);
		return $data->result();
	}

	public function updateRequest(){
		$volunteerid = $this->input->post('volunteerid');
		$status = $this->input->post('status');
		$requestid = $this->input->post('requestid');
		$query = "UPDATE requests SET volunteerid = ".$volunteerid. ",status ='".$status."'  WHERE id = ".$requestid;
		$this->db->query($query);


		$user = $this->userModel->getbyid($volunteerid);
		$volunteers = $this->userModel->VolunteerList();
		if($status == 'Accepted'){
			$title = "Request accepted by " . $user->name;		
			$message = $user->name . " accepted request. He will collect food.";
			foreach ($volunteers as $volunteer) {
				if($volunteer->id != $volunteerid){					
					$this->firebaseModel->sendNotification($volunteer->firebaseId, $title, $message);
				}
			}
			$admins = $this->adminModel->list();
			foreach ($admins as $admin) {		
				if($admin->firebaseId != ""){		
					$this->firebaseModel->sendNotification($admin->firebaseId, $title, $message);
				}
			}
			$request = $this->getbyid($requestid);
			$donor = $this->userModel->getbyid($request->donorid);
			$title = "Your request is accepted by " . $user->name;
			$message = "Hello " . $donor->name . ", thank you for food donation. Your food will be collected by " . $user->name;
			$this->firebaseModel->sendNotification($donor->firebaseId, $title, $message);
		}
		else if($status == 'Collected'){
			$title = "Food collected by " . $user->name;
			$message = $user->name . " collected food.";
			foreach ($volunteers as $volunteer) {
				if($volunteer->id != $volunteerid){
					if($volunteer->firebaseId != ""){
						$this->firebaseModel->sendNotification($volunteer->firebaseId, $title, $message);
					}
				}
			}
			$admins = $this->adminModel->list();
			foreach ($admins as $admin) {		
				if($admin->firebaseId != ""){		
					$this->firebaseModel->sendNotification($admin->firebaseId, $title, $message);
				}
			}
		}
		else if($status == 'Distributed'){
			$request = $this->getbyid($requestid);
			$donor = $this->userModel->getbyid($request->donorid);
			$title = "Food distributed by " . $user->name;
			$message = "Hello " . $donor->name . ", thank you for food donation. Your food is distributed.";
			$this->firebaseModel->sendNotification($donor->firebaseId, $title, $message);
		}
	}

	public function volunteerRemark(){
		//$volunteerid = $this->input->post('volunteerid');
		$requestid = $this->input->post('requestid');		
		$status = $this->input->post('status');
		$vremark = $this->input->post('vremark');
		$spot = $this->input->post('spot');
		$feeds = $this->input->post('feeds');
		$vremark = str_replace("'", "''", $vremark);

		$spotid = $this->spotsModel->getbyname($spot);

		$query = "UPDATE requests SET vremark = '".$vremark. "', status ='".$status."', ";
		$query .= "feedpersons = " . $feeds . ", spotid = " . $spotid . " ";
		$query .= "WHERE id = ".$requestid;
		$this->db->query($query);

		$request = $this->getbyid($requestid);
		$user = $this->userModel->getbyid($request->volunteerid);
		$volunteers = $this->userModel->VolunteerList();

		if($status == 'Collected'){
			$title = "Food collected by " . $user->name;
			$message = $user->name . " collected food.";
			foreach ($volunteers as $volunteer) {
				if($volunteer->id != $request->volunteerid){
					if($volunteer->firebaseId != ""){
						$this->firebaseModel->sendNotification($volunteer->firebaseId, $title, $message);
					}
				}
			}
			$admins = $this->adminModel->list();
			foreach ($admins as $admin) {		
				if($admin->firebaseId != ""){		
					$this->firebaseModel->sendNotification($admin->firebaseId, $title, $message);
				}
			}
		}
		else if($status == 'Distributed'){
			$request = $this->getbyid($requestid);
			$donor = $this->userModel->getbyid($request->donorid);
			$title = "Food distributed by " . $user->name;
			$message = "Hello " . $donor->name . ", thank you for food donation. Your food is distributed.";
			$this->firebaseModel->sendNotification($donor->firebaseId, $title, $message);
		}
	}

	public function RequestList(){
		$query = "SELECT R.id, D.id AS donorid, D.name AS donorname, D.mobileno AS donormobileno, ";
		$query .= "IFNULL(V.id, 0) AS volunteerid, IFNULL(V.name, '') AS volunteername, IFNULL(V.mobileno, '') AS volunteermobileno, ";
		$query .= "R.pickuptime,  DATE_FORMAT(R.createdon, '%d %M %Y') AS requesteddate, R.status, R.persons ";
		$query .= "FROM requests AS R LEFT OUTER JOIN users AS D ON R.donorid = D.id ";
		$query .= "LEFT OUTER JOIN users AS V ON R.volunteerid = V.id";
		$query .= " ORDER BY R.id DESC";
		$data = $this->db->query($query);
		return $data->result();		
	}

	
	public function getbyid($id){  
		$query = "SELECT *, DATE_FORMAT(createdon, '%d %M %Y') AS requesteddate FROM requests WHERE id = " . $id;
		$data = $this->db->query($query);		
		$result = $data->result();
		return $result[0];
	}

	public function getcountofrequest($id){  
		$query = "SELECT COUNT(*) AS rcount FROM requests WHERE id <= " . $id;
		$data = $this->db->query($query);		
		$result = $data->result();
		$row = $result[0];
		return $row->rcount;
	}
   
    public function delete($id){
       	$this->db->where('id', $id);
       	if($this->db->delete('requests'))
			return true;
		else
          return false;
   }
   
  	public function insert(){
		$status = "Requested";
		$field = array(
			'donorid'=>$this->input->post('donorid'),
			'latitude'=>$this->input->post('latitude'),
			'longitude'=>$this->input->post('longitude'),
			'pickuptime'=>$this->input->post('pickuptime'),
			'menus'=>$this->input->post('menus'),
			'persons'=>$this->input->post('persons'),
			'volunteerid'=>$this->input->post('volunteerid'),
			'status' =>$status
		);
		$this->db->insert('requests', $field);
		$id = $this->db->insert_id();

		$volunteers = $this->userModel->VolunteerList();
		$title = "New pickup request received.";		
		foreach ($volunteers as $volunteer) {
			if($volunteer->firebaseId != ""){		
				$message = "Hello " . $volunteer->name . ", we have received pickup request. Please do needful.";
				$this->firebaseModel->sendNotification($volunteer->firebaseId, $title, $message);
			}
		}

		$admins = $this->adminModel->list();
		foreach ($admins as $admin) {
			if($admin->firebaseId != ""){		
				$message = "Hello " . $admin->name . ", we have received pickup request. Please do needful.";
				$this->firebaseModel->sendNotification($admin->firebaseId, $title, $message);
			}
		}
		return $id;
	}
	
	public function count(){  
		$data = $this->db->get('requests');
		return $data->num_rows();
	}

	public function pickupcount(){  
		$this->db->where('status', "Requested");
		$data = $this->db->get('requests');
		return $data->num_rows();
	}

	public function mypickupcount($volunteerid){
		$query = "SELECT * FROM requests WHERE volunteerid = " . $volunteerid . " AND status = 'Accepted' ";
		$data = $this->db->query($query);
		return $data->num_rows();
	}
}
?>
