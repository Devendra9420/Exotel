
 <div class="section-body">
            <h2 class="section-title">Spares Mapping</h2>
            <p class="section-lead">  
            </p>  
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header text-right"> 
            </div>
			<?php $attributes = array('class' => 'form-horizontal group-border hover-stripped editform', 'id' => 'editform', 'method' => 'post');
            echo form_open_multipart('spares/update_spares_map', $attributes); ?>
            <div class="box-body">
				
				<div class="row">
					<div class="col-lg-12">
					<div class='form-group'>
                    <label for='item_code' class='col-lg-6 col-sm-6 control-label'>Spares Id</label>
                    <div class='col-lg-9'>
                        <select type='text' name="primary_spares_id" style="width: 100%;" class='form-control' value="" id='spares_id'>
						</select>	
						<input type='hidden' readonly required name="primary_item_name" class='form-control input-item_name' id='primary_item_name'>
						<input type='hidden' readonly required name="primary_model" class='form-control input-spares_id' id='primary_model'>
						<input type='hidden'   required name="primary_vehicle_category" class='form-control input-spares_id' id='primary_vehicle_category'>
						<input type='hidden'   required name="primary_item_code" class='form-control input-spares_id' id='primary_item_code'>
                    </div>
                </div> 
					<div>Item Name: <b><span id="item_name_div"></span></b>	|	Model: <b><span id="model_div"></span></b>	|	Vehicle Category: <b><span id="vehicle_category_div"></span></b></div>
					</div>
				</div>
				
				 
				<div class="table-responsive">
                <table class="table table-striped" id="spares_map_table">
                    <thead>
                    <tr role="row">
                        <th>Id
                        </th>
                        <th>Make
                        </th>
                        <th>Model
                        </th> 
						<th>Delete
                        </th>  
                    </tr>
                    </thead> 
                    <tbody> 
                    </tbody>
                </table>
				</div>
				<span class="text-right float-right"><button type="button" id="add-row" class="btn btn-info btn-outline">Add Row</button></span>
				
				<span class="text-left float-left"><?php echo $this->rbac->updatePermission; ?></span>
            </div>
			
			</form>
        </div>

    </div>
</div>

	 </div>

 
 