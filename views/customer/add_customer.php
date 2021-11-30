 <div class="section-body">
            <h2 class="section-title">Add Customer</h2> 
	 
    <div class="row">
        <div class="col-lg-12">
      		<div class="panel">
                 
                <div class="panel-body">
                     
						<?php $attributes = array('class' => 'form-horizontal group-border hover-stripped', 'id'=>'addedit_form', 'method' => 'post');
                echo form_open_multipart('customer/insert_customer', $attributes); ?>
						 
						<div class="form-row">
						<div class="form-group col-md-12"> 
                                <label>Customer Name</label>
                                <input class="form-control" placeholder="Customer Name" id="name" value="" type="text" name="customer_name"> 
                        </div>
					
                        <div class="form-group col-md-6">
                                <label>Mobile</label>
                                <input class="form-control" placeholder="1234567890" id="mobile" type="text" value="" name="mobile">
                        </div>
					
						<div class="form-group col-md-6">	
                            <label>Alternate No</label>
								<input class="form-control" placeholder="Alternate Number"  value="" type="text" name="alternate_no"> 
                         </div>
				
                        <div class="form-group col-md-6"> 
                                <label>Email</label>
                                <input class="form-control" type="text" value="" name="email">
                         </div>
				
						<div class="form-group col-md-6"> 
                                <label>Channel</label>
                                 <select class="form-control select-ajax-channel" placeholder="Channel" name="channel">
								<option selected value="<?php echo @$customer->channel;?>"><?php echo @$customer->channel; ?></option> 
								 
								</select>	
							 	
                         </div>
							
							
							 
							<div class="col-md-6 mb-3"><div class="section-title mt-0">Addresse(s)</div></div><div class="col-md-6 text-right"></div> 	
							  
							
						<div class="col-md-12" id="addresscards"> 	
						<?php
							$i=1;
							 
						?>		
							<div class="card-address-number card card-info" id="card_<?=$i;?>">
                  <div class="card-header"> 
					  
                    <div class="col-md-6">
						<div class="form-group row">
    <label class="col-form-label col-sm-2" for="type">Type:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="address_type" value="" />
    </div>
  </div>
					  </div> 
					<div class="card-header-action col-md-6">
                      <a data-collapse="#address-collapse-<?=$i;?>" class="btn btn-icon btn-info float-right" href="#"><i class="fas fa-minus"></i></a>
                    </div>  
                  </div>
				<div class="collapse show" id="address-collapse-<?=$i;?>" style="">			
				 <div class="card-body">
					 <div class="row">
						<div class="form-group col-md-12"><label>Address:   </label>
								<input name="address" type="text" class='form-control' id='address' value="" placeholder='Address'></input>
						</div>
						<div class="form-group col-md-6">
                                <label>City</label>
                                <select class="form-control select-ajax-city" style="width: 100%;"  placeholder="City" id="city_<?=$i;?>" name="city">
								<option selected value=""></option> 
								</select>
                         </div>	
						<div class="form-group col-md-6">
                                <label>Area</label>
                                 <select class="form-control select-ajax-area" onFocus="get_area('<?=$i;?>');" id="area_<?=$i;?>" onChange="get_pincode('<?=$i;?>');" placeholder="Area" name="area">
								<option value=""></option>
								</select>
                         </div>
						
						<div class="form-group col-md-6">
                                <label>Pincode</label> 
							    <input class="form-control input-pincode" value="" id="pincode_<?=$i;?>" type="text" name="pincode">
								<input class="form-control input-zone" value="<?php echo @$customer_address[0]['zone']; ?>" id="zone" type="hidden" name="zone">
                         </div>
						<div class="form-group col-md-6">
                                <label>Google Map</label>
                                <input class="form-control google_map"  id="google_map_<?=$i;?>" value="" type="text" name="google_map">
								<input type="hidden" class="latitude"  id="latitude_<?=$i;?>" name="latitude" value=">" />
								<input type="hidden" class="longitude" id="longitude_<?=$i;?>" name="longitude" value="" />
                         </div>	
					 </div>
					</div>
					</div>		
                			</div>			
						<?php 
							$i++;	
							
						?> 
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
