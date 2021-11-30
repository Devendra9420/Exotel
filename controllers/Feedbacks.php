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
class Feedbacks extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
         
		$this->load->model('Bookings_model', 'Bookings'); 
		$this->load->model('Feedback_model', 'Feedbacks'); 
		
		
		 
    }

	
	public function index()
    {
        $booking_id = base64_decode($this->uri->segment(3));
		$booking_id = null; 
     	if(isset($_REQUEST['id'])) $booking_id = base64_decode($_REQUEST['id']);
		$bookingdata = $this->Bookings->getbooking($booking_id);  
		$data['booking_id'] = $booking_id;   
		$data['booking']  = $bookingdata['booking'];  
		$data['payments'] =  $bookingdata['booking_payments'];
		$data['jobcard'] =  $bookingdata['jobcard'];  
		$data['jobcardDetails'] =  $bookingdata['jobcard_details'];  
		$data['booking_details'] =  $bookingdata['booking_details']; 
		$data['estimate_details'] =  $bookingdata['estimate_details'];   
        $this->load->view('feedbacks/feedback', $data);
        
    }
	
        
	public function savefeedbackdata(){
	
		$feedback_id = $this->input->post('feedback_id');
		
		$booking_id = $this->input->post('booking_id');
		
		 
		 $bookingdetailsaccept = '';
    	if(!empty($this->input->post('bookdetailsaccept')))
        $bookingdetailsaccept = $this->input->post('bookdetailsaccept');
	
		 
	$complaints_resolved = '';
    	if(!empty($this->input->post('complaints_resolved')))
        $complaints_resolved = $this->input->post('complaints_resolved');
	
		 
	 
	$feedback = '';
    	if(!empty($this->input->post('feedback')))
        $feedback = $this->input->post('feedback');
	 
	  
		$issue = '';
    	if(!empty($this->input->post('issue'))){ 
		$issueArray=$_POST['issue']; 
		$issue = implode(',' , $issueArray);	 
		}
         
	$test_ride = '';
    	if(!empty($this->input->post('testride')))
        $test_ride = $this->input->post('testride');
	
		 
	$tips = '';
    	if(!empty($this->input->post('tips')))
        $tips = $this->input->post('tips');
	
		 
	$ref_name_1 = '';
    	if(!empty($this->input->post('ref_name_1')))
        $ref_name_1 = $this->input->post('ref_name_1');
	
		 
	$ref_no_1 = '';
    	if(!empty($this->input->post('ref_no_1')))
        $ref_no_1 = $this->input->post('ref_no_1');
	
		 
	$ref_name_2 = '';
    	if(!empty($this->input->post('ref_name_2')))
        $ref_name_2 = $this->input->post('ref_name_2');
	
		 
	$ref_no_2 = '';
    	if(!empty($this->input->post('ref_no_2')))
        $ref_no_2 = $this->input->post('ref_no_2');
	
	
		 
	$ref_name_3 = '';
    	if(!empty($this->input->post('ref_name_3')))
         $ref_name_3 = $this->input->post('ref_name_3');
	
	
		 
	$ref_no_3 = '';
    	if(!empty($this->input->post('ref_no_3')))
         $ref_no_3 = $this->input->post('ref_no_3');
	
	
		 
	$workinformed = '';
    	if(!empty($this->input->post('workinformed')))
         $workinformed = $this->input->post('workinformed');
	
	
		  
	$billing_change = '';
    	if(!empty($this->input->post('billing_change')))
         $billing_change = $this->input->post('billing_change');
	
	
		 
	$doorstep_experience = '';
    	if(!empty($this->input->post('doorstep_experience')))
         $doorstep_experience = $this->input->post('doorstep_experience');
	
	
		 
	$google_reviews = '';
    	if(!empty($this->input->post('google_reviews')))
         $google_reviews = $this->input->post('google_reviews');
	
	
		$feedback_date = created_on();   
		if(!empty($booking_id)){ 
		if(!empty($feedback_id) && $feedback_id!=0){
			$update_info = array(
            'bookingdetailsaccept' => $bookingdetailsaccept,
            'complaints_resolved' => $complaints_resolved,
            'feedback' => $feedback,
			'what_went_wrong' => $issue,	 
        );
			
			
			
			if(!empty($test_ride)){
				$update_info['test_ride'] = $test_ride;
			}
			
			
			if(!empty($workinformed)){
				$update_info['workinformed'] = $workinformed;
			}
			
			
			if(!empty($billing_change)){
				$update_info['billing_change'] = $billing_change;
			}
			
			if(!empty($neat_outlet)){
				$update_info['neat_outlet'] = $neat_outlet;
			}
			
			
			
			if(!empty($doorstep_experience)){
				$update_info['doorstep_experience'] = $doorstep_experience;
			}
			
			
			if(!empty($tips)){
				$update_info['tips'] = $tips;
			}
			
			
			if(!empty($ref_name_1)){
				$update_info['referral_name_1'] = $ref_name_1;
			}
			if(!empty($ref_no_1)){
				$update_info['referral_mobile_1'] = $ref_no_1;
			}
			
			if(!empty($ref_name_2)){
				$update_info['referral_name_2'] = $ref_name_2;
			}
			if(!empty($ref_no_2)){
				$update_info['referral_mobile_2'] = $ref_no_2;
			}
			
			 if(!empty($ref_name_3)){
				$update_info['referral_name_3'] = $ref_name_3;
			}
			if(!empty($ref_no_3)){
				$update_info['referral_mobile_3'] = $ref_no_3;
			}
			
			if(!empty($google_reviews)){
				$update_info['add_to_google'] = $google_reviews;
			}
				
        $where = array('feedback_id' => $feedback_id); 
        $update = $this->Common->update_record('feedback', $update_info, $where);
			$response['feedback_id'] = $feedback_id;
			$response['recorded'] = 1;
			
			
			
		}else{
		
			$add_info = array(
            'booking_id' => $booking_id,
			'bookingdetailsaccept' => $bookingdetailsaccept,
            'complaints_resolved' => $complaints_resolved,
            'feedback' => $feedback,
			'what_went_wrong' => $issue,	
            'test_ride' => $test_ride,
            'tips' => $tips,
            'referral_name_1' => $ref_name_1,
            'referral_mobile_1' =>  $ref_no_1,
            'referral_name_2' => $ref_name_2,
            'referral_mobile_2' =>  $ref_no_2,
            'referral_name_3' => $ref_name_3,
            'referral_mobile_3' =>  $ref_no_3,  
            'workinformed' =>  $workinformed,  
            'billing_change' =>  $billing_change,  
            'doorstep_experience' =>  $doorstep_experience,	
            'add_to_google' =>  $google_reviews,
            'feedback_date' =>  $feedback_date,	
        		);
         	$this->Common->add_record('feedback', $add_info);
			$response['feedback_id'] = $this->db->insert_id();
			$response['recorded'] = 1;
		}
		
			if($feedback<=2 && $feedback_id!=0){ 
					$this->load->model('Complaints_model'); 
				 	$issues = $this->input->post('issue');
					$issueArray=$_POST['issue']; 
					$issue = implode(',' , $issueArray);	 
					 
			
					$newcomplaint = $this->Complaints_model->add_new_complaint($booking_id,$issue,'Feedback',$from_feedback); 
			}
			
		}else{
			$response['feedback_id'] = 0;
			$response['recorded'] = 0;
		}
	
	echo json_encode($response);
}
	
	
public function thank()
{
    $this->load->view('feedbacks/thank_you');
}	
	
	
	  // List Customers
    public function list_feedback()
    {
        $this->rbac->check_module_access();  
		$this->rbac->check_sub_button_access('feedback','list_feedback', FALSE, array('add','edit','delete'));    
        $data['feedback'] = $this->Feedbacks->getfeedbacklist();  
        $this->header($title = 'Feedback List');
        $this->load->view('feedbacks/list_feedback', $data);
        $this->footer();
    }
	
	
	 // List Customers
    public function list_referral()
    {
        $this->rbac->check_module_access();  
		$this->rbac->check_sub_button_access('feedback','list_referral', FALSE, array('add','edit','delete'));    
        $data['feedback'] = $this->Feedbacks->getfeedbacklist();  
        $this->header($title = 'Referral List');
        $this->load->view('feedback/list_referral', $data);
        $this->footer();
    }
	
	
	public function get_feedback(){
		 header('Content-Type: application/json'); 
        echo $this->Feedbacks->get_feedbacks();
	}
	
	public function feedback_details()
    {
		$feedback_id = $this->uri->segment(3);
		$this->rbac->check_module_access();  
		$this->rbac->check_sub_button_access('feedback','feedback_details', FALSE, array('add','edit','delete'));   
		
		$booking_id = $this->Common->single_row('feedback', array('feedback_id' =>  $feedback_id), 'booking_id'); 
		$booking_data = $this->Bookings->getbooking($booking_id);
		
		
		$feedback_data = $this->Feedbacks->getfeedback($feedback_id);
		$data['feedback'] = $feedback_data['feedback'];
		$data['booking'] = $booking_data['booking'];
		$data['booking_payments'] = $booking_data['booking_payments'];
        $this->header();
        $this->load->view('feedbacks/feedback_details', $data);
        $this->footer();


	}


}