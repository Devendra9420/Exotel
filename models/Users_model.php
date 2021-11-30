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

class Users_model extends CI_Model
{

    function index()
    {

    }

    // auth login
    public function AuthLogin($email, $password)
    {
        $pass = sha1(md5($password));
        // echo $pass;

        //$pass = sha1($password);
        $this->db->select("*");
        $this->db->from('usr_user');
        $this->db->where('USER_NAME', $email);
        $this->db->where('U_PASSWORD', $pass);
        $this->db->where('IS_ACTIVE', '1');
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->first_row('array');
    }

    //logout
    public function logout()
    {

        $this->session->sess_destroy();

        redirect(base_url());
    }
 
	
	public function get_users(){
		$this->rbac->check_sub_button_access('users', 'list_users', FALSE, array('edit'), array('edit'=>'<a href="'.base_url().'users/edit_user/$1" class="edit_record btn btn-info" data-user_id="$1" data-firstname="$2" data-lastname="$3" data-mobile="$4" data-city="$5" data-department="$6">Edit</a>'));  
		$this->rbac->check_sub_button_access('users', 'list_users', FALSE, array('delete'), array('delete'=>'<a href="javascript:void(0);" class="delete_record btn btn-danger" data-user_id="$1">Delete</a>'));  
		$this->datatables->select('id,username,firstname,lastname,mobile,email,city,department,pic');
      	$this->datatables->from('users');  
      	$this->datatables->add_column('action', '<a href="'.base_url().'/users/user_details/$1" class="btn btn-info" data-user_id="$1">Details</a> '.$this->rbac->updatePermission_custom.' '.$this->rbac->deletePermission_custom,'id,firstname,lastname,mobile,city,department');
		$this->datatables->edit_column('pic', '<img alt="image" src="$7" class="rounded-circle" width="35" data-toggle="tooltip" title="" data-original-title="$2 $3">','id,firstname,lastname,mobile,city,department,pic');
		return $this->datatables->generate(); 
	} 
     
    public function getuserslist()
    { 
        return $this->Common->select("users", 'firstname ASC'); 
        return $query->result();
    }
	
	public function getuser($user_id)
    { 
		$data = array();
		$data['user']  = get_users(array('id'=>$user_id));    
        return $data;
    }
	
	 public function add_user_data()
    { 
		 extract($_POST); 
		$last_user_id = $this->Common->find_maxid('id', 'users');
		$new_user_id = ($last_user_id+1);    
		 
		 if(empty($username)){
			 $username = $firstname.$lastname;
		 }
		 $user_info = array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'mobile' => $mobile,
            'alternate_no' => $alternate_no,
            'email' => $email,
            'department' => $department,
            'username' => $username,
			'password' => password_hash($password, PASSWORD_BCRYPT),
            'address' => $address,
            'city' => $city, 
            'area' => $area, 
            'gender' => $gender,
            'user_type' => 1,
            'is_active' => 1,
            'is_verify' => 1,
            'is_admin' => 0,
            'created_at' => created_on(),
            'created_by' => created_by(),
        ); 
		 
		 $this->load->library('file_upload'); 
        if(!empty($_FILES['user_pic'])){ 	 
            $user_pic_upload = $this->file_upload->do_image_upload('user_pic', 'users', 'user_'.$new_user_id); 
                if(!empty($user_pic_upload['file_name'])){ 	
                $user_pic = $user_pic_upload['full_path'];
                }else{
					if($gender=='Male'){ 
					$user_pic = base_url().'uploads/users/no_avatar.png';
					}else{
					$user_pic = base_url().'uploads/users/no_avatar_f.png';
					}
			}
        }else{
			if($gender=='Male'){ 
			$user_pic = base_url().'uploads/users/no_avatar.png';
			}else{
			$user_pic = base_url().'uploads/users/no_avatar_f.png';
			}
		}
		 
		 
		 if(!empty($_FILES['aadhar_front'])){ 	 
            $user_doc_upload = $this->file_upload->do_image_upload('aadhar_front', 'users', 'aadhar_front_'.$new_user_id); 
                if(!empty($user_doc_upload['file_name'])){ 	
                $user_info['aadhar_front']  = $user_doc_upload['full_path'];
                } 
		 }
         if(!empty($_FILES['aadhar_back'])){ 	 
            $user_doc_upload = $this->file_upload->do_image_upload('aadhar_back', 'users', 'aadhar_back_'.$new_user_id); 
                if(!empty($user_doc_upload['file_name'])){ 	
                $user_info['aadhar_back']  = $user_doc_upload['full_path'];
                } 
		 }
		 if(!empty($_FILES['pan_card'])){ 	 
            $user_doc_upload = $this->file_upload->do_image_upload('pan_card', 'users', 'pan_card_'.$new_user_id); 
                if(!empty($user_doc_upload['file_name'])){ 	
                $user_info['pan_card']  = $user_doc_upload['full_path'];
                } 
		 }
		 if(!empty($_FILES['driving_license'])){ 	 
            $user_doc_upload = $this->file_upload->do_image_upload('driving_license', 'users', 'driving_license_'.$new_user_id); 
                if(!empty($user_doc_upload['file_name'])){ 	
                $user_info['driving_license']  = $user_doc_upload['full_path'];
                } 
		 }
		 
		 
		 
		$user_info['pic'] = $user_pic; 
         
        $response = $this->Common->add_record('users', $user_info);
		$user_id = $this->db->insert_id();
		
		 if(!$user_id || $user_id<1){
				return false;
			}else{
				return $user_id;
			}
		
    }  
	
	
	
	public function update_user_data()
    { 
		 extract($_POST); 
		 
		 $user_info = array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'mobile' => $mobile,
            'alternate_no' => $alternate_no,
            'email' => $email,
            'department' => $department, 
            'address' => $address,
            'city' => $city, 
            'area' => $area, 
            'gender' => $gender,
            'user_type' => 1,
            'is_active' => 1,
            'is_verify' => 1,
            'is_admin' => 0,
            'updated_at' => updated_on(),
            'updated_by' => created_by(),
        ); 
		 
		 $this->load->library('file_upload'); 
        if(!empty($_FILES['user_pic'])){ 	 
            $user_pic_upload = $this->file_upload->do_image_upload('user_pic', 'users', 'user_'.$user_id); 
                if(!empty($user_pic_upload['file_name'])){ 	
                $user_pic = $user_pic_upload['full_path'];
                }else{
					if($gender=='Male'){ 
					$user_pic = base_url().'uploads/users/no_avatar.png';
					}else{
					$user_pic = base_url().'uploads/users/no_avatar_f.png';
					}
				}
			$user_info['pic'] = $user_pic; 
        } 
		 
		 
		 if(!empty($_FILES['aadhar_front'])){ 	 
            $user_doc_upload = $this->file_upload->do_image_upload('aadhar_front', 'users', 'aadhar_front_'.$user_id); 
                if(!empty($user_doc_upload['file_name'])){ 	
                $user_info['aadhar_front']  = $user_doc_upload['full_path'];
                } 
		 }
         if(!empty($_FILES['aadhar_back'])){ 	 
            $user_doc_upload = $this->file_upload->do_image_upload('aadhar_back', 'users', 'aadhar_back_'.$user_id); 
                if(!empty($user_doc_upload['file_name'])){ 	
                $user_info['aadhar_back']  = $user_doc_upload['full_path'];
                } 
		 }
		 if(!empty($_FILES['pan_card'])){ 	 
            $user_doc_upload = $this->file_upload->do_image_upload('pan_card', 'users', 'pan_card_'.$user_id); 
                if(!empty($user_doc_upload['file_name'])){ 	
                $user_info['pan_card']  = $user_doc_upload['full_path'];
                } 
		 }
		 if(!empty($_FILES['driving_license'])){ 	 
            $user_doc_upload = $this->file_upload->do_image_upload('driving_license', 'users', 'driving_license_'.$user_id); 
                if(!empty($user_doc_upload['file_name'])){ 	
                $user_info['driving_license']  = $user_doc_upload['full_path'];
                } 
		 }
		 
		  
		
         
		 $where = array(
			 'id' => $user_id,
		 );
		
        $response = $this->Common->update_record('users', $user_info, $where);
		 		
		 if(!$response){
				return false;
			}else{
				return true;
			}
		
    }  
	
	
	
	

}

?>