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
class Offers extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Bookings_model', 'Bookings');
        $this->load->model('Feedback_model', 'Feedbacks');
    }




    // View 
    public function list_guest()
    {
        //$this->rbac->check_module_access();  
        //$this->rbac->check_sub_button_access('offers','list_guest', FALSE, array('view','add','edit','delete'));   
        // $data['guests'] = $this->getguestlist();  
        $this->header($title = 'Offer Guests');
        $this->load->view('offers/list_guest');
        $this->footer();
    }

    public function get_all_guest()
    {
        header('Content-Type: application/json');
        $this->datatables->select('guest_id,name,mobile,vehicle_make,vehicle_model,code,claimed,created_on,updated_on');
        $this->datatables->from('guest');
        //$this->datatables->add_column('action', '<a href="javascript:get_referrals($1);" class="btn btn-icon btn-primary" data-booking_id="$1"><i class="fas fa-eye"></i></a>','guest_id'); 
        echo $this->datatables->generate();
    }



    // View 
    public function list_referrals()
    {
        //$this->rbac->check_module_access();  
        //$this->rbac->check_sub_button_access('offers','list_guest', FALSE, array('view','add','edit','delete'));   
        //  $data['referrals'] = $this->getreferralslist();  
        $this->header($title = 'Offer Referrals');
        $this->load->view('offers/list_referrals');
        $this->footer();
    }

    public function get_all_referrals()
    {
        header('Content-Type: application/json');
        $this->datatables->select('id,guest_id,name,mobile,voted,created_on');
        $this->datatables->from('referral');
        //$this->datatables->add_column('action', '<a href="javascript:get_referrals($1);" class="btn btn-icon btn-primary" data-booking_id="$1"><i class="fas fa-eye"></i></a>','guest_id'); 
        echo $this->datatables->generate();
    }
}
