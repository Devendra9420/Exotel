<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM box-->
        <div class="box">
            <div class="box-title">
                <h4><i class="icon-reorder"></i> Stock Consumption Report </h4>
						<span class="tools">
							<a href="javascript:;" class="icon-chevron-down"></a>
						</span>
            </div>
            <div class="box-body">
                <!-- BEGIN FORM-->

                    <?php echo form_open('reports/stockconsumption_report',array('class'=>"form-horizontal form-bordered form-validate",'method'=>'post'))?>
                    <div class="row">
                        <div class="col-lg-6">
                            <label class="control-label">START DATE</label>
                            <input type="text" data-ad-format="" class="form-control datepicker" name="start_date">
                        </div>
                        <div class="col-lg-6">
                            <label class="control-label">END DATE</label>
                            <input type="text" class="form-control datepicker" name="end_date">
                        </div>
                    </div>
                    <br>
                    <div class="form-actions">
                        <input type="hidden" name="Action" value="Search">
                        <button type="submit" class="btn btn-success" >Show Report</button>
                        <button type="reset" class="btn">Cancel</button>
                    </div>
                </form>
                <!-- END FORM-->
                <?php if (isset($_REQUEST['Action']) == "Search"){ ?>

                    <div class="row ">
                        <div class="col-md-12">
                            <form method="post" action="#">
                                <div class="btn-group pull-right">
                                    <a onclick="print_invoice('printableArea')" class="btn btn-primary">Print</a>
                                    <input name="start_date" value="<?php echo $_REQUEST['start_date']; ?>" type="hidden">
                                    <input name="end_date" value="<?php echo $_REQUEST['end_date']; ?>" type="hidden">

                                </div>
                            </form>

                        </div>
                    </div>

                    <br>
                    <br>
                <div id="printableArea">
                    <link href="<?= base_url(); ?>assets/sales_report.css" rel="stylesheet" type="text/css">


                    <div class="row ">
                        <div class="col-md-12">

                            <header class="clearfix">
                                <div id="logo">
                                     
                                </div>
                                <div id="company">
                                    <h2 class="name"><?=$company->name;?></h2>
                                    <div><?=$company->contact;?></div>
                                    <div><?=$company->email;?></div>
                                </div>

                            </header>
                            <hr>

                            <main class="invoice_report">

                                <h4>Stock Consumption Report from: <strong><?php echo $start ?></strong> to
                                    <strong><?php echo $end ?></strong></h4>
                                <br/>
                                <br/>

                                <?php
                                $key = 0;
                                $total_cost = 0;
                                $total_sell = 0;
                                $total_profit = 0;
                                ?>
								
							<!--	<table border="0" cellspacing="0" cellpadding="0"> -->
								<table class="table table-striped table-hover table-bordered dataTable" id="example1"
                           aria-describedby="editable-sample_info">
                                        <thead>
                                        <tr style="background-color: #ECECEC">
                                            <th class="no text-left">#</th>
                                            <th class="no text-left">Transaction No</th>
                                            <th class="no text-left">Transaction Type</th>
											<th class="desc">Product</th>
                                            <th class="unit text-left">Qty</th>
                                            <th class="unit text-left">Stock On Hand</th>
                                            <th class="qty text-left">New Stock</th>
											<th class="qty text-left">Purchase Rate</th>
											<th class="qty text-left">MRP</th>
											<td class="desc text-left ">Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                <?php //if (!empty($stocktrans)): 
								//foreach ($invoice_details as $invoice_no => $order_details) : ?>
                                    <?php //$total_buying_price = 0; $sales_qty =0; ?>
                                    
                                   
                                        <?php $k = 1 ?>
                                        <?php if (!empty($stocktrans)): foreach ($stocktrans as $trans) :
												
																  if($trans->type == 'purchase'){
																	  $type = 'Inward';
																  }elseif($trans->type == 'sales'){
																	  $type = 'Assign';
																  }elseif($trans->type == 'returns'){
																	  $type = 'Returned';
																  }
											
											
											?>
                                            <tr>
                                                <td class="no text-left"><?php echo $k ?></td>
												<td class="no text-left"><?php echo $trans->transno ?></td>
                                                <td class="desc"><h3><?php echo $type ?></h3></td>
                                                <td class="unit text-left"><?php echo $trans->item_name .' | '.$trans->sub_product.' | '.$trans->brand; ?></td>
												<td class="unit text-left"><?php echo $trans->qty; ?></td>
                                                <?php
                                              // $sales_qty = $v_order->purchase_qty;
                                              // $total_buying_price += $v_order->purchase_rate;
                                              // $t = $sales_qty * $total_buying_price;
                                                ?>
                                                <td class="qty text-left"><?php echo $trans->soh ?></td>
												 <td class="qty text-left"><?php echo $trans->newstock ?></td>
												
												 <td class="qty text-left"><?php echo $trans->purchase_rate ?></td>
												
												 <td class="qty text-left"><?php echo $trans->sales_rate ?></td>
												
												<td class="desc text-left"><?php echo date('d-m-Y', strtotime($trans->date)) ?></td>
                                            </tr>
                                            <?php $k++ ?>
                                            <?php //$total_cost += $v_order->purchase_rate * $sales_qty; ?>

                                            <?php
                                       // endforeach;
                                       // endif;
                                        ?>


                                        
                                        <!-- <tfoot>

                                        <?php //if ($order[$key]->purchase_discount != 0): ?>
                                           <tr>
                                                <td colspan="3"></td>
                                                <td colspan="2">Discount Amount</td>
                                                <td><?php //echo currency(number_format($order[$key]->purchase_discount, 2)); ?></td>
                                            </tr>
                                        <?php //endif; ?>

                                        <tr>
                                            <td colspan="3"></td>
                                            <td colspan="2">Grand Total</td>
                                            <td><?php //echo  currency(number_format($order[$key]->grand_total, 2)); ?></td>
                                        </tr>
                                        
                                        </tfoot> -->
                                        <?php
                                       // $total_sell += $order[$key]->grand_total;
                                       // $total_profit += $order[$key]->grand_total - $t;
                                        ?>
									
                                    <?php $key++; ?>
                                <?php endforeach; endif; ?>

                                </tbody>
                                    </table>


                            </main>
                            <hr>
                             


                        </div>
                    </div>

                </div>
<?php }?>

            </div>
        </div>
        <!-- END SAMPLE FORM box-->
    </div>
</div>

<script type="text/javascript">
    function print_invoice(printableArea) {

        var table = $('#dataTables-example').DataTable();
        table.destroy();

        //$('#dataTables-example').attr('id','none');
        var printContents = document.getElementById(printableArea).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        //$('table').attr('id','dataTables-example');
        location.reload(document.body.innerHTML = originalContents);
        //document.body.innerHTML = originalContents;
    }
</script>