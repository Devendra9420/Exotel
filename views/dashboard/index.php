<?php    //echo 'USER: '. json_encode($this->session->userdata); ?> 
      <!-- Main Content -->
      <div class="section-body">
           <div class="row mb-5"> 
			<div class="col-12">	
			 <?php if(!empty($this->rbac->createPermission_custom)){ echo $this->rbac->createPermission_custom; }  ?> 
			<span class="pl-5"></span>
			 <?php if(!empty($this->rbac->deletePermission_custom)){ echo $this->rbac->deletePermission_custom; }  ?> 
			</div>	 
		   </div>	   
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <a href="<?php if(!empty($this->rbac->readPermission_custom)){ echo $this->rbac->readPermission_custom.'1'; }else{ echo '#'; } ?>">  
			 <div class="card card-statistic-1">
                <div class="card-icon bg-secondary">
                  <i class="far fa-star-half"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>New Bookings</h4>
                  </div>
                  <div class="card-body">
                    <?php echo $this->Bookings->count_bookings('New Booking'); ?>
                  </div>
                </div>
              </div>
			  </a>		  
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <a href="<?php if(!empty($this->rbac->readPermission_custom)){ echo $this->rbac->readPermission_custom.'2'; }else{ echo '#'; } ?>">  
			<div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="far fa-star"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Assigned Bookings</h4>
                  </div>
                  <div class="card-body">
                    <?php echo $this->Bookings->count_bookings('Assigned'); ?>
                  </div>
					
                </div>
              </div>
			</a>	
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
			<a href="<?php if(!empty($this->rbac->readPermission_custom)){ echo $this->rbac->readPermission_custom.'3'; }else{ echo '#'; } ?>">  	
              <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                  <i class="fas fa-star-half-alt"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Ongoing Bookings</h4>
                  </div>
                  <div class="card-body">
                   <?php echo $this->Bookings->count_bookings('Ongoing'); ?> 
                  </div>
                </div>
              </div>
			</a>	
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
			<a href="<?php if(!empty($this->rbac->readPermission_custom)){ echo $this->rbac->readPermission_custom.'4'; }else{ echo '#'; } ?>">  	
              <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                  <i class="fas fa-star"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Completed</h4>
                  </div>
                  <div class="card-body">
                   <?php echo $this->Bookings->count_bookings('Completed'); ?>
                  </div>
					 
                </div>
              </div>
			</a>	
            </div>                  
          </div>
          <div class="row">
            <div class="col-lg-8 col-md-12 col-12 col-sm-12">
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
            <div class="col-lg-4 col-md-12 col-12 col-sm-12">
              <div class="card">
                <div class="card-header">
                  <h4>Recent Activities</h4>
                </div>
                <div class="card-body">             
                  <ul class="list-unstyled list-unstyled-border">
                    <li class="media">
                      <img class="mr-3 rounded-circle" width="50" src="<?php echo base_url(); ?>assets/img/avatar/avatar-1.png" alt="avatar">
                      <div class="media-body">
                        <div class="float-right text-primary">Now</div>
                        <div class="media-title">Farhan A Mujib</div>
                        <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</span>
                      </div>
                    </li>
                    <li class="media">
                      <img class="mr-3 rounded-circle" width="50" src="<?php echo base_url(); ?>assets/img/avatar/avatar-2.png" alt="avatar">
                      <div class="media-body">
                        <div class="float-right">12m</div>
                        <div class="media-title">Ujang Maman</div>
                        <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</span>
                      </div>
                    </li>
                    <li class="media">
                      <img class="mr-3 rounded-circle" width="50" src="<?php echo base_url(); ?>assets/img/avatar/avatar-3.png" alt="avatar">
                      <div class="media-body">
                        <div class="float-right">17m</div>
                        <div class="media-title">Rizal Fakhri</div>
                        <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</span>
                      </div>
                    </li>
                    <li class="media">
                      <img class="mr-3 rounded-circle" width="50" src="<?php echo base_url(); ?>assets/img/avatar/avatar-4.png" alt="avatar">
                      <div class="media-body">
                        <div class="float-right">21m</div>
                        <div class="media-title">Alfa Zulkarnain</div>
                        <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.</span>
                      </div>
                    </li>
                  </ul>
                  <div class="text-center pt-1 pb-1">
                    <a href="#" class="btn btn-primary btn-lg btn-round">
                      View All
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div> 
      </div> 