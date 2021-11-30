 
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
						 
                        <div class="col-4 invoice-block">
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
						
						
						
						<div class="col-4 invoice-block">
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
						 
						<div class="col-6 text-right">
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
					   <div class="col-6 text-right">
						
						 
                            
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
					
					
					 
                        <div class="col-xs-12">
						
                                 	
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
				<button onClick="javascript:printinvoice(printarea);" id="printbutton" type="button" class="btn btn-lg btn-primary text-white hidden-print margin-bottom-5"> Print
                                <i class="fa fa-print"></i>
                            </button>
							
					</div></div>			
				
				
            </div>
        </div>
    </div>
</div>

		
	
	
	</div>
</section>

  
 


