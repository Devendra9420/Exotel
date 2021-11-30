<?php   // echo json_encode($this->session->userdata); ?> 
<?php if($this->session->userdata('department')!='12'){ ?>
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
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
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

<?php } ?>