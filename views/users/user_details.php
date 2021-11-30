
 <div class="section-body">
            <h2 class="section-title">User Details: </h2>
            <p class="section-lead"> 
				<?php echo make_first_capital($user->firstname).' '.make_first_capital($user->lastname); ?>
				<?php if(!empty($user->pic)){  ?>
						<img style="width:30%;" src="<?= @$user->pic; ?>" class="img-rounded" alt="User Profile Pic"> 
						<?php } ?>
            </p> 
	<div class="row">
        <div class="col-lg-12">
              
				
				<div class="box box-primary">
				 <div class="box-header text-left"> 
					 
					 <?php if ($user->is_active == 1) { 
echo $act = "<a class='btn btn-sm btn-warning' href='".base_url()."users/deactive_user/$user->id'>Deactivate</a>"; 
            } else { 
echo $act = "<a class='btn btn-sm btn-success' href='".base_url()."users/activate_user/$user->id'>Activate</a>";
            } ?>
					  
                
					
					<div class="text-right"> 
					 <a href="<?php echo base_url(); ?>users/list_users" class="btn btn-sm btn-info">Back</a>
                	</div>
				
					</div>
					
				<div class="box-body">
     
            	
                <!-- Nav tabs -->
                <ul class="nav nav-pills" role="tablist">
                    <li class="nav-item"><a class="nav-link active" href="#Section1" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-user"></i> User KYC</a></li> 
                </ul>
				
				
				<div class="tab-content">
                   
					<div role="tabpanel" class="tab-pane fade show active" role="tabpanel"  id="Section1">
                        
						
					<div class="card"> 
					<div class="card-header with-border">
                    <h5 class="card-title">Details</h5>
            		</div>  
					<div class="card-body"> 
					<div class="row"> 
					<div class="col-md-5"> Mobile: </div><div class="col-md-7">&nbsp;<?= $user->mobile; ?>	</div>  
					<div class="col-md-5"> Alternate No: </div><div class="col-md-7"><?= @$user->alternate_no; ?>	</div> 
					<div class="col-md-5"> Email: </div><div class="col-md-7 w-100">&nbsp;<?= $user->email; ?>	</div> 
					<div class="col-md-5"> Department: </div><div class="col-md-7 w-100">&nbsp;<?= get_department($user->department); ?>	</div>	
					</div> 
					</div> 	 
					</div>  
				 
					<div class="card"> 
					<div class="card-header with-border">
              		<h5 class="card-title">Documents</h5>
            		</div>
					<div class="card-body">
					<div class="row">
						
					<div class="col-md-5"> Aadhar Card (Front): </div><div class="col-md-7 w-100"><?php if(!empty($user->aadhar_front)){  ?>
						<img style="width:30%;" src="<?= @$user->aadhar_front; ?>" class="img-rounded" alt="Aadhar Card (Front)"> 
						<?php } ?></div> 
					<div class="col-md-5"> Aadhar Card (Back): </div><div class="col-md-7 w-100"><?php if(!empty($user->aadhar_back)){  ?>
						<img style="width:30%;" src="<?= @$user->aadhar_back; ?>" class="img-rounded" alt="Aadhar Card (Back)"> 
						<?php } ?></div>	
					<div class="col-md-5"> PAN Card: </div><div class="col-md-7"><?php if(!empty($user->pan_card)){  ?>
						<img style="width:30%;" src="<?= @$user->pan_card; ?>" class="img-rounded" alt="PAN Card"> 
						<?php } ?></div> 
					<div class="col-md-5"> Driving License: </div><div class="col-md-7"><?php if(!empty($user->driving_license)){  ?>
						<img style="width:30%;" src="<?= @$user->driving_license; ?>" class="img-rounded" alt="Driving License"> 
						<?php } ?></div> 
					</div>
					</div>
					</div>  
						 
					<div class="card"> 
					<div class="card-header with-border">  
             		<h5 class="card-title">Address</h5>
            		</div>
					 <div class="card-body"> 
					<div class="row"> 
					<div class="col-md-5"> Address: </div><div class="col-md-7 w-100">&nbsp;<?= @$user->address; ?>	</div>  
					<div class="col-md-5"> Area: </div><div class="col-md-7">&nbsp;<?= @$user->area; ?>	</div>  	 
					<div class="col-md-5"> City: </div><div class="col-md-7">&nbsp;<?= @$user->city; ?>	</div>		 
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