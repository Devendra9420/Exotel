 
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM box-->
        <div class="box">
            <div class="box-title">
                <h4 style="padding-left: 10px;"><i class="icon-reorder"></i>Assign Mechanic</h4>
						<span class="tools">
							<a href="javascript:;" class="icon-chevron-down"></a>
						</span>
            </div>
            <div class="box-body">
                <!-- BEGIN FORM-->

                    <?php echo form_open('bookings/show_zone_bookings',array('class'=>"form-horizontal form-bordered form-validate",'method'=>'post'))?>
                    <div class="row">
                        <div class="col-lg-5">
                            <label class="control-label">Booking Date</label>
                            <input type="date" data-ad-format="" autocomplete="off" class="form-control" name="bookingDate">
                        </div>
                        <div class="col-md-5">
                           <div class="form-group" id="city_form">
                              <label class="control-label">City<span class='text-danger'>*</span></label>
                              <select class="form-control select2" name="city" id="city">
							  <?php echo city_dropdown($city); ?>
							  </select> 
                           </div>
                           
                      </div> 
                    </div>
                    <br>
                    <div class="form-actions">
                        <input type="hidden" name="Action" value="Search">
                        <button type="submit" class="btn btn-success" >Show Bookings</button>
                        <button type="reset" class="btn">Cancel</button>
                    </div>
                </form>
                <!-- END FORM-->
                <?php if (isset($_REQUEST['Action']) == "Search"){ ?>

                    
 
                     
                    <br>
                <div id="printableArea">
                    


                    <div class="row ">
                        <div class="col-md-12">

                             
                            <hr>

                            <main class="invoice_report">
								 
                                <h4>Booking Date: <strong><?php echo $bookingDate ?></strong> |  Unassigned Total: <?php echo $totalUnassigned; ?> </h4>
                                <br/>
                                <br/>

                                <?php
                                $key = 0;
                                ?>
								<?php $k = 1; ?>
								
								 
								<!-- START ACCORDIONS --->
								
								<div class="box-group" id="accordion">			
                                <?php 
																  
																  
									 if (!empty($zones)){  
								foreach ($zones as $zone_name) { 
									
									$zone=$zone_name->zone;
									//$thiszone_id_list = get_area_details('DISTINCT zone', array('city'=>$city), 'yes')
//										
//										$this->db->query("SELECT * FROM zone WHERE zone='".$zone->zone."'")->result_array();
//									
//									$zoneidarray = array();
//									
//
// 				
//									foreach ($thiszone_id_list as $thiszone_ids){
//										array_push($zoneidarray,$thiszone_ids['id']);
//									}
									
									 
									
									//$queryZoneIDArray = join("','",$zoneidarray);
									 
									$wher_param = array('zone_id'=>$zone, 'customer_city'=>$city, 'service_date'=>$bookingDate, 'status !='=>"Completed", 'status !='=>"Cancelled", 'assigned_mechanic <'=>1);
	 $thisbooking_Q = 	$this->Bookings->getbooking_conditional('Unassigned',  $wher_param);
									
								  	 
									$thisbooking = $thisbooking_Q['dump'];
									
								 $TotalBookings =  $thisbooking_Q['count'];
									
									if( $TotalBookings>0){
									 echo form_open('bookings/assign_mechanic_Byzone',array('class'=>"form-horizontal form-bordered form-validate",'method'=>'post'));
									?>
								
	 								<div class="card">
                  <div class="card-header">
					   
                    <h4>Zone: <?php echo $zone; ?> (<?php echo $TotalBookings; ?>)</h4>
                    <div class="card-header-action">
                      <a data-collapse="#zone_<?php echo $k; ?>" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                  </div>
                  <div class="collapse" id="zone_<?php echo $k; ?>">
                    <div class="card-body">
						
						
		<div class="box-body">
		   				<div class="col-md-12 text-right" style="margin-bottom: 10px;">
                          <button type="submit" class="btn btn-success" >Assign Mechanics</button>
                         
         				</div> 
		  		<div class="col-md-12 text-right" style="margin-bottom: 10px;">
			  
			  
                     <table class="table table-striped table-hover table-bordered dataTable" id="zoneBookingsTable_<?php echo $k; ?>"
                           aria-describedby="editable-sample_info">
                                        <thead>
                                        <tr style="background-color: #ECECEC">
                                            <th class="no text-right">#</th>
                                            <th class="desc">Name</th>
											<th class="desc">Area</th> 
                                            <th class="desc">Booking Date/Time</th>
                                            <th class="desc">Category</th>
                                            <th class="desc">Jobcard Status</th>
											<td class="desc ">Assign</th>
                                        </tr>
                                        </thead>
                                        <tbody>
											<?php $zb = 1 ?>
							 
                                <?php if (!empty($thisbooking)){ 
								foreach ($thisbooking as $book_det){ ?>
											<input name="zone_id[]" type="hidden" value="<?php echo $book_det->zone_id; ?>" />
											<tr>
                                                <td class="no text-left"><?php echo $book_det->booking_id; ?><input name="zone_serialno[]" type="hidden" value="<?php echo $zb; ?>" /></td>
												<td class="desc"><?php echo $book_det->customer_name; ?>
													<input name="booking_id[]" type="hidden" value="<?php echo $book_det->booking_id; ?>" /></td>
												<?php  
																	
														$getjobcard = $this->Bookings->getbooking($book_det->booking_id);	
																	
														$jobCard = $getjobcard['jobcard'];
																	
																	
														if(!empty($jobCard)){
															if($jobCard->status=='New Jobcard Created'){
																$jbStatus = 'Created';
															}elseif($jobCard->status=='Jobcard Edited'){
																$jbStatus = 'Edited';
															}elseif($jobCard->status=='Jobcard Approved'){
																$jbStatus = 'Approved';
															}else{
																$jbStatus = $jobCard->status;
															}
															$jobCardStatus = $jbStatus;
														}else{
															$jobCardStatus = "Not Created";
														}			
												?>
												
                                                <td class="desc"><?php echo $book_det->customer_area; ?></td> 
                                                <td class="desc"><?php echo convert_date($book_det->service_date); echo '<br>'.$book_det->time_slot; ?></td>
												<td class="desc"><?php echo get_service_category($book_det->service_category_id); ?></td>
                                                 
                                                <td class="desc"><?php echo $jobCardStatus; ?></td>
												 
												<td class="desc"> 
													<?php if($jobCardStatus != "Not Created"){  ?>
													<?php if($book_det->status != "Completed" || $book_det->status != "Cancelled"){  ?>
													
												 
													
													<select class="form-control select2" style="width: 100%;" name="mechanic[]" id="mechanic">
							  <option value="">Select Mechanic</option>
								  <?php foreach($mechanics as $mechanic){ 
														if($mechanic->city == $book_det->customer_city){ 
														?>   
									<?php if($book_det->assigned_mechanic==$mechanic->id){ $selected='selected'; }else{ $selected=''; } ?>
														
								<option <?php echo $selected; ?> value="<?php echo $mechanic->id; ?>"><?php echo $mechanic->name; ?></option>
						<?php } 
												}
														?> 
							  </select>
												<?php }else{  
													
													$mechanic_name = get_service_providers(array('id'=>$book_det->assigned_mechanic), 'name');
														
													 echo $mechanic_name;	
												
												}
												}else{
													echo '<select class="form-control" style="width: 100%;" name="mechanic[]" id="mechanic"><option <option value="">NA</option></select>';
												} 
																	
																	
													?>
												
												</td>
                                            </tr>
					</form>
                                            <?php $zb++;
								}
								}
									 				  
											?>
      
                                </tbody>
                                    </table>
							 </div>
							 </div>
					  
                    </div>
                    <div class="card-footer">
                       
                    </div>
                  </div>
                </div>
								
								
								
								<?php $k++; 
									unset($zoneidarray);
										
									}
								}
								}
							?>
								
	 
</div>
								
								
		<!-- END ACCORDIONS --->						
								
								
								
								
								
								
								
								
								
								
							 


                            </main>
                            <hr>
                             


                        </div>
                    </div>

                </div>
<?php }?>

            </div>
        </div>
        <!-- END SAMPLE FORM box-->
    </div>
</div>

