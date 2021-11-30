<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class Siteapi extends API_Controller
{
    public function __construct() {
        parent::__construct();
		 $this->load->model('Api_model');
		 $this->load->model('Bookings_model', 'Bookings'); 
		 $this->load->model('Siteapi_model', 'Site'); 
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
			//'key' => ['table'], // type, {key}|table (by default)
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
		
        return '1234_2806';
    }


	public function getmakemodel(){
		 header("Access-Control-Allow-Origin: *");
        // API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5000, 'ip', 'everyday'],
					//'key' => ['table'], // type, {key}|table (by default)
				]);
				 extract($_POST); 
		
		$response = [];
		  
		
		 $make_name  = get_make($vehicle_make);
		 
		$model_name  = get_model($vehicle_model);  
		
		$data['makename'] = $make_name;
		$data['modelname'] =  $model_name;  
		
		if(empty($data)){ 
		  				$this->api_return(
							[
								'status' => false,
								"result" => [ 
									'data' => $data,  
									'message' => 'No Make Found',
								],

							],
						200);	 
		 }else{    
		 
						// return data
						$this->api_return(
							[
								'status' => true,
								"result" => [
									'data' => $data,  
									'message' => 'Make found successfully!',
								],

							],
						200); 
						  
		}
	}
	
	
	public function get_model_details(){
		header("Access-Control-Allow-Origin: *");
        // API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5000, 'ip', 'everyday'],
					//'key' => ['table'], // type, {key}|table (by default)
				]);
				 extract($_POST); 
		
		$response = [];
		  
		if(!empty($vehicle_model))
		 $model_det  = get_model($vehicle_model,TRUE);  
		else 
		 $model_det  = get_model($model_id,TRUE);
		
		$data['modelcode'] = $model_det->model_code;
		$data['vehiclecategory'] =  $model_det->vehicle_category;  
		
		if(empty($data)){ 
		  				$this->api_return(
							[
								'status' => false,
								"result" => [ 
									'data' => $data,  
									'message' => 'No Make Found',
								],

							],
						200);	 
		 }else{    
		 
						// return data
						$this->api_return(
							[
								'status' => true,
								"result" => [
									'data' => $data,  
									'message' => 'Make found successfully!',
								],

							],
						200); 
						  
		}
	}
	
	 
	public function get_make_model_names(){
		header("Access-Control-Allow-Origin: *");
        // API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5000, 'ip', 'everyday'],
					//'key' => ['table'], // type, {key}|table (by default)
				]);
				 extract($_POST); 
		
		$response = [];
		  
		 
		 $make_det  = get_make($make_id);  
		 
		 $model_det  = get_model($model_id,TRUE);
		
		
		$data['make_name'] = $make_det;
		$data['model_name'] = $model_det->model_name; 
		$data['modelcode'] = $model_det->model_code;
		$data['vehiclecategory'] =  $model_det->vehicle_category;  
		
		if(empty($data)){ 
		  				$this->api_return(
							[
								'status' => false,
								"result" => [ 
									'data' => $data,  
									'message' => 'No Make Found',
								],

							],
						200);	 
		 }else{    
		 
						// return data
						$this->api_return(
							[
								'status' => true,
								"result" => $data,

							],
						200); 
						  
		}
	}
	
	public function get_all_coupons(){
		
		header("Access-Control-Allow-Origin: *");
        // API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5000, 'ip', 'everyday'],
					//'key' => ['table'], // type, {key}|table (by default)
				]);
		
		extract($_POST); 
		
		$response = [];
		 
		$customer_city =     strtolower($this->input->post('location')); 
		$getcustomer = $this->Site->customer_existance(); 
				 
				
		
		
		$model  = get_model($vehicle_model,TRUE);  
		$data['modelcode'] = $model->model_code;
		$vehicle_category =  $model->vehicle_category;  
		 
		if($service_category=='Running Repairs'){
			$service_category = 'Repairs';
		} 
		 
		$coupon_details['mobile']=$mobile; 
		$coupon_details['customer_type'] = $getcustomer['customer_type'];
		$coupon_details['customer_id'] = $getcustomer['customer_id'];
		$coupon_details['zone']=$zone;
		$coupon_details['make']=$vehicle_make;
		$coupon_details['model']=$model->model_code;
		$coupon_details['vehicle_category']=$vehicle_category ;
		$coupon_details['service_category']=$service_category;
		
		$this->load->library('payments');
		$all_coupons = $this->payments->get_all_coupons($coupon_details);
		 
		 
		if(empty($all_coupons)){ 
		  				$this->api_return(
							[
								'status' => false,
								"result" => [ 
									'data' => null,  
									'message' => 'No Coupons Found',
								],

							],
						200);	 
		 }else{    
		 
						// return data
						$this->api_return(
							[
								'status' => true,
								"result" => [
									'data' => $all_coupons,  
									'message' => 'Coupons Available!',
								],

							],
						200); 
						  
		}
		
	}
	
	public function verify_coupon(){
		header("Access-Control-Allow-Origin: *");
        // API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5000, 'ip', 'everyday'],
					//'key' => ['table'], // type, {key}|table (by default)
				]);
				 extract($_POST); 
		
		$response = [];
		  
		 
		 $make_det  = get_make($make_id);  
		 
		 $model_det  = get_model($model_id,TRUE);
		  
		$coupon_details['coupon_code'] = $coupon_code;
		$coupon_details['mobile'] = $mobile;
		$coupon_details['customer_type'] = $customer_type;  
		$coupon_details['zone'] = $zone;
		$coupon_details['make'] = $make;
		$coupon_details['model'] = $model; 
		$coupon_details['vehicle_category'] =  $model_det->vehicle_category;
		$coupon_details['service_category'] =  $service_category;   
		
		
		
		$this->load->library('payments');
		$coupon_data = $this->payments->calculate_coupon($coupon_details, 'cart');
		
		
		if(empty($data)){ 
		  				$this->api_return(
							[
								'status' => false,
								"result" => [ 
									'data' => $coupon_data,  
									'message' => 'No Make Found',
								],

							],
						200);	 
		 }else{    
		 
						// return data
						$this->api_return(
							[
								'status' => true,
								"result" => null,

							],
						200); 
						  
		}
	}
	
	
	
	public function get_category_price_site(){
		
		header("Access-Control-Allow-Origin: *");
        // API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5000, 'ip', 'everyday'],
					//'key' => ['table'], // type, {key}|table (by default)
				]);
		
		$response = [];
		$vehicle_make =     $this->input->post('vehicle_make');
		$vehicle_model =     $this->input->post('vehicle_model');
		$service_category =     $this->input->post('service_category');
		$customer_city =     strtolower($this->input->post('location'));
		
		
		$model  = get_model($vehicle_model,TRUE);  
		$data['modelcode'] = $model->model_code;
		$vehicle_category =  $model->vehicle_category;  
		
		
		 
		
		if($service_category=='Running Repairs'){
			$service_category = 'Repairs';
		} 
		
		if(!empty($service_category) && $service_category != 'NA'){ 
		$service_rates  = $this->Common->single_row('service_category', array("service_name"=>$service_category, "vehicle_category"=>$vehicle_category, "active"=>1));
		 
		
		if(!empty($service_rates) && !empty($service_rates->$customer_city)){
			$servicePrice = $service_rates->$customer_city;
		}else{
			$servicePrice = 'NA';
		}  
		
		 
		}
		 
		$this->load->library('payments');
		$booking_fee = $this->payments->calculate_booking_fee($service_category, $customer_city);
		 
		$response['booking_fee'] = $booking_fee['booking_fee'];
		$response['serviceprice'] = $servicePrice; 
		$response['service_category_id'] = $service_rates->id;
		if(empty($data)){ 
		  				$this->api_return(
							[
								'status' => false,
								"result" => [ 
									'data' => $response,  
									'message' => 'No Pricing Details Found',
								],

							],
						200);	 
		 }else{    
		 
						// return data
						$this->api_return(
							[
								'status' => true,
								"result" => [
									'data' => $response,  
									'message' => 'Pricing Details found successfully!',
								],

							],
						200); 
						  
		}
		
	}
	
	
 	
	public function customer_existance(){
		 header("Access-Control-Allow-Origin: *");
        // API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5000, 'ip', 'everyday'],
					//'key' => ['table'], // type, {key}|table (by default)
				]);
				 extract($_POST); 
		
		 
		  
		
		  $data = $this->Site->customer_existance();
		
		if(empty($data)){ 
		  				$this->api_return(
							[
								'status' => false,
								"result" => [ 
									'data' => $data,  
									'message' => 'No Make Found',
								],

							],
						200);	 
		 }else{    
		 
						// return data
						$this->api_return(
							[
								'status' => true,
								"result" => [
									'data' => $data,  
									'message' => 'Make found successfully!',
								],

							],
						200); 
						  
		}
	}
	
	
	public function save_lead(){
				
				 header("Access-Control-Allow-Origin: *");

				// API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5000, 'ip', 'everyday'],
					//'key' => ['table'], // type, {key}|table (by default)
				]);
				 extract($_POST); 
				
				 
		
				 $getcustomer = $this->Site->customer_existance();
		
				$customer_id = $getcustomer['customer_id'];
				 
				$payload = [
				'id' => $customer_id,
				'mobile' => $mobile
        		];
				$this->load->library('authorization_token');	
				$token = $this->authorization_token->generateToken($payload);  
				 
				$otp_name = $getcustomer['name']; 
				
				 
				$send_otp['otp'] = 'not_needed';
		
				$_POST['otp'] = $send_otp['otp'];
				$_POST['customer_type'] = $getcustomer['customer_type'];
		
				$_POST['customer_id'] = $getcustomer['customer_id'];
				 
			
				$sitebooking_record = $this->Site->check_sitebooking($getcustomer['customer_type'],$getcustomer['channel'],$send_otp['otp']);
					
					$response['OTP_SEND'] = '';
					$response['status'] = 'Failed';
					$response['mobile'] = $mobile; 
					$response['message'] = 'Invalid Mobile Number'; 
		
						 
							
						$otp_data = array(   
				"token" => $token, 
                "mobile" => $mobile,
				"site_booking_id" => $sitebooking_record['site_booking_id'],
				"leads_id" => $sitebooking_record['leads_id'],
				"customer_id" => $getcustomer['customer_id']	
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
						 
			 
				 
	}
	
	
    public function sendotp(){
				
				 header("Access-Control-Allow-Origin: *");

				// API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5000, 'ip', 'everyday'],
					//'key' => ['table'], // type, {key}|table (by default)
				]);
				 extract($_POST); 
				
				 
		
				 $getcustomer = $this->Site->customer_existance();
		
				$customer_id = $getcustomer['customer_id'];
				 
				$payload = [
				'id' => $customer_id,
				'mobile' => $mobile
        		];
				$this->load->library('authorization_token');	
				$token = $this->authorization_token->generateToken($payload);  
				 
				$otp_name = $getcustomer['name']; 
				
				$send_otp = send_otp_customer($mobile, $otp_name, $token, $customer_id);
				 if(!empty($email)){ 
				$mail_data = array( 'customer_email' => $email, 'otp' => $send_otp['otp'], 'customer_name' => $name);
		 		$send_email = $this->mailer->mail_template($email,'customer-otp',$mail_data, 'emailer/customer_otp.php');
				 }
		
				$_POST['otp'] = $send_otp['otp'];
				$_POST['customer_type'] = $getcustomer['customer_type'];
		
				$_POST['customer_id'] = $getcustomer['customer_id'];
				 
			
				$sitebooking_record = $this->Site->check_sitebooking($getcustomer['customer_type'],$getcustomer['channel'],$send_otp['otp']);
					
					$response['OTP_SEND'] = '';
					$response['status'] = 'Failed';
					$response['mobile'] = $mobile; 
					$response['message'] = 'Invalid Mobile Number'; 
		
						if(!empty($send_otp)){   
						// return data
							
						$otp_data = array(   
				"token" => $token, 
                "mobile" => $mobile,
				"site_booking_id" => $sitebooking_record['site_booking_id'],
				"leads_id" => $sitebooking_record['leads_id'],
				"customer_id" => $getcustomer['customer_id']	
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
                			"mobile" => $mobile,
							"site_booking_id" => 0,
							"leads_id" => 0,
							"customer_id" => $getcustomer['customer_id']
							);
							$this->api_return(
							[
								'status' => false,
								"result" => [ 
									'data' => $otp_data,
									'message' => 'Error Sending OTP!',
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
					//'key' => ['table'], // type, {key}|table (by default)
				]);
				 extract($_POST); 
		
					 if(!empty($verify_otp) && $verify_otp=='skip'){ 
				 $responses_data =  true;
					 }else{
				$responses_data = verify_otp_customer($mobile, $otp, $token, $customer_id);		 
					 }
		
				if($responses_data) { 
					$success = 1;	 
				} else {
					$success = 0; 
				}	
		
				if($success==1){
				$response['otp_expired'] = 1;
				$otp_expired = 1;	
				$status = 'OTP Verified';	
				
				if(!empty($complaints))
				$all_selected_complaints =	implode('+',$complaints);
		 
				$_POST['selected_complaints'] = $all_selected_complaints;
		
				$_POST['service_date'] = convert_date($service_date);
				//$response['site_booking_record']=$this->update_sitebooking_data($otp_expired, $status);
		
				$response['site_booking_convert_record']= $this->Site->update_sitebooking_data($otp_expired, $status);
		
				//$response['lead_record']=$this->Site->update_leads_data($otp_expired, $status);	
				}else{
				$response['otp_expired'] = 0;
				$otp_expired = 0;	
				$status = 'OTP Not Verified';	
				}
		
				if($success==1){   
						// return data
						$this->api_return(
							[
								'status' => true,
								"result" => [
									'data' => $response,  
									'message' => $status,
								],

							],
						200); 
						 }else{ 
							$this->api_return(
							[
								'status' => false,
								"result" => [ 
									'data' => $response,  
									'message' => $status,
								],

							],
						200);
						}
		  }
	
	 
	public function add_future_lead()
    {
		
				header("Access-Control-Allow-Origin: *");
        // API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5000, 'ip', 'everyday'],
					//'key' => ['table'], // type, {key}|table (by default)
				]);
				 extract($_POST); 
		
					 
				  
		
				$success= $this->Site->add_lead_future();
		
				 
		
				if($success>0){  
					
					
					$mail_data = array( 'name' => $name,  'mobile' => $mobile, 'city' => $city);
		 	$send_email = $this->mailer->mail_template('info@garageworks.in','new-lead',$mail_data, 'custom');
					
						// return data
						$this->api_return(
							[
								'status' => true,
								"result" => [
									'data' => 1,  
									'message' => $success,
								],

							],
						200); 
						 }else{ 
							$this->api_return(
							[
								'status' => false,
								"result" => [ 
									'data' => 0,  
									'message' => 'Error',
								],

							],
						200);
						}
		  }
	
	
	public function checkform(){
		
		print_r($_POST);
		
	}
	
	
	public function get_city_dropdown()
    {
		
		 header("Access-Control-Allow-Origin: *");
        // API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5000, 'ip', 'everyday'],
					//'key' => ['table'], // type, {key}|table (by default)
				]);
				 extract($_POST); 
		
		$data  = city_dropdown();  
		
		if(empty($data)){ 
		  				$this->api_return(
							[
								'status' => false,
								"result" => [ 
									'data' => $data,  
									'message' => 'No City Found',
								],

							],
						200);	 
		 }else{    
		 
						// return data
						$this->api_return(
							[
								'status' => true,
								"result" => [
									'data' => $data,  
									'message' => 'Cities found successfully!',
								],

							],
						200); 
						  
		}
    }
	
	
	public function get_area_dropdown()
    {
		
		 header("Access-Control-Allow-Origin: *");
        // API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5000, 'ip', 'everyday'],
					//'key' => ['table'], // type, {key}|table (by default)
				]);
				 extract($_POST); 
		
		if(empty($city)){ 
		  				$this->api_return(
							[
								'status' => false,
								"result" => [ 
									'data' => $data,  
									'message' => 'No Area Found',
								],

							],
						200);	 
		 }else{  
		
		$data  = area_dropdown(array('city'=>$city));  
		
		if(empty($data)){ 
		  				$this->api_return(
							[
								'status' => false,
								"result" => [ 
									'data' => $data,  
									'message' => 'No Area Found',
								],

							],
						200);	 
		 }else{    
		 
						// return data
						$this->api_return(
							[
								'status' => true,
								"result" => [
									'data' => $data,  
									'message' => 'Areas found successfully!',
								],

							],
						200); 
						  
		}
			
		}
    }
	
	
	public function get_make_dropdown()
    {
		
		 header("Access-Control-Allow-Origin: *");  
		header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Length, Content-Type, Access-Control-Allow-Origin'); 
		header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
		header("Content-length: 17777");
        // API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5000, 'ip', 'everyday'],
					//'key' => ['table'], // type, {key}|table (by default)
				]);
				 extract($_POST); 
		
		$data  = $this->Common->make_dropdown();  
		
		if(empty($data)){ 
		  				$this->api_return(
							[
								'status' => false,
								"result" => [ 
									'data' => $data,  
									'message' => 'No Make Found',
								],

							],
						200);	 
		 }else{    
		 
						// return data
						$this->api_return(
							[
								'status' => true,
								"result" => [
									'data' => $data,  
									'message' => 'Make found successfully!',
								],

							],
						200); 
						  
		}
    }
	
	
	public function get_model_dropdown()
    {
		
		 header("Access-Control-Allow-Origin: *");
        // API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5000, 'ip', 'everyday'],
					//'key' => ['table'], // type, {key}|table (by default)
				]);
				 extract($_POST); 
		
		if(empty($vehicle_make)){ 
		  				$this->api_return(
							[
								'status' => false,
								"result" => [ 
									'data' => null,  
									'message' => 'No Model Found',
								],

							],
						200);	 
		 }else{  
		
		$data  = $this->Common->model_dropdown($vehicle_make);  
		
		if(empty($data)){ 
		  				$this->api_return(
							[
								'status' => false,
								"result" => [ 
									'data' => $data,  
									'message' => 'No Model Found',
								],

							],
						200);	 
		 }else{    
		 
						// return data
						$this->api_return(
							[
								'status' => true,
								"result" => [
									'data' => $data,  
									'message' => 'Models found successfully!',
								],

							],
						200); 
						  
		}
			
		}
    }
	
	
	public function get_category_price(){
		
		header("Access-Control-Allow-Origin: *");
        // API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5000, 'ip', 'everyday'],
					//'key' => ['table'], // type, {key}|table (by default)
				]);
				 extract($_POST); 
		
		
		
		$response = [];
		$vehicle_make =     $this->input->post('vehicle_make');
		$vehicle_model =     $this->input->post('vehicle_model');
		$customer_city =     strtolower($this->input->post('location'));
		
		
		$model  = get_model($vehicle_model,TRUE);  
		$data['modelcode'] = $model->model_code;
		$vehicle_category =  $model->vehicle_category;  
		 
		
		$premiumrates  = $this->Common->single_row('service_category', array('service_name'=>'Premium Service', 'vehicle_category'=>$vehicle_category , 'active'=>1));
		//$this->db->query("SELECT $customer_city AS rate FROM service_category WHERE service_name = 'Premium Service' AND  vehicle_category = '$vehicle_category' AND active=1")->row();
		
		$comprehensiverates  = $this->Common->single_row('service_category', array('service_name'=>'Comprehensive Service', 'vehicle_category'=>$vehicle_category , 'active'=>1));
		//$this->db->query("SELECT $customer_city AS rate FROM service_category WHERE service_name = 'Comprehensive Service' AND  vehicle_category = '$vehicle_category' AND active=1")->row();
		
		$standardrates  = $this->Common->single_row('service_category', array('service_name'=>'Standard Service', 'vehicle_category'=>$vehicle_category , 'active'=>1));
		//$this->db->query("SELECT $customer_city AS rate FROM service_category WHERE service_name = 'Std Service' AND  vehicle_category = '$vehicle_category' AND active=1")->row();
		
		if(!empty($premiumrates->$customer_city)){
			$premiumPrice = $premiumrates->$customer_city;
		}else{
			$premiumPrice = '';
		}
		if(!empty($comprehensiverates->$customer_city)){
			$comprehensivePrice = $comprehensiverates->$customer_city;
		}else{
			$comprehensivePrice = '';
		}
		if(!empty($standardrates->$customer_city)){
			$standardPrice = $standardrates->$customer_city;
		}else{
			$standardPrice = '';
		}
		$response['premimum_price'] = $premiumPrice;
		$response['comprehensive_price'] =  $comprehensivePrice;
		$response['standard_price'] =  $standardPrice;
		
						// return data
						$this->api_return(
							[
								'status' => true,
								"result" => [
									'data' => $response,  
									'message' => 'Pricing found successfully!',
								],

							],
						200); 
						  
		
		 
	}
	
	
	public function getMobilPrice(){
		$response = [];
		$vehicle_make =     $this->input->post('vehicle_make');
		$vehicle_model =     $this->input->post('vehicle_model');
		$customer_city =     strtolower($this->input->post('location')); 
		
		$vehicle_make =     $this->input->post('vehicle_make');
		$vehicle_model =     $this->input->post('vehicle_model');
		$customer_city =     strtolower($this->input->post('location'));
		
		
		$model  = get_model($vehicle_model,TRUE);  
		$data['modelcode'] = $model->model_code;
		$vehicle_category =  $model->vehicle_category;  
		 
		
		$superrates  = $this->db->query("SELECT $customer_city AS rate FROM service_category WHERE service_name = 'Mobil Super' AND  vehicle_category = '$vehicle_category'")->row();
		
		$onerates  = $this->db->query("SELECT $customer_city AS rate FROM service_category WHERE service_name = 'Mobil 1' AND  vehicle_category = '$vehicle_category'")->row();
		
		 
		
		if(!empty($superrates->rate)){
			$superPrice = $superrates->rate;
		}else{
			$superPrice = '';
		}
		if(!empty($onerates->rate)){
			$onePrice = $onerates->rate;
		}else{
			$onePrice = '';
		} 
		$response['super_price'] = $superPrice;
		$response['one_price'] =  $onePrice; 
		echo json_encode($response);
	}
	
	
	public function send_inquiry(){
		
		 header("Access-Control-Allow-Origin: *");
        // API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5000, 'ip', 'everyday'],
					//'key' => ['table'], // type, {key}|table (by default)
				]);
				 extract($_POST); 
		
		 
			
			$mail_data = array( 'name' => $name, 'email' => $email, 'mobile' => $mobile, 'purpose' => $purpose, 'message' => $message);
		 	$send_email = $this->mailer->mail_template('info@garageworks.in','website-inquiry',$mail_data, 'custom');
		
		if($send_email){   
						// return data
						$this->api_return(
							[
								'status' => true,
								"result" => [ 
									'message' => 'Inquiry sent successfully!',
								],

							],
						200); 
						 }else{ 
							$this->api_return(
							[
								'status' => false,
								"result" => [  
									'message' => 'Error sending inquiry!',
								],

							],
						200);
						}
	}
	
	
	public function reopen(){
		
		$complaints_id = $this->uri->segment(3); 
		
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
            $this->Main_model->update_record('customer_complaints', $data, $where);
		
		 $complaintstatus  = $this->db->query("SELECT * FROM customer_complaints_lifecycle WHERE complaints_id='".$complaints_id."'")->row();
			  
		
			$data = array(
                'complaints_id' => $complaints_id, 
				'action' => $status,  
                'details' => $details, 
				'due_date' => date('Y-m-d', strtotime($due_date)),
				'status' => $status, 
				'assigned_to' => $assigned_to,
				'created_by' => 0,
				'created_on' => date('Y-m-d H:i:s'), 
            );
			
		
		if(!empty($complaintstatus->id)){ 
            $where = array('complaints_id' => $complaints_id);
            $this->Main_model->update_record('customer_complaints_lifecycle', $data, $where);
		}else{
			$this->Main_model->add_record('customer_complaints_lifecycle', $data);
		}
		
		
		
		$data = array(
                'complaints_id' => $complaints_id, 
				'action' => $status,  
                'details' => $details, 
				'due_date' => date('Y-m-d', strtotime($due_date)),
				'status' => $status, 
				'assigned_to' => $assigned_to,
				'created_by' => 0,
				'created_on' => date('Y-m-d H:i:s'), 
            );
			 
		if(!empty($this->input->post("revisit_booking_id"))){
			$data['follow_booking_id'] = $this->input->post("revisit_booking_id");
		}
		
			$this->Main_model->add_record('customer_complaints_track', $data);
		 
		 
			     
                 redirect('https://garageworks.in/complaint_reopened.php');
		
	}
	
 
}