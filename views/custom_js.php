<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
    
<script type="text/javascript"> 
function reset_on_cancelbtn(custom_url) {	
	
	<?php
	$currentURL = current_url(); //http://myhost/main 
	$params   = $_SERVER['QUERY_STRING']; //my_id=1,3 
	if($params !== ''){ 
	$fullURL = $currentURL . '?' . $params; 
	}else{ 
	$fullURL = $currentURL; 
	}
	?>
	
	if(custom_url == ''){ custom_url='<?php echo $fullURL; ?>' } 
	
	$.ajax({
    type: "POST",
    url: "<?php echo base_url(); ?>generals/cancel_btn",
	data: {'page': '<?php echo $fullURL; ?>', 'custom_url': custom_url},
	success: function(urltogo){
         
        if(urltogo !== ""){
           window.location.href = urltogo;
        }
    },
    error: function(urltogo){
       // alert('Error: cannot load page.');
    }
	});
}
	
	
	$(document).on('show.bs.modal', '.modal', function () {
  $(this).appendTo('body');
});
	
	$(document).on('keyup keypress', 'form input[type="text"]', function(e) {
  if(e.keyCode == 13) {
    e.preventDefault();
    return false;
  } 
		
});
	
	$(document).ready(function(){ 
			
				
				$("#mobile").on("change", function(){
        var mobNum = $(this).val();
        var filter = /^\d*(?:\.\d{1,2})?$/;

          if (filter.test(mobNum)) {
            if(mobNum.length==10){
              $("#mobile-valid").removeClass("hidden");
              $("#folio-invalid").addClass("hidden");
             } else {
				 $("#mobile").val();
                alert('Please enter 10  digit mobile number');
               $("#folio-invalid").removeClass("hidden");
               $("#mobile-valid").addClass("hidden");
                return false;
              }
            }
            else {
              alert('Not a valid number');
              $("#folio-invalid").removeClass("hidden");
              $("#mobile-valid").addClass("hidden");
              return false;
           }
    
  });
		
		
		
	});
	
	 var spares_array = <?php if(!empty($spares_array)){ echo json_encode($spares_array); }else{ echo '[]'; } ?>; 
     var labour_array = <?php if(!empty($labour_array)){ echo json_encode($labour_array); }else{ echo '[]'; }  ?>;		
     var complaints_counter = <?php if(!empty($this->session->userdata('complain_counter'))){ echo $this->session->userdata('complain_counter'); }else{ echo '1'; } ?>;	 
     var complain_array = <?php if(!empty($this->session->userdata('complain_array'))){ echo json_encode($this->session->userdata('complain_array')); }else{ echo '[]'; } ?>;
     var newcomplaintslist = '';	
     var old_complaints_selected  = $('#all_selected_complaints').val();	
     var service_category_array = [];	
     var estimate_table = $('#estimate_table').DataTable({ paging: false, searching: false, ordering:false, info:false}); 
     var counter = <?php   if(!empty($this->session->userdata('estimate_counter'))){ echo $this->session->userdata('estimate_counter'); }else{ echo '1'; } ?>;	  
	 	 
    $(document).ready(function(){	
		// GET USERS
		$(".select-ajax-users").select2({
        placeholder: "Search",
        minimumInputLength: 1,
		width: 'resolve',
		allowClear: false,	
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: "<?php echo base_url(); ?>generals/users_dropdown/",
            type: "post",
   			dataType: 'json',
			delay: 250, 
            data: function (params) {
                return {
						q: params.term, // search term
						page: params.page
					  };
				},
				processResults: function (data, params) {
		  params.page = params.page || 1;
		  return {
			results: data,
			pagination: {
			  more: (params.page * 30) < data.total_count
			} 
		  };
		},cache: true
			}
		});
		
		
		// GET SERVICE PROVIDERS
		$(".select-ajax-service-providers").select2({
        placeholder: "Search",
        minimumInputLength: 1,
		width: 'resolve',
		allowClear: false,
			
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: "<?php echo base_url(); ?>generals/service_providers_dropdown/",
             type: "post",
   			dataType: 'json',
			delay: 250, 
            data: function (params) {
                return {
						q: params.term, // search term
						page: params.page
					  };
            },
            processResults: function (data, params) {
      params.page = params.page || 1;
      return {
        results: data,
        pagination: {
          more: (params.page * 30) < data.total_count
        } 
      };
    },cache: true
        }
    });
		
		
		
		// GET CHANNEL
		$(".select-ajax-channel").select2({
        placeholder: "Search",
        minimumInputLength: 0,
		width: 'resolve',
		allowClear: false,
			
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: "<?php echo base_url(); ?>generals/channel_dropdown/",
             type: "post",
   			dataType: 'json',
			delay: 250, 
            data: function (params) {
                return {
						q: params.term, // search term
						page: params.page
					  };
            },
            processResults: function (data, params) {
      params.page = params.page || 1;
      return {
        results: data,
        pagination: {
          more: (params.page * 30) < data.total_count
        } 
      };
    },cache: true
        }
    });
		
		
	// GET CITY
		$(".select-ajax-city").select2({
        placeholder: "Search",
        minimumInputLength: 1,
		width: 'resolve',
		allowClear: false,
			
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: "<?php echo base_url(); ?>generals/city_dropdown/",
             type: "post",
   			dataType: 'json',
			delay: 250, 
            data: function (params) {
                return {
						q: params.term, // search term
						page: params.page
					  };
            },
            processResults: function (data, params) {
      params.page = params.page || 1;
      return {
        results: data,
        pagination: {
          more: (params.page * 30) < data.total_count
        } 
      };
    },cache: true
        }
    });
		
		
	$(".select-ajax-city").change(function(){
    	$(".select-ajax-area").val('');
		$(".select-ajax-area").trigger('change');
		
		$(".input-pincode").val('');
		$(".input-zone").val('');
		$(".google_map").val('');
		$(".longitude").val('');
		$(".latitude").val(''); 
	 
			
	});
		
		
		
	 //GET AREA FROM CITY
	$(".select-ajax-area").select2({
        placeholder: "Search",
        minimumInputLength: 1,
		width: 'resolve',
		allowClear: false,
			
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: "<?php echo base_url(); ?>generals/area_dropdown/",
             type: "post",
   			dataType: 'json',
			delay: 250, 
            data: function (params) {
                return {
						q: params.term, // search term
						page: params.page,
						city: $('#city').val(),
					  };
            },
            processResults: function (data, params) {
      params.page = params.page || 1;
      return {
        results: data,
        pagination: {
          more: (params.page * 30) < data.total_count
        } 
      };
    },cache: true
        },
		templateSelection: function (data, container) {
    // Add custom attributes to the <option> tag for the selected option
    $(data.element).attr('data-pincode', data.pincode);
	$(data.element).attr('data-zone', data.zone);		
    return data.text;
  }
    });
		
	 //POPULATE PINCODE ON AREA CHANGE
		$('.select-ajax-area').change(function(){
    	var pincode = ($(this).find(':selected').data('pincode'));; 
		$('.input-pincode').val(pincode);
		});
	//POPULATE ZONE ON AREA CHANGE	
		$('.select-ajax-area').change(function(){
    	var zone = ($(this).find(':selected').data('zone'));; 
		$('.input-zone').val(zone);
		});
		
		 $('.select-ajax-area').on('select2:open', function (e) {  
		if($('.select-ajax-city').val()===''){
					swal('Ahh!', "Please select proper 'City' first.", 'warning', { buttons: false, timer: 2000,  });  
				}	
	 
	});
		
		////GET MAKE
		$(".select-ajax-make").select2({
        placeholder: "Search",
        minimumInputLength: 1,
		width: 'resolve',
		allowClear: false,	
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: "<?php echo base_url(); ?>generals/make_dropdown/",
             type: "post",
   			dataType: 'json',
			delay: 250, 
            data: function (params) {
                return {
						q: params.term, // search term
						page: params.page
					  };
            },
            processResults: function (data, params) {
      params.page = params.page || 1;
      return {
        results: data,
        pagination: {
          more: (params.page * 30) < data.total_count
        } 
      };
    },cache: true
        }
    });
	
	$(".select-ajax-make").change(function(){
    	$(".select-ajax-model").val('');
		$(".select-ajax-model").trigger('change');
		$("#reg_no").val('');
		$("#yom").val('');
		$("#km_reading").val(''); 
		$(".select-ajax-service-category").val('');
		$(".select-ajax-service-category").trigger('change');
	});
		
		 //GET MODEL FROM MAKE
	$(".select-ajax-model").select2({
        placeholder: "Search",
        minimumInputLength: 1,
		width: 'resolve',
		allowClear: false,
			
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: "<?php echo base_url(); ?>generals/model_dropdown/",
             type: "post",
   			dataType: 'json',
			delay: 250, 
            data: function (params) {
                return {
						q: params.term, // search term
						page: params.page,
						make_id: $('#make').val(),
					  };
            },
            processResults: function (data, params) {
      params.page = params.page || 1;
      return {
        results: data,
        pagination: {
          more: (params.page * 30) < data.total_count
        } 
      };
    },cache: true
        },
		templateSelection: function (data, container) {
    // Add custom attributes to the <option> tag for the selected option
    $(data.element).attr('data-vehiclecategory', data.vehiclecategory);
	$(data.element).attr('data-modelcode', data.modelcode);		
    return data.text;
  }
    });
		
	 $('.select-ajax-model').on('select2:open', function (e) {  
		if($('.select-ajax-make').val()===''){
					swal('Ahh!', "Please select proper 'Make' first.", 'warning', { buttons: false, timer: 2000,  });  
				}	
	 
	});
		
		
		
		
	 //POPULATE VEHICLE CATEGORY ON MODEL CHANGE
		$('.select-ajax-model').change(function(){
    	var vehiclecategory = ($(this).find(':selected').data('vehiclecategory'));; 
		$('.input-vehiclecategory').val(vehiclecategory);
		});
	//POPULATE MODEL CODE ON MODEL CHANGE
		$('.select-ajax-model').change(function(){
    	var modelcode = ($(this).find(':selected').data('modelcode'));; 
		$('.input-modelcode').val(modelcode);
		});
		
	 
	
	
	 //GET SERVICE CATEGORY
	$(".select-ajax-service-category").select2({
        placeholder: "Search",
        minimumInputLength: 1,
		width: 'resolve',
		allowClear: false,
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: "<?php echo base_url(); ?>generals/service_category_dropdown/",
             type: "post",
   			dataType: 'json',
			delay: 250, 
            data: function (params) {
                return {
						q: params.term, // search term
						page: params.page,
						vehiclecategory: $('.input-vehiclecategory').val(), 
						city: $('.select-ajax-city').val(),
						area: $('.select-ajax-area').val(),
					  }; 
            },
            processResults: function (data, params) {
      params.page = params.page || 1;
      return {
        results: data,
        pagination: {
          more: (params.page * 30) < data.total_count
        } 
      };
    },cache: true
        },
		templateSelection: function (data, container) {
    // Add custom attributes to the <option> tag for the selected option
    $(data.element).attr('data-categoryrates', data.category_rates); 
	$(data.element).attr('data-service_name', data.text);		
    return data.text;
  }
    });
	
	 $('.select-ajax-service-category').on('select2:open', function (e) {  
		if($('.select-ajax-area').val()===''){
					swal('Ahh!', "Please select proper  'City' & 'Area'  first.", 'warning', { buttons: false, timer: 2000,  });  
				}
		 if($('.input-modelcode').val()==='' || $('.input-vehiclecategory').val()===''){
					swal('Ahh!', "Please select proper 'Model' first.", 'warning', { buttons: false, timer: 2000,  });  
				}
	 
	});
		
		
	//GET SERVICE CATEGORY
	$("#select-ajax-service-category").select2({
        placeholder: "Search",
        minimumInputLength: 1,
		width: 'resolve',
		allowClear: false,
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: "<?php echo base_url(); ?>generals/service_category_dropdown/",
             type: "post",
   			dataType: 'json',
			delay: 250, 
            data: function (params) {
                return {
						q: params.term, // search term
						page: params.page,
						vehiclecategory: $('.input-vehiclecategory').val(), 
						city: $('.select-ajax-city').val(),
						area: $('.select-ajax-area').val(),
					  }; 
            },
            processResults: function (data, params) {
      params.page = params.page || 1;
      return {
        results: data,
        pagination: {
          more: (params.page * 30) < data.total_count
        } 
      };
    },cache: true
        },
		templateSelection: function (data, container) {
    // Add custom attributes to the <option> tag for the selected option
    $(data.element).attr('data-categoryrates', data.category_rates); 
	$(data.element).attr('data-service_name', data.text);		
    return data.text;
  }
    });
	
	 $('#select-ajax-service-category').on('select2:open', function (e) {  
		if($('.select-ajax-area').val()===''){
					swal('Ahh!', "Please select proper  'City' & 'Area'  first.", 'warning', { buttons: false, timer: 2000,  });  
				}
		 if($('.input-modelcode').val()==='' || $('.input-vehiclecategory').val()===''){
					swal('Ahh!', "Please select proper 'Model' first.", 'warning', { buttons: false, timer: 2000,  });  
				}
	 
	});
		//POPULATE TABLE ON SERVICE CATEGORY CHANGE
	$("#select-ajax-service-category").change(function(){  
			var service_category = $(this).find(':selected').data('service_name');
			var itemtype = $(this).find(':selected').data('itemtype'); 
			var sparesrates = 0; 
			var labourrates = $(this).find(':selected').data('categoryrates'); 
			var totalrates = $(this).find(':selected').data('categoryrates'); 
			var sparesid = ''; 
			var itemcode = ''; 
			var itemname = service_category; 
			if($.inArray(service_category, service_category_array) != -1){
				swal('Ahh!', "This Service Category already selected.", 'warning', { buttons: false, timer: 2000,  });  	
				}else{
		   if(service_category !== ""){     
			$('#service_category_rate').val(totalrates); 	 
 			$(".selected_service_category").append('<div id="selected_'+service_category+'" class="badge badge-info mr-2">'+itemname+'</div>');
        counter++;  
			   service_category_array.push(service_category); 	 
		   }
		   }
	  });
		
		
	 //GET TIME SLOT
	$(".select-ajax-time-slot").select2({
        placeholder: "Search",
        minimumInputLength: 0,
		width: 'resolve',
		allowClear: false,
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: "<?php echo base_url(); ?>generals/timeslot_dropdown/",
             type: "post",
   			dataType: 'json',
			delay: 250, 
            data: function (params) {
                return {
						q: params.term, // search term
						page: params.page, 
					  };
            },
            processResults: function (data, params) {
      params.page = params.page || 1;
      return {
        results: data,
        pagination: {
          more: (params.page * 30) < data.total_count
        } 
      };
    },cache: true
        }
    });	
		
		//GET ITEMS LIST
	$(".select-ajax-items").select2({
        placeholder: "Search",
        minimumInputLength: 1,
		width: 'resolve',
		allowClear: false,
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: "<?php echo base_url(); ?>generals/items_dropdown/",
             type: "post",
   			dataType: 'json',
			delay: 250, 
            data: function (params) {
                return {
						q: params.term, // search term
						page: params.page, 
					  }; 
            },
            processResults: function (data, params) {
      params.page = params.page || 1;
      return {
        results: data,
        pagination: {
          more: (params.page * 30) < data.total_count
        } 
      };
    },cache: true
        },
		templateSelection: function (data, container) {
    // Add custom attributes to the <option> tag for the selected option  
    $(data.element).attr('data-itemname', data.itemname);  
    return data.text;
  }
    });
	
		 
		
		
	 $('.select-ajax-spares').on('select2:open', function (e) {  
		 
		 if($('.input-modelcode').val()==='' || $('.input-vehiclecategory').val()===''){
					swal('Ahh!', "Please select proper 'Model' first.", 'warning', { buttons: false, timer: 2000,  });  
				}
		  if($('.select-ajax-area').val()===''){
					swal('Ahh!', "Please select proper 'City' & 'Area' first.", 'warning', { buttons: false, timer: 2000,  });
		  }
		  if($('.select-ajax-channel').val()===''){
					swal('Ahh!', "Please select proper 'Channel' first.", 'warning', { buttons: false, timer: 2000,  });	  
		}
	 
	});
		
		
		
		
		//GET SPARES LIST
	$(".select-ajax-spares").select2({
        placeholder: "Search",
        minimumInputLength: 1,
		width: 'resolve',
		allowClear: false,
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: "<?php echo base_url(); ?>generals/spares_dropdown/",
             type: "post",
   			dataType: 'json',
			delay: 250, 
            data: function (params) {
                return {
						q: params.term, // search term
						page: params.page,
						vehiclecategory: $('.input-vehiclecategory').val(), 
						modelcode: $('.input-modelcode').val(),
						city: $('#city').val(),
						channel: $('#channel').val(),
					  }; 
            },
            processResults: function (data, params) {
      params.page = params.page || 1;
      return {
        results: data,
        pagination: {
          more: (params.page * 30) < data.total_count
        } 
      };
    },cache: true
        },
		templateSelection: function (data, container) {
    // Add custom attributes to the <option> tag for the selected option
    $(data.element).attr('data-itemtype', data.itemtype); 
    $(data.element).attr('data-sparesrates', data.sparesrates); 
    $(data.element).attr('data-labourrates', data.labourrates); 
    $(data.element).attr('data-totalrates', data.totalrates); 
    $(data.element).attr('data-sparesid', data.sparesid); 
    $(data.element).attr('data-itemcode', data.itemcode); 
    $(data.element).attr('data-itemname', data.itemname); 
    $(data.element).attr('data-itemid', data.itemid); 
    $('#brand_div').html(data.brand); 
    return data.text;
  }
    });
	
		 
		
		
	 $('.select-ajax-spares').on('select2:open', function (e) {  
		 
		 if($('.input-modelcode').val()==='' || $('.input-vehiclecategory').val()===''){
					swal('Ahh!', "Please select proper 'Model' first.", 'warning', { buttons: false, timer: 2000,  });  
				}
		  if($('.select-ajax-area').val()===''){
					swal('Ahh!', "Please select proper 'City' & 'Area' first.", 'warning', { buttons: false, timer: 2000,  });
		  }
		  if($('.select-ajax-channel').val()===''){
					swal('Ahh!', "Please select proper 'Channel' first.", 'warning', { buttons: false, timer: 2000,  });	  
		}
	 
	});
		
		
			//GET LABOUR LIST
	$(".select-ajax-spares-brand").select2({
        placeholder: "Search",
        minimumInputLength: 0,
		width: 'resolve',
		allowClear: false,
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: "<?php echo base_url(); ?>generals/spares_brand_dropdown/",
             type: "post",
   			dataType: 'json',
			delay: 250, 
            data: function (params) { 
                return {
						q: params.term, // search term
						page: params.page,
						spareid: $(this).data("spareid"), 
					  }; 
            },
            processResults: function (data, params) {
      params.page = params.page || 1;
      return {
        results: data,
        pagination: {
          more: (params.page * 30) < data.total_count
        } 
      };
    },cache: true
        },
		templateSelection: function (data, container) {
    // Add custom attributes to the <option> tag for the selected option
    $(data.element).attr('data-brandrate', data.brand_rate);  
    return data.text;
  }
    });
		
		// Initialize select2

		//GET LABOUR LIST
	$(".select-ajax-labour").select2({
        placeholder: "Search",
        minimumInputLength: 1,
		width: 'resolve',
		allowClear: false,
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: "<?php echo base_url(); ?>generals/labour_dropdown/",
             type: "post",
   			dataType: 'json',
			delay: 250, 
            data: function (params) {
                return {
						q: params.term, // search term
						page: params.page,
						vehiclecategory: $('.input-vehiclecategory').val(), 
						modelcode: $('.input-modelcode').val(),
						city: $('#city').val(),
					  }; 
            },
            processResults: function (data, params) {
      params.page = params.page || 1;
      return {
        results: data,
        pagination: {
          more: (params.page * 30) < data.total_count
        } 
      };
    },cache: true
        },
		templateSelection: function (data, container) {
    // Add custom attributes to the <option> tag for the selected option
    $(data.element).attr('data-itemtype', data.itemtype); 
    $(data.element).attr('data-sparesrates', data.sparesrates); 
    $(data.element).attr('data-labourrates', data.labourrates); 
    $(data.element).attr('data-totalrates', data.totalrates); 
    $(data.element).attr('data-sparesid', data.sparesid); 
    $(data.element).attr('data-itemcode', data.itemcode); 
    $(data.element).attr('data-itemname', data.itemname); 
    $(data.element).attr('data-itemid', data.itemid); 
    return data.text;
  }
    });
	
		  
		
	 $('.select-ajax-labour').on('select2:open', function (e) {  
		 
		 if($('.input-modelcode').val()==='' || $('.input-vehiclecategory').val()===''){
					swal('Ahh!', "Please select proper 'Model' first.", 'warning', { buttons: false, timer: 2000,  });  
		}
		 if($('.select-ajax-area').val()===''){
					swal('Ahh!', "Please select proper 'City' & 'Area' first.", 'warning', { buttons: false, timer: 2000,  });  
		}
	 
	});
		
		
	
		
	$('#estimate_table tbody').on( 'click', '.btn-delete', function () {
		var currentrow = $(this).parents('tr');
		var getitemvalue = currentrow.find('.input_itemcode').val();
		$('#selected_'+getitemvalue).remove();
		estimate_table
			.row( $(this).parents('tr') )
			.remove()
			.draw();
		
		var which_type = currentrow.find('.itemtype').val();
		
		removeThis_fromArray(which_type, getitemvalue);
		 
		calculateColumn();
		 
	});
	
		$('.select-ajax-spares-brand').change(function(){ 
			
			var brand_rate = $(this).find(':selected').data('brandrate');  
			var next_spares = $(this).parents('tr').find('.spares_amount');
			//alert(next_spares.val());
			next_spares.val(brand_rate).change();
			calculateColumn();
			 
		});
		
	 
		// add row
    $('.add-row').click(function () { 
        var rowHtml = $("#estimate_table").find("tr")[0].outerHTML 
        estimate_table.row.add($(rowHtml)).draw();
    });
	
	//POPULATE TABLE ON SERVICE CATEGORY CHANGE
	$(".select-ajax-service-category").change(function(){  
			var service_category = $(this).find(':selected').data('service_name');
			var itemtype = $(this).find(':selected').data('itemtype'); 
			var sparesrates = 0; 
			var labourrates = $(this).find(':selected').data('categoryrates'); 
			var totalrates = $(this).find(':selected').data('categoryrates'); 
			var sparesid = ''; 
			var itemcode = ''; 
			var itemname = service_category; 
			if($.inArray(service_category, service_category_array) != -1){
				swal('Ahh!', "This Service Category already selected.", 'warning', { buttons: false, timer: 2000,  });  	
				}else{
		   if(service_category !== ""){    
			  estimate_table.clear().draw();  
			  counter = 1; 
			 estimate_table.row.add( [
            '<input type="hidden" name="estimate_row[]" value="'+ counter + '"><input type="hidden" name="item_id[]" value="'+ service_category + '"><input type="hidden" name="complaint_number[]" value="0"><input type="hidden" name="complaints[]" value=""><input type="hidden" class="itemtype" name="itemtype[]" value="Service Category">'+ counter,
            '<input type="hidden" class="input_itemcode" name="sparesid[]" value="'+ service_category + '"><input type="hidden" name="item_name[]" value="'+ itemname + '">'+ itemname,
            '<input type="text" name="quantity[]" tabindex="1" id="quantity_'+ counter + '" onclick="row_sum('+ counter + ')" size="2" value="1" class="form-control col-4" onkeyup="row_sum('+ counter + ')">',
            '<input type="text" name="spares_rate[]" class="form-control spares_amount"  required onkeyup="row_sum('+ counter + ')" onchange="row_sum('+ counter + ')"  id="spares_'+ counter + '" size="6" value="'+ sparesrates + '">',
            '<input type="text" name="labour_rate[]" class="form-control"  required onkeyup="row_sum('+ counter + ')"  id="labour_'+ counter + '" size="6" value="'+ labourrates + '">',
			'<input type="text" name="total_rate[]"  class="form-control input-totalrate" required onkeyup="row_sum('+ counter + ')"  id="total_'+ counter + '" size="6" value="'+ totalrates + '">',
			'<button type="button" class="btn btn-danger btn-delete"><i class="fas fa-trash"></i></button>'	 	 
        ] ).draw();
 			$(".selected_service_category").append('<div id="selected_'+service_category+'" class="badge badge-info mr-2">'+itemname+'</div>');
        counter++; 
		
			   spares_array = [];	
			      labour_array = [];	
				  service_category_array = [];
			   $(".selected_spares").html();
			   $(".selected_labour").html();
			   service_category_array.push(service_category);
		   calculateColumn();	 
		   }
		   }
	  });
		
		
			    
		
		
	//POPULATE TABLE ON SPECIFIC SPARES CHANGE
	$(".select-ajax-spares").change(function(){  
			var spares = $(this).val();
			var itemtype = $(this).find(':selected').data('itemtype'); 
			var sparesrates = $(this).find(':selected').data('sparesrates'); 
			var labourrates = $(this).find(':selected').data('labourrates'); 
			var totalrates = $(this).find(':selected').data('totalrates'); 
			var sparesid = $(this).find(':selected').data('sparesid'); 
			var itemcode = $(this).find(':selected').data('itemcode'); 
			var itemname = $(this).find(':selected').data('itemname'); 
			var itemid = $(this).find(':selected').data('itemid'); 
			 var brandoptions = $('#brand_div').html();
			if($.inArray(spares, spares_array) != -1){
				swal('Ahh!', "This Spare already selected.", 'warning', { buttons: false, timer: 2000,  });  	
				}else{
			initailizeBrand();		
		   if(spares !== ""){   
			 estimate_table.row.add( [
            '<input type="hidden" name="estimate_row[]" value="'+ counter + '"><input type="hidden" name="item_id[]" value="'+ spares + '"><input type="hidden" name="complaint_number[]" value="0"><input type="hidden" name="complaints[]" value=""><input type="hidden" class="itemtype" name="itemtype[]" value="'+ itemtype +'">'+ counter,
            '<input type="hidden" class="input_itemcode" name="sparesid[]" value="'+ spares + '"><input type="hidden" name="itemid[]" value="'+ itemid + '"><input type="hidden" name="item_name[]" value="'+ itemname + '"><input type="hidden" name="jobdet_ID[]" value="0">'+ itemname,
			<?php if($this->uri->segment(2) == "create_jobcard" || $this->uri->segment(2) == "edit_jobcard") { ?> 
			 '<select class="form-control select-ajax-spares-brand" name="brand[]" data-spareid="'+ sparesid + '"  width="100%;" id="brand_'+ counter + '">'+brandoptions+'</select>',	 
			<?php } ?>	 
            '<input type="text" name="quantity[]" tabindex="1" id="quantity_'+ counter + '" onclick="row_sum('+ counter + ')" size="2" value="1" class="form-control" onkeyup="row_sum('+ counter + ')">',
            '<input type="text" name="spares_rate[]" class="form-control spares_amount"  required onkeyup="row_sum('+ counter + ')" onchange="row_sum('+ counter + ')"  id="spares_'+ counter + '" size="6" value="'+ sparesrates + '">',
            '<input type="text" name="labour_rate[]" class="form-control"  required onkeyup="row_sum('+ counter + ')"  id="labour_'+ counter + '" size="6" value="'+ labourrates + '">',
			'<input type="text" name="total_rate[]"  class="form-control input-totalrate" required onkeyup="row_sum('+ counter + ')"  id="total_'+ counter + '" size="6" value="'+ totalrates + '">',
			'<button type="button" class="btn btn-danger btn-delete"><i class="fas fa-trash"></i></button>'	 	 
        ] ).draw();
 			$(".selected_spares").append('<div id="selected_'+spares+'" class="badge badge-info mr-2">'+itemname+'</div>');
        counter++;
       calculateColumn();
        	spares_array.push(spares);
			initailizeBrand();   
		   }
		   }
	  });
	
	 //POPULATE TABLE ON SPECIFIC LABOUR CHANGE
	$(".select-ajax-labour").change(function(){  
			var labour = $(this).val();
			var itemtype = $(this).find(':selected').data('itemtype'); 
			var sparesrates = $(this).find(':selected').data('sparesrates'); 
			var labourrates = $(this).find(':selected').data('labourrates'); 
			var totalrates = $(this).find(':selected').data('totalrates'); 
			var sparesid = $(this).find(':selected').data('sparesid'); 
			var itemcode = $(this).find(':selected').data('itemcode'); 
			var itemname = $(this).find(':selected').data('itemname'); 
			var itemid = $(this).find(':selected').data('itemid'); 
			if($.inArray(labour, labour_array) != -1){
				swal('Ahh!', "This Labour already selected.", 'warning', { buttons: false, timer: 2000,  });  	
				}else{  
		   if(labour !== ""){   
			 estimate_table.row.add( [
            '<input type="hidden" name="estimate_row[]" value="'+ counter + '"><input type="hidden" name="item_id[]" value="'+ labour + '"><input type="hidden" name="complaint_number[]" value="0"><input type="hidden" name="complaints[]" value=""><input type="hidden" class="itemtype" name="itemtype[]" value="'+ itemtype +'">'+ counter,
            '<input type="hidden" class="input_itemcode" name="labourid[]" value="'+ labour + '"><input type="hidden" name="itemid[]" value="'+ itemid + '"><input type="hidden" name="item_name[]" value="'+ itemname + '"><input type="hidden" name="jobdet_ID[]" value="0">'+ itemname,
			<?php if($this->uri->segment(2) == "create_jobcard" || $this->uri->segment(2) == "edit_jobcard") { ?> 
			 '<select class="form-control select2"  width="100%;" name="brand[]" id="brand_'+ counter + '"><option selected value="">NA</option></select>',	 
			<?php } ?>	 
            '<input type="text" name="quantity[]" tabindex="1" id="quantity_'+ counter + '" onclick="row_sum('+ counter + ')" size="2" value="1" class="form-control" onkeyup="row_sum('+ counter + ')">',
            '<input type="text" name="spares_rate[]" class="form-control spares_amount"  required onkeyup="row_sum('+ counter + ')" onchange="row_sum('+ counter + ')"  id="spares_'+ counter + '" size="6" value="'+ sparesrates + '">',
            '<input type="text" name="labour_rate[]" class="form-control"  required onkeyup="row_sum('+ counter + ')"  id="labour_'+ counter + '" size="6" value="'+ labourrates + '">',
			'<input type="text" name="total_rate[]" class="form-control input-totalrate"  required onkeyup="row_sum('+ counter + ')"  id="total_'+ counter + '" size="6" value="'+ totalrates + '">',
			'<button type="button" class="btn btn-danger btn-delete"><i class="fas fa-trash"></i></button>'	 	 
        ] ).draw();
 			$(".selected_labour").append('<div id="selected_'+labour+'" class="badge badge-info mr-2">'+itemname+'</div>');
        counter++;
        calculateColumn();
        	labour_array.push(labour);
		   }
		}
	  });
		
		
		
			//GET COMPLAINTS LIST
	$(".select-ajax-complaints").select2({
        placeholder: "Search",
        minimumInputLength: 1,
		width: 'resolve',
		allowClear: false,
			
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: "<?php echo base_url(); ?>generals/complaints_dropdown/",
             type: "post",
   			dataType: 'json',
			delay: 250, 
            data: function (params) {
                return {
						q: params.term, // search term
						page: params.page
					  };
            },
            processResults: function (data, params) {
      params.page = params.page || 1;
      return {
        results: data,
        pagination: {
          more: (params.page * 30) < data.total_count
        } 
      };
    },cache: true
        }
    });
	
		 $('.select-ajax-complaints').on('select2:open', function (e) {  
		 
		 if($('.input-modelcode').val()==='' || $('.input-vehiclecategory').val()===''){
					swal('Ahh!', "Please select proper 'Model' first.", 'warning', { buttons: false, timer: 2000,  });  
				}
		  if($('.select-ajax-area').val()===''){
					swal('Ahh!', "Please select proper 'City' & 'Area' first.", 'warning', { buttons: false, timer: 2000,  });
		  }
		  if($('.select-ajax-channel').val()===''){
					swal('Ahh!', "Please select proper 'Channel' first.", 'warning', { buttons: false, timer: 2000,  });	  
		}
	 
	});
	
	//POPULATE COMPLAINT & COMPLAINTS OPTION TABLES
	$(".select-ajax-complaints").change(function(){  
			var complaint = $(this).val();
			var vehiclecategory = $('.input-vehiclecategory').val();
		  	var modelcode = $('.input-modelcode').val(); 
			var channel = $('.select-ajax-channel').val();
			var city = $('.select-ajax-city').val();	 
			var complain_array_count = (complain_array.length+1);
		   if(complaint !== ""){    
			var body = '';	   
			   $.ajax({
            url: '<?=base_url();?>generals/complaint_options/',
            type: 'POST',
            data: {'complaint': complaint, 'vehiclecategory': vehiclecategory, 'modelcode': modelcode, 'channel':channel, 'city':city, 'complaints_counter':complain_array_count},
            dataType: 'json',
            success: function (data) { 
				
				if($.inArray(data[0].complaints, complain_array) != -1){
				swal('Ahh!', "This Complaint already selected.", 'warning', { buttons: false, timer: 2000,  });  	
				}else{  
				if(data[0].complaints!==""){ 
					
					initailizeBrand();  
				
				//data[0].complaints_counter = data[0].count;
					
				data[0].complaints_counter =  complain_array_count;
					
			body += '<div class="card-complaints card card-info" id="card_complaints_'+data[0].complaints_counter+'"><div class="card-header"> <h4>Complaint '+data[0].complaints_counter+ ': ' + data[0].complaints + '</h4><input type="hidden" id="this_complaint_table_name_'+data[0].complaints_counter+'" value="'+data[0].complaints+'" /> <div class="card-header-action col-md-6"> <button type="button" class="btn btn-danger float-right" onclick="deleteComplaint('+data[0].complaints_counter+');"><i class="fas fa-trash"></i></button> </div>   </div> <div class="collapse show" id="complaint-collapse-'+data[0].complaints_counter+'" style="">  <div class="card-body"> <div class="row">';  
			body += '<table class="table table-striped tables-complaints" id="complaintstable_'+data[0].complaints_counter+'"><thead><th>Options</th><th>Description</th><th>Quantity</th><?php if($this->uri->segment(2) == "create_jobcard" || $this->uri->segment(2) == "edit_jobcard") { ?><th>Brand</th><?php } ?><th>Spares</th> <th>Labour</th> <th>Total</th></thead><tbody>';  
					var rowid=1;
				 $.each(data, function(i, data) {
					 data.count = complain_array_count;
					 
					 
					 
            body += '<tr><td><input type="hidden" name="estimate_row[]" value="'+ data.count + '"><input type="hidden" name="item_id[]" value="'+ data.itemid + '"><input type="hidden" name="complaint_number[]" value="'+ data.count + '"><input type="hidden" name="complaints[]" value="'+ data.complaints + '"><input type="hidden" class="itemtype" name="itemtype[]" value="Complaints">'+ data.options +'</td><td><input type="hidden" class="input_itemcode" name="complaint_id[]" value="'+ data.count + '"><input type="hidden" name="itemid[]" value="'+ data.itemid + '"><input type="hidden" name="item_name[]" value="'+ data.itemname + '">'+ data.itemname +'</td><td><input type="text" name="quantity[]" tabindex="1" id="quantity_'+ rowid + '" onclick="complain_row_sum('+ data.count + ', '+rowid+')" size="2" value="1" class="form-control col-6" onkeyup="complain_row_sum('+ data.count + ', '+rowid+')"></td><?php if($this->uri->segment(2) == "create_jobcard" || $this->uri->segment(2) == "edit_jobcard") { ?><td> <select width="100%;" class="form-control select-ajax-spares-brand" name="brand[]" data-spareid="'+ data.sparesid + '" id="brand_'+ data.count + '">'+data.brandlist+'</select></td><?php } ?><td><input type="text" name="spares_rate[]" class="form-control spares_amount"  required onkeyup="complain_row_sum('+ data.count + ', '+rowid+')" onchange="complain_row_sum('+ data.count + ', '+rowid+')"  id="spares_'+ rowid + '" size="6" value="'+ data.sparesrates + '"></td><td><input type="text" name="labour_rate[]" class="form-control"  required onkeyup="complain_row_sum('+ data.count + ', '+rowid+')"  id="labour_'+ rowid + '" size="6" value="'+ data.labourrates + '"></td><td><input type="text" name="total_rate[]" class="form-control input-complaint_totalrate"  required onkeyup="complain_row_sum('+ data.count + ', '+rowid+')"  id="total_'+ rowid + '" size="6" value="'+ data.totalrates + '"></td></tr>';
					rowid++; 
            });
			
			body += '</tbody></table></div></div></div></div>'; 		
			complaints_counter++; 
			   
			 
			 
					
			//$(".selected_complaints").append('<div id="selected_complaint_'+data[0].count+'" class="badge badge-info mr-2 selectedcomplain">'+data[0].complaints+'</div>'); 
			$("#complaints_tables_div").append(body); 			
			$('#complaintstable_'+data[0].count).DataTable({ paging: false, searching: false, ordering:false, info:false}); 		
			complain_array.push(data[0].complaints);
			selected_complaints();       	
			calculateColumn_Complaint();
				initailizeBrand(); 	
					
							}	
			}
						}
        			});
        	
		   	}
		    
	  });	
		
		
		
		 
			 $('#global_casefinder_booking_id').keyup(function () {
            $('#global_casefinder_result').html(''); 
            var img = "<?=base_url()?>";
            var searchField = $('#global_casefinder_booking_id').val(); 
     $.ajax({
     url:'<?=base_url()?>generals/get_booking_casefinder/'+searchField,
     method: 'POST',
     data: {searchField: searchField},
     dataType: 'json',
     success: function(data){
		 
		 if(data !== ''){ 
             $.each(data, function (key, value) {
				 
				 
				 
		   $('#global_casefinder_result').append('<div class="search-item"><a style="display:block;" href="' + img + 'bookings/booking_details/' + value.booking_id + '">' + '<b> Booking ID:' + value.booking_id+' </b><p><div class="ml-10 text-muted"> ' + value.customer_name + '  |  ' + value.customer_phone + '  |  ' + value.status + ' </div><span><small class="time text-right"> ' + value.service_date +' </small></span></p></a></div>');
			 });
		 }else{
			 $('#global_casefinder_result').html('');  
		 }
        }, 
    });
	});	
		 

        $('#global_casefinder_result').on('click', 'li', function () {
            var click_text = $(this).text().split('|');
            $('#global_casefinder_booking_id').val($.trim(click_text[0]));
            $("#global_casefinder_result").html('');
        });
		
		
           	
		selected_complaints();
		
         
		
    }); 
	
	function selected_complaints(){
				 
				 $('#all_selected_complaints').val(complain_array.join('+'));  
			$(".selected_complaints").html('');
				jQuery.each(complain_array, function( i, val ) {
					if(val!==''){ 
			$(".selected_complaints").append('<div id="selected_complaint_'+i+'" class="badge badge-info mr-2 selectedcomplain">'+val+'</div>'); 
					}
				});
			
			 }
	
	
	function initailizeBrand(){ 
   $(".select-ajax-spares-brand").select2({
        placeholder: "Search",
        minimumInputLength: 0,
		width: 'resolve',
		allowClear: false,
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: "<?php echo base_url(); ?>generals/spares_brand_dropdown/",
             type: "post",
   			dataType: 'json',
			delay: 250, 
            data: function (params) { 
                return {
						q: params.term, // search term
						page: params.page,
						spareid: $(this).data("spareid"), 
					  }; 
            },
            processResults: function (data, params) {
      params.page = params.page || 1;
      return {
        results: data,
        pagination: {
          more: (params.page * 30) < data.total_count
        } 
      };
    },cache: true
        },
		templateSelection: function (data, container) {
    // Add custom attributes to the <option> tag for the selected option
    $(data.element).attr('data-brandrate', data.brand_rate);  
    return data.text;
  }
    });
}
	
	
	function removeThis_fromArray(which_type, which_value){ 
			 
		if(which_type=="Spare"){ 
			if(Array.isArray(spares_array) && spares_array.length){ 
				spares_array = jQuery.grep(spares_array, function(value) {
				return value != which_value;
			   });
			}
		}else if(which_type=="Labour"){  
			if(Array.isArray(labour_array) && labour_array.length){ 	
		  	labour_array = jQuery.grep(labour_array, function(value) {
		  	return value != which_value;
		  	});
			} 
		}else if(which_type=="Service Category"){  
			if(Array.isArray(service_category_array) && service_category_array.length){ 	
			service_category_array = jQuery.grep(service_category_array, function(value) {
			return value != which_value;
			});
			}
		}else if(which_type=="Complaints"){  
			if(Array.isArray(complain_array) && complain_array.length){ 	
			complain_array = jQuery.grep(complain_array, function(value) {
		    return value != which_value;
			}); 
			 selected_complaints();
			}
		
		}
			
		}
	
	
        
        function calculateColumn() {  
			
			var estimate_tablerows = $("#estimate_table");
			var allEstimateTotal = 0; 
			estimate_tablerows.find(".input-totalrate").each(function () {
			if (!isNaN($(this).val())) {
			var stval = parseFloat($(this).val());
			allEstimateTotal += isNaN(stval) ? 0 : stval;
				 
			}
			});
			
			$('#total_estimate_sum').val(allEstimateTotal);
			calculatecombinedTotal();
        }
    
 
	 
			 
	
			function calculateColumn_Complaint() {    
				
				var complaintTableTotal_min = 0;
			   var complaintTableTotal_max = 0;
			$('.tables-complaints').each(function(index){  
				
				var	prices = []; 
				$(this).find('tr').each(function(){  
				var stval = $(this).find('.input-complaint_totalrate').val(); // parseFloat($(this).find('.input-complaint_totalrate').val());
				var thisRowTotal = isNaN(stval) ? 0 : stval; 
				prices.push(parseFloat(thisRowTotal));   
				}); 
				 
				var thistable_max = Math.max.apply(null,prices);
				var thistable_min = Math.min.apply(null,prices); 
				
				complaintTableTotal_max += thistable_max;
				complaintTableTotal_min += thistable_min;
				
				
			 
			}); 
				
				
				$('#max_complaints_val').val(complaintTableTotal_max);
				$('#min_complaints_val').val(complaintTableTotal_min);
				
				//alert('Max '+ thistable_max);
				//alert('Min '+ thistable_min);
				
				calculatecombinedTotal();	
				
        }
	
			
			function calculatecombinedTotal() {  
				
			var $totalEstimate_v =  parseFloat($('#total_estimate_sum').val());
			var $complaint_max_v =  parseFloat($('#max_complaints_val').val());  
			var $complaint_min_v = parseFloat($('#min_complaints_val').val());  
				
			var	$totalEstimate = isNaN($totalEstimate_v) ? 0 : $totalEstimate_v;
			var	$complaint_max = isNaN($complaint_max_v) ? 0 : $complaint_max_v;
			var	$complaint_min = isNaN($complaint_min_v) ? 0 : $complaint_min_v;	
				
				var $totalcombine_max = parseFloat($totalEstimate)+parseFloat($complaint_max);
				var $totalcombine_min = parseFloat($totalEstimate)+parseFloat($complaint_min);
				 
				$('#totalcombine_max').val($totalcombine_max);
				$('#totalcombine_min').val($totalcombine_min);
				
				var	totalprice = 0;
				var complainttotalprice = 0; 
				
			$('.input-totalrate').each(function(index){   
				var stval = $(this).val();  
				var thisRowTotal = isNaN(stval) ? 0 : stval;
				totalprice += +parseFloat(thisRowTotal);
				//totalprice.push(parseFloat(thisRowTotal));	  
			});
				
				$('.input-complaint_totalrate').each(function(index){   
				var stval = $(this).val();  
				var thisRowTotal = isNaN(stval) ? 0 : stval;
				complainttotalprice += +parseFloat(thisRowTotal);
				//totalprice.push(parseFloat(thisRowTotal));	  
			});
				
				
				$('#totalcombined_all').val(totalprice+complainttotalprice);
				
			}
				
			 
	
		function deleteComplaint(complaint_number){  
			
		var complaint_name = $('#this_complaint_table_name_'+complaint_number).val();	
		$('#card_complaints_'+complaint_number).remove();
		$("#selected_complaint_"+complaint_number).remove();  
		removeThis_fromArray('Complaints', complaint_name); 
		calculateColumn();	
		calculateColumn_Complaint();	 
		}
	
		function delete_complain_row(complaint_row_number){ 
		$('.tables-complaints').find('#complain_row_'+complaint_row_number).remove();
			 
		}
	
	//FUNCTION FOR LOCATION TO CONTROL MULTIPLE INPUTS THROUGH VARIABLES
	 function get_city(target){ 
	$('#'+target).select2({
        placeholder: "Search",
        minimumInputLength: 1,
		width: 'resolve',
		allowClear: false,
			
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: "<?php echo base_url(); ?>generals/city_dropdown/",
             type: "post",
   			dataType: 'json',
			delay: 250, 
            data: function (params) {
                return {
						q: params.term, // search term
						page: params.page
					  };
            },
            processResults: function (data, params) {
      params.page = params.page || 1;
      return {
        results: data,
        pagination: {
          more: (params.page * 30) < data.total_count
        } 
      };
    },cache: true
        }
    });
	}
	
	 function get_area(id){ 
	$('#area_'+id).select2({
        placeholder: "Search",
        minimumInputLength: 1,
		width: 'resolve',
		allowClear: false,
			
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: "<?php echo base_url(); ?>generals/area_dropdown/",
             type: "post",
   			dataType: 'json',
			delay: 250, 
            data: function (params) {
                return {
						q: params.term, // search term
						page: params.page,
						city: $('#city_'+id).val(),
					  };
            },
            processResults: function (data, params) {
      params.page = params.page || 1;
      return {
        results: data,
        pagination: {
          more: (params.page * 30) < data.total_count
        } 
      };
    },cache: true
        },
		templateSelection: function (data, container) {
    // Add custom attributes to the <option> tag for the selected option
    $(data.element).attr('data-pincode', data.pincode);
	$(data.element).attr('data-zone', data.zone);		
    return data.text;
  }
    });
	 }
		
	 
		function get_pincode(id){ 
		var pincode = $('#area_'+id).find(':selected').data('pincode')
		$('#pincode_'+id).val(pincode);
		}
	
		function get_zone(id){ 
		var zone = $('#area_'+id).find(':selected').data('zone')
		$('#zone_'+id).val(zone);
		}
		 
		
		function row_sum(id){
			var  quantity = $("#quantity_" + id).val();
			if(!$("#spares_" + id).val()){
					$("#spares_" + id).val('0');
				}
				if(!$("#labour_" + id).val()){
					$("#labour_" + id).val('0');
				}
			var spares_rate = parseInt($("#spares_" + id).val());
			var labour_rate = parseInt($("#labour_" + id).val());
			var total_rate = spares_rate+labour_rate
			var total_amount = quantity * total_rate;
			$("#total_" + id).val(total_amount);
			calculateColumn();
			
		}
	
		function complain_row_sum(id,rowid){
			
			var quantity = $("#complaintstable_"+id).find("#quantity_" + rowid).val(); 
			var spares = $("#complaintstable_"+id).find("#spares_" + rowid).val()
			var labour = $("#complaintstable_"+id).find("#labour_" + rowid).val()
			 
				if(!spares){
					spares=0;
				}
				if(!labour){
					labour=0;
				}
			
			var spares_rate = parseInt(spares);
			var labour_rate = parseInt(labour);
			var total_rate = spares_rate+labour_rate
			var total_amount = quantity * total_rate;
			$("#complaintstable_"+id).find("#total_" + rowid).val(total_amount);
			
			calculateColumn();	
			calculateColumn_Complaint();	
			 
			
		}
		 
	
	

	  
</script> 
<script>
$(document).ready(function(){
	
	//$("#addedit_form").on("submit", function(){
//   var formValues= $('#addedit_form').serialize();//Code: Action (like ajax...)
//		alert(formValues);
//   return false;
// })
	
	
  $(".year").datepicker({
    format: "yyyy",
     viewMode: "years", 
     minViewMode: "years",
     autoclose:true,
    startDate: "1990",
    endDate: "<?= date('Y'); ?>",
    container: 'modal-body' 
  });   
}) 
	
	$('.modal').on('shown.bs.modal', function() { 
$('.modal-body .datepicker').css('z-index','3000 !important');
$('.modal-body .bs-datepicker-container').css('z-index','3000 !important'); 
  $('.modal_year').datepicker({
   format: "yyyy",
     viewMode: "years", 
     minViewMode: "years",
     autoclose:true,
    startDate: "1990",
    endDate: "<?= date('Y'); ?>",
    container: '.modal-body',
	parentEl: '.modal-body'  
  });
});
</script>
<?php 
$this->session->unset_userdata('complain_array');	
$this->session->unset_userdata('complain_counter');
$this->session->unset_userdata('estimate_counter');
?>