<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class FirebaseModel extends CI_Model{
	function __construct() {
        parent::__construct();
	}
	
	public function sendNotification($firebaseid, $title, $message)
	{
			ini_set('display_errors', 'On');
			require_once 'Firebase.php';
			require_once 'Push.php';
			$firebase = new Firebase();
			$push = new Push();
			$include_image = TRUE;
			$push->setTitle($title);
			$push->setMessage($message);
			$push->setImage('https://parshwanathsteel.com/app/sliderpics/7.png');
			$json = $push->getPush();
			$firebase->send($firebaseid, $json);
	}
}
