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
class Complaints extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
		//$this->output->enable_profiler(TRUE);
         $this->load->model('Bookings_model', 'Bookings'); 
		 $this->load->model('Complaints_model', 'Complaints'); 
		 
    }

	
	public function index()
    {
        $this->rbac->check_module_access();  
		$this->rbac->check_sub_button_access('complaints','list_complaints', FALSE, array('add','edit','delete'));   
		$data['complaints'] = $this->Complaints->getcomplaintslist();  
        $this->header($title = 'Complaints List');
        $this->load->view('complaints/list_complaints', $data);
        $this->footer();
        
    }
	
	
	 // List Customers
    public function list_complaints()
    {
        $this->rbac->check_module_access();  
		$this->rbac->check_sub_button_access('complaints','list_complaints', FALSE, array('add','edit','delete'));   
		$this->rbac->check_sub_button_access('complaints', 'add_complaints', FALSE, array('add'), array('add'=>'<a href="'.base_url().'complaints/add_complaints" class="add_record btn btn-info"> Add New Complaint <i class="fa fa-plus"></i></a>')); 
		$data['complaints'] = $this->Complaints->getcomplaintslist();  
        $this->header($title = 'Complaints List');
        $this->load->view('complaints/list_complaints', $data);
        $this->footer();
    } 
	
	 // List Customers
    public function list_closed_complaints()
    {
        $this->rbac->check_module_access();  
		$this->rbac->check_sub_button_access('complaints','list_closed_complaints', FALSE, array('add','edit','delete'));   
		$data['complaints'] = $this->Complaints->getcomplaintslist();  
        $this->header($title = 'Closed Complaints List');
        $this->load->view('complaints/list_closed_complaints', $data);
        $this->footer();
    } 
	
	
	public function get_complaints(){
		 header('Content-Type: application/json'); 
        echo $this->Complaints->get_complaints();
	}
	
	public function get_closed_complaints(){
		 header('Content-Type: application/json'); 
        echo $this->Complaints->get_closed_complaints();
	}
	
	public function complaints_details()
    {
		$complaints_id = $this->uri->segment(3);
		$this->rbac->check_module_access();  
		$this->rbac->check_sub_button_access('complaints','complaints_details', FALSE, array('add','edit','delete'));    
		$complaints_data = $this->Complaints->getcomplaint($complaints_id);
		$booking_data = $this->Bookings->getbooking($complaints_data['complaints']->booking_id);
		$data['booking'] = $booking_data['booking']; 
		$data['booking_payments'] = $booking_data['booking_payments']; 
		$data['complaints'] = $complaints_data['complaints'];
		$data['complaints_lifecycle'] = $complaints_data['complaints_lifecycle']; 
		$data['complaints_track'] = $complaints_data['complaints_track'];
        $this->header();
        $this->load->view('complaints/complaints_details', $data);
        $this->footer(); 
	}
	
	 
    public function add_complaints()
    { 
		 
		$this->rbac->check_sub_module_access(); 
		$this->rbac->check_sub_button_access('complaints','add_complaints', FALSE, array('add'));  
		$booking_id = $this->input->post('booking_id');
		$mobile = $this->input->post('mobile');
        if(!empty($booking_id)){ 
		$bookingdata = $this->Bookings->getbooking($booking_id);  
		$data['booking_id'] = $booking_id;   
		$data['booking'] = $bookingdata['booking']; 
		$data['booking_service'] = $bookingdata['booking_service'];
		$data['booking_payments'] = $bookingdata['booking_payments'];	 
		$data['booking_feedback'] = $bookingdata['booking_feedback'];	 
		$data['mobile'] = $data['booking']->customer_mobile;   		
		}elseif(!empty($mobile)){ 
		$bookingdata = $this->Common->get_booking_by_key('customer_mobile', $mobile);	 
			if(!empty($bookingdata)){ 	
			$data['booking_id'] = $booking_id;   
			$data['booking'] = $bookingdata['booking'];   
			$data['mobile'] = $mobile;
			}else{
			$data['booking_id'] = '';
			$data['booking'] = '';
			$data['mobile'] = '';    
			}
		}else{ 
		$data['booking_id'] = '';
		$data['booking'] = '';
		$data['mobile'] = '';   		
		}
		$this->header($title = 'Add Complaints'); 
        $this->load->view('complaints/add_complaints',$data);
        $this->footer();

    }
	
	
	
    	public function add_new_complaint($booking_id=NULL,$complaint=NULL,$medium=NULL,$from_feedback=NULL){  
			
		extract($_POST);	
			
			 
		$result = $this->Complaints->add_new_complaint($booking_id,$complaint,$medium,$from_feedback);
		 
		  
			 
		   if($result){    
				if(!empty($from_feedback)){
				return true;	
				}else{
					$this->session->set_flashdata('success', 'New Complaint# '.$complaints_id.' Created Successfully..!');
					redirect(base_url() . 'complaints/list_complaints');
				}  
		   }else{  
			   if(!empty($from_feedback)){
				return false;	
				}else{
					$this->session->set_flashdata('warning', 'Error while created Complaint');
					redirect(base_url() . 'complaints/list_complaints');
				}
			   
			   
		   }
		}
	
	
	  public function edit_complaints(){
		 extract($_POST);
		$response = [];  
		$complaints_data = $this->Complaints->getcomplaint($complaints_id);
		$complaints = $complaints_data['complaints']; 
		$complaints_lifecycle = $complaints_data['complaints_lifecycle']; 
		 
		  
		$get_all_users  = get_all_users(array('is_admin'=>0));
		 if($get_all_users){ 
		foreach($get_all_users as $user){ 
		$response['employees'][] = array("id"=>$user->id, "text"=>$user->firstname); 
		} 
		 }else{
		$response['employees'] = NULL;	 
		 }
		if(!empty($complaints_lifecycle)){ 
					$response['status'] = $complaints_lifecycle->status;
					$response['details'] = $complaints_lifecycle->details;
					$response['assigned_to'] = $complaints_lifecycle->assigned_to;
					$response['booking_id'] = $complaints->booking_id;
					$response['revisit_booking_id'] = $complaints->revisit_booking_id;  
					if(!empty( $complaints_lifecycle->due_date)){
					$duedate = date('m/d/Y'); 	
					}else{
					$duedate = $complaints_lifecycle->due_date; 
					}
		}else{
					$response['status'] = 'Open';
					$response['details'] = '';
					$response['assigned_to'] = '';  
					$duedate = date('m/d/Y'); 
					$response['booking_id'] = $complaints->booking_id;
					$response['revisit_booking_id'] = ''; 	 
		}
		
		  
		  
			 $response['due_date'] = $duedate;  
		echo json_encode($response); 
		
	}


	
	public function update_complaints(){
		
		  extract($_POST);   
		   
		
		/////////////////////////////////////////////////// ADD BOOKING START  
         $complaints_data = $this->Complaints->update_complaints_data();   
		/////////////////////////////////////////////////// ADD BOOKING START END 
		
		/////////////////////////////////////////////////// ADD BOOKING DETAILS START
		$complaints_lifecycle = $this->Complaints->update_complaints_lifecycle_data(); 
		/////////////////////////////////////////////////// ADD BOOKING DETAILS END
		
		/////////////////////////////////////////////////// ADD BOOKING DETAILS START
		$complaints_track = $this->Complaints->add_complaints_track_data(); 
		/////////////////////////////////////////////////// ADD BOOKING DETAILS END
		
		if($status=='Close'){
			$bookingdata = $this->Bookings->getbooking($booking_id);  
			$booking = $bookingdata['booking'];  
		   $service_category_name = $booking->customer_name;
		 $sms_data = array( 'customer_name' => $booking->customer_name, 'complaints_id' => base64_encode($complaints_id), 'base_url' => base_url()); 
		 $send_sms = $this->sms->sms_template(array($booking->customer_mobile),'complaints-close',$sms_data);
		}
		 
		 
		
			     $this->session->set_flashdata('success', 'Complaint updated Successfully');
                 redirect(base_url() . 'complaints/list_complaints');
		
	}
	
	
	public function reopen(){
		
		$complaints_id = base64_decode($this->uri->segment(3)); 
		
		$response = [];
		$complaints_id = $complaints_id; 
		$details = 'Customer Reopened'; 
		$status = 'Re-Open'; 
		$assigned_to = ''; 
		$due_date = date('m/d/Y'); 
		
		  
			
			$data = array(
                
				'status' => $status,  
            );
		
		if($status=='Close'){
			$data = array( 
				'status' => $status, 
				'archived' => 1,  
            ); 
		}elseif($status=='Re-Open'){
			$data = array( 
				'status' => $status, 
				'archived' => 0,  
            ); 
		}else{
			$data = array( 
				'status' => $status,  
            );
		}
		 
		if(!empty($this->input->post("revisit_booking_id"))){
			$data['follow_booking_id'] = $this->input->post("revisit_booking_id");
		}
		
		
            $where = array('id' => $complaints_id);
            $this->Common->update_record('customer_complaints', $data, $where);
		
		 $complaintstatus  = $this->Common->single_row("customer_complaints_lifecycle",array("complaints_id"=>$complaints_id));
			  
		
			$data = array(
                'complaints_id' => $complaints_id, 
				'action' => $status,  
                'details' => $details, 
				'due_date' => date('Y-m-d', strtotime($due_date)),
				'status' => $status, 
				'assigned_to' => get_users(array('id'=>$assigned_to), 'firstname'),
				'created_by' => 'Customer',
				'created_on' => date('Y-m-d H:i:s'), 
            );
			
		
		if(!empty($complaintstatus->id)){ 
            $where = array('complaints_id' => $complaints_id);
            $this->Common->update_record('customer_complaints_lifecycle', $data, $where);
		}else{
			$this->Common->add_record('customer_complaints_lifecycle', $data);
		}
		
		
		
		$data = array(
                'complaints_id' => $complaints_id, 
				'action' => $status,  
                'details' => $details, 
				'due_date' => date('Y-m-d', strtotime($due_date)),
				'status' => $status, 
				'assigned_to' => get_users(array('id'=>$assigned_to), 'firstname'),
				'created_by' => 'Customer',
				'created_on' => date('Y-m-d H:i:s'), 
            );
			 
		if(!empty($this->input->post("revisit_booking_id"))){
			$data['follow_booking_id'] = $this->input->post("revisit_booking_id");
		}
		
			$this->Main_model->add_record('customer_complaints_track', $data);
		 
		 
			     
                 redirect('https://garageworks.in/complaint_reopened.php');
		
	}
	
	
	
}