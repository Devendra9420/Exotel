
 <div class="section-body">
            <h2 class="section-title">Spares List <?php echo $this->rbac->createPermission_custom; ?><span class="text-right float-right"><?php echo $this->rbac->updatePermission_custom; ?></span></h2>
            <p class="section-lead">  
            </p>  
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header text-right"> 
            </div>
            <div class="box-body">
				<div class="table-responsive">
                <table class="table table-striped" id="listtable">
                    <thead>
                    <tr role="row">
                        <th>Spares Id
                        </th>
                        <th>Item Code
                        </th>
                        <th>Item Name
                        </th> 
						<th>Category
                        </th> 
						<th>Model Code
                        </th>
						<th>Model 
                        </th>
						<th>Make
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
</div>

	 </div>


<!--Modal for ADD -->
<div class="modal fade" role="dialog"  id="add_spares">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add Spares</h4>
            </div>
            <?php $attributes = array('class' => 'form-horizontal group-border hover-stripped addform', 'id' => 'addedit_form', 'method' => 'post');
            echo form_open_multipart('spares/add_spares', $attributes); ?>
            <div class="modal-body"> 
                <div class='form-group'>
                    <label for='item_code' class='col-lg-3 col-sm-3 control-label'>Item Name</label>
                    <div class='col-lg-9'>
                        <select type='text' name="item_code" style="width: 100%;" class='form-control  select-ajax-items'
                               value="" id='item_code'>
						<input type='hidden' readonly required name="item_name" class='form-control input-item_name' id='item_name'>	
                    </div>
                </div> 
				<div class='form-group'>
                    <label for='make'
                           class='col-lg-3 col-sm-3 control-label'>Make</label>
                    <div class='col-lg-9'>
                         <select name="make_id" style="width: 100%;" required  class='form-control select-ajax-make'  id='make' placeholder='Select Make'>
						</select>	
                    </div> 
                </div>
				 <div class='form-group'>
                    <label for='model'
                           class='col-lg-3 col-sm-3 control-label'>Model</label>
                    <div class='col-lg-9'>
                         <select name="model_id" style="width: 100%;" required class='form-control select-ajax-model'  id='model' placeholder='Select Model'>
						</select>	
                    </div>

                </div> 
            </div>
            <div class="modal-footer">
				<?php echo $this->rbac->createPermission; ?>
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!--Modal for ADD ends-->     
 