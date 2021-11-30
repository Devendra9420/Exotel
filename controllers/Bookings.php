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
class Bookings extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
		 //$this->output->enable_profiler(TRUE); 
        auth_check(); // check login auth 
		$this->rbac->check_module_access(); 
		$this->load->model('Bookings_model', 'Bookings'); 
		
		$this->load->model('Customer_model', 'customer_model');  
		
		$this->load->library('payments');
    }

	// Add Customer Form
    public function index()
    {
			//$this->rbac->check_module_access();
			//$this->rbac->check_module_access(); 
			//$this->rbac->check_sub_button_permission(TRUE);  
			$this->rbac->check_sub_button_access('bookings','list_bookings', FALSE, array('add','edit','delete')); 
			$this->rbac->check_sub_button_access('bookings', 'list_bookings', FALSE, array('view'), array('view'=>base_url().'bookings/list_bookings/'));
		
		
			$this->rbac->check_sub_button_access('bookings', 'list_bookings', FALSE, array('add'), array('add'=>'<a href="'.base_url().'bookings/add_booking" class="add_record btn btn-info"> Add New Booking <i class="fa fa-plus"></i></a>')); 
			$this->rbac->check_sub_button_access('bookings', 'list_bookings', FALSE, array('delete'), array('delete'=>'<a href="'.base_url().'bookings/delete_booking" class="delete_record btn btn-danger"> Delete Booking <i class="fa fa-minus"></i></a>')); 
			
			redirect(base_url());
		
			//$this->header($title = 'Bookings'); 
        	//$this->load->view('bookings/pending_jobcards');
        	//$this->footer();
		 
    }
	
	
	
	public function get_events() 
    {
        // Our Stand and End Dates
        $start =  $this->input->post("start");
        $end =  $this->input->post("end");

        $startdt = new DateTime('now'); // setup a local datetime
        $startdt->setTimestamp($start); // Set the date based on timestamp
        $format = $startdt->format('Y-m-d');
		$Booking_Service_date = $startdt->format('Y-m-d');
		$Booking_Service_time = $startdt->format('H:i A');
		
        $enddt = new DateTime('now'); // setup a local datetime
        $enddt->setTimestamp($end); // Set the date based on timestamp
        $format2 = $enddt->format('Y-m-d');
		$Booking_Service_enddate = $startdt->format('Y-m-d');
		$Booking_Service_endtime = $startdt->format('Y-m-d H:i A');
		 
		$events = $this->Common->select_wher('bookings', 'service_date >= "'.$format.'" AND service_date <= "'.$format2.'"'); 
        $data_events = array(); 
        foreach($events as $r) {  
			$timeslot = explode(' - ',$r->time_slot);
			$service_time = $timeslot[0];
            $data_events[] = array(
                "booking_id" => $r->booking_id,
                "title" => $r->customer_name,
                "description" => $r->customer_area, 
                "start" => $r->service_date 
            );
        }

        echo json_encode(array("events" => $data_events));
        exit();
    }
	
    
    // List Customers
    public function list_bookings()
    {
        $this->rbac->check_module_access();  
		$this->rbac->check_sub_button_access('bookings','list_bookings', FALSE, array('add','edit','delete'));  
		$this->rbac->check_sub_button_access('bookings', 'add_booking', FALSE, array('add'), array('add'=>'<a href="'.base_url().'bookings/add_booking" class="add_record btn btn-info"> Add New Booking <i class="fa fa-plus"></i></a>')); 
        $data['bookings'] = $this->Bookings->getbookinglist();  
        $this->header($title = 'Bookings List');
        $this->load->view('bookings/list_bookings', $data);
        $this->footer();
    }
	
	public function get_bookings(){
		if(!empty($this->uri->segment(3))){
		$status = $this->Bookings->getstatus($this->uri->segment(3));
		}else{
		$status = '';
		}
		 header('Content-Type: application/json'); 
        echo $this->Bookings->get_bookings($status);
	}
	 
	// Pending Jobcard
    public function pending_jobcards()
    {
        $this->rbac->check_module_access();  
		$this->rbac->check_sub_button_access('bookings','create_jobcard', FALSE, array('add','edit','delete'));   
        $data['bookings'] = $this->Bookings->getbookinglist();  
        $this->header($title = 'Pending Jobcards');
        $this->load->view('bookings/pending_jobcards', $data);
        $this->footer();
    }
	
	public function get_pending_jobcard_bookings(){ 
		 header('Content-Type: application/json'); 
        echo $this->Bookings->get_pending_jobcard_bookings();
	}
	
	// Pending Jobcard
    public function unapproved_jobcards()
    {
        $this->rbac->check_module_access();  
		$this->rbac->check_sub_button_access('bookings','create_jobcard', FALSE, array('add','edit','delete'));   
        $data['bookings'] = $this->Bookings->getbookinglist();  
        $this->header($title = 'Unapproved Jobcards');
        $this->load->view('bookings/unapproved_jobcards', $data);
        $this->footer();
    }
	
	public function get_unapproved_jobcard_bookings(){ 
		 header('Content-Type: application/json'); 
        echo $this->Bookings->get_unapproved_jobcard_bookings();
	}
	
	  
	// Pending Jobcard
    public function unpaid_bookings()
    {
        $this->rbac->check_module_access();  
		$this->rbac->check_sub_button_access('bookings','unpaid_bookings', FALSE, array('add','edit','delete'));   
        $data['bookings'] = $this->Common->select_wher('bookings',array('stage'=>'Submit Report'));  
        $this->header($title = 'Unpaid Bookings');
        $this->load->view('bookings/unpaid_bookings', $data);
        $this->footer();
    }
	 
	// List Invoices
    public function list_invoice()
    {
        $this->rbac->check_module_access();  
		$this->rbac->check_sub_button_access('bookings','list_invoice', FALSE, array('add','edit','delete'));  
		$this->rbac->check_sub_button_access('bookings', 'list_invoice', FALSE, array('add'), array('add'=>'<a href="'.base_url().'bookings/add_booking" class="add_record btn btn-info"> Add New Booking <i class="fa fa-plus"></i></a>')); 
        $data['bookings'] = $this->Bookings->getinvoicelist();  
        $this->header($title = 'Bookings Invoice List');
        $this->load->view('bookings/list_invoice', $data);
        $this->footer();
    }
	
	public function get_invoices(){
		 
		 header('Content-Type: application/json'); 
        echo $this->Bookings->get_invoices();
	}
	
	// View Invoice
	public function view_invoice()
	{
		$booking_id = $this->uri->segment(3);
		$this->rbac->check_module_access();   
        $bookings_data = $this->Bookings->getbooking($booking_id);
		$data['booking'] = $bookings_data['booking'];
		$data['booking_payments'] = $bookings_data['booking_payments'];
		$data['jobcard'] = $bookings_data['jobcard'];
		$data['jobcard_details'] = $bookings_data['jobcard_details'];
        $this->header($title = 'Booking Invoice# '.$booking_id);
        $this->load->view('bookings/view_invoice', $data);
        $this->footer();
	}
	
	 
	
	
	
	
	
    // Bookings Details
    public function booking_details()
    {
		$booking_id = $this->uri->segment(3);
        $this->rbac->check_module_access();  
		$this->rbac->check_sub_button_permission();  
		$this->rbac->check_sub_button_access('bookings','booking_details', FALSE, array('add','edit','delete'));  
		$this->rbac->check_sub_button_access('bookings', 'create_jobcard', FALSE, array('add'), array('add'=>'<a href="'.base_url().'bookings/create_jobcard/'.$booking_id.'" class="add_record btn btn-info"> Create Jobcard <i class="fa fa-plus"></i></a>')); 
		$bookingdata = $this->Bookings->getbooking($booking_id);  
		$data['booking_id'] = $booking_id;   
		$data['booking']  = $bookingdata['booking']; 
		
		$customerdata = $this->customer_model->getcustomer($data['booking']->customer_id);  
		$data['customer_bookings'] =  $customerdata['customer_bookings'];  ;
		
		
		
		$data['booking_details'] =  $bookingdata['booking_details']; 
		$data['estimate_details'] =  $bookingdata['estimate_details'];  
		$data['jobcard'] =  $bookingdata['jobcard'];  
		$data['jobcard_details'] =  $bookingdata['jobcard_details'];
		$data['jobcard_rejected_details'] =  $bookingdata['jobcard_rejected_details'];  
		$data['booking_payments'] =  $bookingdata['booking_payments']; 
		$data['booking_notes'] = $bookingdata['booking_notes'];
		$data['bookingtrack']= $bookingdata['booking_track']; 
		$data['booking_service']= $bookingdata['booking_service']; 
		
		$data['service_advance_data'] = $this->payments->verify_service_advance($booking_id);
		$data['customer_ledger_data']= $this->payments->get_ledger($booking_id, 'all'); 
		
		$this->output->cache(60);
        $this->header($title = 'Booking Detail'); 
        $this->load->view('bookings/booking_details', $data); 
        $this->footer();
    }
	
	public function getnewitems(){ 
		 extract($_POST);
		$output['htmlfield'] = '';  
		$output['htmlfield']  .= '<h4>Booking Id: '.$booking_id.'</h4> <table class="table table-striped table-hover table-bordered dataTable"  aria-describedby="editable-sample_info"> <thead>  <tr style="background-color: #ECECEC"><th class="">#</th><th>Description</th><th>Quantity</th><th>Brand</th><th>Spares Cost</th><th>Labour Cost</th><th>Total</th></tr></thead><tbody>';  
			$item_line_id = $this->Bookings->getbooking_jobcard_details($booking_id, array('status'=>'Active', 'booking_id'=>$booking_id,'aft_inspection_done'=>1));	
			$total_number = 0;
			 foreach($item_line_id as $rows){ 
		$total_number++;
		$item_id = $rows->item_id;
        $count =  $total_number;
		$qty_selected = $rows->qty; 
            $output['htmlfield'] .= '<tr id="entry_row_' . $count . '">';
            $output['htmlfield'] .= '<td id="serial_' . $count . '">' . $count . '</td>'; 
			$output['htmlfield'] .= '<td>' . $rows->item .'</td>'; 
            $output['htmlfield'] .= '<td> '. $rows->qty.'  </td>';  
			$output['htmlfield'] .= '<td> '.$rows->brand.'</div>  </td>';  
            $output['htmlfield'] .= '<td>'. $rows->spares_rate.'</td>'; 
			 $output['htmlfield'] .= '<td> '. $rows->labour_rate.' </td>'; 
            $output['htmlfield'] .= '<td>'. $rows->amount.'</td>';  
				$output['htmlfield'] .= '</tr>'; 
				$output['thispdtcount'] = $count; 
            } 
			$output['htmlfield'] .= '</tbody></table>';  
		echo $output['htmlfield']; 
	}
	
	
	// Add Customer Form
    public function add_booking()
    { 
		$this->rbac->check_module_access();  
		$this->rbac->check_sub_button_access('bookings','add_bookings', FALSE, array('add'));   
        $Autoconvert = $this->uri->segment(3);
		$Autoconvert_id = $this->uri->segment(4);
		
		if(!empty($Autoconvert) && $Autoconvert=='lead_convert'){ 	 
			$this->load->model('Leads_model', 'Leads'); 	
			$leads_data = $this->Leads->getlead($Autoconvert_id);
			$data['leads_convert'] = 1;	
			$data['leads'] = $leads_data['leads']; 
			$data['leads_id'] = $data['leads']->id;	
			$data['leads_estimate'] = $leads_data['leads_estimate'];  
			$data['leads_lifecycle'] = $leads_data['leads_lifecycle']; 
		}elseif(!empty($Autoconvert) && $Autoconvert=='followup_booking'){ 	 
			$followup_data = $this->Bookings->getbooking($Autoconvert_id); 
			$data['followup_booking'] = 1;	
			$data['followup'] = $followup_data['booking']; 
			$data['followup_id'] = $data['followup']->booking_id;	 
		}else{
		$data['followup_booking'] = 0;	
		$data['followup'] = ''; 	
		$data['leads_convert'] = 0;	
		$data['leads_id'] = '';		
		$data['leads'] = FALSE; 
		$data['leads_estimate'] = FALSE; 
		$data['leads_lifecycle'] = FALSE;	
		}
		
		$this->output->cache(60);
		$this->header($title = 'Add Booking'); 
        $this->load->view('bookings/add_booking',$data);
        $this->footer();

    }
	
	// Customer Details
    public function customer_existance()
    {
		$data = [];
        $mobile = $this->input->post('mobile');
		$customer = get_customer(array('mobile'=>$mobile));
		$leads_id = $this->input->post('leads_id');
		$lead_convert = $this->input->post('lead_convert');
		
		$followup_id = $this->input->post('followup_id');
		$followup_booking = $this->input->post('followup_booking');
		
		
		if($customer){ 
		$data['customer_id']=$customer->customer_id;	
		$address = get_customer_address(array('customer_id'=>$customer->customer_id)); 
		if($address)
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
		
		if(!empty($customeraddress)){ $data['address'] = $customeraddress;	}else{ $data['address'] = null; }	
 		$data['address'] = $customeraddress;	 
			
		$vehicles = get_customer_vehicles(array('customer_id'=>$customer->customer_id));   
		if($vehicles)
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
		if(!empty($customervehicle)){ $data['vehicle'] = $customervehicle;	}else{ $data['vehicle'] = null; }
			
 		$data['name'] = $customer->name;
		$data['mobile'] =  $customer->mobile;
		$data['alternate_no'] =  $customer->alternate_no;
		$data['email'] =  $customer->email;
		$data['channel'] = $customer->channel;
		$data['customer_type'] = 'old';	
 		$this->session->set_userdata('customer', $data); 	
		}else{ 
		$data['customer_id']=0;  
		}
		
		if(!empty($leads_id) && $leads_id>0){ 
		$this->convert_lead_data($leads_id);
		}
		
		if(!empty($followup_id) && $followup_id>0){ 
		$this->followup_booking_data($followup_id);
		}
		
        echo json_encode($data); 
    }
	
	// Customer Details
    public function convert_lead_data($leads_id)
    {
		$data = [];
        $this->load->model('Leads_model', 'Leads'); 
		$leads_data = $this->Leads->getlead($leads_id);
		$leads = $leads_data['leads']; 
		$leads_estimate = $leads_data['leads_estimate']; 
		$leads_lifecycle = $leads_data['leads_lifecycle']; 
		
		
		 
		$data['customer_id']=0;	
		$data['leads_id']=$leads->id;	
		$data['leads_convert']=1;	
		 
		$zone = get_area_details('zone',array('area'=>$leads->area));   
		$latlong = getlonglat($leads->address); 
			$customeraddress[] = array( 
			'type' => 'Home',
			'address' => $leads->address,
			'area' => $leads->area,
			'city' => $leads->city,
			'pincode' => $leads->pincode,
			'google_map' => $leads->google_map,
			'zone'	=> $zone,
			'latitude' => @$latlong['lat'],
			'longitude' => 	@$latlong['long'],	
			);	  
		 
			
 		$data['address'] = $customeraddress;	 
		 
		$make = get_make($leads->make); 
		if(!empty($make)){
		$make_name = $make;	
		}else{
		$make_name = '';	
		}
		
		$model = get_model($leads->model,'all');  
		if(!empty($model->model_id)){ 
			 $lead_model_name = $model->model_name;
			 $lead_model_code = $model->model_code;
			 $lead_vehicle_category = $model->vehicle_category;
        }else{
			$lead_model_name = '';
			 $lead_model_code = '';
			 $lead_vehicle_category = '';
        }
		
			$customervehicle[] = array( 
			'vehicle_id' => 0,
			'make' => $leads->make,
			'make_name' => 	$make_name,
			'model' => $leads->model,
			'model_name' =>  $lead_model_name,
			'model_code' =>  $lead_model_code,
			'vehicle_category' => $lead_vehicle_category,
			'regno' => '',
			'yom' => '', 
			'km_reading' => '', 
			'last_service_date' => '',
			'last_service_id' => '',
			);	 
		 
			
		$data['vehicle'] = $customervehicle;	 
 		$data['name'] = $leads->name;
		$data['mobile'] =  $leads->mobile;
		$data['alternate_no'] =  $leads->alternate_no;
		$data['email'] =  $leads->email;
		$data['channel'] = $leads->channel;
		$data['customer_type'] = 'new';	
		if(!empty($leads->desired_service_date) && $leads->desired_service_date!='0000-00-00')
		$data['desired_service_date'] = $leads->desired_service_date;
		$data['desired_service_time'] = date('H:i',strtotime($leads->desired_service_time));  
		$data['complaints'] =  $leads->complaints;  
		$data['service_category'] =  $leads->service_category;  
		$data['comments'] =  $leads->comments; 
		$leadestimatedata = [];
		
		 
		
		$data['leads_estimate'] = $leads_estimate;	 
		$data['customer_type'] = 'new';	 
		$this->session->unset_userdata('customer'); 
		$this->session->set_userdata('customer', $data);
		
        return true;
    }
	
	 
	// Customer Details
    public function followup_booking_data($followup_id)
    {
		 
		$data = []; 
		$followup_data = $this->Bookings->getbooking($followup_id);
		$followup = $followup_data['booking']; 
		 
		$data['customer_id']=$followup->customer_id;	
		$data['followup_id']=$followup->booking_id;	
		$data['followup_booking']=1;	
		 
		 
		$latlong = getlonglat($followup->customer_address); 
			$customeraddress[] = array( 
			'type' => 'Home',
			'address' => $followup->customer_address,
			'area' => $followup->customer_area,
			'city' => $followup->customer_city,
			'pincode' => $followup->customer_pincode,
			'google_map' => $followup->customer_google_map,
			'zone'	=> $followup->zone_id,
			'latitude' => $followup->customer_lat,
			'longitude' => 	$followup->customer_long,	
			);	  
		 
			
 		$data['address'] = $customeraddress;	 
		 
		$make = get_make($followup->vehicle_make); 
		$model = get_model($followup->vehicle_model,'all');  
			$customervehicle[] = array( 
			'vehicle_id' => 0,
			'make' => $followup->vehicle_make,
			'make_name' => 	$make,
			'model' => $followup->vehicle_model,
			'model_name' =>  $model->model_name,
			'model_code' =>  $model->model_code,
			'vehicle_category' => $model->vehicle_category,
			'regno' => '',
			'yom' => '', 
			'km_reading' => '', 
			'last_service_date' => '',
			'last_service_id' => '',
			);	 
		 
			
		$data['vehicle'] = $customervehicle;	 
 		$data['name'] = $followup->customer_name;
		$data['mobile'] =  $followup->customer_mobile;
		$data['alternate_no'] =  $followup->customer_alternate_no;
		$data['email'] =  $followup->customer_email;
		$data['channel'] = $followup->customer_channel;
		$data['customer_type'] = $followup->customer_type;	
		if(!empty($followup->service_date) && $followup->service_date!='0000-00-00')
		$data['desired_service_date'] = $followup->service_date;
		$data['desired_service_time'] = date('H:i',strtotime($followup->time_slot));  
		$data['complaints'] =  $followup->complaints;  
		$data['service_category'] =  $followup->service_category_id;  
		$data['comments'] =  $followup->comments; 
		$leadestimatedata = [];
		
		 
		$this->session->unset_userdata('customer'); 
		$this->session->set_userdata('customer', $data);
		
        return true;
    }
	
    // Insert new Customer to Databse
    public function insert_booking($leads_estimate_details=NULL)
    {
         
		 
		$last_booking_id = $this->Common->find_maxid('booking_id', 'bookings');
		$booking_no = ($last_booking_id+1); 
		
		$last_service_id = $this->input->post('last_service_id');
		$service_category = $this->input->post('service_category');  
		$service_date = $this->input->post('service_date');
		$time_slot = $this->input->post('time_slot');
		$all_complaints = $this->input->post('all_selected_complaints'); 
		
		$customer_data = $this->Bookings->add_booking_customer($booking_no); 
		
		
		/////////////////////////////////////////////////// ADD BOOKING START  
         $booking_id = $this->Bookings->add_booking_data($booking_no, $customer_data['customer_id'],$customer_data['customer_vehicle']);   
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
		 $estimate_details  = $this->Bookings->add_booking_estimate_details_data($booking_id, $estimate, $leads_estimate_details);  
		/////////////////////////////////////////////////// ADD BOOKING ESTIMATE DETAILS END
		
		/////////////////////////////////////////////////// ADD BOOKING ESTIMATE DETAILS START
		 $booking_payments = $this->Bookings->add_booking_payments($booking_id, $customer_data['customer_id']);  
		/////////////////////////////////////////////////// ADD BOOKING ESTIMATE DETAILS END
		
         /////////////////////////////////////////////////// ADD BOOKING ESTIMATE DETAILS START
		 $booking_service = $this->Bookings->add_bookings_service($booking_id, $customer_data['customer_id'],  $customer_data['customer_vehicle']);  
		/////////////////////////////////////////////////// ADD BOOKING ESTIMATE DETAILS END
		 extract($_POST);
		 
		 $mail_data = array( 'booking_id' => $booking_id, 'Spares_List' => $estimate_details['Spares_List'], 'Labour_List' => $estimate_details['Labour_List']);
		 $send_email = $this->mailer->mail_template($email,'new-booking',$mail_data, 'emailer/new_bookings.php');
 		  
		 $service_category_name = get_service_category($service_category);
		 $sms_data = array( 'service_category' => $service_category_name, 'time_slot' => $time_slot, 'service_date'=>$service_date); 
		 $send_sms = $this->sms->sms_template(array($mobile),'new-booking',$sms_data);
		 
		 
		
        if ($send_email) {
            $this->session->set_flashdata('success', 'New Booking# '.$booking_id.' Created Successfully..!');
            redirect(base_url() . 'bookings/add_booking');
        }
		
		
    }
	
	
	// Add Booking Jobcard Form
    public function create_jobcard()
    {
		$booking_id = $this->uri->segment(3);  
		$this->rbac->check_module_access();       
		$this->rbac->check_sub_button_access('bookings','create_jobcard', FALSE, array('add','edit')); 
		$bookingdata = $this->Bookings->getbooking($booking_id);   
		$data['booking'] = $bookingdata['booking'];  
		$data['estimate_details'] = $bookingdata['estimate_details'];  
        $this->header($title = 'Booking - Create Jobcard'); 
        $this->load->view('bookings/create_jobcard',$data);
        $this->footer();

    }
	
	public function insert_jobcard()
	{ 
		extract($_POST);
		/////////////////////////////////////////////////// ADD BOOKING START  
        $jobcard_id = $this->Bookings->add_booking_jobcard_data();   
		/////////////////////////////////////////////////// ADD BOOKING START END 
		
		/////////////////////////////////////////////////// ADD BOOKING DETAILS START
		$jobcard_details = $this->Bookings->add_booking_jobcard_details_data($jobcard_id); 
		/////////////////////////////////////////////////// ADD BOOKING DETAILS END 
		
		if ($jobcard_details) {
            $this->session->set_flashdata('success', 'Jobcard# '.$jobcard_id .' for Booking# '.$booking_id.' Created Successfully..!');
            redirect(base_url());
        } 
	}
	
	
	   
	// Add Booking Jobcard Form
    public function edit_jobcard()
    {
		$booking_id = $this->uri->segment(3);  
		$this->rbac->check_module_access();       
		$this->rbac->check_sub_button_access('bookings','edit_jobcard', FALSE, array('edit')); 
		$bookingdata = $this->Bookings->getbooking($booking_id);   
		$data['service_advance_data'] = $this->payments->verify_service_advance($booking_id);
		$data['booking'] = $bookingdata['booking'];  
		$data['jobcard'] = $bookingdata['jobcard'];  
		$data['jobcard_details'] = $bookingdata['jobcard_details']; 
		$data['booking_payments'] = $bookingdata['booking_payments']; 
        $this->header($title = 'Booking - Edit Jobcard'); 
        $this->load->view('bookings/edit_jobcard',$data);
        $this->footer();

    }
	
	// Add Booking Jobcard Form
    public function customer_jobcard()
    { 
		
		$booking_id = base64_decode($this->uri->segment(3));  
		$approved = $this->uri->segment(4); 
		$bookingdata = $this->Bookings->getbooking($booking_id);  
		$data['service_advance_data'] = $this->payments->verify_service_advance($booking_id);
		$data['booking_id'] = $booking_id; 
		$data['booking'] = $bookingdata['booking'];  
		$data['jobcard'] = $bookingdata['jobcard'];  
		$data['jobcard_details'] = $bookingdata['jobcard_details']; 
		$data['booking_payments'] = $bookingdata['booking_payments']; 
		
		if(!empty($approved) && $approved=='approved'){
			$data['approved'] = 'Yes';
		}else{
			$data['approved'] = 'No';
		}
		
		
       // $this->header($title = 'Booking - Edit Jobcard'); 
        $this->load->view('bookings/customer_jobcard',$data);
       // $this->footer();

    }
	
		// Add Booking Jobcard Form
    public function update_customer_jobcard()
    {
		
		extract($_POST);
		
		$jobcard_approve = $this->Bookings->approve_jobcard_data();   
		 
		/////////////////////////////////////////////////// ADD BOOKING START  
        $jobcard_details_data = $this->Bookings->update_booking_jobcard_data();   
		/////////////////////////////////////////////////// ADD BOOKING START END 
		
		/////////////////////////////////////////////////// ADD BOOKING DETAILS START
		$jobcard_details = $this->Bookings->update_booking_jobcard_details_data(); 
		/////////////////////////////////////////////////// ADD BOOKING DETAILS END 
		
		 
		
		$bookingdata = $this->Bookings->getbooking($booking_id);   
		
		$booking = $bookingdata['booking'];  
		
		 
				// $sms_data = array( 'booking_id' => $booking->booking_id, 'base_url' => base_url()); 
		 		// $send_sms = $this->sms->sms_template(array($booking->customer_mobile),'customer-jobcard',$sms_data); 
	 
		
		if ($jobcard_approve) {
			  $data['response']=1;
		}else{
				 $data['response']=0;
		}
		
		echo json_encode($data);
		
    }
	
	
	public function edit_service_category()
	{
		extract($_POST);
		
		/////////////////////////////////////////////////// ADD BOOKING START  
        $service_category = $this->Bookings->update_service_category_data();   
		/////////////////////////////////////////////////// ADD BOOKING START END  
		 
		
		if ($service_category) {
            $this->session->set_flashdata('success', 'Service Category changed to '.$service_category.' for Booking# '.$booking_id);
            redirect(base_url() . 'bookings/edit_jobcard/'.$booking_id);
        }else {
            $this->session->set_flashdata('warning', 'Error changing Service Category for Booking# '.$booking_id);
            redirect(base_url() . 'bookings/edit_jobcard/'.$booking_id);
        } 
		 
	}
	
	public function update_yom()
	{
		extract($_POST);
		
		/////////////////////////////////////////////////// ADD BOOKING START  
        $updated_yom = $this->Bookings->update_yom();   
		/////////////////////////////////////////////////// ADD BOOKING START END  
		 
		
		if ($updated_yom) {
            $this->session->set_flashdata('success', 'Year of make changed to '.$updated_yom.' for Booking# '.$booking_id);
            redirect(base_url() . 'bookings/create_jobcard/'.$booking_id);
        }else {
            $this->session->set_flashdata('warning', 'Error changing Year of make for Booking# '.$booking_id);
            redirect(base_url() . 'bookings/create_jobcard/'.$booking_id);
        } 
		 
	}
	
	
	// Add Booking Jobcard Form
    public function update_jobcard()
    {
		/////////////////////////////////////////////////// ADD BOOKING START  
        $jobcard_data_set = $this->Bookings->update_booking_jobcard_data();   
		/////////////////////////////////////////////////// ADD BOOKING START END 
		
		/////////////////////////////////////////////////// ADD BOOKING DETAILS START
		$jobcard_details = $this->Bookings->update_booking_jobcard_details_data(); 
		/////////////////////////////////////////////////// ADD BOOKING DETAILS END 
		extract($_POST);
		$bookingdata = $this->Bookings->getbooking($booking_id);   
		$booking = $bookingdata['booking'];  
		if($jobcard_details['send_update_sms']==1){
				 $sms_data = array( 'booking_id' => $booking->booking_id, 'booking_id_encode' => base64_encode($booking->booking_id), 'base_url' => base_url()); 
		 		 $send_sms = $this->sms->sms_template(array($booking->customer_mobile),'jobcard-edited',$sms_data); 
		}
		
		if ($jobcard_details['response']) {
            $this->session->set_flashdata('success', 'Jobcard# '.$jobcard_id .' for Booking# '.$booking_id.' Updated Successfully..!');
            redirect(base_url() . 'bookings/booking_details/'.$booking_id);
        } 

    }
	
	public function approve_jobcard()
	{
		 
        $jobcard_approve = $this->Bookings->approve_jobcard_data();   
		 
		extract($_POST);
		 
		
		if ($jobcard_approve['response']) {
            $this->session->set_flashdata('success', 'Jobcard# '.$jobcard_id .' for Booking# '.$booking_id.' Approved Successfully..!');
            redirect(base_url() . 'bookings/booking_details/'.$booking_id);
        } 
		
	}
	
	public function get_customer_approval()
	{
		$booking_id = $this->uri->segment(3);
		 
		extract($_POST);
		 
		$bookingdata = $this->Bookings->getbooking($booking_id);   
		$booking = $bookingdata['booking'];  
		
				 $sms_data = array( 'booking_id' => base64_encode($booking_id), 'base_url' => base_url()); 
		 		 $send_sms = $this->sms->sms_template(array($booking->customer_mobile),'customer-approval',$sms_data); 
		
				 $mail_data = array('booking_id' => $booking_id);
				 $send_email = $this->mailer->mail_template($booking->customer_email,'customer-approval',$mail_data, 'emailer/jobcard_approve.php');
		
		$jobcard_data = array(  
			'customer_approval' => 'Sent',
			'updated_on' => date('Y-m-d H:i:s'), 
        ); 
		$jobcard_details = $this->Bookings->custom_update_jobcard($booking_id, $jobcard_data);
		
		if ($jobcard_details['response']) {
            $this->session->set_flashdata('success', 'Jobcard# '.$jobcard_id .' for Booking# '.$booking_id.' sent for customer approval Successfully..!');
            redirect(base_url() . 'bookings/booking_details/'.$booking_id);
        }  
	}
	
	
	 // Jobcard Spareslist
    public function jobcard_spares()
    {
		if(!empty($this->input->post('city'))){
		$data['city'] = $this->input->post('city'); 
		}else{
		$data['city'] = '';
		} 
		
        $this->rbac->check_module_access();  
		$this->rbac->check_sub_button_access('bookings','jobcard_spares', FALSE, array('add','edit','delete'));   
        $data['bookings'] = $this->Bookings->getbookinglist();  
        $this->header($title = 'Jobcard Spares');
        $this->load->view('bookings/jobcard_spares', $data);
        $this->footer();
    }
	
	 
	public function spares_recon()
    {   
        $booking_id = $this->uri->segment(3);  
		$this->rbac->check_module_access();       
		$this->rbac->check_sub_button_access('bookings','edit_jobcard', FALSE, array('edit')); 
		$bookingdata = $this->Bookings->getbooking($booking_id);   
		$data['booking'] = $bookingdata['booking'];  
		$data['jobcard'] = $bookingdata['jobcard'];  
		$data['jobcard_details'] = $bookingdata['jobcard_details']; 
		$data['booking_payments'] = $bookingdata['booking_payments']; 
        $this->header($title = 'Jobcard - Spares Recon'); 
        $this->load->view('bookings/spares_recon',$data);
        $this->footer();
    }
	
	public function save_spares_recon()
    {  
		extract($_POST); 
		/////////////////////////////////////////////////// ADD BOOKING DETAILS START
		$spares_recon_details = $this->Bookings->add_spares_recon_data(); 
		/////////////////////////////////////////////////// ADD BOOKING DETAILS END 
		 
		if($jobcard_details['send_update_sms']==1){
				 $sms_data = array( 'booking_id' => $booking->booking_id, 'booking_id_encode' => base64_encode($booking->booking_id), 'base_url' => base_url());  
		 		 $send_sms = $this->sms->sms_template(array($booking->customer_mobile),'jobcard-edited',$sms_data); 
		}
		
		if ($spares_recon_details['response']) {
            $this->session->set_flashdata('success', 'Spares Assigned For Booking Id# '.$booking_id.' Successfully..!');
            redirect(base_url() . 'bookings/jobcard_spares/');
        }  
         
    }
	
	
	
	public function add_booking_notes()
	{
	 		$add_note = $this->Bookings->add_booking_notes();  
        	extract($_POST);  
			$booking_id = $this->input->post('booking_id');  
			$notes_dump  = '';
			$booking_notes  = $this->Common->select_wher('booking_notes', array('booking_id' =>  $booking_id)); 
		    foreach ($booking_notes as $note) {
			 $notes_dump .= '<div class="card"><div class="card-body">'.$note->notes.'</div>  <div class="card-footer bg-whitesmoke">By: '.get_users(array('id'=>$note->created_by),'firstname').' - '.convert_datetime($note->created_on).'</div></div>'; 
			}
			echo  $notes_dump;	
	}
					 
		 
	public function reschedule_booking()
	{ 
			extract($_POST);  
			$rescheduled = $this->Bookings->reschedule_booking();  
            $this->session->set_flashdata('success', 'Booking# '.$booking_id.' Rescheduled Successfully..!');
            redirect(base_url() . 'bookings/booking_details/'.$booking_id);
        	 
	}	  
	
	
	 
	// Cancel Booking
    public function cancel_booking()
    {
        extract($_POST);    
        $cancel_info = array(
            'status' => 'Cancelled',
			'remark' => $cancel_remark,
        );
		 
		$cancel_info2 = array(
            'status' => 'Cancelled', 
        );
        $where = array('booking_id' => $booking_id);
        
        $this->Common->update_record('bookings', $cancel_info, $where);
		$this->Common->update_record('booking_services', $cancel_info2, $where);
		
		/*BOOKING TRACK*/ 
		$bookingdata = $this->Bookings->getbooking($booking_id);   
		$booking = $bookingdata['booking'];    
		$platform_details = platform_agent();
			$booking_track_data = array(
			'booking_id' => $booking_id,
            'customer_id' => $booking->customer_id,
			'vehicle_id' => $booking->vehicle_id,
			'status' => 'Cancelled',
			'stage' => 'Cancelled',
			'owner' => created_by(),	 
			'owner_name' => created_by_name(),	
			'owner_platform' => $platform_details,
			'remark' => $cancel_remark,
		    'created_on' => updated_on() 
        	);
		$response = $this->Common->add_record('booking_track', $booking_track_data); 
		  
		
			$serviceDateTime = convert_date($booking->service_date).' '.$booking->time_slot;
			$mechanic_name = get_service_providers(array('id'=>$booking->assigned_mechanic),'name');
		 $mail_data = array( 'booking_id' => $booking_id, 'name' => $booking->customer_name, 'email' => $booking->customer_email, 'mobile' => $booking->customer_mobile, 'cancel_reason' => $cancel_remark, 'serviceDateTime' => $serviceDateTime, 'cancelled_by' => created_by_name(), 'mechanic_name' => $mechanic_name);
		 
		$send_email = $this->mailer->mail_template('prabudh@garageworks.in','cancel-booking-notify-gw',$mail_data, 'custom');
		
		if(!empty($custom_bookingid)){
		return true;
		}else{
		//$this->Common->update_record('stock', $cat_data, $where);
        $this->session->set_flashdata('success', 'Booking# '.$booking_id.' Cancelled Successfully..!');
        redirect(base_url() . 'bookings/booking_details/'.$booking_id);
		}
     	
	}
	
	
	public function duplicate(){ 
		$result = $this->Bookings->DuplicateRecord('claims', 'id', 1);
		print_r($result);
	}
	
	// Booking Payments
    public function delete_booking()
    {
		$this->rbac->check_module_access();  
		$this->rbac->check_sub_button_access('bookings','delete_bookings', FALSE, array('delete'));   
		$this->header($title = 'Delete Booking'); 
        $this->load->view('bookings/delete_booking');
        $this->footer(); 
    }
	
	public function  delete_booking_data(){   
	 	$booking_id = $this->input->post('booking_id'); 
		$this->Common->delete_record('bookings', 'booking_id', $booking_id);
		$this->Common->delete_record('booking_details', 'booking_id', $booking_id);  
		$this->Common->delete_record('booking_estimate', 'booking_id', $booking_id);
		$this->Common->delete_record('booking_estimate_details', 'booking_id', $booking_id);
		$this->Common->delete_record('booking_payments', 'booking_id', $booking_id);
		$this->Common->delete_record('booking_services', 'booking_id', $booking_id);
		$this->Common->delete_record('booking_service_track', 'booking_id', $booking_id); 
		$this->Common->delete_record('booking_track', 'booking_id', $booking_id); 
		$this->Common->delete_record('booking_notes', 'booking_id', $booking_id);
		$this->Common->delete_record('inspection_uploads', 'booking_id', $booking_id); 
		$this->Common->delete_record('jobcard', 'booking_id', $booking_id);
		$this->Common->delete_record('jobcard_details', 'booking_id', $booking_id); 
		$this->Common->delete_record('mechanic_log', 'booking_id', $booking_id); 
		$this->Common->delete_record('report_uploads', 'booking_id', $booking_id); 
		$this->session->set_flashdata('success', 'Booking Id# '. $booking_id. ' deleted successfully'); 
		redirect(base_url() . 'bookings/delete_booking');
		
	}
	
	
	 // Zone Grouping 
    public function assign_mechanic()
    {  
 		$start_date1 = date('Y-m-d');  
        $data['start'] = $start_date1; 
		$data['cities'] = $this->Common->select('city');
		$data['booking'] = $this->db->query("SELECT * FROM bookings WHERE service_date > '".$start_date1."'")->result();  
		$data['mechanics'] = get_all_service_providers(array('department'=>'11'));  
        $this->header();
        $this->load->view('bookings/assign_mechanic', $data);
        $this->footer();  
    }
	function show_zone_bookings(){
		extract($_POST);     
        $data['bookingDate'] = $bookingDate; 
		$wher_param = array('customer_city'=>$city, 'service_date'=>$bookingDate, 'status !='=>"Completed", 'status !='=>"Cancelled", 'assigned_mechanic <'=>1); 
		$Unassigned_data = $this->Bookings->getbooking_conditional('Unassigned', $wher_param);
		$data['totalUnassigned'] = $Unassigned_data['count'];
		$data['city'] = $city; 
		$data['Action'] = $Action;
		$data['zones'] = get_area_details('zone', array('city'=>$city), true, true); 
		$data['mechanics'] = get_all_service_providers(array('department'=>'11'));  
        $this->header(); 
        $this->load->view('bookings/assign_mechanic',$data);
        $this->footer();
	}
	
	function assign_mechanic_Byzone(){
		extract($_POST);     
		$status = 'Assigned';
		$stage = 'Assigned';
		
			$data_entered=0;		 
		 for ($i = 0; $i < count($zone_serialno); $i++) { 
				 if($mechanic[$i]>0 && !empty($mechanic[$i])){  
					 /////////////////////////////////////////////////// UPDATE BOOKING START 
				$mechanic_assign_query = array(
				'assigned_mechanic' => $mechanic[$i],
				'stage' => $stage,
				'status' => $status,
				'updated_on' => updated_on()
            		); 
					$where = array('booking_id' => $booking_id[$i]);
         			$data_entry = $this->Common->update_record('bookings', $mechanic_assign_query, $where); 
					/////////////////////////////////////////////////// UPDATE BOOKING END 
					$bookingData = $this->Bookings->getbooking($booking_id[$i]); 
					 $booking=$bookingData['booking']; 
					 $platform_details = platform_agent(); 
			/////////////////////////////////////////////////// UPDATE BOOKING DETAILS START 
			 $booking_details_data = array(
			'assigned_mechanic' => $mechanic[$i],
            'assigned_by' => created_by(),
            'assigned_date' =>  created_on(), 
        );
			 $where = array('booking_id' => $booking_id[$i]);
			$this->Common->update_record('booking_details', $booking_details_data, $where); 
			/////////////////////////////////////////////////// UPDATE BOOKING DETAILS END 
					/////////////////////////////////////////////////// ADD BOOKING TRACK START  
					$Mechanic_Q = get_service_providers(array('id'=>$mechanic[$i]), 'name'); 
					$mechanic_assign_BookingTrack = array(
				'booking_id' => $booking_id[$i],
				'customer_id' =>$booking->customer_id,
				'vehicle_id' => $booking->vehicle_id,
				'status' =>$booking->status,		
				'stage' => 'Mechanic Assigned: '.$Mechanic_Q.'('.$mechanic[$i].')',
				'owner' =>  created_by(),	 
				'owner_name' => created_by_name(),			
				'owner_platform' => $platform_details,
				'created_on' =>  updated_on()		
						 );    
				 $data_entry = $this->Common->add_record('booking_track', $mechanic_assign_BookingTrack);  
				 	/////////////////////////////////////////////////// ADD BOOKING TRACK END
		 
					 
		 $mail_data = array('booking_id' => $booking_id[$i], 'mechanic_name'=>$Mechanic_Q);
		 $send_email = $this->mailer->mail_template($booking->customer_email,'mechanic-assigned',$mail_data, 'emailer/mechanic_assigned.php');
 		  
		 $service_category_name = get_service_category($booking->service_category_id);
		 $sms_data = array('mechanic_name'=>$Mechanic_Q, 'service_category' => $service_category_name, 'time_slot' => $booking->time_slot, 'service_date'=>convert_date($booking->service_date)); 
		 $send_sms = $this->sms->sms_template(array($booking->customer_mobile),'mechanic-assigned',$sms_data);  
				  $data_entered++;
				} 
		 } 
			if ($data_entered>0) { 
                $this->session->set_flashdata('success', 'Mechanic Assigned Successfully');
                 redirect(base_url() . 'bookings/assign_mechanic/'); 
            }else{ 
                $this->session->set_flashdata('warning', 'No Mechanic Selected to Assign');
                 redirect(base_url() . 'bookings/assign_mechanic/'); 
            }
		
		
	}
	 
	public function update_booking_address(){
			extract($_POST); 
			
			$cust_book_info = array(
					'customer_mobile' => $mobile,
					'customer_email' => $email,
					'customer_address_type' => $address_type,
					'customer_address' => $address,
					'customer_area' => $area,
					'customer_city' => $city,
					'customer_pincode' => $pincode,
					'customer_google_map' => $google_map,
					'customer_lat' => $latitude,
					'customer_long' => $longitude,
					'zone_id' => $zone,
					);
		 
		/////////////////////////////////////////////////// UPDATE BOOKING DETAILS START
		$custom_update_booking = $this->Bookings->custom_update_booking($booking_id, $cust_book_info); 
		/////////////////////////////////////////////////// UPDATE BOOKING DETAILS END 
		
		/////////////////////////////////////////////////// UPDATE CUSTOMER DETAILS START
		$update_customer = $this->customer_model->update_customer($customer_id); 
		/////////////////////////////////////////////////// UPDATE CUSTOMER DETAILS END 
		
		extract($_POST);
		$bookingdata = $this->Bookings->getbooking($booking_id);   
		$booking = $bookingdata['booking'];  
	  
		if ($custom_update_booking) {
            $this->session->set_flashdata('success', 'Booking# '.$booking_id.' Updated Successfully..!');
            redirect(base_url() . 'bookings/booking_details/'.$booking_id);
        }else{ 
            $this->session->set_flashdata('warning', 'Oops! Something went wrong while updating Booking# '.$booking_id.'..!');
            redirect(base_url() . 'bookings/booking_details/'.$booking_id);
        }
	}
	
	
	
	public function lock_unlock(){ 
				 $booking_id = $this->uri->segment(3); 
				 $bookingdata = $this->Bookings->getbooking($booking_id);   
		 		$booking  = $bookingdata['booking'];
				if($booking->locked == 1){
					$action = 'Unlocked';
					$lock=0; 
					$lock_status='unlocked_by_'.created_by_name(); 
				}else{  
					$action = 'Locked';
					$lock=1; 
					$lock_status='locked_by_'.created_by_name(); 
				}
				$data = array(
                'locked' => $lock, 
                'lock_status' => $lock_status  
            	); 
        		$where = array('booking_id' => $booking_id);
				$this->Common->update_record('bookings', $data, $where); 
				 $this->session->set_flashdata('success', 'Booking '.$action.' Successfully!');
                 redirect(base_url()); 
		
	}

}