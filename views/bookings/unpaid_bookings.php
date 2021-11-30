
 <div class="section-body">
            <h2 class="section-title">Unpaid Booking List<span class="text-right float-right"><a href="<?php echo base_url(); ?>bookings" class="btn btn-sm btn-info">Back</a></span></h2>
            <p class="section-lead">  
            </p>

	 
	 
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header text-right">
                 
            </div>
            <div class="box-body">
				<div class="table-responsive">
                <table class="table table-striped datatable" id="listtable">
                    <thead>
                    <tr role="row">
                        <th>Booking Id
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Mobile
                        </th> 
						<th>Service Date
                        </th> 
						<th>Channel
                        </th>
						<th>Service
                        </th>
						<th>Mechanic
                        </th>
						<th>Invoice Amount
						</th>
						<th>Stage
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                     
							<?php
								$i = 1;
								if($bookings)
									foreach($bookings as $booking){
										
										$booking_id = $booking->booking_id;
										$payments = $this->Bookings->getbooking_payments($booking_id);
										
										if($payments->payment_status='Issued' && !empty($payments->rz_payment_link)){ 
										$rz_payments = $this->Cart->check_payment_status($booking_id, $paymentlink_id); 
										$rz_payment_status = $rz_payments['payment_status'];
										}
										
										if(empty($rz_payment_status) || $rz_payment_status!='paid'){ 
											 
										
		 echo '<tr>';
		 echo '<td>'.$booking_id.'</td>';
		 echo '<td>'.$$booking->customer_name.'<input type="hidden" name="customer_mobile" id="customer_mobile_'.$i.'"  value="'.$booking->customer_mobile.'" /></td>';
		 echo '<td>'.$booking->customer_channel.'</td>';
		 echo '<td>'.convert_date($booking->service_date).'</td>';
		 echo '<td>'.get_service_category($booking->service_category_id).'</td>';
		 echo '<td>'.get_service_providers($booking->assigned_mechanic).'</td>';
		  if(!empty($payments->rz_payment_link)){
			echo '<td><input type="hidden" name="payment_link" id="payment_link_'.$i.'" value="'.$payments->rz_payment_link.'" />'; 
		 }else{
			echo '<td>'; 
		 } 									
		 echo $payments->estimated_amount.'</td>'; 
		 if(!empty($payments->rz_payment_link)){
		 echo '<td><button class="btn btn-info" type="button" onclick="resend_rz_link('.$i.');" name="sendlinktocustomer" id="sendlinktocustomer_'.$i.'">Resend Link</button></td>';
		 }else{
		echo '<td> NA </td>';	 
		 }
				echo '</tr>';
			$i++;			
									}
										
									}
						
							?>
                
                    </tbody>
                </table>
				</div>
            </div>
        </div>

    </div>
</div>

	 </div>

     
 