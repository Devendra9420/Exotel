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
class Estimator extends MY_Controller
{

	 public function __construct()
    {
        parent::__construct();
        auth_check(); // check login auth
		$this->load->model('Bookings_model', 'Bookings'); 
		$this->load->model('Estimator_model', 'Estimator');
		  
    }

	  
	
	 
    public function estimate()
    {
		
		
		if(!empty($this->input->post('action'))){
		$data['action'] = $this->input->post('action'); 
		}else{
		$data['action'] = '';
		} 
		 
		if(!empty($this->input->post('make')) && !empty($this->input->post('model'))){ 
		$data['make_id']=$this->input->post('make');	
		$data['model_id']=$this->input->post('model');	 
		 }else{
		$data['make_id']='';	
		$data['model_id']='';		
		}
 
			if(!empty($this->session->userdata('city'))){
				$data['city'] = $this->session->userdata('city');
			}if(!empty($this->input->post('city'))){
				$data['city'] = $this->input->post('city');
			}else{
				$data['city'] = 'Pune';
			}
		 
        $this->header($title = 'Estimate'); 
        $this->load->view('estimator/estimate', $data);
        $this->footer();
    }
	
	
	
	 
	
	 
	
	
	
	// Save Estimate
    public function create_estimate()
    {
		extract($_POST);
		/////////////////////////////////////////////////// ADD BOOKING START  
        $estimate_id = $this->Estimator->add_estimate_data();   
		/////////////////////////////////////////////////// ADD BOOKING START END 
		
		/////////////////////////////////////////////////// ADD BOOKING DETAILS START
		$estimate_details = $this->Estimator->add_estimate_details_data($estimate_id); 
		/////////////////////////////////////////////////// ADD BOOKING DETAILS END 
		
		if ($estimate_details) {
            $this->session->set_flashdata('success', 'Estimator# '.$estimate_id .' Created Successfully..!');
            redirect(base_url() . 'estimator/estimate');
        } 
    }
	
	 


}