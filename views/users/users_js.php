<?php if($this->uri->segment(2) == 'list_users'){ ?>
<script type="text/javascript"> 
    $(document).ready(function(){
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
              ajax: {"url": "<?php echo base_url().'users/get_users'?>", "type": "POST"},
                    columns: [
                        {"data": "id"},
                        {"data": "pic"},
                        {"data": "firstname"},
                        {"data": "lastname"},
                        {"data": "mobile"},
                        {"data": "email"},
                        {"data": "city"},  
                        {"data": "department"},
                        {"data": "action"}
					],
		  columnDefs: [
					   { orderable: false, targets: [1,8] },
			  			{ serachable: false, targets: [1,8] }
					],
                order: [[2, 'asc']],
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
            var code=$(this).data('user_id');
                        var name=$(this).data('name');
                        var mobile=$(this).data('price');
                        var city=$(this).data('city');
                        var area=$(this).data('area');
                        var channel=$(this).data('channel');
            $('#ModalUpdate').modal('show');
            			$('[name="user_id"]').val(code);
                        $('[name="name"]').val(name);
                        $('[name="mobile"]').val(mobile);
                        $('[name="city"]').val(city).trigger('change');
                        $('[name="area"]').val(area).trigger('change');
                        $('[name="channel"]').val(channel).trigger('change');
      					});
            // End Edit Records
            // get delete Records
            $('#listtable').on('click','.delete_record',function(){
            var code=$(this).data('user_id');
            $('#ModalDelete').modal('show');
            $('[name="user_id"]').val(code);
      });
            // End delete Records
    }); 

	
</script>
<?php } if($this->uri->segment(2) == 'edit_user' || $this->uri->segment(2) == 'add_user'){ ?>

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
	
	<?php if($this->uri->segment(2) == 'add_user'){ ?>
	$('#mobile').change(function () {
	var mobileval = $(this).val();
	$('#password').val(mobileval);	
	});
						  
	$('#email').change(function () {
	var emailval = $(this).val();
	$('#username').val(emailval);		
	}); 			  
	<?php } ?>	
						 
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
                firstname: {
                  required: true,
                  number: false,

              },
				lastname: {
                  required: true,
                  number: false,

              },
              // address: {
             //     required: true,

             // },
             city: {
                  required: true,
              },
              //area: {
//                  required: true,
//              },
//              pincode: {
//                  required: true,
//              },
//              google_map: {
//                  required: true,
//              },
              department: {
                  required: true,
              },
            //  address_type: {
            //      required: true,
            //  },
            } 
		
	
	
		
            });
	
	$("#add_address_form").validate({
            rules: { 
               address: {
                  required: true,

              },
             city: {
                  required: true,
              },
            //  area: {
            //      required: true,
            //  },
            //  pincode: {
            //      required: true,
            //  },
            //  google_map: {
           //       required: true,
           //   },
           //   channel: {
          //        required: true,
          //    },
          //    address_type: {
          //        required: true,
           //   },
            } 
		 
		
            });
	
	

    $('#firstname').keypress(function (e) {
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
	
	
	
    $('#lastname').keypress(function (e) {
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
<?php }  ?>