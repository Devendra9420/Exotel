

<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-body">
                <div class="invoice">
                    <div class="row invoice-logo">
                        <div class="col-xs-6 invoice-logo-space">
                            <img src="<?= base_url(); ?>assets/logo.png" class="img-responsive"
                                 alt=""/></div>
                        <div class="col-xs-6">
                            <p> #<?php echo $surveyDetail['invoice_no'] ?> 
                            </p>

                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-xs-4">
                            <h3>To:</h3>
                            <ul class="list-unstyled">
								 
                                <li> <?= $surveyDetail['name'] ?> </li>
                                <li> <?= $surveyDetail['mobile'] ?> </li>
                                <li> <?= $surveyDetail['v_address']; ?> </li> 
                                <!--<li> Madrid </li>
                                <li> Spain </li>
                                <li> 1982 OOP </li>-->
                            </ul>
                        </div>
                        <div class="col-xs-4">

                        </div>
                        <div class="col-xs-4 invoice-payment">
                            <h3>Invoice Details:</h3>
                            <div id="invoice">
                                <div class="date">Date of  Invoice: <?php echo date('M d,Y',strtotime($surveyDetail['invoice_date'])); ?></div>
                                 
								<?php
	
								
        $sql = $this->db->query("select * from gic where GIC_ID=".$surveyDetail['gic']);
        $gics = $sql->row();
                                 
									
									?>
								 <div class="date"><span class="badge bg-important"> GIC:  <?= $gics->GIC_NAME; ?></span>   
                                        </div>
								
								<div class="date"> <span class="badge bg-important"> Claim No: <?= $surveyDetail['claim_no']; ?></span>   
                                        </div>
								
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th> #</th> 
                                    <th> Product</th> 
                                    <th > Quantity</th>
                                    <th > MRP</th>
                                    <th> Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $n = 1;
                                foreach ($invoice as $rows) {
                                    ?>
                                    <tr>
                                        <td><?php echo $n; ?></td> 
                                        <td><?php echo $rows->item; ?></td> 
                                        <td ><?php echo $rows->qty; ?></td>
                                        <td > <?php echo $rows->rate; ?></td>
                                        <td > <?php echo $rows->insurer_amount; ?></td>
                                    </tr>
                                    <?php $n++;
                                } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="well">
                                <address>
                                    <strong><?=$company->name;?></strong>
                                    <br/> <?=$company->address;?>
                                    <br/>
                                    <abbr title="Phone">P:</abbr> <?=$company->contact;?>
                                </address>
                                <address>
                                    <strong><?=$company->name;?></strong>
                                    <br/>
                                    <a href="mailto:#"> <?=$company->email;?> </a>
                                </address>
                            </div>
                        </div>
                        <div class="col-xs-8 invoice-block">
                            <ul class="list-unstyled amounts">
                                <li>
                                    <strong>Sub - Total:</strong>  <?= $surveyDetail['insurer_amount'] ?> </li>
                                <li>
                                    <strong>Discount:</strong> NA
                                </li>
                                 
                                <li>
                                    <strong>Grand Total:</strong>   <?= $surveyDetail['insurer_amount'] ?> </li>
                            </ul>
                            <br/>
                            <a class="btn btn-lg btn-primary hidden-print margin-bottom-5"
                               onclick="javascript:window.print();"> Print
                                <i class="fa fa-print"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>




