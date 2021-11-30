<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('detect_agent')) {
	function detect_agent($select=FALSE)
        { 
  $ci =& get_instance(); 
  $data['device'] = $ci->agent->browser().'('.$ci->agent->version().')';
  $data['browser'] = $ci->agent->browser();		
  $data['browser_version'] = $ci->agent->version();
  $data['os'] = $ci->agent->platform();
  $data['ip'] = $ci->input->ip_address();
	if($select)	{ 
  return $data[$select];
	}else{
  return $data;
	}
		}
}

if(!function_exists('platform_agent')){
	function platform_agent(){
		$ci =& get_instance(); 
  $data['device'] = $ci->agent->browser().'('.$ci->agent->version().')';
  $data['browser'] = $ci->agent->browser();		
  $data['browser_version'] = $ci->agent->version();
  $data['os'] = $ci->agent->platform();
  $data['ip'] = $ci->input->ip_address();
		return 'Device: '.$data['device'] .' | OS: '.$data['os'].' | IP: '.$data['ip'];
	}
	
}
//check auth
    if (!function_exists('channel_dropdown')) {
        function channel_dropdown($select=FALSE)
        { 
            $ci =& get_instance();
            $ci->db->select();
        	$ci->db->from('channel');
		    $query = $ci->db->get(); 
			if($query->num_rows() > 0) { 
				$data = '<option value="">Select</option>';
				$result = $query->result();
				foreach($result as $channel){
					if($select && $select==$channel->channelname){
					$selected = 'selected';
					}else{
					$selected = '';
					}
				$data.='<option '.$selected.' value="'.$channel->channelname.'">'.$channel->channelname.'</option>';	
				}
				return $data;
			}else{
				return false;  
			}
        }
    }

 
    if (!function_exists('city_dropdown')) {
        function city_dropdown($selected=FALSE)
        { 
            $ci =& get_instance();
            $ci->db->select();
        	$ci->db->from('cities');
			$ci->db->where(array('active'=>1));
		    $query = $ci->db->get(); 
			if($query->num_rows() > 0) { 
				$data = '<option value="">Select</option>';
				$result = $query->result();
				foreach($result as $city){
					if($selected && $selected==$city->name){
					$selected_yes = 'selected';
					}else{
					$selected_yes = '';
					}
				$data.='<option '.$selected_yes.' value="'.$city->name.'">'.$city->name.'</option>';	
				}
				return $data;
			}else{
				return false;  
			}
        }
    }

 
    if (!function_exists('area_dropdown')) {
        function area_dropdown($where=FALSE, $selected=FALSE)
        { 
            $ci =& get_instance();
            $ci->db->select('area','pincode');
        	$ci->db->from('area');
			$ci->db->where(array('active'=>1));
			if($where)
        	$ci->db->where($where);
		    $query = $ci->db->get(); 
			if($query->num_rows() > 0) { 
				$data = '<option value="">Select</option>';
				$result = $query->result();
				foreach($result as $area){
					if($selected && $selected==$area->area){
					$selected_yes = 'selected';
					}else{
					$selected_yes = '';
					}
				$data.='<option data-pincode="'.$area->pincode.'" data-zone="'.$area->zone.'" '.$selected_yes.' value="'.$area->area.'">'.$area->area.'</option>';	
				}
				return $data;
			}else{
				return false;  
			}
        }
    }

	if (!function_exists('zone_dropdown')) {
        function zone_dropdown($where=FALSE, $selected=FALSE)
        { 
            $ci =& get_instance();
            $ci->db->select('zone');
        	$ci->db->from('area');
			if($where)
        	$ci->db->where($where); 
        	$ci->db->group_by('zone');
		    $query = $ci->db->get(); 
			if($query->num_rows() > 0) { 
				$data = '<option value="">Select</option>';
				$result = $query->result();
				foreach($result as $zone){
					if($selected && $selected==$zone->zone){
					$selected_yes = 'selected';
					}else{
					$selected_yes = '';
					}
				$data.='<option '.$selected_yes.' value="'.$zone->zone.'">'.$zone->zone.'</option>';	
				}
				return $data;
			}else{
				return false;  
			}
        }
    }

	


	if (!function_exists('service_category_dropdown')) {
        function service_category_dropdown($where=FALSE, $selected=FALSE, $city=FALSE)
        { 
            $ci =& get_instance();
            $ci->db->select();
        	$ci->db->from('service_category'); 
			$ci->db->where(array('active'=>1)); 
			if($where)
			$ci->db->where($where);  	
		    $query = $ci->db->get(); 
			if($query->num_rows() > 0) { 
				$data = '<option value="">Select</option>';
				$result = $query->result();
				foreach($result as $service_category){
					if($selected && $selected==$service_category->id){
					$selected_yes = 'selected';
					}else{
					$selected_yes = '';
					}
					
					if($city)
					$city_price = 'data-'.$city.'="'.$service_category->city.'"'; 
					else
					$city_price = '';
					
				$data.='<option '.$selected_yes.' '.$city_price.' value="'.$service_category->id.'">'.$service_category->service_name.'</option>';	
				}
				return $data;
			}else{
				return false;  
			}
        }
    }

	
	if (!function_exists('make_dropdown')) {
        function make_dropdown($select=FALSE)
        { 
            $ci =& get_instance();
            $ci->db->select();
        	$ci->db->from('vehicle_make'); 	
		    $query = $ci->db->get(); 
			if($query->num_rows() > 0) { 
				$data = '<option value="">Select</option>';
				$result = $query->result();
				foreach($result as $make){
					if($select && $select==$make->make_id){
					$selected = 'selected';
					}else{
					$selected = '';
					}
				$data.='<option '.$selected.' value="'.$make->make_id.'">'.$make->make_name.'</option>';	
				}
				return $data;
			}else{
				return false;  
			}
        }
    }


	if (!function_exists('model_dropdown')) {
        function model_dropdown($make_id=FALSE, $selected=FALSE)
        { 
			if($make_id){ 
            $ci =& get_instance();
            $ci->db->select();
        	$ci->db->from('vehicle_model'); 
			$ci->db->where(array('make_id'=>$make_id));  	
		    $query = $ci->db->get(); 
			if($query->num_rows() > 0) { 
				$data = '<option value="">Select</option>';
				$result = $query->result();
				foreach($result as $model){
					if($selected && $selected==$model->model_id){
					$selected_yes = 'selected';
					}else{
					$selected_yes = '';
					}
				$data.='<option '.$selected_yes.' data-modelcode="'.$model->model_code.'" data-vehiclecategory="'.$model->vehicle_category.'" value="'.$model->model_id.'">'.$model->model_name.'</option>';	
				}
				return $data;
			}else{
				return false;  
			}
			}else{
				return false;
			}
        }
    }



	if (!function_exists('get_all_gic')) {
        function get_all_gic($where=FALSE, $select=FALSE)
        { 
            $ci =& get_instance();
			if($select){ 
			$ci->db->select($select);
			}else{
            $ci->db->select();
			}
        	$ci->db->from('gic'); 
			if($where) 
        	$ci->db->where($where); 
			$ci->db->group_by('GIC_NAME');
		    $query = $ci->db->get(); 
			if($query->num_rows() > 0) {  
				return $query->result();   
			}else{
					return false;  
			}
        }
    }


//////////////// Dropdown Functions End

	
	if (!function_exists('get_all_services')) {
        function get_all_services($where=FALSE, $search=FALSE)
        { 
            $ci =& get_instance();
            $ci->db->select();
        	$ci->db->from('services'); 
        	$ci->db->where(array('active'=>1));
			if($where)
        	$ci->db->where($where);  
		    if($search)
        	$ci->db->like($search);  
		    $query = $ci->db->get(); 
			if($query->num_rows() > 0) {  
				return $query->result();   
			}else{
					return false;  
			}
        }
    }


	if (!function_exists('check_service_map')) {
        function check_service_map($service=FALSE, $where=FALSE)
        { 
            $ci =& get_instance();
            $ci->db->select($service);
        	$ci->db->from('service_mapping');  
			if($where)
        	$ci->db->where($where);  
		    $query = $ci->db->get(); 
			if($query->num_rows() > 0) {  
				$result =  $query->row();
				if($result->$service == 'Y'){
					return true;
				}else{
					return false;
				} 
			}else{
				return false;  
			}
        }
    }

 if (!function_exists('get_area_details')) {
        function get_area_details($select=FALSE, $where=FALSE, $disctinct=FALSE, $get_all=FALSE, $search_query=FALSE)
        { 
            $ci =& get_instance();
			if($disctinct)
			$ci->db->distinct();
			if($select)
            $ci->db->select($select);
			else 
            $ci->db->select();	
        	$ci->db->from('area'); 
			$ci->db->where(array('active'=>1));
        	$ci->db->where($where);  
			if($search_query)
			$ci->db->like(array('area'=>$search_query));	
		    $query = $ci->db->get(); 
			if($query->num_rows() > 0) {  
				if($get_all){
				$result =  $query->result();
				return $result;
				}else{ 
				$result =  $query->row();
				if($select)
					return $result->$select;
				else
					return $result;
				}
			}else{
				return false;  
			}
        }
    }


 if (!function_exists('get_service_category')) {
        function get_service_category($service_category_id)
        { 
            $ci =& get_instance();
            $ci->db->select('service_name');
        	$ci->db->from('service_category'); 
			$ci->db->where(array('active'=>1));
        	$ci->db->where(array('id'=>$service_category_id));  
		    $query = $ci->db->get(); 
			if($query->num_rows() > 0) {  
				$result =  $query->row();
				if(!empty($result->service_name)){
					return $result->service_name;
				}else{
					return false;
				} 
			}else{
				return false;  
			}
        }
    }

if (!function_exists('get_service_category_rates')) {
        function get_service_category_rates($service_category, $city, $vehicle_category)
        { 
            $ci =& get_instance();
            $ci->db->select($city);
        	$ci->db->from('service_category'); 
			$ci->db->where(array('active'=>1));
        	$ci->db->where(array('service_name'=>$service_category, 'vehicle_category'=>$vehicle_category));  
		    $query = $ci->db->get(); 
			if($query->num_rows() > 0) {  
				$result =  $query->row();
				if(!empty($result->$city)){
					return $result->$city;
				}else{
					return false;
				} 
			}else{
				return false;  
			}
        }
    }

  if (!function_exists('get_make')) {
        function get_make($make_id, $all=NULL)
        { 
            $ci =& get_instance();
			if($all){
			$ci->db->select();
        	}else{
			$ci->db->select('make_name');
        	}
            $ci->db->from('vehicle_make'); 
			$ci->db->where(array('active'=>1));  
			if(!$all){
			$ci->db->where(array('make_id'=>$make_id));  
		    }else{
			$ci->db->order_by('make_name ASC');  
		    }
        	$query = $ci->db->get(); 
			if($query->num_rows() > 0) {  
				if($all){ 
				return $query->result();
				}else{ 
					$result =  $query->row();
					if(!empty($result->make_name)){
						return $result->make_name;
					}else{
						return false;
					}
				}
			}else{
				return false;  
			}
        }
    }
 
   if (!function_exists('get_model')) {
        function get_model($model_id, $all=NULL)
        { 
            $ci =& get_instance();
			
			if($all)
            $ci->db->select();
			else
			$ci->db->select('model_name');
	
			$ci->db->from('vehicle_model'); 
			$ci->db->where(array('active'=>1));
        	$ci->db->where(array('model_id'=>$model_id));  
		    $query = $ci->db->get(); 
			if($query->num_rows() > 0) {  
				$result =  $query->row();
				if(!empty($result->model_name)){
					if($all)	
					return $result;	 
					else
					return $result->model_name;
				}else{
					return false;
				} 
			}else{
				return false;  
			}
        }
    }

	if (!function_exists('get_all_model')) {
        function get_all_model($make_id)
        { 
            $ci =& get_instance(); 
            $ci->db->select(); 
			$ci->db->from('vehicle_model'); 
			$ci->db->where(array('active'=>1));
        	$ci->db->where(array('make_id'=>$make_id));  
		    $query = $ci->db->get(); 
			if($query->num_rows() > 0) {  
				$result =  $query->result();
				if(!empty($result)){ 
					return $result;	  
				}else{
					return false;
				} 
			}else{
				return false;  
			}
        }
    }

	if (!function_exists('get_customer')) {
        function get_customer($where, $select=NULL)
        { 
            $ci =& get_instance();
			if($select)
            $ci->db->select($select);
			else
			$ci->db->select();	
        	$ci->db->from('customer');  
        	$ci->db->where($where); 
		    $query = $ci->db->get(); 
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
    }

	if (!function_exists('get_customer_address')) {
        function get_customer_address($where, $select=NULL)
        { 
            $ci =& get_instance();
			if($select)
            $ci->db->select($select);
			else
			$ci->db->select();	
        	$ci->db->from('customer_address');  
        	$ci->db->where($where); 
		    $query = $ci->db->get(); 
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
    }


if (!function_exists('get_customer_vehicles')) {
        function get_customer_vehicles($where, $select=NULL)
        { 
            $ci =& get_instance();
			if($select)
            $ci->db->select($select);
			else
			$ci->db->select();	
        	$ci->db->from('vehicles');  
        	$ci->db->where($where); 
		    $query = $ci->db->get(); 
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
    }

if (!function_exists('get_customer_bookings')) {
        function get_customer_bookings($where, $select=NULL)
        { 
            $ci =& get_instance();
			if($select)
            $ci->db->select($select);
			else
			$ci->db->select();	
        	$ci->db->from('bookings');  
        	$ci->db->where($where);  
        	$ci->db->order_by('service_date DESC, time_slot DESC');
		    $query = $ci->db->get(); 
			if($query->num_rows() > 0) {    
				if($select){ 
				$result = $query->row();	
				$response =  $result->$select;
				}else{ 
				$response =  $query->result();	 
				}
				
				if(!empty($response)){
					return $response;
				}else{
					return false;
				}
				
			}else{
				return false;  
			}
        }
    }

if (!function_exists('get_all_users')) {
        function get_all_users($where=NULL, $select=NULL)
        { 
            $ci =& get_instance();  
			$ci->db->select();	
        	$ci->db->from('users');    
        	if($where)
			$ci->db->where($where); 
			$ci->db->where(array('is_active'=>1)); 	
		    $query = $ci->db->get(); 
			if($query->num_rows() > 0) {     
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
    }

	 

if (!function_exists('get_users')) {
        function get_users($where=NULL, $select=NULL)
        { 
            $ci =& get_instance();
			if($select)
            $ci->db->select($select);
			else
			$ci->db->select();	
        	$ci->db->from('users');    
        	$ci->db->where($where); 
		    $query = $ci->db->get(); 
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
    }





if (!function_exists('get_all_service_providers')) {
        function get_all_service_providers($where=NULL, $select=NULL)
        { 
            $ci =& get_instance();  
			$ci->db->select();	
        	$ci->db->from('service_providers');    
        	if($where)
			$ci->db->where($where); 
			$ci->db->where(array('is_active'=>1)); 	
		    $query = $ci->db->get(); 
			if($query->num_rows() > 0) {     
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
    }

	 

if (!function_exists('get_service_providers')) {
        function get_service_providers($where=NULL, $select=NULL)
        { 
            $ci =& get_instance();
			if($select)
            $ci->db->select($select);
			else
			$ci->db->select();	
        	$ci->db->from('service_providers');    
        	$ci->db->where($where); 
		    $query = $ci->db->get(); 
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
    }



if (!function_exists('get_user_type')) {
        function get_user_type($user_type_id)
        { 
            $ci =& get_instance();
            $ci->db->select('user_type');
        	$ci->db->from('user_type'); 
        	$ci->db->where(array('id'=>$user_type_id));  
		    $query = $ci->db->get(); 
			if($query->num_rows() > 0) {  
				$result =  $query->row();
				if(!empty($result->user_type)){
					return $result->user_type;
				}else{
					return false;
				} 
			}else{
				return false;  
			}
        }
    }

   if (!function_exists('get_department')) {
        function get_department($department_id, $all=NULL)
        { 
            $ci =& get_instance(); 
			if($all)
            $ci->db->select();
			else
			$ci->db->select('department'); 
			$ci->db->from('departments'); 
        	$ci->db->where(array('id'=>$department_id));  
		    $query = $ci->db->get(); 
			if($query->num_rows() > 0) {  
				$result =  $query->row();
				if(!empty($result->department)){
					if($all)	
					return $result;	 
					else
					return $result->department;
				}else{
					return false;
				} 
			}else{
				return false;  
			}
        }
    }



if (!function_exists('get_all_customers')) {
        function get_all_customers($where=NULL, $select=NULL, $limit=100, $start=0)
        { 
            $ci =& get_instance();  
			$ci->db->select();	
        	$ci->db->from('customer');    
        	if($where)
			$ci->db->where($where); 
			$this->db->limit($limit,$start);
		    $query = $ci->db->get(); 
			if($query->num_rows() > 0) {     
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
    }

	 

if (!function_exists('get_customer')) {
        function get_customer($where=NULL, $select=NULL)
        { 
            $ci =& get_instance();
			if($select)
            $ci->db->select($select);
			else
			$ci->db->select();	
        	$ci->db->from('customer');    
        	$ci->db->where($where); 
		    $query = $ci->db->get(); 
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
    }


	if(!function_exists('send_otp_customer')){
		function send_otp_customer($mobile, $name, $token, $customer_id){
				$ci =& get_instance();
				$otp = rand(1000, 9999);
				$sms_data = array('otp' => $otp); 
				$send_sms = $ci->sms->sms_template(array($mobile),'send-otp',$sms_data);
				if(!empty($send_sms)){ 
				$data = array(
                'customer_id' => $customer_id,
				'name' => $name,		
                'mobile' => $mobile, 
				'otp' => $otp, 
				'token' => $token,	
                'is_expired' => '0', 
				'create_at' => date("Y-m-d H:i:s"),
				);
 			    $ci->Common->add_record('customer_otp', $data); 
				$response['otp'] = $otp;
				$response['mobile'] = $mobile;
				$response['token'] = $token; 
					return $response;
				}else{
					return false;
				} 
		}
	}
		
	if(!function_exists('verify_otp_customer')){
		function verify_otp_customer($mobile, $otp, $token, $customer_id){
				
			$ci =& get_instance(); 
			$ci->db->select();	
        	$ci->db->from('customer_otp'); 
        	$ci->db->where(array('token'=>$token, 'otp'=>$otp, 'mobile'=>$mobile,  'is_expired' => 0, 'customer_id'=>$customer_id));  
			$ci->db->where('NOW() <= DATE_ADD(create_at, INTERVAL 24 HOUR)'); 
		    $query = $ci->db->get(); 
				if($query->num_rows() > 0) {   
					$result =  $query->row();  
					$data = array(
					'is_expired' => 1,
					);
					$where = array('id' => $result->id);
					$ci->Common->update_record('customer_otp', $data, $where);
					
					return true;
					 
				}else{
						return false;
					} 
		}
	}











if(!function_exists('send_otp')){
		function send_otp($mobile, $name, $token, $user_type, $user_id){
				$ci =& get_instance();
				$otp = rand(1000, 9999);
				$sms_data = array('otp' => $otp); 
				$send_sms = $ci->sms->sms_template(array($mobile),'send-otp',$sms_data);
				if(!empty($send_sms)){ 
					$data = array(
                'user_id' => $user_id,
				'name' => $name,
                'mobile' => $mobile, 
				'otp' => $otp,
				'user_type' => $user_type,
				'token' => $token,	
                'is_expired' => '0', 
				'create_at' => date("Y-m-d H:i:s"),
				);
 			    $ci->Common->add_record('otp_expiry', $data); 
					$data = array(
					'token' => $token,
					);
					$where = array('id' => $user_id);
					$ci->Common->update_record('service_providers', $data, $where);	
					return true;
				}else{
					return false;
				} 
		}
	}
		
	if(!function_exists('verify_otp')){
		function verify_otp($mobile, $otp, $token){
				
			$ci =& get_instance(); 
			$ci->db->select();	
        	$ci->db->from('otp_expiry'); 
        	$ci->db->where(array('token'=>$token, 'mobile'=>$mobile, 'otp'=>$otp, 'is_expired' => 0));  
			$ci->db->where('NOW() <= DATE_ADD(create_at, INTERVAL 24 HOUR)'); 
		    $query = $ci->db->get(); 
				if($query->num_rows() > 0) {   
					$result =  $query->row();  
					$data = array(
					'is_expired' => 1,
					);
					$where = array('id' => $result->id);
					$ci->Common->update_record('otp_expiry', $data, $where);
					$response = get_service_providers(array('id'=>$result->user_id)); 
					return $response;
				}else{
						return false;
					} 
		}
	}


 if (!function_exists('mechanic_log')) {
        function mechanic_log($mechanic_id)
        { 
            $ci =& get_instance();
            $ci->db->select();
        	$ci->db->from('mechanic_log'); 
        	$ci->db->where(array('mechanic_id'=>$mechanic_id));  
		    $query = $ci->db->get(); 
			if($query->num_rows() > 0) {  
				$result =  $query->result(); 
			}else{
				return false;  
			}
        }
    }



	if (!function_exists('getlonglat')){   
function getlonglat($address){ 
$url = "https://maps.google.com/maps/api/geocode/json?key=AIzaSyBgW3kze70q1ov1DO0DMUDsZd3f8CUUOBw&libraries=places&region=in&address=".urlencode($address); 
$ch=curl_init();//initiating curl
curl_setopt($ch,CURLOPT_URL,$url);// CALLING THE URL
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_PROXYPORT,3128);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
$response=curl_exec($ch);
$response=json_decode($response);  
if($response->status == 'OK') {
    $latitude = $response->results[0]->geometry->location->lat;
    $longitude = $response->results[0]->geometry->location->lng;   
    $data['lat'] = $latitude;
    $data['long'] = $longitude;
	return $data;
}else{
    $data =  $response->status;
    //var_dump($response);
	return false;
}   
} 
}
   

if (!function_exists('getaddress')){   
function getaddress($lat,$long){
$url = "https://maps.google.com/maps/api/geocode/json?key=AIzaSyBgW3kze70q1ov1DO0DMUDsZd3f8CUUOBw&libraries=places&region=in&latlng=".$lat.",".$long; 
$ch=curl_init();//initiating curl
curl_setopt($ch,CURLOPT_URL,$url);// CALLING THE URL
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_PROXYPORT,3128);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
$response=curl_exec($ch);
$response=json_decode($response);  
if ($response->status == 'OK') {
    $address = $response->results[0]->formatted_address;    
	return $address;
} else {
    $data =  $response->status;
    //var_dump($response);
	return false;
} 
} 
}


if (!function_exists('getdistance')){ 
 function getdistance($lat1, $long1, $lat2, $long2)
{
	$apiKey = 'AIzaSyBgW3kze70q1ov1DO0DMUDsZd3f8CUUOBw'; // Google maps now requires an API key.
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&units=metric&sensor=false&key=".$apiKey;
	$geocode=file_get_contents($url);
    $output= json_decode($geocode, TRUE);	
	if(!empty($output['rows'][0]['elements'][0]['distance']) && !empty($output['rows'][0]['elements'][0]['duration'])){ 
    $dist =  $output['rows'][0]['elements'][0]['distance']['text'];
    $time =  $output['rows'][0]['elements'][0]['duration']['text'];
	$dist_v =  $output['rows'][0]['elements'][0]['distance']['value'];
    $time_v =  $output['rows'][0]['elements'][0]['duration']['value'];	
	
	$distance_converted =  round($dist_v * 0.001,2);
		
	$data['dist'] = $distance_converted;
    $data['time'] = $time;
	return $data;	 
	}else{
	return false;	
	}
}
}

if(!function_exists('getduration')){
	function getduration($time1, $time2=NULL, $time_unit='minutes'){ 
	 
	if(empty($time2)){ $time2 =  date('Y-m-d H:i:s'); }  
 $dateDiff = intval((strtotime($time2)-strtotime($time1))/60); 
 $hours = intval($dateDiff/60);
 $minutes = $dateDiff;
 $ThisTime = date('H:i:s', strtotime($hours.':'.$minutes)); 
 $time = explode(':', $ThisTime);
// return  ($time[0]*60) + ($time[1]) + ($time[2]/60); 
return $minutes;		
	}
}

?> 