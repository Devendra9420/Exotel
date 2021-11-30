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

class Feedback_model extends CI_Model
{
		 
	 

    function index()
    {

    }
	
	public function get_feedbacks($status=NULL){   
		$this->datatables->select('feedback_id,booking_id,feedback, feedback_date, referral_name_1,referral_mobile_1,referral_name_2,referral_mobile_2,referral_name_3,referral_mobile_3');
      	$this->datatables->from('feedback');   
      	$this->datatables->add_column('action', '<a href="'.base_url().'/feedbacks/feedback_details/$1" class="btn btn-icon btn-primary" data-feedback_id="$1"><i class="fas fa-eye"></i></a>','feedback_id'); 
		return $this->datatables->generate(); 
	
	}
	
	public function count_feedback($status=NULL, $col=NULL){
		 
		 return $this->Common->count_all_results('feedback');
		 
	}
	
    
	
    public function getfeedbacklist()
    { 
        return $this->Common->select("feedback", 'feedback_date ASC'); 
        return $query->result();
    }
	
	public function getfeedback($feedback_id)
    {  
		$data = array();
		$data['feedback'] = $this->Common->single_row('feedback', array('feedback_id' =>  $feedback_id)); 
		$booking_id = $data['feedback']->booking_id;
		$data['booking']  = $this->Common->single_row('bookings', array('booking_id' =>  $booking_id));  
        $data['booking_details'] =  $this->Common->select_wher('booking_details', array('booking_id' =>  $booking_id));
		$data['booking_estimate'] =  $this->Common->single_row('booking_estimate', array('booking_id' =>  $booking_id)); 
        $data['estimate_details'] =  $this->Common->select_wher('booking_estimate_details', array('booking_id' =>  $booking_id), 'id DESC');
		$data['jobcard'] =  $this->Common->single_row('jobcard', array('booking_id' =>  $booking_id)); 
		$data['jobcard_details'] =  $this->Common->select_wher('jobcard_details', array('booking_id' =>  $booking_id, 'status'=>'Active'));
		$data['jobcard_rejected_details'] =  $this->Common->select_wher('jobcard_details', array('booking_id' =>  $booking_id, 'status'=>'Inactive'));
		$data['booking_payments'] =  $this->Common->single_row('booking_payments', array('booking_id' =>  $booking_id));
		$data['booking_notes'] =  $this->Common->select_wher('booking_notes', array('booking_id' =>  $booking_id));
		$data['booking_track'] =  $this->Common->select_wher('booking_track', array('booking_id' =>  $booking_id));
		$data['booking_service'] =  $this->Common->single_row('booking_services', array('booking_id' =>  $booking_id));
		$data['booking_service_track'] =  $this->Common->select_wher('booking_service_track', array('booking_id' =>  $booking_id)); 
        return $data;
    }
	
	    
	
	
	
	//FILE END
}

?>