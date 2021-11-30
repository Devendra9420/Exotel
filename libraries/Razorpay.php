<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH."third_party/razorpay/Razorpay.php");

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

/**
 * Razorpay library used to use razorpay payment gateway 
 * This library contains all CURL, etc. function to communicate with Razorpay.
 *  
 * @author 		Chintan
 * @version		1.0.0
 */
class razorpay
{
	function __construct()
	{
		
		$this->ci =& get_instance();  
		$settings = get_general_settings();  
		 $this->razor_key = $settings['razor_key'];
		$this->razor_secret_key = $settings['razor_secret_key'];
		 $this->razor_userpwd = $this->razor_key.':'.$this->razor_secret_key; 
		$this->ci->load->helper(array('form', 'url')); 
		 
	}
	
	 
	
	 
	function create_payment_link($customer_data, $booking_id, $amount, $description, $detailed_description="")
	{   
	$reciept_no = $booking_id.'_'.date('dmY_hi'); 
	$ch = curl_init();
    $fields = array();
    $fields["customer"]["name"] = $customer_data['name'];
    $fields["customer"]["email"] = $customer_data['email'];
    $fields["customer"]["contact"] = $customer_data['mobile']; 
	$fields["amount"] = $amount*100;
	$fields["currency"] = "INR";
	$fields["description"] = $description;
	$fields["reference_id"] = $reciept_no;
	$fields["accept_partial"] = false; 
	$fields["reminder_enable"] = false;
	$fields["notify"]['sms'] = true;
	$fields["notify"]['email'] = true; 
	$fields["options"]["checkout"]["name"] = "GarageWorks";	
	$fields["options"]["checkout"]["description"] = $detailed_description;		 
    curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/payment_links/');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_USERPWD, $this->razor_userpwd);
    $headers = array();
    $headers[] = 'Accept: application/json';
    $headers[] = 'Content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $data = curl_exec($ch); 
    if (empty($data) OR (curl_getinfo($ch, CURLINFO_HTTP_CODE != 200))) {
       $data = FALSE;
    } else { 
		$rs_data = json_decode($data, TRUE);
    }
    curl_close($ch);
		
    	if(!empty($rs_data['error']['code']) && $rs_data['error']){ 
		$rs_data  = 'No payment details captured';
		//$rs_data['transaction_response'] = 'failed';	
		}else{
			$razorlink_data = array(  
			'payment_status' => 'Issued',
			'rz_payment_id' => $rs_data['id'],
			'rz_invoice_no' => $rs_data['reference_id'],
			'rz_payment_link' => $rs_data['short_url'],
			'rz_payment_status' => $rs_data['status'],
			'updated_on' => date('Y-m-d H:i:s') 
        );
		//	$rs_data['transaction_response'] = 'success';
		}
		
		if($data){
			return $rs_data;
		}else{
			return $rs_data['transaction_response'];
		}
		
    }  
	
     
     
     public function verify_payment_link($booking_id, $paymentlink_id){  
	$ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/payment_links/'.$paymentlink_id);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, $this->razor_userpwd); 
    $data = curl_exec($ch); 
    if (empty($data) OR (curl_getinfo($ch, CURLINFO_HTTP_CODE != 200))) {
       $data = FALSE;
    } else { 
		$rs_data = json_decode($data, TRUE);
    }
    curl_close($ch);  
	if(!empty($rs_data['status'])){ 
		if($rs_data['status'] == 'paid'){ 
			$response['payment_details'] = $rs_data; 
		    $response['payment_status'] = $rs_data['status'];
			$response['amount_collected'] = $rs_data['amount_paid']/100; 
			$response['payment_mode'] = $rs_data['payments'][0]['method']; 
			$response['payment_date'] = date('Y-m-d', $rs_data['updated_at']);  
		}else{
			$response['payment_details'] = $rs_data; 
		    $response['payment_status'] = $rs_data['status'];
			$response['amount_collected'] = false; 
			$response['payment_mode'] = false; 
			$response['payment_date'] = false; 
		}
	}else{
			$response['payment_details'] = false; 
		    $response['payment_status'] = false;
			$response['amount_collected'] = false; 
			$response['payment_mode'] = false;
			$response['payment_date'] = false; 
		}
            
           return $response; 
       }
     
    public function create_payment_package($amount,$description,$customer_data,$notes)
	{
		
		$this->CI =& get_instance();
		$general_settings = get_general_settings();
		$razor_key = $general_settings['razor_key'];
		$razor_secret_key = $general_settings['razor_secret_key']; 
		$api = new Api($razor_key, $razor_secret_key); 
		$razorpayOrder = $api->order->create(array(
			'receipt'         => rand(),
			'amount'          => $amount * 100, // in paisa
			'currency'        => 'INR',
			'payment_capture' => 1 // auto capture
		));
 
		$amount = $razorpayOrder['amount']; 
		$razorpayOrderId = $razorpayOrder['id']; 
 
		$data = array(
			"key" => $this->razor_key,
			"amount" => $amount,
			"name" => $general_settings['application_name'],
			"description" => $description,
			"image" => base_url().'logo.png',
			"prefill" => array(
				"name"  => $customer_data['name'],
				"email"  => $customer_data['email'],
				"mobile" => $customer_data['mobile'],
			),
			"notes"  => $notes,
			"theme"  => array(
				"color"  => "#41adef",
				"image_padding" => false,
			),
			"order_id" => $razorpayOrderId,
		);
		
		return $data;
	}
	
	
	 
	
     public function verify_payment($razorpay_payment_id, $razorpay_order_id, $razorpay_signature)
	{
		$success = true;
		$error = "payment_failed";
		
		 
		 
		if (empty($razorpay_payment_id) === false) {
			$api = new Api($this->razor_key, $this->razor_secret_key);
		try {
				$attributes = array(
					'razorpay_order_id' => $razorpay_order_id,
					'razorpay_payment_id' => $razorpay_payment_id,
					'razorpay_signature' => $razorpay_signature
				);
				$api->utility->verifyPaymentSignature($attributes);
			} catch(SignatureVerificationError $e) {
				$success = false;
				$error = 'Razorpay_Error : ' . $e->getMessage();
			}
		}
		if ($success === true) {
			 
			return true; 
		}
		else {
			return false; 
		}
	}
	
	
	public function fetch_payment_details($razorpay_payment_id)
	{
		$success = true;
		$error = "payment_failed";
		
		 
		 
		if (empty($razorpay_payment_id) === false) {
			$api = new Api($this->razor_key, $this->razor_secret_key);
		try {
				$attributes = array(
					'razorpay_order_id' => $razorpay_order_id,
					'razorpay_payment_id' => $razorpay_payment_id,
					'razorpay_signature' => $razorpay_signature
				);
			$get_payment_data =	$api->payment->fetch($paymentId);
			
			
			$get_payment_data =	$api->payment->fetch($paymentId);
			
			} catch(SignatureVerificationError $e) {
				$success = false;
				$error = 'Razorpay_Error : ' . $e->getMessage();
			}
		}
		if ($success === true) {
			 
			//{
//  "id": "pay_G8VQzjPLoAvm6D",
//  "entity": "payment",
//  "amount": 1000,
//  "currency": "INR",
//  "status": "captured",
//  "order_id": "order_G8VPOayFxWEU28",
//  "invoice_id": null,
//  "international": false,
//  "method": "upi",
//  "amount_refunded": 0,
//  "refund_status": null,
//  "captured": true,
//  "description": "Purchase Shoes",
//  "card_id": null,
//  "bank": null,
//  "wallet": null,
//  "vpa": "gaurav.kumar@exampleupi",
//  "email": "gaurav.kumar@example.com",
//  "contact": "+919999999999",
//  "customer_id": "cust_DitrYCFtCIokBO",
//  "notes": [],
//  "fee": 24,
//  "tax": 4,
//  "error_code": null,
//  "error_description": null,
//  "error_source": null,
//  "error_step": null,
//  "error_reason": null,
//  "acquirer_data": {
//    "rrn": "033814379298"
//  },
//  "created_at": 1606985209
//}
			return $get_payment_data; 
		}
		else {
			return false; 
		}
	}
	

     
}

/* End of file Razorpay.php */
/* Location: ./application/libraries/Razorpay.php */