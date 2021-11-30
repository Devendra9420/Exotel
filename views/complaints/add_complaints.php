 <div class="section-body">
            <h2 class="section-title">Search Booking</h2> 
	 
    <div class="row">
        <div class="col-lg-12">
      		<div class="panel">
                 
                <div class="panel-body">
                     
						<?php $attributes = array('class' => 'form-horizontal group-border hover-stripped', 'id'=>'search_form', 'method' => 'post');
                echo form_open_multipart('complaints/add_complaints', $attributes); ?>
						 
						<div class="form-row">
						<div class="form-group col-md-6">
                                <label>Booking Id</label>
                                <input class="form-control" placeholder="Search By Booking Id" id="booking_id" type="number" value="<?php echo @$booking_id;?>" name="booking_id">
                        </div>
							
						<div class="form-group col-md-6">
                                <label>Mobile Number</label>
                                <input class="form-control" placeholder="Search By Customer Mobile" id="mobile" type="number" value="<?php echo @$mobile;?>" name="mobile">
                        </div>	
				  
							
							 <div class="form-group col-lg-12" style="text-align: center;">
                        <button type='submit' name="search_book" class="btn dark btn-info" id='search_book' placeholder=''>Search</button>
                    </div>
							
							</form>
				</div>
							
							<?php $attributes = array('class' => 'form-horizontal group-border hover-stripped', 'id'=>'addedit_form', 'method' => 'post');
                echo form_open_multipart('complaints/add_new_complaint', $attributes); ?>
					
				<input type='hidden' name="booking_id" class='form-control' value="<?php echo @$booking_id; ?>" id='booking_id' placeholder=''>
				
				<div class="col-md-12" id="bookingcard"> 	
						 	
							<div class="card-booking card card-info" id="card_booking">
                  <div class="card-header"> 
					  
                     <h4>Booking Details <?php if(!empty($booking_id)){ echo '<a href="'.base_url().'bookings/booking_details/'.$booking_id.'" target="_blank">View Details</a>'; } ?>	  </h4> 
					<div class="card-header-action col-md-3">
				
                      <a data-collapse="#booking-collapse" class="btn btn-icon btn-info float-right" href="#"><i class="fas fa-minus"></i></a>
                    </div>  
                  </div>
				<div class="collapse" id="booking-collapse" style="">			
				 <div class="card-body">
					 <div class="row">
					<?php if(!empty($booking_id)){  ?>	 
					 
					<div class="col-md-6"> Booking Id: </div><div class="col-md-6"><?php echo $booking->booking_id; ?>	</div> 	 
					<div class="col-md-6"> Customer Name: </div><div class="col-md-6"><?php echo $booking->customer_name; ?>	</div> 
					<div class="col-md-6"> Channel: </div><div class="col-md-6"><?php echo $booking->customer_channel; ?>	</div>  
					<div class="col-md-6"> Mobile: </div><div class="col-md-6"><?php echo $booking->customer_mobile; ?>	</div>   
						 <div class="col-sm-6"> Service Date  </div> <div class="col-sm-6"> <?php echo convert_date($booking->service_date); ?>  </div>   
							
						 <?php  $make  = $this->Common->single_row('vehicle_make', array('make_id' =>  $booking->vehicle_make), 'make_name');  
							$model  = $this->Common->single_row('vehicle_model', array('model_id' =>  $booking->vehicle_model), 'model_name'); 								 
							 	?> 
							<div class="col-sm-6">Make</div> <div class="col-sm-6">  <?php echo $make; ?>  </div> 
							<div class="col-sm-6">Model</div> <div class="col-sm-6">  <?php echo $model; ?>  </div>  
							
						  <div class="col-sm-6"> Service Category  </div>  <div class="col-sm-6"> <?php echo get_service_category($booking->service_category_id); ?>  </div> 
						
						 <div class="col-sm-6"> Total Amount</div> <div class="col-sm-6">  <?php echo $booking_payments->total_amount; ?>  </div>
						 <div class="col-sm-6"> Mode of Payment</div> <div class="col-sm-6">  <?php echo $booking_payments->payment_mode; ?>  </div>
						 <div class="col-sm-6"> Assigned Mechanic</div> <div class="col-sm-6">  <?php echo @get_service_providers(array('id'=>$booking->assigned_mechanic),'name'); ?>  </div>
						  <div class="col-sm-6">Feedback</div> <div class="col-sm-6">  <?php echo @$booking_feedback->feedback; ?>  </div>
							 <div class="col-sm-6"> Complaints</div> <div class="col-sm-6"> 
							
							  <?php
							  $complaints_split = explode('+', $booking->complaints);
						$n =1;
						foreach ($complaints_split as $complaint_list){
							if(!empty($complaint_list)){   
							echo $n.') '. $complaint_list;//$this->Common->single_row('complaints',array('id'=>$complaint_list),'complaints').'<br>';
							$n++;
							}
						}
						?> 
							  </div>   
							<div class="col-sm-6"> Comments</div> <div class="col-sm-6">  <?php echo @$booking->comments; ?>  </div>   
						 <?php } ?>
					</div> 
				</div>
				</div>
					</div>
					</div>
				
				
					<div class="form-row">
						
						<div class="form-group col-md-6"> 
                                <label>Complaint</label>
                               <select class="form-control select2" name="complaint" id="complaint" style="width: 100%;">
							  <option value="">Select</option> 
							<option value="Mechanic was rude">Mechanic was rude</option>
<option value="Service Manager / Staff Rude">Service Manager / Staff Rude</option>
<option value="No-show">No-show</option>
<option value="Work quality not good">Work quality not good</option>
<option value="Vehicle complaints not resolved">Vehicle complaints not resolved</option>
<option value="New vehicle issues after service">New vehicle issues after service</option>
<option value="Delivered incomplete service">Delivered incomplete service</option>
<option value="Mechanic not carrying spares">Mechanic not carrying spares</option>
<option value="Mechanic did not complete 21 point service">Mechanic did not complete 21 point service</option>
<option value="Vehicle not cleaned properly">Vehicle not cleaned properly</option>  
							  </select> 
                        </div>
					  
						<div class="form-group col-md-6">	
                            <label>Medium</label>
								<select class="form-control select2" name="medium" id="medium" style="width: 100%;">
							  <option value="">Select</option> 
								<option value="Google">Google</option>
								<option value="Social Media">Social Media</option>
								<option value="Call Center">Call Center</option>
								<option value="Email">Email</option>
								<option value="Others">Others</option> 
							  </select> 
                         </div>
				
                        <div class="form-group col-md-6"> 
                                <label>Remark/Comments</label>
					  <textarea class="form-control" rows="5" cols="100" name="comments" id="comments"></textarea>
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