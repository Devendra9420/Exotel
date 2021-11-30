 
      <!-- Main Content -->
      <div class="section-body">
		   <h2 class="section-title">Performance Dashboard</h2>
            <p class="section-lead"> 
            </p>
		  
           <div class="row mb-5"> 
			<div class="col-12">	
			 <?php if(!empty($this->rbac->createPermission_custom)){ echo $this->rbac->createPermission_custom; }  ?> 
			<span class="pl-5"></span>
			 <?php if(!empty($this->rbac->deletePermission_custom)){ echo $this->rbac->deletePermission_custom; }  ?> 
			</div>	 
		   </div>	   
          <div class="row">
			  
			  
			  
			  <div class="col-lg-12 col-md-12 col-sm-12 col-12">
				  
			 <div class="row">	  
            <div class="col-lg-4 col-md-4 col-sm-4 col-4">
			<a href="#">  	
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="fas fa-rupee-sign"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Billing</h4>
                  </div>
                  <div class="card-body">
                   <?php echo $this->Dashboard->total_billing(); ?> 
                  </div>
                </div>
              </div>
			</a>	
            </div>
				  
            <div class="col-lg-4 col-md-4 col-sm-4 col-4">
			<a href="#">  	
              <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                  <i class="fas fa-motorcycle"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Completion Rate <small>Bookings Completed / Bookings Received</small></h4>
                  </div>
                  <div class="card-body">
                   <?php echo $this->Dashboard->booking_completion_ratio(); ?>
                  </div>
					 
                </div>
              </div>
			</a>	
            </div>
			  
				 <div class="col-lg-4 col-md-4 col-sm-4 col-4">
			<a href="#">  	
              <div class="card card-statistic-1">
                <div class="card-icon shadow-primary bg-danger"> 
                  <i class="fas fa-frown"></i> 
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>No. of Complaints:</h4>
                  </div>
                  <div class="card-body">
                  Open: <?php echo $this->Dashboard->count_complaints('open'); ?><br>
					  <small>Re-Opened: <?php echo $this->Dashboard->count_complaints('reopened'); ?></small>
                  </div>
					 
                </div>
              </div>
			</a>	
            </div>
				 
			  <div class="col-lg-4 col-md-4 col-sm-4 col-4">
			<a href="#">  	
              <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                  <i class="fas fa-stethoscope"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Diagnosis Accuracy <small>Jobcard Created v/s Invoiced Items</small></h4>
                  </div>
                  <div class="card-body">
                   <?php //echo $this->Dashboard->complains_accuracy(); ?>
                  </div>
					 
                </div>
              </div>
			</a>	
            </div>
			  
			  <div class="col-lg-4 col-md-4 col-sm-4 col-4">
			<a href="#">  	
              <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                  <i class="fas fa-star"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Avg. Customer Rating:</h4>
                  </div>
                  <div class="card-body">
                   <?php echo $this->Dashboard->avg_ratings(); ?>
                  </div>
					 
                </div>
              </div>
			</a>	
            </div>
				 
				 
				  <div class="col-lg-4 col-md-4 col-sm-4 col-4">
			<a href="#">  	
              <div class="card card-statistic-1">
                <div class="card-icon bg-dark">
                  <i class="fas fa-wrench"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>No. of Pending Jobcards:</h4>
                  </div>
                  <div class="card-body">
                   <?php echo $this->Dashboard->no_pending_jobcards(); ?>
                  </div>
					 
                </div>
              </div>
			</a>	
            </div>
				 
				 
				  
				   </div> 
			  
			  </div> 
				
				<div class="col-lg-4 col-md-6 col-sm-6 col-12" style="display: none;">
			 <div class="card card-statistic-2">
                <div class="card-stats">
                  <div class="card-stats-title">Complaints 
                  </div>
                  <div class="card-stats-items">
                    <div class="card-stats-item">
                      <div class="card-stats-item-count"><?php echo $this->Dashboard->count_complaints('open'); ?></div>
                      <div class="card-stats-item-label">Open</div>
                    </div>
                   
					 <div class="card-stats-item">
                      <div class="card-stats-item-count"><?php echo $this->Dashboard->count_complaints('reopened'); ?></div>
                      <div class="card-stats-item-label">Re-Opened</div>
                    </div> 
                  </div>
                </div>
                <div class="card-icon shadow-primary bg-danger">
                  <i class="fas fa-frown"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Complaints</h4>
                  </div>
                  <div class="card-body">
                    <?php echo $this->Dashboard->count_complaints('open'); ?>
                  </div>
                </div>
              </div>
			  </div>
			  
			  
          </div>
          <div class="row">
			 <div class="col-lg-12 col-md-12 col-12 col-sm-12">
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
						<th>Stage
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
			  
            <div class="col-lg-4 col-md-12 col-12 col-sm-12" style="display: none;">
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
      </div> 
 

