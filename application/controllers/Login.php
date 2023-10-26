<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("session");
        $this->load->helper("cookie");
		$this->load->model('CookieModel', 'cookie');        
        $this->load->model('FirmsModel', 'firm');
    }
    

    public function index()
    {
        $data['firms'] = $this->firm->lists();
        $this->load->view('login',$data);
    }

    public function checklogin()
    { 
        $firmid = str_replace("'", "''", $this->input->post('firm'));
        $username = str_replace("'", "''", $this->input->post('username'));
        $password = str_replace("'", "''", $this->input->post('password'));
    
        $query = "SELECT * FROM firms WHERE id = " . $firmid ;
		$firms = $this->db->query($query); 
        $firm = $firms->result()[0];

        
        $query = "SELECT * FROM admins WHERE username = '" . $username . "' AND password = '" . $password . "'";
		$data = $this->db->query($query);             
		if ($data->num_rows() > 0) {
			$result = $data->result();
			foreach ($result as $row) {
				$this->load->helper('cookie');
				$this->cookie->setCookie('name', $row->username);
				$this->cookie->setCookie('usertype', 'pscadmin');
                $this->cookie->setCookie('firm', $firm->firm);
                $this->cookie->setCookie('firmid', $firm->id);
                $this->cookie->setCookie('firmcolor', $firm->firmcolor);
                // $this->cookie->setCookie('type', $row->usertype);
				$this->cookie->setCookie('adminid', $row->id);
				redirect(base_url('admin'));
			}
		}
        else if($username == 'superadmin' && $password == 'Forestgump@1901'){
            $this->load->helper('cookie');
            $this->setCookie('usertype', 'superadmin');
            $this->setCookie('id', '0');
            redirect(base_url('superadmin/dashboard'));
        } 
        
		else{
            $this->session->set_flashdata('error_msg', 'Username or password is wrong');
            redirect(base_url('login'));
        }
        

    }
    public function setCookie($name, $value)
    {
        $cookie = array(
            'name' => $name,
            'value' => $value,
            'expire' => '31556926',
        );
        $this->input->set_cookie($cookie);
    }

    public function getCookie($name)
    {
        return $this->input->cookie($name, true);
    }

    public function clearCookie($name)
    {
        $cookie = array(
            'name' => $name,
            'value' => '',
            'expire' => '-3600',
        );
        $this->input->set_cookie($cookie);
    }

    public function logout()
    {
        // $this->clearCookie('name');
        // $this->clearCookie('usertype');
		// $this->clearCookie('adminid');
        // $this->clearCookie('firm');
        // $this->clearCookie('firmid');
		// $this->clearCookie('firmcolor');
        // $this->session->unset_userdata('name');
		// $this->session->unset_userdata('usertype');
		// $this->session->unset_userdata('adminid');
        // $this->session->unset_userdata('firm');
        // $this->session->unset_userdata('firmid');
		// $this->session->unset_userdata('firmcolor');
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', time()-1000);
                setcookie($name, '', time()-1000, '/');
            }
        }
        redirect(base_url());
    }

}
