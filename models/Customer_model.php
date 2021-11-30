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

class Customer_model extends CI_Model
{

    function index()
    {

    }
	
	public function get_customers(){
		$this->rbac->check_sub_button_access('customer', 'list_customers', FALSE, 'edit', array('edit'=>'<a href="'.base_url().'customer/edit_customer/$1" class="edit_record btn btn-info" data-customer_id="$1" data-name="$2" data-mobile="$3" data-area="$4" data-city="$5" data-channel="$6">Edit</a>'));  
		$this->rbac->check_sub_button_access('customer', 'list_customers', FALSE, 'delete', array('delete'=>'<a href="javascript:void(0);" class="delete_record btn btn-danger" data-customer_id="$1">Delete</a>'));  
		$this->datatables->select('customer_id,name,mobile,area,city,channel');
      	$this->datatables->from('customer');  
      	$this->datatables->add_column('action', '<a href="'.base_url().'/customer/customer_details/$1" class="btn btn-info" data-customer_id="$1">Details</a> '.$this->rbac->updatePermission_custom.' '.$this->rbac->deletePermission_custom,'customer_id,name,mobile,area,city,channel');
		return $this->datatables->generate(); 
	} 
     
    public function getcustomerlist()
    { 
        return $this->Common->select("customer", 'name ASC'); 
        return $query->result();
    }
	
	public function getcustomer($customer_id)
    { 
		$data = array();
		$data['customer']  = get_customer(array('customer_id'=>$customer_id));  
        $data['customer_addresses'] =  get_customer_address(array('customer_id'=>$customer_id));   
		$data['customer_vehicles'] =  get_customer_vehicles(array('customer_id'=>$customer_id));
		$data['customer_bookings'] =  get_customer_bookings(array('customer_id'=>$customer_id));
        return $data;
    }
	
	public function getcustomer_addresses($customer_id)
    { 
		 
        $data =  get_customer_address(array('customer_id'=>$customer_id)); 
        return $data;
    }
	
	public function getcustomer_vehicle($customer_id)
    { 
		 
		$data =  get_customer_vehicles(array('customer_id'=>$customer_id));
        return $data;
    } 
	
	public function getcustomer_bookings($customer_id)
    { 
		 
		$data  =  get_customer_bookings(array('customer_id'=>$customer_id));
        return $data;
    }
	
	public function update_token($mobile, $token, $customer_id)
    { 
        $data = array(
        'token' => $token, 
        ); 
        $where = array('customer_id' => $customer_id, 'mobile'=>$mobile);
        $this->Common->update_record('customer', $data, $where);  
		return true;
    }
		
	public function add_customer_set($booking_no)
	{
		extract($_POST); 
		if($customer_type!="old"){
			$cust_info = array(
            'name'=> $name,
			'mobile' => $mobile,
			'email' => $email,
			'alternate_no' => $alternate_no,
			'address' => $address,
			'city' => $city,
			'area' => $area,
			'pincode' => $pincode,
			'google_map' => $google_map ,
			'channel' => $channel	
        	);
         $this->Common->add_record('customer', $cust_info);
		 $customer_id = $this->db->insert_id();
			  
			$address_info = array(
            'customer_id'=> $customer_id, 
			'type' => 'Home',	 
			'address' => $address,
			'city' => $city,
			'area' => $area,
			'pincode' => $pincode,
			'google_map' => $google_map,
			'latitude' => $latitude,
			'longitude' => $longitude,
			'created_on' => created_on(),
			'updated_on' => updated_on(),	
        	);
         $this->Common->add_record('customer_address', $address_info);
		 $customer_address_id = $this->db->insert_id();
			
			$veh_info = array(
            'customer_id'=> $customer_id,
			'make' => $make,
			'model' => $model,
			'category' => $vehicle_category,
			'regno' => $reg_no,
			'yom' => $yom,
			'km_reading' => $km_reading,
			'last_service_date' => '',
			'last_service_id' => '', 
        	);
        $this->Common->add_record('vehicles', $veh_info);
		$customer_vehicle = $this->db->insert_id();
			
		}else{ 
			
			 
			$existing_vehicle = $this->Common->single_row('vehicles', array('customer_id'=>$customer_id, 'regno' => $reg_no, 'yom' => $yom, 'make'=>$make, 'model'=>$model), 'vehicle_id');
			
			if(empty($existing_vehicle) || $existing_vehicle<1){
			 $customer_vehicle = $this->add_customer_vehicle($customer_id);	
			}else{
			 $customer_vehicle = $existing_vehicle;		
			} 
				
			//$customer_vehicle = $this->input->post('customer_vehicle'); 
			$customer_id = $this->input->post('customer_id'); 
			
		}
		
		$data['customer_id'] = $customer_id; 
		$data['customer_vehicle'] = $customer_vehicle;
		
		return $data;
		
	}
	
	public function add_new_customer()
	{
		extract($_POST);  
		
			$cust_info = array(
            'name'=> $name,
			'mobile' => $mobile,
			'email' => $email,
			'alternate_no' => $alternate_no,
			'address' => $address,
			'city' => $city,
			'area' => $area,
			'pincode' => $pincode,
			'google_map' => $google_map ,
			'channel' => $channel	
        	);
         $this->Common->add_record('customer', $cust_info);
		 $customer_id = $this->db->insert_id();
		   
		return $customer_id;
		
	}
	public function update_customer($customer_id)
	{
		extract($_POST);  
		
			$cust_info = array(
            'name'=> $name,
			'mobile' => $mobile,
			'email' => $email,
			'alternate_no' => $alternate_no,
			'address' => $address,
			'city' => $city,
			'area' => $area,
			'pincode' => $pincode,
			'google_map' => $google_map,
			'channel' => $channel	
        	);
        
		$where = array('customer_id'=>$customer_id);
		 $result = $this->Common->update_record('customer', $cust_info, $where);
		  
		if($result)
		return true;
		else
		return false;
		
	}
	
	public function add_customer_address($customer_id)
	{
		extract($_POST); 
		 
			  
			$address_info = array(
            'customer_id'=> $customer_id, 
			'type' => 'Home',	 
			'address' => $address,
			'city' => $city,
			'area' => $area,
			'pincode' => $pincode,
			'google_map' => $google_map,
			'latitude' => $latitude,
			'longitude' => $longitude,
			'created_on' => created_on(),
			'updated_on' => updated_on(),	
        	);
         $this->Common->add_record('customer_address', $address_info);
		 $customer_address_id = $this->db->insert_id();
			
		  
		
		return $customer_address_id;
		
	}
	
	public function update_customer_address($customer_id, $address_id)
	{
		extract($_POST); 
		 
			  
			$address_info = array(
            'customer_id'=> $customer_id, 
			'type' => 'Home',	 
			'address' => $address,
			'city' => $city,
			'area' => $area,
			'pincode' => $pincode,
			'google_map' => $google_map,
			'latitude' => $latitude,
			'longitude' => $longitude,
			'created_on' => created_on(),
			'updated_on' => updated_on(),	
        	);
		
		   
		$where = array('customer_id'=>$customer_id, 'address_id'=>$address_id);
		 $result = $this->Common->update_record('customer_address', $address_info, $where);
		  
		if($result)
		return true;
		else
		return false;
		  
	}
	
	public function add_customer_vehicle($customer_id)
	{
		extract($_POST); 
	 
			
			$veh_info = array(
            'customer_id'=> $customer_id,
			'make' => $make,
			'model' => $model,
			'category' => $vehicle_category,
			'regno' => @$reg_no,
			'yom' => @$yom,
			'km_reading' => @$km_reading,
        	);
        $this->Common->add_record('vehicles', $veh_info);
		$customer_vehicle = $this->db->insert_id();
		 
		
		return $customer_vehicle;
		
	}
	
	public function update_customer_vehicle($customer_id, $vehicle_id)
	{
		extract($_POST); 
		 
			  
			$veh_info = array( 
			'make' => $make,
			'model' => $model,
			'category' => $vehicle_category,
			'regno' => $reg_no,
			'yom' => $yom,
			'km_reading' => $km_reading,
        	);
		
		   
		$where = array('customer_id'=>$customer_id, 'vehicle_id'=>$vehicle_id);
		 $result = $this->Common->update_record('vehicles', $address_info, $where);
		  
		if($result)
		return true;
		else
		return false;
		  
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
	
	

}

?>