<?php

defined('BASEPATH') or exit('No direct script access allowed');

class DispatchModel extends CI_Model
{

	public function __construct(){				
		$this->load->database();			
		$this->load->model('FirebaseModel', 'firebaseModel');
        $this->load->model('UserModel', 'user');
        $this->load->model('DBModel', 'dbModel');
        $this->load->model('QuotationsModel', 'quotation');
    }
    
    // public function totalrecords()
    // {
    //     return $this->db->count_all("orders");
    // }

    // public function get_data($limit, $start) 
    // {
    //     $query = "SELECT * FROM orders WHERE id <> 0 ";
    //     if(isset($_GET['orderno']))
	//     {
	//         $query .= "AND orderno LIKE '%" . str_replace("'", "''", str_replace(" ", "%", $_GET['orderno'])) . "%'";
	//     }
    //     if(isset($_GET['qname']))
	//     {
	//         $query .= "AND qname LIKE '%" . str_replace("'", "''", str_replace(" ", "%", $_GET['qname'])) . "%'";
	//     }
    //     $query .=" ORDER BY createdon DESC , id DESC ";
    //     $query .= "LIMIT " . $limit . " OFFSET " . $start;
    //     $result = $this->db->query($query);
    //     return $result->result();
    // }

    // public function lists()
    // {
    //     $query = "SELECT * FROM orders ORDER BY createdon DESC , id DESC";
    //     $result = $this->db->query($query);
    //     return $result->result();
    // }

    public function save()
    {   
        $oid = $this->input->post('oid');        
        date_default_timezone_set('Asia/Kolkata');
        $now = date('Y-m-d H:i:s');                
       
        $field = array(
            'oid'=>$this->input->post('oid'),
            'srno'=>$this->getnextsrno($oid),                       
            'ddate'=>$this->input->post('ddate'),
            'createdby' => $_COOKIE['name'],
        );

        $this->db->insert('dispatches', $field);
        $did = $this->db->insert_id(); 
              
        $count = $this->input->post('count');
        for($i = 1; $i < $count; $i++)
        {
            
                $field = array(
                    'did' => $did,
                    'odid' => $this->input->post('odid'.$i),
                    'brandid' => $this->input->post('brandid'.$i),
                    'pwid' => $this->input->post('pwid'.$i),
                    'pid' => $this->input->post('pid'.$i),
                    'unit' => $this->input->post('unit'.$i),
                    'weight' => $this->input->post('dispatchedweight'.$i),
                );
                $this->db->insert('dispatchdetails', $field);  
        }
        
    }

    public function getnextsrno($oid)
    {

		if($this->getbyoid($oid))
		{
			$query = "SELECT IFNULL(MAX(srno), 0) AS svalue  FROM dispatches WHERE oid = ".$oid;
			$qno= $this->dbModel->getsinglevalue($query);
			return $qno + 1;
		}
		else{
			return 1;
		}	
       
    }

    public function getbyoid($oid)
    {
        $this->db->where('oid', $oid);
        $query = $this->db->get('dispatches');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
	}
    public function getbyid($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('dispatches');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
      public function getdetails($id)
    {
        $query = "SELECT D.* , (SELECT O.qname FROM orders AS O WHERE O.id = D.oid) AS ordername FROM dispatches AS D";
        $query .= " WHERE D.oid = " . $id;
        $result = $this->db->query($query);
        return $result->result();
    }

    public function getDispatchdetails($did)
    {
        $query = "SELECT B.name AS brandname, P.product, PW.sizeinmm, OD.* , DD.odid, DD.weight, (SELECT P.billingin FROM products AS P ";
        $query .= " WHERE P.id = OD.pid) AS billingin FROM brands AS B, products AS P, productweights AS PW, orderdetails AS OD, ";
        $query .= "dispatchdetails AS DD WHERE B.id = OD.brandid AND P.id = OD.pid AND PW.id = OD.pwid AND OD.id = DD.odid AND DD.did = " . $did;
       
        $result = $this->db->query($query);
       
        return $result->result();
    }


    // public function preparedo($id)
    // {
    //     $quotation = $this->quotation->getbyid($id);      
    //     $user = $this->user->getbyid($quotation->userid);  
    //     $result = $this->quotation->getdetails($id);
    //     $month = date('m');
    //     $year = date('Y');        
    //     $financialyear = $year . "-" . ($year + 1);
    //     if($month < 4)
    //     $financialyear = ($year - 1) . "-" . $year;

         
    //     date_default_timezone_set('Asia/Kolkata');
    //     $now = date('Y-m-d H:i:s');             
         
    //     $orderno = $this->getnextorderno($financialyear);    
    //     $field = array(
    //         'firmname'=>$user->firmname,
    //         'name'=>$user->name,
    //         'address'=>$user->address,
    //         'city'=>$user->city,
    //         'mobileno'=>$user->mobileno,
    //         'gstno'=>$user->gstno,
    //         'state'=>$user->state,
    //         'profession'=>$user->profession,
    //         'qname'=>$quotation->qname,
    //         'firmid'=>$quotation->firmid,
    //         'orderno'=>$orderno,
    //         'financialyear'=>$financialyear,
    //         'status'=>"Close",
    //         'createdon'=>$now,
    //         'qid'=>$quotation->id,
    //         'totalweight' => $quotation->totalweight,
    //         'subtotal' => $quotation->subtotal,
    //         'loading' => $quotation->loading,
    //         'lcharges' => $quotation->lcharges,
    //         'ccharges' => $quotation->ccharges,
    //         'fcharges' => $quotation->fcharges,
    //         'paidby' => $quotation->paidby,
    //         'ocharges' => $quotation->ocharges,
    //         'gst' => $quotation->gst,
    //         'roundoff' => $quotation->roundoff,
    //         'total' => $quotation->total,
    //         'vehicleno' => $quotation->vehicleno,
    //         'narration' => $quotation->narration,
    //     );

    //     $this->db->insert('orders', $field);
    //     $oid = $this->db->insert_id(); 

    //     foreach ($result as $row)
    //     {
    //         $field = array(
    //             'oid' => $oid,
    //             'pwid' => $row->pwid,
    //             'pid' => $row->pid,
    //             'estimationin' => $row->estimationin,
    //             'singleweight' => $row->singleweight,
    //             'quantities' => $row->quantities,
    //             'weight' => $row->weight,
    //             'brandid' => $row->brandid,
    //             'rate' => $row->rate,
    //             'amount' => $row->amount,
    //             'narration' => $row->narration,
    //         );     
    //         $this->db->insert('orderdetails', $field);            
    //     }
    //     $query = "UPDATE quotations SET dostatus = 'yes', doid = " . $oid . " WHERE id = " . $id;
    //     $this->db->query($query);
    //     return $oid;
    // }
    
    // public function getbyid($id)
    // {
    //     $query = "SELECT * FROM orders WHERE id = " . $id;
    //     $result = $this->db->query($query);
    //     return $result->result()[0];
    // }

    // public function getdetails($id)
    // {
    //     $query = "SELECT B.name AS brandname, P.product, PW.sizeinmm, OD.* , (SELECT P.billingin FROM products AS P WHERE P.id = OD.pid) AS billingin FROM brands AS B, products AS P, productweights AS PW, orderdetails AS OD ";
    //     $query .= "WHERE B.id = OD.brandid AND P.id = OD.pid AND PW.id = OD.pwid AND OD.oid = " . $id;
    //     $result = $this->db->query($query);
    //     return $result->result();
    // }

    // public function delete($id)
    // {       
    //     $this->db->where('id', $id);
    //     $this->db->delete('orders');

    //     $this->db->where('oid', $id);
    //     $this->db->delete('orderdetails');
    // }

    // public function getnextorderno($financialyear)
    // {
    //     $query = "SELECT IFNULL(MAX(orderno), 0) AS svalue FROM orders WHERE financialyear = '" . $financialyear . "'";
    //     $orderno = $this->dbModel->getsinglevalue($query);
    //     return $orderno + 1;
    // }
}