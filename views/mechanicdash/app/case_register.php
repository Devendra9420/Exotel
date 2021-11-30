<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>GarageWorks - Mechanic Case Register - TechSpanner</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
	
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/modules/chocolat/dist/css/chocolat.css"> 
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/modules/prism/prism.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/modules/datatables/datatables.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/modules/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/modules/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/modules/jquery-selectric/selectric.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/modules/summernote/summernote-bs4.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/modules/codemirror/lib/codemirror.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/modules/codemirror/theme/duotone-dark.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/modules/jquery-selectric/selectric.css">
  
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/modules/bootstrap-social/bootstrap-social.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/modules/izitoast/css/iziToast.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/modules/ionicons/css/ionicons.min.css">	
	<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/modules/fullcalendar/fullcalendar.min.css">  
	

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/style.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/components.css">
</head>

	 <style>
		 select{
			 width: 100% !important;
		 }
		 .select2-container.select2-dropdown-open {
   			 width: 100% !important;
  			}
		 .select2-container-multi .select2-search-choice-close {
    left: auto;
    right: 3px;
  }

  .select2-container-multi .select2-choices .select2-search-choice {
    padding-right: 18px;
    padding-left: 5px;
  }
		 
.pac-container {
        z-index: 10000 !important;
    }	
		 
	.select2-selection__clear {
    /*position: absolute !important; */
	float: right;
   right: 20px !important; 
}
.form-control::-webkit-input-placeholder {
  opacity: 0.5; 
}	
		 .loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
	margin: auto;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
		 .main-content {
    padding-left: 30px;
    padding-right: 30px;
    padding-top: 30px;
    width: 100%;
    position: relative;
}
	</style>
    <body>
		
		<div class="section-body"> 

   <div class="main-content">
        <section class="section">
          <div class="section-header text-center"> 
            <h1>Case Register</h1> 
			  
			</div>
			<div class="section-body">  
    
				 
			<?php 
$limit = 10;    
$total_pages = ceil($total_records / $limit);  				
?>		
					
              
                    <div class="row">
                        <div class="col-sm-12 col-12">  
                                <h4>Bookings from: <strong><?= date('d-m-Y', strtotime($start_date)); ?></strong> to <strong><?= date('d-m-Y', strtotime($end_date)); ?></strong>
                                </h4>
                                
								 
								<div id="case-content">Loading...</div>
                           
                          
				 <input id="total_pages" type="hidden" value="<?php echo $total_pages; ?>" />
							<ul class="pagination">
                          <li class="page-item">
                            <a class="page-link" id="btn_prev" href="javascript:getData(this.data-id);" data-id="0" aria-label="Previous">
                              <span aria-hidden="true">«</span>
                              <span class="sr-only">Previous</span>
                            </a>
                          </li>
						<?php 
					if(!empty($total_pages)){
						for($i=1; $i<=$total_pages; $i++){
								if($i == 1){
									?>		
                          <li class="page-item active" id="page-item-<?php echo $i;?>"><a class="page-link" href="javascript:getData(<?php echo $i;?>);" data-id="<?php echo $i;?>"><?php echo $i;?></a></li>
								<?php 
								}
								else{
									?>
						  <li class="page-item" id="page-item-<?php echo $i;?>"><a class="page-link" href="javascript:getData(<?php echo $i;?>);" data-id="<?php echo $i;?>"><?php echo $i;?></a></li>
								<?php
								}
						}
					}
								?>
                          <li class="page-item">
                            <a class="page-link" id="btn_next" href="javascript:getData(this.data-id);" aria-label="Next">
                              <span aria-hidden="true">»</span>
                              <span class="sr-only">Next</span>
                            </a>
                          </li>
                        </ul>
							
							
							 
							
							
							
                        </div>
                    </div> 
					
					
					
					
					
					
					
					
					
					
                
             
        
</div>  



	  </section>
      </div>	 
    

  <!-- General JS Scripts -->
  <script src="<?php echo base_url(); ?>/assets/modules/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/modules/popper.js"></script>
  <script src="<?php echo base_url(); ?>/assets/modules/tooltip.js"></script>
  <script src="<?php echo base_url(); ?>/assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/modules/moment.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/js/stisla.js"></script>
  <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
  <!-- JS Libraies -->

  
  <script src="<?php echo base_url(); ?>/assets/modules/jquery-ui/jquery-ui.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script> 
  <script src="<?php echo base_url(); ?>/assets/modules/prism/prism.js"></script>

  <script src="<?php echo base_url(); ?>/assets/modules/cleave-js/dist/cleave.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/modules/cleave-js/dist/addons/cleave-phone.us.js"></script>
  <script src="<?php echo base_url(); ?>/assets/modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/modules/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script src="<?php echo base_url(); ?>/assets/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/modules/select2/dist/js/select2.full.min.js"></script> 
  
  <script src="<?php echo base_url(); ?>/assets/modules/summernote/summernote-bs4.js"></script>
  <script src="<?php echo base_url(); ?>/assets/modules/codemirror/lib/codemirror.js"></script>
  <script src="<?php echo base_url(); ?>/assets/modules/codemirror/mode/javascript/javascript.js"></script>
  
  
  <script src="<?php echo base_url(); ?>/assets/modules/datatables/datatables.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?php echo base_url(); ?>/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script> 

  
  <script src="<?php echo base_url(); ?>/assets/modules/jquery-selectric/jquery.selectric.min.js"></script>
  
  <script src="<?php echo base_url(); ?>/assets/modules/izitoast/js/iziToast.min.js"></script>
  
  <script src="<?php echo base_url(); ?>/assets/modules/sweetalert/sweetalert.min.js"></script>





  <!-- Page Specific JS File -->



 
  <script src="<?php echo base_url(); ?>/assets/js/scripts.js"></script>
  <script src="<?php echo base_url(); ?>/assets/js/custom.js"></script>

 
 <?php  
		 	$this->load->view('mechanicdash/app/mechanicdash_js');
			
			?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
    
<script type="text/javascript"> 
	$(document).on('show.bs.modal', '.modal', function () {
  $(this).appendTo('body');
});
	
	$(document).on('keyup keypress', 'form input[type="text"]', function(e) {
  if(e.keyCode == 13) {
    e.preventDefault();
    return false;
  }
		
	 
});
	
  
</script> 
</body>
</html>