<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 *	@author : Chintan Desai
 *  @support: chintz2806@gmail.com
 *	date	: 01 November, 2019
 *	GarageWorks Inventory Management System
 *  website: garageworks.in
 *  version: 1.0
 */
class Claims extends MY_Controller
{

	public function __construct()
    {
        parent::__construct();
		 // $this->output->enable_profiler(TRUE);
		$ci =& get_instance();	   
	$apiKey = urlencode('Ay+JJSUfJHE-OIKqfZM0a7dukqAGf4XyHPw5HfG7WO');	   		
	$dataTextlocal=array("username"=>'info@garageworks.in',"hash"=>'c6b1afd667f0095a22a8c695fc640a44174d4c6321ad31b843bf350549767cfa',"apikey"=>$apiKey);
    $ci->load->library('Textlocal',$dataTextlocal);
		
        if ($this->session->userdata('user_id')) {
        } else {
        redirect(base_url() . 'index.php/Users/login');
        }

    }
	 

   

    // List Items
    public function list_claims()
    {

        $data['item'] = $this->Main_model->all_claims();
        $data['gics'] = $this->Main_model->select('gic');
		$data['cities'] = $this->Main_model->select('city');
		$data['makes'] = $this->Main_model->select('vehicle_make');
		$data['models'] = $this->Main_model->select('vehicle_model');
		// $data['category'] = $this->Main_model->select('category');
        $this->header();
        $this->load->view('claims/list_claims', $data);
        $this->footer();


    }

    // Inserting new Item to Database
    public function create_new_claims()
    {
        $name = $this->input->post('name');
        $mobile = $this->input->post('mobile');
        $alternate_no = $this->input->post('alternate_no');
	//	$address = $this->input->post('address');
		$city = $this->input->post('city');
        
		
		$make = $this->input->post('make');
		$model = $this->input->post('model');
	//	$yom = $this->input->post('yom');
	//	$color = $this->input->post('color');
	//	$regno = $this->input->post('regno');
	//	$km = $this->input->post('km');
	 	$v_address = $this->input->post('v_address');
		$customer_google_map = $this->input->post('customer_google_map');
		
	//	$engine_no = $this->input->post('engine_no');
	//	$chasis_no = $this->input->post('chasis_no');
		$gic = $this->input->post('gic');
		$claim_no = $this->input->post('claim_no');
		$created_by = $this->session->userdata('user_id'); // $user_id;
		$created_on = date('Y-m-d', strtotime($this->input->post('created_on'))); //$this->input->post('created_on');// date('Y-m-d');
		 
		$status = '0';
		
       /// $qrCode = $this->input->post('qrCode');
        $this->load->model('Main_model');
          
            $data = array(
                'name' => $name,
                'mobile' => $mobile,
               'alternate_no' => $alternate_no,
             //   'address' => $address,
				'make' => $make,
                'model' => $model,
            //    'yom' => $yom,
           //     'color' => $color,
          //      'regno' => $regno,
			//	'km' => $km,
			 	'v_address' => $v_address,
				'google_map' => $customer_google_map,
			//	'engine_no' => $engine_no,
			//	'chasis_no' => $chasis_no,
				'created_on' => $created_on,
				'created_by' => $created_by,
				'gic' => $gic,
				'claim_no' => $claim_no,
				'city' => $city,
				'active' => 1

            );
             
            $response = $this->Main_model->add_record('claims', $data);
			
			$newclaimid = $this->db->insert_id();
		
			$cust_info2 = array(
			'claim_id' => $newclaimid,
             'stage' => 0,
			'status' => 'Claim Created'
        );
			$this->Main_model->add_record('claim_status', $cust_info2);
			
		////////////////////////////////////////////////////////////////////////////////////// CUSTOMER SMS ////////////////////////////////////////////////
		   				
						//GET CLAIM DATA
						$where = array('id' => $newclaimid);;
						$getclaimdata =$this->Main_model->single_row('claims', $where, 's');
						//GET MAKE
						$where = array('make_id' => $getclaimdata['make']);
						$getmake =$this->Main_model->single_row('vehicle_make', $where, 's');
						//GET MODEL
						$where = array('model_id' => $getclaimdata['model']);
						$getmodel =$this->Main_model->single_row('vehicle_model', $where, 's');
			 			
		
						if(!empty($getmake['make_name'])){
							$makename = $getmake['make_name'];
						}else{
							$makename = '#';
						}
		
						if(!empty($getmake['model_name'])){
							$modelname = $getmake['model_name'];
						}else{
							$modelname = '#';
						}
						
						if(!empty($name)){
							$name = $name;
						}else{
							$name = 'Customer';
						}
						
		
			 	$sms_msg = 'Hi '.$name.', We have registered your claim for '.$makename.' '.$modelname.'. To know more about GarageWorks claims experience, please click here https://garageworks.in/claimsinfo.html. Please contact us at (080) 47184618 for any further queries - GarageWorks';
				 
				
		
			  	$smsresponse = $this->send_booking_sms($getclaimdata['mobile'], $sms_msg);
				$uploadlink =  base_url().'surveyorapp/customeruploaddetails/'.$newclaimid;
				$sms_msg = 'Hi '.$name.', For faster claims processing, please upload the following documents on the link: '.$uploadlink.' Claim Form, Driving License, RC Copy, PAN Card - GarageWorks'; 
					 
		
			
			  $smsresponse = $this->send_booking_sms($getclaimdata['mobile'], $sms_msg);
		
    	////////////////////////////////////////////////////////////////////////////////////// CUSTOMER SMS ////////////////////////////////////////////////
		
		
           // $stock = $this->Main_model->add_record('stock', $data2);
            if ($response) {
                 

                $this->session->set_flashdata('success', 'claims added Successfully');
                redirect(base_url() . 'index.php/Claims/list_claims');

            }
         
    }
	
	public function update_vehicledetails()
	{
		$custid = $this->input->post('cid');
		$claim_no = $this->input->post('claim_no');
        $make = $this->input->post('make'); 
        $model = $this->input->post('model'); 
		$name = $this->input->post('name');
		$cust_info = array(
			'name' => $name,
            'make'=> $make,
			'model' => $model, 
			'claim_no' => $claim_no,
        );
        $where = array('id' => $custid);
        $this->load->model('Main_model');
        $this->Main_model->update_record('claims', $cust_info,$where); 

		$this->session->set_flashdata('success', 'claims added Successfully');
        redirect(base_url() . 'claims/claims_details/'.$custid);
			 
		 
	}
	
	// claims details
    public function claims_details()
    {
        $id = $this->uri->segment(3);
		$data['makes'] = $this->Main_model->select('vehicle_make');
		$data['models'] = $this->Main_model->select('vehicle_model');
        $where = array('id' => $id);
		$where2 = array('claim_id' => $id);
		$data['gics'] = $this->Main_model->select('gic');
		$data['surveyors'] = $this->Main_model->select('surveyor'); 
        $this->header();
        $data['stage'] = $this->Main_model->single_row('claim_status', $where2, 's');
		$data['surveyDetail'] = $this->Main_model->single_row('claims', $where, 's');
        $this->load->view('claims/claims_details', $data);
        $this->footer();
    }
	
	
	public function addClaimsnotes(){
		$this->load->model('Main_model');
        
		$claimsid = $this->input->post('claimsid');
		
		$admincomment = $this->input->post('admincomment');
		
		$created_by =  $this->session->userdata('user_id'); 
		
		$created_on = date('Y-m-d H:i:s'); //$this->input->post('created_on');// date('Y-m-d');
		
		$cust_info = array(
            'claim_id'=> $claimsid,
			'notes' => $admincomment,
			'created_by' => $created_by,
			'created_on' => $created_on, 
        );
         	$this->Main_model->add_record('claim_notes', $cust_info);
			$note_id = $this->db->insert_id();
			$adminnotesdump  = '';
			$getnotes  = $this->db->query("select * from claim_notes where claim_id=".$claimsid."")->result();
		    foreach ($getnotes as $claim_notes) {
			 $adminnotesdump .= $claim_notes->notes.'<br><small style="color:grey">'.date('d-m-Y H:i:s', strtotime($claim_notes->created_on)).'</small><hr>';
			}
		
			 echo  $adminnotesdump;
		
	}
	
	
	// Assign claims
    public function assign_claims()
    {
        $custid = $this->input->post('cid'); 
        $survey_assigned_on = date('Y-m-d', strtotime($_POST['survey_assigned_on']));
		$cust_info = array(
            'claim_id'=> $custid,
			'surveyor' => $this->input->post('assigned_surveryor'),
			'survey_date' => $survey_assigned_on,
			'created_on' => date('Y-m-d') 
        );
        $where = array('id' => $custid);
        $this->load->model('Main_model');
        $this->Main_model->add_record('claim_survey_assign', $cust_info);
         
		$this->update_claim_status($custid, '1', 'Survey Scheduled');

		 
			 
		$where = array('id' => $custid);
						$getclaimdata =$this->Main_model->single_row('claims', $where, 's');
		
		$where2 = array('surveyor_id' => $this->input->post('assigned_surveryor'));
						$getsurveyordata =$this->Main_model->single_row('surveyor', $where2, 's');
		
		$message = "New Survey assigned! Claim No ".$custid.". Survey Link: ".base_url()."index.php/surveyorapp/surveydetails/".$custid;
			//"Hi, Your insurance claim has been registered with GarageWorks. Our representative will connect to schedule a survey";
		//$surveysms = $this->send_booking_sms($getsurveyordata['mobile'],$message);
		
		  	
		////////////////////////////////////////////////////////////////////////////////////// CUSTOMER SMS ////////////////////////////////////////////////
		   				//GET CLAIM DATA
						$where = array('id' => $custid);
						$getclaimdata =$this->Main_model->single_row('claims', $where, 's');
						//GET MAKE
						$where = array('make_id' => $getclaimdata['make']);
						$getmake =$this->Main_model->single_row('vehicle_make', $where, 's');
						//GET MODEL
						$where = array('model_id' => $getclaimdata['model']);
						$getmodel =$this->Main_model->single_row('vehicle_model', $where, 's');
			 
			 	$sms_msg = 'Hi '.$getclaimdata['name'].', Survey for your claim '.$getclaimdata['claim_no'].' has been scheduled for '.$survey_assigned_on.'. '.$getsurveyordata['name'].' will contact prior to visiting you - GarageWorks';
				 
			  	$smsresponse = $this->send_booking_sms($getclaimdata['mobile'], $sms_msg);
				 
				
		$sms_msg = 'Claim No '.$getclaimdata['claim_no'].', '.$getclaimdata['name'].', '.$getclaimdata['mobile'].', '.$getclaimdata['v_address'].', Survey Form: https://garageworks.in/flywheel_demo/surveyorapp/surveydetails/'.$custid;
				 
			  	$smsresponse = $this->send_booking_sms($getsurveyordata['mobile'], $sms_msg);
		
    	////////////////////////////////////////////////////////////////////////////////////// CUSTOMER SMS ////////////////////////////////////////////////
			
        //$this->Main_model->update_record('stock', $cat_data, $where);
        $this->session->set_flashdata('info', 'claims Updated Successfully..!');

        redirect(base_url() . 'index.php/claims/claims_details/'.$custid);
    }
	
	
	// Assign claims
    public function update_kyc()
    {
        $custid = $this->input->post('cid'); 
		$cust_info = array( 
            'name' => $this->input->post('name'),
			'mobile' => $this->input->post('mobile'),
			'alternate_no' => $this->input->post('alternate_no'),
			'email' => $this->input->post('email'),
			'v_address' => $this->input->post('v_address'),
			'google_map' => $this->input->post('customer_google_map'),
        );
        $where = array('id' => $custid);
        $this->load->model('Main_model'); 
        $this->Main_model->update_record('claims', $cust_info, $where); 
		$this->session->set_flashdata('info', 'claims Updated Successfully..!');

        redirect(base_url() . 'index.php/claims/claims_details/'.$custid);
    }
	
	
	// Assign claims
    public function surveystatus_claims()
    {
        $custid = $this->input->post('cid'); 
        $survey_date = date('Y-m-d', strtotime($_POST['survey_date']));
		$cust_info = array(
			'claim_id' => $custid,
            'survey_status' => $this->input->post('survey_status'),
			'survey_date' => $survey_date,
			'created_on' => date('Y-m-d')
        );
        $where = array('id' => $custid);
        $this->load->model('Main_model');
        $this->Main_model->add_record('claim_survey_status', $cust_info);
         
		$this->update_claim_status($custid, '2', 'Survey Document Pending');
		
        //$this->Main_model->update_record('stock', $cat_data, $where);
        $this->session->set_flashdata('info', 'claims Updated Successfully..!');

        redirect(base_url() . 'index.php/claims/claims_details/'.$custid);
    }
	
	
	// Assign claims
    public function surveystatus_claims_btn()
    {
       // $custid = $this->input->post('cid'); 
		$custid = $this->uri->segment(3);
        //$survey_date = date('Y-m-d', strtotime($_POST['survey_date']));
		$cust_info = array(
			'claim_id' => $custid,
            'survey_status' => 'Yes',//$this->input->post('survey_status'),
			'survey_date' => date('Y-m-d'),
			'created_on' => date('Y-m-d')
        );
        $where = array('id' => $custid);
        $this->load->model('Main_model');
        $this->Main_model->add_record('claim_survey_status', $cust_info);
         
		$this->update_claim_status($custid, '2', 'Survey Document Pending');
		
        //$this->Main_model->update_record('stock', $cat_data, $where);
        $this->session->set_flashdata('info', 'claims Updated Successfully..!');

        redirect(base_url() . 'index.php/claims/claims_details/'.$custid);
    }
	
	
	// Create claims Form
    public function create_survey_form()
    {
        $custid = $this->input->post('cid'); 
		
		
		$survey_code = $custid;
		
		///////DOCUMENT UPLOAD
	  
		$uploaddir = "uploads/images/claims/";
		// Configure upload directory and allowed file types 
    	$upload_dir = "uploads/images/claims/";
    	$allowed_types = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx', 'xls', 'xlsx'); 
      
    	// Define maxsize for files i.e 2MB 
    	$maxsize = 60 * 1024 * 1024;  
		$uploaded_on = date('Y-m-d');
		 
		
		 // Checks if user sent an empty form  
    if(!empty(array_filter($_FILES['claim_form']['name']))) {  
        // Loop through each file in files[] array 
        foreach ($_FILES['claim_form']['tmp_name'] as $key => $value) {  
			$file_tmpname = $_FILES['claim_form']['tmp_name'][$key]; 
            $file_name = $_FILES['claim_form']['name'][$key]; 
            $file_size = $_FILES['claim_form']['size'][$key]; 
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION); 
		
		  if ($file_name != '') {
			
			$temp = explode(".", $file_name);
				$newfilename =  $survey_code. '_claim_form_' . $key . '.' . end($temp);
 			 
			
			$data_upload = $uploaddir . basename($newfilename);
             
            $imageFileType = strtolower(pathinfo($data_upload,PATHINFO_EXTENSION));
             
			if(!in_array(strtolower($file_ext), $allowed_types)) { 
                 $this->session->set_flashdata('warning', 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
                 
                $uploadOk = 0;
                redirect(base_url().'index.php/claims/claims_details/'.$custid);

            }
			  if ($file_size > $maxsize){           
                      $this->session->set_flashdata('warning', 'Error: File size is larger than the allowed limit.');
			redirect(base_url().'index.php/claims/claims_details/'.$custid);	   
		  }
			 if (move_uploaded_file($file_tmpname, $data_upload)) {

                $picture = $data_upload; 
				  
				  /// $qrCode = $this->input->post('qrCode');
        $this->load->model('Main_model');
          
            $data = array(
                'claims_id' => $custid,
                'type' => 'Claim_Form',
                'new_filename' => $newfilename,
                'actual_filename' => $file_name,
				'file_type' => $imageFileType,
                'file_url' => $data_upload, 
				'uploaded_on' => $uploaded_on 

            );
             
            $response = $this->Main_model->add_record('claims_uploads', $data);
				 
				
					 
			 
				 
				 
            } else {
                 $this->session->set_flashdata('warning', 'Error:  '.$file_name.' could not be uploaded.');
			redirect(base_url().'index.php/claims/claims_details/'.$custid);	 


            }
        } else {

              $this->session->set_flashdata('warning', 'Error:  '.$file_name.' could not be uploaded.');
			redirect(base_url().'index.php/claims/claims_details/'.$custid);	 
        }
		
		
		}
		
	}
		
		 ////// VEHICLE IMAGE UPLOAD
		 
		
		
		
		 // Checks if user sent an empty form  
    if(!empty(array_filter($_FILES['vehicle_pics_upload']['name']))) { 
  
        // Loop through each file in files[] array 
        foreach ($_FILES['vehicle_pics_upload']['tmp_name'] as $key => $value) { 
		
		
			$file_tmpname = $_FILES['vehicle_pics_upload']['tmp_name'][$key]; 
            $file_name = $_FILES['vehicle_pics_upload']['name'][$key]; 
            $file_size = $_FILES['vehicle_pics_upload']['size'][$key]; 
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION); 
		
		  if ($file_name != '') {
			
			$temp = explode(".", $file_name);
				$newfilename =  $survey_code. '_vehicle_pics_' . $key . '.' . end($temp);
 			 
			
			$data_upload = $uploaddir . basename($newfilename);
            //$data_upload = $uploaddir . basename($_FILES['file_picture']['name']);
            $imageFileType = strtolower(pathinfo($data_upload,PATHINFO_EXTENSION));
             
			if(!in_array(strtolower($file_ext), $allowed_types)) { 
                 $this->session->set_flashdata('warning', 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
                //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
                redirect(base_url().'index.php/claims/claims_details/'.$custid);

            }
			  if ($file_size > $maxsize){           
                      $this->session->set_flashdata('warning', 'Error: File size is larger than the allowed limit.');
			redirect(base_url().'index.php/claims/claims_details/'.$custid);	   
		  }
			 if (move_uploaded_file($file_tmpname, $data_upload)) {

                $picture = $data_upload;
				 
				 
				  /// $qrCode = $this->input->post('qrCode');
        $this->load->model('Main_model');
          
            $data = array(
                'claims_id' => $custid,
                'type' => 'Vehicle_Images',
                'new_filename' => $newfilename,
                'actual_filename' => $file_name,
				'file_type' => $imageFileType,
                'file_url' => $data_upload, 
				'uploaded_on' => $uploaded_on 

            );
             
				 
				 	 
					 
            $response = $this->Main_model->add_record('claims_uploads', $data);
			
			 
				 
				 
            } else {
                 $this->session->set_flashdata('warning', 'Error:  '.$file_name.' could not be uploaded.');
			redirect(base_url().'index.php/claims/claims_details/'.$custid);	 


            }
        } else {

              $this->session->set_flashdata('warning', 'Error:  '.$file_name.' could not be uploaded.');
			redirect(base_url().'index.php/claims/claims_details/'.$custid);	 
        }
		
		
		}
		
	}
		
		 ////// RC COPY 
		
		 // Checks if user sent an empty form  
    if(!empty($_FILES['rc_copy']['name'])) { 
  
        // Loop through each file in files[] array 
        //foreach ($_FILES['rc_copy']['tmp_name'] as $key => $value) {  
			$file_tmpname = $_FILES['rc_copy']['tmp_name']; 
            $file_name = $_FILES['rc_copy']['name']; 
            $file_size = $_FILES['rc_copy']['size']; 
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION); 
		
		  if ($file_name != '') {
			
			$temp = explode(".", $file_name);
				$newfilename = $survey_code. '_rc_copy.' . end($temp);
 			 
			
			$data_upload = $uploaddir . basename($newfilename);
            //$data_upload = $uploaddir . basename($_FILES['file_picture']['name']);
            $imageFileType = strtolower(pathinfo($data_upload,PATHINFO_EXTENSION));
             
			if(!in_array(strtolower($file_ext), $allowed_types)) { 
                 $this->session->set_flashdata('warning', 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
                //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
                redirect(base_url().'index.php/claims/claims_details/'.$custid);

            }
			  if ($file_size > $maxsize){           
                      $this->session->set_flashdata('warning', 'Error: File size is larger than the allowed limit.');
			redirect(base_url().'index.php/claims/claims_details/'.$custid);	   
		  }
			 if (move_uploaded_file($file_tmpname, $data_upload)) {

                $picture = $data_upload;
				 
				 
				  /// $qrCode = $this->input->post('qrCode');
        $this->load->model('Main_model');
          
            $data = array(
                'claims_id' => $custid,
                'type' => 'RC_Copy',
                'new_filename' => $newfilename,
                'actual_filename' => $file_name,
				'file_type' => $imageFileType,
                'file_url' => $data_upload, 
				'uploaded_on' => $uploaded_on 

            );
             
				 
					 
					 
            $response = $this->Main_model->add_record('claims_uploads', $data);
				
			 
				 
				 
            } else {
                 $this->session->set_flashdata('warning', 'Error:  '.$file_name.' could not be uploaded.');
			redirect(base_url().'index.php/claims/claims_details/'.$custid);	 


            }
        } else {

              $this->session->set_flashdata('warning', 'Error:  '.$file_name.' could not be uploaded.');
			redirect(base_url().'index.php/claims/claims_details/'.$custid);	 
        }
		
		
		 
		
	}
		
		
		
		
			 ////// PAN Card
		
		 // Checks if user sent an empty form  
    if(!empty($_FILES['pancard']['name'])) { 
  
        // Loop through each file in files[] array 
        //foreach ($_FILES['rc_copy']['tmp_name'] as $key => $value) {  
			$file_tmpname = $_FILES['pancard']['tmp_name']; 
            $file_name = $_FILES['pancard']['name']; 
            $file_size = $_FILES['pancard']['size']; 
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION); 
		
		  if ($file_name != '') {
			
			$temp = explode(".", $file_name);
				$newfilename = $survey_code. '_pancard.' . end($temp);
 			 
			
			$data_upload = $uploaddir . basename($newfilename);
            //$data_upload = $uploaddir . basename($_FILES['file_picture']['name']);
            $imageFileType = strtolower(pathinfo($data_upload,PATHINFO_EXTENSION));
             
			if(!in_array(strtolower($file_ext), $allowed_types)) { 
                 $this->session->set_flashdata('warning', 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
                //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
                redirect(base_url().'index.php/claims/claims_details/'.$custid);

            }
			  if ($file_size > $maxsize){           
                      $this->session->set_flashdata('warning', 'Error: File size is larger than the allowed limit.');
			redirect(base_url().'index.php/claims/claims_details/'.$custid);	   
		  }
			 if (move_uploaded_file($file_tmpname, $data_upload)) {

                $picture = $data_upload;
				 
				 
				  /// $qrCode = $this->input->post('qrCode');
        $this->load->model('Main_model');
          
            $data = array(
                'claims_id' => $custid,
                'type' => 'PAN_Card',
                'new_filename' => $newfilename,
                'actual_filename' => $file_name,
				'file_type' => $imageFileType,
                'file_url' => $data_upload, 
				'uploaded_on' => $uploaded_on 

            );
             
            $response = $this->Main_model->add_record('claims_uploads', $data);
				
			 
				 
				 
            } else {
                 $this->session->set_flashdata('warning', 'Error:  '.$file_name.' could not be uploaded.');
			redirect(base_url().'index.php/claims/claims_details/'.$custid);	 


            }
        } else {

              $this->session->set_flashdata('warning', 'Error:  '.$file_name.' could not be uploaded.');
			redirect(base_url().'index.php/claims/claims_details/'.$custid);	 
        }
		
		
		 
		
	}
		
		
		
		////// Driving License Back
		
		 // Checks if user sent an empty form  
    if(!empty($_FILES['driving_license_back']['name'])) { 
  
        // Loop through each file in files[] array 
        //foreach ($_FILES['rc_copy']['tmp_name'] as $key => $value) {  
			$file_tmpname = $_FILES['driving_license_back']['tmp_name']; 
            $file_name = $_FILES['driving_license_back']['name']; 
            $file_size = $_FILES['driving_license_back']['size']; 
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION); 
		
		  if ($file_name != '') {
			
			$temp = explode(".", $file_name);
				$newfilename = $survey_code. '_driving_license_back.' . end($temp);
 			 
			
			$data_upload = $uploaddir . basename($newfilename);
            //$data_upload = $uploaddir . basename($_FILES['file_picture']['name']);
            $imageFileType = strtolower(pathinfo($data_upload,PATHINFO_EXTENSION));
             
			if(!in_array(strtolower($file_ext), $allowed_types)) { 
                 $this->session->set_flashdata('warning', 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
                //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
                redirect(base_url().'index.php/claims/claims_details/'.$custid);

            }
			  if ($file_size > $maxsize){           
                      $this->session->set_flashdata('warning', 'Error: File size is larger than the allowed limit.');
			redirect(base_url().'index.php/claims/claims_details/'.$custid);	   
		  }
			 if (move_uploaded_file($file_tmpname, $data_upload)) {

                $picture = $data_upload;
				 
				 
				  /// $qrCode = $this->input->post('qrCode');
        $this->load->model('Main_model');
          
            $data = array(
                'claims_id' => $custid,
                'type' => 'Driving_License_Back',
                'new_filename' => $newfilename,
                'actual_filename' => $file_name,
				'file_type' => $imageFileType,
                'file_url' => $data_upload, 
				'uploaded_on' => $uploaded_on 

            );
             
            $response = $this->Main_model->add_record('claims_uploads', $data);
				
			 
            } else {
                 $this->session->set_flashdata('warning', 'Error:  '.$file_name.' could not be uploaded.');
			redirect(base_url().'index.php/claims/claims_details/'.$custid);	 


            }
        } else {

              $this->session->set_flashdata('warning', 'Error:  '.$file_name.' could not be uploaded.');
			redirect(base_url().'index.php/claims/claims_details/'.$custid);	 
        }
		
		
		 
		
	}
		
		
		
		
		////// Driving License Front
		
		 // Checks if user sent an empty form  
    if(!empty($_FILES['driving_license_front']['name'])) { 
  
        // Loop through each file in files[] array 
        //foreach ($_FILES['rc_copy']['tmp_name'] as $key => $value) {  
			$file_tmpname = $_FILES['driving_license_front']['tmp_name']; 
            $file_name = $_FILES['driving_license_front']['name']; 
            $file_size = $_FILES['driving_license_front']['size']; 
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION); 
		
		  if ($file_name != '') {
			
			$temp = explode(".", $file_name);
				$newfilename = $survey_code. '_driving_license_front.' . end($temp);
 			 
			
			$data_upload = $uploaddir . basename($newfilename);
            //$data_upload = $uploaddir . basename($_FILES['file_picture']['name']);
            $imageFileType = strtolower(pathinfo($data_upload,PATHINFO_EXTENSION));
             
			if(!in_array(strtolower($file_ext), $allowed_types)) { 
                 $this->session->set_flashdata('warning', 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
                //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
                redirect(base_url().'index.php/claims/claims_details/'.$custid);

            }
			  if ($file_size > $maxsize){           
                      $this->session->set_flashdata('warning', 'Error: File size is larger than the allowed limit.');
			redirect(base_url().'index.php/claims/claims_details/'.$custid);	   
		  }
			 if (move_uploaded_file($file_tmpname, $data_upload)) {

                $picture = $data_upload;
				 
				 
				  /// $qrCode = $this->input->post('qrCode');
        $this->load->model('Main_model');
          
            $data = array(
                'claims_id' => $custid,
                'type' => 'Driving_License_Front',
                'new_filename' => $newfilename,
                'actual_filename' => $file_name,
				'file_type' => $imageFileType,
                'file_url' => $data_upload, 
				'uploaded_on' => $uploaded_on 

            );
             
            $response = $this->Main_model->add_record('claims_uploads', $data);
			
			
				 
            } else {
                 $this->session->set_flashdata('warning', 'Error:  '.$file_name.' could not be uploaded.');
			redirect(base_url().'index.php/claims/claims_details/'.$custid);	 


            }
        } else {

              $this->session->set_flashdata('warning', 'Error:  '.$file_name.' could not be uploaded.');
			redirect(base_url().'index.php/claims/claims_details/'.$custid);	 
        }
		
		
		 
		
	}
		
		
		
		 
		
		 ////// VEHICLE IMAGES UPLOAD
		$yom = $this->input->post('yom');
		$color = $this->input->post('color');
		$regno = $this->input->post('regno');
		$km = $this->input->post('km'); 
		$insurance_expire = date('Y-m-d', strtotime($this->input->post('insurance_expire')));  
		
		 
		
		$surveyed_on = date('Y-m-d', strtotime($_POST['surveyed_on']));
		$cust_info = array( 
			'claim_id'=>$custid,
			'insurance_expire'=>$insurance_expire,
			'surveyed_on' => $surveyed_on,
			'yom' => $yom,
            'color' => $color,
            'regno' => $regno,
			'km' => $km,
			'engine_no' =>  $this->input->post('surveyed_engine_no'),
			'chasis_no' => $this->input->post('surveyed_chasis_no'), 
			'created_on'=> date('Y-m-d')
        );
			    	 
		
        $where = array('id' => $custid);
        $this->load->model('Main_model');
        $this->Main_model->add_record('claim_survey_details', $cust_info);
		$this->update_claim_status($custid, '3', 'Estimate Pending');
		
		$this->update_claim_details($custid, 'surveyed_on', $surveyed_on);
		
        $this->session->set_flashdata('info', 'claims Form Created Successfully..!');
		
		
		////////////////////////////////////////////////////////////////////////////////////// CUSTOMER SMS ////////////////////////////////////////////////
		   				//GET CLAIM DATA
						$where = array('id' => $custid);
						$getclaimdata =$this->Main_model->single_row('claims', $where, 's');
						//GET MAKE
						$where = array('make_id' => $getclaimdata['make']);
						$getmake =$this->Main_model->single_row('vehicle_make', $where, 's');
						//GET MODEL
						$where = array('model_id' => $getclaimdata['model']);
						$getmodel =$this->Main_model->single_row('vehicle_model', $where, 's');
			 
			 	$sms_msg = 'Hi '.$getclaimdata['name'].', Survey has been completed for your claim '.$getclaimdata['claim_no'].'. Please contact us at (080) 47184618 for any further queries - GarageWorks';
				 
			  	$smsresponse = $this->send_booking_sms($getclaimdata['mobile'], $sms_msg);
				 
		
    	////////////////////////////////////////////////////////////////////////////////////// CUSTOMER SMS ////////////////////////////////////////////////
		
        redirect(base_url() . 'index.php/claims/claims_details/'.$custid);
    }
	
	
	
	
	 
	
	
	
	
	
	// claims Estimate Form
    public function claims_estimate()
    {
        $id = $this->uri->segment(3);
        $where = array('id' => $id);
		
		 $claimdet = $this->db->query("SELECT * FROM claims WHERE id =".$id)->row();
        
		
		
		if(!empty($claimdet)){ 
			
			$getvehicledet  = $this->db->query("SELECT model_code, vehicle_category FROM vehicle_model WHERE make_id='".$claimdet->make."' AND model_id = '".$claimdet->model."'");
			$vehdet = $getvehicledet->row();
			
			$citynameq = $this->db->query("SELECT cityname FROM city WHERE city_id =".$claimdet->city)->row();
			$cityname = $citynameq->cityname;
			
			$data['model_code']=$vehdet->model_code;
			$data['vehicle_category']=$vehdet->vehicle_category;
			
			$data['customer_channel']='Insurance'; 
			 
			 $data['customer_city'] = $cityname;
			
			
			$sparestable = $this->db->query("SELECT * FROM spares WHERE model_code='".$data['model_code']."' AND vehicle_category = '".$data['vehicle_category']."'");
			$spareslists = $sparestable->result();
			
			
			$labourtable = $this->db->query("SELECT * FROM labour WHERE vehicle_category = '".$data['vehicle_category']."'");
			$labourlists = $labourtable->result();
			 
			$data['spares_list']  =	$spareslists;
			$data['labour_list']  =	$labourlists;   
		}
			
			
		 
        $this->header();
        $data['surveyDetail'] = $this->Main_model->single_row('claims', $where, 's');
        $this->load->view('claims/claims_estimate', $data);
        $this->footer();
    }
	
	
	
	public function estimate_SpecificSpares()
	{
		$specific_spares =   $this->input->post('specific_spares');
		$vehicle_category =   $this->input->post('vehicle_category');
		$model_code =    $this->input->post('model_code');
		$customer_channel =    $this->input->post('customer_channel');
		$customer_city =    strtolower($this->input->post('customer_city'));
		$count = $this->input->post('total');
		$this->load->model('Main_model');
		
		
		$sparesid = $this->db->query("SELECT * FROM spares WHERE model_code='".$model_code."' AND vehicle_category = '".$vehicle_category."' AND item_code = '".$specific_spares."'")->row();
		
		 
			
				if(!empty($sparesid)){  
					$sparesrate_cost = $this->db->query("SELECT MAX(rate) AS rate FROM spares_rate WHERE spares_id='".$sparesid->spares_id."'")->row();
					$spares_labour_rate_cost = $this->db->query("SELECT  $customer_city AS rate, item_code, item_name, vehicle_category   FROM labour WHERE  vehicle_category = '".$vehicle_category."' AND item_code='".$sparesid->item_code."'")->row();
					
					if(empty($sparesrate_cost->rate) || empty($sparesrate_cost)){
						$sparesrate = 0;
					}else{ 
						
						
						$checkDiscount = $this->db->query("SELECT amount,type FROM discount WHERE service='Spares' AND criteria = '".$customer_channel."' AND active='active'")->row();
						if(!empty($checkDiscount->amount) && !empty($checkDiscount->type)){
							if($checkDiscount->type=='slab'){
							$sparesrate = $sparesrate_cost->rate-$checkDiscount->amount;	
							}elseif($checkDiscount->type=='flat'){
							$sparesrate = $checkDiscount->amount;	
							}elseif($checkDiscount->type=='percentage'){
							 $sparesrate = $sparesrate_cost->rate - ($sparesrate_cost->rate * ($checkDiscount->amount / 100));
							}else{ 
							$sparesrate = $sparesrate_cost->rate;
							}
						}else{ 
						$sparesrate = $sparesrate_cost->rate;
						}
						
						
					}
					
					if(empty($spares_labour_rate_cost)){
						$spares_labour_rate = 0;
					}else{
						$spares_labour_rate = $spares_labour_rate_cost->rate;
					}
					$s_itemcode = $sparesid->spares_id;
					$s_itemname = $sparesid->item_name;
				 }else{
					$sparesrate = 0;
					$spares_labour_rate = 0;
					$s_itemcode = '';
					$s_itemname = '';
				}
		
			$unit_price = $sparesrate;
			$labour_amount = $spares_labour_rate;
			$estimated_amount = $unit_price+$labour_amount;
			
		$getallbrands  = $this->db->query("SELECT * FROM spares_rate WHERE spares_id = '$s_itemcode'")->result();
				$brandslist="<option value='0'>None</option>";
			
				foreach($getallbrands as $getallbrand){
					
					if($getallbrand->id>0){ 
					$brandslist .= "<option value='".$getallbrand->id."'>".$getallbrand->brand."</option>";
					}
				}
		
		
			 if(!empty($s_itemname)){ 
		$estimate_table_data[] = array("count"=>$count, "item_id"=>$s_itemcode, "item_name"=>$s_itemname, "quantity"=>'1', "unit_price"=>$unit_price, "labour_price"=>$labour_amount, "estimated_amount"=>$estimated_amount, "brandlist"=>$brandslist);
		 
			 }else{
		$estimate_table_data[]	= '';	 
			 }
		
		
		 echo json_encode($estimate_table_data);
		
	}
	
	
	public function estimate_SpecificLabour()
	{
		$specific_labour =     $this->input->post('specific_repairs');
		$vehicle_category =     $this->input->post('vehicle_category');
		$model_code =     $this->input->post('model_code');
		$customer_city =    strtolower($this->input->post('customer_city'));
		$count = $this->input->post('total');
		$this->load->model('Main_model');
		
		
		$labourprice_cost = $this->db->query("SELECT $customer_city AS rate, item_code, item_name, vehicle_category FROM labour WHERE vehicle_category = '".$vehicle_category."' AND item_code = '".$specific_labour."'")->row();
		
		
	 
				if(!empty($labourprice_cost)){ 	
					
					$labourprice = $labourprice_cost->rate;
					
					$l_itemcode = $labourprice_cost->item_code;
					$l_itemname = 'Labour - '.$labourprice_cost->item_name;
				}else{
					$labourprice = 0;
					$l_itemcode = '';
					$l_itemname = '';
				} 
			if(!empty($s_itemname)){
				$itemname = $s_itemname;
				$itemcode = $s_itemcode;
			}else{
				$itemname = $l_itemname;
				$itemcode = $l_itemcode;
			}
			$unit_price = 0;
			$labour_amount = $labourprice;
			$estimated_amount = $unit_price+$labour_amount;
			
			 if(!empty($itemname)){ 
		$estimate_table_data[] = array("count"=>$count, "item_id"=>$itemcode, "item_name"=>$itemname, "quantity"=>'1', "unit_price"=>$unit_price, "labour_price"=>$labour_amount, "estimated_amount"=>$estimated_amount);
		 
			 }
		
		
		 echo json_encode($estimate_table_data);
		
	}
	
	public function estimate_Complaints()
	{
		$complaints =    $this->input->post('complaints');
		$vehicle_category =   $this->input->post('vehicle_category');
		$vehicle_make =   $this->input->post('vehicle_make');
		$vehicle_model =    $this->input->post('vehicle_model');
		$customer_channel =    $this->input->post('customer_channel');
		
		$customer_city =    strtolower($this->input->post('customer_city'));
		$count =  $this->input->post('total');
		$output = '';
		$this->load->model('Main_model');
		 $modelcodes  = $this->db->query("SELECT * FROM vehicle_model WHERE model_id = '".$vehicle_model."'")->row();
		$modelcode =  $modelcodes->model_code;
		
		$complaintcolumns  = $this->db->query("SELECT * FROM complaints WHERE id = '".$complaints."'")->row();
		 
			$complaintoptions = array($complaintcolumns->option1, $complaintcolumns->option2, $complaintcolumns->option3, $complaintcolumns->option4, $complaintcolumns->option5, $complaintcolumns->option6);
		
		$options = 1;
		 foreach ($complaintoptions as $complaintoptionsval) {
     
 
		
		$complaint_options  = $complaintoptionsval;
		 
		if($complaint_options!='NA' && $complaint_options!='N' && !empty($complaint_options)){
			 
		$sparesid = $this->db->query("SELECT * FROM spares WHERE model_code='".$modelcode."' AND vehicle_category = '".$vehicle_category."' AND item_code = '".$complaint_options."'")->row();
				if(!empty($sparesid)){  
					$sparesrate_cost = $this->db->query("SELECT MAX(rate) AS rate FROM spares_rate WHERE spares_id='".$sparesid->spares_id."'")->row();
					$spares_labour_rate_cost = $this->db->query("SELECT  $customer_city AS rate, item_code, item_name, vehicle_category   FROM labour WHERE  vehicle_category = '".$vehicle_category."' AND item_code='".$sparesid->item_code."'")->row();
					
					
					
					$checkDiscount = $this->db->query("SELECT amount,type FROM discount WHERE service='Spares' AND criteria = '".$customer_channel."' AND active='active'")->row();
						if(!empty($checkDiscount->amount) && !empty($checkDiscount->type)){
							if($checkDiscount->type=='slab'){
							$sparesrate = $sparesrate_cost->rate-$checkDiscount->amount;	
							}elseif($checkDiscount->type=='flat'){
							$sparesrate = $checkDiscount->amount;	
							}elseif($checkDiscount->type=='percentage'){
							 $sparesrate = $sparesrate_cost->rate - ($sparesrate_cost->rate * ($checkDiscount->amount / 100));
							}else{ 
							$sparesrate = $sparesrate_cost->rate;
							}
						}else{ 
						$sparesrate = $sparesrate_cost->rate;
						}
					
					 
					
					if(empty($spares_labour_rate_cost)){
						$spares_labour_rate = 0;
					}else{
						$spares_labour_rate = $spares_labour_rate_cost->rate;
					}
					$s_itemcode = $sparesid->spares_id;
					$s_itemname = $sparesid->item_name;
				 }else{
					$sparesrate = 0;
					$spares_labour_rate = 0;
					$s_itemcode = '';
					$s_itemname = '';
				}
			
		$labourprice_cost = $this->db->query("SELECT  $customer_city AS rate, item_code, item_name, vehicle_category  FROM labour WHERE vehicle_category = '".$vehicle_category."' AND item_code = '".$complaint_options."'")->row();
				if(!empty($labourprice_cost)){ 	
					$labourprice = $labourprice_cost->rate;
					$l_itemcode = $labourprice_cost->item_code;
					$l_itemname = 'Labour - '.$labourprice_cost->item_name;
				}else{
					$labourprice = 0;
					$l_itemcode = '';
					$l_itemname = '';
				} 
			if(!empty($s_itemname)){
				$itemname = $s_itemname;
				$itemcode = $s_itemcode;
			}else{
				$itemname = $l_itemname;
				$itemcode = $l_itemcode;
			}
			$unit_price = $sparesrate;
			$labour_amount = $spares_labour_rate+$labourprice;
			$estimated_amount = $unit_price+$labour_amount;
			
			 if(!empty($itemname)){ 
		$estimate_table_data[] = array("options"=>"Option ".$options, "count"=>$count, "item_id"=>$itemcode, "item_name"=>$itemname, "quantity"=>'1', "unit_price"=>$unit_price, "labour_price"=>$labour_amount, "estimated_amount"=>$estimated_amount, "complaints"=>$complaintcolumns->complaints  );
		$options++;
			 }
		}
		
		
		  }
		
		
		
		 
		
		
		 
		 
		
		
			
             
		echo json_encode($estimate_table_data);
		
	}
	
	
	public function getSparesBrandPrice(){
		$brand =    $this->input->post('brand');
		 $item_id =    $this->input->post('item_id');
		 $customer_channel =    $this->input->post('customer_channel');
		$this->load->model('Main_model');
		 $sparesbrandRates  = $this->db->query("SELECT rate FROM spares_rate WHERE spares_id='".$item_id."' AND id='".$brand."'")->row();
		
		
		$checkDiscount = $this->db->query("SELECT amount,type FROM discount WHERE service='Spares' AND criteria = '".$customer_channel."' AND active='active'")->row();
						if(!empty($checkDiscount->amount) && !empty($checkDiscount->type)){
							if($checkDiscount->type=='slab'){
							$brandrate =  $sparesbrandRates->rate - $checkDiscount->amount;	
							}elseif($checkDiscount->type=='flat'){
							$brandrate = $checkDiscount->amount;	
							}elseif($checkDiscount->type=='percentage'){
							 $brandrate = $sparesbrandRates->rate - ($sparesbrandRates->rate * ($checkDiscount->amount / 100));
							}else{ 
							$brandrate = $sparesbrandRates->rate;
							}
						}else{ 
						$brandrate = $sparesbrandRates->rate;
						}
		
		
		//$brandrate =   $sparesbrandRates->rate;
		echo $brandrate;
	}
	
	
	
    // Get data for purchased
    public function get_data_for_claimsestimate()
    {
        $item_id = $this->input->post('id');
        $count = $this->input->post('total');
        $this->load->model('Main_model');

        $where = array('item_id' => $item_id);
        $data = $this->Main_model->get_purchased($item_id);

        if ($item_id != 0) {
           $output = '';
            $output .= '<tr id="entry_row_' . $count . '">';
            $output .= '<td id="serial_' . $count . '">' . $count . '</td>';
            $output .= '<td><input type="hidden" name="item_id[]" value="' . $data->item_id . '"> ' . $data->item_id . '</td>';
			$output .= '<input type="hidden" name="item_name[]" value="' . $data->item_name . ' - ' . $data->sub_product . ' - ' . $data->brand . '">';
            //$output .= '<input type="hidden" name="category_id[]" value="' . $data->category_id . '">';
            $output .= '<td>' . $data->item_name . ' - ' . $data->sub_product . '<br>' . $data->brand . '</td>';
            $output .= '<td><div id="spinner4">

     <input type="text" name="quantity[]" tabindex="1" id="quantity_' . $count . '" onclick="calculate_single_entry_sum(' . $count . ')" size="2" value="1" class="form-control col-lg-2" onkeyup="calculate_single_entry_sum(' . $count . ')">

                                </div>
                            </div></td>';
            $output .= '<td><input type="text" name="unit_price[]"  required onkeyup="calculate_single_entry_sum(' . $count . ')"  id="unit_price_' . $count . '" size="6" value=""></td>';
			
			 $output .= '<td><input type="text" name="labour_price[]"  required onkeyup="calculate_single_entry_sum(' . $count . ')"  id="labour_price_' . $count . '" size="6" value=""></td>';
			//$output  .= '<td><input type="text" required name="mrp[]" id="mrp_' . $count . '" size="6" value=""></td>';
			
			
            $output .= '<td>
        <input type="text" name="estimated_amount[]" required  readonly="readonly" id="single_entry_total_' . $count . '" size="6" value="">
        </td>';
            $output .= '<td>
<i style="cursor: pointer;" id="delete_button_' . $count . '" onclick="delete_row(' . $count . ')" class="fa fa-trash"></i>
				</td>';
            $output .= '</tr>';

            echo $output;
        } else {
            echo $output = 0;
        }

    }
	
	
	
	// Save Estimate
    public function claims_estimate_form()
    {
        $custid = $this->input->post('claims_id'); 
		$item_id = $this->input->post('item_id');
		$item_name = $this->input->post('item_name');
       // $category_id = $this->input->post('category_id');
        $itemID = $this->input->post('unit_price');
        $unit_price = $this->input->post('unit_price');
		$labour_price = $this->input->post('labour_price');
        $quantity = $this->input->post('quantity');
		$estimate_no = $this->input->post('estimate_no');
		 $estimated_amount = $this->input->post('estimated_amount');
		$estimated_date = date('Y-m-d', strtotime($this->input->post('estimate_date'))); 
        $remark = $this->input->post('remark'); 				 
		$complaint_number = $this->input->post('complaint_number');
		$estimate_complaint	 = $this->input->post('estimate_complaint');
		
					 $total_spares = 0;
					 $total_labour = 0;
		
		 for ($i = 0; $i < count($itemID); $i++) {
            extract($_POST);

            if (strlen($unit_price[$i]) > 0) {
			$estimated_items = array(
					
					
                'claims_id' => $custid, 
				'complaint_number' => $complaint_number[$i],
				'complaints' => $estimate_complaint[$i],	
                'item_id' => $item_id[$i],
				'item' => $item_name[$i],
               // 'purchase_rate' => $unit_price[$i],
                'qty' => $quantity[$i],
                'amount' => $estimated_amount[$i],
				'rate' => $unit_price[$i],
				'labour_rate' => $labour_price[$i],
            );

				$total_spares += $unit_price[$i];
		 		$total_labour += $labour_price[$i];	
				
            $data_entry = $this->Main_model->add_record('claims_estimate_details', $estimated_items);
			}
		 }
		
		$cust_info = array(
			'claim_id' => $custid,
            'estimate_no' => $estimate_no,
			'estimate_date' => $estimated_date,
			'estimate_total' => $this->input->post('totalamount'), 
			'total_spares' => $total_spares,
			'total_labour' => $total_labour,
			'remark' => $remark,
			'created_on' => date('Y-m-d'),
        );
				  	 	 	 


        $where = array('id' => $custid);
        $this->load->model('Main_model');
        $this->Main_model->add_record('claim_estimate', $cust_info);
		$this->update_claim_status($custid, '4', 'Estimate Approval Awaited');
		$this->update_claim_details($custid, 'estimate_date', $estimated_date);
        //$this->Main_model->update_record('stock', $cat_data, $where);
        $this->session->set_flashdata('info', 'claims Updated Successfully..!');
		
		$this->update_claim_details($custid, 'estimate_total', $this->input->post('totalamount'));
		
		
		////////////////////////////////////////////////////////////////////////////////////// CUSTOMER SMS ////////////////////////////////////////////////
		   				//GET CLAIM DATA
						$where = array('id' => $custid);
						$getclaimdata =$this->Main_model->single_row('claims', $where, 's');
						//GET MAKE
						$where = array('make_id' => $getclaimdata['make']);
						$getmake =$this->Main_model->single_row('vehicle_make', $where, 's');
						//GET MODEL
						$where = array('model_id' => $getclaimdata['model']);
						$getmodel =$this->Main_model->single_row('vehicle_model', $where, 's');
			 
			 	$sms_msg = 'Hi '.$getclaimdata['name'].', Estimate for your claim '.$getclaimdata['claim_no'].' has been submitted to the Insurance Co. Our team will contact you once assessment has been received - GarageWorks';
				 
			  	$smsresponse = $this->send_booking_sms($getclaimdata['mobile'], $sms_msg);
				 
		
    	////////////////////////////////////////////////////////////////////////////////////// CUSTOMER SMS ////////////////////////////////////////////////
		
		
        redirect(base_url() . 'index.php/claims/claims_details/'.$custid);
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////// CLAIMS EDIT
// claims Estimate Form
    public function claims_estimate_edit()
    {
        $id = $this->uri->segment(3);
        $where = array('id' => $id);
		
		$where2 = array('claim_id' => $id);
		
		$data['estimate'] = $this->Main_model->single_row('claim_estimate', $where2, 's');
		
		
        $sql = $this->db->query("select * from claims_estimate_details WHERE claims_id =".$id);
        $data['estimate_det'] = $sql->result();
		
		 $claimdet = $this->db->query("SELECT * FROM claims WHERE id =".$id)->row();
        
		
		
		if(!empty($claimdet)){ 
			
			$getvehicledet  = $this->db->query("SELECT model_code, vehicle_category FROM vehicle_model WHERE make_id='".$claimdet->make."' AND model_id = '".$claimdet->model."'");
			$vehdet = $getvehicledet->row();
			
			$citynameq = $this->db->query("SELECT cityname FROM city WHERE city_id =".$claimdet->city)->row();
			$cityname = $citynameq->cityname;
			
			$data['model_code']=$vehdet->model_code;
			$data['vehicle_category']=$vehdet->vehicle_category;
			
			$data['customer_channel']='Insurance'; 
			 
			 $data['customer_city'] = $cityname;
			
			
			$sparestable = $this->db->query("SELECT * FROM spares WHERE model_code='".$data['model_code']."' AND vehicle_category = '".$data['vehicle_category']."'");
			$spareslists = $sparestable->result();
			
			
			$labourtable = $this->db->query("SELECT * FROM labour WHERE vehicle_category = '".$data['vehicle_category']."'");
			$labourlists = $labourtable->result();
			 
			$data['spares_list']  =	$spareslists;
			$data['labour_list']  =	$labourlists;   
		}
		
		$data['products'] = $this->db->query("SELECT * FROM  item AS i")->result();
        $this->header();
        $data['surveyDetail'] = $this->Main_model->single_row('claims', $where, 's');
		
        $this->load->view('claims/claims_estimate_edit', $data);
		
        $this->footer();
    }
	
	
	
	
	
	
    // Get data for purchased
    public function get_data_for_claimsestimate_edit()
    {
        $item_id = $this->input->post('id');
        $count = $this->input->post('total');
        $this->load->model('Main_model');

        $where = array('item_id' => $item_id);
        $data = $this->Main_model->get_purchased($item_id);

        if ($item_id != 0) {
           $output = '';
            $output .= '<tr id="entry_row_' . $count . '">';
            $output .= '<td id="serial_' . $count . '">' . $count . '</td>';
            $output .= '<td><input type="hidden" name="item_id[]" value="' . $data->item_id . '"> ' . $data->item_id . '</td>';
			$output .= '<input type="hidden" name="item_name[]" value="' . $data->item_name . ' - ' . $data->sub_product . ' - ' . $data->brand . '">';
            //$output .= '<input type="hidden" name="category_id[]" value="' . $data->category_id . '">';
            $output .= '<td>' . $data->item_name . ' - ' . $data->sub_product . '<br>' . $data->brand . '</td>';
            $output .= '<td><div id="spinner4">

     <input type="text" name="quantity[]" tabindex="1" id="quantity_' . $count . '" onclick="calculate_single_entry_sum(' . $count . ')" size="2" value="1" class="form-control col-lg-2" onkeyup="calculate_single_entry_sum(' . $count . ')">

                                </div>
                            </div></td>';
            $output .= '<td><input type="text" name="unit_price[]"  required onkeyup="calculate_single_entry_sum(' . $count . ')"  id="unit_price_' . $count . '" size="6" value=""></td>';
			
			 $output .= '<td><input type="text" name="labour_price[]"  required onkeyup="calculate_single_entry_sum(' . $count . ')"  id="labour_price_' . $count . '" size="6" value=""></td>';
			//$output  .= '<td><input type="text" required name="mrp[]" id="mrp_' . $count . '" size="6" value=""></td>';
			
			
            $output .= '<td>
        <input type="text" name="estimated_amount[]" required  readonly="readonly" id="single_entry_total_' . $count . '" size="6" value="">
        </td>';
            $output .= '<td>
<i style="cursor: pointer;" id="delete_button_' . $count . '" onclick="delete_row(' . $count . ')" class="fa fa-trash"></i>
				</td>';
            $output .= '</tr>';

            echo $output;
        } else {
            echo $output = 0;
        }

    }
	
	
	
	// Save Estimate
    public function claims_estimate_edit_form()
    {
        $custid = $this->input->post('claims_id'); 
		$item_id = $this->input->post('item_id');
		$item_name = $this->input->post('item_name');
       // $category_id = $this->input->post('category_id');
        $itemID = $this->input->post('unit_price');
        $unit_price = $this->input->post('unit_price');
		$labour_price = $this->input->post('labour_price');
        $quantity = $this->input->post('quantity');
		$estimate_no = $this->input->post('estimate_no');
		 $estimated_amount = $this->input->post('estimated_amount');
		$estimated_date =  date('Y-m-d', strtotime($this->input->post('estimate_date')));
		$remark = $this->input->post('remark'); 			
		$complaint_number = $this->input->post('complaint_number');
		$estimate_complaint	 = $this->input->post('estimate_complaint');
		$Estimate_ID = $this->input->post('jobdet_ID');
 		//$deletethisprocurentry = $this->Main_model->delete_record('claims_estimate_details', 'claims_id', $custid);
					 $total_spares = 0;
					 $total_labour = 0;
		
		 for ($i = 0; $i < count($itemID); $i++) {
            extract($_POST);
			 	
            if (strlen($unit_price[$i]) > 0) {
				
				if(!empty($Estimate_ID[$i])){ 
				$approvedItem = $this->db->query("select * from claims_estimate_details where id=".$Estimate_ID[$i])->row();
				}else{
					$approvedItem->id = '';
				}
				
				
			$estimated_items = array(
                'claims_id' => $custid,
				'complaint_number' => $complaint_number[$i],
				'complaints' => $estimate_complaint[$i],
                'item_id' => $item_id[$i],
				'item' => $item_name[$i],
               // 'purchase_rate' => $unit_price[$i],
                'qty' => $quantity[$i],
                'amount' => $estimated_amount[$i],
				'rate' => $unit_price[$i],
				'labour_rate' => $labour_price[$i],
            );

				$total_spares += $unit_price[$i];
		 		$total_labour += $labour_price[$i];	
				
				if(!empty($approvedItem->id) && !empty($Estimate_ID[$i])){ 
			$where4 = array('id' => $Estimate_ID[$i]);
			$this->Main_model->update_record('claims_estimate_details', $estimated_items, $where4);
				}else{ 
            $data_entry = $this->Main_model->add_record('claims_estimate_details', $estimated_items);
				}
			
			}
		 }
		
		 
		
		$cust_info = array(
			'claim_id' => $custid,
            'estimate_no' => $estimate_no,
			'estimate_date' => $estimated_date,
			'estimate_total' => $this->input->post('totalamount'), 
			'total_spares' => $total_spares,
			'remark' => $remark,
			'total_labour' => $total_labour,
			);
				
		
        $where = array('id' => $custid);
        $this->load->model('Main_model');
        $this->Main_model->update_record('claim_estimate', $cust_info, $where);
		
		$this->update_claim_details($custid, 'estimate_total', $this->input->post('estimate_total'));
		
        //$this->Main_model->update_record('stock', $cat_data, $where);
        $this->session->set_flashdata('info', 'claims Updated Successfully..!');

		
		////////////////////////////////////////////////////////////////////////////////////// CUSTOMER SMS ////////////////////////////////////////////////
		   				
						//GET CLAIM DATA
						$where = array('id' => $custid);
						$getclaimdata =$this->Main_model->single_row('claims', $where, 's');
						
						//GET MAKE
						$where = array('make_id' => $getclaimdata['make']);
						$getmake =$this->Main_model->single_row('vehicle_make', $where, 's');
						//GET MODEL
						$where = array('model_id' => $getclaimdata['model']);
						$getmodel =$this->Main_model->single_row('vehicle_model', $where, 's');
			 				
						$where2 = array('claim_id' => $custid);
						$claimstatusget =$this->Main_model->single_row('claim_status', $where2, 's');
		
					 if($claimstatusget['stage'] < 5){ 
						
			 	$sms_msg = 'Hi '.$getclaimdata['name'].', Estimate for your claim '.$getclaimdata['claim_no'].' has been submitted to the Insurance Co. Our team will contact you once assessment has been received - GarageWorks';
				 
			  	$smsresponse = $this->send_booking_sms($getclaimdata['mobile'], $sms_msg);
					 
					 }
		
    	////////////////////////////////////////////////////////////////////////////////////// CUSTOMER SMS ////////////////////////////////////////////////
		 
        redirect(base_url() . 'index.php/claims/claims_details/'.$custid);
    }
	

//////////////////////////////////////////////////////////////////////////////////////////////////////////// CLAIMS EDIT END
	
	
	
	
	
	
	
	
	
	
	
	
	
	// Show Insurer Invoice details
    public function claim_estimate_print()
    {
        $id = $this->uri->segment(3);
        $this->header($title = "Claim Estimate");
        $where = array('id' => $id);
        $where2 = array('claim_id' => $id);
		
		$data['estimateDet']   = $this->Main_model->single_row('claim_estimate', $where2, 's');
		$data['surveryDet']   = $this->Main_model->single_row('claim_survey_details', $where2, 's');
		
		 $claimdet = $this->db->query("SELECT * FROM claims WHERE id =".$id)->row();
        
		
		
		if(!empty($claimdet)){ 
			
			$getvehicledet  = $this->db->query("SELECT model_code, vehicle_category FROM vehicle_model WHERE make_id='".$claimdet->make."' AND model_id = '".$claimdet->model."'");
			$vehdet = $getvehicledet->row();
			
			$citynameq = $this->db->query("SELECT cityname FROM city WHERE city_id =".$claimdet->city)->row();
			$cityname = $citynameq->cityname;
			
			$data['model_code']=$vehdet->model_code;
			$data['vehicle_category']=$vehdet->vehicle_category;
			
			$data['customer_channel']='Insurance'; 
			 
			 $data['customer_city'] = $cityname;
			
			
			$sparestable = $this->db->query("SELECT * FROM spares WHERE model_code='".$data['model_code']."' AND vehicle_category = '".$data['vehicle_category']."'");
			$spareslists = $sparestable->result();
			
			
			$labourtable = $this->db->query("SELECT * FROM labour WHERE vehicle_category = '".$data['vehicle_category']."'");
			$labourlists = $labourtable->result();
			 
			$data['spares_list']  =	$spareslists;
			$data['labour_list']  =	$labourlists;   
		}
		
		
        $sql = $this->db->query("select * from claims_estimate_details where claims_id=$id");
        $data['estimate'] = $sql->result();
		$data['surveyDetail'] = $this->Main_model->single_row('claims', $where, 's');
        $this->load->view('claims/claim_estimate_print', $data);
        $this->footer();
    }
	
	
	
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////// CLAIMS Approved Estimate
// claims Approved Estimate Form
    public function claims_estimate_approved()
    {
        $id = $this->uri->segment(3);
        $where = array('id' => $id);
		
		$where2 = array('claim_id' => $id);
		
		$data['estimate'] = $this->Main_model->single_row('claim_estimate', $where2, 's');
		
		 $claimdet = $this->db->query("SELECT * FROM claims WHERE id =".$id)->row();
        
		
		
		if(!empty($claimdet)){ 
			
			$getvehicledet  = $this->db->query("SELECT model_code, vehicle_category FROM vehicle_model WHERE make_id='".$claimdet->make."' AND model_id = '".$claimdet->model."'");
			$vehdet = $getvehicledet->row();
			
			$citynameq = $this->db->query("SELECT cityname FROM city WHERE city_id =".$claimdet->city)->row();
			$cityname = $citynameq->cityname;
			
			$data['model_code']=$vehdet->model_code;
			$data['vehicle_category']=$vehdet->vehicle_category;
			
			$data['customer_channel']='Insurance'; 
			 
			 $data['customer_city'] = $cityname;
			
			
			$sparestable = $this->db->query("SELECT * FROM spares WHERE model_code='".$data['model_code']."' AND vehicle_category = '".$data['vehicle_category']."'");
			$spareslists = $sparestable->result();
			
			
			$labourtable = $this->db->query("SELECT * FROM labour WHERE vehicle_category = '".$data['vehicle_category']."'");
			$labourlists = $labourtable->result();
			 
			$data['spares_list']  =	$spareslists;
			$data['labour_list']  =	$labourlists;   
		}
		
        $sql = $this->db->query("select * from claims_estimate_details WHERE claims_id =".$id);
        $data['estimate_det'] = $sql->result();
		
		$data['products'] = $this->db->query("SELECT * FROM  item AS i")->result();
        $this->header();
        $data['surveyDetail'] = $this->Main_model->single_row('claims', $where, 's');
        $this->load->view('claims/claims_estimate_approved', $data);
        $this->footer();
    }
	
	
	
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////// Save CLAIMS GIC APPROVAL
    public function claims_estimate_approved_form()
    {
        $custid = $this->input->post('claims_id'); 
 
		
		
		$survey_code = $custid;

		$item_id = $this->input->post('item_id');
		$item_name = $this->input->post('item_name');
       // $category_id = $this->input->post('category_id');
        $itemID = $this->input->post('unit_price');
        
		$estimate_id = $this->input->post('estimate_id');
		
		$actual_unit_price = $this->input->post('actual_unit_price');
		$unit_price = $this->input->post('unit_price');
		$actual_labour_price = $this->input->post('actual_labour_price');
		$labour_price = $this->input->post('labour_price');
        $actual_estimated_amount = $this->input->post('actual_estimated_amount');
		$estimated_amount = $this->input->post('estimated_amount');
		$customer_liability = $this->input->post('customer_liability');
		$approval_status = $this->input->post('approval_status');
		
		$quantity = $this->input->post('quantity');
		$estimate_no = $this->input->post('estimate_no');
		$complaint_number = $this->input->post('complaint_number');
		$estimate_complaint	 = $this->input->post('estimate_complaint');
			
		$approval_date =  date('Y-m-d', strtotime($this->input->post('approval_date')));
		
		$totalcustomerliability = $this->input->post('totalcustomerliability');
			
		$totalamount = $this->input->post('totalamount');
		
					 $actual_total_spares = 0;
					 $actual_total_labour = 0;
					 $total_spares = 0;
					 $total_labour = 0;
		
		 for ($i = 0; $i < count($itemID); $i++) {
            //extract($_POST);

            if (strlen($unit_price[$i]) > 0) {
				
				if(!empty($estimate_id[$i])){
					$estimate_id_this = $estimate_id[$i];
				}else{
					$estimate_id_this = 0;
				}
				
			$estimated_items = array(
                'claims_id' => $custid,
				'estimate_id' => $estimate_id_this,
				'complaint_number' => $complaint_number[$i],
				'complaints' => $estimate_complaint[$i],
                'item_id' => $item_id[$i],
				'item' => $item_name[$i],
               // 'purchase_rate' => $unit_price[$i],
                'qty' => $quantity[$i],
                'amount' => $estimated_amount[$i],
				'rate' => $unit_price[$i],
				'labour_rate' => $labour_price[$i],
			    'actual_amount' => $actual_estimated_amount[$i],
				'actual_rate' => $actual_unit_price[$i],
				'actual_labour_rate' => $actual_labour_price[$i],
				 'customer_liability' => $customer_liability[$i],
			 	'approval_status' => $approval_status[$i],
            );

				$total_spares += $unit_price[$i];
		 		$total_labour += $labour_price[$i];	
			 	
			 	$actual_total_spares += $actual_unit_price[$i];
		 		$actual_total_labour += $actual_labour_price[$i];	
				
            $data_entry = $this->Main_model->add_record('claims_estimate_approved_details', $estimated_items);
			}
		 }
		
		 
		
		$cust_info = array(
			'claim_id' => $custid,
            'estimate_no' => $estimate_no,
			'approval_date' => $approval_date,
			'approved_total' => $totalamount, 
			'customer_liability' => $totalcustomerliability, 
			'approved_spares' => $total_spares,
			'approved_labour' => $total_labour,
			'created_on' => date('Y-m-d'),
			);
				
		
        $where = array('claim_id' => $custid);
        $this->load->model('Main_model');
        $this->Main_model->add_record('claim_estimate_approved', $cust_info);
									    
		 
		
			 
			 $uploaddir = "uploads/images/";
		// Configure upload directory and allowed file types 
    	$upload_dir = "uploads/images/";
    	$allowed_types = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx', 'xls', 'xlsx'); 
      
    	// Define maxsize for files i.e 2MB 
    	$maxsize = 60 * 1024 * 1024;  
		$uploaded_on = date('Y-m-d');
		
		
		
		 // Checks if user sent an empty form  
     
			if ($_FILES['approval_assesment']['name'] != '') {
  
         
		
		
			$file_tmpname = $_FILES['approval_assesment']['tmp_name']; 
            $file_name = $_FILES['approval_assesment']['name']; 
            $file_size = $_FILES['approval_assesment']['size']; 
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION); 
		
		   
			
				$temp = explode(".", $file_name);
				$newfilename = 'APPROVAL_'.$survey_code. '_' . $temp[0] . '.' . end($temp);
 			  	$data_upload = $uploaddir . basename($newfilename);
                $imageFileType = strtolower(pathinfo($data_upload,PATHINFO_EXTENSION));
            
			  
			  
			  
			  
							if(!in_array(strtolower($file_ext), $allowed_types)) { 
								$this->session->set_flashdata('msg', '<div class="alert alert-warning alert-dismissable">
								<button type="button" class="close" data-dismiss="alert"
									aria-hidden="true">
											&times;
												</button>
															<span>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</span>
																	</div>');
                 
                		$uploadOk = 0;
                		redirect(base_url().'index.php//claims/claims_details/'.$custid);

            				}
			  				if ($file_size > $maxsize){           
												 $this->session->set_flashdata('msg', '<div class="alert alert-warning alert-dismissable">
												<button type="button" class="close" data-dismiss="alert"
								  aria-hidden="true">
								  &times;
							   </button>
							   <span>Error: File size is larger than the allowed limit..</span>
							</div>');
						redirect(base_url().'index.php/claims/claims_details/'.$custid);	   
						 	}
			if (move_uploaded_file($file_tmpname, $data_upload)) {

                $picture = $data_upload;
				 

            } 

			else {
										$this->session->set_flashdata('msg', '<div class="alert alert-warning alert-dismissable">
						   <button type="button" class="close" data-dismiss="alert"
							  aria-hidden="true">
							  &times;
						   </button>
						   <span>Error:  '.$file_name.' could not be uploaded..</span>
						</div>');
									redirect(base_url().'index.php/claims/claims_details/'.$custid);	 


            }
			  
        	 
		  } 
		
		
		
		
		
		
		
		
		
		
		
		
		if(empty($newfilename)){$newfilename="";}
		
		if(empty($picture)){$picture="";}
		
		
		 
			 
			 
		
        //$approval_date = date('Y-m-d', strtotime($_POST['approval_date']));
		$cust_info = array(
			'claim_id' => $custid,
            'approved_status' => 'Approved',
			'approved_amount' => $totalamount,
			'customer_liability' => $totalcustomerliability, 
			'approved_spares' => $total_spares,
			'approved_labour' => $total_labour,
			'approval_date' => $approval_date,
			'approval_assesment' => $newfilename,
			'approval_assesment_url' => $picture,
			'created_on' => date('Y-m-d')
        );  	

        $where = array('id' => $custid);
        $this->load->model('Main_model');
        $this->Main_model->add_record('claim_gic_approval', $cust_info);
        $this->update_claim_status($custid, '5', 'Customer Approval Awaited');
			 
		$this->update_claim_details($custid, 'approved_total', $this->input->post('approved_total'));	 
			 
        //$this->Main_model->update_record('stock', $cat_data, $where);
        $this->session->set_flashdata('info', 'claims Updated Successfully..!');

        redirect(base_url() . 'index.php/claims/claims_details/'.$custid);
    }
	

//////////////////////////////////////////////////////////////////////////////////////////////////////////// CLAIMS GIC APPROVAL END
	
	
	
	// Assign claims
    public function claims_approval()
    {
        $custid = $this->input->post('cid'); 
		
		
		$survey_code = $custid;
		
		
		
		
		
		
		
		
		$uploaddir = "uploads/images/";
		// Configure upload directory and allowed file types 
    	$upload_dir = "uploads/images/";
    	$allowed_types = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx', 'xls', 'xlsx'); 
      
    	// Define maxsize for files i.e 2MB 
    	$maxsize = 60 * 1024 * 1024;  
		$uploaded_on = date('Y-m-d');
		
		
		
		 // Checks if user sent an empty form  
     
			if ($_FILES['approval_assesment']['name'] != '') {
  
         
		
		
			$file_tmpname = $_FILES['approval_assesment']['tmp_name']; 
            $file_name = $_FILES['approval_assesment']['name']; 
            $file_size = $_FILES['approval_assesment']['size']; 
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION); 
		
		   
			
				$temp = explode(".", $file_name);
				$newfilename = 'APPROVAL_'.$survey_code. '_' . $temp[0] . '.' . end($temp);
 			  	$data_upload = $uploaddir . basename($newfilename);
                $imageFileType = strtolower(pathinfo($data_upload,PATHINFO_EXTENSION));
            
			  
			  
			  
			  
							if(!in_array(strtolower($file_ext), $allowed_types)) { 
								$this->session->set_flashdata('msg', '<div class="alert alert-warning alert-dismissable">
								<button type="button" class="close" data-dismiss="alert"
									aria-hidden="true">
											&times;
												</button>
															<span>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</span>
																	</div>');
                 
                		$uploadOk = 0;
                		redirect(base_url().'index.php//claims/claims_details/'.$custid);

            				}
			  				if ($file_size > $maxsize){           
												 $this->session->set_flashdata('msg', '<div class="alert alert-warning alert-dismissable">
												<button type="button" class="close" data-dismiss="alert"
								  aria-hidden="true">
								  &times;
							   </button>
							   <span>Error: File size is larger than the allowed limit..</span>
							</div>');
						redirect(base_url().'index.php/claims/claims_details/'.$custid);	   
						 	}
			if (move_uploaded_file($file_tmpname, $data_upload)) {

                $picture = $data_upload;
				 

            } 

			else {
										$this->session->set_flashdata('msg', '<div class="alert alert-warning alert-dismissable">
						   <button type="button" class="close" data-dismiss="alert"
							  aria-hidden="true">
							  &times;
						   </button>
						   <span>Error:  '.$file_name.' could not be uploaded..</span>
						</div>');
									redirect(base_url().'index.php/claims/claims_details/'.$custid);	 


            }
			  
        	 
		  } 
		
		
		
		
		
		
		
		
		
		
		
		
		if(empty($newfilename)){$newfilename="";}
		
		if(empty($picture)){$picture="";}
		
		
		
		
        $approval_date = date('Y-m-d', strtotime($_POST['approval_date']));
		$cust_info = array(
			'claim_id' => $custid,
            'approved_status' => $this->input->post('approval_status'),
			'approved_amount' =>$this->input->post('approved_amount'),
			'approval_date' => $approval_date,
			'approval_assesment' => $newfilename,
			'approval_assesment_url' => $picture,
			'created_on' => date('Y-m-d')
        );  	

        $where = array('id' => $custid);
        $this->load->model('Main_model');
        $this->Main_model->add_record('claim_gic_approval', $cust_info);
        $this->update_claim_status($custid, '5', 'Customer Approval Awaited');
		
        //$this->Main_model->update_record('stock', $cat_data, $where);
        $this->session->set_flashdata('info', 'claims Updated Successfully..!');

        redirect(base_url() . 'index.php/claims/claims_details/'.$custid);
    }
	
	
	
	
	// Assign claims
    public function claim_customer_approval()
    {
        $custid = $this->input->post('cid'); 
		
		
		$survey_code = $custid;
		 
		
		 
		
		if(isset($_POST['pickup_date'])){ 
        $pickup_date = date('Y-m-d', strtotime($_POST['pickup_date']));
		
		 $pickup_date_indian = date('d-m-Y', strtotime($_POST['pickup_date']));	
		}else{
		$pickup_date = '';	
		 $pickup_date_indian = ' ';		
		}
		$approval_date = date('Y-m-d', strtotime($_POST['approval_date']));
		
		$cust_info = array(
            'claim_id' => $custid,
			'approved_status' => $this->input->post('approved_status'), 
			'approval_date' => $approval_date,
			'repair_type' => $this->input->post('repair_type'), 
			'pickup_date' =>  $pickup_date,
			'pickup_time' => $this->input->post('pickup_time'),
			'service_provider' => $this->input->post('service_provider'),
			'created_on' => date('Y-m-d')
        );  	
			  

        $where = array('id' => $custid);
        $this->load->model('Main_model');
        $this->Main_model->add_record('claim_customer_approval', $cust_info);
        $this->update_claim_status($custid, '6', 'Customer Approval Received');
		$this->update_claim_details($custid, 'service_provider', $this->input->post('service_provider'));
		$this->update_claim_details($custid, 'repair_type', $this->input->post('repair_type'));
        //$this->Main_model->update_record('stock', $cat_data, $where);
        $this->session->set_flashdata('info', 'claims Updated Successfully..!');
		
		 if(!empty($this->input->post('repair_type')) && $this->input->post('repair_type')=='Pickup'){
		 
			
			 $where = array('id' => $this->input->post('service_provider'));
						$getgarages =$this->Main_model->single_row('garages', $where, 's');
			 
		////////////////////////////////////////////////////////////////////////////////////// CUSTOMER SMS ////////////////////////////////////////////////
		   				//GET CLAIM DATA
						$where = array('id' => $custid);
						$getclaimdata =$this->Main_model->single_row('claims', $where, 's');
						//GET MAKE
						$where = array('make_id' => $getclaimdata['make']);
						$getmake =$this->Main_model->single_row('vehicle_make', $where, 's');
						//GET MODEL
						$where = array('model_id' => $getclaimdata['model']);
						$getmodel =$this->Main_model->single_row('vehicle_model', $where, 's');
			 
			 	$sms_msg = 'Vehicle pick-up scheduled for $pickup_date_indian, '.$this->input->post('pickup_time').'. Customer Details: '.$getclaimdata['name'].', '.$getclaimdata['mobile'].', '.$getclaimdata['v_address'].', '.$getclaimdata['google_map'];
				  
			  	$smsresponse = $this->send_booking_sms($getgarages['mobile'], $sms_msg);
				 
		
			 
    	////////////////////////////////////////////////////////////////////////////////////// CUSTOMER SMS ////////////////////////////////////////////////
		 }
        redirect(base_url() . 'index.php/claims/claims_details/'.$custid);
    }
	
	
	
	
	public function getServiceProviders(){
		$repair_type =     $this->input->post('repair_type');
		$this->load->model('Main_model');
		if($repair_type=='Doorstep'){
		$records  = $this->db->query("SELECT * FROM mechanic");	
		$responses = $records->result();
		foreach ($responses as $response){ 
		$data[] = array("id"=>$response->mechanic_id, "text"=>$response->name);
		}	
		}elseif($repair_type=='Pickup'){
		$records  = $this->db->query("SELECT * FROM garages");	
			$responses = $records->result();
		foreach ($responses as $response){ 
		$data[] = array("id"=>$response->id, "text"=>$response->name);
		}
		}
		 
		 echo json_encode($data);
	}
	
	
	public function spares_ordered(){
	
		$custid = $this->uri->segment(3);
		
		$survey_code = $custid;
		 
        $this->update_claim_status($custid, '6', 'Spares Procurement Awaited');
		redirect(base_url() . 'index.php/claims/claims_details/'.$custid);
		
	}
	
	
	
	// Repair Start Form
    public function create_repairstart_form()
    {
        $custid = $this->input->post('cid'); 
        $repair_startdate = date('Y-m-d', strtotime($_POST['repair_startdate']));
		$repair_enddate = date('Y-m-d', strtotime($_POST['repair_enddate']));
		$cust_info = array( 
			'claim_id' => $custid,
			'repair_startdate' => $repair_startdate,
			'repair_enddate' => $repair_enddate,
			'created_on' => date('Y-m-d')
        );
        $where = array('id' => $custid);
        $this->load->model('Main_model');
        $this->Main_model->add_record('claim_repair', $cust_info);
        $this->update_claim_status($custid, '7', 'Repair In Progress');
        //$this->Main_model->update_record('stock', $cat_data, $where);
        $this->session->set_flashdata('info', 'Claim Updated Successfully..!');
		$this->update_claim_details($custid, 'repair_startdate', $repair_startdate);
		
		
		////////////////////////////////////////////////////////////////////////////////////// CUSTOMER SMS ////////////////////////////////////////////////
		   				//GET CLAIM DATA
						$where = array('id' => $custid);
						$getclaimdata =$this->Main_model->single_row('claims', $where, 's');
						//GET MAKE
						$where = array('make_id' => $getclaimdata['make']);
						$getmake =$this->Main_model->single_row('vehicle_make', $where, 's');
						//GET MODEL
						$where = array('model_id' => $getclaimdata['model']);
						$getmodel =$this->Main_model->single_row('vehicle_model', $where, 's');
			 
			 	$sms_msg = 'Hi '.$getclaimdata['name'].', Repair has started on your '.$getmake['make_name'].' '.$getmodel['model_name'].'. Tentative completion date is '.$repair_enddate.'. Timelines are subject to availability of spares - GarageWorks';
				 
			  	$smsresponse = $this->send_booking_sms($getclaimdata['mobile'], $sms_msg);
				 
		
			 
    	////////////////////////////////////////////////////////////////////////////////////// CUSTOMER SMS ////////////////////////////////////////////////
		  redirect(base_url() . 'index.php/claims/claims_details/'.$custid);
    }
	
	
	
	
	
	
	
	
	
	
	// Create invoice upload form
    public function claims_invoice_upload()
    {
        $custid = $this->input->post('cid'); 
		
		
		$survey_code = $custid;
		
		 
		 
		$checkinvoice  = $this->db->query("SELECT COUNT(id) AS invoiceexists FROM claim_invoice WHERE invoice_no='".$this->input->post('invoice_no')."'")->row();	
			 
		if(!empty($checkinvoice->invoiceexists) && $checkinvoice->invoiceexists>0){
			
		$this->session->set_flashdata('warning', 'Invoice no already exist in the system!');
		
         redirect(base_url() . 'index.php/claims/claims_details/'.$custid);
			
		}
		
		
		$uploaddir = "uploads/images/";
		// Configure upload directory and allowed file types 
    	$upload_dir = "uploads/images/";
    	$allowed_types = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx', 'xls', 'xlsx'); 
      
    	// Define maxsize for files i.e 2MB 
    	$maxsize = 60 * 1024 * 1024;  
		$uploaded_on = date('Y-m-d');
		
		
		
		 // Checks if user sent an empty form  
     
			if ($_FILES['invoice_upload']['name'] != '') {
  
         
		
		
			$file_tmpname = $_FILES['invoice_upload']['tmp_name']; 
            $file_name = $_FILES['invoice_upload']['name']; 
            $file_size = $_FILES['invoice_upload']['size']; 
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION); 
		
		   
			
				$temp = explode(".", $file_name);
				$newfilename = 'INV_'.$survey_code. '_' . $temp[0] . '.' . end($temp);
 			  	$data_upload = $uploaddir . basename($newfilename);
                $imageFileType = strtolower(pathinfo($data_upload,PATHINFO_EXTENSION));
            
			  
			  
			  
			  
							if(!in_array(strtolower($file_ext), $allowed_types)) { 
								$this->session->set_flashdata('msg', '<div class="alert alert-warning alert-dismissable">
								<button type="button" class="close" data-dismiss="alert"
									aria-hidden="true">
											&times;
												</button>
															<span>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</span>
																	</div>');
                 
                		$uploadOk = 0;
                		redirect(base_url().'index.php//claims/claims_details/'.$custid);

            				}
			  				if ($file_size > $maxsize){           
												 $this->session->set_flashdata('msg', '<div class="alert alert-warning alert-dismissable">
												<button type="button" class="close" data-dismiss="alert"
								  aria-hidden="true">
								  &times;
							   </button>
							   <span>Error: File size is larger than the allowed limit..</span>
							</div>');
						redirect(base_url().'index.php/claims/claims_details/'.$custid);	   
						 	}
			if (move_uploaded_file($file_tmpname, $data_upload)) {

                $picture = $data_upload;
				 

            } 

			else {
										$this->session->set_flashdata('msg', '<div class="alert alert-warning alert-dismissable">
						   <button type="button" class="close" data-dismiss="alert"
							  aria-hidden="true">
							  &times;
						   </button>
						   <span>Error:  '.$file_name.' could not be uploaded..</span>
						</div>');
									redirect(base_url().'index.php/claims/claims_details/'.$custid);	 


            }
			  
        	 
		  } 
		
        
		
		 
		 
		  
		if(empty($newfilename)){$newfilename="";}
		
		if(empty($picture)){$picture="";}

		
		$invoice_date = date('Y-m-d', strtotime($_POST['invoice_date']));
		$cust_info = array( 
			'claim_id'=> $custid,
			'invoice_date' => $invoice_date, 
			'invoice_no' =>  $this->input->post('invoice_no'),
			'approved_spares' => $this->input->post('approved_spares'),
			'approved_labour' => $this->input->post('approved_labour'),
			'invoice_total' => $this->input->post('invoice_total'),
			'customer_liability' => $this->input->post('customer_liability'),
			 'invoice_upload_name' => $newfilename,
			'invoice_upload_url' => $picture,
			'created_on'=> date('Y-m-d')
        );
        $where = array('id' => $custid);
        $this->load->model('Main_model');
        $this->Main_model->add_record('claim_invoice', $cust_info);
		
		$this->update_claim_status($custid, '8', 'GIC Liability Pending');
		
		
		////////////////////////////////////////////////////////////////////////////////////// CUSTOMER SMS ////////////////////////////////////////////////
		   				//GET CLAIM DATA
						$where = array('id' => $custid);
						$getclaimdata =$this->Main_model->single_row('claims', $where, 's');
						//GET MAKE
						$where = array('make_id' => $getclaimdata['make']);
						$getmake =$this->Main_model->single_row('vehicle_make', $where, 's');
						//GET MODEL
						$where = array('model_id' => $getclaimdata['model']);
						$getmodel =$this->Main_model->single_row('vehicle_model', $where, 's');
			 
				if(!empty($this->input->post('invoice_total'))){
					$invoicetotal = $this->input->post('invoice_total');
				}else{
					$invoicetotal = 'xxxxx';
				}
		
			 	$sms_msg = 'Hi '.$getclaimdata['name'].', Final invoice for your claim '.$getclaimdata['claim_no'].' for amount Rs. '.$invoicetotal.' has been submitted to the Insurance Company - GarageWorks';
				 
			  	$smsresponse = $this->send_booking_sms($getclaimdata['mobile'], $sms_msg);
				 
		
    	////////////////////////////////////////////////////////////////////////////////////// CUSTOMER SMS ////////////////////////////////////////////////
		
		
        $this->session->set_flashdata('info', 'claims Form Created Successfully..!');
		
         redirect(base_url() . 'index.php/claims/claims_details/'.$custid);
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	// claims Invoice Form
    public function claims_invoice()
    {
        $id = $this->uri->segment(3);
        $where = array('id' => $id);
		$data['products'] = $this->db->query("SELECT * FROM  item")->result();
		
		
		
		$data['estimates'] = $this->db->query("SELECT * FROM  claims_estimate WHERE claims_id=".$id)->result();
        
		$this->header();
        $data['surveyDetail'] = $this->Main_model->single_row('claims', $where, 's');
        $this->load->view('claims/claims_invoice', $data);
        $this->footer();
    }
	
	
	
	// Get data for purchased
    public function get_data_for_claimsinvoice()
    {
        $item_id = $this->input->post('id');
        $count = $this->input->post('total');
        $this->load->model('Main_model');

        $where = array('item_id' => $item_id);
        $data = $this->Main_model->get_purchased($item_id);

        if ($item_id != 0) {
            $output = '';
            $output .= '<tr id="entry_row_' . $count . '">';
            $output .= '<td id="serial_' . $count . '">' . $count . '</td>';
            $output .= '<td><input type="hidden" name="item_id[]" value="' . $data->item_id . '"> ' . $data->item_id . '</td>';
			$output .= '<input type="hidden" name="item_name[]" value="' . $data->item_name . ' - ' . $data->sub_product . ' - ' . $data->brand . '">';
            //$output .= '<input type="hidden" name="category_id[]" value="' . $data->category_id . '">';
            $output .= '<td>' . $data->item_name . ' - ' . $data->sub_product . '<br>' . $data->brand . '</td>';
            $output .= '<td><div id="spinner4">

     <input type="text" name="quantity[]" tabindex="1" id="quantity_' . $count . '" onclick="calculate_single_entry_sum(' . $count . ')" size="2" value="1" class="form-control col-lg-2" onkeyup="calculate_single_entry_sum(' . $count . ')">

                                </div>
                            </div></td>';
            $output .= '<td><input type="text" name="unit_price[]"  required onkeyup="calculate_single_entry_sum(' . $count . ')"  id="unit_price_' . $count . '" size="6" value=""></td>';
			
			//$output  .= '<td><input type="text" required name="mrp[]" id="mrp_' . $count . '" size="6" value=""></td>';
			
			
            $output .= '<td>
        <input type="text" name="estimated_amount[]" required  readonly="readonly" id="single_entry_total_' . $count . '" size="6" value="">
        </td>';
			
			$output .= '<td><input type="text" name="insurer_amount[]" required onkeyup="calculate_customer_entry_sum(' . $count . ')" id="insurer_single_total_' . $count . '" size="6" value=""></td>';
			
			$output .= '<td><input type="text" name="customer_amount[]" required  readonly="readonly" id="customer_single_total_' . $count . '" size="6" value=""></td>';
				
				
            $output .= '<td>
<i style="cursor: pointer;" id="delete_button_' . $count . '" onclick="delete_row(' . $count . ')" class="fa fa-trash"></i>
				</td>';
            $output .= '</tr>';

            echo $output;
        } else {
            echo $output = 0;
        }

    }
	
	
	
	
	
	
	
	
	// Save Invoice
    public function claims_invoice_form()
    {
        $custid = $this->input->post('claims_id'); 
		$item_id = $this->input->post('item_id');
		$item_name = $this->input->post('item_name');
       // $category_id = $this->input->post('category_id');
        $itemID = $this->input->post('unit_price');
        $unit_price = $this->input->post('unit_price');
        $quantity = $this->input->post('quantity');
		
        $estimated_amount = $this->input->post('estimated_amount');
		$insurer_amount = $this->input->post('insurer_amount');
		$customer_amount = $this->input->post('customer_amount');
		$invoice_no = $this->input->post('invoice_no');
        $estimated_on = date('Y-m-d');
		$cust_info = array(
            'invoice_amount' => $this->input->post('totalamount'),
			'insurer_amount' => $this->input->post('insurer_totalamount'),
			'customer_amount' => $this->input->post('customer_totalamount'),
			'invoice_no' => $invoice_no,
			'invoice_date' => date('Y-m-d', strtotime($this->input->post('invoice_date'))),
			'status' => 6
        );
        $where = array('id' => $custid);
        $this->load->model('Main_model');
        $this->Main_model->update_record('claims', $cust_info, $where);
         
		 for ($i = 0; $i < count($itemID); $i++) {
            extract($_POST);

            if (strlen($unit_price[$i]) > 0) {
			$estimated_items = array(
                'claims_id' => $custid,
                'item_id' => $item_id[$i],
				'invoice_no' => $invoice_no,
				'item' => $item_name[$i],
                'insurer_amount' => $insurer_amount[$i],
				'customer_amount' => $customer_amount[$i],
                'qty' => $quantity[$i],
                'amount' => $estimated_amount[$i],
				'rate' => $unit_price[$i]
            );


            $data_entry = $this->Main_model->add_record('claims_invoice', $estimated_items);
			}
		 }
		
        //$this->Main_model->update_record('stock', $cat_data, $where);
        $this->session->set_flashdata('info', 'claims Updated Successfully..!');

        redirect(base_url() . 'index.php/claims/claims_details/'.$custid);
    }
	
	
	// Show Insurer Invoice details
    public function show_insurer_invoices()
    {
        $id = $this->uri->segment(3);
        $this->header($title = "Insurer Invoice");
        $where = array('id' => $id);
        $sql = $this->db->query("select * from claims_invoice where claims_id=$id");
        $data['invoice'] = $sql->result();
		$data['surveyDetail'] = $this->Main_model->single_row('claims', $where, 's');
        $this->load->view('claims/insurer_invoice', $data);
        $this->footer();
    }
	
	
	// Show Customer Invoice details
    public function show_customer_invoices()
    {
        $id = $this->uri->segment(3);
        $this->header($title = "Customer Invoice");
        $where = array('id' => $id);
        $sql = $this->db->query("select * from claims_invoice where claims_id=$id");
        $data['invoice'] = $sql->result();
		$data['surveyDetail'] = $this->Main_model->single_row('claims', $where, 's');
        $this->load->view('claims/customer_invoice', $data);
        $this->footer();
    }
	
	
	
	// Create invoice upload form
    public function claims_gic_liability()
    {
        $custid = $this->input->post('cid'); 
		
		
		$survey_code = $custid;
		
		 
		
		
		$uploaddir = "uploads/images/";
		// Configure upload directory and allowed file types 
    	$upload_dir = "uploads/images/";
    	$allowed_types = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx', 'xls', 'xlsx'); 
      
    	// Define maxsize for files i.e 2MB 
    	$maxsize = 60 * 1024 * 1024;  
		$uploaded_on = date('Y-m-d');
		
		
		
		 // Checks if user sent an empty form  
     
			if ($_FILES['gicliability_upload']['name'] != '') {
  
         
		
		
			$file_tmpname = $_FILES['gicliability_upload']['tmp_name']; 
            $file_name = $_FILES['gicliability_upload']['name']; 
            $file_size = $_FILES['gicliability_upload']['size']; 
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION); 
		
		   
			
				$temp = explode(".", $file_name);
				$newfilename = 'GICLAB_'.$survey_code. '_' . $temp[0] . '.' . end($temp);
 			  	$data_upload = $uploaddir . basename($newfilename);
                $imageFileType = strtolower(pathinfo($data_upload,PATHINFO_EXTENSION));
            
			  
			  
			  
			  
							if(!in_array(strtolower($file_ext), $allowed_types)) { 
								$this->session->set_flashdata('msg', '<div class="alert alert-warning alert-dismissable">
								<button type="button" class="close" data-dismiss="alert"
									aria-hidden="true">
											&times;
												</button>
															<span>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</span>
																	</div>');
                 
                		$uploadOk = 0;
                		redirect(base_url().'index.php//claims/claims_details/'.$custid);

            				}
			  				if ($file_size > $maxsize){           
												 $this->session->set_flashdata('msg', '<div class="alert alert-warning alert-dismissable">
												<button type="button" class="close" data-dismiss="alert"
								  aria-hidden="true">
								  &times;
							   </button>
							   <span>Error: File size is larger than the allowed limit..</span>
							</div>');
						redirect(base_url().'index.php/claims/claims_details/'.$custid);	   
						 	}
			if (move_uploaded_file($file_tmpname, $data_upload)) {

                $picture = $data_upload;
				 

            } 

			else {
										$this->session->set_flashdata('msg', '<div class="alert alert-warning alert-dismissable">
						   <button type="button" class="close" data-dismiss="alert"
							  aria-hidden="true">
							  &times;
						   </button>
						   <span>Error:  '.$file_name.' could not be uploaded..</span>
						</div>');
									redirect(base_url().'index.php/claims/claims_details/'.$custid);	 


            }
			  
        	 
		  } 
		
        
		
		 
		 
		  
		if(empty($newfilename)){$newfilename="";}
		
		if(empty($picture)){$picture="";} 

		
		 
		$cust_info = array( 
			'claim_id'=> $custid, 
			'labour_liability' => $this->input->post('labour_liability'),
			'spares_liability' => $this->input->post('spares_liability'),
			'customer_liability' => $this->input->post('customer_liability'),
			 'liability_upload_name' => $newfilename,
			'liability_upload_url' => $picture,
			'created_on'=> date('Y-m-d')
        );
        $where = array('id' => $custid);
        $this->load->model('Main_model');
        $this->Main_model->add_record('claim_gic_liability', $cust_info);
		
		$this->update_claim_status($custid, '9', 'Delivery Pending');
		
        $this->session->set_flashdata('info', 'claims Form Created Successfully..!');
		
		////////////////////////////////////////////////////////////////////////////////////// CUSTOMER SMS ////////////////////////////////////////////////
		   				//GET CLAIM DATA
						$where = array('id' => $custid);
						$getclaimdata =$this->Main_model->single_row('claims', $where, 's');
						//GET MAKE
						$where = array('make_id' => $getclaimdata['make']);
						$getmake =$this->Main_model->single_row('vehicle_make', $where, 's');
						//GET MODEL
						$where = array('model_id' => $getclaimdata['model']);
						$getmodel =$this->Main_model->single_row('vehicle_model', $where, 's');
			 
						$insurer_liability = $this->input->post('labour_liability') + $this->input->post('spares_liability');
							$where3 = array('claim_id' => $custid);
						$getclaim_invoice =$this->Main_model->single_row('claim_invoice', $where3, 's');
		
			 	//$sms_msg = 'Hi '.$getclaimdata['name'].', We have received the final liability from Insurance Company. Approved amount is ₹'.$insurer_liability.' (Invoice Value: ₹'.$getclaim_invoice['invoice_total'].')';
				 
		if(!empty($this->input->post('customer_liability')) && $this->input->post('customer_liability')>0){ 
			
			
			$booking_payments_data = array(
			'claims_id' => $custid,
			'reciept_no' => '', 
			'estimated_amount' => $this->input->post('customer_liability'),
			'discount' => '0',
			'total_amount' => $this->input->post('customer_liability'), 
			'payment_status' => 'Not Paid',
			'payment_mode' => '',
			'payment_date' => '0000-00-00',
			'rz_payment_id' => '',
			'rz_invoice_no' => '',
			'rz_payment_link' => '',
			'rz_payment_status' => '',
			'created_on' => date('Y-m-d H:i:s'), 
			'updated_on' => date('Y-m-d H:i:s')
			
        );
	
        $this->Main_model->add_record('claims_payments', $booking_payments_data);
			
			
		$sendpaymentlink = $this->createrazorpaylink($getclaimdata['name'], $getclaimdata['email'], $getclaimdata['mobile'],  $getclaimdata['claim_no'], ($this->input->post('customer_liability')*100), $custid);
					
			
			if(!empty($sendpaymentlink)){ 
				
				//$sms_msg = 'Hi '.$getclaimdata['name'].', We have received the final liability from Insurance Company. Approved amount is Rs '.$insurer_liability.' (Invoice Value: Rs '.$getclaim_invoice['invoice_total'].', Customer Payable Amount: Rs '.$this->input->post('customer_liability').'. To make the payment please click here: '.$sendpaymentlink.' - GarageWorks'; 
				
				$sms_msg = 'Final liability for '.$getclaimdata['claim_no'].' is Rs '.$insurer_liability.', Invoice value - Rs '.$getclaim_invoice['invoice_total'].' Kindly pay the difference here '.$sendpaymentlink;
					
					
			  	$smsresponse = $this->send_booking_sms($getclaimdata['mobile'], $sms_msg);
			}
		}
		
    	////////////////////////////////////////////////////////////////////////////////////// CUSTOMER SMS ////////////////////////////////////////////////
		
        redirect(base_url() . 'index.php/claims/claims_details/'.$custid);
    }
	
	
	 
	
	
	public function createrazorpaylink($customer_name, $customer_email, $customer_phone,  $claim_no, $payment_amount, $claim_id){
	 
		$reciept_no = 'claim_'.$claim_no.'_'.date('dmY');
		
		$ch = curl_init();
    $fields = array();
    $fields["customer"]["name"] = $customer_name;
    $fields["customer"]["email"] = $customer_email;
    $fields["customer"]["contact"] = $customer_phone; 
	$fields["amount"] = $payment_amount;
	$fields["currency"] = "INR";
	$fields["description"] = "GarageWorks! Invoice for Claim No:". $claim_no;
	$fields["reference_id"] = $reciept_no;
	$fields["accept_partial"] = false; 
	$fields["reminder_enable"] = false;
	$fields["notify"]['sms'] = true;
	$fields["notify"]['email'] = true;
	//$fields["expire_by"] = "link";
	//$fields["callback_url"] = base_url().'index.php/booking/razorpaythankyou/';
	//$fields["callback_method"] = "get";
	$fields["options"]["checkout"]["name"] = "GarageWorks";	
	$fields["options"]["checkout"]["description"] = "Two-Wheeler Services In Your Parking";		
	//$fields["options"]["checkout"]["readonly"]["email"] = 1;		
	//$fields["options"]["checkout"]["readonly"]["contact"] = 1;			
    curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/payment_links/');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_USERPWD, "rzp_live_8UbYFNwis1oK8D:4zHnXIzYfc3lHHoCCBM76hx6");
    $headers = array();
    $headers[] = 'Accept: application/json';
    $headers[] = 'Content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $data = curl_exec($ch);

    if (empty($data) OR (curl_getinfo($ch, CURLINFO_HTTP_CODE != 200))) {
       $data = FALSE;
    } else {
        //return json_decode($data, TRUE);
		$rs_data = json_decode($data, TRUE);
    }
    curl_close($ch);
		
		/////////////////////////////////////////////////// UPDATE BOOKING PAYMENTS START
		
	 
		if(!empty($rs_data['error']['code']) && $rs_data['error']){ 
		$rs_data  = 'No payment details captured';
		}else{
			$claim_payments_data = array(  
			'reciept_no' => $reciept_no,
			'payment_status' => 'Issued',
			'rz_payment_id' => $rs_data['id'],
			'rz_invoice_no' => $rs_data['reference_id'],
			'rz_payment_link' => $rs_data['short_url'],
			'rz_payment_status' => $rs_data['status'],
			'updated_on' => date('Y-m-d H:i:s')
			
        );
		
		$where = array('claims_id' => $claim_id);
        
        $this->Main_model->update_record('claims_payments', $claim_payments_data, $where);
		
		 $rs_data['Payment_Invoice_Id'] = $rs_data['id'];
		 $rs_data['Payment_link'] = $rs_data['short_url'];	
		}
		/////////////////////////////////////////////////// UPDATE BOOKING PAYMENTS END
		if(!empty($rs_data['Payment_link'])){
			return $rs_data['Payment_link'];
		}else{
			return false;
		}
		//print_r($data);
		
	}
	
	public function CheckRS_PaymentStatus($claims_id,$rz_payment_id,$reciept_id){
		   //$mechanic_id = $this->input->post('mechanic_id');
		   //$claims_id = $this->input->post('claims_id'); 
		   //$rz_payment_id = $this->input->post('rz_payment_id'); 
		   //$reciept_id = 'claim_'.$claims_id.'_'.date('dmY');
		
			$ch = curl_init();
     
		
    curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/payment_links/'.$rz_payment_id);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, "rzp_live_8UbYFNwis1oK8D:4zHnXIzYfc3lHHoCCBM76hx6");
  //  $headers = array();
  //  $headers[] = 'Accept: application/json';
  //  $headers[] = 'Content-Type: application/json';
  //  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $data = curl_exec($ch);

    if (empty($data) OR (curl_getinfo($ch, CURLINFO_HTTP_CODE != 200))) {
       $data = FALSE;
    } else {
        //return json_decode($data, TRUE);
		$rs_data = json_decode($data, TRUE);
    }
    curl_close($ch);
		
		
		if(!empty($rs_data['status'])){ 
		if($rs_data['status'] == 'paid'){ 
		/////////////////////////////////////////////////// UPDATE BOOKING PAYMENTS START
		
	 	 
		
		$claims_payments_data = array(  
			'total_amount' => $rs_data['amount_paid'],
			'payment_status' => 'Paid', 
			'rz_payment_status' => 'Paid',
			'payment_mode' => 'Online',
			'rz_payment_mode' => $rs_data['payments'][0]['method'],
			'payment_date' => date('Y-m-d'),			
			'updated_on' => date('Y-m-d H:i:s')
			
        );
		
		$where = array('claims_id' => $claims_id);
        
        $this->Main_model->update_record('claims_payments', $claims_payments_data, $where);
		
			$response['payment_details'] = $rs_data;
		
		   $response['payment_status'] = $rs_data['status'];
			$response['amount_collected'] = $rs_data['amount_paid'];
		
			$response['payment_mode'] = $rs_data['payments'][0]['method'];
			$response['payment_date'] = date('Y-m-d');
			
		 
		/////////////////////////////////////////////////// UPDATE BOOKING PAYMENTS END
		}else{
			$response['payment_details'] = $rs_data;
		
		   $response['payment_status'] = $rs_data['status'];
			$response['amount_collected'] = '';
		
			$response['payment_mode'] = '';
			$response['payment_date'] = '';
		}
	}else{
			$response['payment_details'] = 'No payment processed';
		
		   $response['payment_status'] = 'No payment processed';
			$response['amount_collected'] = '';
		
			$response['payment_mode'] = '';
			$response['payment_date'] = '';
		}
           
		
		   $response['msg'] = 'Payment Status Updated'; 
		   $response['status'] = 'SUCCESS!';
		
		
			$returnval['amount_collected'] = $response['amount_collected']; 
			$returnval['payment_mode'] = $response['payment_mode'];
		
           return $returnval; 
       }
	
	public function checkpaymentlink()
    {
		$claims_id =    $this->input->post('claims_id'); 
		$this->load->model('Main_model');
		$records  = $this->db->query("SELECT * FROM claims_payments WHERE  claims_id = '$claims_id'");
		$response = $records->row(); 
		
		 if($records->num_rows()>0){  
				
		$GetChckData = $this->CheckRS_PaymentStatus($claims_id,$response->rz_payment_id,$response->rz_invoice_no);
		 
		if(!empty($GetChckData['amount_collected']) || $GetChckData['amount_collected']!=0 ){ 
		$amount_collected = $GetChckData['amount_collected'];	 
		$payment_mode = $GetChckData['payment_mode'];	 
		$customer_liability = $response->estimated_amount;	
		}else{
		$amount_collected = 0;	 
		$payment_mode = '';	 
		$customer_liability = 0;		
		}
			 
		 }else{
		$amount_collected = 0;	 
		$payment_mode = '';	 
		$customer_liability = 0;	
		}	
		
		$linkdata['customer_liability'] = $customer_liability;
		$linkdata['amount_collected'] = $amount_collected;	 
		$linkdata['payment_mode'] = $payment_mode;	 
		
        echo json_encode($linkdata); 
		// print_r($response);
		 
    }
	
	
	// Repair Start Form
    public function claim_delivery()
    {
        $custid = $this->input->post('cid'); 
        $delivery_date = date('Y-m-d', strtotime($_POST['delivery_date'])); 
		$cust_info = array( 
			'claim_id' => $custid,
			'delivery_date' => $delivery_date,
			'amount_collected' => $this->input->post('amount_collected'),
			'payment_mode' => $this->input->post('payment_mode'),
			'comments' => $this->input->post('payment_comments'),
			'created_on' => date('Y-m-d')
        );
 

        $where = array('id' => $custid);
        $this->load->model('Main_model');
        $this->Main_model->add_record('claim_delivery', $cust_info);
        $this->update_claim_status($custid, '10', 'Delivery Completed');
        //$this->Main_model->update_record('stock', $cat_data, $where);
        $this->session->set_flashdata('info', 'Claim Updated Successfully..!');
		
		
		
        redirect(base_url() . 'index.php/claims/claims_details/'.$custid);
    }
	
	
	
	
	
	// claims Invoice Form
    public function close_claims()
    {
        $custid = $this->uri->segment(3);
		
		
		$close_type = $this->input->post('close_type');	
        $cust_info = array(
            'active' => 0,
			'close_type' => $close_type,
        );
        $where = array('id' => $custid);
		$this->update_claim_status($custid, '-1', 'Claim Cancelled - '.$close_type );
        $this->load->model('Main_model');
        $this->Main_model->update_record('claims', $cust_info, $where);
		
		//$this->Main_model->update_record('stock', $cat_data, $where);
        $this->session->set_flashdata('info', 'claims Closed Successfully..!');

        redirect(base_url() . 'index.php/claims/claims_details/'.$custid);
    }
	
	
	
	
	public function update_claim_details($claimid, $col, $val)
    {
         $cust_info = array(
             $col => $val,
        );
        $where = array('id' => $claimid);
        $this->load->model('Main_model');
        $this->Main_model->update_record('claims', $cust_info, $where);
         
		 return true;
        
         
    }
	
	public function update_claim_status($claimid, $stage, $status)
    {
         $cust_info = array(
             'stage' => $stage,
			'status' => $status
        );
        $where = array('claim_id' => $claimid);
        $this->load->model('Main_model');
        $this->Main_model->update_record('claim_status', $cust_info, $where);
		
		$this->Main_model->update_record('claims', $cust_info, $where);
         
		 return true;
        
         
    }
	
	public function send_booking_sms($mobile, $message){
		 
 	
		$numbers = array(
                    $mobile
                );
                $sender = 'GWHELP'; 
                
                try{
                    $response['OTP_SEND'] = $this->textlocal->sendSms($numbers, $message, $sender);
                    
			       }catch(Exception $e){ 
                    $response['status'] = 'Failed';
					$response['mobile'] = $mobile; 
					$response['message'] = 'Error: '.$e->getMessage();
                }
		
			//echo json_encode($response); 
				 
	
	
	}
	
	public function send_claim_email($email, $subject, $message){
		 
		//$subject = "Survey Assigned";
		
		//$message = "Hi, Your insurance claim has been registered with GarageWorks. Our representative will connect to schedule a survey";
		
		$this->load->config('email');
        $this->load->library('email');
        
        $from = $this->config->item('smtp_user');
        $to = $email; // $this->input->post('to');
        $subject = $subject; // $this->input->post('subject');
        $message = $message; // $this->input->post('message');

        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) {
         $response = 1; //  $this->session->set_flashdata('info', 'Your Email has successfully been sent.');
			//echo 'Your Email has successfully been sent.';
        } else {
          $response = 0;//  show_error($this->email->print_debugger());
        }
		
return $response;
	}
	
	
	public function send_claim_email2(){
		 
		//$subject = "Survey Assigned";
		
		//$message = "Hi, Your insurance claim has been registered with GarageWorks. Our representative will connect to schedule a survey";
		
		$this->load->config('email');
        $this->load->library('email');
        
        $from = $this->config->item('smtp_user');
        $to = 'chintz2806@gmail.com'; // $this->input->post('to');
        $subject = 'GWCARE TEST'; // $this->input->post('subject');
        $message = 'Hi, <br> New Survey assigned! Claim No'; // $this->input->post('message');

        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) {
         $response = 1; //  
			$this->session->set_flashdata('info', 'Email has successfully been sent.');
			//echo 'Your Email has successfully been sent.';
        } else {
			$this->session->set_flashdata('Warning', 'Error in sending Email.');
          $response = 0;//  show_error($this->email->print_debugger());
        }
		
echo $response;
	}


}