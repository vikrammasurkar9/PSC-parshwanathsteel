<?php

defined('BASEPATH') or exit('No direct script access allowed');

class QuotationsModel extends CI_Model
{

	public function __construct(){				
		$this->load->database();			
		$this->load->model('FirebaseModel', 'firebaseModel');
		$this->load->model('UserModel', 'userModel');
    }
    
    // public function lists()
    // {
    //     $query = "SELECT *, (SELECT name FROM users WHERE users.id = userid) AS username, ";
    //     $query .= "(SELECT firmname FROM users WHERE users.id = userid) AS firmname, ";
    //     $query .= "(SELECT city FROM users WHERE users.id = userid) AS city, ";
    //     $query .= "(SELECT savedincontacts FROM users WHERE users.id = userid) AS savedincontacts, ";
    //     $query .= "(SELECT mobileno FROM users WHERE users.id = userid) AS mobileno ";
    //     $query .= "FROM quotations ORDER BY requestdate DESC, id DESC";
    //     $result = $this->db->query($query);
    //     return $result->result();
    // }
    
    
    public function lists()
    {
        $query = "SELECT *, (SELECT name FROM users WHERE users.id = userid) AS username, ";
        $query .= "(SELECT firmname FROM users WHERE users.id = userid) AS firmname, ";
        $query .= "(SELECT city FROM users WHERE users.id = userid) AS city, ";
        $query .= "(SELECT email FROM users WHERE users.id = userid) AS email, ";
        $query .= "(SELECT savedincontacts FROM users WHERE users.id = userid) AS savedincontacts, ";
        $query .= "(SELECT mobileno FROM users WHERE users.id = userid) AS mobileno ";
        $query .= "FROM quotations ORDER BY requestdate DESC, id DESC";
        $result = $this->db->query($query);
        return $result->result();
    }


    public function totalrecords()
    {
        return $this->db->count_all("quotations");
    }

    public function totalleads()
    {
        $query = "SELECT * FROM quotations WHERE status = 'Lead'";
        $result = $this->db->query($query);
        return $result->result();
    }
    public function totalquotations()
    {
        $query = "SELECT * FROM quotations WHERE status <> 'Lead' || dostatus <> 'yes' ";
        $result = $this->db->query($query);
        return $result->result();
    }

    public function leads()
    {
        $query = "SELECT * FROM quotations WHERE filename = ''";
        $result = $this->db->query($query);
        return $result->result();
    }

    public function get_data_for_requests($limit, $start) 
    {
        $query = "SELECT *, (SELECT name FROM users WHERE users.id = userid) AS username, ";
        $query .= "(SELECT firmname FROM users WHERE users.id = userid) AS firmname, ";
        $query .= "(SELECT city FROM users WHERE users.id = userid) AS city, ";
        $query .= "(SELECT savedincontacts FROM users WHERE users.id = userid) AS savedincontacts, ";
        $query .= "(SELECT mobileno FROM users WHERE users.id = userid) AS mobileno ";
        $query .= "FROM quotations WHERE id <> 0 ";
        if(isset($_GET['leadno']))
	    {
	        $query .= "AND id LIKE '%" . str_replace("'", "''", str_replace(" ", "%", $_GET['leadno'])) . "%'";
	    }
        if(isset($_GET['qname']))
	    {
	        $query .= "AND qname LIKE '%" . str_replace("'", "''", str_replace(" ", "%", $_GET['qname'])) . "%'";
	    }
        $query .= " ORDER BY requestdate DESC , id ";
        $query .= "LIMIT " . $limit . " OFFSET " . $start;
        $result = $this->db->query($query);
        return $result->result();
    }

    public function get_data_for_quotations($limit, $start) 
    {
        $query = "SELECT *, (SELECT name FROM users WHERE users.id = userid) AS username, ";
        $query .= "(SELECT firmname FROM users WHERE users.id = userid) AS firmname, ";
        $query .= "(SELECT city FROM users WHERE users.id = userid) AS city, ";
        $query .= "(SELECT savedincontacts FROM users WHERE users.id = userid) AS savedincontacts, ";
        $query .= "(SELECT mobileno FROM users WHERE users.id = userid) AS mobileno ";
        $query .= "FROM quotations WHERE id <> 0 ";
        if(isset($_GET['status']))
	    {
	        $query .= "AND followup = '" . $_GET['status'] . "' ";
	    }
        if(isset($_GET['qno']))
	    {
	        $query .= "AND (sbqno LIKE '%" . str_replace("'", "''", str_replace(" ", "%", $_GET['qno'])) . "%'";
            $query .= "OR mbqno LIKE '%" . str_replace("'", "''", str_replace(" ", "%", $_GET['qno'])) . "%') ";
	    }

        if(isset($_GET['qname']))
	    {
	        $query .= "AND qname LIKE '%" . str_replace("'", "''", str_replace(" ", "%", $_GET['qname'])) . "%'";
	    }


        $query .= " ORDER BY createdon DESC , qno DESC ";
        $query .= "LIMIT " . $limit . " OFFSET " . $start;
        // echo $query;
        // exit;
        $result = $this->db->query($query);
        return $result->result();
    }

    public function listgiven()
    {
        $query = "SELECT * FROM quotations WHERE filename <> ''";
        $result = $this->db->query($query);
        return $result->result();
    }

    public function listpending()
    {
        $query = "SELECT * FROM quotations WHERE filename = ''";
        $result = $this->db->query($query);
        return $result->result();
    }

    public function save()
    {        
        $id = 0;
        $userid = $this->input->post('userid');
		$eid = $this->input->post('eid');
		$qname = $this->input->post('qname');
		$pwids = $this->input->post('pwids');
		$pids = $this->input->post('pids');
		$bids = $this->input->post('bids');
		$estimationsIn = $this->input->post('estimationsIn');
		$quantities = $this->input->post('quantities');
        $weights = $this->input->post('weights');
     
        $query = "DELETE FROM quotations WHERE userid = " . $userid . " AND eid = " . $eid;
        $this->db->query($query);


        $qno = $this->getnextqno();
        date_default_timezone_set('Asia/Karachi');
        $now = date('Y-m-d H:i:s');

        $field = array(
            'userid' => $userid,
            'qname' => $qname,
            'eid' => $eid,
            'requestdate' => $now,
            'filename'=>'',
            'qno' =>$qno,
            'createdby' => $_COOKIE['name'],
            'adminid'=> $_COOKIE['adminid'],
        );
        $this->db->insert('quotations', $field);
        $id = $this->db->insert_id();

        $pwidsArray = explode(',', $pwids);
        $pidsArray = explode(',', $pids);
        $bidsArray = explode(',', $bids);
        $estimationsInArray = explode(',', $estimationsIn);
        $quantitiesArray = explode(',', $quantities);
        $weightsArray = explode(',', $weights);
        for($i = 0; $i < sizeof($pwidsArray); $i++)
        {
            $field = array(
                'qid' => $id,
                'pwid' => $pwidsArray[$i],
                'pid' => $pidsArray[$i],
                'bid' => $bidsArray[$i],
                'estimationin' => $estimationsInArray[$i],
                'quantities' => $quantitiesArray[$i],
                'weight' => $weightsArray[$i],
            );
            $this->db->insert('quotationdetails', $field);
        }
        return $id;
    }

    public function saveQuotation()
    {
        $count = $this->input->post('count');
        $qbpcount = $this->input->post('qbpcount');
        $qid = $this->input->post('id');
        $query = "DELETE FROM quotationbrandprices WHERE qid = " . $qid;
        $this->db->query($query);

        for($i = 1; $i < $qbpcount; $i++)
        {   
            $count = $this->input->post('countid_' . $i);
            $qdid = $this->input->post('id' . $count);
            $bid = $this->input->post('bid_' . $i);
            $bid = $this->input->post('bid_' . $i);
            $pwid = $this->input->post('pwid' . $count);
            $rate = $this->input->post('rate_' . $i);

            $estimationin = $this->input->post('estimationin' . $count);
            $quantities = $this->input->post('quantities' . $count);
            $weight = $this->input->post('htotalweight' . $count);
            $query = "UPDATE quotationdetails SET estimationin = '" . $estimationin . "', quantities = '" . $quantities . "', weight= '" . $weight . "'  WHERE  id = " . $qdid;
            $this->db->query($query);
            if($rate > 0){
                $query = "INSERT INTO quotationbrandprices(qid, qdid, bid, pwid, rate) ";
                $query .= "VALUES(" . $qid . ", " . $qdid . ", " . $bid . ", " . $pwid . ", " . ($rate == "" ? "NULL" : $rate) . " )";      
                $this->db->query($query);
            }
        }

        $qno = $this->getnextqno();
        $query = "UPDATE quotations SET qno = ".$qno." WHERE id = " . $qid;
        $this->db->query($query);

         $query = "UPDATE quotations SET status ='MBQuotation' WHERE id = " . $qid;
        $this->db->query($query);

        

        

        $month = date('m');
        $year = date('Y');
        
        $financialyear = $year . "-" . ($year + 1);
        if($month < 4)
        $financialyear = ($year - 1) . "-" . $year;

        date_default_timezone_set('Asia/Kolkata');
        $now = date('Y-m-d H:i:s');

        $query = "SELECT * FROM quotations WHERE id = " . $qid . " AND mbqno IS NULL";
        if($this->dbmodel->checkifexists($query)){
            $mbqno = $this->getnextmbqno($financialyear);
            $field = array(
                'createdon'=>$now,
                'status'=>'MBQuotation',
                'sbqstatus'=>'no',
                'mbqstatus'=>'yes',
                'mbqno'=>$mbqno,
                'financialyear'=>$financialyear,
                
            ); 
            $this->db->where('id', $qid);
            $this->db->update('quotations', $field);
        }
       
        $userid = $this->input->post('userid');
        $user = $this->userModel->getbyid($userid);
        $title = "Quotation Done";
        $message = "Hello " . $user->name . ", your quotation is done please check.";
        //$this->firebaseModel->sendNotification($user->firebaseid, $title, $message);
        return "success";
    }

    public function savesquotation()
    {
        $count = $this->input->post('count');
        $qid = $this->input->post('id');
        for($i = 1; $i < $count; $i++)
        {   
            $qdid = $this->input->post('id' . $i);            
            $brandid = $this->input->post('brandid'.$i);
            $amount = $this->input->post('amount'.$i);
            $rate = $this->input->post('rate'.$i);
            $narration = $this->input->post('narration'.$i);
            $narration = str_replace("'", "''", $narration);
            $query = "UPDATE quotationdetails SET brandid = '" . $brandid . "' , rate = '" . $rate . "', amount = '".$amount."', narration = '".$narration."'   WHERE id = ". $qdid;
            $this->db->query($query);
            //echo $query;
        }

        $qno = $this->getnextqno();

        $loading = $this->input->post('loading');
        $lcharges = ($this->input->post('lcharges') == "" ? "0" : $this->input->post('lcharges'));
        $ccharges = ($this->input->post('ccharges') == "" ? "0" : $this->input->post('ccharges'));
        $fcharges = ($this->input->post('fcharges') == "" ? "0" : $this->input->post('fcharges'));
        $ocharges = ($this->input->post('ocharges') == "" ? "0" : $this->input->post('ocharges'));
        $gst = ($this->input->post('gst') == "" ? "0" : $this->input->post('gst'));
        $roundoff = ($this->input->post('roundoff') == "" ? "0" : $this->input->post('roundoff'));
        $vehicleno = $this->input->post('vehicleno');
       // $total = ($subtotal + $lcharges + $ccharges + $fcharges + $ocharges + $gst) - $roundoff;
        $field = array(
            'totalweight' => $this->input->post('totalweight'),
            'subtotal' => $this->input->post('subtotal'),
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
            'qno' => $qno,
            
        );

        $this->db->where('id', $qid);
        $this->db->update('quotations', $field);
        $query = "UPDATE quotations SET status ='SBQuotation' WHERE id = " . $qid;
        $this->db->query($query);
        $month = date('m');
        $year = date('Y');
        
        $financialyear = $year . "-" . ($year + 1);
        if($month < 4)
        $financialyear = ($year - 1) . "-" . $year;

        date_default_timezone_set('Asia/Kolkata');
        $now = date('Y-m-d H:i:s');

        $query = "SELECT * FROM quotations WHERE id = " . $qid . " AND sbqno IS NULL";
        if($this->dbmodel->checkifexists($query)){
            $sbqno = $this->getnextsbqno($financialyear);
            $field = array(
                'createdon'=>$now,
                'status'=>'SBQuotation',
                'sbqstatus'=>'yes',
                'sbqno'=>$sbqno,
                'financialyear'=>$financialyear,
                
            ); 
            $this->db->where('id', $qid);
            $this->db->update('quotations', $field);
        }
    }

    public function saveeditedsquotation()
    {
        $bid=1;
        $count = $this->input->post('count');
        $qid = $this->input->post('id');
        $userid = $this->input->post('userid');

        $field = array(
            'firmname'=>$this->input->post('firmname'),
            'name'=>$this->input->post('name'),
			'address'=>$this->input->post('address'),
            'city'=>$this->input->post('city'),
			'mobileno'=>$this->input->post('mobileno'),
            'gstno'=>$this->input->post('gstno'),
            'state'=>$this->input->post('state'),
			
            'profession'=>$this->input->post('profession'),
        );
        $this->db->where('id', $userid);
        $this->db->update('users', $field);

        $field = array(
            'qname'=>$this->input->post('firmname'), 
            'firmid'=>$this->input->post('firmid'),           
            'narration'=>$this->input->post('narration'),
            'enquirysource'=>$this->input->post('enquirysource'),
        );
        $this->db->where('id', $qid);
        $this->db->update('quotations', $field);
        
        for($i = 1; $i < $count; $i++)
        {  

            if(!$this->input->post('pid'.$i)==""){
                $field = array(
                    'qid' => $qid,
                    'pwid' => $this->input->post('pwid' . $i),
                    'pid' => $this->input->post('pid' . $i),
                    'bid' =>$bid,
                    'estimationin' => $this->input->post('unit' . $i),
                    'quantities' => $this->input->post('quantities' . $i),
                    'singleweight' => $this->input->post('singleweight' . $i),
                    'weight' => $this->input->post('weight'.$i),
                    'rate' => $this->input->post('rate'.$i),
                    'amount' => $this->input->post('totalAmount'.$i),
                    'brandid' => $this->input->post('brand'.$i),
                    'narration' => $this->input->post('narration' . $i),
                );
                if ($this->input->post('id') == 0) {            
                    $this->db->insert('quotationdetails', $field);                
                } 
                else {       
                    if($i<=1){
                        $query = "DELETE FROM quotationdetails WHERE qid = " . $qid;
                        $this->db->query($query);    
                        $this->db->insert('quotationdetails', $field);  
                    }
                    else{
                        $this->db->insert('quotationdetails', $field);             
                    }
                }
            }
        }

        $qno = $this->getnextqno();

        $loading = $this->input->post('loading');
        $lcharges = ($this->input->post('lcharges') == "" ? "0" : $this->input->post('lcharges'));
        $ccharges = ($this->input->post('ccharges') == "" ? "0" : $this->input->post('ccharges'));
        $fcharges = ($this->input->post('fcharges') == "" ? "0" : $this->input->post('fcharges'));
        $ocharges = ($this->input->post('ocharges') == "" ? "0" : $this->input->post('ocharges'));
        $gst = ($this->input->post('gst') == "" ? "0" : $this->input->post('gst'));
        $roundoff = ($this->input->post('roundoff') == "" ? "0" : $this->input->post('roundoff'));
        $vehicleno = $this->input->post('vehicleno');
       // $total = ($subtotal + $lcharges + $ccharges + $fcharges + $ocharges + $gst) - $roundoff;
        $field = array(
            'totalweight' => $this->input->post('totalweight'),
            'subtotal' => $this->input->post('subtotal'),
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
            'qno' =>$qno,
            
        );

        $this->db->where('id', $qid);
        $this->db->update('quotations', $field);
        $query = "UPDATE quotations SET status ='SBQuotation' WHERE id = " . $qid;
        $this->db->query($query);
        $month = date('m');
        $year = date('Y');
        
        $financialyear = $year . "-" . ($year + 1);
        if($month < 4)
        $financialyear = ($year - 1) . "-" . $year;

        date_default_timezone_set('Asia/Kolkata');
        $now = date('Y-m-d H:i:s');

        $query = "SELECT * FROM quotations WHERE id = " . $qid . " AND sbqno IS NULL";
        if($this->dbmodel->checkifexists($query)){
            $sbqno = $this->getnextsbqno($financialyear);
            $field = array(
                'createdon'=>$now,
                'status'=>'SBQuotation',
                'sbqstatus'=>'yes',
                'sbqno'=>$sbqno,
                'financialyear'=>$financialyear,
            
            ); 
            $this->db->where('id', $qid);
            $this->db->update('quotations', $field);
        }
    }


    public function savenewquotation()
    {
        $qid = $this->input->post('id');
        $userid = $this->input->post('userid');

        $mobileno = $this->input->post('mobileno');
		$name = $this->input->post('firmname');
		$reply = $this->userModel->getuserdatafornameandmobileno($name, $mobileno);
       
        $field = array(
            'firmname'=>$this->input->post('firmname'),
            'name'=>$this->input->post('name'),
			'address'=>$this->input->post('address'),
            'city'=>$this->input->post('city'),
			'mobileno'=>$this->input->post('mobileno'),
            'gstno'=>$this->input->post('gstno'),
            'state'=>$this->input->post('state'),
			'password'=>'123',
            'profession'=>$this->input->post('profession'),
            'source'=>'web',
        );
        if ($reply == false) {            
            $this->db->insert('users', $field);
            $userid = $this->db->insert_id();
              
        } else {    
            $userid = $reply->id;        
            $this->db->where('id', $userid);
            $this->db->update('users', $field);
        }
		$eid = "0";
        date_default_timezone_set('Asia/Kolkata');
        $now = date('Y-m-d H:i:s');
        $field = array(
            'userid' => $userid,
            'qname' => $name,
            'eid' => $eid,
            'requestdate' => $now,
            'status'=>'Lead',
            'filename'=>'',
            'firmid' => $this->input->post('firmid'),
            'createdby' => $_COOKIE['name'],
            'adminid'=> $_COOKIE['adminid'],
            'narration'=>$this->input->post('narration'),
            'enquirysource'=>$this->input->post('enquirysource'),
        );                
        $this->db->insert('quotations', $field);
        $qid = $this->db->insert_id(); 

        $bid=1;
        $count = $this->input->post('count');
        //$qid = $this->input->post('id');
        for($i = 1; $i < $count; $i++)
        {  

            if(!$this->input->post('pid'.$i)==""){
                $field = array(
                    'qid' => $qid,
                    'pwid' => $this->input->post('pwid' . $i),
                    'pid' => $this->input->post('pid' . $i),
                    'bid' =>$bid,
                    'estimationin' => $this->input->post('unit' . $i),
                    'quantities' => $this->input->post('quantities' . $i),
                    'singleweight' => $this->input->post('singleweight' . $i),
                    'weight' => $this->input->post('weight'.$i),
                    'rate' => $this->input->post('rate'.$i),
                    'amount' => $this->input->post('totalAmount'.$i),
                    'brandid' => $this->input->post('brand'.$i),
                    'narration' => $this->input->post('narration' . $i),
                );
                if ($this->input->post('id') == 0) {            
                    $this->db->insert('quotationdetails', $field);                
                } 
                else {       
                    if($i<=1){
                        $query = "DELETE FROM quotationdetails WHERE qid = " . $qid;
                        $this->db->query($query);    
                        $this->db->insert('quotationdetails', $field);  
                    }
                    else{
                        $this->db->insert('quotationdetails', $field);             
                    }
                }
            }
        }

        $qno = $this->getnextqno();
        $loading = $this->input->post('loading');
        $lcharges = ($this->input->post('lcharges') == "" ? "0" : $this->input->post('lcharges'));
        $ccharges = ($this->input->post('ccharges') == "" ? "0" : $this->input->post('ccharges'));
        $fcharges = ($this->input->post('fcharges') == "" ? "0" : $this->input->post('fcharges'));
        $ocharges = ($this->input->post('ocharges') == "" ? "0" : $this->input->post('ocharges'));
        $gst = ($this->input->post('gst') == "" ? "0" : $this->input->post('gst'));
        $roundoff = ($this->input->post('roundoff') == "" ? "0" : $this->input->post('roundoff'));
        $vehicleno = $this->input->post('vehicleno');
       // $total = ($subtotal + $lcharges + $ccharges + $fcharges + $ocharges + $gst) - $roundoff;
        $field = array(
            'totalweight' => $this->input->post('totalweight'),
            'subtotal' => $this->input->post('subtotal'),
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
            'qno' =>$qno,
        );

        $this->db->where('id', $qid);
        $this->db->update('quotations', $field);
        $query = "UPDATE quotations SET status ='SBQuotation' WHERE id = " . $qid;
        $this->db->query($query);
        $month = date('m');
        $year = date('Y');
        
        $financialyear = $year . "-" . ($year + 1);
        if($month < 4)
        $financialyear = ($year - 1) . "-" . $year;

        date_default_timezone_set('Asia/Kolkata');
        $now = date('Y-m-d H:i:s');

        $query = "SELECT * FROM quotations WHERE id = " . $qid . " AND sbqno IS NULL";
        if($this->dbmodel->checkifexists($query)){
            $sbqno = $this->getnextsbqno($financialyear);
            $field = array(
                'createdon'=>$now,
                'status'=>'SBQuotation',
                'sbqstatus'=>'yes',
                'sbqno'=>$sbqno,
                'financialyear'=>$financialyear,
            ); 
            $this->db->where('id', $qid);
            $this->db->update('quotations', $field);
        }


        return $qid;
        
    }

    public function uploadQuotation()
    {
        $qid = $this->input->post('qid');
        $id = $this->input->post('id');
        if (isset($_FILES['file']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
			$target_dir = '././quotations/' . $id . '.pdf';			
            if (file_exists($target_dir)) {
                unlink($target_dir);
            }
			move_uploaded_file($_FILES['file']['tmp_name'], $target_dir);
        }
        $query = "UPDATE quotations SET filename <> '' WHERE id = " . $qid;
        $this->db->query($query);

        $userid = $this->input->post('userid');
        $user = $this->userModel->getbyid($userid);
        $title = "Quotation uploaded";
        $message = "Hello " . $user->name . ", quotation is uploaded, please check.";
        $this->firebaseModel->sendNotification($user->firebaseid, $title, $message);
        return "success";
    }

    public function getbyid($id)
    {
        $query = "SELECT *, (SELECT name FROM users WHERE users.id = userid) AS username, ";
        $query .= "(SELECT firmname FROM users WHERE users.id = userid) AS firmname, ";
        $query .= "(SELECT gstno FROM users WHERE users.id = userid) AS gstno, ";
        $query .= "(SELECT state FROM users WHERE users.id = userid) AS state, ";
        $query .= "(SELECT city FROM users WHERE users.id = userid) AS city, ";
        $query .= "(SELECT address FROM users WHERE users.id = userid) AS address, ";
        $query .= "(SELECT savedincontacts FROM users WHERE users.id = userid) AS savedincontacts, ";
        $query .= "(SELECT email FROM users WHERE users.id = userid) AS email, ";
        $query .= "(SELECT mobileno FROM users WHERE users.id = userid) AS mobileno ,";
        $query .= "(SELECT profession FROM users WHERE users.id = userid) AS profession ";
        $query .= "FROM quotations WHERE id = " . $id;
        $result = $this->db->query($query);
        return $result->result()[0];
    }

    public function getdetails($id)
    {
        $query = "SELECT QD.*, (SELECT P.product FROM products AS P WHERE P.id = QD.pid) AS productname, PW.weight AS pvweight, ";
        $query .= "(SELECT P.type FROM products AS P WHERE P.id = QD.pid) AS type, ";
        $query .= "(SELECT P.billingin FROM products AS P WHERE P.id = QD.pid) AS billingin, ";
        $query .= "(SELECT B.name FROM brands AS B WHERE B.id = QD.bid) AS brandname, ";
        $query .= "PW.sizeinmm FROM quotationdetails AS QD, productweights AS PW WHERE PW.id = QD.pwid AND QD.qid = " . $id;
        $result = $this->db->query($query);
        return $result->result();
    }

    public function quotationbrandprices($id)
    {
        $query = "SELECT * FROM quotationbrandprices WHERE qid = " . $id;
        $result = $this->db->query($query);
        return $result->result();
    }

    public function getnextqno()
    {
        $query = "SELECT IFNULL(MAX(qno), 0) AS svalue FROM quotations";
        $qno= $this->dbModel->getsinglevalue($query);
        return $qno + 1;
    }

    public function getnextmbqno($financialyear)
    {
        $query = "SELECT IFNULL(MAX(mbqno), 0) AS svalue FROM quotations WHERE financialyear = '" . $financialyear . "'";
        $mbqno= $this->dbModel->getsinglevalue($query);
        return $mbqno + 1;
    }
    public function getnextsbqno($financialyear)
    {
        $query = "SELECT IFNULL(MAX(sbqno), 0) AS svalue FROM quotations WHERE financialyear = '" . $financialyear . "'";
        $sbqno= $this->dbModel->getsinglevalue($query);
        return $sbqno + 1;
    }

    
}