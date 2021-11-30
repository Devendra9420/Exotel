<script> 
$(document).ready(function () {
    $("#update_vehicledetails").validate({
            rules: {
               
              make: {
                  required: true,
              },
              model: {
                  required: true,
              }, 
              name: {
                  required: true,
              },
			claim_no:{
			required: true,	
			},	
             
            }
            });

    $('#name').keypress(function (e) {
    var regex = new RegExp("^[a-zA-Z ]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
    return true;
    }
    else
    {
    e.preventDefault();
    alert('Please enter only alphabets in name');
    return false;
    }
  });
          });
          
</script>
	

<style>
.card-header .fa {
  transition: .3s transform ease-in-out;
}
.card-header .collapsed .fa {
  transform: rotate(90deg);
}
	.card-header .btn[aria-expanded=true] {
color: #fff;
background-color: #858585;
}
.card.active > .card-header{
  background-color: #4a5cf2;
}
	.accordion-button{position:relative;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;width:100%;padding:1rem 1.25rem;font-size:1rem;color:#4f4f4f;text-align:left;background-color:transparent;border:1px solid rgba(0,0,0,.125);border-radius:0;overflow-anchor:none;-webkit-transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,border-radius .15s ease,-webkit-box-shadow .15s ease-in-out;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,border-radius .15s ease,-webkit-box-shadow .15s ease-in-out;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,border-radius .15s ease;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,border-radius .15s ease,-webkit-box-shadow .15s ease-in-out}@media(prefers-reduced-motion:reduce){.accordion-button{-webkit-transition:none;transition:none}}.accordion-button.collapsed{border-bottom-width:0}.accordion-button:not(.collapsed){color:#105cd9;background-color:#e7f0fe}.accordion-button:not(.collapsed):after{background-image:none;-webkit-transform:rotate(180deg);transform:rotate(180deg)}.accordion-button:after{-ms-flex-negative:0;flex-shrink:0;width:1.25rem;height:1.25rem;margin-left:auto;content:"";background-image:none;background-repeat:no-repeat;background-size:1.25rem;-webkit-transition:-webkit-transform .2s ease-in-out;transition:-webkit-transform .2s ease-in-out;transition:transform .2s ease-in-out;transition:transform .2s ease-in-out,-webkit-transform .2s ease-in-out}@media(prefers-reduced-motion:reduce){.accordion-button:after{-webkit-transition:none;transition:none}}.accordion-button:hover{z-index:2}.accordion-button:focus{z-index:3;border-color:#1266f1;outline:0;-webkit-box-shadow:0 4px 10px 0 rgba(0,0,0,.2),0 4px 20px 0 rgba(0,0,0,.1);box-shadow:0 4px 10px 0 rgba(0,0,0,.2),0 4px 20px 0 rgba(0,0,0,.1)}.accordion-header{margin-bottom:0}.accordion-item:first-of-type .accordion-button{border-top-left-radius:.25rem;border-top-right-radius:.25rem}.accordion-item:last-of-type .accordion-button.collapsed,.accordion-item:last-of-type .accordion-collapse{border-bottom-width:1px;border-bottom-right-radius:.25rem;border-bottom-left-radius:.25rem}.accordion-collapse{border:solid rgba(0,0,0,.125);border-width:0 1px}.accordion-body{padding:1rem 1.25rem}.accordion-flush .accordion-button{border-right:0;border-left:0;border-radius:0}.accordion-flush .accordion-collapse{border-width:0}.accordion-flush .accordion-item:first-of-type .accordion-button{border-top-width:0;border-top-left-radius:0;border-top-right-radius:0}.accordion-flush .accordion-item:last-of-type .accordion-button.collapsed{border-bottom-width:0;border-bottom-right-radius:0;border-bottom-left-radius:0}@-webkit-keyframes progress-bar-stripes{0%{background-position-x:4px}}@keyframes progress-bar-stripes{0%{background-position-x:4px}}.progress{height:4px;font-size:.75rem;background-color:#eee;border-radius:.25rem}.progress,.progress-bar{display:-webkit-box;display:-ms-flexbox;display:flex;overflow:hidden}.progress-bar{-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;color:#fff;text-align:center;white-space:nowrap;background-color:#1266f1;-webkit-transition:width .6s ease;transition:width .6s ease}@media(prefers-reduced-motion:reduce){.progress-bar{-webkit-transition:none;transition:none}}.progress-bar-striped{background-image:linear-gradient(45deg,hsla(0,0%,100%,.15) 25%,transparent 0,transparent 50%,hsla(0,0%,100%,.15) 0,hsla(0,0%,100%,.15) 75%,transparent 0,transparent);background-size:4px 4px}.progress-bar-animated{-webkit-animation:progress-bar-stripes 1s linear infinite;animation:progress-bar-stripes 1s linear infinite}
</style>
   <style>
    .pac-container {
        z-index: 10000 !important;
    }
	   label.error, .error, .has-error {
    color:red !important;
	border-color: red !important; 
}
		.has-error .select2-selection {
    border: 1px solid red;
    border-radius: 4px;
}
		.error:before {
    content: "";
}
		
</style>

<script> 
$(document).ready(function () {
    $("#customer_kyc_edit").validate({
            rules: {
              mobile: {
                    required: true,
                    maxlength: 10,
                    minlength: 10,
                    number: true,

                }, 
				alternate_no: { 
                    maxlength: 10,
                    minlength: 10,
                    number: true,

                }, 
				name: {
                  required: true,

              },
              v_address: {
                  required: true,
              },
              customer_google_map: {
                  required: true,
              },
             
            }
            });

    $('#name').keypress(function (e) {
    var regex = new RegExp("^[a-zA-Z ]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
    return true;
    }
    else
    {
    e.preventDefault();
    alert('Please enter only alphabets in name');
    return false;
    }
  });
          });
          
</script>

<section class="content">


    <div class="row">
        <div class="col-md-12">

           
            <div class="box box-primary">
                <div class="box-body box-profile">
                  <div class="row">
        	<div class="col-md-3">  
                    <h3 class="profile-username text-center">Survey No: <?php echo $surveyDetail['id']; ?></h3>

                     <hr>
					<p  class="text-muted text-center" >
					<?php 		
						
						if($surveyDetail['active'] == 1){ 
							
								if($stage['stage'] == 0){ 
									echo '<span class="label label-light"  style="color:black;">'. $stage['status'] .'</span>';
								}
                                 elseif($stage['stage'] == 1){ 
									echo '<span class="label label-default">'.$stage['status'].'</span>';
								}					   
								 elseif($stage['stage'] == 2){ 
									echo '<span class="label label-primary"> '.$stage['status'].' </span>';
								 }
								elseif($stage['stage'] == 3){ 
									echo '<span class="label label-info"> '.$stage['status'].' </span>';
								 }
								elseif($stage['stage'] == 4){ 
									echo '<span class="label label-info"> '.$stage['status'].' </span>';
								}
								elseif($stage['stage'] == 5){ 
									echo '<span class="label label-info"> '.$stage['status'].' </span>';
								 }
						        elseif($stage['stage'] == 6){ 
									echo '<span class="label label-info"> '.$stage['status'].' </span>';
								 }
								elseif($stage['stage'] == 7){ 
									echo '<span class="label label-warning"> '.$stage['status'].' </span>';
								 }
								elseif($stage['stage'] == 8){ 
									echo '<span class="label label-info"> '.$stage['status'].' </span>';
								 }
								elseif($stage['stage'] == 9){ 
									echo '<span class="label label-info"> '.$stage['status'].' </span>';
								 }
								elseif($stage['stage'] == 10){ 
									echo '<span class="label label-success"> '.$stage['status'].' </span>';
								 }
								 else{
                                    echo '<span class="label label-danger"> Status:Error </span>';
								 }
														  }
							else{
                                    if(!empty($surveyDetail['close_type'])){ 
							
								echo '<br><span class="label label-danger"> Claim Cancelled: '.$surveyDetail['close_type'].'</span>';
								}else{
								echo '<span class="label label-danger"> Claim Cancelled: Error </span>';
								 }
							
														   
							 }
						
						 
					?></p>
					<p class="text-muted text-center" id="paymentstatus" style="display: none;"><b><span class="label label-success" id="paymentcollectedamt"></span>  </b></p>
					<p  class="text-muted text-center"><b><?php 
						$where = array('GIC_ID' => $surveyDetail['gic']);
						$getvalue =$this->Main_model->single_row('gic', $where, 's');
						echo $getvalue['GIC_NAME']; ?></b> <br> Claim No: <?php echo $surveyDetail['claim_no']; ?></p>
					
					<br>
				</div>
					  <div class="col-md-9">  
					<p   class="text-muted text-center">Created On: <?php  echo date('d-m-Y',strtotime($surveyDetail['created_on'])); ?></p>
					
					<p   class="text-muted text-center">Created By: <?php 
						$where = array('USER_ID' => $surveyDetail['created_by']);
						$getvalue =$this->Main_model->single_row('usr_user', $where, 's');
						echo $getvalue['USER_NAME']; ?></p>
					
					<p  class="text-muted text-center"><b><?php 
						$where = array('city_id' => $surveyDetail['city']);
						$getvalue =$this->Main_model->single_row('city', $where, 's');
						echo $getvalue['cityname']; ?></b></p>
					<p class="text-muted text-center"><?php  echo"<a href='#mod_editkyc' data-toggle='modal' class='btn btn-small btn-default'> Edit KYC </a>"; ?></p>	  
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Name</b> <a class="pull-right"><?php echo $surveyDetail['name']; ?></a>
                        </li>
						<li class="list-group-item">
                            <b>Mobile</b> <a class="pull-right"><?php echo $surveyDetail['mobile']; ?></a>
                        </li>
						<li class="list-group-item">
                            <b>Alternate Number</b> <a class="pull-right"><?php echo $surveyDetail['alternate_no']; ?></a>
                        </li>
                        <li class="list-group-item">
                            <b>Email</b> <a class="pull-right"><?php echo $surveyDetail['email']; ?></a>
                        </li>
						<li class="list-group-item">
                            <b>Address</b> <a class="pull-right"><?php echo $surveyDetail['v_address']; ?></a>
                        </li>
						<li class="list-group-item">
                            <b>Google Address</b> <a class="pull-right"><?php echo $surveyDetail['google_map']; ?></a>
                        </li>
                    </ul>
                </div>
					</div>
					
					
					 <div class="row" style="padding:10px 0px;margin-top:5px;background-color:#f2f2f2;">
                        <div class="col-sm-6">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea class="form-control" name="admincomment" id="admincomment"></textarea>
                                </div>
                             
                                <button type="button" class="btn btn-primary" onclick="addComment(<?php echo $surveyDetail['id']; ?>)">Add Comment</button>
                            </div>
                        </div>
        			<div class="col-md-6">	
					<h3 class="box-title">Comments:</h3><br/>
					<div id="adminnotes">	
					<?php 
						
						$sql = $this->db->query("select * from claim_notes where claim_id=".$surveyDetail['id']."");
        				$data['claim_notes'] = $sql->result();
                                foreach ($data['claim_notes'] as $claim_notes) {
									echo $claim_notes->notes.'<br><small style="color:grey">'.date('d-m-Y H:i:s', strtotime($claim_notes->created_on)).'</small><hr>';
								}  ?>
					</div>	
					</div>
                    </div>
				
				
				</div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

		
		
		<!-- VEHICLE DETAILS ---->
		
        <div class="col-md-12">
            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    
                    <div  class="col-md-7">
                     <?php if($stage['stage'] < 11) { ?>
						   <?php if($stage['stage'] == 0){ 
							 
							 echo"<a href='#mod_assign' data-toggle='modal' class='btn btn-info'> ASSIGN SURVEY </a>";
						 
	//echo '<span class="label label-default">ASSIGN CASE</span>';
									}
														   
														   
                                elseif($stage['stage'] == 1){ 
									?>
									 <a  onclick='return confirm("Are you sure you want to start the survey?");'  href='<?php echo  base_url()."claims/surveystatus_claims_btn/".$surveyDetail['id']."' data-toggle='modal' class='btn btn-info'> START SURVEY</a>";
									//echo '<span class="label label-default">CREATE SURVEY FORM</span>';
								}
														   
								 elseif($stage['stage'] == 2){ 
									
									echo"<a href='#mod_surveydetails' data-toggle='modal' class='btn btn-info'> ENTER SURVEY DETAILS </a>";
									//echo '<span class="label label-default">CREATE SURVEY FORM</span>';
								}						   
														   
								 elseif($stage['stage'] == 3){ 
									 
									 echo"<a href='".base_url()."claims/claims_estimate/".$surveyDetail['id']."' data-toggle='modal' class='btn btn-info'> CREATE ESTIMATE </a>";
									 //echo '<span class="label label-default">CREATE ESTIMATE FORM</span>';
								 }
														   
								elseif($stage['stage'] == 4){ 
									 
									echo"<a href='".base_url()."claims/claims_estimate_approved/".$surveyDetail['id']."' data-toggle='modal' class='btn btn-info'> UPDATE ASSESMENT </a>";
									
									// echo"<a href='#mod_gicapproval' data-toggle='modal' class='btn btn-lg btn-huge green btn-info'> UPDATE Insurer APPROVAL </a>";
									 //echo '<span class="label label-default">CREATE ESTIMATE FORM</span>';
								 }
								elseif($stage['stage'] == 5){ 
									 
									 echo"<a href='#mod_customerapproval' data-toggle='modal' class='btn btn-info'> UPDATE CUSTOMER APPROVAL </a>";
									 //echo '<span class="label label-default">CREATE ESTIMATE FORM</span>';
								 }
														   
								elseif($stage['stage'] == 6){ 
									
									 	if($stage['status'] == 'Customer Approval Received'){ 
									 
										 
										
										?>
									 
			<a  onclick='return confirm("Are you sure you ordered spares?");'  href='<?php echo  base_url()."claims/spares_ordered/".$surveyDetail['id']."'  class='btn btn-info'> SPARES ORDERED</a>";
									//echo '<span class="label label-default">CREATE SURVEY FORM</span>';
								
										} else{ 
								
        $sql = $this->db->query("select * from claim_customer_approval where claim_id=".$surveyDetail['id']);
        $customerapproval = $sql->row();
                                 
									
						 
						
									if($customerapproval->approved_status == 'Approved'){ 
									 echo"<a href='#mod_repair' data-toggle='modal' class='btn btn-info'> START REPAIR </a>";
									 //echo '<span class="label label-default">CREATE ESTIMATE FORM</span>';
									} else{
                                    echo '<span class="label label-danger">Customer Approval: '.$customerapproval->approved_status.'</span>';
									}
										}
									
								 }
								
								elseif($stage['stage'] == 7){ 
									 
									 echo "<a href='#mod_invoice' data-toggle='modal' class='btn btn-info'> END REPAIR </a>";
										 
									 
								 }elseif($stage['stage'] == 8){ 
									 
									 echo "<a href='#mod_gicliability' data-toggle='modal' class='btn btn-info'> UPDATE LIABILITY </a>";
									
								 }elseif($stage['stage'] == 9){ 
									 
									 echo "<button type='button' id='checkRZPayment_btn' class='btn btn-info'> END CASE</button>";
									
								 }elseif($stage['stage'] == 10){ 
									 
									 echo '<span class="label label-success" style="padding:5px;">DELIVERY COMPLETED: CLAIM CLOSED</span>';
									
								 }
								 else{
                                    echo '<span class="label label-danger">CLAIM STAGES : ERROR!</span>';
								}
														  }
						
						
						 
						?>
                    </div>
					<div class="col-md-3">
						<?php if($surveyDetail['active'] == 1){  
						//  href="<?=base_url('claims/close_claims/'.$surveyDetail['id'])" 
						if($stage['stage'] < 9){ 
						?>
						<a href='#mod_closeclaimsnow' data-toggle='modal' class="btn btn-danger">CANCEL CLAIM</a> 
						<?php 
						}
						}
						?>
					</div>
					<div class="col-md-2">
                        <a href="<?=base_url('claims/list_claims')?>" class="btn btn-info">Back</a>
                    </div>
					
					
					
					<div class="col-md-12">
						<hr>
					<h3 class="box-title">About Vehicle</h3>
					</div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                   
					<div class="col-md-2">
					
					<strong> Vehicle Make</strong>

                    <p class="text-muted">
                         <?php 
						$where = array('make_id' => $surveyDetail['make']);
						$getvalue =$this->Main_model->single_row('vehicle_make', $where, 's');
						echo $getvalue['make_name']; ?>
                    </p>
					</div>
					
                    <div class="col-md-2">
					
                    <strong > Vehicle Model</strong>

                    <p class="text-muted">
                         <?php 
						$where = array('model_id' => $surveyDetail['model']);
						$getvalue =$this->Main_model->single_row('vehicle_model', $where, 's');
						echo $getvalue['model_name']; ?>
                    </p>

                    </div>
					
                    <div class="col-md-2">

                    <strong>Year Of Make</strong>
					
                    <p class="text-muted">
						<?php
	
						$where = array('claim_id' => $surveyDetail['id']);
						$getvalue =$this->Main_model->single_row('claim_survey_details', $where, 's');
						//echo $getvalue['make_name']; 
	
						 
						?>
                         <?php  if(!empty($getvalue['yom'])){ echo $getvalue['yom']; }else{ echo '';} ?>
                    </p>
					</div>
					
                    <div class="col-md-2">
					
					<strong>Color</strong>
					
                    <p class="text-muted">
                         <?php  echo $getvalue['color']; ?>
                    </p>
					</div>
					
                    <div class="col-md-2">
					
					<strong>Registration No.</strong>
					
                    <p class="text-muted">
                         <?php  echo $getvalue['regno']; ?>
                    </p>
					</div>
					
                    <div class="col-md-2">
					
					
					
					<strong>Km Reading</strong>
					
                    <p class="text-muted">
                         <?php  echo $getvalue['km']; ?>
                    </p>
					</div>
					
                     
					
                    <div class="col-md-3" style="display: none;">
					
					
					<strong>Engine No.</strong>
					
                    <p class="text-muted">
                         <?php  echo $getvalue['engine_no']; ?>
                    </p>
					</div>
					
                    <div class="col-md-3" style="display: none;">
					
					
					<strong>Chasis No.</strong>
					
                    <p class="text-muted">
                         <?php  echo $getvalue['chasis_no']; ?>
                    </p>
					</div>
					
                     
			 	</div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
		</div>
			
		<!-- VEHICLE DETAILS END ---->
		<div class="accordion" id="accordionExample">
		
			
			
		<!------------------------- DOCUMENTS ----------------------------------------->
			
			 
		 
			
			 <div class="card">
    <div class="card-header" id="heading0">
      <h2 class="mb-0">
        <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapse0" aria-expanded="true" aria-controls="collapse0">
         Claim Documents <?php
	
						$where = array('claims_id' => $surveyDetail['id']);
						$getvalue =$this->Main_model->single_row('claims_uploads', $where, 's');
						//echo $getvalue['make_name']; 
						 
		  $didcustupload = $this->db->query("select count(id) as custuploads from claims_uploads where uploaded_by='Customer' and claims_id=".$surveyDetail['id'])->row();
		  if(!empty($didcustupload->custuploads) && $didcustupload->custuploads>0){
			  echo '<span class="label label-default"> Customer Uploaded</span>';
		  }
		 
						 
						

						?>
        </button>
      </h2>
    </div>

    <div id="collapse0" class="collapse" aria-labelledby="heading0" data-parent="#accordionExample">
      <div class="card-body">
		  <!-------------------------------------------------------- Open Accordion ---->
		  
			<div class="col-md-12">
            
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Claim Documents</h3>
					<hr>
                
				<?php
	
						$where = array('claim_id' => $surveyDetail['id']);
						$getvalue =$this->Main_model->single_row('claim_survey_details', $where, 's');
						//echo $getvalue['make_name']; 
	
						 


						?>
			 
				 
				 
					<div class="col-md-2">
				 
					
					<strong>Driving License</strong><br>

                   &nbsp;<br>
							<?php
						 $thissurveydoc = $surveyDetail['id'];
        $sql = $this->db->query("select * from claims_uploads where claims_id=$thissurveydoc AND type='Driving_License_Front'");
        $driving_license_front = $sql->row();
											 
		//$sql = $this->db->query("select * from claims_uploads where claims_id=$thissurveydoc AND type='Driving_License_Back'");
     //   $driving_license_back = $sql->row();
											 
							?> 
 <?php if(!empty($driving_license_front->file_url)){ ?><a target="_blank" href="<?php echo base_url($driving_license_front->file_url); ?>">View Driving License</a><br>  <?php } ?>
<?php /*?> <?php if(!empty($driving_license_back->file_url)){ ?><a target="_blank" href="<?php echo base_url($driving_license_back->file_url); ?>" >View Back Side</a>  <?php } ?><?php */?>
					 
					
					 
				</div>
				<div class="col-md-2">
				 
					
					<strong>PAN Card</strong>

                    &nbsp;<br>
							<?php
						 
        $sql = $this->db->query("select * from claims_uploads where claims_id=$thissurveydoc AND type='PAN_Card'");
        $PAN_Card = $sql->row();
						  if(!empty($PAN_Card->file_url)){ 
						 ?>
						 <br> <a target="_blank" href="<?php echo base_url($PAN_Card->file_url); ?>" >View Pancard </a>
						<?php } ?>
					 
				</div>
					
			 
					
				<div class="col-md-2">
				 
					
					<strong>RC Copy</strong>
						&nbsp;<br>
                  
							<?php
						 
        $sql = $this->db->query("select * from claims_uploads where claims_id=$thissurveydoc AND type='RC_Copy'");
        $RC_Copy = $sql->row();
						 if(!empty($RC_Copy->file_url)){ 
							?> 
						 <br>  <a target="_blank" href="<?php echo base_url($RC_Copy->file_url); ?>">Open RC Copy </a>
						<?php
						}
						?> 
							
					 
				</div>
					
					<hr>
               <div class="col-md-2">
					<strong>Claim Form</strong> 
						 &nbsp;<br>
							<?php
						  
        $sql = $this->db->query("select * from claims_uploads where claims_id=$thissurveydoc AND type='Claim_Form'");
        $data['Claim_Form'] = $sql->result();
						
											 $i = 1;
						 foreach($data['Claim_Form'] as $Claim_Form){
							if(!empty($Claim_Form->file_url)){ 
							?>
						 
						    
				  <br> <a target="_blank" href="<?php echo base_url($Claim_Form->file_url); ?>" >View Image <?php echo $i; ?></a>
						<?php
						 $i++;
							}
						 }
						?> 
							 
					</div>
					
					<div class="col-md-3">
					<strong>Vehicle Images</strong> 
						 
						 &nbsp;<br>
							<?php
						 
        $sql = $this->db->query("select * from claims_uploads where claims_id=$thissurveydoc AND type='Vehicle_Images'");
        $data['Vehicle_Images'] = $sql->result();
							 $i = 1;
						 foreach($data['Vehicle_Images'] as $vehicleImages){
						if(!empty($vehicleImages->file_url)){ 	
							?>
						 
						   
          <br>  <a target="_blank" href="<?php echo base_url($vehicleImages->file_url); ?>" >View Image <?php echo $i; ?></a>
						<?php
						 $i++;
							}
						 }
						?> 
							 
					
				</div>
					
					
					
					
					
			</div>
			</div>
			</div>	
		   <!-------------------------------------------------------- Close Accordion ---->
		  </div>
    </div>
  </div>
		 
		<!------------------------- DOCUMENTS END ----------------------------------------->
			
			
			
		<!-- ASSIGNED DETAILS ---->
		<?php if($stage['stage'] >= 1){ ?>
			
			 <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
          Survey Assigned Details
        </button>
      </h2>
    </div>

    <div id="collapse1" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
		  <!-------------------------------------------------------- Open Accordion ---->
			<div class="col-md-12">
            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    
					
					<h3 class="box-title">Survey Assigned Details</h3>
					<hr>
                    <div class="col-md-6">
						
						<?php
	
						$where = array('claim_id' => $surveyDetail['id']);
						$getvalue =$this->Main_model->single_row('claim_survey_assign', $where, 's');
						//echo $getvalue['make_name']; 
	
						 
						?>
					<strong>Surveyor Name: </strong>
						<?php
						$whereclau = array('surveyor_id' => $getvalue['surveyor']);
						$surveyorname= $this->Main_model->single_row('surveyor', $whereclau, 's');
						?>
						<?= $surveyorname['name'] ?>
					</div>
					<div class="col-md-6">
					<strong>Survey Assigned Date: </strong>
						 
					<?= date('d-m-Y', strtotime($getvalue['survey_date'])) ?>
					</div>
				</div>
			</div>
			</div>
		  <!-------------------------------------------------------- Close Accordion ---->
		  </div>
    </div>
  </div>
		<?php } ?>
		<!-- ASSIGNED DETAILS END ---->
		
		<!-- SURVEY STATUS DETAILS ---->
		<?php if($stage['stage'] >= 2){ ?>
			
			 <div class="card">
    <div class="card-header" id="heading2">
      <h2 class="mb-0">
        <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapse2" aria-expanded="true" aria-controls="collapse2">
          Survey Status Details
        </button>
      </h2>
    </div>

    <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordionExample">
      <div class="card-body">
		  <!-------------------------------------------------------- Open Accordion ---->
		  
			 <div class="col-md-12">
            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    
					
					<h3 class="box-title">Survey Status Details</h3>
					<hr>
                    <div class="col-md-6">
						
						<?php
	
						$where = array('claim_id' => $surveyDetail['id']);
						$getvalue =$this->Main_model->single_row('claim_survey_status', $where, 's');
						//echo $getvalue['make_name']; 
	
						 

						?>
					<strong>Surveyor Status: </strong>
						 
						<?= $getvalue['survey_status'] ?>
					</div>
					<div class="col-md-6">
					<strong>Survey Date: </strong>
						 
					<?= date('d-m-Y', strtotime($getvalue['survey_date'])) ?>
					</div>
				
		  
		  <!-- SURVEY FORM DETAILS ---->
		<?php if($stage['stage'] >= 3){ ?>
			
			  
		   
                     
                
				<?php
	
						$where = array('claim_id' => $surveyDetail['id']);
						$getvalue =$this->Main_model->single_row('claim_survey_details', $where, 's');
						//echo $getvalue['make_name']; 
	
						 


						?>
				<div class="col-md-6">
				 
					
					<strong>Surveyed On Date.</strong>
 
                         &nbsp; <?= date('d-m-Y', strtotime($getvalue['surveyed_on'])) ?>     
                     
					 
				</div>
				<div class="col-md-6">
				 
					
					<strong>Insurance Expiry Date.</strong>

                     
                         &nbsp; <?= date('d-m-Y', strtotime($getvalue['insurance_expire'])) ?>     
                    
				</div>	
				<div class="col-md-3" style="display: none;">
				 
					
					<strong> Engine No.</strong>

                   <p class="text-muted">
                       &nbsp;  <?php echo $getvalue['engine_no'];  ?>
                    </p>
					 
				</div>
				<div class="col-md-3" style="display: none;">
				 
					
					<strong> Chasis No.</strong>

                    <p class="text-muted">
                        &nbsp; <?php echo $getvalue['chasis_no'];  ?>
                    </p>
					 
				</div>
					   
					<hr>
                     <div style="display: none;">
					<div class="col-md-2">
				 
					
					<strong>Driving License</strong><br>

                   &nbsp;<br>
							<?php
						 $thissurveydoc = $surveyDetail['id'];
        $sql = $this->db->query("select * from claims_uploads where claims_id=$thissurveydoc AND type='Driving_License_Front'");
        $driving_license_front = $sql->row();
											 
		//$sql = $this->db->query("select * from claims_uploads where claims_id=$thissurveydoc AND type='Driving_License_Back'");
     //   $driving_license_back = $sql->row();
											 
							?> 
 <?php if(!empty($driving_license_front->file_url)){ ?><a target="_blank" href="<?php echo base_url($driving_license_front->file_url); ?>">View Driving License</a><br>  <?php } ?>
<?php /*?> <?php if(!empty($driving_license_back->file_url)){ ?><a target="_blank" href="<?php echo base_url($driving_license_back->file_url); ?>" >View Back Side</a>  <?php } ?><?php */?>
					 
					
					 
				</div>
				<div class="col-md-2">
				 
					
					<strong>PAN Card</strong>

                    &nbsp;<br>
							<?php
						 
        $sql = $this->db->query("select * from claims_uploads where claims_id=$thissurveydoc AND type='PAN_Card'");
        $PAN_Card = $sql->row();
						  if(!empty($PAN_Card->file_url)){ 
						 ?>
						 <br> <a target="_blank" href="<?php echo base_url($PAN_Card->file_url); ?>" >View Pancard </a>
						<?php } ?>
					 
				</div>
					
			 
					
				<div class="col-md-2">
				 
					
					<strong>RC Copy</strong>
						&nbsp;<br>
                  
							<?php
						 
        $sql = $this->db->query("select * from claims_uploads where claims_id=$thissurveydoc AND type='RC_Copy'");
        $RC_Copy = $sql->row();
						 if(!empty($RC_Copy->file_url)){ 
							?> 
						 <br>  <a target="_blank" href="<?php echo base_url($RC_Copy->file_url); ?>">Open RC Copy </a>
						<?php
						}
						?> 
							
					 
				</div>
					
					<hr>
               <div class="col-md-2">
					<strong>Claim Form</strong> 
						 &nbsp;<br>
							<?php
						  
        $sql = $this->db->query("select * from claims_uploads where claims_id=$thissurveydoc AND type='Claim_Form'");
        $data['Claim_Form'] = $sql->result();
						
											 $i = 1;
						 foreach($data['Claim_Form'] as $Claim_Form){
							if(!empty($Claim_Form->file_url)){ 
							?>
						 
						    
				  <br> <a target="_blank" href="<?php echo base_url($Claim_Form->file_url); ?>" >View Image <?php echo $i; ?></a>
						<?php
						 $i++;
							}
						 }
						?> 
							 
					</div>
					
					<div class="col-md-3">
					<strong>Vehicle Images</strong> 
						 
						 &nbsp;<br>
							<?php
						 
        $sql = $this->db->query("select * from claims_uploads where claims_id=$thissurveydoc AND type='Vehicle_Images'");
        $data['Vehicle_Images'] = $sql->result();
							 $i = 1;
						 foreach($data['Vehicle_Images'] as $vehicleImages){
						if(!empty($vehicleImages->file_url)){ 	
							?>
						 
						   
          <br>  <a target="_blank" href="<?php echo base_url($vehicleImages->file_url); ?>" >View Image <?php echo $i; ?></a>
						<?php
						 $i++;
							}
						 }
						?> 
							 
					
				</div>
					
					
					</div>
				 
		   
		<?php } ?>
		<!-- SURVEY FORM DETAILS END ---->
			
					</div>
			</div>
			</div>	
		  
		   <!-------------------------------------------------------- Close Accordion ---->
		  </div>
    </div>
  </div>
		<?php } ?>
		<!-- SURVEY STATUS DETAILS END ---->
		
		
		
		
		
		 
		
		
		
		<!-- ESTIMATED DETAILS ---->
		<?php if($stage['stage'] >= 4){ ?>
			
			 <div class="card">
    <div class="card-header" id="heading4">
      <h2 class="mb-0">
        <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="true" aria-controls="collapse4">
          Estimate Details
        </button>
      </h2>
    </div>

    <div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordionExample">
      <div class="card-body">
		  <!-------------------------------------------------------- Open Accordion ---->
		  
			 <div class="col-md-12">
            
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Estimate Details</h3>
					<hr>
                
				
				<div class="col-md-3">
				 
					
					<strong>Estimate No.</strong>
					
					<?php
	
						$where = array('claim_id' => $surveyDetail['id']);
						$getvalue =$this->Main_model->single_row('claim_estimate', $where, 's');
						//echo $getvalue['make_name']; 
	
						 
						  


						?>
					
                    <p class="text-muted">
                             <?php echo $getvalue['estimate_no'];  ?>   
                    </p>
					 
				</div>
					
				<div class="col-md-3">
				 
					
					<strong>Estimate Date.</strong>

                    <p class="text-muted">
                             <?= date('d-m-Y', strtotime($getvalue['estimate_date'])) ?>   
                    </p>
					 
				</div>
				<div class="col-md-3">
				 
					
					<strong>Estimate Total</strong>

                   <p class="text-muted">
                         <?php echo $getvalue['estimate_total'];  ?>
                    </p>
					 
				</div>
				<div class="col-md-3">
				 		 
					
					<strong>Estimated Spares</strong>

                    <p class="text-muted">
                         <?php echo $getvalue['total_spares'];  ?>
                    </p>
					<br />
					 <strong>Estimated Labour</strong>

                    <p class="text-muted">
                         <?php echo $getvalue['total_labour'];  ?>
                    </p>
				</div>
					   
					<hr>
                    <div class="col-md-12">
					<strong>Estimated Items</strong><br>
						<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-body">
                <div class="invoice">
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th> #</th> 
                                    <th> Item</th>
                                    <th > Quantity</th>
                                    <th > Spares Cost</th>									
                                    <th > Labour Cost</th>
                                    <th> Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $n = 1;
											   
								 
						  
	
        $sql = $this->db->query("select * from claims_estimate_details where claims_id=".$thissurveydoc);
        $data['estimated_items'] = $sql->result();
                                foreach ($data['estimated_items'] as $rows) {
                                    ?>
                                    <tr>
                                        <td><?php echo $n; ?></td> 
                                        <td><?php echo $rows->item; ?></td>
                                        <td ><?php echo $rows->qty; ?></td>
                                        <td > <?php echo $rows->rate; ?></td>
										<td > <?php echo $rows->labour_rate; ?></td>
                                        <td > <?php echo $rows->amount; ?></td>
                                    </tr>
                                    <?php $n++;
                                } ?>

                                </tbody>
                            </table>
                        </div>
						
						 <div class="col-md-12">
							 <hr/>
						<b> Comments: </b><?php echo $getvalue['remark'];  ?>
							 <hr/>
						</div>
						
						<div class="form-group col-lg-6">
							<a target="new" href='<?= base_url('claims/claim_estimate_print/'.$surveyDetail['id']) ?>' data-toggle='modal'
                               class='btn btn-success'>
                                <i class='fa fa-pencil-square-o'></i>
                                Print Estimate
                            </a>
							 </div>
						
						<div class="form-group col-lg-6">
							<a href='<?= base_url('claims/claims_estimate_edit/'.$surveyDetail['id']) ?>' data-toggle='modal'
                               class='btn btn-warning'>
                                <i class='fa fa-pencil-square-o'></i>
                                Edit Estimate
                            </a>
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
			 <!-------------------------------------------------------- Close Accordion ---->
		  </div>
    </div>
  </div>
		<?php } ?>
		<!-- ESTIMATED DETAILS END ---->
		
		<!-- Insurer APPROVAL DETAILS ---->
		<?php if($stage['stage'] >= 5){ ?>
			
			
			 <div class="card">
    <div class="card-header" id="heading5">
      <h2 class="mb-0">
        <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapse5" aria-expanded="true" aria-controls="collapse5">
          Insurer Assesment Details
        </button>
      </h2>
    </div>

    <div id="collapse5" class="collapse" aria-labelledby="heading5" data-parent="#accordionExample">
      <div class="card-body">
		  <!-------------------------------------------------------- Open Accordion ---->
		  
		  
			 <div class="col-md-12">
            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    
					
					<h3 class="box-title">Insurer Assesment Details</h3>
					<hr>
					<?php
	
						$where = array('claim_id' => $surveyDetail['id']);
						$getvalue =$this->Main_model->single_row('claim_gic_approval', $where, 's');
						//echo $getvalue['make_name']; 
	
						 
						    	 



						?>
                    <div class="col-md-3">
					<strong>Approval Status:</strong>
						 <?= $getvalue['approved_status'] ?>
					</div>
					<div class="col-md-3">
					<strong>Approval Date: </strong>
						 
					<?= date('d-m-Y', strtotime($getvalue['approval_date'])) ?>
					</div>
					<div class="col-md-3">
					<strong>Approval Amount: </strong>
						 
					<?= $getvalue['approved_amount']  ?>
					</div>
					
					<div class="col-md-3">
					<strong>Approved Spares: </strong>
						 
					<?= $getvalue['approved_spares']  ?>
					</div>
					
					<div class="col-md-3">
					<strong>Approved Labour: </strong>
						 
					<?= $getvalue['approved_labour']  ?>
					</div>
					
					<div class="col-md-3">
					<strong>Customer Liability: </strong>
						 
					<?= $getvalue['customer_liability']  ?>
					</div>
					
					 <div class="col-md-3">
					<strong>Approval Assesment: </strong><br>
						<ul>
						 
						
						<li><a href="<?php echo base_url().$getvalue['approval_assesment_url']; ?>" target="new"><?php echo $getvalue['approval_assesment'] ?></a></li>
						  
						 
					</ul>
					</div>
					
					 
					
					<hr>
                    <div class="col-md-12">
					<strong>Approved Items</strong><br>
						<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-body">
                <div class="invoice">
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th> #</th> 
                                    <th> Item</th>
                                    <th> Quantity</th>
                                    <th> Apprv. Spares</th>									
                                    <th> Apprv. Labour</th>
                                    <th> Customer Liability</th>
									<th> Amount</th>
									<th> Approved?</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $n = 1;
											   
								 
						  
	
        $sql = $this->db->query("select * from claims_estimate_approved_details where claims_id=".$thissurveydoc);
        $data['estimated_items'] = $sql->result();
                                foreach ($data['estimated_items'] as $rows) {
                                    ?>
                                    <tr>
                                        <td><?php echo $n; ?></td> 
                                        <td><?php echo $rows->item; ?></td>
                                        <td ><?php echo $rows->qty; ?></td>
                                        <td > <?php echo $rows->rate; ?></td>
										<td > <?php echo $rows->labour_rate; ?></td>
										<td > <?php echo $rows->customer_liability; ?></td>
                                        <td > <?php echo $rows->amount; ?></td>
										 <td > <?php echo $rows->approval_status; ?></td>
										
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
			</div>	
 <!-------------------------------------------------------- Close Accordion ---->
		  </div>
    </div>
  </div>
		<?php } ?>
		<!-- Insurer APPROVAL DETAILS END ---->
		
		<!-- CUSTOMER APPROVAL DETAILS ---->
		<?php if($stage['stage'] >= 6){ ?>
			
			
			 <div class="card">
    <div class="card-header" id="heading6">
      <h2 class="mb-0">
        <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapse6" aria-expanded="true" aria-controls="collapse6">
          Customer Approval Details
        </button>
      </h2>
    </div>

    <div id="collapse6" class="collapse" aria-labelledby="heading6" data-parent="#accordionExample">
      <div class="card-body">
		  <!-------------------------------------------------------- Open Accordion ---->
		  
		  
			 <div class="col-md-12">
            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    
					
					<h3 class="box-title">Customer Approval Details</h3>
					<hr>
					<?php
	
						$where = array('claim_id' => $surveyDetail['id']);
						$getvalue =$this->Main_model->single_row('claim_customer_approval', $where, 's');
						//echo $getvalue['make_name']; 
	 

						?>
                    <div class="col-md-3">
					<strong>Approval Status:</strong>
						 <?= $getvalue['approved_status'] ?>
					</div>
					<div class="col-md-3">
					<strong>Approval Date: </strong>
						 
					<?= date('d-m-Y', strtotime($getvalue['approval_date'])) ?>
					</div>
					<div class="col-md-3">
					<strong>Repair Type: </strong>
						 
					<?= $getvalue['repair_type']  ?>
					</div>
					
					 <div class="col-md-3">
					<strong>Pickup/Repair Date: </strong><br>
						 
						 
						
						<?php if(!empty($getvalue['pickup_date']) && $getvalue['pickup_date'] != '1970-01-01'){ echo date('d-m-Y', strtotime($getvalue['pickup_date'])); } ?>
						  
						 
					 
					</div>
					
					<div class="col-md-3">
					<strong>Pickup/Repair Time: </strong><br>
						 
						 
						
						<?php if(!empty($getvalue['pickup_time'])){ echo $getvalue['pickup_time']; } ?>
						  
						 
					 
					</div>
					
					<div class="col-md-3">
					<strong>Service Provider: </strong><br>
					<?php
							if($getvalue['repair_type']=='Pickup'){ 
							
							 $where = array('id' => $getvalue['service_provider']);
						$getgarages =$this->Main_model->single_row('garages', $where, 's');
								echo $getgarages['name'];
							}else{
							
							 $where = array('mechanic_id' => $getvalue['service_provider']);
						$getgarages =$this->Main_model->single_row('mechanic', $where, 's');
								echo $getgarages['name'];
								
								
							}
							  ?>
					</div>
					
					 
				</div>
			</div>
			</div>	
 <!-------------------------------------------------------- Close Accordion ---->
		  </div>
    </div>
  </div>
		<?php } ?>
		<!-- CUSTOMER APPROVAL DETAILS END ---->
		
		<!-- REPAIR START DETAILS ---->
		<?php if($stage['stage'] >= 7){ ?>
			
			
			 <div class="card">
    <div class="card-header" id="heading7">
      <h2 class="mb-0">
        <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapse7" aria-expanded="true" aria-controls="collapse7">
          Repair Start Details
        </button>
      </h2>
    </div>

    <div id="collapse7" class="collapse" aria-labelledby="heading7" data-parent="#accordionExample">
      <div class="card-body">
		  <!-------------------------------------------------------- Open Accordion ---->
		  
		  
			 <div class="col-md-12">
            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    
					
					<h3 class="box-title">Repair Start Details</h3>
					<hr>
					
					<?php
	
						$where = array('claim_id' => $surveyDetail['id']);
						$getvalue =$this->Main_model->single_row('claim_repair', $where, 's');
						//echo $getvalue['make_name']; 
	 

						?>
					
					
                     
					<div class="col-md-6">
					<strong>Repair Start Date: </strong>
						 
					<?= date('d-m-Y', strtotime($getvalue['repair_startdate'])) ?>
					</div>
					<div class="col-md-6">
					<strong>Repair End Date: </strong>
						 
					<?= date('d-m-Y', strtotime($getvalue['repair_enddate'])) ?>
					</div>
				</div>
			</div>
			</div>	
 <!-------------------------------------------------------- Close Accordion ---->
		  </div>
    </div>
  </div>
		<?php } ?>
		<!-- REPAIR START DETAILS END ---->
		
		
		
		
		<!-- INVOICE UPLOAD DETAILS ---->
		<?php if($stage['stage'] >= 8){ ?>
			
			
			 <div class="card">
    <div class="card-header" id="heading8">
      <h2 class="mb-0">
        <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapse8" aria-expanded="true" aria-controls="collapse8">
          Invoice Upload Details
        </button>
      </h2>
    </div>

    <div id="collapse8" class="collapse" aria-labelledby="heading8" data-parent="#accordionExample">
      <div class="card-body">
		  <!-------------------------------------------------------- Open Accordion ---->
		  
		  
			 <div class="col-md-12">
            
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Invoice Upload Details</h3>
					<hr>
                <?php
	
						$where = array('claim_id' => $surveyDetail['id']);
						$getvalue =$this->Main_model->single_row('claim_invoice', $where, 's');
						//echo $getvalue['make_name']; 
	 

						 
						$totalestimatevalue =  $this->db->query("select SUM(amount) as totalestiamount, SUM(rate) as totalspareamount, SUM(labour_rate) as totallabouramount from claims_estimate_approved_details where claims_id=".$surveyDetail['id'])->row();
	
						$totalapprovedvalue =  $this->db->query("select SUM(amount) as totalestiamount, SUM(rate) as totalspareamount, SUM(labour_rate) as totallabouramount  from claims_estimate_approved_details where claims_id=".$surveyDetail['id'])->row();
	
								$totalInvAmt =$totalestimatevalue->totalestiamount;
								$totalSpareAmt =$totalestimatevalue->totalspareamount;
								$totalLabourAmt =$totalestimatevalue->totallabouramount;
									
								$totalApproved = $totalapprovedvalue->totalestiamount;
								
								$totalUnapproved = ($totalestimatevalue->totalestiamount-$totalapprovedvalue->totalestiamount);
						?>
				
				<div class="col-md-6">
				 
					
					<strong>Invoice Date: </strong>

                    <p class="text-muted">
                          <?= date('d-m-Y', strtotime($getvalue['invoice_date'])) ?>     
                    </p>
					 
				</div>
				  
					   <div class="col-md-6">
				 
					
					<strong>Invoice No: </strong>

                    <p class="text-muted">
                          <?php echo $getvalue['invoice_no'];  ?>     
                    </p>
					 
				</div>
					
					<div class="col-md-3">
				 
					
					<strong>Total Spares: </strong>

                    <p class="text-muted">
                          <?php echo $totalSpareAmt; ?>     
                    </p>
					 
				</div>
					
					<div class="col-md-3">
				 
					
					<strong>Total Labout: </strong>

                    <p class="text-muted">
                          <?php echo $totalLabourAmt; ?>     
                    </p>
					 
				</div>
					
					<div class="col-md-3">
				 
					
					<strong>Total Approved: </strong>

                    <p class="text-muted">
                          <?php echo ($getvalue['approved_spares']+$getvalue['approved_labour']); //$getvalue['approved_spares']; ?>     
                    </p>
					 
				</div>
					
					
				  
					   <div class="col-md-3">
				 
					
					<strong>Total Unapproved: </strong>

                    <p class="text-muted">
                          <?php echo $totalUnapproved;  ?>     
                    </p>
					 
				</div>
					
					 
					 	
					
                    <div class="col-md-6">
					<strong>Invoice Uploaded: </strong><br>
						<ul>
						 
						
						<li><a href="<?php echo base_url().$getvalue['invoice_upload_url']; ?>" target="new"><?php echo $getvalue['invoice_upload_name'] ?></a></li>
						  
						 
					</ul>
					</div>
					
					
					  <div class="col-md-6">
					<strong>Invoice Total: </strong>
					 <p class="text-muted">
                          <?php echo $getvalue['invoice_total'];  ?>     
                    </p>
					</div>
					 <div class="col-md-3" style="display: none;">
					<strong>Customer Liability: </strong>
					 <p class="text-muted">
                          <?php echo $getvalue['customer_liability'];  ?>     
                    </p>
					</div>
					
							 
					 
			</div>
			</div>
			</div>	
 <!-------------------------------------------------------- Close Accordion ---->
		  </div>
    </div>
  </div>
		<?php } ?>
		<!-- INVOICE UPLOAD DETAILS END ---->
		
		
		<!-- INVOICE DETAILS ---->
		<?php if($stage['stage'] >= 17){ ?>
			
			 <div class="card">
    <div class="card-header" id="heading9">
      <h2 class="mb-0">
        <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapse17" aria-expanded="true" aria-controls="collapse17">
          Invoice Details
        </button>
      </h2>
    </div>

    <div id="collapse17" class="collapse" aria-labelledby="heading9" data-parent="#accordionExample">
      <div class="card-body">
		  <!-------------------------------------------------------- Open Accordion ---->
		  
		  
			 <div class="col-md-12">
            
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Invoice Details</h3>
					<hr>
                
				
				<div class="col-md-3">
				 
					
					

                    <p class="text-muted">
                        <strong>Invoice No.:</strong> <?php echo $surveyDetail['invoice_no'];  ?><br>
						<strong>Invoice Date:</strong><?php echo $surveyDetail['invoice_date'];  ?>
                    </p>
					 
				</div>
				 
				<div class="col-md-3">
				 
					
					<strong>Invoice Total</strong>

                    <p class="text-muted">
                         <?php echo $surveyDetail['invoice_amount'];  ?>
                    </p>
					 
				</div>
					
					<div class="col-md-3">
				 
					
					<strong>Insurer Total</strong>

                    <p class="text-muted">
                         <?php echo $surveyDetail['insurer_amount'];  ?>
                    </p>
					 
				</div>
					
					
					<div class="col-md-3">
				 
					
					<strong>Insurer Total</strong>

                    <p class="text-muted">
                         <?php echo $surveyDetail['customer_amount'];  ?>
                    </p>
					 
				</div>
					
					   
					<hr>
                    <div class="col-md-12">
					<strong>Invoiced Items</strong><br>
						<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-body">
                <div class="invoice">
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th> #</th> 
                                    <th> Item</th>
                                    <th > Quantity</th>
                                    <th > Rate</th>
                                    <th> Amount</th>
									<th>Insurer Amt</th>
								<th>Customer Amt</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $n = 1;
											   
								 
						  
	
        $sql = $this->db->query("select * from claims_invoice where claims_id=".$thissurveydoc);
        $data['estimated_items'] = $sql->result();
                                foreach ($data['estimated_items'] as $rows) {
                                    ?>
                                    <tr>
                                        <td><?php echo $rows->id; ?></td> 
                                        <td><?php echo $rows->item; ?></td>
                                        <td><?php echo $rows->qty; ?></td>
                                        <td> <?php echo $rows->rate; ?></td>
                                        <td> <?php echo $rows->amount; ?></td>
                                        <td> <?php echo $rows->insurer_amount; ?></td>
										<td> <?php echo $rows->customer_amount; ?></td>
                                    </tr>
                                    <?php $n++;
                                } ?>

                                </tbody>
                            </table>
							 <div class="form-group col-lg-12">
								 
							 <div class="form-group col-lg-6">
							<a target="new" href='<?= base_url('claims/show_insurer_invoices/'.$surveyDetail['id']) ?>' data-toggle='modal'
                               class='btn btn-success'>
                                <i class='fa fa-pencil-square-o'></i>
                                Insurer Invoice
                            </a>
							 </div>
								 
							<div class="form-group col-lg-6">
							<a target="new" href='<?= base_url('claims/show_customer_invoices/'.$surveyDetail['id']) ?>' data-toggle='modal'
                               class='btn btn-success'>
                                <i class='fa fa-pencil-square-o'></i>
                                Customer Invoice
                            </a>
							 </div>
								 
							</div
							
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
				 <!-------------------------------------------------------- Close Accordion ---->
		  </div>
    </div>
  </div>
		<?php } ?>
		<!-- INVOICE DETAILS END ---->
		
		<!-- Insurer LIABILITY DETAILS ---->
		<?php if($stage['stage'] >= 9){ ?>
		
		
		 <div class="card">
    <div class="card-header" id="heading10">
      <h2 class="mb-0">
        <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapse9" aria-expanded="true" aria-controls="collapse9">
          Insurer Liability
        </button>
      </h2>
    </div>

    <div id="collapse9" class="collapse" aria-labelledby="heading10" data-parent="#accordionExample">
      <div class="card-body">
		  <!-------------------------------------------------------- Open Accordion ---->
		  
			 <div class="col-md-12">
            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    
					
					<h3 class="box-title">Insurer Liability</h3>
					<hr>
					
					<?php
	
						$where = array('claim_id' => $surveyDetail['id']);
						$getvalue =$this->Main_model->single_row('claim_gic_liability', $where, 's');
						//echo $getvalue['make_name']; 
	 
					  	 

						?>
					
					
                     
					<div class="col-md-3">
					<strong>Spares Liability: </strong>
						 
					<?=  $getvalue['spares_liability']  ?>
					</div>
					<div class="col-md-3">
					<strong>Labour Liability: </strong>
						 
					<?=  $getvalue['labour_liability']  ?>
					</div>
					<div class="col-md-3">
					<strong>Customer Liability: </strong>
						 
					<?=  $getvalue['customer_liability']  ?>
					</div>
					
					
                    <div class="col-md-3">
					<strong>Liability Uploaded: </strong><br>
						<ul>
						 
						
						<li><a href="<?php echo base_url().$getvalue['liability_upload_url']; ?>" target="new"><?php echo $getvalue['liability_upload_name'] ?></a></li>
						  
						 
					</ul>
					</div>
					
				</div>
			</div>
			</div>	
 <!-------------------------------------------------------- Close Accordion ---->
		  </div>
    </div>
  </div>
		<?php } ?>
		<!-- Insurer LIABILITY DETAILS END ---->
				
				
		<!-- DELIVERY DETAILS ---->
		<?php if($stage['stage'] >= 10){ ?>
		
		 <div class="card">
    <div class="card-header" id="heading11">
      <h2 class="mb-0">
        <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapse10" aria-expanded="true" aria-controls="collapse10">
          Delivery Details
        </button>
      </h2>
    </div>

    <div id="collapse10" class="collapse" aria-labelledby="heading11" data-parent="#accordionExample">
      <div class="card-body">
		  <!-------------------------------------------------------- Open Accordion ---->
		  
		  
			 <div class="col-md-12">
            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    
					
					<h3 class="box-title">Delivery Details</h3>
					<hr>
					
					<?php
	
						$where = array('claim_id' => $surveyDetail['id']);
						$getvalue =$this->Main_model->single_row('claim_delivery', $where, 's');
						//echo $getvalue['make_name']; 
	 
					  	 

						?>
					
					
                     
					<div class="col-md-3">
					<strong>Delivery Date: </strong>
						 
					<?= date('d-m-Y', strtotime($getvalue['delivery_date'])) ?>
					</div>
					<div class="col-md-3">
					<strong>Amount Collected: </strong>
						 
					<?=  $getvalue['amount_collected']  ?>
					</div>
					<div class="col-md-3">
					<strong>Payment Mode: </strong>
						 
					<?=  $getvalue['payment_mode']  ?>
					</div>
					<div class="col-md-3">
					<strong>Payment Receipt details: </strong>
						 
					<?=  $getvalue['comments']  ?>
					</div>
				</div>
			</div>
			</div>	
 <!-------------------------------------------------------- Close Accordion ---->
		  </div>
    </div>
  </div>
		<?php } ?>
		<!-- DELIVERY DETAILS END ---->
		
		
				 </div>
		
		
	 </div>

</section>



<!--Modal for Assign Case -->


<div class="modal fade" role="dialog"  id="mod_assign">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Assign Survey</h4>
            </div>
            <?= form_open_multipart(base_url() . 'index.php/claims/assign_claims', array('method' => 'POST', 'class' => 'form-horizontal')) ?>
			
            <div class="modal-body">
				 <input type='hidden' name="cid" class='form-control' id='c_' value='<?= $surveyDetail['id'] ?>'>
				
				<div class="form-group" >
                    <label for="cname" class="control-label col-lg-3">Surveyor</label>
 					<div class="col-lg-9">
                         <select name="assigned_surveryor" class='form-control select2assign' style="width: 100%;" required>
						<?php foreach($surveyors as $surveyor){ ?>   
						<option value="<?php echo $surveyor->surveyor_id; ?>"><?php echo $surveyor->name; ?></option>
						<?php } ?>
						</select>
					 </div>
				</div>
				
				
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Survey Date</label>
					<div class="col-lg-9">
                          <input type="text" value="" size="16" required name="survey_assigned_on"
                       class="form-control form-control-inline input-medium datepicker">
						 
                    </div>
                </div>
				
				 
			 
				
				
				
				
				
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
<?php echo $My_Controller->savePermission;?>
            </div>
            <?php echo form_close();?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Modal for Assign Case END-->


		
		<!--Modal for Survey Status -->


<div class="modal fade" role="dialog"  id="mod_surveystatus">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Change Survey Status</h4>
            </div>
            <?= form_open_multipart(base_url() . 'index.php/claims/surveystatus_claims', array('method' => 'POST', 'class' => 'form-horizontal')) ?>
			
            <div class="modal-body">
				 <input type='hidden' name="cid" class='form-control' id='c_' value='<?= $surveyDetail['id'] ?>'>
				
				<div class="form-group" >
                    <label for="survey_status" class="control-label col-lg-3">Survey Status</label>
 					<div class="col-lg-9">
                         <select name="survey_status" class='form-control select2' style="width: 100%;" required>
						 
						<option value="Yes">Yes</option>
						 <option value="No">No</option>
						</select>
					 </div>
				</div>
				
				
				<div class="form-group" >	
					<label for="surveyed_date" class="control-label col-lg-3">Survey Date</label>
					<div class="col-lg-9">
                          <input type="text" value="" size="16" required name="survey_date"
                       class="form-control form-control-inline input-medium datepicker">
						 
                    </div>
                </div>
				
				 
			 
				
				
				
				
				
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
<?php echo $My_Controller->savePermission;?>
            </div>
            <?php echo form_close();?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Modal for Survey Status END-->
		
		
<!--Modal for Create Survey Form -->

 
<div class="modal fade" role="dialog"  id="mod_surveydetails">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Enter Survey Details</h4>
            </div>
            <?= form_open_multipart(base_url() . 'index.php/claims/create_survey_form', array('method' => 'POST', 'class' => 'form-horizontal')) ?>
			
            <div class="modal-body">
				
				<input type='hidden' name="cid" class='form-control' id='c_' value='<?= $surveyDetail['id'] ?>'>
				 
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Surveyed Date</label>
					<div class="col-lg-9">
						
						 <?php
	
						$where = array('claim_id' => $surveyDetail['id']);
						$getvalue =$this->Main_model->single_row('claim_survey_status', $where, 's');
						//echo $getvalue['make_name']; 
	   
						?>
						
                          <input type="text" value="<?= date('m/d/Y',strtotime($getvalue['survey_date']))  ?>" size="16" required name="surveyed_on"
                       class="form-control form-control-inline input-medium datepicker">
						 
                    </div>
                </div>
				
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Insurance Expiry Date</label>
					<div class="col-lg-9">
						
						 
						
                          <input type="text" value="<?= date('m/d/Y',strtotime($getvalue['survey_date'].'+1 year'))  ?>" size="16" required name="insurance_expire"
                       class="form-control form-control-inline input-medium datepicker">
						 
                    </div>
                </div>
				
				<h4 class="box-title">Documents/Vehicle Image Upload</h4>	
				 
				<div class="form-group" >
                    <label for="cname" class="control-label col-lg-3">Driving License</label>	
					<div class="col-lg-9">
						 
                         <input class="form-control" name="driving_license_front"   type="file"> 
						<?php
						 $thissurveydoc = $surveyDetail['id'];
        $sql = $this->db->query("select * from claims_uploads where claims_id=$thissurveydoc AND type='Driving_License_Front'");
        $driving_license_front = $sql->row();
											 
		//$sql = $this->db->query("select * from claims_uploads where claims_id=$thissurveydoc AND type='Driving_License_Back'");
     //   $driving_license_back = $sql->row();
											 
							?> 
 <?php if(!empty($driving_license_front->file_url)){ ?><a target="_blank" href="<?php echo base_url($driving_license_front->file_url); ?>">View Driving License</a><br>  <?php } ?>
                    </div>
				</div>
				 
				<div class="form-group" style="display: none;" >
					 <label for="cname" class="control-label col-lg-3">Driving License Back Side</label>	
					<div class="col-lg-9">
						 
                         <input class="form-control" name="driving_license_back"   type="file"> 
                    </div>
				 </div>
			
				 
				
			<div class="form-group" >
                    <label for="cname" class="control-label col-lg-3">PAN Card Upload</label>	
					<div class="col-lg-9">
                         <input class="form-control" name="pancard" type="file"> 
						<?php
						 
        $sql = $this->db->query("select * from claims_uploads where claims_id=$thissurveydoc AND type='PAN_Card'");
        $PAN_Card = $sql->row();
						  if(!empty($PAN_Card->file_url)){ 
						 ?>
						 <br> <a target="_blank" href="<?php echo base_url($PAN_Card->file_url); ?>" >View Pancard </a>
						<?php } ?>
						
                    </div>
			 </div>
				
				 
				
			 <div class="form-group" >
                    <label for="cname" class="control-label col-lg-3">RC Copy Upload</label>	
					<div class="col-lg-9">
                         <input class="form-control" name="rc_copy"   type="file"> 
						
						<?php
						 
        $sql = $this->db->query("select * from claims_uploads where claims_id=$thissurveydoc AND type='RC_Copy'");
        $RC_Copy = $sql->row();
						 if(!empty($RC_Copy->file_url)){ 
							?> 
						 <br>  <a target="_blank" href="<?php echo base_url($RC_Copy->file_url); ?>">Open RC Copy </a>
						<?php
						}
						?> 
						
                    </div>
			 </div>
				 
			 <div class="form-group" >
                    <label for="cname" class="control-label col-lg-3">Claim Form Upload</label>	
					<div class="col-lg-9">
                         <input class="form-control" name="claim_form[]" max="3" multiple type="file"> 
						
						<?php
						  
        $sql = $this->db->query("select * from claims_uploads where claims_id=$thissurveydoc AND type='Claim_Form'");
        $data['Claim_Form'] = $sql->result();
						
											 $i = 1;
						 foreach($data['Claim_Form'] as $Claim_Form){
							if(!empty($Claim_Form->file_url)){ 
							?>
						 
						    
				  <br> <a target="_blank" href="<?php echo base_url($Claim_Form->file_url); ?>" >View Image <?php echo $i; ?></a>
						<?php
						 $i++;
							}
						 }
						?> 
						
                    </div>
			 </div>
				  
				
				  
			
			<div class="form-group" >
                    <label for="cname" class="control-label col-lg-3">Vehicle Pictures Upload</label>	
					<div class="col-lg-9">
                         <input class="form-control" name="vehicle_pics_upload[]" multiple type="file"> 
						
						 &nbsp;<br>
							<?php
						 
        $sql = $this->db->query("select * from claims_uploads where claims_id=$thissurveydoc AND type='Vehicle_Images'");
        $data['Vehicle_Images'] = $sql->result();
							 $i = 1;
						 foreach($data['Vehicle_Images'] as $vehicleImages){
						if(!empty($vehicleImages->file_url)){ 	
							?>
						 
						   
          <br>  <a target="_blank" href="<?php echo base_url($vehicleImages->file_url); ?>" >View Image <?php echo $i; ?></a>
						<?php
						 $i++;
							}
						 }
						?> 
                    </div>
				 </div>
				  
				
				<h4 class="box-title">Vehicle Details</h4>
                
				
				
				<div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Year Of Make</label>

                    <div class='col-lg-9'>
                        <input type='text' name="yom" class='form-control date-picker-year'
                               value="" id=''
                               placeholder=''>
                    </div>
                </div>

                <div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Color</label>

                    <div class='col-lg-9'>
                        <input type='text' name="color" class='form-control'
                               value="" id=''
                               placeholder=''>
                    </div>
                </div>
				
                <div class="form-group">
                    <label for="cname" class="control-label col-lg-3">Registration No</label>

                    <div class="col-lg-9">
                        <input type='text' name="regno" class='form-control'
                               value="" id=''
                               placeholder=''>
                    </div>
                </div>
                <div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Km Reading</label>

                    <div class='col-lg-9'>
                        <input type='text' name="km" class='form-control'
                               value="" id=''
                               placeholder=''>
                    </div>
                </div>
				
				<div class='form-group' style="display: none;"
                    <label for='inputEmail1' class='col-lg-3 col-sm-3 control-label'>Engine No</label>
                    <div class='col-lg-9'>
                         
                        <input type='text' name="surveyed_engine_no" class='form-control' id='surveyed_engine_no'
                               value='<?= $surveyDetail['engine_no'] ?>'>
                    </div>
                </div>
			 
				<div class='form-group' style="display: none;"
                    <label for='inputEmail1' class='col-lg-3 col-sm-3 control-label'>Chasis No</label>
                    <div class='col-lg-9'>
                         
                        <input type='text' name="surveyed_chasis_no" class='form-control' id='surveyed_chasis_no'
                               value='<?= $surveyDetail['chasis_no'] ?>'>
                    </div>
                </div>
				
				
				
				
				
				
				
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
<?php echo $My_Controller->savePermission;?>
            </div>
            <?php echo form_close();?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Modal for Create Survey Form  END-->


		<!--Modal for Create Claim Approval Form -->

 
<div class="modal fade" role="dialog"  id="mod_gicapproval">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Update Assesment</h4>
            </div>
            <?= form_open_multipart(base_url() . 'index.php/claims/claims_approval', array('method' => 'POST', 'class' => 'form-horizontal')) ?>
			
            <div class="modal-body">
				
				<input type='hidden' name="cid" class='form-control' id='c_' value='<?= $surveyDetail['id'] ?>'>
				 
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Approval Date</label>
					<div class="col-lg-9">
                          <input type="text" value="<?php echo date('m/d/Y'); ?>" size="16" required name="approval_date"
                       class="form-control form-control-inline input-medium datepicker">
						 
                    </div>
                </div>
				  
				 
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Approved Amount</label>
					<div class="col-lg-9">
                          <input type="text" value=" " size="16" required name="approved_amount"
                       class="form-control form-control-inline input-medium">
						 
                    </div>
                </div>
				
				
                <div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Approval Status</label>

                    <div class='col-lg-9'>
                        <select type='text' name="approval_status" class='form-control select2gicapproval' style="width: 100%" placeholder=''>
							<option value="Approved">Approved</option>
							<option value="Rejected">Rejected</option>
						</select>
                    </div>
                </div>
				
			 	
				
				<div class="form-group" >
                    <label for="cname" class="control-label col-lg-3">Approval Assesment Upload</label>	
					<div class="col-lg-9">
                         <input class="form-control" name="approval_assesment" type="file"> 
                    </div>
				 </div>
				
				
				
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
<?php echo $My_Controller->savePermission;?>
            </div>
            <?php echo form_close();?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Modal for Create Claim Approval Form END-->
		
		
		
		
		
		<!--Modal for Create Customer Approval Form -->

 
<div class="modal fade" role="dialog"  id="mod_customerapproval">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Update Customer Approval</h4>
            </div>
            <?= form_open_multipart(base_url() . 'index.php/claims/claim_customer_approval', array('method' => 'POST', 'class' => 'form-horizontal')) ?>
			
            <div class="modal-body">
				
				<input type='hidden' name="cid" class='form-control' id='c_' value='<?= $surveyDetail['id'] ?>'>
				 
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Approval Date</label>
					<div class="col-lg-9">
                          <input type="text" value="<?php echo date('m/d/Y'); ?>" size="16" required name="approval_date"
                       class="form-control form-control-inline input-medium datepicker">
						 
                    </div>
                </div>
				   
				
                <div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Approval Status</label>

                    <div class='col-lg-9'>
                        <select type='text' name="approved_status" class='form-control select2custapproval' style="width: 100%" placeholder=''>
							<option value="Approved">Approved</option>
						 
							<option value="Rejected">Rejected</option>
						</select>
                    </div>
                </div>
				
			 	<div class="form-group">	
					<label for="cname" class="control-label col-lg-3">Repair Type</label>
					<div class="col-lg-9">
						<select name="repair_type" class="select2custapproval form-control" id="repair_type" style="width: 100%" required>
						<option>Select</option>
						<option value="Doorstep">Doorstep</option>
						<option value="Pickup">Pickup</option>
						</select>
                    </div>
                </div>
				
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Pickup/Repair Date</label>
					<div class="col-lg-9">
                          <input type="text" value="" size="16"   name="pickup_date"
                       class="form-control form-control-inline input-medium datepicker">
						 
                    </div>
                </div>
				
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Pickup/Repair Time</label>
					<div class="col-lg-9">
                         <input placeholder="Select Pickup Time" type="time"  min="09:00" max="20:00" id="pickup_time" name="pickup_time" class="form-control timepicker" autocomplete="off">
						 
                    </div>
                </div>
				
				 
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Service Provider</label>
					<div class="col-lg-9">
                          <select name="service_provider" class="select2custapproval form-control" id="service_provider" style="width: 100%" required>
						 
						</select>
						
						 
						 
                    </div>
                </div>
				
				
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
<?php echo $My_Controller->savePermission;?>
            </div>
            <?php echo form_close();?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Modal for Create Customer Approval Form END-->
		
		
		
<!--Modal for Create Repair Start Form -->

 
<div class="modal fade" role="dialog"  id="mod_repair">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Start Repair</h4>
            </div>
            <?= form_open_multipart(base_url() . 'index.php/claims/create_repairstart_form', array('method' => 'POST', 'class' => 'form-horizontal')) ?>
			
            <div class="modal-body">
				
				<input type='hidden' name="cid" class='form-control' id='c_' value='<?= $surveyDetail['id'] ?>'>
				 
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Repair Start Date</label>
					<div class="col-lg-9">
                          <input type="text" value="" size="16" required name="repair_startdate"
                       class="form-control form-control-inline input-medium datepicker">
						 
                    </div>
                </div>
				  
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Repair End Date</label>
					<div class="col-lg-9">
                          <input type="text" value="" size="16" required name="repair_enddate"
                       class="form-control form-control-inline input-medium datepicker">
						 
                    </div>
                </div>
				
                
				
			 
				
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
<?php echo $My_Controller->savePermission;?>
            </div>
            <?php echo form_close();?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Modal for Create Repair Start Form  END-->

 

<!--Modal for Create Invoice Upload Form -->

 
<div class="modal fade" role="dialog"  id="mod_invoice">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Upload Invoice</h4>
            </div>
            <?= form_open_multipart(base_url() . 'index.php/claims/claims_invoice_upload', array('method' => 'POST', 'class' => 'form-horizontal')) ?>
			 
            <div class="modal-body">
				
				<input type='hidden' name="cid" class='form-control' id='c_' value='<?= $surveyDetail['id'] ?>'>
				 
				
				
				
				   <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th> #</th> 
                                    <th> Item</th>
                                    <th > Quantity</th>
                                    <th > Spares Cost</th>									
                                    <th > Labour Cost</th>
                                    <th> Amount</th>
                                    <th> Approved</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $n = 1;
									
								$total_spares =0;
									$total_labour =0;
								 $approved_spares = 0;
									$approved_labour = 0;	
								$customer_liab = 0;
								$totalInvoiceAmt = 0;
        $sql = $this->db->query("select * from claims_estimate_details where claims_id=".$surveyDetail['id']);
        $data['estimated_items'] = $sql->result();
                                foreach ($data['estimated_items'] as $rows) {
									
									
		$approvedItem = $this->db->query("select * from claims_estimate_approved_details where estimate_id=".$rows->id)->row();
         							 
									if(empty($approvedItem->approval_status)){
									$approved = 'Unapproved';
										
									$customer_liab += $rows->amount;	
										
									}else{
									$approved = $approvedItem->approval_status;
									$customer_liab += $approvedItem->customer_liability;		
									}
									
									 
									$total_spares += $rows->rate;
									$total_labour += $rows->labour_rate;
									 
									$totalInvoiceAmt += $rows->amount;
                                    ?>
                                    <tr>
                                        <td><?php echo $n; ?></td> 
                                        <td><?php echo $rows->item; ?></td>
                                        <td ><?php echo $rows->qty; ?></td>
                                        <td > <?php echo $rows->rate; ?></td>
										<td > <?php echo $rows->labour_rate; ?></td>
                                        <td > <?php echo $rows->amount; ?></td> 
                                        <td > <?php echo $approved; ?></td>
                                    </tr>
                                    <?php $n++;
                                } ?>

                                </tbody>
                            </table>
                        </div>
						 
                    </div>
				
				
				
				
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Invoice Date</label>
					<div class="col-lg-9">
                          <input type="text" value="<?php echo date('d-m-Y'); ?>" size="16" required name="invoice_date"
                       class="form-control form-control-inline input-medium datepicker">
						 
                    </div>
                </div>
				  
				 
				
                <div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Invoice No</label>

                    <div class='col-lg-9'>
                        <input type="text" value="" size="16" required name="invoice_no"
                       class="form-control form-control-inline input-large">
                    </div>
                </div>
				
				
				
                <div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Spares</label>

                    <div class='col-lg-9'>
                        <input type="number" value="<?php echo $total_spares; ?>" size="16" required name="approved_spares" id="invoice_approved_spares" 
                       class="form-control form-control-inline input-large" onclick="calculate_invoicetotalsum()" onkeyup="calculate_invoicetotalsum()">
                    </div>
                </div>
				
				
                <div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Labour</label>

                    <div class='col-lg-9'>
                        <input type="number" value="<?php echo $total_labour;?>" size="16" required name="approved_labour" id="invoice_approved_labour"
                       class="form-control form-control-inline input-large" onclick="calculate_invoicetotalsum()" onkeyup="calculate_invoicetotalsum()">
                    </div>
                </div>
				
				
				<div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Invoice Total</label>

                    <div class='col-lg-9'>
                        <input type="number" value="<?php echo $totalInvoiceAmt; ?>" size="16" required name="invoice_total" id="invoice_invoice_total"
                       class="form-control form-control-inline input-large">
                    </div>
                </div>
				
				<div class='form-group' style="display: none;">
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Customer Liability</label>

                    <div class='col-lg-9'>
                        <input type="text" value="<?php echo $customer_liab; ?>" size="16"   name="customer_liability"
                       class="form-control form-control-inline input-large">
                    </div>
                </div>
				
				<script>
				function calculate_invoicetotalsum() {

        
		
		if(!$("#invoice_approved_spares").val()){
			$("#invoice_approved_spares").val('');
		}
		if(!$("#invoice_approved_labour").val()){
			$("#invoice_approved_labour").val('');
		}
        var invoice_approved_spares = parseInt($("#invoice_approved_spares").val());
		var invoice_approved_labour = parseInt($("#invoice_approved_labour").val());
		 
		var customerliab =  (invoice_approved_spares+invoice_approved_labour); 
        $("#invoice_invoice_total").val(customerliab);
         }
				</script>
				
				
			 <div class="form-group" >
                    <label for="cname" class="control-label col-lg-3">Upload Invoice</label>	
					<div class="col-lg-9">
                         <input class="form-control" name="invoice_upload" type="file"> 
                    </div>
				 </div>
				
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
<?php echo $My_Controller->savePermission;?>
            </div>
            <?php echo form_close();?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Modal for Upload Inovice Form END-->
		
		
		
		
		<!--Modal for Create Insurer Liability  Form -->

 
<div class="modal fade" role="dialog"  id="mod_gicliability">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Update Insurer Liability</h4>
            </div>
            <?= form_open_multipart(base_url() . 'index.php/claims/claims_gic_liability', array('method' => 'POST', 'class' => 'form-horizontal')) ?>
			
            <div class="modal-body">
				
				<input type='hidden' name="cid" class='form-control' id='c_' value='<?= $surveyDetail['id'] ?>'>
				 
				 
				
				 <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th> #</th> 
                                    <th> Item</th>
                                    <th > Quantity</th>
                                    <th > Spares Cost</th>									
                                    <th > Labour Cost</th>
                                    <th> Amount</th>
                                    <th> Approved</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $n = 1;
											   
								 $approved_spares = 0;
									$approved_labour = 0;	
								$customer_liab = 0;
								$total_spares =0;
									$total_labour =0;
        $sql = $this->db->query("select * from claims_estimate_details where claims_id=".$surveyDetail['id']);
        $data['estimated_items'] = $sql->result();
                                foreach ($data['estimated_items'] as $rows) {
									
									
		$approvedItem = $this->db->query("select * from claims_estimate_approved_details where estimate_id=".$rows->id)->row();
         
									if(empty($approvedItem->approval_status)){
									$approved = 'Unapproved';
										
									$customer_liab += $rows->amount;	
										
									}else{
									$approved = $approvedItem->approval_status;
									$customer_liab += $approvedItem->customer_liability;		
									}
									
									 
                                    ?>
                                    <tr>
                                        <td><?php echo $n; ?></td> 
                                        <td><?php echo $rows->item; ?></td>
                                        <td ><?php echo $rows->qty; ?></td>
                                        <td > <?php echo $rows->rate; ?></td>
										<td > <?php echo $rows->labour_rate; ?></td>
                                        <td > <?php echo $rows->amount; ?></td> 
                                        <td > <?php echo $approved; ?></td>
                                    </tr>
                                    <?php $n++;
                                } ?>

                                </tbody>
                            </table>
                        </div>
						 
                    </div>
				
				
				  
						 <?php
	
						$where = array('claim_id' => $surveyDetail['id']);
						$getvalue =$this->Main_model->single_row('claim_invoice', $where, 's');
						//echo $getvalue['make_name']; 
	   
						?>
				
				
				<input type="hidden" id="invoice_amt" value="<?php echo $getvalue['invoice_total']; ?>" />
				 <div class="form-group" >
                    <label for="cname" class="control-label col-lg-3">Upload</label>	
					<div class="col-lg-9">
                         <input class="form-control" name="gicliability_upload" type="file"> 
                    </div>
				 </div>
				
                <div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Insurer Spares Liability</label>

                    <div class='col-lg-9'>
                        <input type="number" value="" size="16" required id="spare_liability" name="spares_liability"
                       class="form-control form-control-inline input-large" onclick="calculate_customerliability()" onkeyup="calculate_customerliability()">
                    </div>
                </div>
				
				
				<div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Insurer Labour Liability</label>

                    <div class='col-lg-9'>
                        <input type="number" value="" size="16" id="labour_liability" required name="labour_liability"
                       class="form-control form-control-inline input-large" onclick="calculate_customerliability()" onkeyup="calculate_customerliability()">
                    </div>
                </div>
				
				
                <div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Customer Liability</label>

                    <div class='col-lg-9'>
                        <input type="text" value="" size="16" readonly id="customer_liabilityread" required name="customer_liabilityread"
                       class="form-control form-control-inline input-large">
						<input type="hidden" value="" size="16"   id="customer_liability" required name="customer_liability"
                       class="form-control form-control-inline input-large">
                    </div>
                </div>
				
				
				
				<script>
				function calculate_customerliability() {

        
		
		if(!$("#spare_liability").val()){
			$("#spare_liability").val('');
		}
		if(!$("#labour_liability").val()){
			$("#labour_liability").val('');
		}
        var spare_liability = parseInt($("#spare_liability").val());
		var labour_liability = parseInt($("#labour_liability").val());
		var invoice_amt = parseInt($("#invoice_amt").val());
		var customerliab = invoice_amt-(spare_liability+labour_liability); 
        $("#customer_liability").val(customerliab);
		$("#customer_liabilityread").val(customerliab);			
         }
				</script>
				
				
				
			 
				
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
<?php echo $My_Controller->savePermission;?>
            </div>
            <?php echo form_close();?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Modal for Insurer Liablity Form END-->
		
		
		
		
		
		<!--Modal for Create Delivery  Form -->

 
<div class="modal fade" role="dialog"  id="mod_delivery">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Create Delivery</h4>
            </div>
            <?= form_open_multipart(base_url() . 'index.php/claims/claim_delivery', array('method' => 'POST', 'class' => 'form-horizontal')) ?>
			
            <div class="modal-body">
				
				<input type='hidden' name="cid" class='form-control' id='c_' value='<?= $surveyDetail['id'] ?>'>
				 
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Delivery Date</label>
					<div class="col-lg-9">
                          <input type="text" value="<?php echo date('d-m-Y'); ?>" size="16" required name="delivery_date"
                       class="form-control form-control-inline input-medium datepicker">
						 
                    </div>
                </div>
				  
				  <?php
	
						$where = array('claim_id' => $surveyDetail['id']);
						$getvalue =$this->Main_model->single_row('claim_gic_liability', $where, 's');
						//echo $getvalue['make_name']; 
	   
						?>
				
                <div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Amount Collected</label>
					
                    <div class='col-lg-9'>
                        <input type="text" value="" size="16" required name="amount_collected" id="amount_collected" class="form-control form-control-inline input-large">
						<p id="showcust_liability" style="display: none;">Customer Liability: <span id="showcust_liability_amt"><?php echo $getvalue['customer_liability']; ?></span></p>
                    </div>
                </div>
				
				
                <div class="form-group">	
					<label for="cname" class="control-label col-lg-3">Payment Mode</label>
					<div class="col-lg-9">
						<select name="payment_mode" id="payment_mode" class="form-control" style="width: 100%;" required>
							<option>Select</option>
							<option value="Paytm">Paytm</option>
							<option value="Credit Card">Credit Card</option>
							<option value="Cash">Cash</option>
							<option value="UPI">UPI</option>
						</select>
                    </div>
                </div>   
				
				
				<div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Enter Payment Receipt details</label>
					
                    <div class='col-lg-9'>
                        <textarea name="payment_comments" id="payment_comments"></textarea>
                    </div>
                </div>
				
				
				
				
			 
				
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
<?php echo $My_Controller->savePermission;?>
            </div>
            <?php echo form_close();?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Modal for Delivery Form END-->

	



		
		 <script type='text/javascript'>
			 $(document).ready(function() {
    $('#checkRZPayment_btn').click(function() {
        
		   
	  	   
		    var csrf_test_name = $("input[name=csrf_test_name]").val();
			   // total_number++;
        $.ajax({
            url: '<?=base_url();?>index.php/claims/checkpaymentlink/',
            type: 'POST',
            data: {'claims_id': <?php echo $surveyDetail['id']; ?>, 'csrf_test_name': csrf_test_name},
            dataType: 'json',
            success: function (data) {
				$('#showcust_liability').show();
                $('#showcust_liability_amt').html(data.customer_liability)
				$('#amount_collected').val(data.amount_collected)
				if(data.payment_mode !== ''){ 
				$('#payment_mode').val(data.payment_mode);
				}
				$('#mod_delivery').modal('show');
				

            }
        });
		   
	  
	  
	  
	  });
				 
	autocheckrazorpay();			 
});
			 
			 function autocheckrazorpay(){
				  
	  	   
		    var csrf_test_name = $("input[name=csrf_test_name]").val();
			   // total_number++;
        $.ajax({
            url: '<?=base_url();?>index.php/claims/checkpaymentlink/',
            type: 'POST',
            data: {'claims_id': <?php echo $surveyDetail['id']; ?>, 'csrf_test_name': csrf_test_name},
            dataType: 'json',
            success: function (data) {
				//$('#showcust_liability').show();
                //$('#showcust_liability_amt').html(data.customer_liability)
				//$('#amount_collected').val(data.amount_collected)
				if(data.payment_mode !== ''){  
				$('#paymentstatus').show('slow');
				$('#paymentcollectedamt').html('Payment Received');
				}
				 
				
				
				

            }
        });
		   
	   
			 }
				 
</script>
		
		
		
		
<!--Modal for CLOSE CLAIM -->

 
<div class="modal fade" role="dialog"  id="mod_closeclaimsnow">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Cancel Claim</h4>
            </div>
            <?= form_open_multipart(base_url() . 'index.php/claims/close_claims/'.$surveyDetail['id'], array('method' => 'POST', 'class' => 'form-horizontal')) ?>
			
            <div class="modal-body">
				
				<input type='hidden' name="cid" class='form-control' id='c_' value='<?= $surveyDetail['id'] ?>'>
				 
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Cancel Reason</label>
					<div class="col-lg-9">
                         <select type='text' name="close_type" class='form-control select2close' style="width: 100%" placeholder=''>
							<option value="Rejected">Rejected</option>
							<option value="Withdrawal">Withdrawal</option> 
							<option value="Reported to Dealer">Reported to Dealer</option> 
							<option value="Dealer Reported to Local Garage">Dealer Reported to Local Garage</option>
						</select>
						 
                    </div>
                </div>
				  
				  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
<?php echo $My_Controller->savePermission;?>
            </div>
            <?php echo form_close();?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Modal for CLOSE CLAIM END-->		
	 
	

<!--Modal for Edit Kyc  Form -->

 <div class="modal fade" role="dialog"  id="entervehicledet"  tabindex="-1" role="basic" aria-hidden="true"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content modalselect2">
            <div class="modal-header">
                
                <h4 class="modal-title">Add Vehicle Details</h4>
            </div>
            <?= form_open_multipart(base_url() . 'index.php/claims/update_vehicledetails', array('id'=>'update_vehicledetails', 'method' => 'POST', 'class' => 'form-horizontal')) ?>
			
            <div class="modal-body">
				 
				<input type='hidden' name="cid" class='form-control' id='c_' value='<?php echo $surveyDetail['id']; ?>'>
				 
				  <div class="form-group">
                    <label for="cname" class="control-label col-lg-3">Claim No</label>

                    <div class="col-lg-9">
                        <input type='text' name="claim_no" class='form-control'
                               value=""  required="required" 
                               placeholder=''>
                    </div>
                </div>
				
				  <div class='form-group'>
                    <label for='inputEmail1' class='col-lg-3 col-sm-3 control-label'>Customer Name</label>
                    <div class='col-lg-9'>
                         
                        <input type='text'   name="name" class='form-control' id='name'  value=''>
                    </div>
                  </div>
				
				
				
				 <div class='form-group'>
                    <label for='make' class='col-lg-3 col-sm-3 control-label'>Make</label>

                    <div class='col-lg-9'>
                          <select name="make" class='form-control select2modal' id="make" style="width: 100%;" placeholder=''>
							 <option>Select Make</option> 
						<?php foreach($makes as $make){ ?>   
						<option value="<?php echo $make->make_id; ?>"><?php echo $make->make_name; ?></option>
						<?php } ?>
						</select>
						
						 
                    </div>
                </div>
                

                <div class='form-group' >
                    <label for='model' class='col-lg-3 col-sm-3 control-label'>Model</label>
                    <div class='col-lg-9'>
                       <select name="model" class='form-control select2modal' id="model" style="width: 100%;" placeholder=''>
						 <option value="">Select</option> 
						</select>
                    </div>
                </div>
 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
<?php echo $My_Controller->savePermission;?>
            </div>
            <?php echo form_close();?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Modal for Edit KYC Form END-->
<div class="modal fade" role="dialog"  id="mod_editkyc">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Edit Customer KYC</h4>
            </div>
            <?= form_open_multipart(base_url() . 'index.php/claims/update_kyc', array('id'=>'customer_kyc_edit', 'method' => 'POST', 'class' => 'form-horizontal')) ?>
			
            <div class="modal-body">
				
		 
					 
				
				<input type='hidden' name="cid" class='form-control' id='c_' value='<?= $surveyDetail['id'] ?>'>
				 
				
				
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Name</label>
					<div class="col-lg-9">
                          <input type="text" value="<?php echo $surveyDetail['name']; ?>" size="16" id="name" required name="name"
                       class="form-control form-control-inline input-medium">
						 
                    </div>
                </div>
				
				
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Mobile</label>
					<div class="col-lg-9">
                          <input type="text" value="<?php echo $surveyDetail['mobile']; ?>" size="16" id="mobile" required name="mobile"
                       class="form-control form-control-inline input-medium">
						 
                    </div>
                </div>
				
				
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Alternate No</label>
					<div class="col-lg-9">
                          <input type="text" value="<?php echo $surveyDetail['alternate_no']; ?>" id="alternate_no" size="16"   name="alternate_no"
                       class="form-control form-control-inline input-medium">
						 
                    </div>
                </div>
				
				
				<div class="form-group" >	
					<label for="cname" class="control-label col-lg-3">Email</label>
					<div class="col-lg-9">
                          <input type="text" value="<?php echo $surveyDetail['email']; ?>" size="16" id="email" name="email"
                       class="form-control form-control-inline input-medium">
						 
                    </div>
                </div>
				  
				  
				
                <div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Vehicle Address</label>
					
                    <div class='col-lg-9'>
                       <input type="text" value="<?php echo $surveyDetail['v_address']; ?>" size="16" id="v_address" required name="v_address" class="form-control form-control-inline input-medium"
                    </div>
                </div>
				
				 
				 <div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Google Map</label>
					
                    <div class='col-lg-9'>
                        <input type="text" class="form-control form-control-inline input-medium" value="<?php echo $surveyDetail['google_map']; ?>" name="customer_google_map" id="customer_google_map" placeholder="Google Map" onFocus="geolocate()"  />
							  <input type="hidden" class="form-control" name="customer_long" id="customer_long"  /> 
							  <input type="hidden" class="form-control" name="customer_lat" id="customer_lat"  /> 
                    </div>
                </div>
			 
				
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
<?php echo $My_Controller->savePermission;?>
            </div>
            <?php echo form_close();?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Modal for Edit KYC Form END-->

	
	<script type='text/javascript'>
   function addComment(claimsid){
	  var admincomment = $("#admincomment").val();  
		  
		  if(admincomment !== ""){ 
       var csrf_test_name = $("input[name=csrf_test_name]").val();
     $.ajax({
     url:'<?=base_url()?>index.php/claims/addClaimsnotes/',
     method: 'POST',
     data: {claimsid: claimsid, admincomment: admincomment, 'csrf_test_name': csrf_test_name},
     dataType: 'html',
     success: function(response){ 
		 $('#adminnotes').html(response);  
     }
   });
		 } 
   }
				
	 
  
	$(document).ready(function(){
 
	  $('form input').on('keypress', function(e) {
    return e.which !== 13;
});

$('#make').change(function(){
    	var make = $(this).val(); 
		  
		  if(make !== ""){ 
       
			  
           var csrf_test_name = $("input[name=csrf_test_name]").val();
     $.ajax({
     url:'<?=base_url()?>index.php/bookings/getModelsByMake/',
     method: 'POST',
     data: {vehicle_make: make, 'csrf_test_name': csrf_test_name},
     dataType: 'json',
     success: function(response){ 
		 
		 $('#model').empty().trigger("change");  
			  var data = {
    id: '',
    text: 'Select Model'
};
var newOption = new Option(data.text, data.id, false, false);
$('#model').append(newOption).trigger('change');
		 
		 $('#model').select2({
			 placeholder :'Select Model', 
			 width: 'resolve',
             data: response
                }); 
 		$('#model').trigger('change');
        
     }
   });
		  
		  
		  }
	  });

});
	 
	</script>	
	<script type='text/javascript'> 
	$(document).ready(function(){
		$('#repair_type').change(function(){
    	var repair_type = $(this).val(); 
		  
		  if(repair_type !== ""){ 
       
			  
           var csrf_test_name = $("input[name=csrf_test_name]").val();
     $.ajax({
     url:'<?=base_url()?>index.php/claims/getServiceProviders/',
     method: 'POST',
     data: {repair_type: repair_type, 'csrf_test_name': csrf_test_name},
     dataType: 'json',
     success: function(response){ 
		 
		 $('#service_provider').empty().trigger("change");  
			  var data = {
    id: '',
    text: 'Select Service Provider'
};
var newOption = new Option(data.text, data.id, false, false);
$('#service_provider').append(newOption).trigger('change');
		 
		 $('#service_provider').select2({
			 placeholder :'Select Service Provider', 
			 width: 'resolve',
             data: response
                }); 
 		$('#service_provider').trigger('change');
     }
   });
		  
		  
		  }
	  });
		
		
		jQuery('button').click( function(e) {
    jQuery('.collapse').collapse('hide');
});
		
		
		 });
		</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgW3kze70q1ov1DO0DMUDsZd3f8CUUOBw&libraries=places&callback=initAutocomplete"
        async defer></script>
	<script>
// This sample uses the Autocomplete widget to help the user select a
// place, then it retrieves the address components associated with that
// place, and then it populates the form fields with those details.
// This sample requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script
// src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

var placeSearch, autocomplete;

 
function initAutocomplete() {
  // Create the autocomplete object, restricting the search predictions to
  // geographical location types.
  autocomplete = new google.maps.places.Autocomplete(
      document.getElementById('customer_google_map'));

  // Avoid paying for data that you don't need by restricting the set of
  // place fields that are returned to just the address components.
 // autocomplete.setFields(['address_component']);

  // When the user selects an address from the drop-down, populate the
  // address fields in the form.
 // autocomplete.addListener('place_changed', fillInAddress);
	autocomplete.addListener('place_changed', function () {
      var place = autocomplete.getPlace();
      // place variable will have all the information you are looking for.
      $('#customer_lat').val(place.geometry['location'].lat());
      $('#customer_long').val(place.geometry['location'].lng());
    });
}

 

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      var circle = new google.maps.Circle(
          {center: geolocation, radius: position.coords.accuracy});
      autocomplete.setBounds(circle.getBounds());
    });
  }
}
		
		
		
    </script>
	
	 
	
	 <?php  
			   if(empty($surveyDetail['make']) || $surveyDetail['make']=='0'){ 
				?>
	<script type="text/javascript">
     $(document).ready(function(){
		$('#entervehicledet').modal('show');
	 });
</script>
				 <?php 
				  }
				  ?>
	