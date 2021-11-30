<?php

class Spares_Model extends MY_Model 
{

      
	public function get_spares(){   
		$this->datatables->select('spares_id,item_code,item_name, vehicle_category,model_code,model,make');
      	$this->datatables->from('spares'); 
		return $this->datatables->generate();  
	}
	
	public function get_spares_data($spares_id){
			$spares_rate  = $this->Common->single_row('spares', array('spares_id'=>$spares_id));			
     		$data = [];	  
					$data['item_name']=$spares_rate->item_name;  
		return $data;
	}
	
	public function get_all_spares($search=NULL){ 
            $this->db->select();
        	$this->db->from('spares'); 
			if($search)
        	//$this->db->like(array('item_name'=>$search));
			$this->db->like(array('spares_id'=>$search)); 
			//$this->db->group_by('item_name'); 
		    $query = $this->db->get(); 
			if($query->num_rows() > 0) {  
				$result = $query->result();
				foreach($result as $spares){ 
					 
					
				$data[]=array("id"=>$spares->spares_id, "text"=>$spares->spares_id, "itemcode"=>$spares->item_code, "item_name"=>$spares->item_name, "model"=>$spares->model, "vehicle_category"=>$spares->vehicle_category);   
				}
				return $data;
			}else{
				false;  
			}
         
	}
	
	public function get_spares_id_rows($spares_id){ 
            $this->db->select();
        	$this->db->from('spares');  
			$this->db->where(array('spares_id'=>$spares_id));
		    $query = $this->db->get(); 
			if($query->num_rows() > 0) {  
				$result = $query->result();
				foreach($result as $spares){  
				$data[]=array("spared_id"=>$spares->spares_id, "item_name"=>$spares->item_name, "make"=>$spares->make, "model"=>$spares->model, "model_code"=>$spares->model_code, "vehicle_category"=>$spares->vehicle_category, "itemcode"=>$spares->item_code);   
				}
				return $data;
			}else{
				false;  
			}
         
	}
	
	
	public function add_spares(){ 
		extract($_POST);  
		$make = get_make($make_id);
		$model_all = get_model($model_id);
		
		$model_det = $this->Common->single_row('vehicle_model',array('model_id'=>$model_id, 'make_id'=>$make_id));
		
		$model = $model_det->model_name;
		$model_code = $model_det->model_code;
		$vehicle_category = $model_det->vehicle_category;
		
		$spares = $this->Common->single_row('spares', array('spares_id'=>$item_code.$model_code, 'model_code'=>$model_code, 'vehicle_category'=>$vehicle_category,'item_code'=>$item_code, 'item_name'=>$item_name)); 
		if(!empty($spares->id) && $spares->id>0){  
			$response['msg_type'] = 'warning';
			$response['msg'] = 'Spares '. $item_code.$model_code . ' already exists in the system!';
		 
		}else{  
		$existing_spares = $this->Common->count_all_results('spares', array('spares_id'=>$item_code.$model_code, 'item_name'=>$item_name, 'item_code'=>$item_code, 'model_code'=>$model_code, 'model'=>$model, 'vehicle_category'=>$vehicle_category, 'make'=>$make), 'id'); 
			if($existing_spares<1){ 
				
				$spare_data= array(  
				'spares_id' => $item_code.$model_code, 
			    'item_name' => $item_name,
			    'item_code' => $item_code, 
			    'model_code' => $model_code,
			    'model' => $model,  
			    'make' => $make, 
			    'vehicle_category' => $vehicle_category,	
						); 
				
				$this->add_to_bd($spare_data, 'spares');
				
			$data = array(  
				'spares_id' => $item_code.$model_code, 
			    'item_name' => $item_name,
			    'item_code' => $item_code, 
			    'model_code' => $model_code,
			    'model' => $model,  
			    'make' => $make, 
			    'vehicle_category' => $vehicle_category,	
						); 
			$response = $this->Common->add_record('spares', $data);
				
		 
			
				$response['msg_type'] = 'success';
			$response['msg'] = 'New Spares ('. $item_code.$model_code. ') added successfully..!';
				 
	 
			}else{
			$response['msg_type'] = 'warning';
			$response['msg'] = 'Spares '. $item_code.$model_code . ' already exists in the system!'; 
			}
		}
				
				if($response){
				return $response;
				}else{
				return false;	
				}  
	}
	 
	public function get_items(){   
		$this->datatables->select('item_code,item_name,hsn_no,gstn_rate,item_id');
      	$this->datatables->from('item');
		$this->datatables->add_column('action', '<a href="javascript:update_item($1)" class="btn btn-icon btn-primary" data-item_id="$1"><i class="fas fa-pen"></i> Update</a>','item_id'); 
		return $this->datatables->generate();  
	}
	
	public function get_items_data($item_id){
			$spares_rate  = $this->Common->single_row('item', array('item_id'=>$item_id));			
     		$data = [];	 
                    $data['item_id']=$spares_rate->item_id;
					$data['item_code']=$spares_rate->item_code;
					$data['item_name']=$spares_rate->item_name; 
					$data['hsn_no']=$spares_rate->hsn_no;
					$data['gstn_rate']=$spares_rate->gstn_rate;
		return $data;
	}
	
	public function update_item(){
		 
		 extract($_POST);    
		  
		$data = array(
				'item_code' => $item_code,
			   	'item_name'=>$item_name,
				'hsn_no'=>$hsn_no,
				'gstn_rate'=>$gstn_rate,
					); 
		 
        $where = array('item_id' => $item_id); 
        $response = $this->Common->update_record('item', $data, $where); 
		
		
		$this->update_to_bd($data,'item',$where); 
		
		
		$data = array( 
			   	'item_name'=>$item_name,
					); 
		 
        $where = array('item_code' => $item_code); 
        $response = $this->Common->update_record('spares', $data, $where); 
        $response = $this->Common->update_record('spares_rate', $data, $where); 
        $response = $this->Common->update_record('labour', $data, $where);
		
		 $this->update_to_bd($data,'spares',$where); 
		$this->update_to_bd($data,'spares_rate',$where); 
		$this->update_to_bd($data,'labour',$where); 
		
				if($response){
				return true; 
				}else{
				return false;
				}
			 
		
	}
	
	public function add_item(){ 
		extract($_POST);    
		$item = $this->Common->single_row('item', array('item_code'=>$item_code, 'item_name'=>$item_name), 'item_id'); 
		if(!empty($item->item_id) && $item->item_id>0){ 
			$response['msg_type'] = 'warning';
			$response['msg'] = 'Item '. $item_name . ' already exists in the system!';
		 
		}else{  
		$existing_item = $this->Common->count_all_results('item', array('item_code'=>$item_code, 'item_name'=>$item_name), 'item_id'); 
			if($existing_item<1){ 
			$data =  array(
				'item_code' => $item_code,
			   	'item_name'=>$item_name,
				'hsn_no'=>$hsn_no,
				'gstn_rate'=>$gstn_rate,	
						); 
			$response = $this->Common->add_record('item', $data);
		 
			  $this->add_to_bd($data,'item');
				 
				
			$response['msg_type'] = 'success';
			$response['msg'] = 'Item '. $item_name . ' successfully added';	
		 	
			}else{
			$response['msg_type'] = 'warning';
			$response['msg'] = 'Item '. $item_name . ' already exists in the system!';
			}
		}
				if($response){
				return $response;
				}else{
				return false;	
				}  
	}
	
	 
	
	public function get_spares_rate(){   
		$this->datatables->select('spares_id,item_name,brand,rate,id');
      	$this->datatables->from('spares_rate');
		$this->datatables->add_column('action', '<a href="javascript:update_rate($1)" class="btn btn-icon btn-primary" data-spare_rate_id="$1"><i class="fas fa-pen"></i> Update</a>','id'); 
		return $this->datatables->generate();  
	}
	
	public function get_spares_rate_data($rates_id){
			$spares_rate  = $this->Common->single_row('spares_rate', array('id'=>$rates_id));			
     		$data = [];	 
                    $data['id']=$spares_rate->id;
					$data['spares_id']=$spares_rate->spares_id;
					$data['item_name']=$spares_rate->item_name; 
					$data['brand']=$spares_rate->brand;
					$data['rate']=$spares_rate->rate;
		return $data;
	}
	
	public function update_spares_rate(){
		 
		 extract($_POST);    
		  
		$data = array(
				'brand'=>$brand,
				'rate' => $rate, 	
					); 
		 
        $where = array('id' => $id); 
        $response = $this->Common->update_record('spares_rate', $data, $where); 
	 	
		$this->update_to_bd($data,'spares_rate',$where);
		
				if($response){
				return true; 
				}else{
				return false;
				}
			 
		
	}
	
	public function add_spares_rate(){ 
		extract($_POST);    
		$spares_rate = $this->Common->single_row('spares_rate', array('spares_id'=>$spares_id, 'brand'=>'', 'rate'=>0), 'id'); 
		if(!empty($spares_rate->id) && $spares_rate->id>0){ 
		$data = array(  
				'spares_id' => $spares_id, 
			    'item_name' => $item_name, 
			  //  'model' => $model, 
			    'brand' => $brand, 
			    'rate' => $rate, 	
					); 
         $where = array('id' => $spares_rate->id);
         $response = $this->Common->update_record('spares_rate', $data, $where); 
		 	
			$this->update_to_bd($data,'spares_rate',$where);
			
			
		}else{  
		$existing_spares_rate = $this->Common->count_all_results('spares_rate', array('spares_id'=>$spares_id, 'brand'=>$brand), 'id'); 
			if($existing_spares_rate<1){ 
			$data = array(  
					'spares_id' => $spares_id, 
					'item_name' => $item_name, 
				//	'model' => $model, 
					'brand' => $brand, 
					'rate' => $rate, 	
						); 
			$response = $this->Common->add_record('spares_rate', $data);
		 	
				$this->add_to_bd($data, 'spares_rate');
				
			}else{
			$this->session->set_flashdata('warning', 'Spares Rate for '. $spares_id. ' already exists with the same brand..!');
			redirect(base_url() . 'index.php/spares/price_master/'.$vehicle_make.'/'.$vehicle_model);
			}
		}
				if($response){
				return true;
				}else{
				return false;	
				}  
	}
	  
	public function update_spares_map(){ 
		extract($_POST);  
		
		 
		$make = $this->input->post('make');
		$model = $this->input->post('model');
        $row_counter = $this->input->post('row_counter');	 
		$primary_spares_id =  $this->input->post('primary_spares_id');
		$primary_item_name =  $this->input->post('primary_item_name');
		$primary_item_code =  $this->input->post('primary_item_code');
		
		$row = 0;
		 for ($i = 0; $i < count($row_counter); $i++) {
             
 		$make_id = $make[$i];
		$model_id = $model[$i];
		$make_name = get_make($make[$i]);
		$model_all = get_model($model[$i]); 
		$model_det = $this->Common->single_row('vehicle_model',array('model_id'=>$model[$i], 'make_id'=>$make[$i])); 
		$model_name = $model_det->model_name;
		$model_code = $model_det->model_code;
		$vehicle_category = $model_det->vehicle_category;
		  
		$existing_spares = $this->Common->single_row('spares', array('item_name'=>$primary_item_name, 'model'=>$model_name, 'model_code'=>$model_code, 'vehicle_category'=>$vehicle_category,'item_code'=>$primary_item_code, 'make'=>$make_name, 'spares_id'=>$primary_spares_id));  
			 
		if(!empty($existing_spares->id) && $existing_spares->id>0){  
			$response['type'] = 'warning';
			$response['msg'] = 'Spares '. $primary_spares_id . ' for '.$model_name.'  already exists in the system!';
		 
		}else{  
		$existing_item = $this->Common->single_row('spares', array('item_name'=>$primary_item_name, 'item_code'=>$primary_item_code, 'model_code'=>$model_code, 'model'=>$model_name, 'vehicle_category'=>$vehicle_category, 'make'=>$make_name, 'spares_id!='=>$primary_spares_id));  
			if(!empty($existing_item->id)){ 
						
						$data = array(  
						'spares_id' => $primary_spares_id, 
						'item_name' => $primary_item_name,
						'item_code' => $primary_item_code, 
						'model_code' => $model_code,
						'model' => $model_name,  
						'make' => $make_name, 
						'vehicle_category' => $vehicle_category,	
						); 
								$where = array(
								'id' => $existing_item->id, 
								'item_name' => $primary_item_name,
								'item_code' => $primary_item_code, 
								'model_code' => $model_code,
								'model' => $model_name,  
								'make' => $make_name);
								$query = $this->Common->update_record('spares', $data, $where);  
						
						$this->update_to_bd($data,'spares',$where);
				
				
						$response['type'] = 'success';
						$response['msg'] = 'New Spares ('. $primary_spares_id. ') mapped successfully..!'; 	
		 				
			}else{
				$data = array(  
						'spares_id' => $primary_spares_id, 
						'item_name' => $primary_item_name,
						'item_code' => $primary_item_code, 
						'model_code' => $model_code,
						'model' => $model_name,  
						'make' => $make_name, 
						'vehicle_category' => $vehicle_category,	
										); 
							$query = $this->Common->add_record('spares', $data); 
				
						$this->add_to_bd($data, 'spares');
					
					
						$response['type'] = 'success';
						$response['msg'] = 'New Spares ('. $primary_spares_id. ') mapped successfully..!'; 
				
				
			}
				
			 
		}
				
				
				}
		 
		
		
				if($response){
				return $response;
				}else{
				return false;	
				}  
	}
	
	
	
	public function add_to_bd($data, $table){ 
		 
	//$ch = curl_init(); 
//    curl_setopt($ch, CURLOPT_URL, 'http://bikedost.co.in/flywheel/site/add_to_db');
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//    //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
//	$payload = json_encode(array("data" => $data, "table" => $table));	
//	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
//    curl_setopt($ch, CURLOPT_POST, 1); 
//    $headers = array();
//    $headers[] = 'Accept: application/json';
//    $headers[] = 'Content-Type: application/json';
//    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//    $data = curl_exec($ch);
//
//    if (empty($data) OR (curl_getinfo($ch, CURLINFO_HTTP_CODE != 200))) {
//       $data = FALSE;
//    } else {
//        //return json_decode($data, TRUE);
//		$data = json_decode($data, TRUE);
//    }
//    curl_close($ch); 
//		return json_decode($data, TRUE);
	}
	
	
	public function update_to_bd($data,$table,$where){
		 
	//$ch = curl_init(); 
//    curl_setopt($ch, CURLOPT_URL, 'http://bikedost.co.in/flywheel/site/update_to_bd');
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//    //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
//	$payload = json_encode(array("data" => $data, "table" => $table, "where" => $where));	
//	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
//    curl_setopt($ch, CURLOPT_POST, 1); 
//    $headers = array();
//    $headers[] = 'Accept: application/json';
//    $headers[] = 'Content-Type: application/json';
//    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//    $data = curl_exec($ch);
//
//    if (empty($data) OR (curl_getinfo($ch, CURLINFO_HTTP_CODE != 200))) {
//       $data = FALSE;
//    } else {
//        //return json_decode($data, TRUE);
//		$data = json_decode($data, TRUE);
//    }
//    curl_close($ch); 
//		
	}
	
	
	
}

?>