  
<?php if($this->uri->segment(2) == 'list_feedback' || $this->uri->segment(2) == 'list_referral'){ 
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
              ajax: {"url": "<?php echo base_url().'feedbacks/get_feedback/'; ?>", "type": "POST"},
		  <?php if($this->uri->segment(2) == 'list_feedback'){ ?>
	
                    columns: [
                        {"data": "booking_id"},
                        {"data": "customer_name"},
                        {"data": "customer_mobile"},
                        {"data": "customer_channel"},
                        {"data": "customer_city"},
                        {"data": "service_category_id"},
                        {"data": "feedback"}, 
                        {"data": "assigned_mechanic"},
                        {"data": "feedback_date"},
                        {"data": "action"}  
						 
						
					],
		<?php }elseif($this->uri->segment(2) == 'list_referral'){ ?>
					columns: [
                        {"data": "booking_id"},
                        {"data": "referral_name_1"},
                        {"data": "referral_mobile_1"},
                        {"data": "referral_name_2"},
                        {"data": "referral_mobile_2"},
                        {"data": "referral_name_3"},
                        {"data": "referral_mobile_3"}, 
                        {"data": "feedback_date"},   
						 
						
					],
		  <?php } ?>
		   <?php if($this->uri->segment(2) == 'list_feedback'){ ?>
		  columnDefs: [
					   { orderable: false, targets: [1,2,3,4,5,7,9] }
					],
		  <?php }elseif($this->uri->segment(2) == 'list_referral'){ ?>
		   columnDefs: [
					   { orderable: false, targets: [1,2,3,4,5,6] }
					],
		    <?php } ?>
                order: [[0, 'desc']],
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
<?php } ?>

	  