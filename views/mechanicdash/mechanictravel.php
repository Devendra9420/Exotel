 <div class="section-body">
            <h2 class="section-title">Mechanic Travel</h2>
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
                <?php echo form_open('mechanicdash/mechanictravel',array('class'=>"form-horizontal form-bordered form-validate",'method'=>'post'))?>


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
                <?php echo form_open('mechanicdash/mechanictravel',array('class'=>"form-horizontal form-bordered form-validate",'method'=>'post'))?>


                <div class="row">
                        <div class="col-lg-12">
                            <label class="control-label">Date Range</label>
                            <select class="form-control select2" required id="daterange_m" name="daterange_m">
							<option value="">Select</option>
							<option value="current">This Month</option>
							<option value="last_month">Last Month</option>
							<option value="last_3_month">Last 3 Month</option>
							</select>
                        </div> 
                    </div>
                    <br>
                    <div class="form-actions">
                        <input type="hidden" name="action" value="Search">
						<input type="hidden" name="mechanic_id" value="<?php echo $mechanic_id; ?>">
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
								
                                <h4>Mechanic Name: <?php echo $mechanic->name; ?> | Travel from: <strong><?= date('d-m-Y', strtotime($start_date1)); ?></strong> to <strong><?= date('d-m-Y', strtotime($end_date1)); ?></strong>
                                </h4>
                                <br>
                                <br>
								 
								<?php $travel = $this->Mechanicdash->get_mechanic_travel($mechanic_id, $start_date1, $end_date1); ?> 
                                
								<h4>Total Distance Travelled Today: <?php echo number_format($travel['travel_today'],2); ?> Kms</h4>
								<table class="table table-striped table-hover table-bordered dataTable"  aria-describedby="editable-sample_info">
                                        <thead> 
                                        <tr style="background-color: #ECECEC">
                                             
                                            <th class="desc">Booking Id</th>
                                            <th class="unit text-center">Service Date</th> 
                                            <th class="unit text-center">Distance Travelled</th>
                                        </tr>
                                        </thead>
                                        <tbody>
											
                                <?php 
											
								  foreach($travel['total_bookings'] as $booking){
									  
									  echo $booking;
									  
								  } 	 
					     			  
								?>  
      
		<tr> <td cellspan="2" align="">Avg Distance</td> <td align=""><?= number_format($travel['avg_travel'],2); ?> Kms</td></tr>		 
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
<?php } ?>
</div>
