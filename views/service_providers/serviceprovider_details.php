
 <div class="section-body">
            <h2 class="section-title">Service Provider Details: </h2>
            <p class="section-lead"> 
				
				<?php if(!empty($serviceprovider->pic)){  ?>
						<a class="gallery-item" id="dp-img"><img width="50"  alt="image" src="<?= @$serviceprovider->pic; ?>" class="rounded-circle" data-toggle="tooltip" title="<?php echo $serviceprovider->name; ?> Profile Pic" data-original-title="<?php echo $serviceprovider->name; ?>"></a>
						<?php } ?>
	 
	 		<?php echo make_first_capital($serviceprovider->name).' '.make_first_capital($serviceprovider->lastname); ?>
	 
	 
            </p> 
	<div class="row">
        <div class="col-lg-12">
              
				
				<div class="box box-primary">
				 <div class="box-header text-left"> 
					 
					 <?php if ($serviceprovider->is_active == 1) { 
echo $act = "<a class='btn btn-sm btn-warning' href='".base_url()."serviceproviders/deactive_serviceprovider/$serviceprovider->id'>Deactivate</a>"; 
            } else { 
echo $act = "<a class='btn btn-sm btn-success' href='".base_url()."serviceproviders/activate_serviceprovider/$serviceprovider->id'>Activate</a>";
            } ?>
					  
                
					
					<div class="text-right"> 
					 <a href="<?php echo base_url(); ?>serviceproviders/list_serviceproviders" class="btn btn-sm btn-info">Back</a>
                	</div>
				
					</div>
					
				<div class="box-body">
     
            	
                <!-- Nav tabs -->
                <ul class="nav nav-pills" role="tablist">
                    <li class="nav-item"><a class="nav-link active" href="#Section1" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-user"></i> Service Provider KYC</a></li> 
                </ul>
				
				
				<div class="tab-content">
                   
					<div role="tabpanel" class="tab-pane fade show active" role="tabpanel"  id="Section1">
                        
						
					<div class="card"> 
					<div class="card-header with-border">
                    <h5 class="card-title">Details</h5>
            		</div>  
					<div class="card-body"> 
					<div class="row"> 
					<div class="col-md-5"> Mobile: </div><div class="col-md-7">&nbsp;<?= $serviceprovider->mobile; ?>	</div>  
					<div class="col-md-5"> Alternate No: </div><div class="col-md-7"><?= @$serviceprovider->alternate_no; ?>	</div> 
					<div class="col-md-5"> Email: </div><div class="col-md-7 w-100">&nbsp;<?= $serviceprovider->email; ?>	</div> 
					<div class="col-md-5"> Department: </div><div class="col-md-7 w-100">&nbsp;<?= get_department($serviceprovider->department); ?>	</div>	
					</div> 
					</div> 	 
					</div>  
				 
					<div class="card"> 
					<div class="card-header with-border">
              		<h5 class="card-title">Documents</h5>
            		</div>
					<div class="card-body">
					<div class="row">
						
					<div class="col-md-5"> Aadhar Card (Front): </div><div class="col-md-7 w-100"><?php if(!empty($serviceprovider->aadhar_front)){  ?>
						<div class="gallery-item" data-image="<?= @$serviceprovider->aadhar_front; ?>" data-title="Aadhar Card (Front)" href="<?= @$serviceprovider->aadhar_front; ?>" title="Aadhar Card (Front)" style="background-image: url("<?= @$serviceprovider->aadhar_front; ?>");"></div>
						<?php } ?></div> 
					<div class="col-md-5"> Aadhar Card (Back): </div><div class="col-md-7 w-100"><?php if(!empty($serviceprovider->aadhar_back)){  ?>
						<div class="gallery-item" data-image="<?= @$serviceprovider->aadhar_back; ?>" data-title="Aadhar Card (Back)" href="<?= @$serviceprovider->aadhar_back; ?>" title="Aadhar Card (Back)" style="background-image: url("<?= @$serviceprovider->aadhar_back; ?>");"></div>
						<?php } ?></div>	
					<div class="col-md-5"> PAN Card: </div><div class="col-md-7"><?php if(!empty($serviceprovider->pan_card)){  ?>
						<div class="gallery-item" data-image="<?= @$serviceprovider->pan_card; ?>" data-title="PAN Card" href="<?= @$serviceprovider->pan_card; ?>" title="PAN Card" style="background-image: url("<?= @$serviceprovider->pan_card; ?>");"></div>
						<?php } ?></div> 
					<div class="col-md-5"> Driving License: </div><div class="col-md-7"><?php if(!empty($serviceprovider->driving_license)){  ?>
						<div class="gallery-item" data-image="<?= @$serviceprovider->driving_license; ?>" data-title="Driving License" href="<?= @$serviceprovider->driving_license; ?>" title="Driving License" style="background-image: url("<?= @$serviceprovider->driving_license; ?>");"></div>
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
					<div class="col-md-5"> Address: </div><div class="col-md-7 w-100">&nbsp;<?= @$serviceprovider->address; ?>	</div>  
					<div class="col-md-5"> Area: </div><div class="col-md-7">&nbsp;<?= @$serviceprovider->area; ?>	</div>  	 
					<div class="col-md-5"> City: </div><div class="col-md-7">&nbsp;<?= @$serviceprovider->city; ?>	</div>		 
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