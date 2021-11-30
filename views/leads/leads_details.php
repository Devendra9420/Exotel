
 <div class="section-body">
            <h2 class="section-title">Lead ID# <?= $leads->id; ?></h2>
              <p class="section-lead text-right">  
	 		 			<h6 class="label label-primary">Status: <?= $leads->status; ?></h6>  
	 				<div class="btn-group drop-right mb-2">
                      <button class="btn btn-warning btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Action
                      </button>
				<div class="dropdown-menu dropright" x-placement="right-start" style="position: absolute; transform: translate3d(95px, 0px, 0px); top: 0px; left: 0px; will-change: transform;">  
					
                        <a href="<?= base_url() ?>bookings/add_booking/lead_convert/<?php echo $leads->id; ?>"  class="dropdown-item has-icon label-info"><i class="ion-loop"></i> Convert Lead</a>
						   
						 <a style="display: none;" href=''  id="followbooking" class='dropdown-item has-icon label-info'> 
                         <i class="ion-reply-all"></i> Follow-Up Booking</a>  
                        <div class="dropdown-divider"></div>
						 
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
     
            	
					
					
					
                <!-- Nav tabs -->
                <ul class="nav nav-pills" role="tablist">
                    <li class="nav-item"><a class="nav-link active" href="#Section1" aria-controls="customer" role="tab" data-toggle="tab">Customer </a></li>
                    <li class="nav-item"><a class="nav-link" href="#Section2" aria-controls="vehicle" role="tab" data-toggle="tab">Vehicle </a></li>
                    <li class="nav-item"><a class="nav-link" href="#Section3" aria-controls="service" role="tab" data-toggle="tab">Service  </a></li>  
					<li class="nav-item"><a class="nav-link" href="#Section5" aria-controls="payments" role="tab" data-toggle="tab">Estimate </a></li> 
                </ul>
				
				
				<div class="tab-content">
                   
					<div role="tabpanel" class="tab-pane fade show active" role="tabpanel"  id="Section1">
                        
						
					<div class="card"> 
					<div class="card-header with-border">
                    <h5 class="card-title">Details</h5>
            		</div>  
					<div class="card-body"> 
					<div class="row">
					<div class="col-md-5"> Customer Name: </div><div class="col-md-7 w-100">&nbsp;<?= $leads->name; ?>	</div> 
					<div class="col-md-5"> Mobile: </div><div class="col-md-7">&nbsp;<?= $leads->mobile; ?>	</div>  
					<div class="col-md-5"> Alternate No: </div><div class="col-md-7"><?= $leads->alternate_no; ?>	</div> 
					<div class="col-md-5"> Email: </div><div class="col-md-7 w-100">&nbsp;<?= $leads->email; ?>	</div> 
					<div class="col-md-5"> Channel: </div><div class="col-md-7 w-100">&nbsp;<?= $leads->channel; ?>	</div>	
					</div> 
					</div> 	 
					</div> 	
					 
					 
					
						 
					<div class="card"> 
					<div class="card-header with-border">  
             		<h5 class="card-title">Address</h5>
            		</div>
					 <div class="card-body">
						 
					<div class="row">  
					<div class="col-md-5"> Address: </div><div class="col-md-7 w-100">&nbsp;<?= $leads->address; ?>	</div> 
					<div class="col-md-5"> Google Map: </div><div class="col-md-7">&nbsp;<?= $leads->google_map; ?>	</div> 
					<div class="col-md-5"> Area: </div><div class="col-md-7">&nbsp;<?= $leads->area; ?>	</div> 
					<div class="col-md-5"> Pincode: </div><div class="col-md-7">&nbsp;<?= $leads->pincode; ?>	</div>	 
					<div class="col-md-5"> City: </div><div class="col-md-7">&nbsp;<?= $leads->city; ?>	</div>		 
					 </div>
					 
					</div>
					</div>  
					 
					 
					 </div>	 
					
					  
				
					<div role="tabpanel" class="tab-pane fade" role="tabpanel"  id="Section2">
                    <div class="card">  
					<div class="card-header with-border">
                    <h5 class="card-title">Details</h5>
            		</div>
						
					 <div class="card-body">  
						 
						 <div class="row"> 
							 
						 <?php  $make  = $this->Common->single_row('vehicle_make', array('make_id' =>  $leads->make), 'make_name');  
							$model  = $this->Common->single_row('vehicle_model', array('model_id' =>  $leads->model), 'model_name'); 								 
							 	?> 
							<div class="col-sm-6">Make</div> <div class="col-sm-6">  <?php echo $make; ?>  </div> 
							<div class="col-sm-6">Model</div> <div class="col-sm-6">  <?php echo $model; ?>  </div>   
                        </div>	
						 
						 
					 </div>
					</div> 
	   				</div>	 
			 
					<div role="tabpanel" class="tab-pane fade" role="tabpanel"  id="Section3">
						  <div class="card">  
								<div class="card-header with-border">
								<h5 class="card-title">Details</h5>
								</div>
						
					 <div class="card-body">  
						 
						 <div class="row"> 
							  
							<div class="col-sm-6"> Service Category  </div>  <div class="col-sm-6"> <?php echo @$leads->service_category; ?>  </div> 
							<div class="col-sm-6"> Service Date  </div> <div class="col-sm-6"> <?php echo @convert_date($leads->desired_service_date); ?>  </div>   
							<div class="col-sm-6"> Time Slot</div> <div class="col-sm-6">  <?php echo @$leads->desired_time_slot; ?>  </div> 
							 <div class="col-sm-6"> Complaints</div> <div class="col-sm-6"> 
							
							  <?php
							  $complaints_split = explode('+', $leads->complaints);
						$n =1;
						foreach ($complaints_split as $complaint_list){
							if(!empty($complaint_list)){   
							echo $n.') '. $complaint_list.'<br>';
							$n++;
							}
						}
						?> 
							  </div>   
							<div class="col-sm-6"> Comments</div> <div class="col-sm-6">  <?php echo @$leads->comments; ?>  </div>   
                        </div>	
						  </div> 
							   </div> 
						    
						   
					</div>	
						
					
				 
					              
						<div role="tabpanel" class="tab-pane fade" role="tabpanel"  id="Section5">
						  <div class="row"> 
							
							  
							  
							  
							<div class="card"> 
                  <div class="card-body">
                    <div class="row">
                      
								
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
											if($leads_estimate)	
											foreach ($leads_estimate as $rows) {
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
						  <hr>
					</div>	
					
					
					
					 
					
					
					
					
					
						
				</div>
			
			
			 
		 
				</div>	
					
                
	
				</div>	   
						 
    
                
                
            
        </div>
    </div>
 </div>
 
