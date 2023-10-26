<?php

defined('BASEPATH') or exit('No direct script access allowed');

class DquotationModel extends CI_Model
{

	public function __construct(){				
		$this->load->database();			
		$this->load->model('FirebaseModel', 'firebaseModel');
        $this->load->model('UserModel', 'userModel');
        $this->load->model('DBModel', 'dbModel');
    }

    public function totalrecords()
    {
        return $this->db->count_all("dquotations");
    }

    public function get_data($limit, $start) 
    {
        $query = "SELECT * FROM dquotations ORDER BY createdon DESC , id DESC ";
        $query .= "LIMIT " . $limit . " OFFSET " . $start;
        $result = $this->db->query($query);
        return $result->result();
    }
    
    public function lists()
    {
        $query = "SELECT * FROM dquotations ORDER BY createdon DESC , id DESC";
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
                'name'=>$this->input->post('name'),
                'email'=>$this->input->post('email'),
                'mobileno'=>$this->input->post('mobileno'),
                'profession'=>$this->input->post('profession'),
                'qname'=>$this->input->post('name'),
                'firmid'=>$this->input->post('firmid'),
                'ponumber'=>$this->input->post('ponumber'),
                'paymentmode'=>$this->input->post('paymentmode'),
                'paymentdetails'=>$this->input->post('paymentdetails'),
                'orderno'=>$orderno,
                'financialyear'=>$financialyear,
                'status'=>"new",
                'createdon'=>$now,
            );

            $this->db->insert('dquotations', $field);
            $oid = $this->db->insert_id(); 
        } else 
        {            
            $field = array(
                'name'=>$this->input->post('name'),
                'email'=>$this->input->post('email'),
                'mobileno'=>$this->input->post('mobileno'),
                'profession'=>$this->input->post('profession'),
                'qname'=>$this->input->post('name'),                
                'firmid'=>$this->input->post('firmid'),
                'ponumber'=>$this->input->post('ponumber'),
                'paymentmode'=>$this->input->post('paymentmode'),
                'paymentdetails'=>$this->input->post('paymentdetails'),
                'status'=>"new",
                'updatedon'=>$now,
            );

            $this->db->where('id', $oid);
            $this->db->update('dquotations', $field);
        }
        $totalweight = 0;
        $subtotal = 0;        
        $count = $this->input->post('count');
        for($i = 1; $i < $count; $i++)
        {
            if(!$this->input->post('pid'.$i)==""){
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
                if ($this->input->post('id') == 0) {            
                    $this->db->insert('dquotationdetails', $field);
                } 
                else 
                {       
                    if($i<=1){
                        $query = "DELETE FROM dquotationdetails WHERE oid = " . $oid;
                        $this->db->query($query);    
                        $this->db->insert('dquotationdetails', $field);  
                    }
                    else{
                        $this->db->insert('dquotationdetails', $field);             
                    }
                }
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
        $total = ($subtotal + $lcharges + $ccharges + $fcharges + $ocharges + $gst) - $roundoff;
        $field = array(
            'totalweight' => $totalweight,
            'subtotal' => $subtotal,
            'loading' => $loading,
            'lcharges' => $lcharges,
            'ccharges' => $ccharges,
            'fcharges' => $fcharges,
            'paidby' => $this->input->post('paidby'),
            'ocharges' => $ocharges,
            'gst' => $gst,
            'roundoff' => $roundoff,
            'total' => $total,
            'vehicleno' => $vehicleno,
        );
        $this->db->where('id', $oid);
        $this->db->update('dquotations', $field);

        return $oid;
    }
    
    public function getbyid($id)
    {
        $query = "SELECT * FROM dquotations WHERE id = " . $id;
        $result = $this->db->query($query);
        return $result->result()[0];
    }

    public function getdetails($id)
    {
        $query = "SELECT B.name AS brandname, P.product, PW.sizeinmm, OD.* FROM brands AS B, products AS P, productweights AS PW, dquotationdetails AS OD ";
        $query .= "WHERE B.id = OD.brandid AND P.id = OD.pid AND PW.id = OD.pwid AND OD.oid = " . $id;
        $result = $this->db->query($query);
        return $result->result();
    }

    public function delete($id)
    {       
        $this->db->where('id', $id);
        $this->db->delete('dquotations');

        $this->db->where('oid', $id);
        $this->db->delete('dquotationdetails');
    }

    public function getnextorderno($financialyear)
    {
        $query = "SELECT IFNULL(MAX(orderno), 0) AS svalue FROM dquotations WHERE financialyear = '" . $financialyear . "'";
        $orderno = $this->dbModel->getsinglevalue($query);
        return $orderno + 1;
    }
}