<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class Customerapi extends API_Controller
{
    public function __construct() {
        parent::__construct();
		 //$this->output->enable_profiler(TRUE);
		 $this->load->model('Customerapi_model', 'Customerapi');
		 $this->load->model('Bookings_model', 'Bookings'); 
		 $this->load->model('Customer_model', 'Customer');  
		 $this->load->library('payments');
		 $this->load->library('Firebase');
		
		header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
		
		
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
				 header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        		 header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		 
				// API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5000, 'ip', 'everyday'],
					//'key' => ['header'], // type, {key}|table (by default)
				]);
				 extract($_POST);  
				$customer = get_customer(array('mobile'=>$mobile));
				
			if(!empty($customer->customer_id)){ 
				
				$payload = [
				'customer_id' => $customer->customer_id,
				'mobile' => $customer->mobile
        		];
				$this->load->library('Authorization_token');	
				$token = $this->authorization_token->generateToken($payload); 
				$name = $customer->name; 
				$send_otp = send_otp_customer($mobile, $name, $token, $customer->customer_id);  
				$customer_id = $customer->customer_id;
			}else{
				
				$payload = [
				'customer_name' => 'guest',
				'mobile' => $mobile
        		];
				$this->load->library('Authorization_token');	
				$token = $this->authorization_token->generateToken($payload); 
				$name = $mobile.'_'.date('His'); 
				$send_otp = send_otp_customer($mobile, $name, $token, 0);
				$customer_id = 0;	  	 
				}
		
				if($send_otp){ 
				$otp_data = array(   
				"token" => $token, 
                "mobile" => $mobile,
				"customer_id" => $customer_id, 	
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
				"token" => $token, 
                "mobile" => $mobile
							); 
						$this->api_return(
							[
								'status' => false,
								"result" => [ 
									'data' => NULL, 
									'message' => 'Error! something went wrong. Please retry',
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
					//'key' => ['header'], // type, {key}|table (by default)
				]);
				 extract($_POST);  
				 if(!empty($token))
				$customer_verified = verify_otp_customer($mobile, $otp, $token, $customer_id);  
				if($customer_verified){   
					
						$get_customer = get_customer(array('mobile'=>$mobile));

						if(!empty($get_customer->customer_id)){   
						$store_token = $this->Customerapi->store_token($mobile, $token, $customer_id);  
						$data['is_customer'] = 1;		
						$data['customer'] = $get_customer;	
						$data['customer']->token=$token; 
						$message = 'Welcome back '.$get_customer->name;	 
						}else{   
						$data['is_customer']  = 0;		
						$data['customer']['customer_id'] = 0;	 
						$data['customer']['name'] =NULL;
						$data['customer']['mobile'] =$mobile;
						$data['customer']['email'] =NULL;
						$data['customer']['city'] =NULL;
						$data['customer']['token'] = $token; 
						$message = 'Welcome to GarageWorks. Please enter your details to proceed';	 
						
						}

						// return data
						$this->api_return(
							[
								'status' => true,
								"result" => [
									'data' => $data,  
									'message' => $message,
								],

							],
						200);
					
                 }else{
                    $otp_data = array(    
                    "mobile" => $mobile,
                    "token"	=> $token,
                    "customer_id" => $customer_id,	
                    );
                    $this->api_return(
                    [
                        'status' => false,
                        "result" => [ 
                            'data' => $otp_data, 
                            'message' => 'OTP not valid',
                        ],

                    ],
                200);
                }
		  }
	
	 
	 
	public function add_new_customer()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			//'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST); 
		  	
		 $new_customer_id = $this->Customer->add_new_customer();
		 $update_token = $this->Customer->update_token($mobile, $token, $new_customer_id);
		 $customer_data =  $this->Customer->getcustomer($new_customer_id); 	 
		
		$data['customer']  = $customer_data['customer'];
        $data['customer_address'] =  $customer_data['customer_addresses'];   
		$data['customer_vehicle'] =  $customer_data['customer_vehicles'];
		 
			 // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $data, 
                    'message' => 'Welcome aboard!',
                ],
            ],
        200); 
        
    }
	
	public function get_customer_details()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			//'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST); 
		 
		 $customer_data =  $this->Customer->getcustomer($customer_id); 	 
		
		if(!empty($customer_data['customer']->customer_id)){ 
		$data['customer']  = $customer_data['customer'];
        $data['customer_address'] =  $customer_data['customer_addresses'];   
		$data['customer_vehicle'] =  $customer_data['customer_vehicles']; 
		$data['customer_booking'] =  $customer_data['customer_bookings'];
		 
			 // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $data, 
                    'message' => 'Customer Details Found',
                ],
            ],
        200); 
		}else{
			$this->api_return(
            [
                'status' => false,
                "result" => [
                    'data' => null, 
                    'message' => 'Customer Details Not Found',
                ],
            ],
        200); 
		}
        
    }
	
	
	public function get_all_make()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			//'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST);  
		$data['makes'] =  get_make(FALSE, TRUE);  
			 // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $data, 
                    'message' => 'Make Found',
                ],
            ],
        200); 
        
    }
	
	public function get_all_models()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			//'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST);  
		$data['models'] =  get_all_model($make_id,TRUE);  
			 // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $data, 
                    'message' => 'Models Found',
                ],
            ],
        200); 
        
    }
	
	
	public function get_model_details()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			//'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST);  
		$data['model_details'] =  get_model($model_id,TRUE);  
			 // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $data, 
                    'message' => 'Model Details Found',
                ],
            ],
        200); 
        
    }
	
	
	
	public function get_all_areas()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			//'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST); 
		if(empty($search_query))
		$search_query = FALSE;	
		$data['areas'] =  get_area_details(FALSE, array('city'=>$city),FALSE, TRUE, $search_query);  
			 // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $data, 
                    'message' => 'Areas Found',
                ],
            ],
        200); 
        
    }
	
	public function get_area_details()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			//'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST);  
		$data['area_details'] =  get_area_details(FALSE, array('city'=>$city,'area'=>$area), FALSE, TRUE, FALSE);  
			 // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $data, 
                    'message' => 'Area Details Found',
                ],
            ],
        200); 
        
    }
	
	 
	public function get_common_complaints()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			//'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST);  
		if(empty($search_query)){
			$search_query = '';
		}
		 
		$complaints =  $this->Common->select_wher('complaints','id IN (71,101,86,72,14)');  
		if(!empty($complaints)){ 
		foreach($complaints as $row){
			$complaintID = $row->id;
			$complaintName = $row->complaints;
			$complaint[] = array('complaint_id'=>$complaintID, 'complaint_name'=>$complaintName);  
		}
		$data['common_complaints'] =  $complaint;  
			 // return data
			$this->api_return(
				[
					'status' => true,
					"result" => [
						'data' => $data, 
						'message' => 'Common Complaints Found',
					],
				],
			200); 
		}else{
			$this->api_return(
				[
					'status' => true,
					"result" => [
						'data' => null, 
						'message' => 'No Common Complaints Found',
					],
				],
			200);
		}
        
    }
	
	
	public function get_all_complaints()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			//'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST);  
		if(empty($search_query)){
			$search_query = '';
		}
		$complaints =  $this->Common->complaints_dropdown($search_query);  
		if($complaints){ 
		foreach($complaints as $row){
			$complaint[] = array('complaint_id'=>$row['id'], 'complaint_name'=>$row['text']);  
		}
		$data['complaints'] =  $complaint;  
			 // return data
			$this->api_return(
				[
					'status' => true,
					"result" => [
						'data' => $data, 
						'message' => 'Complaints Found',
					],
				],
			200); 
		}else{
			$this->api_return(
				[
					'status' => true,
					"result" => [
						'data' => null, 
						'message' => 'No Complaints Found',
					],
				],
			200);
		}
        
    }
	
	
	public function get_all_spares()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			//'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST);  
		if(empty($search_query)){
			$search_query = '';
		}
		$spares =  $this->Common->spares_dropdown($vehicle_category, $model_code, $search_query, $channel, $city, FALSE);  
		if($spares){ 
		foreach($spares as $row){
			 
			
			  $spare[]=array("spares_id"=>$row['id'], "spare_name"=>$row['text'], "spares_rates"=>$row['sparesrates'], "labour_rates"=>$row['labourrates'], "total_rates"=>$row['totalrates'], "item_code"=>$row['itemcode']);  
			 
		}
		$data['spares'] =  $spare;  
			 // return data
			$this->api_return(
				[
					'status' => true,
					"result" => [
						'data' => $data, 
						'message' => 'Spares Found',
					],
				],
			200); 
		}else{
			$this->api_return(
				[
					'status' => true,
					"result" => [
						'data' => null, 
						'message' => 'No Spare Found',
					],
				],
			200);
		}
        
    }
	
	
	public function get_all_labour()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			//'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST);  
		if(empty($search_query)){
			$search_query = '';
		}
		 
		$labours =  $this->Common->labour_dropdown($vehicle_category, $model_code, $city, $search_query, FALSE);  
		if($labours){ 
		foreach($labours as $row){
			  
		   
			   $labour[]=array("labour_id"=>$row['id'], 
							   "labour_name"=>$row['text'], 
							   "spares_rates"=>$row['sparesrates'], 
							   "labour_rates"=>$row['labourrates'],
							   "total_rates"=>$row['totalrates'], 
							   "item_code"=>$row['itemcode']);  
				
		 
			 
		}
		$data['labour'] =  $labour;  
			 // return data
			$this->api_return(
				[
					'status' => true,
					"result" => [
						'data' => $data, 
						'message' => 'Labour Work Found',
					],
				],
			200); 
		}else{
			$this->api_return(
				[
					'status' => true,
					"result" => [
						'data' => null, 
						'message' => 'No Labour Work Found',
					],
				],
			200);
		}
        
    }
	
	public function get_all_gic()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			//'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST);  
		$gics =  get_all_gic();  
		
		foreach($gics as $gic){ 
			$gic_data[] = array('gic_id'=>$gic->GIC_ID, 'gic_name'=>$gic->GIC_NAME);
		}
		
		$data['gic'] = $gic_data;
			
			 // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $data, 
                    'message' => 'GIC Found',
                ],
            ],
        200); 
        
    }
	
	public function get_customer_bookings()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			//'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST); 
		  
				$customer_bookings = $this->Customer->getcustomer_bookings($customer_id);  
			 	 
			 	
			 		if($customer_bookings){ 
						$booking_count = 0;
				 foreach($customer_bookings as $booking){ 
				$bookingdata = $this->Bookings->getbooking($booking->booking_id); 
				$booking_service  = $bookingdata['booking_service']; 
				$booking_details  = $bookingdata['booking_details']; 
				$data['booking'] =  $bookingdata['booking'];  
			 	$data['jobcard']=$bookingdata['jobcard']; 
			 	$booking_payment=$bookingdata['booking_payment']; 
				if(empty($response['jobcard'])){
				$jobcard_status = 'Not Created';
				$jobcard_stage  = 'Not Created'; 
				}else{
				$jobcard_status = $data['jobcard']->status;
				$jobcard_stage  = $data['jobcard']->stage; 	
				}  
					 
					 $break_complaints = explode('+',$data['booking']->complaints);
			 	$complaints = join(", ", $break_complaints); 
					 
					 if($data['jobcard']->customer_approval=='Sent'){ 
					 $action = 'approve_jobcard';
					 }elseif($booking_service->stage=='Submit Report' && $data['booking']->status!='Completed'){ 
						 if($booking_payment->payment_status=='Issued' || $booking_payment->payment_status=='Not Paid'){ 
						 $action = 'complete_payment';
						 }
					 }elseif($data['booking']->status=='Completed'){ 
						 if(empty($bookingdata['booking_feedback']->feedback)){ 
						 $action = 'give_feedback';
						 }
					 }else{
						 $action = null;
					 }
					 
		$booking_data[]  = array(  
				"booking_id" => $data['booking']->booking_id, 
                "customer_id" => $data['booking']->customer_id,
                "customer_name" => $data['booking']->customer_name,
                "customer_email" => $data['booking']->customer_email,
                "customer_mobile" => $data['booking']->customer_mobile, 
                "customer_alternate_no" => $data['booking']->customer_alternate_no, 
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
				"lock" => $data['booking']->locked, 
				"action" => $action, 
				);
					 $booking_count++;
				 }
		
			 
			 
			 // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $booking_data, 
					'message' => $booking_count.' Bookings Found',
                ],
            ],
        200);
		 
		 }else{
					$this->api_return(
							[
								'status' => false,
								"result" => [ 
									'data' => NULL, 
									'message' => 'No Bookings Found',
								], 
							],
						200); 
		 }
		 
        
    }
	
	
	 public function customer_jobcard_approval()
	 {
		 header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			//'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST); 
		  
		 if(!empty($booking_id)){    
				
			 	$jobcard_approval = $this->Bookings->approve_jobcard_data();   
			 
		 }else{
			 // return data
        $this->api_return(
            [
                'status' => false,
                "result" => [
                    'data' => null,
					'message' => 'Something Went Wrong!'
                ],
            ],
        200); 
		 }
		 
        // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $jobcard_approval,
					'message' => 'Jobcard approved for Booking Id# '.$booking_id
                ],
            ],
        200); 
	 }
	
	
	public function complete_payment(){
		 header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			//'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST); 
		  
		 if(!empty($booking_id)){    
				
			 	 
				$payment_details = $this->payments->final_payment($booking_id); 
				 
		 
		 }else{
			// return data
        $this->api_return(
            [
                'status' => false,
                "result" => [
                    'data' => null, 
					'message' => 'Something Went Wrong!'
                ],
            ],
        200);
		 }
		 
        // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $notify_status, 
					'message' => 'Booking Payment Details'
                ],
            ],
        200);
	}
	
	
	public function unlock_booking()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			//'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST); 
		  
		 if(!empty($booking_id)){    
				
			 	$data = array(
                'locked' => 0, 
                'lock_status' => "Unlocked By Customer"  
            	); 
        		$where = array('booking_id' => $booking_id);
				$this->Common->update_record('bookings', $data, $where); 
				
			$notify_status = 'Booking Unlocked successfully';   
		 
		 }else{
			$notify_status = 'Error Unlocking Booking'; 
		 }
		 
        // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $notify_status, 
					'message' => 'Booking Unlock Status'
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
			//'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST); 
		   
		 if(!empty($booking_id)){   
			 	  
				$bookingdata = $this->Bookings->getbooking($booking_id);  
				$booking_service  = $bookingdata['booking_service']; 
				$jobcard_details  = $this->Bookings->getbooking_jobcard_details($booking_id, array('booking_id' =>  $booking_id, 'status'=>'Active'));// 
				$booking_details  = $bookingdata['booking_details'];
				$booking =  $bookingdata['booking']; 
				$jobcard_details  = $jobcard_details; 
				$estimated_amount = $booking_details->estimated_amount; 
			 	
			 		if($jobcard_details)
			 	foreach($jobcard_details as $jobcard_item){
					
					if($jobcard_item->item_type = 'Complaints'){
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
			 
			 
			 	if(empty($jobcard_details)){ 
			$data = NULL; 
		 		}
		 
			 
			 $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $data, 
					'message' => 'Jobcard found'
                ],
            ],
        	200);
			 
		 }else{
			$this->api_return(
            [
                'status' => false,
                "result" => [
                    'data' => NULL, 
					'message' => 'No details found'
                ],
            ],
        	200);
		 }
		 
        // return data
        
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
				
			$data = $this->payments->send_payment_link($booking_id);  
		   
				if(!empty($data) && !empty($data['paymentlink'])){   
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
		     $payment_status = $this->payments->check_payment_status($booking_id, $rz_payment_id);
		 
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
	
	public function get_dashboard()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			//'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST);  
		$services =  get_all_services();  
		 
		foreach($services as $row){
			
			$service_slug = $row->service_slug;
			$check_allowed = check_service_map($service_slug, array('area_id'=>$area_id,'city'=>$city));
			 
			if($check_allowed){
				 	$is_allowed = 1; 
			}else{
				$is_allowed = 0;
			}
			
			$service[] = array('id'=>$row->id,'service_name'=>$row->service_name,'service_type'=>$row->service_type,'service_details'=>$row->details,'service_images'=>$row->image,'service_icon'=>$row->icon,'is_allowed'=>$is_allowed,'skip_details'=>$row->skip_details);  
		}
		 $data['services'] = $service;
			 // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $data, 
                    'message' => 'Welcome aboard!',
                ],
            ],
        200); 
        
    }

	public function get_service_packages()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			//'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST);  
		$service =  $this->Common->single_row('services',array('id'=>$service_id,'active'=>1));  
		if(!empty($service)){
			
			$service_slug = $service->service_slug;
			$check_allowed = check_service_map($service_slug, array('area_id'=>$area_id,'city'=>$city));
			 
			if($check_allowed){
				$is_allowed = 1; 
			}else{
				$is_allowed = 0;
			}
			
			$service_data = array('id'=>$service->id,'service_name'=>$service->service_name,'service_type'=>$service->service_type,'service_details'=>$service->details,'service_images'=>$service->image,'service_icon'=>$service->icon,'is_allowed'=>$is_allowed);   
			
			
			$service_packages_data = $this->Common->select_wher('service_packages',array('service_id'=>$service_id,'active'=>1));
			foreach($service_packages_data as $pack){ 
				$package_slug = $pack->package_slug;
			$check_allowed_pack = check_service_map($package_slug, array('area_id'=>$area_id,'city'=>$city)); 
			if($check_allowed_pack){
				$is_allowed_pack = 1; 
			}else{
				$is_allowed_pack = 0;
			} 
				
				$city_slug = make_slug($city);
				$service_rate =  $this->Common->single_row('service_rates',array('service_id'=>$pack->service_id,'package_id'=>$pack->id,'vehicle_category'=>$vehicle_category,'active'=>1), $city_slug);  
				 
				
				$service_packages[] = array('package_id'=>$pack->id,
											'service_id'=>$pack->service_id,
											'package_name'=>$pack->package_name,  
											'package_slug'=>$pack->package_slug,
											'details'=>$pack->details,
											'features'=>$pack->features,
											'benefits'=>$pack->benefits,
											'terms'=>$pack->terms,
											'image'=>$pack->image,
											'rates'=>$service_rate,
											'active'=>$pack->active,
										    'is_allowed_pack'=>$is_allowed_pack);
			} 
			
		}
		
		$data['service'] =  $service_data;
		$data['service_packages'] =  $service_packages;
			 // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $data, 
                    'message' => 'Services Updated',
                ],
            ],
        200); 
        
    }
	
	
	public function get_service_flow()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			//'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST);  
		$service_flow =  $this->Common->select_wher('services_flow',array('service_type'=>$service_type,'active'=>1));;  
		if(!empty($service_flow)){
			
			 $count = 0;
			foreach($service_flow as $row){ 
			 
				$service_flow_data[] = array('service_type'=>$row->service_type,
											'step_no'=>$row->step_no,
											'step_details'=>$row->step_details);
			
			$count++;
			
			} 
			
		}
		$data['flow_count'] = $count;
		$data['service_flow'] =  $service_flow_data; 
			 // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $data, 
                    'message' => 'Services Flow Updated',
                ],
            ],
        200); 
        
    }
	
	
	public function get_package_option()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			//'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST);  
		$package_options_data = [];
		$package_options =  $this->Common->select_wher('service_options',array('package_id'=>$package_id));  
		if(!empty($package_options)){
			 
			foreach($package_options as $row){ 
			 
				$package_options_data[] = array('option_type'=>$row->option_type,
											'option_name'=>$row->option_name,
											'option_details'=>$row->option_name,
											'option_details'=>$row->details,
											'option_rate'=>$row->rate);
			
			 
			
			} 
			
		} 
		if(empty($package_options_data)){ $package_options_data = null; }
		$data['service_flow'] =  $package_options_data; 
			 // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $data, 
                    'message' => 'Package Option Updated',
                ],
            ],
        200); 
        
    }
	
	 
	public function create_new_customer()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			//'key' => ['header'], // type, {key}|table (by default)
        ]);
		
		$_POST['channel'] = 'Direct';
		
		 extract($_POST);
		
		$customer_id = $this->Customer->add_new_customer();   
		$customer_address = $this->Customer->add_customer_address($customer_id); 
		$customer_vehicle = $this->Customer->add_customer_vehicle($customer_id);   
	 	 
		 if($customer_id){ 
		$customer_data =  $this->Customer->getcustomer($customer_id); 
			 
			 $data['customer']=$customer_data['customer'];
			 $data['customer_address']=$customer_data['customer_addresses'];
			 $data['customer_vehicle']=$customer_data['customer_vehicles'];
				 
			 // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $data, 
                    'message' => 'Customer Created Successfully',
                ],
            ],
        200); 
		 }else{
			$this->api_return(
            [
                'status' => false,
                "result" => [
                    'data' => null, 
                    'message' => 'Customer Not Created',
                ],
            ],
        200);  
		 }
        
    }
	
	public function calculate_cart()
    {
        header("Access-Control-Allow-Origin: *");

		
		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			//'key' => ['header'], // type, {key}|table (by default)
        ]);
	  
		 extract($_POST); 
		
		$service_name = $this->Common->single_row('service_packages',array('id'=>$package_id,'active'=>1),'package_name');
		
		$booking_fee = $this->payments->calculate_booking_fee($service_name, $city);
		
			 
				
		//$package_price  = $this->payments->calculate_package();
//		
//		$option_price  = $this->payments->calculate_package_option();
//		
//		$complaint_price  = $this->payments->calculate_complaint();
//		
//		$spares_price  = $this->payments->calculate_spares();
//		
//		$labour_price  = $this->payments->calculate_labour();
		 
		 
		if(!$booking_fee){ 
		 $booking_fee = 0;
		}
	 
		   $data['booking_fee']  = $booking_fee['booking_fee'];
		   $data['discount']  = 0;
		
//		
//		$area_id = 
//		$city = 
//		$make = 
//		$model = 
//		$model_code = 	 	
//		$customer_id =	
//		$address_id =	
//		$vehicle_id =
//		$vehicle_category = 
//		$service_id =   
//		$package_id =    
//		$option_id =   	
//		$complaints =  	
//		$spares =  	
//		$labour =  	 
		
			
		   
			 // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $data, 
                    'message' => 'Booking Fee',
                ],
            ],
        200); 
        
    }
	
	
	
	public function save_booking()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5000, 'ip', 'everyday'],
			//'key' => ['header'], // type, {key}|table (by default)
        ]);
	  
		 extract($_POST); 
		
		
		if(!empty($complaints))
				$all_selected_complaints =	implode('+',$complaints);
		 
				$_POST['selected_complaints'] = $all_selected_complaints;
		
				$_POST['service_date'] = convert_date($service_date);
				//$response['site_booking_record']=$this->update_sitebooking_data($otp_expired, $status);
		
				$response['site_booking_convert_record']= $this->Site->update_sitebooking_data($otp_expired, $status);
		
		
		
		
		$device = $this->input->post("device");
			$os =  $this->input->post("os"); 
			$browser =  $this->input->post("browser");
			$make_name =  get_make($vehicle_make);
			$model_name =  get_model($vehicle_model);  
			
		 $sitebookingdata = array(
				'otp_verify_time' => date('Y-m-d H:i:s'), 
			 	'booking_confirm_time' => date('Y-m-d H:i:s'), 
                'existing_customer' => $customer_id,
                'otp_expired' => $otp_expired,
				'status' => $status,
            );
         $sitebookingwhere = array('id' => $site_booking_id);
         $response = $this->Common->update_record('site_bookings', $sitebookingdata, $sitebookingwhere); 
		
		if(!empty($complaints)){ 
		$all_selected_complaints =	implode('+',$complaints);
			   
		$_POST['selected_complaints'] = $all_selected_complaints;
		
		$_POST['complaints'] = $all_selected_complaints;
		}
		  
		 
		
			 $compile_estimate_data = $this->Site->compile_estimate_data(); 
			 
		$last_booking_id = $this->Common->find_maxid('booking_id', 'bookings');
		$booking_no = ($last_booking_id+1); 
		
		$_POST['reg_no'] = '';
		$_POST['last_service_id'] = '';
		/////////////////////////////////////////////////// ADD BOOKING ESTIMATE DETAILS START
		$customer_data = $this->Bookings->add_booking_customer($booking_no); 
		
		 $convert_desired_service_date = date('Y-m-d', strtotime($service_date));
		/////////////////////////////////////////////////// ADD BOOKING START  
         $booking_id = $this->Bookings->add_booking_data($booking_no, $customer_data['customer_id'],$customer_data['customer_vehicle'],array('customer_id'=>$customer_data['customer_id'], 'vehicle_id'=>$customer_data['customer_vehicle'],'service_date'=>$convert_desired_service_date,'booking_medium'=>'app'));   
		/////////////////////////////////////////////////// ADD BOOKING START END 
		
		/////////////////////////////////////////////////// ADD BOOKING DETAILS START
		$booking_details = $this->Bookings->add_booking_details_data($booking_id); 
		/////////////////////////////////////////////////// ADD BOOKING DETAILS END
		
		
		/////////////////////////////////////////////////// ADD BOOKING TRACK START
		$booking_track = $this->Bookings->add_booking_track_data($booking_id,$customer_data['customer_vehicle'],' '); 
		/////////////////////////////////////////////////// ADD BOOKING TRACK END
		 
		/////////////////////////////////////////////////// ADD BOOKING ESTIMATE START
		 $estimate = $this->Bookings->add_booking_estimate_data($booking_id);  
		/////////////////////////////////////////////////// ADD BOOKING ESTIMATE END
		
		/////////////////////////////////////////////////// ADD BOOKING ESTIMATE DETAILS START
		 $estimate_details  = $this->Bookings->add_booking_estimate_details_data($booking_id, $estimate, $compile_estimate_data);  
		/////////////////////////////////////////////////// ADD BOOKING ESTIMATE DETAILS END
		
		/////////////////////////////////////////////////// ADD BOOKING ESTIMATE DETAILS START
		 $booking_payments = $this->Bookings->add_booking_payments($booking_id, $customer_data['customer_id']);  
		/////////////////////////////////////////////////// ADD BOOKING ESTIMATE DETAILS END
		
         /////////////////////////////////////////////////// ADD BOOKING ESTIMATE DETAILS START
		 $booking_service = $this->Bookings->add_bookings_service($booking_id, $customer_data['customer_id'],  $customer_data['customer_vehicle']);  
		/////////////////////////////////////////////////// ADD BOOKING ESTIMATE DETAILS END
		
		if(empty($booking_fee_amount)){ $booking_fee_amount = 0; } 
		
		$this->load->library('payments');
		$this->load->library('razorpay');
		$demand_booking_fee = $this->payments->add_customer_ledger('booking_fee', $booking_id, $booking_fee_amount, 'Online Booking');
		
		if(empty($discount_amount)){ $discount_amount = 0; }
		
		$demand_discount = $this->payments->add_customer_ledger('discount', $booking_id, $discount_amount, 'Online Booking');
		
		 
			if(!empty($ref_no)){ 
			 
				$payment_mode = 'Razorpay';
			$receive_booking_fee = $this->payments->collect_customer_ledger($booking_id, 'booking_fee', $booking_fee_amount, @$payment_mode, @$payment_status, $ref_no, 'Via payment gateway');  	 
			
				
				
			}
	 
		
		 
		
					$service_category_name = get_service_category($service_category);
					
				if($customer_type=='old'){ 
			$existingcustmsg = '(Existing Customer. Channel: '.$channel.')';
			$existing_customer = 1;
			$customer_channel  = $channel;
		}else{
			$existingcustmsg = '(New Customer)';
			$existing_customer = 0;
			$customer_channel  = 'Online';
		}
		
		  
					
					$mail_data = array( 'name' => $name, 'existingcustmsg' => $existingcustmsg, 'email' => $email,  'mobile' => $mobile, 'customer_address' => $address, 'customer_google_map' => $google_map, 'customer_area'=> $area, 'customer_city' => $city, 'desired_service_date' => $service_date, 'desired_time_slot' => $time_slot, 'make_name'=>$make_name, 'model_name'=>$model_name,'service_category' => $service_category_name, 'sparesLISTNAME' => $estimate_details['Spares_List'], 'labourLISTNAME'=>$estimate_details['Labour_List'], 'complaint_list'=>$all_selected_complaints, 'comments'=>$comments, 'booking_id'=>$booking_id);
			if(!$booking_id){ 
		 			$send_email = $this->mailer->mail_template('hello@garageworks.in','booking_from_website',$mail_data, 'custom');	
		
		 $mail_data = array( 'booking_id' => $booking_id, 'Spares_List' => $estimate_details['Spares_List'], 'Labour_List' => $estimate_details['Labour_List']);
		 $send_email = $this->mailer->mail_template($email,'new-booking',$mail_data, 'emailer/new_bookings.php');
 		  
		 
		 $sms_data = array( 'service_category' => $service_category_name, 'time_slot' => $time_slot, 'service_date'=>$service_date); 
		 $send_sms = $this->sms->sms_template(array($mobile),'new-booking',$sms_data);
		 
			}
		 
	 
	 
		   $data['booking_id']  = $booking_id;
		  
		if($booking_id){
				$this->api_return(
					[
						'status' => true,
						"result" => [
							'data' => $data, 
							'message' => 'Booking created successfully',
						],
					],
				200); 
		}else{
				$this->api_return(
            [
                'status' => false,
                "result" => [
                    'data' => null, 
                    'message' => 'Error placing booking',
                ],
            ],
        200); 
			
		}
        
    }
	
	
	
}