 <div class="section-body">
            <h2 class="section-title">Closed Complaints List <span class="text-right float-right"><a href="<?php echo base_url(); ?>complaints" class="btn btn-sm btn-info">Back</a></span></h2>
            <p class="section-lead">  
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
                        <th>Complaints Id
                        </th>
						<th>Booking Id
                        </th>
                        <th>Area
                        </th>
                        <th>Channel
                        </th> 
						<th>Mechanic
                        </th>
						<th>Name
                        </th>
						<th>Feedback
                        </th>
						<th>Complaint Date
                        </th>
						<th>Complaints Reason
                        </th>
						<th>Due Date
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


 
<div class="modal fade" role="dialog"  id="modupdatecomplaints">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">             
				<h5 class="modal-title">Update Complaints</h5>  
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
			</div> 
            <?= form_open_multipart(base_url() . 'complaints/update_complaints', array('method' => 'POST', 'class' => 'form-horizontal' , 'id' =>'myForm')) ?>

            <div class="modal-body"> 
				<input type='hidden' name="complaints_id" class='form-control' value="" id='complaints_id' placeholder=''> 
				<input type='hidden' name="booking_id" class='form-control' value="" id='booking_id' placeholder=''> 
                <div class='form-group'>
                    <label>Status</label>
                      	<select name="status" id="complaint_status" class='form-control select2_modal' style="width: 100%;" required>  
							<option value="Re-Open">Re-Open</option> 
						</select> 
                </div>
				
			 
				
				<div class="form-group">
                    <label>Comments</label> 
                    <textarea class="form-control" required rows="5" cols="100" name="details" id="details"></textarea> 
                    
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
