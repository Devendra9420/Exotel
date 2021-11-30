<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Spares extends MY_Controller 
{

    public function __construct() {
        Parent::__construct();
        $this->load->model("Spares_model", 'Spares');
    }

   public function index(){

     	$data['items'] = $this->Common->select('item');  
        $this->header();
        $this->load->view('spares/items', $data);
        $this->footer();

   } 
      // List Items
    public function list_spares()
    { 
		$this->rbac->check_sub_button_access('spares', 'add_spares', FALSE, array('add'), array('add'=>'<button type="button" data-target="#add_spares" data-toggle="modal" class="add_record btn btn-info"> Add New Spare <i class="fa fa-plus"></i></button>'));
		$this->rbac->check_sub_button_access('spares', 'map_spares', FALSE, array('edit'), array('edit'=>'<a href="'.base_url().'spares/map_spares" class="edit_record btn btn-info"> Map Spare <i class="fa fa-eye"></i></a>'));
		$data['spares'] = $this->Common->select('spares');  
        $this->header();
        $this->load->view('spares/spares', $data);
        $this->footer(); 
    }
	// List Items
    public function map_spares()
    {  
		$this->rbac->check_sub_button_access('spares', 'map_spares', FALSE, array('add','edit'));
		$data['spares'] = $this->Common->select('spares');  
        $this->header();
        $this->load->view('spares/map_spares', $data);
        $this->footer(); 
    }
	public function get_spares(){ 
		 header('Content-Type: application/json'); 
        echo $this->Spares->get_spares();
	}
	public function get_spares_details()
	{ 
	   extract($_POST);   
	   $data = $this->Spares->get_spares_data($spares_id);  
       echo json_encode($data); 
	}
	public function get_all_spares()
	{
		if($this->input->post('q')){
			$search=$this->input->post('q');
		  }else{
			 $search=NULL; 
		  } 
		echo json_encode($this->Spares->get_all_spares($search));
	}
	
	public function get_spares_id_rows()
	{
		extract($_POST);   
		echo json_encode($this->Spares->get_spares_id_rows($spares_id));
	}
	
	public function add_spares(){ 
		 extract($_POST);     
         $response = $this->Spares->add_spares();  
				if($response){
				$this->session->set_flashdata($response['msg_type'], $response['msg']);
				redirect(base_url() . 'spares/list_spares/');
				}else{
				$this->session->set_flashdata('danger', 'Error! while adding New Spares ('. $spares_id. ')');
				redirect(base_url() . 'spares/list_spares/');
				} 
	}
	
	public function update_spares_map(){
		extract($_POST);     
         $response = $this->Spares->update_spares_map();  
				if($response){
				$this->session->set_flashdata($response['type'], $response['msg']);
				redirect(base_url() . 'spares/list_spares/');
				}else{
				$this->session->set_flashdata('danger', 'Error! while adding New Spares ('. $spares_id. ')');
				redirect(base_url() . 'spares/list_spares/');
				} 
	}
	 // List Items
    public function list_spares_rate()
    { 
		$this->rbac->check_sub_button_access('spares', 'add_spares_rate', FALSE, array('add'), array('add'=>'<button type="button" data-target="#add_spares_rate" data-toggle="modal" class="add_record btn btn-info"> Add New Spare Rate<i class="fa fa-plus"></i></button>')); 
		$data['spares_rate'] = $this->Common->select('spares_rate'); 
        $this->header();
        $this->load->view('spares/spares_rate', $data);
        $this->footer(); 
    }
	 
	public function get_spares_rate(){ 
		 header('Content-Type: application/json'); 
        echo $this->Spares->get_spares_rate();
	}
	
	public function get_spares_rate_details()
	{ 
	   extract($_POST);   
	   $data = $this->Spares->get_spares_rate_data($rates_id);  
       echo json_encode($data); 
	} 
	public function add_spares_rate(){ 
		 extract($_POST);     
         $response = $this->Spares->add_spares_rate();  
				if($response){
				$this->session->set_flashdata('success', 'Spares Rate for '. $spares_id. ' added successfully..!');
				redirect(base_url() . 'spares/list_spares_rate/');
				}else{
				$this->session->set_flashdata('danger', 'Error! while adding Spares Rate for '. $spares_id);
				redirect(base_url() . 'spares/list_spares_rate/');
				} 
	}
	
	public function update_spares_rate(){ 
		 extract($_POST);     
         $response = $this->Spares->update_spares_rate();  
				if($response){
				$this->session->set_flashdata('success', 'Spares Rate for '. $spares_id. ' updated successfully..!');
				redirect(base_url() . 'spares/list_spares_rate/');
				}else{
				$this->session->set_flashdata('danger', 'Error! while updating Spares Rate for '. $spares_id);
				redirect(base_url() . 'spares/list_spares_rate/');
				} 
	}
	
	
	
	 // List Items
     // List Items
    public function list_items()
    { 
		 
		$this->rbac->check_sub_button_access('spares', 'add_item', FALSE, array('add'), array('add'=>'<button type="button" data-target="#add_item" data-toggle="modal" class="add_record btn btn-info"> Add New Item<i class="fa fa-plus"></i></button>')); 
		$data['items'] = $this->Common->select('item'); 
        $this->header();
        $this->load->view('spares/items', $data);
        $this->footer(); 
    }
	 
	public function get_items(){ 
		 header('Content-Type: application/json'); 
        echo $this->Spares->get_items();
	}
	
	public function get_items_details()
	{ 
	   extract($_POST);   
	   $data = $this->Spares->get_items_data($item_id);  
       echo json_encode($data); 
	} 
	public function add_item(){ 
		 extract($_POST);     
         $response = $this->Spares->add_item();  
				if($response){
				$this->session->set_flashdata($response['msg_type'], $response['msg']);
				redirect(base_url() . 'spares/list_items/');
				}else{
				$this->session->set_flashdata('danger', 'Error! while adding Item');
				redirect(base_url() . 'spares/list_items/');
				} 
	}
	
	public function update_item(){ 
		 extract($_POST);     
         $response = $this->Spares->update_item();  
				if($response){
				$this->session->set_flashdata('success', 'Item updated successfully..!');
				redirect(base_url() . 'spares/list_items/');
				}else{
				$this->session->set_flashdata('danger', 'Error! while updating Item ');
				redirect(base_url() . 'spares/list_items/');
				} 
	}
	
	 // List Labour
    public function list_labour()
    { 
		$data['labours'] = $this->Common->select('labour'); 
		$data['categories'] = $this->Main_model->select('vehicle_category'); 
		$data['items'] = $this->db->query("SELECT * FROM item WHERE item_code NOT IN (SELECT item_code FROM labour)")->result();
        $this->header();
        $this->load->view('spares/labour', $data);
        $this->footer();  
    }
	
	 
	public function Getsinglelabour(){
     
     // POST data
     $labour_id = $this->input->post('labour_id');
	 $labour_data = $this->Common->single_row('labour', array('id'=>$labour_id));			
     				 $data['id']=$labour_data->id; 
                     $data['item_name']=$labour_data->item_name;
                     $data['item_code']=$labour_data->item_code;
                     $data['vehicle_category']=$labour_data->vehicle_category;
                     $data['gst']=$labour_data->gst;
                     $data['sac']=$labour_data->sac;   
                     $data['rate']=$labour_data->rate;
		
     echo json_encode($data);
  }
	 
	
	public function add_labour(){
		$foritem = $this->input->post('foritem');
		if($foritem==1){
		$item_name = $this->input->post('item_name');	
		}elseif($foritem==0){
		$item_name = $this->input->post('labour_item_name');	
		}
		
		$item_code = $this->input->post('item_code');
		$gst = $this->input->post('gst');
		$sac = $this->input->post('sac');
		$vehicle_categories = $this->db->query("SELECT * FROM vehicle_category")->result();
		
		$n=0;
		foreach($vehicle_categories as $vehicle_category){
		$n++;
		$category_rate  = $this->input->post($vehicle_category->vehicle_category.'_rate');
		
		$data = array(
                'item_name' => $item_name,
                'item_code' => $item_code,
                'vehicle_category' => $vehicle_category->vehicle_category,
                'gst' => $gst, 
				'sac' => $sac, 
				'rate' => $category_rate, 	
					);
         $response = $this->Main_model->add_record('labour', $data);	
			
		}
		  		
				if($response){
				$this->session->set_flashdata('success', 'Labour for '. $item_name. ' created successfully..!');
				redirect(base_url() . 'spares/list_labour/');
				}else{
				$this->session->set_flashdata('danger', 'Error! while creating new labour for '.$item_name. '');
				redirect(base_url() . 'spares/list_labour/');
				}
			 
		
	}
	
	  
	 
	
	
	public function update_labour(){
		 
		$labour_id = $this->input->post('labour_id'); 
		$gst = $this->input->post('gst');
		$sac = $this->input->post('sac');
		$rate = $this->input->post('rate'); 
		 
		 
		
		$data = array( 
                'gst' => $gst, 
				'sac' => $sac, 
				'rate' => $rate, 	
					); 
		 
        $where = array('id' => $labour_id);
        
         $response = $this->Main_model->update_record('labour', $data, $where);
		  		
				if($response){
				$this->session->set_flashdata('success', 'Labour for '. $item_name. ' updated successfully..!');
				redirect(base_url() . 'spares/list_labour/');
				}else{
				$this->session->set_flashdata('danger', 'Error! while updating labour for '.$item_name. '');
				redirect(base_url() . 'spares/list_labour/');
				}
			 
		
	}
	
	 
	
	public function update_allsparesrate(){
		
         $vehicle_make = $this->input->post('vehicle_make'); 
		
         $vehicle_model = $this->input->post('vehicle_model'); 
		
		 $sparesID = $this->input->post('modelitem'); 
		 $rates_id = $this->input->post('rates_id'); 
         $sparerates = $this->input->post('rate'); 
         $brand = $this->input->post('brand'); 
		 for ($i = 0; $i < count($rates_id); $i++) {  
            if (strlen($sparerates[$i]) > 0) {
			$data = array( 
				'rate' => $sparerates[$i], 
				'brand' => $brand[$i], 
            );
			  $where = array('id' => $rates_id[$i]);
			 $response =  $this->Main_model->update_record('spares_rate', $data, $where);
			}
		 }
		 
				if($response){
				$this->session->set_flashdata('success', 'Spares Rates for '. $sparesID. ' updated successfully..!');
				redirect(base_url() . 'spares/price_master/'.$vehicle_make.'/'.$vehicle_model);
				}else{
				$this->session->set_flashdata('danger', 'Error! while updating Spares Rates for '. $sparesID. '');
				redirect(base_url() . 'spares/price_master/'.$vehicle_make.'/'.$vehicle_model);
				}
			 
		
	}
	 
	 
	
	
	public function price_master(){
		 
		$data['makes'] = $this->Main_model->select('vehicle_make'); 
		if(!empty($this->uri->segment(3))){
			$data['selected_make'] = $this->uri->segment(3);
		}else{
			$data['selected_make'] = '';
		}
		if(!empty($this->uri->segment(4))){
		$data['selected_model'] = $this->uri->segment(4);
		}else{
			$data['selected_model'] = '';
		}
		// $data['category'] = $this->Main_model->select('category');
        $this->header();
        $this->load->view('spares/price_master', $data);
        $this->footer();
		
	}
	
	
	
	public function getItemByModel()
    {
		$data = [];
		 
		$vehicle_make =     $this->input->post('vehicle_make'); 
		$vehicle_model =     $this->input->post('vehicle_model');  
		$this->load->model('Main_model');
		 
		$records  = $this->db->query("SELECT model_code, vehicle_category FROM vehicle_model WHERE make_id='$vehicle_make' AND model_id = '$vehicle_model'");
		 $responses = $records->row();
		if(!empty($records->row())){ 
			
			$data['model_code']=$responses->model_code;
				$data['vehicle_category']=$responses->vehicle_category;
			
			$sparestable = $this->db->query("SELECT * FROM spares WHERE model_code='".$responses->model_code."' AND vehicle_category = '".$responses->vehicle_category."'");
			$spareslists = $sparestable->result();
			
			if(!empty($sparestable->result())){ 
			
			foreach ($spareslists as $spareslist){ 
			 $spareslistdata[] = array("id"=>$spareslist->item_code, "text"=>$spareslist->item_name);
		}
			}
			
			 
			
			if(!empty($spareslistdata)){ 
		$data['spares_list']  =	$spareslistdata;
			}else{
				$data['spares_list']  =	array("id"=>'', "text"=>'');
			}
		 
			
		}else{ 
		$data['spares_list']  =	array("id"=>'', "text"=>'');
		 
		}
		 echo json_encode($data);
		 
		// print_r($response);
    }
	
	 
	
	
    
}