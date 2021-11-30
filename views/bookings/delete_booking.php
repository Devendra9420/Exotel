 <div class="section-body">
            <h2 class="section-title">Delete Booking</h2>
            <p class="section-lead">  
            </p>
	 
	 
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header text-right">
                 
            </div>
            <div class="box-body"> 
 
<?= form_open_multipart(base_url() . 'bookings/delete_booking_data', array('method' => 'POST', 'class' => '', 'id'=> 'newBookingForm')) ?>	
<div class="form-group">
<label for="exampleInputFile">Booking Id to delete</label>
<input type="type" name="booking_id" id="booking_id"> 
</div>
<?php echo $this->rbac->deletePermission; ?>
</form>
 
			</div>
		</div>
	</div>
</div>