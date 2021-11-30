 
      <!-- Main Content -->
      <div class="section-body">
		   
		  
<?php if(empty($action)){  ?> 
		  <div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header text-right">
               <h2 class="section-title">Select Mechanic</h2>  
            </div>
            <div class="box-body">
                <!-- BEGIN FORM-->
                <?php echo form_open('dist/mechanic_dash',array('class'=>"form-horizontal form-bordered form-validate",'method'=>'post'))?>


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


			 <!-- BEGIN FORM-->
                <?php echo form_open('dist/mechanic_dash',array('class'=>"form-horizontal form-bordered form-validate",'method'=>'post'))?>


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
						<input type="hidden" name="mechanic_id" value="<?php echo $mechanic_id; ?>">
                        <button type="submit" class="btn btn-success" >Show Report</button>
                        <button type="reset" class="btn">Cancel</button>
                    </div>
                </form>
                <!-- END FORM-->

				<div class="row mt-5">
					
				<h4>Mechanic Name: <?php echo $mechanic->name; ?> | Dashboard from: <strong><?= date('d-m-Y', strtotime($start_date1)); ?></strong> to <strong><?= date('d-m-Y', strtotime($end_date1)); ?></strong>
                </h4>
					
				<?php $perfom = $this->Mechanicdash->get_mechanic_performance($mechanic_id, $start_date1, $end_date1); ?>
					
				<div class="col-12 col-md-12 col-lg-5">
                <div class="card profile-widget">
                  <div class="profile-widget-header">                     
                    <img alt="image" src="<?php echo $mechanics->pic; ?>" class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">City</div>
                        <div class="profile-widget-item-value"><?php echo @$mechanics->city; ?></div>
                      </div>
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Skill Category</div>
                        <div class="profile-widget-item-value"><?php echo @$mechanics->category; ?></div>
                      </div>
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">HUB</div>
                        <div class="profile-widget-item-value">Pune</div>
                      </div>
                    </div>
                  </div>
                  <div class="profile-widget-description">
                    <div class="profile-widget-name"><?php echo $mechanics->name; ?><div class="text-muted d-inline font-weight-normal"><div class="slash"></div> Id: GWMEC_12<?php echo $mechanics->id; ?></div>
					  <div class="text-right">
						 <a target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo $mechanics->mobile; ?>" class="btn btn-icon btn-dark mr-1">
                      <i class="fab fa-whatsapp"></i>
                    </a>
                    <a target="_blank" href="tel:+91<?php echo $mechanics->mobile; ?>" class="btn btn-icon btn-dark mr-1">
                      <i class="fa fa-phone"></i>
                    </a>
					  </div>
					  </div> 
					 <p>Address: <?php echo $mechanics->address; ?> </p>
					   
			 <div class="card card-statistic-2">
                <div class="card-stats">
                  <div class="card-stats-title">Total Cases 
                  </div>
                  <div class="card-stats-items">
                    <div class="card-stats-item">
                      <div class="card-stats-item-count"><?php echo @$perfom['mechanic']['totalcase']; ?></div>
                      <div class="card-stats-item-label">This Mechanic</div>
                    </div>
                    <div class="card-stats-item">
                      <div class="card-stats-item-count"><?php echo @$perfom['gw_overall']['totalcase']; ?></div>
                      <div class="card-stats-item-label">Total Cases</div>
                    </div>
					 
                  </div>
                </div>
				 <?php 
			
					if(!empty($perfom['mechanic']['total_complaints'])){
						if($perfom['mechanic']['total_complaints']>0){
							$complaint_bg = 'danger'; 
							$complain_icon = 'frown';
						}else{
							$complaint_bg = 'success';  
							$complain_icon = 'smile';
						} 
						$complaint_count = $perfom['mechanic']['total_complaints'];
					}else{
							$complaint_bg = 'success';  
							$complain_icon = 'smile';
							$complaint_count = 0;
					} 
				?>
                <div class="card-icon shadow-primary bg-<?php echo $complaint_bg; ?>">
                  <i class="fas fa-<?php echo $complain_icon; ?>"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Complaints</h4>
                  </div>
                  <div class="card-body">
                    <?php echo $complaint_count; ?>
                  </div>
                </div>
              </div>
			   
					  
                  </div>
                  <div class="card-footer text-center">
                     
                   
                     
                  </div>
                </div>
              </div>	
					
					
				 <div class="col-12 col-md-12 col-lg-7 mt-3">
				  
			 <div class="row">
				 
            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
			<a href="#">  	
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="fas fa-rupee-sign"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Avg time (Per Case)</h4>
                  </div>
                  <div class="card-body"> 
                   <?php echo round(@$perfom['mechanic']['avgtime_percase']); ?><small> mins</small><br>
					<small>Overall: <?php echo round(@$perfom['overall']['avgtime_percase']); ?> mins</small>  
                  </div>
                </div>
              </div>
			</a>	
            </div>
				  
            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
			<a href="#">  	
              <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                  <i class="fas fa-motorcycle"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Avg Addt Item Amt</h4>
                  </div>
                  <div class="card-body">
                   <?php echo number_format(@$perfom['mechanic']['avgbill_newitems'],2); ?><br>
					<small>Overall: <?php echo number_format(@$perfom['overall']['avgbill_newitems'],2); ?></small>    
                  </div>
					 
                </div>
              </div>
			</a>	
            </div>
			  
			  <div class="col-lg-6 col-md-6 col-sm-6 col-6">
			<a href="#">  	
              <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                  <i class="fas fa-stethoscope"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Avg Billing Amt</h4>
                  </div>
                  <div class="card-body">
                   <?php echo number_format(@$perfom['mechanic']['avgbill_total'],2); ?> <br>
					  <small>Overall: <?php echo number_format(@$perfom['overall']['avgbill_total'],2); ?></small>    
                  </div>
					 
                </div>
              </div>
			</a>	
            </div>
			  
			  <div class="col-lg-6 col-md-6 col-sm-6 col-6">
			<a href="#">  	
              <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                  <i class="fas fa-star"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Avg travel time / km</h4>
                  </div>
                  <div class="card-body">
                   <?php echo @$perfom['mechanic']['avg_travel_km']; ?> <br>
					  <small>Overall: <?php echo @$perfom['overall']['avg_travel_km']; ?></small>      
                  </div>
					 
                </div>
              </div>
			</a>	
            </div>
				  
				   </div> 
			  
			  </div> 
					
				</div>	
          
          <div class="row" style="display: none;">
			 <div class="col-lg-8 col-md-12 col-12 col-sm-12">
              <div class="card">
                <div class="card-header">
                  <h4>Case Tracker</h4>
                  <div class="card-header-action">
                    
                  </div>
                </div>
                <div class="card-body">
                   
					 
                  	<div class="table-responsive">
                <table class="table table-striped" id="listtable">
                    <thead>
                    <tr role="row">
                        <th>Booking Id
                        </th>
                        <th>
                            City
                        </th>
                        <th>
                            Mobile
                        </th> 
						<th>Time
                        </th> 
						<th>Mechanic
                        </th>
						<th>Locked
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                     
							 
                
                    </tbody>
                </table>
				</div>
                   
                    
                  
                
					
					
                </div>
              </div>
            </div>
			  
            <div class="col-lg-4 col-md-12 col-12 col-sm-12">
              <div class="card">
                <div class="card-header">
                  <h4>Booking Calendar</h4>
                  <div class="card-header-action">
                    
                  </div>
                </div>
                <div class="card-body">
                   
					 
                  
                   
                    <div class="fc-overflow">                            
                      <div id="bookingCalendar"></div>
                    </div>
                  
                
					
					
                </div>
              </div>
            </div>
            
          </div> 


<?php } ?>
      </div> 
 

