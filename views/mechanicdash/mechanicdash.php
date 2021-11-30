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
                <?php echo form_open('mechanicdash/mechanicdash',array('class'=>"form-horizontal form-bordered form-validate",'method'=>'post'))?>


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
                <?php echo form_open('mechanicdash/mechanicdash',array('class'=>"form-horizontal form-bordered form-validate",'method'=>'post'))?>


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

                                <h4>Mechanic Dashboard from: <strong><?= $start; ?></strong> to <strong><?= $end; ?></strong>
                                </h4>
                                <br>
                                <br>
								<table class="table table-striped table-hover table-bordered datatable"  aria-describedby="editable-sample_info">
                                        <thead> 
                                        <tr style="background-color: #ECECEC">
                                            <th class="">#</th>
                                            <th class="desc">Mechanic Name</th>
                                            <th class="unit text-left">Completed Cases</th>
                                            <th class="qty text-left">Ratings</th>
                                            <th class="total text-left">Avg. Ratings</th>
											<th class="total text-left">No of Late Arrivals</th>
                                        </tr>
                                        </thead>
                                        <tbody> 
                                <?php
								$i = 1; 
								if($mechanics)
                                foreach ($mechanics as $mec): 
								$completed_cases = $this->Mechanicdash->completed_cases($mec->id, $start_date1, $end_date1);	 
								$ratings = $this->Mechanicdash->mechanic_ratings($mec->id, $start_date1, $end_date1);	 
								$avg_rating=$ratings['avg_rating'];	
								$no_of_feedback=$ratings['no_of_feedback'];	 
								$late_bookings = $this->Mechanicdash->late_bookings($mec->id, $start_date1, $end_date1);	 
								?>  
                                        <tr>
                                            <td align=""><?= $i; ?></td>
                                            <td align=""><?= $mec->name; ?></td>
                                            <td align=""><?= $completed_cases; ?></td>
                                            <td align=""><?= $no_of_feedback; ?></td>
                                            <td align=""><?= number_format($avg_rating,2); ?></td>
                                            <td align=""><?= $late_bookings; ?></td> 
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
<?php } ?>
</div>
