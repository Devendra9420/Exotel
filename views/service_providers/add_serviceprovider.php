 <div class="section-body">
            <h2 class="section-title">Add Service Provider</h2> 
	 
    <div class="row">
        <div class="col-lg-12">
      		<div class="panel">
                 
                <div class="panel-body">
                     
						<?php $attributes = array('class' => 'form-horizontal group-border hover-stripped', 'id'=>'addedit_form', 'method' => 'post');
                echo form_open_multipart('serviceproviders/insert_serviceprovider', $attributes); ?>
						 <input type="hidden" value="2" name="user_type">
						<div class="form-row">
						<div class="form-group col-md-6"> 
                                <label>First Name</label>
                                <input class="form-control" placeholder="First Name" id="name" value="" type="text" name="name"> 
                        </div>
						<div class="form-group col-md-6"> 
                                <label>Last Name</label>
                                <input class="form-control" placeholder="Last Name" id="lastname" value="" type="text" name="lastname"> 
                        </div>
                        <div class="form-group col-md-6">
                                <label>Mobile</label>
                                <input class="form-control" placeholder="1234567890" id="mobile" type="text" value="" name="mobile">
                        </div>
					
						<div class="form-group col-md-6">	
                            <label>Alternate No</label>
								<input class="form-control" placeholder="Alternate Number"  value="" type="text" name="alternate_no"> 
                         </div>
				
                        <div class="form-group col-md-6"> 
                                <label>Email</label>
                                <input class="form-control" type="text" value="" id="email" name="email">
                         </div>
				
						<div class="form-group col-md-6"> 
                                <label>Department</label>
                                 <select class="form-control select2" placeholder="Department" name="department">
								<?php if($departments)
										foreach($departments as $department){ ?>
									 <option value="<?php echo @$department->id;?>"><?php echo @$department->department; ?></option> 
								 <?php } ?>
								</select>	
							 	
                         </div>
							
							<div class="form-group col-md-6" style="display: none;"> 
                                <label>Username (Automatically first &amp; last name is set as Username)</label>
                                <input class="form-control" autocomplete="off"  type="text" value="" id="username" name="username">
                         </div>
							
							<div class="form-group col-md-6" style="display: none;"> 
                                <label>Password (Automatically mobile number is set as password)</label>
                                <input class="form-control" autocomplete="off" type="password" value="" id="password" name="password">
                         </div>
							
						<div class="form-group col-md-6"> 
                                <label>Gender</label>
                                <div class="selectgroup selectgroup-pills">
                        <label class="selectgroup-item">
                          <input type="radio" name="gender" value="Male" class="selectgroup-input" checked="checked">
                          <span class="selectgroup-button selectgroup-button-icon"><b>M</b></span>
                        </label>
                        <label class="selectgroup-item">
                          <input type="radio" name="gender" value="Female" class="selectgroup-input">
                          <span class="selectgroup-button selectgroup-button-icon"><b>F</b></span>
                        </label>
                         
                      </div>  
                         </div> 
							
						<div class="form-group col-md-6"> 
                                <label>Picture</label>
                                <input class="form-control" type="file" name="serviceprovider_pic">
                         </div>
							
						 
						<div class="col-md-12" id="addresscards"> 	
						<?php
							$i=1;
							 
						?>		
							<div class="card-address-number card card-info" id="card_<?=$i;?>">
                  <div class="card-header"> 
					  
                    <div class="col-md-6"> 
						Address
					  </div> 
					<div class="card-header-action col-md-6">
                      <a data-collapse="#address-collapse-<?=$i;?>" class="btn btn-icon btn-info float-right" href="#"><i class="fas fa-minus"></i></a>
                    </div>  
                  </div>
				<div class="collapse show" id="address-collapse-<?=$i;?>" style="">			
				 <div class="card-body">
					 <div class="row">
						<div class="form-group col-md-12"><label>Address:   </label>
								<input name="address" type="text" class='form-control' id='address' value="" placeholder='Address'></input>
						</div>
						<div class="form-group col-md-6">
                                <label>City</label>
                                <select class="form-control select-ajax-city" style="width: 100%;"  placeholder="City" id="city_<?=$i;?>" name="city">
								<option selected value=""></option> 
								</select>
                         </div>	
						<div class="form-group col-md-6">
                                <label>Area</label>
                                 <select class="form-control select-ajax-area" onFocus="get_area('<?=$i;?>');" id="area_<?=$i;?>" placeholder="Area" name="area">
								<option value=""></option>
								</select>
                         </div> 
						 
					 </div>
					</div>
					</div>		
                			</div>			
						<?php 
							$i++;	
							
						?> 
							</div>
					
								
							<div class="col-md-12" id="documentcards"> 	
						<?php
							$i=1;
							 
						?>		
							<div class="card-address-number card card-info" id="card_<?=$i;?>">
                  <div class="card-header"> 
					  
                    <div class="col-md-6"> 
						Documents
					  </div> 
					<div class="card-header-action col-md-6">
                      <a data-collapse="#address-collapse-<?=$i;?>" class="btn btn-icon btn-info float-right" href="#"><i class="fas fa-minus"></i></a>
                    </div>  
                  </div>
				<div class="collapse show" id="address-collapse-<?=$i;?>" style="">			
				 <div class="card-body">
					 <div class="row">
						<div class="form-group col-md-6"><label>Aadhar Card (Front):   </label>
								<input name="aadhar_front" type="file" class='form-control' id='aadhar_front' value="" placeholder='Aadhar Front'> 
						</div>
						<div class="form-group col-md-6"><label>Aadhar Card (Back):   </label>
								<input name="aadhar_back" type="file" class='form-control' id='aadhar_back' value="" placeholder='Aadhar Back'> 
						</div> 
						 <div class="form-group col-md-6"><label>PAN Card:   </label>
								<input name="pancard" type="file" class='form-control' id='pancard' value="" placeholder='PAN Card'> 
						</div> 
						 <div class="form-group col-md-6"><label>Driving License:   </label>
								<input name="driving_license" type="file" class='form-control' id='driving_license' value="" placeholder='Driving License'> 
						</div> 
					 </div>
					</div>
					</div>		
                			</div>			
						<?php 
							$i++;	
							
						?> 
							</div>
						
						</div>
				<div class="panel-footer">
                        <div class="form-group">
                            <div class="col-md-12">
                                <?php echo $this->rbac->createPermission; ?>
                                <a href="<?php if(!empty($_SERVER['HTTP_REFERER'])){ echo $_SERVER['HTTP_REFERER']; }else{ echo $this->uri->uri_string(); } ?>" class="btn btn-warning">Cancel</a>
                            </div>
                        </div> 
						</div>	
                    </form>

                </div>
            </div>
        </div>
    </div>
</div> 
