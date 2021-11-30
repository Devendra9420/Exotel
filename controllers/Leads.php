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
class Leads extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
         
		$this->load->model('Bookings_model', 'Bookings'); 
		$this->load->model('Leads_model', 'Leads'); 
		
		
		 
    }

	
	public function index()
    {
        $leads_id = $this->uri->segment(3);
		$leads_id = null; 
     	if(isset($_GET['leads_id']))
        $leads_id = $_GET['leads_id'];
		$leadsdata = $this->Leads->getleads($leads_id);  
		$data['leads_id'] = $leads_id;   
		$data['leads']  = $bookingdata['leads'];  
		$data['leads_estimate'] =  $bookingdata['leads_estimate'];
		$data['leads_lifecycle'] =  $bookingdata['leads_lifecycle'];   
        $this->load->view('leads/leads', $data);
        
    } 
	
	  // List Customers
    public function list_leads()
    {
        $this->rbac->check_module_access();  
		$this->rbac->check_sub_button_access('leads','list_leads', FALSE, array('add','edit','delete'));
		$this->rbac->check_sub_button_access('leads', 'add_leads', FALSE, array('add'), array('add'=>'<a href="'.base_url().'leads/add_leads" class="add_record btn btn-info"> Add New Lead <i class="fa fa-plus"></i></a>')); 
        $this->Leads->auto_archive();
		$data['leads'] = $this->Leads->getleadslist();  
        $this->header($title = 'Leads List');
        $this->load->view('leads/list_leads', $data);
        $this->footer();
    } 
	
	public function get_leads(){
		 header('Content-Type: application/json'); 
        echo $this->Leads->get_leads();
	}
	
	public function leads_details()
    {
		$leads_id = $this->uri->segment(3);
		$this->rbac->check_module_access();  
		$this->rbac->check_sub_button_access('leads','leads_details', FALSE, array('add','edit','delete'));    
		$leads_data = $this->Leads->getlead($leads_id);
		$data['leads'] = $leads_data['leads']; 
		$data['leads_estimate'] = $leads_data['leads_estimate']; 
		$data['leads_lifecycle'] = $leads_data['leads_lifecycle']; 
        $this->header();
        $this->load->view('leads/leads_details', $data);
        $this->footer(); 
	}

	// Add Customer Form
    public function add_leads()
    { 
		$this->rbac->check_module_access(); 
		$this->rbac->check_sub_button_access('leads','add_leads', FALSE, array('add'));   
        $leadconvert = $this->uri->segment(3);
		$leads_id = $this->uri->segment(4);
		
		if(!empty($leadconvert) && $leadconvert=='lead_convert'){ 	 
			 
			$leads_data = $this->Leads->getlead($leads_id);
			$data['lead_convert'] = 1;	
			$data['leads'] = $leads_data['leads']; 
			$data['leads_id'] = $data['leads']->id;	
			$data['leads_estimate'] = $leads_data['leads_estimate']; 
			$data['leads_lifecycle'] = $leads_data['leads_lifecycle']; 
		}else{
		$data['lead_convert'] = 0;	
		$data['leads_id'] = '';		
		$data['leads'] = FALSE; 
		$data['leads_estimate'] = FALSE; 
		$data['leads_lifecycle'] = FALSE;	
		}
		$this->header($title = 'Add Leads'); 
        $this->load->view('leads/add_leads',$data);
        $this->footer();

    }
	
	// Insert new Customer to Databse
    public function insert_leads()
    {
          
		/////////////////////////////////////////////////// ADD BOOKING START  
         $leads_id = $this->Leads->add_leads_data();   
		/////////////////////////////////////////////////// ADD BOOKING START END 
		 
		
		/////////////////////////////////////////////////// ADD BOOKING ESTIMATE DETAILS START
		 $leads_estimate_details  = $this->Leads->add_leads_estimate_details_data($leads_id);  
		/////////////////////////////////////////////////// ADD BOOKING ESTIMATE DETAILS END
		
		
		/////////////////////////////////////////////////// ADD BOOKING ESTIMATE DETAILS START
		 $leads_lifecycle = $this->Leads->add_leads_lifecycle($leads_id);  
		/////////////////////////////////////////////////// ADD BOOKING ESTIMATE DETAILS END
		 
		
         
            $this->session->set_flashdata('success', 'New Lead# '.$leads_id.' Created Successfully..!');
            redirect(base_url() . 'leads/leads_details/'.$leads_id);
         
		
		
    }
	
	
	
	public function edit_lead(){
		 extract($_POST);
		$response = [];  
		$leads_data = $this->Leads->getlead($leads_id);
		$leads = $leads_data['leads']; 
		$leads_lifecycle = $leads_data['leads_lifecycle']; 
		 
		  
		$get_all_users  = get_all_users(array('is_admin'=>0));
		 if($get_all_users){ 
		foreach($get_all_users as $user){ 
		$response['employees'][] = array("id"=>$user->id, "text"=>$user->firstname); 
		} 
		 }else{
		$response['employees'] = NULL;	 
		 }
		if(!empty($leads_lifecycle)){ 
					$response['status'] = $leads_lifecycle->status;
					$response['details'] = $leads_lifecycle->details;
					$response['assigned_to'] = $leads_lifecycle->assigned_to; 
					if(!empty( $leads_lifecycle->due_date)){
					$duedate = date('m/d/Y'); 	
					}else{
					$duedate = $leads_lifecycle->due_date; 
					}
		}else{
					$response['status'] = 'Open';
					$response['details'] = '';
					$response['assigned_to'] = '';  
					$duedate = date('m/d/Y'); 	 
		}
		
			 $response['due_date'] = $duedate;  
		echo json_encode($response); 
		
	}
	
	public function update_lead(){
		 extract($_POST);  
			
			$data = array( 
				'status' => $status,  
            ); 
		if($status=='Wrong No' || $status=='Not interested - Service Done' || $status=='Not Interested - Too Expensive' || $status=='Duplicate/Repeat Lead' || $status=='Non Servicable'){
			$data = array( 
				'status' => $status, 
				'archived' => 1,  
            ); 
		}else{
			$data = array( 
				'status' => $status,  
            );
		}  
            $where = array('id' => $leads_id);
            $this->Common->update_record('leads', $data, $where);
		$leads_data = $this->Leads->getlead($leads_id);
		$leads = $leads_data['leads']; 
		$leads_lifecycle = $leads_data['leads_lifecycle'];  
			$data = array(
                'leads_id' => $leads_id, 
				'action' => $status,  
                'details' => $details, 
				'due_date' => $due_date,
				'status' => $status, 
				'assigned_to' => $assigned_to,
				'created_by' => created_by(),
				'created_on' => created_on(), 
            ); 
		if(!empty($leads_lifecycle->id)){ 
            $where = array('leads_id' => $leads_id);
            $this->Common->update_record('leads_lifecycle', $data, $where);
		}else{
			$this->Common->add_record('leads_lifecycle', $data);
		} 
			     $this->session->set_flashdata('success', 'Lead updated Successfully');
                 redirect(base_url() . 'leads/list_leads'); 
	}
	
	
	public function archive_lead(){ 
		$leads_id =   $this->uri->segment(3); 
			$data = array( 
				'archived' => 1,  
            );
            $where = array('id' => $leads_id);
            $this->Common->update_record('leads', $data, $where);
		 
			     $this->session->set_flashdata('success', 'Lead archived Successfully');
                 redirect(base_url() . 'leads/list_leads'); 
	}
	
	
	
	
	

}