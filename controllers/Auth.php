<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->library('mailer');
		$this->load->model('auth_model', 'auth_model');
	}

	//--------------------------------------------------------------
	public function index(){

		if($this->session->has_userdata('is_admin')){
			redirect('dashboard');
		}
		else{
			redirect('auth/login');
		}
	}
	
	
	
	
	
	/////////////// RBACK RULES 
			
		// To check if user has access to this MODULE = $this->rbac->check_module_access();
	
		// To check if user has access to this SUB_MODULE = $this->rbac->check_sub_module_access(); 
	 
		// To check if user has permission for operations to this SUB_MODULE = check_sub_module_permission($module, $sub_module, $operation)
	
 		// To check if user has permission for all button to this SUB_MODULE = $this->rbac->check_sub_button_access($module, $sub_module, TRUE); 
	
		// To check if user has permission for specific button to this SUB_MODULE = $this->rbac->check_sub_button_access($module, $sub_module, FALSE, array($operation)); 
	
		// To check if user has permission for specific custom button to this SUB_MODULE = $this->rbac->check_sub_button_access($module, $sub_module, FALSE, array($operation), array($operation=>'COMPLETE LINK <a></a> TAG or any other text data')); 
	
	public function test(){ 
				$this->header($title = 'Test Dashboard');
				$this->load->view('test');
				$this->footer();
	}
	
	public function list_test(){ 
			$this->rbac->check_sub_module_access();  
			$this->rbac->check_sub_button_access('auth','list_test', TRUE);   
				$this->header($title = 'List Test');
				$this->load->view('test');
				$this->footer();
	}
	
	//--------------------------------------------------------------
	public function login(){

		if($this->input->post('submit')){

			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('error', $data['errors']);
				redirect(base_url('auth/login'),'refresh');
			}
			else {
				$data = array(
					'username' => $this->input->post('username'),
					'password' => $this->input->post('password')
				);
				$result = $this->auth_model->login($data);
				if($result){
					if($result['is_verify'] == 0){
						$this->session->set_flashdata('error', 'Please verify your email address!');
						redirect(base_url('auth/login'));
						exit();
					}
					if($result['is_active'] == 0){
						$this->session->set_flashdata('error', 'Account is disabled by Admin!');
						redirect(base_url('auth/login'));
						exit();
					}
					if($result['is_admin'] == 1){
						$admin_data = array(
							'user_id' => $result['id'],
							'username' => $result['username'],  
							'user_full_name' => $result['firstname'].' '.$result['lastname'],
							'user_pic' => $result['pic'],
							'user_mobile' => $result['mobile'],
							'user_email' => $result['email'],
							'is_admin' => $result['is_admin'],
							'city' => $result['city'],
							'user_type' => $result['user_type'],
							'department' => $result['department'],
							'is_admin_login' => TRUE,
						);
						$this->session->set_userdata($admin_data);
						$this->rbac->set_access_in_session(); // set access in session

						 
						redirect(base_url(), 'refresh');
						 

						}else{
						
						$admin_data = array(
							'user_id' => $result['id'],
							'username' => $result['username'],  
							'user_full_name' => $result['firstname'].' '.$result['lastname'],
							'user_pic' => $result['pic'],
							'user_mobile' => $result['mobile'],
							'user_email' => $result['email'],
							'is_admin' => $result['is_admin'],
							'city' => $result['city'],
							'user_type' => $result['user_type'],
							'department' => $result['department'],
							'is_admin_login' => FALSE,
						);
						$this->session->set_userdata($admin_data);
						$this->rbac->set_access_in_session(); // set access in session

						 
						redirect(base_url(), 'refresh');

						
						}
					}
					else{
						$this->session->set_flashdata('errors', 'Invalid Username or Password!');
						redirect(base_url('auth/login'));
					}
				}
			}
			else{
				$data['title'] = 'Login';
				$data['navbar'] = false;
				$data['sidebar'] = false;
				$data['footer'] = false;
				$data['bg_cover'] = true;

				$this->header($title = '<img alt="image" src="'.base_url().'logo.png" class="shadow-light mr-1 img-fluid">');
				$this->load->view('auth/login', $data);
				$this->footer();
			}
		}	

		//-------------------------------------------------------------------------
		public function register(){

			if($this->input->post('submit')){

				// for google recaptcha
				if ($this->recaptcha_status == true) {
		            if (!$this->recaptcha_verify_request()) {
		                $this->session->set_flashdata('form_data', $this->input->post());
		                $this->session->set_flashdata('error', 'reCaptcha Error');
		                redirect(base_url('auth/register'));
		                exit();
		            }
		        }
	        
				$this->form_validation->set_rules('username', 'Username', 'trim|alpha_numeric|is_unique[admin.username]|required');
				$this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
				$this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
				$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|is_unique[admin.email]|required');
				$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
				$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|required|matches[password]');

				if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('form_data', $this->input->post());
					$this->session->set_flashdata('errors', $data['errors']);
					redirect(base_url('auth/register'),'refresh');
				}
				else{
					$data = array(
						'username' => $this->input->post('username'),
						'firstname' => $this->input->post('firstname'),
						'lastname' => $this->input->post('lastname'),
						'user_type' => 2, // By default i putt role is 2 for registraiton
						'email' => $this->input->post('email'),
						'password' =>  password_hash($this->input->post('password'), PASSWORD_BCRYPT),
						'is_active' => 1,
						'is_verify' => 0,
						'token' => md5(rand(0,1000)),    
						'last_ip' => '',
						'created_at' => date('Y-m-d : h:m:s'),
						'updated_at' => date('Y-m-d : h:m:s'),
					);
					$data = $this->security->xss_clean($data);
					$result = $this->auth_model->register($data);
					if($result){
						//sending welcome email to user
						$this->load->helper('email_helper');

						$mail_data = array(
							'fullname' => $data['firstname'].' '.$data['lastname'],
							'verification_link' => base_url('auth/verify/').'/'.$data['token']
						);

						$to = $data['email'];

						$email = $this->mailer->mail_template($to,'email-verification',$mail_data);

						if($email){
							$this->session->set_flashdata('success', 'Your Account has been made, please verify it by clicking the activation link that has been send to your email.');	
							redirect(base_url('auth/login'));
						}	
						else{
							echo 'Email Error';
						}
					}
				}
			}
			else{
				$data['title'] = 'Create an Account';
				$data['navbar'] = false;
				$data['sidebar'] = false;
				$data['footer'] = false;
				$data['bg_cover'] = true;

				$this->header($title = 'Register');
				$this->load->view('auth/register', $data);
				$this->footer();
			}
		}

		//----------------------------------------------------------	
		public function verify(){

			$verification_id = $this->uri->segment(4);
			$result = $this->auth_model->email_verification($verification_id);
			if($result){
				$this->session->set_flashdata('success', 'Your email has been verified, you can now login.');
				redirect(base_url('auth/login'));
			}
			else{
				$this->session->set_flashdata('success', 'The url is either invalid or you already have activated your account.');	
				redirect(base_url('auth/login'));
			}	
		}

		//--------------------------------------------------		
		public function forgot_password(){

			if($this->input->post('submit')){
				//checking server side validation
				$this->form_validation->set_rules('email', 'Email', 'valid_email|trim|required');
				if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('errors', $data['errors']);
					redirect(base_url('auth/forget_password'),'refresh');
				}

				$email = $this->input->post('email');
				$response = $this->auth_model->check_user_mail($email);

				if($response){

					$rand_no = rand(0,1000);
					$pwd_reset_code = md5($rand_no.$response['id']);
					$this->auth_model->update_reset_code($pwd_reset_code, $response['id']);
					
					// --- sending email
					$to = $response['email'];
					$mail_data= array(
						'fullname' => $response['firstname'].' '.$response['lastname'],
						'reset_link' => base_url('auth/reset_password/'.$pwd_reset_code)
					);
					$this->mailer->mail_template($to,'forget-password',$mail_data);

					if($email){
						$this->session->set_flashdata('success', 'We have sent instructions for resetting your password to your email');

						redirect(base_url('auth/forgot_password'));
					}
					else{
						$this->session->set_flashdata('error', 'There is the problem on your email');
						redirect(base_url('auth/forgot_password'));
					}
				}
				else{
					$this->session->set_flashdata('error', 'The Email that you provided are invalid');
					redirect(base_url('auth/forgot_password'));
				}
			}
			else{

				$data['title'] = 'Forget Password';
				$data['navbar'] = false;
				$data['sidebar'] = false;
				$data['footer'] = false;
				$data['bg_cover'] = true;

				$this->header($title = 'Forget Password');
				$this->load->view('auth/forget_password', $data);
				$this->footer();
			}
		}

		//----------------------------------------------------------------		
		public function reset_password($id=0){

			// check the activation code in database
			if($this->input->post('submit')){
				$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
				$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|required|matches[password]');

				if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);

					$this->session->set_flashdata('reset_code', $id);
					$this->session->set_flashdata('errors', $data['errors']);
					redirect($_SERVER['HTTP_REFERER'], 'refresh');
				}
  
				else{
					$new_password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
					$this->auth_model->reset_password($id, $new_password);
					$this->session->set_flashdata('success','New password has been Updated successfully.Please login below');
					redirect(base_url('auth/login'));
				}
			}
			else{
				$result = $this->auth_model->check_password_reset_code($id);

				if($result){

					$data['title'] = 'Reseat Password';
					$data['reset_code'] = $id;
					$data['navbar'] = false;
					$data['sidebar'] = false;
					$data['footer'] = false;
					$data['bg_cover'] = true;

					$this->header($title = 'Reset Password');
					$this->load->view('auth/reset_password', $data);
					$this->footer();

				}
				else{
					$this->session->set_flashdata('error','Password Reset Code is either invalid or expired.');
					redirect(base_url('auth/forgot_password'));
				}
			}
		}

		//-----------------------------------------------------------------------
		public function logout(){
			$this->session->sess_destroy();
			redirect(base_url('auth/login'), 'refresh');
		}
		
		// Get Country. State and City
		//----------------------------------------
		public function get_country_states()
		{
			$states = $this->db->select('*')->where('country_id',$this->input->post('country'))->get('states')->result_array();
		    $options = array('' => 'Select Option') + array_column($states,'name','id');
		    $html = form_dropdown('state',$options,'','class="form-control select2" required');
			$error =  array('msg' => $html);
			echo json_encode($error);
		}

		//----------------------------------------
		public function get_state_cities()
		{
			$cities = $this->db->select('*')->where('state_id',$this->input->post('state'))->get('cities')->result_array();
		    $options = array('' => 'Select Option') + array_column($cities,'name','id');
		    $html = form_dropdown('city',$options,'','class="form-control select2" required');
			$error =  array('msg' => $html);
			echo json_encode($error);
		}

	}  // end class


?>