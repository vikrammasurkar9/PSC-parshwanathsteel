<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('string');
        $this->load->model('UserModel', 'user');
        $this->load->model('DBModel', 'dbmodel');
    }

    public function index()
    {
        $query = "SELECT * FROM reports";
        $data['result'] = $this->dbmodel->getdata($query);

        $query = "SELECT * FROM brands ORDER BY srno";
        $data['brands'] = $this->dbmodel->getdata($query);

        $query = "SELECT * FROM products ORDER BY srno";
        $data['products'] = $this->dbmodel->getdata($query);

        $this->load->view('admin/layout/header'); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('reports/reports', $data);
        $this->load->view('admin/layout/footer');        
    }

    public function savereport()
    {
        $productid = $this->input->post('productid');
        $brandid = $this->input->post('brandid');
        $name = str_replace("'", "''", $this->input->post('name'));

        $query = "INSERT INTO reports(name,productid,brandid) VALUES ('".$name."',".$productid.",". $brandid.")";        
        $this->dbmodel->execute($query);
        redirect(base_url('reports'));
    }

    public function exportreport($id)
    {
        $data['id'] = $id;
        $query = "SELECT name AS svalue FROM reports WHERE id = " . $id;
        $name = $this->dbmodel->getsinglevalue($query);
        $query = "SELECT productid AS svalue FROM reports WHERE id = " . $id;
        $productid = $this->dbmodel->getsinglevalue($query);
        $query = "SELECT brandid AS svalue FROM reports WHERE id = " . $id;
        $brandid = $this->dbmodel->getsinglevalue($query);

        $query = "SELECT DISTINCT P.product, PW.* FROM products AS P, productweights AS PW, brandproducts AS BP ";
        $query .= "WHERE P.id = PW.pid AND BP.pwid = PW.id ";
        if($brandid != 0)
        {
            $query .= "AND BP.bid = " . $brandid . " ";
        }
        if($productid != 0)
        {
            $query .= "AND P.id = " . $productid . " ";
        }
        $query .= "ORDER BY P.categoryid, P.srno, PW.sizeinmm";
        $data['result'] = $this->dbmodel->getdata($query);

        $query = "SELECT * FROM brands ORDER BY srno";
        $data['brands'] = $this->dbmodel->getdata($query);


        $query = "SELECT * FROM brands WHERE id IN(SELECT BP.bid FROM products AS P, productweights AS PW, brandproducts AS BP ";
        $query .= "WHERE P.id = PW.pid AND BP.pwid = PW.id ";
        if($brandid != 0)
        {
            $query .= "AND BP.bid = " . $brandid . " ";
        }
        if($productid != 0)
        {
            $query .= "AND P.id = " . $productid . " ";
        }
        $query .= ") ORDER BY srno";
        $data['brandsTable'] = $this->dbmodel->getdata($query);

        $query = "SELECT * FROM products ORDER BY srno";
        $data['products'] = $this->dbmodel->getdata($query);

        $query = "SELECT * FROM products WHERE id IN(SELECT P.id FROM products AS P, productweights AS PW, brandproducts AS BP ";
        $query .= "WHERE P.id = PW.pid AND BP.pwid = PW.id ";
        if($brandid != 0)
        {
            $query .= "AND BP.bid = " . $brandid . " ";
        }
        if($productid != 0)
        {
            $query .= "AND P.id = " . $productid . " ";
        }
        $query .= ") ORDER BY srno";
        $data['productsTable'] = $this->dbmodel->getdata($query);

        $query = "SELECT * FROM brandproducts AS BP, productweights AS PW, products AS P ";
        $query .= "WHERE P.id = PW.pid AND PW.id = BP.pwid ";
        if($brandid != 0)
        {
            $query .= "AND BP.bid = " . $brandid . " ";
        }
        if($productid != 0)
        {
            $query .= "AND P.id = " . $productid . " ";
        }
        
        $data['brandproducts'] = $this->dbmodel->getdata($query);
        $data['name'] = $name;
        
        $this->load->view('reports/exportreport',$data);
    }

    public function printreport($id)
    {
        $data['id'] = $id;
        $query = "SELECT name AS svalue FROM reports WHERE id = " . $id;
        $name = $this->dbmodel->getsinglevalue($query);
        $data["name"] = $name;
        $query = "SELECT createdon AS svalue FROM reports WHERE id = " . $id;
        $date = $this->dbmodel->getsinglevalue($query);
        $data["date"] = $date;
        $query = "SELECT productid AS svalue FROM reports WHERE id = " . $id;
        $productid = $this->dbmodel->getsinglevalue($query);
        $query = "SELECT brandid AS svalue FROM reports WHERE id = " . $id;
        $brandid = $this->dbmodel->getsinglevalue($query);

        $query = "SELECT DISTINCT P.product, PW.* FROM products AS P, productweights AS PW, brandproducts AS BP ";
        $query .= "WHERE P.id = PW.pid AND BP.pwid = PW.id ";
        if($brandid != 0)
        {
            $query .= "AND BP.bid = " . $brandid . " ";
        }
        if($productid != 0)
        {
            $query .= "AND P.id = " . $productid . " ";
        }
        $query .= "ORDER BY P.categoryid, P.srno, PW.sizeinmm";
        $data['result'] = $this->dbmodel->getdata($query);

        $query = "SELECT * FROM brands ORDER BY srno";
        $data['brands'] = $this->dbmodel->getdata($query);


        $query = "SELECT * FROM brands WHERE id IN(SELECT BP.bid FROM products AS P, productweights AS PW, brandproducts AS BP ";
        $query .= "WHERE P.id = PW.pid AND BP.pwid = PW.id ";
        if($brandid != 0)
        {
            $query .= "AND BP.bid = " . $brandid . " ";
        }
        if($productid != 0)
        {
            $query .= "AND P.id = " . $productid . " ";
        }
        $query .= ") ORDER BY srno";
        $data['brandsTable'] = $this->dbmodel->getdata($query);

        $query = "SELECT * FROM products ORDER BY srno";
        $data['products'] = $this->dbmodel->getdata($query);

        $query = "SELECT * FROM products WHERE id IN(SELECT P.id FROM products AS P, productweights AS PW, brandproducts AS BP ";
        $query .= "WHERE P.id = PW.pid AND BP.pwid = PW.id ";
        if($brandid != 0)
        {
            $query .= "AND BP.bid = " . $brandid . " ";
        }
        if($productid != 0)
        {
            $query .= "AND P.id = " . $productid . " ";
        }
        $query .= ") ORDER BY srno";
        $data['productsTable'] = $this->dbmodel->getdata($query);

        $query = "SELECT * FROM brandproducts AS BP, productweights AS PW, products AS P ";
        $query .= "WHERE P.id = PW.pid AND PW.id = BP.pwid ";
        if($brandid != 0)
        {
            $query .= "AND BP.bid = " . $brandid . " ";
        }
        if($productid != 0)
        {
            $query .= "AND P.id = " . $productid . " ";
        }
        
        $data['brandproducts'] = $this->dbmodel->getdata($query);
        $data['name'] = $name;
                
        $this->load->view('admin/layout/header'); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('reports/printreport',$data);
        $this->load->view('admin/layout/footer');       

    }

    public function newreport()
    {
        if(isset($_GET['name']))
        {
            if($_GET['name'] != "")
            {
                date_default_timezone_set('Asia/Karachi');
               $now = date('Y-m-d H:i:s');

                $productid = $this->input->get('productid');
                $brandid = $this->input->get('brandid');
                $name = str_replace("'", "''", $this->input->get('name'));

                $query = "INSERT INTO reports(name,productid,brandid,createdon) VALUES ('".$name."',".$productid.",". $brandid.",'".$now."')";        
                $this->dbmodel->execute($query);
                $this->session->set_flashdata('success_msg','Report saved.');                
                redirect(base_url('reports/newreport'));
            }
        }
        $showsave = "no";
        $query = "SELECT DISTINCT P.product, PW.* FROM products AS P, productweights AS PW, brandproducts AS BP ";
        $query .= "WHERE P.id = PW.pid AND BP.pwid = PW.id ";
        if(isset($_GET['brandid']))
        {
            $showsave = "yes";
            if($_GET['brandid'] != 0)
            {
                $query .= "AND BP.bid = " . $_GET['brandid'] . " ";
            }
        }
        if(isset($_GET['productid']))
        {
            $showsave = "yes";
            if($_GET['productid'] != 0)
            {
                $query .= "AND P.id = " . $_GET['productid'] . " ";
            }
        }
        $query .= "ORDER BY P.categoryid, P.srno, PW.sizeinmm";
        $data['result'] = $this->dbmodel->getdata($query);

        $query = "SELECT * FROM brands ORDER BY srno";
        $data['brands'] = $this->dbmodel->getdata($query);


        $query = "SELECT * FROM brands WHERE id IN(SELECT BP.bid FROM products AS P, productweights AS PW, brandproducts AS BP ";
        $query .= "WHERE P.id = PW.pid AND BP.pwid = PW.id ";
        if(isset($_GET['brandid']))
        {
            if($_GET['brandid'] != 0)
            {
                $query .= "AND BP.bid = " . $_GET['brandid'] . " ";
            }
        }
        if(isset($_GET['productid']))
        {
            if($_GET['productid'] != 0)
            {
                $query .= "AND P.id = " . $_GET['productid'] . " ";
            }
        }
        $query .= ") ORDER BY srno";
        $data['brandsTable'] = $this->dbmodel->getdata($query);

        $query = "SELECT * FROM products ORDER BY srno";
        $data['products'] = $this->dbmodel->getdata($query);

        $query = "SELECT * FROM products WHERE id IN(SELECT P.id FROM products AS P, productweights AS PW, brandproducts AS BP ";
        $query .= "WHERE P.id = PW.pid AND BP.pwid = PW.id ";
        if(isset($_GET['brandid']))
        {
            if($_GET['brandid'] != 0)
            {
                $query .= "AND BP.bid = " . $_GET['brandid'] . " ";
            }
        }
        if(isset($_GET['productid']))
        {
            if($_GET['productid'] != 0)
            {
                $query .= "AND P.id = " . $_GET['productid'] . " ";
            }
        }
        $query .= ") ORDER BY srno";
        $data['productsTable'] = $this->dbmodel->getdata($query);

        $query = "SELECT * FROM brandproducts AS BP, productweights AS PW, products AS P ";
        $query .= "WHERE P.id = PW.pid AND PW.id = BP.pwid ";
        if(isset($_GET['brandid']))
        {
            if($_GET['brandid'] != 0)
            {
                $query .= "AND BP.bid = " . $_GET['brandid'] . " ";
            }
        }
        if(isset($_GET['productid']))
        {
            if($_GET['productid'] != 0)
            {
                $query .= "AND P.id = " . $_GET['productid'] . " ";
            }
        }
        
        // echo $query;
        // exit;
        $data['brandproducts'] = $this->dbmodel->getdata($query);
        $data["showsave"] = $showsave;
        $this->load->view('admin/layout/header'); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('reports/reportmaker', $data);
        $this->load->view('admin/layout/footer');
    }

    public function deleteReport($id)
    {
        $query = "DELETE FROM reports WHERE id = ". $id;        
        $this->dbmodel->execute($query);
        $this->session->set_flashdata('delete_msg','Record deleted successfully');
        redirect(base_url('reports'));
    }

	//Cookie Management

	function setCookie($name, $value) 
	{
		$cookie= array( 
				'name'   => $name, 
				'value'  => $value, 
				'expire' => '31556926', 
		); 
		$this->input->set_cookie($cookie); 
	}
		
	function getCookie($name)
	{
		return $this->input->cookie($name, true);
	}

	function clearCookie($name) 
	{
		$cookie= array( 
				'name'   => $name, 
				'value'  => '', 
				'expire' => '-3600', 
		); 
		$this->input->set_cookie($cookie); 
	}
//End of Cookie Management
}




