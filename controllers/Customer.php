<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 *	@author : Chintan Desai
 *  @support: chintz2806@gmail.com
 *	date	: 01 November, 2019
 *	GarageWorks Inventory Management System
 * website: garageworks.in
 *  version: 1.0
 */
class Customer extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        auth_check(); // check login auth
		$this->rbac->check_module_access(); 
		$this->load->model('Customer_model', 'customer_model'); 
		 
    }


    // Add Customer Form
    public function add_customer()
    {
		$this->rbac->check_sub_module_access(); 
		$this->rbac->check_sub_button_access('customer','add', FALSE, array('add'));  
        $this->header($title = 'Add Customer'); 
        $this->load->view('customer/add_customer');
        $this->footer();

    }
    // List Customers
    public function list_customers()
    {
        $this->rbac->check_module_access();  
		$this->rbac->check_sub_button_access('customer','list_customers', FALSE, array('add','edit','delete'));  
		$this->rbac->check_sub_button_access('customer', 'add_customer', FALSE, 'add', array('add'=>'<a href="'.base_url().'customer/add_customer" class="add_record btn btn-info"> Add New <i class="fa fa-plus"></i></a>')); 
        $data['customers'] = $this->customer_model->getcustomerlist();  
        $this->header($title = 'Customers List');
        $this->load->view('customer/list_customers', $data);
        $this->footer();
    }
	
	public function get_customers(){
		 header('Content-Type: application/json'); 
        echo $this->customer_model->get_customers();
	}
	
    // Customer Details
    public function customer_details()
    {
        $this->rbac->check_module_access();  
		//$this->rbac->check_sub_button_permission();  
		$customer_id = $this->uri->segment(3);
		$customerdata = $this->customer_model->getcustomer($customer_id);  
		$data['customer_id'] = $customer_id;   
		$data['customer']  = $customerdata['customer']; 
		$data['customer_addresses'] =  $customerdata['customer_addresses'];  ;
		$data['customer_vehicles'] =  $customerdata['customer_vehicles'];  ;
		$data['customer_bookings'] =  $customerdata['customer_bookings'];  ;
        $this->header($title = 'Customer Detail'); 
        $this->load->view('customer/customer_details', $data); 
        $this->footer();
    }
	
    // Insert new Customer to Databse
    public function insert_customer()
    {
         
		
		$cust_info = array(
            'name' => $this->input->post('customer_name'),
            'mobile' => $this->input->post('mobile'),
            'alternate_no' => $this->input->post('alternate_no'),
            'email' => $this->input->post('email'),
            'channel' => $this->input->post('channel'),
        );
         
        $customer_id = $this->Common->add_record('customer', $cust_info);
		
		$address = $this->input->post('address');
		$area = $this->input->post('area');
		$city = $this->input->post('city');
		$pincode = $this->input->post('pincode');
		$google_map = $this->input->post('google_map');
		$latitude = $this->input->post('latitude');
		$longitude = $this->input->post('longitude');
		$address_type = $this->input->post('address_type'); 
		
			$cust_info = array(
			'customer_id' => $customer_id,	
            'type' => $address_type,
            'address' => $address,
            'area' => $area,
            'city' => $city,
            'pincode' => $pincode,
            'google_map' => $google_map,
            'latitude' => $latitude,
            'longitude' => $longitude,
        	);
		
        $response = $this->Common->add_record('customer_address', $cust_info);
		 
          
        if ($response) {
            $this->session->set_flashdata('success', 'New Customer added Successfully..!');
            redirect(base_url() . 'customer/list_customers');
        }
    }
	
	 public function edit_customer() 
    {
		 
		$customer_id = $this->uri->segment(3);   
		$this->rbac->check_module_access();  
		$this->rbac->check_sub_button_access('customer','edit', FALSE, array('edit')); 
		$customerdata = $this->customer_model->getcustomer($customer_id);   
        $data['customer'] = $customerdata['customer'];  
		$data['customer_addresses'] = $customerdata['customer_addresses'];   
        $this->header();
        $this->load->view('customer/edit_customer',$data);
        $this->footer();

    }
	
    // Update Customer Details
    public function update_customer()
    {
        $custid = $this->input->post('customer_id');

        $cust_info = array(
            'name' => $this->input->post('customer_name'),
            'mobile' => $this->input->post('mobile'),
            'alternate_no' => $this->input->post('alternate_no'),
            'email' => $this->input->post('email'),
            'channel' => $this->input->post('channel'),
        );
         $where = array('customer_id' => $custid); 
        $response = $this->Common->update_record('customer', $cust_info, $where);
		
				$customer_open_bookings = $this->Common->select_wher('bookings', 'customer_id='.$custid.' AND status NOT IN ("Completed","Cancelled")');
				if($customer_open_bookings)
				foreach($customer_open_bookings as $customer_booking){
					$cust_book_info = array(
					'customer_name' => $this->input->post('customer_name'),
					'customer_mobile' => $this->input->post('mobile'),
					'customer_alternate_no' => $this->input->post('alternate_no'),
					'customer_email' => $this->input->post('email'),
					'customer_channel' => $this->input->post('channel'),
					);
					$where = array('booking_id' => $customer_booking->booking_id); 
					$response = $this->Common->update_record('bookings', $cust_book_info, $where);
				}
		
		
		
		$address = $this->input->post('address');
		$area = $this->input->post('area');
		$city = $this->input->post('city');
		$pincode = $this->input->post('pincode');
		$google_map = $this->input->post('google_map');
		$latitude = $this->input->post('latitude');
		$longitude = $this->input->post('longitude');
		$address_type = $this->input->post('address_type');
		$address_id  = $this->input->post('address_id');
		$total_address = count($address);
		for($i=0; $i < $total_address; $i++)
        {
			$cust_info = array(
            'type' => $address_type[$i],
            'address' => $address[$i],
            'area' => $area[$i],
            'city' => $city[$i],
            'pincode' => $pincode[$i],
            'google_map' => $google_map[$i],
            'latitude' => $latitude[$i],
            'longitude' => $longitude[$i],
        	);
         $where = array('customer_id' => $custid, 'address_id' => $address_id[$i]); 
        $response = $this->Common->update_record('customer_address', $cust_info, $where);
		
				$customer_open_bookings = $this->Common->select_wher('bookings', 'customer_id='.$custid.' AND status NOT IN ("Completed","Cancelled") AND customer_address_type="'.$address_type[$i].'"');
				if($customer_open_bookings)
				foreach($customer_open_bookings as $customer_booking){
					$cust_book_info = array(
					'customer_address_type' => $address_type[$i],
					'customer_address' => $address[$i],
					'customer_area' => $area[$i],
					'customer_city' => $city[$i],
					'customer_pincode' => $pincode[$i],
					'customer_google_map' => $google_map[$i],
					'customer_lat' => $latitude[$i],
					'customer_long' => $longitude[$i],
					);
					$where = array('booking_id' => $customer_booking->booking_id); 
					$response = $this->Common->update_record('bookings', $cust_book_info, $where);
				}
			
		}
		
		
		
		
        if ($response) {
            $this->session->set_flashdata('success', 'Customer Updated Successfully..!');
             redirect(base_url() . 'customer/list_customers/');
        } else {
            $this->session->set_flashdata('warning', 'Nothing to Update!');
             redirect(base_url() . 'customer/list_customers/');


        }
    }
	
	public function add_address()
    {
         
		 
		$created_on = date('Y-m-d');
		
        $data = array(
            'type'=> $this->input->post("address_type"), 
			'customer_id' => $this->input->post("customer_id"), 
            'address' => $this->input->post("address"),
            'area' => $this->input->post("area"),
            'city' => $this->input->post("city"), 
            'pincode' => $data['pincode'],
			'google_map' => $this->input->post("google_map"),
            'longitude' => $this->input->post("longitude"),
            'latitude' => $this->input->post("latitude"),
            'created_on' => $created_on,
        );
        
        $response = $this->Common->add_record('customer_address', $data);
        if ($response) {
            $this->session->set_flashdata('success', 'Customer address added Successfully..!');
            redirect(base_url() . 'customer/edit_customer/'.$this->input->post("customer_id"));
        }
    }
	


}