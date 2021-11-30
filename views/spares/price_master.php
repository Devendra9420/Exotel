<?php echo form_open(base_url() . 'index.php/spares/update_allsparesrate', array('method' => 'post')); ?>
<div class="row">
    <div class="col-md-12">
        <div class="box light bordered">
			 <div class="box-header with-border">
                    <h3 class="box-title"> <span class="caption-subject font-dark sbold uppercase">Spares Price Master </span></h3>
                </div>
            <div class="box-body">
                <div class="clearfix"> 


                    <div class="col-md-6">
                        <label>Make:</label>
                        <select class="form-control select2" name="vehicle_make" id="vehicle_make" required>
                            <option value="">Select Make</option>
                            <?php foreach ($makes as $make) : 
							if(!empty($selected_make) && $selected_make==$make->make_id){
								$selected = 'selected';
							}else{
								$selected = '';
							}
							?>
                                <option <?php echo $selected; ?> value="<?php echo $make->make_id; ?>"><?php echo $make->make_name; ?></option>
                            <?php endforeach; ?>
                        </select>

                    </div>

                    <div class="col-md-6">

                        <label>Model:</label>
                        <select class="form-control select2" name="vehicle_model" id="vehicle_model">
							  <option value="">Select</option> 
							  </select> 

                    </div>
				 
                </div>

            </div>
        </div>
    </div>
</div>
<div class="row" id="showsparesdiv" style="display: none;">
    <div class="col-lg-12">

        <div class="box box-warning">
            <div class="box-heading">
                <h5>Select Item</h5>

            </div>
            <div class="box-body" id="rows-list">
                <div class="input-group">

                    <span class="input-group-addon"> <span class="fa fa-search"> </span> </span>

                   <!--<select class="form-control product input-xlarge pdtfromdbs" name="modelitem" id="modelitem"
                            onchange="return get_procure_data(this.value);">-->
					   
					    <select class="form-control product input-xlarge modelitem" style="width: 100%;" name="modelitem" id="modelitem" 
                            onchange="return get_spares_rates(this.value);">
                         
                    </select>

                </div>
                         <hr>
					<span id="selected_sparesid_div" style="display: none;">
					<input name="selected_sparesid" id="selected_sparesid" type="hidden" value="" />
					 
                        <button class="btn btn-success" onClick="return add_rate();" type="button">Add Price</button>
             		 <hr>
					</span>	
				
                <div style="height:250px;overflow-y:scroll;" id=""> 
                    <div>
                        <table cellspacing="0" border="1" style="font-size:11px;border-collapse:collapse;"
                               id="" class="table table-striped table-hover" rules="all">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Spares ID</th>
                                <th>Item Name</th>
                                <th>Brand</th> 
                                <th>Rate</th> 
                            </tr>
                            </thead>
                            <tbody id="spares_entry_holder">

                            </tbody>
                        </table>
                    </div>


                </div>

                
            </div>
        </div>
    </div>
	
	<div class="col-lg-12"> 

         <div data-sortable-id="ui-widget-10" class="box box-success">
            
            <div class="box-body"> 
			<div class="form-group col-md-10">
                        <button class="btn btn-success" type="submit">Update Price</button>
             </div>
	 		</div>
	 	 </div>
</div>	 
	 

</div>
 
</form>
<!--Modal for ADD -->
<div class="modal fade" role="dialog"  id="addRate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add Spares Rate</h4>
            </div>
            <?php $attributes = array('class' => 'form-horizontal group-border hover-stripped addform', 'id' => 'addform', 'method' => 'post');
            echo form_open_multipart('spares/add_sparesrate', $attributes); ?>
            <div class="modal-body"> 
		 
				 <input type='hidden' name="vehicle_make2"  id="vehicle_make2" class='form-control' value="">
				
				<input type='hidden' name="vehicle_model2"  id="vehicle_model2" class='form-control' value="">
				
				<div class='form-group'>
                    <label for='inputPassword1'
                           class='col-lg-3 col-sm-3 control-label'>Spares Id</label>
                    <div class='col-lg-9'>
                        <input type='text' readonly name="e_sparesid" class='form-control'
                               value="" id='e_sparesid'
                               placeholder=''>
                    </div>
                </div>
                <div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Item Name</label>
                    <div class='col-lg-9'>
                        <input type='text' readonly name="e_item_name" class='form-control'
                               value="" id='e_item_name'>
                    </div>
                </div>
				 <div class='form-group'>
                    <label for='inputPassword1'
                           class='col-lg-3 col-sm-3 control-label'>Model</label>
                    <div class='col-lg-9'>
                        <input type='text' readonly name="e_model" class='form-control'
                               value=""   id='e_model'
                               placeholder=''>
                    </div>

                </div>
                <div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Brand</label>

                    <div class='col-lg-9'>
                        <input type='text'   name="e_brand" required class='form-control'
                               value="" id='e_brand'
                               placeholder=''>
                    </div>
                </div>
				  <div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Rate</label>

                    <div class='col-lg-9'>
                        <input type='number' required name="e_rate" class='form-control'
                               value="" id='e_rate'
                               placeholder=''>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <?php echo $My_Controller->savePermission; ?>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!--Modal for ADD ends-->
<script type="text/javascript">

	$(document).ready(function(){
 
	  $('form input').on('keypress', function(e) {
    return e.which !== 13;
});
		
		
		var make = $('#vehicle_make').val();
		var model = $('#vehicle_model').val();
		var csrf_test_name = $("input[name=csrf_test_name]").val();
		
	 	
		
		 $('#vehicle_model').change(function(){
    	var vehicle_model = $(this).val(); 
		var vehicle_make = $('#vehicle_make').val();
			 if(vehicle_make!=='' && vehicle_model!==''){
				$('#showsparesdiv').show(); 
			 }else{
				 $('#showsparesdiv').hide(); 
			 }
		 });
		
					  
	  $('#vehicle_make').change(function(){
    	var vehicle_make = $(this).val(); 
		   
		  if(vehicle_make !== ""){ 
       
			  
           
     $.ajax({
     url:'<?=base_url()?>index.php/bookings/getModelsByMake/',
     method: 'POST',
     data: {vehicle_make: vehicle_make, 'csrf_test_name': csrf_test_name},
     dataType: 'json',
     success: function(response){ 
		 
		 $('#vehicle_model').empty().trigger("change");  
			  var data = {
    id: '',
    text: 'Select Model'
};
var newOption = new Option(data.text, data.id, false, false);
$('#vehicle_model').append(newOption).trigger('change');
		 
		 $('#vehicle_model').select2({
			 placeholder :'Select Model', 
			 width: 'resolve',
             data: response
                }); 
 		$('#vehicle_model').trigger('change');
		
		 
     }
   });
		  
		  
		  }
	  });
		
		 
		
	 
	
});	
	
    var total_number = 0;
    function get_spares_rates(spares_id) {
        total_number++;
        var csrf_test_name = $("input[name=csrf_test_name]").val();
        $.ajax({
            url: '<?=base_url();?>index.php/spares/get_spares_rates/',
            type: 'POST',
            data: {'id': spares_id, 'total': total_number, 'csrf_test_name': csrf_test_name},
            dataType: 'html',
            success: function (response) {

                $('#spares_entry_holder').html(response); 
				$('#selected_sparesid').val(spares_id); 
				$('#selected_sparesid_div').show();
				$('#e_sparesid').val(spares_id);
				
				var itemnamedata = $('#modelitem').select2('data')[0]['text'];
				
				$('#e_item_name').val(itemnamedata);
				$('#e_model').val($('#vehicle_model').val());
            }
        });
    }


    </script>
	<script>	 
		
	 function add_rate(){ 
				 
		 			if($('#selected_sparesid').val()!==''){ 
						$('#vehicle_make2').val($('#vehicle_make').val());
						$('#vehicle_model2').val($('#vehicle_model').val());
				 $('#addRate').modal('show');
					}else{
						alert('Spares Id not selected');
					}
				 
            }
       <?php 
		if(!empty($selected_make)){ 
		?>
		$(document).ready(function(){
		$('#vehicle_make').trigger('change');
		});
		<?php 
		}
		?>
	<?php 
		if(!empty($selected_model)){ 
		?>
		$(document).ready(function(){
			
			  
				 			setTimeout( function(){	 
        $('#vehicle_model').val(<?php echo $selected_model; ?>).trigger('change');
								 }, 1000 );
			  
         
		 
			});	
		 <?php
		}
		 ?>
	
</script>