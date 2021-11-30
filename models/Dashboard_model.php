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

class Dashboard_model extends CI_Model
{

    function index()
    {

    }

     
	public function count_complaints($type='total'){
		if($type=='total'){ 
		$complaints = $this->Common->count_all_results('customer_complaints'); 
		}elseif($type=='open'){ 
		$complaints = $this->Common->count_all_results('customer_complaints','status IN ("Re-visit", "Open")'); 
		}elseif($type=='closed'){ 
		$complaints = $this->Common->count_all_results('customer_complaints',array('archived'=>1)); 
		}elseif($type=='reopened'){
		$complaints = $this->Common->count_all_results('customer_complaints_lifecycle',array('status'=>'Re-Open')); 
		}
		return $complaints;
	}
	
		
	public function total_billing($type=NULL){
		if(!$type){ 
		$total_bill = $this->Common->sum_results('jobcard_details',array('item_type!='=>'Service Category', 'status'=>'Active'), 'amount');  
		}elseif($type='all'){  
		$total_bill = $this->Common->sum_results('jobcard_details',array('item_type!='=>'Service Category'), 'amount');  
		}
		return '&#8377; '.$total_bill.'/-';
	}
	
	public function booking_completion_ratio(){
		 
	 
			$start_date = date('Y-m-d', strtotime('first day of this month'));
		$end_date = date('Y-m-d', strtotime('last day of this month'));	
			
		$completed = $this->Common->count_all_results('bookings',array('status'=>'Completed','service_date >='=>$start_date, 'service_date <='=>$end_date));  
		   
		$received = $this->Common->count_all_results('bookings',array('service_date >='=>$start_date, 'service_date <='=>$end_date));  
		 
		return   round(($completed*100)/$received,2).'%';
	
	}
	
	public function avg_ratings(){
		 
		$rating_1 = $this->Common->count_all_results('feedback',array('feedback='=>1), 'feedback_id');
		$rating_2 = $this->Common->count_all_results('feedback',array('feedback='=>2), 'feedback_id');
		$rating_3 = $this->Common->count_all_results('feedback',array('feedback='=>3), 'feedback_id');
		$rating_4 = $this->Common->count_all_results('feedback',array('feedback='=>4), 'feedback_id');
		$rating_5 = $this->Common->count_all_results('feedback',array('feedback='=>5), 'feedback_id');
		
		$ratings = [
	1 => $rating_1,
    2 => $rating_2,
    3 => $rating_3,
    4 => $rating_4,
    5 => $rating_5
			];   
		 
		 
		$totalStars = 0;
$voters = array_sum($ratings);
foreach ($ratings as $stars => $votes)
{//This is the trick, get the number of starts in total, then
 //divide them equally over the total nr of voters to get the average
    $totalStars += $stars * $votes;
}
   $data['voters'] = $voters;
   $data['total_rating'] = $totalStars;
	if($totalStars>0 && $voters>0){ 	
   $data['total_rating'] =  $totalStars/$voters;
	return round($data['total_rating'],2);
	}else{
	return 0;	
	}
		
	}
	 
		
	public function no_pending_jobcards(){ 
		return $this->Common->count_all_results('bookings','stage IN ("Created", "Rescheduled") AND status!="Cancelled" AND jobcard_id=0');
	}
	
	public function get_today_bookings(){   
		$this->datatables->select('booking_id,customer_city,customer_mobile,time_slot,assigned_mechanic, locked, lock_status, status, stage, updated_on');
      	$this->datatables->from('bookings'); 
      	$this->datatables->where('status NOT IN ("Completed", "Cancelled", "Rescheduled")');
      	$this->datatables->where(array('service_date'=>created_on()));
      	$this->datatables->add_column('action', '<a id="lock_action" href="'.base_url().'/bookings/lock_unlock/$1" class="btn btn-icon btn-primary" data-booking_id="$1"><i class="fas fa-eye"></i></a>','booking_id');  
		$this->datatables->edit_column('booking_id', '<a href="'.base_url().'bookings/booking_details/$1" class="" data-booking_id="$1">$1</a>','booking_id'); 
		return $this->datatables->generate(); 
	
	}
	

}

?>