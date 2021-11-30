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

class Api_model extends CI_Model
{
		 
	 

    function index()
    {

    }
	
	   
	public function user_active_bookings($mechanic_id, $booking_id){   
		$ci =& get_instance();
		//$active = $ci->Common->select_join('bookings AS b', 'booking_services AS bs', 'b.service_date<="'.date('Y-m-d').'" AND bs.stage!= "Closed"  AND bs.stage!= "Not Started" AND b.assigned_mechanic="'.$mechanic_id.'" AND b.booking_id!="'.$booking_id.'" AND b.status!="Cancelled" AND b.status!="Completed"', 'COUNT(b.booking_id) AS total_active', 'bs.booking_id=b.booking_id', TRUE, FALSE, FALSE);
		 
		$active_q  = $ci->Common->fetch_CustomQuery("SELECT b.booking_id, b.time_slot, DATE_FORMAT(b.service_date, '%d-%m-%Y') AS service_date, b.assigned_mechanic, b.status, b.stage FROM bookings AS b INNER JOIN booking_services AS bs ON bs.booking_id=b.booking_id WHERE b.service_date>='".date('Y-m-d')."' AND bs.stage!= 'Closed'  AND bs.stage!= 'Not Started' AND b.assigned_mechanic='".$mechanic_id."' AND b.booking_id!='".$booking_id."' AND b.status!='Cancelled' AND b.status!='Completed' AND b.stage!= 'Assigned'");
		 
			if(!empty($active_q['result'])){ 
				$result = 	$active_q['result'];
				$count = $active_q['result_count'];	
			}else{
				$result = 	0;
				$count = 0;	
			}
				//if(!empty($totalAssignedResult) && $totalNoOfAssigned>0){
				if(!empty($result) && $count>0){
				$active = '0';	
				}else{
				$active = '1';	
				}
		
		
		return $active; 			
	 }
	
	
	public function get_action_buttons($booking_id){
		
				 $ci =& get_instance();
		 		 $bookingdata = $ci->Bookings->getbooking($booking_id); 
				 $bookings = $bookingdata['booking'];
				 $booking_services = $bookingdata['booking_service'];
				
				 if(!empty($booking_services->inspection_time)){
					 
				$action_4['show'] = 0;
				$action_4['icon'] = 'not_responding.png';
				$action_4['label'] = 'No Response';
				$action_4['type'] = 'api_request';
				$action_4['value'] = 'customer_not_responding'; 
					 
				$action_5['show'] = 0;
				$action_5['icon'] = 'cancel_booking.png';
				$action_5['label'] = 'Cancel Booking';
				$action_5['type'] = 'api_request';
				$action_5['value'] = 'cancel_booking';
				
				$action_6['show'] = 0;
				$action_6['icon'] = 'no_location.png';
				$action_6['label'] = 'Location Not Found';
				$action_6['type'] = 'api_request';
				$action_6['value'] = 'location_not_found';
					 
			 
					 
				 }elseif(!empty($booking_services->reached_time)){
					 
				 $action_4['show'] = 1;
				$action_4['icon'] = 'not_responding.png';
				$action_4['label'] = 'No Response';
				$action_4['type'] = 'api_request';
				$action_4['value'] = 'customer_not_responding'; 	 
					 
				$action_5['show'] = 1;
				$action_5['icon'] = 'cancel_booking.png';
				$action_5['label'] = 'Cancel Booking';
				$action_5['type'] = 'api_request';
				$action_5['value'] = 'cancel_booking';
					 
				$action_6['show'] = 1;
				$action_6['icon'] = 'no_location.png';
				$action_6['label'] = 'Location Not Found';
				$action_6['type'] = 'api_request';
				$action_6['value'] = 'location_not_found';	
				
				  
				 }else{
					 
				$action_4['show'] = 0;
				$action_4['icon'] = 'not_responding.png';
				$action_4['label'] = 'No Response';
				$action_4['type'] = 'api_request';
				$action_4['value'] = 'customer_not_responding'; 	 
					 
				$action_5['show'] = 0;
				$action_5['icon'] = 'cancel_booking.png';
				$action_5['label'] = 'Cancel Booking';
				$action_5['type'] = 'api_request';
				$action_5['value'] = 'cancel_booking';
					 
				$action_6['show'] = 0;
				$action_6['icon'] = 'no_location.png';
				$action_6['label'] = 'Location Not Found';
				$action_6['type'] = 'api_request';
				$action_6['value'] = 'location_not_found';	
				
					 
					 
				 }
		
		
				
				 
		
		
				if($bookings->lock_status=="customer_not_responding"){
				$action_4['show'] = 0;
				$action_4['icon'] = 'not_responding.png';
				$action_4['label'] = 'No Response';
				$action_4['type'] = 'api_request';
				$action_4['value'] = 'customer_not_responding'; 
				}elseif($bookings->lock_status=="cancel_booking"){  
				$action_5['show'] = 0;
				$action_5['icon'] = 'cancel_booking.png';
				$action_5['label'] = 'Cancel Booking';
				$action_5['type'] = 'api_request';
				$action_5['value'] = 'cancel_booking';
				}elseif($bookings->lock_status=="location_not_found"){  
				$action_6['show'] = 0;
				$action_6['icon'] = 'no_location.png';
				$action_6['label'] = 'Location Not Found';
				$action_6['type'] = 'api_request';
				$action_6['value'] = 'location_not_found';	
				}
		
		
		
				if(!in_array($booking_services->service_stage, array('not_started','start_trip','payment_done'))){
					
					 $show_mobile = 1; 	 
				
				 }else{
				$action_6['show'] = 1;
				$action_6['icon'] = 'no_location.png';
				$action_6['label'] = 'Location Not Found';
				$action_6['type'] = 'api_request';
				$action_6['value'] = 'location_not_found';	 
					
				 $show_mobile = 0; 	 
					
				 }
		
		  		$data['action_4'] = $action_4;
				$data['action_5'] = $action_5;
				$data['action_6'] = $action_6;
				$data['show_mobile'] = $show_mobile;
		
		return $data; 			
	 }
	
	
	/* SERVICE ACTIONS */
	public function update_booking_service($status=NULL, $stage=NULL, $action=NULL, $platform='APP', $payment_comments, $backend=FALSE){
		
			extract($_POST); 
		
		 	$ci =& get_instance();
            $ci->load->model('Bookings_model', 'Bookings');   
			$bookingdata = $ci->Bookings->getbooking($booking_id); 
			$bookings = $bookingdata['booking'];
			$booking_services  = $bookingdata['booking_service'];
			 
				
		
		//////////////// Bookings
			$data = array(
                'stage' => $stage,
				'status' => $status, 
			    'updated_on' => updated_on()
            );
			if(!empty($km_reading))
			$data['vehicle_km_reading']	 = $km_reading;
		
            $where = array('booking_id' => $booking_id);
            $ci->Common->update_record('bookings', $data, $where); 
			
		//////////////// Booking Details
			if($api_action == 'start_work'){ 
				$data = array(
                'actual_service_date' => created_on(),
				'actual_time_slot' => date('H:i:s'),
				); 
				$where = array('booking_id' => $booking_id);
				$ci->Common->update_record('booking_details', $data, $where); 
			}
		
			if($api_action == 'payment_done'){  
				$data = array(
                'actual_amount' => $amount_collected,
				'payment_mode' => $payment_mode,
				); 
				$where = array('booking_id' => $booking_id);
				$ci->Common->update_record('booking_details', $data, $where);  
			}
		
		if($backend){  $owner_name = created_by_name(); $owner = created_by(); }else{ $owner_name = get_service_providers(array('id'=>$mechanic_id),'name');  $owner = $mechanic_id; }
			
			//////////////// Booking Track
			$platform_ip =	@$ip;
			$platform_details = 'Device: '.@$device.' | OS: '.@$os.' | IP: '.$platform_ip;
        	$ci->Bookings->addBookingTrack($status, $stage, $owner, $platform_details, $action, $owner_name);
			
		
			//////////////// Booking Service
			//// START TRIP
			if($api_action == 'start_trip'){  
				$extra_data = array(
                'start_time' => date('Y-m-d H:i:s'),
				'start_lat' => $lat,
				'start_long' => $long,	
				'start_location' => @getaddress($lat,$long),
				'service_stage' => $api_action,
				);  
			}
		
			//// REACHED
			if($api_action == 'reached'){   
				
				$dist = getdistance($lat,$long,$booking_services->start_lat,$booking_services->start_long);
				$extra_data = array(
				'reached' => 1,	
                'reached_time' => date('Y-m-d H:i:s'),
				'distance_travelled' => @$dist['dist'],
				'duration_travelled' => @$dist['time'],	
				'delay' => @getduration($bookings->service_date.' '.$bookings->time_slot, date('Y-m-d H:i:s')),	
				'service_stage' => $api_action,
				);  
			}
		
			//// INSPECTION DONE
			if($api_action == 'inspection_done'){   
				
					
					$ci->load->library('functions');	
				    
					 
				 
				if(!empty($_FILES['inspection_vehicle_image']['name'])){   
						$uploaddir = "uploads/inspection/"; 
						$upload_data_arr = $ci->functions->custom_file_upload_mulitple('inspection_vehicle_image', $uploaddir, $booking_id.'_vehicle_images_');  
						if(!empty($upload_data_arr)){ 		
							foreach($upload_data_arr as $upload_data){ 
						$add_response =	$this->addInspectionUploads('Vehicle Images', $upload_data['file_name'], $upload_data['original_name'], $upload_data['file_ext'], $upload_data['file_path'], $booking_id);
							}
						} 
							  	
				} 
				
				
				
				
				if(!empty($_FILES['inspection_audio'])){ 
					if(isset($_FILES["inspection_audio"]["tmp_name"]) &&  $_FILES["inspection_audio"]['name']!=""){   
						$uploaddir = "uploads/inspection/"; 
						$upload_data = $ci->functions->custom_file_upload('inspection_audio', $uploaddir, $booking_id.'_audio');
						if(!empty($upload_data['file_name'])){ 		
						$add_response =	$this->addInspectionUploads('Audio', $upload_data['file_name'], $upload_data['original_name'], $upload_data['file_ext'], $upload_data['file_path'], $booking_id);
						}
					}
				}
				
				
					 
					
				
				$extra_data = array(
                'inspection_time' => date('Y-m-d H:i:s'),
				'service_stage' => $api_action,
				//'km_reading' => $km_reading, 
				);  
			}
		
			//// START WORK
			if($api_action == 'start_work'){   
				$extra_data = array(
                'service_date' => date('Y-m-d'),
                'service_time' => date('H:i:s'),
                'service_by' => $mechanic_id,
				'inspection_duration' => @getduration($booking_services->reached_time, date('Y-m-d H:i:s')), 
				'service_stage' => $api_action,
				);  
				
				/*UPDATE LAST BOOKING ID*/  
			$update_vehicle = array(
			'last_service_id' => $booking_id,
            'last_service_date' => date('Y-m-d'),  
        	);
			$where = array('vehicle_id' => $bookings->vehicle_id, 'customer_id'=>$bookings->customer_id);
			$this->Common->update_record('vehicles', $update_vehicle, $where); 
				/*UPDATE LAST BOOKING ID END*/  
			}
		
			//// END WORK
			if($api_action == 'end_work'){   
				$extra_data = array(
                'end_work_time' => date('Y-m-d H:i:s'), 
				'service_duration' => @getduration($booking_services->service_date.' '.$booking_services->service_time, date('Y-m-d H:i:s')), 
				'service_stage' => $api_action,
				);  
			}
			
			//// SUBMIT REPORT
			if($api_action == 'submit_report'){   
				//
//				$rawdata = json_encode($_FILES);
//					
//				$raw_data = array(
//                'parent' => 'Booking Id '.$booking_id, 
//                'content' => $rawdata
// 					);   
//        		$raw_resp = $ci->Common->add_record('raw_table', $raw_data);  
//				 
//				
//					$ci->load->library('functions');
//				
//				
				
				
				$ci->load->library('functions');
				if(!empty($_FILES['report_vehicle_image']['name'])){ 	 
					 
						    
						$uploaddir = "uploads/service_report/"; 
						$upload_data_arr = $ci->functions->custom_file_upload_mulitple('report_vehicle_image', $uploaddir, $booking_id.'_vehicle_images_');
						
					
						if(!empty($upload_data_arr)){ 		
							foreach($upload_data_arr as $upload_data){ 
						$add_response =	$this->addReportUploads('Vehicle Images', $upload_data['file_name'], $upload_data['original_name'], $upload_data['file_ext'], $upload_data['file_path'], $booking_id);
							}
						}
					 
				 
							  	
				} 
				
				
				 
				
				if(!empty($_FILES['report_audio'])){ 
					if(isset($_FILES["report_audio"]["tmp_name"]) &&  $_FILES["report_audio"]['name']!=""){   
						$uploaddir = "uploads/service_report/"; 
						$upload_data = $ci->functions->custom_file_upload('report_audio', $uploaddir, $booking_id.'_audio');
						if(!empty($upload_data['file_name'])){ 		
						$add_response =	$this->addReportUploads('Audio', $upload_data['file_name'], $upload_data['original_name'], $upload_data['file_ext'], $upload_data['file_path'], $booking_id);
						}
					}
				} 
				 
				
				
				if(empty($service_recommendation)){
					$service_recommendation = ' ';
				}
				
				$extra_data = array(  
				'service_recommendation' => @$service_recommendation, 
				'service_stage' => $api_action,
				);  
			}
		
			//// PAYMENT DONE
			if($api_action == 'payment_done'){  
				$ci->load->library('functions');
				
				if(!empty($_FILES['reciept_ss'])){ 
					if(isset($_FILES["reciept_ss"]["tmp_name"]) &&  $_FILES["reciept_ss"]['name']!=""){   
						$uploaddir = "uploads/payments/"; 
						$upload_data = $ci->functions->custom_file_upload('reciept_ss', $uploaddir, $booking_id.'_payment_reciept');
						if(!empty($upload_data['file_name'])){ 		
						$add_response =	$this->addPaymentUploads('Payment Reciept', $upload_data['file_name'], $upload_data['original_name'], $upload_data['file_ext'], $upload_data['file_path'], $booking_id);
						}
					}
				} 
				
				if(!empty($payment_mode)){
					 $payment_status = 'Paid';
					 $payment_date = created_on();
				}else{
					$payment_status = '';
					$payment_date = '';
				}
				 
				
				$extra_data = array(  
				'service_amount' => @$amount_collected,
				'payment_mode' => @$payment_mode,
				'payment_comments'	=> @payment_comments,
				'payment_status'	=> @payment_status,
				'payment_date' => $payment_date,  
				'service_stage' => $api_action,
				); 
				
				$ci->load->library('payments');
										   
				$response = $ci->payments->process_final_payment($booking_id, $amount_collected, $payment_status, $payment_mode, $payment_date, $payment_comments);
			}
		
			$ci->Bookings->updateBookingService($status, $stage, $extra_data);
			
			//////////////// Booking Service Track  
			 
			$ci->Bookings->addServiceTrack($booking_services->service_id, $stage, $action); 
		
			//////////////// Booking Update Mechanic Log  
		
			$response = $ci->Bookings->UpdateMechanicLog($mechanic_id, $long, $lat, $activity, $booking_id);
			
			if($api_action == 'start_trip'){ 
			$service_provider = get_service_providers(array('id'=>$mechanic_id));	
			$sms_data = array('service_provider_name' => @$service_provider->name); 	
			$send_sms = $ci->sms->sms_template(array($bookings->customer_mobile),'trip-started',$sms_data);
			}elseif($api_action == 'reached'){ 
			$service_provider = get_service_providers(array('id'=>$mechanic_id));	
			$sms_data = array('service_provider_name' => @$service_provider->name); 	
			$send_sms = $ci->sms->sms_template(array($bookings->customer_mobile),'trip-ended',$sms_data);
			}elseif($api_action == 'end_work'){ 
				
					$ci->load->library('payments');
					$get_final_payment = $ci->payments->calculate_final_payment($booking_id);	
				
			$invoice_total = $get_final_payment;	
			$sms_data = array('invoice_total' => $invoice_total); 	
			$send_sms = $ci->sms->sms_template(array($bookings->customer_mobile),'end-work',$sms_data);
			}elseif($api_action == 'payment_done'){ 
				
			$bookingdata = $ci->Bookings->getbooking($booking_id); 
			  	
			$total_amount = $bookingdata['booking_payments']->total_amount;	
			$payment_mode = $bookingdata['booking_payments']->payment_mode;	
				
			$sms_data = array('total_amount' => $total_amount, 'payment_mode' => $payment_mode, 'booking_id' => $bookings->booking_id, 'base_url' => base_url()); 	
			$send_sms = $ci->sms->sms_template(array($bookings->customer_mobile),'payment-done',$sms_data);
				
			$sms_data = array('booking_id' => base64_encode($bookings->booking_id), 'base_url' => base_url(), 'total_amount' => $total_amount, 'payment_mode' => $payment_mode); 	
			$send_sms = $ci->sms->sms_template(array($bookings->customer_mobile),'booking-completed',$sms_data); 
			 
			$mail_data = array( 'booking_id' => $bookings->booking_id, 'total_amount' => $total_amount, 'payment_mode' => $payment_mode);
		    $send_email = $this->mailer->mail_template($bookings->customer_email,'booking-completed',$mail_data, 'emailer/completed_booking.php');
				
				
			}   
		
			return $response;
		 
	}
	
	
	   
	
	
	public function addInspectionUploads($type, $new_filename, $actual_filename, $file_type, $file_url, $booking_id){ 
		$ci =& get_instance();
		if(empty($actual_filename)){$actual_filename ="";} 
		if(empty($file_url)){$file_url ="";} 
		$temp = explode(".", $file_type);
		$file_type_ext =  end($temp);  
				
		$data = array(
                'booking_id' => $booking_id,
                'type' => $type,
                'new_filename' => $new_filename,
                'actual_filename' => $actual_filename,
				'file_type' => $file_type_ext,
                'file_url' => $file_url 

            ); 
		
		 
		$existing_upload = $this->Common->single_row('inspection_uploads', array('booking_id'=>$booking_id, 'type'=>$type, 'new_filename'=>$new_filename)); 
		if(!empty($existing_upload->id) && $existing_upload->id>0){  
		delete_single_uploads('/var/www/html/flywheel_v3/uploads/inspection/'.$existing_upload->new_filename); 
		$where = array('id' => $existing_upload->id); 		
		$ci->Common->update_record('inspection_uploads', $data, $where);  	 
		$response = 'Uploaded';	
			}else{ 
		 $response = $ci->Common->add_record('inspection_uploads', $data); 
			}
		
		return $response;
		
	}
	
	
	public function addReportUploads($type, $new_filename, $actual_filename, $file_type, $file_url, $booking_id){ 
		$ci =& get_instance();
		if(empty($actual_filename)){$actual_filename ="";} 
		if(empty($file_url)){$file_url ="";} 
		$temp = explode(".", $file_type);
		$file_type_ext =  end($temp); 
		$data = array(
                'booking_id' => $booking_id,
                'type' => $type,
                'new_filename' => $new_filename,
                'actual_filename' => $actual_filename,
				'file_type' => $file_type_ext,
                'file_url' => $file_url 

            );  
		
        $response = $ci->Common->add_record('report_uploads', $data);  
		return $response;
		
	}
	
	public function addPaymentUploads($type, $new_filename, $actual_filename, $file_type, $file_url, $booking_id){ 
		$ci =& get_instance();
		if(empty($actual_filename)){$actual_filename ="";} 
		if(empty($file_url)){$file_url ="";} 
		$temp = explode(".", $file_type);
		$file_type_ext =  end($temp); 
		$data = array(
                'new_filename' => $new_filename,
               	'actual_filename' => $actual_filename,
				'file_type' => $file_type_ext,
                'file_url' => $file_url,	
        	); 
		$where = array('booking_id' => $booking_id);  
        $response = $ci->Common->update_record('booking_services', $data, $where); 
		return $response;
		
	}
	//FILE END
}

?>