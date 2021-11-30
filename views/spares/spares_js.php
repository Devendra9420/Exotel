<?php if($this->uri->segment(2) == 'list_spares' || $this->uri->segment(2) == 'list_spares_rate' || $this->uri->segment(2) == 'list_labour' || $this->uri->segment(2) == 'list_items'){ ?>
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
		  		<?php if($this->uri->segment(2) == 'list_spares'){ ?>
		  	  ajax: {"url": "<?php echo base_url().'spares/get_spares/'; ?>", "type": "POST"},
		  		<?php }elseif($this->uri->segment(2) == 'list_labour'){ ?>	
              ajax: {"url": "<?php echo base_url().'spares/get_labour/'; ?>", "type": "POST"}, 
		  		<?php }elseif($this->uri->segment(2) == 'list_items'){ ?>	
              ajax: {"url": "<?php echo base_url().'spares/get_items/'; ?>", "type": "POST"}, 
		  		<?php }elseif($this->uri->segment(2) == 'list_spares_rate'){ ?>	
              ajax: {"url": "<?php echo base_url().'spares/get_spares_rate/'; ?>", "type": "POST"}, 
		  		<?php }elseif($this->uri->segment(2) == 'list_items'){ ?>	
              ajax: {"url": "<?php echo base_url().'spares/get_items/'; ?>", "type": "POST"}, 
		  		<?php } ?> 
					<?php if($this->uri->segment(2) == 'list_spares'){ ?>
		  			columns: [
                       { data: 'spares_id' },
                       { data: 'item_code' },
                       { data: 'item_name' },
                       { data: 'vehicle_category' },
                       { data: 'model_code' },
                       { data: 'model' }, 
                       { data: 'make' },  
					], 
                	order: [[2, 'asc']],	
					<?php } ?>
					<?php if($this->uri->segment(2) == 'list_spares_rate'){ ?>	
                     columns: [
                       { data: 'spares_id' }, 
					  { data: 'item_name' },
					 { data: 'brand' },
					 { data: 'rate' }, 
					 { data: 'action' }, 
					],
		  			columnDefs: [
					   {orderable: false, targets: -1}
						],
                	order: [[1, 'asc']],
					<?php } ?>		
					
		  			<?php if($this->uri->segment(2) == 'list_items'){ ?>	
                     columns: [ 
					 { data: 'item_code' },
					  { data: 'item_name' },
					 { data: 'hsn_no' },
					 { data: 'gstn_rate' }, 
					 { data: 'action' }, 
					],
		  			columnDefs: [
					   {orderable: false, targets: -1}
						],
                	order: [[1, 'asc']],
					<?php } ?>	
		  
		  
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
 
<?php } if($this->uri->segment(2) == 'list_spares_rate'){ ?>
<script>	 
	 function update_rate(rates_id){  
        $.ajax({
            url: '<?=base_url();?>spares/get_spares_rate_details/',
            type: 'POST',
            data: {'rates_id': rates_id},
            dataType: 'json',
            success: function (data) {  
				if(data !== ''){   
				 	$('#e_id').val(data.id);
					$('#e_spares_id').val(data.spares_id);
					$('#e_item_name').val(data.item_name); 
					$('#e_brand').val(data.brand);
					$('#e_rate').val(data.rate);  
				$('#edit_spares_rate').modal('show');
				
				}
            }
        }); 
			 }  
	
</script> 
<script> 
$(document).ready(function () { 
	
	$('#a_sparesid').change(function(){
    	//var item_name =  $(this).select2('data')[0]['text']; //$(this).find(':selected').data('itemname');
		var spares_id = $(this).val(); 
		$.ajax({
            url: '<?=base_url();?>spares/get_spares_details/',
            type: 'POST',
            data: {'spares_id': spares_id},
            dataType: 'json',
            success: function (data) {  
				if(data !== ''){    
					$('#a_item_name').val(data.item_name);   
				}
            }
        }); 
		
		});
	 
 }); 
          
</script>
<?php
}if($this->uri->segment(2) == 'list_items'){ ?>
<script>	 
	 function update_item(item_id){  
        $.ajax({
            url: '<?=base_url();?>spares/get_items_details/',
            type: 'POST',
            data: {'item_id': item_id},
            dataType: 'json',
            success: function (data) {  
				if(data !== ''){   
				 	$('#e_item_id').val(data.item_id);
					$('#e_item_code').val(data.item_code);
					$('#e_item_name').val(data.item_name); 
					$('#e_hsn_no').val(data.hsn_no);
					$('#e_gstn_rate').val(data.gstn_rate);  
				$('#edit_item').modal('show');
				
				}
            }
        }); 
			 }  
	
</script>  
<?php
}if($this->uri->segment(2) == 'list_spares'){ ?>
 
<script> 
$(document).ready(function () { 
	
	$('.select-ajax-items').change(function(){
    	var item_name =  $(this).select2('data')[0]['text']; //$(this).find(':selected').data('itemname');
		 
		$('.input-item_name').val(item_name);
		});
	 
 });
	
	    
          
</script>
    
<?php } if($this->uri->segment(2) == 'map_spares'){ ?>
 
<script> 
$(document).ready(function () { 
	
	
	var spares_map_table = $('#spares_map_table').DataTable({ paging: false, searching: false, ordering:false, info:false}); 
	var counter=1; 
	
	 
	
	
	
		//GET SPARES LIST
	$("#spares_id").select2({
        placeholder: "Search",
        minimumInputLength: 1,
		width: 'resolve',
		allowClear: true,
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: "<?php echo base_url(); ?>spares/get_all_spares/",
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
    $(data.element).attr('data-itemcode', data.itemcode);  
	 $(data.element).attr('data-itemname', data.item_name);  
	 $(data.element).attr('data-model', data.model);  
	 $(data.element).attr('data-vehiclecategory', data.vehicle_category);  
			
	 
			
			
    return data.text;
  }
    });
	 
	$('#spares_id').on('select2:clearing', function (e) {  
		 
		spares_map_table.clear().draw();  
	});
	
		// add row
    $('#add-row').click(function () { 
		
		var spares_id = $('#spares_id').val();
		if(spares_id !== ""){ 
        var rowHtml = $("#spares_map_table").find("tr")[0].outerHTML 
		initailizeMakeModel();		
		spares_map_table.row.add( [
            '<input type="hidden" name="row_counter[]" value="'+ counter + '"><input type="hidden" name="item_id[]" value="0">'+ counter, 
			'<select class="form-control select-ajax-make" name="make[]" id="make_'+ counter + '"> </select>',	 
			'<select class="form-control select-ajax-model" name="model[]" id="model_'+ counter + '"> </select>', 
			'<button type="button" class="btn btn-danger btn-delete"><i class="fas fa-trash"></i></button>'	 	 
        ] ).draw();  
		counter++;	
		initailizeMakeModel();		
        //spares_map_table.row.add($(rowHtml)).draw();
		}else{
			swal('Ahh!', "Please select Spare Id / Item first", 'warning', { buttons: false, timer: 2000,  }); 
			 
		}
    });
	
	$("#spares_id").change(function(){  
			
		spares_map_table.clear().draw(); 
		
		
		//spares_map_table.draw();
			counter = 1;
			var spares_id = $(this).val();   
			$('#spares_id').val(spares_id); 	
		   if(spares_id !== ""){   
			initailizeMakeModel();		
			   
			   $('#item_name_div').html(($(this).find(':selected').data('itemname')));
			   $('#model_div').html(($(this).find(':selected').data('model')));
			   $('#vehicle_category_div').html(($(this).find(':selected').data('vehiclecategory')));
			   
			   
			   $('#primary_item_code').val(($(this).find(':selected').data('itemcode')));
			   $('#primary_item_name').val(($(this).find(':selected').data('itemname')));
			   $('#primary_model').val(($(this).find(':selected').data('model')));
			   $('#primary_vehicle_category').val(($(this).find(':selected').data('vehiclecategory')));
			   
			   
			   $.ajax({
            url: '<?=base_url();?>spares/get_spares_id_rows/',
            type: 'POST',
            data: {'spares_id': spares_id},
            dataType: 'json',
            success: function (data) {  
				if(data !== ''){   
					//$.each(data, function(i, data) {
					spares_map_table.row.add( [
            '<input type="hidden" name="row_counter[]" value="'+ counter + '"><input type="hidden" name="item_id[]" value="">'+ counter, 
			'<select class="form-control select-ajax-make" name="make[]" id="make_'+ counter + '"><option selected value=""></option></select>',	 
			'<select class="form-control select-ajax-model" name="model[]" id="model_'+ counter + '"><option selected value=""></select>', 
			'<button type="button" class="btn btn-danger btn-delete"><i class="fas fa-trash"></i></button>'	 	 
        ] ).draw();  
			initailizeMakeModel();					
					counter++; 
					//});
				}
            }
        }); 
			   
		 
		   }
		    
	  });
	
	$('#spares_map_table tbody').on( 'click', '.btn-delete', function () { 
		spares_map_table
			.row( $(this).parents('tr') )
			.remove()
			.draw();  
	});
	
	 
 });
	
	function initailizeMakeModel(){ 
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
	
	$('.select-ajax-model').on('select2:open', function (e) {  
		var this_row_model = $(this).parents('tr').find($('.select-ajax-model')); 
			this_row_model.val('');
		   this_row_model.trigger('change');
	 
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
    	var vehiclecategory = ($(this).find(':selected').data('vehiclecategory'));
		$('.input-vehiclecategory').val(vehiclecategory);
		});
	//POPULATE MODEL CODE ON MODEL CHANGE
		$('.select-ajax-model').change(function(){
    	var modelcode = ($(this).find(':selected').data('modelcode'));
		$('.input-modelcode').val(modelcode);
		});
		
}    
          
</script>
    
<?php }  ?>