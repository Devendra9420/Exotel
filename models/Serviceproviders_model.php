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

class Serviceproviders_model extends CI_Model
{

    function index()
    {

    }

     

    //logout
    public function logout()
    {

        $this->session->sess_destroy();

        redirect(base_url());
    }
 
	
	public function get_serviceproviders(){
		$this->rbac->check_sub_button_access('serviceproviders', 'list_serviceproviders', FALSE, 'edit', array('edit'=>'<a href="'.base_url().'serviceproviders/edit_serviceprovider/$1" class="edit_record btn btn-info" data-serviceprovider_id="$1" data-name="$2" data-lastname="$3" data-mobile="$4" data-city="$5" data-department="$6">Edit</a>'));  
		$this->rbac->check_sub_button_access('serviceproviders', 'list_serviceproviders', FALSE, 'delete', array('delete'=>'<a href="javascript:void(0);" class="delete_record btn btn-danger" data-serviceprovider_id="$1">Delete</a>'));  
		$this->datatables->select('id,name,name,lastname,mobile,email,city,department,pic');
      	$this->datatables->from('service_providers');  
      	$this->datatables->add_column('action', '<a href="'.base_url().'/serviceproviders/serviceprovider_details/$1" class="btn btn-info" data-serviceprovider_id="$1">Details</a> '.$this->rbac->updatePermission_custom.' '.$this->rbac->deletePermission_custom,'id,name,lastname,mobile,city,department');
		$this->datatables->edit_column('pic', '<img alt="image" src="$7" class="rounded-circle" width="35" data-toggle="tooltip" title="" data-original-title="$2 $3">','id,name,lastname,mobile,city,department,pic');
		return $this->datatables->generate(); 
	} 
     
    public function getserviceproviderslist()
    { 
        return $this->Common->select("service_providers", 'name ASC'); 
        return $query->result();
    }
	
	public function getserviceprovider($serviceprovider_id)
    { 
		$data = array();
		$data['serviceprovider']  = get_service_providers(array('id'=>$serviceprovider_id));    
        return $data;
    }
	
	 public function add_serviceprovider_data()
    { 
		 extract($_POST); 
		$last_serviceprovider_id = $this->Common->find_maxid('id', 'service_providers');
		$new_serviceprovider_id = ($last_serviceprovider_id+1);    
		 $serviceprovider_info = array(
            'name' => $name,
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
            'user_type' => 2,
            'is_active' => 1,
            'is_verify' => 1,
            'is_admin' => 0,
            'created_at' => created_on(),
            'created_by' => created_by(),
        ); 
		 
		 $this->load->library('file_upload'); 
        if(!empty($_FILES['serviceprovider_pic'])){ 	 
            $serviceprovider_pic_upload = $this->file_upload->do_image_upload('serviceprovider_pic', 'service_providers', 'serviceprovider_'.$new_serviceprovider_id); 
                if(!empty($serviceprovider_pic_upload['file_name'])){ 	
                $serviceprovider_pic = $serviceprovider_pic_upload['full_path'];
                }else{
					if($gender=='Male'){ 
					$serviceprovider_pic = base_url().'uploads/users/no_avatar.png';
					}else{
					$serviceprovider_pic = base_url().'uploads/users/no_avatar_f.png';
					}
			}
        }else{
			if($gender=='Male'){ 
			$serviceprovider_pic = base_url().'uploads/users/no_avatar.png';
			}else{
			$serviceprovider_pic = base_url().'uploads/users/no_avatar_f.png';
			}
		}
		 
		 
		 if(!empty($_FILES['aadhar_front'])){ 	 
            $serviceprovider_doc_upload = $this->file_upload->do_image_upload('aadhar_front', 'service_providers', 'aadhar_front_'.$new_serviceprovider_id); 
                if(!empty($serviceprovider_doc_upload['file_name'])){ 	
                $serviceprovider_info['aadhar_front']  = $serviceprovider_doc_upload['full_path'];
                } 
		 }
         if(!empty($_FILES['aadhar_back'])){ 	 
            $serviceprovider_doc_upload = $this->file_upload->do_image_upload('aadhar_back', 'service_providers', 'aadhar_back_'.$new_serviceprovider_id); 
                if(!empty($serviceprovider_doc_upload['file_name'])){ 	
                $serviceprovider_info['aadhar_back']  = $serviceprovider_doc_upload['full_path'];
                } 
		 }
		 if(!empty($_FILES['pan_card'])){ 	 
            $serviceprovider_doc_upload = $this->file_upload->do_image_upload('pan_card', 'service_providers', 'pan_card_'.$new_serviceprovider_id); 
                if(!empty($serviceprovider_doc_upload['file_name'])){ 	
                $serviceprovider_info['pan_card']  = $serviceprovider_doc_upload['full_path'];
                } 
		 }
		 if(!empty($_FILES['driving_license'])){ 	 
            $serviceprovider_doc_upload = $this->file_upload->do_image_upload('driving_license', 'service_providers', 'driving_license_'.$new_serviceprovider_id); 
                if(!empty($serviceprovider_doc_upload['file_name'])){ 	
                $serviceprovider_info['driving_license']  = $serviceprovider_doc_upload['full_path'];
                } 
		 }
		 
		 
		 
		$serviceprovider_info['pic'] = $serviceprovider_pic; 
         
        $response = $this->Common->add_record('service_providers', $serviceprovider_info);
		$serviceprovider_id = $this->db->insert_id();
		
		 if(!$serviceprovider_id || $serviceprovider_id<1){
				return false;
			}else{
				return $serviceprovider_id;
			}
		
    }  
	
	
	
	public function update_serviceprovider_data()
    { 
		 extract($_POST); 
		 
		 $serviceprovider_info = array(
            'name' => $name,
            'lastname' => $lastname,
            'mobile' => $mobile,
            'alternate_no' => $alternate_no,
            'email' => $email,
            'department' => $department, 
            'address' => $address,
            'city' => $city, 
            'area' => $area, 
            'gender' => $gender,
            'user_type' => 2,
            'is_active' => 1,
            'is_verify' => 1,
            'is_admin' => 0,
            'updated_at' => updated_on(),
            'updated_by' => created_by(),
        ); 
		 
		 $this->load->library('file_upload'); 
        if(!empty($_FILES['serviceprovider_pic'])){ 	 
            $serviceprovider_pic_upload = $this->file_upload->do_image_upload('serviceprovider_pic', 'service_providers', 'serviceprovider_'.$serviceprovider_id); 
                if(!empty($serviceprovider_pic_upload['file_name'])){ 	
                $serviceprovider_pic = $serviceprovider_pic_upload['full_path'];
                }else{
					if($gender=='Male'){ 
					$serviceprovider_pic = base_url().'uploads/users/no_avatar.png';
					}else{
					$serviceprovider_pic = base_url().'uploads/users/no_avatar_f.png';
					}
				}
			$serviceprovider_info['pic'] = $serviceprovider_pic; 
        } 
		 
		 
		 if(!empty($_FILES['aadhar_front'])){ 	 
            $serviceprovider_doc_upload = $this->file_upload->do_image_upload('aadhar_front', 'service_providers', 'aadhar_front_'.$serviceprovider_id); 
                if(!empty($serviceprovider_doc_upload['file_name'])){ 	
                $serviceprovider_info['aadhar_front']  = $serviceprovider_doc_upload['full_path'];
                } 
		 }
         if(!empty($_FILES['aadhar_back'])){ 	 
            $serviceprovider_doc_upload = $this->file_upload->do_image_upload('aadhar_back', 'service_providers', 'aadhar_back_'.$serviceprovider_id); 
                if(!empty($serviceprovider_doc_upload['file_name'])){ 	
                $serviceprovider_info['aadhar_back']  = $serviceprovider_doc_upload['full_path'];
                } 
		 }
		 if(!empty($_FILES['pan_card'])){ 	 
            $serviceprovider_doc_upload = $this->file_upload->do_image_upload('pan_card', 'service_providers', 'pan_card_'.$serviceprovider_id); 
                if(!empty($serviceprovider_doc_upload['file_name'])){ 	
                $serviceprovider_info['pan_card']  = $serviceprovider_doc_upload['full_path'];
                } 
		 }
		 if(!empty($_FILES['driving_license'])){ 	 
            $serviceprovider_doc_upload = $this->file_upload->do_image_upload('driving_license', 'service_providers', 'driving_license_'.$serviceprovider_id); 
                if(!empty($serviceprovider_doc_upload['file_name'])){ 	
                $serviceprovider_info['driving_license']  = $serviceprovider_doc_upload['full_path'];
                } 
		 }
		 
		  
		
         
		 $where = array(
			 'id' => $serviceprovider_id,
		 );
		
        $response = $this->Common->update_record('service_providers', $serviceprovider_info, $where);
		 		
		 if(!$response){
				return false;
			}else{
				return true;
			}
		
    }  
	
	
	
	

}

?>