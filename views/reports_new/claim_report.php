<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM box-->
        <div class="box">
            <div class="box-title">
                <h4><i class="icon-reorder"></i> Insurance Claim Report </h4>
						<span class="tools">
							<a href="javascript:;" class="icon-chevron-down"></a>
						</span>
            </div>
            <div class="box-body">
                <!-- BEGIN FORM-->

                    <?php echo form_open('reports/claim_report_download',array('class'=>"form-horizontal form-bordered form-validate",'method'=>'post'))?>
                    <div class="row">
                        <div class="col-lg-6">
                            <label class="control-label">START DATE</label>
                            <input type="text" data-ad-format="" class="form-control datepicker"  value="" name="start_date">
                        </div>
                        <div class="col-lg-6">
                            <label class="control-label">END DATE</label>
                            <input type="text" class="form-control datepicker" value="" name="end_date">
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

                   
                    <br>
                    <br>
                <div id="printableArea">
                    <link href="<?= base_url(); ?>assets/sales_report.css" rel="stylesheet" type="text/css">


                    <div class="row ">
                        <div class="col-md-12">

                           

                          
							
							
							
							
							
							
							
							
							
							
							


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