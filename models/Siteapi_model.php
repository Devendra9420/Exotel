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

class Siteapi_model extends CI_Model
{
		 
	 

    function index()
    {

    }
	
	// Customer Details
    public function customer_existance()
    {
		extract($_POST); 
		$data = []; 
		$customer = get_customer(array('mobile'=>$mobile));    
		if($customer){ 
		$data['customer_id']=$customer->customer_id;	
		$address = get_customer_address(array('customer_id'=>$customer->customer_id)); 
		if(!empty($address))
		foreach ($address as $add){  
		$zone = get_area_details('zone',array('area'=>$add->area));   
		$latlong = getlonglat($add->address); 
			$customeraddress[] = array( 
			'type' => $add->type,
			'address' => $add->address,
			'area' => $add->area,
			'city' => $add->city,
			'pincode' => $add->pincode,
			'google_map' => $add->google_map,
			'zone'	=> $zone,
			'latitude' => @$latlong['lat'],
			'longitude' => 	@$latlong['long'],	
			);	  
		} 
 		if(!empty($customeraddress)){ $data['address'] = $customeraddress;	}else{ $data['address'] = '';  }
		$vehicles = get_customer_vehicles(array('customer_id'=>$customer->customer_id));   
		if(!empty($vehicles))	
		foreach ($vehicles as $vehicle){ 
		$make = get_make($vehicle->make); 
		$model = get_model($vehicle->model,'all');  
			$customervehicle[] = array( 
			'vehicle_id' => $vehicle->vehicle_id,
			'make' => $vehicle->make,
			'make_name' => 	$make,
			'model' => $vehicle->model,
			'model_name' =>  $model->model_name,
			'model_code' =>  $model->model_code,
			'vehicle_category' => $vehicle->category,
			'regno' => $vehicle->regno,
			'yom' => $vehicle->yom, 
			'km_reading' => $vehicle->km_reading, 
			'last_service_date' => convert_date($vehicle->last_service_date),
			'last_service_id' => $vehicle->last_service_id,
			);	 
		} 
			if(!empty($customervehicle)){ $data['vehicle'] = $customervehicle;	}else{ $data['vehicle'] = '';  } 
 		$data['name'] = $customer->name;
		$data['mobile'] =  $customer->mobile;
		$data['alternate_no'] =  $customer->alternate_no;
		$data['email'] =  $customer->email;
		$data['channel'] = $customer->channel;
		$data['customer_type'] = 'old';	 	
		}else{ 
		$data['customer_id']=0;  
		$data['name'] = "Guest";	
		$data['customer_type'] = 'new';
		$data['channel'] = 'Online';	
		} 
        return $data; 
    }
	
	public function check_sitebooking($customer_type='old',$channel='Online',$otp){
	
		extract($_POST); 
		
		$sitedataresponse = [];
		
		 
		 
		if($customer_type=='old'){ 
			$existingcustmsg = '(Existing Customer. Channel: '.$channel.')';
			$existing_customer = 1;
			$customer_channel  = $channel;
		}else{
			$existingcustmsg = '(New Customer)';
			$existing_customer = 0;
			$customer_channel  = 'Online';
		}
		 
					
		if(!empty($site_booking_id) && $site_booking_id!=0){ 
				$sitebookingdata = array(
				'otp_send_time' => date('Y-m-d H:i:s'), 
                'otp_expired' => 0,
				'status' => 'OTP Resend',
            );
         	$sitebookingwhere = array('id' => $site_booking_id);
         	$this->Common->update_record('site_bookings', $sitebookingdata, $sitebookingwhere);
			////////////////////////////////////////////////////////////////  UPDATE LEAD
			$sitebookingdata_lead = array(
				'converted' => 0,
				'status' => 'OTP Resend',
            );
         	$sitebookingwhere_lead = array('id' => $leads_id);
         	$this->Common->update_record('leads', $sitebookingdata_lead, $sitebookingwhere_lead);
			$response['leads_id'] = $leads_id;
			////////////////////////////////////////////////////////////////  UPDATE LEAD END 
			 $response['site_booking_id'] = $site_booking_id;	
			return $response;
		}else{  
		
			$add_site_booking = $this->add_sitebooking_data($otp);
			$ci =& get_instance();
            $ci->load->model('Leads_model', 'Leads');     
			 $leads_id = $ci->Leads->add_leads_data(array('site_booking_id'=>$add_site_booking, 'desired_service_date'=>$service_date, 'service_category'=>get_service_category($service_category)));     
			 $compile_estimate_data = $this->compile_estimate_data();
			//foreach($compile_estimate_data as $com_es_data){ 
//				
//				$datastringfix = implode('|', $com_es_data);
//					
//			$dataraw = array('content'=>$datastringfix, 'parent'=>'leadraw');
//			  $this->Common->add_record('raw_table', $dataraw);
//			}
			
			if(!empty($compile_estimate_data))
			 $leads_estimate_details  = $ci->Leads->add_leads_estimate_details_data($leads_id, $compile_estimate_data);     
			 $leads_lifecycle = $ci->Leads->add_leads_lifecycle($leads_id);   
			 $response['site_booking_id'] = $add_site_booking;	
			 $response['leads_id'] = $leads_id;
			
			return $response;
			
		}
		
		
	}
	
	 
	
	public function add_sitebooking_data($otp){   
		
		extract($_POST); 
			
			$device = $this->input->post("device");
			$os =  $this->input->post("os"); 
			$browser =  $this->input->post("browser");
			$make_name =  get_make($vehicle_make);
			$model_name =  get_model($vehicle_model);  
			
			$complaint_list = '';
		if(!empty($complaints)){ 
		   foreach($complaints as $complaint){
			$complaints_name  = $this->Common->single_row('complaints',array('id' => $complaint),'complaints'); 
			$complaint_list .= $complaints_name.' | ';
		}
		} 
		 			
		$sparesLISTNAME = '';
		if(!empty($specific_spares)){ 
		   foreach($specific_spares as $spare){ 
			$spare_name =  $this->Common->single_row('spares',array('spares_id' => $spare),'item_name');  
			$sparesLISTNAME .= $spare_name.' | ';
		}
		} 
		
		$labourLISTNAME = '';
		if(!empty($specific_repairs)){ 
		   foreach($specific_repairs as $repair){ 
			$repair_name =  $this->Common->single_row('labour',array('item_code' => $repair),'item_name');   
			$labourLISTNAME .= $repair_name.' | ';
		}
		}
		
		 if(!empty($otp)){ $otpsent_status='OTP Sent Successfully'; }else{ $otpsent_status='Failed to Send OTP'; }
		if(empty($existing_customer)){ $existing_customer = '0'; }
		$lead_data = array( 
				'source' => $utm_source, 
				'medium' => $utm_medium,  
                'campaign' => $utm_campaign, 
                'target' => $utm_target, 
                'customer_name' => $name, 
				'customer_phone' => $mobile,
				'customer_alternate_no' => $alternate_no,
			    'customer_email' => $email,
			    'customer_city' => $city,
			    'make' => $make_name,
				'model' => $model_name,
				'estimated_amount' => $estimated_amount,
				'customer_address' => $address,
			    'customer_area' => $area,
				'customer_google_map' => $google_map,
				'customer_pincode' => $pincode,
				'service_category' => get_service_category($service_category), 
				'service_date' => $service_date, 
				'time_slot' => date('H:i:s', strtotime($time_slot.':00')),  
				'comments' => $comments,
				'specific_spares' => $sparesLISTNAME,
				'specific_repairs' => $labourLISTNAME,   
				'existing_customer' => $existing_customer,   
				'otp' => $otp,
				'otp_expired' => '0',
				'otp_send_time' => updated_on(), 
				'complaints' => $complaint_list, 
				'status' => $otpsent_status,
				'device' => $device,
				'os' => $os,
				'browser' => $browser,
				'created_on' => updated_on(),
            );
			 
			
			  $sitedataresponse = $this->Common->add_record('site_bookings', $lead_data);	
			  $site_booking_id = $this->db->insert_id();	
				
			 return $site_booking_id;
			 	
	}
	
	
	public function update_sitebooking_data($otp_expired, $status){   
		
		extract($_POST); 
			
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
		  
		
		
		
		
			 $_POST['service_date'] =  $service_date;
		
			 $compile_estimate_data = $this->compile_estimate_data(); 
			 
		$last_booking_id = $this->Common->find_maxid('booking_id', 'bookings');
		$booking_no = ($last_booking_id+1); 
		
		$_POST['reg_no'] = '';
		$_POST['last_service_id'] = '';
		/////////////////////////////////////////////////// ADD BOOKING ESTIMATE DETAILS START
		$customer_data = $this->Bookings->add_booking_customer($booking_no); 
		
		 $convert_desired_service_date = date('Y-m-d', strtotime($service_date));
		
		$this->load->library('payments');
		$this->load->library('razorpay');
		
		if(!empty($coupon_code)){ 
			 $make_det  = get_make($make);   
		 $model_det  = get_model($model,TRUE); 
		$coupon_details['coupon_code'] = $coupon_code;
		$coupon_details['mobile'] = $mobile;
		$coupon_details['customer_type'] = $customer_type;  
		$coupon_details['zone'] = $zone;
		$coupon_details['make'] = $make;
		$coupon_details['model'] = $model; 
		$coupon_details['vehicle_category'] =  $model_det->vehicle_category;
		$coupon_details['service_category'] =  $service_category;    
		$coupon_details['city'] =  $city;    
			$calculate_coupon = $this->payments->calculate_coupon($coupon_details, 'cart'); 
			if(!empty($calculate_coupon['discount_type'])){
					if($calculate_coupon['discount_type']=='cart'){ 
							$demand_discount = $calculate_coupon['discount_amount'];
					}elseif($calculate_coupon['discount_type']=='product'){ 
							
						if($calculate_coupon['discount_criteria']=='free'){ 
							foreach ($compile_estimate_data as $linekey => $linevalue) {
								if ($linevalue['item_type']=$calculate_coupon['product_type'] && $linevalue['item_name']=$calculate_coupon['product']) {
									$compile_estimate_data[$linekey]['quantity'] = 1;
									$compile_estimate_data[$linekey]['total_rate'] = $calculate_coupon['discount_amount'];
									$compile_estimate_data[$linekey]['spares_rate'] = $calculate_coupon['discount_amount'];
									$compile_estimate_data[$linekey]['labour_rate'] = 0;
									$compile_estimate_data[$linekey]['coupon_applied'] = 1;
								}
							}
						} 
							
						
						  
					}else{ 
							$demand_discount = 0;	 
					}
			}
		}else{ 
			$discount_amount = 0;
			$coupon_code = '';
		}
		
		
		/////////////////////////////////////////////////// ADD BOOKING START  
         $booking_id = $this->Bookings->add_booking_data($booking_no, $customer_data['customer_id'],$customer_data['customer_vehicle'],array('customer_id'=>$customer_data['customer_id'], 'vehicle_id'=>$customer_data['customer_vehicle'],'service_date'=>$convert_desired_service_date,'booking_medium'=>'website','coupon_code'=>$coupon_code));   
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
		
		
		$demand_booking_fee = $this->payments->add_customer_ledger('booking_fee', $booking_id, $booking_fee_amount, 'Online Booking');
		
		
		
		$demand_discount = $this->payments->add_customer_ledger('discount', $booking_id, $discount_amount, 'Online Booking');	 
		
		
		if(!empty($gateway_payment) && $gateway_payment=='yes'){   
			if(!empty($ref_no)){ 
			  
				$payment_mode = 'Razorpay';
			$receive_booking_fee = $this->payments->collect_customer_ledger($booking_id, 'booking_fee', $booking_fee_amount, @$payment_mode, @$payment_status, $ref_no, 'Via payment gateway');  	 
			
				
				
			}
		}
			
		 
		
		$data = array(  
				'converted' => 1,
				'archived' => 1,
				'booking_id' => $booking_id, 
				'status' => $status, 
            );
        $where = array('id' => $leads_id);
        $this->Common->update_record('leads', $data, $where);
		
		
		// extract($_POST);
		 
		 
					
		
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
		
		 			$send_email = $this->mailer->mail_template('hello@garageworks.in','booking_from_website',$mail_data, 'custom');	
		
		 $mail_data = array( 'booking_id' => $booking_id, 'Spares_List' => $estimate_details['Spares_List'], 'Labour_List' => $estimate_details['Labour_List']);
		 $send_email = $this->mailer->mail_template($email,'new-booking',$mail_data, 'emailer/new_bookings.php');
 		  
		 
		 $sms_data = array( 'service_category' => $service_category_name, 'time_slot' => $time_slot, 'service_date'=>$service_date); 
		 $send_sms = $this->sms->sms_template(array($mobile),'new-booking',$sms_data);
		 
		
		
		  if($booking_id){
 				return $booking_id;	 	
 			   }else{
 			   return false;
 		   }   
			  
			  
	}
	
	
	  
	
			 
	
	
	
	public function compile_estimate_data(){
 		extract($_POST);
		
		$collective_estimate=[];
		 
		if(!empty($service_category)){
			
		  
				$service_cat_est_data['item_id'] = $service_name;
				$service_cat_est_data['item_name'] = $service_name;
				$service_cat_est_data['complaint_number'] = 0;
				$service_cat_est_data['complaints'] = '';
				$service_cat_est_data['spares_rate'] = '';
				$service_cat_est_data['labour_rate'] = $service_rate;
				$service_cat_est_data['quantity'] = 1;
				$service_cat_est_data['estimate_no'] = 0;
				$service_cat_est_data['total_rate'] = $service_rate; 
				$service_cat_est_data['item_type'] = 'Service Category';	 
				$collective_estimate[] =  $service_cat_est_data;
				 
			
		}
		
		
		if(!empty($complaints_id)){
			$complaints_counter  = 1; 
			
			 
			
			foreach($complaints_id as $thiscomplaint_ID){ 
			  
			 
				
			 $complaint_options_data  = $this->Common->complaint_options($thiscomplaint_ID, $vehicle_category, $model_code, $channel, $city, $complaints_counter);
				
		 
				
				foreach($complaint_options_data as $complaint_op){ 
				$est_data['item_id'] = $complaint_op['itemid'];
				$est_data['item_name'] = $complaint_op['itemname'];
				$est_data['complaint_number'] = $complaints_counter;
				$est_data['complaints'] = $complaint_op['complaints'];
				$est_data['spares_rate'] = $complaint_op['sparesrates'];
				$est_data['labour_rate'] = $complaint_op['labourrates'];
				$est_data['quantity'] = 1;
				$est_data['estimate_no'] = $complaints_counter;
				$est_data['total_rate'] = $complaint_op['totalrates']; 
				$est_data['item_type'] = 'Complaints';	 
				$collective_estimate[] =  $est_data;
				}
				
			 
				
						  $complaints_counter++;	
						  
			}
			
		}
		
		
		if(!empty($specific_spares)){
			$spares_counter = 1;
			
			 
			foreach($specific_spares as $thisspareID){ 
			
				$thisspare = $this->Common->single_row('spares', array('spares_id'=>$thisspareID), 'item_name');
				
			$sparesid_data =  $this->Common->spares_dropdown($vehicle_category, $model_code, $thisspare, $channel, $city);	
				
				 
				foreach($sparesid_data as $spare_data){ 
				$spare_est_data['item_id'] = $spare_data['itemid'];
				$spare_est_data['item_name'] = $spare_data['itemname'];
				$spare_est_data['complaint_number'] = 0;
				$spare_est_data['complaints'] = '';
				$spare_est_data['spares_rate'] = $spare_data['sparesrates'];
				$spare_est_data['labour_rate'] = $spare_data['labourrates'];
				$spare_est_data['quantity'] = 1;
				$spare_est_data['estimate_no'] = $spares_counter;
				$spare_est_data['total_rate'] = $spare_data['totalrates']; 
				$spare_est_data['item_type'] = 'Spare';	 
				$collective_estimate[] =  $spare_est_data;
				}
				
			 
				
						  $spares_counter++;	
						  
			}
			
		}
		
		
		if(!empty($specific_repairs)){
			$labour_counter = 1;
			
			 
			foreach($specific_repairs as $thislabour){ 
			
				 
					
			$labourid_data =  $this->Common->labour_dropdown($vehicle_category, $model_code, $city, $thislabour, 'Lead');	
				
				 
				foreach($labourid_data as $labour_data){ 
				$labour_est_data['item_id'] = $labour_data['itemid'];
				$labour_est_data['item_name'] = $labour_data['itemname'];
				$labour_est_data['complaint_number'] = 0;
				$labour_est_data['complaints'] = '';
				$labour_est_data['spares_rate'] = $labour_data['sparesrates'];
				$labour_est_data['labour_rate'] = $labour_data['labourrates'];
				$labour_est_data['quantity'] = 1;
				$labour_est_data['estimate_no'] = $labour_counter;
				$labour_est_data['total_rate'] = $labour_data['totalrates']; 
				$labour_est_data['item_type'] = 'Labour';	 
				$collective_estimate[] =   $labour_est_data;
				}
				 
						  $labour_counter++;	
						  
			}
			
		}
		
		 
		
		return $collective_estimate;	
	}
	
	public function add_lead_future(){
	
		extract($_POST);   
			$ci =& get_instance();
            $ci->load->model('Leads_model', 'Leads');     
			 $leads_id = $ci->Leads->add_leads_data();     
		 
			 $response = $leads_id;
			
			return $response;
			
		 
		
		
	}
	
	//FILE END
}

?>