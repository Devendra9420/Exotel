 <?php  

	if(!empty($this->uri->segment(2))){ 
		if($this->uri->segment(2)=='pending_jobcards'){
		$status_name =	'Pending Jobcard';
		}else{ 
		$status_name = $this->Bookings->getstatus($this->uri->segment(3));
		}
	}else{ 
		$status_name = '';
	}

	
?>
 <div class="section-body">
            <h2 class="section-title"><?php echo $status_name; ?> Jobcard Spares<span class="text-right float-right"><a href="<?php echo base_url(); ?>bookings" class="btn btn-sm btn-info">Back</a></span></h2>
            <p class="section-lead">  
            </p>

	 
<?php if(empty($city)){  ?>
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header text-right">
               
            </div>
            <div class="box-body">
                <!-- BEGIN FORM-->
                <?php echo form_open('bookings/jobcard_spares',array('class'=>"form-horizontal form-bordered form-validate",'method'=>'post'))?>


                <div class="row">
                        <div class="col-lg-12">
                            <label class="control-label">Select City</label>
                            <select class="form-control select2" style="width: 100%;" name="city" id="city">
							  <?php echo city_dropdown($city); ?>
                        </div> 
                    
                    <br>
                    <div class="form-actions">
                        <input type="hidden" name="action" value="search">
                        <button type="submit" class="btn btn-success" >Submit</button>
                        <button type="reset" class="btn">Cancel</button>
                    </div>
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
				<div class="table-responsive">
                <table class="table table-striped datatable" id="listtable">
                    <thead>
                    <tr role="row">
                        <th>Booking Id
                        </th>
                        <th>
                           Service Date
                        </th>
                        <th>
                            Channel
                        </th>   
						<th>Make
                        </th>
						<th>Model
                        </th>
						<th>Service
                        </th>
						<th>Spares
                        </th> 
                        <th>
                            Action
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                     
							<?php 
			
							$data = $this->Bookings->get_jobcard_spares($city);
							if($data)
							foreach ($data as $row){ 
								echo '<tr>';
								echo '<td>'.$row['booking_id'].'</td>';
								echo '<td>'.$row['service_date'].'</td>';
								echo '<td>'.$row['customer_channel'].'</td>';
								echo '<td>'.$row['make_name'].'</td>';
								echo '<td>'.$row['model_name'].'</td>';
								echo '<td>'.$row['service_category'].'</td>';
								echo '<td>'.$row['spares_list'].'</td>';
								if(!empty($row['spares_list'])){ 
								echo '<td>'.$row['assign'].'</td>';
								}else{ 
								echo '<td>No Spares</td>';	
								}
								echo '</tr>'; 
							}
	
							?>
                
                    </tbody>
                </table>
				</div>
            </div>
        </div>

    </div>
</div>
<?php } ?>
	 </div>

     
 