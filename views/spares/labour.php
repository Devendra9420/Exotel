    <div class="row">
        <div class="col-xs-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"> <span class="caption-subject font-dark sbold uppercase">Labour List   | <a
                                href='#mod_addlabour' data-toggle='modal' class='btn green btn-info'>
                                Add New <i class="fa fa-plus"></i>
                            </a></span></h3>
                </div>
                <div class="box-body">

                    <table class="table table-striped table-hover table-bordered dataTable" id="labour-table">
                        <thead>
                        <tr role="row">
                             
                            <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                Item Code
                            </th>
							 
							  <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                Item Name
                            </th>
                            
                            <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                Vehicle Category
                            </th>
                            <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                 Rate
                            </th>
                          <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                 GST
                            </th>
							<th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                 SAC
                            </th>
							 <th class="sorting_disabled" role="columnheader" rowspan="1" colspan="1"
                                aria-label="QR Code">
                                 Action
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
//$(document).ready(function() {
//    $('#labour-table').DataTable({
//        "pageLength" : 10,
//		"processing": true,
//        "serverSide": true,
//		'serverMethod': 'post',
//        "order": [
//          [1, "asc" ]
//        ],
//          'columns': [
//             { data: 'item_code' },
//			  { data: 'item_name' },
//             { data: 'vehicle_category' },
//             { data: 'rate' },
//             { data: 'gst' },
//             { data: 'sac' },  
//          ],
//        "ajax": {
//            url : ' index.php/spares/labourList/' 
//        },
//    });
//});
</script>
 
<!--Modal for ADD -->
<script>
$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        var inputValue = $(this).attr("value");
       // var targetBox = $("." + inputValue);
       // $(".box").not(targetBox).hide();
		if(inputValue==0){
			$("#NoItemDiv").show();
			$("#ItemDiv").hide();
		}else if(inputValue==1){
			$("#ItemDiv").show();
			$("#NoItemDiv").hide();
		}else{
			$("#NoItemDiv").show();
			$("#ItemDiv").hide();
		}
       // $(targetBox).show();
    });
	
	 $('#item_name').change(function(){
	 var item_code = $(this).val();
		 $('#item_code').val(item_code);
	 });	 
		 
});
</script>

<div class="modal fade" role="dialog"  id="mod_addlabour">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add New Labour</h4>
            </div>
            <?= form_open_multipart(base_url() . 'index.php/spares/add_labour', array('method' => 'POST', 'class' => 'form-horizontal')) ?>

            <div class="modal-body">

                
				<div class='form-group'>
                    <label for='inputEmail1' class='col-lg-3 col-sm-3 control-label'>Labour for item?</label>
                    <div class='col-lg-9'> 
						<div class="radio col-lg-6">
  						<label><input type="radio" value='0' checked name="foritem">No</label>
						</div>
						<div class="radio col-lg-6">
  						<label><input type="radio" value='1' name="foritem">Yes</label>
						</div>
                         
                    </div>
                </div>
				
				<div class='form-group'>
                    <div id="NoItemDiv"><label for='inputEmail1' class='col-lg-3 col-sm-3 control-label'>Item Name</label>
                    <div class='col-lg-9'>
                        
                        <input type='text' name="labour_item_name" class='form-control' id='labour_item_name' value=''>
                    </div>
					</div>
					 <div id="ItemDiv" style="display: none;"><label for='inputEmail1' class='col-lg-3 col-sm-3 control-label'>Item Name</label>
                    <div class='col-lg-9'>
                         
                        <select name="item_name" id="item_name" class="form-control select2model" style="width: 100%;">
						<option>Select Item</option>
						<?php foreach($items as $item){ ?>
							<option value="<?php echo $item->item_code;?>"><?php echo $item->item_name;?></option>	
						<?php } ?>	
							</select>
                    </div>
					</div>
                </div>
				<div class="form-group">
                    <label for="cname" class="control-label col-lg-3">Item Code</label>

                    <div class="col-lg-9">
                        <input type='text' name="item_code" class='form-control' value="" id='item_code' placeholder=''>
                    </div>
                </div>
                <div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>GST Rate</label>

                    <div class='col-lg-9'>
                        <input type='text' name="gst" class='form-control' value="" id='gst' placeholder=''>
                    </div>
                </div>
				 

                <div class='form-group'>
                     <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>SAC Code</label>

                    <div class='col-lg-9'>
                        <input type='text' name="sac" class='form-control' value="" id='sac' placeholder=''>
                    </div>
                </div>
                
				 <div class='col-lg-12'>
                      
					 <table class="table table-striped table-hover table-bordered dataTable" ><thead><tr><td>Vehicle Category</td><td>Rate</td></tr></thead>
					 <tbody>
				<?php foreach($categories as $category){ ?>
					<tr>
					<td><?php echo $category->vehicle_category;?></td> 
					<td><input type="text" class="form-control" name="<?php echo $category->vehicle_category;?>_rate" value="0" /></td>
					</tr>
				<?php } ?>	
					 </tbody>
					</table>
            
				</div>
                 
				
                
                
            </div>
            <div class="modal-footer">
				  
                           
				
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
<?php echo $My_Controller->savePermission;?>
            </div>
            <?php echo form_close();?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" role="dialog"  id="mod_updatelabour">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Update Labour</h4>
            </div>
            <?= form_open_multipart(base_url() . 'index.php/spares/update_labour', array('method' => 'POST', 'class' => 'form-horizontal')) ?>

            <div class="modal-body">
 
				<div class='form-group'>
                    <div id="NoItemDiv"><label for='inputEmail1' class='col-lg-3 col-sm-3 control-label'>Item Name</label>
                    <div class='col-lg-9'>
                        <input type='hidden' name="labour_id" class='form-control' id='edit_labour_id' value=''>
                        <input type='text' readonly name="item_name" class='form-control' id='edit_item_name' value=''>
                    </div>
					</div>
					  
                </div>
				<div class="form-group">
                    <label for="cname" class="control-label col-lg-3">Item Code</label>

                    <div class="col-lg-9">
                        <input type='text' readonly name="item_code" class='form-control' value="" id='edit_item_code' placeholder=''>
                    </div>
                </div>
                <div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>GST Rate</label>

                    <div class='col-lg-9'>
                        <input type='text' name="gst" class='form-control' value="" id='edit_gst' placeholder=''>
                    </div>
                </div>
				 

                <div class='form-group'>
                     <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>SAC Code</label>

                    <div class='col-lg-9'>
                        <input type='text' id="edit_sac" name="sac" class='form-control' value="" placeholder=''>
                    </div>
                </div>
                
				 <div class='col-lg-12'>
                      
					 <table class="table table-striped table-hover table-bordered dataTable" ><thead><tr><td>Vehicle Category</td><td>Rate</td></tr></thead>
					 <tbody>
				 
					<tr>
					<td id="edit_catname"> </td> 
					<td><input type="text" class="form-control" id="edit_rate" name="rate" value="0" /></td>
					</tr>
				 
					 </tbody>
					</table>
            
				</div>
                 
				
                
                
            </div>
            <div class="modal-footer">
				  
                           
				
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
<?php echo $My_Controller->savePermission;?>
            </div>
            <?php echo form_close();?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script type="text/javascript" language="javascript" >
 $(document).ready(function(){
  
  fetch_data();

  function fetch_data()
  {
	  
   var dataTable = $('#labour-table').DataTable({
        "pageLength" : 10,
		"processing": true,
        "serverSide": true,
		'serverMethod': 'post',
        "order": [
          [1, "asc" ]
        ],
          'columns': [
             { data: 'item_code' },
			  { data: 'item_name' },
             { data: 'vehicle_category' },
             { data: 'rate' },
             { data: 'gst' },
             { data: 'sac' },  
			  { data: 'updatebtn' },
          ],
        "ajax": {
            url : '<?=base_url()?>index.php/spares/labourList/' 
        },
    });
  }
  
  

  
  $(document).on('click', '.update', function(){  
           var labour_id = $(this).attr("id");  
           $.ajax({  
                url:"<?=base_url()?>index.php/spares/Getsinglelabour/",  
                method:"POST",  
                data:{labour_id:labour_id},  
                dataType:"json",  
                success:function(data)  
                { 
					 
                     $('#edit_labour_id').val(data.id);
                     $('#edit_item_name').val(data.item_name);  
                     $('#edit_item_code').val(data.item_code);   
                     $('#edit_catname').html(data.vehicle_category); 
                     $('#edit_gst').val(data.gst);    
                     $('#edit_sac').val(data.sac);    
                     $('#edit_rate').val(data.rate); 
					 $('#mod_updatelabour').modal('show');
                }  
           })  
      });  
 
  
  
 });
</script>