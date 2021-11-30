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

class Bookings_model extends CI_Model
{
		 
	 

    function index()
    {

    }
	
	public function get_bookings($status=NULL){   
		$this->datatables->select('booking_id,customer_name,customer_mobile,service_date,time_slot,vehicle_make,vehicle_model,customer_channel,service_category_id,assigned_mechanic,status,stage');
      	$this->datatables->from('bookings'); 
      	$this->datatables->where(array('status'=>$status));
      	$this->datatables->add_column('action', '<a href="'.base_url().'bookings/booking_details/$1" class="btn btn-icon btn-primary" data-booking_id="$1"><i class="fas fa-eye"></i></a>','booking_id'); 
		return $this->datatables->generate(); 
	
	}
	
	public function get_pending_jobcard_bookings(){   
		$this->datatables->select('booking_id,customer_name,customer_mobile,service_date,time_slot,vehicle_make,vehicle_model,customer_channel,service_category_id,assigned_mechanic,status,stage');
      	$this->datatables->from('bookings');  
		$this->datatables->where('stage','Created');	
		$this->datatables->where('status!=','Cancelled');	
		$this->datatables->or_where('stage','Rescheduled');	 
		$this->datatables->where('jobcard_id',0);	 
      	$this->datatables->add_column('action', '<a href="'.base_url().'bookings/create_jobcard/$1" class="btn btn-icon btn-primary" data-booking_id="$1"><i class="fas fa-edit"></i></a>','booking_id'); 
		return $this->datatables->generate(); 
	
	}
	
	public function get_unapproved_jobcard_bookings(){   
		$this->datatables->select('booking_id,customer_name,customer_mobile,service_date,time_slot,vehicle_make,vehicle_model,customer_channel,service_category_id,assigned_mechanic,status,stage');
      	$this->datatables->from('bookings');  
		//$this->datatables->join('jobcard AS j', 'j.booking_id=b.booking_id', 'INNER'); 
		$this->datatables->where('status','Ongoing');	
		$this->datatables->where('stage','Inspection Done');	 
		$this->datatables->where('jobcard_approved','No');	 
      	$this->datatables->add_column('action', '<a href="'.base_url().'bookings/create_jobcard/$1" class="btn btn-icon btn-primary" data-booking_id="$1"><i class="fas fa-edit"></i></a>','booking_id'); 
		return $this->datatables->generate(); 
	
	}
	
	public function get_invoices(){   
		$this->datatables->select('booking_payments.booking_id,customer_name,customer_mobile,customer_channel,customer_area,service_category_id,assigned_mechanic,status,stage,payment_mode,payment_date,total_amount');
      	$this->datatables->from('bookings');  
		$this->datatables->join('booking_payments', 'booking_payments.booking_id=bookings.booking_id', 'LEFT'); 
		$this->datatables->where('status','Completed');	
		$this->datatables->custom_count(1);	
      	$this->datatables->add_column('action', '<a href="'.base_url().'bookings/view_invoice/$1" class="btn btn-icon btn-primary" data-booking_id="$1"><i class="fas fa-edit"></i></a>','booking_id'); 
		return $this->datatables->generate(); 
	
	}
	
	
	public function get_jobcard_spares($city){  
		
		$query = $this->Common->select_wher('bookings', 'customer_city="'.$city.'" AND status!= "Ongoing" AND status!= "Completed"  AND status!= "Cancelled" AND service_date>="'.created_on().'"');
			
		//	$this->Common->select_join('bookings AS b', 'jobcard AS j', 'b.customer_city="'.$city.'" AND b.status!= "Ongoing" AND b.status!= "Completed"  AND b.status!= "Cancelled"', 'b.*', 'j.booking_id=b.booking_id', FALSE, FALSE, FALSE, 'b.service_date DESC');
		if($query)
		foreach($query as $row){ 
			
			$bookingdata = $this->getbooking($row->booking_id);
			
			$jobcard   = $this->Common->select_wher('jobcard_details', array('item_type'=>'Spare', 'booking_id'=>$row->booking_id));
		 
		  	$i = 1;
		 	$spareslists = '';
			if($jobcard)
		 foreach($jobcard as $getspare){ 
			 if(!empty($getspare->item)){ 
			 	if($i > 1){ 
				$spareslists .= '<br>'.$getspare->item.' ('.$getspare->item_id.')';	
				}else{ 
					$spareslists .= $getspare->item.' ('.$getspare->item_id.')';
				 }
		 		$i++;
			 }
		 }
			
		
		$spares_assigned_q   = $this->Common->count_all_results("spares_recon", array('booking_id'=>$row->booking_id), 'id');
			
			 
			 
				    if(!empty($spares_assigned_q) && $spares_assigned_q>0){
						$assign_link = '-';
					}else{
						$assign_link ="<a href='".base_url()."bookings/spares_recon/".$row->booking_id."' class=''>Assign</a>";
					}	
			
			$data[] = array( 
         "booking_id" =>   "<a href='".base_url()."bookings/booking_details/".$row->booking_id."' class=''>".$row->booking_id."</a>", 
		 "service_date" =>  date('d-m-Y', strtotime($row->service_date)),  
		 "customer_channel" =>  $row->customer_channel, 
		 "make_name" =>  get_make($row->vehicle_make), 
         "model_name" =>  get_model($row->vehicle_model),
		 "service_category" =>  get_service_category($row->service_category_id),  
         "spares_list"=> $spareslists,
         "assign" => $assign_link,
        );
			
			
			
		}
		
		if(!empty($data)){ 
		return $data;
		}else{
		return false;	
		}
	}
	
	
	public function count_bookings($status=NULL, $col=NULL){
		if($status)
		 return $this->Common->count_all_results('bookings', array('status' =>  $status), $col);
		else
		 return $this->Common->count_all_results('bookings');
		 
	}
	
    public function getstatus($statusid=NULL){
		if($statusid){
			return $this->Common->single_row('status_map_booking', array('id'=>$statusid), 'status');
		}else{
			return false;
		}
	}
	
    public function getbookinglist()
    { 
        return $this->Common->select("bookings", 'service_date ASC'); 
         
    }
	
	 	public function getinvoicelist()
    { 
        return $this->Common->select_wher('bookings', array('status'=>'Completed'), 'status');
        
    }
	
	// What condiontal booking data is needed (Either total count or the complete dump) based on different parameter
	//$booking_id=NULL, $booking_date=NULL, $city=NULL, $zone=NULL
	public function getbooking_conditional($condition='Unassigned', $whereparams=NULL)
    {
		
		$data = array();  
		if($condition=='Unassigned'){  
		$data['count']=$this->Common->single_row('bookings', $whereparams, 'COUNT(*)');  
		$data['dump']=$this->Common->select_wher('bookings', $whereparams); 
		}
		 
        return $data;
    }
	
	public function getbooking($booking_id)
    {  
		$data = array();
		$data['booking']  = $this->Common->single_row('bookings', array('booking_id' =>  $booking_id));  
        $data['booking_details'] =  $this->Common->single_row('booking_details', array('booking_id' =>  $booking_id));
		$data['booking_estimate'] =  $this->Common->single_row('booking_estimate', array('booking_id' =>  $booking_id)); 
        $data['estimate_details'] =  $this->Common->select_wher('booking_estimate_details', array('booking_id' =>  $booking_id), 'id ASC');
		$data['jobcard'] =  $this->Common->single_row('jobcard', array('booking_id' =>  $booking_id)); 
		$data['jobcard_details'] =  $this->Common->select_wher('jobcard_details', array('booking_id' =>  $booking_id, 'status'=>'Active'));
		$data['jobcard_total_amount'] = $this->Common->single_row('jobcard_details', array('booking_id' =>  $booking_id, 'status'=>'Active'), 'SUM(amount)'); 
		$data['jobcard_rejected_details'] =  $this->Common->select_wher('jobcard_details', array('booking_id' =>  $booking_id, 'status'=>'Inactive'));
		$data['booking_payments'] =  $this->Common->single_row('booking_payments', array('booking_id' =>  $booking_id));
		$data['booking_notes'] =  $this->Common->select_wher('booking_notes', array('booking_id' =>  $booking_id));
		$data['booking_track'] =  $this->Common->select_wher('booking_track', array('booking_id' =>  $booking_id));
		$data['booking_service'] =  $this->Common->single_row('booking_services', array('booking_id' =>  $booking_id));
		$data['booking_service_track'] =  $this->Common->select_wher('booking_service_track', array('booking_id' =>  $booking_id));  
		$data['booking_feedback'] =  $this->Common->single_row('feedback', array('booking_id' =>  $booking_id));
		
        return $data;
    }
	
	public function getbooking_estimate_details($booking_id, $where=NULL)
    { 
		$data = array();  
		if($where)
		$where_array = 	$where;
		else
		$where_array = 	array('booking_id' =>  $booking_id);
        $estimate_details  =  $this->Common->select_wher('booking_estimate_details', $where_array, 'id ASC'); 
        return $estimate_details;
    } 
	
	
	public function getbooking_jobcard_details($booking_id, $where=NULL)
    { 
		$data = array();  
		if($where)
		$where_array = 	$where;
		else
		$where_array = 	array('booking_id' =>  $booking_id);
        $jobcard_details  =  $this->Common->select_wher('jobcard_details', $where_array, 'id ASC'); 
        return $jobcard_details;
    }  
	
	public function getbooking_details($booking_id)
    { 
		 
		$data =  $this->Common->single_row('booking_details', array('booking_id' =>  $booking_id));  
        return $data;
    } 
	
	public function getjobcard_details($booking_id)
    { 
		 
		$data =  $this->Common->select_wher('jobcard_details', array('booking_id' =>  $booking_id));
        return $data;
    }
	
	public function getbooking_payments($booking_id)
    { 
		  
		$data =  $this->Common->single_row('booking_payments', array('booking_id' =>  $booking_id));
        return $data;
    }
	
	
	public function add_booking_customer($booking_no)
	{
		$ci =& get_instance();
		 $this->load->model('Customer_model', 'Customer');	
		$customer_data = $ci->Customer->add_customer_set($booking_no);    
		$data['customer_id'] = $customer_data['customer_id']; 
		$data['customer_vehicle'] = $customer_data['customer_vehicle'];
		
		return $data;
		
	}
	
	
	public function add_booking_data($booking_no, $customer_id, $customer_vehicle_id, $custom_data=NULL){
		
		extract($_POST); 
		 
		if(!empty($customer_vehicle_id))
		$customer_vehicle=$customer_vehicle_id;	
		  
		$status = 'New Booking';
		$stage = 'Created'; 
		
		if(empty($address_type)){
			$address_type = 'Home';
		}
		
		$data = array( 
                'booking_no' => $booking_no,
				'customer_id' => $customer_id,
                'customer_name' => $name,
                 'customer_email' => $email,
				 'customer_mobile' => $mobile,
				 'customer_alternate_no' => $alternate_no,
				 'customer_type' => $customer_type,
				 'customer_address_type' => $address_type,
				 'customer_address' => $address,
				 'customer_city' => $city,
				 'customer_area' => $area,
				 'customer_pincode' => $pincode,
				 'customer_google_map' => $google_map,
				 'customer_lat' => $latitude,
				 'customer_long' => $longitude,
				'customer_channel' => $channel,
				 'zone_id' => $zone,
				 'vehicle_id' => $customer_vehicle, 
				'vehicle_make' => $make,
                'vehicle_model' => $model, 
                 'vehicle_regno' => $reg_no,
                 'vehicle_yom' => $yom,
			 	'vehicle_km_reading' => $km_reading, 
			 	'vehicle_last_service_id' => $last_service_id,
			 	'service_category_id' => $service_category,
				'time_slot' => $time_slot,
				'service_date' => $service_date,
				'complaints' => $all_selected_complaints,
				'status' => $status,
				'stage' => $stage,
				'comments' => $comments,
				'created_by' => created_by(),
				'created_on' => created_on(),
				'updated_on' => updated_on() 
            );
		
		if(!empty($custom_data)){ foreach($custom_data as $key=>$val){ $data[$key] = $val; }  }
             
            $response = $this->Common->add_record('bookings', $data); 
			$booking_id = $this->db->insert_id();
			 
		if(!empty($comments)){
			$cust_info = array(
            'booking_id'=> $booking_id,
			'notes' => 'Comments while adding booking: '.$comments,
			'created_by' => created_by(),
			'created_on' => updated_on(), 
        	);
         	$notes =  $this->Common->add_record('booking_notes', $cust_info);
		}
		
		if(empty($leads_convert)) $leads_convert=0;
		
		if(!empty($leads_id) && $leads_convert>0){	
			 $leadconverted = array( 
			'converted' => 1, 	 
        );
			 $where = array('id' => $leads_id);
			$this->Common->update_record('leads', $leadconverted, $where);
					
		}
		
			if(!$booking_id || $booking_id<1){
				return false;
			}else{
				return $booking_id;
			}
		
	}
		
	public function add_booking_details_data($booking_id){
		
	extract($_POST);  
	$booking_details_data = array(
			'booking_id' => $booking_id,
            'service_date' => $service_date,
			'time_slot' => $time_slot 
        	);
	$response = $this->Common->add_record('booking_details', $booking_details_data);  
		 
			if($response){
				return true;
			}else{
				return false;
			}
		
	}
	
	public function update_service_category_data()
	{
		extract($_POST);  
		
		$service_category_name = get_service_category($service_category);
		
		
	$booking_data = array(
			'service_category_id' => $service_category, 
        	'updated_on' => updated_on() 
            );
        $where = array('booking_id' => $booking_id);
		$response = $this->Common->update_record('bookings', $booking_data, $where);
		$response = $this->Common->update_record('booking_services', $booking_data, $where); 
		
		$jobcard_details_data = array(
			'item' => $service_category_name, 
        	'item_id' => $service_category_name, 
        	'labour_rate' => $service_category_rate, 
        	'amount' => $service_category_rate,  
			'endpoint' => 'edit_jobcard',
            );
        $where = array('item_type'=>'Service Category', 'booking_id' => $booking_id);
		$response = $this->Common->update_record('jobcard_details', $jobcard_details_data, $where);
		
		
		 
			if($service_category_name){
				return $service_category_name;
			}else{
				return false;
			}
	}
	
	public function update_yom()
	{
		extract($_POST);  
		 
		$booking_data = array(
			'vehicle_yom' => $yom, 
        	'updated_on' => updated_on() 
            );
        $where = array('booking_id' => $booking_id);  
		$response = $this->Common->update_record('bookings', $booking_data, $where);
		 
		$vehicle_data = array(
			'yom' => $yom,  
            );
        $where = array('vehicle_id' => $vehicle_id);  
		$response = $this->Common->update_record('vehicles', $vehicle_data, $where);
		
		
		 
			if($yom){
				return $yom;
			}else{
				return false;
			}
	}
	
	
	public function add_booking_track_data($booking_id, $customer_vehicle_id, $custom_comment=NULL, $status=NULL, $stage=NULL){
			
		extract($_POST);  
		 if(!$status)	 
		$status = 'New Booking';
		if(!$stage)	
		$stage = 'Created'; 
		
		if(empty($customer_vehicle))
		$customer_vehicle=$customer_vehicle_id;	
		
		if($custom_comment)
			$comments = $custom_comment;
			
			$platform_details = platform_agent();
			$booking_track_data = array(
			'booking_id' => $booking_id,
            'customer_id' => $customer_id,
			'vehicle_id' => $customer_vehicle,
			'status' => $status,
			'stage' => $stage, 
			'owner' => created_by(),	 
			'owner_name' => created_by_name(),
			'owner_platform' => $platform_details,
			'remark' => $comments,
		    'created_on' => updated_on() 
        	);
			$response = $this->Common->add_record('booking_track', $booking_track_data); 
			
			if($response){
				return true;
			}else{
				return false;
			}
		
	
	}
	
	
	public function add_booking_estimate_data($booking_id){
			
		extract($_POST);  
		   
		$stage = 'Estimate Created';  
		$service_category_name = $this->Common->single_row('service_category', array('id'=>$service_category));
		
		 $booking_estimate_data = array(
			'booking_id' => $booking_id,
            'service_category' => $service_category_name->service_name,
			'complaints' => $all_selected_complaints,
			'stage' => $stage, 
			'created_on' => created_on() 
        	);
			
			$this->Common->add_record('booking_estimate', $booking_estimate_data);
		
			$estimate_id = $this->db->insert_id();
		
			if(!$estimate_id || $estimate_id<1){
				return false;
			}else{
				return $estimate_id;
			}
		
	}
	
	
	public function add_booking_estimate_details_data($booking_id, $estimate_id, $site_lead=NULL){
		
		extract($_POST);  
	if(!empty($site_lead)){ 	
		
	foreach($site_lead as $site_lead){ 
		
		$item_id = $site_lead['item_id'];
		$item_name = $site_lead['item_name'];
        $complaint_number = $site_lead['complaint_number'];
        $thiscomplaints = $site_lead['complaints'];
        $spares_rate = $site_lead['spares_rate'];
		$labour_rate = $site_lead['labour_rate'];
        $quantity = $site_lead['quantity'];
		$estimate_no = $site_lead['estimate_no'];
		$total_rate = $site_lead['total_rate']; 
        $item_type = $site_lead['item_type'];	 
		
        if(!empty($coupon_applied)){ $coupon_applied = $site_lead['coupon_applied']; }else{ $coupon_applied = 0; }
		
		$Spares_List = '';
		$Labour_List = '';	
		$row = 0;
		$complaint_count = 0;
		 
		 
            
			   
            if (strlen($quantity) > 0) {
				 
			$estimated_items = array(
                'booking_id' => $booking_id,
				'estimate_id' => $estimate_id,
				'complaint_number' => $complaint_number,
				'complaints' => $thiscomplaints,
                'item_type' => $item_type,
                'item_id' => $item_id,
				'item' => $item_name, 
                'qty' => $quantity,
                'amount' => $total_rate,
				'spares_rate' => $spares_rate,
				'labour_rate' => $labour_rate,
				'coupon_applied' => $coupon_applied,
            );
				if($item_type == 'Spare'){ 
				$Spares_List .= $item_name.'<br>';	
				}elseif($item_type == 'Labour'){ 
				$Labour_List .= $item_name.'<br>';	
				}
				
			$response =    $this->Common->add_record('booking_estimate_details', $estimated_items);
			}
		 
		
	}
		
		$data['Spares_List'] = $Spares_List;
		$data['Labour_List'] = $Labour_List;
		
	}else{ 
		$item_id = $this->input->post('item_id');
		$item_name = $this->input->post('item_name');
        $complaint_number = $this->input->post('complaint_number');
        $complaints = $this->input->post('complaints');
        $spares_rate = $this->input->post('spares_rate');
		$labour_rate = $this->input->post('labour_rate');
        $quantity = $this->input->post('quantity');
		$estimate_no = $this->input->post('estimate_no');
		$total_rate = $this->input->post('total_rate'); 
        $item_type = $this->input->post('itemtype');	 
		if(empty($coupon_applied)){ $coupon_applied = 0; }
		$Spares_List = '';
		$Labour_List = '';	
		$row = 0;
		$complaint_count = 0;
		 for ($i = 0; $i < count($complaints); $i++) {
            extract($_POST);
			   
            if (strlen($quantity[$i]) > 0) {
				
				if($item_type[$i]=='Complaints'){
					
					if(empty($this_complaint)){
						$this_complaint = $complaints[$i];
						$complaint_count++;
					}
					
					if($this_complaint!=$complaints[$i]){
						$this_complaint = $complaints[$i];
						$complaint_count++;
					}
					
					$complaint_number[$i] = $complaint_count;
					
				}
				
			$estimated_items = array(
                'booking_id' => $booking_id,
				'estimate_id' => $estimate_id,
				'complaint_number' => $complaint_number[$i],
				'complaints' => $complaints[$i],
                'item_type' => $item_type[$i],
                'item_id' => $item_id[$i],
				'item' => $item_name[$i], 
                'qty' => $quantity[$i],
                'amount' => $total_rate[$i],
				'spares_rate' => $spares_rate[$i],
				'labour_rate' => $labour_rate[$i],
				'coupon_applied' => $coupon_applied,
            );
				if($item_type[$i] == 'Spare'){ 
				$Spares_List .= $item_name[$i].'<br>';	
				}elseif($item_type[$i] == 'Labour'){ 
				$Labour_List .= $item_name[$i].'<br>';	
				}
				
			$response =    $this->Common->add_record('booking_estimate_details', $estimated_items);
			}
		 }
		
		$data['Spares_List'] = $Spares_List;
		$data['Labour_List'] = $Labour_List;
		
	}
	
		if(!$response){
				return false;
			}else{
				return $data;
			}
			 
	}
	
	
 
	
	
	
	
		public function add_booking_payments($booking_id, $customer_id){
			
		extract($_POST);  
		   
		$stage = 'Not Paid'; 
			
		$booking_payments_data = array(
			'booking_id' => $booking_id,
			'reciept_no' => $booking_id,
            'customer_id' => $customer_id,
			'service_date' => $service_date, 
			'estimated_amount' => '',
			'discount' => '',
			'total_amount' => '', 
			'payment_status' => $stage,
			'payment_mode' => '',
			'payment_date' => '0000-00-00',
			'rz_payment_id' => '',
			'rz_invoice_no' => '',
			'rz_payment_link' => '',
			'rz_payment_status' => '',
			'created_on' => created_on(), 
			'updated_on' => updated_on()
			
        ); 
        $response = $this->Common->add_record('booking_payments', $booking_payments_data);
			
		if($response){
				return true;
			}else{
				return false;
			}
			
		}
	
		public function add_bookings_service($booking_id, $customer_id, $customer_vehicle){
			
		extract($_POST);  
		   
		$stage = 'Not Started';  
		$status = 'New Booking';	
			
		/////////////////////////////////////////////////// ADD BOOKING SERVICE START
		
		$booking_services_data = array(
			'booking_id' => $booking_id,
            'customer_id' => $customer_id,
			'vehicle_id' => $customer_vehicle,
			'stage' => $stage,
			'status' => $status,
			'service_stage' => 'not_started',
			'service_date' => $service_date,
			'service_time' => $time_slot,
			'service_category_id' => $service_category, 
			'created_on' => created_on(),
			'created_by' => created_by(),
			'updated_on' => updated_on()
			
        );
			$response = $this->Common->add_record('booking_services', $booking_services_data);
		
		
		/////////////////////////////////////////////////// ADD BOOKING SERVICE END	
			
		if($response){
				return true;
			}else{
				return false;
			}
			
		}
	
	
	public function add_booking_jobcard_data(){
			
		extract($_POST);  
		   
		$status = 'Jobcard Created';
		$stage = 'Jobcard Created';
		$last_jobcard_id = $this->Common->find_maxid('id', 'jobcard');
		$new_jobcard_id = ($last_jobcard_id+1);    
		
		$getbooking = $this->getbooking($booking_id); 
		$booking = $getbooking['booking'];
		$service_category_id = $booking->service_category_id; 
		
			$jobcard_data = array(
			//'jobcard_id' => $new_jobcard_id, 
			'booking_id' => $booking_id,
            'service_category' => $service_category_id,
			'created_on' => created_on(),
			'updated_on' => updated_on(),
			'created_by' => created_by(),
			'status' => $status,
			'stage' => $stage,
			'remark' => $comments,
			'jobcard_attempt' => 1,  
			);
	 
			$this->Common->add_record('jobcard', $jobcard_data);
		  	
		if(!empty($comments)){
			$cust_info = array(
            'booking_id'=> $booking_id,
			'notes' => 'Comments while creating jobcard: '.$comments,
			'created_by' => created_by(),
			'created_on' => updated_on(), 
        	);
         	$notes =  $this->Common->add_record('booking_notes', $cust_info);
		}
		
			$jobcard_id = $this->db->insert_id();
		
			if(!$jobcard_id || $jobcard_id<1){
				return false;
			}else{
				return $jobcard_id;
			}
		
	}
	
	
	public function add_booking_jobcard_details_data($jobcard_id){
		
		extract($_POST);  
		  
		$status = 'Jobcard Created';
		$stage = 'Jobcard Created';
		
		$getbooking = $this->getbooking($booking_id); 
		$booking = $getbooking['booking']; 
		
		$item_id = $this->input->post('item_id');
		$item_name = $this->input->post('item_name');
        $complaint_number = $this->input->post('complaint_number');
        $complaints = $this->input->post('complaints');
        $spares_rate = $this->input->post('spares_rate');
		$labour_rate = $this->input->post('labour_rate');
        $quantity = $this->input->post('quantity');
        $brand = $this->input->post('brand');
		$estimate_no = $this->input->post('estimate_no');
		$total_rate = $this->input->post('total_rate'); 
        $item_type = $this->input->post('itemtype');	
		$coupon_applied = $this->input->post('coupon_applied');
		$Spares_List = '';
		$Labour_List = '';	
		$row = 0; 
		$no_of_items = 0;
		$AmountTotal = 0;
		$complaint_count = 0;
		 for ($i = 0; $i < count($complaints); $i++) {
            extract($_POST);

            if (strlen($quantity[$i]) > 0 && $jobcard_id>0 && $booking_id>0) {
		  
				if(empty($brand[$i])){ $brand[$i] = ''; }
				
			 	
				if($item_type[$i]=='Complaints'){
					
					if(empty($this_complaint)){
						$this_complaint = $complaints[$i];
						$complaint_count++;
					}
					
					if($this_complaint!=$complaints[$i]){
						$this_complaint = $complaints[$i];
						$complaint_count++;
					}
					
					$complaint_number[$i] = $complaint_count;
					
				}
				
			$jobcard_items = array(
                'jobcard_id' => $jobcard_id,
				'booking_id' => $booking_id,
				'complaint_number' => $complaint_number[$i],
				'complaints' => $complaints[$i],
                'item_type' => $item_type[$i],
                'item_id' => $item_id[$i],
				'item' => $item_name[$i],
				'brand' => $brand[$i], 
                'qty' => $quantity[$i],
                'amount' => $total_rate[$i],
				'spares_rate' => $spares_rate[$i],
				'labour_rate' => $labour_rate[$i],
				'status' => 'Active',  
				'endpoint' => 'create_jobcard', 
				'coupon_applied' => $coupon_applied[$i],
				
            );
				if($item_type[$i] == 'Spares'){ 
				$Spares_List .= $item_name[$i].'<br>';	
				}elseif($item_type[$i] == 'Labour'){ 
				$Labour_List .= $item_name[$i].'<br>';	
				}
				
				$AmountTotal += 	((float)$total_rate[$i]);
			    $this->Common->add_record('jobcard_details', $jobcard_items);
				$no_of_items++;
				
				/////////////////////////////////////////////////// ADD JOBCARD DETAILS END
			}
		 }
		  
			 
		
		$this->load->library('payments');
		$demand_jobcard_total = $this->payments->add_customer_ledger('jobcard_total', $booking_id, $AmountTotal, 'Jobcard Create');
		
		$demand_service_advance = $this->payments->add_customer_ledger('service_advance', $booking_id, $service_advance, 'Jobcard Create');
		
		$request_service_advance = $this->payments->request_service_advance($booking_id, $service_advance);
			
		$demand_round_off = $this->payments->add_customer_ledger('round_off', $booking_id, $round_off, 'Round Off');
	 
		
		$data['Spares_List'] = $Spares_List;
		$data['Labour_List'] = $Labour_List;
		
		$data = array(
                'no_of_items' => $no_of_items,
				'service_advance' => $service_advance,
				'round_off' => $round_off,
            );
        $where = array('id' => $jobcard_id);
        $this->Common->update_record('jobcard', $data, $where);
		
		$data = array(
                'jobcard_id' => $jobcard_id,   
				'stage' => $stage, 
				'complaints' => $all_selected_complaints,
				'updated_on' => updated_on() 
            );
        $where = array('booking_id' => $booking_id);
        $this->Common->update_record('bookings', $data, $where);
		
		$booking_details_data = array(
			'jobcard_id' => $jobcard_id,
            'jobcard_by' => created_by(),
            'jobcard_date' => created_on(),
			'jobcard_status' => $status,
			'estimated_amount' => $AmountTotal,	
        );
		$where = array('booking_id' => $booking_id);
		$this->Common->update_record('booking_details', $booking_details_data, $where); 
		 
		$booking_payments_data = array(  
			'estimated_amount' => $AmountTotal, 
			'payment_status' => 'Not Paid',
			'payment_mode' => '',
			'payment_date' => '0000-00-00',
			'rz_payment_id' => '',
			'discount' => $discount, 
			'rz_invoice_no' => '',
			'rz_payment_link' => '',
			'rz_payment_status' => '',
			'updated_on' => updated_on() 
        ); 
		$where = array('booking_id' => $booking_id); 
        $this->Common->update_record('booking_payments', $booking_payments_data, $where);
		 
		 
			$platform_details = platform_agent();
			$booking_track_data = array(
			'booking_id' => $booking_id,
            'customer_id' => $booking->customer_id,
			'vehicle_id' => $booking->vehicle_id,
			'status' => $booking->status,
			'stage' => $stage. ' @ Estimated Value : '. $AmountTotal, 
			'owner' => created_by(),	 
			'owner_name' => created_by_name(),
			'owner_platform' => $platform_details,
			'remark' => $comments,
		    'created_on' => updated_on() 
        	);
		$response = $this->Common->add_record('booking_track', $booking_track_data); 
		
		
		if(!$response){
				return false;
			}else{
				return $data;
			}
		
	}
	
	
	
public function update_booking_jobcard_data(){
			
		extract($_POST);  
		   
		
		$getbooking = $this->getbooking($booking_id); 
		$booking = $getbooking['booking'];
		
		if(!empty($customer_approval)){
			if($customer_approval == 'Yes'){
			$status = 'Jobcard Approved';
			$stage = 'Jobcard Approved';
			$jobcard_status = 'Approved';
			$jobcard_stage = 'Approved';
			}else{
			$status = 'Jobcard Edited';
			$stage = 'Jobcard Edited'; 
			$jobcard_status = 'Edited';
			$jobcard_stage = 'Edited';
			}
		}else{
			$customer_approval = 'No';
			$status = 'Jobcard Edited';
			$stage = 'Jobcard Edited'; 
			$jobcard_status = 'Edited';
			$jobcard_stage = 'Edited';
		}
		 
		$aft_inspect = 0; 
		if($booking->status == 'Ongoing'){ 
		$aft_inspect = 1;
		}else{  
		$aft_inspect = 0;
		}
	
			$sendEditAfterApproveSMS = 0;
			$checkapproved = $getbooking['jobcard']; 
			if(!empty($checkapproved->stage) && $checkapproved->stage == 'Approved'){
				$sendEditAfterApproveSMS = 1;
			}
		
		$jobcard_data = array(
			'status' => $jobcard_status,
			'stage' => $jobcard_stage,
			'customer_approval' => $customer_approval,
			'jobcard_attempt' => $jobcard_attempt+1,  
			'updated_on' => updated_on(),  
			'remark' => $comments,
		); 
		$where = array('id' => $jobcard_id); 
		$response = $this->Common->update_record('jobcard', $jobcard_data, $where);
	 	 
		if(!empty($comments)){
			$cust_info = array(
            'booking_id'=> $booking_id,
			'notes' => 'Comments while editing jobcard: '.$comments,
			'created_by' => created_by(),
			'created_on' => updated_on(), 
        	);
         	$notes =  $this->Common->add_record('booking_notes', $cust_info);
		}
	
	
		$booking_jobcard_data = array(
			'jobcard_approved' => $customer_approval,
			'updated_on' => updated_on(),   
		); 
		$where = array('booking_id' => $booking_id); 
		$response = $this->Common->update_record('bookings', $booking_jobcard_data, $where);
	
		
		
	 	$data['status'] = $jobcard_status; 
		$data['stage'] = $jobcard_stage;
		
	
			if(!$response){
				return false;
			}else{
				return $data;
			}
		
	}
	
	
	public function update_booking_jobcard_details_data(){
		
		extract($_POST);  
		  
		
		
		 
		$getbooking = $this->getbooking($booking_id); 
		$booking = $getbooking['booking'];
		
		
		
		$Updatejobcard_Items = array( 
			'status' => 'Inactive',
		); 
		$where = array('booking_id' => $booking_id);
		$this->Common->update_record('jobcard_details', $Updatejobcard_Items, $where);
		
		
		if(!empty($customer_approval)){
			if($customer_approval == 'Yes'){
			$status = 'Jobcard Approved';
			$stage = 'Jobcard Approved';
			$jobcard_status = 'Approved';
			$jobcard_stage = 'Approved';
			
			$end_point = 'after_approved';
				
			}else{
			$status = 'Jobcard Edited';
			$stage = 'Jobcard Edited'; 
			$jobcard_status = 'Edited';
			$jobcard_stage = 'Edited';
				
			$end_point = 'edit_jobcard';	
			}
		}else{
			$customer_approval = 'No';
			$status = 'Jobcard Edited';
			$stage = 'Jobcard Edited'; 
			$jobcard_status = 'Edited';
			$jobcard_stage = 'Edited';
			
			$end_point = 'edit_jobcard';
		}
		 
		 
		
		$aft_inspect = 0; 
		if($booking->status == 'Ongoing'){ 
		$aft_inspect = 1;
		}else{  
		$aft_inspect = 0;
		}
		
		
			$sendEditAfterApproveSMS = 0;
			$checkapproved = $getbooking['jobcard']; 
			if(!empty($checkapproved->stage) && $checkapproved->stage == 'Approved'){
				$sendEditAfterApproveSMS = 1;
			}
		 
		
		
		
		$jobdet_ID = $this->input->post('jobdet_ID');	
		$item_id = $this->input->post('item_id');
		$item_name = $this->input->post('item_name');
        $complaint_number = $this->input->post('complaint_number');
        $complaints = $this->input->post('complaints');
        $spares_rate = $this->input->post('spares_rate');
		$labour_rate = $this->input->post('labour_rate');
        $quantity = $this->input->post('quantity');
        $brand = $this->input->post('brand');
		$estimate_no = $this->input->post('estimate_no');
		$total_rate = $this->input->post('total_rate'); 
        $item_type = $this->input->post('itemtype');
		$coupon_applied = $this->input->post('coupon_applied'); 
		$Spares_List = '';
		$Labour_List = '';	
		$row = 0; 
		$no_of_items = 0;
		$AmountTotal = 0;
		$complaint_count = 0;
		 for ($i = 0; $i < count($complaints); $i++) {
            extract($_POST);

            if (strlen($quantity[$i]) > 0 && $jobcard_id>0 && $booking_id>0) {
		  
				if(empty($brand[$i])){ $brand[$i] = ''; }
				
				if($item_type[$i]=='Complaints'){
					
					if(empty($this_complaint)){
						$this_complaint = $complaints[$i];
						$complaint_count++;
					}
					
					if($this_complaint!=$complaints[$i]){
						$this_complaint = $complaints[$i];
						$complaint_count++;
					}
					
					$complaint_number[$i] = $complaint_count;
					
				}
				
			$jobcard_items = array(
                'jobcard_id' => $jobcard_id,
				'booking_id' => $booking_id,
				'complaint_number' => $complaint_number[$i],
				'complaints' => $complaints[$i],
                'item_type' => $item_type[$i],
                'item_id' => $item_id[$i],
				'item' => $item_name[$i],
				'brand' => $brand[$i], 
                'qty' => $quantity[$i],
                'amount' => $total_rate[$i],
				'spares_rate' => $spares_rate[$i],
				'labour_rate' => $labour_rate[$i],
				'status' => 'Active',   
				'endpoint' => $end_point,
				'coupon_applied' => $coupon_applied[$i],
            );
				if($item_type[$i] == 'Spares'){ 
				$Spares_List .= $item_name[$i].'<br>';	
				}elseif($item_type[$i] == 'Labour'){ 
				$Labour_List .= $item_name[$i].'<br>';	
				}
				
				$AmountTotal += 	((float)$total_rate[$i]);
			   
				if($jobdet_ID[$i]!=0){ 
				$where = array('id' => $jobdet_ID[$i]);
		        $this->Common->update_record('jobcard_details', $jobcard_items, $where);
				}else{ 
			    $estimated_items['aft_inspection_done'] = 	$aft_inspect;
				$this->Common->add_record('jobcard_details', $jobcard_items);
				}
				
				 
				
				$no_of_items++;
				
				/////////////////////////////////////////////////// ADD JOBCARD DETAILS END
			}
		 }
		  
		
		
			$this->load->library('payments');
										$ledger_data = array(   
										 'requested_amount'=>$AmountTotal,
										 'transaction_type'=>'jobcard_total',	
										 'updated_on'=>updated_on() 
										); 
		$update_jobcard_total = $this->payments->update_customer_ledger($booking_id, 'jobcard_total', $ledger_data);
		
										$ledger_data2 = array(   
										 'requested_amount'=>$service_advance, 
										 'transaction_type'=>'service_advance', 
										 'updated_on'=>updated_on() 
										); 
		$update_service_advance = $this->payments->update_customer_ledger($booking_id, 'service_advance', $ledger_data2);
 										
		
		
										$ledger_data3 = array(   
										 'requested_amount'=>$round_off,
										 'transaction_type'=>'round_off',  
										 'updated_on'=>updated_on() 
										); 
		$update_round_off = $this->payments->update_customer_ledger($booking_id, 'round_off', $ledger_data3);
		
		
		
		$data['Spares_List'] = $Spares_List;
		$data['Labour_List'] = $Labour_List;
		
		$data = array(
                'no_of_items' => $no_of_items,
				'service_advance' => $service_advance,
				'round_off' => $round_off,
            );
        $where = array('id' => $jobcard_id);
        $this->Common->update_record('jobcard', $data, $where);
		if(!empty($all_selected_complaints)){ 
		$data = array(
                'jobcard_id' => $jobcard_id,   
				'complaints' => $all_selected_complaints,
				'stage' => $stage,
				'updated_on' => updated_on() 
            );
		}else{
			$data = array(
                'jobcard_id' => $jobcard_id,   
				'stage' => $stage,
				'updated_on' => updated_on() 
            );	
		}
        $where = array('booking_id' => $booking_id);
        $this->Common->update_record('bookings', $data, $where);
		
		$booking_details_data = array(
			'jobcard_id' => $jobcard_id,
            'jobcard_by' => created_by(),
            'jobcard_date' => created_on(),
			'jobcard_status' => $jobcard_status,
			'estimated_amount' => $AmountTotal,	
        );
		$where = array('booking_id' => $booking_id);
		$this->Common->update_record('booking_details', $booking_details_data, $where); 
		 
		$booking_payments_data = array(  
			'estimated_amount' => $AmountTotal, 
			'payment_status' => 'Not Paid',
			'payment_mode' => '',
			'payment_date' => '0000-00-00',
			'rz_payment_id' => '',
			'discount' => $discount, 
			'rz_invoice_no' => '',
			'rz_payment_link' => '',
			'rz_payment_status' => '',
			'updated_on' => updated_on() 
        ); 
		$where = array('booking_id' => $booking_id); 
        $this->Common->update_record('booking_payments', $booking_payments_data, $where);
		 
		 if($stage == 'Jobcard Edited'){
				$newstage = 'Jobcard Edited';
				$newremark =  ' @ Estimated Value : '. $AmountTotal;
			}elseif($stage == 'Jobcard Approved'){
				$newstage = 'Jobcard Approved';
				$newremark =  ' @ Final Value : '. $AmountTotal;
			}
		
			$platform_details = platform_agent();
			$booking_track_data = array(
			'booking_id' => $booking_id,
            'customer_id' => $booking->customer_id,
			'vehicle_id' => $booking->vehicle_id,
			'status' => $booking->status,
			'stage' => $newstage, 
			'owner' => created_by(),	 	 
			'owner_name' => created_by_name(),
			'owner_platform' => $platform_details,
			'remark' => $newremark,
		    'created_on' => updated_on() 
        	);
		$response = $this->Common->add_record('booking_track', $booking_track_data); 
		
		 $data['send_update_sms'] = $sendEditAfterApproveSMS;
		 
		
		if(!$response){
				return false;
			}else{
				$data['response'] = true;
				return $data;
			}
		
	}
	
	
	public function approve_jobcard_data()
    {
		
		  
		  
		 extract($_POST);  
		  
		
		
		 
		$getbooking = $this->getbooking($booking_id); 
		$booking = $getbooking['booking'];
		
		if(!empty($customer_approval)){
			if($customer_approval == 'Yes'){
			$status = 'Jobcard Approved';
			$stage = 'Jobcard Approved';
			$jobcard_status = 'Approved';
			$jobcard_stage = 'Approved';
			}else{
			$status = 'Jobcard Edited';
			$stage = 'Jobcard Edited'; 
			$jobcard_status = 'Edited';
			$jobcard_stage = 'Edited';
			}
		}else{
			$customer_approval = 'No';
			$status = 'Jobcard Edited';
			$stage = 'Jobcard Edited'; 
			$jobcard_status = 'Edited';
			$jobcard_stage = 'Edited';
		} 
		
		 
		 $jobcard_data = array(
			'status' => $jobcard_status,
			'stage' => $jobcard_stage,
			'customer_approval' => $customer_approval,
			'jobcard_attempt' => $jobcard_attempt+1,  
			'updated_on' => updated_on(),  
			'remark' => $comments,
		); 
		$where = array('id' => $jobcard_id); 
		$response = $this->Common->update_record('jobcard', $jobcard_data, $where);
	 	 
	 	$data['status'] = $jobcard_status; 
		$data['stage'] = $jobcard_stage;
		 
		 
			$booking_details_data = array(
			'jobcard_status' => $jobcard_status,
			);
			 $where = array('booking_id' => $booking_id);
			$this->Common->update_record('booking_details', $booking_details_data, $where);
			
		  
		 
		 if($stage == 'Jobcard Edited'){
				$newstage = 'Jobcard Edited';
				$newremark =   ' @ Estimated Value : '. $getbooking['booking_details']->estimated_amount;
			}elseif($stage == 'Jobcard Approved'){
				$newstage = 'Jobcard Approved';
				$newremark = ' @ Final Value : '. $getbooking['booking_details']->estimated_amount;
			}
		 
		 
		
		$platform_details = platform_agent();
			$booking_track_data = array(
			'booking_id' => $booking_id,
            'customer_id' => $booking->customer_id,
			'vehicle_id' => $booking->vehicle_id,
			'status' => $status,
			'stage' => $newstage, 
			'owner' => created_by(),	 
			'owner_name' => created_by_name(),	
			'owner_platform' => $platform_details,
			'remark' => $newremark,
		    'created_on' => updated_on() 
        	);
		$response = $this->Common->add_record('booking_track', $booking_track_data); 
		 
		
		if(!$response){
				return false;
			}else{
				$data['response'] = true;
				return $data;
			}
		 
         
    }
	
	
	public function add_spares_recon_data(){ 
		extract($_POST);  
		/////////////////////////////////////////////////// ADD SPARES RECON START 
		$item_id = $this->input->post('item_id');
		$item_name = $this->input->post('item_name'); 
        $itemID = $this->input->post('jobdet_ID');
        $jobdet_ID = $this->input->post('jobdet_ID');
        $quantity = $this->input->post('quantity');  
		$brand = $this->input->post('brand'); 
		$assigned = $this->input->post('assigned'); 
		$no_of_items = 0; 
		 for ($i = 0; $i < count($itemID); $i++) {  
            if (strlen($quantity[$i]) > 0) {  
				if(!empty($assigned[$i]) && $assigned[$i]==$item_id[$i]){ 
				$is_assigned = 1;
				}else{
				$is_assigned = 0;	
				}
			$estimated_items = array(
                'jobcard_details_id' => $jobdet_ID[$i],
				'booking_id' => $booking_id, 
                'item_id' => $item_id[$i],
				'item' => $item_name[$i],
				'brand' => $brand[$i], 
                'qty' => $quantity[$i], 
				'assigned' => $is_assigned,
				'created_on' => date('Y-m-d'), 
            ); 
			   $response = $this->Common->add_record('spares_recon', $estimated_items);
				$no_of_items++; 
				/////////////////////////////////////////////////// ADD SPARES RECON END
			}
		 }  
		if(!$response){
				return false;
			}else{
				$data['response'] = true;
				return $data;
			} 
	}
	
	 public function get_booking_uploads($type, $booking_id)
	 {
		 
		 if($type=="inspection"){
			$response = $this->Common->select_wher('inspection_uploads', array('booking_id' =>  $booking_id)); 
		 }elseif($type=="report"){
			$response = $this->Common->select_wher('report_uploads', array('booking_id' =>  $booking_id)); 
		 }elseif($type=="reciept"){
			$response = $this->Common->select_wher('booking_services', array('booking_id' =>  $booking_id)); 
		 }
		 
		 return $response;
		 
	 }
	
	
	public function custom_update_jobcard($booking_id, $data)
	{ 
		$where = array('booking_id' => $booking_id); 
        $response = $this->Common->update_record('jobcard', $data, $where);
		if(!$response){
				return false;
			}else{
				$data['response'] = true;
				return $data;
			}
	}
	
	public function custom_update_booking($booking_id, $data)
	{ 
		$where = array('booking_id' => $booking_id); 
        $response = $this->Common->update_record('bookings', $data, $where);
		if(!$response){
				return false;
			}else{ 
				return true;
			}
	}
	
		
	public function add_booking_notes()
	{
		extract($_POST);  
		  
		
		$booking_id = $this->input->post('booking_id'); 
		$booking_notes = $this->input->post('booking_notes'); 
			$cust_info = array(
            'booking_id'=> $booking_id,
			'notes' => $booking_notes,
			'created_by' => created_by(),
			'created_on' => updated_on(), 
        	);
         $response =  $this->Common->add_record('booking_notes', $cust_info);
		if(!$response){
				return false;
			}else{ 
				return true;
			}
	}
	
	
	
	public function reschedule_booking()
	{
		extract($_POST);  
		 
		
		$status = 'New Booking';
		$stage = 'Rescheduled'; 
		$remark = 'Booking Rescheduled'; 
		
		$getbooking = $this->getbooking($booking_id); 
		$booking = $getbooking['booking'];
		
		$edit_info = array( 
				'time_slot' => $time_slot,
				'service_date' => $service_date,
				'assigned_mechanic' => '',
				'status' => $status,
			    'stage' => $stage,
				'rescheduled' => 1,
				'updated_on' => updated_on()
        );
		$edit_info2 = array(
            	'time_slot' => $time_slot,
				'service_date' => $service_date,
				'assigned_mechanic' => '',
        );
        $where = array('booking_id' => $booking_id); 
        $this->Common->update_record('bookings', $edit_info, $where);
		$this->Common->update_record('booking_details', $edit_info2, $where);  
		 
		 $platform_details = platform_agent();
			$booking_track_data = array(
			'booking_id' => $booking_id,
            'customer_id' => $booking->customer_id,
			'vehicle_id' => $booking->vehicle_id,
			'status' => $status,
			'stage' => $stage, 
			'owner' => created_by(),	 
			'owner_name' => created_by_name(),
			'remark' => $remark,	
			'owner_platform' => $platform_details, 
		    'created_on' => updated_on() 
        	);
		$response = $this->Common->add_record('booking_track', $booking_track_data); 
		 
		$add_to_rescheduled_log =  $this->DuplicateRecord('booking_services', 'booking_id', $booking_id, 'reschedule_log', FALSE); 
		
		$booking_service_data = array(  
			'stage' => $stage,
			'status' => $status,
			'reached' => 0,
			'service_stage' => 'not_started',
			'service_date' => $service_date,
			'service_time' => $time_slot,  
			'payment_status' => 'Not Paid',
			'payment_mode' => '',
			'payment_date' => '',
			'payment_comments' => '',
			'created_by' => created_by(),
			'updated_on' => updated_on()
			
        );
		
		$where = array('booking_id' => $booking_id); 
        $this->Common->update_record('booking_services', $booking_service_data, $where);
		 
		
		$booking_payments_data = array(  
			'service_date' => $service_date, 
			'total_amount' => '', 
			'payment_status' => 'Not Paid',
			'payment_mode' => '',
			'payment_date' => '0000-00-00',
			'net_payable' => '',
			'rz_payment_id' => '',
			'rz_invoice_no' => '',
			'rz_payment_link' => '',
			'rz_payment_status' => '',
			'updated_on' => updated_on()
			
        );
		
		$where = array('booking_id' => $booking_id);   
         $response =  $this->Common->update_record('booking_payments', $booking_payments_data, $where);
	 	
		$this->load->library('payments');
		
	$this->payments->delete_customer_ledger($booking_id, 'net_payable');
	$this->payments->delete_customer_ledger($booking_id, 'final_paid');	
		if(!$response){
				return false;
			}else{ 
				return true;
			}
	}
	
	 
	
	public function DuplicateRecord($table, $primary_key_field, $primary_key_val, $other_table, $custom_fields){ 
    
    $this->db->where($primary_key_field, $primary_key_val); 
    $query = $this->db->get($table); 
	if($query->num_rows()>0){ 	
    foreach ($query->result() as $row){ 
        foreach($row as $key=>$val) {   
                	$this->db->set($key, $val);   
        }  
    }  
	if($custom_fields){
		foreach($custom_fields as $key2=>$val2) {   
                	$this->db->set($ke2y, $val2);   
        } 
	}	
    $response = $this->db->insert($other_table); 
	}else{
	$response = 0;	
	} 
	if($response != 0){
	return $this->db->insert_id();	
	}else{
	return false;	
	}	
	}
	
	public function replaceBookingId($table, $adjust_key_field, $adjust_key_val, $where_id, $where_value){ 
	 		$data = array(
			$adjust_key_field => $adjust_key_val, 
        	); 
			$where = array($where_id => $where_value);
		
			$response = $this->Common->update_record($table, $data, $where);  	
		if($response){
			return true;
		}else{
			return false;
		}
	}
	
	public function resetColumns($table, $columns=array(), $where_id, $where_value){
			$data = array();
			foreach($columns as $col){ 
			$data[$col] = ''; 
			}
			$where = array($where_id => $where_value);
			
			$response = $this->Common->update_record($table, $data, $where);  	
				
		if($response){
			return true;
		}else{
			return false;
		}
	}
	
	public function addBookingTrack($status=NULL, $stage=NULL, $owner=NULL, $owner_platform=NULL, $remark='Error! Remark Not Captured', $owner_name=NULL){
		extract($_POST);  
		
			if(!$owner){
			 $owner=created_by();
			$owner_name=created_by_name();
			} 
			
			 if(empty($customer_id)){ $customer_id=0; }
			 if(empty($vehicle_id)){ $vehicle_id=0; }
		
			if(empty($owner_platform)) $owner_platform=platform_agent(); 
		
			 $booking_track_data = array(
			'booking_id' => $booking_id,
            'customer_id' => $customer_id,
			'vehicle_id' => $vehicle_id,
			'status' => $status,
			'stage' => $stage,
			'owner' => $owner,
			'owner_name' => $owner_name,	 
			'owner_platform' => $owner_platform,
			'remark' => $remark,
			'created_on' => updated_on(),
        	);
			$response = $this->Common->add_record('booking_track', $booking_track_data);
			
		if(!$response){
				return false;
			}else{ 
				return true;
			}
		
	}
	
	public function updateBookingService($status=NULL, $stage=NULL, $extradata=NULL){
			extract($_POST);   
			 $booking_service_data = array(
			'stage' => $stage,
            'status' => $status,
			'mechanic_id' => $mechanic_id,
			'updated_on' => updated_on(),	
        	);
		 
			if($extradata){ 
				foreach($extradata as $extrakey=>$extravalue){
					$booking_service_data[$extrakey] = $extravalue;
				}
			} 
			$where = array('booking_id' => $booking_id);
			$response = $this->Common->update_record('booking_services', $booking_service_data, $where);  
		
		if(!$response){
				return false;
			}else{ 
				return true;
			}
		
	}
		
	public function addServiceTrack($booking_service_id, $stage=NULL, $action=NULL){
		extract($_POST); 
			if(empty($stage_resource)) $stage_resource='Mechanic_App';
			if(empty($stage_resource_id)) $stage_resource_id=$mechanic_id;
			$booking_service_track_data = array(
			'booking_id' => $booking_id,
            'mechanic_id' => $mechanic_id,	 
			'booking_service_id' => $booking_service_id,
			'service_date' => @$service_date,
			'service_time' => @$service_time, 
			'action' => $action,
			'stage' => $stage,	 
			'stage_resource' => $stage_resource,
			'stage_resource_id' => $stage_resource_id,	
			'created_on' => created_on(),  
        	);
			$response = $this->Common->add_record('booking_service_track', $booking_service_track_data);
			if(!$response){
				return false;
			}else{ 
				return true;
			}
	}
	
	public function UpdateMechanicLog(){  
		extract($_POST); 
			 $mechaniclog_data = array(
			'booking_id' => $booking_id,	 
			'mechanic_id' => $mechanic_id,
			'longitude' => $long,
			'latitude' => $lat,
			'activity' => $activity,
			'created_on' => created_on(),
        );
		$response =	$this->Common->add_record('mechanic_log', $mechaniclog_data);
		
		if(!$response){
				return false;
			}else{ 
				return true;
			}
	}
	
	
	public function UpdatePaymentProcess($total_amount, $payment_status=NULL, $payment_mode=NULL, $payment_date=NULL, $payment_comments=NULL, $net_payable=NULL, $discount=NULL, $estimated_amount=NULL){
		 extract($_POST); 
		
		if(!$net_payable) { $net_payable=0; }
		
		$booking_payments_data = array(   
			'updated_on' => updated_on()
        );
		if($total_amount){ $booking_payments_data['total_amount']=$total_amount; }
		if($payment_status){ $booking_payments_data['payment_status']=$payment_status; }
		if($payment_mode){ $booking_payments_data['payment_mode']=$payment_mode; }
		if($payment_date){ $booking_payments_data['payment_date']=$payment_date; }
		if($payment_comments){ $booking_payments_data['comments']=$payment_comments; }
		if($discount){ $booking_payments_data['discount']=$discount; }
		if($estimated_amount){ $booking_payments_data['estimated_amount']=$estimated_amount; }
		if($net_payable){ $booking_payments_data['net_payable']=$net_payable; }
		
		$where = array('booking_id' => $booking_id); 
        $response =$this->Common->update_record('booking_payments', $booking_payments_data, $where);
		if(!$response){
				return false;
			}else{ 
				return true;
			}
		
	}
	
	
	
	//FILE END
}

?>