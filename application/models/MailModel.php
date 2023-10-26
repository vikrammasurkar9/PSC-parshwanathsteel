<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MailModel extends CI_Model{
	function __construct() {
        parent::__construct();
    }
	public function sendMail($to, $subject, $body){	
		try{
			require_once __DIR__ . '/mailer/class.phpmailer.php';
			require_once __DIR__ . '/mailer/PHPMailerAutoload.php';

			$mail = new PHPMailer;
			$mail ->isSMTP();
			$mail ->Host='smtp.gmail.com';
			$mail ->Port=587; 
			$mail ->SMTPSecure='tls';
			$mail ->SMTPAuth='true';
			$mail ->Username="messagefromwebsites@gmail.com";
			$mail ->Password="iGAP@Tech";
			$mail ->FromName='Robin Hood Army, Kolhapur';
			$mail ->addAddress($to);
			$mail ->Subject = $subject;
			$mail ->msgHTML($body);
			$result = "sent";
			if (!$mail->send()) {
				$result = "failed " . $mail->ErrorInfo;
			}
			return $result;
		}
		catch(Exception $ex){
			return "exception";
		}
	}
	
}
