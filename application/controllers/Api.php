<?php

require(APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS,POST");

class Api extends REST_Controller {

    function __construct(){
		parent:: __construct();
		$this->load->model('DBModel', 'dBModel');
		$this->load->model('QuotationsModel', 'quotationsModel');
        $this->load->model('SliderModel', 'slider');
        $this->load->model('CategoriesModel', 'category');
    }
	function sliders_post()
	{
		$result['data'] = $this->slider->lists();
		$this->response($result, 200);
	}
	function synchdata_post()
	{
	    $query = "SELECT * FROM categories ORDER BY id";
		$result['categories'] = $this->dBModel->getdata($query);
		$query = "SELECT * FROM products ORDER BY srno";
		$result['products'] = $this->dBModel->getdata($query);
		$query = "SELECT * FROM brandproducts ORDER BY bid";
		$result['brandproducts'] = $this->dBModel->getdata($query);
		$query = "SELECT * FROM brands ORDER BY srno";
		$result['brands'] = $this->dBModel->getdata($query);
		$query = "SELECT PW.*, P.product AS productname, P.type FROM products AS P, productweights AS PW WHERE P.id = PW.pid ORDER BY P.srno, PW.srno";
		$result['productweights'] = $this->dBModel->getdata($query);
		$this->response($result, 200);
	}

	function productweights_post()
	{
		$pid = $this->input->post('pid');
		$from = $this->input->post('from');		
		$query = "SELECT *, '' AS productname, '' AS type FROM productweights WHERE pid = " . $pid . " ORDER BY srno";
		if($from == "brand")
		{
			$query = "SELECT *, (SELECT P.product FROM products AS P WHERE P.id = pid) AS productname, (SELECT P.type FROM products AS P WHERE P.id = pid) AS type ";
			$query .= "FROM productweights WHERE id IN(SELECT pwid FROM brandproducts WHERE bid = " . $pid . ") ORDER BY srno";
		}
		$result['data'] = $this->dBModel->getdata($query);
		$this->response($result, 200);
	}

	function brandproductweights_post()
	{
		$pid  =$this->input->post('pid');
		$query = "SELECT * FROM productweights WHERE pid = " . $pid . " ORDER BY srno";
		$result['data'] = $this->dBModel->getdata($query);
		$this->response($result, 200);
	}

	function productstoestimate_post()
	{
		$ids = $this->input->post('ids');
		$pids = $this->input->post('pids');
		$bids = $this->input->post('bids');

		$query = "SELECT PW.*, P.product AS productname, P.type AS ptype ";
		$query .= "FROM products AS P, productweights AS PW ";
		$query .= "WHERE P.id = PW.pid AND PW.id IN(" . $ids . ") ";
		$query .= "AND P.id IN (" . $pids . ") ORDER BY PW.srno";
		$result['data'] = $this->dBModel->getdata($query);
		$this->response($result, 200);
	}

	function news_post()
	{
		$query = "SELECT * FROM broadcasting ORDER BY id DESC";
		$result['data'] = $this->dBModel->getdata($query);
		$this->response($result, 200);
	}
	function archives_post()
	{
		$query = "SELECT * FROM archives ORDER BY id DESC";
		$result['data'] = $this->dBModel->getdata($query);
		$this->response($result, 200);
	}
	function categories_post()
	{
		$query = "SELECT * FROM categories ORDER BY id";
		$result['data'] = $this->dBModel->getdata($query);
		$this->response($result, 200);
	}

	function requestforquote_post()
	{
		$qid = $this->quotationsModel->save();
		$dataarray=array();
		$result=array();
		$result['qid'] = $qid;
		$result['status'] = "success";
		array_push($dataarray, $result);
		header('Content-Type: application/json');
		echo json_encode(array("data"=>$dataarray));
	}

	function estimates_post()
	{
		$id = $this->input->post('id');
		$query = "SELECT * FROM quotations WHERE userid = " . $id . " ORDER BY id DESC";
		$result['data'] = $this->dBModel->getdata($query);
		$this->response($result, 200);
	}
	
	function lastupdatetime_post()
	{
		$query = "SELECT updatetime FROM updatestatus";
		$data = $this->dBModel->getdata($query);
		$updatetime = $data[0]->updatetime;
		$dataarray=array();
		$result=array();
		$result['updatetime'] = $updatetime;
		array_push($dataarray, $result);
		header('Content-Type: application/json');
		echo json_encode(array("data"=>$dataarray));
	}
}
