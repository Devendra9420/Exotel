<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dist extends MY_Controller {

	 public function __construct()
    {
        parent::__construct();
        auth_check(); // check login auth 
		$this->load->model('Bookings_model', 'Bookings');  
		$this->load->model('Serviceproviders_model', 'Serviceproviders');
		$this->load->model('Dashboard_model', 'Dashboard');
		$this->load->model('Mechanicstats_model', 'Mechanic_dash');
		$this->load->model('Mechanicdash_model', 'Mechanicdash');
		 
    } 
	
	public function index() {  
		if($this->session->userdata('department')=='3'){ 
			$this->header($title = 'Dashboard'); 
        	$this->load->view('dashboard/technical_advisor');
        	$this->footer(); 
		}else{
			$this->rbac->check_sub_button_access('bookings','list_bookings', FALSE, array('add','edit','delete')); 
			$this->rbac->check_sub_button_access('bookings', 'list_bookings', FALSE, array('view'), array('view'=>base_url().'bookings/list_bookings/'));
		
		
			$this->rbac->check_sub_button_access('bookings', 'list_bookings', FALSE, array('add'), array('add'=>'<a href="'.base_url().'bookings/add_booking" class="add_record btn btn-info"> Add New Booking <i class="fa fa-plus"></i></a>')); 
			$this->rbac->check_sub_button_access('bookings', 'list_bookings', FALSE, array('delete'), array('delete'=>'<a href="'.base_url().'bookings/delete_booking" class="delete_record btn btn-danger"> Delete Booking <i class="fa fa-minus"></i></a>')); 
			
			$this->header($title = 'Dashboard'); 
        	$this->load->view('dashboard/dashboard');
        	$this->footer(); 
		} 
	} 
	
	public function mechanic_dash(){
		
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
		
		
        $this->header($title = 'Mechanic Dashboard');
		$this->load->view('dashboard/mechanic_dash',$data);
		$this->footer();
		 
	}
	
	public function mechanicdash_booking(){ 
		 header('Content-Type: application/json'); 
        echo $this->Mechanic_dash->mechanicdash_booking();
	}
	
	
	public function technicaladvisor_dashboard_bookings(){ 
		 header('Content-Type: application/json'); 
        echo $this->Dashboard->get_today_bookings();
	}
	
	
	public function index_0() {
		$data = array(
			'title' => "General Dashboard"
		);
		$this->load->view('dist/index-0', $data);
	}

	public function layout_default() {
		$data = array(
			'title' => "Layout &rsaquo; Default"
		);
		$this->load->view('dist/layout-default', $data);
	}

	public function layout_transparent() {
		$data = array(
			'title' => "Layout &rsaquo; Transparent Sidebar"
		);
		$this->load->view('dist/layout-transparent', $data);
	}

	public function layout_top_navigation() {
		$data = array(
			'title' => "Layout &rsaquo; Top Navigation"
		);
		$this->load->view('dist/layout-top-navigation', $data);
	}

	public function blank() {
		$data = array(
			'title' => "Blank Page"
		);
		$this->load->view('dist/blank', $data);
	}

	public function bootstrap_alert() {
		$data = array(
			'title' => "Bootstrap Components &rsaquo; Alert"
		);
		$this->load->view('dist/bootstrap-alert', $data);
	}

	public function bootstrap_badge() {
		$data = array(
			'title' => "Bootstrap Components &rsaquo; Badge"
		);
		$this->load->view('dist/bootstrap-badge', $data);
	}

	public function bootstrap_breadcrumb() {
		$data = array(
			'title' => "Bootstrap Components &rsaquo; Breadcrumb"
		);
		$this->load->view('dist/bootstrap-breadcrumb', $data);
	}

	public function bootstrap_buttons() {
		$data = array(
			'title' => "Bootstrap Components &rsaquo; Buttons"
		);
		$this->load->view('dist/bootstrap-buttons', $data);
	}

	public function bootstrap_card() {
		$data = array(
			'title' => "Bootstrap Components &rsaquo; Card"
		);
		$this->load->view('dist/bootstrap-card', $data);
	}

	public function bootstrap_carousel() {
		$data = array(
			'title' => "Bootstrap Components &rsaquo; Carousel"
		);
		$this->load->view('dist/bootstrap-carousel', $data);
	}

	public function bootstrap_collapse() {
		$data = array(
			'title' => "Bootstrap Components &rsaquo; Collapse"
		);
		$this->load->view('dist/bootstrap-collapse', $data);
	}

	public function bootstrap_dropdown() {
		$data = array(
			'title' => "Bootstrap Components &rsaquo; Dropdown"
		);
		$this->load->view('dist/bootstrap-dropdown', $data);
	}

	public function bootstrap_form() {
		$data = array(
			'title' => "Bootstrap Components &rsaquo; Form"
		);
		$this->load->view('dist/bootstrap-form', $data);
	}

	public function bootstrap_list_group() {
		$data = array(
			'title' => "Bootstrap Components &rsaquo; List Group"
		);
		$this->load->view('dist/bootstrap-list-group', $data);
	}

	public function bootstrap_media_object() {
		$data = array(
			'title' => "Bootstrap Components &rsaquo; Media Object"
		);
		$this->load->view('dist/bootstrap-media-object', $data);
	}

	public function bootstrap_modal() {
		$data = array(
			'title' => "Bootstrap Components &rsaquo; Modal"
		);
		$this->load->view('dist/bootstrap-modal', $data);
	}

	public function bootstrap_nav() {
		$data = array(
			'title' => "Bootstrap Components &rsaquo; Nav"
		);
		$this->load->view('dist/bootstrap-nav', $data);
	}

	public function bootstrap_navbar() {
		$data = array(
			'title' => "Bootstrap Components &rsaquo; Navbar"
		);
		$this->load->view('dist/bootstrap-navbar', $data);
	}

	public function bootstrap_pagination() {
		$data = array(
			'title' => "Bootstrap Components &rsaquo; Pagination"
		);
		$this->load->view('dist/bootstrap-pagination', $data);
	}

	public function bootstrap_popover() {
		$data = array(
			'title' => "Bootstrap Components &rsaquo; Popover"
		);
		$this->load->view('dist/bootstrap-popover', $data);
	}

	public function bootstrap_progress() {
		$data = array(
			'title' => "Bootstrap Components &rsaquo; Progress"
		);
		$this->load->view('dist/bootstrap-progress', $data);
	}

	public function bootstrap_table() {
		$data = array(
			'title' => "Bootstrap Components &rsaquo; Table"
		);
		$this->load->view('dist/bootstrap-table', $data);
	}

	public function bootstrap_tooltip() {
		$data = array(
			'title' => "Bootstrap Components &rsaquo; Tooltip"
		);
		$this->load->view('dist/bootstrap-tooltip', $data);
	}

	public function bootstrap_typography() {
		$data = array(
			'title' => "Bootstrap Components &rsaquo; Typography"
		);
		$this->load->view('dist/bootstrap-typography', $data);
	}

	public function components_article() {
		$data = array(
			'title' => "Components &rsaquo; Article"
		);
		$this->load->view('dist/components-article', $data);
	}

	public function components_avatar() {
		$data = array(
			'title' => "Components &rsaquo; Avatar"
		);
		$this->load->view('dist/components-avatar', $data);
	}

	public function components_chat_box() {
		$data = array(
			'title' => "Components &rsaquo; Chat Box"
		);
		$this->load->view('dist/components-chat-box', $data);
	}

	public function components_empty_state() {
		$data = array(
			'title' => "Components &rsaquo; Empty State"
		);
		$this->load->view('dist/components-empty-state', $data);
	}

	public function components_gallery() {
		$data = array(
			'title' => "Components &rsaquo; Gallery"
		);
		$this->load->view('dist/components-gallery', $data);
	}

	public function components_hero() {
		$data = array(
			'title' => "Components &rsaquo; Hero"
		);
		$this->load->view('dist/components-hero', $data);
	}

	public function components_multiple_upload() {
		$data = array(
			'title' => "Components &rsaquo; Multiple Upload"
		);
		$this->load->view('dist/components-multiple-upload', $data);
	}

	public function components_pricing() {
		$data = array(
			'title' => "Components &rsaquo; Pricing"
		);
		$this->load->view('dist/components-pricing', $data);
	}

	public function components_statistic() {
		$data = array(
			'title' => "Components &rsaquo; Statistic"
		);
		$this->load->view('dist/components-statistic', $data);
	}

	public function components_tab() {
		$data = array(
			'title' => "Components &rsaquo; Tab"
		);
		$this->load->view('dist/components-tab', $data);
	}

	public function components_table() {
		$data = array(
			'title' => "Components &rsaquo; Table"
		);
		$this->load->view('dist/components-table', $data);
	}

	public function components_user() {
		$data = array(
			'title' => "Components &rsaquo; User"
		);
		$this->load->view('dist/components-user', $data);
	}

	public function components_wizard() {
		$data = array(
			'title' => "Components &rsaquo; Wizard"
		);
		$this->load->view('dist/components-wizard', $data);
	}

	public function forms_advanced_form() {
		$data = array(
			'title' => "Forms &rsaquo; Advanced Forms"
		);
		$this->load->view('dist/forms-advanced-form', $data);
	}

	public function forms_editor() {
		$data = array(
			'title' => "Forms &rsaquo; Editor"
		);
		$this->load->view('dist/forms-editor', $data);
	}

	public function forms_validation() {
		$data = array(
			'title' => "Forms &rsaquo; Validation"
		);
		$this->load->view('dist/forms-validation', $data);
	}

	public function gmaps_advanced_route() {
		$data = array(
			'title' => "Google Maps &rsaquo; Advanced Route"
		);
		$this->load->view('dist/gmaps-advanced-route', $data);
	}

	public function gmaps_draggable_marker() {
		$data = array(
			'title' => "Google Maps &rsaquo; Draggable Marker"
		);
		$this->load->view('dist/gmaps-draggable-marker', $data);
	}

	public function gmaps_geocoding() {
		$data = array(
			'title' => "Google Maps &rsaquo; Geocoding"
		);
		$this->load->view('dist/gmaps-geocoding', $data);
	}

	public function gmaps_geolocation() {
		$data = array(
			'title' => "Google Maps &rsaquo; Geolocation"
		);
		$this->load->view('dist/gmaps-geolocation', $data);
	}

	public function gmaps_marker() {
		$data = array(
			'title' => "Google Maps &rsaquo; Marker"
		);
		$this->load->view('dist/gmaps-marker', $data);
	}

	public function gmaps_multiple_marker() {
		$data = array(
			'title' => "Google Maps &rsaquo; Multiple Marker"
		);
		$this->load->view('dist/gmaps-multiple-marker', $data);
	}

	public function gmaps_route() {
		$data = array(
			'title' => "Google Maps &rsaquo; Route"
		);
		$this->load->view('dist/gmaps-route', $data);
	}

	public function gmaps_simple() {
		$data = array(
			'title' => "Google Maps &rsaquo; Simple"
		);
		$this->load->view('dist/gmaps-simple', $data);
	}

	public function modules_calendar() {
		$data = array(
			'title' => "Modules &rsaquo; Calendar"
		);
		$this->load->view('dist/modules-calendar', $data);
	}

	public function modules_chartjs() {
		$data = array(
			'title' => "Modules &rsaquo; ChartJS"
		);
		$this->load->view('dist/modules-chartjs', $data);
	}

	public function modules_datatables() {
		$data = array(
			'title' => "Modules &rsaquo; Datatables"
		);
		$this->load->view('dist/modules-datatables', $data);
	}

	public function modules_flag() {
		$data = array(
			'title' => "Modules &rsaquo; Flag"
		);
		$this->load->view('dist/modules-flag', $data);
	}

	public function modules_font_awesome() {
		$data = array(
			'title' => "Modules &rsaquo; Font Awesome"
		);
		$this->load->view('dist/modules-font-awesome', $data);
	}

	public function modules_ion_icons() {
		$data = array(
			'title' => "Modules &rsaquo; Ion Icons"
		);
		$this->load->view('dist/modules-ion-icons', $data);
	}

	public function modules_owl_carousel() {
		$data = array(
			'title' => "Modules &rsaquo; Owl Carousel"
		);
		$this->load->view('dist/modules-owl-carousel', $data);
	}

	public function modules_sparkline() {
		$data = array(
			'title' => "Modules &rsaquo; Sparkline"
		);
		$this->load->view('dist/modules-sparkline', $data);
	}

	public function modules_sweet_alert() {
		$data = array(
			'title' => "Modules &rsaquo; Sweet Alert"
		);
		$this->load->view('dist/modules-sweet-alert', $data);
	}

	public function modules_toastr() {
		$data = array(
			'title' => "Modules &rsaquo; Toastr"
		);
		$this->load->view('dist/modules-toastr', $data);
	}

	public function modules_vector_map() {
		$data = array(
			'title' => "Modules &rsaquo; Vector Map"
		);
		$this->load->view('dist/modules-vector-map', $data);
	}

	public function modules_weather_icon() {
		$data = array(
			'title' => "Modules &rsaquo; Weather Icon"
		);
		$this->load->view('dist/modules-weather-icon', $data);
	}

	public function auth_forgot_password() {
		$data = array(
			'title' => "Forgot Password"
		);
		$this->load->view('dist/auth-forgot-password', $data);
	}

	public function auth_login() {
		$data = array(
			'title' => "Login"
		);
		$this->load->view('dist/auth-login', $data);
	}

	public function auth_register() {
		$data = array(
			'title' => "Register"
		);
		$this->load->view('dist/auth-register', $data);
	}

	public function auth_reset_password() {
		$data = array(
			'title' => "Reset Password"
		);
		$this->load->view('dist/auth-reset-password', $data);
	}

	public function errors_503() {
		$data = array(
			'title' => "503"
		);
		$this->load->view('dist/errors-503', $data);
	}

	public function errors_403() {
		$data = array(
			'title' => "403"
		);
		$this->load->view('dist/errors-403', $data);
	}

	public function errors_404() {
		$data = array(
			'title' => "404"
		);
		$this->load->view('dist/errors-404', $data);
	}

	public function errors_500() {
		$data = array(
			'title' => "500"
		);
		$this->load->view('dist/errors-500', $data);
	}

	public function features_activities() {
		$data = array(
			'title' => "Activities"
		);
		$this->load->view('dist/features-activities', $data);
	}

	public function features_post_create() {
		$data = array(
			'title' => "Post Create"
		);
		$this->load->view('dist/features-post-create', $data);
	}

	public function features_posts() {
		$data = array(
			'title' => "Posts"
		);
		$this->load->view('dist/features-posts', $data);
	}

	public function features_profile() {
		$data = array(
			'title' => "Profile"
		);
		$this->load->view('dist/features-profile', $data);
	}

	public function features_settings() {
		$data = array(
			'title' => "Settings"
		);
		$this->load->view('dist/features-settings', $data);
	}

	public function features_setting_detail() {
		$data = array(
			'title' => "Setting Detail"
		);
		$this->load->view('dist/features-setting-detail', $data);
	}

	public function features_tickets() {
		$data = array(
			'title' => "Tickets"
		);
		$this->load->view('dist/features-tickets', $data);
	}

	public function utilities_contact() {
		$data = array(
			'title' => "Contact"
		);
		$this->load->view('dist/utilities-contact', $data);
	}

	public function utilities_invoice() {
		$data = array(
			'title' => "Invoice"
		);
		$this->load->view('dist/utilities-invoice', $data);
	}

	public function utilities_subscribe() {
		$data = array(
			'title' => "Subscribe"
		);
		$this->load->view('dist/utilities-subscribe', $data);
	}

	public function credits() {
		$data = array(
			'title' => "Credits"
		);
		$this->load->view('dist/credits', $data);
	}
}
