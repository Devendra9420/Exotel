<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM box-->
        <div class="box">
            <div class="box-title">
                <h4><i class="icon-reorder"></i> Voucher Report </h4>
						<span class="tools">
							<a href="javascript:;" class="icon-chevron-down"></a>
						</span>
            </div>
            <div class="box-body">
                <!-- BEGIN FORM-->

                    <?php echo form_open('reports/export_voucherlog',array('class'=>"form-horizontal form-bordered form-validate",'method'=>'post'))?>
                    <div class="row">
                        <div class="col-lg-6">
                            <label class="control-label">START DATE</label>
                            <input type="text" data-ad-format="" class="form-control datepicker" name="start_date">
                        </div>
                        <div class="col-lg-6">
                            <label class="control-label">END DATE</label>
                            <input type="text" class="form-control datepicker" name="end_date">
                        </div>
						<div class="col-lg-6">
							<label class="control-label">SELECT VENDOR</label>
							<select name="vendor_id" class='form-control select2' style="width: 100%;" id='vendor_id'>
							<option value="">All</option>
							<?php foreach ($vendors as $vendor){ ?>
							<option value="<?php echo $vendor->vendor_id; ?>"><?php echo $vendor->vendor_name; ?></option>
						
							<?php } ?>
							</select>
						</div>
						<div class="col-lg-6">
							<label class="control-label">SELECT STATUS</label>
							<select name="payment_status" class='form-control select2' style="width: 100%;" id='payment_status'>
							<option value="">All</option>
							<option value="Paid">Paid</option>
							<option value="Unpaid">Unpaid</option>
						
							 
							</select>
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
                        <div class="col-md-8 col-md-offset-2">
                            <form method="post" action="#">
                                <div class="btn-group pull-right">
                                    <a onclick="print_invoice('printableArea')" class="btn btn-primary">Print</a>
                                    <input name="start_date" value="<?php echo $_REQUEST['start_date']; ?>" type="hidden">
                                    <input name="end_date" value="<?php echo $_REQUEST['end_date']; ?>" type="hidden">
									<input name="vendor_id" value="<?php echo $_REQUEST['vendor_id']; ?>" type="hidden">
									<input name="payment_mode" value="<?php echo $_REQUEST['payment_status']; ?>" type="hidden">

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
								<?php //echo $query; ?>
                                <h4>Voucher Report from: <strong><?php echo $start ?></strong> to
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
                                            <th class="no text-right">#</th>
                                            <th class="no text-right">Voucher No</th>
											<th class="desc">Vendor Name</th>
											<th class="desc">Category</th>
                                            <th class="unit text-left">Date of Invoice</th>
                                            <th class="unit text-left">Total Value</th>
                                            <th class="qty text-left">Payment Amount</th>
											<td class="desc text-left ">Payment Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
											 <?php $k = 1 ?>
											
                                <?php if (!empty($voucher_details)): 
								foreach ($voucher_details as $results) : ?>
                                    
                                     		<tr>
                                                <td class="no text-left"><?php echo $k ?></td>
												<td class="no text-left"><?php echo $results->voucher_no ?></td>
												<?php $vendor =	$this->db->query("SELECT * FROM vendor WHERE vendor_id = '".$results->vendor_id."'")->row(); ?>
												
                                                <td class="desc"><h3><?php echo $vendor->vendor_name ?></h3></td>
												<td class="desc"><?php echo $vendor->category ?></td>
                                                <td class="unit text-left"><?php echo date('d-m-Y', strtotime($results->invoice_date)) ?></td>
												<td class="unit text-left"><?php echo $results->total_value; ?></td>
                                                 
                                                <td class="qty text-left"><?php echo $results->payment_amount; ?></td>
												 
												<td class="desc text-left"><?php echo $results->payment_status; ?></td>
                                            </tr>
                                            <?php $k++ ?>
                                          


                                        
                                        
									
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