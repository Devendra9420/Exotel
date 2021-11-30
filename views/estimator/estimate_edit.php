<?php echo form_open_multipart(base_url() . 'index.php/claims/claims_estimate_edit_form', array('method' => 'post')); ?>
<div class="row">
	<div class="col-lg-6"><h2>Estimate For Survey No: <?php echo $surveyDetail['id']; ?></h2></div>
	<div class="col-lg-6 text-right">
		 
                        <a href="<?=base_url('claims/claims_details/'.$surveyDetail['id'])?>" class="btn btn-warning">Back</a> 
                    </div>
	<hr>
     
</div>
<div class="row">
<div class="col-lg-12">
            
            <div class="box-body">
                
                       <div class="col-lg-6">
                            <span>Estimate Date: </span>
                                 <input type="text" value="<?php echo date('m/d/Y',strtotime($estimate['estimate_date'])); ?>" size="16" required name="estimate_date"
                       class="form-control form-control-inline input-medium datepicker">
                              
                        </div>
                         
                         
				
                        <div class="col-lg-6">
                            <span>Estimate No: </span>
                                 <input type="text" value="<?php echo $estimate['estimate_no']; ?>" size="16" required name="estimate_no"
                       class="form-control form-control-inline input-large">
                              
                        </div>
						     
                         
                     
                    
                 
            </div>
        </div>
</div>
<div class="row">
    <div class="col-lg-12">

        <div class="box box-warning">
            <div class="box-heading">
                <h5> </h5>
					
            </div>
            <div class="box-body" id="rows-list">
                <div class="input-group">
						
					
					
                    
				
					
					<div class="row">
						
						
						<div class="col-md-6">
                           <div class="form-group" id="service_category_form">
                              <label class="control-label">Specific Spares<span class='text-danger'>*</span></label>
                              <select class="form-control select2"   onchange="return getSpecificSparesRates();"   name="specific_spares" id="specific_spares">
								  <option value="">Select</option> 
								  
								  <?php foreach($spares_list as $spares){ ?>   
								<option value="<?php echo $spares->item_code; ?>"><?php echo $spares->item_name; ?></option>
						<?php } ?> 
							   </select>
                           </div>
                            
                      </div>
						<div class="col-md-6">
                           <div class="form-group" id="service_category_form">
                              <label class="control-label">Specific Repairs<span class='text-danger'>*</span></label>
                              <select class="form-control select2"    onchange="return getSpecificLabourRates();"    name="specific_repairs" id="specific_repairs">
								  <option value="">Select</option> 
								  <?php foreach($labour_list as $labour){ ?>   
								<option value="<?php echo $labour->item_code; ?>"><?php echo $labour->item_name; ?></option>
						<?php } ?> 
							   </select>
                           </div>
                            
                      </div>	
						</div>	
					
					
                </div>
                         <hr>

                <div style="height:250px;overflow-y:scroll;" id="">

					 <input type="hidden" name="claims_id" class="form-control input-medium" value="<?php echo $surveyDetail['id']; ?>"/>
					
					<input type="hidden" value="<?php echo $customer_channel; ?>" id="customer_channel" name="customer_channel" >
							
							<input type="hidden" value="<?php echo $model_code; ?>" id="model_code" name="model_code" >
							
							<input type="hidden" value="<?php echo $vehicle_category; ?>" id="vehicle_category"  name="vehicle_category" >
							
							<input type="hidden" value="<?php echo $customer_city; ?>" id="customer_city" name="customer_city" > 
							
					
					
                    <div>
                        <table class="table table-striped table-hover table-bordered dataTable" id="servicetable" aria-describedby="editable-sample_info"> 
					<thead>
						<th>#</th> 
						<th>Description</th>
						<th>Quantity</th> 
						<th>Spares Cost</th>
						<th>Labour Cost</th>
						<th>Total</th>
						<th><i class="fa fa-trash"></i></th> 
					    </thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all" id="service_estimate_entry">
							<?php 
								$total_number = 0;
								foreach ($estimate_det as $rows) {
									
								 
										
										$total_number++;
										
								 $item_id = $rows->item_id;
        $count =  $total_number;
		$qty_selected = $rows->qty;
        $this->load->model('Main_model'); 
									
				  
         
            $output['htmlfield'] = '';
            $output['htmlfield'] .= '<tr id="entry_row_' . $count . '">';
            $output['htmlfield'] .= '<input type="hidden" name="jobdet_ID[]" value="' . $rows->id . '"><td id="serial_' . $count . '">' . $count . '</td>';  
			 
		    $output['htmlfield'] .= '<input type="hidden" name="item_id[]" id="item_id_'. $count .'" value="' . $rows->item_id . '"> <input type="hidden" name="estimate_complaint[]" value="' . $rows->complaints . '"><input type="hidden" name="complaint_number[]" value="0">';
            $output['htmlfield'] .= '<input type="hidden" name="item_name[]" value="' . $rows->item . '">';
			$output['htmlfield'] .= '<td>' . $rows->item .' </td>';
			 
									
            $output['htmlfield'] .= '<td><div id="spinner4"><input type="text" name="quantity[]" tabindex="1" id="quantity_' . $count . '" onclick="calculate_single_entry_sum(' . $count . ')" size="2" value="'. $qty_selected.'" class="form-control col-lg-2"  onkeyup="calculate_single_entry_sum(' . $count . ')"></div>  </td>';
			 
										
            $output['htmlfield'] .= '<td><input type="text" required name="unit_price[]"  onkeyup="calculate_single_entry_sum(' . $count . ')" id="unit_price_' . $count . '" size="6" value="'. $rows->rate.'"></td>';
			
			 $output['htmlfield'] .= '<td><input type="text" name="labour_price[]"  required onkeyup="calculate_single_entry_sum(' . $count . ')"  id="labour_price_' . $count . '" size="6" value="'. $rows->labour_rate.'"></td>';
			
            $output['htmlfield'] .= '<td><input type="text" name="estimated_amount[]" required  readonly="readonly" id="single_entry_total_' . $count . '" size="6" value="'. $rows->amount.'"></td>';
			
										if($rows->complaints=="Service Category"){ 
            $output['htmlfield'] .= '<td> </td>';
										}else{
				$output['htmlfield'] .= '<td><i style="cursor: pointer;" id="delete_button_' . $count . '" onclick="delete_row(' . $count . ')" class="fa fa-trash"></i></td>';							
										}
				$output['htmlfield'] .= '</tr>';
										
				$output['thispdtcount'] = $count;
										
            echo $output['htmlfield'];
			
			// echo '<script> 
  // calculate_single_entry_sum(' . $count . ');
  //  calculate_grand_total_for_purchaseonload(' . $count . ');
 // </script>';
				
				
				 
						 
							
									
								}
						
								?>
								
                            </tbody>
                        </table>
                    </div>


                </div>

                <div class="box-footer">
                    <div style="text-align:left">
						<div class="form-group col-md-10">
						 <div class="form-group col-md-6">
                            <span>Total:
                                <input type="text" name="totalamount" id="net_payment" value=""
                                       class="form-control text-right" data-parsley-id="6284"></span>
                              
                        </div>
						<div class="form-group col-md-6">
                        
						</div>
                    </div>
                    </div>
                    <div style="text-align:right">
                        Total = <span style="font-weight:bold;" id="grand_totalnew"> 0</span>

                        <span style="font-size:11px;" id="">Total Items = </span>
                        <span style="font-size:11px; font-weight:bold;" id="items">0</span>
						<span style=""><button class="btn btn-success" type="submit">Update Estimate</button></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

</div>

</form>
<script type="text/javascript">

    //var total_number = 0;
	var total_number = <?php echo $total_number; ?>;
    
	 
	 var c_total_number = 0;
	 
	 
	$(document).ready(function(){
 
	  $('form input').on('keypress', function(e) {
    return e.which !== 13;
});
 
		for (var i = 1; i <= total_number; i++) {
		calculate_single_entry_sum(i);
		calculate_grand_total_for_purchase();
		}
	
	});
	
	
	
  
     

 

    
function c_calculate_single_entry_sum(entry_number) {

        var c_quantity = $("#c_quantity_" + entry_number).val();
		
		if(!$("#c_unit_price_" + entry_number).val()){
			$("#c_unit_price_" + entry_number).val('0');
		}
		if(!$("#c_labour_price_" + entry_number).val()){
			$("#c_labour_price_" + entry_number).val('0');
		}
        var c_unit_purchase_price = parseInt($("#c_unit_price_" + entry_number).val());
		var c_labour_purchase_price = parseInt($("#c_labour_price_" + entry_number).val());
		var c_purchase_price = c_unit_purchase_price+c_labour_purchase_price
        var c_single_entry_total = c_quantity * c_purchase_price;
        $("#c_single_entry_total_" + entry_number).val(c_single_entry_total);
         

    }
	

	function calculate_single_entry_sum(entry_number) {

        var quantity = $("#quantity_" + entry_number).val();
		
		if(!$("#unit_price_" + entry_number).val()){
			$("#unit_price_" + entry_number).val('0');
		}
		if(!$("#labour_price_" + entry_number).val()){
			$("#labour_price_" + entry_number).val('0');
		}
        var unit_purchase_price = parseInt($("#unit_price_" + entry_number).val());
		var labour_purchase_price = parseInt($("#labour_price_" + entry_number).val());
		var purchase_price = unit_purchase_price+labour_purchase_price
        var single_entry_total = quantity * purchase_price;
        $("#single_entry_total_" + entry_number).val(single_entry_total);
        calculate_grand_total_for_purchase();

    }

    function balance_total() {


        var gtotal = $('#grand_total').val();
        var pay = $('#payment').val();

        if (gtotal && pay) {
            var bal = gtotal - pay;
            $("#balance").val(bal);
        }
    }

    function delete_row(entry_number) {
       
        $("#entry_row_" + entry_number).remove();

        for (var i = entry_number; i < total_number; i++) {

			var thisitemid = $("#item_id_" + (i)).val();
			
            $("#serial_" + (i + 1)).attr("id", "serial_" + i);
            $("#serial_" + (i)).html(i);

            $("#quantity_" + (i + 1)).attr("id", "quantity_" + i);
            $("#quantity_" + (i)).attr({
                onkeyup: "calculate_single_entry_sum(" + i + ")",
                onclick: "calculate_single_entry_sum(" + i + ")"
            });

            $("#unit_price_" + (i + 1)).attr("id", "unit_price_" + i);
            $("#unit_price_" + (i)).attr({
                onkeyup: "calculate_single_entry_sum(" + i + ")",
                onclick: "calculate_single_entry_sum(" + i + ")"
            });
			
			
            $("#labour_price_" + (i + 1)).attr("id", "labour_price_" + i);
            $("#labour_price_" + (i)).attr({
                onkeyup: "calculate_single_entry_sum(" + i + ")",
                onclick: "calculate_single_entry_sum(" + i + ")"
            });
			
			 
			
            $("#delete_button_" + (i + 1)).attr("id", "delete_button_" + i);
            $("#delete_button_" + (i)).attr("onclick", "delete_row(" + i + ")");

            $("#entry_row_" + (i + 1)).attr("id", "entry_row_" + i);
			
			$("#single_entry_total_" + (i + 1)).attr("id", "single_entry_total_" + i);
        }

        total_number--;
        calculate_grand_total_for_purchase();
    }
	
	
	function c_delete_row(c_entry_number) {
       
        $("#c_entry_row_" + c_entry_number).remove();

        for (var i = c_entry_number; i < c_total_number; i++) {

            $("#c_serial_" + (i + 1)).attr("id", "c_serial_" + i);
            //$("#c_serial_" + (i)).html('Option'+i);

            $("#c_quantity_" + (i + 1)).attr("id", "c_quantity_" + i);
             $("#c_quantity_" + (i)).attr({
                onkeyup: "c_calculate_single_entry_sum(" + i + ")",
                onclick: "c_calculate_single_entry_sum(" + i + ")"
            });

            $("#c_unit_price_" + (i + 1)).attr("id", "c_unit_price_" + i);
            $("#c_unit_price_" + (i)).attr({
                onkeyup: "c_calculate_single_entry_sum(" + i + ")",
                onclick: "c_calculate_single_entry_sum(" + i + ")"
            });
			
			
            $("#c_labour_price_" + (i + 1)).attr("id", "c_labour_price_" + i);
             $("#c_labour_price_" + (i)).attr({
                onkeyup: "c_calculate_single_entry_sum(" + i + ")",
                onclick: "c_calculate_single_entry_sum(" + i + ")"
            });

            $("#c_delete_button_" + (i + 1)).attr("id", "c_delete_button_" + i);
            $("#c_delete_button_" + (i)).attr("onclick", "c_delete_row(" + i + ")");

            $("#c_entry_row_" + (i + 1)).attr("id", "c_entry_row_" + i);
			$("#c_single_entry_total_" + (i + 1)).attr("id", "c_single_entry_total_" + i);
        }

        c_total_number--; 
    }


    function calculate_grand_total_for_purchase() {

        grand_total = 0;
        for (var i = 1; i <= total_number; i++) {
            grand_total += Number($("#single_entry_total_" + i).val());

        }
        $("#grand_totalnew").html(grand_total);
        $("#hidden_total").val(grand_total);
        $("#sub_total").val(grand_total);
        $("#net_payment").val(grand_total);
        $("#items").html(total_number);

    }
  
    function calculate_discount(id) {

        var amount = $("#sub_total").val();
        discount = (id / 100) * amount;
        var net_payment = amount - discount;
        $("#net_payment").val(net_payment);


    }
  
    function calculate_change_amount() {
        get_grand_total = Number($("#net_payment").val());
        get_payment_amount = Number($("#payment").val());

        if (get_payment_amount > get_grand_total) {

            change_amount = get_payment_amount - get_grand_total;
            change_amount = change_amount.toFixed(2);
            $("#change_amount").attr("value", change_amount);
            get_change_amount = Number($("#change_amount").val());
            net_payable = get_payment_amount - get_change_amount;
            net_payable = net_payable.toFixed(2);
            $("#net_payment").attr("value", net_payable);
            $("#due_amount").attr("value", 0);
        }

        if (get_payment_amount < get_grand_total) {

            $("#change_amount").attr("value", 0);
            $("#net_payment").attr("value", get_payment_amount);
            get_due_amount = get_grand_total - get_payment_amount;
            get_due_amount = get_due_amount.toFixed(2);
            $("#due_amount").attr("value", get_due_amount);
        }

        if (get_payment_amount == get_grand_total) {

            $("#change_amount").attr("value", 0);
            $("#net_payment").attr("value", get_payment_amount);
            $("#due_amount").attr("value", 0);
        }
    }
	
	
	function get_brand_rates(id, item_id){
		var csrf_test_name = $("input[name=csrf_test_name]").val();
		  var brand = $('#brand_'+id).val();
		  var unit_price = $('#unit_price_'+id).val(); 
		 var customer_channel = $('#customer_channel').val(); 
		   if(brand > 0 || brand == ''){ 
			   // total_number++;
        $.ajax({
            url: '<?=base_url();?>index.php/claims/getSparesBrandPrice/',
            type: 'POST',
            data: {'brand': brand, 'item_id':item_id, 'customer_channel':customer_channel, 'csrf_test_name': csrf_test_name},
            dataType: 'html',
            success: function (data) {
                 
				$('#unit_price_'+id).val(data);
				calculate_single_entry_sum(id); 

            }
        });
			   
		   }else{
			   $('#unit_price_'+id).val('0');
				 calculate_single_entry_sum(id); 
		   }
	}
	
	
	function get_brand_rates_complaints(id, item_id){
		var csrf_test_name = $("input[name=csrf_test_name]").val();
		  var brand = $('#c_brand_'+id).val();
		  var unit_price = $('#c_unit_price_'+id).val(); 
		 var customer_channel = $('#customer_channel').val(); 
		   if(brand > 0 || brand == ''){ 
			   // total_number++;
        $.ajax({
            url: '<?=base_url();?>index.php/claims/getSparesBrandPrice/',
            type: 'POST',
            data: {'brand': brand, 'item_id':item_id, 'customer_channel':customer_channel, 'csrf_test_name': csrf_test_name},
            dataType: 'html',
            success: function (data) {
                 
				$('#c_unit_price_'+id).val(data);
				c_calculate_single_entry_sum(id); 

            }
        });
		   }else{
			   $('#c_unit_price_'+id).val('0');
				c_calculate_single_entry_sum(id); 
		   }
	}


    
    
     


     
  
   
  
    
	
	
	
	function getSpecificSparesRates(){
		 
	  	  var csrf_test_name = $("input[name=csrf_test_name]").val();
		  var specific_spares = $('#specific_spares').val();
		  var vehicle_category = $('#vehicle_category').val();
		var customer_channel = $('#customer_channel').val();
		
		var customer_city = $('#customer_city').val();
		  var model_code = $('#model_code').val();		
		   if(specific_spares !== ""){ 
			   // total_number++;
        $.ajax({
            url: '<?=base_url();?>index.php/claims/estimate_SpecificSpares/',
            type: 'POST',
            data: {'total':  total_number, 'specific_spares': specific_spares, 'model_code':model_code, 'vehicle_category': vehicle_category, 'csrf_test_name': csrf_test_name, 'customer_channel':customer_channel, 'customer_city':customer_city},
            dataType: 'json',
            success: function (data) {
                
				
				//$('#servicetable').DataTable().destroy();
				
				var body = '';
				
				$.each(data, function(i, data) {
					 total_number++;
					data.count= total_number;
            body += '<tr id="entry_row_'+ data.count + '">';
            body    += '<td id="serial_'+ data.count + '">'+ data.count + '</td>';
            body    += '<input type="hidden" name="item_id[]" id="item_id_'+ data.count +'" value="'+ data.item_id + '"><input type="hidden" name="estimate_complaint[]" value="Additional Spares">';
            body    += '<input type="hidden" name="item_name[]" value="'+ data.item_name + '"><input type="hidden" name="complaint_number[]" value="0"><td>'+ data.item_name + '</td>';
            body    += '<td><div id="spinner4"> <input type="text" name="quantity[]" tabindex="1" id="quantity_'+ data.count + '" onclick="calculate_single_entry_sum('+ data.count + ')" size="2" value="1" class="form-control col-lg-2" onkeyup="calculate_single_entry_sum('+ data.count + ')"> </div>  </td>';
			 				
            body    += '<td><input type="text" name="unit_price[]"  required onkeyup="calculate_single_entry_sum('+ data.count + ')"  id="unit_price_'+ data.count + '" size="6" value="'+ data.unit_price + '"></td>';
            body    += '<td><input type="text" name="labour_price[]"  required onkeyup="calculate_single_entry_sum('+ data.count + ')"  id="labour_price_'+ data.count + '" size="6" value="'+ data.labour_price + '"></td>';
            body    += '<td><input type="text" name="estimated_amount[]" required  readonly="readonly" id="single_entry_total_'+ data.count + '" size="6" value="'+ data.estimated_amount + '"></td>';
            body    += '<td> <i style="cursor: pointer;" id="delete_button_'+ data.count + '" onclick="delete_row('+ data.count + ')" class="fa fa-trash"></i></td>';
            body    += '</tr>';
            
					 
        });
			body += '';
				
				$( "#service_estimate_entry").append(body);
				
			 
				
				//
//				$('#servicetable').DataTable({
//            'paging': false, 
//            'lengthChange': false,
//            'searching': false,
//            'ordering': false,
//            'info': false,
//            'autoWidth': true }).draw();
				calculate_grand_total_for_purchase();

            }
        });
		   }
	  } 
			
			
			
			
			function getSpecificLabourRates(){
		 
	  	  var csrf_test_name = $("input[name=csrf_test_name]").val();
		  var specific_repairs = $('#specific_repairs').val();
		  var vehicle_category = $('#vehicle_category').val();
		  var model_code = $('#model_code').val();	
		  var customer_city = $('#customer_city').val();			
		   if(specific_repairs !== ""){ 
			   // total_number++;
        $.ajax({
            url: '<?=base_url();?>index.php/claims/estimate_SpecificLabour/',
            type: 'POST',
            data: {'total': total_number, 'specific_repairs': specific_repairs, 'model_code':model_code, 'vehicle_category': vehicle_category, 'csrf_test_name': csrf_test_name, 'customer_city':customer_city},
            dataType: 'json',
            success: function (data) {
                
				
				//$('#servicetable').DataTable().destroy();
				
				var body = '';
				
				$.each(data, function(i, data) {
					total_number++;
					data.count=total_number;
            body += '<tr id="entry_row_'+ data.count + '">';
            body    += '<td id="serial_'+ data.count + '">'+ data.count + '</td>';
            body    += '<input type="hidden" name="item_id[]" value="'+ data.item_id + '"><input type="hidden" name="estimate_complaint[]" value="Additional Repair">';
            body    += '<input type="hidden" name="item_name[]" value="'+ data.item_name + '"><input type="hidden" name="complaint_number[]" value="0"><td>'+ data.item_name + '</td>';
            body    += '<td><div id="spinner4"> <input type="text" name="quantity[]" tabindex="1" id="quantity_'+ data.count + '" onclick="calculate_single_entry_sum('+ data.count + ')" size="2" value="1" class="form-control col-lg-2" onkeyup="calculate_single_entry_sum('+ data.count + ')"> </div> </td>';
            
			body    += '<td><input type="text" name="unit_price[]"  required onkeyup="calculate_single_entry_sum('+ data.count + ')"  id="unit_price_'+ data.count + '" size="6" value="'+ data.unit_price + '"></td>';
            body    += '<td><input type="text" name="labour_price[]"  required onkeyup="calculate_single_entry_sum('+ data.count + ')"  id="labour_price_'+ data.count + '" size="6" value="'+ data.labour_price + '"></td>';
            body    += '<td><input type="text" name="estimated_amount[]" required  readonly="readonly" id="single_entry_total_'+ data.count + '" size="6" value="'+ data.estimated_amount + '"></td>';
            body    += '<td> <i style="cursor: pointer;" id="delete_button_'+ data.count + '" onclick="delete_row('+ data.count + ')" class="fa fa-trash"></i></td>';
            body    += '</tr>';
            
					 
        });
			body += '';
				
				$( "#service_estimate_entry").append(body);
				
				//$('#servicetable').DataTable({
//            'paging': false, 
//            'lengthChange': false,
//            'searching': false,
//            'ordering': false,
//            'info': false,
//            'autoWidth': true }).draw();
				calculate_grand_total_for_purchase();

            }
        });
		   }
	  } 
	
</script>