
 <div class="section-body">
            <h2 class="section-title">Spares Rate List <?php echo $this->rbac->createPermission_custom; ?><span class="text-right float-right"></span></h2>
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
                        <th>Item Name
                        </th> 
						<th>Brand
                        </th> 
						<th>Rate
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
<div class="modal fade" role="dialog"  id="edit_spares_rate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Edit Spares Rate</h4>
            </div>
            <?php $attributes = array('class' => 'form-horizontal group-border hover-stripped editform', 'id' => 'editform', 'method' => 'post');
            echo form_open_multipart('spares/update_spares_rate', $attributes); ?>
            <div class="modal-body"> 
		 
				<div class='form-group'>
                    <label for='e_id'
                           class='col-lg-3 col-sm-3 control-label'>Record Id</label>
                    <div class='col-lg-9'>
                        <input type='text' name="id" class='form-control'
                               value="" readonly id='e_id'
                               placeholder=''>
                    </div>
                </div>
				
				<div class='form-group'>
                    <label for='e_sparesid'
                           class='col-lg-3 col-sm-3 control-label'>Spares Id</label>
                    <div class='col-lg-9'>
                        <input type='text' name="spares_id" class='form-control'
                               value="" readonly id='e_spares_id'
                               placeholder=''>
                    </div>
                </div>
                <div class='form-group'>
                    <label for='e_item_name' class='col-lg-3 col-sm-3 control-label'>Item Name</label>
                    <div class='col-lg-9'>
                        <input type='text' name="item_name" class='form-control'
                               value="" readonly id='e_item_name'>
                    </div>
                </div> 
                <div class='form-group'>
                    <label for='e_brand' class='col-lg-3 col-sm-3 control-label'>Brand</label>

                    <div class='col-lg-9'>
                        <input type='text' required name="brand" class='form-control'
                               value="" id='e_brand'
                               placeholder=''>
                    </div>
                </div>
				  <div class='form-group'>
                    <label for='inputPassword1' class='col-lg-3 col-sm-3 control-label'>Rate</label>

                    <div class='col-lg-9'>
                        <input type='text' required name="rate" class='form-control'
                               value="" id='e_rate'
                               placeholder=''>
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
<div class="modal fade" role="dialog"  id="add_spares_rate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add Spares Rate</h4>
            </div>
            <?php $attributes = array('class' => 'form-horizontal group-border hover-stripped addform', 'id' => 'addform', 'method' => 'post');
            echo form_open_multipart('spares/add_spares_rate', $attributes); ?>
            <div class="modal-body">
				  
				<div class='form-group'>
                    <label for='a_sparesid' class='col-lg-3 col-sm-3 control-label'>Spares Id</label>
                    <div class='col-lg-9'>
                        <input type='text' name="spares_id" class='form-control'
                               value="" id='a_sparesid'
                               placeholder=''>
                    </div>
                </div>
                <div class='form-group'>
                    <label for='a_item_name' class='col-lg-3 col-sm-3 control-label'>Item Name</label>
                    <div class='col-lg-9'>
                        <input type='text' readonly name="item_name" class='form-control'
                               value="" id='a_item_name'>
                    </div>
                </div>
				 
                <div class='form-group'>
                    <label for='a_brand' class='col-lg-3 col-sm-3 control-label'>Brand</label> 
                    <div class='col-lg-9'>
                        <input type='text'   name="brand" class='form-control'
                               value="" id='a_brand'
                               placeholder=''>
                    </div>
                </div>
				  <div class='form-group'>
                    <label for='a_rate' class='col-lg-3 col-sm-3 control-label'>Rate</label> 
                    <div class='col-lg-9'>
                        <input type='text' required name="rate" class='form-control'
                               value="" id='a_rate'
                               placeholder=''>
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
 