<div class="row">
	<div class="col-lg-12">
		<div class="tabs-container" id="estates_page">
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#tab-1"><i class="fa fa-user"></i> Details</a></li>
				<li><a data-toggle="tab" href="#tab-2" ><i class="fa fa-home"></i> Apartments/Houses</a></li>
				<li><a data-toggle="tab" href="#tab-3"><i class="fa fa-credit-card"></i> Payments</a></li>
			</ul>
			<div class="tab-content">
				<!-- Tenant Details -->
				<div id="tab-1" class="tab-pane active">
					<div class="col-lg-6">
						<div class="box box-solid">
						<div class="box-header with-border">
							<h3 class="box-title"><i class="fa fa-user"></i> <?php echo $sub_title; ?></h3>
							<?php if(empty($houses)):?>
							<div class="pull-right">
								<a href="<?php echo site_url("tenant/del_tenant/".$tenant['tenant_id']); ?>" class="btn btn-danger" title="Delete <?php echo $tenant['names']; ?>'s details" onclick="return confirm_delete('<?php echo "the details of tenant: ".$tenant['names']; ?>');"><i class="fa fa-trash"></i>Delete</a>
							</div>
							<?php endif; ?>
							<div class="pull-right">
								<a class="btn btn-default" href="<?php echo site_url("tenant/update/".$tenant['tenant_id']); ?>" title="Edit <?php echo $tenant['names']; ?>'s details">
									<i class="fa fa-edit"></i> Edit
								</a>
							</div>
						</div>
						
						<table class="table table-condensed table-hover">
								<tr><th>ID</th><td><?php echo $tenant['tenant_id']; ?></td></tr>
								<tr><th>Names</th><td><?php echo $tenant['names']; ?></td></tr>
								<tr><th>Phone1</th><td><?php echo $tenant['phone1']; ?></td></tr>
								<?php if($tenant['phone2'] != FALSE ):?>
								<tr><th>Phone2</th><td><?php echo $tenant['phone2']; ?></td></tr>
								<?php endif; ?>
								<tr><th>Date added</th><td><?php echo mdate('%d, %M %Y', $tenant['date_created']); ?></td></tr>
								<tr><th>Home address</th><td><?php echo $tenant['home_address']; ?></td></tr>
								<tr><th>District</th><td><?php echo $tenant['district']; ?></td></tr>
						</table>
							  </div><!-- /.box -->
					</div><!-- /.col-lg-6 -->

				</div> <!-- tab-1 end Details pane -->
				<!-- Tenant Details -->
				<!-- Apartments/Houses -->
				<div id="tab-2" class="tab-pane">
					<div class="col-lg-8">
						<div class="box box-solid">
							<div class="box-header with-border">
								<h3 class="box-title"><i class="fa fa-home"></i> Houses Occupied</h3>
								<div class="pull-right">
									<a class="btn btn-default" href="<?php echo site_url("tenancy/create/".$tenant['tenant_id']); ?>" title="Assign <?php echo $tenant['names']; ?> a house">
										<i class="fa fa-plus-square"></i> Add
									</a>
								</div>
							</div>
							<?php if(!empty($houses)): //we should view payments section only if this tenant had a house ?>
							<table class="table table-condensed table-hover">
								<tr>
									<th>Estate</th>
									<th>House/Room No</th>
									<th>Start Date</th>
									<th>Rate</th>
									<!-- If the estates owner/admin is logged in -->
									<th colspan="<?php if($_SESSION['role']==4||$_SESSION['role']==3){?>3<?php }?>">Action</th>
								</tr>
								<?php foreach($houses as $house):?>
								<tr>
									<td><a href="<?php echo site_url("estate/view/".$house['estate_id']); ?>" title="View estate details"><?php echo $house['estate_name']; ?></a></td>
									<td><a href="<?php echo site_url("house/view/".$house['house_id']); ?>" title="View house details"><?php echo $house['house_no']; ?></a></td>
									<td><?php echo mdate('%d, %M %Y', $house['start_date']); ?></td>
									<td><?php echo number_format($house['rent_rate']); ?></td>
									<td>
									<a href="<?php echo site_url("payment/create/".$house['tenancy_id']); ?>" title="Enter payment for room <?php echo $house['house_no'] . " (" . $house['estate_name']; ?>)"> <span class="fa fa-money"></span></a>
									</td>
									<!-- If the estates owner/admin is logged in -->
									<?php if($_SESSION['role']==4||$_SESSION['role']==3){?>
									<td>
									<a href="<?php echo site_url("tenancy/update/{$house['tenancy_id']}"); ?>" title="Make changes to this tenancy arrangement" ><span class="fa fa-edit"></span></a>
									</td>
									<td>
									<a href="<?php echo site_url("tenancy/del_tenancy/{$house['tenancy_id']}"); ?>" onclick="return confirm_delete('<?php echo "the house for  ".$tenant['names'] ; ?>');" title="Delete"><span class="fa fa-trash text-danger"></span></a>
									</td>
									<?php } ?>
								</tr>
								<?php endforeach;?>
							</table>
						</div><!-- /.box -->
					</div><!-- /.col-lg-8 -->

				</div> <!-- tab-2 end Details pane -->
				<!-- Apartments/Houses -->
				<!-- Payments -->
				<div id="tab-3" class="tab-pane">
					<div class="col-lg-12">
						<div class="box box-solid">
						<div class="box-header with-border">
							<h3 class="box-title"><i class="fa fa-credit-card"></i> Payments</h3>
							<!--div class="pull-right">
								<a class="btn btn-default" href="<?php echo site_url("payment/create/".$tenant['tenant_id']); ?>" title="Enter payment for <?php echo $tenant['names']; ?>">
									<i class="fa fa-plus-square"></i> Add
								</a>
							</div-->
						</div>
						<?php if(!empty($payments)):?>
							<table class="table table-condensed table-hover dynamicTables">
								<thead>
									<tr>
										<th>Receipt No</th>
										<th>House No</th>
										<th>Payment date</th>
										<th>Amount paid</th>
										<th>Start date</th>
										<th>End date</th>
										<!--th>Details</th-->
										<!-- If the estates owner/admin is logged in -->
										<?php if($_SESSION['role']==4||$_SESSION['role']==3):?>
										<th>&nbsp;</th>
										<th>&nbsp;</th>
										<?php endif;?>
									</tr>
								</thead>
								<tbody>
									<?php foreach($payments as $payment):?>
									<tr>
										<td><a href="<?php echo site_url("payment/view/".$payment['payment_id']); ?>" title="View receipt"><?php echo $payment['payment_id']; ?></a></td>
										<td><a href="<?php echo site_url("house/view/".$payment['house_id']); ?>" title="View house details"><?php echo $payment['house_no']; ?></a></td>
										<td><?php echo mdate('%d, %M %Y', $payment['payment_date']); ?></td>
										<td><?php echo number_format($payment['amount']); ?></td>
										<td><?php echo mdate('%d, %M %Y', strtotime($payment['start_date'])); ?></td>
										<td><?php echo mdate('%d, %M %Y', strtotime($payment['end_date'])); ?></td>
										<!--td><?php echo $payment['particulars']; ?></td-->
										<!-- If the estates owner/admin is logged in -->
										<?php if($_SESSION['role']==4||$_SESSION['role']==3){?>
										<td>
										<a href="<?php echo site_url("payment/update/{$payment['payment_id']}"); ?>" title="Make changes to this payment" ><span class="fa fa-edit"></span></a>
										</td>
										<td>
										<a href="<?php echo site_url("payment/del_payment/{$payment['payment_id']}"); ?>" onclick="return confirm_delete('<?php echo "the payment for  ".$tenant['names'] ; ?>');" title="Delete"><span class="fa fa-trash text-danger"></span></a>
										</td>
										<?php } ?>
									</tr>
									<?php endforeach;?>
								</tbody>
								<tfoot>
									<tr>
										<th>Total</th>
										<th colspan="2">&nbsp;</th>
										<th><u><?php echo number_format($total_payments['amt_paid']); ?></u></th>
										<th colspan="2">&nbsp;</th>
										<!--th>&nbsp;</th-->
										<!-- If the estates owner/admin is logged in -->
										<?php if($_SESSION['role']==4||$_SESSION['role']==3){?>
										<th colspan="2"></th>
										<?php } ?>
									</tr>
								</tfoot>
							</table>
						<?php endif;?>
						<?php endif; //we should view payments section only if this tenant had a house ?>
						</div><!-- /.box -->
					</div><!-- /.col-lg-6 -->

				</div> <!-- tab-3 end Details pane -->
				<!-- Payments -->
			</div><!-- tab-content -->
		</div><!-- tabs-container -->
	</div><!-- col-lg-12 -->
</div><!-- /.row -->