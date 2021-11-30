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
 
 
   
	
class payments
{
	 
	 
	function __construct()
	{
		$settings = get_general_settings();  
		$this->CI =& get_instance();
        $this->CI->load->helper(array('form', 'url', 'email'));
		$this->CI->load->library('razorpay');
		$this->CI->load->model('Bookings_model', 'Bookings');  
	}
	
	//CALCULATE BOOKING FEE | PAY AT CREATE BOOKING - CART LEVEL
	
	public function calculate_booking_fee($service_category, $city){
			 
		 $service_category_rate = $this->CI->Common->single_row('service_category', array('service_name'=>$service_category), $city);		
		 $service_rate_structure = $this->CI->Common->single_row('service_rate_structure', array('service_category'=>$service_category));
						$booking_fee = 0;
						if(!empty($service_rate_structure->booking_advance) && !empty($service_rate_structure->booking_advance_type)){
							if($service_rate_structure->booking_advance_type=='flat'){
							$booking_fee = $service_rate_structure->booking_advance;	
							}elseif($service_rate_structure->booking_advance_type=='percentage'){
							$booking_fee  = ($service_category_rate * $service_rate_structure->booking_advance) / 100;
							} 
						}else{
						$booking_fee = $service_category_rate;
						}		
		
		 $data = array(
		 'service_category' => $service_category,	 
		 'booking_fee' => $booking_fee,
		 'booking_fee_slab' => @$service_rate_structure->booking_advance_type,
		 'booking_fee_slab_rate' => @$service_rate_structure->booking_advance, 
		 );
		
		 return $data; 
		 

	}
	
	
	
	public function get_all_coupons($coupon_details=NULL,$stage='cart'){
		 
		 
		
		 
		$mobile = $coupon_details['mobile'];
		$customer_type = $coupon_details['customer_type'];
		$zone = $coupon_details['zone'];
		$make = $coupon_details['make'];
		$model = $coupon_details['model'];
		$vehicle_category = $coupon_details['vehicle_category'];
		$service_category = $coupon_details['service_category'];
		 
		 $all_coupon_id = $this->CI->Common->select_wher('coupons',array('active'=>1, 'expiry_date>='=>date('Y-m-d')));	 
		
		$coupons = [];
			
			if($all_coupon_id)
				foreach($all_coupon_id as $coupon_id){ 
				$valid_coupon = 1;	
								if(!empty($coupon_id->zone) && $coupon_id->zone != 'all'){   
									 if($zone==$coupon_id->zone){ $valid_coupon = 1; }else{	$valid_coupon = 0;	} 
								}
								if(!empty($coupon_id->make) && $coupon_id->make != 'all'){    
									if($make==$coupon_id->make){ $valid_coupon = 1; }else{	$valid_coupon = 0;	}
								}
								if(!empty($coupon_id->model) && $coupon_id->model != 'all'){    
									if($model==$coupon_id->model){ $valid_coupon = 1; }else{	$valid_coupon = 0;	}
								}
								if(!empty($coupon_id->vehicle_category) && $coupon_id->vehicle_category != 'all'){    
									if($vehicle_category==$coupon_id->vehicle_category){ $valid_coupon = 1; }else{	$valid_coupon = 0;	}
								}
								if(!empty($coupon_id->service_category) && $coupon_id->service_category != 'all'){    
									if($service_category==$coupon_id->service_category){ $valid_coupon = 1; }else{	$valid_coupon = 0;	}
								}
								if(!empty($coupon_id->customer_type) && $coupon_id->customer_type != 'all'){  
									if($customer_type==$coupon_id->customer_type){ $valid_coupon = 1; }else{	$valid_coupon = 0;	} 
								}
								if(!empty($coupon_id->single_use) && $coupon_id->single_use>0){ 
									$coupon_used = $this->CI->Common->count_all_results('coupon_history', array('mobile'=>$mobile, 'coupon_id'=>$coupon_id->id));
										if($coupon_used<1){ $valid_coupon = 1; }else{	$valid_coupon = 0;	}
								} 
						if(!empty($coupon_id->id)){    
								 
								 $coupons[] = array('coupon_id'=>$coupon_id->id,'coupon_code'=>$coupon_id->coupon_code,'coupon_details'=>$coupon_id->details,'valid'=>$valid_coupon);	 
						} 		   
				} 
		
			return  $coupons; 	 
		 
		
		 
	}
	 
	
		//CALCULATE COUPONS | APPLY AT CART LEVEL | COUPON CODE
	
	public function calculate_coupon($coupon_details=NULL,$stage='cart'){
		 
		 $valid_coupon = 1;
		
		$coupon_code = $coupon_details['coupon_code'];
		$mobile = $coupon_details['mobile'];
		$customer_type = $coupon_details['customer_type'];
		$zone = $coupon_details['zone'];
		$make = $coupon_details['make'];
		$model = $coupon_details['model'];
		$vehicle_category = $coupon_details['vehicle_category'];
		$service_category = $coupon_details['service_category'];
		$city = $coupon_details['city'];
		
		
		 $coupon_id = $this->CI->Common->single_row('coupons',array('coupon_code'=>$coupon_code, 'active'=>1, 'expiry_date>='=>date('Y-m-d')));	 
		
		
		        if(!empty($coupon_id->zone) && $coupon_id->zone != 'all'){   
					
					if($zone==$coupon_id->zone){ $valid_coupon = 1; }else{	$valid_coupon = 0;	}
				
				}
					
				if(!empty($coupon_id->make) && $coupon_id->make != 'all'){    
					
					if($make==$coupon_id->make){ $valid_coupon = 1; }else{	$valid_coupon = 0;	}
				
				}
					
				if(!empty($coupon_id->model) && $coupon_id->model != 'all'){    
					
					if($model==$coupon_id->model){ $valid_coupon = 1; }else{	$valid_coupon = 0;	}
				
				}
				
				if(!empty($coupon_id->vehicle_category) && $coupon_id->vehicle_category != 'all'){    
					
					if($vehicle_category==$coupon_id->vehicle_category){ $valid_coupon = 1; }else{	$valid_coupon = 0;	}
				
				}
		
				if(!empty($coupon_id->service_category) && $coupon_id->service_category != 'all'){    
					
					if($service_category==$coupon_id->service_category){ $valid_coupon = 1; }else{	$valid_coupon = 0;	}
				
				}
				  
				if(!empty($coupon_id->customer_type) && $coupon_id->customer_type != 'all'){    
					
					if($customer_type==$coupon_id->customer_type){ $valid_coupon = 1; }else{	$valid_coupon = 0;	}
				
				}
		
				if(!empty($coupon_id->single_use) && $coupon_id->single_use>0){    
					
					$coupon_used = $this->CI->Common->count_all_results('coupon_history', array('mobile'=>$mobile, 'coupon_id'=>$coupon_id->id));
					
						if($coupon_used<1){ $valid_coupon = 1; }else{	$valid_coupon = 0;	}
				
				}
		
		if($valid_coupon==1 && !empty($coupon_id->id)){ 
				 
			 
			
				if($coupon_id->coupon_level=='cart'){ 
					$coupon_rules = $this->CI->Common->single_row('coupon_rules',array('coupon_id'=>$coupon_id->id));	 
				  //id	coupon_id	type	value	criteria	rule	

						if($coupon_rules){
							
							if($coupon_rules->type=='product'){
											if(!empty($coupon_rules->product) && !empty($coupon_rules->product_type)){ 
												 $data['discount_type']  = $coupon_rules->type; 
												 $data['discount_product']  = $coupon_rules->product; 
												 $data['discount_product_type']  = $coupon_rules->product_type; 
												 $data['discount_amount']  = $coupon_rules->amount;
												 $data['discount_criteria']  = $coupon_rules->criteria;
											}else{
												  $data['discount_type']  = ''; 
												  $data['discount_product']  = ''; 
												  $data['discount_product_type']  = ''; 
												  $data['discount_amount']  = 0;
												  $data['discount_criteria']  = '';
											 }
							}else{ 
								
								$service_rate = get_service_category_rates($service_category, $city, $vehicle_category);  
											if(!empty($coupon_rules->amount) && !empty($coupon_rules->type)){ 	 
															if($coupon_rules->type=='slab'){
															$discount_amount = $service_rate-$coupon_rules->amount;	
															}elseif($coupon_rules->type=='flat'){
															$discount_amount = $coupon_rules->amount;	
															}elseif($coupon_rules->type=='percentage'){
															 $sparesrate = $service_rate - ($service_rate * ($coupon_rules->amount / 100));
															}else{ 
															$discount_amount = 0;
															} 
												 $data['discount_type']  = $coupon_rules->type;  
												 $data['discount_amount']  = $discount_amount;
												  $data['discount_criteria']  = $coupon_rules->criteria;
											}else{
												  $data['discount_type']  = ''; 
												  $data['discount_amount']  = 0;
												  $data['discount_criteria']  = '';
											 }  
											
							}

						}

				}

		} 		 
			$data['valid_coupon']  = $valid_coupon; 
		
			return  $data; 	 
		 
		
		 
	}
	
	
	public function recheck_coupon($booking_id,$stage='cart'){
		 
		 $bookingdata = $this->CI->Bookings->getbooking($booking_id); 
			$bookings = $bookingdata['booking'];   
		$coupon_code = $bookings->coupon_code;
		$mobile = $bookings->customer_mobile;
		$customer_type = $bookings->customer_type;
		$zone = $bookings->zone_id;
		
		  $model_det  = get_model($model_id,TRUE); 
		
		$make =  $bookings->vehicle_make;
		$model = $bookings->vehicle_model;
		$vehicle_category = $model_det->vehicle_category;
		$service_category = get_service_category($bookings->service_category_id);
		$city = $bookings->customer_city;
		
		
		 $coupon_id = $this->CI->Common->single_row('coupons',array('coupon_code'=>$coupon_code, 'active'=>1, 'expiry_date>='=>date('Y-m-d')));	 
		
		
		        if(!empty($coupon_id->zone) && $coupon_id->zone != 'all'){   
					
					if($zone==$coupon_id->zone){ $valid_coupon = 1; }else{	$valid_coupon = 0;	}
				
				}
					
				if(!empty($coupon_id->make) && $coupon_id->make != 'all'){    
					
					if($make==$coupon_id->make){ $valid_coupon = 1; }else{	$valid_coupon = 0;	}
				
				}
					
				if(!empty($coupon_id->model) && $coupon_id->model != 'all'){    
					
					if($model==$coupon_id->model){ $valid_coupon = 1; }else{	$valid_coupon = 0;	}
				
				}
				
				if(!empty($coupon_id->vehicle_category) && $coupon_id->vehicle_category != 'all'){    
					
					if($vehicle_category==$coupon_id->vehicle_category){ $valid_coupon = 1; }else{	$valid_coupon = 0;	}
				
				}
		
				if(!empty($coupon_id->service_category) && $coupon_id->service_category != 'all'){    
					
					if($service_category==$coupon_id->service_category){ $valid_coupon = 1; }else{	$valid_coupon = 0;	}
				
				}
				  
				if(!empty($coupon_id->customer_type) && $coupon_id->customer_type != 'all'){    
					
					if($customer_type==$coupon_id->customer_type){ $valid_coupon = 1; }else{	$valid_coupon = 0;	}
				
				}
		
				if(!empty($coupon_id->single_use) && $coupon_id->single_use>0){    
					
					$coupon_used = $this->CI->Common->count_all_results('coupon_history', array('mobile'=>$mobile, 'coupon_id'=>$coupon_id->id));
					
						if($coupon_used<1){ $valid_coupon = 1; }else{	$valid_coupon = 0;	}
				
				}
		
		if($valid_coupon==1 && !empty($coupon_id->id) && $coupon_id>0){ 
				 
			 
			
				if($coupon_id->coupon_level=='cart'){ 
					$coupon_rules = $this->CI->Common->single_row('coupon_rules',array('coupon_id'=>$coupon_id->id));	 
				  //id	coupon_id	type	value	criteria	rule	

						if($coupon_rules){
							
							if($coupon_rules->type=='product'){
											if(!empty($coupon_rules->product) && !empty($coupon_rules->product_type)){ 
												 $data['discount_type']  = $coupon_rules->type; 
												 $data['discount_product']  = $coupon_rules->product; 
												 $data['discount_product_type']  = $coupon_rules->product_type; 
												 $data['discount_amount']  = $coupon_rules->amount;
												 $data['discount_criteria']  = $coupon_rules->criteria;
												
											$jobcard_details_data = array( 
												'spares_rate' => $coupon_rules->amount,  
												'labour_rate' => 0, 
												'amount' => $coupon_rules->amount,   
												'endpoint' => 'coupon_work_end',  
												'coupon_applied' => 1,
												);
											
										$where = array('item_type'=>$coupon_rules->product_type, 'item'=>$coupon_rules->product, 'booking_id' => $booking_id);
										$update_jobcard = $this->Common->update_record('jobcard_details', $jobcard_details_data, $where); 
											}else{
												  $data['discount_type']  = ''; 
												  $data['discount_product']  = ''; 
												  $data['discount_product_type']  = ''; 
												  $data['discount_amount']  = 0;
												  $data['discount_criteria']  = '';
											 }
							}else{ 
								
								$service_rate = get_service_category_rates($service_category, $city, $vehicle_category);  
											if(!empty($coupon_rules->amount) && !empty($coupon_rules->type)){ 	 
															if($coupon_rules->type=='slab'){
															$discount_amount = $service_rate-$coupon_rules->amount;	
															}elseif($coupon_rules->type=='flat'){
															$discount_amount = $coupon_rules->amount;	
															}elseif($coupon_rules->type=='percentage'){
															 $sparesrate = $service_rate - ($service_rate * ($coupon_rules->amount / 100));
															}else{ 
															$discount_amount = 0;
															} 
												 $data['discount_type']  = $coupon_rules->type;  
												 $data['discount_amount']  = $discount_amount;
												  $data['discount_criteria']  = $coupon_rules->criteria;
												
										$ledger_data = array( 
										 'ref_no'=>@$ref_no,
										 'requested_amount'=>$$discount_amount, 
										 'parent_id'=>$booking_id, 
										 'comments'=>'Final End Work Calculation',
										 'remark'=>'coupon: '.$coupon_code, 
										);
											
										$demand_discount = $this->update_customer_ledger($booking_id, 'discount', $ledger_data);
												
												
											}else{
												  $data['discount_type']  = ''; 
												  $data['discount_amount']  = 0;
												  $data['discount_criteria']  = '';
											 }  
								 
									
									
							}

						}

				}

		} 		 
			$data['valid_coupon']  = $valid_coupon; 
		
			return  $data; 	 
		 
		
		 
	}
	 
	
	 public function get_ledger($booking_id, $transaction_type='all', $single=NULL){
		if($transaction_type=='all'){
		$this_ledger_data = $this->CI->Common->select_wher('customer_ledger', array('booking_id'=>$booking_id));
		}else{
			if($single){ 
			$this_ledger_data = $this->CI->Common->single_row('customer_ledger', array('booking_id'=>$booking_id, 'transaction_type'=>$transaction_type), $single);	
				if(empty($this_ledger_data) && $single!='mode' && $single!='created_on' && $single!='updated_on'){ $this_ledger_data = 0; }
			}else{
			$this_ledger_data = $this->CI->Common->single_row('customer_ledger', array('booking_id'=>$booking_id, 'transaction_type'=>$transaction_type));		
			}
		}
		return $this_ledger_data;
	}
	
					
		/* PAYMENT DETAILS */	
	public function get_payment_details($booking_id){ 
		 
		if($booking_id>0){  
			$final_amt = $this->calculate_final_payment($booking_id);
			
			if($final_amt==0){ 
			$this->CI->Bookings->UpdatePaymentProcess(FALSE, 'Paid', FALSE, FALSE, FALSE, $final_amt, FALSE, FALSE);  
			}else{ 
			$this->CI->Bookings->UpdatePaymentProcess(FALSE, FALSE, FALSE, FALSE, FALSE, $final_amt, FALSE, FALSE);  
			}
			
			$bookingdata = $this->CI->Bookings->getbooking($booking_id); 
			$bookings = $bookingdata['booking']; 
			$booking_payments = $bookingdata['booking_payments']; 
		    if(!empty($booking_payments->net_payable)){
				$total_amount = $booking_payments->net_payable;
			}else{
				$total_amount = 0;
			} 
			 
		$data['Payment_amount'] = $total_amount;
		$data['Payment_Status'] = $booking_payments->payment_status;
			if($booking_payments->payment_status == 'Issued'){
			$data['rz_payment_id'] = $booking_payments->rz_payment_id;		
			}
        $data['UPI_QR'] = base_url().'uploads/UPI.png';
		$data['UPI_ID'] = 'garageworks@okicici';	
		$data['PAYTM_QR'] = base_url().'uploads/PAYTM.png';	 
		return $data;
		
		}else{
		return false;	
		}
		
	}   
	
	
	   
 
	 
	 /* FINAL PAYMENT CALCULATION */	
	public function calculate_final_payment($booking_id, $calculate_on_stage="Auto"){ 
	 
		if($booking_id>0){  
			 
					 $bookingdata = $this->CI->Bookings->getbooking($booking_id);  
			$booking = $bookingdata['booking'];
			$booking_details = $bookingdata['booking_details'];
			$booking_payments = $bookingdata['booking_payments'];
			
			
					$this_ledger_jobcard_total = $this->get_ledger($booking_id, 'jobcard_total','requested_amount');
					$this_ledger_discount = $this->get_ledger($booking_id, 'discount','received_amount');
					$this_ledger_booking_fee = $this->get_ledger($booking_id, 'booking_fee','received_amount');
					$this_ledger_service_advance = $this->get_ledger($booking_id, 'service_advance','received_amount');
					$this_ledger_round_off = $this->get_ledger($booking_id, 'round_off','requested_amount');
					$this_ledger_final_pay = $this->get_ledger($booking_id, 'final_paid','received_amount'); 
					$invoice_total = $this_ledger_jobcard_total-$this_ledger_discount;  
					$net_payable = $invoice_total-$this_ledger_booking_fee-$this_ledger_service_advance-$this_ledger_round_off-$this_ledger_final_pay;  
					if($net_payable<$this_ledger_booking_fee){ 
					$final_payable_amount = 0;  
					}else{ 
					$final_payable_amount =	$net_payable; 
					}    
					
					$this->CI->Bookings->UpdatePaymentProcess($this_ledger_final_pay, FALSE, FALSE, FALSE, FALSE, $net_payable, $this_ledger_discount, $invoice_total); 
			
					$net_payable_exists = $this->CI->Common->single_row('customer_ledger', array('booking_id'=>$booking_id, 'transaction_type'=>'net_payable'),'id'); 
					if(!empty($net_payable_exists) && $net_payable_exists>0){ 
							$ledger_data = array(   
										 'customer_id'=>$booking->customer_id, 
										 'booking_id'=>$booking_id,
										 'transaction_type'=>'net_payable', 
										 'ref_no'=>@$ref_no,
										 'requested_amount'=>$final_payable_amount,
										 'mode'=>'Auto',
										 'status'=>'Auto',
										 'parent_id'=>$booking_id,
										 'connection'=>'',
										 'comments'=>'Calculate Automatically',
										 'remark'=>$calculate_on_stage,
										 'created_on'=>created_on(),
										 'created_by'=>created_by(), 
										 'updated_on'=>updated_on() 
										); 
					$update_service_advance = $this->update_customer_ledger($booking_id, 'net_payable', $ledger_data); 
						}else{
					$demand_service_advance = $this->add_customer_ledger('net_payable', $booking_id, $final_payable_amount, 'Final Calculation', $calculate_on_stage); 
						}
					
								
			return $final_payable_amount;
				
		}else{
			return false;
		} 
		  
       }
	 
	
	public function request_final_payment($booking_id, $nostatuschange=NULL){
		
		$bookingdata = $this->CI->Bookings->getbooking($booking_id);  
				$booking = $bookingdata['booking'];
		$final_amt = $this->calculate_final_payment($booking_id);
		
		if($booking->booking_medium!='app'){ 
		 				$data['Payment_amount'] = $final_amt; 
						$payment_link_amt = ($data['Payment_amount']); 
						if(!empty($payment_link_amt) && $payment_link_amt>=1){  
							$customer_data = array('name'=>$booking->customer_name,'mobile'=>$booking->customer_mobile,'email'=>$booking->customer_email);
					$data['paymentlink'] = $this->CI->razorpay->create_payment_link($customer_data,  $booking_id, $payment_link_amt, 'Payable amount for your service', 'Final amount to be paid for you service');
					/////////////////////////////////////////////////// UPDATE BOOKING PAYMENTS START  
					if(!empty($data['paymentlink']['error']['code']) && $data['paymentlink']['error']){ 
					$payments_data  = false;
					}else{
							
						if($nostatuschange){ 
						 $pay_status = 'Not Paid'; 
						}else{
						 $pay_status = 'Issued'; 	
						}
						 $payments_data = array(  
						'payment_status' => $pay_status,
						'payment_id' => $data['paymentlink']['id'],
						'invoice_no' => $data['paymentlink']['reference_id'],
						'payment_link' => $data['paymentlink']['short_url'],
						'payment_status' => $data['paymentlink']['status'],
						'updated_on' => date('Y-m-d H:i:s') 
						);  
						
						
											$booking_payments_data = array(  
											'payment_status' => $pay_status,
											'rz_payment_id' => $data['paymentlink']['id'],
											'rz_invoice_no' => $data['paymentlink']['reference_id'],
											'rz_payment_link' => $data['paymentlink']['short_url'],
											'rz_payment_status' => $data['paymentlink']['status'],
											'updated_on' => date('Y-m-d H:i:s')

										); 
										$where = array('booking_id' => $booking_id); 
										$this->CI->Common->update_record('booking_payments', $booking_payments_data, $where); 
										 


						$data['paymentlink']['payment_invoice_id'] = $data['paymentlink']['id']; 

					}
							/////////////////////////////////////////////////// UPDATE BOOKING PAYMENTS START 
								 
						}else{
					$payments_data = false;		
						}   
	 
		}else{
			
			 $this->CI->Customerapi->request_final_payment($booking_id);
		}
	 
		 return $this->get_payment_details($booking_id); 
		
	}
	
	
	/* CHECK PAYMENT LINK */	
	public function verify_final_payment($booking_id){
		    
	 
			$final_amt = $this->calculate_final_payment($booking_id); 
			if($final_amt>0){ 
		$bookingdata = $this->CI->Bookings->getbooking($booking_id);  
			$booking = $bookingdata['booking'];
			$booking_details = $bookingdata['booking_details'];
			$booking_payments = $bookingdata['booking_payments'];
			
		
		if($booking->booking_medium!='app'){ 
			
				$paymentlink_id = $booking_payments->rz_payment_id;
			
				if(!empty($paymentlink_id)){ 
					 
					 $payment_link_data = $this->CI->razorpay->verify_payment_link($booking_id, $paymentlink_id);    
		if(!empty($payment_link_data['payment_status']) && $payment_link_data['payment_status']=='paid'){ 
		/////////////////////////////////////////////////// UPDATE BOOKING PAYMENTS START 
		$booking_payments_data = array(  
			'total_amount' => $payment_link_data['amount_collected'],
			'payment_status' => 'Paid', 
			'rz_payment_status' => 'Paid',
			'payment_mode' => 'Online',
			'rz_payment_mode' => $payment_link_data['payment_mode'],
			'payment_date' => $payment_link_data['payment_date'],			
			'updated_on' => updated_on()
        ); 
		$where = array('booking_id' => $booking_id);
        $this->CI->Common->update_record('booking_payments', $booking_payments_data, $where);  
			$this->collect_customer_ledger($booking_id, 'final_paid', $payment_link_data['amount_collected'], 'Razorpay', 'Paid', $paymentlink_id, 'Paid through link on '.$payment_link_data['payment_date']); 
			
		}
		/////////////////////////////////////////////////// UPDATE BOOKING PAYMENTS END
					
				} 
			
			}
		}
		 return $this->get_payment_details($booking_id); 
		
       }
	
	
	/* CHECK PAYMENT LINK */	
	public function process_final_payment($booking_id, $amount_collected, $payment_status, $payment_mode, $payment_date, $payment_comments, $payment_remaks='Manual Collection'){
		    
	 
			$final_amt = $this->calculate_final_payment($booking_id); 
			
			$bookingdata = $this->CI->Bookings->getbooking($booking_id);  
			$booking = $bookingdata['booking'];
			$booking_details = $bookingdata['booking_details'];
			$booking_payments = $bookingdata['booking_payments'];
			
		
		if($final_amt>0){  
		  
			if(empty($amount_collected)){ $amount_collected = $final_amt;}
			
		/////////////////////////////////////////////////// UPDATE BOOKING PAYMENTS START 
		$booking_payments_data = array(  
			'total_amount' => $amount_collected,
			'payment_status' => $payment_status,  
			'payment_mode' => $payment_mode, 
			'payment_date' => $payment_date,
			'comments' => $payment_comments,
			'updated_on' => updated_on()
        ); 
		$where = array('booking_id' => $booking_id);
			
        $this->CI->Common->update_record('booking_payments', $booking_payments_data, $where);  
	    $this->collect_customer_ledger($booking_id, 'final_paid', $amount_collected, $payment_mode, $payment_status, 'Manual Collection', $payment_comments, $payment_remaks); 
			 
		 
		/////////////////////////////////////////////////// UPDATE BOOKING PAYMENTS END
					
				}  
		 
		 return $this->get_payment_details($booking_id); 
		
       }
	
	
	public function add_customer_ledger($transaction_type, $booking_id, $amount, $comments='', $remark='Added'){
	  	
				$bookingdata = $this->CI->Bookings->getbooking($booking_id);  
				$booking = $bookingdata['booking']; 
		
					$ledger_data = array(
										 'customer_id'=>$booking->customer_id, 
										 'booking_id'=>$booking_id,
										 'transaction_type'=>$transaction_type,
										 'ref_no'=>@$ref_no,
										 'requested_amount'=>$amount,
										 'mode'=>'',
										 'status'=>'',
										 'parent_id'=>$booking_id,
										 'connection'=>'',
										 'comments'=>@$comments,
										 'remark'=>@$remark,
										 'created_on'=>created_on(),
										 'created_by'=>created_by()
										);
		 
		 		$this->CI->Common->add_record('customer_ledger', $ledger_data); 
		$customer_ledger_id = $this->CI->db->insert_id();	
		 
		
		if(!empty($customer_ledger_id)){   
		return $customer_ledger_id;  
		}else{
		return false;		
		}
	}
	
	 
	
	public function collect_customer_ledger($booking_id, $transaction_type, $amount, $payment_mode, $payment_status, $ref_no, $comments="", $remark="Collected"){
 
		$bookingdata = $this->CI->Bookings->getbooking($booking_id);  
				$booking = $bookingdata['booking']; 
		
		$where = array('booking_id'=>$booking_id, 'transaction_type'=>$transaction_type);
				  
					$ledger_data = array(  
										 'booking_id'=>$booking_id,
										 'customer_id'=>$booking->customer_id, 
										 'transaction_type'=>$transaction_type,
										 'ref_no'=>@$ref_no,
										 'received_amount'=>$amount,
										 'mode'=>@$payment_mode,
										 'status'=>@$payment_status,
										 'parent_id'=>@$booking_id,
										 'connection'=>'',
										 'comments'=>@$comments,
										 'remark'=>@$remark,
										 'updated_on'=>updated_on() 
										);
		 
		 	$update_ledger = $this->CI->Common->update_record('customer_ledger', $ledger_data, $where);   
		
		if($update_ledger){   
			return true;  
		}else{
			return false;		
		} 
	}
	
	
	public function update_customer_ledger($booking_id, $transaction_type, $ledger_data){
 		 
		$bookingdata = $this->CI->Bookings->getbooking($booking_id);  
				$booking = $bookingdata['booking']; 
		
		$where = array('booking_id'=>$booking_id, 'transaction_type'=>$transaction_type);  
		 	$update_ledger = $this->CI->Common->update_record('customer_ledger', $ledger_data, $where);   
		
		if($update_ledger){   
			return true;  
		}else{
			return false;		
		} 
	}
	
	public function delete_customer_ledger($booking_id, $transaction_type){
 		    $where = array('booking_id'=>$booking_id, 'transaction_type'=>$transaction_type);  
		 	$delete_ledger = $this->CI->Common->delete_record('customer_ledger', FALSE, FALSE, $where);   
		
		if($$delete_ledger){   
			return true;  
		}else{
			return false;		
		} 
	}
	
	
	public function request_service_advance($booking_id, $service_advance){
		
		$bookingdata = $this->CI->Bookings->getbooking($booking_id);  
				$booking = $bookingdata['booking'];
	 
		
		if($booking->booking_medium!='app'){ 
		 				$data['Payment_amount'] = $service_advance; 
						$payment_link_amt = ($data['Payment_amount']); 
						if(!empty($payment_link_amt) && $payment_link_amt>=1){  
							$customer_data = array('name'=>$booking->customer_name,'mobile'=>$booking->customer_mobile,'email'=>$booking->customer_email);
					$data['paymentlink'] = $this->CI->razorpay->create_payment_link($customer_data,  $booking_id, $payment_link_amt, 'Service advance for your service', 'Service advance amount to be paid for you service');
					/////////////////////////////////////////////////// UPDATE BOOKING PAYMENTS START  
					if(!empty($data['paymentlink']['error']['code']) && $data['paymentlink']['error']){ 
					$payments_data  = false;
					}else{
							
						 
						 $pay_status = 'Issued'; 	
						 
						 $payments_data = array(  
						'payment_status' => $pay_status,
						'payment_id' => $data['paymentlink']['id'],
						'invoice_no' => $data['paymentlink']['reference_id'],
						'payment_link' => $data['paymentlink']['short_url'], 
						'updated_on' => date('Y-m-d H:i:s') 
						);  
						
						
											$service_advance_payments_data = array( 
											'service_advance_payment_id' => $data['paymentlink']['id'],
											'service_advance_invoice_no' => $data['paymentlink']['reference_id'],
											'service_advance_payment_link' => $data['paymentlink']['short_url'],
											'service_advance_payment_status' => $pay_status,
											'updated_on' => date('Y-m-d H:i:s')

										); 
										$where = array('booking_id' => $booking_id); 
										$this->CI->Common->update_record('jobcard', $service_advance_payments_data, $where); 
										 


						$data['paymentlink']['payment_invoice_id'] = $data['paymentlink']['id']; 

					}
							/////////////////////////////////////////////////// UPDATE BOOKING PAYMENTS START 
								 
						}else{
					$payments_data = false;		
						}   
	 
		}else{
			
			 $this->CI->Customerapi->request_service_advance($booking_id);
		}
	 
		 return $this->get_service_advance_details($booking_id); 
		
	}
	
	
	/* CHECK PAYMENT LINK */	
	public function verify_service_advance($booking_id){
	 
			
			$this_service_advance_demanded = $this->get_ledger($booking_id, 'service_advance','requested_amount');
			$this_service_advance_received = $this->get_ledger($booking_id, 'service_advance','received_amount');
		
			if($this_service_advance_demanded>0 && $this_service_advance_received<$this_service_advance_demanded){ 
		 	$bookingdata = $this->CI->Bookings->getbooking($booking_id);  
			$booking = $bookingdata['booking']; 
			$jobcard = $bookingdata['jobcard'];
		if($booking->booking_medium!='app'){  
				$paymentlink_id = $jobcard->service_advance_payment_id; 
				if(!empty($paymentlink_id)){  
					 $payment_link_data = $this->CI->razorpay->verify_payment_link($booking_id, $paymentlink_id);    
		if(!empty($payment_link_data['payment_status']) && $payment_link_data['payment_status']=='paid'){ 
		/////////////////////////////////////////////////// UPDATE BOOKING PAYMENTS START 
		$service_advance_payments_data = array(    
			'service_advance_payment_status' => 'Paid', 
			'service_advance_payment_mode' => $payment_link_data['payment_mode'], 
			'updated_on' => updated_on()
        ); 
		$where = array('booking_id' => $booking_id);
        $this->CI->Common->update_record('jobcard', $service_advance_payments_data, $where);  
			$this->collect_customer_ledger($booking_id, 'service_advance', $payment_link_data['amount_collected'], 'Razorpay', 'Paid', $paymentlink_id, 'Paid through link on '.$payment_link_data['payment_date']);  
		}
		/////////////////////////////////////////////////// UPDATE BOOKING PAYMENTS END
				} 
			}
		}
		return $this->get_service_advance_details($booking_id); 
        }
	
		/* PAYMENT DETAILS */	
	public function get_service_advance_details($booking_id){  
		if($booking_id>0){  
			$this_service_advance_demanded = $this->get_ledger($booking_id, 'service_advance','requested_amount');
			$this_service_advance_received = $this->get_ledger($booking_id, 'service_advance','received_amount');
			
			if(!empty($this_service_advance_demanded) && $this_service_advance_demanded>0){ 
		    if(!empty($this_service_advance_demanded)){
				$service_advance_amount = $this_service_advance_demanded;
			}else{
				$service_advance_amount = 0;
			} 
			 
		$data['service_advance_amount'] = $this_service_advance_demanded;
			if($this_service_advance_demanded>0 && $this_service_advance_received>=$this_service_advance_demanded){ 
		$data['service_advance_status'] = 'Paid';
											$service_advance_payments_data = array(  
											'service_advance_payment_status' => $data['service_advance_status'],
											'updated_on' => date('Y-m-d H:i:s') 
											); 
											$where = array('booking_id' => $booking_id); 
											$this->CI->Common->update_record('jobcard', $service_advance_payments_data, $where); 
			}else{
		$data['service_advance_status'] = 'Not Paid';	 
			}
			
			$bookingdata = $this->CI->Bookings->getbooking($booking_id); 
			$bookings = $bookingdata['booking']; 
			$jobcard = $bookingdata['jobcard']; 
			
			if($jobcard->service_advance_payment_status == 'Issued'){
			$data['service_advance_payment_id'] = $booking_payments->rz_payment_id;		
			}
			
        $data['UPI_QR'] = base_url().'uploads/UPI.png';
		$data['UPI_ID'] = 'garageworks@okicici';	
		$data['PAYTM_QR'] = base_url().'uploads/PAYTM.png';	 
		return $data;
		
		}else{
		return false;	
		}
		}else{
		return false;	
		}
	}   
	

}