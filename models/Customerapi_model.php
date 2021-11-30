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

class Customerapi_model extends CI_Model
{
		 
	 

    function index()
    {

    }
	
	public function store_token($mobile, $token, $customer_id){
		extract($_POST);  
		$ci =& get_instance();
		$ci->load->model('Customer_model', 'Customer');   
		$update_token = $ci->Customer->update_token($mobile, $token, $customer_id);
		if($update_token){
		return $update_token;
		}else{
		return false;	
		}
		
	}
	
	
	   
   
	//FILE END
}

?>