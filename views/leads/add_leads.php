 <div class="section-body">
            <h2 class="section-title">Customer Details</h2> 
	 
    <div class="row">
        <div class="col-lg-12">
      		<div class="panel">
                 
                <div class="panel-body">
                     
						<?php $attributes = array('class' => 'form-horizontal group-border hover-stripped', 'id'=>'addedit_form', 'method' => 'post');
                echo form_open_multipart('leads/insert_leads', $attributes); ?>
						 
						<div class="form-row">
						<div class="form-group col-md-6">
                                <label>Mobile</label>
                                <input class="form-control" placeholder="1234567890" id="mobile" type="text" value="<?php echo @$this->session->userdata['customer']['mobile'];?>" name="mobile">
                        </div>
				<?php
					$customer_type='new';
					if(!empty($this->session->userdata['customer']['customer_type'])){ $customer_type = $this->session->userdata['customer']['customer_type']; } 
					$customer_id='0';
					if(!empty($this->session->userdata['customer']['customer_id'])){ $customer_id = $this->session->userdata['customer']['customer_id'];  } 		
				?>
						<input class="form-control" value="<?php echo @$leads_convert; ?>" type="hidden" id="leads_convert" name="leads_convert"> 	
						<input class="form-control" value="<?php echo @$leads_id; ?>" type="hidden" id="leads_id" name="leads_id"> 		
						<input class="form-control" value="<?php echo @$customer_id; ?>" type="hidden" name="customer_id"> 	
						<input class="form-control" value="<?php echo @$customer_type; ?>" type="hidden" name="customer_type"> 	
						<div class="form-group col-md-6"> 
                                <label>Customer Name</label>
                                <input class="form-control" placeholder="Customer Name" id="name" value="<?php echo @$this->session->userdata['customer']['name'];?>" type="text" name="name"> 
                        </div>
					  
						<div class="form-group col-md-6">	
                            <label>Alternate No</label>
								<input class="form-control" placeholder="Alternate Number"  value="<?php echo @$this->session->userdata['customer']['alternate_no'];?>" type="text" name="alternate_no"> 
                         </div>
				
                        <div class="form-group col-md-6"> 
                                <label>Email</label>
                                <input class="form-control" type="text" value="<?php echo @$this->session->userdata['customer']['email'];?>" name="email">
                         </div>
				
						<div class="form-group col-md-6"> 
                            <label>Lead Source</label>
                            <select class="form-control select2" id="source" placeholder="Source" name="source"> 
							<option value="">Select</option> 
							<option value="Sales Partner">Sales Partner</option>
							<option value="GW In-house Team">GW In-house Team</option>
							<option value="eStore">eStore</option>
							<option value="Exotel">Exotel</option>
							<option value="Email">Email</option>
							<option value="Social Media">Social Media</option>
							<option value="Online">Online</option>
							<option value="Offline">Offline</option> 
							</select>	
                         </div>
							
							
						<div class="form-group col-md-6"> 
                                <label>Channel</label>
                                <select class="form-control select-ajax-channel" id="channel" placeholder="Channel" name="channel">
								<option selected value="<?php echo @$this->session->userdata['customer']['channel'];?>"><?php echo @$this->session->userdata['customer']['channel'];?></option>
								</select>	
                         </div>
							
							
						<div class="form-group col-md-12"> 
                                <label>Agent Name</label>
                                <select class="form-control select-ajax-users" id="owner" placeholder="Agent" name="owner">
								<option selected value="<?php echo @$this->session->userdata['customer']['agent'];?>"><?php echo @$this->session->userdata['customer']['agent'];?></option>
								</select>	
                         </div>	 
							 
							  
							
						<div class="col-md-12" id="addresscards"> 	
						 	
							<div class="card-address-number card card-info" id="card_address">
                  <div class="card-header"> 
					  
                     <h4>Address Details</h4>
					  <?php //print_r($this->session->userdata('customer')); ?>
					  	 <?php if($this->session->has_userdata('customer')){ 
							echo '<select name="address_type" id="address_type" class="select2" style="width:60%;">';
							$customer_address = $this->session->userdata['customer']['address'];
							foreach($customer_address as $addr){ 
						?> 
						<option data-address="<?php echo @$addr['address']; ?>" data-city="<?php echo @$addr['city']; ?>" data-area="<?php echo @$addr['area']; ?>" data-pincode="<?php echo @$addr['pincode']; ?>" data-zone="<?php echo @$addr['zone']; ?>" data-googlemap="<?php echo @$addr['google_map']; ?>" data-latitude="<?php echo @$addr['latitude']; ?>" data-longitude="<?php echo @$addr['longitude']; ?>" value="<?php echo @$addr['type']; ?>"><?php echo  @$addr['type']; ?></option>
						
					<?php }
							echo '</select>';
									}
						?>
					<div class="card-header-action col-md-3">
				
                      <a data-collapse="#address-collapse" class="btn btn-icon btn-info float-right" href="#"><i class="fas fa-minus"></i></a>
                    </div>  
                  </div>
				<div class="collapse show" id="address-collapse" style="">			
				 <div class="card-body">
					 <div class="row">
						<div class="form-group col-md-12"><label>Address:   </label> 
								<input name="address" type="text" class='form-control' id='address' value="<?php echo @$customer_address[0]['address']; ?>" placeholder='Address'></input>
						</div>
						<div class="form-group col-md-6">
                                <label>City</label>
                                <select class="form-control select-ajax-city" style="width: 100%;"  placeholder="City" id="city" name="city"> 
								<option selected value="<?php echo @$customer_address[0]['city']; ?>"><?php echo @$customer_address[0]['city']; ?></option> 
								</select>
                         </div>	
						<div class="form-group col-md-6">
                                <label>Area</label>
                                 <select class="form-control select-ajax-area" id="area" placeholder="Area" name="area">
								<option selected value="<?php echo @$customer_address[0]['area']; ?>"><?php echo @$customer_address[0]['area']; ?></option>
								</select>
                         </div>
						
						<div class="form-group col-md-6">
                                <label>Pincode</label>
                                <input class="form-control input-pincode" value="<?php echo @$customer_address[0]['pincode']; ?>" id="pincode" type="text" name="pincode">
								<input class="form-control input-zone" value="<?php echo @$customer_address[0]['zone']; ?>" id="zone" type="hidden" name="zone">
                         </div>
						<div class="form-group col-md-6">
                                <label>Google Map</label>
                                <input class="form-control google_map" id="google_map" value="<?php echo @$customer_address[0]['google_map']; ?>" type="text" name="google_map">
								<input type="hidden" class="latitude" id="latitude" name="latitude" value="<?php echo @$customer_address[0]['latitude']; ?>" />
								<input type="hidden" class="longitude" id="longitude" name="longitude" value="<?php echo @$customer_address[0]['longitude']; ?>" />
							
							 
							
							
                         </div>	
					 </div>
					</div>
					</div>		
                			</div>			
					
							</div>
					
							<div class="col-md-12" id="vehiclecards"> 	
						 
							<div class="card-vehicle-number card card-info" id="card_vehicle">
                  <div class="card-header"> 
					   
                     <h4>Vehicle Details</h4>
					   <?php if($this->session->has_userdata('customer')){ 
							echo '<select name="customer_vehicle" id="customer_vehicle" class="select2" style="width:60%;">';
							$customer_vehicle = $this->session->userdata['customer']['vehicle'];
							foreach($customer_vehicle as $vehicle){ 
						?> 
						<option data-reg="<?php echo @$vehicle['regno']; ?>" data-yom="<?php echo @$vehicle['yom']; ?>" data-kmreading="<?php echo @$vehicle['km_reading']; ?>" data-make="<?php echo @$vehicle['make']; ?>" data-makename="<?php echo @$vehicle['make_name']; ?>"  data-model="<?php echo @$vehicle['model']; ?>" data-modelname="<?php echo @$vehicle['model_name']; ?>" data-vehiclecategory="<?php echo @$vehicle['vehicle_category']; ?>"   data-modelcode="<?php echo @$vehicle['model_code']; ?>" data-lastserviceid="<?php echo @$vehicle['last_service_id']; ?>"  data-lastservicedate="<?php echo @$vehicle['last_service_date']; ?>"  value="<?php echo @$vehicle['vehicle_id']; ?>"><?php echo @$vehicle['make_name'].' '. @$vehicle['model_name']; ?></option>
						
					<?php }
							echo '</select>';
									}
						?>
					<div class="card-header-action col-md-3">
                      <a data-collapse="#vehicle-collapse" class="btn btn-icon btn-info float-right" href="#"><i class="fas fa-minus"></i></a>
                    </div>  
                  </div>
				<div class="collapse show" id="vehicle-collapse" style="">			
				 <div class="card-body">
					 <div class="row">
						 <div class="form-group col-md-6">
                                <label>Make</label>
                                <select class="form-control select-ajax-make" style="width: 100%;"  placeholder="Make" id="make" name="make">
								<option selected value="<?php echo @$customer_vehicle[0]['make']; ?>"><?php echo @$customer_vehicle[0]['make_name']; ?></option> 
								</select>
                         </div>	
						<div class="form-group col-md-6">
                                <label>Model</label>
                                 <select class="form-control select-ajax-model" id="model"  placeholder="Model" name="model">
								 <option selected value="<?php echo @$customer_vehicle[0]['model']; ?>"><?php echo @$customer_vehicle[0]['model_name']; ?></option>
								</select>
							<input class="form-control input-modelcode" id="model_code" value="<?php echo @$customer_vehicle[0]['model_code']; ?>" type="hidden" name="model_code">
							<input class="form-control input-vehiclecategory" id="vehicle_category" value="<?php echo @$customer_vehicle[0]['vehicle_category']; ?>" type="hidden" name="vehicle_category">
							
                         </div>
						 
						<div class="form-group col-md-4"><label>Registration No:   </label>
								<input name="reg_no" type="text" class='form-control' id='reg_no' value="<?php echo @$customer_vehicle[0]['regno']; ?>" placeholder='MHXX-XX-XXXX'></input>
						</div>
					 	<div class="form-group col-md-4">
                                <label>Year Of Make</label>
                                <input class="form-control" value="<?php echo @$customer_vehicle[0]['yom']; ?>" id="yom" type="year" name="yom">
                         </div>
						<div class="form-group col-md-4">
                                <label>Km Reading</label>
                                <input class="form-control" value="<?php echo @$customer_vehicle[0]['km_reading']; ?>" type="number" id="km_reading" name="km_reading">
							 
                         </div>	
					 
						
						<div class="col-md-6">
                           <div class="form-group" class="last_service_id" style="display: none;">
                              <label class="control-label">Vehicle Last Service ID: </label>
                              <br> <input name="last_service_id" id="last_service_id" type="hidden" value="<?php echo @$customer_vehicle[0]['last_service_id']; ?>" />
							   <input name="last_service_date" id="last_service_date" type="hidden" value="<?php echo @$customer_vehicle[0]['last_service_date']; ?>" />
							   <div id="last_service_id_div"></div>
                           </div>
                            
                      </div> 
						
					 </div>
					</div>
					</div>		
                			</div>			
					
							</div>
				
				
				<div class="col-md-12" id="service_categorycards"> 	
						 
							<div class="card-service_category card card-info" id="card_service_category">
                  <div class="card-header"> 
					  
                     <h4>Service Details</h4>
					<div class="card-header-action col-md-6">
                      <a data-collapse="#service-category-collapse" class="btn btn-icon btn-info float-right" href="#"><i class="fas fa-minus"></i></a>
                    </div>  
                  </div>
				<div class="collapse show" id="service-category-collapse" style="">			
				 <div class="card-body">
					 <div class="row">
						<div class="form-group col-md-12"><label>Service Category:   </label>
								<select class="form-control select-ajax-service-category" style="width: 100%;"  placeholder="Service Category" id="service_category" name="service_category">
								<option selected value=""></option> 
								</select>
							<div class="selected_service_category p-3" style="display: none;"></div>
						</div> 
						<div class="form-group col-md-6"><label>Desired Service Date:   </label>
								 <input class="form-control" value="<?php echo @$this->session->userdata['customer']['desired_service_date']; ?>" type="date" id="service_date" name="service_date">
						</div>
						 
						 <div class="form-group col-md-6"><label>Desired Time Slot:   </label>
								 <select class="form-control select-ajax-time-slot" style="width: 100%;"  placeholder="Time Slot" id="time_slot" name="time_slot">
								<option selected value="<?php echo @$this->session->userdata['customer']['desired_service_time']; ?>"></option> 
								</select>
						</div>
						 
						
					 </div>
					</div>
					</div>		
                			</div>			
					
							</div>
			
				
					<div class="col-md-12" id="specific_cards"> 	
						 
							<div class="card-specific card card-info" id="card_specific">
                  <div class="card-header"> 
					  
                     <h4>Specific Details</h4>
					<div class="card-header-action col-md-6">
                      <a data-collapse="#specific-collapse" class="btn btn-icon btn-info float-right" href="#"><i class="fas fa-minus"></i></a>
                    </div>  
                  </div>
				<div class="collapse show" id="specific-collapse" style="">			
				 <div class="card-body">
					 <div class="row">
						 
					 	  
						<div class="form-group col-md-6"><label>Specific Spares:   </label>
								<select class="form-control select-ajax-spares"   style="width: 100%;"  placeholder="Specific Spares" id="specific_spares" name="specific_spares">
								<option selected value=""></option> 
								</select>
							<div class="selected_spares p-3"></div>
							<div id="brand_div"></div>
						</div>
						 
						 <div class="form-group col-md-6"><label>Specific Repairs:   </label>
								<select class="form-control select-ajax-labour"   style="width: 100%;"  placeholder="Specific Repairs" id="specific_repairs" name="specific_repairs">
								<option selected value=""></option> 
								</select>
							 <div class="selected_labour p-3"></div>
						</div>
						 
						 
						 <div class="form-group col-md-12"><label>Complaints:   </label>
								<select class="form-control select-ajax-complaints"   style="width: 100%;"  placeholder="Complaints" id="complaints" name="complaints">
								<option selected value=""></option> 
								</select>
							 <input class="all_selected_complaints" id="all_selected_complaints" value="" name="all_selected_complaints" type="hidden" />
							 <div class="selected_complaints p-3"></div>
						</div>
						 
						
					 </div>
					</div>
					</div>		
                			</div>			
					
							</div>
				
				
						 	 
				<?php  $complaints_counter = 1; ?>
				<?php  $estimate_counter = 1; ?>
              <div class="col-md-12" id="estimate_cards" style="display: none;"> 	
                <div class="card-estimate card card-info" id="card_estimate">
                  <div class="card-header">
                    <h4>Estimate</h4>
					 <div class="card-header-action col-md-6">
                      <a data-collapse="#estimate-collapse" class="btn btn-icon btn-info float-right" href="#"><i class="fas fa-minus"></i></a>
                    </div>   
                  </div>
				   <div class="collapse show" id="estimate-collapse" style="">		
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="estimate_table">
                        <thead>
                          <tr> 
                            <th>#</th>
                            <th>Description</th> 
                            <th>Quantity</th>
                            <th>Spares</th>
                            <th>Labour</th>
                            <th>Total</th>
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                          
                        </tbody>
                      </table>
                    </div>
                  </div>
					</div>   
                </div>
              </div>
            
				<div class="col-md-12" id="complaints_tables_div" style="display: none;"> 	
				</div>
				
				<div class="col-md-12" id="comments_div"> 	
				<div class="form-group">
                      <label>Comments/Details and estimates of additional work</label>
					  <textarea class="form-control" rows="5" cols="100" name="comments" id="comments"><?php echo @$this->session->userdata['customer']['comments']; ?></textarea> 
                    </div>
					 
					
					<input class="form-control" value="" id="total_estimate_sum" type="hidden" name="total_estimate_sum">
					<input class="form-control" value="" id="max_complaints_val" type="hidden" name="max_complaints_val">
					<input class="form-control" value="" id="min_complaints_val" type="hidden" name="min_complaints_val">
					
					 	
				</div>	
				
				<div class="col-md-6" style="display: none;"> 	
					<div class="form-group">
                      <label>Minimum Total Estimate: </label>
					  <input class="form-control" value="0" id="totalcombine_min" type="text" readonly name="totalcombine_min"> 	
                    </div>
				</div>
				
				<div class="col-md-6" style="display: none;"> 	
					<div class="form-group">
                      <label>Maxiumum Total Estimate: </label>
					  <input class="form-control" value="0" id="totalcombine_max" type="text" readonly name="totalcombine_max"> 	
                    </div>
				</div>		 
					
					 
				
					
					 
				
				
				
				
						</div>
				<div class="panel-footer">
                        <div class="form-group">
                            <div class="col-md-12">
                                <?php echo $this->rbac->createPermission; ?>
                                <a href="<?php if(!empty($_SERVER['HTTP_REFERER'])){ echo $_SERVER['HTTP_REFERER']; }else{ echo $this->uri->uri_string(); } ?>" class="btn btn-warning">Cancel</a>
                            </div>
                        </div> 
						</div>	
                    </form>

                </div>
            </div>
        </div>
    </div>
</div> 



<?php //$this->session->unset_userdata('customer'); ?>