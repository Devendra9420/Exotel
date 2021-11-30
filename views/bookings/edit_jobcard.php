 <div class="section-body">
	  
            <h2 class="section-title">Edit Jobcard for Booking ID# <?= $booking->booking_id; ?></h2> 
	  
    <div class="row">
        <div class="col-lg-12">
      		<div class="panel">
                <div class="panel-header text-right"> 
						 <a href="<?php if(!empty($_SERVER['HTTP_REFERER'])){ echo $_SERVER['HTTP_REFERER']; }else{ echo $this->uri->uri_string(); } ?>" class="btn btn-sm btn-info text-right">Back</a> 
				</div>
                <div class="panel-body">
                     
						<?php $attributes = array('class' => 'form-horizontal group-border hover-stripped', 'id'=>'addedit_form', 'method' => 'post');
                echo form_open_multipart('bookings/update_jobcard', $attributes); ?>
						 
						<div class="form-row">
							
							<?php  
							$model = get_model($booking->vehicle_model, 'all');
							?>
							
					 
							 <div style="display: none;">
								<select class="form-control select-ajax-city" name="city_custom" id="city"><option value="<?php echo @$booking->customer_city; ?>"><?php echo @$booking->customer_city; ?></option></select> 
							<select class="form-control select-ajax-channel" name="channel__custom" id="channel"><option value="<?php echo @$booking->customer_channel; ?>"><?php echo @$booking->customer_channel; ?></option></select>
							</div>
							
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
					<p>Area: <?php echo $booking->customer_area; ?></p>   
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
					<p>Service Date: <?php echo convert_date($booking->service_date); ?> - <?php echo $booking->time_slot; ?></p>
					<p>Service Category: <?php echo get_service_category($booking->service_category_id); ?></p>   
					<p>Last Km Reading: <?php echo $booking->vehicle_km_reading; ?></p>  
					 <p>Year of Make: <?php echo @$booking->vehicle_yom;  ?></p>  
                  </div>
                </div>
              </div>
			
							
				<div class="col-12 col-md-6 col-lg-3">
                <div class="card card-primary">
                  <div class="card-header">
                    <h4>Other Details</h4>
                  </div>
                  <div class="card-body">
					<p>Comment: <?php echo @$booking->comments; ?></p>
					 <p> 
					 <?php if($booking->stage=="Inspection Done"){ ?> 
						 	<?php 
							$service_advance_demanded_amt =   $this->payments->get_ledger($booking->booking_id, 'service_advance', 'requested_amount');
							$service_advance_received_amt =   $this->payments->get_ledger($booking->booking_id, 'service_advance', 'received_amount');  
							$service_advance_tobe_paid = $service_advance_demanded_amt-$service_advance_received_amt;
							?> 
										
							<lable>Customer Approved: </lable>
						 
						 <?php 
							if($service_advance_tobe_paid>0){ ?>
      <span style="padding: 7px;"  class="label-warning">Service advance for Rs. <?php echo $service_advance_tobe_paid; ?>/- is still not paid by the customer.</span>		 								<?php	}else{  ?>
						 
							<select name="customer_approval" id="customer_approval" class="form-control select2"><option>Select</option>
							<option <?php if($jobcard->customer_approval=='Yes'){ echo 'selected'; } ?> value="Yes">Yes</option>
							<option <?php if($jobcard->customer_approval=='No'){ echo 'selected'; } ?> value="No">No</option>
							<option <?php if($jobcard->customer_approval=='Sent'){ echo 'selected'; } ?> value="Sent">Sent</option>	 	 
							</select>
						 
								<?php } ?>	 	
						 
						<?php } ?>	
					 </p>
					  <p>&nbsp;</p>
					  <p>&nbsp;</p>
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
						 
						  <div class="form-group col-md-12"><label>Complaints:   </label>
								<select class="form-control select-ajax-complaints" style="width: 100%;"  placeholder="Complaints" id="complaints" name="complaints">
								<option selected value=""></option> 
								</select>
							 <input class="all_selected_complaints" id="all_selected_complaints" value="" name="all_selected_complaints" type="hidden" />
							 <div class="selected_complaints p-3"></div>
						</div>
					 	  
						<div class="form-group col-md-6"><label>Specific Spares:   </label>
								<select class="form-control select-ajax-spares" style="width: 100%;"  placeholder="Specific Spares" id="specific_spares" name="specific_spares">
								<option selected value=""></option> 
								</select>  
						</div>
						 
						 <div class="form-group col-md-6"><label>Specific Repairs:   </label>
								<select class="form-control select-ajax-labour" style="width: 100%;"  placeholder="Specific Repairs" id="specific_repairs" name="specific_repairs">
								<option selected value=""></option> 
								</select>
							 
						</div>
						 
						 
						
					 </div>
					</div>
					</div>		
                			</div>			
					
							</div>
				
				
						 	 
				<?php  $complaints_counter = 1; ?>
				<?php  $estimate_counter = 1; ?>   
              <div class="col-md-12" id="estimate_cards"> 	
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
                            <th>Brand</th>
                            <th>Quantity</th>
                            <th>Spares</th>
                            <th>Labour</th>
                            <th>Total</th>
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                          
							<?php 
							$counter = 1;
				 $all_estimate_details = $this->Bookings->getbooking_jobcard_details($booking->booking_id, 'booking_id = "'.$booking->booking_id.'" AND item_type!="Complaints" AND status="Active"');
							if($all_estimate_details)
							foreach ($all_estimate_details as $row){ 
								?>
							<tr>
							<td> 
			<input type="hidden" name="estimate_row[]" value="<?= $counter; ?>"><input type="hidden" name="item_id[]" value="<?= $row->item_id; ?>"><input type="hidden" name="complaint_number[]" value="<?= $row->complaint_number; ?>"><input type="hidden" name="complaints[]" value="<?= $row->complaints; ?>">
			<input type="hidden" class="itemtype" name="itemtype[]" value="<?= $row->item_type; ?>"><input type="hidden" name="jobdet_ID[]" value="<?= $row->id;  ?>">
								<?= $counter; ?></td>
			<td> 
				
			<?php
			if($row->item_type=="Spare"){ ?> 
            <input type="hidden" class="input_itemcode" name="sparesid[]" value="<?= $row->item_id; ?>">
			<?php }elseif($row->item_type=="Labour"){  ?> 
			<input type="hidden" class="input_itemcode" name="labourid[]" value="<?= $row->item_id; ?>"> 
			<?php } ?>			 
				
			 
				
				
			<input type="hidden" name="item_name[]" value="<?= $row->item; ?>"><?= $row->item; ?>
				<?php if($jobcard->customer_approval=='No' && $row->item_type=="Service Category"){ 
				$this_service_category = $row->item; 
				echo '<br><button type="button" data-target="#edit_service_category" data-toggle="modal" class="btn btn-sm btn-info"> Edit <i class="fa fa-pen"></i></button>';  
							} 
				?>
			</td>	
			<td><select class="form-control select-ajax-spares-brand" data-spareid="<?= $row->item_id; ?>"  style="width: 100%;" name="brand[]" id="brand_<?= $counter; ?>"><option value="" selected></option></select></td>	 
			<td>
            <input type="text" name="quantity[]" tabindex="1" id="quantity_<?= $counter; ?>" onclick="row_sum(<?= $counter; ?>)" size="2" value="<?= $row->qty; ?>" class="form-control" onkeyup="row_sum(<?= $counter; ?>)"></td><td> 
             <input type="text" name="spares_rate[]" class="form-control spares_amount"  required onkeyup="row_sum(<?= $counter; ?>)"  onchange="row_sum(<?= $counter; ?>)"  id="spares_<?= $counter; ?>" size="6" value="<?= $row->spares_rate; ?>"></td>
			<td> 
            <input type="text" name="labour_rate[]" class="form-control"  required onkeyup="row_sum(<?= $counter; ?>)"  id="labour_<?= $counter; ?>" size="6" value="<?= $row->labour_rate; ?>"></td>
			<td>  
			<input type="text" name="total_rate[]"  class="form-control input-totalrate" required onkeyup="row_sum(<?= $counter; ?>)"  id="total_<?= $counter; ?>" size="6" value="<?= $row->amount; ?>"></td>
								
			
			 
			<input type="hidden" name="coupon_applied[]"  class="form-control"   id="coupon_applied_<?= $counter; ?>" size="6" value="<?= $row->coupon_applied; ?>"> 			
				
								
								
			<td> 
			<button type="button" class="btn btn-danger btn-delete"><i class="fas fa-trash"></i></button></td>
			</tr>
				
       		<?php  
				if($row->item_type="Spare"){ 			
			  $spares_array[] = $row->item_id;
			?>
			 
			<?php			
				}elseif($row->item_type="Labour"){ 				
			  $labour_array[] = $row->item_id;		
				?>
			 
			 <?php
			}
			$counter++;  
			}
								
			$estimate_counter = $counter;				
			
			?>
							
                        </tbody>
                      </table>
                    </div>
                  </div>
					</div>   
                </div>
              </div>
            
				<div class="col-md-12" id="complaints_tables_div">
					
					<?php 
							$complain_counter = 1;
							$complaint_number = 1;
							//$single_complain = 0;
				 $all_complain_details = $this->Bookings->getbooking_jobcard_details($booking->booking_id, 'booking_id = "'.$booking->booking_id.'" AND item_type="Complaints" AND  status="Active"');
							$complaint_serial = 0;
							if($all_complain_details)
							foreach ($all_complain_details as $row){ 
							
							
								 
										if($row->complaint_number!=$complaint_number){
											 $complaint_number++;
											// $single_complain = 0;
											 $complaint_serial = 0;
											$complaint_array[] = $row->complaints; 
											echo '</tbody></table></div></div></div></div>';
											
										}
								
								$complaint_serial++;
										
										
										if($complaint_serial==1){
									
							?>
				 <div class="card-complaints card card-info" id="card_complaints_<?= $complaint_number; ?>"><div class="card-header"> <h4>Complaint <?= $complaint_number; ?>: <?= $row->complaints; ?></h4> <div class="card-header-action col-md-6"> <button style="display: none;" type="button" class="btn btn-danger float-right" onclick="deleteComplaint(<?= $complaint_number; ?>, '<?= $row->complaints; ?>')"><i class="fas fa-trash"></i></button> </div>   </div> <div class="collapse show" id="complaint-collapse-<?= $complaint_number; ?>" style="">  <div class="card-body"> <div class="row">  
			 <table class="table table-striped tables-complaints" id="complaintstable_<?= $complaint_number; ?>">  
                        <thead>  
                          <tr> 
                            <th>#</th>
                            <th>Description</th>
                            <th>Brand</th>
                            <th>Quantity</th>
                            <th>Spares</th>
                            <th>Labour</th>
                            <th>Total</th> 
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                          
							<?php }
							//$complaint_serial++;
							?>
							<tr id="complain_row_<?= $complain_counter; ?>">
							<td> 
			<input type="hidden" name="estimate_row[]" value="<?= $complain_counter; ?>"><input type="hidden" name="item_id[]" value="<?= $row->item_id; ?>"><input type="hidden" name="complaint_number[]" value="<?= $row->complaint_number; ?>"><input type="hidden" name="complaints[]" value="<?= $row->complaints; ?>">
			<input type="hidden" class="itemtype" name="itemtype[]" value="<?= $row->item_type; ?>"><input type="hidden" name="jobdet_ID[]" value="<?= $row->id;  ?>" />
			Option <?= $complaint_serial; ?></td>
			<td> 					
            <input type="hidden" class="input_itemcode" name="sparesid[]" value="<?= $row->item_id; ?>"><input type="hidden" name="item_name[]" value="<?= $row->item; ?>"><?= $row->item; ?></td>
			  
			<td><select class="form-control select-ajax-spares-brand" data-spareid="<?= $row->item_id; ?>"  name="brand[]"  style="width: 100%;" id="brand_<?= $complain_counter; ?>"><option value="" selected></option></select></td>					
			<td>
            <input type="text" name="quantity[]" tabindex="1" id="quantity_<?= $complain_counter; ?>" onclick="complain_row_sum(<?= $complaint_number; ?>,<?= $complain_counter; ?>)" size="2" value="<?= $row->qty; ?>" class="form-control" onkeyup="complain_row_sum(<?= $complain_counter; ?>)"></td><td> 
             <input type="text" name="spares_rate[]" class="form-control spares_amount"  required onkeyup="complain_row_sum(<?= $complaint_number; ?>,<?= $complain_counter; ?>)" onchange="complain_row_sum(<?= $complaint_number; ?>,<?= $complain_counter; ?>)"  id="spares_<?= $complain_counter; ?>" size="6" value="<?= $row->spares_rate; ?>"></td>
			<td> 
            <input type="text" name="labour_rate[]" class="form-control"  required onkeyup="complain_row_sum(<?= $complaint_number; ?>,<?= $complain_counter; ?>)"  id="labour_<?= $complain_counter; ?>" size="6" value="<?= $row->labour_rate; ?>"></td>
			<td>  
			<input type="text" name="total_rate[]"  class="form-control input-complaint_totalrate" required onkeyup="complain_row_sum(<?= $complaint_number; ?>,<?= $complain_counter; ?>)"  id="total_<?= $complain_counter; ?>" size="6" value="<?= $row->amount; ?>"></td>
			<td><button type="button" onClick="delete_complain_row(<?= $complain_counter; ?>);" class="btn btn-danger btn-delete"><i class="fas fa-trash"></i></button></td>
			</tr>
				
       		   
					 <?php  $complain_counter++; 
							
										
							
							} ?>
						 
						</tbody></table></div></div></div></div>			
							
					 
					
				</div>
				
				<div class="col-md-12" id="comments_div"> 	
				<div class="form-group">
                      <label>Comments</label>
					  <textarea class="form-control" rows="5" cols="100" name="comments" id="comments"><?= @$jobcard->remark ?></textarea> 
                    </div>
					 
					
					<input class="form-control" value="" id="total_estimate_sum" type="hidden" name="total_estimate_sum">
					<input class="form-control" value="" id="max_complaints_val" type="hidden" name="max_complaints_val">
					<input class="form-control" value="" id="min_complaints_val" type="hidden" name="min_complaints_val">
					
					 	
				</div>	
				
				
				<div class="col-md-6"> 	
					<div class="form-group">
                      <label>Total Amount: </label>
					  <input class="form-control" value="0" id="totalcombined_all" type="text" readonly name="totalcombine_max"> 	
                    </div>
				</div>		 
					
					 
				<div class="col-md-6"> 	
					<div class="form-group">
                      <label>Discount: </label>
					  <input class="form-control" value="<?= @$booking_payments->discount ?>" id="discount" type="number"  name="discount"> 	
                    </div>
				</div>
					
					 
				<div class="col-md-6"> 	
					<div class="form-group">
                      <label>Service Advance: </label>
					  <input class="form-control" value="<?= @$jobcard->service_advance ?>" id="service_advance" type="number" name="service_advance"> 	
                    </div>
				</div>		 
					
					 
				<div class="col-md-6"> 	
					<div class="form-group">
                      <label>Round Off: </label>
					  <input class="form-control" value="<?= @$jobcard->round_off ?>" id="round_off" type="number"  name="round_off"> 	
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
<!--Modal for EDIT -->
<div class="modal fade" role="dialog"  id="edit_service_category">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Edit Service Category</h4>
            </div>
            <?php $attributes = array('class' => 'form-horizontal group-border hover-stripped editform', 'id' => 'editform', 'method' => 'post');
            echo form_open_multipart('bookings/edit_service_category', $attributes); ?>
            <div class="modal-body"> 
		 
				 <input type="hidden" id="booking_id" name="booking_id" value="<?php echo @$booking->booking_id; ?>" />  
				  <div style="display: none;">
				<select class="form-control select-ajax-city" style="width: 100%;"  placeholder="City" id="city_dummy" name="city_dummy"> 
								<option selected value="<?php echo @$booking->customer_city; ?>"><?php echo @$booking->customer_city; ?></option> 
								</select>
							
							
							  <select class="form-control select-ajax-area" id="area" placeholder="Area" name="area">
								<option selected value="<?php echo @$booking->customer_area; ?>"><?php echo @$booking->customer_area; ?></option>
								</select>
							
							<input class="form-control input-vehiclecategory" id="vehicle_category" value="<?php echo @$model->vehicle_category; ?>" type="hidden" name="vehicle_category">
				
				</div> 
				<div class="form-group col-md-12"><label>Service Category:   </label>
								<select class="form-control" style="width: 100%;"  placeholder="Service Category" id="select-ajax-service-category" name="service_category">
								<option selected value="<?php echo $this_service_category; ?>"><?php echo $this_service_category; ?></option> 
								</select>
							<input name="service_category_rate" id="service_category_rate" type="hidden" value="" />
							<div class="selected_service_category p-3" style="display: none;"></div>
						</div> 
				

            </div>
            <div class="modal-footer">
				<?php echo $this->rbac->updatePermission; ?>
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button> 
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!--Modal for EDIT ends-->











<?php $this->session->unset_userdata('customer'); 

$break_com = explode("+", $booking->complaints);
if(!empty($break_com)){ 
foreach($break_com as $complained){
	if(!empty($complained)){ 
	$com_arr[] = $complained;
	}
}
}
if(!empty($com_arr)){ 
$this->session->set_userdata('complain_array',  $com_arr);
}

$this->session->set_userdata('estimate_counter', $estimate_counter);				

$this->session->set_userdata('complain_counter', $complain_counter);
?>