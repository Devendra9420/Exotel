 <div class="section-body">
	  
            <h2 class="section-title">Spares Recon</h2> 
	  
    <div class="row">
        <div class="col-lg-12">
      		<div class="panel">
                <div class="panel-header text-right"> 
						 <a href="<?php if(!empty($_SERVER['HTTP_REFERER'])){ echo $_SERVER['HTTP_REFERER']; }else{ echo $this->uri->uri_string(); } ?>" class="btn btn-sm btn-info text-right">Back</a> 
				</div>
                <div class="panel-body">
                     
						<?php $attributes = array('class' => 'form-horizontal group-border hover-stripped spares_assign_form', 'id'=>'addedit_form', 'method' => 'post');
                echo form_open_multipart('bookings/save_spares_recon', $attributes); ?>
						 
						<div class="form-row">
							
							<?php  
							$model = get_model($booking->vehicle_model, 'all');
							?>
							<input class="form-control" id="booking_id" value="<?php echo @$booking->booking_id; ?>" type="hidden" name="booking_id">
							<input class="form-control" id="city" value="<?php echo @$booking->customer_city; ?>" type="hidden" name="city">
							<input class="form-control " id="make" value="<?php echo @$booking->vehicle_make; ?>" type="hidden" name="make">
							<input class="form-control" id="model" value="<?php echo @$booking->vehicle_model; ?>" type="hidden" name="model">
							<input class="form-control input-modelcode" id="model_code" value="<?php echo @$model->model_code; ?>" type="hidden" name="model_code">
							<input class="form-control input-vehiclecategory" id="vehicle_category" value="<?php echo @$model->vehicle_category; ?>" type="hidden" name="vehicle_category">
							<input type="hidden" name="jobcard_attempt" id="jobcard_attempt" value="<?php echo $jobcard->jobcard_attempt; ?>">
							<input type="hidden" name="jobcard_id" id="jobcard_id" value="<?php echo $jobcard->id; ?>">
							
							
			<div class="col-12 col-md-6 col-lg-3">
                <div class="card card-primary">
                  <div class="card-header">
                    <h4>Customer Details</h4>
                  </div>
                  <div class="card-body"> 
					<p>Name: <?php echo $booking->customer_name; ?></p> 
					<p>Mobile: <?php echo $booking->customer_mobile; ?></p>
					<p>Channel: <?php echo $booking->customer_channel; ?></p>  
                  </div>
                </div>
              </div>
					
					
			 <div class="col-12 col-md-6 col-lg-3">
                <div class="card card-primary">
                  <div class="card-header">
                    <h4>Booking Details</h4>
                  </div>
                  <div class="card-body">
					<p>Make: <?php echo get_make($booking->vehicle_make); ?></p>   
					<p>Model: <?php echo $model->model_name; ?></p>   
					<p>&nbsp;</p>
                  </div>
                </div>
              </div>
				
				
			<div class="col-12 col-md-6 col-lg-3">
                <div class="card card-primary">
                  <div class="card-header">
                    <h4>Vehicle Details</h4>
                  </div>
                  <div class="card-body">
					<p>Service Date: <?php echo convert_date($booking->service_date); ?></p>
					<p>Service Category: <?php echo get_service_category($booking->service_category_id); ?></p>   
					<p>Last Km Reading: <?php echo $booking->vehicle_km_reading; ?></p>  
                  </div>
                </div>
              </div>
			
							
				<div class="col-12 col-md-6 col-lg-3">
                <div class="card card-primary">
                  <div class="card-header">
                    <h4>Other Details</h4>
                  </div>
                  <div class="card-body">
					<p>Comment: <?php echo @$booking->comment; ?></p>
					 <p> 
					 <?php if($booking->stage=="Inspection Done"){ ?> 
							<lable>Customer Approved: </lable>
							<select name="customer_approval" id="customer_approval" class="form-control select2"><option>Select</option>
							<option <?php if($jobcard->customer_approval=='Yes'){ echo 'selected'; } ?> value="Yes">Yes</option>
							<option <?php if($jobcard->customer_approval=='No'){ echo 'selected'; } ?> value="No">No</option>
							<option <?php if($jobcard->customer_approval=='Sent'){ echo 'selected'; } ?> value="Sent">Sent</option>	 	 
							</select>
						<?php } ?>	
					 </p>
					  <p>&nbsp;</p>
					  <p>&nbsp;</p>
                  </div>
                </div>
              </div>
		
				 
						 	 
				<?php  $complaints_counter = 1; ?>
				<?php  $estimate_counter = 1; ?>   
              <div class="col-md-12" id="estimate_cards"> 	
                <div class="card-estimate card card-info" id="card_estimate">
                  <div class="card-header">
                    <h4>Spares</h4>
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
                            <th>Brand</th>
                            <th>Quantity</th> 
                            <th>Assign</th>
                          </tr>
                        </thead>
                        <tbody>
                          
							<?php 
							$counter = 1;
				 $jobcard_details = $this->Common->select_wher('jobcard_details', 'booking_id = "'.$booking->booking_id.'" AND item_type NOT IN ("Labour", "Service Category")');
							if($jobcard_details)
							foreach ($jobcard_details as $row) {
								
								$show = 1;
								
								if($row->item_type=="Complaints"){
									
								$is_Spare = $this->Common->single_row('spares', array('spares_id'=>$row->item_id));
									
								if(!empty($is_Spare->id)){
									$show = 1;
								}else{
									$show = 0;
								}	
								} 
								if($show==1){ 
									
									
								?>
							<tr>
							<td> 
			<input type="hidden" name="estimate_row[]" value="<?= $counter; ?>"><input type="hidden" name="item_id[]" value="<?= $row->item_id; ?>"><input type="hidden" name="complaint_number[]" value="<?= $row->complaint_number; ?>"><input type="hidden" name="complaints[]" value="<?= $row->complaints; ?>">
			<input type="hidden" class="itemtype" name="itemtype[]" value="<?= $row->item_type; ?>"><input type="hidden" name="jobdet_ID[]" value="<?= $row->id;  ?>">
								<?= $counter; ?></td>
			<td> 
				
			<?php
			if($row->item_type="Spare"){ ?> 
            <input type="hidden" class="input_itemcode" name="sparesid[]" value="<?= $row->item_id; ?>">
			<?php }  ?>			 
				
			<input type="hidden" name="item_name[]" value="<?= $row->item; ?>"><?= $row->item; ?></td>	
			<td><select class="form-control select-ajax-spares-brand" data-spareid="<?= $row->item_id; ?>"  style="width: 100%;" name="brand[]" id="brand_<?= $counter; ?>"><option value="" selected></option></select></td>	 
			<td>
            <input type="text" name="quantity[]" tabindex="1" id="quantity_<?= $counter; ?>" onclick="row_sum(<?= $counter; ?>)" size="2" value="<?= $row->qty; ?>" class="form-control" onkeyup="row_sum(<?= $counter; ?>)"></td>   
			<td> 
			<div class="custom-control custom-checkbox">
                      <input type="checkbox" name="assigned[]" class="custom-control-input spares_be_assigned" id="customCheck<?= $counter; ?>" value="<?= $row->item_id;  ?>">
                      <label class="custom-control-label" for="customCheck<?= $counter; ?>"></label>
                    </div>	
			  </td>
			</tr>
				 
			 <?php
			 
			$counter++;  
									
								}
								
								
			} 		
			?>
							
                        </tbody>
                      </table>
                    </div>
                  </div>
					</div>   
                </div>
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
<?php $this->session->unset_userdata('customer'); ?>