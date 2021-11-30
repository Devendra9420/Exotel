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

/**
 * Class serviceproviders
 *
 * @property CI_Session session
 * @property serviceprovider serviceprovider
 * @property General General
 * @property Main_model Main_model
 * @property CI_Input input
 * @property CI_URI uri
 */
//Extending all Controllers from Core Controller (MY_Controller)
class Serviceproviders extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access(); 
		//$this->load->model('serviceproviders'); 
		$this->load->model('Serviceproviders_model', 'Serviceproviders');
    }

    

    //Load View Form For serviceprovider Creation.........
    public function add_serviceprovider()
    {
		$this->rbac->check_sub_module_access(); 
		$this->rbac->check_sub_button_access('serviceproviders','add', FALSE, array('add'));  
        $data['departments'] = $this->Common->select_wher('departments',array('user_type_id'=>2, 'is_active'=>1)); 
        $this->header($title = 'Add Service Provider');
        $this->load->view('service_providers/add_serviceprovider', $data);
        $this->footer();

    }
	// List Customers
    public function list_serviceproviders()
    {
        $this->rbac->check_module_access();  
		$this->rbac->check_sub_button_access('serviceproviders','list_serviceproviders', FALSE, array('add','edit','delete'));  
		$this->rbac->check_sub_button_access('serviceproviders', 'add_serviceprovider', FALSE, 'add', array('add'=>'<a href="'.base_url().'serviceproviders/add_serviceprovider" class="add_record btn btn-info"> Add New <i class="fa fa-plus"></i></a>')); 
        $data['serviceproviders'] = $this->Serviceproviders->getserviceproviderslist();  
        $this->header($title = 'Service Providers List');
        $this->load->view('service_providers/list_serviceproviders', $data);
        $this->footer();
    }
	
	public function get_serviceproviders(){
		 header('Content-Type: application/json'); 
        echo $this->Serviceproviders->get_serviceproviders();
	}
	
    // Customer Details
    public function serviceprovider_details()
    {
        $this->rbac->check_module_access();  
		$this->rbac->check_sub_button_permission();  
		$serviceprovider_id = $this->uri->segment(3);
		$serviceproviderdata = $this->Serviceproviders->getserviceprovider($serviceprovider_id);  
		$data['serviceprovider_id'] = $serviceprovider_id;   
		$data['serviceprovider']  = $serviceproviderdata['serviceprovider'];  
        $this->header($title = 'Service Provider Detail'); 
        $this->load->view('service_providers/serviceprovider_details', $data); 
        $this->footer();
    }
	
	//Load View Form For serviceprovider Creation.........
    public function edit_serviceprovider()
    {
		$this->rbac->check_sub_module_access(); 
		$this->rbac->check_sub_button_access('serviceproviders','edit', FALSE, array('edit'));  
        $data['departments'] = $this->Common->select_wher('departments',array('user_type_id'=>2, 'is_active'=>1)); 
		$serviceprovider_id = $this->uri->segment(3);
		$serviceproviderdata = $this->Serviceproviders->getserviceprovider($serviceprovider_id);  
		$data['serviceprovider_id'] = $serviceprovider_id;   
		$data['serviceprovider']  = $serviceproviderdata['serviceprovider'];  
        $this->header($title = 'Edit Service Provider');
        $this->load->view('service_providers/edit_serviceprovider', $data);
        $this->footer();

    }
	
	
	// Insert new Customer to Databse
    public function insert_serviceprovider()
    {
         
		extract($_POST); 
		 $response = $this->Serviceproviders->add_serviceprovider_data();   
		  
        if ($response) {
            $this->session->set_flashdata('success', 'New Service Provider added Successfully..!');
            redirect(base_url() . 'serviceproviders/list_serviceproviders');
        }
    }
	
     
 // Insert new Customer to Databse
    public function update_serviceprovider()
    {
         
		extract($_POST); 
		 $response = $this->Serviceproviders->update_serviceprovider_data();   
		  
        if ($response) {
            $this->session->set_flashdata('success', 'Service Provider Id# '.$serviceprovider_id.' has been updated Successfully..!');
            redirect(base_url() . 'serviceproviders/list_serviceproviders');
        }
    }

    // Delete specific serviceprovider
    public function delete_serviceproviders($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('serviceproviders'); 
        $this->session->set_flashdata('success', 'serviceprovider has been deleted successfully');
        redirect(base_url() . 'serviceproviders/list_serviceproviders');

    }

    //status of serviceprovider (Active)
    public function activate_serviceprovider()
    {
        $serviceprovider_id = $this->uri->segment(3);
        $update = array(
            'is_active' => '1' 
        );
        $where = array(
            'id' => $serviceprovider_id 
        );
        $data['serviceproviders'] = $this->Common->update_record('service_providers', $update, $where);
        redirect(base_url() . "serviceproviders/serviceprovider_details/".$serviceprovider_id);
    }

    //status of serviceprovider (In-active)
    public function deactive_serviceprovider()
    { 
        $serviceprovider_id = $this->uri->segment(3);
        $update = array(
            'is_active' => '0' 
        );
        $where = array(
            'id' => $serviceprovider_id 
        );
        $data['serviceproviders'] = $this->Common->update_record('service_providers', $update, $where);
        redirect(base_url() . "serviceproviders/serviceprovider_details/".$serviceprovider_id);
    }
  
 
}
