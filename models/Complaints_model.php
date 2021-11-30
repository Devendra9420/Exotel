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

class Complaints_model extends CI_Model
{
		 
	 

    function index()
    {

    }
	 
	public function get_complaints($status=NULL){   
		$this->datatables->select('id as complaints_id,mobile,booking_id,created_on,medium,complaints,status, comments');
      	$this->datatables->from('customer_complaints');
		$this->datatables->where('archived=0');   
      	$this->datatables->add_column('action', '<a href="javascript:updatecomplaints($1);" class="btn btn-icon btn-primary" data-complaints_id="$1"><i class="fas fa-edit"></i></a>','complaints_id');  
		return $this->datatables->generate();  
	}
	
	public function get_closed_complaints($status=NULL){   
		$this->datatables->select('id as complaints_id,mobile,booking_id,created_on,medium,complaints,status, comments');
      	$this->datatables->from('customer_complaints');
		$this->datatables->where('archived=1');   
      	$this->datatables->add_column('action', '<a href="javascript:updatecomplaints($1);" class="btn btn-icon btn-primary" data-complaints_id="$1"><i class="fas fa-edit"></i></a>','complaints_id');  
		return $this->datatables->generate();  
	}
	
	public function count_complaints($status=NULL, $col=NULL){
		 
		 return $this->Common->count_all_results('customer_complaints');
		 
	}
	 
	
    public function getcomplaintslist()
    { 
        return $this->Common->select("customer_complaints", 'created_on ASC'); 
        return $query->result();
    }
	
	public function getcomplaint($complaints_id)
    {  
		$data = array();
		$data['complaints'] = $this->Common->single_row('customer_complaints', array('id' =>  $complaints_id));    
		$data['complaints_lifecycle'] =  $this->Common->single_row('customer_complaints_lifecycle', array('complaints_id' =>  $complaints_id)); 
		$data['complaints_track'] =  $this->Common->select_wher('customer_complaints_track', array('complaints_id' =>  $complaints_id)); 
        return $data;
    }
	
	    
	 
	
	public function add_complaints_data(){
		
		extract($_POST);  
		$data = array( 
                'medium' => $medium,  
				'booking_id' => $booking_id,
                'complaints' => $complaints, 
				'mobile' => $mobile,  
				'comments' => $comments, 
				'status' => 'Open', 
				'created_by' => created_by(), 
				'created_on' => created_on(),
            );
             
            $response = $this->Common->add_record('customer_complaints', $data); 
			$complaints_id = $this->db->insert_id();
			 
		 
		
			if(!$complaints_id || $complaints_id<1){
				return false;
			}else{
				return $complaints_id;
			}
		
	}
	
	
	 
	
	public function add_complaints_lifecycle($complaints_id){
		extract($_POST);
	$complaintsstatus  = $this->Common->select_row("customer_complaints_lifecycle", array('complaints_id'=>$complaints_id));
				  
			
			$data = array(
                'complaints_id' => $leads_id, 
				'action' => $status,  
                'details' => $details, 
				'due_date' => $due_date,
				'status' => $status, 
				'assigned_to' => get_users(array('id'=>$assigned_to), 'firstname'),
				'created_by' => created_by(),
				'created_on' => created_on(), 
            );
		
		if(!empty($complaintsstatus->id)){ 
            $where = array('complaints_id' => $complaints_id);
        $response =    $this->Common->update_record('customer_complaints_lifecycle', $data, $where);
		}else{
		$response =	$this->Common->add_record('customer_complaints_lifecycle', $data);
		}
		
		if(!$response){
				return false;
			}else{
				return true;
			}
		
		
	}
	
	
	
	public function update_complaints_data(){
		extract($_POST);
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
		if(!empty($revisit_booking_id)){
			$data['revisit_booking_id'] = $revisit_booking_id;
		}
		
		$where = array('id' => $complaints_id);
        $response=$this->Common->update_record('customer_complaints', $data, $where);
		
		if(!$response){
				return false;
			}else{
				return true;
			}
		
		
	}
	
	
	public function update_complaints_lifecycle_data(){
		extract($_POST);
		
		
			$lifecycle_exists  = $this->Common->single_row('customer_complaints_lifecycle',array('complaints_id'=>$complaints_id));
			  
		if(empty($due_date)) $due_date='';
		if(empty($assigned_to)) $assigned_to='';
			$data = array(
                'complaints_id' => $complaints_id, 
				'action' => $status,  
                'details' => $details, 
				'due_date' => $due_date,
				'status' => $status, 
				'assigned_to' => get_users(array('id'=>$assigned_to), 'firstname'),
				'created_by' => created_by(),
				'created_on' => created_on(), 
            );
			
		
		if(!empty($lifecycle_exists->id)){ 
            $where = array('complaints_id' => $complaints_id);
            $response=$this->Common->update_record('customer_complaints_lifecycle', $data, $where);
		}else{
			$response=$this->Common->add_record('customer_complaints_lifecycle', $data);
		}
		
		
		if(!$response){
				return false;
			}else{
				return true;
			}
		
		
	}
	
	
	
	public function add_complaints_track_data(){
		extract($_POST);
		 
		if(empty($due_date)) $due_date='';
		if(empty($assigned_to)) $assigned_to='';
		
		$data = array(
                'complaints_id' => $complaints_id, 
				'action' => $status,  
                'details' => $details, 
				'due_date' => $due_date,
				'status' => $status, 
				'assigned_to' => $assigned_to,
				'created_by' => created_by(),
				'created_on' => created_on(), 
            );
			 
		if(!empty($revisit_booking_id)){
			$data['revisit_booking_id'] = $revisit_booking_id;
		}
		
			$response=$this->Common->add_record('customer_complaints_track', $data);
		
		if(!$response){
				return false;
			}else{
				return true;
			}
		
		
	}
	
		public function add_new_complaint($booking_id=NULL,$complaint=NULL,$medium=NULL,$from_feedback=NULL){  
		extract($_POST);	
		if(!$medium)
		$medium = 'Feedback';  
		$bookingdata = $this->Bookings->getbooking($booking_id);  
		$data['booking_id'] = $booking_id;   
		$booking  = $bookingdata['booking'];  
		$data['payments'] =  $bookingdata['booking_payments'];
		$data['jobcard'] =  $bookingdata['jobcard'];     
		$mobile = $booking->customer_mobile;   
		if(!$comments)
		$comments = '';	
			 $complaintExists  = $this->Common->single_row('customer_complaints', array('archived'=>0, 'booking_id'=>$booking_id)); 
		   if(empty($complaintExists->id) || $complaintExists->id<1){ 
				$complaint_data = array( 
					'medium' => $medium,  
					'mobile' => $mobile,
					'booking_id' => $booking_id,      
					'complaints' => $complaint,  
					'comments' => $comments, 
					'status' => 'Open', 
					'created_by' => 0, 
					'created_on' => date('Y-m-d H:i:s')
				); 
			  $response = $this->Common->add_record('customer_complaints', $complaint_data);
		 	  $complaints_id = $this->db->insert_id();  
			$complaint_data = array( 
				'complaints_id' => $complaints_id, 
				'action' => 'Open',  
                'details' => 'Complaint Created', 
				'due_date' => '',
				'status' => 'Open', 
				'assigned_to' => '',
				'created_by' => 0,
				'created_on' => date('Y-m-d H:i:s'), 
            ); 
			  $response = $this->Common->add_record('customer_complaints_lifecycle', $complaint_data);
		
			   
			return true;	 
			 
			   
		   }else{ 
		 		
			  return false;	
			    
		   }
	}
	
	//FILE END
}

?>