  
<?php if($this->uri->segment(2) == 'list_complaints' || $this->uri->segment(2) == 'list_closed_complaints'){ 
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
		  <?php if($this->uri->segment(2) == 'list_complaints'){ ?>
              ajax: {"url": "<?php echo base_url().'complaints/get_complaints/'; ?>", "type": "POST"},
		  <?php }elseif($this->uri->segment(2) == 'list_closed_complaints'){ ?>
			  ajax: {"url": "<?php echo base_url().'complaints/get_closed_complaints/'; ?>", "type": "POST"},
			<?php } ?>
	
                    columns: [
                        {"data": "complaints_id"},
                        {"data": "booking_id"},
                        {"data": "customer_area"},
                        {"data": "customer_channel"},
                        {"data": "assigned_mechanic"},
                        {"data": "customer_name"},
                        {"data": "feedback"},
                        {"data": "created_on"}, 
                        {"data": "complaints"},
                        {"data": "due_date"},
                        {"data": "status"},
                        {"data": "action"}  
						 
						
					],
		 
 		  columnDefs: [
					   { orderable: false, targets: [7,9] }
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

	 function updatecomplaints(complaints_id){ 
        $.ajax({
            url: '<?=base_url();?>complaints/edit_complaints/',
            type: 'POST',
            data: {'complaints_id': complaints_id},
            dataType: 'json',
            success: function (data) {  
				if(data !== ''){   
				 	$('#complaints_id').val(complaints_id); 
					$('#booking_id').val(data.booking_id); 
					$('#details').val(data.details); 
					$('#revisit_booking_id').val(data.revisit_booking_id);  
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
				$('#modupdatecomplaints').modal('show'); 
				}
            }
        }); 
			 }
		
	 $(document).ready(function(){
		$('#complaint_status').change(function(){
    	var status = $(this).val(); 
	if(status=='Re-Visit'){
		$('#revisit_booking_div').show();
	}else{
	    $('#revisit_booking_div').hide();	
	}
});
		 
		 
		 $('#revisit_booking_id').keyup(function () {
            $('#revisit_caseresult').html(''); 
            var img = "<?=base_url()?>";
            var searchField = $('#revisit_booking_id').val();
         var csrf_test_name = $("input[name=csrf_test_name]").val();
     $.ajax({
     url:'<?=base_url()?>generals/get_booking_casefinder/'+searchField,
     method: 'POST',
     data: {searchField: searchField},
     dataType: 'json',
     success: function(data){
		 
		 if(data !== ''){ 
             $.each(data, function (key, value) { 
			 
		   //$('#revisit_caseresult').append('<a  class="dropdown-item" href="' + img + 'bookings/booking_details/' + value.booking_id + '"><div class="dropdown-item-desc">' + '<b> Booking ID:' + value.booking_id+' </b><p text-muted"> ' + value.customer_name + '  |  ' + value.customer_phone + '  |  ' + value.status + ' </p><div class="time"> ' + value.service_date +' </div></div></a>');
				 
				 $('#revisit_caseresult').append('<a class="dropdown-item" href="javascript:select_revisit_booking('+value.booking_id+');"><div class="dropdown-item-desc">' + '<b> Booking ID:' + value.booking_id+' </b><p text-muted"> ' + value.customer_name + '  |  ' + value.customer_phone + '  |  ' + value.status + ' </p><div class="time"> ' + value.service_date +' </div></div></a>');
				 
				  
			 });
		 }else{
			 $('#revisit_caseresult').html('');  
		 }
        }, 
    });
	});	
		 

        $('#revisit_caseresult').on('click', 'li', function () {
            var click_text = $(this).text().split('|');
            $('#global_casefinder_booking_id').val($.trim(click_text[0]));
            $("#revisit_caseresult").html('');
        });
		 
		 
	 });
	
	function select_revisit_booking(thisbooking){
		$('#revisit_booking_id').val(thisbooking);
	}
		</script>

<?php }  if($this->uri->segment(2) == 'new_complaints' || $this->uri->segment(2) == 'add_complaints'){ ?>

 
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

              },
              address: {
                  required: true,

              },
             city: {
                  required: true,
              },
              area: {
                  required: true,
              },
              pincode: {
                  required: true,
              },
              google_map: {
                  required: true,
              },
              channel: {
                  required: true,
              },
              make: {
                  required: true,
              },
              model: {
                  required: true,
              },
			  service_date:{
				  required: true,
			  }, 
			  service_category:{
				  required: true,
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
	 
	 
          });
	
	    
          
</script>
 
<?php }  ?>
	  