 <div class="section-body">
            <h2 class="section-title">Leads List <span class="text-right float-right"><a href="<?php echo base_url(); ?>bookings" class="btn btn-sm btn-info">Back</a></span></h2>
            <p class="section-lead">  
				<?php echo $this->rbac->createPermission_custom; ?>
            </p>

	 
	 
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header text-right">
                 
            </div>
            <div class="box-body">
				<div class="table-responsive">
                <table class="table table-striped" id="listtable">
                    <thead>
                    <tr role="row">
                        <th>Leads Id
                        </th>
                        <th>Name
                        </th>
                        <th>Mobile
                        </th>  
						<th>City
                        </th>
						<th>Source
                        </th>
						<th>Service Category
                        </th>
						<th>Desired Service Date
                        </th>
						<th>Created Date
                        </th>
						<th>Contact Date
                        </th>
						<th>Status
                        </th> 
                        <th>Action
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
</div>

	 </div>


 
<div class="modal fade" role="dialog"  id="modupdateleads">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">             
				<h5 class="modal-title">Update Lead</h5>  
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			</div> 
            <?= form_open_multipart(base_url() . 'leads/update_lead', array('method' => 'POST', 'class' => 'form-horizontal' , 'id' =>'myForm')) ?>

            <div class="modal-body"> 
				<input type='hidden' name="leads_id" class='form-control' value="" id='leads_id' placeholder=''> 
				
                <div class='form-group'>
                    <label>Status</label>
                      	<select name="status" id="status" class='form-control select2_modal' style="width: 100%;" required>  
							<option value="">Select</option> 
							<option value="Open">Open</option>
							<option value="Contact Later">Contact Later</option>
							<option value="Not answering">Not answering</option>
							<option value="Not reachable">Not reachable</option>
							<option value="Not interested - Service Done">Not interested - Service Done</option>
							<option value="Not Interested - Too Expensive">Not Interested - Too Expensive</option>
							<option value="Wrong No">Wrong No</option>
							<option value="Phone Switched off">Phone Switched off</option> 
							<option value="Duplicate/Repeat Lead">Duplicate/Repeat Lead</option>
							<option value="Non Servicable">Non Servicable</option>  
						</select> 
                </div>
				<div class="form-group">
                    <label>Comments</label> 
                    <textarea class="form-control" required rows="5" cols="100" name="details" id="details"></textarea> 
                    
                </div>
				<div class="form-group">
                    <label>Assigned To</label> 
						<select name="assigned_to" id="assigned_to" class='form-control select2_modal' style="width: 100%;">  
							<option value="">Select</option>  
						</select> 
                </div> 
				  
                <div class='form-group'>
                    <label>Due Date (Contact Date)</label>  
                        <input type='date' name="due_date"  style="width: 100%;" autocomplete="off" class='form-control' value="" id='due_date' placeholder=''> 
                </div>
				 
				  
                
            </div>
            <div class="modal-footer">
               <?php echo $this->rbac->updatePermission; ?>
				<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button> 
				<div style="min-height: 100px;"></div>
            </div>
            <?php echo form_close();?>
        </div>
        <!-- /.modal-content -->
    </div>
  </div>
