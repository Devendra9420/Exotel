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
 
 
   
	
class Mechanicdash extends MY_Controller
{

    public function __construct()
    {
        parent::__construct(); 
		$this->load->model('Bookings_model', 'Bookings'); 
		$this->load->model('Mechanicdash_model', 'Mechanicdash'); 
    }
	
	 
	
    public function mechanicdash()
    {
		$data['action'] = 'no_action';  
		$mechanic_id = $this->input->post('mechanic_id'); 
		if(empty($mechanic_id)){
		$mechanic_id = '';	
		$data['mechanics'] = get_all_service_providers(array('department'=>'11')); 
		}else{
		$mechanic_id = $this->input->post('mechanic_id');	
		$data['mechanics'] = get_service_providers(array('id'=>$mechanic_id));
		} 
		if(empty($this->input->post('start_date'))){
		$start_date = date('d/m/Y', strtotime('first day of this month'));	
		}else{
		$start_date = $this->input->post('start_date');	
		} 
		if(empty($this->input->post('end_date'))){
		$end_date = date('d/m/Y');	
		}else{
		$end_date = $this->input->post('end_date');	
		} 
		
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date)); 
		
	   	$data['start'] = $start_date;
        $data['end'] = $end_date;
		
		$data['start_date'] = date('Y-d-m', strtotime($start_date));
        $data['end_date'] = date('Y-d-m', strtotime($end_date));
		
		$data['start_date1'] = $start_date1;
        $data['end_date1'] = $end_date1;
        $this->header();
		$this->load->view('mechanicdash/mechanicdash',$data);
		$this->footer();
     }
	
	
	// Mechanic Billings
    public function mechanicbill()
    {
		if(!empty($this->input->post('action'))){
		$data['action'] = $this->input->post('action'); 
		}else{
		$data['action'] = '';
		} 
		
		$mechanic_id = $this->input->post('mechanic_id'); 
		if(empty($mechanic_id)){
		$mechanic_id = '';	
		$data['mechanics'] = get_all_service_providers(array('department'=>'11')); 
		}else{
		$mechanic_id = $this->input->post('mechanic_id');	
		$data['mechanics'] = get_service_providers(array('id'=>$mechanic_id));
		} 
		if(empty($this->input->post('start_date'))){
		$start_date = date('d/m/Y', strtotime('first day of this month'));	
		}else{
		$start_date = $this->input->post('start_date');	
		} 
		if(empty($this->input->post('end_date'))){
		$end_date = date('d/m/Y');	
		}else{
		$end_date = $this->input->post('end_date');	
		} 
		
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date)); 
		
	   	$data['start'] = $start_date;
        $data['end'] = $end_date;
		
		$data['start_date'] = date('Y-d-m', strtotime($start_date));
        $data['end_date'] = date('Y-d-m', strtotime($end_date));
		
		$data['start_date1'] = $start_date1;
        $data['end_date1'] = $end_date1;
		
		 
		$mechanic_id = $this->input->post('mechanic_id');	
		$data['mechanic_id'] = $mechanic_id;
		$data['mechanic'] = get_service_providers(array('id'=>$mechanic_id));
		$data['bookings'] =  $this->Common->select_wher('bookings', array('assigned_mechanic'=>$mechanic_id, 'status'=>'Completed', 'service_date >='=>$start_date1, 'service_date <='=>$end_date1));	 
		$data['mechanic_log'] = $this->Common->select_wher('mechanic_log', array('mechanic_id'=>$mechanic_id));	 
		 
        $this->header();
        $this->load->view('mechanicdash/mechanicbill',$data);
        $this->footer();
     }
	 
	
	
	// Mechanic Perform
    public function mechanicperform()
    {
		if(!empty($this->input->post('action'))){
		$data['action'] = $this->input->post('action'); 
		}else{
		$data['action'] = '';
		} 
		
		$mechanic_id = $this->input->post('mechanic_id'); 
		if(empty($mechanic_id)){
		$mechanic_id = '';	
		$data['mechanics'] = get_all_service_providers(array('department'=>'11')); 
		}else{
		$mechanic_id = $this->input->post('mechanic_id');	
		$data['mechanics'] = get_service_providers(array('id'=>$mechanic_id));
		} 
		if(empty($this->input->post('daterange_m'))){
		$start_date = date('Y-m-d', strtotime('first day of this month'));
		$end_date = date('Y-m-d', strtotime('last day of this month'));	
		}else{ 
			
			if($this->input->post('daterange_m') == 'last_month'){
			$start_date = date('Y-m-d', strtotime('first day of last month'));
			$end_date = date('Y-m-d', strtotime('last day of last month'));	
			}elseif($this->input->post('daterange_m') == 'last_3_month'){
			$start_date = date('d-m-Y', strtotime('-3 month',strtotime(date('m').'/01/'.date('Y').' 00:00:00')));;
			$end_date = date('Y-m-d');	
			}else{
			$start_date = date('Y-m-d', strtotime('first day of this month'));
			$end_date = date('Y-m-d', strtotime('last day of this month'));	
			}
			
		} 
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));
         
	   	$data['start'] = $start_date;
        $data['end'] = $end_date;
		$data['start_date1'] = $start_date1;
        $data['end_date1'] = $end_date1;
		
		 
		$mechanic_id = $this->input->post('mechanic_id');	
		$data['mechanic_id'] = $mechanic_id;
		$data['mechanic'] = get_service_providers(array('id'=>$mechanic_id));
		$data['bookings'] =  $this->Common->select_wher('bookings', array('assigned_mechanic'=>$mechanic_id, 'status'=>'Completed', 'service_date >='=>$start_date1, 'service_date <='=>$end_date1));	 
		$data['mechanic_log'] = $this->Common->select_wher('mechanic_log', array('mechanic_id'=>$mechanic_id));	 
		  
        $this->header();
        $this->load->view('mechanicdash/mechanicperform',$data);
        $this->footer(); 
     }
	
	
	
	// Mechanic Perform
    public function mechanictravel()
    {
		if(!empty($this->input->post('action'))){
		$data['action'] = $this->input->post('action'); 
		}else{
		$data['action'] = '';
		} 
		
		$mechanic_id = $this->input->post('mechanic_id'); 
		if(empty($mechanic_id)){
		$mechanic_id = '';	
		$data['mechanics'] = get_all_service_providers(array('department'=>'11')); 
		}else{
		$mechanic_id = $this->input->post('mechanic_id');	
		$data['mechanics'] = get_service_providers(array('id'=>$mechanic_id));
		} 
		if(empty($this->input->post('daterange_m'))){
		$start_date = date('Y-m-d', strtotime('first day of this month'));
		$end_date = date('Y-m-d', strtotime('last day of this month'));	
		}else{ 
			
			if($this->input->post('daterange_m') == 'last_month'){
			$start_date = date('Y-m-d', strtotime('first day of last month'));
			$end_date = date('Y-m-d', strtotime('last day of last month'));	
			}elseif($this->input->post('daterange_m') == 'last_3_month'){
			$start_date = date('d-m-Y', strtotime('-3 month',strtotime(date('m').'/01/'.date('Y').' 00:00:00')));;
			$end_date = date('Y-m-d');	
			}else{
			$start_date = date('Y-m-d', strtotime('first day of this month'));
			$end_date = date('Y-m-d', strtotime('last day of this month'));	
			}
			
		} 
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));
         
	   	$data['start'] = $start_date;
        $data['end'] = $end_date;
		$data['start_date1'] = $start_date1;
        $data['end_date1'] = $end_date1;
		
		 
		$mechanic_id = $this->input->post('mechanic_id');	
		$data['mechanic_id'] = $mechanic_id;
		$data['mechanic'] = get_service_providers(array('id'=>$mechanic_id));
		$data['bookings'] =  $this->Common->select_wher('bookings', array('assigned_mechanic'=>$mechanic_id, 'status'=>'Completed', 'service_date >='=>$start_date1, 'service_date <='=>$end_date1));	 
		$data['mechanic_log'] = $this->Common->select_wher('mechanic_log', array('mechanic_id'=>$mechanic_id));	 
		  
        $this->header();
        $this->load->view('mechanicdash/mechanictravel',$data);
        $this->footer(); 
     }
	
    

}