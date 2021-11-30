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

class Estimator_model extends CI_Model
{
		 
	 

    function index()
    {

    }
	
	     
	
	public function add_estimate_data(){
			
		extract($_POST);  
		   
		$status = 'Estimate Created';
		$stage = 'Estimate Created';
		$last_estimate_id = $this->Common->find_maxid('id', 'estimate');
		$new_estimate_id = ($last_estimate_id+1);    
		
	 
		$service_category_id = ''; 
		
			$estimate_data = array(
			'estimate_id' => $new_estimate_id, 
			'make' => $make,
			'model' => $model,	
			'city' => $city,
			'created_on' => created_on(),
			'updated_on' => updated_on(),
			'created_by' => created_by(),
			'status' => $status,
			'stage' => $stage,
			'remark' => $comments,
			'estimate_attempt' => 1,  
			);
	 
			$this->Common->add_record('estimate', $estimate_data);
		  	
			$estimate_id = $this->db->insert_id();
		
			if(!$estimate_id || $estimate_id<1){
				return false;
			}else{
				return $estimate_id;
			}
		
	}
	
	
	public function add_estimate_details_data($estimate_id){
		
		extract($_POST);  
		  
		$status = 'Estimate Created';
		$stage = 'Estimate Created'; 
		
		$item_id = $this->input->post('item_id');
		$item_name = $this->input->post('item_name');
        $complaint_number = $this->input->post('complaint_number');
        $complaints = $this->input->post('complaints');
        $spares_rate = $this->input->post('spares_rate');
		$labour_rate = $this->input->post('labour_rate');
        $quantity = $this->input->post('quantity');
        $brand = $this->input->post('brand');
		$estimate_no = $this->input->post('estimate_no');
		$total_rate = $this->input->post('total_rate'); 
        $item_type = $this->input->post('itemtype');			 
		 
		$Spares_List = '';
		$Labour_List = '';	
		$row = 0; 
		$no_of_items = 0;
		$AmountTotal = 0;
		 for ($i = 0; $i < count($complaints); $i++) {
            extract($_POST);

            if (strlen($quantity[$i]) > 0) {
		  
				if(!empty($brand[$i])){ $brand[$i] = ''; }
				
			 
			$estimate_items = array(
                'estimate_id' => $estimate_id, 
				'complaint_number' => $complaint_number[$i],
				'complaints' => $complaints[$i],
                'item_type' => $item_type[$i],
                'item_id' => $item_id[$i],
				'item' => $item_name[$i],
				'brand' => $brand[$i], 
                'qty' => $quantity[$i],
                'amount' => $total_rate[$i],
				'spares_rate' => $spares_rate[$i],
				'labour_rate' => $labour_rate[$i],
				'status' => 'Active', 
            );
				if($item_type[$i] == 'Spares'){ 
				$Spares_List .= $item_name[$i].'<br>';	
				}elseif($item_type[$i] == 'Labour'){ 
				$Labour_List .= $item_name[$i].'<br>';	
				}
				
				$AmountTotal += 	((float)$spares_rate[$i])+((float)$labour_rate[$i]);
			    $this->Common->add_record('estimate_details', $estimate_items);
				$no_of_items++;
				
				/////////////////////////////////////////////////// ADD JOBCARD DETAILS END
			}
		 }
		  
		
		$data['Spares_List'] = $Spares_List;
		$data['Labour_List'] = $Labour_List;
		
		$data = array(
                'no_of_items' => $no_of_items,  
            );
        $where = array('id' => $estimate_id);
        $this->Common->update_record('estimate', $data, $where);
		 
		
		if(!$response){
				return false;
			}else{
				return $data;
			}
		
	}
	
	
	 
	
	
	
	//FILE END
}

?>