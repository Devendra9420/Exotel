<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>GarageWorks - Customer Jobcard - TechSpanner</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
	
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/chocolat/dist/css/chocolat.css"> 
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/prism/prism.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/jquery-selectric/selectric.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/summernote/summernote-bs4.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/codemirror/lib/codemirror.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/codemirror/theme/duotone-dark.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/jquery-selectric/selectric.css">
  
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/bootstrap-social/bootstrap-social.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/izitoast/css/iziToast.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/ionicons/css/ionicons.min.css">	
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/fullcalendar/fullcalendar.min.css">  
	

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/components.css">
</head>

	 <style>
		 select{
			 width: 100% !important;
		 }
		 .select2-container.select2-dropdown-open {
   			 width: 100% !important;
  			}
		 .select2-container-multi .select2-search-choice-close {
    left: auto;
    right: 3px;
  }

  .select2-container-multi .select2-choices .select2-search-choice {
    padding-right: 18px;
    padding-left: 5px;
  }
		 
.pac-container {
        z-index: 10000 !important;
    }	
		 
	.select2-selection__clear {
    /*position: absolute !important; */
	float: right;
   right: 20px !important; 
}
.form-control::-webkit-input-placeholder {
  opacity: 0.5; 
}	
		 .loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
	margin: auto;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
		 .main-content {
    padding-left: 30px;
    padding-right: 30px;
    padding-top: 30px;
    width: 100%;
    position: relative;
}
	</style>
    <body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <aside id="sidebar-wrapper">
          <div class="sidebar-brand" style="padding-top: 30px;text-align: center;">
            <a href="<?php echo base_url(); ?>"><img alt="image" src="<?php echo base_url(); ?>logo.png" class="img-fluid mr-1 pr-3"></a>
          </div> 
          
        </aside> 
<!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header text-center">
            <h1>Booking <?= $booking_id ?> - Customer Jobcard</h1> 
          </div> <div class="section-body">  
    <div class="row">
        <div class="col-lg-12">
      		<div class="panel">
                <div class="panel-body">
                     
						<?php $attributes = array('class' => 'form-horizontal group-border hover-stripped ApproveForm', 'id'=>'addedit_form', 'method' => 'post');
                echo form_open_multipart('bookings/approve_jobcard', $attributes); ?>
						 
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
							
						<input type="hidden" name="customer_id" id="customer_id" value="<?php echo @$booking->customer_id; ?>" />
						<input type="hidden" name="customer_approval" value="Yes" />
							
			<div class="col-12 col-md-6 col-lg-3">
                <div class="card card-primary">
                  <div class="card-header">
                    <h4>Customer Details</h4>
                  </div>
                  <div class="card-body"> 
					<p>Name: <?php echo $booking->customer_name; ?></p> 
					<p>Mobile: <?php echo $booking->customer_mobile; ?></p>
					<p>Channel: <?php echo $booking->customer_channel; ?></p>  
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
                  </div>
                </div>
              </div>
				
				
			<div class="col-12 col-md-6 col-lg-3">
                <div class="card card-primary">
                  <div class="card-header">
                    <h4>Vehicle Details</h4>
                  </div>
                  <div class="card-body">
					<p>Service Date: <?php echo convert_date($booking->service_date); ?></p>
					<p>Service Category: <?php echo get_service_category($booking->service_category_id); ?></p>   
					<p>Last Km Reading: <?php echo $booking->vehicle_km_reading; ?></p>  
                  </div>
                </div>
              </div>
			
							
				<div class="col-12 col-md-6 col-lg-3">
                <div class="card card-primary">
                  <div class="card-header">
                    <h4>Other Details</h4>
                  </div>
                  <div class="card-body">
					<p>Comment: <?php echo @$jobcard->remark; ?></p>
					 <p> 
					 
					 </p>
					  <p>&nbsp;</p>
					  <p>&nbsp;</p>
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
                            <th style="display: none;">Brand</th>
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
				 
			</td>	
			<td style="display: none;"><select  class="form-control select-ajax-spares-brand" data-spareid="<?= $row->item_id; ?>"  style="width: 100%;" name="brand[]" id="brand_<?= $counter; ?>"><option value="" selected></option></select></td>	 
			<td>
            <input type="text" readonly name="quantity[]" tabindex="1" id="quantity_<?= $counter; ?>" onclick="row_sum(<?= $counter; ?>)" size="2" value="<?= $row->qty; ?>" class="form-control" onkeyup="row_sum(<?= $counter; ?>)"></td><td> 
             <input type="text" readonly name="spares_rate[]" class="form-control spares_amount"  required onkeyup="row_sum(<?= $counter; ?>)"  onchange="row_sum(<?= $counter; ?>)"  id="spares_<?= $counter; ?>" size="6" value="<?= $row->spares_rate; ?>"></td>
			<td> 
            <input type="text" readonly name="labour_rate[]" class="form-control"  required onkeyup="row_sum(<?= $counter; ?>)"  id="labour_<?= $counter; ?>" size="6" value="<?= $row->labour_rate; ?>"></td>
			<td>  
			<input type="text" readonly name="total_rate[]"  class="form-control input-totalrate" required onkeyup="row_sum(<?= $counter; ?>)"  id="total_<?= $counter; ?>" size="6" value="<?= $row->amount; ?>"></td>
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
				 <div class="card-complaints card card-info" id="card_complaints_<?= $complaint_number; ?>"><div class="card-header"> <h4>Complaint <?= $complaint_number; ?>: <?= $row->complaints; ?></h4> <div class="card-header-action col-md-6"> <button style="display: none;" type="button" class="btn btn-danger float-right" onclick="deleteComplaint(<?= $complaint_number; ?>')"><i class="fas fa-trash"></i></button> </div>   </div> <div class="collapse show" id="complaint-collapse-<?= $complaint_number; ?>" style="">  <div class="card-body"> <div class="row">  
			 <table class="table table-striped tables-complaints" id="complaintstable_<?= $complaint_number; ?>">  
                        <thead>  
                          <tr> 
                            <th>#</th>
                            <th>Description</th>
                            <th style="display: none;">Brand</th>
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
			  
			<td style="display: none;"><select class="form-control select-ajax-spares-brand" data-spareid="<?= $row->item_id; ?>"  name="brand[]"  style="width: 100%;" id="brand_<?= $complain_counter; ?>"><option value="" selected></option></select></td>					
			<td>
            <input type="text" readonly name="quantity[]" tabindex="1" id="quantity_<?= $complain_counter; ?>" onclick="complain_row_sum(<?= $complaint_number; ?>,<?= $complain_counter; ?>)" size="2" value="<?= $row->qty; ?>" class="form-control" onkeyup="complain_row_sum(<?= $complain_counter; ?>)"></td><td> 
             <input type="text" readonly name="spares_rate[]" class="form-control spares_amount"  required onkeyup="complain_row_sum(<?= $complaint_number; ?>,<?= $complain_counter; ?>)" onchange="complain_row_sum(<?= $complaint_number; ?>,<?= $complain_counter; ?>)"  id="spares_<?= $complain_counter; ?>" size="6" value="<?= $row->spares_rate; ?>"></td>
			<td> 
            <input type="text" readonly name="labour_rate[]" class="form-control"  required onkeyup="complain_row_sum(<?= $complaint_number; ?>,<?= $complain_counter; ?>)"  id="labour_<?= $complain_counter; ?>" size="6" value="<?= $row->labour_rate; ?>"></td>
			<td>  
			<input type="text" readonly name="total_rate[]"  class="form-control input-complaint_totalrate" required onkeyup="complain_row_sum(<?= $complaint_number; ?>,<?= $complain_counter; ?>)"  id="total_<?= $complain_counter; ?>" size="6" value="<?= $row->amount; ?>"></td>
			<td><button type="button" onClick="delete_complain_row(<?= $complain_counter; ?>);" class="btn btn-danger btn-delete"><i class="fas fa-trash"></i></button></td>
			</tr>
				
       		   
					 <?php  $complain_counter++; 
							
										
							
							} ?>
						 
						</tbody></table></div></div></div></div>			
							
					 
					
				</div>
				
				<div class="col-md-12" id="comments_div" style="display: none;"> 	
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
					  <input class="form-control" value="0" id="totalcombine_max" type="text" readonly name="totalcombine_max"> 	
                    </div>
				</div>		 
					
					 
				<div class="col-md-6"> 	
					<div class="form-group">
                      <label>Discount: </label>
						<?php $discount =   $this->payments->get_ledger($booking->booking_id, 'discount', 'requested_amount'); ?>
					  <input class="form-control" readonly value="<?= @$discount; ?>" id="discount" type="number"  name="discount"> 	
                    </div>
				</div>
					
				<div class="col-md-6"> 	
					<div class="form-group">
                      <label>Round Off: </label>
					  <input class="form-control" value="<?php echo @$round_off_demanded_amt; ?>" id="round_off" type="number"  name="round_off"> 	
                    </div>
				</div>
							
					<?php 
							$service_advance_demanded_amt =   $this->payments->get_ledger($booking->booking_id, 'service_advance', 'requested_amount');
							$service_advance_received_amt =   $this->payments->get_ledger($booking->booking_id, 'service_advance', 'received_amount');
							
							$round_off_demanded_amt =   $this->payments->get_ledger($booking->booking_id, 'round_off', 'requested_amount');
							
							
							$service_advance_tobe_paid = $service_advance_demanded_amt-$service_advance_received_amt;
							?> 
				
				<div class="col-md-6"> 	
					<div class="form-group">
                      <label>Service Advance to be paid: </label> 
					  <input class="form-control" readonly value="<?= @$service_advance_demanded_amt; ?>" id="service_advance" type="number"  name="service_advance"> 	
                    </div>
				</div> 
							
							
				<div class="col-md-6"> 	
					<div class="form-group">
                      <label>Service Advance Paid: </label> 
					  <input class="form-control" readonly value="<?= @$service_advance_received_amt; ?>" id="service_advance_paid" type="number"  name="service_advance_amt"> 	
                    </div>
				</div>
							
							
						</div>
				<div class="panel-footer">
                        <div class="form-group">
                            <div class="col-md-12">
								
								 <div style="text-align:center">
						<span id="loadingdiv" style="display: none; text-align:center" class="col-12"><div class="loader"></div></span>
						<span id="submitdiv">
						<?php if($jobcard->customer_approval!='Yes'){ ?>
								<?php if($service_advance_tobe_paid<1){ ?>
							
                        <span style=""><button class="btn  btn-success" onClick="approvethisjobcard();" type="button">Approve Jobcard</button></span>
						
						
						<span style=""><a href="<?= base_url() ?>bookings/customer_jobcard/<?php echo $booking_id; ?>" class="btn  btn-danger">Cancel</a></span>
								<?php }else{  ?>
							<h6>Payment of service advance for Rs. <?php echo $service_advance_tobe_paid; ?>/- is pending. Before approving this jobcard, please pay the amount through the link sent on your mobile number via sms.</h6>
								<?php } ?>
					  <?php } ?>
							</span>	
                    			</div>
								
								
                                
                            </div>
                        </div> 
						</div>	
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>  

<!--Modal for EDIT ends-->

	  </section>
      </div>	
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy;  <div class="bullet"></div> 
        </div>
        <div class="footer-right">
          
        </div>
      </footer>
    

  <!-- General JS Scripts -->
  <script src="<?php echo base_url(); ?>assets/modules/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/modules/popper.js"></script>
  <script src="<?php echo base_url(); ?>assets/modules/tooltip.js"></script>
  <script src="<?php echo base_url(); ?>assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/modules/moment.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/stisla.js"></script>
  <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
  <!-- JS Libraies -->

  
  <script src="<?php echo base_url(); ?>assets/modules/jquery-ui/jquery-ui.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script> 
  <script src="<?php echo base_url(); ?>assets/modules/prism/prism.js"></script>

  <script src="<?php echo base_url(); ?>assets/modules/cleave-js/dist/cleave.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/modules/cleave-js/dist/addons/cleave-phone.us.js"></script>
  <script src="<?php echo base_url(); ?>assets/modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/modules/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script src="<?php echo base_url(); ?>assets/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js"></script> 
  
  <script src="<?php echo base_url(); ?>assets/modules/summernote/summernote-bs4.js"></script>
  <script src="<?php echo base_url(); ?>assets/modules/codemirror/lib/codemirror.js"></script>
  <script src="<?php echo base_url(); ?>assets/modules/codemirror/mode/javascript/javascript.js"></script>
  
  
  <script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script> 

  
  <script src="<?php echo base_url(); ?>assets/modules/jquery-selectric/jquery.selectric.min.js"></script>
  
  <script src="<?php echo base_url(); ?>assets/modules/izitoast/js/iziToast.min.js"></script>
  
  <script src="<?php echo base_url(); ?>assets/modules/sweetalert/sweetalert.min.js"></script>





  <!-- Page Specific JS File -->



 
  <script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>

 
 


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
    <?php  
  $this->load->view('custom_js');
   ?>
<script type="text/javascript"> 
  
 
	function approvethisjobcard(){
		 
 	var formValues= $('.ApproveForm').serialize(); 
			$('#submitdiv').hide();
			$('#loadingdiv').show();
      $.ajax({
     url:'<?php echo base_url();?>bookings/update_customer_jobcard/',
     method: 'POST',
     data: formValues,
     dataType: 'json',
     success: function(data){ 
		 
		 if(data.response == '1'){
		 	
			 	swal('Great!', "Jobcard Approved Successfully!", 'success', { buttons: false, timer: 2000,  });	   
			 
 			setTimeout(function() {
  window.location.href = "<?php echo base_url();?>bookings/customer_jobcard/<?php echo base64_encode($booking_id); ?>/approved";
}, 2000);
			  
			//$('#loadingdiv').hide(); 		   
		 }else{
			swal('Oops!', "Something went wrong!", 'warning', { buttons: false, timer: 2000,  });	   
			 
		 }
		 
     }
   });
		 
		}
</script>
 <?php if(!empty($approved) && $approved=="Yes"){ ?>
	
	<script> 	
swal('Great!', "Thankyou for approving your jobcard!", 'success', { buttons: false, timer: 5000,  });	   		
</script>
 <?php } ?>
<script> 
	
	 $(document).ready(function(){	
	calculateColumn();	
	 });
	
	function calculateColumn() {  
			
			var estimate_tablerows = $("#estimate_table");
			var allEstimateTotal = 0; 
			estimate_tablerows.find(".input-totalrate").each(function () {
			if (!isNaN($(this).val())) {
			var stval = parseFloat($(this).val());
			allEstimateTotal += isNaN(stval) ? 0 : stval;
				 
			}
			});
			
			$('#total_estimate_sum').val(allEstimateTotal);
			calculateColumn_Complaint();
        }
	
	
	function calculateColumn_Complaint() {    
				
				var complaintTableTotal_min = 0;
			   var complaintTableTotal_max = 0;
			$('.tables-complaints').each(function(index){  
				
				var	prices = []; 
				$(this).find('tr').each(function(){  
				var stval = $(this).find('.input-complaint_totalrate').val(); // parseFloat($(this).find('.input-complaint_totalrate').val());
				var thisRowTotal = isNaN(stval) ? 0 : stval; 
				prices.push(parseFloat(thisRowTotal));   
				}); 
				 
				var thistable_max = Math.max.apply(null,prices);
				var thistable_min = Math.min.apply(null,prices); 
				
				complaintTableTotal_max += thistable_max;
				complaintTableTotal_min += thistable_min;
				
				
			 
			}); 
				
				
				$('#max_complaints_val').val(complaintTableTotal_max);
				$('#min_complaints_val').val(complaintTableTotal_min);
				
				//alert('Max '+ thistable_max);
				//alert('Min '+ thistable_min);
				
				calculatecombinedTotal();	
				
        }
	
	
	function calculatecombinedTotal() {  
				
			var $totalEstimate_v =  parseFloat($('#total_estimate_sum').val());
			var $complaint_max_v =  parseFloat($('#max_complaints_val').val());  
			var $complaint_min_v = parseFloat($('#min_complaints_val').val());  
				
			var	$totalEstimate = isNaN($totalEstimate_v) ? 0 : $totalEstimate_v;
			var	$complaint_max = isNaN($complaint_max_v) ? 0 : $complaint_max_v;
			var	$complaint_min = isNaN($complaint_min_v) ? 0 : $complaint_min_v;	
				
				var $totalcombine_max = parseFloat($totalEstimate)+parseFloat($complaint_max);
				var $totalcombine_min = parseFloat($totalEstimate)+parseFloat($complaint_min);
				 
				$('#totalcombine_max').val($totalcombine_max);
				$('#totalcombine_min').val($totalcombine_min);
				 
				var	totalprice = 0;
				var complainttotalprice = 0; 
				
			$('.input-totalrate').each(function(index){   
				var stval = $(this).val();  
				var thisRowTotal = isNaN(stval) ? 0 : stval;
				totalprice += +parseFloat(thisRowTotal);
				//totalprice.push(parseFloat(thisRowTotal));	  
			});
				
				$('.input-complaint_totalrate').each(function(index){   
				var stval = $(this).val();  
				var thisRowTotal = isNaN(stval) ? 0 : stval;
				complainttotalprice += +parseFloat(thisRowTotal);
				//totalprice.push(parseFloat(thisRowTotal));	  
			});
				
				
				$('#totalcombined_all').val(totalprice+complainttotalprice);
				
			}
//jobcardTotal();				
</script>
 
</body>
</html>