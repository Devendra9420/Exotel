

<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-body">
                <div class="invoice">
                    <div class="row invoice-logo">
                        <div class="col-xs-6 invoice-logo-space">
                            <img src="<?= base_url(); ?>logo.png" class="img-responsive"
                                 alt=""/></div>
                        
                    </div>
                    <hr/>
                    <div class="row">
                         
                        <div class="col-xs-6">
						 <h3>Estimate Details:</h3>
							 <ul class="list-unstyled">
								 
								 
								<li>Estimate No: <?= $estimateDetail['estimate_no']; ?>  </li>
								  
								  
								 <li>Make / Model: <?php 
						$where = array('make_id' => $estimateDetail['make']);
						$getvalue =$this->Main_model->single_row('vehicle_make', $where, 's');
						echo $getvalue['make_name']; ?> / <?php 
						$where = array('model_id' => $estimateDetail['model']);
						$getvalue =$this->Main_model->single_row('vehicle_model', $where, 's');
						echo $getvalue['model_name']; ?>  </li> 
							</ul>
						</div>
                        <div class="col-xs-4 invoice-payment">
                            
                             <ul class="list-unstyled">
								
								 
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
                                    <strong><?=$this->session->userdata('franchise_name');?></strong>
                                    <br/> <?=$company->address;?>
                                    <br/>
                                    <abbr title="Phone">P:</abbr> <?=$company->contact;?>
                                </address>
                                <address>
                                    <strong><?=$company->name;?></strong>
                                    <br/>
                                    <span> <?=$company->email;?> </span>
                                </address>
                            </div>
                        </div>
                        <div class="col-xs-8 invoice-block">
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




