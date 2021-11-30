 <div class="section-body">
            <h2 class="section-title">Estimate</h2>
            <p class="section-lead">  
            </p>

<?php if(empty($action)){  ?>
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header text-right">
               <h2 class="section-title">Select Vehicle</h2>  
            </div>
            <div class="box-body">
                <!-- BEGIN FORM-->
                <?php echo form_open('Estimator/estimate',array('class'=>"form-horizontal form-bordered form-validate",'method'=>'post'))?>


                <div class="row">
                        <div class="form-group col-md-6">
                             <label>Make</label>
                                <select class="form-control select-ajax-make" style="width: 100%;"  placeholder="Make" id="make" name="make">
								<option selected value="<?php echo @$customer_vehicle[0]['make']; ?>"><?php echo @$customer_vehicle[0]['make_name']; ?></option> 
								</select>
                        </div> 
					
					<div class="form-group col-md-6">
                                <label>Model</label>
                                 <select class="form-control select-ajax-model" id="model"  placeholder="Model" name="model">
								 <option selected value="<?php echo @$customer_vehicle[0]['model']; ?>"><?php echo @$customer_vehicle[0]['model_name']; ?></option>
								</select>
							<input class="form-control input-modelcode" id="model_code" value="<?php echo @$customer_vehicle[0]['model_code']; ?>" type="hidden" name="model_code">
							<input class="form-control input-vehiclecategory" id="vehicle_category" value="<?php echo @$customer_vehicle[0]['vehicle_category']; ?>" type="hidden" name="vehicle_category">
							
                         </div>
					
					<div class="form-group col-md-12">
                                <label>City</label>
                                <select class="form-control select-ajax-city" style="width: 100%;"  placeholder="City" id="city" name="city"> 
								<option selected value="<?php echo @$customer_address[0]['city']; ?>"><?php echo @$customer_address[0]['city']; ?></option> 
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
      		<div class="panel">
                 
                <div class="panel-body">
                     
							<?php $attributes = array('class' => 'form-horizontal group-border hover-stripped', 'id'=>'addedit_form', 'method' => 'post');
                echo form_open_multipart('estimator/create_estimate', $attributes); ?> 
						 
						<div class="form-row">
							
							<?php  
							$model = get_model($model_id, 'all');
							?>
							<input class="form-control" id="booking_id" value="<?php echo @$booking->booking_id; ?>" type="hidden" name="booking_id">
							 
						 <div style="display: none;">
							<select class="form-control select-ajax-city" id="city" name="city">
								<option selected value="<?php echo @$city; ?>"><?php echo @$city; ?></option>
							 </select>
							<select class="form-control select-ajax-channel" id="channel"name="channel"><option selected value="Direct">Direct</option></select>
					</div>	
							<input class="form-control " id="make" value="<?php echo @$make_id; ?>" type="hidden" name="make">
							<input class="form-control" id="model" value="<?php echo @$model->model_id; ?>" type="hidden" name="model">
							 
							
							
							<input class="form-control input-modelcode" id="model_code" value="<?php echo @$model->model_code; ?>" type="hidden" name="model_code">
							<input class="form-control input-vehiclecategory" id="vehicle_category" value="<?php echo @$model->vehicle_category; ?>" type="hidden" name="vehicle_category">
							
			 
					
					
			 <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                  <div class="card-header">
                    <h4>Vehicle Details</h4>
                  </div>
                  <div class="card-body">
					<p>Make: <?php echo get_make($make_id); ?></p>   
					<p>Model: <?php echo $model->model_name; ?></p>   
					<p>&nbsp;</p>
                  </div>
                </div>
              </div>
				
				
			 
		
					 
				
					<div class="col-md-12" id="specific_cards"> 	
						 
							<div class="card-specific card card-info" id="card_specific">
                  <div class="card-header"> 
					  
                     <h4>Specific Details</h4>
					<div class="card-header-action col-md-6">
                      <a data-collapse="#specific-collapse" class="btn btn-icon btn-info float-right" href="#"><i class="fas fa-minus"></i></a>
                    </div>  
                  </div>
				<div class="collapse show" id="specific-collapse" style="">			
				 <div class="card-body">
					 <div class="row">
						 
					 	  <div class="form-group col-md-12"><label>Complaints:   </label>
								<select class="form-control select-ajax-complaints" style="width: 100%;"  placeholder="Complaints" id="complaints" name="complaints">
								<option selected value=""></option> 
								</select>
							 <input class="all_selected_complaints" id="all_selected_complaints" value="" name="all_selected_complaints" type="hidden" />
							 <div class="selected_complaints p-3"></div>
						</div>
						 
						 
						 
						<div class="form-group col-md-6"><label>Specific Spares:   </label>
								<select class="form-control select-ajax-spares" style="width: 100%;"  placeholder="Specific Spares" id="specific_spares" name="specific_spares">
								<option selected value=""></option> 
								</select>
							 
						</div>
						 
						 <div class="form-group col-md-6"><label>Specific Repairs:   </label>
								<select class="form-control select-ajax-labour" style="width: 100%;"  placeholder="Specific Repairs" id="specific_repairs" name="specific_repairs">
								<option selected value=""></option> 
								</select>
							 
						</div>
						 
						 
						
					 </div>
					</div>
					</div>		
                			</div>			
					
							</div>
				
				
						 	 
				<?php  $complaints_counter = 1; ?>
				<?php  $estimate_counter = 1; ?>   
              <div class="col-md-12" id="estimate_cards"> 	
                <div class="card-estimate card card-info" id="card_estimate">
                  <div class="card-header">
                    <h4>Estimate</h4>
					 <div class="card-header-action col-md-6">
                      <a data-collapse="#estimate-collapse" class="btn btn-icon btn-info float-right" href="#"><i class="fas fa-minus"></i></a>
                    </div>   
                  </div>
				   <div class="collapse show" id="estimate-collapse" style="">		
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="estimate_table">
                        <thead>
                          <tr> 
                            <th>#</th>
                            <th>Description</th> 
                            <th>Quantity</th>
                            <th>Spares</th>
                            <th>Labour</th>
                            <th>Total</th>
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                          
							 
							
                        </tbody>
                      </table>
                    </div>
                  </div>
					</div>   
                </div>
              </div>
            
				<div class="col-md-12" id="complaints_tables_div">
				 
						 
						</tbody></table></div></div></div></div>			
							
					 
					
				</div>
				
				<div class="col-md-12" id="comments_div"> 	
				<div class="form-group">
                      <label>Comments</label>
					  <textarea class="form-control" rows="5" cols="100" name="comments" id="comments"></textarea> 
                    </div>
					 
					
					<input class="form-control" value="" id="total_estimate_sum" type="hidden" name="total_estimate_sum">
					<input class="form-control" value="" id="max_complaints_val" type="hidden" name="max_complaints_val">
					<input class="form-control" value="" id="min_complaints_val" type="hidden" name="min_complaints_val">
					
					 	
				</div>	
				
				
				<div class="col-md-6"> 	
					<div class="form-group">
                      <label>Total Amount: </label>
					  <input class="form-control" value="0" id="totalcombine_max" type="text" readonly name="totalcombine_max"> 	
                    </div>
				</div>		 
					
					 
				<div class="col-md-6"> 	
					<div class="form-group">
                      <label>Discount: </label>
					  <input class="form-control" value="0" id="discount" type="number"  name="discount"> 	
                    </div>
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

<?php	
}
?> 