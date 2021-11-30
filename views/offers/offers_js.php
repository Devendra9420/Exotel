  
<?php if($this->uri->segment(2) == 'list_guest' || $this->uri->segment(2) == 'list_referrals'){ 
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
		  <?php if($this->uri->segment(2) == 'list_guest'){ ?>
              ajax: {"url": "<?php echo base_url().'offers/get_all_guest/'; ?>", "type": "POST"}, 
                    columns: [
                        {"data": "guest_id"},
                        {"data": "name"},
                        {"data": "mobile"},
                        {"data": "vehicle_make"},
                        {"data": "vehicle_model"},
                        {"data": "code"},
                        {"data": "claimed"}, 
                        {"data": "created_on"}, //render: $.fn.dataTable.render.moment( 'DD-MM-YYYY' )},
                        {"data": "updated_on"}, //render: $.fn.dataTable.render.moment( 'DD-MM-YYYY' )} 
					], 
		  columnDefs: [
					   { orderable: false, targets: [3,4,5,6] }
					],
		  <?php }elseif($this->uri->segment(2) == 'list_referrals'){ ?>
		  	 ajax: {"url": "<?php echo base_url().'offers/get_all_referrals/'; ?>", "type": "POST"}, 
                    columns: [
                        {"data": "id"},
						{"data": "guest_id"},
                        {"data": "name"},
                        {"data": "mobile"}, 
                        {"data": "voted"},  
                        {"data": "created_on"}, //render: $.fn.dataTable.render.moment( 'DD-MM-YYYY' )} 
					], 
		  columnDefs: [
					   { orderable: false, targets: [4] }
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
            var code=$(this).data('guest_id');
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

	  