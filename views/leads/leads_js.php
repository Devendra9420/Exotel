  
<?php if($this->uri->segment(2) == 'list_leads'){ 
?>
<script type="text/javascript"> 
    $(document).ready(function(){
        
		 
		$.fn.dataTable.render.moment = function ( from, to, locale ) {
    // Argument shifting
    if ( arguments.length === 1 ) {
        locale = 'en';
        to = from;
        from = 'YYYY-MM-DD';
    }
    else if ( arguments.length === 2 ) {
        locale = 'en';
    }
 
    return function ( d, type, row ) {
        if (! d) {
            return type === 'sort' || type === 'type' ? 0 : d;
        }
 
        var m = window.moment( d, from, locale, true );
 
        // Order and type get a number value from Moment, everything else
        // sees the rendered value
        return m.format( type === 'sort' || type === 'type' ? 'x' : to );
    };
};
		
		// Setup datatables
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
      {
          return {
              "iStart": oSettings._iDisplayStart,
              "iEnd": oSettings.fnDisplayEnd(),
              "iLength": oSettings._iDisplayLength,
              "iTotal": oSettings.fnRecordsTotal(),
              "iFilteredTotal": oSettings.fnRecordsDisplay(),
              "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
              "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
          };
      };
 
      var table = $("#listtable").dataTable({
          initComplete: function() {
              var api = this.api();
              $('#listtable_filter input')
                  .off('.DT')
                  .on('input.DT', function() {
                      api.search(this.value).draw();
              });
          },
              oLanguage: {
              sProcessing: "loading..."
          }, 
              processing: true,
              serverSide: true,
              ajax: {"url": "<?php echo base_url().'leads/get_leads/'; ?>", "type": "POST"},
		  
	
                    columns: [
                        {"data": "leads_id"},
                        {"data": "name"},
                        {"data": "mobile"},
                        {"data": "city"},
                        {"data": "source"},
                        {"data": "service_category"},
                        {"data": "desired_service_date"},
                        {"data": "created_on"}, 
                        {"data": "contact_date"},
                        {"data": "status"},
                        {"data": "action"}  
						 
						
					],
		 
 		  columnDefs: [
					   { orderable: false, targets: [7,8,9] },
			  		   { searchable: false, targets: [7,8,9] }
					], 
                order: [[7, 'desc']],
          rowCallback: function(row, data, iDisplayIndex) {
              var info = this.fnPagingInfo();
              var page = info.iPage;
              var length = info.iLength;
              $('td:eq(0)', row).html();
          }
 
      });
            // end setup datatables
            // get Edit Records
            $('#listtable').on('click','.edit_record',function(){
            var code=$(this).data('customer_id');
                        var name=$(this).data('name');
                        var mobile=$(this).data('price');
                        var city=$(this).data('city');
                        var area=$(this).data('area');
                        var channel=$(this).data('channel');
            $('#ModalUpdate').modal('show');
            			$('[name="customer_id"]').val(code);
                        $('[name="name"]').val(name);
                        $('[name="mobile"]').val(mobile);
                        $('[name="city"]').val(city).trigger('change');
                        $('[name="area"]').val(area).trigger('change');
                        $('[name="channel"]').val(channel).trigger('change');
      					});
            // End Edit Records
            // get delete Records
            $('#listtable').on('click','.delete_record',function(){
            var code=$(this).data('customer_id');
            $('#ModalDelete').modal('show');
            $('[name="customer_id"]').val(code);
      });
            // End delete Records
    }); 

	
</script>
<script>	
 
		
	 function updatelead(leads_id){ 
        $.ajax({
            url: '<?=base_url();?>leads/edit_lead/',
            type: 'POST',
            data: {'leads_id': leads_id},
            dataType: 'json',
            success: function (data) {  
				if(data !== ''){   
				 	$('#leads_id').val(leads_id); 
					$('#details').val(data.details);  
					$('#due_date').val(data.due_date); 
					$('#status').val(data.status).trigger('change');
 					$('#assigned_to').empty().trigger("change");  
				  var assignedtodata = { id: '', text: 'Select'};
				  var employeelist = new Option(assignedtodata.text, assignedtodata.id, false, false);
				  $('#assigned_to').append(employeelist).trigger('change');
 		 $('#assigned_to').select2({
			 placeholder :'Select Employee', 
			 width: 'resolve',
			 dropdownParent: $(".modal"),
             data: data.employees
                });
				$('#assigned_to').val(data.assigned_to).trigger('change');	 
				$('#modupdateleads').modal('show'); 
				}
            }
        }); 
			 }
		
		</script>

<?php }  if($this->uri->segment(2) == 'new_leads' || $this->uri->segment(2) == 'add_leads'){ ?>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgW3kze70q1ov1DO0DMUDsZd3f8CUUOBw&libraries=places"   defer></script>
	<script>
 
		
		$(document).ready(function() {
		 
		createGeoListeners();
	});
		
	function fetchlonglat(){
		var geocoder = new google.maps.Geocoder();
var address = document.getElementsByClassName("google_map").value;
geocoder.geocode( { 'address': address}, function(results, status) {
  if (status == google.maps.GeocoderStatus.OK)
  {
      // do something with the geocoded result
      //
       $('.longitude').val(results[0].geometry.location.longitude);
        $('.latitude').val(results[0].geometry.location.latitude);
	  
	 
  }
});
	}	
	// Perhaps put these into a javascript library
	function createGeoListeners(autocompletesWraps) {
		var options = {types: ['geocode'],componentRestrictions: {country: "in"}};
		var inputs = $('.google_map');
		var autocompletes = [];
		for (var i = 0; i < inputs.length; i++) {
			var autocomplete = new google.maps.places.Autocomplete(inputs[i], options);
			autocomplete.inputId = inputs[i].id;
			autocomplete.inputs_long = $('.longitude');[i];
			autocomplete.inputs_lat = $('.latitude');[i];
			autocomplete.addListener('place_changed', fillInAddressFields);
			inputs[i].addEventListener("focus", function() {
				geoLocate(autocomplete);
			}, false);
			autocompletes.push(autocomplete);
		}
	}
	function fillInAddressFields() {
		$('.googleerror').removeClass('is-valid is-invalid');
		var place = this.getPlace();
		for (var i = 0; i < place.address_components.length; i++) {
			var addressType = place.address_components[i].types[0];
			var val = place.address_components[i].long_name;
			var latval = place.geometry['location'].lat();
			var lngval = place.geometry['location'].lng();  
			$('.longitude').val(lngval);
			$('.latitude').val(latval);
		}
	}
	function geoLocate(autocomplete) {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
				var geolocation = {
					lat: position.coords.latitude,
					lng: position.coords.longitude
				};
				var circle = new google.maps.Circle({
					center: geolocation,
					radius: position.coords.accuracy
				});
				autocomplete.setBounds(circle.getBounds());
			});
		}
	}
	function gm_authFailure() { 
		$('.gm-err-autocomplete').addClass('is-invalid');
		swal("Error","There is a problem with the Google Maps or Places API","error");
	};
    </script>
<script> 
$(document).ready(function () {
    $("#addedit_form").validate({
            rules: {
              mobile: {
                    required: true,
                    maxlength: 10,
                    minlength: 10,
                    number: true,

                },
			  alternate_no:{
				maxlength: 10,
                    minlength: 10,
                    number: true,
			  },	
              name: {
                  required: true,
                  number: false,

              } 
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
	 
	
	 $('#mobile').change(function() {
   			 
		 	var mobile = $(this).val();
			var vehiclecategory = $('.input-vehiclecategory').val();
		  	var modelcode = $('.input-modelcode').val(); 
			var channel = $('.select-ajax-channel').val();
			var city = $('.select-ajax-city').val();
		 	var leads_convert = $('#leads_id').val();
		    if(mobile.length == 10){  
				if(leads_convert===''){
					var leads_id = 0;
				}else{
					var leads_id = leads_convert;
				}
			$.ajax({
            url: '<?=base_url();?>bookings/customer_existance/',
            type: 'POST',
            data: {'mobile': mobile, 'leads_id': leads_id},
            dataType: 'json',
            success: function (data) {
				if(data.customer_id==0){
					
					 
					document.getElementById("addedit_form").reset();
					$('#addedit_form').find('select')
                    .val(null)
                    .trigger('change.select2');
					$('#addedit_form').find('input:text').val('');
					 $("#name").attr("readonly", false); 
					$('#address_type_div').hide();
					$('#customer_vehicle_div').hide();
					$('#mobile').val(mobile); 
					 
					
					
					return false;
				}else{
					 
					<?php if ($lead_convert==1){  ?>
					window.location.href = '<?=base_url();?>bookings/add_booking';
					<?php }else{   ?>
					location.reload(); 
					<?php } ?>
				}
			}
			   })
		    }
		 
  	 });
	
	
	
	$('#address_type').change(function() {
   			
		 	var type = $(this).val(); 
			var address = $(this).find(':selected').data('address');
			var city = $(this).find(':selected').data('city');
			var area = $(this).find(':selected').data('area');
			var pincode = $(this).find(':selected').data('pincode');
			var zone = $(this).find(':selected').data('zone');
			var google_map = $(this).find(':selected').data('googlemap');
			var latitude = $(this).find(':selected').data('latitude');
			var longitude = $(this).find(':selected').data('longitude'); 
		     
			 $("#address").val(address); 
		 	 
			 $('#city').empty().trigger('change');
		  	 var newOption = new Option(city, city, false, false);
			 $('#city').append(newOption).trigger('change');
			 
			 $('#area').empty().trigger('change');
			 var newOption = new Option(area, area, false, false);
			 $('#area').append(newOption).trigger('change');
			
		
		
		
			 $("#pincode").val(pincode);
			 $("#zone").val(zone);
		
			 $("#google_map").val(google_map);
			 $("#latitude").val(latitude);
			 $("#longitude").val(longitude);
		 
  	 });
	
	
	
	$('#customer_vehicle').change(function() { 
		 	var type = $(this).val(); 
			var make = $(this).find(':selected').data('make');
			var makename = $(this).find(':selected').data('makename');
			var model = $(this).find(':selected').data('model');
			var modelname = $(this).find(':selected').data('modelname');
			var regno = $(this).find(':selected').data('regno');
			var yom = $(this).find(':selected').data('yom');
			var km_reading = $(this).find(':selected').data('kmreading'); 
			var last_service_id = $(this).find(':selected').data('lastserviceid');
			var last_service_date = $(this).find(':selected').data('lastservicedate');
			var vehicle_category = $(this).find(':selected').data('vehiclecategory');
			var model_code = $(this).find(':selected').data('modelcode'); 
			 
			 $('#make').empty().trigger('change');
		  	 var newOption = new Option(makename, make, false, false);
			 $('#make').append(newOption).trigger('change');
		
			 $('#model').empty().trigger('change');
		  	 var newOption = new Option(modelname, model, false, false);
			 $('#model').append(newOption).trigger('change');
		
		 
		
			 $("#reg_no").val(regno); 
			 $("#yom").val(yom);
			 $("#km_reading").val(km_reading); 
			 $('.last_service_id').show();
			 $("#last_service_id").val(last_service_id);
			 $("#last_service_date").val(last_service_date); 
			 $('#last_service_id_div').html('<a style="padding:5px;" target="_blank" href="<?=base_url('bookings/booking_details/')?>/'+last_service_id+'" class="label-info">Last Booking - '+last_service_id+'</a>'); 
			 $(".input-modelcode").val(model_code);
			 $(".input-vehiclecategory").val(vehicle_category); 
  	 });
	
	
	
	 
          });
	
	    
          
</script>



<?php  
							if($this->session->has_userdata('customer')){  
								
								
								
									
									
							$lead_estimate_data = @$this->session->userdata['customer']['lead_estimate'];
							if(!empty($lead_estimate_data)){  
								
						?> 


	 
   
	<script type='text/javascript'>
    
	  
	   
	   
		 function loadestimate(){ 
			 <?php 
					foreach ($lead_estimate_data as $estimate){   
			 if($estimate->complaints=='Service Category'){ ?>
			 	 
			 
			 	$(".select-ajax-service-category").append('<option value="<?php echo $estimate->item; ?>" data-categoryrates="<?php echo $estimate->amount; ?>" data-service_name="<?php echo $estimate->item; ?>" selected><?php echo $estimate->item; ?></option>');  
				$('.select-ajax-service-category').val('<?php echo @$this->session->userdata['customer']['service_category']; ?>')
					$('.select-ajax-service-category').trigger('change'); 
		 <?php 	 }
						
						
						elseif($estimate->complaints=='Additional Spares'){ 
			 	 $itemcode = $this->Common->single_row('spares',array('spares_id'=>$estimate->item_id));
			 	?>
			 $('.select-ajax-spares').append('<option selected value="<?php echo $estimate->item_id; ?>" data-itemtype="Spare" data-sparesrates="<?php echo $estimate->spares_rate; ?>" data-labourrates="<?php echo $estimate->labour_rate; ?>" data-totalrates="<?php echo $estimate->amount; ?>" data-sparesid="<?php echo $estimate->item_id; ?>" data-itemcode="<?php echo $itemcode->item_code; ?>" data-itemname="<?php echo $estimate->item; ?>" data-itemid="<?php echo $estimate->item_id; ?>"><?php echo $estimate->item; ?></option>');
   			 $('.select-ajax-spares').val('<?php echo $estimate->item_id; ?>').trigger('change');
    
			 
		 <?php 	 }elseif($estimate->complaints=='Additional Repair'){ ?>
			 	 $('.select-ajax-labour').append('<option selected value="<?php echo $estimate->item_id; ?>" data-itemtype="Labour" data-sparesrates="<?php echo $estimate->spares_rate; ?>" data-labourrates="<?php echo $estimate->labour_rate; ?>" data-totalrates="<?php echo $estimate->amount; ?>" data-sparesid="<?php echo $estimate->item_id; ?>" data-itemcode="<?php echo $itemcode->item_code; ?>" data-itemname="<?php echo $estimate->item; ?>" data-itemid="<?php echo $estimate->item_id; ?>"><?php echo $estimate->item; ?></option>');  
				 $('.select-ajax-labour').val('<?php echo $estimate->item_id; ?>').trigger('change');
		 <?php 	 }
			 
					}
								
			$complaints = explode(' | ', $this->session->userdata['customer']['complaints']);
			 foreach($complaints as $complaint){ 
				 if(!empty($complaint)){ 
					 $complaint_id = $this->Common->single_row('complaints',array('complaints'=>$complaint));
			 	?>
			 
			 	 $('.select-ajax-complaints').append('<option value="<?php echo $complaint_id->id; ?>"  selected><?php echo $complaint; ?></option>');	 
				 $('.select-ajax-complaints').val('<?php echo $complaint_id->id; ?>').trigger('change');	 
			 <?php 
				 } 
			 }
			?>
		  }
      
		
		 
		 $(window).on('load', function() {
	   
			 $('#leads_convert').val('<?php echo @$this->session->userdata['customer']['leads_convert']; ?>');
			 $('#leads_id').val('<?php echo @$this->session->userdata['customer']['leads_id']; ?>');
    return loadestimate();
  
	   });
		
    </script>
	<?php } 
			}
?>
	
<?php if ($lead_convert==1){  ?>
	<script type='text/javascript'>
  	$(window).on('load', function() {
    $('#mobile').val('<?php echo $leads->mobile; ?>').trigger('change');
    });
	</script>

<?php } ?>

<?php $this->session->unset_userdata('customer'); ?>
<?php }  ?>
	  