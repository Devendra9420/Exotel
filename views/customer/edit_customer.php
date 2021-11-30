 <div class="section-body">
            <h2 class="section-title">Edit Customer Details</h2>
            <p class="section-lead"><?= $customer->name; ?></p>
	 
    <div class="row">
        <div class="col-lg-12">
      		<div class="panel">
                 
                <div class="panel-body">
                     
						<?php $attributes = array('class' => 'form-horizontal group-border hover-stripped', 'id'=>'addedit_form', 'method' => 'post');
                echo form_open_multipart('customer/update_customer', $attributes); ?>
						
						<input type="hidden" name="customer_id" value="<?php echo $this->uri->segment(3); ?>">
						<div class="form-row">
						<div class="form-group col-md-12"> 
                                <label>Customer Name</label>
                                <input class="form-control" placeholder="Customer Name" id="name" value="<?= $customer->name; ?>" type="text" name="customer_name"> 
                        </div>
					
                        <div class="form-group col-md-6">
                                <label>Mobile</label>
                                <input class="form-control" placeholder="1234567890" id="mobile" type="text" value="<?= $customer->mobile; ?>" name="mobile">
                        </div>
					
						<div class="form-group col-md-6">	
                            <label>Alternate No</label>
								<input class="form-control" placeholder="Alternate Number"  value="<?= $customer->alternate_no; ?>" type="text" name="alternate_no"> 
                         </div>
				
                        <div class="form-group col-md-6"> 
                                <label>Email</label>
                                <input class="form-control" type="text" value="<?= $customer->email; ?>" name="email">
                         </div>
				
						<div class="form-group col-md-6"> 
                                <label>Channel</label>
                                <select class="form-control select-ajax-channel" placeholder="Channel" name="channel">
								<option selected value="<?php echo @$customer->channel;?>"><?php echo @$customer->channel; ?></option> 
								 
								</select>	
                         </div>
							
							
							 
							<div class="col-md-6 mb-3"><div class="section-title mt-0">Addresse(s)</div></div><div class="col-md-6 text-right"><button type="button"  class="btn btn-icon btn-info" data-toggle="modal" data-target="#addNewAddress">Add New Address</button></div> 	
							  
							
						<div class="col-md-12" id="addresscards"> 	
						<?php
							$i=1;
							foreach ($customer_addresses as $addr){ 
						?>		
							<div class="card-address-number card card-info" id="card_<?=$i;?>">
                  <div class="card-header"> 
					  
                    <div class="col-md-6">
						<div class="form-group row">
    <label class="col-form-label col-sm-2" for="type">Type:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="address_type[]" value="<?= $addr->type; ?>" />
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
							<input type="hidden" name="address_id[]" value="<?= $addr->address_id; ?>" />
						<div class="form-group col-md-12"><label>Address:   </label>
								<input name="address[]" type="text" class='form-control' id='address' value="<?= $addr->address; ?>" placeholder='Address'></input>
						</div>
						<div class="form-group col-md-6">
                                <label>City</label>
                                <select class="form-control select-ajax-city" style="width: 100%;"  placeholder="City" id="city_<?=$i;?>" name="city[]">
								<option value=""></option>
								<option selected value="<?= $addr->city; ?>"><?= $addr->city; ?></option> 
								</select>
                         </div>	
						<div class="form-group col-md-6">
                                <label>Area</label>
                                 <select class="form-control select-ajax-area" onFocus="get_area('<?=$i;?>');" id="area_<?=$i;?>" onChange="get_pincode('<?=$i;?>');" placeholder="Area" name="area[]">
								<option value=""></option>
								<option selected value="<?= $addr->area; ?>"><?= $addr->area; ?></option> 
								</select>
                         </div>
						
						<div class="form-group col-md-6">
                                <label>Pincode</label>
                                <input class="form-control input-pincode" value="<?= $addr->pincode; ?>" id="pincode_<?=$i;?>" type="text" name="pincode[]">
								<input class="form-control input-zone" value="" id="zone_<?=$i;?>" type="hidden" name="zone[]">
                         </div>
						<div class="form-group col-md-6">
                                <label>Google Map</label>
                                <input class="form-control google_map" id="google_map_<?=$i;?>" value="<?= $addr->google_map; ?>" type="text" name="google_map[]">
								<input type="hidden" class="latitude" id="latitude_<?=$i;?>" name="latitude[]" value="<?= $addr->latitude; ?>" />
								<input type="hidden" class="longitude" id="longitude_<?=$i;?>" name="longitude[]" value="<?= $addr->longitude; ?>" />
                         </div>	
					 </div>
					</div>
					</div>		
                			</div>			
						<?php 
							$i++;	
							}
						?> 
							</div>
					
												
						</div>
				<div class="panel-footer">
                        <div class="form-group">
                            <div class="col-md-12">
                                <?php echo $this->rbac->updatePermission; ?>
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
<div class="modal fade" role="dialog" id="addNewAddress">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
				<?php $attributes = array('class' => 'form-horizontal group-border hover-stripped', 'id'=>'add_address_form', 'method' => 'post');
                echo form_open_multipart('customer/add_address', $attributes); ?>
              <div class="modal-body">
                <div class="row"> 
					<input type="hidden" name="customer_id" value="<?php echo $this->uri->segment(3); ?>">
					
						
					<div class="form-group col-md-12"><label>Address:   </label>
								<input type="text" class="form-control" name="address_type" value="" />
						</div>
						<input type="hidden" name="address_id[]" value="" />
						<div class="form-group col-md-12"><label>Address:   </label>
								<input name="address" type="text" class='form-control' id='address' value="" placeholder='Address'></input>
						</div>
						<div class="form-group col-md-6">
                                <label>City</label>
                                <select class="form-control select-ajax-city" style="width: 100%;"  placeholder="City" id="city_<?=$i;?>" name="city">
								<option value=""></option>
								</select>
                         </div>	
						<div class="form-group col-md-6">
                                <label>Area</label>
                                 <select class="form-control select-ajax-area"  style="width: 100%;" onFocus="get_area('<?=$i;?>');" id="area_<?=$i;?>" onChange="get_pincode('<?=$i;?>');" placeholder="Area" name="area">
								<option value=""></option>
								</select>
                         </div>
						
						<div class="form-group col-md-6">
                                <label>Pincode</label>
                                <input class="form-control input-pincode" value="" id="pincode_<?=$i;?>" type="text" name="pincode">
								<input class="form-control input-zone" value="" id="zone_<?=$i;?>" type="hidden" name="zone">
                         </div>
						<div class="form-group col-md-6">
                                <label>Google Map</label>
								<input class="form-control google_map" id="google_map_<?=$i;?>" value="" type="text" name="google_map">
								<input type="hidden" class="latitude" id="latitude_<?=$i;?>" name="latitude" value="" />
								<input type="hidden" class="longitude" id="longitude_<?=$i;?>" name="longitude" value="" />
							 
                         </div>	
					 </div>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <?php echo $this->rbac->createPermission; ?>
              </div>
			  </form>
            </div>
          </div>
        </div>
