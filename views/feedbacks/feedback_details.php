 
 <div class="section-body">
            <h2 class="section-title">Feedback#<?= $feedback->feedback_id; ?>  for Booking ID# <?= $feedback->booking_id; ?></h2>
            <p class="section-lead text-right">  
	 		 
                        <a href="<?php if(!empty($_SERVER['HTTP_REFERER'])){ echo $_SERVER['HTTP_REFERER']; }else{ echo $this->uri->uri_string(); } ?>" class="btn btn-sm btn-info">Back</a>
                    
            </p> 
	<div class="row">
        <div class="col-lg-12">
               
				<div class="box box-primary">
				 
					
				<div class="box-body">
     
            	 <div class="row row-eq-height">
        <div class="col-lg-8">
					
				 <div class="card"> 
					<div class="card-header with-border">
                    <h5 class="card-title">Details</h5>
            		</div>  
					<div class="card-body"> 
					<div class="row">
					<div class="col-md-5"> Feedback Date: </div><div class="col-md-7 w-100">&nbsp;<?= convert_date($feedback->feedback_date); ?>	</div>
					<hr>	
					<div class="col-md-5"> Customer Name: </div><div class="col-md-7 w-100">&nbsp;<?= $booking->customer_name; ?>	</div> 
					<div class="col-md-5"> Mobile: </div><div class="col-md-7">&nbsp;<?= $booking->customer_mobile; ?>	</div>  
					<div class="col-md-5"> Alternate No: </div><div class="col-md-7"><?= $booking->customer_alternate_no; ?>	</div> 
					<div class="col-md-5"> Email: </div><div class="col-md-7 w-100">&nbsp;<?= $booking->customer_email; ?>	</div> 
					<div class="col-md-5"> City: </div><div class="col-md-7 w-100">&nbsp;<?= $booking->customer_city; ?>	</div>	
					<div class="col-md-5"> Channel: </div><div class="col-md-7 w-100">&nbsp;<?= $booking->customer_channel; ?>	</div>
					<div class="col-md-5"> Service Date: </div><div class="col-md-7 w-100">&nbsp;<?= convert_date($booking->service_date); ?>	</div>	
					<div class="col-md-5"> Mechanic Name: </div><div class="col-md-7 w-100">&nbsp;<?php echo @get_service_providers(array('id'=>$booking->assigned_mechanic),'name'); ?> </div>	
					<div class="col-md-5"> Total Invoice: </div><div class="col-md-7 w-100">&nbsp;<?= $booking_payments->total_amount; ?>	</div>	
					<div class="col-sm-5"> Complaints</div> <div class="col-sm-7 w-100">&nbsp;
							
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
				
				
				</div>	
					  
        <div class="col-lg-4">
					
				 <div class="card"> 
					<div class="card-header with-border">
                    <h5 class="card-title">Rating</h5>
            		</div>  
					<div class="card-body"> 
					<div class="row">
						<?php
						if($feedback->feedback>3){
							$color = 'success';
						}elseif($feedback->feedback<3){
							$color = 'danger';
						}elseif($feedback->feedback==3){
							$color = 'warning';
						}
						?>
					<div class="col-md-12 text-center"><h1 class="text-<?= $color; ?>"><?=  $feedback->feedback; ?></h1>
						 <h5>Rating</h5></div>
					<hr>	 
					<div class="col-md-12 text-center">
						
						<?php for ($i = 1; $i <= $feedback->feedback; $i++)  { ?>
						<a class="btn btn-icon btn-<?= $color; ?> text-white"><i class="fas fa-star"></i></a>
						<?php } ?>
						
					</div>
						<p>&nbsp;</p>
						<p>&nbsp;</p>
						<p>&nbsp;</p>
					</div> 
					</div> 	 
					</div> 	
				
				
				</div>	
					</div>
					<div class="row"> 
					 <div class="col-lg-12">
						<div class="card">
                <div class="card-body"> 
					<div class="row">
						<div class="col-md-5">Details Confirmed?:</div><div class="col-md-7">&nbsp;<?php echo $feedback->bookingdetailsaccept; ?></div>
						<div class="col-md-5"> Complaints Resolved?: </div><div class="col-md-7">&nbsp;<?php echo $feedback->complaints_resolved; ?></div>
						<div class="col-md-5"> What Wrong?: </div><div class="col-md-7">&nbsp;
						<?php
						if(!empty($feedback->what_went_wrong)){ 
							$wrong_all = explode(',',$feedback->what_went_wrong);
							if(!empty($wrong_all))
							foreach($wrong_all as $wrongs){ 
							echo $wrongs.'<br>';
							}
						}
						 ?></div>
						<div class="col-md-5"> Test Ride?: </div><div class="col-md-7">&nbsp;<?php echo $feedback->test_ride; ?></div>
						<div class="col-md-5"> Tips: </div><div class="col-md-7">&nbsp;<?php echo $feedback->tips; ?></div>
						<div class="col-md-5"> Work Informed?: </div><div class="col-md-7">&nbsp;<?php echo $feedback->workinformed; ?></div>
						<div class="col-md-5"> Billing Change?: </div><div class="col-md-7">&nbsp;<?php echo $feedback->billing_change; ?></div>
						<div class="col-md-5"> Doorstep Experience: </div><div class="col-md-7">&nbsp;<?php echo $feedback->doorstep_experience; ?></div>
						<div class="col-md-5"> Allowed to add on Google: </div><div class="col-md-7">&nbsp;<?php echo $feedback->add_to_google; ?></div>
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