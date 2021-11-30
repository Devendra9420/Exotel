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

class Leads_model extends CI_Model
{
		 
	 

    function index()
    {

    }
	
	public function get_leads($status=NULL){   
		$this->datatables->select('id as leads_id,name,mobile,city,created_on,source,service_category,desired_service_date,status,make,model');
      	$this->datatables->from('leads');
		$this->datatables->where('converted=0');   
      	$this->datatables->add_column('action', '<a href="javascript:updatelead($1);" class="btn btn-icon btn-primary" data-leads_id="$1"><i class="fas fa-edit"></i></a>','leads_id');  
		return $this->datatables->generate();  
	}
	
	public function count_leads($status=NULL, $col=NULL){
		 
		 return $this->Common->count_all_results('leads');
		 
	}
	 
	
    public function getleadslist()
    { 
        return $this->Common->select("leads", 'created_on ASC'); 
        return $query->result();
    }
	
	public function getlead($leads_id)
    {  
		$data = array();
		$data['leads'] = $this->Common->single_row('leads', array('id' =>  $leads_id));  
		$data['leads_estimate'] =  $this->Common->select_wher('leads_estimate', array('leads_id' =>  $leads_id));  
		$data['leads_lifecycle'] =  $this->Common->single_row('leads_lifecycle', array('leads_id' =>  $leads_id)); 
        return $data;
    }
	
	    
	public function auto_archive()
	{
		 $all60days = $this->Common->select_wher('leads','created_on  < now() - interval 60 DAY AND archived=0'); 
		if($all60days){ 
		foreach($all60days as $all60day){ 
			if(!empty($all60day->id)){ 
			$where = array('id' => $all60day->id);
			$lead_data = array(  
				'archived' => 1,   
            ); 
            $this->Common->update_record('leads', $lead_data, $where);
			}
		}
		}
	}
	
	public function add_leads_data($custom_data=NULL){
		
		extract($_POST); 
		  if(!empty($customer_id) && $customer_id>0){
			  $customer_id;
		  }
		if(!empty($service_category)){ 
		if($service_category=='Running Repairs'){
			$service_category = 'Repairs';
		}elseif($service_category=='Standard Service'){
			$service_category = 'Std Service';
		}elseif($service_category=='Accidental Repairs'){
			$service_category = 'Accidental Repairs';
		}else{
			$service_category = '';
		}
			}else{
			$service_category = '';
		}
		
			if(empty($email)) $email = '';
			if(empty($city)) $city = '';
			if(empty($area)) $area = '';
			
			
			if(empty($comments)) $comments = '';
		
			
			
			if(empty($service_date)) $service_date = date('d/m/Y');
			
		if(empty($source)){
						$source = 'Online';
					}
		if(empty($owner)){
						$owner = 'Website';
					}
		
		if(empty($selected_complaints)){ $selected_complaints=''; }
		
		$data = array( 
                'source' => $source, 
				'owner' => $owner,  
                'name' => $name, 
				'mobile' => $mobile,
				'email' => @$email,
				'city' => @$city, 
				'area' => @$area,
				'address' => @$address,
				'pincode' => @$pincode,
				'google_map' => @$google_map,
				'latitude' => @$latitude,
				'longitude' => @$longitude,
				'channel' => @$channel,
				'make' => @$make, 
				'model' => @$model,   
				'existing_customer' => @$customer_id,    
				'complaints' => @$selected_complaints, 
				'service_category' => @$service_category, 
				'desired_service_date' =>  @convert_date($service_date),  
				'comments' => @$comments, 
				'status' => 'Open', 
				'created_on' => created_on(), 
            );
		
		if(!empty($custom_data)){ foreach($custom_data as $key=>$val){ $data[$key] = $val; }  }
			
			
		if(!empty($this->input->post('specific_spares'))){  
			$all_spares = implode(',',$this->input->post('specific_spares'));
			$data['specific_spares'] = $all_spares;
		}
		
		if(!empty($this->input->post('specific_repairs'))){  
			$all_repairs = implode(',',$this->input->post('specific_repairs'));
			$data['specific_repairs'] = $all_repairs;
		}
             
            $response = $this->Common->add_record('leads', $data); 
			$leads_id = $this->db->insert_id();
			 
		 
		
			if(!$leads_id || $leads_id<1){
				return false;
			}else{
				return $leads_id;
			}
		
	}
	
	
	public function add_leads_estimate_details_data($new_leads_id, $site_lead_estimate=NULL){
		
		extract($_POST);  
		  
		if(empty($leads_id)){ $leads_id=$new_leads_id; }
		
		$Spares_List = '';
		$Labour_List = '';	
		$row = 0;

    if($site_lead_estimate){
		
		foreach($site_lead_estimate as $site_lead){ 
		
		$item_id = $site_lead['item_id'];
		$item_name = $site_lead['item_name'];
        $complaint_number = $site_lead['complaint_number'];
        $thiscomplaints = $site_lead['complaints'];
        $spares_rate = $site_lead['spares_rate'];
		$labour_rate = $site_lead['labour_rate'];
        $quantity = $site_lead['quantity'];
		$estimate_no = $site_lead['estimate_no'];
		$total_rate = $site_lead['total_rate']; 
        $item_type = $site_lead['item_type'];	 
		
		
		//for ($i = 0; $i < count($quantity); $i++) {
            extract($_POST);

            if (strlen($quantity) > 0) {
			$estimated_items = array(
                'leads_id' =>  $new_leads_id,
				//'estimate_id' => $estimate_id,
				'complaint_number' => $complaint_number,
				'complaints' => $thiscomplaints,
                'item_type' => $item_type,
                'item_id' => $item_id,
				'item' => $item_name,
                'qty' => $quantity,
                'amount' => $total_rate,
				'spares_rate' => $spares_rate,
				'labour_rate' => $labour_rate,
            );
				if($item_type == 'Spares'){ 
				 
				$Spares_List .= $item_name.' | ';		
				 
					
					
				}elseif($item_type == 'Labour'){ 
				  
				$Labour_List .= $item_name.' | ';		
				 
					
				}
				
			$response =    $this->Common->add_record('leads_estimate', $estimated_items);
			}
		 //}
			
		}
			
    }else{
		
		$item_id = $this->input->post('item_id');
		$item_name = $this->input->post('item_name');
        $complaint_number = $this->input->post('complaint_number');
        $complaints = $this->input->post('complaints');
        $spares_rate = $this->input->post('spares_rate');
		$labour_rate = $this->input->post('labour_rate');
        $quantity = $this->input->post('quantity');
		$estimate_no = $this->input->post('estimate_no');
		$total_rate = $this->input->post('total_rate'); 
        $item_type = $this->input->post('itemtype');	 
		
		
		for ($i = 0; $i < count($quantity); $i++) {
            extract($_POST);

            if (strlen($quantity[$i]) > 0) {
			$estimated_items = array(
                'leads_id' => $new_leads_id,
				//'estimate_id' => $estimate_id,
				'complaint_number' => $complaint_number[$i],
				'complaints' => $complaints[$i],
                'item_type' => $item_type[$i],
                'item_id' => $item_id[$i],
				'item' => $item_name[$i],
                'qty' => $quantity[$i],
                'amount' => $total_rate[$i],
				'spares_rate' => $spares_rate[$i],
				'labour_rate' => $labour_rate[$i],
            );
				if($item_type[$i] == 'Spares'){ 
				 
				$Spares_List .= $item_name[$i].' | ';		
				 
					
					
				}elseif($item_type[$i] == 'Labour'){ 
				  
				$Labour_List .= $item_name[$i].' | ';		
				 
					
				}
				
			$response =    $this->Common->add_record('leads_estimate', $estimated_items);
			}
		 }
    }
		// for ($i = 0; $i < count($quantity); $i++) {
//            extract($_POST);
//
//            if (strlen($quantity[$i]) > 0) {
//			$estimated_items = array(
//                'leads_id' => $$new_leads_id,
//				//'estimate_id' => $estimate_id,
//				'complaint_number' => $complaint_number[$i],
//				'complaints' => $complaints[$i],
//                'item_type' => $item_type[$i],
//                'item_id' => $item_id[$i],
//				'item' => $item_name[$i],
//                'qty' => $quantity[$i],
//                'amount' => $total_rate[$i],
//				'spares_rate' => $spares_rate[$i],
//				'labour_rate' => $labour_rate[$i],
//            );
//				if($item_type[$i] == 'Spares'){ 
//				 
//				$Spares_List .= $item_name[$i].' | ';		
//				 
//					
//					
//				}elseif($item_type[$i] == 'Labour'){ 
//				  
//				$Labour_List .= $item_name[$i].' | ';		
//				 
//					
//				}
//				
//			$response =    $this->Common->add_record('leads_estimate', $estimated_items);
//			}
//		 }
		
		$data['Spares_List'] = $Spares_List;
		$data['Labour_List'] = $Labour_List;
		
		if(!empty($Spares_List) && !empty($Labour_List)){ 
		$spares_labour_data = array(  
				'specific_spares' => $Spares_List,
				'specific_repairs' => $Labour_List,   
			);
		
		$where = array('id' => $leads_id);
		$this->Common->update_record('leads', $spares_labour_data, $where); 
		}
		
		if(!$response){
				return false;
			}else{
				return $data;
			}
			 
	}
	
	public function add_leads_lifecycle($leads_id){
		extract($_POST);
	$leadstatus  = $this->Common->single_row("leads_lifecycle", array('leads_id'=>$leads_id));
				
		if(empty($status))
		$status = 'Open';	
		if(empty($details))
		$details = '';	
		if(empty($due_date))
		$due_date = '';	
		if(empty($assigned_to))
		$assigned_to = created_by();
		
			$data = array(
                'leads_id' => $leads_id, 
				'action' => $status,  
                'details' => $details, 
				'due_date' => $due_date,
				'status' => $status, 
				'assigned_to' => $assigned_to,
				'created_by' => created_by(),
				'created_on' => created_on(), 
            );
		
		if(!empty($leadstatus->id)){ 
            $where = array('leads_id' => $leads_id);
        $response =    $this->Common->update_record('leads_lifecycle', $data, $where);
		}else{
		$response =	$this->Common->add_record('leads_lifecycle', $data);
		}
		
		if(!$response){
				return false;
			}else{
				return true;
			}
		
		
	}
	
	//FILE END
}

?>