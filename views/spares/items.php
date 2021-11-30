
 <div class="section-body">
            <h2 class="section-title">Item List <?php echo $this->rbac->createPermission_custom; ?><span class="text-right float-right"></span></h2>
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
                        <th>Item Code
                        </th> 
                        <th>Item Name
                        </th> 
						<th>Hsn No
                        </th> 
						<th>GSTN Rate
                        </th> 
						<th>Action
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

     <!--Modal for EDIT -->
<div class="modal fade" role="dialog"  id="edit_item">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Edit Item</h4>
            </div>
            <?php $attributes = array('class' => 'form-horizontal group-border hover-stripped editform', 'id' => 'editform', 'method' => 'post');
            echo form_open_multipart('spares/update_item', $attributes); ?>
            <div class="modal-body"> 
		 
				<div class='form-group'>
                    <label for='e_id'
                           class='col-lg-3 col-sm-3 control-label'>Item Id</label>
                    <div class='col-lg-9'>
                        <input type='text' name="item_id" class='form-control'
                               value="" readonly id='e_item_id'
                               placeholder=''>
                    </div>
                </div>
				
				<div class='form-group'>
                    <label for='e_item_code'
                           class='col-lg-3 col-sm-3 control-label'>Item Code</label>
                    <div class='col-lg-9'>
                        <input type='text' name="item_code" class='form-control'
                               value=""   id='e_item_code'
                               placeholder=''>
                    </div>
                </div>
                <div class='form-group'>
                    <label for='e_item_name' class='col-lg-3 col-sm-3 control-label'>Item Name</label>
                    <div class='col-lg-9'>
                        <input type='text' name="item_name" class='form-control'
                               value=""   id='e_item_name'>
                    </div>
                </div> 
                <div class='form-group'>
                    <label for='e_hsn_no' class='col-lg-3 col-sm-3 control-label'>Hsn No</label>

                    <div class='col-lg-9'>
                        <input type='text' required name="hsn_no" class='form-control'
                               value="" id='e_hsn_no'
                               placeholder=''>
                    </div>
                </div>
				  <div class='form-group'>
                    <label for='e_gstn_rate' class='col-lg-3 col-sm-3 control-label'>GSTN Rate</label>

                    <div class='col-lg-9'>
                        <select name="gstn_rate" class='form-control select2' id='e_gstn_rate'>
								<option  value="0.12">0.12</option>
								<option  value="0.18">0.18</option>
								<option  value="0.28">0.28</option>
                             </select>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
				<?php echo $this->rbac->updatePermission; ?>
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button> 
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!--Modal for EDIT ends-->

<!--Modal for ADD -->
<div class="modal fade" role="dialog"  id="add_item">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add Item</h4>
            </div>
            <?php $attributes = array('class' => 'form-horizontal group-border hover-stripped addform', 'id' => 'addform', 'method' => 'post');
            echo form_open_multipart('spares/add_item', $attributes); ?>
            <div class="modal-body">
				  
				<div class='form-group'>
                    <label for='a_item_code' class='col-lg-3 col-sm-3 control-label'>Item Code</label>
                    <div class='col-lg-9'>
                        <input type='text' name="item_code" class='form-control'
                               value="" id='a_item_code'
                               placeholder=''>
                    </div>
                </div>
                <div class='form-group'>
                    <label for='a_item_name' class='col-lg-3 col-sm-3 control-label'>Item Name</label>
                    <div class='col-lg-9'>
                        <input type='text'   name="item_name" class='form-control'
                               value="" id='a_item_name'>
                    </div>
                </div>
				 
                <div class='form-group'>
                    <label for='a_hsn_no' class='col-lg-3 col-sm-3 control-label'>HSN No</label> 
                    <div class='col-lg-9'>
                        <input type='text'   name="hsn_no" class='form-control'
                               value="" id='a_hsn_no'
                               placeholder=''>
                    </div>
                </div>
				  <div class='form-group'>
                    <label for='a_gstn_rate' class='col-lg-3 col-sm-3 control-label'>GSTN Rate</label> 
                    <div class='col-lg-9'>
                        <select name="gstn_rate" class='form-control select2' id='a_gstn_rate'>
								<option  value="0.12">0.12</option>
								<option  value="0.18">0.18</option>
								<option  value="0.28">0.28</option>
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
 

 

