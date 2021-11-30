
 <div class="section-body">
            <h2 class="section-title">Customer Details: </h2>
            <p class="section-lead"> 
				<?php echo make_first_capital($customer->name); ?>
            </p> 
	<div class="row">
        <div class="col-lg-12">
              
				
				<div class="box box-primary">
				 <div class="box-header text-right"> 
					 <a href="<?php echo base_url(); ?>customer/list_customers" class="btn btn-sm btn-info">Back</a>
                </div>
				
					
				<div class="box-body">
     
            	
                <!-- Nav tabs -->
                <ul class="nav nav-pills" role="tablist">
                    <li class="nav-item"><a class="nav-link active" href="#Section1" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-user"></i> Customer KYC</a></li>
                    <li class="nav-item"><a class="nav-link" href="#Section2" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-envelope"></i> Vehicle Details</a></li>
                    <li class="nav-item"><a class="nav-link" href="#Section3" aria-controls="messages" role="tab" data-toggle="tab"><i class="fa fa-cube"></i> Service History</a></li> 
                </ul>
				
				
				<div class="tab-content">
                   
					<div role="tabpanel" class="tab-pane fade show active" role="tabpanel"  id="Section1">
                        
						
					<div class="card"> 
					<div class="card-header with-border">
                    <h5 class="card-title">Details</h5>
            		</div>  
					<div class="card-body"> 
					<div class="row">
					<div class="col-md-5"> Customer Name: </div><div class="col-md-7 w-100">&nbsp;<?= $customer->name; ?>	</div> 
					<div class="col-md-5"> Mobile: </div><div class="col-md-7">&nbsp;<?= $customer->mobile; ?>	</div>  
					<div class="col-md-5"> Alternate No: </div><div class="col-md-7"><?= $customer->alternate_no; ?>	</div> 
					<div class="col-md-5"> Email: </div><div class="col-md-7 w-100">&nbsp;<?= $customer->email; ?>	</div> 
					<div class="col-md-5"> Channel: </div><div class="col-md-7 w-100">&nbsp;<?= $customer->channel; ?>	</div>	
					</div> 
					</div> 	 
					</div> 	
					 
						 
				 
					<div class="card"> 
					<div class="card-header with-border">
              		<h5 class="card-title">Documents</h5>
            		</div>
					<div class="card-body">
					<div class="row">
					<div class="col-md-5"> Aadhar No.: </div><div class="col-md-7 w-100">&nbsp;</div> 
					<div class="col-md-5"> Pan Card: </div><div class="col-md-7">&nbsp;</div> 
					<div class="col-md-5"> Driving License: </div><div class="col-md-7">&nbsp;</div> 
					</div>
					</div>
					</div>  
					 
					
						 
					<div class="card"> 
					<div class="card-header with-border">  
             		<h5 class="card-title">Address</h5>
            		</div>
					 <div class="card-body">
						 <?php if(!empty($customer_addresses)){ 
							   foreach ($customer_addresses as $addr){ ?> 
					<div class="row">
					<div class="col-md-5"><h6><i> Type: </i></h6></div><div class="col-md-7 w-100">&nbsp;<?= $addr->type; ?>	</div> 
					<div class="col-md-5"> Address: </div><div class="col-md-7 w-100">&nbsp;<?= $addr->address; ?>	</div> 
					<div class="col-md-5"> Google Map: </div><div class="col-md-7">&nbsp;<?= $addr->google_map; ?>	</div> 
					<div class="col-md-5"> Area: </div><div class="col-md-7">&nbsp;<?= $addr->area; ?>	</div> 
					<div class="col-md-5"> Pincode: </div><div class="col-md-7">&nbsp;<?= $addr->pincode; ?>	</div>	 
					<div class="col-md-5"> City: </div><div class="col-md-7">&nbsp;<?= $addr->city; ?>	</div>		 
					 </div>
						<?php }
							  } ?> 
					</div>
					</div>  
					 
					 
					 </div>	 
					
					  
				
					<div role="tabpanel" class="tab-pane fade" role="tabpanel"  id="Section2">
                    <div class="card">  
					<div class="card-header with-border">
                    <h3 class="card-title">Vehicle Details</h3>
            		</div>
						
					 <div class="card-body">  
						 <?php  
						 if($customer_vehicles)
						 foreach($customer_vehicles as $veh){ ?>
						 <div class="row"> 
							<div class="col-sm-6">  Vehicle ID.  </div>  <div class="col-sm-6"> <?php echo $veh->vehicle_id; ?>  </div> 
							<div class="col-sm-6"> Vehicle Reg No.  </div> <div class="col-sm-6"> <?php echo $veh->regno; ?>  </div>  
						 <?php  $make  = $this->Common->single_row('vehicle_make', array('make_id' =>  $veh->make), 'make_name');  
							$model  = $this->Common->single_row('vehicle_model', array('model_id' =>  $veh->model), 'model_name'); 								 
							 	?> 
							<div class="col-sm-6">Make</div> <div class="col-sm-6">  <?php echo $make; ?>  </div> 
							<div class="col-sm-6">Model</div> <div class="col-sm-6">  <?php echo $model; ?>  </div> 
							<div class="col-sm-6">Category</div> <div class="col-sm-6">  <?php echo $veh->category; ?> </div> 
							<div class="col-sm-6">Last Service Id</div>
                            <div class="col-sm-6"> <?php if(!empty($veh->last_service_id)){  ?>  <a style="padding:5px;" target="_blank" href="<?=base_url('bookings/booking_details/')?>/'<?php echo $veh->last_service_id; ?>'" class="label-info">(View - <?php echo $veh->last_service_id; ?>)</a>  <?php } ?> </div> 
							<div class="col-sm-6">Last Service Date</div>
                            <div class="col-sm-6">  <?php if(!empty($veh->last_service_date)) echo date('d-m-Y', strtotime($veh->last_service_date)); ?> </div>  
                        </div>	
						  <hr>
						 <?php } ?>  
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
						
			
				</div>
			
			
			 
		 
				</div>	
					
                
	
				</div>	   
						 
    
                
                
            
        </div>
    </div>
 </div>