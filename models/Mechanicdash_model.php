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

class Mechanicdash_model extends CI_Model
{
		 
	 

    function index()
    {

    }
	
	 
    public function completed_cases($mechanic_id, $start_date, $end_date)
    {
		extract($_POST); 
		$data = []; 
		 
		 
		$data = $this->Common->count_all_results('bookings', array('assigned_mechanic'=>$mechanic_id, 'status'=>'Completed', 'service_date >='=>$start_date, 'service_date <='=>$end_date));
		 
        return $data; 
    }
	
	 public function mechanic_ratings($mechanic_id, $start_date, $end_date)
    {
		extract($_POST); 
		$data = []; 
		
		 
		 $rating_1 = $this->Common->select_join('feedback', 'bookings', array('bookings.assigned_mechanic'=>$mechanic_id, 'bookings.status'=>'Completed', 'bookings.service_date >='=>$start_date, 'bookings.service_date <='=>$end_date, 'feedback.feedback'=>1), 'COUNT(feedback.feedback_id) AS ratingcount', 'feedback.booking_id=bookings.booking_id', 'INNER', 'Yes');
		
		$rating_2 = $this->Common->select_join('feedback', 'bookings', array('bookings.assigned_mechanic'=>$mechanic_id, 'bookings.status'=>'Completed', 'bookings.service_date >='=>$start_date, 'bookings.service_date <='=>$end_date, 'feedback.feedback'=>2), 'COUNT(feedback.feedback_id) AS ratingcount', 'feedback.booking_id=bookings.booking_id', 'INNER', 'Yes');
		
		$rating_3 = $this->Common->select_join('feedback', 'bookings', array('bookings.assigned_mechanic'=>$mechanic_id, 'bookings.status'=>'Completed', 'bookings.service_date >='=>$start_date, 'bookings.service_date <='=>$end_date, 'feedback.feedback'=>3), 'COUNT(feedback.feedback_id) AS ratingcount', 'feedback.booking_id=bookings.booking_id', 'INNER', 'Yes');
		
		$rating_4 = $this->Common->select_join('feedback', 'bookings', array('bookings.assigned_mechanic'=>$mechanic_id, 'bookings.status'=>'Completed', 'bookings.service_date >='=>$start_date, 'bookings.service_date <='=>$end_date, 'feedback.feedback'=>4), 'COUNT(feedback.feedback_id) AS ratingcount', 'feedback.booking_id=bookings.booking_id', 'INNER', 'Yes');
		
		$rating_5 = $this->Common->select_join('feedback', 'bookings', array('bookings.assigned_mechanic'=>$mechanic_id, 'bookings.status'=>'Completed', 'bookings.service_date >='=>$start_date, 'bookings.service_date <='=>$end_date, 'feedback.feedback'=>5), 'COUNT(feedback.feedback_id) AS ratingcount', 'feedback.booking_id=bookings.booking_id', 'INNER', 'Yes');
		 
		 if(empty($rating_1->ratingcount)){ 
			$rating_1->ratingcount = 0;	 
		 }
		 if(empty($rating_2->ratingcount)){ 
			$rating_2->ratingcount = 0;	 
		 }
		 if(empty($rating_3->ratingcount)){ 
			$rating_3->ratingcount = 0;	 
		 }
		 if(empty($rating_4->ratingcount)){ 
			$rating_4->ratingcount = 0;	 
		 }
		 if(empty($rating_5->ratingcount)){ 
			$rating_5->ratingcount = 0;	 
		 }
		 
		
		$ratings = [
	1 => $rating_1->ratingcount,
    2 => $rating_2->ratingcount,
    3 => $rating_3->ratingcount,
    4 => $rating_4->ratingcount,
    5 => $rating_5->ratingcount,
			];   
		 
		 
		$totalStars = 0;
$voters = array_sum($ratings);
		 if($ratings)  
foreach ($ratings as $stars => $votes)
{
	 
    $totalStars +=  $stars * $votes;
}
   $data['voters'] = $voters;
   $data['total_rating'] = $totalStars;
	if($totalStars>0 && $voters>0){ 	
   $data['total_rating'] =  $totalStars/$voters;
	$data['avg_rating'] = $data['total_rating'];
	}else{
	$data['avg_rating'] = 0;	
	}
		 
		  
		$no_of_feedback  = $this->Common->select_join('feedback', 'bookings', array('bookings.assigned_mechanic'=>$mechanic_id, 'bookings.status'=>'Completed', 'bookings.service_date >='=>$start_date, 'bookings.service_date <='=>$end_date), 'COUNT(feedback.feedback_id) AS totalfeedbackno', 'feedback.booking_id=bookings.booking_id', 'INNER', 'Yes');
			
		if(!empty($no_of_feedback->totalfeedbackno)){ 
		$data['no_of_feedback'] = $no_of_feedback->totalfeedbackno;	
		 }else{
		$data['no_of_feedback'] = 0;	
		}					
		 
        return $data; 
    }
	 
	  
	 
	
	public function late_bookings($mechanic_id, $start_date, $end_date)
	{ 
	extract($_POST); 
		$data = [];  
	$mecbookings = $this->Common->select_wher('bookings', array('assigned_mechanic'=>$mechanic_id, 'status'=>'Completed', 'service_date >='=>$start_date, 'service_date <='=>$end_date));		 			
        $late = 0;
		if($mecbookings)
        foreach($mecbookings as $book){   
        $reached_time = $this->Common->single_row('booking_services', array('booking_id'=>$book->booking_id));	 
			if(!empty($reached_time->reached_time)){   
			$bookingtime = $book->time_slot;
			$reachdiff = getduration($reached_time->reached_time, $bookingtime); 
				if($reachdiff > 14){
				$late++;	
				}	 
			} 
        }
		return $late;
	}
	
	public function get_mechanic_performance($mechanic_id, $start_date, $end_date)
	{ 
								$total = '';
                                $quantity = '';
                                $i = 1;
                                 
								$total_booking_mechanic = $this->Common->count_all_results('bookings', array('assigned_mechanic'=>$mechanic_id, 'service_date >='=>$start_date, 'service_date <='=>$end_date));
		
								$total_booking = $this->Common->count_all_results('bookings', array('service_date >='=>$start_date, 'service_date <='=>$end_date));
		
								 
								//////////////////////////////////////////////////// MECHANIC ////////////////////////////////////////////////////	 
		
								$mechanic_bookings_for_complaints = $this->Common->select_wher('bookings', array('assigned_mechanic'=>$mechanic_id, 'service_date >='=>$start_date, 'service_date <='=>$end_date));	 
								$total_mechanic_complaints = 0;
								if($mechanic_bookings_for_complaints)
								foreach($mechanic_bookings_for_complaints as $complaint){ 
								$complaint_exists = $this->Common->single_row('customer_complaints', array('booking_id'=>$complaint->booking_id));
								if(!empty($complaint_exists->id)){
								$total_mechanic_complaints++;	
								}	
								}
								$mechanic['total_complaints']=$total_mechanic_complaints;
								
								$mechanic['totalcase']=$total_booking_mechanic;
								$gw_overall['totalcase']=$total_booking;
								
								
                                $mechanic_bookings = $this->Common->select_wher('bookings', array('assigned_mechanic'=>$mechanic_id, 'service_date >='=>$start_date, 'service_date <='=>$end_date));	 
								
		
		
								$reachdiff = 0;  
                                $amt_of_new = 0;
                                $amt_of_all = 0;   
                                $service_duration = 0; 
                                $total_distance_travelled = 0;		
                                $reachtime = 0;  
								if($mechanic_bookings)
									
									
									
								 foreach($mechanic_bookings as $book){  
                                ////////////////////////// TIME TO SERVICE
								$service_duration_q = $this->Common->single_row('booking_services', array('booking_id'=>$book->booking_id));
								if($service_duration_q->service_duration)
                                $service_duration += $service_duration_q->service_duration;	   
                                
								/// New Items Bill
                                $newitems = $this->Bookings->getbooking_jobcard_details($book->booking_id,array('status'=>'Active','booking_id'=>$book->booking_id,'aft_inspection_done'=>1));	 	
                                $item_line_id = array();
                                $count = 0;	
								if($newitems)	
                                foreach($newitems as $item){
                                $item_line_id[$count++] = $item->id; 
                                if(!empty($item->amount)){ 	
                                $amt_of_new += $item->amount;
                                }
                                }   
                                /// Total Bill
                                $totalbookbill = $this->Bookings->getbooking_details($book->booking_id); 
                                $Billcount = 0;
								if($totalbookbill)		
                                foreach($totalbookbill as $allbill){ 
                                if(!empty($allbill->actual_amount)){ 	
                                $amt_of_all += $allbill->actual_amount;
                                }
                                }   
					
                                /// Total Distance Travelled 
                                $total_distance_travelled_q = $this->Common->single_row('booking_services', array('booking_id'=>$book->booking_id));
								if(!empty($total_distance_travelled_q->distance_travelled)){  
								$total_distance_travelled += preg_replace("/[^0-9.]/", "", $total_distance_travelled_q->distance_travelled);  
								}
									 
								$total_distance_travelled_q2 = $this->Common->single_row('reschedule_log', array('booking_id'=>$book->booking_id));
								if(!empty($total_distance_travelled_q2->distance_travelled)){  
								$total_distance_travelled += preg_replace("/[^0-9.]/", "", $total_distance_travelled_q2->distance_travelled);  
								}
									 
                                $start_time_q = $this->Common->single_row('booking_services', array('booking_id'=>$book->booking_id)); 
								if(!empty($start_time_q->start_time)){ 	
								$start_time = $start_time_q->start_time; 	
								}
					
                                $service_time_q = $this->Common->single_row('booking_services', array('booking_id'=>$book->booking_id)); 			
								if(!empty($service_time_q)){	
								$service_time  = $service_time_q->service_time; 
								} 	
								 if(!empty($start_time))		
                                 $start_time = strtotime(date('H-i-s', strtotime($start_time))); 
								 if($service_time)
                                 $service_time = strtotime(date('H-i-s', strtotime($service_time))); 
								 if(!empty($start_time) && !empty($service_time))
                                 $reachtime += ($service_time - $service_time)/60;
                    }	 
                                /// New Item Bill Avg	
                                if(!empty($amt_of_new)){ 	
                                $avgbill_newitems = ($amt_of_new/$total_booking);						  
                                }else{
                                $avgbill_newitems = 0;	
                                } 
								
								$mechanic['avgbill_newitems']=$avgbill_newitems;
                                /// Total Bill Avg
                                if(!empty($amt_of_all)){ 	
                                $avgbill_total = ($amt_of_all/$total_booking);						  
                                }else{
                                $avgbill_total = 0;	
                                } 
								$mechanic['avgbill_total']=$avgbill_total;
		
                                ///////// Avg Service Time
                                if($total_booking > 0){ 	
                                $avgtime_percase_cal = ($service_duration/$total_booking);		
                                $avgtime_percase =  $avgtime_percase_cal;  
                                }else{
                                $avgtime_percase = 0;	
                                } 
								$mechanic['avgtime_percase']=$avgtime_percase;
		
                                if(!empty($total_distance_travelled)){ 
                                $avg_travel_km = $total_distance_travelled/$total_booking;
                                }else{
                                $avg_travel_km = 0;	
                                }	 
								$mechanic['total_travel_km']=$total_distance_travelled;  
								$mechanic['avg_travel_km']=$avg_travel_km;  
								$data['mechanic']=$mechanic;	
		
		
		
		
								//////////////////////////////////////////////////// GW //////////////////////////////////////////////////// 
								$gw_bookings = $this->Common->select_wher('bookings', array('service_date >='=>$start_date, 'service_date <='=>$end_date));	 			
								$reachdiff = 0;  
                                $amt_of_new = 0;
                                $amt_of_all = 0;   
                                $service_duration = 0; 
                                $total_distance_travelled = 0;		
                                $reachtime = 0;  
								if($gw_bookings)
                foreach($gw_bookings as $book){  
                                ////////////////////////// TIME TO SERVICE
								$service_duration_q = $this->Common->single_row('booking_services', array('booking_id'=>$book->booking_id));
								if(!empty($service_duration_q->service_duration))
                                $service_duration += $service_duration_q->service_duration;	   
                                
								/// New Items Bill
                                $newitems = $this->Bookings->getbooking_jobcard_details($book->booking_id,array('status'=>'Active','booking_id'=>$book->booking_id,'aft_inspection_done'=>1));	 	
                                $item_line_id = array();
                                $count = 0;	
								if($newitems)	
                                foreach($newitems as $item){
                                $item_line_id[$count++] = $item->id; 
                                if(!empty($item->amount)){ 	
                                $amt_of_new += $item->amount;
                                }
                                }   
                                /// Total Bill
                                $totalbookbill = $this->Bookings->getbooking_details($book->booking_id); 
                                $Billcount = 0;
								if($totalbookbill)		
                                foreach($totalbookbill as $allbill){ 
                                if(!empty($allbill->actual_amount)){ 	
                                $amt_of_all += $allbill->actual_amount;
                                }
                                }   
					
                                /// Total Distance Travelled 
                                $total_distance_travelled_q = $this->Common->single_row('booking_services', array('booking_id'=>$book->booking_id));
								if(!empty($total_distance_travelled_q->distance_travelled)){  
								$total_distance_travelled += preg_replace("/[^0-9.]/", "", $total_distance_travelled_q->distance_travelled);  
								}
								
								$total_distance_travelled_q2 = $this->Common->single_row('reschedule_log', array('booking_id'=>$book->booking_id));
								if(!empty($total_distance_travelled_q2->distance_travelled)){  
								$total_distance_travelled += preg_replace("/[^0-9.]/", "", $total_distance_travelled_q2->distance_travelled);  
								}
								 
                                $start_time_q = $this->Common->single_row('booking_services', array('booking_id'=>$book->booking_id)); 
								if(!empty($start_time_q->start_time)){ 	
								$start_time = $start_time_q->start_time; 	
								} 
					
                                $service_time_q = $this->Common->single_row('booking_services', array('booking_id'=>$book->booking_id)); 			
								if(!empty($service_time_q)){	
								$service_time  = $service_time_q->service_time; 
								} 	
								 if(!empty($start_time))		
                                 $start_time = strtotime(date('H-i-s', strtotime($start_time))); 
								 if($service_time)
                                 $service_time = strtotime(date('H-i-s', strtotime($service_time))); 
								 if(!empty($start_time) && !empty($service_time))
                                 $reachtime += ($service_time - $service_time)/60;
                    }	 
                                /// New Item Bill Avg	
                                if(!empty($amt_of_new)){ 	
                                $avgbill_newitems = ($amt_of_new/$total_booking);						  
                                }else{
                                $avgbill_newitems = 0;	
                                } 
								
								$gw_overall['avgbill_newitems']=$avgbill_newitems;
                                /// Total Bill Avg
                                if(!empty($amt_of_all)){ 	
                                $avgbill_total = ($amt_of_all/$total_booking);						  
                                }else{
                                $avgbill_total = 0;	
                                } 
								$gw_overall['avgbill_total']=$avgbill_total;
		
                                ///////// Avg Service Time
                                if($total_booking > 0){ 	
                                $avgtime_percase_cal = ($service_duration/$total_booking);		
                                $avgtime_percase =  $avgtime_percase_cal;  
                                }else{
                                $avgtime_percase = 0;	
                                } 
								$gw_overall['avgtime_percase']=$avgtime_percase;
		
                                if(!empty($total_distance_travelled)){ 
                                $avg_travel_km = $total_distance_travelled/$total_booking;
                                }else{
                                $avg_travel_km = 0;	
                                }	 
								$gw_overall['total_travel_km']=$total_distance_travelled;  
								$gw_overall['avg_travel_km']=$avg_travel_km;
										
								
								$data['gw_overall']=$gw_overall;
		
		
		return $data;
									 
	}
	
	public function get_mechanic_travel($mechanic_id, $start_date, $end_date)
	{
		
							 
							$today_date = created_on();
							$distance_travelled_today = 0;  
		 $mechanic_bookings = $this->Common->select_wher('bookings', array('assigned_mechanic'=>$mechanic_id, 'service_date'=>$today_date), 'service_date ASC, booking_id ASC');	   
										 
										if($mechanic_bookings) 
										foreach($mechanic_bookings as $book){  
								$service_duration_q = $this->Common->single_row('booking_services', array('booking_id'=>$book->booking_id));	   	
                                $distance_travelled =  preg_replace("/[^0-9.]/", "", $service_duration_q->distance_travelled); 
												if(!empty($distance_travelled)){ 			
												$distance_travelled_today += $distance_travelled;	  
												}
										}
		
		 $rescheduled_bookings = $this->Common->select_wher('reschedule_log', array('mechanic_id'=>$mechanic_id, 'service_date'=>$today_date), 'service_date ASC, booking_id ASC');	   
										 
										if($rescheduled_bookings) 
										foreach($rescheduled_bookings as $book_r){     
                                $distance_travelled_r =  preg_replace("/[^0-9.]/", "", $book_r->distance_travelled); 
												if(!empty($distance_travelled_r)){ 			
												$distance_travelled_today += $distance_travelled_r;	  
												}
										}
		
		
		
							 $data['travel_today'] = $distance_travelled_today; 
		
											////// THIS MONTH 
								$total_distance_travelled = 0;   
								$mechanic_bookings = $this->Common->select_wher('bookings', array('assigned_mechanic'=>$mechanic_id, 'service_date>='=>$start_date, 'service_date<='=>$end_date), 'service_date ASC, booking_id ASC');	   
										
										$eachbooking = [];
										$late = 0;
										$total_booking = 0;	
										$distance_travelled_total  = 0;
										if($mechanic_bookings) 
										foreach($mechanic_bookings as $book){ 
											
								$service_duration_q = $this->Common->single_row('booking_services', array('booking_id'=>$book->booking_id));	
								if(!empty($service_duration_q->distance_travelled)){ 			
                                $distance_travelled = preg_replace("/[^0-9.]/", "", $service_duration_q->distance_travelled); 
								}else{
								$distance_travelled = 0;	
								}
											
											
											if($book->status == 'Cancelled'){ $red_color='style="color:red;"'; }else{ $red_color=''; }
											
					$eachbooking[] = '<tr '.$red_color.'><td align="">'.$book->booking_id.'</td> <td align="">'.date('d-m-Y',strtotime($book->service_date)).'</td> <td align="">'.number_format($distance_travelled,2).'</td></tr>';	 
									$total_booking++;		
									$distance_travelled_total += 	$distance_travelled;	 
									}	
		
		
		
												//RESCHEDULED BOOKINGS 
								$rescheduled_bookings = $this->Common->select_wher('reschedule_log', array('mechanic_id'=>$mechanic_id, 'service_date>='=>$start_date, 'service_date<='=>$end_date), 'service_date ASC, booking_id ASC');	 
										if($rescheduled_bookings) 
										foreach($rescheduled_bookings as $book_r){   
								if(!empty($book_r->distance_travelled)){ 			
                                $distance_travelled_r = preg_replace("/[^0-9.]/", "", $book_r->distance_travelled); 
								}else{
								$distance_travelled_r = 0;	
								} 	 		
					$eachbooking[] = '<tr><td style="color:blue;">'.$book_r->booking_id.'</td> <td  style="color:blue;">'.date('d-m-Y',strtotime($book_r->service_date)).'</td> <td  style="color:blue;">'.number_format($distance_travelled_r,2).'</td></tr>';	 
									$total_booking++;		
									$distance_travelled_total += 	$distance_travelled_r;	 
									} 
												//RESCHEDULED BOOKINGS  END
		
		
		
											
						$data['total_bookings'] = $eachbooking;	 
						
						if($total_booking>0){ 
						$data['avg_travel'] = ($distance_travelled_total/$total_booking);
						}else{
						$data['avg_travel'] = 0;	
						}
											 
		
					return $data;		
								
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
			$spare_name =  $this->Common->single_row('spares',array('item_code' => $spare),'item_name');  
			$sparesLISTNAME .= $spare_name.' | ';
		}
		} 
		
		$labourLISTNAME = '';
		if(!empty($specific_repairs)){ 
		   foreach($specific_repairs as $repair){ 
			$repair_name =  $this->Common->single_row('labour',array('item_code' => $repair),'item_name');   
			$labourLISTNAME .= $spare_name.' | ';
		}
		}
		
		 if(!empty($otp)){ $otpsent_status='OTP Sent Successfully'; }else{ $otpsent_status='Failed to Send OTP'; }
		
		$lead_data = array( 
				'source' => $utm_source, 
				'medium' => $utm_medium,  
                'campaign' => $utm_campaign, 
                'target' => $utm_target, 
                'customer_name' => $name, 
				'customer_mobile' => $mobile,
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
				'service_category' => $service_category, 
				'service_date' => date('Y-m-d', strtotime($service_date)), 
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
			  $response['site_booking_id'] = $this->db->insert_id();	
				
			 return $response['site_booking_id'];
			 	
	}
	 
	
	       public function update_sitebooking_data($otp){  
				extract($_POST); 
			   $sitebookingdata = array(
				'otp_verify_time' => date('Y-m-d H:i:s'), 
                'otp_expired' => $otp_expired,
				'status' => $status,
            );
         $sitebookingwhere = array('id' => $site_booking_id);
         $response = $this->Main_model->update_record('site_bookings', $sitebookingdata, $sitebookingwhere); 
			   if($response){
				   return true; 
			   }else{
				   return false;
			   }   
		   }
	
			public function update_leads_data($otp){ 
				extract($_POST);
				$data_lead = array(
				'converted' => 0,
				'status' => $status,
            );
         $where_lead = array('id' => $leads_id);
          $response = $this->Main_model->update_record('leads', $data_lead, $where_lead);
				if($response){
				   return true; 
			   }else{
				   return false;
			   }  
			}
	
	
		 

	
	public function get_mechanic_cases($mechanic_id, $start_date, $end_date, $start_record, $limit){
		 				
						$mechanic_bookings = $this->Common->select_wher('bookings', array('assigned_mechanic'=>$mechanic_id, 'service_date>='=>$start_date, 'service_date<='=>$end_date), 'service_date DESC, booking_id DESC', $limit, $start_record);
							
										 $data = 'No Bookings Found!';
										if($mechanic_bookings) 
											$i=1;
									$data = '<div class="row"><div class="col-12 col-sm-12 col-lg-12">';		
										if(!empty($mechanic_bookings))
										   foreach($mechanic_bookings as $book){  
											
											$bookingdata = $this->Bookings->getbooking($book->booking_id);  
											$bookings = $bookingdata['booking'];
											$booking_details = $bookingdata['booking_details'];
											$booking_services  = $bookingdata['booking_service'];
											$booking_payment  = $bookingdata['booking_payments'];
											$booking_feedback = $bookingdata['booking_feedback'];
											
											$make  = $this->Common->single_row('vehicle_make', array('make_id' =>  $book->vehicle_make), 'make_name');  
							$model  = $this->Common->single_row('vehicle_model', array('model_id' =>  $book->vehicle_model), 'model_name'); 			
											
											$complaints_split = explode('+', $book->complaints);
						$n =1;
						$allcomplaints = '';	
									
						foreach ($complaints_split as $complaint_list){
							if(!empty($complaint_list)){   
							$allcomplaints .= $n.') '. $complaint_list.'<br>';  
							$n++;
							}
						}
						
						if($bookings->status=='Cancelled'){ 					
						$is_cancelled =  '<span class="badge badge-danger">Cancelled</span> #'.$book->booking_id;			 
						}else{
						$is_cancelled = '#'.$book->booking_id;	
						}
											
									$data .= '<div class="card">
                  <div class="card-header">
                    <h4>'.$is_cancelled.' | '.$book->customer_name.' | '.$make.'-'.$model.'<br/>'.convert_date($book->service_date).' '.$book->time_slot.'</h4>
                    <div class="card-header-action">
                     
					 	<a data-toggle="collapse" data-collapse="#mycard-collapse-'.$i.'" class="btn btn-icon btn-info" href="#"><i class="fas fa-plus"></i></a>
                    </div>
                  </div>
                  <div class="collapse" id="mycard-collapse-'.$i.'" style="">
                    <div class="card-body">
					<div class="row">
                      <div class="col-6"> Start Time</div> <div class="col-6">'.date('H:i',strtotime($booking_services->start_time)).'</div>
                      <div class="col-6"> Reached Time</div> <div class="col-6">'.date('H:i',strtotime($booking_services->reached_time)).'</div>  
                      <div class="col-6"> Work Start Time</div> <div class="col-6">'.date('H:i',strtotime($booking_services->service_time)).'</div>
                      <div class="col-6"> Work End Time</div> <div class="col-6">'.date('H:i',strtotime($booking_services->end_work_time)).'</div> 
                      <div class="col-6"> Distance Travelled </div> <div class="col-6">'.@$booking_services->distance_travelled.'</div> 
                      <div class="col-6"> Customer Rating </div> <div class="col-6">'.@$booking_feedback->feedback.'</div>
					   <div class="col-6"> Complaints</div> <div class="col-6">'.@$allcomplaints.'</div>   
					   <div class="col-6"> Payment Amount</div> <div class="col-6">'.@$booking_payment->total_amount.'</div>
					   <div class="col-6"> Payment Mode</div> <div class="col-6">'.@$booking_payment->payment_mode.'</div>
					</div>   
                    </div> 
                  </div>
                </div>';
																							  
											$i++;
											
										}
				$data .= '</div></div>';
		 
		return $data;
		
	}
	
	
	
	
	//FILE END
}

?>