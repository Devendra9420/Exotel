
 <div class="section-body">
            <h2 class="section-title">Complaint ID# <?= $complaints->id; ?></h2>
              <p class="section-lead text-right">  
	 		 			<h6 class="label label-primary">Status: <?= $complaints->status; ?></h6>  
	 				 
	 
	 
            </p> 
	<div class="row">
        <div class="col-lg-12">
               
				<div class="box box-primary">
				 <div class="box-header text-right">   
					 <a href="<?php if(!empty($_SERVER['HTTP_REFERER'])){ echo $_SERVER['HTTP_REFERER']; }else{ echo $this->uri->uri_string(); } ?>" class="btn btn-sm btn-info">Back</a>
					 
                </div>
				
					
				<div class="box-body">
     
            	
					
					
					
                <!-- Nav tabs -->
                <ul class="nav nav-pills" role="tablist">
                    <li class="nav-item"><a class="nav-link active" href="#Section1" aria-controls="complaints" role="tab" data-toggle="tab">Customer </a></li> 
					<li class="nav-item"><a class="nav-link" href="#Section2" aria-controls="customer" role="tab" data-toggle="tab">Complaint Details </a></li> 
					<li class="nav-item"><a class="nav-link" href="#Section3" aria-controls="track" role="tab" data-toggle="tab">Track </a></li> 
                </ul>
				
				
				<div class="tab-content">
                   
					<div role="tabpanel" class="tab-pane fade show active" role="tabpanel"  id="Section1">
                        
						
					<div class="card"> 
					<div class="card-header with-border">
                    <h5 class="card-title">Details</h5>
            		</div>  
					<div class="card-body"> 
					<div class="row">
					<div class="col-md-5"> Customer Name: </div><div class="col-md-7 w-100">&nbsp;<?= $booking->customer_name; ?>	</div> 
					<div class="col-md-5"> Mobile: </div><div class="col-md-7">&nbsp;<?= $booking->customer_mobile; ?>	</div>  
					<div class="col-md-5"> Alternate No: </div><div class="col-md-7"><?= $booking->customer_alternate_no; ?>	</div> 
					<div class="col-md-5"> Email: </div><div class="col-md-7 w-100">&nbsp;<?= $booking->customer_email; ?>	</div> 
					<div class="col-md-5"> Channel: </div><div class="col-md-7 w-100">&nbsp;<?= $booking->customer_channel; ?>	</div>	
					</div> 
					</div> 	 
					</div> 	
					 
					 
					
						 
					<div class="card"> 
					<div class="card-header with-border">  
             		<h5 class="card-title">Address</h5>
            		</div>
					 <div class="card-body">
						 
					<div class="row">  
					<div class="col-md-5"> Address: </div><div class="col-md-7 w-100">&nbsp;<?= $booking->customer_address; ?>	</div> 
					<div class="col-md-5"> Google Map: </div><div class="col-md-7">&nbsp;<?= $booking->customer_google_map; ?>	</div> 
					<div class="col-md-5"> Area: </div><div class="col-md-7">&nbsp;<?= $booking->customer_area; ?>	</div> 
					<div class="col-md-5"> Pincode: </div><div class="col-md-7">&nbsp;<?= $booking->customer_pincode; ?>	</div>	 
					<div class="col-md-5"> City: </div><div class="col-md-7">&nbsp;<?= $booking->customer_city; ?>	</div>		 
					 </div>
					 
					</div>
					</div>  
					 
					 
					 </div>	 
					
					  
				
					<div role="tabpanel" class="tab-pane fade" role="tabpanel"  id="Section2">
						
						 <div class="card">  
					<div class="card-header with-border">
                    <h5 class="card-title">Complaint</h5>
            		</div>
						
					 <div class="card-body">  
						 
						 <div class="row"> 
							 
							<div class="col-sm-6">Complaint</div> <div class="col-sm-6">  <?= @$complaints->complaints; ?> </div>    
							<div class="col-sm-6">Complaint Date</div> <div class="col-sm-6">  <?= @convert_date($complaints->created_on); ?> </div>      
							<div class="col-sm-6">Status</div> <div class="col-sm-6">  <?= @$complaints->status; ?> </div>
							<div class="col-sm-6">Re-visit Booking Id</div> <div class="col-sm-6">  <?php if(!empty($complaints->revisit_booking_id)){ echo '<a href="'.base_url().'bookings/booking_details/'.$complaints->revisit_booking_id.'" target="_blank">'.$complaints->revisit_booking_id.'</a>'; } ?>  </div> 
							<div class="col-sm-6">Due Date</div> <div class="col-sm-6">  <?php if(!empty($complaints_lifecycle->due_date) && $complaints_lifecycle->due_date!='0000-00-00'){ echo @convert_date($complaints_lifecycle->due_date); } ?> </div> 
							<div class="col-sm-6">Comments</div> <div class="col-sm-6">  <?= @$complaints->comments; ?> </div>
							 
                        </div>	
						 
						 
					 </div>
					</div> 
						
						
                    <div class="card">  
					<div class="card-header with-border">
                    <h5 class="card-title">Source Details</h5>
            		</div>
						
					 <div class="card-body">  
						 
						 <div class="row"> 
							 <div class="col-sm-6">Medium</div> <div class="col-sm-6">  <?= @$complaints->medium; ?> </div>
						 
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
						
						 <div class="col-sm-6"> Total Amount</div> <div class="col-sm-6">  <?php echo @$booking_payments->total_amount; ?>  </div>
						 <div class="col-sm-6"> Mode of Payment</div> <div class="col-sm-6">  <?php echo @$booking_payments->payment_mode; ?>  </div>
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
						 
					</div> 
						 
						 
						 
						 
					 </div>
					</div> 
	   				</div>	 
			 
					<div role="tabpanel" class="tab-pane fade" role="tabpanel"  id="Section3">
						  <div class="card">  
								<div class="card-header with-border">
								<h5 class="card-title">Track</h5>
								</div>
						
					 <div class="card-body">  
						 
						 <div class="row"> 
							  
						  <div class="activities">
						
						<?php
									if(!empty($complaints_track))
									foreach ($complaints_track as $actions){
							?>
									
									
                  <div class="activity">
                    <div class="activity-icon bg-primary text-white shadow-primary">
                      <i class="ion-ionic"></i>
                    </div>
                    <div class="activity-detail">
                      <div class="mb-2">   
						<span class="text-job text-primary"><?php echo convert_date($actions->created_on);   ?></span> 
                      </div>
                      
						<p><?php echo $actions->action; ?> - <?php  echo $actions->details; ?></p>					
						 
					  	<p>
						<span class="text-job text-primary">Assigned to: <?php echo $actions->assigned_to;   ?></span> 	
						 </p>					
						 
					  	<p>
						 <span class="text-job text-primary">
						 <small>Created by: <?php if(!empty($actions->created_by)) echo get_users(array("id"=>$actions->created_by), 'firstname'); ?></small>
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
						 
    
                
                
            
        </div>
    </div>
 </div>
 
