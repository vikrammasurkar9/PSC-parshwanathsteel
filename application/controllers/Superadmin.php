<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Superadmin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('string');
        $this->load->model('ProductsModel', 'product');
        $this->load->model('BrandsModel', 'brand');
        $this->load->model('DBModel', 'dbmodel');
        $this->load->model('ProductweightModel', 'productweight');
        $this->load->model('QuotationsModel', 'quotation');
        $this->load->model('BroadcastingModel', 'broadcasting');
        $this->load->model('UserModel', 'user');
        $this->load->model('AdminModel', 'admin');
        $this->load->model('QuotationRequestModel', 'quotationrequest');
        $this->load->model('FirmsModel', 'firm');
		$this->load->model('CookieModel', 'cookie');
        $this->load->model('ParitygroupsModel', 'paritygroup');
    }   
    public function index()
    {
        if(isset($_COOKIE['usertype']))
		{
			$usertype = $this->cookie->getCookie("usertype");
			$id = $this->cookie->getCookie("id");
			if($usertype =="pscadmin")
			    redirect(base_url('admin/dashboard'));  
            else if($usertype == "superadmin") 
                redirect(base_url('superadmin/dashboard'));      
            else                
                redirect(base_url('login')); 
		}
		else
            redirect(base_url('login'));
    }

    public function dashboard()
    {
        $data['users'] = sizeof($this->user->lists());
        $data['categories'] = sizeof($this->product->lists());
        $data['brands'] = sizeof($this->brand->lists());
        $data['productweights'] = sizeof($this->productweight->listAll());
        $data['news'] = sizeof($this->broadcasting->lists());
        $data['quotations'] = sizeof($this->quotation->lists());
        $data['givenquotations'] = sizeof($this->quotation->listgiven());
        $data['pendingquotations'] = sizeof($this->quotation->listpending());
        $this->load->view('superadmin/layout/header'); 
        $this->load->view('superadmin/layout/sidebar'); 
        $this->load->view('superadmin/dashboard', $data);
        $this->load->view('superadmin/layout/footer');
    }
    
    public function users()
    {
		$data['results'] = $this->user->lists();
        $this->load->view('superadmin/layout/header',$data); 
        $this->load->view('superadmin/layout/sidebar'); 
        $this->load->view('superadmin/users',$data);
        $this->load->view('superadmin/layout/footer');
    }
    
    //Admins
    public function admins($id)
    {
        $data['id'] = $id ;
        $query = "SELECT DISTINCT position FROM admins";
        $data['positions'] = $this->db->query($query)->result();
        $data['result'] = $this->admin->lists();
        $data['data'] = $this->admin->getbyid($id);
        $this->load->view('superadmin/layout/header',$data); 
        $this->load->view('superadmin/layout/sidebar'); 
        $this->load->view('superadmin/admins',$data);
        $this->load->view('superadmin/layout/footer');
    }
 
     public function saveAdmin()
     {
         $id = $this->input->post('id');
         $result = $this->admin->save();
 
         if($result == "false"){
             $this->session->set_flashdata('exist_msg','Already Exist');
         }elseif($result == "success"){
             if($id == 0){
                 $this->session->set_flashdata('success_msg','saved successfully');
             }else{
                 $this->session->set_flashdata('success_msg','updated successfully');
             }
         }
         redirect(base_url('superadmin/admins/0'));
     }
 
     public function deleteAdmin($id)
     {
         $result = $this->admin->delete($id);
 
         $this->session->set_flashdata('delete_msg','deleted successfully');
 
         redirect(base_url('superadmin/admins/0'));
     }


      //Admins
    public function paritygroups($brandid, $id)
    {
        $data['id'] = $id;
        $data['brandid'] = $brandid;
        $data['brand'] = $this->brand->getbyid($brandid);
        $data['result'] = $this->paritygroup->lists($brandid);        
        $data['data'] = $this->paritygroup->getbyid($id);
        $this->load->view('superadmin/layout/header',$data); 
        $this->load->view('superadmin/layout/sidebar'); 
        $this->load->view('superadmin/paritygroups');
        $this->load->view('superadmin/layout/footer');
    }
 
     public function saveParityGroup()
     {
        $brandid = $this->input->post('brandid');
        $id = $this->input->post('id');
        $result = $this->paritygroup->save(); 
        if($id == 0){
            $this->session->set_flashdata('success_msg','saved successfully');
        }
        else{
            $this->session->set_flashdata('success_msg','updated successfully');
        }
        redirect(base_url('superadmin/paritygroups/' . $brandid . '/0'));
     }
 
     public function deleteParityGroup($brandid, $id)
     {
         $result = $this->paritygroup->delete($id); 
         $this->session->set_flashdata('delete_msg','deleted successfully'); 
         redirect(base_url('superadmin/paritygroups/' . $brandid . '/0'));
     }
    
     //brands
     public function brands()
     {
         $data['result'] = $this->brand->lists();
         $data['producers'] = $this->brand->producers();
         $this->load->view('superadmin/layout/header'); 
         $this->load->view('superadmin/layout/sidebar'); 
         $this->load->view('superadmin/brands',$data);
         $this->load->view('superadmin/layout/footer');
     }
 
     public function saveBrand()
     {
         $id = $this->input->post('id');
         $result = $this->brand->save();
 
         if($result == "false"){
             $this->session->set_flashdata('exist_msg','Already Exist');
         }elseif($result == "success"){
             if($id == 0){
                 $this->session->set_flashdata('success_msg','Record saved successfully');
             }else{
                 $this->session->set_flashdata('success_msg','Record updated successfully');
             }
         }
         redirect(base_url('admin/brands/0'));
     }
 
     public function deleteBrand($id)
     {
         $result = $this->brand->delete($id);
 
         $this->session->set_flashdata('delete_msg','Record deleted successfully');
 
         redirect(base_url('admin/brands/0'));
     }

     public function brandproducts($brandid)
     {
         $data['brandid'] = $brandid;
         $data['brand'] = $this->brand->getbyid($brandid);
         $data['result'] = $this->brand->onlyproducts($brandid);
         $data['products'] = $this->product->lists();
         $data['paritygroups'] = $this->paritygroup->lists($brandid);
         $query = "SELECT * FROM paritygroupproducts";
         $data['paritygroupproducts'] = $this->dbmodel->getdata($query);
         $this->load->view('superadmin/layout/header'); 
         $this->load->view('superadmin/layout/sidebar'); 
         $this->load->view('superadmin/brandproducts',$data);
         $this->load->view('superadmin/layout/footer');
     }

     public function brandproductreport($brandid)
     {
         $data['brandid'] = $brandid;
         $data['brand'] = $this->brand->getbyid($brandid);
         $data['result'] = $this->brand->onlyproducts($brandid);
        //  print_r($data['result']);
        //  exit;
         $data['paritygroups'] = $this->paritygroup->lists($brandid);
         $query = "SELECT * FROM paritygroupproducts";
         $data['paritygroupproducts'] = $this->dbmodel->getdata($query);
         $this->load->view('superadmin/layout/header'); 
         $this->load->view('superadmin/layout/sidebar'); 
         $this->load->view('superadmin/brandproductreport',$data);
         $this->load->view('superadmin/layout/footer');
     }

     public function updatebaserate()
     {
        $brandid = $this->input->post('brandid',TRUE);
        $baserate = $this->input->post('baserate',TRUE);
        
        $query = "UPDATE brands SET baserate = " . $baserate . " WHERE id = " . $brandid;
        $this->db->query($query);

        $query = "UPDATE brandproducts SET rate = " . $baserate . " + parity WHERE bid = " . $brandid;
        $this->db->query($query);

        $query = "UPDATE brandproducts SET billingrate = rate WHERE bid = " . $brandid . " AND pwid IN(SELECT PW.id FROM productweights AS PW, products AS P WHERE P.id = PW.pid AND P.billingin = 'Kgs') ";
        $this->db->query($query);

        $query = "SELECT BP.id, BP.rate, BP.parity, PW.weight FROM brandproducts AS BP, productweights AS PW, products AS P WHERE  BP.pwid = PW.id AND P.id = PW.pid AND P.billingin = 'Meter' AND BP.bid = " . $brandid;
        $result = $this->dbmodel->getdata($query);
        foreach($result as $row)
        {
            $rate = $row->rate;
            $query = "UPDATE brandproducts SET billingrate = " . $rate * $row->weight . " WHERE id = " . $row->id;
            $this->db->query($query);
        }

        $query = "SELECT BP.id, PW.weight FROM brandproducts AS BP, productweights AS PW, products AS P WHERE  BP.pwid = PW.id AND P.id = PW.pid AND P.billingin = 'Feet' AND BP.bid = " . $brandid;
        $result = $this->dbmodel->getdata($query);
        foreach($result as $row)
        {
            $query = "UPDATE brandproducts SET billingrate = rate * " . ($row->weight / 3.28) . " WHERE id = " . $row->id;
            $this->db->query($query);
        }
		echo json_encode("success");

     }
     public function updateparity()
     {
        $productid = $this->input->post('productid',TRUE);
        $parity = $this->input->post('parity',TRUE);
        
        if($parity != ""){
            $query = "UPDATE brandproducts SET parity = " . $parity . " WHERE id=".$productid;
            $data = $this->db->query($query);            
        
            $query = "SELECT * FROM brandproducts WHERE id = " . $productid;
            $result = $this->dbmodel->getdata($query);
            $brandproduct = $result[0];
            $pwid = $brandproduct->pwid;
            $brandid = $brandproduct->bid;
        
            $query = "SELECT * FROM brands WHERE id = " . $brandid;
            $result = $this->dbmodel->getdata($query);
            $brand = $result[0];
            $baserate = $brand->baserate;

            $query = "SELECT PW.weight, P.billingin FROM products AS P, productweights AS PW WHERE P.id = PW.pid AND PW.id = " . $pwid;
            $result = $this->dbmodel->getdata($query);
            $productweight = $result[0];
            $weight = $productweight->weight;
            $billingin = $productweight->billingin;

            $rate = $baserate + $parity;        
            $billingrate = $baserate + $parity;
            if($billingin == "Kgs")
            {
                $billingrate = $rate;
            }
            else if($billingin == "Meter")
            {
                // $billingrate = $rate * 6;
                $billingrate = $rate * $weight;
            }
            else if($billingin == "Feet")
            {
                $billingrate = $rate / 3.28;
            }
            $query = "UPDATE brandproducts SET rate = " . $rate . ", billingrate = " . $billingrate . "  WHERE id = " . $productid;
            $this->db->query($query);
        }
        else{
            $query = "UPDATE brandproducts SET parity = NULL, rate = NULL, billingrate = NULL WHERE id = ".$productid;
            $data = $this->db->query($query);
        }
		echo json_encode("success");
    }    

    public function updateparitygroup()
    {
        $brandproductid = $this->input->post('brandproductid');
        $paritygroupid = $this->input->post('paritygroupid');
        $query = "DELETE FROM paritygroupproducts WHERE bpid = " . $brandproductid;
        $this->db->query($query);
        if($paritygroupid != 0)
        {
            $query = "INSERT INTO paritygroupproducts(pgroupid, bpid) VALUES(" . $paritygroupid . ", " . $brandproductid . ")";
            $this->db->query($query);
        }
        echo json_encode("success");
    }

    public function updateparitygroupparity()
    {
        $pgid = $this->input->post('pgid');
        $parity = $this->input->post('parity');
        $query = "UPDATE paritygroups SET parity = " . $parity . " WHERE id = " . $pgid;
        $this->db->query($query);
        $query = "SELECT B.baserate, BP.id AS bpid FROM brands AS B, brandproducts AS BP, paritygroupproducts AS PGP WHERE B.id = BP.bid ";
        $query .= "AND BP.id = PGP.bpid AND PGP.pgroupid = " . $pgid;

       
        

        $result = $this->dbmodel->getdata($query);
        foreach($result as $row)
        {
            $query = "UPDATE brandproducts SET parity = " . $parity . ", billingrate = " . ($row->baserate + $parity) . " WHERE id = " . $row->bpid;
            $this->db->query($query);
            
        }

        $paritygroup = $this->paritygroup->getbyid($pgid);
        $brandid = $paritygroup->brandid;
        $query = "UPDATE brandproducts SET billingrate = rate WHERE bid = " . $brandid . " AND pwid IN(SELECT PW.id FROM productweights AS PW, products AS P WHERE P.id = PW.pid AND P.billingin = 'Kgs') ";
        $this->db->query($query);

        $query = "SELECT BP.id, BP.rate, BP.parity, PW.weight FROM brandproducts AS BP, productweights AS PW, products AS P WHERE  BP.pwid = PW.id AND P.id = PW.pid AND P.billingin = 'Meter' AND BP.bid = " . $brandid;
        $result = $this->dbmodel->getdata($query);
        
        foreach($result as $row)
        {
            $rate = $row->rate + $row->parity;
            $query = "UPDATE brandproducts SET billingrate = " . $rate * $row->weight . " WHERE id = " . $row->id;
            $this->db->query($query);
        }

        $query = "SELECT BP.id, PW.weight FROM brandproducts AS BP, productweights AS PW, products AS P WHERE  BP.pwid = PW.id AND P.id = PW.pid AND P.billingin = 'Feet' AND BP.bid = " . $brandid;
        $result = $this->dbmodel->getdata($query);
        foreach($result as $row)
        {
            $query = "UPDATE brandproducts SET billingrate = rate * " . ($row->weight / 3.28) . " WHERE id = " . $row->id;
            $this->db->query($query);
        }
        echo json_encode("success");
    }

    //Broadcasting

    public function broadcasting()
    {
        $data['id'] = 0;
        $data['result'] = $this->broadcasting->lists();        
        $this->load->view('superadmin/layout/header'); 
        $this->load->view('superadmin/layout/sidebar'); 
        $this->load->view('superadmin/broadcasting',$data);
        $this->load->view('superadmin/layout/footer');
    }

    public function saveBroadcasting()
    {
        $id = $this->input->post('id');
        $result = $this->broadcasting->save();

        if($result = "success"){
            if($id==0){
                $this->session->set_flashdata('success_msg', 'Record Save Successfully');
                }else{
                    $this->session->set_flashdata('success_msg', 'Record Updated Successfully');
                }
        }

        //redirect(base_url('admin/broadcasting/0'));

    }

    public function deleteBroadcasting($id)
    {
        $result = $this->broadcasting->delete($id);
        
        $this->session->set_flashdata('delete_msg','Record deleted successfully');

        redirect(base_url('superadmin/broadcasting/0'));
    }


     //firms

     public function firms($id)
     {
         $data['id'] = $id;
         $data['result'] = $this->firm->lists();       
         $data['data'] = $this->firm->getbyid($id);         
         $this->load->view('superadmin/layout/header'); 
         $this->load->view('superadmin/layout/sidebar'); 
         $this->load->view('superadmin/firms',$data);
         $this->load->view('superadmin/layout/footer');
     }
 
     public function savefirm()
     {
         $id = $this->input->post('id');
         $result = $this->firm->save();
         if($result = "success"){
             if($id==0){
                 $this->session->set_flashdata('success_msg', 'Record Save Successfully');
             }else{
                 $this->session->set_flashdata('success_msg', 'Record Updated Successfully');
             }
         }
         redirect(base_url('superadmin/firms/0'));
     }
 
     public function deletefirm($id)
     {
         $result = $this->firm->delete($id);        
         $this->session->set_flashdata('delete_msg','Record deleted successfully');
         redirect(base_url('superadmin/firms/0'));
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
	

    public function logout()  
    { 
        $this->clearCookie('usertype');
        $this->clearCookie('id');
        $this->session->unset_userdata('usertype');
        $this->session->unset_userdata('id');
        redirect(base_url());
    }
}




