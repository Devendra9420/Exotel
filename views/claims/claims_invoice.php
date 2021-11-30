<?php echo form_open_multipart(base_url() . 'index.php/claims/claims_invoice_form', array('method' => 'post')); ?>
<div class="row">
	<div class="text-left"><h2>Invoice For Survey No: <?php echo $surveyDetail['id']; ?></h2></div>
	<div class="text-right">
                        <a href="<?=base_url('claims/claims_details/'.$surveyDetail['id'])?>" class="btn btn-warning">Back</a>
                    </div>
	<hr>
     
</div>
<div class="row">
     
	<div class="col-lg-8">

        <div class="box box-warning">
            <div class="box-heading">
                <h5> </h5>
				<div class="col-lg-6">	
					<label for="cname" class="control-label col-lg-3">Invoice No</label>
					<div class="form-group">
                          <input type="text" value="" size="16" required name="invoice_no"
                       class="form-control form-control-inline input-large">
						 
                    </div>
                </div>
				  
				<div class="col-lg-6">	
					<label for="cname" class="control-label col-lg-3">Invoice Date</label>
					<div class="form-group" >	
                          <input type="text" value="<?php echo date('d-m-Y'); ?>" size="16" required name="invoice_date"
                       class="form-control form-control-inline input-medium datepickernopast">
						 
                    </div>
                </div>	
            </div>
            <div class="box-body" id="rows-list">
                <div class="input-group">

                    <span class="input-group-addon"> <span class="fa fa-search"> </span> </span>
					
                   <select class="form-control product input-xlarge pdtfromdb" name="item_id" id="surveyestimate_items"
                            onchange="return get_purchased_data(this.value);">
                        

                </div>
                         <hr>

                <div style="height:250px;overflow-y:scroll;" id="">

					 <input type="hidden" name="claims_id" class="form-control input-medium" value="<?php echo $surveyDetail['id']; ?>"/>
                    <div>
                        <table cellspacing="0" border="1" style="font-size:11px;border-collapse:collapse;"
                               id="" class="table table-striped table-hover" rules="all">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Rate</th> 
                                <th>Total</th>
								<th>Insurer Amt</th>
								<th>Customer Amt</th>
                                <th><i class="fa fa-trash"></i></th>
                            </tr>
                            </thead>
                            <tbody id="purchase_entry_holder">
							
								<?php 
								$total_number = 0;
								foreach ($estimates as $rows) {
									
									 $total_number++;
								 $item_id = $rows->item_id;
        $count =  $total_number;
		$qty_selected = $rows->qty;
		
		$rate_selected = intval($rows->rate);
		$totalamt_selected = intval($rows->amount);
									
        $this->load->model('Main_model');

        $where = array('item_id' => $item_id);
        $data = $this->Main_model->get_purchased($item_id);
									
        if ($item_id != "") {
            $output['htmlfield'] = '';
            $output['htmlfield'] .= '<tr id="entry_row_' . $count . '">';
            $output['htmlfield'] .= '<td id="serial_' . $count . '">' . $count . '</td>';
			
			
			 if ($item_id == 0) {
			$output['htmlfield'] .= '<td colspan="2"><input type="hidden" name="item_id[]" class="form-control" value="0"><input type="text" name="item_name[]" class="form-control" value="'.$rows->item.'"> </td>';
			 }else{
			
				  $output['htmlfield'] .= '<td><input type="hidden" name="item_id[]" value="' . $data->item_id . '"> ' . $data->item_id . '</td>';
			$output['htmlfield'] .= '<input type="hidden" name="item_name[]" value="' . $data->item_name . ' - ' . $data->sub_product . ' - ' . $data->brand . '">';
            //$output .= '<input type="hidden" name="category_id[]" value="' . $data->category_id . '">';
            $output['htmlfield'] .= '<td>' . $data->item_name . ' - ' . $data->sub_product . '<br>' . $data->brand . '</td>';
				 
			 }
				
           
            $output['htmlfield'] .= '<td><div id="spinner4">

     <input type="text" name="quantity[]" tabindex="1" id="quantity_' . $count . '" onclick="calculate_single_entry_sum(' . $count . ')" size="2" value="'.$qty_selected.'" class="form-control col-lg-2" onkeyup="calculate_single_entry_sum(' . $count . ')">

                                </div>
                            </div></td>';
            $output['htmlfield'] .= '<td><input type="text" name="unit_price[]"  required onkeyup="calculate_single_entry_sum(' . $count . ')"  id="unit_price_' . $count . '" size="6" value="'.$rate_selected.'"></td>';
			
			//$output  .= '<td><input type="text" required name="mrp[]" id="mrp_' . $count . '" size="6" value=""></td>';
			
			
            $output['htmlfield'] .= '<td>
        <input type="text" name="estimated_amount[]" required  readonly="readonly" id="single_entry_total_' . $count . '" size="6" value="'.$totalamt_selected.'">
        </td>';
			
			$output['htmlfield'] .= '<td><input type="text" name="insurer_amount[]" required onkeyup="calculate_customer_entry_sum(' . $count . ')" id="insurer_single_total_' . $count . '" size="6" value=""></td>';
			
			$output['htmlfield'] .= '<td><input type="text" name="customer_amount[]" required  readonly="readonly" id="customer_single_total_' . $count . '" size="6" value=""></td>';
				
				
            $output['htmlfield'] .= '<td>
<i style="cursor: pointer;" id="delete_button_' . $count . '" onclick="delete_row(' . $count . ')" class="fa fa-trash"></i>
				</td>';
            $output['htmlfield'] .= '</tr>';
				$output['thispdtcount'] = $count;
            echo $output['htmlfield'];
			
			echo '<script>$(document).ready(function() {
   calculate_single_entry_sum(' . $count . ');
   calculate_customer_entry_sum(' . $count . ');
   calculate_grand_total_for_purchaseonload(' . $count . ');
});</script>';
				
				
				;
        } else {
            echo $output = 0;
        }
							
									
								}
										
								?>
								
                            </tbody>
                        </table>
                    </div>


                </div>

                <div class="box-footer">
                    <div style="text-align:left">
                    </div>
                    <div style="text-align:right">
                        Total = <span style="font-weight:bold;" id="grand_totalnew"> 0</span>

                        <span style="font-size:11px;" id="">Total Items = </span>
                        <span style="font-size:11px; font-weight:bold;" id="items">0</span>
                    </div>
					<hr>
					
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 ui-sortable" >
        <!-- begin box -->
        <div data-sortable-id="ui-widget-10" class="box box-success">
            <div class="box-heading">
                <h4 class="box-title">
                    Payment </h4>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                         
						<tr style="display: none;">
                            <td>Sub Total</td>
                            <td>
                                <input type="text" name="sub_total" value="" id="sub_total"
                                       class="form-control text-right" data-parsley-id="0979">
                                <ul class="parsley-errors-list" id="parsley-id-0979"></ul>
                            </td>
                        </tr>
                        <tr style="display: none;">
                            <td>Discount <span class="badge badge-primary"> % </span></td>
                            <td id="customer_discount_holder">
                                <input type="text" name="discount" value="" id="discount"
                                       onchange="calculate_discount(this.value);" class="form-control text-right">
                            </td>
                        </tr>
                        <tr style="display: none;">
                            <td>Payment</td>
                            <td>
                                <input type="text" data-parsley-required="true" placeholder="Enter Payment Amount"
                                       onkeyup="return calculate_change_amount()" value="" id="payment"
                                       name="paymentTotal"
                                       class="form-control text-right" data-parsley-id="4305">
                                <ul class="parsley-errors-list" id="parsley-id-4305"></ul>
                            </td>
                        </tr>
                         
                        <tr>
                            <td>Total</td>
                            <td>
                                <input type="text" name="totalamount" id="net_payment" value=""
                                       class="form-control text-right" data-parsley-id="6284">
                                <ul class="parsley-errors-list" id="parsley-id-6284"></ul>
                            </td>
                        </tr>
						
							<tr>
                            <td>Insurer Total</td>
                            <td>
                                <input type="text" name="insurer_totalamount" id="insurer_net_payment" value=""
                                       class="form-control text-right" data-parsley-id="6284">
                                <ul class="parsley-errors-list" id="parsley-id-6284"></ul>
                            </td>
                        </tr>
							
							<tr>
                            <td>Customer Total</td>
                            <td>
                                <input type="text" name="customer_totalamount" id="customer_net_payment" value=""
                                       class="form-control text-right" data-parsley-id="6284">
                                <ul class="parsley-errors-list" id="parsley-id-6284"></ul>
                            </td>
                        </tr>
							
                        <tr style="display: none;">
                            <td>Due</td>
                            <td>
                                <input type="text" name="due_amount" id="due_amount" value=""
                                       class="form-control text-right" data-parsley-id="3991">
                                <ul class="parsley-errors-list" id="parsley-id-3991"></ul>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="form-group col-md-10">
                        <button class="btn btn-success" type="submit">Create Invoice</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end box -->
    </div>

</div>

</form>
<script type="text/javascript">

    //var total_number = 0;
	var total_number = <?php echo $total_number; ?>;
    function get_purchased_data(product_id) {
        if(product_id != '' && product_id != ' '){
		total_number++;
        var csrf_test_name = $("input[name=csrf_test_name]").val();
		if(product_id == '0'){
			var output
			 output = '<tr id="entry_row_' +total_number+ '"> <td id="serial_' +total_number+ '">' +total_number+ '</td> <td colspan="2"><input type="hidden" name="item_id[]" class="form-control" value="0"><input type="text" name="item_name[]" class="form-control" value="Labour"> </td> <td><div id="spinner4"><input type="text" name="quantity[]" tabindex="1" id="quantity_' +total_number+ '" onclick="calculate_single_entry_sum(' +total_number+ ')" size="2" value="1" class="form-control col-lg-2" onkeyup="calculate_single_entry_sum(' +total_number+ ')"></div></div></td> <td><input type="text" name="unit_price[]"  required onkeyup="calculate_single_entry_sum(' +total_number+ ')"  id="unit_price_' +total_number+ '" size="6" value=""></td> <td><input type="text" name="estimated_amount[]" required  readonly="readonly" id="single_entry_total_' +total_number+ '" size="6" value=""></td><td><input type="text" name="insurer_amount[]" required onkeyup="calculate_customer_entry_sum(' +total_number+ ')" id="insurer_single_total_' +total_number+ '" size="6" value=""></td><td><input type="text" name="customer_amount[]" required  readonly="readonly" id="customer_single_total_' +total_number+ '" size="6" value=""></td><td><i style="cursor: pointer;" id="delete_button_' +total_number+ '" onclick="delete_row(' +total_number+ ')" class="fa fa-trash"></i></td></tr>';
			
			$('#purchase_entry_holder').append(output);
			calculate_grand_total_for_purchase();
			
		}else{ 
        $.ajax({
            url: '<?=base_url();?>index.php/claims/get_data_for_claimsinvoice/',
            type: 'POST',
            data: {'id': product_id, 'total': total_number, 'csrf_test_name': csrf_test_name},
            dataType: 'html',
            success: function (response) {

                $('#purchase_entry_holder').append(response);
                $("#bar_code").val('');
                $("#bar_code").focus();
                calculate_grand_total_for_purchase();


            }
        });
	}
		 
		}
    }


    function calculate_single_entry_sum(entry_number) {

        var quantity = $("#quantity_" + entry_number).val();
        var purchase_price = $("#unit_price_" + entry_number).val();
        var single_entry_total = quantity * purchase_price;
        $("#single_entry_total_" + entry_number).val(single_entry_total);
		$("#insurer_single_total_" + entry_number).val(single_entry_total);
		calculate_grand_total_for_purchase();

    }
	
	
	function calculate_customer_entry_sum(entry_number) {

        var single_entry_totalfield = $("#single_entry_total_" + entry_number).val();
        var single_entry_insurefield = $("#insurer_single_total_" + entry_number).val();
		var single_customer_total = single_entry_totalfield-single_entry_insurefield;
		
		$("#customer_single_total_" + entry_number).val(single_customer_total);
		
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

            $("#delete_button_" + (i + 1)).attr("id", "delete_button_" + i);
            $("#delete_button_" + (i)).attr("onclick", "delete_row(" + i + ")");

            $("#entry_row_" + (i + 1)).attr("id", "entry_row_" + i);
        }

        total_number--;
        calculate_grand_total_for_purchase();
    }


    function calculate_grand_total_for_purchase() {

        grand_total = 0;
		insurer_grand_total = 0;
		customer_grand_total = 0;
        for (var i = 1; i <= total_number; i++) {
            grand_total += Number($("#single_entry_total_" + i).val());
			insurer_grand_total += Number($("#insurer_single_total_" + i).val());
			customer_grand_total += Number($("#customer_single_total_" + i).val());
			
        }
        $("#grand_totalnew").html(grand_total);
        $("#hidden_total").val(grand_total);
        $("#sub_total").val(grand_total);
        $("#net_payment").val(grand_total);
		$("#insurer_net_payment").val(insurer_grand_total);
		$("#customer_net_payment").val(customer_grand_total);
        $("#items").html(total_number);

    }
	function calculate_grand_total_for_purchaseonload(total_number_onload) {

        grand_total = 0;
		insurer_grand_total = 0;
		customer_grand_total = 0;
        for (var i = 1; i <= total_number_onload; i++) {
            grand_total += Number($("#single_entry_total_" + i).val());
			insurer_grand_total += Number($("#insurer_single_total_" + i).val());
			customer_grand_total += Number($("#customer_single_total_" + i).val());
        }
        $("#grand_totalnew").html(grand_total);
        $("#hidden_total").val(grand_total);
        $("#sub_total").val(grand_total);
        $("#net_payment").val(grand_total);
        $("#insurer_net_payment").val(insurer_grand_total);
		$("#customer_net_payment").val(customer_grand_total);
		
		$("#items").html(total_number_onload);

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
</script>