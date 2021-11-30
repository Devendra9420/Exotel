    <div class="row">
        <div class="col-xs-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"> <span class="caption-subject font-dark sbold uppercase">Complaints List </span></h3>
                </div>
                <div class="box-body">

                    <table class="table table-striped table-hover table-bordered dataTable" id="complaints-table">
                        <thead>
                        <tr role="row">
                             
                            <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                Complaints
                            </th>
							 
							  <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                Option 1
                            </th>
                            
                            <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                Option 2
                            </th>
                            <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                 Option 3
                            </th>
                          <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                 Option 4
                            </th>
							<th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                 Option 5
                            </th>
							<th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                 Option 6
                            </th>

                            
                             
                            
                        </tr>
                        </thead>

                        <tbody>
                        
                         
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>

</section>

<script type="text/javascript"> 
$(document).ready(function() {
    $('#complaints-table').DataTable({
        "pageLength" : 10,
		"processing": true,
        "serverSide": true,
		'serverMethod': 'post', 
		'responsive': true,
        "order": [
          [1, "asc" ]
        ],
          'columns': [
             { data: 'complaints' },
			  { data: 'option1' },
             { data: 'option2' },
             { data: 'option3' },
             { data: 'option4' },
             { data: 'option5' }, 
             { data: 'option6' }, 
          ],
        "ajax": {
            url : '<?=base_url()?>index.php/spares/complaintsList/' 
        },
    });
});
</script>
 