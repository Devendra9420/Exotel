

<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-body">
                <div class="invoice">
                    <div class="row invoice-logo">
                        <div class="col-xs-6 invoice-logo-space">
                            <img src="<?= base_url(); ?>assets/logo.png" class="img-responsive"
                                 alt=""/></div>
                        
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-xs-4">
                            <h3>To:</h3>
                            <ul class="list-unstyled">
								<?php
	
								
        $sql = $this->db->query("select * from gic where GIC_ID=".$surveyDetail['gic']);
        $gics = $sql->row();
                                 
									
									?>
                                <li> <?= $gics->GIC_NAME ?> </li>
                                <li> <?= $gics->GIC_CONTACT ?> </li>
                                <li> <?= $gics->GIC_PHONE ?> </li>
                                <li> <?= $gics->GIC_ADDRESS ?> </li>
                                <!--<li> Madrid </li>
                                <li> Spain </li>
                                <li> 1982 OOP </li>-->
                            </ul>
                        </div>
                        <div class="col-xs-4">
						 <h3>Customer Details:</h3>
							 <ul class="list-unstyled">
								<li>Client Name:  <?= $surveyDetail['name']; ?></li>
								<li>Vehicle Reg No:  <?= $surveryDet['regno']; ?> </li>
								<li>Claim No: <?= $surveyDetail['claim_no']; ?>  </li>
								  
								  
								 <li>Make / Model: <?php 
						$where = array('make_id' => $surveyDetail['make']);
						$getvalue =$this->Main_model->single_row('vehicle_make', $where, 's');
						echo $getvalue['make_name']; ?> / <?php 
						$where = array('model_id' => $surveyDetail['model']);
						$getvalue =$this->Main_model->single_row('vehicle_model', $where, 's');
						echo $getvalue['model_name']; ?>  </li> 
							</ul>
						</div>
                        <div class="col-xs-4 invoice-payment">
                            <h3>Estimate Details:</h3>
                             <ul class="list-unstyled">
								
								<li>Estimate No: <?php echo $estimateDet['estimate_no']; ?></li>
                                <li>Estimate Date: <?php echo date('M d,Y',strtotime($estimateDet['estimate_date'])); ?></li>
                                 
                            </ul>
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
                                    <th > Spares Cost</th>
									<th > Labour Cost</th>
                                    <th> Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $n = 1;
								
									
                                foreach ($estimate as $rows) {
                                    ?>
                                    <tr>
                                        <td><?php echo $n; ?></td> 
                                        <td><?php echo $rows->item; ?></td> 
                                        <td ><?php echo $rows->qty; ?></td>
                                        <td > <?php echo $rows->rate; ?></td>
                                        <td > <?php echo $rows->labour_rate; ?></td>
                                        <td > <?php echo $rows->amount; ?></td>
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
						
						<div class="col-xs-4">
						<div class="form-group" id="remark">
                              <label class="control-label">Comments </label> 
							    <textarea class="form-control" name="remark" id="remark"><?php echo $estimate['remark']; ?></textarea>
                           </div>
						</div>
					</div>
					
                        <div class="col-xs-4 invoice-block">
                            <ul class="list-unstyled amounts">
                                <li>
                                    <strong>Total:</strong>  <?= $estimateDet['estimate_total'] ?> </li>
                                 
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




