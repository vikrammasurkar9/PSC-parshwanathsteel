<?php

require(APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS,POST");

class Authentication extends REST_Controller {

    function __construct(){
		parent:: __construct();
		$this->load->model('UserModel', 'user');
		$this->load->model('MailModel', 'mail');
	}
	
	public function login_post()
	{ 
		$mobileno = $this->input->post('mobileno');
		$password = $this->input->post('password');
		$reply = $this->user->getuserdataforlogin($mobileno, $password);
		if($reply == false)
		{
			$dataarray=array();
			$result=array();
			$result['status'] = "fail";
			$result['id'] = 0;
			$result['name'] = "";
			$result['mobileno'] = "";
			$result['firebaseid'] = "";
			//$this->response($result, 200);
			array_push($dataarray, $result);
			header('Content-Type: application/json');
			echo json_encode(array("data"=>$dataarray));
		}
		else{
		    
		    $query = "UPDATE users SET source = 'app' WHERE id = " . $reply->id;
			$this->db->query($query);
		    
			$dataarray=array();
			$result=array();
			$result['status'] = "success";
			$result['id'] = $reply->id;		
			$result['name'] = $reply->name;
			$result['mobileno'] = $reply->mobileno;
			$result['profession'] = $reply->profession;
			$result['email'] = $reply->email;
			$result['firebaseid'] = $reply->firebaseid;
			$result['joiningdate'] = $reply->joiningdate;
			//$this->response($result, 200);
			array_push($dataarray, $result);
			header('Content-Type: application/json');
			echo json_encode(array("data"=>$dataarray));
		}
	}

	public function updatefirebaseid_post()
	{ 
		$id = $this->input->post('id');
		$firebaseid = $this->input->post('firebaseid');
		if($firebaseid != "")
		{
			$query = "UPDATE users SET firebaseid = '" . $firebaseid . "' WHERE id = " . $id;
			$this->db->query($query);
		}
		$dataarray=array();
		$result=array();
		$result['status'] = "success";
		array_push($dataarray, $result);
		header('Content-Type: application/json');
		echo json_encode(array("data"=>$dataarray));
	}

	public function forgotpassword_post()
	{ 
		$mobileno = $this->input->post('mobileno');
		$reply = $this->user->getuserdataformobileno($mobileno);
		if($reply == false)
		{
			$dataarray=array();
			$result=array();
			$result['status'] = "fail";
			array_push($dataarray, $result);
			header('Content-Type: application/json');
			echo json_encode(array("data"=>$dataarray));
		}
		else{
			$dataarray=array();
			$result=array();
			$result['status'] = "success";			
			array_push($dataarray, $result);
			header('Content-Type: application/json');

			// $message = "Hello ". $reply->name .", <br />";
			// $message .= "your password for Robin Hood Army Application is : " . $reply->password . "<br />";
			// $message .= "Regards, Team Robin Hood Army";

			// $subject = "Password for your account";			
			//$mail->sendMail($reply->email, $subject, $message);
			echo json_encode(array("data"=>$dataarray));
		}
	}

	public function signup_post()
	{ 
		if(!$this->user->exists())
		{
			$id = $this->user->register();
			$dataarray=array();
			$result=array();
			$result['status'] = "success";
			$result['id'] = $id;
			array_push($dataarray, $result);
			header('Content-Type: application/json');
			echo json_encode(array("data"=>$dataarray));
		}
		else
		{
			$dataarray=array();
			$result=array();
			$result['status'] = "exists";
			$result['data'] = "exists";
			$result['id'] = "0";
			array_push($dataarray, $result);
			header('Content-Type: application/json');
			echo json_encode(array("data"=>$dataarray));
		}
	}
}