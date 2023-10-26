<?php

defined('BASEPATH') or exit('No direct script access allowed');

class OrdersModel extends CI_Model
{

	public function __construct(){				
		$this->load->database();			
		$this->load->model('FirebaseModel', 'firebaseModel');
        $this->load->model('UserModel', 'user');
        $this->load->model('DBModel', 'dbModel');
        $this->load->model('QuotationsModel', 'quotation');
    }
    
    public function totalrecords()
    {
        return $this->db->count_all("orders");
    }

    public function get_data($limit, $start) 
    {
        $query = "SELECT * FROM orders WHERE id <> 0 ";
        if(isset($_GET['orderno']))
	    {
	        $query .= "AND orderno LIKE '%" . str_replace("'", "''", str_replace(" ", "%", $_GET['orderno'])) . "%'";
	    }
        if(isset($_GET['qname']))
	    {
	        $query .= "AND qname LIKE '%" . str_replace("'", "''", str_replace(" ", "%", $_GET['qname'])) . "%'";
            
	    }
        if(isset($_GET['status']))
	    {
            if($_GET['status'] != "All")
	            $query .= "AND status = '" . $_GET['status'] . "' ";
            else
            $query .= "AND status != 'Remove' ";
	    }
        // if(!isset($_GET['status']))
	    // {
            
	    //         $query .= "AND status != 'Remove' ";
            
	    // }
        $query .=" ORDER BY createdon DESC , id DESC ";
        $query .= "LIMIT " . $limit . " OFFSET " . $start;
     
        $result = $this->db->query($query);
        return $result->result();
    }

    public function get_orders() 
    {
        $query = "SELECT *, (SELECT COUNT(*) FROM dispatches AS D WHERE D.oid = orders.id) AS dispatchcount ";
        $query .= "FROM orders WHERE id <> 0 ";
        if(isset($_GET['orderno']))
	    {
	        $query .= "AND orderno LIKE '%" . str_replace("'", "''", str_replace(" ", "%", $_GET['orderno'])) . "%'";
	    }
        if(isset($_GET['qname']))
	    {
	        $query .= "AND qname LIKE '%" . str_replace("'", "''", str_replace(" ", "%", $_GET['qname'])) . "%'";
            
	    }
        if(isset($_GET['status']))
	    {
            if($_GET['status'] != "All")
	            $query .= "AND status = '" . $_GET['status'] . "' ";
            
	    }
        if(!isset($_GET['status']))
	    {
            
	            $query .= "AND status != 'Remove' ";
            
	    }
        $query .=" ORDER BY createdon DESC , id DESC ";
       
     
        $result = $this->db->query($query);
        return $result->result();
    }

    public function lists()
    {
        $query = "SELECT * FROM orders ORDER BY createdon DESC , id DESC";
        $result = $this->db->query($query);
        return $result->result();
    }

    public function save()
    {   
        $month = date('m');
        $year = date('Y');
        
        $financialyear = $year . "-" . ($year + 1);
        if($month < 4)
        $financialyear = ($year - 1) . "-" . $year;

        $oid = $this->input->post('id');        
        date_default_timezone_set('Asia/Kolkata');
        $now = date('Y-m-d H:i:s');                
        if ($oid == 0) 
        {            
            $orderno = $this->getnextorderno($financialyear);
        
            $field = array(
                'firmname'=>$this->input->post('firmname'),
                'name'=>$this->input->post('name'),
                'address'=>$this->input->post('address'),
                'city'=>$this->input->post('city'),
                'mobileno'=>$this->input->post('mobileno'),
                'gstno'=>$this->input->post('gstno'),
                'state'=>$this->input->post('state'),
                'profession'=>$this->input->post('profession'),
                'qname'=>$this->input->post('firmname'),
                'firmid'=>$this->input->post('firmid'),
                'ponumber'=>$this->input->post('ponumber'),
                'paymentmode'=>$this->input->post('paymentmode'),
                'paymentdetails'=>$this->input->post('paymentdetails'),
                'orderno'=>$orderno,
                'financialyear'=>$financialyear,
                'status'=>$this->input->post('status'),
                'narration'=>$this->input->post('narration'),
                'enquirysource'=>$this->input->post('enquirysource'),
                'createdon'=>$now,
                'createdby' => $_COOKIE['name'],
            );

            $this->db->insert('orders', $field);
            $oid = $this->db->insert_id(); 
        } 
        else 
        {            
            $field = array(
                'firmname'=>$this->input->post('firmname'),
                'name'=>$this->input->post('name'),
                'address'=>$this->input->post('address'),
                'city'=>$this->input->post('city'),
                'mobileno'=>$this->input->post('mobileno'),
                'gstno'=>$this->input->post('gstno'),
                'state'=>$this->input->post('state'),
                'profession'=>$this->input->post('profession'),
                'qname'=>$this->input->post('firmname'),                
                'firmid'=>$this->input->post('firmid'),
                'ponumber'=>$this->input->post('ponumber'),
                'paymentmode'=>$this->input->post('paymentmode'),
                'paymentdetails'=>$this->input->post('paymentdetails'),
                'status'=>$this->input->post('status'),
                'narration'=>$this->input->post('narration'),
                'enquirysource'=>$this->input->post('enquirysource'),
                'updatedon'=>$now,
                'createdby' => $_COOKIE['name'],
            );
            $this->db->where('id', $oid);
            $this->db->update('orders', $field);
        }
        $query = "DELETE FROM orderdetails WHERE oid = " . $oid;
        $this->db->query($query);    
                            
        $totalweight = 0;
        $subtotal = 0;        
        $count = $this->input->post('count');
        for($i = 1; $i < $count; $i++)
        {
            if($this->input->post('pid'.$i) != ""){
                $field = array(
                    'oid' => $oid,
                    'pwid' => $this->input->post('pwid'.$i),
                    'pid' => $this->input->post('pid'.$i),
                    'estimationin' => $this->input->post('unit'.$i),
                    'singleweight' => $this->input->post('singleweight'.$i),
                    'quantities' => $this->input->post('quantities'.$i),
                    'weight' => $this->input->post('weight'.$i),
                    'brandid' => $this->input->post('brand'.$i),
                    'rate' => $this->input->post('rate'.$i),
                    'amount' => $this->input->post('totalAmount'.$i),
                    'narration' => $this->input->post('narration'.$i),
                );
                $this->db->insert('orderdetails', $field);  
                $totalweight += $this->input->post('weight'.$i);
                $subtotal += $this->input->post('totalAmount'.$i);
            }
        }
        $loading = $this->input->post('loading');
        $lcharges = ($this->input->post('lcharges') == "" ? "0" : $this->input->post('lcharges'));
        $ccharges = ($this->input->post('ccharges') == "" ? "0" : $this->input->post('ccharges'));
        $fcharges = ($this->input->post('fcharges') == "" ? "0" : $this->input->post('fcharges'));
        $ocharges = ($this->input->post('ocharges') == "" ? "0" : $this->input->post('ocharges'));
        $gst = ($this->input->post('gst') == "" ? "0" : $this->input->post('gst'));
        $roundoff = ($this->input->post('roundoff') == "" ? "0" : $this->input->post('roundoff'));
        $vehicleno = $this->input->post('vehicleno');
        //$total = ($subtotal + $lcharges + $ccharges + $fcharges + $ocharges + $gst) - $roundoff;
        $field = array(
            'totalweight' => $totalweight,
            'subtotal' => $subtotal,
            'loading' => $loading,
            'lcharges' => $lcharges,
            'ccharges' => $ccharges,
            'fcharges' => $fcharges,
            'paidby' => $this->input->post('paidby'),
            'cd' => $this->input->post('cd'),
            'ocharges' => $ocharges,
            'gst' => $gst,
            'roundoff' => $roundoff,
            'total' => $this->input->post('total'),
            'vehicleno' => $vehicleno,
        );
        $this->db->where('id', $oid);
        $this->db->update('orders', $field);

        return $oid;
    }


    public function preparedo($id)
    {
        $quotation = $this->quotation->getbyid($id);      
        $user = $this->user->getbyid($quotation->userid);  
        $result = $this->quotation->getdetails($id);
        $month = date('m');
        $year = date('Y');        
        $financialyear = $year . "-" . ($year + 1);
        if($month < 4)
        $financialyear = ($year - 1) . "-" . $year;

         
        date_default_timezone_set('Asia/Kolkata');
        $now = date('Y-m-d H:i:s');             
         
        $orderno = $this->getnextorderno($financialyear);    
        $field = array(
            'firmname'=>$user->firmname,
            'name'=>$user->name,
            'address'=>$user->address,
            'city'=>$user->city,
            'mobileno'=>$user->mobileno,
            'gstno'=>$user->gstno,
            'state'=>$user->state,
            'profession'=>$user->profession,
            'qname'=>$quotation->qname,
            'firmid'=>$quotation->firmid,
            'orderno'=>$orderno,
            'financialyear'=>$financialyear,
            'status'=>"Open",
            'createdon'=>$now,
            'qid'=>$quotation->id,
            'totalweight' => $quotation->totalweight,
            'subtotal' => $quotation->subtotal,
            'loading' => $quotation->loading,
            'lcharges' => $quotation->lcharges,
            'ccharges' => $quotation->ccharges,
            'fcharges' => $quotation->fcharges,
            'paidby' => $quotation->paidby,
            'cd' => $quotation->cd,
            'ocharges' => $quotation->ocharges,
            'gst' => $quotation->gst,
            'roundoff' => $quotation->roundoff,
            'total' => $quotation->total,
            'vehicleno' => $quotation->vehicleno,
            'narration' => $quotation->narration,
            'enquirysource'=>$quotation->enquirysource,
            'createdby' => $_COOKIE['name'],
        );

        $this->db->insert('orders', $field);
        $oid = $this->db->insert_id(); 

        foreach ($result as $row)
        {
            $field = array(
                'oid' => $oid,
                'pwid' => $row->pwid,
                'pid' => $row->pid,
                'estimationin' => $row->estimationin,
                'singleweight' => $row->singleweight,
                'quantities' => $row->quantities,
                'weight' => $row->weight,
                'brandid' => $row->brandid,
                'rate' => $row->rate,
                'amount' => $row->amount,
                'narration' => $row->narration,
            );     
            $this->db->insert('orderdetails', $field);            
        }
        $query = "UPDATE quotations SET dostatus = 'yes', doid = " . $oid . " WHERE id = " . $id;
        $this->db->query($query);
        return $oid;
    }
    
    public function getbyid($id)
    {
        $query = "SELECT * FROM orders WHERE id = " . $id;
        $result = $this->db->query($query);
        return $result->result()[0];
    }

    public function getdetails($id)
    {
        $query = "SELECT  B.name AS brandname, P.product, PW.sizeinmm, OD.* , ";
        $query .= "(SELECT P.billingin FROM products AS P WHERE P.id = OD.pid) AS billingin, ";
        $query .= "(SELECT IFNULL(SUM(weight), 0) FROM dispatchdetails AS DD WHERE DD.odid = OD.id) AS dispachedtotal ";
        $query .= "FROM brands AS B, products AS P, productweights AS PW, orderdetails AS OD ";
        $query .= "WHERE B.id = OD.brandid AND P.id = OD.pid AND PW.id = OD.pwid AND OD.oid = " . $id;
        
        $result = $this->db->query($query);
        return $result->result();
    }

    public function delete($id)
    {       
        $this->db->where('id', $id);
        $this->db->delete('orders');

        $this->db->where('oid', $id);
        $this->db->delete('orderdetails');
    }

    public function getnextorderno($financialyear)
    {
        $query = "SELECT IFNULL(MAX(orderno), 0) AS svalue FROM orders WHERE financialyear = '" . $financialyear . "'";
        $orderno = $this->dbModel->getsinglevalue($query);
        return $orderno + 1;
    }
}