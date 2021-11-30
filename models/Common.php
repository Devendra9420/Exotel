<?php

class Common extends MY_Model
{

     
    public function __construct()
    {
		 
        parent::__construct();
        
    }
 

	
    //// . SQL QUERIES
	
	
	function bps_table($table, $pr_key)
    {  
        $this->_table_name = $table;
        $this->_primary_key = $pr_key; 
	}
	
	

    
	//select
    public function select($table, $order=NULL)
    {
        $this->db->select();
        $this->db->from($table);
		if($order)
		$this->db->order_by($order);
        $query = $this->db->get();
		
		return ($query->num_rows() > 0) ? $query->result() : false; //result ['value']
		 

    }

    // add record
    function add_record($table, $array_data)
    {
        $this->db->insert($table, $array_data);
		$inserted_id = $this->db->insert_id();
        if (!empty($inserted_id))
            return $inserted_id;
        else
            return false;
    }

    //update record
    function update_record($table, $update, $id)
    {
		$this->db->select();
        $this->db->from($table); 
		$this->db->where($id);
        $query = $this->db->get();
		
		if ($query->num_rows() > 0){  
		 
        $this->db->where($id);
        $query = $this->db->update($table, $update);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
		}else{
		
		return $this->add_record($table, $update);	
			
		}
    }

    //delete record
    function delete_record($table, $field_name=NULL, $id=NULL, $where=NULL)
    {
		if($where){ 
        $query = $this->db->where($field_name, $id);
		}else{
		$query = $this->db->where($where); 
		}
		if(!empty($where) && !empty($id) && !empty($field_name)){ 
		$this->db->delete($table);
		}else{
			$query = NULL;
		}
		
        if ($query != NULL)
            return $query;
        else
            return false;
    }

	
	//select where
    function select_wher($table, $where = NULL, $order=NULL, $limit=NULL, $start=NULL)
    {

        $this->db->select('*');
        if ($where)
            $this->db->where($where);
		if($order)
		$this->db->order_by($order);
		if($limit)
		$this->db->limit($limit,$start);	
        $query = $this->db->get($table);
		return ($query->num_rows() > 0) ? $query->result() : false; //result ['value']
         
    }

    //single row array record
    function single_row_array($table, $where = NULL, $return = 's', $order=NULL)
    {
        $this->db->select('*');
        if ($where)
            $this->db->where($where);
		if($order)
		$this->db->order_by($order);
        $query = $this->db->get($table);
		
		return ($query->num_rows() > 0) ? $query->row_array() : false; //result array(key=>value)
        

    }
	
	 
	
	//single row record
    function single_row($table, $where = NULL, $select = NULL, $order=NULL)
    {
		if($select){ 
        $this->db->select($select);
		 }else{
		$this->db->select('*');	
		}
        if ($where)
        $this->db->where($where); 
		if($order)
		$this->db->order_by($order);
        $query = $this->db->get($table);
        if($select){ 
		$result = $query->row();
		return ($query->num_rows() > 0) ? $result->$select : false; 
		}else{
		return ($query->num_rows() > 0) ? $query->row() : false; //result ->value	
		}

    }
	
	
	//multiple table row record with single key value
    function data_multi_table_row($tables, $where = NULL, $return = NULL)
    {
		$data = array();
		$totaltable = count($tables);
		for ($i = 1; $i <= $totaltable; $i++) { 
		if($return[$i]){ 
        $this->db->select($return[$i]);
		 }else{
		$this->db->select('*');	
		}
        if ($where){
            $this->db->where($where); 
			$query[$i] = $this->db->get($tables[$i]);

			if($query[$i]->num_rows > 0){  
			$data[$tables[$i]] = $query[$i]->row(); //result ->value	
			}else{			
			$data[$tables[$i]] = '';	
			}   
		}else{
		$data[$tables[$i]] = '';	
		}
			
		}
		return $data;
		//echo json_encode($data);			
    }
	
	
    //fetch limited records
    public function fetch_limit_records($limit, $start, $tbl, $where=NULL, $order=NULL)
    { 
        $this->db->limit($limit, $start);
		if ($where)
         $this->db->where($where); 
		if($order)
		$this->db->order_by($order);
        $query = $this->db->get($tbl);
		  if ($query->num_rows() > 0) { 
            foreach ($query->result() as $row) { 
                $data[] = $row; 
            	} 
            return $data; //result array(key=>value)
          } 
        return false; 
    }

    
	
    // fetching records by single column
    public function fetch_bysinglecol($col, $tbl, $id, $order=NULL)
    {
        $where = array(
            $col => $id
        );
        $this->db->select()->from($tbl)->where($where);
		if($order)
		$this->db->order_by($order);
        $query = $this->db->get();
		return ($query->num_rows() > 0) ? $query->result() : false; //result ['value']
         
    }

    //Custom Query function
    public function fetch_CustomQuery($sql, $return=NULL)
    {
        $query = $this->db->query($sql);
		
		//return ($query->num_rows() > 0) ? $query->result() : false; //result ['value']
		
		if($query->num_rows() > 0){  
			if($return='row'){
				$data['result']=$query->row();  
				$data['result_count']=$query->num_rows();	
				 
			}elseif($return='array'){
				$data['result']=$query->result_array();  
				$data['result_count']=$query->num_rows();	
				 
			}else{
				$data['result']=$query->result();  
				$data['result_count']=$query->num_rows();	
				 
			}
			return $data;
		}else{
		return false;	
		}
        
    }

    //find max id
    public function find_maxid($col, $tbl, $where=NULL)
    { 
		$maxid = 0; 
		$this->db->select('MAX('.$col.') AS maxid');
		if($where)
		$this->db->where($where);		 
		$query = $this->db->get($tbl);
		if($query->num_rows() > 0){
		 $result = $query->row();
		}else{
		 $result =false; 
		} 
		if ($result) {
    	$maxid = $result->maxid; 
		} 
        return $maxid; //numberic (0 or value)

    }
	
	  
 
	// count all result
     public function count_all($tbl)
    {
		 
        return $this->db->count_all($tbl); //numberic (0 or value)
    }
	
	
	// count all result with where
	function count_all_results($table_name, $where=NULL, $column_name=NULL)
	{  
		
		
		if(!empty($column_name)){  
		$this->db->select($column_name);
		}else{
		$this->db->select();
		}
		
		$this->db->from($table_name);
		if(!empty($where))
        {
            $this->db->where($where);
        }
		 
		$query =  $this->db->count_all_results();	 
		 
		
		return (!empty($query)) ? $query : 0; //numberic (0 or value)
     	 
	}	
	
	// count all result with where
	function sum_results($table_name, $where=NULL, $column_name=NULL)
	{  
		
		
		 $this->db->select('SUM('.$column_name.') AS sumtotal');
		 $this->db->from($table_name);
			if(!empty($where))
			{
				$this->db->where($where);
			} 
		$query = $this->db->get();
		$result = $query->row(); 
		return ($query->num_rows() > 0) ? $result->sumtotal : 0; //result ['value'] 
     	 
	}	
	
	
	//select where LIKE (Wildcard)
    function select_like($table, $col, $value, $wildcard=NULL, $order=NULL)
    {
		 
        $this->db->select('*');
		$this->db->from($table);
		if($array){ 
		$this->db->like($array);
		}
		if($wildcard){
		$this->db->like($col, $value, $wildcard);	// BEFORE: '%VALUE' OR AFTER 'VALUE%'
		}else{ 
		$this->db->like($col, $value);
		}
		if($order)
		$this->db->order_by($order);
		$query = $this->db->get();

		return ($query->num_rows() > 0) ? $query->result() : false; //result ['value']
         
    }
	
	
	//select where LIKE array (WHERE col LIKE ?? & col2 LIKE ??)
    function select_like_array($table, $col, $value, $array=NULL, $order=NULL)
    {
		 
        $this->db->select('*');
		$this->db->from($table);
		if($array){ 
		$this->db->like($array);
		}else{ 
		$this->db->like($col, $value);
		}
		if($order)
		$this->db->order_by($order);
		$query = $this->db->get();

		return ($query->num_rows() > 0) ? $query->result() : false; //result ['value']
         
    }
	
	
	//select where LIKE array (WHERE col LIKE ?? OR col2 LIKE ??)
    function get_like_or($table, $col, $value, $col2=NULL, $value2=NULL, $col3=NULL, $value3=NULL, $order=NULL)
    {
		 
        $this->db->select('*');
		$this->db->from($table); 
		$this->db->like($col, $value);
		if(!empty($col2)){ 
		$this->db->or_like($col2, $value2);
		}
		if(!empty($col3)){ 
		$this->db->or_like($col3, $value3);
		}
		if($order)
		$this->db->order_by($order);
		$query = $this->db->get();
		return ($query->num_rows() > 0) ? $query->result() : false; //result ['value']
         
    }
	
	
	//select where LIKE array (WHERE col LIKE ?? OR col2 LIKE ??)
    function get_like_or_not($table, $col=NULL, $value=NULL, $col2=NULL, $value2, $col3=NULL, $value3, $order=NULL)
    {
		 
        $this->db->select('*');
		$this->db->from($table);
		if(!empty($col)){ 
		$this->db->like($col, $value);
		}
		if(!empty($col2)){ 
		$this->db->not_like($col, $value);
		}
		if(!empty($col3)){ 
		$this->db->or_not_like($col, $value);
		}
		if($order)
		$this->db->order_by($order);
		$query = $this->db->get();
		return ($query->num_rows() > 0) ? $query->result() : false; //result ['value']
         
    }
    
   //single row record
    function select_join($tbl1, $tbl2, $where = NULL, $select = NULL, $jointo, $joincondition='INNER', $single=NULL, $multijoin=NULL, $order=NULL)
    {
		
		if($select){ 
        $this->db->select($select);
		 }else{
		$this->db->select('*.'.$tbl1);	
		}
		$this->db->from($tbl1); 
        if ($where)
            $this->db->where($where); 
		$this->db->join($tbl2, $jointo, $joincondition);
		if(!empty($multijoin)){
			foreach($multijoin as $key=>$jointbl){
		$this->db->join($key,$jointbl, $joincondition);		
			}
		}
			
		if($order)
		$this->db->order_by($order);
		
        $query = $this->db->get();
        
		if($single){ 
		return ($query->num_rows() > 0) ? $query->row() : false; //result ['value']
		}else{
		return ($query->num_rows() > 0) ? $query->result() : false; //result ['value']	
		}

    }
	
	function users_dropdown($search=NULL)
        { 
            
            $this->db->select();
        	$this->db->from('users'); 
			if($search)
        	$this->db->like(array('firstname'=>$search));
        	$this->db->or_like(array('mobile'=>$search));
			$this->db->where(array('is_active'=>1,'is_admin'=>0));
		    $query = $this->db->get(); 
			if($query->num_rows() > 0) { 
				 
				$result = $query->result();
				foreach($result as $user){ 
				$data[]=array("id"=>$user->id, "text"=>$user->firstname);   
				}
				return $data;
			}else{
				false;  
			}
        }
	
	function service_providers_dropdown($search=NULL)
        { 
            
            $this->db->select();
        	$this->db->from('service_providers'); 
			if($search)
        	$this->db->like(array('name'=>$search,'mobile'=>$search));
			$this->db->where(array('is_active'=>1));
		    $query = $this->db->get(); 
			if($query->num_rows() > 0) { 
				 
				$result = $query->result();
				foreach($result as $service_provider){ 
				$data[]=array("id"=>$service_provider->id, "text"=>$service_provider->name);   
				}
				return $data;
			}else{
				false;  
			}
        }
	
	
	function channel_dropdown($search=NULL)
        { 
            
            $this->db->select();
        	$this->db->from('channel'); 
			if($search)
        	$this->db->like(array('channelname'=>$search));
		    $query = $this->db->get(); 
			if($query->num_rows() > 0) { 
				 
				$result = $query->result();
				foreach($result as $channel){ 
				if($channel->channelname!="Retail"){ 
				$data[]=array("id"=>$channel->channelname, "text"=>$channel->channelname);   
					} 
				}
				return $data;
			}else{
				false;  
			}
        }
	
	
	function city_dropdown($search=NULL,$limit=100,$start=0)
        { 
            
            $this->db->select();
        	$this->db->from('cities');
			$this->db->where(array('active'=>1));
			if($search)
        	$this->db->like(array('name'=>$search));
			$this->db->limit($limit,$start);
		    $query = $this->db->get(); 
			if($query->num_rows() > 0) { 
				 
				$result = $query->result();
				foreach($result as $city){ 
				$data[]=array("id"=>$city->name, "text"=>$city->name);   
				}
				return $data;
			}else{
				false;  
			}
        }
	
	  function area_dropdown($city=NULL, $search=NULL, $service_category=NULL, $limit=100,$start=0)
        { 
             
            $this->db->select();
        	$this->db->from('area');
			$this->db->where(array('active'=>1));
			if($city)
        	$this->db->where(array('city'=>$city));
		    if($search)
        	$this->db->like(array('area'=>$search));
			$this->db->limit($limit,$start);
		    $query = $this->db->get(); 
			if($query->num_rows() > 0) {  
				$result = $query->result();
				foreach($result as $area){
					
					
					$show = 1;
					
					if($service_category){ 
					
						 
						if($city){  
						$wherer = 'area_id='.$area->id.' and city="'.$city.'"';		
						}else{ 
						$wherer = 'area_id="'.$area->id.'"';
						}
					 
						$q2 = $this->db->query('select `'.$service_category.'` as allowed from zone_mapping where '.$wherer)->row();
						if($q2 && $q2->allowed=='Y'){  
						$show = 1;	  
						}else{
						$show = 0;	
						}
					}
					
					if($show==1){  
					$data[]=array("id"=>$area->area, "text"=>$area->area, "pincode"=>$area->pincode, "zone"=>$area->zone);   	  
					}
					
				}
				return $data;
			}else{
				false;  
			}
        }
	
	
	function make_dropdown($search=NULL,$limit=100,$start=0)
        { 
            
            $this->db->select();
        	$this->db->from('vehicle_make');
			$this->db->where(array('active'=>1));
			if($search)
        	$this->db->like(array('make_name'=>$search));
			$this->db->limit($limit,$start);
		    $query = $this->db->get(); 
			if($query->num_rows() > 0) { 
				 
				$result = $query->result();
				foreach($result as $city){ 
				$data[]=array("id"=>$city->make_id, "text"=>$city->make_name);   
				}
				return $data;
			}else{
				false;  
			}
        }
	
	
	 function model_dropdown($make_id=NULL, $search=NULL,$limit=100,$start=0)
        { 
            
            $this->db->select();
        	$this->db->from('vehicle_model'); 
        	$this->db->where(array('active'=>1));
			if($make_id)
        	$this->db->where(array('make_id'=>$make_id));
		    if($search)
        	$this->db->like(array('model_name'=>$search));
			$this->db->limit($limit,$start);
		    $query = $this->db->get(); 
			if($query->num_rows() > 0) {  
				$result = $query->result();
				foreach($result as $model){
				$data[]=array("id"=>$model->model_id, "text"=>$model->model_name, "modelcode"=>$model->model_code, "vehiclecategory"=>$model->vehicle_category);   	  
				}
				return $data; 
			}else{
				false;  
			}
        }
	
	
	function service_category_dropdown($vehicle_category=NULL, $city=NULL, $area=NULL, $search=NULL)
        { 
		
            $city_slug = make_slug($city); 
            $this->db->select('service_category.id as serviceID, service_category.service_name as servicename, service_category.'.$city_slug.' as rates');
        	$this->db->from('service_category'); 
        	$this->db->where(array('active'=>1));
			if($vehicle_category)
        	$this->db->where(array('vehicle_category'=>$vehicle_category));
		    if($search)
        	$this->db->like(array('service_name'=>$search));
		    $query = $this->db->get(); 
		
			 
		
			if($query->num_rows() > 0) {  
				$result = $query->result();
				
				foreach($result as $service){
					
					if($area){ 
					$area_id = $this->single_row('area', array('area'=>$area), 'id');	
					$wherer = 'area_id='.$area_id.' and city="'.$city.'"';	
					}else{ 
					$wherer = 'city="'.$city.'"';	
					}
					 
					$q2 = $this->db->query('select `'.$service->servicename.'` as allowed from zone_mapping where '.$wherer)->row();
					if($q2 && $q2->allowed=='Y'){ 
        			$data[]=array("id"=>$service->serviceID, "text"=>$service->servicename, "category_rates"=>$service->rates);   	  
					}
				}
				return $data; 
			}else{
				false;  
			}
        }
	
	function timeslot_dropdown($search=NULL)
        { 
            
            $this->db->select();
        	$this->db->from('timeslot'); 
			if($search)
        	$this->db->like(array('slot'=>$search));
		    $query = $this->db->get(); 
			if($query->num_rows() > 0) { 
				 
				$result = $query->result();
				foreach($result as $slot){ 
				$data[]=array("id"=>$slot->slot, "text"=>$slot->slot);   
				}
				return $data;
			}else{
				false;  
			}
        }
	
	function items_dropdown($search=NULL,$limit=100,$start=0)
        {  
            $this->db->select();
        	$this->db->from('item'); 
			if($search)
        	$this->db->like(array('item_name'=>$search));
			$this->db->limit($limit,$start);
		    $query = $this->db->get(); 
			if($query->num_rows() > 0) {  
				$result = $query->result();
				foreach($result as $item){ 
				$data[]=array("id"=>$item->item_code, "text"=>$item->item_name, "itemname"=>$item->item_name);   
				}
				return $data;
			}else{
				false;  
			}
        }
	
	
	function spares_dropdown($vehicle_category=NULL, $model_code=NULL, $search=NULL, $channel=NULL, $city=NULL, $reason=NULL,$limit=100,$start=0)
        { 
		 
            $city_slug = make_slug($city); 
            $this->db->select();
        	$this->db->from('spares'); 
			if($model_code)
        	$this->db->where(array('model_code'=>$model_code));
			//if($vehicle_category)
        	//$this->db->where(array('vehicle_category'=>$vehicle_category));
		    			if(!empty($reason)){
			if($search)
        	$this->db->where(array('item_code'=>$search));
					   }else{
			if($search)
        	$this->db->like(array('item_name'=>$search));	
						} 
			$this->db->limit($limit,$start);
		    $query = $this->db->get();  
			if($query->num_rows() > 0) {  
				$result = $query->result(); 
				foreach($result as $spare){  
					
				$spares_rate = $this->find_maxid('rate', 'spares_rate', array('spares_id'=>$spare->spares_id));
				$spares_labour_rate = $this->single_row('labour', array('type'=>'SL', 'vehicle_category'=>$vehicle_category, 'item_code'=>$spare->item_code));
				
				
					
					 
					
					
					if(empty($spares_rate)){
						$sparesrate = 0;
					}else{   
						//$checkDiscount = $this->single_row('discount', array('service'=>'Spares', 'criteria'=>$channel, 'active'=>'active'));
//						
//						if(!empty($checkDiscount->amount) && !empty($checkDiscount->type)){
//							if($checkDiscount->type=='slab'){
//							$sparesrate = $spares_rate-$checkDiscount->amount;	
//							}elseif($checkDiscount->type=='flat'){
//							$sparesrate = $checkDiscount->amount;	
//							}elseif($checkDiscount->type=='percentage'){
//							 $sparesrate = $spares_rate - ($spares_rate * ($checkDiscount->amount / 100));
//							}else{ 
//							$sparesrate = $spares_rate;
//							}
//						}else{ 
//						$sparesrate = $spares_rate;
//						}
						$sparesrate = $spares_rate;
					}
					 
					if(!empty($spares_labour_rate->$city_slug)){ 
					$spares_cost = $sparesrate+$spares_labour_rate->$city_slug;
					$spares_labour_rate_city  = $spares_labour_rate->$city_slug;
						}else{
					$spares_cost = $sparesrate;	
					$spares_labour_rate_city  = 0;	
					}
					
					$getallbrands =  $this->select_wher('spares_rate', array('spares_id'=>$spare->spares_id));
					$brandslist = [];
					$brandslist[] ="<option value='0'>None</option>";
						if($getallbrands)
						foreach($getallbrands as $getallbrand){
							if(!empty($getallbrand->brand)){ 
							$brandslist[]  = "<option value='".$getallbrand->id."'>".$getallbrand->brand."</option>";
							}
						}
					
					
        $data[]=array("id"=>$spare->spares_id, "text"=>$spare->item_name, "itemtype"=>'Spare', "sparesrates"=>$sparesrate, "labourrates"=>$spares_labour_rate_city, "totalrates"=>$spares_cost, "sparesid"=>$spare->spares_id, "itemid"=>$spare->spares_id, "itemcode"=>$spare->item_code, "itemname"=>$spare->item_name, "brand"=>$brandslist); 
				}
				return $data; 
			}else{
				false;  
			}
        }
	
	function spares_brand_dropdown($sparesid, $search=NULL,$limit=100,$start=0)
		{
		  
            $this->db->select();
        	$this->db->from('spares_rate');  
			$this->db->where(array('spares_id'=>$sparesid)); 
			if($search)
        	$this->db->where(array('brand'=>$search)); 
			$this->db->limit($limit,$start);
		    $query = $this->db->get();  
			if($query->num_rows() > 0) {  
				$result = $query->result(); 
				foreach($result as $brand){  
        	$data[]=array("id"=>$brand->brand, "text"=>$brand->brand, "brand_rate"=>$brand->rate); 
				}
				return $data; 
			}else{
				false;  
			}
		}
	
	
	function labour_dropdown($vehicle_category=NULL, $model_code=NULL, $city=NULL, $search=NULL, $reason=NULL,$limit=100,$start=0)
        {  
            $city_slug = make_slug($city); 
            $this->db->select();
        	$this->db->from('labour');  
			$this->db->where(array('type'=>'LL'));
			if($vehicle_category)
        	$this->db->where(array('vehicle_category'=>$vehicle_category));
		    			if(!empty($reason)){
			if($search)
        	$this->db->where(array('item_code'=>$search));
					   }else{
			if($search)
        	$this->db->like(array('item_name'=>$search));	
						}
			$this->db->limit($limit,$start);
		    $query = $this->db->get();  
			if($query->num_rows() > 0) {  
				$result = $query->result(); 
				foreach($result as $labour){  
					$labour_rate = $labour->$city_slug;
        $data[]=array("id"=>$labour->item_code, "text"=>$labour->item_name, "itemtype"=>'Labour', "sparesrates"=>0, "labourrates"=>$labour_rate, "totalrates"=>$labour_rate, "sparesid"=>'', "itemid"=>$labour->item_code,"itemcode"=>$labour->item_code, "itemname"=>$labour->item_name); 
				}
				return $data; 
			}else{
				false;  
			}
        }
	
	function complaints_dropdown($search=NULL,$limit=100,$start=0)
        { 
		    $this->db->select();
        	$this->db->from('complaints'); 
			if($search)
        	$this->db->like(array('complaints'=>$search));
			$this->db->limit($limit,$start);
		    $query = $this->db->get(); 
			if($query->num_rows() > 0) { 
				 
				$result = $query->result();
				foreach($result as $complaint){ 
				$data[]=array("id"=>$complaint->id, "text"=>$complaint->complaints);   
				}
				return $data;
			}else{
				false;  
			}
        }
	
	public function complaint_options($complaint, $vehicle_category, $model_code, $channel, $city, $complaints_counter)
	{
		 
		$complaint_data = array();
		 
		 
		
		$get_options  = $this->single_row('complaints', array('id' => $complaint));
		 
		$option_list = array($get_options->option1, $get_options->option2, $get_options->option3, $get_options->option4, $get_options->option5, $get_options->option6);
		
		$options = 1;
		 foreach ($option_list as $option) { 
		
		 
		 
		if($option!='NA' && $option!='N' && !empty($option)){
		
		$spares = $this->spares_dropdown($vehicle_category, $model_code, $option, $channel, $city, 'complaint');
		
		if(!empty($spares[0])){ 	
		$spare = $spares[0]; 
		 if(!empty($spare['itemcode'])){ 
			 
			$complaint_data[] = array("options"=>"Option ".$options, "count"=>$complaints_counter, "itemcode"=>$spare['itemcode'], "itemid"=>$spare['itemid'], "itemname"=>$spare['itemname'], "quantity"=>'1', "sparesrates"=>$spare['sparesrates'], "labourrates"=>$spare['labourrates'], "totalrates"=>$spare['totalrates'], "sparesid"=>$spare['sparesid'], "brandlist"=>$spare['brand'], "complaints"=>$get_options->complaints);
			 
		 }
		}
			
		 $labours = $this->labour_dropdown($vehicle_category, $model_code, $city, $option, 'complaint'); 
		if(!empty($labours[0])){ 	
		$labour = $labours[0];	
		 if(!empty($labour['itemcode'])){ 
			 
			$complaint_data[] = array("options"=>"Option ".$options, "count"=>$complaints_counter, "itemcode"=>$labour['itemcode'], "itemid"=>$labour['itemcode'], "itemname"=>$labour['itemname'], "quantity"=>'1', "sparesrates"=>$labour['sparesrates'], "labourrates"=>$labour['labourrates'], "totalrates"=>$labour['totalrates'], "sparesid"=>'', "brandlist"=>"<option selected value=''>NA</option>", "complaints"=>$get_options->complaints);
			 
		 }
		}
			$options++;
		     
			} 
		
		  }
		 
		return $complaint_data;
		
	}
	
	public function get_booking_by_key($keySet,$valueVal)
    {  
		$data = array();
		$data['booking']  = $this->single_row('bookings', array($keySet =>  $valueVal), FALSE, 'service_date desc'); 
		if(!empty($data['booking']->booking_id)){ 
		$booking_id = $data['booking']->booking_id;
        $data['booking_details'] =  $this->select_wher('booking_details', array('booking_id' =>  $booking_id));
		$data['booking_estimate'] =  $this->single_row('booking_estimate', array('booking_id' =>  $booking_id)); 
        $data['estimate_details'] =  $this->select_wher('booking_estimate_details', array('booking_id' =>  $booking_id), FALSE, 'id DESC');
		$data['jobcard'] =  $this->single_row('jobcard', array('booking_id' =>  $booking_id)); 
		$data['jobcard_details'] =  $this->select_wher('jobcard_details', array('booking_id' =>  $booking_id, 'status'=>'Active'));
		$data['jobcard_rejected_details'] =  $this->select_wher('jobcard_details', array('booking_id' =>  $booking_id, 'status'=>'Inactive'));
		$data['booking_payments'] =  $this->single_row('booking_payments', array('booking_id' =>  $booking_id));
		$data['booking_notes'] =  $this->select_wher('booking_notes', array('booking_id' =>  $booking_id));
		$data['booking_track'] =  $this->select_wher('booking_track', array('booking_id' =>  $booking_id));
		$data['booking_service'] =  $this->single_row('booking_services', array('booking_id' =>  $booking_id));
		$data['booking_service_track'] =  $this->select_wher('booking_service_track', array('booking_id' =>  $booking_id)); 
        return $data;
		}else{
		return false;
		}
    }
//GENERAL MODEL END
}


?>

