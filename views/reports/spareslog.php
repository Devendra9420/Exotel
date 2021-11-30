<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM box-->
        <div class="box">
            <div class="box-title">
                <h4><i class="icon-reorder"></i> Spares Log </h4>
						<span class="tools">
							<a href="javascript:;" class="icon-chevron-down"></a>
						</span>
            </div>
            <div class="box-body">
                <!-- BEGIN FORM-->

                    <?php echo form_open('reports/export_spareslog',array('class'=>"form-horizontal form-bordered form-validate",'method'=>'post'))?>
                    <div class="row">
                        <div class="col-lg-6">
                            <label class="control-label">Start Date</label>
                            <input type="text" data-ad-format="" autocomplete="off" class="form-control datepicker" name="start_date">
                        </div>
                        <div class="col-lg-6">
                            <label class="control-label">End Date</label>
                            <input type="text" class="form-control datepicker" autocomplete="off" name="end_date">
                        </div>
                    </div>
                    <br>
                    <div class="form-actions">
                        <input type="hidden" name="Action" value="Search">
                        <button type="submit" class="btn btn-success" >Download Report</button>
                        <button type="reset" class="btn">Cancel</button>
                    </div>
                </form>
                <!-- END FORM-->
                <?php if (isset($_REQUEST['Action']) == "Search"){ ?>

                    <div class="row ">
                        <div class="col-md-8 col-md-offset-2">
                            <form method="post" action="#">
                                <div class="btn-group pull-right">
									<?= form_open_multipart(base_url() . 'index.php/reports/export_spareslog', array('method' => 'POST', 'class' => 'form-horizontal')) ?>
                                    <a onclick="print_invoice('printableArea')" class="btn btn-primary">Print</a>
                                    <input name="start_date" value="<?php echo $_REQUEST['start_date']; ?>" type="hidden">
                                    <input name="end_date" value="<?php echo $_REQUEST['end_date']; ?>" type="hidden"> 
									  <input type="submit" name="export" id="export" class="btn btn-success" value="Download log" />  
             
           							 <?php echo form_close();?>
                                </div>
                            </form>

                        </div>
                    </div>

                    <br>
                    <br>
                <div id="printableArea">
                    


                    <div class="row ">
                        <div class="col-md-8 col-md-offset-2">

                           

                            <main class="invoice_report">

                                <h4>Booking Log from: <strong><?php echo $start ?></strong> to
                                    <strong><?php echo $end ?></strong></h4>
                               <p>Please click on the download button to export the report.</p>
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
 <script> $(function(){ $('.pageloader').remove(); });</script> 
 
 