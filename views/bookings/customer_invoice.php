<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>GarageWorks - Invoice - TechSpanner</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://garageworks.in/flywheel/assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://garageworks.in/flywheel/assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
	
  <link rel="stylesheet" href="https://garageworks.in/flywheel/assets/modules/chocolat/dist/css/chocolat.css"> 
  <link rel="stylesheet" href="https://garageworks.in/flywheel/assets/modules/prism/prism.css">
  <link rel="stylesheet" href="https://garageworks.in/flywheel/assets/modules/datatables/datatables.min.css">
  <link rel="stylesheet" href="https://garageworks.in/flywheel/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://garageworks.in/flywheel/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
  <link rel="stylesheet" href="https://garageworks.in/flywheel/assets/modules/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="https://garageworks.in/flywheel/assets/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" href="https://garageworks.in/flywheel/assets/modules/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="https://garageworks.in/flywheel/assets/modules/jquery-selectric/selectric.css">
  <link rel="stylesheet" href="https://garageworks.in/flywheel/assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
  <link rel="stylesheet" href="https://garageworks.in/flywheel/assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
  <link rel="stylesheet" href="https://garageworks.in/flywheel/assets/modules/summernote/summernote-bs4.css">
  <link rel="stylesheet" href="https://garageworks.in/flywheel/assets/modules/codemirror/lib/codemirror.css">
  <link rel="stylesheet" href="https://garageworks.in/flywheel/assets/modules/codemirror/theme/duotone-dark.css">
  <link rel="stylesheet" href="https://garageworks.in/flywheel/assets/modules/jquery-selectric/selectric.css">
  
	
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.css">
	
  <link rel="stylesheet" href="https://garageworks.in/flywheel/assets/modules/bootstrap-social/bootstrap-social.css">
  <link rel="stylesheet" href="https://garageworks.in/flywheel/assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="https://garageworks.in/flywheel/assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">
  <link rel="stylesheet" href="https://garageworks.in/flywheel/assets/modules/izitoast/css/iziToast.min.css">
  <link rel="stylesheet" href="https://garageworks.in/flywheel/assets/modules/ionicons/css/ionicons.min.css">	
	<link rel="stylesheet" href="https://garageworks.in/flywheel/assets/modules/fullcalendar/fullcalendar.min.css">  
	

  <!-- Template CSS -->
  <link rel="stylesheet" href="https://garageworks.in/flywheel/assets/css/style.css">
  <link rel="stylesheet" href="https://garageworks.in/flywheel/assets/css/components.css">
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
		 
		 @media print
{    
    .hidden-print, .no-print, .no-print *
    {
        display: none !important;
    }
}
		 
.main-content {
    padding-left: 0px;
    padding-right: 0px;
    padding-top: 0px;
    width: 100%;
    position: relative;
}
.h3, h3 {
    font-size: 1rem;
}	
.invoice {
    box-shadow: 0 4px 8px rgb(0 0 0 / 3%);
    background-color: #fff;
    border-radius: 3px;
    border: none;
    position: relative;
    margin-bottom: 30px;
    padding: 20px;
}
		 
#field{margin-left:.5em;float:left}#field,label{float:left;font-family:Arial,Helvetica,sans-serif;font-size:small}br{clear:both}input{border:1px solid #000;margin-bottom:.5em}input.error{border:1px solid red}label.error{background:url(images/unchecked.gif) no-repeat;padding-left:16px;margin-left:.3em}label.valid{background:url(images/checked.gif) no-repeat;display:block;width:16px;height:16px}
		.subheaders_heading{background-color: #495bf2!important;
    color: #fff!important;}	
		.subheaders_heading .box-title{ color: #fff!important;}	
		table.table-bordered.dataTable tbody th, table.table-bordered.dataTable tbody td {
    font-weight: 400;
}
		.sidebar-menu li {
			list-style:none;
		}
		.sidebar-menu{
		padding-left: 0px;}
		.content{
			font-weight: 400;
			font-size: 12.5px;
		}
		.h2, h2 {
    font-size: 20px;
    font-weight: bold;
}
		
		
		.dtable-container {
    max-width: 100% !important;


    table {
        white-space: nowrap !important;
        width:100%!important;
        border-collapse:collapse!important;
    }
}
		/*table th:nth-child(3), td:nth-child(3) {
  display: none;
}*/
		@media (max-width: 767px){ 
.main-header .logo {
     
    height: 70px;
    
    padding: 10px 45px; 
}
		}
		 
/* 
Generic Styling, for Desktops/Laptops 
*/
table { 
  width: 100%; 
  border-collapse: collapse; 
}
/* Zebra striping */
tr:nth-of-type(odd) { 
  background: #eee; 
}
th { 
  background: #333; 
  color: white; 
  font-weight: bold; 
}
td, th { 
  padding: 6px; 
  border: 1px solid #ccc; 
  text-align: left; 
}
		 
/* 
Max width before this PARTICULAR table gets nasty
This query will take effect for any screen smaller than 760px
and also iPads specifically.
*/
 
	</style>
    <body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
 
<!-- Main Content -->
      <div class="main-content">
      <section class="content">
<div id="container">
	
<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-body">
                <div id="printarea" class="invoice printarea">
                   <div class="row invoice-logo">
                        <div class="col-sm-3 invoice-logo-space">
                            <img src="<?= base_url(); ?>logo.png" class="img-responsive"
                                 alt=""/></div>
                        <div class="col-sm-9 text-right">
                            <h3>&nbsp;</h3>

                        </div>
                    </div>
                    <hr style="margin-top: 0px; margin-bottom: 0px; "/>
                    <div class="row">
                        <div class="col-6"> 
                            <ul class="list-unstyled">
								<li> <?= $booking->customer_name; ?> </li>
								<li> Booking No#<?php echo $booking->booking_id; ?>  </li>
                                <li> Date of  Invoice: <?php echo date('M d,Y',strtotime($booking->service_date)); ?> </li>
                                
                                <!--<li> Madrid </li>
                                <li> Spain </li>
                                <li> 1982 OOP </li>-->
                            </ul>
                        </div>
                         <div class="col-6 invoice-payment"> 
                            <div id="invoice"> 
                                  
								<?php
	
							 $make_name  = get_make($booking->vehicle_make);
							$model_name  = get_model($booking->vehicle_model);	 
								
			 
									
									?>
								
								 <div class="date"><span class=" "> Make:  <?= @$make_name; ?></span>   
                                        </div>
								
								<div class="date"> <span class=" "> Model: <?= @$model_name; ?></span>   
                                        </div>
								
								<div class="date"> <span class=""> Reg No.: <?= @$booking->vehicle_regno; ?></span>   
                                        </div>
								
                            </div>
                        </div>
                    </div>
                    <div class="row" style="">
                        <div class="col-lg-12 col-xs-12">
						<div class="table-responsive">		
                            <table class="table table-striped table-hover" style=" min-height: 80px; ">
                                <thead>
                                <tr>
									<th> #</th> 
                                    <th> Description</th> 
                                    <th> HSN </th>
                                    <th> Brand</th>
                                    <th> Spares Cost</th>
                                    <th> Labour Cost</th>
                                    <th> Quantity</th>
                                    <th> Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $n = 1;
								if($jobcard_details)	 
                                foreach ($jobcard_details as $rows) {
									$hsn_no = $this->Common->single_row('item', array('item_name'=>$rows->item),'hsn_no')
                                    ?> 
									<tr>
                                        <td><?php echo $n; ?></td> 
                                        <td><?php echo $rows->item; ?></td> 
										<td><?php echo $hsn_no; ?></td>	
                                        <td><?php echo $rows->brand; ?></td>
                                        <td> <?php echo $rows->spares_rate; ?></td>
										<td> <?php echo $rows->labour_rate; ?></td>
                                        <td><?php echo $rows->qty; ?></td>
                                        <td> <?php echo $rows->amount; ?></td>
                                    </tr>
                                    <?php $n++;
                                }  
 									?>

                                </tbody>
                            </table>
							</div>
                        </div>
						 
                        <div class="col-6 invoice-block">
                            <div class="well" style="padding: 0px;">
								<ul class="list-unstyled amounts" style="padding-right:50px; font-size:15px;">
                                <li>
                                    <strong>Sub - Total:</strong> 
									<?php 
									$sub_tot = $this->payments->get_ledger($booking->booking_id, 'jobcard_total', 'requested_amount');
									echo $sub_tot;
									?>
									</li>
                                <li>
                                     Discount: 
									<?php 
									$discount_amt =  $this->payments->get_ledger($booking->booking_id, 'discount', 'received_amount');
									echo $discount_amt;
									?>
                                </li>
                                 
                                <li>
                                    Adjustments:
									<?php 
									$round_off_amt =   $this->payments->get_ledger($booking->booking_id, 'round_off', 'requested_amount');
									echo $round_off_amt;
									?>
									
									</li>
 
								
                            </ul>
							</div>
                            <br/>
                             
                        </div>
						
						
						
						<div class="col-6 invoice-block">
                            <div class="well" style="padding: 0px;">
								<ul class="list-unstyled amounts" style="padding-right:50px; font-size:15px;">  
                                <li> <strong>Invoice Value: </strong>   
									<?php 
									$booking_fee_amt =   $this->payments->get_ledger($booking->booking_id, 'booking_fee', 'received_amount');
									
									$service_advance_amt =   $this->payments->get_ledger($booking->booking_id, 'service_advance', 'received_amount');
									
									 ?>
									
									<?php  
									$net_pay_cal = $sub_tot-$discount_amt-$round_off_amt;
									$invoice_val = max($net_pay_cal, $booking_fee_amt);
									$net_pay_amount = $invoice_val-$booking_fee_amt;
									echo $invoice_val;
									?>
								</li> 
                                <li> Booking Fee: <?= $booking_fee_amt; ?> </li>
                                <li> Service Advance: <?= $service_advance_amt; ?> </li> 
 									
                            </ul>
							</div>
                            <br/>
                             
                        </div>
						
						
						<div class="col-6 text-right">&nbsp;</div>
						<div class="col-6 text-right">
                            <div class="well" style="padding: 0px;">
								 
								<h4> <strong>Net Payable: <?php echo $net_pay_amount; ?></strong></h4> 
                                  
							</div>
                            <br/>
                             
                        </div>
						 
						<div class="col-xs-12 col-sm-12 col-md-6">
                                <h5>Payment Receipt Details:</h5>
                            <table class="table table-striped table-hover" style=" min-height: 80px; ">
                                <thead>
                                <tr>
									<th> #</th> 
                                    <th> Amount</th> 
                                    <th> Date</th>
                                    <th> Mode</th> 
                                </tr>
                                </thead>
                                <tbody>
                                <?php $n = 1;
									
									 
									
								$payments_made = $this->Common->select_wher('customer_ledger','booking_id='.$booking->booking_id.' AND received_amount>0 AND transaction_type IN ("final_paid","service_advance","booking_fee")');
								if($payments_made)	 
                                foreach ($payments_made as $paid) {
									 
                                    ?> 
									<tr>
                                        <td><?php echo $n; ?></td> 
                                        <td><?php echo $paid->received_amount; ?></td> 
										<td><?php echo date('M d,Y',strtotime($paid->updated_on)); ?></td>	
                                        <td><?php echo $paid->mode; ?></td> 
                                    </tr>
                                    <?php $n++;
                                }  
 									?>

                                </tbody>
                            </table>
                         
                        </div>
					   <div class="col-xs-12 col-sm-12 col-md-6 text-right">
						
						 
                            
                                <address>
                                    <strong><?=$this->general_settings['application_name'];?></strong>
                                    <br/><?=$this->general_settings['email'];?>
									
                                    <br/>GSTIN: 27AAFCT4549P1ZL 
                                </address>
                                
                           
                        
                        <div class="invoice-block text-right">
							<strong><?=$this->general_settings['company_name'];?></strong><br />
                            <img src="<?= base_url(); ?>signature.png" class="img-responsive" alt="" style="display: initial;width: 150px;" /><br />
							<p>Authorized Signatory</p>
                            <br/>
                            
                        </div>
                    
                    
                   </div>
					
					
					 
                        <div class="col-12">
						
                                 	
					 <p>
Thank you for availing services with GarageWorks<br>
If the invoice value or amount collected is different from what you have actually paid, please inform us at info@garageworks.in
						 </p>
							
<p><strong>Service Warranty:</strong></p>

<ul class="list-unstyled amounts">
<li>Please ride your vehicle for the next 2-3 days.</li>
<li>In case there are any complaints or issues, please do contact us at 8806174754 or write to us at info@garageworks.in. Please do quote your Invoice No</li>
<li>Our services / workmanship have a warranty of 7 days. We offer free service visit for all warranty issues</li>
<li>Warranty on spares parts as per the manufacturer guidelines only</li>
<li>Warranty visit is not applicable due to any issue because of repair work which was recommended by GarageWorks, but not approved by you</li>
</ul>
						</div>
					 
					 
				 
                </div>
					
				<div class="row hidden-print" style="margin-top: 50px;">
					 
  
  <div class="col-6  text-center"> 
  <a href="https://g.page/garageworks1/review?rc" target="_blank" />  <img src="<?= base_url(); ?>review.png" alt="review" style="width: 5.5em;"> Give us your review </a>
  </div>
 
  <div class="col-6  text-center"> 
   <a href="<?= base_url(); ?>feedback?id=<?php echo $booking->booking_id; ?>" target="_blank" />  <img src="<?= base_url(); ?>feedback.png" alt="feedback" style="width: 6em;"> Give your feedback </a>
  </div>
 
                        <div class="col-12 text-center">
				<button onClick="javascript:window.print();" id="printbutton" type="button" class="btn btn-lg btn-primary text-white hidden-print margin-bottom-5"> Print
                                <i class="fa fa-print"></i>
                            </button>
							
					</div></div>			
				
				
            </div>
        </div>
    </div>
</div>

		
	
	
	</div>
</section>
      </div>	
      <footer class="main-footer">
        <div class="footer-left">
          
        </div>
        <div class="footer-right">
          
        </div>
      </footer>
    

  <!-- General JS Scripts -->
  <script src="https://garageworks.in/flywheel/assets/modules/jquery.min.js"></script>
  <script src="https://garageworks.in/flywheel/assets/modules/popper.js"></script>
  <script src="https://garageworks.in/flywheel/assets/modules/tooltip.js"></script>
  <script src="https://garageworks.in/flywheel/assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="https://garageworks.in/flywheel/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="https://garageworks.in/flywheel/assets/modules/moment.min.js"></script>
  <script src="https://garageworks.in/flywheel/assets/js/stisla.js"></script>
  <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
  <!-- JS Libraies -->

  
  <script src="https://garageworks.in/flywheel/assets/modules/jquery-ui/jquery-ui.min.js"></script>
  <script src="https://garageworks.in/flywheel/assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script> 
  <script src="https://garageworks.in/flywheel/assets/modules/prism/prism.js"></script>

  <script src="https://garageworks.in/flywheel/assets/modules/cleave-js/dist/cleave.min.js"></script>
  <script src="https://garageworks.in/flywheel/assets/modules/cleave-js/dist/addons/cleave-phone.us.js"></script>
  <script src="https://garageworks.in/flywheel/assets/modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>
  <script src="https://garageworks.in/flywheel/assets/modules/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script src="https://garageworks.in/flywheel/assets/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
  <script src="https://garageworks.in/flywheel/assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
  <script src="https://garageworks.in/flywheel/assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
  <script src="https://garageworks.in/flywheel/assets/modules/select2/dist/js/select2.full.min.js"></script> 
  
  <script src="https://garageworks.in/flywheel/assets/modules/summernote/summernote-bs4.js"></script>
  <script src="https://garageworks.in/flywheel/assets/modules/codemirror/lib/codemirror.js"></script>
  <script src="https://garageworks.in/flywheel/assets/modules/codemirror/mode/javascript/javascript.js"></script>
  
  
  <script src="https://garageworks.in/flywheel/assets/modules/datatables/datatables.min.js"></script>
  <script src="https://garageworks.in/flywheel/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://garageworks.in/flywheel/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script> 

  
  <script src="https://garageworks.in/flywheel/assets/modules/jquery-selectric/jquery.selectric.min.js"></script>
  
  <script src="https://garageworks.in/flywheel/assets/modules/izitoast/js/iziToast.min.js"></script>
  
  <script src="https://garageworks.in/flywheel/assets/modules/sweetalert/sweetalert.min.js"></script>





  <!-- Page Specific JS File -->



 
  <script src="https://garageworks.in/flywheel/assets/js/scripts.js"></script>
  <script src="https://garageworks.in/flywheel/assets/js/custom.js"></script>

 
 


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
  window.location.href = "<?php echo base_url();?>bookings/customer_jobcard/<?php echo $booking->booking_id; ?>/approved";
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
</script>
 
</body>
</html>