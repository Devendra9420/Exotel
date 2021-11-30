<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
	<title>GarageWorks | Feedback</title>

	<!-- Favicons-->
	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
	 
	<!-- GOOGLE WEB FONT -->
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i" rel="stylesheet">

	<!-- BASE CSS -->
	<link href="<?= base_url() ?>assets/feedback/css/animate.min.css" rel="stylesheet">
	<link href="<?= base_url() ?>assets/feedback/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?= base_url() ?>assets/feedback/css/menu.css" rel="stylesheet">
	<link href="<?= base_url() ?>assets/feedback/css/style.css" rel="stylesheet">
	<link href="<?= base_url() ?>assets/feedback/css/responsive.css" rel="stylesheet">
	<link href="<?= base_url() ?>assets/feedback/css/icon_fonts/css/all_icons_min.css" rel="stylesheet">
	<link href="<?= base_url() ?>assets/feedback/css/skins/square/grey.css" rel="stylesheet">
	
	<!-- COLOR CSS -->
	<link href="<?= base_url() ?>assets/feedback/css/color_4.css" rel="stylesheet">
	
	<!-- BASE CSS -->
	<link href="<?= base_url() ?>assets/feedback/css/date_time_picker.css" rel="stylesheet">

	<!-- YOUR CUSTOM CSS -->
	<link href="<?= base_url() ?>assets/feedback/css/custom.css" rel="stylesheet">

	<script src="<?= base_url() ?>assets/feedback/js/modernizr.js"></script>
	<!-- Modernizr -->
	<style>
	/* .      iOS STYLE RADIO 			*/
 .ios-ui-select{
	background: #dddddd;
	border: none;
	height: 36px;
	background: #dddddd;
	-webkit-border-radius: 18px;
	border-radius: 18px;
	width: 60px;
	-webkit-transition: all 0.3s ease-in-out;
	-moz-transition: all 0.3s ease-in-out;
	-ms-transition: all 0.3s ease-in-out;
	-o-transition: all 0.3s ease-in-out;
	transition: all 0.3s ease-in-out;
	-webkit-box-shadow: none;
	box-shadow: none;
	cursor: pointer;
	position: relative;
	display: inline-block;
}
.ios-ui-select.checked{
	-webkit-box-shadow: inset 0 0 0 36px #6ddc5f;
	box-shadow: inset 0 0 0 36px #6ddc5f;
}
.ios-ui-select.checked .inner{
	left: 27px;
}
.ios-ui-select .inner{
	width: 30px;
	height: 30px;
	position: absolute;
	top: 3px;
	left: 3px;
	-webkit-border-radius: 100%;
	border-radius: 100%;
	background: white;
	-webkit-transition: all 350ms cubic-bezier(0, 0.89, 0.44, 1);
	-moz-transition: all 350ms cubic-bezier(0, 0.89, 0.44, 1);
	-o-transition: all 350ms cubic-bezier(0, 0.89, 0.44, 1);
	transition: all 350ms cubic-bezier(0, 0.89, 0.44, 1);
	-webkit-box-shadow: 0 1px 2px 0 rgba(0,0,0,0.2),0 3px 4px 0 rgba(0,0,0,0.1);
	box-shadow: 0 1px 2px 0 rgba(0,0,0,0.2),0 3px 4px 0 rgba(0,0,0,0.1);
}
	</style>
</head>

<body>
	
	<div id="preloader">
		<div data-loader="circle-side"></div>
	</div><!-- /Preload -->
	
	<div id="loader_form">
		<div data-loader="circle-side-2"></div>
	</div><!-- /loader_form -->

	<header>
		<div class="container-fluid">
		    <div class="row">
                <div class="col-3">
                    <div id="logo_home">
                        <h1><a href="index.html"><img src="<?= base_url() ?>assets/feedback/img/logo.png" alt="GarageWorks Feedback"></a></h1>
                    </div>
                </div>
                <div class="col-9">
                    <div id="social">
                        <ul>
                            <li><a target="_blank" href="https://www.facebook.com/garageworksservice"><i class="icon-facebook"></i></a></li>
                            <li><a target="_blank" href="https://www.instagram.com/garageworks_"><i class="icon-instagram"></i></a></li> 
                            <li><a target="_blank" href="https://in.linkedin.com/company/garage-works"><i class="icon-linkedin"></i></a></li>
                        </ul>
                    </div>
                    <!-- /social -->
                    
                </div>
            </div>
		</div>
		<!-- container -->
	</header>
	<!-- End Header -->

	<main>
		<div id="form_container">
			<div class="row">
				<div class="col-lg-5 leftsidecolor">
					<div id="left_form">
						<figure><img src="<?= base_url() ?>assets/feedback/img/review_bg.svg" alt=""></figure>
						<h2>Feedback</h2>
						<p>Your feedback is valuable to us. Please fill in the details to help us serve you better.</p>
						<a href="#0" id="more_info" style="display: none;" data-toggle="modal" data-target="#more-info"><i class="pe-7s-info"></i></a>
					</div>
				</div>
				<div class="col-lg-7">

					<div id="wizard_container">
						<div id="top-wizard">
							<div id="progressbar"></div>
						</div>
						<!-- /top-wizard -->
						<?php 
	
	$feedbackExisits  = $this->db->query("SELECT COUNT(*) AS isexisting FROM feedback WHERE booking_id='".$booking->booking_id."'")->row();
			$feedbackExisited = $feedbackExisits->isexisting;
		  if($feedbackExisited<1){ 
		  ?>
						<form name="feedbackForm" class="feedbackForm" id="wrapped" method="POST">
							 <input id="website" name="website" type="text" value="">
							<input id="booking_id" name="booking_id" type="hidden" value="<?php echo $booking->booking_id; ?>">
							<input id="feedback_id" name="feedback_id" type="hidden" value="0">
							<!-- Leave for security protection, read docs for details -->
							<div id="middle-wizard">
								
								<?php  
						$getservice_category   = $this->db->query("SELECT service_name FROM service_category WHERE id='".$booking->service_category_id."'")->row();
							$service_category  = $getservice_category->service_name;
								$n = 1;	
		  						$tot = 5;
								?>
								
								<div class="step step1">
									<h3 class="main_question"><strong style="display: none;"><?php echo $n.'/'.$tot; ?></strong>Please Confirm the following</h3>
									<div class="row">
										<div class="col-md-12">
												<div class="row">
												<div class="col-sm-6"><strong>Service:</strong>   <?= $service_category ?> </div>
												<div class="col-sm-6"><strong>Invoice Total:</strong>   <?php if(!empty($payments->total_amount) && !empty($payments->discount)){ ?>  Rs. <?php echo $payments->total_amount-$payments->discount;?> /- <?php  }else{ echo 'Rs. '.$payments->total_amount?> /- <?php  } ?></div>
											 
												</div>
											<div class="form-group clearfix">  
												<div class="col-sm-12">
													<?php  
						$getservice_category   = $this->db->query("SELECT service_name FROM service_category WHERE id='".$booking->service_category_id."'")->row();
							$service_category  = $getservice_category->service_name;
									?>
													 
													
                            <table class="table table-striped table-hover" style=" min-height: 80px; ">
                                <thead>
                                <tr>
									<th> #</th> 
                                    <th> Description</th>  
                                    <th> Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $n = 1;
									
								 
									
									
									 $sql = $this->db->query("select * from jobcard_details where booking_id=".$booking->booking_id." and status='Active'");
        $data_jobcard_items  = $sql->result();
                                foreach ($data_jobcard_items as $rows) {
									
                                    ?>
                                    <?php 
									 
									$thisbrandname = $this->db->query("select brand from spares_rate where id='".$rows->brand."'")->row(); 
									if(!empty($thisbrandname)){ 
										$thisbrand = $thisbrandname->brand;
									}else{
										$thisbrand = '';
									}
										?>
									<tr>
                                        <td><?php echo $n; ?></td> 
                                         
										<td><?php echo $rows->item; ?></td>	 
                                        <td> <?php echo $rows->amount; ?></td>
                                    </tr>
                                    <?php $n++;
                                }  
								 
									
 
									 
									?>

                                </tbody>
                            </table>
									<br>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Do you accept?</label>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<select type="text" name="bookdetailsaccept" class="form-control required" placeholder="Select">
												<option>Please Select</option>
												<option value="yes">Yes</option>	
												<option value="no">No</option>	
												</select>	
											</div>
										</div>
									</div>			
                        </div>
												
												 
												 
											</div>
											   
										</div>
									</div>
									<!-- /row -->
								</div>
								<!-- /step 1 -->
								
								
								<?php if(!empty($booking->complaints)){  ?>
								<?php 
								$n = 2; 
								$tot = $tot+1;
								?>
								<div class="step step1_2">
									<h3 class="main_question"><strong style="display: none;"><?php echo $n.'/'.$tot; ?></strong>Were your complaints resolved?</h3>
									<div class="row">
										<div class="col-md-12">
												 
											<div class="form-group clearfix">  
												<div class="col-sm-12">
													<h4>Complaints:</h4>
													<?php  
						$complaints   =  explode('+',$booking->complaints);
							 
							$noofcomplaints = count($complaints);			
							//foreach($complaints as $complain){
								$a = 1;		
							foreach($complaints as $complain) {	
						 
						  
								if(!empty($complain)){ echo $a.') '.$complain.'<br><br>'; $a++; }
								 
							}
									?>
													 
													
                            
									 
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>Please select your answer</label>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<input type="radio" style="margin-right: 10px;" class="required" id="complaints-1" name="complaints_resolved" value="Yes"><label for="complaints-1" class="">Yes</label> 
												<input type="radio" style="margin-left:30px; margin-right: 10px;" class="required" id="complaints-2" name="complaints_resolved" value="No"><label for="complaints-2" class="">No</label> 
												<input type="radio" style="margin-right: 10px; margin-left:30px;"   class="required" id="complaints-3" name="complaints_resolved" value="Not Listed"><label for="complaints-3" class="">Complaints not listed</label>
											</div>
										</div>
									</div>			
                        </div>
												
												 
												 
											</div>
											   
										</div>
									</div>
									<!-- /row -->
								</div>
								<!-- /step 2-->
								<?php }else{
								$n = 1; 
								} ?>
								
								
								
								
								<?php 
								$n = $n+1;  
								?>
								<div class="step step2">
									<h3 class="main_question"><strong style="display: none;"><?php echo $n.'/'.$tot;  ?></strong>Please rate your overall experience with GarageWorks</h3>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group clearfix">
												 
												<span class="rating">
												<input type="radio" class="required rating-input" id="rating-input-1-5" name="feedback" value="5"><label for="rating-input-1-5" class="rating-star"></label>
												<input type="radio" class="required rating-input" id="rating-input-1-4" name="feedback" value="4"><label for="rating-input-1-4" class="rating-star"></label>
												<input type="radio" class="required rating-input" id="rating-input-1-3" name="feedback" value="3"><label for="rating-input-1-3" class="rating-star"></label>
												<input type="radio" class="required rating-input" id="rating-input-1-2" name="feedback" value="2"><label for="rating-input-1-2" class="rating-star"></label>
												<input type="radio" class="required rating-input" id="rating-input-1-1" name="feedback" value="1"><label for="rating-input-1-1" class="rating-star"></label>
												</span>
											</div>
											   
										</div>
									</div>
									<!-- /row -->
								</div>
								<!-- /step 3-->
								
								  
								<div class="step step3 detailsstep">
								 </div>
									<!-- /row -->

									   
								<div class="submit step lastpage">
									<div id="finalstep1_2" style="display: none;">
										<div class="row">
										<div class="col-md-12" style="text-align: center;">
										<p><h3>Sorry! <span style="font-size:100px;">😑</span></h3></p>	
										<h5>Our team will get in touch with you in 24 hours.</h5>	
										</div>
										</div>
									</div>	
									<div id="finalstep3_5">
										<div id="thankyoudiv"></div>
										<div id="lastquestiondiv">
									<h3 class="main_question"><strong style="display: none;"><?php echo $n.'/'.$tot;  ?></strong><span class="detailsheading">Can you refer us to your friends?</span></h3>
									 
									<div class="row">
										 
										<div class="col-md-6">
											<div class="form-group">
												<label>Can you share some more details on the experience ?</label>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												    
   <div id="myRadioGroup">
	   
	   
     <label class="control-label">No</label><input class="ios" id="issueradioyes" type="checkbox" name="haveissues" value="Yes" style="margin-left: 10px;"  />
    
      <label class="control-label" style="margin-left: 20px;">Yes</label>
		
		</div>
											</div>
										</div>
										 
									</div>
									<!-- /row -->
 									
										
									<div class="row" id="moredetails" style="display: none;">
										 
										<div class="col-md-6">
											<div class="form-group">	
										Did the mechanic take a test ride ?
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
											<select type="text" name="testride" class="form-control required" placeholder="Select">
												<option value=""></option>
												<option value="yes">Yes</option>	
												<option value="no">No</option>	
											</select>	
											</div>
										</div>
										
										<div class="col-md-6">
											<div class="form-group">	
										Were you informed about the work to be done before it started?
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
											<select type="text" name="workinformed" class="form-control required" placeholder="Select">
												<option value=""></option>
												<option value="yes">Yes</option>	
												<option value="no">No</option>	
											</select>	
											</div>
										</div>
										
										<div class="col-md-6">
											<div class="form-group">	
										Was there a change in the final billing after you approved the job card?
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
											<select type="text" name="billing_change" class="form-control required" placeholder="Select">
												<option value=""></option>
												<option value="yes">Yes</option>	
												<option value="no">No</option>	
											</select>	
											</div>
										</div>
										
										<div class="col-md-6">
											<div class="form-group">	
										What do you think about GarageWorks doorstep experience ?
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
											<select type="text" name="doorstep_experience" class="form-control required" placeholder="Select">
												<option value=""></option>
												<option value="Convenient">Convenient
												<option value="Trustworthy">Trustworthy</option>	
												<option value="Cost-effective">Cost-effective</option>	 
											</select>	
											</div>
										</div>
										
										
										
									</div> 
										
									<br>
									 </div>
							</div>
								</div>
								<!-- /step 6-->	
									
									
									
									
									
									
									
									
									
								
							</div>
							<!-- /middle-wizard -->
							<div id="bottom-wizard">
								<button type="button" style="display: none;" name="backward" class="backward">Backward </button>
								<button type="button" name="forward" class="forward">Forward</button>
								<div id="submitdiv" style="display: none;"><button style="display: none;" id="submitbuttonele" type="button" onClick="savefeedbackdata();" name="process" class="submit">Submit</button></div>
							</div>
							<!-- /bottom-wizard -->
						</form>
					
					<?php }else{ echo '<h3>You have already given feedback for this booking.</h3>'; } ?>
					</div>
					<!-- /Wizard container -->
				</div>
			</div><!-- /Row -->
		</div><!-- /Form_container -->
	</main>
	
	<footer id="home" class="clearfix">
		<p>© <?php echo date('Y'); ?> GarageWorks</p>
		 
	</footer>
	<!-- end footer-->

	<div class="cd-overlay-nav">
		<span></span>
	</div>
	<!-- cd-overlay-nav -->

	<div class="cd-overlay-content">
		<span></span>
	</div>
	<!-- cd-overlay-content -->

	 

	 

	 

	<!-- SCRIPTS -->
	<!-- Jquery-->
	<script src="<?= base_url() ?>assets/feedback/js/jquery-3.2.1.min.js"></script>
	<!-- Common script -->
	<script src="<?= base_url() ?>assets/feedback/js/common_scripts.js"></script>
	<!-- Wizard script -->
	<script src="<?= base_url() ?>assets/feedback/js/review_wizard_func.js"></script>
	<!-- Menu script -->
	<script src="<?= base_url() ?>assets/feedback/js/velocity.min.js"></script>
	<script src="<?= base_url() ?>assets/feedback/js/main.js"></script>
	<!-- Theme script -->
	<script src="<?= base_url() ?>assets/feedback/js/functions.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
 
	  $('form input').on('keypress', function(e) {
    return e.which !== 13;
});
		
			
			 $.fn.extend({
        iosCheckbox: function() {
            this.destroy = function(){
                $(this).each(function() {
            		$(this).next('.ios-ui-select').remove();
                });
            };
            
            if ($(this).attr('data-ios-checkbox') === 'true') {
                return;
            }
            
            $(this).attr('data-ios-checkbox', 'true');
            
            $(this).each(function() {
                /**
                 * Original checkbox element
                 */
                var org_checkbox = $(this);
                /**
                 * iOS checkbox div
                 */
                var ios_checkbox = jQuery("<div>", {
                    class: 'ios-ui-select'
                }).append(jQuery("<div>", {
                    class: 'inner'
                }));

                // If the original checkbox is checked, add checked class to the ios checkbox.
                if (org_checkbox.is(":checked")) {
                    ios_checkbox.addClass("checked");
                }
                
                // Hide the original checkbox and print the new one.
                org_checkbox.hide().after(ios_checkbox);
                
                if (org_checkbox.is(":disabled")){
                   // In case the original checkbox is disabled don't register the click event.
                	 return ios_checkbox.css('opacity','0.6');
                }
                
                // Add click event listener to the ios checkbox
                ios_checkbox.click(function() {
                    // Toggel the check state
                    ios_checkbox.toggleClass("checked");
                    // Check if the ios checkbox is checked
                    if (ios_checkbox.hasClass("checked")) {
                        // Update state
                        org_checkbox.prop('checked', true);
						$("#moredetails").show('slow');
						$( "#issueradioyes" ).prop( "checked", true );
                    } else {
                        // Update state
                        org_checkbox.prop('checked', false);
						$("#moredetails").hide();
						$( "#issueradioyes" ).prop( "checked", false );
                    }
                    
                    // Run click even in case it was registered to the original checkbox element.
                	org_checkbox.click();
                });
            });
            return this;
        }
    });
 

		 
 $(".ios").iosCheckbox();
   
		
		
		
		$('.forward').on('click', function(e) {
    e.preventDefault();
			ajaxfeedbackdata();
		  var ratingscheck = $('input[name="feedback"]:checked').val();
			
				if (ratingscheck == 1 || ratingscheck == 2) {
				$('#finalstep1_2').show();
				$('#finalstep3_5').hide();
				$('#submitbuttonele').hide();
					
				}else if (ratingscheck == 3 || ratingscheck == 4 || ratingscheck == 5) {
				$('#finalstep1_2').hide();
				$('#finalstep3_5').show();
				
					if($('.lastpage').is(':visible')){ 
					$('#submitdiv').show();
					$('#submitbuttonele').show();	
					}
				}	
			 
			
			
			if (ratingscheck == 1 || ratingscheck == 2 || ratingscheck == 3) {
			$('.step3').html('<div id="step123"><h3 class="main_question"><strong style="display: none;"><?php echo $n.'/'.$tot;  ?></strong><span class="detailsheading">What went wrong?</span></h3> <div class="row"> <div class="col-md-12"> <div class="form-group"> <input required name="issue[]" type="checkbox" class="icheck icheckbox_square-grey required" value="Booking Experience" /> <label>Booking Experience</label><br><input required name="issue[]" type="checkbox" class="icheck icheckbox_square-grey required" value="Mechanic was rude" /><label>Mechanic was rude</label><br><input required  name="issue[]" type="checkbox" class="icheck icheckbox_square-grey required" value="Mechanic was late" /><label>Mechanic was late</label><br><input required name="issue[]" type="checkbox" class="icheck icheckbox_square-grey required" value="Service Quality not good" /><label>Service Quality not good</label><br><input required name="issue[]" type="checkbox" class="icheck icheckbox_square-grey required" value="Washing Quality not good" /><label>Washing Quality not good</label><br><input required name="issue[]" type="checkbox" class="icheck icheckbox_square-grey required" value="Spoiled my parking" /><label>Spoiled my parking</label><br><input required name="issue[]" type="checkbox" class="icheck icheckbox_square-grey required" value="Serviced too quickly" /><label>Serviced too quickly</label><br><input required name="issue[]" type="checkbox" class="icheck icheckbox_square-grey required" value="Services are expensive" /><label>Services are expensive</label></div></div></div>');
				if($('#step123').is(':visible')){
				$('input[name="issue[]"]').valid();
				}
			 }else if (ratingscheck == 4 || ratingscheck == 5) {
			
				 
				 if (ratingscheck == 4){
					 var ratingof4 = '<div class="row ifrate4"> <div class="col-md-6"><div class="form-group"><label>Any tips on how we can score 5?</label></div></div><div class="col-md-6"><div class="form-group"><textarea rows="4" cols="4" name="tips" class="form-control"></textarea></div></div></div>';
				 }else{
					 var ratingof4 = ' ';
				 }
				 var ratingabv4 = '<h3 class="main_question"><strong style="display: none;"><?php echo $n.'/'.$tot;  ?></strong><span class="detailsheading">Can you refer us to your friends?</span></h3>'+ratingof4+'<!-- /row --><div class="row"><div class="col-md-6"><div class="form-group"><input type="text" name="ref_name_1" class="form-control ref_name" placeholder="Reference Name 1" /></div></div><div class="col-md-6"><div class="form-group"><input type="number"  name="ref_no_1" class="form-control ref_no" placeholder="Reference Number 1" /></div></div></div><!-- /row --><div class="row"><div class="col-md-6"><div class="form-group"><input type="text" name="ref_name_2" class="form-control ref_name" placeholder="Reference Name 2" /></div></div><div class="col-md-6"><div class="form-group"><input type="number" name="ref_no_2" class="form-control ref_no" placeholder="Reference Number 2" /></div></div></div><!-- /row --><div class="row"><div class="col-md-6"><div class="form-group"><input type="text" name="ref_name_3" class="form-control ref_name" placeholder="Reference Name 3" /></div></div><div class="col-md-6"><div class="form-group"><input type="number" name="ref_no_3" class="form-control ref_no" placeholder="Reference Number 3" /></div></div></div><!-- /row --><div class="row"><div class="col-md-6"><div class="form-group"><label>Can we paste this review on Google?</label></div></div><div class="col-md-6"><div class="form-group"><select name="google_reviews" class="form-control"><option value=""></option><option value="yes">Yes</option><option value="no">No</option></select>	</div></div> </div><!-- /row --><br>';
				 
			$('.step3').html(ratingabv4);	
			
				 
				// $('.step4').show();
			} 
			 	
			//if (ratingscheck == 4 || ratingscheck == 5) {
//			$('.step4').show('slow');
//			}else{
//			$('.step4').remove();		
//			}
			
			//if (ratingscheck == 4) {	
//			$('.ifrate4').show('slow');
//			}else{	
//			$('.ifrate4').hide('slow');
//			}
//		  
    	 
});
		
	});	
		
		function ajaxfeedbackdata(){
		 
 		var formValues= $('#wrapped').serialize(); 
      $.ajax({
     url:'<?= base_url() ?>feedbacks/savefeedbackdata/',
     method: 'POST',
     data: formValues,
     dataType: 'json',
     success: function(response){ 
		 
		 if(response.recorded == '1'){
			 
			  $('#feedback_id').val(response.feedback_id);
			  //$('#lastquestiondiv').show();
			  //$('#thankyoudiv').html('Thank you for your valuable feedback!');
			 		   
		 }else{
			 $('#feedback_id').val(response.feedback_id); 
			 //$('#otperror').html('');
		 }
		 
     }
   });
		 
		}
		
		function savefeedbackdata(){
		 
 		var formValues= $('#wrapped').serialize(); 
      $.ajax({
     url:'<?= base_url() ?>feedbacks/savefeedbackdata/',
     method: 'POST',
     data: formValues,
     dataType: 'json',
     success: function(response){ 
		 
		 if(response.recorded == '1'){
			 $('#bottom-wizard').hide();
			  $('#feedback_id').val(response.feedback_id);
			  $('#lastquestiondiv').hide();
			 	$('#thankyoudiv').show();
			 
			  $('#thankyoudiv').html('<b>Thank you for your valuable feedback!</b>');
			 		   
		 }else{
			 $('#feedback_id').val(response.feedback_id); 
			  $('#lastquestiondiv').hide();
			 	$('#thankyoudiv').show();
			 //$('#otperror').html('');
		 }
		 
     }
   });
		 
		}
	</script>
</body>
</html>