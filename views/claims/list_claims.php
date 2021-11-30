   <style>
    .pac-container {
        z-index: 10000 !important;
    }
	   label.error, .error, .has-error {
    color:red !important;
	border-color: red !important; 
}
		.has-error .select2-selection {
    border: 1px solid red;
    border-radius: 4px;
}
		.error:before {
    content: "";
}
		
</style>

<div class="row">
        <div class="col-xs-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"> <span class="caption-subject font-dark sbold uppercase">Claim List | <a
                                href='#myModal-1' data-toggle='modal' class='btn green btn-info'>
                                Create New Claim<i class="fa fa-plus"></i>
                            </a></span></h3>
                </div>
                <div class="box-body">

                    <table class="table table-striped table-hover table-bordered dataTable" id="example1"
                           aria-describedby="editable-sample_info">
                        <thead>
                        <tr role="row">
                            <th class="sorting_enabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                CLAIM ID
                            </th>
                            <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                INSURED NAME
                            </th>
							<th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                INSURED MOBILE
                            </th>
							  <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                CLAIM NO
                            </th>
                            <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                CASE DATE
                            </th>
                            <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                GIC
                            </th>
                            <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                CITY
                            </th>
                          

                             
                            <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                STATUS
                            </th>
                            <th class="sorting_disabled" role="columnheader" tabindex="0"
                                aria-controls="editable-sample"
                                rowspan="1"
                                colspan="1" aria-label="Delete: activate to sort column ascending">
                                Action
                            </th>
                             
                        </tr>
                        </thead>

                        <tbody role="alert" aria-live="polite" aria-relevant="all">
                        <?php foreach ($item as $results) { ?>
                        <tr class='odd'>


							<td><?php echo $results->id?></td>
                                 

                            <td><?php echo $results->name?></td>
							<td><?php echo $results->mobile?>	</td>
							<td class=center><?php echo $results->claim_no?></td>
                            <td><?php echo date('d-m-Y', strtotime($results->created_on))?></td>
                            <td><?php echo $results->GIC_NAME?></td>
                            <td><?php echo $results->cityname?></td> 
                             
                            <td><?php 
							if($results->active == 1){ 
								if($results->stage == 0){ 
									echo '<span class="label label-light" style="color:black;">'.$results->status.'</span>';
								}
                                 elseif($results->stage == 1){ 
									echo '<span class="label label-default">'.$results->status.'</span>';
								}					   
								 elseif($results->stage == 2){ 
									echo '<span class="label label-primary"> '.$results->status.' </span>';
								 }
								elseif($results->stage == 3){ 
									echo '<span class="label label-info"> '.$results->status.' </span>';
								 }
								elseif($results->stage == 4){ 
									echo '<span class="label label-info"> '.$results->status.' </span>';
								}
								elseif($results->stage == 5){ 
									echo '<span class="label label-info"> '.$results->status.' </span>';
								 }
						        elseif($results->stage == 6){ 
									echo '<span class="label label-info"> '.$results->status.' </span>';
								 }
								elseif($results->stage == 7){ 
									echo '<span class="label label-warning"> '.$results->status.' </span>';
								 }
								elseif($results->stage == 8){ 
									echo '<span class="label label-info"> '.$results->status.' </span>';
								 }
								elseif($results->stage == 9){ 
									echo '<span class="label label-info"> '.$results->status.' </span>';
								 }
								elseif($results->stage == 10){ 
									echo '<span class="label label-success"> '.$results->status.' </span>';
								 }
								 else{
                                    echo '<span class="label label-danger"> Status:Error </span>';
								 }
							}
							else{
								
                                if(!empty($results->close_type)){ 
								echo '<br><span class="label label-danger"> Claim Cancelled: '.$results->close_type.'</span>';
								}else{
								echo '<span class="label label-danger"> Claim Cancelled: Error </span>';
								 }
								
							}
														   
								 
	
								 ?>

							</td>

                            <td>
                               <a href='<?= base_url() ?>claims/claims_details/<?= $results->id ?>'
                                   class='btn btn-app'><i class='fa fa-file-text'></i> Details</a>
								
								<a style="display: none;" href='#myModal<?php echo $results->item_id?>' <?php echo $My_Controller->editPermission;?>
                                   data-toggle='modal' class='btn btn-warning'><i class='fa fa-pencil-square-o'></i>
                                    Edit
                                </a>
                            </td>
                             
                        <?php } ?>
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>

</section>


<script>
    function get_items(id) {
        var csrf_test_name = $("input[name=csrf_test_name]").val();
        $.ajax({
            url: '<?=base_url();?>index.php/item/get_items/',
            type: 'POST',
            data: {'id': id, 'csrf_test_name': csrf_test_name},
            dataType: 'html',
            success: function (response) {
                //console.log(response.category_id);

                $('#itemBar').html(response);
                //$('#purchase_entry_holder').html(response);
                $("#barcode").val('');
                $("#barcode").focus();


            }
        });
    }
</script>
<!-- page start-->

 


<!------------------------------------------------------------------------------->

<!--Modal for ADD -->

<script> 
$(document).ready(function () {
    $("#newClaimForm").validate({
            rules: {
              mobile: {
                    required: true,
                    maxlength: 10,
                    minlength: 10,
                    number: true,

                }, 
				alternate_no: { 
                    maxlength: 10,
                    minlength: 10,
                    number: true,

                },  
              gic: {
                  required: true,
              },
               
              city: {
                  required: true,
              },
              v_address: {
                  required: true,
              },
              customer_google_map: {
                  required: true,
              },
             
            }
            });

    $('#name').keypress(function (e) {
    var regex = new RegExp("^[a-zA-Z ]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
    return true;
    }
    else
    {
    e.preventDefault();
    alert('Please enter only alphabets in name');
    return false;
    }
  });
          });
          
</script>
<div class="modal fade" role="dialog"  id="myModal-1">
    <div class="modal-dialog">
        <div class="modal-content modalselect2">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add New Claims</h4>
            </div>
            <?= form_open_multipart(base_url() . 'index.php/claims/create_new_claims', array('id' => 'newClaimForm', 'method' => 'POST', 'class' => 'form-horizontal')) ?>
			
            <div class="modal-body">
				
				 
				<div class="form-group" >
                    <label for="cname" class="control-label col-lg-3">Claim Date</label>

                    <div class="col-lg-9">
                         <input type="text" name="created_on"
                               class="form-control input-medium datepicker"
                               required="required" value="<?php echo date('m/d/Y'); ?>"/>
                    </div>
				 
                </div>
				
				
				<div class="form-group" >
                    <label for="cname" class="control-label col-lg-3">Insurer</label>

                    <div class="col-lg-9">
                         <select name="gic"  id="gic"   class="form-control input-large select2modal" style="width: 100%;" >
						<?php foreach($gics as $gic){ ?>   
						<option value="<?php echo $gic->GIC_ID; ?>"><?php echo $gic->GIC_NAME; ?></option>
						<?php } ?>
						</select>
                    </div>
				 
                </div>
				
				
				<div class="form-group">
                    <label for="cname" class="control-label col-lg-3">Claim No</label>

                    <div class="col-lg-9">
                        <input type='text' name="claim_no" class='form-control'
                               value=""   
                               placeholder=''>
                    </div>
                </div>
				
				
				<h4 class="box-title">Insured Personal Details</h4>
                <div class='form-group'>
                    <label for='inputEmail1' class='col-lg-3 col-sm-3 control-label'>Name</label>
                    <div class='col-lg-9'>
                        <input type='hidden' name="cid" class='form-control' id='c_' value=''>
                        <input type='text'   name="name" class='form-control' id='name'  value=''>
                    </div>
                </div>
				<div class="form-group">
                    <label for="cname" class="control-label col-lg-3">Mobile</label>

                    <div class="col-lg-9">
                        <input type='text' name="mobile" class='form-control'
                               value="" required="required" 
                               placeholder=''>
                    </div>
                </div>
                 
				 <div class="form-group">
                    <label for="cname" class="control-label col-lg-3">Alternate Number</label>

                    <div class="col-lg-9">
                        <input type='text' name="alternate_no" class='form-control'
                               value=""  
                               placeholder=''>
                    </div>
                </div>
				
				
				<div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>City</label>

                    <div class='col-lg-9'>
                         <select  class="form-control input-large select2modal"  name="city" id="city" style="width: 100%;" required>
                            <option value="">Select City</option>
                            <?php foreach ($cities as $city) : ?>
                                <option
                                    value="<?php echo $city->city_id ?>"><?php echo $city->cityname; ?></option>
                            <?php endforeach; ?>
                        </select>
						 
                    </div>
                </div>
				<h4 class="box-title">Insured Vehicle Details</h4>
                <div class='form-group'>
                    <label for='make' class='col-lg-3 col-sm-3 control-label'>Make</label>

                    <div class='col-lg-9'>
                          <select name="make" class='form-control select2modal' id="make" style="width: 100%; margin-bottom: .5em;"   >
							 <option value="">Select Make</option> 
						<?php foreach($makes as $make){ ?>   
						<option value="<?php echo $make->make_id; ?>"><?php echo $make->make_name; ?></option>
						<?php } ?>
						</select>
						
						 
                    </div>
                </div>
                

                <div class='form-group' >
                    <label for='model' class='col-lg-3 col-sm-3 control-label'>Model</label>

                    <div class='col-lg-9'>
                       <select name="model" class='form-control select2modal' id="model" style="width: 100%; margin-bottom: .5em;"   >
						 <option value="">Select</option> 
						</select>
                    </div>
                </div>

                
                 
				
                 
                 
				
				
				 <div class="form-group" >
                    <label for="cname" class="control-label col-lg-3">Vehicle Address</label>

                    <div class="col-lg-9">
                        <input type='text' name="v_address" class='form-control'
                               value="" 
                               placeholder=''>
                    </div>
                </div>
				
				
				  <div class="form-group" >
                              <label class="control-label col-lg-3">Google Map</label>
                               <div class="col-lg-9">
								   <input type="text" class="form-control" name="customer_google_map" id="customer_google_map" placeholder="Google Map" onFocus="geolocate()"  />
							  <input type="hidden" class="form-control" name="customer_long" id="customer_long"  /> 
							  <input type="hidden" class="form-control" name="customer_lat" id="customer_lat"  />  
                          	 </div>
                            
                     </div>
				
				
				
				
				
				
				
				
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
<?php echo $My_Controller->savePermission;?>
            </div>
            <?php echo form_close();?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script type='text/javascript'>
  
	$(document).ready(function(){
 
	  $('form input').on('keypress', function(e) {
    return e.which !== 13;
});

$('#make').change(function(){
    	var make = $(this).val(); 
		  
		  if(make !== ""){ 
       
			  
           var csrf_test_name = $("input[name=csrf_test_name]").val();
     $.ajax({
     url:'<?=base_url()?>index.php/bookings/getModelsByMake/',
     method: 'POST',
     data: {vehicle_make: make, 'csrf_test_name': csrf_test_name},
     dataType: 'json',
     success: function(response){ 
		 
		 $('#model').empty().trigger("change");  
			  var data = {
    id: '',
    text: 'Select Model'
};
var newOption = new Option(data.text, data.id, false, false);
$('#model').append(newOption).trigger('change');
		 
		 $('#model').select2({
			 placeholder :'Select Model', 
			 width: 'resolve',
             data: response
                }); 
 		$('#model').trigger('change');
        
     }
   });
		  
		  
		  }
	  });

});
	 
	</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgW3kze70q1ov1DO0DMUDsZd3f8CUUOBw&libraries=places&callback=initAutocomplete"
        async defer></script>
	<script>
// This sample uses the Autocomplete widget to help the user select a
// place, then it retrieves the address components associated with that
// place, and then it populates the form fields with those details.
// This sample requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script
// src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

var placeSearch, autocomplete;

 
function initAutocomplete() {
  // Create the autocomplete object, restricting the search predictions to
  // geographical location types.
  autocomplete = new google.maps.places.Autocomplete(
      document.getElementById('customer_google_map'));

  // Avoid paying for data that you don't need by restricting the set of
  // place fields that are returned to just the address components.
 // autocomplete.setFields(['address_component']);

  // When the user selects an address from the drop-down, populate the
  // address fields in the form.
 // autocomplete.addListener('place_changed', fillInAddress);
	autocomplete.addListener('place_changed', function () {
      var place = autocomplete.getPlace();
      // place variable will have all the information you are looking for.
      $('#customer_lat').val(place.geometry['location'].lat());
      $('#customer_long').val(place.geometry['location'].lng());
    });
}

 

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      var circle = new google.maps.Circle(
          {center: geolocation, radius: position.coords.accuracy});
      autocomplete.setBounds(circle.getBounds());
    });
  }
}
    </script>