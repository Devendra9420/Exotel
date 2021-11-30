
 <div class="section-body">
            <h2 class="section-title">Booking ID# <?= $booking->booking_id; ?></h2>
            <p class="section-lead"> 
				<h6 class="label label-primary">Status: <?= $booking->status; ?></h6> 
	 		<div class="btn-group drop-right mb-2">
                      <?php if($booking->status!="Cancelled"){ ?>
					  <button class="btn btn-warning btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Action
                      </button>
					  <?php } ?>
				<div class="dropdown-menu dropright" x-placement="right-start" style="position: absolute; transform: translate3d(95px, 0px, 0px); top: 0px; left: 0px; will-change: transform;">  
					<?php if(!empty($booking_service->service_stage)){ $booking_service_stage = $booking_service->service_stage; }else{ $booking_service_stage = 'not_started'; } ?>
						 <?php if($this->rbac->check_sub_module_permission($this->uri->segment(1),$this->uri->segment(2), 'reschedule')==1 && in_array($booking_service_stage, array('not_started','start_trip','reached','inspection_done'))){  ?>
                        <a href="#mod_reschedulebooking" data-toggle="modal" data-target="#mod_reschedulebooking" class="dropdown-item has-icon label-info"><i class="ion-loop"></i> Reschedule Booking</a>
						   <?php } ?>
						 <a href='<?= base_url() ?>bookings/add_booking/followup_booking/<?php echo $booking->booking_id; ?>'  id="followbooking" class='dropdown-item has-icon label-info'> 
                         <i class="ion-reply-all"></i> Follow-Up Booking</a>  
                        <div class="dropdown-divider"></div>
						  
                        <?php if($this->rbac->check_sub_module_permission($this->uri->segment(1),$this->uri->segment(2), 'cancel')==1){ 
						if($booking->status!="Completed" && $booking->status!="Cancelled" && $booking->stage!="Completed" && $booking->stage!="Cancelled" && $booking->stage!="Started Service" && $booking->stage!="Service Work End" && $booking->stage!="Submit Report" && $booking->stage!="End Booking" && in_array($booking_service_stage, array('not_started','start_trip','reached','inspection_done','start_work'))){ ?>
						<a href="#mod_cancel" data-toggle="modal" data-target="#mod_cancel" class="dropdown-item has-icon label-danger"><i class="ion-trash-b"></i> Cancel Booking</a>
						<?php }
							} ?>
						  <?php if($this->rbac->check_sub_module_permission($this->uri->segment(1),$this->uri->segment(2), 'service_action')==1 && !empty($booking->assigned_mechanic)){ 
						 if(in_array($booking_service_stage, array('not_started','start_trip','','reached')) && $booking_service->status='Ongoing'){ ?>
					<a href='#mod_doInspection' data-toggle='modal' class="btn btn-info">Upload Inspection Data</a> 	
						 <?php }elseif(in_array($booking_service_stage, array('inspection_done','start_work')) && $jobcard->customer_approval=="Yes"){  ?>
					<a href='#mod_doEndWork' data-toggle='modal' class="btn btn-info">End Work</a> 
						  <?php }elseif(in_array($booking_service_stage, array('end_work'))){  ?>
					<a href='#mod_doSubmitReport' data-toggle='modal' class="btn btn-info">Submit Report</a> 
						  <?php }elseif(in_array($booking_service_stage, array('submit_report'))){  ?>
					<a href='#mod_doEndBooking' data-toggle='modal' class="btn btn-info">Process Payment</a> 		
						 <?php }   
							} ?>
                      </div>
                    </div>
            </p> 
	<div class="row">
        <div class="col-lg-12">
               
				<div class="box box-primary">
				 <div class="box-header text-right">   
					 <a href="<?php if(!empty($_SERVER['HTTP_REFERER'])){ echo $_SERVER['HTTP_REFERER']; }else{ echo $this->uri->uri_string(); } ?>" class="btn btn-sm btn-info">Back</a>
					 
                </div>
				
					
				<div class="box-body">
     
            	<div class="row">
					<div class="col-9 col-sm-12 col-md-9">
					
					
                <!-- Nav tabs -->
                <ul class="nav nav-pills" role="tablist">
                    <li class="nav-item"><a class="nav-link active" href="#Section1" aria-controls="customer" role="tab" data-toggle="tab">Customer </a></li>
                    <li class="nav-item"><a class="nav-link" href="#Section2" aria-controls="service" role="tab" data-toggle="tab">Service </a></li> 
					<li class="nav-item"><a class="nav-link" href="#Section4" aria-controls="payments" role="tab" data-toggle="tab">Payments </a></li> 
					<li class="nav-item"><a class="nav-link" href="#Section7" aria-controls="ledger" role="tab" data-toggle="tab">Ledger </a></li>  
					<li class="nav-item"><a class="nav-link" href="#Section3" aria-controls="messages" role="tab" data-toggle="tab">Past History</a></li> 
					<li class="nav-item"><a class="nav-link" href="#Section6" aria-controls="track" role="tab" data-toggle="tab">Notes </a></li>
                </ul>
				
				
				<div class="tab-content">
                   
					<div role="tabpanel" class="tab-pane fade show active" role="tabpanel"  id="Section1">
                        
						
					<div class="card"> 
					<div class="card-header with-border">
                    	<div class="row">
						<div class="col-md-6">	<h5 class="card-title">Details</h5> </div>
						<div class="col-md-6 text-right">	
						<span class=""><a href='#editBookingAddress' data-toggle='modal' class="btn btn-info">Update Details</a> 	</span>	
						</div>	
						</div>
            		</div>  
					<div class="card-body"> 
					<div class="row">
					<div class="col-md-5"> Customer Name: </div><div class="col-md-7 w-100">&nbsp;<?= $booking->customer_name; ?>	</div> 
					<div class="col-md-5"> Mobile: </div><div class="col-md-7">&nbsp;<?= $booking->customer_mobile; ?>	</div>  
					<div class="col-md-5"> Alternate No: </div><div class="col-md-7"><?= $booking->customer_alternate_no; ?>	</div> 
					<div class="col-md-5"> Email: </div><div class="col-md-7 w-100">&nbsp;<?= $booking->customer_email; ?>	</div> 
					<div class="col-md-5"> Channel: </div><div class="col-md-7 w-100">&nbsp;<?= $booking->customer_channel; ?>	</div>	
					<div class="col-md-5"> Customer Type: </div><div class="col-md-7 w-100">&nbsp;<?php if($booking->customer_type=='new'){ echo 'New'; }elseif($booking->customer_type=='old'){ echo 'Existing'; } ?>	</div>	
					</div> 
					</div> 	 
					</div> 	
					 
					 
					
						 
					<div class="card"> 
					<div class="card-header with-border">  
             		<h5 class="card-title">Address</h5>
            		</div>
					 <div class="card-body">
						 
					<div class="row">
					<div class="col-md-5"><h6><i> Type: </i></h6></div><div class="col-md-7 w-100">&nbsp;<?= @$booking->customer_address_type; ?>	</div> 
					<div class="col-md-5"> Address: </div><div class="col-md-7 w-100">&nbsp;<?= @$booking->customer_address; ?>	</div> 
					<div class="col-md-5"> Google Map: </div><div class="col-md-7">&nbsp;<?= @$booking->customer_google_map; ?>	</div> 
					<div class="col-md-5"> Area: </div><div class="col-md-7">&nbsp;<?= @$booking->customer_area; ?>	</div> 
					<div class="col-md-5"> Pincode: </div><div class="col-md-7">&nbsp;<?= @$booking->customer_pincode; ?>	</div>	 
					<div class="col-md-5"> City: </div><div class="col-md-7">&nbsp;<?= @$booking->customer_city; ?>	</div>		 
					 </div>
					 
					</div>
					</div>  
					 
					 
					 </div>	 
					
					  
				
					<div role="tabpanel" class="tab-pane fade" role="tabpanel"  id="Section2">
                    <div class="card">  
					<div class="card-header with-border">
                    <h5 class="card-title">Vehicle Details</h5>
            		</div>
						
					 <div class="card-body">  
						 
						 <div class="row"> 
							<div class="col-sm-6">  Vehicle ID.  </div>  <div class="col-sm-6"> <?php echo $booking->vehicle_id; ?>  </div> 
							<div class="col-sm-6"> Vehicle Reg No.  </div> <div class="col-sm-6"> <?php echo @$booking->vehicle_regno; ?>  </div>  
						 <?php  $make  = $this->Common->single_row('vehicle_make', array('make_id' =>  $booking->vehicle_make), 'make_name');  
							$model  = $this->Common->single_row('vehicle_model', array('model_id' =>  $booking->vehicle_model), 'model_name'); 								 
							 	?> 
							<div class="col-sm-6">Make</div> <div class="col-sm-6">  <?php echo $make; ?>  </div> 
							<div class="col-sm-6">Model</div> <div class="col-sm-6">  <?php echo $model; ?>  </div>  
							<div class="col-sm-6">Km Reading</div> <div class="col-sm-6">  <?php echo @$booking->vehicle_km_reading; ?>  </div>
							<div class="col-sm-6">Year of make</div> <div class="col-sm-6">  <?php echo @$booking->vehicle_yom; ?>  </div> 
							<div class="col-sm-6">Last Service Id</div>
                            <div class="col-sm-6"> <?php if(!empty($booking->vehicle_last_service_id)){  ?>  <a style="padding:5px;" target="_blank" href="<?=base_url('bookings/booking_details/')?><?php echo $booking->vehicle_last_service_id; ?>" class="label-info">(View - <?php echo $booking->vehicle_last_service_id; ?>)</a>  <?php } ?> </div>  
                        </div>	
						 
						 
					 </div>
					</div> 
						
						  <div class="card">  
								<div class="card-header with-border">
								<h5 class="card-title">Service Details</h5>
								</div>
						
					 <div class="card-body">  
						 
						 <div class="row"> 
							  
							<div class="col-sm-6"> Service Category  </div>  <div class="col-sm-6"> <?php echo get_service_category($booking->service_category_id); ?>  </div> 
							<div class="col-sm-6"> Service Date  </div> <div class="col-sm-6"> <?php echo convert_date($booking->service_date); ?>  </div>   
							<div class="col-sm-6"> Time Slot</div> <div class="col-sm-6">  <?php echo $booking->time_slot; ?>  </div> 
							 <div class="col-sm-6"> Complaints</div> <div class="col-sm-6"> 
							
							  <?php
							  $complaints_split = explode('+', $booking->complaints);
						$n =1;
						foreach ($complaints_split as $complaint_list){
							if(!empty($complaint_list)){   
							echo $n.') '. $complaint_list.'<br>'; //$this->Common->single_row('complaints',array('id'=>$complaint_list),'complaints').'<br>';
							$n++;
							}
						}
						?> 
							  </div>   
							 
                        </div>	
						  </div> 
							   </div> 
						    
						   <div class="card">  
								<div class="card-header with-border">
								<h5 class="card-title">Mechanic Details</h5>
								</div>
						
					 <div class="card-body">  
						 
						 <div class="row">  
							<div class="col-sm-6"> Mechanic Name  </div> <div class="col-sm-6"> <?php echo @get_service_providers(array('id'=>$booking->assigned_mechanic),'name'); ?>  </div>   
							<div class="col-sm-6"> Mechanic ID</div> <div class="col-sm-6">  <?php echo @$booking->assigned_mechanic; ?>  </div>  
                        </div>	
						  </div> 
							   </div>
						
						  <div class="row"> 
							
							  <?php  
				if(!empty($jobcard->id)){
					$jobcard_id = $jobcard->id;  
					$est_active = "";
					$est_tab = ''; 
					$job_active = 'active';
					$job_tab = 'active show'; 
					$job_approved =  $jobcard->customer_approval;
					$jobcard_attempt = $jobcard->jobcard_attempt; 
				}else{
					$jobcard_id = 0;
					$est_active = 'active'; 
					$est_tab = 'active show'; 
					$job_active = "";
					$job_tab = ''; 
					$job_approved = 'No';
					$jobcard_attempt = 0;
				} 
				?>
							  
							  
							<div class="card"> 
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12 col-sm-12 col-md-12">
                        <ul class="nav nav-pills mb-5" id="jobcardtabs" role="tablist">
                         
							<?php   if($jobcard){ ?>
							<li class="nav-item">
                            <a class="nav-link <?= $job_active; ?>" id="jobcard_pill" data-toggle="tab" href="#jobcard_tab" role="tab" aria-controls="jobcard_tab">Jobcard</a>
                          	</li>
							<?php } ?>
							
                          	<?php if($job_approved  =='Yes'){ ?> 
							<li class="nav-item">
                            <a class="nav-link" id="rejected_jobcard_pill" data-toggle="tab" href="#rejected_jobcard_tab" role="tab" aria-controls="rejected_jobcard_tab">Rejected Jobcard</a>
                          	</li>
							<?php } ?> 
							
                          	<li class="nav-item">
                            <a class="nav-link <?= $est_active; ?>"  id="estimate_pill" data-toggle="tab" href="#estimate_tab" role="tab" aria-controls="estimate_tab" >Estimate</a>
                          	</li>
							
                        </ul>
                       
						  
                        	<div class="tab-content no-padding" id="jobcardtabs_content">
							
                          <div class="tab-pane fade <?= $job_tab; ?>" id="jobcard_tab" role="tabpanel" aria-labelledby="jobcard">
                          <?php   if($jobcard){ ?>
							  
							  <div class="row"> 
							<div class="col-12 col-sm-12 col-md-12">
							<h5>Active Jobcard <?php 
									  if($this->rbac->check_sub_module_permission($this->uri->segment(1),$this->uri->segment(2), 'edit_jobcard')==1){ 
									  if($booking->status!="Cancelled" && $booking->status!="Completed"){ 
								   ?>
                        <a href="<?=base_url('bookings/edit_jobcard/'.$booking->booking_id)?>" class="btn btn-sm btn-warning">Edit Jobcard</a> 
								<?php 
									   } 
						
									  }
									?>		</h5>		
							</div>	
							 <hr>  
							   
						   <div class="col-12 col-sm-12 col-md-6">   
								 <?php  echo form_open_multipart(base_url() . 'index.php/bookings/approve_jobcard', array('method' => 'post')); ?> 
							   
							   <div class="form-group row">
							<label class="col-sm-3 col-form-label">Customer Approved:</label>
								<div class="col-sm-3">	   
							 <select name="customer_approval" id="customer_approval" style="width: 100%;" class="form-control select2  mx-sm-3">
							<option>Select</option>
							<option <?php if($job_approved  =='Yes'){ echo 'selected'; } ?> value="Yes">Yes</option>
							<option <?php if($job_approved  =='No'){ echo 'selected'; } ?> value="No">No</option>
							<option <?php if($job_approved  =='Sent'){ echo 'selected'; } ?> value="Sent">Sent</option>	 
							</select>
							   	</div>
								    <div class="col-sm-3">
								 <?php 
								    
									if($this->rbac->check_sub_module_permission($this->uri->segment(1),$this->uri->segment(2), 'customer_approval')==1){ 
										if($booking->status!="Cancelled"){ 
										?>
									 
					    	<?php 
							$service_advance_demanded_amt =   $this->payments->get_ledger($booking->booking_id, 'service_advance', 'requested_amount');
							$service_advance_received_amt =   $this->payments->get_ledger($booking->booking_id, 'service_advance', 'received_amount');  
							$service_advance_tobe_paid = $service_advance_demanded_amt-$service_advance_received_amt;
							?> 
										
										
						   <?php if($job_approved!='Yes'){ 
								  			if($service_advance_tobe_paid>0){ ?>
      <span style="padding: 7px;"  class="label-warning">Service advance for Rs. <?php echo $service_advance_tobe_paid; ?>/- is still not paid by the customer.</span>		 								<?php	}else{  ?>
								
                      <button class="btn btn-success" type="submit">Update</button>
							<?php				
											}
								   
						     }   
										}
										
									}
								?>
								   </div>
                    			</div> 
							    
						   <input type="hidden" name="jobcard_id" id="jobcard_id" value="<?php echo $jobcard_id; ?>" />
						   <input type="hidden" name="jobcard_attempt" id="jobcard_attempt" value="<?php echo $jobcard_attempt; ?>" />
						   <input type="hidden" name="booking_id" class="form-control input-medium" value="<?php echo $booking->booking_id; ?>"/>
								   
							   
							   </form>
							   </div>
							   <div class="col-6 col-sm-6 col-md-3">
								<?php if($booking->status!="Cancelled"){ 
									if($job_approved!='Yes'){ ?>
							 
							   <?php if($job_approved=='Sent'){ ?>
							 <span style="padding: 7px;"  class="label-warning">Waiting for customer approval..</span>
							   <?php }else{  ?>
							   <a href="<?php echo base_url() . 'index.php/bookings/get_customer_approval/'.$booking->booking_id; ?>"  class="btn btn-md  btn-warning">Get customer approval</a>
							   <?php }  
									}
								      }
								   ?>
								
							   </div>	
							   <div class="col-6 col-sm-6 col-md-3">
						 		&nbsp;<span style="display: none;" class=""><b>Comments:</b><br> <?php echo @$jobcard->remark;  ?></span>
							   </div>  
                    	    
							  
							  <div class="col-xs-12">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>#</th> 
									<th>Service/Complaint</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
									<th>Brand</th>
                                    <th>Spares Cost</th>									
                                    <th>Labour Cost</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>
								<?php
								$n = 1;	
								$total_jobcard_amount = 0;					
								if($jobcard_details)	
                                foreach ($jobcard_details as $rows) {
                                ?> 
                                    <tr>
                                        <td><?php echo $n; ?></td> 
                                        <td><?php echo $rows->complaints; ?></td>
										<td><?php echo $rows->item; ?></td>
                                        <td><?php echo $rows->qty; ?></td>
                                        <td><?php echo $rows->brand; ?></td>
										<td><?php echo $rows->spares_rate; ?></td>
										<td><?php echo $rows->labour_rate; ?></td>
                                        <td><?php echo $rows->amount; ?></td>
                                    </tr>
                                    <?php $n++;
									$total_jobcard_amount += $rows->amount;
                                } ?>

                                </tbody>
                            </table>
								  <div class="row">
								  <div class="col-md-6"> 	
					<div class="form-group">
                      <label>Total Amount: </label>
					  <input class="form-control" value="<?php echo $total_jobcard_amount; ?>" id="totalcombine_max" type="text" readonly name="totalcombine_max"> 	
                    </div>
				</div>		 
					
					 
				<div class="col-md-6"> 	
					<div class="form-group">
                      <label>Discount: </label>
					  <input class="form-control" value="<?= @$booking_payments->discount ?>" id="discount" type="number"  name="discount"> 	
                    </div>
				</div>	
						</div>
								  
                        </div>
							   </div>
					
					  <?php } ?>
					  
                          </div>
							
                            <?php if($job_approved  =='Yes'){ ?> 
							<div class="tab-pane fade" id="rejected_jobcard_tab" role="tabpanel" aria-labelledby="rejected_jobcard_tab">
                            
							<div class="row"> 
								
								<div class="col-12 col-sm-12 col-md-6">
								<h5>Rejected Jobcard</h5>		
								</div>	
								
								<div class="col-12 col-sm-12 col-md-6 text-right">
								<span class=""><b>Comments:</b><br> <?php echo $jobcard->remark;  ?></span>
								</div>
							
								<div class="col-xs-12">
                            		<table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>#</th> 
									<th>Service/Complaint</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
									<th>Brand</th>
                                    <th>Spares Cost</th>									
                                    <th>Labour Cost</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>
								<?php
								$n = 1;	
										 
								if($jobcard_rejected_details)							 
                                foreach ($jobcard_rejected_details as $rows) {
                                ?> 
                                    <tr>
                                        <td><?php echo $n; ?></td> 
                                        <td><?php echo $rows->complaints; ?></td>
										<td><?php echo $rows->item; ?></td>
                                        <td><?php echo $rows->qty; ?></td>
                                        <td><?php echo $rows->brand; ?></td>
										<td><?php echo $rows->spares_rate; ?></td>
										<td><?php echo $rows->labour_rate; ?></td>
                                        <td><?php echo $rows->amount; ?></td>
                                    </tr>
                                    <?php $n++;
									
                                } ?>

                                </tbody>
                            		</table>
								
                        		</div>	
								
							</div>	
                          	</div>
							<?php } ?> 
						  
							
						  <div class="tab-pane fade <?= $est_tab; ?>" id="estimate_tab" role="tabpanel" aria-labelledby="estimate_tab">
                            <div class="row"> 
								
							<div class="col-12 col-sm-12 col-md-6">
							<h5>Estimate</h5>	
							</div>	
							
							<div class="col-12 col-sm-12 col-md-6 text-right">
									<?php if($booking->status!="Cancelled"){ 
											if($jobcard_id<1){  
											echo $this->rbac->createPermission_custom;
									  }
										}
								?>
							</div>	
                        	
									<div class="col-12 col-sm-12 col-md-12">
										<table class="table table-striped table-hover">
											<thead>
											<tr>
												<th>#</th> 
												<th>Complaint</th>
												<th>Item</th>
												<th>Quantity</th> 
												<th>Spares Cost</th>									
												<th>Labour Cost</th>
												<th>Amount</th>
											</tr>
											</thead>
											<tbody>
											<?php $n = 1; 
											foreach ($estimate_details as $rows) {
												?> 
												<tr>
													<td><?php echo $n; ?></td> 
													<td><?php echo $rows->complaints; ?></td>
													<td><?php echo $rows->item; ?></td>
													<td><?php echo $rows->qty; ?></td> 
													<td><?php echo $rows->spares_rate; ?></td>
													<td><?php echo $rows->labour_rate; ?></td>
													<td><?php echo $rows->amount; ?></td>
												</tr>
												<?php $n++;
											} ?> 
											</tbody>
										</table>
                        			</div>
								</div>
                          </div>
						  
							
							
							
                        </div>
						
                      </div>
                    </div>
                  </div>
                </div>  
							  
							  
							  
                        </div>	
						
						
	   				</div>	 
			 
					 
						
					
					<div role="tabpanel" class="tab-pane fade" role="tabpanel"  id="Section4">
						   <div class="card">  
								<div class="card-header with-border">
								<h5 class="card-title">Details</h5>
								</div>
						
					 <div class="card-body">  
						 
						 <div class="row">  
							<div class="col-sm-6"> Estimated Amount  </div>  <div class="col-sm-6"> &nbsp; <?php echo @$booking_payments->estimated_amount; ?>  </div> 
							<div class="col-sm-6"> Additional Discount  </div> <div class="col-sm-6"> &nbsp;  <?php echo @$booking_payments->discount; ?>  </div>   
							<div class="col-sm-6"> Payable Amount</div> <div class="col-sm-6"> &nbsp;  <?php echo @$booking_payments->net_payable; ?>  </div> 
							<div class="col-sm-6"> Payment Status</div> <div class="col-sm-6"> &nbsp;  <?php echo @$booking_payments->payment_status; ?>  </div>   
							<div class="col-sm-6"> Payment Date</div> <div class="col-sm-6"> &nbsp; <?php echo @$booking_payments->payment_date; ?>  </div>
							<div class="col-sm-6"> Payment Mode</div> <div class="col-sm-6"> &nbsp;  <?php echo @$booking_payments->payment_mode; ?>  </div>
                        </div>	
						 </div>	
							   </div>	
						   
					</div>	
					              
						
						<div role="tabpanel" class="tab-pane fade" role="tabpanel"  id="Section7">
						   <div class="card">  
								<div class="card-header with-border">
								<h5 class="card-title">Transactions</h5>
								</div>
						
					 <div class="card-body">  
						
						 <div class="row">  
							 <div class="col-10 col-sm-10 col-md-10 p-2"><strong>Jobcard Total: </strong><strong><?php echo $this->payments->get_ledger($booking->booking_id, 'jobcard_total', 'requested_amount');  ?></strong></div>
					<div class="col-2 col-sm-2 col-md-2 p-2"> </div>
							<div class="col-12 col-sm-12 col-md-12">
										<table class="table table-striped table-hover">
											<thead>
											<tr>
												 
												<th> </th> 
												<th>Requested</th> 
												<th>Received</th> 
												<th>Mode</th>
												<th>Date</th>
											</tr>
											</thead>
											<tbody> 
                                    <tr> 
                                        <td>Booking Fee</td> 
                                        <td><?php echo @$this->payments->get_ledger($booking->booking_id, 'booking_fee', 'requested_amount'); ?></td>
                                        <td><?php echo @$this->payments->get_ledger($booking->booking_id, 'booking_fee', 'received_amount'); ?></td>
                                        <td><?php echo @$this->payments->get_ledger($booking->booking_id, 'booking_fee', 'mode'); ?></td>
                                        <td><?php echo @convert_date($this->payments->get_ledger($booking->booking_id, 'booking_fee', 'updated_on')); ?></td> 
                                    </tr>
									<tr> 
                                        <td>Service Advance</td> 
                                        <td><?php echo @$this->payments->get_ledger($booking->booking_id, 'service_advance', 'requested_amount'); ?></td>
                                        <td><?php echo @$this->payments->get_ledger($booking->booking_id, 'service_advance', 'received_amount'); ?></td>
                                        <td><?php echo @$this->payments->get_ledger($booking->booking_id, 'service_advance', 'mode'); ?></td>
                                        <td><?php echo @convert_date($this->payments->get_ledger($booking->booking_id, 'service_advance', 'updated_on')); ?></td> 
                                    </tr>			
									 <tr> 
                                        <td>Discount</td> 
                                        <td><?php echo @$this->payments->get_ledger($booking->booking_id, 'discount', 'requested_amount'); ?></td>
                                        <td><?php echo @$this->payments->get_ledger($booking->booking_id, 'discount', 'received_amount'); ?></td>
                                        <td><?php echo @$this->payments->get_ledger($booking->booking_id, 'discount', 'mode'); ?></td>
                                        <td><?php echo @convert_date($this->payments->get_ledger($booking->booking_id, 'discount', 'updated_on')); ?></td> 
                                    </tr>
									
									<tr> 
                                        <td>Round Off</td> 
                                        <td><?php echo @$this->payments->get_ledger($booking->booking_id, 'round_off', 'requested_amount'); ?></td>
                                        <td><?php echo @$this->payments->get_ledger($booking->booking_id, 'round_off', 'received_amount'); ?></td>
                                        <td><?php echo @$this->payments->get_ledger($booking->booking_id, 'round_off', 'mode'); ?></td>
                                        <td><?php echo @convert_date($this->payments->get_ledger($booking->booking_id, 'round_off', 'updated_on')); ?></td> 
                                    </tr>			
												 
											</tbody>
											<tfoot>
												<tr> 
													<td><strong>Net Payable</strong></td> 
													<td><strong><?php echo @$booking_payments->net_payable; ?></strong></td>
													<?php $final_paid = $this->payments->get_ledger($booking->booking_id, 'final_paid', 'received_amount'); ?>
													<td><strong><?php echo @$final_paid; ?></strong></td>
													<td><?php if(!empty($final_paid) && $final_paid>0){ echo $this->payments->get_ledger($booking->booking_id, 'final_paid', 'mode'); } ?></td>
													<td><?php if(!empty($final_paid) && $final_paid>0){ echo @convert_date($this->payments->get_ledger($booking->booking_id, 'final_paid', 'updated_on')); } ?></td> 
												</tr>
											</tfoot>
										</table>
                        			</div>
							 
							   
							 
                        </div>	
						 </div>	
							   </div>	
						   
					</div>	
						
						<div role="tabpanel" class="tab-pane fade" role="tabpanel"  id="Section3">
						<table class="table table-striped table-hover table-bordered dataTable"  id="customerbookings">
                        <thead>
                        <tr role="row">
                            <th class="sorting_enabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                Booking No 
                            </th>
                             
							  <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                Service Date
                            </th>
                            
                            <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                Time
                            </th> 
                             
							<th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                Make
                            </th> 
                            <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                Model
                            </th> 
							<th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                Service
                            </th>
							<th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                Mechanic
                            </th>
							<th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                Status
                            </th>
							<th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                Invoice Value
                            </th>
                             <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                Details
                            </th>
                             
                        </tr>
                        </thead>
		
                        <tbody>
                        		 <?php 
						  if($customer_bookings)
						 foreach($customer_bookings as $bookings){ 
							
							
							 $make  = $this->Common->single_row('vehicle_make', array('make_id' =>  $bookings->vehicle_make), 'make_name'); 
							 
							$model  = $this->Common->single_row('vehicle_model', array('model_id' =>  $bookings->vehicle_model), 'model_name'); 		
							 
							 $service_category  = $this->Common->single_row('service_category', array('id' =>  $bookings->service_category_id), 'service_name');  
		  
		 					 $booking_details  = $this->Common->single_row('booking_details', array('id' =>  $bookings->booking_id));  
		 
						 	$mechanicname_q  = $this->Common->single_row('mechanic', array('mechanic_id' =>  $bookings->assigned_mechanic), 'name');  
							 
						 
							if($mechanicname_q){ 
							$mechanicname  = $mechanicname_q;
								}else{
								$mechanicname  = 'Not Assigned';
							}
							 
							?>
							 
							
							<tr>
								<td><?php echo $bookings->booking_id; ?></td>
								<td><?php echo date('d-m-Y', strtotime($bookings->service_date)); ?></td>
								<td><?php echo $bookings->time_slot; ?></td> 
								<td><?php echo $make; ?></td>
								<td><?php echo $model; ?></td>
								<td><?php echo $service_category; ?></td>
								<td><?php echo $mechanicname; ?></td>
								<td><?php echo $bookings->status; ?></td>  
								<td><?php if(!empty($booking_details->estimated_amount)) echo $booking_details->estimated_amount; ?></td>
								<td><a href="<?=base_url()?>index.php/bookings/booking_details/<?php echo $bookings->booking_id; ?>" target="_blank" class="btn btn-info">Details</a></td>
							</tr>
							
							<?php } ?>
							
                        </tbody>
                    </table>
					</div>	
					
					
					<div role="tabpanel" class="tab-pane fade" role="tabpanel"  id="Section6">
						   <div class="card">  
								
						
					 <div class="card-body">  
						 
						 <div class="row">  
							 
							 
							<div class="col-sm-12"> 
							 
								<div class="form-group">
                      
									
						<label>Internal Booking Notes:</label>
                      <textarea class="form-control" name="booking_notes" id="booking_notes"></textarea>
                    </div>
							<button type="button" class="btn btn-primary" onclick="add_booking_notes(<?php echo $booking->booking_id; ?>)">Add Note</button>
							<hr>
								
								
							<div class="col-md-12">	
					<h3 class="box-title">Notes:</h3><br/>
					<div id="booking_notes_list">	
					<?php 
						
								if($booking_notes): 
                                foreach ($booking_notes as $note) {
									?>
						<div class="card"> 
                  <div class="card-body">
                    <?php echo $note->notes; ?>
                  </div>
					 
							
                  <div class="card-footer bg-whitesmoke">
                    <?php echo 'By: '.get_users(array('id'=>$note->created_by),'firstname').' - '. convert_datetime($note->created_on); ?>
                  </div>
                </div>  
					<?php }
							endif;
						?>
					</div>	
					</div> 
							 
							 </div> 
							 
							
                        </div>	
						 </div>	
							   </div>	
						   
					</div>	
					
					
					
					
					
						
				</div>
			
			</div>
			 
					 <div class="col-3 col-sm-12 col-md-3"> 
						 
						 
						 
							  
								<h6 class="section-title">Stage: <?php echo $booking->stage; ?></h6>
							 
							     <div class="activities">
						
						<?php
									if($bookingtrack)
									foreach ($bookingtrack as $actions){
							?>
									
									
                  <div class="activity">
                    <div class="activity-icon bg-primary text-white shadow-primary">
                      <i class="ion-ionic"></i>
                    </div>
                    <div class="activity-detail">
                      <div class="mb-2">   
						<span class="text-job text-primary"><?php echo convert_datetime($actions->created_on);   ?></span>
						 <?php if($actions->stage=='Inspection Done'){  
											$inspection_uploads = $this->Bookings->get_booking_uploads('inspection',$booking->booking_id); 
											?>
						 
											&nbsp;<span class="bullet"></span>  
											
											<div class="float-right dropdown">
                          <a href="#" class="label label-info" data-toggle="dropdown">Download Files</a>
                          <div class="dropdown-menu">
                            <div class="dropdown-title">Inspection Uploads</div>
                            <?php if($inspection_uploads) foreach($inspection_uploads as $insUpload){   
									echo '<a class="dropdown-item has-icon" href="'.$insUpload->file_url.'" target="_blank"><i class="fas fa-eye"></i> '.$insUpload->type.' </a>'; 
								  }
							?>   
                          </div>
                        </div> 
						 
											<?php }elseif($actions->stage=='Submit Report'){  
											$report_uploads  = $this->Bookings->get_booking_uploads('report',$booking->booking_id);  
											?>
							  			
											&nbsp;<span class="bullet"></span>  
											
											<div class="float-right dropdown">
                          <a href="#" class="label label-info" data-toggle="dropdown"> Download Files</a>
                          <div class="dropdown-menu">
                            <div class="dropdown-title">Reports Uploads</div>
                            <?php  if($report_uploads)  foreach($report_uploads as $repUpload){   
									echo '<a class="dropdown-item has-icon" href="'.$repUpload->file_url.'" target="_blank"><i class="fas fa-eye"></i> '.$repUpload->type.' </a>'; 
								  }
							?>   
                          </div>
                        </div> 
						 
											 
											<?php }elseif($actions->stage=='Payment Collected' || $actions->stage=='End Booking'){  
											$pay_uploads  = $this->Bookings->get_booking_uploads('reciept',$booking->booking_id);  
											?>
											
						 
											
											&nbsp;<span class="bullet"></span>  
											
											<div class="float-right dropdown">
                          <a href="#" class="label label-info" data-toggle="dropdown"> Download Files</a>
                          <div class="dropdown-menu">
                            <div class="dropdown-title">Reciept Uploads</div>
                            <?php if($pay_uploads) foreach($pay_uploads as $payUpload){   
									echo '<a class="dropdown-item has-icon" href="'.$payUpload->file_url.'" target="_blank"><i class="fas fa-eye"></i> Payment Reciept </a>'; 
								  }
							?>   
                          </div>
                        </div>  
						 		 
										<?php	} ?> 
                      </div>
                      
						<p><?php echo $actions->stage;
								 echo '</p><p>'.$actions->remark.'<p>'; 
											?> 	   
								 
						</p>					
						 
					  	<p>
						<span class="text-job text-primary">By: <?php echo $actions->owner_name;   ?></span> 	
						 </p>					
						 
					  	<p>
						 <span class="text-job text-primary">
						 <small><?php echo $actions->owner_platform; ?></small>
						  </span>  </p>
													</div> 
												 </div>
									
									 <?php
									}
                     
									?>
                         
								 </div> 
							 
							 </div>  
					
		 </div>	
				</div>	
					
                
	
				</div>	   
						 
    
                
                
            
        </div>
    </div>
 </div>


	<!--Modal for CANCEL BOOKING -->

 
<div class="modal fade" role="dialog"  id="mod_cancel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Cancel Booking</h4>
            </div>
            <?= form_open_multipart(base_url() . 'bookings/cancel_booking/', array('method' => 'POST', 'class' => 'form-horizontal')) ?>
			
            <div class="modal-body">
				
				<input type='hidden' name="booking_id" class='form-control'  value='<?php echo $booking->booking_id; ?>'> 
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Cancel Remark</label>
					<div class="col-lg-9"> 
						  
						<select style="width:100%;" required class="form-control select2" name="cancel_remark" id="cancel_remark">
               <optgroup label="Cancellation by Customer">
                   <option value="Customer requested for rescheduling appointment">Customer requested for rescheduling appointment</option>
                   <option value="Customer not available/not answering calls">Customer not available/not answering calls</option> 
                   <option value="Customer changed mind / got the work done from outside">Customer changed mind / got the work done from outside</option>
                   <option value="Customer finds estimated cost expensive">Customer finds estimated cost expensive</option>
                   <option value="Customer preferred date/time not available">Customer preferred date/time not available</option>
                   <option value="Customer changed location, mechanic unable to reach in time">Customer changed location, mechanic unable to reach in time</option> 
                   <option value="Customer cancelled because of insufficient parts">Customer cancelled because of insufficient parts</option>
                   <option value="Customer cancelled - Mechanic - No Show / Reported Late">Customer cancelled - Mechanic - No Show / Reported Late</option>
                   <option value="Duplicate booking by Customer">Duplicate booking by Customer</option> 
               </optgroup>
               <optgroup label="Cancellation by GarageWorks">
                   <option value="Mechanic no show/absent">Mechanic no show/absent</option>
                   <option value="Spare parts not available">Spare parts not available</option>
                   <option value="Non serviceable area">Non serviceable area</option>
                   <option value="Non serviceable vehicle">Non serviceable vehicle</option>
                   <option value="Customer wants specific brand of parts">Customer wants specific brand of parts</option>
                   <option value="Change of service category or package">Change of service category or package</option> 
               </optgroup> 
              </select>
						
						
                    </div>
                </div>
				   
            </div>
            <div class="modal-footer">
                <?php echo $this->rbac->updatePermission; ?>
				<button type="button" class="btn dark btn-warning" data-dismiss="modal">Close</button> 
            </div>
            <?php echo form_close();?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Modal for CANCEL BOOKING END-->	
		


	<!--Modal for BOOKING RESCHEDULE-->

 
<div class="modal fade" role="dialog"  id="mod_reschedulebooking">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Booking Reschedule</h4>
            </div>
            <?= form_open_multipart(base_url() . 'index.php/bookings/reschedule_booking/', array('method' => 'POST', 'class' => 'form-horizontal', 'id'=> 'editbooking_addressForm')) ?>
			
            <div class="modal-body">
				
				<input type='hidden' name="booking_id" class='form-control' id='bookingID_' value='<?= $booking->booking_id; ?>'>
				   
                    
						 <div class="form-group col-md-12"><label>Service Date:   </label>
								 <input class="form-control" value="<?= convert_date($booking->service_date); ?>" type="date" id="service_date" name="service_date">
						</div>
						 
						 <div class="form-group col-md-12"><label>Time Slot:   </label>
								 <select class="form-control select-ajax-time-slot" style="width: 100%;"  placeholder="Time Slot" id="time_slot" name="time_slot">
								<option selected value="<?= $booking->time_slot; ?>"><?= $booking->time_slot; ?></option> 
								</select>
						</div> 
				  
            </div>
            <div class="modal-footer"> 
				<?php echo $this->rbac->updatePermission; ?>
				 <button type="button" class="btn dark btn-warning" data-dismiss="modal">Close</button> 
            </div>
            <?php echo form_close();?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Modal for  BOOKING RESCHEDULE END-->	


		
			<!--Modal for Do Inspection --> 
<div class="modal fade" role="dialog"  id="mod_doInspection">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Upload Inspection Data</h4>
            </div>
            <?= form_open_multipart(base_url() . 'index.php/mechanicapi/booking_services_backend/', array('method' => 'POST', 'class' => 'form-horizontal')) ?>
			
            <div class="modal-body">
				
				<input type='hidden' name="booking_id" class='form-control' id='c3_' value='<?= $booking->booking_id; ?>'>
				<input id="vehicle_id_3" name="vehicle_id" value="<?php echo $booking->vehicle_id; ?>" type='hidden' />
				 <input id="mechanic_assigned_3" name="mechanic_id" value="<?php echo $booking->assigned_mechanic; ?>" type='hidden' />
				 <input id="customer_id_3" name="customer_id" value="<?php echo $booking->customer_id; ?>" type='hidden' />
				<input id="customer_id_3" name="km_reading" value="<?php echo $booking->vehicle_km_reading; ?>" type='hidden' />
				 <input id="activity" name="activity" value="Inspection Done" type='hidden' />
				<input id="stage" name="stage" value="Inspection Done" type='hidden' />
				<input id="api_action" name="api_action" value="inspection_done" type="hidden" />
				<input id="long" name="long" value="" type='hidden' />
				<input id="lat" name="lat" value="" type='hidden' />
				
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Inspection Audio</label>
					<div class="col-lg-9"> 
						 <input type="file" class="form-control" name="inspection_audio" />
                    </div>
                </div>
				 
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Number Plate</label>
					<div class="col-lg-9"> 
						<input type="file" class="form-control" name="inspection_numberplate" />
                    </div>
                </div>
				
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Km Reading</label>
					<div class="col-lg-9"> 
						<input type="file" class="form-control" name="inspection_km" />
                    </div>
                </div>
				
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Selfie</label>
					<div class="col-lg-9"> 
						<input type="file" class="form-control" name="inspection_selfie" />
                    </div>
                </div>
				
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Vehicle Images</label>
					<div class="col-lg-9"> 
						 <input type="file" class="form-control"  multiple="multiple" name="inspection_vehicle_image[]" />
                    </div>
                </div>
				 
				  
            </div>
            <div class="modal-footer">
               <?php echo $this->rbac->updatePermission; ?>
				 <button type="button" class="btn dark btn-warning" data-dismiss="modal">Close</button> 
            </div>
            <?php echo form_close();?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Modal for Do Inspection END -->
	
	
	<!--Modal for END WORK --> 
<div class="modal fade" role="dialog"  id="mod_doEndWork">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">End Work</h4>
            </div>
            <?= form_open_multipart(base_url() . 'index.php/mechanicapi/booking_services_backend', array('method' => 'POST', 'class' => 'form-horizontal')) ?>
			
            <div class="modal-body">
				
				<input type='hidden' name="booking_id" class='form-control' id='c3_' value='<?= $booking->booking_id; ?>'>
				<input id="vehicle_id_3" name="vehicle_id" value="<?php echo $booking->vehicle_id; ?>" type='hidden' />
				 <input id="mechanic_assigned_3" name="mechanic_id" value="<?php echo $booking->assigned_mechanic; ?>" type='hidden' />
				 <input id="customer_id_3" name="customer_id" value="<?php echo $booking->customer_id; ?>" type='hidden' />
				<input id="customer_id_3" name="km_reading" value="<?php echo $booking->vehicle_km_reading; ?>" type='hidden' />
				 <input id="activity" name="activity" value="Service Work End" type='hidden' />
				<input id="stage" name="stage" value="Work End" type='hidden' />
				<input id="api_action" name="api_action" value="end_work" type="hidden" />
				<input id="long" name="long" value="" type='hidden' />
				<input id="lat" name="lat" value="" type='hidden' />
				
				<div class="form-group" >	
				 
					<div class="col-lg-9"> 
						<p>Are you sure you want to end work?</p>  
                    </div>
                </div>
				
				 
				  
				  
            </div>
            <div class="modal-footer">
                <?php echo $this->rbac->updatePermission; ?>
				<button type="button" class="btn dark btn-warning" data-dismiss="modal">Close</button> 
            </div>
            <?php echo form_close();?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Modal for Do END WORK END -->
		   
		
		<!--Modal for Do Submit Report --> 
<div class="modal fade" role="dialog"  id="mod_doSubmitReport">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Submit Report Data</h4>
            </div>
            <?= form_open_multipart(base_url() . 'index.php/mechanicapi/booking_services_backend', array('method' => 'POST', 'class' => 'form-horizontal')) ?>
			
            <div class="modal-body">
				
				<input type='hidden' name="booking_id" class='form-control' id='c3_' value='<?= $booking->booking_id; ?>'>
				<input id="vehicle_id_3" name="vehicle_id" value="<?php echo $booking->vehicle_id; ?>" type='hidden' />
				 <input id="mechanic_assigned_3" name="mechanic_id" value="<?php echo $booking->assigned_mechanic; ?>" type='hidden' />
				 <input id="customer_id_3" name="customer_id" value="<?php echo $booking->customer_id; ?>" type='hidden' />
				<input id="customer_id_3" name="km_reading" value="<?php echo $booking->vehicle_km_reading; ?>" type='hidden' />
				 <input id="activity" name="activity" value="Report Submitted" type='hidden' />
				<input id="stage" name="stage" value="Submit Report" type='hidden' />
				<input id="api_action" name="api_action" value="submit_report" type="hidden" />
				<input id="long" name="long" value="" type='hidden' />
				<input id="lat" name="lat" value="" type='hidden' />
				
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Report Audio</label>
					<div class="col-lg-9"> 
						 <input type="file" class="form-control" name="report_audio" />
                    </div>
                </div>
				
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Vehicle Images</label>
					<div class="col-lg-9"> 
						 <input type="file" class="form-control"  multiple="multiple" name="report_vehicle_image[]" />
                    </div>
                </div>
				
				      
				  
				  
            </div>
            <div class="modal-footer">
               <?php echo $this->rbac->updatePermission; ?>
				 <button type="button" class="btn dark btn-warning" data-dismiss="modal">Close</button> 
            </div>
            <?php echo form_close();?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Modal for Do Inspection END -->
	
	
	
	<!--Modal for Do End Booking --> 
<div class="modal fade" role="dialog"  id="mod_doEndBooking">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Process Payment Data</h4>
            </div>
            <?= form_open_multipart(base_url() . 'index.php/mechanicapi/booking_services_backend', array('method' => 'POST', 'class' => 'form-horizontal')) ?>
			
            <div class="modal-body">
				
				<input type='hidden' name="booking_id" class='form-control' id='c3_' value='<?= $booking->booking_id; ?>'>
				<input id="vehicle_id_3" name="vehicle_id" value="<?php echo $booking->vehicle_id; ?>" type='hidden' />
				 <input id="mechanic_assigned_3" name="mechanic_id" value="<?php echo $booking->assigned_mechanic; ?>" type='hidden' />
				 <input id="customer_id_3" name="customer_id" value="<?php echo $booking->customer_id; ?>" type='hidden' />
				<input id="customer_id_3" name="km_reading" value="<?php echo $booking->vehicle_km_reading; ?>" type='hidden' />
				 <input id="activity" name="activity" value="Payment Collected" type='hidden' />
				<input id="stage" name="stage" value="End Booking" type='hidden' />
				<input id="api_action" name="api_action" value="payment_done" type="hidden" />
				<input id="long" name="long" value="" type='hidden' />
				<input id="lat" name="lat" value="" type='hidden' />
				
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Amount to be collected</label>
					<div class="col-lg-9">
					<?php 
					 
						//$get_final_payment = $this->payments->calculate_final_payment($booking->booking_id);	
						
						if(!empty($booking_payments->net_payable)){
							$BookingAmt = @$booking_payments->net_payable;
						}else{
							$BookingAmt = '';
						}
						?>
				    <span> &#8377; <?php echo $BookingAmt; ?></span>
                    </div>
                </div>
 
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Payment Mode</label>
					<div class="col-lg-9"> 
						 <select style="width: 50%;" name="payment_mode" id="payment_mode" class="form-control select2">
						<option value="Cash">Cash</option>
						<option value="UPI">UPI</option>
						<option value="Corporate">Corporate</option>	 
						<option value="Online">Online</option>	 
						</select>
                    </div>
                </div>
				
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Amount Collected</label>
					<div class="col-lg-9"> 
						<input type="text" class="form-control" name="amount_collected" required id="amount_collected" />
                    </div>
                </div>
				
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Reciept Image</label>
					<div class="col-lg-9"> 
						<input type="file" class="form-control" name="reciept_ss" />
                    </div>
                </div>
				
				 <div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Comments/Reason</label>
					<div class="col-lg-9"> 
						<textarea class="form-control" name="payment_comments" required id="payment_comments"></textarea>
                    </div>
                </div>   
				  
				  
            </div>
            <div class="modal-footer">
               <?php echo $this->rbac->updatePermission; ?>
				 <button type="button" class="btn dark btn-warning" data-dismiss="modal">Close</button> 
            </div>
            <?php echo form_close();?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Modal for Do End Booking END -->

<div class="modal fade" role="dialog" id="editBookingAddress">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Update Booking</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
				<?php $attributes = array('class' => 'form-horizontal group-border hover-stripped', 'id'=>'updatebookingaddress_form', 'method' => 'post');
                echo form_open_multipart('bookings/update_booking_address', $attributes); ?>
              <div class="modal-body">
                <div class="row"> 
					<?php $i = 0; ?>
					<input type="hidden" name="booking_id" value="<?php echo $booking->booking_id; ?>">
					<input type="hidden" name="customer_id" value="<?php echo $booking->customer_id; ?>"> 
					<input class="form-control" value="<?php echo $booking->customer_name; ?>" id="name_<?=$i;?>" type="hidden" name="name">
					<input class="form-control" value="<?php echo $booking->customer_channel; ?>" id="name_<?=$i;?>" type="hidden" name="channel">
					
					<div class="form-group col-md-12"><label>Mobile:   </label>
								<input type="text" class="form-control" name="mobile" value="<?php echo $booking->customer_mobile; ?>" />
					</div>
					<div class="form-group col-md-12"><label>Email:   </label>
								<input type="text" class="form-control" name="email" value="<?php echo $booking->customer_email; ?>" />
						</div>
					<div class="form-group col-md-12"><label>Address Type:   </label>
								<input type="text" class="form-control" name="address_type" value="<?php echo $booking->customer_address_type; ?>" />
						</div>
						<input type="hidden" name="address_id[]" value="" />
						<div class="form-group col-md-12"><label>Address:   </label>
								<input name="address" type="text" class='form-control' id='address' value="<?php echo $booking->customer_address; ?>" placeholder='Address'></input>
						</div>
						<div class="form-group col-md-6">
                                <label>City</label>
                                <select class="form-control select-ajax-city" style="width: 100%;"  placeholder="City" id="city_<?=$i;?>" name="city">
								<option value="<?php echo $booking->customer_city; ?>"><?php echo $booking->customer_city; ?></option>
								</select>
                         </div>	
						<div class="form-group col-md-6">
                                <label>Area</label>
                                 <select class="form-control select-ajax-area"  style="width: 100%;" onFocus="get_area('<?=$i;?>');" id="area_<?=$i;?>" onChange="get_pincode('<?=$i;?>');" placeholder="Area" name="area">
								<option value="<?php echo $booking->customer_area; ?>"><?php echo $booking->customer_area; ?></option>
								</select>
                         </div>
						
						<div class="form-group col-md-6">
                                <label>Pincode</label>
                                <input class="form-control input-pincode" value="<?php echo $booking->customer_pincode; ?>" id="pincode_<?=$i;?>" type="text" name="pincode">
								<input class="form-control input-zone" value="<?php echo $booking->zone_id; ?>" id="zone_<?=$i;?>" type="hidden" name="zone">
                         </div>
						<div class="form-group col-md-6">
                                <label>Google Map</label>
								<input class="form-control google_map" id="google_map_<?=$i;?>" value="<?php echo $booking->customer_google_map; ?>" type="text" name="google_map">
								<input type="hidden" class="latitude" id="latitude_<?=$i;?>" name="latitude" value="<?php echo $booking->customer_lat; ?>" />
								<input type="hidden" class="longitude" id="longitude_<?=$i;?>" name="longitude" value="<?php echo $booking->customer_long; ?>" />
							 
                         </div>	
					 </div>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <?php echo $this->rbac->updatePermission; ?>
              </div>
			  </form>
            </div>
          </div>
        </div>

