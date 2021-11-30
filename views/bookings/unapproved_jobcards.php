 <?php  

	if(!empty($this->uri->segment(2))){ 
		if($this->uri->segment(2)=='unapproved_jobcards'){
		$status_name =	'Unapproved Jobcard';
		}else{ 
		$status_name = $this->Bookings->getstatus($this->uri->segment(3));
		}
	}else{ 
		$status_name = '';
	}

	
?>
 <div class="section-body">
            <h2 class="section-title"><?php echo $status_name; ?> Booking List<span class="text-right float-right"><a href="<?php echo base_url(); ?>bookings" class="btn btn-sm btn-info">Back</a></span></h2>
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
                        <th>Booking Id
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Mobile
                        </th> 
						<th>Service Date
                        </th>
						<th>Time
                        </th>
						<th>Make
                        </th>
						<th>Model
                        </th>
						<th>Channel
                        </th>
						<th>Service
                        </th>
						<th>Mechanic
                        </th>
						<th>Stage
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
</div>

	 </div>

     
 