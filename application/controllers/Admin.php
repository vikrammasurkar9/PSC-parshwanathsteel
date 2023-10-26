<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');	
        $this->load->helper('string');
        $this->load->model('ProductsModel', 'product');
        $this->load->model('BrandsModel', 'brand');
        $this->load->model('ProductweightModel', 'productweight');
        $this->load->model('QuotationsModel', 'quotation');
        $this->load->model('DquotationModel', 'dquotation');
        $this->load->model('BroadcastingModel', 'broadcasting');
        $this->load->model('ArchivesModel', 'archive');
        $this->load->model('CategoriesModel', 'category');
        $this->load->model('BrandgroupsModel', 'brandgroup');
        $this->load->model('UserModel', 'user');
        $this->load->model('DBModel', 'dbmodel');
        $this->load->model('QuotationRequestModel', 'quotationrequest');
        $this->load->model('OrdersModel', 'order');
		$this->load->model('SliderModel', 'slider');
		$this->load->model('ProfessionModel', 'profession');
        $this->load->model('EnquirysourcesModel', 'enquirysource');
        $this->load->model('FirmsModel', 'firm');
        $this->load->model('ContactsModel', 'contact');
		$this->load->model('CookieModel', 'cookie');
        $this->load->model('AdminModel', 'admin');
        $this->load->model('EnquiryModel', 'enquiry');
        $this->load->model('DispatchModel', 'dispatch');

    }

    public function trial(){

        $query = 'SELECT id, leadno, financialyear FROM `quotations` WHERE financialyear="2023-2024" ORDER BY id ASC';
        $result = $this->db->query($query)->result();
        $count = 1;
        foreach ($result as $row)
        {
           //echo $row->id;
           $query = "UPDATE quotations SET leadno = '$count' WHERE id = ".$row->id."";
           $this->db->query($query);
           $count++;
            
        }
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
        $data['orders'] = sizeof($this->order->lists());
        $data['givenquotations'] = sizeof($this->quotation->listgiven());
        $data['pendingquotations'] = sizeof($this->quotation->listpending());
        $data['firms'] = $this->firm->lists(); 
        $this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/dashboard', $data);
        $this->load->view('admin/layout/footer');
    }
    
     public function slider($id)
	{
		$data['id'] = $id;
		$data['result'] = $this->slider->lists();
        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/slider', $data);
		$this->load->view('admin/layout/footer');
	}

	public function saveslider()
	{
		$result = $this->slider->save();
		redirect(base_url('admin/slider/0'));
	}

	public function deleteslider($id)
	{
		$result = $this->slider->delete($id);
		redirect(base_url('admin/slider/0'));
	}

    public function profession($id)
	{
		$data['id'] = $id;
        $data['data'] = $this->profession->getbyid($id);
		$data['result'] = $this->profession->lists();
        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/profession', $data);
		$this->load->view('admin/layout/footer');
	}

	public function saveprofession()
	{
		$result = $this->profession->save();
		redirect(base_url('admin/profession/0'));
	}

	public function deleteprofession($id)
	{
		$result = $this->profession->delete($id);
		redirect(base_url('admin/profession/0'));
	}
    //Enquiry Sources

    public function enquirysource($id)
	{
		$data['id'] = $id;
        $data['data'] = $this->enquirysource->getbyid($id);
		$data['result'] = $this->enquirysource->lists();
        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data);
		$this->load->view('admin/layout/sidebar');
		$this->load->view('admin/enquirysource', $data);
		$this->load->view('admin/layout/footer');
	}

	public function saveenquirysource()
	{
		$result = $this->enquirysource->save();
		redirect(base_url('admin/enquirysource/0'));
	}

	public function deleteenquirysource($id)
	{
		$result = $this->enquirysource->delete($id);
		redirect(base_url('admin/enquirysource/0'));
	}

    
    public function users()
    {
		$data['results'] = $this->user->lists();
        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data);
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/users',$data);
        $this->load->view('admin/layout/footer');
	}

    public function user($id)
    {
        $data['id'] = $id;
        $data['data'] = $this->user->getbyid($id);
        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/user',$data);
        $this->load->view('admin/layout/footer');
    }

    public function saveuser()
    {
        $id = $this->input->post('id');
        $result = $this->user->save();
        if($result == "false"){
            $this->session->set_flashdata('exist_msg','Already Exist');
        }elseif($result == "success"){
            if($id == 0){
                $this->session->set_flashdata('success_msg','Record saved successfully');
            }else{
                $this->session->set_flashdata('success_msg','Record updated successfully');
            }
        }
        redirect(base_url('admin/requests'));
    }
    
    //products
    public function products($id)
    {
       
        $data['id'] = $id ;
        $data['result'] = $this->product->lists();
        $data['categories'] = $this->category->lists();
        $data['data'] = $this->product->getbyid($id);
        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data);
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/products',$data);
        $this->load->view('admin/layout/footer');
    }

    public function saveProduct()
    {
        $id = $this->input->post('id');
        $result = $this->product->save();

        if($result == "false"){
            $this->session->set_flashdata('exist_msg','Already Exist');
        }elseif($result == "success"){
            if($id == 0){
                $this->session->set_flashdata('success_msg','Record saved successfully');
            }else{
                $this->session->set_flashdata('success_msg','Record updated successfully');
            }
        }
        redirect(base_url('admin/products/0'));
    }

    public function deleteProduct($id)
    {
        $result = $this->product->delete($id);
        $this->session->set_flashdata('delete_msg','Record deleted successfully');
        redirect(base_url('admin/products/0'));
    }

     //brands
     public function brands($id)
     {
        
         $data['id'] = $id ;
         $data['result'] = $this->brand->lists();
         $data['producers'] = $this->brand->producers();
         $data['brandgroups'] = $this->brandgroup->lists();
         $data['data'] = $this->brand->getbyid($id);
         $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data);
         $this->load->view('admin/layout/sidebar'); 
         $this->load->view('admin/brands',$data);
         $this->load->view('admin/layout/footer');
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
         $data['brand'] = $this->brand->getbyid($brandid);
         $data['result'] = $this->brand->products($brandid);
         $data['products'] = $this->product->lists();
         $data['firms'] = $this->firm->lists(); 
         $this->load->view('admin/layout/header',$data);
         $this->load->view('admin/layout/sidebar'); 
         $this->load->view('admin/brandproducts', $data);
         $this->load->view('admin/layout/footer');
     }

    public function addproductinbrand($bid, $pwid)
	{
		$query = "INSERT INTO brandproducts(bid, pwid) VALUES(" . $bid . ", " . $pwid . ")";
		$this->db->query($query);
        echo "success";        
	}

	public function removeproductinbrand($bid, $pwid)
	{
        $query = "DELETE FROM brandproducts WHERE bid = " . $bid . " AND pwid = " . $pwid;
		$this->db->query($query);
		echo "success";
	}
    
    //ProductWeight
    public function productweights($pid, $id)
    {
        $data['id'] = $id;
        $data['pid'] = $pid;
        $data['result'] = $this->productweight->productweightlistbypid($pid);
        $data['data'] = $this->productweight->getbyid($id);
        $data['product'] = $this->product->getbyid($pid);        
        $data['products'] = $this->product->lists();
        $data['brandwiseproductweights'] = $this->productweight->brandwiseproductweights($id);

        // echo $data['product']->type;
        // exit;
        // print_r($data);
        // exit;

        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data);
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/productweights',$data);
        $this->load->view('admin/layout/footer');
    }

    public function saveProductweight()
    {
        $pid = $this->input->post('pid');
        $id = $this->input->post('id');
        $result = $this->productweight->save();
       
        if($result == "false"){
            $this->session->set_flashdata('exist_msg', ' Already exist');
        }elseif($result == "success"){
            if($id==0){
            $this->session->set_flashdata('success_msg', 'Record Save Successfully');
            }else{
                $this->session->set_flashdata('success_msg', 'Record Updated Successfully');
            }
        }
       
        redirect(base_url('admin/productweights/'. $pid .'/0'));
    }

    public function deleteProductweight($pid, $id)
    {
        $result= $this->productweight->delete($id);
        $this->session->set_flashdata('delete_msg','Record deleted successfully');
        redirect(base_url('admin/productweights/'. $pid .'/0'));
    }

    //Broadcasting

    public function broadcasting()
    {
        $data['id'] = 0;
        $data['result'] = $this->broadcasting->lists();        
        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/broadcasting',$data);
        $this->load->view('admin/layout/footer');
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
        redirect(base_url('admin/broadcasting/0'));
    }

    public function deleteBroadcasting($id)
    {
        $result = $this->broadcasting->delete($id);        
        $this->session->set_flashdata('delete_msg','Record deleted successfully');
        redirect(base_url('admin/broadcasting/0'));
    }


    //Contacts

    public function contacts($id)
     {        
         $data['id'] = $id ;
         $data['result'] = $this->contact->lists();
         $data['states'] = $this->contact->states();
         $data['professions'] = $this->profession->lists();
        if($id !=0)
        {
         $data['data'] = $this->contact->getbyid($id);
         $data['cities'] = $this->contact->cities($data['data']->state);
        }

         $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data); 
         $this->load->view('admin/layout/sidebar'); 
         $this->load->view('admin/contacts',$data);
         $this->load->view('admin/layout/footer');
     }

    public function savecontact()
    {
        $id = $this->input->post('id');
        $result = $this->contact->save();
        if($result = "success"){
            if($id==0){
                $this->session->set_flashdata('success_msg', 'Record Save Successfully');
            }else{
                $this->session->set_flashdata('success_msg', 'Record Updated Successfully');
            }
        }
        redirect(base_url('admin/contacts/0'));
    }

    public function deletecontact($id)
    {
        $result = $this->contact->delete($id);        
        $this->session->set_flashdata('delete_msg','Record deleted successfully');
        redirect(base_url('admin/contacts/0'));
    }

    public function uploadexcel()
    {
        $this->contact->uploadexcel("PSS.xls");
    }



    //Archives

    public function archives()
    {
        $data['id'] = 0;
        $data['result'] = $this->archive->lists();        
        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/archives',$data);
        $this->load->view('admin/layout/footer');
    }

    public function savearchive()
    {
        $id = $this->input->post('id');
        $result = $this->archive->save();
        if($result = "success"){
            if($id==0){
                $this->session->set_flashdata('success_msg', 'Record Save Successfully');
            }else{
                $this->session->set_flashdata('success_msg', 'Record Updated Successfully');
            }
        }
        redirect(base_url('admin/archives/0'));
    }

    public function deletearchive($id)
    {
        $result = $this->archive->delete($id);        
        $this->session->set_flashdata('delete_msg','Record deleted successfully');
        redirect(base_url('admin/archives/0'));
    }

    //Categories
    public function categories($id)
    {
        $data['id'] = $id;
        $data['data'] = $this->category->getbyid($id);
        $data['result'] = $this->category->lists();        
        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/categories',$data);
        $this->load->view('admin/layout/footer');
    }

    public function saveCategory()
    {
        $id = $this->input->post('id');
        $result = $this->category->save();
        if($result = "success"){
            if($id==0){
                $this->session->set_flashdata('success_msg', 'Record Save Successfully');
            }else{
                $this->session->set_flashdata('success_msg', 'Record Updated Successfully');
            }
        }
        redirect(base_url('admin/categories/0'));
    }

    public function deleteCategory($id)
    {
        $result = $this->category->delete($id);        
        $this->session->set_flashdata('delete_msg', 'Record deleted successfully');
        redirect(base_url('admin/categories/0'));
    }

    public function brandgroups($id)
    {
        $data['id'] = $id;
        $data['data'] = $this->brandgroup->getbyid($id);
        $data['result'] = $this->brandgroup->lists();        
        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/brandgroups',$data);
        $this->load->view('admin/layout/footer');
    }

    public function saveBrandGroup()
    {
        $id = $this->input->post('id');
        $result = $this->brandgroup->save();
        if($result = "success"){
            if($id==0){
                $this->session->set_flashdata('success_msg', 'Record Save Successfully');
            }else{
                $this->session->set_flashdata('success_msg', 'Record Updated Successfully');
            }
        }
        redirect(base_url('admin/brandgroups/0'));
    }

    public function deleteBrandGroup($id)
    {
        $result = $this->brandgroup->delete($id);        
        $this->session->set_flashdata('delete_msg','Record deleted successfully');
        redirect(base_url('admin/brandgroups/0'));
    }
    // public function followupquotations()
    // {
    //     $url = base_url("admin/quotations");
    //     $data['total'] = sizeof($this->quotation->totalquotations());
    //     $total_rows = $this->quotation->totalrecords();
    //     $per_page = 250;
    //     $uri_segment = 3;
    //     $config = $this->dbmodel->configurePagination($url, $total_rows, $per_page, $uri_segment);
	// 	$this->pagination->initialize($config);
	// 	$page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;
	// 	$data["page"] = $page;
	// 	$data["links"] = $this->pagination->create_links();
    //     $data["total_rows"] = $total_rows;
    //     $data['result'] = $this->quotation->get_data_for_quotations($per_page, $page);
    //     $this->load->view('admin/layout/header'); 
    //     $this->load->view('admin/layout/sidebar'); 
    //     $this->load->view('admin/followupquotations', $data);
    //     $this->load->view('admin/layout/footer');
    // }

    public function quotations()
    {
        $url = base_url("admin/quotations");
        $data['total'] = sizeof($this->quotation->totalquotations());
        $total_rows = $this->quotation->totalrecords();
        $per_page = 250;
        $uri_segment = 3;
        $config = $this->dbmodel->configurePagination($url, $total_rows, $per_page, $uri_segment);
		$this->pagination->initialize($config);
		$page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;
		$data["page"] = $page;
		$data["links"] = $this->pagination->create_links();
        $data["total_rows"] = $total_rows;
        $data['result'] = $this->quotation->get_data_for_quotations($per_page, $page);
        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/quotations', $data);
        $this->load->view('admin/layout/footer');
    }

    // Enquiry

    public function enquiries()
    {
        $url = base_url("admin/enquiries");
        $data['total'] = $this->enquiry->totalrecords();
        
        $total_rows = $this->enquiry->totalrecords();
        $per_page = 200;
        $uri_segment = 3;
        $config = $this->dbmodel->configurePagination($url, $total_rows, $per_page, $uri_segment);
		$this->pagination->initialize($config);
		$page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;
		$data["page"] = $page;
		$data["links"] = $this->pagination->create_links();
        $data["total_rows"] = $total_rows;
        $data['result'] = $this->enquiry->get_data_for_enquiries($per_page, $page);
        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/enquiries', $data);
        $this->load->view('admin/layout/footer');
    }

    public function enquiry($id)
    {
        $data['id']= $id; 
        $data['contacts'] = $this->contact->lists();    
        $data['professions'] = $this->profession->lists();   
        $data['firms'] = $this->firm->lists(); 
        $data['data'] = $this->enquiry->getbyid($id);
        if($id!= 0)
        $data['user'] = $this->user->getbyid($data['data']->userid);
        // print_r($data['user']);
        // exit;
        $this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/enquiry', $data);
        $this->load->view('admin/layout/footer');
    }

    public function saveEnquiry()
    {
        $eid = $this->enquiry->save();
        $contactid = $this->input->post('contactid');
        if($contactid != 0)
        {
            $this->contact->updatecontact();           
        }
        redirect(base_url('admin/enquiries/'));
    }
    public function deleteenquiry($id)
    {
        $result = $this->enquiry->delete($id);
        $this->session->set_flashdata('delete_msg','Record deleted successfully');
        redirect(base_url('admin/enquiries'));
    }
    public function printenquiry($id)
    {
        $data['id'] = $id;
        $data['data'] = $this->enquiry->getenquirybyid($id);  
        $data['firm'] = $this->firm->getbyid($data['data']->firmid);   
        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/printenquiry',$data);
        $this->load->view('admin/layout/footer');
    }

    // public function editrequest($id)
    // {
    //     $data['id']= $id; 
    //     $data['data'] = $this->quotation->getbyid($id);
    //     $data['user'] = $this->user->getbyid($data['data']->userid);
    //     $data['brands'] = $this->brand->lists();    
    //     $data['firms'] = $this->firm->lists(); 
    //     $data['brandproducts'] = $this->brand->brandproducts();
    //     $data['quotationsdetails'] = $this->quotation->getdetails($id);    
    //     $data['professions'] = $this->profession->lists();    
    //     $data['quotationbrandprices'] = $this->quotation->quotationbrandprices($id);
    //     $data['productlist'] = $this->product->lists();
    //     $data['productweightlist'] = $this->productweight->listAll();
    //     $this->load->view('admin/layout/header'); 
    //     $this->load->view('admin/layout/sidebar'); 
    //     $this->load->view('admin/editrequest', $data);
    //     $this->load->view('admin/layout/footer');
    // }


public function allrequests()
    {
       $data['result'] = $this->quotation->lists();

        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/allrequests', $data);
        $this->load->view('admin/layout/footer');
    }
    public function requests()
    {
        $url = base_url("admin/requests");
        $data['total'] = sizeof($this->quotation->totalleads());
        
        $total_rows = $this->quotation->totalrecords();
        $per_page = 200;
        $uri_segment = 3;
        $config = $this->dbmodel->configurePagination($url, $total_rows, $per_page, $uri_segment);
		$this->pagination->initialize($config);
		$page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;
		$data["page"] = $page;
		$data["links"] = $this->pagination->create_links();
        $data["total_rows"] = $total_rows;
        $data['result'] = $this->quotation->get_data_for_requests($per_page, $page);
        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/requests', $data);
        $this->load->view('admin/layout/footer');
    }

    public function request()
    {
        $data['id']= 0; 
        $data['contacts'] = $this->contact->lists();      
        $data['productlist'] = $this->product->lists();   
        $data['professions'] = $this->profession->lists(); 
        $data['enquirysources'] = $this->enquirysource->lists();          
        $data['states'] = $this->contact->states();
        $data['firms'] = $this->firm->lists(); 
        $this->load->view('admin/layout/header', $data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/request', $data);
        $this->load->view('admin/layout/footer');
    }

    public function saveRequest()
    {
        $qid = $this->quotationrequest->save();
        $contactid = $this->input->post('contactid');
        if($contactid != 0)
        {
            $this->contact->updatecontact();           
        }
        redirect(base_url('admin/printrequest/'.$qid));
    }

    public function editrequest($id)
    {
        $data['id']= $id; 
        $data['data'] = $this->quotation->getbyid($id);
        $data['states'] = $this->contact->states();
        $data['cities'] = $this->contact->cities($data['data']->state);
        $data['user'] = $this->user->getbyid($data['data']->userid);
        $data['brands'] = $this->brand->lists();    
        $data['firms'] = $this->firm->lists(); 
        $data['brandproducts'] = $this->brand->brandproducts();
        $data['quotationsdetails'] = $this->quotation->getdetails($id);    
        $data['professions'] = $this->profession->lists();    
        $data['quotationbrandprices'] = $this->quotation->quotationbrandprices($id);
        $data['productlist'] = $this->product->lists();
        $data['productweightlist'] = $this->productweight->listAll();
        $data['enquirysources'] = $this->enquirysource->lists(); 
        $this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/editrequest', $data);
        $this->load->view('admin/layout/footer');
    }

    public function savetocontacts()
    {
        $userid = $this->input->post('userid',TRUE);
        $this->contact->savefromleads($userid);
        echo json_encode("success");
    }
    public function updatefollowupstatus()
    {
        $id = $this->input->post('id',TRUE);
        $query = "UPDATE quotations SET followup = 'Yes' WHERE id = ".$id."";
        $this->db->query($query);
        echo json_encode("success");
    }

    public function printrequest($id)
    {
        $data['id'] = $id;
        $data['data'] = $this->quotation->getbyid($id);        
        $data['firm'] = $this->firm->getbyid($data['data']->firmid);
        $data['brands'] = $this->brand->lists();
        $data['brandproducts'] = $this->brand->brandproducts();
        $data['result'] = $this->quotation->getdetails($id);
        // print_r($data['result']);
        // exit;
        $data['quotationbrandprices'] = $this->quotation->quotationbrandprices($id);
        
        $data['producers'] = $this->brand->producers();
        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/printrequest',$data);
        $this->load->view('admin/layout/footer');
    }

    public function deleterequest($id)
    {
        $result = $this->quotationrequest->delete($id);
        $this->session->set_flashdata('delete_msg','Record deleted successfully');
        redirect(base_url('admin/requests'));
    }

    public function deleterequests()
    {
        $query = "DELETE FROM quotations WHERE requestdate < (NOW() - INTERVAL 10 DAY)";
        $this->db->query($query);
        $query = "DELETE FROM quotationdetails WHERE qid NOT IN(SELECT id FROM quotations)";
        $this->db->query($query);
        $this->session->set_flashdata('delete_msg','Record deleted successfully');
        redirect(base_url('admin/requests'));
    }

    public function quotation($id)
    {
        $data['id'] = $id;
        $data['data'] = $this->quotation->getbyid($id);     
        $data['firm'] = $this->firm->getbyid($data['data']->firmid);
        $data['producers'] = $this->brand->producers();
        $data['brands'] = $this->brand->lists();
        $data['brandproducts'] = $this->brand->brandproducts();
        $data['result'] = $this->quotation->getdetails($id);
        
        $data['quotationbrandprices'] = $this->quotation->quotationbrandprices($id);
        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/quotation', $data);
        $this->load->view('admin/layout/footer');
    }

    public function saveQuotation()
    {
        $send = $this->input->post('send');
        $this->quotation->saveQuotation();
        $id = $this->input->post('id');
        $this->session->set_flashdata('success_msg', 'Quotation prepared.');
        redirect(base_url('admin/printquotation/' . $id.'?send='.$send));
    }

    //brands
    public function printquotation($id)
    {
        $data['id'] = $id;
        $data['data'] = $this->quotation->getbyid($id);     
        $data['firm'] = $this->firm->getbyid($data['data']->firmid);
        $data['producers'] = $this->brand->producers();
        $data['brands'] = $this->brand->lists();
        $data['brandproducts'] = $this->brand->brandproducts();
        $data['result'] = $this->quotation->getdetails($id);
        $data['quotationbrandprices'] = $this->quotation->quotationbrandprices($id);
        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/printquotation',$data);
        $this->load->view('admin/layout/footer');
    }

    public function saveImage()
    {
        $img = $_POST['img'];
        $id = $_POST['id'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $name = random_string('alnum', 20);
        file_put_contents('././quotations/' . $name . '.png', $data);
        $query  = "UPDATE quotations SET filename = '" . $name . ".png' WHERE id = " . $id;
        $this->db->query($query);
    }

    // public function saveReview()
    // {
    //     $qid = $this->input->post('qid');
    //     $review = $this->input->post('review');
    //     $rating = $this->input->post('rating');

    //     $query  = "UPDATE quotations SET review = '" . $review . "' , rating='".$rating."' WHERE id = " . $qid;
    //     $this->db->query($query);
    //     redirect(base_url('admin/quotations'));
    // }

    public function saveReview()
    {
        $qid = $this->input->post('qid');
        $review = $this->input->post('review');
        $reviewstatus = $this->input->post('reviewstatus');
        date_default_timezone_set('Asia/Kolkata');
        $now = date('Y-m-d H:i:s'); 
        $createdby = $_COOKIE['name'];

        $query  = "INSERT INTO quotationreviews (qid, reviewstatus, review, updatedon, createdby) VALUES ";
        $query .= "(".$qid.", '".$reviewstatus."', '".$review."', '".$now."', '".$createdby."')";
        $this->db->query($query);
        redirect(base_url('admin/quotations'));
    }

    //Send On whatsapp

    public function sendQuotation()
    {
        $img = $_POST['img'];
        $id = $_POST['id'];
        $mobileno = $_POST['mobileno'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $name = random_string('alnum', 20);
        file_put_contents('././quotations/' . $name . '.png', $data);
        $query  = "UPDATE quotations SET filename = '" . $name . ".png' WHERE id = " . $id;
        $this->db->query($query);
        $adminid = $_COOKIE['adminid'];
        $admin = $this->admin->getbyid($adminid);     

        $url = base_url('././quotations/' . $name . '.png');

        $msg = "Quotation From : \n\n ".$admin->username . " \n Parshwanath Ispat Pvt Ltd";

        file_get_contents('http://bulkwhatsapp.live/whatsapp/api/send?mobile='.$mobileno.'&msg='.urlencode($msg).'&apikey='.$admin->wakey.'&img1='.$url);
        
    }
    public function sendOrder()
    {
        $img = $_POST['img'];
        $id = $_POST['id'];
        $mobileno = $_POST['mobileno'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $name = random_string('alnum', 20);
        file_put_contents('././orders/' . $name . '.png', $data);
        // $query  = "UPDATE quotations SET filename = '" . $name . ".png' WHERE id = " . $id;
        // $this->db->query($query);
        $adminid = $_COOKIE['adminid'];
        $admin = $this->admin->getbyid($adminid);  
        $url = base_url('././orders/' . $name . '.png');

        $msg = "DO From : \n\n ".$admin->username . " \n Parshwanath Ispat Pvt Ltd";
        $url1 = "http://bulkwhatsapp.live/whatsapp/api/send?mobile='.$mobileno.'&msg='.$msg.'&apikey='.$admin->wakey.'&img1='.$url";

       
        file_get_contents('http://bulkwhatsapp.live/whatsapp/api/send?mobile='.$mobileno.'&msg='.urlencode($msg).'&apikey='.$admin->wakey.'&img1='.$url);

        
    }

    //Estimate

    public function newquotation()
 {
     $data['id']= 0; 
     $data['contacts'] = $this->contact->lists();      
     $data['productlist'] = $this->product->lists();   
     $data['enquirysources'] = $this->enquirysource->lists(); 
     $data['professions'] = $this->profession->lists();   
     $data['firms'] = $this->firm->lists();     
     $data['states'] = $this->contact->states();
     $this->load->view('admin/layout/header',$data); 
     $this->load->view('admin/layout/sidebar'); 
     $this->load->view('admin/newquotation', $data);
     $this->load->view('admin/layout/footer');
 }
 public function savenewquotation()
    {

        $send = $this->input->post('send');
        $qid = $this->quotation->savenewquotation();        
        $contactid = $this->input->post('contactid');
        if($contactid != 0)
        {
            $this->contact->updatecontact();           
        } 

        $this->session->set_flashdata('success_msg', 'Single brand quotation prepared.');
        redirect(base_url('admin/printsquotation/' . $qid.'?send='.$send));
    }


    public function editsquotation($id)
    {
        $data['id'] = $id;
        
        $data['data'] = $this->quotation->getbyid($id);   
        $data['states'] = $this->contact->states();
        $data['cities'] = $this->contact->cities($data['data']->state);
        $data['professions'] = $this->profession->lists();   
        $data['firm'] = $this->firm->getbyid($data['data']->firmid);
        $data['firms'] = $this->firm->lists();
        $data['producers'] = $this->brand->producers();
        $data['brandproducts'] = $this->brand->brandproducts();
        $data['result'] = $this->quotation->getdetails($id);
              
        $data['quotationbrandprices'] = $this->quotation->quotationbrandprices($id);

        $data['productlist'] = $this->product->lists();
        $data['productvarietylist'] = $this->productweight->lists();
        $query = "SELECT BP.*, B.name, B.baserate FROM brands AS B, brandproducts AS BP WHERE B.id = BP.bid ORDER BY B.srno";
        $data['brands'] = $this->dbmodel->getdata($query);
        $data['enquirysources'] = $this->enquirysource->lists(); 
        $this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/squotationedit',$data);
        $this->load->view('admin/layout/footer');
    }
    public function squotation($id)
    {
        $data['id'] = $id;
        $data['data'] = $this->quotation->getbyid($id);   
        $data['firm'] = $this->firm->getbyid($data['data']->firmid);
        $data['producers'] = $this->brand->producers();
        $data['brands'] = $this->brand->lists();
        $data['brandproducts'] = $this->brand->brandproducts();
        $data['result'] = $this->quotation->getdetails($id);
        $data['productlist'] = $this->product->lists();   
              
        $data['quotationbrandprices'] = $this->quotation->quotationbrandprices($id);

        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/squotation',$data);
        $this->load->view('admin/layout/footer');
    }

    public function savesquotation()
    {
     
        $send = $this->input->post('send');
    
        $this->quotation->savesquotation();
        $id = $this->input->post('id');

        $this->session->set_flashdata('success_msg', 'Single brand quotation prepared.');
        redirect(base_url('admin/printsquotation/' . $id.'?send='.$send));
    }

    public function saveeditedsquotation()
    {

        $this->quotation->saveeditedsquotation();
        $id = $this->input->post('id');

        $this->session->set_flashdata('success_msg', 'Single brand quotation prepared.');
        redirect(base_url('admin/printsquotation/' . $id));
    }

    public function printsquotation($id)
    {
        $data['id'] = $id;
        $data['data'] = $this->quotation->getbyid($id); 
        if($data['data']==false)
        redirect(base_url('admin/quotations'));

        // print_r($data['data']);
        // exit;
        $data['firm'] = $this->firm->getbyid($data['data']->firmid);
        $data['producers'] = $this->brand->producers();
        $data['brands'] = $this->brand->lists();
        $data['brandproducts'] = $this->brand->brandproducts();
        $data['result'] = $this->quotation->getdetails($id);        
        $data['quotationbrandprices'] = $this->quotation->quotationbrandprices($id);

        // print_r($data['result'] );
        // exit;
        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/printsquotation',$data);
        $this->load->view('admin/layout/footer');
    }
    public function printproforma($id)
    {
        $data['id'] = $id;
        $data['data'] = $this->quotation->getbyid($id); 
        if($data['data']==false)
        redirect(base_url('admin/quotations'));

        // print_r($data['data']);
        // exit;
        $data['firm'] = $this->firm->getbyid($data['data']->firmid);
        $data['producers'] = $this->brand->producers();
        $data['brands'] = $this->brand->lists();
        $data['brandproducts'] = $this->brand->brandproducts();
        $data['result'] = $this->quotation->getdetails($id);        
        $data['quotationbrandprices'] = $this->quotation->quotationbrandprices($id);

        // print_r($data['result'] );
        // exit;
        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/printproforma',$data);
        $this->load->view('admin/layout/footer');
    }


    public function printdeliverychallan($id)
    {
        $data['id'] = $id;
        $data['data'] = $this->quotation->getbyid($id);
        $data['producers'] = $this->brand->producers();
        $data['brands'] = $this->brand->lists();
        $data['brandproducts'] = $this->brand->brandproducts();
        $data['result'] = $this->quotation->getdetails($id);
        $data['quotationbrandprices'] = $this->quotation->quotationbrandprices($id);
        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/printdeliverychallan',$data);
        $this->load->view('admin/layout/footer');
    }

   
    //Quotation request

    

    public function editEstimate($id)
    {
        $data['id']= $id;
        $data['productlist'] = $this->product->lists();
        if($id != 0){
            $data['data'] = $this->quotation->getbyid($id);                
            $data['results'] = $this->quotation->getdetails($id);
        }
        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/quotationrequests',$data);
        $this->load->view('admin/layout/footer');
    }

    public function dispatches($id)
    {
        $data['id'] = $id;
        $data['data'] = $this->order->getbyid($id);
        $data['firm'] = $this->firm->getbyid($data['data']->firmid);
        $data['result'] = $this->dispatch->getdetails($id);
        // print_r(sizeof($data['result']));
        // exit;
        $this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/dispatches');
        $this->load->view('admin/layout/footer');
    }
    public function dispatch($id)
    {
        date_default_timezone_set('Asia/Kolkata');
        $data['orderid'] = $id;
        $data['productlist'] = $this->product->lists();
        $data['productvarietylist'] = $this->productweight->lists();
        $query = "SELECT BP.*, B.name, B.baserate FROM brands AS B, brandproducts AS BP WHERE B.id = BP.bid ORDER BY B.srno";
        $data['brands'] = $this->dbmodel->getdata($query);
        $data['data'] = $this->order->getbyid($id);
        // print_r($data['data']);
        // exit;
        $data['firm'] = $this->firm->getbyid($data['data']->firmid);
        $data['result'] = $this->order->getdetails($id);
        $this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/dispatch');
        $this->load->view('admin/layout/footer');
    }
    public function savedispatch()
    {
        $this->dispatch->save();
        $oid = $this->input->post('oid');
        redirect(base_url('admin/dispatches/' . $oid));
    }

    public function printdispatch($did)
    {
        $data['did'] = $did;
        $data['dispatch'] = $this->dispatch->getbyid($did);
        $data['data'] = $this->order->getbyid($data['dispatch']->oid);
        $data['firm'] = $this->firm->getbyid($data['data']->firmid);
         $data['result'] = $this->dispatch->getDispatchdetails($did);
        //$data['result'] = $this->order->getdetails($data['dispatch']->oid);
       
        
        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/printdispatch',$data);
        $this->load->view('admin/layout/footer');
    }
    public function printpendingdispatch($id)
    {
        $data['orderid'] = $id;
        $data['productlist'] = $this->product->lists();
        $data['productvarietylist'] = $this->productweight->lists();
        $query = "SELECT BP.*, B.name, B.baserate FROM brands AS B, brandproducts AS BP WHERE B.id = BP.bid ORDER BY B.srno";
        $data['brands'] = $this->dbmodel->getdata($query);
        $data['data'] = $this->order->getbyid($id);
        $data['firm'] = $this->firm->getbyid($data['data']->firmid);
        $data['result'] = $this->order->getdetails($id);
       
        
        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/printpendingdispatch',$data);
        $this->load->view('admin/layout/footer');
    }

    
    public function orders()
    {
       
        $data['result'] = $this->order->get_orders();
       if(isset($_GET["status"]))
        $data['status'] = $_GET["status"];
       else
        $data['status'] = "Open";
        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/orders', $data);
        $this->load->view('admin/layout/footer');
    }

    public function allorders()
    {
        $url = base_url("admin/allorders");
        $total_rows = $this->order->totalrecords();
        $per_page = 80;
        $uri_segment = 3;
        $config = $this->dbmodel->configurePagination($url, $total_rows, $per_page, $uri_segment);
		$this->pagination->initialize($config);
		$page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;
		$data["page"] = $page;
		$data["links"] = $this->pagination->create_links();
        $data["total_rows"] = $total_rows;
        $data['result'] = $this->order->get_data($per_page, $page);
       if(isset($_GET["status"]))
        $data['status'] = $_GET["status"];
       else
        $data['status'] = "All";
        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/allorders', $data);
        $this->load->view('admin/layout/footer');
    }

    public function order()
    {
        $data['id']= 0; 
        $data['states'] = $this->contact->states();
        $data['contacts'] = $this->contact->lists();    
        $data['productlist'] = $this->product->lists(); 
        $data['firms'] = $this->firm->lists();         
        $data['professions'] = $this->profession->lists();    
        $data['enquirysources'] = $this->enquirysource->lists(); 
        $this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/order', $data);
        $this->load->view('admin/layout/footer');
    }

    public function saveOrder()
    {

        $send = $this->input->post('send');
        $oid = $this->order->save();
        $contactid = $this->input->post('contactid');
        echo $contactid;
        // exit;
        if($contactid != 0)
        {
            $this->contact->updatecontact();           
        }
        redirect(base_url('admin/printorder/' . $oid.'?send='.$send));
    }

    public function printorder($id)
    {
        $data['id'] = $id;
        $data['data'] = $this->order->getbyid($id);
        $data['firm'] = $this->firm->getbyid($data['data']->firmid);
        $data['result'] = $this->order->getdetails($id);

               
        $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/printorder',$data);
        $this->load->view('admin/layout/footer');
    }

    public function editorder($id)
    {
        $data['id'] = $id;
        $data['productlist'] = $this->product->lists();
        $data['productvarietylist'] = $this->productweight->lists();
        $query = "SELECT BP.*, B.name, B.baserate FROM brands AS B, brandproducts AS BP WHERE B.id = BP.bid ORDER BY B.srno";
        $data['brands'] = $this->dbmodel->getdata($query);
        $data['firms'] = $this->firm->lists();
        $data['data'] = $this->order->getbyid($id);
        $data['result'] = $this->order->getdetails($id);
        $data['states'] = $this->contact->states();
        $data['cities'] = $this->contact->cities($data['data']->state);
        $data['enquirysources'] = $this->enquirysource->lists(); 
        $this->load->view('admin/layout/header',$data); 
        $this->load->view('admin/layout/sidebar'); 
        $this->load->view('admin/editorder',$data);
        $this->load->view('admin/layout/footer');
    }

    public function deleteorder($id)
    {
        $result = $this->order->delete($id);
        $this->session->set_flashdata('delete_msg','Record deleted successfully');
        redirect(base_url('admin/orders'));
    }

    public function orderstatus($oid)
    {
        $status = $_GET["status"];
        $query = "UPDATE orders SET status = '".$status."' WHERE id = ".$oid."";
        $this->dbmodel->execute($query);
        redirect(base_url('admin/orders'));
    }

    
    function getvarieties(){
        $pid = $this->input->post('id',TRUE);
        
        $query = "SELECT * FROM productweights WHERE pid IN($pid) ";
        $query .= "ORDER BY sizeinmm";			
        $data = $this->db->query($query)->result();
        
		echo json_encode($data);
    }
    function getcities(){
        $state = $this->input->post('state',TRUE);
        
        $query = "SELECT S.name, C.city FROM states AS S, cities AS C  WHERE S.id = C.state_id AND  S.name = '$state' ";
    
        $data = $this->db->query($query)->result();
        
		echo json_encode($data);
    }

    function getQuotationReviews(){
        $id = $this->input->post('id',TRUE);
        
        $query = "SELECT * FROM quotationreviews WHERE qid =".$id." ORDER BY id DESC";
    
        $data = $this->db->query($query)->result();
        
		echo json_encode($data);
    }

    function getbrands(){
        $pwid = $this->input->post('id',TRUE);        
        $query = "SELECT B.*, BP.billingrate FROM brands AS B, brandproducts AS BP WHERE B.id = BP.bid AND BP.pwid = " .  $pwid . " ORDER BY B.srno";
        $data = $this->db->query($query)->result();        
		echo json_encode($data);
    }

    function getrates(){
        $pid = $this->input->post('productid');
        $bid = $this->input->post('brandid');
        
        $query = "SELECT BP.billingrate AS price FROM brands AS B, brandproducts AS BP WHERE B.id = BP.bid AND B.id = " . $bid . " AND BP.pwid = " . $pid;
        $data = $this->db->query($query)->result();
        if(sizeof($data) > 0)
        {
            $row = $data[0];
            echo $row->price;
        }
        else{
            echo "0";
        }
    }    
 
 public function preparedo($id)
 {
    $orderid = $this->order->preparedo($id);
    redirect(base_url('admin/editorder/' . $orderid));     
 }
 
 
  //Dquotation
 
 public function dquotations()
 {
    $url = base_url("admin/dquotations");
    $total_rows = $this->dquotation->totalrecords();
    $per_page = 50;
    $uri_segment = 3;
    $config = $this->dbmodel->configurePagination($url, $total_rows, $per_page, $uri_segment);
    $this->pagination->initialize($config);
    $page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;
    $data["page"] = $page;
    $data["links"] = $this->pagination->create_links();
    $data["total_rows"] = $total_rows;
    $data['result'] = $this->dquotation->get_data($per_page, $page);

    //$data['result'] = $this->dquotation->lists();
     $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data); 
     $this->load->view('admin/layout/sidebar'); 
     $this->load->view('admin/quotation/dquotations', $data);
     $this->load->view('admin/layout/footer');
 }

 public function dquotation()
 {
     $data['id']= 0; 
     $data['productlist'] = $this->product->lists();     
     $data['firms'] = $this->firm->lists();
     $this->load->view('admin/layout/header',$data); 
     $this->load->view('admin/layout/sidebar'); 
     $this->load->view('admin/quotation/dquotation', $data);
     $this->load->view('admin/layout/footer');
 }

 public function saveDquotation()
 {
     $oid = $this->dquotation->save();
    
     redirect(base_url('admin/printdquotation/' . $oid));
 }

 public function printdquotation($id)
 {
     $data['id'] = $id;
     $data['data'] = $this->dquotation->getbyid($id);
     $data['firm'] = $this->firm->getbyid($data['data']->firmid);
     $data['result'] = $this->dquotation->getdetails($id);
     $data['firms'] = $this->firm->lists(); 
		$this->load->view('admin/layout/header',$data); 
     $this->load->view('admin/layout/sidebar'); 
     $this->load->view('admin/quotation/printdquotation',$data);
     $this->load->view('admin/layout/footer');
 }

 public function editdquotation($id)
 {
     $data['id'] = $id;
     $data['productlist'] = $this->product->lists();
     $data['productvarietylist'] = $this->productweight->lists();
     $query = "SELECT BP.*, B.name, B.baserate FROM brands AS B, brandproducts AS BP WHERE B.id = BP.bid ORDER BY B.srno";
     $data['brands'] = $this->dbmodel->getdata($query);
     $data['firms'] = $this->firm->lists();
     $data['data'] = $this->dquotation->getbyid($id);
     $data['result'] = $this->dquotation->getdetails($id);
     
     $this->load->view('admin/layout/header',$data); 
     $this->load->view('admin/layout/sidebar'); 
     $this->load->view('admin/quotation/editdquotation',$data);
     $this->load->view('admin/layout/footer');
 }

//  public function preparedo($id)
//  {
    
//     $this->order->preparedo($id);
//     redirect(base_url('admin/orders'));
     
//  }

 public function deletedquotation($id)
 {
     $result = $this->dquotation->delete($id);
     $this->session->set_flashdata('delete_msg','Record deleted successfully');
     redirect(base_url('admin/dquotations'));
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




