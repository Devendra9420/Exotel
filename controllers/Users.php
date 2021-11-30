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
 * Class users
 *
 * @property CI_Session session
 * @property User User
 * @property General General
 * @property Main_model Main_model
 * @property CI_Input input
 * @property CI_URI uri
 */
//Extending all Controllers from Core Controller (MY_Controller)
class Users extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        auth_check(); // check login auth
        $this->rbac->check_module_access();
        //$this->load->model('Users'); 
        $this->load->model('Users_model', 'Users');
    }



    //Load View Form For User Creation.........
    public function add_user()
    {
        $this->rbac->check_sub_module_access();
        $this->rbac->check_sub_button_access('users', 'add_user', FALSE, array('add'));
        $data['departments'] = $this->Common->select_wher('departments', array('user_type_id' => 1, 'is_active' => 1));
        $this->header($title = 'Add User');
        $this->load->view('users/add_user', $data);
        $this->footer();
    }
    // List Customers
    public function list_users()
    {
        $this->rbac->check_module_access();
        $this->rbac->check_sub_button_access('users', 'list_users', FALSE, array('add', 'edit', 'delete'));
        $this->rbac->check_sub_button_access('users', 'add_user', FALSE, array('add'), array('add' => '<a href="' . base_url() . 'users/add_user" class="add_record btn btn-info"> Add New <i class="fa fa-plus"></i></a>'));
        $data['users'] = $this->Users->getuserslist();
        $this->header($title = 'Users List');
        $this->load->view('users/list_users', $data);
        $this->footer();
    }

    public function get_users()
    {
        header('Content-Type: application/json');
        echo $this->Users->get_users();
    }

    // Customer Details
    public function user_details()
    {
        $this->rbac->check_module_access();
        $this->rbac->check_sub_button_permission();
        $user_id = $this->uri->segment(3);
        $userdata = $this->Users->getuser($user_id);
        $data['user_id'] = $user_id;
        $data['user']  = $userdata['user'];
        $this->header($title = 'User Detail');
        $this->load->view('users/user_details', $data);
        $this->footer();
    }

    //Load View Form For User Creation.........
    public function edit_user()
    {
        $this->rbac->check_sub_module_access();
        $this->rbac->check_sub_button_access('users', 'edit', FALSE, array('edit'));
        $data['departments'] = $this->Common->select_wher('departments', array('user_type_id' => 1, 'is_active' => 1));
        $user_id = $this->uri->segment(3);
        $userdata = $this->Users->getuser($user_id);
        $data['user_id'] = $user_id;
        $data['user']  = $userdata['user'];
        $this->header($title = 'Edit User');
        $this->load->view('users/edit_user', $data);
        $this->footer();
    }


    // Insert new Customer to Databse
    public function insert_user()
    {

        extract($_POST);
        $response = $this->Users->add_user_data();

        if ($response) {
            $this->session->set_flashdata('success', 'New User added Successfully..!');
            redirect(base_url() . 'users/list_users');
        }
    }


    // Insert new Customer to Databse
    public function update_user()
    {

        extract($_POST);
        $response = $this->Users->update_user_data();

        if ($response) {
            $this->session->set_flashdata('success', 'User Id# ' . $user_id . ' has been updated Successfully..!');
            redirect(base_url() . 'users/list_users');
        }
    }

    // Delete specific user
    public function delete_users($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('users');
        $this->session->set_userdata('success', 'User has been deleted successfully');
        redirect(base_url() . 'Users/list_users');
    }

    //status of user (Active)
    public function activate_user()
    {
        $user_id = $this->uri->segment(3);
        $update = array(
            'is_active' => '1'
        );
        $where = array(
            'id' => $user_id
        );
        $data['users'] = $this->Common->update_record('users', $update, $where);
        redirect(base_url() . "users/user_details/" . $user_id);
    }

    //status of user (In-active)
    public function deactive_user()
    {
        $user_id = $this->uri->segment(3);
        $update = array(
            'is_active' => '0'
        );
        $where = array(
            'id' => $user_id
        );
        $data['users'] = $this->Common->update_record('users', $update, $where);
        redirect(base_url() . "users/user_details/" . $user_id);
    }
}
