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
  
class Paymentsapi extends MY_Controller
{

    public function __construct()
    {
        parent::__construct(); 
		$this->load->model('Bookings_model', 'Bookings'); 
		$this->load->model('Customer_model', 'Customer');
		$this->load->library('razorpay');	 
		$this->load->library('payments');
    } 
	 
	public function calculate_booking_fee(){
			extract($_POST);    
		
		$booking_fee_calculation = $this->payments->calculate_booking_fee($service_category, $city); 
		 $data = array(
		 'service_category' => $service_category,	 
		 'booking_fee' => $booking_fee_calculation['booking_fee'],
		 'booking_fee_slab' => $booking_fee_calculation['booking_fee_slab'],
		 'booking_fee_slab_rate' => $booking_fee_calculation['booking_fee_slab_rate'],
		 'description' => "Booking Fee for ".$service_category,
		 ); 
		 echo json_encode($data); 
		 

	}
	
	
	public function calculate_coupon(){
		extract($_POST);      
		if(!empty($discount_terms)){ 
			$discount_terms['user_type'] = $user_type;
			$discount_terms['channel'] = $channel;
			$discount_terms['city'] = $city;
			$discount_terms['service_category'] = $service_category;
			$discount_terms['service_id'] = $service_id;
			$discount_terms['coupon_code'] = $coupon_code;
			$discount_terms['discount_criteria'] = $discount_criteria;
			$discount_terms['discount_prefixed_type'] = $discount_prefixed_type;
			$discount_terms['discount_prefixed_amount'] = $discount_prefixed_amount;
		} 
		 
			$data = $this->payments->calculate_coupon($discount_terms);	  
			echo json_encode($data);  
	}
	 
	//////// WEBSITE PAYMENT GATEWAY FUNCTION
	 public function payment_gateway_options(){ 
		 extract($_POST);     
		 $customer_data = array(
		 'name' => $name,
		 'mobile' => $mobile,
		 'email' => $email, 
		 ); 
		$description = $payment_description. " for ".$service_category; 
		 $notes = array(
			 	"address"  => $payment_description. " for ".$service_category,
				"merchant_order_id" => rand(),
		 );
		 
		$data  = $this->razorpay->create_payment_package($amount,$description,$customer_data,$notes); 
		echo json_encode($data);  
	 }

	//////// WEBSITE PAYMENT DONE VERIFICATION PROCESS	
	public function payment_gateway_verify()
	{
		extract($_POST);   
		$data = [];
	    $data['verified'] = $this->razorpay->verify_payment($razorpay_payment_id, $razorpay_order_id, $razorpay_signature);  
		if(!empty($data)){ 
			 $data['status'] = 'true';
			echo json_encode($data);
		}else{
			 $data['status'] = 'false';
			echo json_encode($data); 
		}
	}
	
	public function send_payment_link($customer_id, $booking_id, $payment_description, $amount){ 
  		extract($_POST);  
		if($booking_id>0){ 
			$bookingdata = $this->Bookings->getbooking($booking_id);  
			$booking = $bookingdata['booking']; 
			   
			$data['Payment_amount'] = $amount; 
		    $payment_link_amt = ($data['Payment_amount']); 
			if(!empty($payment_link_amt) && $payment_link_amt>=1){  
		$customer_data = array('name'=>$booking->customer_name,'mobile'=>$booking->customer_mobile,'email'=>$booking->customer_email);
					$data['paymentlink'] = $this->CI->razorpay->create_payment_link($customer_data,  $booking_id, $payment_link_amt, 'Payable amount for your service', 'Final amount to be paid for you service');
		/////////////////////////////////////////////////// UPDATE BOOKING PAYMENTS START  
		if(!empty($data['paymentlink']['error']['code']) && $data['paymentlink']['error']){ 
		$booking_payments_data  = false;
		}else{
			
			 $pay_status = 'Issued'; 
			 $booking_payments_data = array(  
			'payment_status' => $pay_status,
			'payment_id' => $data['paymentlink']['id'],
			'invoice_no' => $data['paymentlink']['reference_id'],
			'payment_link' => $data['paymentlink']['short_url'],
			'payment_status' => $data['paymentlink']['status'],
			'updated_on' => date('Y-m-d H:i:s') 
        	);  
			
		    $data['paymentlink']['payment_invoice_id'] = $data['paymentlink']['id']; 
			
		}
				/////////////////////////////////////////////////// UPDATE BOOKING PAYMENTS START 
				
			}else{
		$booking_payments_data = false;		
			}  
		echo json_encode($booking_payments_data); 	
		}else{
		echo false;	
		}
		
	}
	
	/* CHECK PAYMENT LINK */	
	public function verify_payment_link($booking_id, $paymentlink_id=NULL){  
		extract($_POST);  
		if($booking_id>0){   
			if (!$paymentlink_id){
			$bookingdata = $this->Bookings->getbooking($booking_id);  
			$booking = $bookingdata['booking'];
			$booking_details = $bookingdata['booking_details'];
			$booking_payments = $bookingdata['booking_payments'];
				$paymentlink_id = $booking_payments->rz_payment_id;
				if(empty($paymentlink_id)){ $paymentlink_id='';}
			} 
		$payment_link_data = $this->razorpay->verify_payment_link($booking_id, $paymentlink_id); 
		
		
		if(!empty($payment_link_data['payment_status']) && $payment_link_data['payment_status']=='paid'){ 
		/////////////////////////////////////////////////// UPDATE BOOKING PAYMENTS START 
		$booking_payments_data = array(  
			'total_amount' => $payment_link_data['amount_collected'],
			'payment_details' => $payment_link_data['payment_details'],
			'payment_status' => $response['payment_status'],  
			'payment_mode' => $payment_link_data['payment_mode'],
			'payment_date' => $payment_link_data['payment_date'],			
			'updated_on' => updated_on(),
        ); 
		 
		}
		/////////////////////////////////////////////////// UPDATE BOOKING PAYMENTS END 
			echo json_encode($booking_payments_data); 		
		}else{
			echo false;
		} 
		  
       }
	 
	
	public function add_customer_ledger(){
			extract($_POST);  
		$customer_ledger_id = $this->payments->add_customer_ledger($transaction_type,  $booking_id, $amount, $payment_mode, $payment_status, $ref_id, $comments=''); 
		$data['customer_ledger_id'] = $customer_ledger_id;
		echo json_encode($data); 
	}
	
	
	public function get_customer_ledger(){
		extract($_POST);  
		$customer_ledger = $this->payments->get_ledger($booking_id, $transaction_type, $single); 
		$data['customer_ledger'] = $customer_ledger;
		echo json_encode($data); 
	}
	
	 
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 
	 
	
	  
	
		
	   
	
	public function calculate_package(){
		extract($_POST);   
		
		$service_name = $this->Common->single_row('services',array('id'=>$service_id), 'service_name');
		$package_name = $this->Common->single_row('service_packages',array('service_id'=>$service_id, 'package_id'=>$package_id), 'package_name');
	 
		if(empty($package_price)){ 
				$city_slug = make_slug($city);
				$service_rate =  $this->Common->single_row('service_rates',array('service_id'=>$service_id,'package_id'=>$package_id,'vehicle_category'=>$vehicle_category,'active'=>1), $city_slug);  
				if(!empty($service_rate)){ 
				$data['package_item']= array('service_name'=>$service_name, 'package_name'=>$package_name, 'package_rates'=>$service_rate);	 
				$data['total'] = $total;
				}else{
				$data = null;
				}
		}
		
		if(!empty($data)){   
			return $data;  
		}else{
		return false;		
		} 	
	}
		
	public function calculate_package_option(){
		extract($_POST);    
		$service_name = $this->Common->single_row('services',array('id'=>$service_id), 'service_name');
		$package_name = $this->Common->single_row('service_packages',array('service_id'=>$service_id, 'package_id'=>$package_id), 'package_name');
		$package_options_upsell = $this->Common->select_wher('service_option',array('id'=>$option_id, 'package_id'=>$package_id, 'option_type'=>'upsell'));
		$data['total'] = 0;
		if(empty($package_options_upsell)){  
			$upsell_total = 0;
			foreach($package_options_upsell as $option_data){ 
				 
				$service_rate =  $this->Common->single_row('service_options',array('id'=>$option_id,'package_id'=>$package_id,'option_type'=>'upsell'), $city_slug);  
				$data['package_option']['upsell']= array('service_name'=>$service_name, 'package_name'=>$package_name, 'package_rates'=>$service_rate);	 
				$upsell_total += $service_rate;
				 
			}
		}
		$data['total'] += $upsell_total;
		$package_options_crossell = $this->Common->select_wher('service_option',array('id'=>$option_id, 'package_id'=>$package_id, 'option_type'=>'crossell')); 
		if(empty($package_options_crossell)){  
			$crossell_total = 0;
			foreach($package_options_crossell as $option_data){ 
				 
				$service_rate =  $this->Common->single_row('service_options',array('id'=>$option_id,'package_id'=>$package_id,'option_type'=>'crossell'), $city_slug);  
				$data['package_option']['crossell']= array('service_name'=>$service_name, 'package_name'=>$package_name, 'package_rates'=>$service_rate);	 
				$crossell_total += $service_rate;
				 
			}
		}
		
		$data['total'] += $crossell_total;
		
		if(!empty($data)){   
			return $data;  
		}else{
		return false;		
		} 
	}
		
	public function calculate_complaint(){
		
		extract($_POST);   
		
		foreach($all_complaints as $this_complaint){ 
		$complaint_data = array();
		 
		 
		
		$get_options  = $this->single_row('complaints', array('id' => $this_complaint->complaint_id));
		 
		$option_list = array($get_options->option1, $get_options->option2, $get_options->option3, $get_options->option4, $get_options->option5, $get_options->option6);
		
		$options = 1;
			$total_combined = [];
		 foreach ($option_list as $option) {  
		 
		if($option!='NA' && $option!='N' && !empty($option)){
		
		$spares = $this->spares_dropdown($vehicle_category, $model_code, $option, $channel, $city, 'complaint');
		$spare = $spares[0]; 
			
		 if(!empty($spare['totalrates'])){   
			  $total_combined[] = $spare['totalrates']; 
		 }
				 
		 $labours = $this->labour_dropdown($vehicle_category, $model_code, $city, $option, 'complaint'); 
		 $labour = $labours[0];	
		 if(!empty($labour['totalrates'])){  
			 $total_combined[] = $labour['totalrates'];
		 }
			
			$options++;
		     
			} 
		
			 $complaint_range = min($total_combined).'-'.max($total_combined);
			 $complaint_data[] = array('complaints'=>$get_options->complaints, 'complaint_rates'=>$complaint_range);	 
			 
			 
		  }
			
			 
			 
		 
		}
		
		
		
		if(!empty($complaint_data)){   
			return $complaint_data;  
		}else{
		return false;		
		} 	
		
	}
		
	public function calculate_spares(){
		extract($_POST);   
		 
		foreach($all_spares as $this_spare){  
		$spares = $this->spares_dropdown($vehicle_category, $model_code, $this_spare, $channel, $city, FALSE);
		$spare = $spares[0];  
		 if(!empty($spare['totalrates'])){   
			  $total_rate[] = $spare['totalrates']; 
		 }  
			 $spares_data[] = array('spare_id'=>$spare['id'], 'spare_name'=>$spare['text'], 'spares_rate'=>$total_rate);
			  
		}
		
		 
		
		if(!empty($spares_data)){   
			return $spares_data;  
		}else{
		return false;		
		} 
	}
		
	public function calculate_labour(){
		extract($_POST);   
		
		foreach($all_spares as $this_labour){  
		$labours = $this->labour_dropdown($vehicle_category, $model_code, $this_labour, $channel, $city, FALSE);
		$labour = $labours[0];  
		 if(!empty($labour['totalrates'])){   
			  $total_rate[] = $labour['totalrates']; 
		 }  
			 $labour_data[] = array('labour_id'=>$labour['id'], 'labour_name'=>$labour['text'], 'labour_rate'=>$total_rate);	 
		}
		
	 
		
		if(!empty($labour_data)){   
			return $labour_data;  
		}else{
		return false;		
		}
	}
	
	
	// Show Customer Invoice details
    public function customer_invoice()
    {
        $booking_id = base64_decode($this->uri->segment(3));
       // $this->header($title = "Booking Invoice"); 
		$bookings_data = $this->Bookings->getbooking($booking_id);
		$data['booking'] = $bookings_data['booking'];
		$data['booking_payments'] = $bookings_data['booking_payments'];
		$data['jobcard'] = $bookings_data['jobcard'];
		$data['jobcard_details'] = $bookings_data['jobcard_details'];
		
		//$data['surveyDetail'] = $this->Common->single_row('claims', $where, 's');
        $this->load->view('bookings/customer_invoice', $data);
       // $this->footer();
    }
	
	

}