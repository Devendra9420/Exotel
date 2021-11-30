<?php if($this->session->userdata('department')=='3'){ ?>

<script type="text/javascript"> 
    $(document).ready(function(){
       
		
		$('#bookingCalendar').fullCalendar({
		
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,basicWeek,basicDay'
      },
      defaultDate: '<?php echo date('Y-m-d'); ?>',
      navLinks: true,  
      editable: false,
      eventLimit: true,  
      eventSources: [
           {
           events: function(start, end, timezone, callback) {
			    
                $.ajax({
                    url: '<?php echo base_url() ?>bookings/get_events/',
					method: 'POST',
                    dataType: 'json',
                    data: {
                          
                        start: start.unix(),
                        end: end.unix()
                    },
                    success: function(msg) {
                        var events = msg.events;
                        callback(events);
                    }
                });
              }
            },
        ], 
		eventRender: function (event, element, view) { 
            $(element).each(function () { 
                $(this).attr('date-num', event.start.format('YYYY-MM-DD')); 
				 
				$(this).hide();
            });
        },
        eventAfterAllRender: function(view){
            for( cDay = view.start.clone(); cDay.isBefore(view.end) ; cDay.add(1, 'day') ){
                var dateNum = cDay.format('YYYY-MM-DD');
                var dayEl = $('.fc-day[data-date="' + dateNum + '"]');
                var eventCount = $('.fc-event[date-num="' + dateNum + '"]').length;
                if(eventCount){
                    var html = '<span class="event-count text-center" style="margin:auto;">' + 
                                '<h1 style="font-size: 56px;" class="text-primary">' +
                                eventCount + 
                                '</h1>' +
                                ' ' +
                                '</span>';

                    dayEl.html(html);

                }
            }
        },
    });

		 
             
    }); 

	
</script>
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
		  	 
              ajax: {"url": "<?php echo base_url().'dist/technicaladvisor_dashboard_bookings/'; ?>", "type": "POST"}, 
		  		 
		  
                    columns: [
                        {"data": "booking_id"}, 
                        {"data": "customer_city"},
                        {"data": "customer_mobile"}, 
                        {"data": "time_slot"},  
                        {"data": "assigned_mechanic"},
                        {"data": "stage"},
                        {"data": "locked"},
                        {"data": "action"}  
						 
						
					],
		  columnDefs: [
					   { orderable: false, targets: -1 }
					],
                order: [[3, 'asc']],
          rowCallback: function(row, data, iDisplayIndex) {
              var info = this.fnPagingInfo();
              var page = info.iPage;
              var length = info.iLength;
              $('td:eq(0)', row).html();
			  
			  	if(data['locked'] == "1")
				{
					var lock_status = data['lock_status'];
					lock_status.replace("_", " ");
					 
					
					 $('td', row).css('background-color', 'Red');
					 $('td', row).css('color', 'White');
					 $("td:eq(6)", row).html('Locked<br>'+lock_status);
					 $("td:eq(7)", row).find($('#lock_action')).html('Unlock');
				}else if(data['locked'] == "0")
				{
					  $("td:eq(6)", row).text('Unlocked'); 
					 $("td:eq(7)", row).find($('#lock_action')).html('Lock');
				} 
			  
			  if(data['stage'] !== "")
				{
				
					var date = data['updated_on'];
					var hrs = date.split(' ')[1];
					
					 $("td:eq(5)", row).html(data['stage']+'<br>'+hrs); 
				}
			   
			  return row;
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
<?php }else{  ?>

<script type="text/javascript"> 
    $(document).ready(function(){
       
		
		$('#bookingCalendar').fullCalendar({
		
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,basicWeek,basicDay'
      },
      defaultDate: '<?php echo date('Y-m-d'); ?>',
      navLinks: true,  
      editable: false,
      eventLimit: true,  
      eventSources: [
           {
           events: function(start, end, timezone, callback) {
			    
                $.ajax({
                    url: '<?php echo base_url() ?>bookings/get_events/',
					method: 'POST',
                    dataType: 'json',
                    data: {
                          
                        start: start.unix(),
                        end: end.unix()
                    },
                    success: function(msg) {
                        var events = msg.events;
                        callback(events);
                    }
                });
              }
            },
        ], 
		eventRender: function (event, element, view) { 
            $(element).each(function () { 
                $(this).attr('date-num', event.start.format('YYYY-MM-DD')); 
				 
				$(this).hide();
            });
        },
        eventAfterAllRender: function(view){
            for( cDay = view.start.clone(); cDay.isBefore(view.end) ; cDay.add(1, 'day') ){
                var dateNum = cDay.format('YYYY-MM-DD');
                var dayEl = $('.fc-day[data-date="' + dateNum + '"]');
                var eventCount = $('.fc-event[date-num="' + dateNum + '"]').length;
                if(eventCount){
                    var html = '<span class="event-count text-center" style="margin:auto;">' + 
                                '<h1 style="font-size: 56px;" class="text-primary">' +
                                eventCount + 
                                '</h1>' +
                                ' ' +
                                '</span>';

                    dayEl.html(html);

                }
            }
        },
    });

		 
             
    }); 

	
</script>

<?php } ?>
  