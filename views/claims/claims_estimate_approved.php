<?php echo form_open_multipart(base_url() . 'index.php/claims/claims_estimate_approved_form', array('method' => 'post')); ?>
<div class="row">
	<div class="col-lg-6"><h2>Estimate GIC Approval For Survey No: <?php echo $surveyDetail['id']; ?></h2></div>
	<div class="col-lg-6 text-right">
		 
                        <a href="<?=base_url('claims/claims_details/'.$surveyDetail['id'])?>" class="btn btn-warning">Back</a> 
                    </div>
	<hr>
     
</div>
<div class="row">
	
	<?php 
						$where = array('claim_id' => $surveyDetail['id']);
						$getvalue =$this->Main_model->single_row('claim_survey_assign', $where, 's');
						//echo $getvalue['make_name']; 
	 
					 	$where = array('GIC_ID' => $surveyDetail['gic']);
						$getgic =$this->Main_model->single_row('gic', $where, 's');
		 
		 
						$whereclau = array('surveyor_id' => $getvalue['surveyor']);
						$surveyorname= $this->Main_model->single_row('surveyor', $whereclau, 's');
						?>
					 
		 				 <div class="col-xs-6">
						 <h3>Customer Details:</h3>
							 <ul class="list-unstyled">
								<li>Client Name:  <?= $surveyDetail['name']; ?></li>
								<li>Vehicle Reg No:  <?= $surveyDetail['regno']; ?> </li>
								<li>Claim No: <?= $surveyDetail['claim_no']; ?>  </li>
							</ul>
						</div>
                        <div class="col-xs-6 invoice-payment">
                            <h3>Insurer / Surveyor Details:</h3>
                             <ul class="list-unstyled">
								
								<li>Insurer Name: <?php echo $getgic['GIC_NAME']; ?></li>
                                <li>Surveyor Name: <?php echo $surveyorname['name']; ?></li>
                                 <li>Surveyed On: <?php echo date('d-m-Y', strtotime($getvalue['survey_date'])); ?></li>
                            </ul>
                        </div>
	
	
<div class="col-lg-12">
            
            <div class="box-body">
                
				
				 
				 
                            
                                 <input type="hidden" value="<?php echo $estimate['estimate_no']; ?>" size="16" required name="estimate_no"
                       class="form-control form-control-inline input-large">
                              
                       
				
				
				
				
                       <div class="col-lg-6">
                            <span>Approval Date: </span>
                                 <input type="text" value="<?php echo date('m/d/Y'); ?>" size="16" required name="approval_date"
                       class="form-control form-control-inline input-medium datepicker">
                              
                        </div>
                         
                         
						 
				
				
                        <div class="col-lg-6">
                            <span>Approval Assesment Upload: </span>
                                <input class="form-control form-control-inline input-large" required name="approval_assesment" type="file">  
                              
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
                <div class="input-group" style="display: none;">

                   
					
                   

                </div>
                         <hr>

                <div style="height:250px;overflow-y:scroll;" id="">

					 <input type="hidden" name="claims_id" class="form-control input-medium" value="<?php echo $surveyDetail['id']; ?>"/>
					
					
				<input type="hidden" value="<?php echo $customer_channel; ?>" id="customer_channel" name="customer_channel" >
							
							<input type="hidden" value="<?php echo $model_code; ?>" id="model_code" name="model_code" >
							
							<input type="hidden" value="<?php echo $vehicle_category; ?>" id="vehicle_category"  name="vehicle_category" >
							
							<input type="hidden" value="<?php echo $customer_city; ?>" id="customer_city" name="customer_city" > 
							
					 
					
					
                    <div>
                        <table cellspacing="0" border="1" style="font-size:11px;border-collapse:collapse;"
                               id="" class="table table-striped table-hover" rules="all">
                            <thead>
                            <tr>
                                <th>#</th> 
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Appr. Spares</th>
								<th>Appr. Labour</th>
                                <th>Appr. Total</th>
                                <th>Approved?</th>
								<th>Customer Liability</th>
								
                            </tr>
                            </thead>
                            <tbody id="purchase_entry_holder">
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
            $output['htmlfield'] .= '<td id="serial_' . $count . '">' . $count;
			
			 $output['htmlfield'] .= '<input type="hidden" name="estimate_id[]" value="'. $rows->id .'">';
									
			 $output['htmlfield'] .= '<input type="hidden" name="estimate_complaint[]" value="'. $rows->complaints .'">';
            $output['htmlfield'] .= '<input type="hidden" name="complaint_number[]" value="'.$rows->complaint_number .'"></td>';						
									
			if (empty($item_id)) {	
			$output['htmlfield'] .= '<td><input type="hidden" name="item_id[]" value="0"><input type="text" name="item_name[]" class="form-control" value="' . $rows->item .' ">';
			}else{ 
		    $output['htmlfield'] .= '<td><input type="hidden" name="item_id[]" value="' . $rows->item_id . '">'; 
            $output['htmlfield'] .= '<input type="text" name="item_name[]" class="form-control" value="' . $rows->item . '"></td>';
			}
				//QTY					
            $output['htmlfield'] .= '<td><div id="spinner4">
				
     <input type="hidden" name="actual_quantity[]" tabindex="1" id="actual_quantity_' . $count . '" onclick="calculate_liability(' . $count . ')" size="2" value="'. $qty_selected.'" class="form-control col-lg-2"  onkeyup="calculate_liability(' . $count . ')">
	 
	 
	 <input type="text" name="quantity[]" tabindex="1" id="quantity_' . $count . '" onclick="calculate_liability(' . $count . ')" size="2" value="'. $qty_selected.'" class="form-control col-lg-2"  onkeyup="calculate_liability(' . $count . ')">
	 
                                </div>
                            </div> </td>';
									
									
				//SPARES
									
            $output['htmlfield'] .= '<td><input type="hidden" required name="actual_unit_price[]"  onkeyup="calculate_liability(' . $count . ')" id="actual_unit_price_' . $count . '" size="6" value="'. $rows->rate.'">';
			$output['htmlfield'] .= '<input type="text" required name="unit_price[]"  onkeyup="calculate_liability(' . $count . ')" id="unit_price_' . $count . '" size="6" value="'. $rows->rate.'"></td>';
									
									
									
				//LABOUR					
			 $output['htmlfield'] .= '<td><input type="hidden" name="actual_labour_price[]"  required onkeyup="calculate_liability(' . $count . ')"  id="actual_labour_price_' . $count . '" size="6" value="'. $rows->labour_rate.'">';
			$output['htmlfield'] .= '<input type="text" name="labour_price[]"  required onkeyup="calculate_liability(' . $count . ')"  id="labour_price_' . $count . '" size="6" value="'. $rows->labour_rate.'"></td>';						
			
									
				
				//TOTAL					
            $output['htmlfield'] .= '<td>
        <input type="hidden" name="actual_estimated_amount[]" required  readonly="readonly" id="actual_single_entry_total_' . $count . '" size="6" value="'. $rows->amount.'">';
			$output['htmlfield'] .= '
        <input type="text" name="estimated_amount[]" required  readonly="readonly" id="single_entry_total_' . $count . '" size="6" value="'. $rows->amount.'">
         </td>';
									
									
									
            $output['htmlfield'] .= '<td>
			<select name="approval_status[]" id="approved_' . $count . '" class="form-control form-control-inline input-large" onchange="calculate_liability(' . $count . ')"><option value="Approved">Approved</option><option value="Partially Approved">Partially Approved</option><option value="Rejected">Rejected</option></select>
				</td>';
									
									
				//CUSTOMER LIABILITY					
			$output['htmlfield'] .= '<td>
        <input type="text" name="customer_liability[]" required  readonly="readonly" id="customer_liability_' . $count . '" size="6" value="0.000">
         </td>';
									
									
									
									
									
            	$output['htmlfield'] .= '</tr>';
				$output['thispdtcount'] = $count;
            echo $output['htmlfield'];
			
			//echo '<script>$(document).ready(function() {
   //calculate_liability(' . $count . ');
  // calculate_grand_total_for_purchase();
//});</script>';
				
				
				;
       
							
									
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
                            <span>Total Approved:
                                <input type="text" name="totalamount" id="net_payment" value=""
                                       class="form-control text-right" data-parsley-id="6284"></span>
                              
                        </div>
						<div class="form-group col-md-6">
                            <span>Total Customer Liability:
                                <input type="text" name="totalcustomerliability" id="customer_net_payment" value=""
                                       class="form-control text-right" data-parsley-id="6284"></span>
                              
                        </div>
                    </div>
                    </div>
                    <div style="text-align:right">
                        Total = <span style="font-weight:bold;" id="grand_totalnew"> 0</span>

                        <span style="font-size:11px;" id="">Total Items = </span>
                        <span style="font-size:11px; font-weight:bold;" id="items">0</span>
						<span style=""><button class="btn btn-success" type="submit">Update Approval</button></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

</div>

</form>
<script type="text/javascript">

	
	
   
var total_number = <?php echo $total_number; ?>;
	

 
	
	$(document).ready(function(){
 
	  $('form input').on('keypress', function(e) {
    return e.which !== 13;
});
 
		for (var i = 1; i <= total_number; i++) {
		calculate_liability(i);
		calculate_grand_total_for_purchase();
		}
	
	});
	
	
	 function calculate_liability(entry_number) {
		 
		 var approval = $("#approved_" + entry_number).val();
		 
		 
		 var quantity = $("#actual_quantity_" + entry_number).val();
		
		if(!$("#actual_unit_price_" + entry_number).val()){
			$("#unit_price_" + entry_number).val('0.000');
		}
		if(!$("#actual_labour_price_" + entry_number).val()){
			$("#actual_labour_price_" + entry_number).val('0.000');
		}
		 
		 
		 var actual_unit_purchase_price = parseInt($("#actual_unit_price_" + entry_number).val());
		var actual_labour_purchase_price = parseInt($("#actual_labour_price_" + entry_number).val());
		 
		var actual_single_entry_total = parseInt($("#actual_single_entry_total_" + entry_number).val());
		 
		 var purchase_price = actual_unit_purchase_price+actual_labour_purchase_price
		 var single_entry_total = quantity * purchase_price;
		 
		 if(approval == "Approved"){
			 $("#unit_price_" + entry_number).val(actual_unit_purchase_price);
			 $("#labour_price_" + entry_number).val(actual_labour_purchase_price);
			 $("#customer_liability_" + entry_number).val(0.000);
			 
		var new_customerliability = parseInt($("#customer_liability_" + entry_number).val());
         $("#single_entry_total_" + entry_number).val(actual_single_entry_total);
			 
		 }else if(approval == "Rejected"){
			 $("#unit_price_" + entry_number).val('0');
			 $("#labour_price_" + entry_number).val('0');
			 $("#customer_liability_" + entry_number).val(single_entry_total);
			 
		var new_customerliability = parseInt($("#customer_liability_" + entry_number).val());
         $("#single_entry_total_" + entry_number).val(actual_single_entry_total-new_customerliability);
			 
		 }else if(approval == "Partially Approved"){
			 
			 var new_unitprice = parseInt($("#unit_price_" + entry_number).val());
			 var new_labourprice = parseInt($("#labour_price_" + entry_number).val());
			 
			 var new_purchase_price =  new_unitprice+new_labourprice;
			 var new_single_entry_total = quantity * new_purchase_price;
			 
			 $("#customer_liability_" + entry_number).val(actual_single_entry_total-new_single_entry_total);
		 
			 var new_customerliability = parseInt($("#customer_liability_" + entry_number).val());
             $("#single_entry_total_" + entry_number).val(actual_single_entry_total-new_customerliability);
			 
		 }
		 
		 
		 
        calculate_grand_total_for_purchase();

    }
	
	

     

      


    function calculate_grand_total_for_purchase() {

        var grand_total = 0;
        for (var i = 1; i <= total_number; i++) {
            grand_total += Number($("#single_entry_total_" + i).val());

        }
		
		var grand_customertotal = 0;
        for (var i = 1; i <= total_number; i++) {
            grand_customertotal += Number($("#customer_liability_" + i).val());

        }
		
		
		$("#net_payment").val(grand_total);
		$("#customer_net_payment").val(grand_customertotal);
		
		
        $("#grand_totalnew").html(grand_total+grand_customertotal);   
        $("#items").html(total_number);

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
					
			body    += '<input type="hidden" name="estimate_id[]" value="0">';
					
            body    += '<input type="hidden" name="item_id[]" id="item_id_'+ data.count +'" value="'+ data.item_id + '"><input type="hidden" name="estimate_complaint[]" value="Additional Spares">';
            body    += '<input type="hidden" name="item_name[]" value="'+ data.item_name + '"><input type="hidden" name="complaint_number[]" value="0"><td>'+ data.item_name + '</td>';
            body    += '<td><div id="spinner4"> <input type="hidden" name="actual_quantity[]" tabindex="1" id="actual_quantity_'+ data.count + '" onclick="calculate_liability('+ data.count + ')" size="2" value="1" class="form-control col-lg-2" onkeyup="calculate_liability('+ data.count + ')"> <input type="text" name="quantity[]" tabindex="1" id="quantity_'+ data.count +'" onclick="calculate_liability('+ data.count + ')" size="2" value="1" class="form-control col-lg-2"  onkeyup="calculate_liability('+ data.count + ')"> </div>  </td>';
			 				
            body    += '<td><input type="hidden" name="actual_unit_price[]"  required onkeyup="calculate_liability('+ data.count + ')"  id="actual_unit_price_'+ data.count + '" size="6" value="'+ data.unit_price + '"><input type="text" name="unit_price[]"  required onkeyup="calculate_liability('+ data.count + ')"  id="unit_price_'+ data.count + '" size="6" value="'+ data.unit_price + '"></td>';
					
            body    += '<td><input type="hidden" name="actual_labour_price[]"  required onkeyup="calculate_liability('+ data.count + ')"  id="actual_labour_price_'+ data.count + '" size="6" value="'+ data.labour_price + '"><input type="text" name="labour_price[]"  required onkeyup="calculate_liability('+ data.count + ')"  id="labour_price_'+ data.count + '" size="6" value="'+ data.labour_price + '"></td>';
					
            body    += '<td><input type="hidden" name="actual_estimated_amount[]" required  readonly="readonly" id="actual_single_entry_total_'+ data.count + '" size="6" value="'+ data.estimated_amount + '"><input type="text" name="estimated_amount[]" required  readonly="readonly" id="single_entry_total_'+ data.count + '" size="6" value="'+ data.estimated_amount + '"></td>';
         //   body    += '<td> <i style="cursor: pointer;" id="delete_button_'+ data.count + '" onclick="delete_row(' body    += '')" class="fa fa-trash"></i></td>';
            
										
   body    += '<td> <select name="approval_status[]" id="approved_'+ data.count + '" class="form-control form-control-inline input-large" onchange="calculate_liability(' + data.count + ')"><option value="Approved">Approved</option><option value="Partially Approved">Partially Approved</option><option value="Rejected">Rejected</option></select> </td>';
									
									
				//CUSTOMER LIABILITY					
			 body    += '<td><input type="text" name="customer_liability[]" required  readonly="readonly" id="customer_liability_'+ data.count + '" size="6" value="0.000"</td>';
									
									
									
											
					
		    body    += '</tr>';
              
		    calculate_liability(data.coun);
   			calculate_grand_total_for_purchase();	
					 
        });
			body += '';
				
				$( "#purchase_entry_holder").append(body);
				
			  
				
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
					
			body    += '<input type="hidden" name="estimate_id[]" value="0">';
					
            body    += '<input type="hidden" name="item_id[]" value="'+ data.item_id + '"><input type="hidden" name="estimate_complaint[]" value="Additional Repair">';
            body    += '<input type="hidden" name="item_name[]" value="'+ data.item_name + '"><input type="hidden" name="complaint_number[]" value="0"><td>'+ data.item_name + '</td>';
             body    += '<td><div id="spinner4"> <input type="hidden" name="actual_quantity[]" tabindex="1" id="actual_quantity_'+ data.count + '" onclick="calculate_liability('+ data.count + ')" size="2" value="1" class="form-control col-lg-2" onkeyup="calculate_liability('+ data.count + ')"> <input type="text" name="quantity[]" tabindex="1" id="quantity_'+ data.count +'" onclick="calculate_liability('+ data.count + ')" size="2" value="1" class="form-control col-lg-2"  onkeyup="calculate_liability('+ data.count + ')"> </div>  </td>';
			 				
            body    += '<td><input type="hidden" name="actual_unit_price[]"  required onkeyup="calculate_liability('+ data.count + ')"  id="actual_unit_price_'+ data.count + '" size="6" value="'+ data.unit_price + '"><input type="text" name="unit_price[]"  required onkeyup="calculate_liability('+ data.count + ')"  id="unit_price_'+ data.count + '" size="6" value="'+ data.unit_price + '"></td>';
					
            body    += '<td><input type="hidden" name="actual_labour_price[]"  required onkeyup="calculate_liability('+ data.count + ')"  id="actual_labour_price_'+ data.count + '" size="6" value="'+ data.labour_price + '"><input type="text" name="labour_price[]"  required onkeyup="calculate_liability('+ data.count + ')"  id="labour_price_'+ data.count + '" size="6" value="'+ data.labour_price + '"></td>';
					
            body    += '<td><input type="hidden" name="actual_estimated_amount[]" required  readonly="readonly" id="actual_single_entry_total_'+ data.count + '" size="6" value="'+ data.estimated_amount + '"><input type="text" name="estimated_amount[]" required  readonly="readonly" id="single_entry_total_'+ data.count + '" size="6" value="'+ data.estimated_amount + '"></td>';
         //   body    += '<td> <i style="cursor: pointer;" id="delete_button_'+ data.count + '" onclick="delete_row(' body    += '')" class="fa fa-trash"></i></td>';
            
										
   body    += '<td> <select name="approval_status[]" id="approved_'+ data.count + '" class="form-control form-control-inline input-large" onchange="calculate_liability(' + data.count + ')"><option value="Approved">Approved</option><option value="Partially Approved">Partially Approved</option><option value="Rejected">Rejected</option></select> </td>';
									
									
				//CUSTOMER LIABILITY					
			 body    += '<td><input type="text" name="customer_liability[]" required  readonly="readonly" id="customer_liability_'+ data.count + '" size="6" value="0.000"</td>';
            
					 body    += '</tr>';
              
		    calculate_liability(data.coun);
   			calculate_grand_total_for_purchase();	
					 
        });
			body += '';
				
				$( "#purchase_entry_holder").append(body);
				
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