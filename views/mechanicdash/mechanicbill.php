 <div class="section-body">
            <h2 class="section-title">Mechanic Dash</h2>
            <p class="section-lead">  
            </p>

 <?php if(empty($action)){  ?>
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header text-right">
               <h2 class="section-title">Select Mechanic</h2>  
            </div>
            <div class="box-body">
                <!-- BEGIN FORM-->
                <?php echo form_open('mechanicdash/mechanicbill',array('class'=>"form-horizontal form-bordered form-validate",'method'=>'post'))?>


                <div class="row">
                        <div class="col-lg-12">
                            <label class="control-label">Select Mechanic</label>
                            <select class="form-control select2" style="width: 100%;" name="mechanic_id" id="mechanic_id">
							  <option value="">Select Mechanic</option>
								  <?php foreach($mechanics as $mechanic){  
														?>   
								<option value="<?php echo $mechanic->id; ?>"><?php echo $mechanic->name; ?></option>
						<?php  
												}
														?> 
							  </select>
                        </div> 
                    </div>
                    <br>
                    <div class="form-actions">
                        <input type="hidden" name="action" value="search"> 
                        <button type="submit" class="btn btn-success" >Submit</button>
                        <button type="reset" class="btn">Cancel</button>
                    </div>
                </form>
                <!-- END FORM-->
                 
 

            </div>
            </div>
        </div>

    </div> 

<?php }else{  ?>
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header text-right">
                 
            </div>
            <div class="box-body">
                <!-- BEGIN FORM-->
                <?php echo form_open('mechanicdash/mechanicbill',array('class'=>"form-horizontal form-bordered form-validate",'method'=>'post'))?>


                <div class="row">
                        <div class="col-lg-6">
                            <label class="control-label">START DATE</label>
                            <input type="date" value="<?php echo $start_date; ?>" class="form-control" name="start_date">
                        </div>
                        <div class="col-lg-6">
                            <label class="control-label">END DATE</label>
                            <input type="date" value="<?php echo $end_date; ?>" class="form-control" name="end_date">
                        </div>
                    </div>
                    <br>
                    <div class="form-actions">
                        <input type="hidden" name="action" value="Search">
                        <button type="submit" class="btn btn-success" >Show Report</button>
                        <button type="reset" class="btn">Cancel</button>
                    </div>
                </form>
                <!-- END FORM-->
                <?php //if (isset($_REQUEST['Action']) == "Search"){ ?>
 
                    <br>
                    <br>
                
                     
                    <div class="row ">
                        <div class="col-md-12">

                           
                            <hr>

                            <main class="mechanic_report">

                                <h4>Mechanic Name: <?php echo $mechanic->name; ?> | Dashboard from: <strong><?= $start; ?></strong> to <strong><?= $end; ?></strong>
                                </h4>
                                <br>
                                <br>
								<table class="table table-striped table-hover table-bordered datatable"  aria-describedby="editable-sample_info">
                                        <thead> 
                                        <tr style="background-color: #ECECEC">
                                            <th class="">#</th>
                                            <th class="desc">Booking Id</th>
                                            <th class="unit text-left">Customer</th>
                                            <th class="qty text-left">Channel</th>
                                            <th class="total text-left">Make</th>
                                            <th class="total text-left">Model</th>
                                            <th class="total text-left">Service Date</th>
                                            <th class="total text-left">Service Category</th>
                                            <th class="total text-left">Invoice Amt</th>
											<th class="total text-left">Line Items</th>
                                        </tr>
                                        </thead>
                                        <tbody>
											
          <?php 
		 $total = '';
          $quantity = '';
          $i = 1;
		if($bookings)	
          foreach ($bookings as $book): 
                      $no_of_new = 0; 

          $newitems = $this->Bookings->getbooking_jobcard_details($book->booking_id,array('status'=>'Active','booking_id'=>$book->booking_id,'aft_inspection_done'=>1));	 


                      $item_line_id = array();
                      $count = 0;	
						if($newitems)
                   foreach($newitems as $item){
                       $item_line_id[$count++] = $item->id; 
                       $no_of_new++;
                   }

                       $make_name   = get_make($book->vehicle_make);
                       $model_name = get_model($book->vehicle_model);						 
                      $make_name  = get_service_category($book->service_category_id);

                      $booking_details = $this->Bookings->getbooking_details($book->booking_id);
			 
			if(!empty($booking_details->actual_amount)){
				$invoice_val = $booking_details->actual_amount;
			}else{
				$invoice_val = 0;
			}
											
                      $jobcard_details_line_id = '';
                      foreach($item_line_id as $itm_aar){
                          $jobcard_details_line_id .= $itm_aar.'|';

                      }
																  
								?>  
                                        <tr>
                                            <td align=""><?= $i; ?></td>
                                            <td align=""><?= $book->booking_id; ?></td> 
                                            <td align=""><?= $book->customer_name; ?></td> 
                                            <td align=""><?= $book->customer_channel; ?></td>
                                            <td align=""><?= $make_name; ?></td>
                                            <td align=""><?= $model_name; ?></td>
                                            <td align=""><?= date('d-m-Y', strtotime($book->service_date)); ?></td>
                                            <td align=""><?= get_service_category($book->service_category_id); ?></td>
                                            <td align=""><?= $invoice_val; ?></td>
											<td align=""><?php if(!empty($jobcard_details_line_id)){ ?> <a href="javascript:showtheitems(<?= $book->booking_id; ?>);"><?= $no_of_new; ?></a> <?php }else{ echo $no_of_new; } ?></td>
                                             
                                        </tr> 
                                    <?php $i++; endforeach; ?>
									</tbody>

                                        

                                    </table>
                             </main>
                            <hr>
                            <footer class="text-center"> 
                            </footer> 
                        </div>
                    </div> 
                
            </div>
            </div>
        </div> 
    </div>
 <div aria-hidden="true" aria-labelledby="ShowNewItemsAdded" role="dialog" tabindex="-1" id="ShowNewItemsAdded" class="modal fade modalselect2" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">New Items Added</h4>
                </div>
                <div class="modal-body modal-edit" id="newitemsbox">
                </div>
                <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">  
	 function showtheitems(booking_id) { 
     $.ajax({
     url:'<?=base_url()?>index.php/bookings/getnewitems/',
     method: 'POST',
     data: {booking_id: booking_id},
     dataType: 'html',
     success: function(response){ 
		 $('#newitemsbox').html(response); 
		 $('#ShowNewItemsAdded').modal('show');   
        },
        error: function() {
            alert('Error');
        }
    });
    return false;
}  
</script>

<?php } ?>
</div>
