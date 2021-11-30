<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class Offersapi extends API_Controller
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

		public function validate_model(){
		
			header("Access-Control-Allow-Origin: *");

                  // API Configuration
                  $this->_apiConfig([
                      'methods' => ['POST'], // 'GET', 'OPTIONS'
                      'limit' => [5000, 'ip', 'everyday'],
                      //'key' => ['table'], // type, {key}|table (by default)
                  ]);
				 extract($_POST);  
			 
        $model = get_model($vehicle_model, TRUE);
        if(!empty($model->vehicle_category)){ 
         
			$valid_model = $this->Common->single_row('service_category', array('service_name'=>$service_category, 'vehicle_category'=>$model->vehicle_category),'active');
			
         	if(!empty($valid_model) && $valid_model>0){  
            
			$this->api_return(
              [
              'status' => true,
              "result" => [ 
              'data' => '1',
              'message' => 'Vehicle category applicable',
              ],
              ],
              200);
			}else{
				$this->api_return(
              [
              'status' => false,
              "result" => [ 
              'data' => '0',
              'message' => 'Vehicle category not applicable',
              ],
              ],
              200);
			}
			
        }else{
           $this->api_return(
              [
              'status' => false,
              "result" => [ 
              'data' => '0',
              'message' => 'Vehicle category not applicable',
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
		
				$getguest = $this->guest_existance();
				$guest_id = $getguest['guest_id']; 
				$guest_name = $getguest['name']; 
				$verify_otp = $this->verify_otp_guest($mobile, $otp, $guest_id);		 
		   
		  
		  
                $response['mobile'] = $mobile;  
                if($verify_otp){  
							$otp_data = array(   
							"name" => $name, 
							"mobile" => $mobile,
							"code" => $getguest['code'], 
							"guest_id" => $getguest['guest_id'],
							"referral" => $getguest['referral'], 
							"total_votes_gained" => $getguest['total_votes_gained'],
							"total_ref_visited" => $getguest['total_ref_visited'],
							);
					  $this->api_return(
					  [
					  'status' => true,
					  "result" => [ 
					  'data' => $otp_data,
					  'message' => 'OTP verified successfully for '.$mobile,
					  ],
					  ],
					  200); 
               }else{
								  $otp_data = array(    
								  "name" => $name, 
								  "mobile" => $mobile,
								  "code" => '', 
								  "guest_id" => ''	
								  );
					  $this->api_return(
					  [
					  'status' => false,
					  "result" => [ 
					  'data' => $otp_data,
					  'message' => 'Invalid OTP!',
					  ],
					  ],
					  200);
              }
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
				$getguest = $this->guest_existance();
				$guest_id = $getguest['guest_id']; 
				$guest_name = $getguest['name']; 
				$send_otp = $this->send_otp_guest($mobile, $guest_name, $guest_id);
				 
                $response['mobile'] = $mobile;  
                if(!empty($send_otp)){  
                $otp_data = array(   
                "name" => $name, 
                "mobile" => $mobile,
                "code" => $getguest['code'], 
                "guest_id" => $getguest['guest_id'],
				"referral" => $getguest['referral'],	
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
              "name" => $name, 
              "mobile" => $mobile,
              "code" => '', 
              "guest_id" => ''	
              );
              $this->api_return(
              [
              'status' => false,
              "result" => [ 
              'data' => $otp_data,
              'message' => 'Invalid Mobile Number!',
              ],
              ],
              200);
              }
              }
	
 		
                public function guest_existance()
                {
                extract($_POST); 
                $data = []; 
				$slugname = make_slug(preg_replace('/\s+/', '', $name));		
                $guest = $this->get_guest(array('mobile'=>$mobile));    
                if($guest){ 
                $data['guest_id']=$guest->guest_id;	
                $referrals = $this->get_guest_referral(array('guest_id'=>$guest->guest_id)); 
				$total_refs = 	$this->get_guest_total_votes($guest->guest_id); 
						if(!empty($referrals))
								foreach($referrals as $referral){    
								$guest_referral[] = array( 
								'guest_id' => $referral->guest_id,
								'name' => $referral->name,
								'mobile' => $referral->mobile,
								'email' => $referral->email,
								'otp' => $referral->otp,
								'vote' => $referral->voted,
								'active'	=> $referral->active,
								'created_on' => $referral->created_on,	
								);	  
						}
                $data['name'] = $guest->name;
                $data['mobile'] =  $guest->mobile;
                $data['alternate_no'] =  $guest->alternate_no;
                $data['email'] =  $guest->email;
                $data['code'] = $guest->code;
                $data['guest_type'] = 'old';	
                $data['referral'] = @$guest_referral;
				$data['total_votes_gained'] = $total_refs['total_votes'];
				$data['total_ref_visited'] = $total_refs['total_ref_visited'];	
                }else{
						$cust_info = array(
						'name'=> $name,
						'mobile' => $mobile, 
						'vehicle_make' => @$vehicle_make, 
						'vehicle_model' => @$vehicle_model, 
						'code' => substr($slugname, 0, 4).substr($mobile, -4),
						'guest_type' => 'new', 
						'created_on' => updated_on(),	
						);
					$this->Common->add_record('guest', $cust_info);
					$guest_id = $this->db->insert_id();			
					$data['guest_id']=$guest_id;  
					$data['name'] = $name;	
					$data['mobile'] =  $mobile;
					$data['guest_type'] = 'new';
					$data['code'] = substr($slugname, 0, 4).substr($mobile, -4);	
					$data['referral'] = '';	
					$data['total_votes_gained'] = 0;
					$data['total_ref_visited'] = 0;			
                } 
                return $data; 
                }


		function send_otp_guest($mobile, $name, $guest_id){
        $otp = rand(1000, 9999);
        $sms_data = array('otp' => $otp); 
        $send_sms = $this->sms->sms_template(array($mobile),'send-otp',$sms_data);
        if(!empty($send_sms)){ 
        $data = array(
		'guest_id' => $guest_id,	
        'name' => $name,		
        'mobile' => $mobile, 
        'otp' => $otp,  	
        'is_expired' => '0', 
        'create_at' => date("Y-m-d H:i:s"),
        ); 
		 
        $this->Common->add_record('guest_otp', $data); 
        $response['otp'] = $otp;
        $response['mobile'] = $mobile; 
            return $response;
        }else{
            return false;
        } 
		}
	
		function verify_otp_guest($mobile, $otp, $guest_id){ 
        $this->db->select();	
        $this->db->from('guest_otp'); 
        $this->db->where(array('otp'=>$otp, 'mobile'=>$mobile,  'is_expired' => 0, 'guest_id'=>$guest_id));  
        $this->db->where('NOW() <= DATE_ADD(create_at, INTERVAL 24 HOUR)'); 
        $query = $this->db->get(); 
        if($query->num_rows() > 0) {   
        $result =  $query->row();  
        $data = array(
        'is_expired' => 1,
        );
        $where = array('id' => $result->id);
        $this->Common->update_record('guest_otp', $data, $where);
        return true;
        }else{
        return false;
        } 
		}
	 

	
		 
	
	
	function get_guest($where, $select=NULL)
        { 
             
			if($select)
            $this->db->select($select);
			else
			$this->db->select();	
        	$this->db->from('guest');  
        	$this->db->where($where); 
		    $query = $this->db->get(); 
			if($query->num_rows() > 0) {   
				$result =  $query->row(); 
				if($select)
				$response =  $result->$select;
				else
				$response =  $query->row();	 
				if(!empty($response)){
					return $response;
				}else{
					return false;
				} 
			}else{
				return false;  
			}
        }
	
	function get_guest_referral($where, $select=NULL)
        { 
             
			if($select)
            $this->db->select($select);
			else
			$this->db->select();	
        	$this->db->from('referral');  
        	$this->db->where($where); 
		    $query = $this->db->get(); 
			if($query->num_rows() > 0) {   
				$result =  $query->result(); 
				if($select)
				$response =  $result[0]->$select;
				else
				$response =  $query->result();	 
				if(!empty($response)){
					return $response;
				}else{
					return false;
				} 
			}else{
				return false;  
			}
        }
	
	function get_guest_total_votes($guest_id)
        { 
			
			$where = array('guest_id'=>$guest_id);
		
			$this->db->select();	
        	$this->db->from('referral');  
        	$this->db->where($where); 
		    $query = $this->db->get(); 
		 	$data['total_ref_visited'] =  $query->num_rows();
			
			$where2 = array('guest_id'=>$guest_id, 'voted'=>1);
			$this->db->select();	
        	$this->db->from('referral');  
        	$this->db->where($where); 
		    $query = $this->db->get(); 
		 	$data['total_votes'] =  $query->num_rows();
		
			return $data;
			 
        }
	
	
	
	
	  public function vote_sendotp(){
				
				 header("Access-Control-Allow-Origin: *");

                  // API Configuration
                  $this->_apiConfig([
                      'methods' => ['POST'], // 'GET', 'OPTIONS'
                      'limit' => [5000, 'ip', 'everyday'],
                      //'key' => ['table'], // type, {key}|table (by default)
                  ]);
				 extract($_POST);  
				  
		  	$alreadyvoted = $this->Common->single_row('referral',array('mobile'=>$mobile, 'guest_id'=>$guest_id),'id');
		  	if(!empty($alreadyvoted) && $alreadyvoted>0){ 
		  	 $this->api_return(
              [
              'status' => true,
              "result" => [ 
			  'existed' => 1,		  
              'data' => $alreadyvoted,
              'message' => 'You have already voted!',
              ],
              ],
              200);
			}else{ 
		  
				$send_otp = $this->send_otp_referral($mobile, $name, $guest_id);
				 
                $response['mobile'] = $mobile;  
                if(!empty($send_otp)){  
					
                $otp_data = array(   
                "name" => $name, 
                "mobile" => $mobile,   
                "referral_id" => $send_otp['referral_id'], 	
                );
              $this->api_return(
              [
              'status' => true,
              "result" => [ 
			  'existed' => 0,	  
              'data' => $otp_data,
              'message' => 'OTP sent successfully on '.$mobile,
              ],
              ],
              200); 
               }else{
              $otp_data = array(    
              "name" => $name, 
                "mobile" => $mobile,   
                "referral_id" => '', 		
              );
              $this->api_return(
              [
              'status' => false,
              "result" => [ 
			  'existed' => 0,		  
              'data' => $otp_data,
              'message' => 'Invalid Mobile Number!',
              ],
              ],
              200);
              }
		  
		  
	  }
	
              }
	
 		
                public function check_guest()
                {
                header("Access-Control-Allow-Origin: *");
        // API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5000, 'ip', 'everyday'],
					//'key' => ['table'], // type, {key}|table (by default)
				]);
				 extract($_POST); 
                $data = []; 
                $guest = $this->get_guest(array('code'=>$guest_code));    
                if($guest){ 
				 $data['guest_id']=$guest->guest_id;
				 $data['guest_name']=$guest->name;
				 $data['guest_mobile']=$guest->mobile;
					$this->api_return(
					  [
					  'status' => true,
					  "result" => [ 
					  'data' => $data,
					  'message' => 'Reference found successfully for the code '.$guest_code,
					  ],
					  ],
					  200); 
					
                }else{
                 $data['guest_id']='';
				 $data['guest_name']='';
				 $data['guest_mobile']='';	
					$this->api_return(
					  [
					  'status' => false,
					  "result" => [ 
					  'data' => $data,
					  'message' => 'No record found for the code '.$guest_code,
					  ],
					  ],
					  200); 
                } 
                return $data; 
                }
	
				
	
	
				public function vote_verifyotp()
    			{
		
				header("Access-Control-Allow-Origin: *");
        // API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5000, 'ip', 'everyday'],
					//'key' => ['table'], // type, {key}|table (by default)
				]);
				 extract($_POST); 
		 
				$verify_otp = $this->verify_otp_referral($mobile, $otp, $guest_id, $referral_id);		 
		  
                $response['mobile'] = $mobile;  
                if($verify_otp){ 
					
					
					$data = array(
        'voted' => 1,
		'active' => 1,				
        );
        $where = array('id' => $referral_id, 'guest_id'=>$guest_id);
        $this->Common->update_record('referral', $data, $where);
					
					
							$otp_data = array(   
							"name" => $name, 
							"mobile" => $mobile,  
							"guest_id" => $guest_id, 	
							);
					  $this->api_return(
					  [
					  'status' => true,
					  "result" => [ 
					  'data' => $otp_data,
					  'message' => 'OTP verified successfully for '.$mobile,
					  ],
					  ],
					  200); 
               }else{
								  $otp_data = array(    
								  "name" => $name, 
								  "mobile" => $mobile, 
								  "guest_id" => ''	
								  );
					  $this->api_return(
					  [
					  'status' => false,
					  "result" => [ 
					  'data' => $otp_data,
					  'message' => 'Invalid OTP!',
					  ],
					  ],
					  200);
              }
		  }
	
	
	function send_otp_referral($mobile, $name, $guest_id){
        $otp = rand(1000, 9999);
        $sms_data = array('otp' => $otp); 
        $send_sms = $this->sms->sms_template(array($mobile),'send-otp',$sms_data);
        if(!empty($send_sms)){  
		$data = array(
        'name' => $name,
		'mobile' => $mobile, 
		'guest_id' => $guest_id,
		'otp' => $otp,
		'is_expired' => '0', 	
		'voted' => 0,				
		'active' => 1, 	
		'created_on' => updated_on(),	
        );
          $this->Common->add_record('referral', $data);
		$referral_id = $this->db->insert_id();			
		$response['referral_id'] = $referral_id;	
        $response['otp'] = $otp;
        $response['mobile'] = $mobile; 
            return $response;
        }else{
            return false;
        } 
		}
	
	function verify_otp_referral($mobile, $otp, $guest_id, $referral_id){ 
        $this->db->select();	
        $this->db->from('referral'); 
        $this->db->where(array('otp'=>$otp, 'mobile'=>$mobile,  'is_expired' => 0, 'guest_id'=>$guest_id, 'id'=>$referral_id));  
        $this->db->where('NOW() <= DATE_ADD(created_on, INTERVAL 24 HOUR)'); 
        $query = $this->db->get(); 
        if($query->num_rows() > 0) {   
        $result =  $query->row();  
        $data = array(
        'is_expired' => 1,
        );
        $where = array('id' => $referral_id);
        $this->Common->update_record('referral', $data, $where);
        return true;
        }else{
        return false;
        } 
		}
	
	
	public function refreshvotes()
    {
		
				header("Access-Control-Allow-Origin: *");
        // API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5000, 'ip', 'everyday'],
					//'key' => ['table'], // type, {key}|table (by default)
				]);
				 extract($_POST); 
		
				$getguest = $this->guest_existance();
				$guest_id = $getguest['guest_id']; 
				$guest_name = $getguest['name']; 
				   
		  
                $response['mobile'] = $mobile;  
                if(!empty($getguest['guest_id'])){  
							$otp_data = array(   
							"name" => $name, 
							"mobile" => $mobile,
							"code" => $getguest['code'], 
							"guest_id" => $getguest['guest_id'],
							"referral" => $getguest['referral'], 
							"total_votes_gained" => $getguest['total_votes_gained'],
							"total_ref_visited" => $getguest['total_ref_visited'],
							);
					  $this->api_return(
					  [
					  'status' => true,
					  "result" => [ 
					  'data' => $otp_data,
					  'message' => 'Votes refreshed '.$mobile,
					  ],
					  ],
					  200); 
               }else{
								  $otp_data = array(    
								  "name" => $name, 
								  "mobile" => $mobile,
								  "code" => '', 
								  "guest_id" => ''	
								  );
					  $this->api_return(
					  [
					  'status' => false,
					  "result" => [ 
					  'data' => $otp_data,
					  'message' => 'Error! refreshing votes',
					  ],
					  ],
					  200);
              }
		  }
	
 		function votesacheived(){ 
          
        header("Access-Control-Allow-Origin: *");
        // API Configuration
				$this->_apiConfig([
					'methods' => ['POST'], // 'GET', 'OPTIONS'
					'limit' => [5000, 'ip', 'everyday'],
					//'key' => ['table'], // type, {key}|table (by default)
				]);
				 extract($_POST); 
		 
			
				$data = array(
        'claimed' => 1,
        );
        $where = array('guest_id' => $guest_id);
        $this->Common->update_record('guest', $data, $where);
			
			
                if(!empty($guest_id)){  
							  
					  $this->api_return(
					  [
					  'status' => true,
					  "result" => [ 
					  'data' => $guest_id,
					  'message' => 'Offer claimed recorded',
					  ],
					  ],
					  200); 
               }else{
								   
					  $this->api_return(
					  [
					  'status' => false,
					  "result" => [ 
					  'data' => $guest_id,
					  'message' => 'Error! something went wrong',
					  ],
					  ],
					  200);
              }
			
		}
	
	
	 
	
	
	
}