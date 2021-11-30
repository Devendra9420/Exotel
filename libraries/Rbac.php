<?php
class RBAC 
{	
	private $module_access;
	private $sub_module_access;
	
	public $createPermission; 
    public $updatePermission; 
    public $readPermission; 
    public $deletePermission;
	
	public $createPermission_custom; 
    public $updatePermission_custom; 
    public $readPermission_custom; 
    public $deletePermission_custom;
	
	
	function __construct()
	{
		$this->obj =& get_instance();
		$this->obj->module_access = $this->obj->session->userdata('module_access');
		$this->obj->sub_module_access = $this->obj->session->userdata('sub_module_access');
		$this->obj->is_admin = $this->obj->session->userdata('is_admin');
	}

	//---------------------------------------------------------------- STORE ALL ACCESS DATA TO SESSION
	function set_access_in_session()
	{
		$this->obj->db->from('module_access');
		$this->obj->db->where('user_type',$this->obj->session->userdata('user_type'));
		$this->obj->db->where('department',$this->obj->session->userdata('department'));
		$query=$this->obj->db->get();
		$data=array();
		$sub_data=array();
		foreach($query->result_array() as $v)
		{
			$data[$v['module']][$v['operation']] = '';
			
				$this->obj->db->from('sub_module_access');
			$this->obj->db->where('module',$v['module']);
			$this->obj->db->where('user_type',$this->obj->session->userdata('user_type'));
			$this->obj->db->where('department',$this->obj->session->userdata('department')); 
			$query=$this->obj->db->get();
			
			foreach($query->result_array() as $vv)
			{
				$break_ops = explode('|',$vv['operation']);
				foreach($break_ops as $ops){ 
				$sub_data[$v['module']][$vv['sub_module']][$ops] = '';
				}

			}
			

		}
		
		$this->obj->session->set_userdata('module_access',$data);
		$this->obj->session->set_userdata('sub_module_access',$sub_data);
		
		//foreach($this->obj->session->userdata('module_access') as $module=>$operations){ 
//		$this->obj->db->from('sub_module_access');
//		$this->obj->db->where('module',$module);
//		$this->obj->db->where('user_type',$this->obj->session->userdata('user_type'));
//		$this->obj->db->where('department',$this->obj->session->userdata('department')); 
//		$query=$this->obj->db->get();
//		$sub_data=array();
//		foreach($query->result_array() as $vv)
//		{
//			$break_ops = explode('|',$vv['operation']);
//			foreach($break_ops as $ops){ 
//			$sub_data[$vv['module']][$vv['sub_module']][$ops] = '';
//			}
//			
//		}
//		$this->obj->session->set_userdata('sub_module_access',$sub_data);	
//		}
		
	}

	
	//--------------------------------------------------------------	TO CHECK IF THIS MODULE IS ALLOWED
	function check_module_access()
	{
		if($this->obj->is_admin){
			return 1;
		}
		elseif(!$this->check_module_permission($this->obj->uri->segment(1))) //sending controller name // FUNCTION CALL TO CHECK THE SESSIONS
		{
			$back_to = $_SERVER['REQUEST_URI'];
			$back_to =  encode($back_to);
			redirect('access_denied/index/'.$back_to);
		}
	}
	
	
	

	//--------------------------------------------------------------	FUNCTION CALL TO CHECK THE SESSIONS
	function check_module_permission($module) // $module is controller name
	{
		$access = false;
		
		if($this->obj->is_admin)
			return true;
		elseif(isset($this->obj->module_access[$module])){
			foreach($this->obj->module_access[$module] as $key => $value)
			{
			  if($key == 'access') {
			  	$access = true;
			  }
			}

			if($access)
				return 1;
			else 
			 	return 0;
		}
	}
	
	//--------------------------------------------------------------	CHECK IF THERE A ACTION UNDER MODULE IS ALLOWED
	function check_operation_access($action=1, $custom_btn=NULL, $class=NULL, $datavariable=NULL)
	{
		if($action==1){
			$action = $this->obj->uri->segment(2);
		}
		if($this->obj->is_admin){ 
			$this->Set_action_operations_buttons('all', $custom_btn, $class, $datavariable);
			return 1;
		}
		elseif(!$this->check_operation_permission($action)) // CALL TO FUNCTION TO CHECK THE IF THIS ACTION IS ALLOWED FOR THIS MODULE
		{
			 
			$back_to =$_SERVER['REQUEST_URI'];
			$back_to = $this->obj->functions->encode($back_to);
			redirect('access_denied/index/'.$back_to);
		}
	}
	
	//--------------------------------------------------------------	
	function check_operation_permission($operation, $custom_btn=NULL, $class=NULL, $datavariable=NULL) //  FUNCTION TO CHECK THE IF THIS ACTION IS ALLOWED FOR THIS MODULE
	{

		if(isset($this->obj->module_access[$this->obj->uri->segment(1)][$operation])){ 
			$this->Set_action_operations_buttons($operation, $custom_btn, $class, $datavariable);
			return 1; 
		}
		else{ 
			 
		 	return 0;	
		}
		
	}
	
	
	//--------------------------------------------------------------		TO CHECK IF THIS SUBMODULE UNDER THE MODULE IS ALLOWED
	function check_sub_module_access()
	{
		if($this->obj->is_admin){
			return 1;
		}
		elseif(!$this->check_sub_module_permission($this->obj->uri->segment(1), $this->obj->uri->segment(2))) //sending controller name & submodule name // FUNCTION CALL TO CHECK THE SESSIONS
		{
			$back_to = $_SERVER['HTTP_REFERER'];
			//$back_to = encode($back_to);
			redirect('access_denied/index/'.$back_to);
			return 0;
		}else{
			return 1;
		}
	}
	
	
	//--------------------------------------------------------------	
	function check_sub_module_permission($module, $sub_module, $operation=NULL) // $module is controller name $submodule is submodule // FUNCTION TO CHECK ACCESS TO A SPECIFIC OPERATION IN SUB MODULE
	{
		$access = false;
		
		if($this->obj->is_admin)
			return true;
		elseif(isset($this->obj->sub_module_access[$module][$sub_module])){
				if($operation){
				if(isset($this->obj->sub_module_access[$module][$sub_module][$operation])){ 
				$access = true;
				}	
			}else{ 
				foreach($this->obj->sub_module_access[$module][$sub_module] as $key => $value)
				{
				  if($key == 'access') {
					$access = true;
				  }
				}
			}
			if($access)
				return 1;
			else 
			 	return 0;
		}
	}
	

	 
	
	//--------------------------------------------------------------	CHECK IF THERE A ACTION UNDER SUB_MODULE OF MODULE IS ALLOWED
	function check_sub_button_access($module=NULL, $sub_module=NULL, $getall=FALSE, $action=1, $custom_btn=NULL, $class=NULL, $datavariable=NULL)
	{
		if(!$module)
			$module = $this->obj->uri->segment(1);
		if(!$sub_module)
			$sub_module = $this->obj->uri->segment(2);
		if($this->obj->is_admin){
			$this->Set_action_operations_buttons('all', $custom_btn, $class, $datavariable);
			return 1;
		}
		elseif(!$this->check_sub_button_permission($module, $sub_module, $getall, $action, $custom_btn, $class, $datavariable)) // CALL TO FUNCTION TO CHECK THE IF THIS ACTION IS ALLOWED FOR THIS SUB_MODULE UNDER MODULE
		{
			 $back_to =$_SERVER['REQUEST_URI'];
			$back_to = encode($back_to);
			//redirect('access_denied/index/'.$back_to);
		}
	}
	
	
	
	
	//--------------------------------------------------------------	// CALL TO FUNCTION TO CHECK THE IF THIS ACTION IS ALLOWED FOR THIS SUB_MODULE UNDER MODULE
	function check_sub_button_permission($module=NULL, $sub_module=NULL, $getall=FALSE, $operations=array(), $custom_btn=NULL, $class=NULL, $datavariable=NULL)
	{   
		if($this->obj->is_admin){
			$this->Set_action_operations_buttons('all', $custom_btn, $class, $datavariable);
			return 1;
		}else{ 
			if(!$module)
				$module = $this->obj->uri->segment(1);
			if(!$sub_module)
				$sub_module = $this->obj->uri->segment(2);
			if($getall){
				 foreach($this->obj->sub_module_access[$module][$sub_module] as $key => $value){ 
					if(isset($this->obj->sub_module_access[$module][$sub_module][$key])){
					 $this->Set_action_operations_buttons($key, $custom_btn, $class, $datavariable); 
					}
				 }
				 return 1;
			}elseif(!empty($operations)){  
				foreach($operations as $operation){ 	
					if(isset($this->obj->sub_module_access[$module][$sub_module][$operation])){ 
					$this->Set_action_operations_buttons($operation, $custom_btn, $class, $datavariable); 
					} 
				}
				return 1;
			}else{
				return 0;
			}
		}
	}
	
	
	function Set_action_operations_buttons($operations=0, $custom_btn=NULL, $class=NULL, $datavariable=NULL){
		
		if($operations!==0){   
			if($operations=='all'){
				$this->createPermission = "<input type='submit' value='Submit' class='btn btn-success formsubmit_button ".$class."' ".$datavariable." >";
				$this->updatePermission = "<input type='submit' value='Update' class='btn btn-success formupdate_button ".$class."' ".$datavariable." >";
				$this->readPermission   = "<input type='button' value='View' class='btn btn-primary formview_button ".$class."' ".$datavariable." >";
				$this->deletePermission = "<input type='submit' onclick='confirm(&quot;Are you sure you want to delete this data?&quot; )' value='Delete' class='btn btn-danger formdelete_button ".$class."' ".$datavariable." >"; 
				if($custom_btn){
					foreach($custom_btn as $type=>$btnlink){
						 
							if($type=='add'){ 
							 $this->createPermission_custom = $btnlink;
							}
							if($type=='edit'){ 
							 $this->updatePermission_custom = $btnlink;
							}
							if($type=='view' || $type=='access'){ 
							 $this->readPermission_custom = $btnlink;
							} 
							if($type=='delete'){ 
							 $this->deletePermission_custom = $btnlink;
							}	
						 
					}	
				}
			}elseif(!$custom_btn){
				if($operations=='add'){ 
				 $this->createPermission = "<input type='submit' value='Submit' class='btn btn-success formsubmit_button ".$class."' ".$datavariable." >";
				}
				if($operations=='edit'){ 
				 $this->updatePermission = "<input type='submit' value='Update' class='btn btn-success formupdate_button ".$class."' ".$datavariable." >";
				}
				if($operations=='view' || $operations=='access'){ 
				 $this->readPermission = "<input type='button' value='View' class='btn btn-primary formview_button ".$class."' ".$datavariable." >";
				}
				
				if($operations=='delete'){ 
				 $this->deletePermission = "<input type='submit' onclick='confirm(&quot;Are you sure you want to delete this data?&quot; )' value='Delete' class='btn btn-danger formdelete_button ".$class."' ".$datavariable." >";
				}	
			}elseif($custom_btn){
					foreach($custom_btn as $type=>$btnlink){
						 
							if($type=='add'){ 
							 $this->createPermission_custom = $btnlink;
							}
							if($type=='edit'){ 
							 $this->updatePermission_custom = $btnlink;
							}
							if($type=='view' || $type=='access'){ 
							 $this->readPermission_custom = $btnlink;
							} 
							if($type=='delete'){ 
							 $this->deletePermission_custom = $btnlink;
							}	
						 
					}	
				}
			return 1;
		}else{
			$this->createPermission = "<input type='button' value='Restricted' class='btn  btn-sm btn-outline-light disabled' />";
			$this->updatePermission = "<input type='button' value='Restricted' class='btn  btn-sm btn-outline-light disabled' />";
			$this->readPermission = "<input type='button' value='Restricted' class='btn  btn-sm btn-outline-light disabled' />";
			$this->deletePermission = "<input type='button' value='Restricted' class='btn  btn-sm btn-outline-light disabled' />";	
			
			$this->createPermission_custom = "<input type='button' value='Restricted' class='btn  btn-sm btn-outline-light disabled' />";
			$this->updatePermission_custom = "<input type='button' value='Restricted' class='btn  btn-sm btn-outline-light disabled' />";
			$this->readPermission_custom = "<input type='button' value='Restricted' class='btn  btn-sm btn-outline-light disabled' />";
			$this->deletePermission_custom = "<input type='button' value='Restricted' class='btn  btn-sm btn-outline-light disabled' />";	
			
			return 0;
		}
		
	}
	
	 


}
?>