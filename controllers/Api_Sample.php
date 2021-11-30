<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class Api_Sample extends API_Controller
{
    public function __construct() {
        parent::__construct();
		 $this->load->model('Api_model');
		 $this->load->model('Bookings_model', 'Bookings'); 
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
            'limit' => [5, 'ip', 'everyday'],             /**
             * type :: ['header', 'get', 'post']
             * key  :: ['table : Check Key in Database', 'key']
             */
            //'key' => ['POST', $this->key() ], // type, {key}|table (by default)
			'key' => ['header'], // type, {key}|table (by default)
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

        return 1452;
    }


    public function sendotp(){
				
				 header("Access-Control-Allow-Origin: *");

				// API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5, 'ip', 'everyday'],
					'key' => ['header'], // type, {key}|table (by default)
				]);
				 extract($_POST); 
				 if($user_type=='service_providers') 
				$user = get_service_providers(array('mobile'=>$mobile));
				if(!empty($user)){ 
				$payload = [
				'id' => $user->id,
				'mobile' => $user
        		];
				$this->load->library('authorization_token');	
				$token = $this->authorization_token->generateToken($payload);  
				$user_id = $user->id; 
				  
				$send_otp = send_otp($mobile, $token, $user_type, $user_id);
					
						if($send_otp){   
						// return data
						$this->api_return(
							[
								'status' => true,
								"result" => [
									'token' => $token,
									'mobile' => $mobile,
									'message' => 'OTP sent successfully on '.$mobile,
								],

							],
						200); 
						 }else{
							$this->api_return(
							[
								'status' => false,
								"result" => [ 
									'mobile' => $mobile,
									'message' => 'Mobile number not found in database',
								],

							],
						404);
						}
			 
				
				 
				}else{
					$this->api_return(
					[
						'status' => false,
						"result" => [ 
							'mobile' => $mobile,
							'message' => 'Mobile number not found in database',
						],

					],
				404);
				}
	}
	
	public function verifyotp()
    {
        // API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5, 'ip', 'everyday'],
					'key' => ['header'], // type, {key}|table (by default)
				]);
				 extract($_POST);
		
				 if(!empty($token))
				$user_verified = verify_otp($mobile, $otp, $token);  
				if($user_verified){   
						// return data
						$this->api_return(
							[
								'status' => true,
								"result" => [
									'user_data' => $user_verified, 
									'message' => 'OTP verified successfully',
								],

							],
						200); 
						 }else{
							$this->api_return(
							[
								'status' => false,
								"result" => [ 
									'mobile' => $mobile,
									'message' => 'OTP not valid',
								],

							],
						404);
						}
		  }
	
	
	
    public function login()
    {
        header("Access-Control-Allow-Origin: *");

        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
        ]);

        // you user authentication code will go here, you can compare the user with the database or whatever
        $payload = [
            'id' => "2806",
            'other' => "Some other data"
        ];

        // Load Authorization Library or Load in autoload config file
        $this->load->library('authorization_token');

        // generate a token
        $token = $this->authorization_token->generateToken($payload);

        // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'token' => $token,
                ],
                
            ],
        200);
    }

    /**
     * view method
     *
     * @link [api/user/view]
     * @method POST
     * @return Response|void
     */
    public function view()
    {
        header("Access-Control-Allow-Origin: *");

        // API Configuration [Return Array: User Token Data]
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            'requireAuthorization' => true,
        ]);

        // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'user_data' => $user_data['token_data']
                ],
            ],
        200);
    }
	
	
	
	/**
     * view method
     *
     * @link [api/user/view]
     * @method POST
     * @return Response|void
     */
    public function add_booking()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5, 'ip', 'everyday'],
			'key' => ['header'], // type, {key}|table (by default)
        ]);
		
		$last_booking_id = $this->Common->find_maxid('booking_id', 'bookings');
		$booking_no = ($last_booking_id+1);  
		$last_service_id = $this->input->post('last_service_id');
		$service_category = $this->input->post('service_category');  
		$service_date = $this->input->post('service_date');
		$time_slot = $this->input->post('time_slot');
		$all_complaints = $this->input->post('all_selected_complaints'); 
		$customer_data = $this->Bookings->add_booking_customer($booking_no);   
		/////////////////////////////////////////////////// ADD BOOKING START  
         $booking_id = $this->Bookings->add_booking_data($booking_no, $customer_data['customer_id']);   
		/////////////////////////////////////////////////// ADD BOOKING START END  
		/////////////////////////////////////////////////// ADD BOOKING DETAILS START
		$booking_details = $this->Bookings->add_booking_details_data($booking_id); 
		/////////////////////////////////////////////////// ADD BOOKING DETAILS END  
		/////////////////////////////////////////////////// ADD BOOKING TRACK START
		$booking_track = $this->Bookings->add_booking_track_data($booking_id); 
		/////////////////////////////////////////////////// ADD BOOKING TRACK END 
		/////////////////////////////////////////////////// ADD BOOKING ESTIMATE START
		 $estimate = $this->Bookings->add_booking_estimate_data($booking_id);  
		/////////////////////////////////////////////////// ADD BOOKING ESTIMATE END  
		/////////////////////////////////////////////////// ADD BOOKING ESTIMATE DETAILS START
		 $estimate_details  = $this->Bookings->add_booking_estimate_details_data($booking_id, $estimate);  
		/////////////////////////////////////////////////// ADD BOOKING ESTIMATE DETAILS END 
		/////////////////////////////////////////////////// ADD BOOKING ESTIMATE DETAILS START
		 $booking_payments = $this->Bookings->add_booking_payments($booking_id, $customer_data['customer_id']);  
		/////////////////////////////////////////////////// ADD BOOKING ESTIMATE DETAILS END 
         /////////////////////////////////////////////////// ADD BOOKING ESTIMATE DETAILS START
		 $booking_service = $this->Bookings->add_bookings_service($booking_id, $customer_data['customer_id'],  $customer_data['customer_vehicle']);  
		/////////////////////////////////////////////////// ADD BOOKING ESTIMATE DETAILS END
		 extract($_POST); 
		 $mail_data = array( 'booking_id' => $booking_id, 'Spares_List' => $estimate_details['Spares_List'], 'Labour_List' => $estimate_details['Labour_List']);
		 $send_email = $this->mailer->mail_template($email,'new-booking',$mail_data, 'emailer/new_bookings.php'); 
		 $service_category_name = $this->Common->single_row('service_category', array('id'=>$service_category)); 
		 $sms_data = array( 'service_category' => $service_category_name->service_name, 'time_slot' => $time_slot, 'service_date'=>$service_date); 
		 $send_sms = $this->sms->sms_template(array($mobile),'new-booking',$sms_data); 
        // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'booking_id' => $booking_id
                ],
            ],
        200);
    }
	
	
	
	public function get_booking()
    {
        header("Access-Control-Allow-Origin: *");

		// API Configuration
        $this->_apiConfig([
            'methods' => ['POST'], // 'GET', 'OPTIONS'
            'limit' => [5, 'ip', 'everyday'],
			'key' => ['header'], // type, {key}|table (by default)
        ]);
		 extract($_POST); 
		$bookingdata = $this->Bookings->getbooking($booking_id);  
		$data['booking_id'] = $booking_id;   
		$data['booking']  = $bookingdata['booking'];
		
		
		$booking_data = array(  
			
				"booking_id" => $data['booking']->booking_id, 
                "customer_id" => $data['booking']->customer_id,
                "customer_name" => $data['booking']->customer_name,
                "customer_email" => $data['booking']->customer_email,
                "customer_mobile" => $data['booking']->customer_mobile, 
                "customer_address" => $data['booking']->customer_address,
                "customer_city" => $data['booking']->customer_city,
                "customer_area" => $data['booking']->customer_area,
                "customer_pincode" => $data['booking']->customer_pincode,
                "customer_google_map" => $data['booking']->customer_google_map,
                "customer_lat" => $data['booking']->customer_lat,
                "customer_long" => $data['booking']->customer_long,
                "customer_channel" => $data['booking']->customer_channel,  
                "vehicle_make" => get_make($data['booking']->vehicle_make),  
                "vehicle_model" => get_model($data['booking']->vehicle_model),  
                "vehicle_regno" => $data['booking']->vehicle_regno,  
                "vehicle_yom" => $data['booking']->vehicle_yom,  
                "vehicle_km_reading" => $data['booking']->vehicle_km_reading,  
                "service_category" => get_service_category($data['booking']->service_category_id),  
                "time_slot" => $data['booking']->time_slot,
                "service_date" => convert_date($data['booking']->service_date),
                "complaints" => $data['booking']->complaints,  
                "booking_status" => $data['booking']->stage,     
                "created_on" => convert_date($data['booking']->created_on),  
		);
		
		
		 
        // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'data' => $booking_data
                ],
            ],
        200);
    }
	
	
	
	
}