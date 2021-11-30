<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class Mechanicapi extends API_Controller
{
    public function __construct() {
        parent::__construct();
		 //$this->output->enable_profiler(TRUE);
		 $this->load->model('Api_model');
		 $this->load->model('Bookings_model', 'Bookings');  
		$this->load->library('payments');
    }

   public function index()
    {
        header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([ 
            'methods' => ['POST'], // 'GET', 'OPTIONS' 
            /**
             * Number limit, type limit, time limit (last minute)
             */
            'limit' => [5000, 'ip', 'everyday'],             /**
             * type :: ['header', 'get', 'post']
             * key  :: ['table : Check Key in Database', 'key']
             */
            //'key' => ['POST', $this->key() ], // type, {key}|table (by default)
			//'key' => ['header'], // type, {key}|table (by default)
        ]); 
        // return data
        $this->api_return(
            [
                'status' => true,
                "result" => "Return API Response",
            ],
        200);
    }

    /**
     * Check API Key
     *
     * @return key|string
     */
    private function key()
    {
        // use database query for get valid key

        return 1450002;
    }


    public function sendotp(){
				
				 header("Access-Control-Allow-Origin: *");

				// API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5000, 'ip', 'everyday'],
					//'key' => 'table' // ['header'], // type, {key}|table (by default)
				]);
				 extract($_POST);  
				$user = get_service_providers(array('mobile'=>$mobile));
				if(!empty($user)){ 
				$payload = [
				'id' => $user->id,
				'mobile' => $user->mobile
        		];
				$this->load->library('Authorization_token');	
				$token = $this->authorization_token->generateToken($payload);  
				$user_id = $user->id;  
				$name = $user->name; 
				$send_otp = send_otp($mobile, $name, $token, '2', $user_id);
					
						if($send_otp){   
						// return data
						$otp_data = array(   
				"token" => $token, 
                "mobile" => $mobile
							);
							
						$this->api_return(
							[
								'status' => true,
								"result" => [ 
									'data' => $otp_data,
									'message' => 'OTP sent successfully on '.$mobile,
								],

							],
						200); 
						 }else{
							$otp_data = array(    
                			"mobile" => $mobile
							);
							$this->api_return(
							[
								'status' => false,
								"result" => [ 
									'data' => $otp_data,
									'message' => 'Mobile number not found in database',
								],

							],
						200);
						}
			 
				
				 
				}else{
					$otp_data = array(    
                "mobile" => $mobile
							);
					
					$this->api_return(
					[
						'status' => false,
						"result" => [ 
							'data' => $otp_data,
							'message' => 'Mobile number not found in database',
						],

					],
				200);
				}
	}
	
	public function verifyotp()
    {
		
					header("Access-Control-Allow-Origin: *");
        // API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5000, 'ip', 'everyday'],
					////'key' => ['header'], // type, {key}|table (by default)
				]);
				 extract($_POST);  
				 if(!empty($token))
				$user_verified = verify_otp($mobile, $otp, $token);  
				if(!empty($user_verified)){   
						// return data
						$this->api_return(
							[
								'status' => true,
								"result" => [
									'data' => $user_verified, 
									'office_support' => get_general_settings('office_support'),
									'message' => 'OTP verified successfully',
								],

							],
						200); 
						 }else{
							$otp_data = array(    
                			"mobile" => $mobile 
							);
							$this->api_return(
							[
								'status' => false,
								"result" => [ 
									'data' => $otp_data,
									'office_support' => get_general_settings('office_support'),
									'message' => 'OTP not valid',
								],

							],
						200);
						}
		  }
	
	 
	 
	public function get_bookings()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			////'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST); 
		  	
		$bookingdata = get_customer_bookings('assigned_mechanic="'.$mechanic_id.'" AND service_date >= "'.created_on().'" AND status NOT IN ("Cancelled", "Completed")');   
		 if(!empty($bookingdata)){  
		foreach($bookingdata as $data['booking']){ 
			 
				 
				 
				$active = $this->Api_model->user_active_bookings($mechanic_id, $data['booking']->booking_id);
				 
				$bookingdata_q = $this->Bookings->getbooking($data['booking']->booking_id);  
				$booking_service  = $bookingdata_q['booking_service']; 
				$booking_details  = $bookingdata_q['booking_details']; 
				
				$data['jobcard']=$bookingdata_q['jobcard'];
			 
				if(empty($response['jobcard'])){
				$jobcard_status = 'Not Created';
				$jobcard_stage  = 'Not Created'; 
				}else{
				$jobcard_status = $data['jobcard']->status;
				$jobcard_stage  = $data['jobcard']->stage; 	
				}
			 
			
			
				$action_1['show'] = 1;
				$action_1['icon'] = 'navigate.png';
				$action_1['label'] = 'Navigate';
				$action_1['type'] = 'map';
				$action_1['value'] = 'direction_gmap';
			
				$action_2['show'] = 1;
				$action_2['icon'] = 'jobcard.png';
				$action_2['label'] = 'Jobcard';
				$action_2['type'] = 'page';
				$action_2['value'] = 'show_jobcard';
			
				$action_3['show'] = 1;
				$action_3['icon'] = 'assigned_spares.png';
				$action_3['label'] = 'Assigned Spares';
				$action_3['type'] = 'page';
				$action_3['value'] = 'show_assigned_spares';
			
				
				$action_btns = $this->Api_model->get_action_buttons($data['booking']->booking_id);  
				 
				$action_4=$action_btns['action_4'];
				$action_5=$action_btns['action_5'];
				$action_6=$action_btns['action_6'];
				
				$break_complaints = explode('+',$data['booking']->complaints);
			 	$complaints = join(", ", $break_complaints); 
				
				$show_mobile = $action_btns['show_mobile'];
				$show_alternate_no = $action_btns['show_mobile'];
			
		$booking_data[] = array(  
				"booking_id" => $data['booking']->booking_id, 
                "customer_id" => $data['booking']->customer_id,
                "customer_name" => $data['booking']->customer_name,
                "customer_email" => $data['booking']->customer_email,
                "customer_mobile" => $data['booking']->customer_mobile,
                "show_mobile" => $show_mobile,
                "customer_alternate_no" => $data['booking']->customer_alternate_no,
				"show_alternate_no" => $show_alternate_no,
                "customer_address" => $data['booking']->customer_address,
                "customer_city" => $data['booking']->customer_city,
                "customer_area" => $data['booking']->customer_area,
                "customer_pincode" => $data['booking']->customer_pincode,
                "customer_google_map" => $data['booking']->customer_google_map,
                "customer_lat" => $data['booking']->customer_lat,
                "customer_long" => $data['booking']->customer_long,
                "customer_channel" => $data['booking']->customer_channel,
                "vehicle_id" => $data['booking']->vehicle_id,  
                "vehicle_make" => get_make($data['booking']->vehicle_make),  
                "vehicle_model" => get_model($data['booking']->vehicle_model),  
                "vehicle_regno" => $data['booking']->vehicle_regno,  
                "vehicle_yom" => $data['booking']->vehicle_yom,  
                "vehicle_km_reading" => $data['booking']->vehicle_km_reading,  
                "service_category" => $data['booking']->service_category_id,
                "service_category_name" => get_service_category($data['booking']->service_category_id),  
                "time_slot" => $data['booking']->time_slot,
                "service_date" => convert_date($data['booking']->service_date), 
                "assigned_mechanic" => $data['booking']->assigned_mechanic,
                "specific_complaints" => $complaints,  
                "status" => $data['booking']->status,    
                "stage" => $data['booking']->stage,    
				"service_status" => $booking_service->stage, 
				"jobcard_status" =>  $jobcard_status,
				"jobcard_stage"  =>  $jobcard_stage,
				"service_name" => get_service_category($data['booking']->service_category_id), 
				"booking_type" => $data['booking']->booking_type, 
				"estimated_amount" => $booking_details->estimated_amount, 
                "created_on" => convert_date($data['booking']->created_on), 
				"active" => $active,
				"lock" => $data['booking']->locked,
				'action_button_1' => $action_1,
				'action_button_2' => $action_2,
				'action_button_3' => $action_3,
				'action_button_4' => $action_4,
				'action_button_5' => $action_5,
				'action_button_6' => $action_6,
		);
		
		}
			 
			 
			 // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $booking_data, 
                ],
            ],
        200);
			 
		 }else{
			// return data
        $this->api_return(
            [
                'status' => false,
                "result" => [
                    'data' => NULL, 
                ],
            ],
        200);
		 }
		 
        
    }
	
	public function get_booking_details()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			////'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST); 
		  
		 if(!empty($booking_id)){  
		  
				$bookingdata = $this->Bookings->getbooking($booking_id);  
				$booking_service  = $bookingdata['booking_service']; 
				$booking_details  = $bookingdata['booking_details']; 
				$data['booking'] =  $bookingdata['booking']; 
			 	$active = $this->Api_model->user_active_bookings($mechanic_id, $booking_id);
			 	
			 	$data['jobcard']=$bookingdata['jobcard'];
			 
				if(empty($response['jobcard'])){
				$jobcard_status = 'Not Created';
				$jobcard_stage  = 'Not Created'; 
				}else{
				$jobcard_status = $data['jobcard']->status;
				$jobcard_stage  = $data['jobcard']->stage; 	
				}
			 
			 
				$action_1['show'] = 1;
				$action_1['icon'] = 'navigate.png';
				$action_1['label'] = 'Navigate';
				$action_1['type'] = 'map';
				$action_1['value'] = 'direction_gmap';
			
				$action_2['show'] = 1;
				$action_2['icon'] = 'jobcard.png';
				$action_2['label'] = 'Jobcard';
				$action_2['type'] = 'page';
				$action_2['value'] = 'show_jobcard';
			
				$action_3['show'] = 1;
				$action_3['icon'] = 'assigned_spares.png';
				$action_3['label'] = 'Assigned Spares';
				$action_3['type'] = 'page';
				$action_3['value'] = 'show_assigned_spares';
			
				
				$action_btns = $this->Api_model->get_action_buttons($booking_id);  
				 
				$action_4=$action_btns['action_4'];
				$action_5=$action_btns['action_5'];
				$action_6=$action_btns['action_6'];
				
			 	$break_complaints = explode('+',$data['booking']->complaints);
			 	$complaints = join(", ", $break_complaints); 
			 
			 	$show_mobile = $action_btns['show_mobile'];
				$show_alternate_no = $action_btns['show_mobile'];
			 
		$booking_data  = array(  
				"booking_id" => $booking_id, 
                "customer_id" => $data['booking']->customer_id,
                "customer_name" => $data['booking']->customer_name,
                "customer_email" => $data['booking']->customer_email,
                "customer_mobile" => $data['booking']->customer_mobile,
                "show_mobile" => $show_mobile,
                "customer_alternate_no" => $data['booking']->customer_alternate_no,
				"show_alternate_no" => $show_alternate_no,
				"customer_address" => $data['booking']->customer_address,
                "customer_city" => $data['booking']->customer_city,
                "customer_area" => $data['booking']->customer_area,
                "customer_pincode" => $data['booking']->customer_pincode,
                "customer_google_map" => $data['booking']->customer_google_map,
                "customer_lat" => $data['booking']->customer_lat,
                "customer_long" => $data['booking']->customer_long,
                "customer_channel" => $data['booking']->customer_channel,
                "vehicle_id" => $data['booking']->vehicle_id,  
                "vehicle_make" => get_make($data['booking']->vehicle_make),  
                "vehicle_model" => get_model($data['booking']->vehicle_model),  
                "vehicle_regno" => $data['booking']->vehicle_regno,  
                "vehicle_yom" => $data['booking']->vehicle_yom,  
                "vehicle_km_reading" => $data['booking']->vehicle_km_reading,  
                "service_category" => $data['booking']->service_category_id,
                "service_category_name" => get_service_category($data['booking']->service_category_id),  
                "time_slot" => $data['booking']->time_slot,
                "service_date" => convert_date($data['booking']->service_date), 
                "assigned_mechanic" => $data['booking']->assigned_mechanic,
                "specific_complaints" => $complaints,  
                "status" => $data['booking']->status,    
                "stage" => $data['booking']->stage,    
				"service_status" => $booking_service->stage, 
				"jobcard_status" =>  $jobcard_status,
				"jobcard_stage"  =>  $jobcard_stage,
				"service_name" => get_service_category($data['booking']->service_category_id), 
				"booking_type" => $data['booking']->booking_type, 
				"estimated_amount" => $booking_details->estimated_amount, 
                "created_on" => convert_date($data['booking']->created_on), 
				"active" => $active,
				"lock" => $data['booking']->locked,
				'action_button_1' => $action_1,
				'action_button_2' => $action_2,
				'action_button_3' => $action_3,
				'action_button_4' => $action_4,
				'action_button_5' => $action_5,
				'action_button_6' => $action_6,
		);
		
			 
			 // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $booking_data, 
                ],
            ],
        200);
		 
		 }else{
					$this->api_return(
							[
								'status' => false,
								"result" => [ 
									'data' => NULL, 
								], 
							],
						200); 
		 }
		 
        
    }
	

	public function details_action()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			////'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST); 
		  
		 if(!empty($booking_id)){  
		 
				 
				
				 
			 	
				if($detail_action_type=='customer_not_responding'){ 
				 $lock_status= 'customer_not_responding'; 
				 $action = 'Mechanic Marked: Customer Not Responding';	
				}elseif($detail_action_type=='cancel_booking'){
				 $lock_status='cancel_booking';	
				 $action = 'Mechanic Marked: Cancel Appointment';
				}elseif($detail_action_type=='location_not_found'){
				 $lock_status='location_not_found';	
				 $action = 'Mechanic Marked: Location Not Found';	
				}
			 	
			 
			 	$data = array(
                'locked' => 1, 
                'lock_status' => $lock_status  
            	); 
        		$where = array('booking_id' => $booking_id);
				$this->Common->update_record('bookings', $data, $where); 
			 
			 	
			 	 
			 
			 
			 	$active = $this->Api_model->user_active_bookings($mechanic_id, $booking_id);
			 
				$bookingdata = $this->Bookings->getbooking($booking_id);  
				$booking_service  = $bookingdata['booking_service']; 
				$booking_details  = $bookingdata['booking_details']; 
				$data['booking'] =  $bookingdata['booking'];  
			 	$data['jobcard']=$bookingdata['jobcard'];
			  
			 	$platform_ip =	@$ip;
				$platform_details = 'Device: '.@$device.' | OS: '.@$os;
			 	$owner_name = get_service_providers(array('id'=>$mechanic_id),'name');
			 	$owner = $mechanic_id; 
			 
			 	$this->Bookings->addBookingTrack($data['booking']->status, $data['booking']->stage, $owner, $platform_details, $action, $owner_name);
			 
			 
				if(empty($response['jobcard'])){
				$jobcard_status = 'Not Created';
				$jobcard_stage  = 'Not Created'; 
				}else{
				$jobcard_status = $data['jobcard']->status;
				$jobcard_stage  = $data['jobcard']->stage; 	
				}
			 
				$action_1['show'] = 1;
				$action_1['icon'] = 'navigate.png';
				$action_1['label'] = 'Navigate';
				$action_1['type'] = 'map';
				$action_1['value'] = 'direction_gmap';
			
				$action_2['show'] = 1;
				$action_2['icon'] = 'jobcard.png';
				$action_2['label'] = 'Jobcard';
				$action_2['type'] = 'page';
				$action_2['value'] = 'show_jobcard';
			
				$action_3['show'] = 1;
				$action_3['icon'] = 'assigned_spares.png';
				$action_3['label'] = 'Assigned Spares';
				$action_3['type'] = 'page';
				$action_3['value'] = 'show_assigned_spares';
			
				
				$action_btns = $this->Api_model->get_action_buttons($booking_id);  
				 
				$action_4=$action_btns['action_4'];
				$action_5=$action_btns['action_5'];
				$action_6=$action_btns['action_6'];
				
			 	$break_complaints = explode('+',$data['booking']->complaints);
			 	$complaints = join(", ", $break_complaints); 
					
			 	$show_mobile = $action_btns['show_mobile'];
				$show_alternate_no = $action_btns['show_mobile'];
			 
			 
		$booking_data = array(  
				"booking_id" => $booking_id, 
                "customer_id" => $data['booking']->customer_id,
                "customer_name" => $data['booking']->customer_name,
                "customer_email" => $data['booking']->customer_email,
                "customer_mobile" => $data['booking']->customer_mobile,
                "show_mobile" => $show_mobile,
                "customer_alternate_no" => $data['booking']->customer_alternate_no,
				"show_alternate_no" => $show_alternate_no,
				"customer_address" => $data['booking']->customer_address,
                "customer_city" => $data['booking']->customer_city,
                "customer_area" => $data['booking']->customer_area,
                "customer_pincode" => $data['booking']->customer_pincode,
                "customer_google_map" => $data['booking']->customer_google_map,
                "customer_lat" => $data['booking']->customer_lat,
                "customer_long" => $data['booking']->customer_long,
                "customer_channel" => $data['booking']->customer_channel,
                "vehicle_id" => $data['booking']->vehicle_id,  
                "vehicle_make" => get_make($data['booking']->vehicle_make),  
                "vehicle_model" => get_model($data['booking']->vehicle_model),  
                "vehicle_regno" => $data['booking']->vehicle_regno,  
                "vehicle_yom" => $data['booking']->vehicle_yom,  
                "vehicle_km_reading" => $data['booking']->vehicle_km_reading,  
                "service_category" => $data['booking']->service_category_id,
                "service_category_name" => get_service_category($data['booking']->service_category_id),  
                "time_slot" => $data['booking']->time_slot,
                "service_date" => convert_date($data['booking']->service_date), 
                "assigned_mechanic" => $data['booking']->assigned_mechanic,
                "specific_complaints" => $complaints,  
                "status" => $data['booking']->status,    
                "stage" => $data['booking']->stage,    
				"service_status" => $booking_service->stage,
				"jobcard_status" =>  $jobcard_status,
				"jobcard_stage"  =>  $jobcard_stage,
				"service_name" => get_service_category($data['booking']->service_category_id), 
				"booking_type" => $data['booking']->booking_type, 
				"estimated_amount" => $booking_details->estimated_amount, 
                "created_on" => convert_date($data['booking']->created_on), 
				"active" => $active,
				"lock" => $data['booking']->locked,
				'action_button_1' => $action_1,
				'action_button_2' => $action_2,
				'action_button_3' => $action_3,
				'action_button_4' => $action_4,
				'action_button_5' => $action_5,
				'action_button_6' => $action_6,
		);
		
		 
		 	 // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $booking_data, 
                ],
            ],
        200);
		 
		 }else{
					$this->api_return(
							[
								'status' => false,
								"result" => [ 
									'data' => NULL, 
								], 
							],
						200); 
		 }
    }
	
	public function notify_customer()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			////'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST); 
		  
		 if(!empty($booking_id)){   
			 	 
			  
			 
			 	$active = $this->Api_model->user_active_bookings($mechanic_id, $booking_id);
			 
				$bookingdata = $this->Bookings->getbooking($booking_id);  
				$booking_service  = $bookingdata['booking_service']; 
				$booking_details  = $bookingdata['booking_details']; 
				$data['booking'] =  $bookingdata['booking']; 
				
			 	$data = array(
                'locked' => 0, 
                'lock_status' => "Unlocked By Customer"  
            	); 
        		$where = array('booking_id' => $booking_id);
				$this->Common->update_record('bookings', $data, $where); 
				
			$notify_status = 'Customer Notified successfully';   
		 
		 }else{
			$notify_status = 'Error notifying customer'; 
		 }
		 
        // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $notify_status, 
                ],
            ],
        200);
    }
	
	public function get_jobcard_details()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			////'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST); 
		  
		 if(!empty($booking_id)){   
			 	 
			  
			 
			 	$active = $this->Api_model->user_active_bookings($mechanic_id, $booking_id);
			 
				$bookingdata = $this->Bookings->getbooking($booking_id);  
				$booking_service  = $bookingdata['booking_service']; 
				$jobcard_details  = $this->Bookings->getbooking_jobcard_details($booking_id, array('booking_id' =>  $booking_id, 'status'=>'Active'));// 
				$booking_details  = $bookingdata['booking_details'];
				$booking =  $bookingdata['booking']; 
				$jobcard_details  = $jobcard_details; 
				$estimated_amount = $booking_details->estimated_amount; 
			 	
			 		if($jobcard_details)
			 	foreach($jobcard_details as $jobcard_item){ 
					if($jobcard_item->item_type == 'Complaints'){
						$jobcard_item->item_type = $jobcard_item->complaints;
					} 
					$data[] = array(   
                "item_id" => $jobcard_item->item_id,
                "item_type" => $jobcard_item->item_type,
                "item" => $jobcard_item->item,
                "brand" => $jobcard_item->brand,
                "qty" => $jobcard_item->qty,
						);
				}
			 
			 
			 	 
			 	$category_order = array_filter($data, function ($var) {
				return ($var['item_type'] == 'Service Category');
				});
			 	$labour_order = array_filter($data, function ($var) {
				return ($var['item_type'] == 'Labour');
				});
			 	$spare_order = array_filter($data, function ($var) {
				return ($var['item_type'] == 'Spare');
				});
			 	$complaint_order = array_filter($data, function ($var) {
				return ($var['item_type'] != 'Service Category' && $var['item_type'] != 'Labour' && $var['item_type'] != 'Spare');
				});
			 	$data = array_merge_recursive($category_order,$labour_order,$spare_order,$complaint_order);
			 
			 	if(empty($jobcard_details)){ 
					$data = NULL; 
		 		}
		 
			 	
			 
			 $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $data, 
                ],
            ],
        	200);
			 
		 }else{
			$this->api_return(
            [
                'status' => false,
                "result" => [
                    'data' => NULL, 
                ],
            ],
        	200);
		 }
		 
        // return data
        
    }
	
	
	public function get_assigned_spares()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			////'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST); 
		  
		 if(!empty($booking_id)){   
			 	 
			  
			 
			 	$active = $this->Api_model->user_active_bookings($mechanic_id, $booking_id);
			 
				$bookingdata = $this->Bookings->getbooking($booking_id);  
				$booking =  $bookingdata['booking'];  
				$booking_service  = $bookingdata['booking_service']; 
				$jobcard_details  = $bookingdata['jobcard_details']; 
				$booking_details  = $bookingdata['booking_details'];
				$estimated_amount = $booking_details->estimated_amount; 
				$assigned_spares_data = $this->Common->select_wher('spares_recon', array('booking_id'=>$booking_id,'assigned'=>1));  
			 	
			 	if($assigned_spares_data)
			 	foreach($assigned_spares_data as $assigned_spares){
					$data[] = array(   
					"item_id" => $assigned_spares->item_id,
					"item" => $assigned_spares->item,
					"brand" => $assigned_spares->brand,
					"qty" => $assigned_spares->qty,
						);
				}
			 
			 	if(empty($data)){ 
			$data = NULL; 
		 		}
		 
			 	 // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $data, 
                ],
            ],
        200);
		 
		 }else{
					$this->api_return(
							[
								'status' => false,
								"result" => [ 
									'data' => NULL, 
								], 
							],
						200); 
		 }
		
		
    }
	
	public function booking_services()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			////'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST); 
		
		
				
		
				foreach ($_POST as $posting_key=>$posting_value){ $rawdatapost[]=$posting_key.':'.$posting_value; }
				$all_post_data_activity = implode(' | ',$rawdatapost);
		 		if(!$mechanic_id){  $owner_name = created_by_name(); $owner = created_by(); }else{ $owner_name = get_service_providers(array('id'=>$mechanic_id),'name');  $owner = $mechanic_id; }
				$data = array(
                'parent' => 'Booking Id'.$booking_id.' By: '.$owner_name,
				'content' => $all_post_data_activity 
				);  
				$this->Common->add_record('raw_table', $data); 
		
		
		   	if(empty($platform)){ $platform='APP'; }
		    $bookingdata = $this->Bookings->getbooking($booking_id);  
			$bookings = $bookingdata['booking'];
			$booking_details = $bookingdata['booking_details'];
			
			$booking_payments = $bookingdata['booking_payments'];
			$booking_services  = $bookingdata['booking_service'];
			$booking_service_id = $booking_services->service_id;  
		
		
		
		
		
				//Started Trip
				if($api_action == 'start_trip'){ 
				$status = 'Ongoing'; 
				$action = 'Trip Start Location:'.@getaddress($lat,$long);
				$device_time = date('H:i', strtotime($device_time)); 
				$serviceTime = date('H:i', strtotime($service_start_time));  
				$HrBeforetime = date('H:i', strtotime($serviceTime[0].'-1 hour'));
				$HrAftrtime = date('H:i', strtotime($serviceTime[0].'-1 hour'));   
					//if($device_time<$HrBeforetime || $device_time>$HrAftrtime){  
//								$this->api_return(
//								[
//									'status' => false,
//									"result" => [  
//										'message' => 'You cannot start trip before or after one hour of service time',
//									],
//
//								],
//								200);  
//					}   
				} 
				//Reached
				if($api_action == 'reached'){   
					$status = 'Ongoing'; 
					$action = 'Mechanic Reached @ Location:'.@getaddress($lat,$long); 
				}
				//Inspection Done
				if($api_action == 'inspection_done'){   
					$status = 'Ongoing'; 
					$action = 'Inspection Done'; 
				}
				//Start Work
				if($api_action == 'start_work'){   
					$status = 'Ongoing'; 
					$action = 'Mechanic Started Service'; 
				}
				//End Work
				if($api_action == 'end_work'){   
					$status = 'Ongoing'; 
					$action = 'Mechanic Service Work End'; 
					 
					
					$this->load->library('payments');
					$this->load->library('razorpay');
					$this->payments->recheck_coupon($booking_id);
					
					$final_payable_amount = $this->payments->calculate_final_payment($booking_id,'End Work');
					
				 	
					
				 	
					
					if($final_payable_amount>0){ 
					$bookingdata = $this->Bookings->getbooking($booking_id);  
					$booking = $bookingdata['booking']; 
					//$send_customer_link = $this->razorpay->create_payment_link($booking->customer_name, $booking->customer_email, $booking->customer_mobile, $payment_link_amt, 'Final amount to be paid for you service',  $booking_id);
						$request_final_payment = $this->payments->request_final_payment($booking_id, 'Yes');	
					}
					
				}
				//Submit Report
				if($api_action == 'submit_report'){   
					$status = 'Ongoing'; 
					$action = 'Report Submitted'; 
				}
				$payment_comments = 'NA';
				//Payment Done
				if($api_action == 'payment_done'){   
					$status = 'Completed';  	
					if(!empty($payment_comments)){   
					$action = 'Payment Done @ '.$payment_mode.'. ('.$payment_comments.') Collected Amt: '.$amount_collected. ' / Invoice Amt: '.$booking_payments->estimated_amount;
					}else{	
					$action = 'Payment Done @ '.$payment_mode.'. Collected Amt: '.$amount_collected. ' / Invoice Amt: '.$booking_payments->estimated_amount;	 
					} 
					
				}
		 
				
				 
		
		
		$response = $this->Api_model->update_booking_service($status, $stage, $action, $platform, $payment_comments);  
		if($response){ 
				// return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $response,
					'message' => 'Action Updated',
                ],
            ],
        	200); 
		}else{
			$this->api_return(
							[
								'status' => false,
								"result" => [  
									'data' => $response,
									'message' => 'Error! Something didnt work as expected',
								],

							],
							200); 
		}
			 
		
		 
    }
	
	public function upload_inspection_files()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			////'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST); 
		   	if(empty($platform)){ $platform='APP'; }
		    $bookingdata = $this->Bookings->getbooking($booking_id);  
			$bookings = $bookingdata['booking'];
			$booking_details = $bookingdata['booking_details'];
			$booking_services  = $bookingdata['booking_service'];
			$booking_service_id = $booking_services->service_id;   
			
			 $response = NULL; 
			 $UploadProcess = 0; 
		
		if($upload_file_name == 'inspection_selfie'){ 
			$Upload_Type = 'Selfie';
			$newFileName = $booking_id.'_selfie';
			$UploadProcess = 1; 
		}
		
		if($upload_file_name == 'inspection_km'){ 
			$Upload_Type = 'Km Reading';
			$newFileName = $booking_id.'_kmreading';
			$UploadProcess = 1;  
			 //Update Km in Bookings
			$data = array(
                'vehicle_km_reading' => $km_reading, 
            );   
		 	$where = array('booking_id' => $booking_id);
            $this->Common->update_record('bookings', $data, $where);
			//Update Km in Booking Services
			$data = array(
                'km_reading' => $km_reading, 
            );   
		 	$where = array('booking_id' => $booking_id);
            $this->Common->update_record('booking_services', $data, $where); 
			
		}
		
		if($upload_file_name == 'inspection_numberplate'){
						$Upload_Type = 'Number Plate';
						$newFileName = $booking_id.'_numberplate';
						$UploadProcess = 1;  
		}
		
		  
		if($UploadProcess == 1 && isset($_FILES["userfile"]["tmp_name"]) &&  $_FILES["userfile"]['name']!=""){   
				$uploaddir = "uploads/inspection/"; 
				$upload_data = $this->functions->custom_file_upload('userfile', $uploaddir, $newFileName); 
				$response =	$this->Api_model->addInspectionUploads($Upload_Type, $upload_data['file_name'], $upload_data['original_name'], $upload_data['file_ext'], $upload_data['file_path'], $booking_id);
			 
		}else{
				$response =	'No File Uploaded';
		}
			
		 
		 
		if($response){ 
				// return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $response,
					'message' => 'Data Uploaded',
                ],
            ],
        200); 
		}else{
			$this->api_return(
							[
								'status' => false,
								"result" => [  
									'message' => 'Error! No Files to Upload',
								],

							],
							200); 
		}
			 
		
		 
    }
	
	
	public function booking_services_backend()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS' 
        ]);
		 extract($_POST); 
		   	if(empty($platform)){ $platform='FLYWHEEL'; }
		    $bookingdata = $this->Bookings->getbooking($booking_id);  
			$bookings = $bookingdata['booking'];
			$booking_details = $bookingdata['booking_details'];
			$booking_services  = $bookingdata['booking_service'];
			$booking_service_id = $booking_services->service_id;  
		 
				//Inspection Done
				if($api_action == 'inspection_done'){   
					$status = 'Ongoing'; 
					$action = 'Inspection Done (Via Backend)'; 
				}
				//Start Work
				if($api_action == 'start_work'){   
					$status = 'Ongoing'; 
					$action = 'Mechanic Started Service (Via Backend)'; 
				}
				//End Work
				if($api_action == 'end_work'){   
					$status = 'Ongoing'; 
					$action = 'Service Work End (Via Backend)'; 
					 
					 
					
					$this->load->library('payments');
					$this->load->library('razorpay');
					$this->payments->recheck_coupon($booking_id);
					
					$final_payable_amount = $this->payments->calculate_final_payment($booking_id);
					
					$demand_service_advance = $this->payments->add_customer_ledger('final_paid', $booking_id, $final_payable_amount, 'Final Calculation', '@End Work');
					
					if($final_payable_amount>0){ 
					$bookingdata = $this->Bookings->getbooking($booking_id);  
					$booking = $bookingdata['booking']; 
					 
						$request_final_payment = $this->payments->request_final_payment($booking_id);	
					}
					
					
					
				}
				//Submit Report
				if($api_action == 'submit_report'){   
					$status = 'Ongoing'; 
					$action = 'Report Submited (Via Backend)'; 
				}
				//Payment Done
				if($api_action == 'payment_done'){   
					$status = 'Completed';  	
					if(!empty($payment_comments)){   
					$action = 'Payment Done (Via Backend) @ '.$payment_mode.'. ('.$payment_comments.') Collected Amt: '.$amount_collected. ' / Invoice Amt: '.$booking_details->estimated_amount;
					}else{	
					$action = 'Payment Done (Via Backend) @ '.$payment_mode.'. Collected Amt: '.$amount_collected. ' / Invoice Amt: '.$booking_details->estimated_amount;	
					$payment_comments = 'Via Mechanic App';
					} 
					
				} 
		
		if(empty($payment_comments)){ $payment_comments = ''; }
			
		$response = $this->Api_model->update_booking_service($status, $stage, $action, $platform, $payment_comments, TRUE);  
		if($response){ 
				// return data
        	$this->session->set_flashdata('success', 'Service action for Booking# '.$booking_id.' processed successfully..!');
            redirect(base_url() . 'bookings/booking_details/'.$booking_id);
		}else{
			 $this->session->set_flashdata('warning', 'Error in processing service action for '.$booking_id.'');
            redirect(base_url() . 'bookings/booking_details/'.$booking_id);
		}
			 
		
		 
    }
	
	
	
	
	
	public function getjobcard()
    {
        // API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5000, 'ip', 'everyday'],
					////'key' => ['header'], // type, {key}|table (by default)
				]);
				 extract($_POST); 
				
			$bookingdata = $this->Bookings->getbooking($booking_id); 
			$response['jobcard']=$bookingdata['jobcard'];
			if(empty($response['jobcard'])){
			$response['jobcard']['status']  = 'Not Created';
			$response['jobcard']['stage']  = 'Not Created';
			$response['jobcard']['booking_id'] =  $booking_id;	
			}
			$response['jobcard_details']=$bookingdata['jobcard_details'];	 
			$response['jobcard_total']=$bookingdata['jobcard_total_amount'];
		
				if(!empty($bookingdata['jobcard_details'])){   
						// return data
						$this->api_return(
							[
								'status' => true,
								"result" => [
									'data' => $response,  
									'message' => 'Jobcard details fetched successfully',
								],

							],
						200); 
						 }else{
							 
							$this->api_return(
							[
								'status' => false,
								"result" => [   
									'message' => 'No Jobcard found',
								],

							],
						200);
						}
		  }
	
	public function get_payment_details($booking_id=NULL)
    {
		
		header("Access-Control-Allow-Origin: *");
        // API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5000, 'ip', 'everyday'],
					//'key' => ['header'], // type, {key}|table (by default)
				]);
				 extract($_POST); 
				
			$this->load->library('payments');
					$this->load->library('razorpay');
		
			$data = $this->payments->get_payment_details($booking_id);  
		   
				if(!empty($data)){   
						// return data
						$this->api_return(
							[
								'status' => true,
								"result" => [
									'data' => $data,  
									'message' => 'Payment details fetched successfully',
								],

							],
						200); 
						 }else{
							 
							$this->api_return(
							[
								'status' => false,
								"result" => [  
									'message' => 'No Payment Details found',
								],

							],
						200);
						}
		  }
	
	public function send_payment_link()
    {
		
		header("Access-Control-Allow-Origin: *");
        // API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5000, 'ip', 'everyday'],
					//'key' => ['header'], // type, {key}|table (by default)
				]);
				 extract($_POST); 
				
		$this->load->library('payments');
					$this->load->library('razorpay');
		
			$data = $this->payments->request_final_payment($booking_id);  
		   
				if(!empty($data) && !empty($data['Payment_Status'])){   
						// return data
						$this->api_return(
							[
								'status' => true,
								"result" => [
									'data' => $data,  
									'message' => 'Payment details fetched successfully',
								],

							],
						200); 
						 }else{
							 
							$this->api_return(
							[
								'status' => false,
								"result" => [  
									'message' => 'No Payment Details found',
								],

							],
						200);
						}
		  }
	
	 public function check_payment_link()
    {
		 
		 header("Access-Control-Allow-Origin: *");
        // API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5000, 'ip', 'everyday'],
					//'key' => ['header'], // type, {key}|table (by default)
				]);
		 
			 extract($_POST); 
				 if($rz_payment_id)
		     $payment_status = $this->payments->verify_final_payment($booking_id, $rz_payment_id);
		 
		 	 $data = $this->payments->get_payment_details($booking_id);  
		
				if(!empty($data)){   
						// return data
						$this->api_return(
							[
								'status' => true,
								"result" => [
									'data' => $data,  
									'message' => 'Payment Status fetched successfully',
								],

							],
						200); 
						 }else{
							 
							$this->api_return(
							[
								'status' => false,
								"result" => [  
									'message' => 'No Payment Status found',
								],

							],
						200);
						}
		  }
	
	
	public function performance()
    {
		$mechanic_id = $this->uri->segment(3); 
		$data['mechanic_id'] = $mechanic_id;
		$data['mechanic'] = get_service_providers(array('id'=>$mechanic_id));
		 
        $this->load->view('mechanicdash/app/mechanicdash',$data);
		 
		  } 
	
	// Mechanic Perform
    public function mechanicperform()
    {
		 
		$this->load->model('Mechanicdash_model','Mechanicdash');
		
		$mechanic_id = $this->uri->segment(3); 
		 
		 
		$data['mechanics'] = get_service_providers(array('id'=>$mechanic_id));
		 
		
		$start_date = date('Y-m-d', strtotime('monday this week'));
		$end_date = date('Y-m-d', strtotime('sunday this week'));	
		
		$start_date_last = date('Y-m-d', strtotime('first day of this month'));
		$end_date_last = date('Y-m-d', strtotime('last day of this month'));
		 
		
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));
		
		$start_date2 = date('Y-m-d', strtotime($start_date_last));
        $end_date2 = date('Y-m-d', strtotime($end_date_last));
         
	   	$data['start'] = $start_date;
        $data['end'] = $end_date;
		$data['start_date1'] = $start_date1;
        $data['end_date1'] = $end_date1;
		$data['start_date2'] = $start_date2;
        $data['end_date2'] = $end_date2;
		
		 
		 	
		$data['mechanic_id'] = $mechanic_id;
		$data['mechanic'] = get_service_providers(array('id'=>$mechanic_id));
		$data['bookings'] =  $this->Common->select_wher('bookings', array('assigned_mechanic'=>$mechanic_id, 'status'=>'Completed', 'service_date >='=>$start_date1, 'service_date <='=>$end_date1));	 
		$data['mechanic_log'] = $this->Common->select_wher('mechanic_log', array('mechanic_id'=>$mechanic_id));	 
		  
        $this->load->view('mechanicdash/app/mechanicperform',$data);
     }
	
	
	
	// Mechanic Perform
    public function mechanictravel()
    {
		 
		
		 $this->load->model('Mechanicdash_model','Mechanicdash');
		
		$mechanic_id = $this->uri->segment(3); 
		 
		$data['mechanics'] = get_service_providers(array('id'=>$mechanic_id));
		 
		 
		$start_date = date('Y-m-d', strtotime('first day of this month'));
		$end_date = date('Y-m-d', strtotime('last day of this month'));	
	   
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));
         
	   	$data['start'] = $start_date;
        $data['end'] = $end_date;
		$data['start_date1'] = $start_date1;
        $data['end_date1'] = $end_date1; 
		 
		$data['mechanic_id'] = $mechanic_id;
		$data['mechanic'] = get_service_providers(array('id'=>$mechanic_id));
		$data['bookings'] =  $this->Common->select_wher('bookings', array('assigned_mechanic'=>$mechanic_id, 'status'=>'Completed', 'service_date >='=>$start_date1, 'service_date <='=>$end_date1));	 
		$data['mechanic_log'] = $this->Common->select_wher('mechanic_log', array('mechanic_id'=>$mechanic_id));	 
		  
      
        $this->load->view('mechanicdash/app/mechanictravel',$data);
         
     }
	
	// Mechanic Case Register
    public function case_register()
    {
		 
		$this->load->model('Mechanicdash_model','Mechanicdash');
		
		$mechanic_id = $this->uri->segment(3); 
		 
		$data['mechanics'] = get_service_providers(array('id'=>$mechanic_id));
		 
		$start_date = date('Y-m-d', strtotime("-45 days"));
        $end_date = date('Y-m-d');
		
         
	   	$data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
		
		 	
		$data['mechanic_id'] = $mechanic_id;
		$data['mechanic'] = get_service_providers(array('id'=>$mechanic_id));
		$data['total_records'] =   $this->Common->count_all_results('bookings', array('assigned_mechanic'=>$mechanic_id, 'service_date >='=>$start_date, 'service_date <='=>$end_date));  
		  
        $this->load->view('mechanicdash/app/case_register',$data);
     }
	
	
	public function mechanic_cases(){
		$this->load->model('Mechanicdash_model','Mechanicdash');
		
		extract($_POST); 
		
		$mechanic_id = $this->uri->segment(3); 
		$start_date = date('Y-m-d', strtotime("-45 days"));
        $end_date = date('Y-m-d');
		
		$limit = 10;  
		if (empty($resulting_page_id)){ $resulting_page_id=1; }
		$start_record = ($resulting_page_id-1) * $limit;  
		 
		$result = $this->Mechanicdash->get_mechanic_cases($mechanic_id, $start_date, $end_date, $start_record, $limit);
		
		echo $result;
		
	}
	
	
}
