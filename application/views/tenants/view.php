<div class="row no-print">
</div><!-- /.row -->
<div class="row">
	<div class="col-lg-6">
		<div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-user"></i> <?php echo $sub_title; ?></h3>
			<div class="pull-right">
				<a href="<?php echo site_url("tenant/del_tenant/".$tenant['tenant_id']); ?>" class="btn btn-danger" title="Delete <?php echo $tenant['names']; ?>'s details" onclick="return confirm_delete('<?php echo "the details of tenant: ".$tenant['names']; ?>');"><i class="fa fa-trash"></i>Delete</a>
			</div>
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
                <tr><th>Phone2</th><td><?php echo $tenant['phone2']; ?></td></tr>
                <tr><th>Home address</th><td><?php echo $tenant['home_address']; ?></td></tr>
                <tr><th>District</th><td><?php echo $tenant['district']; ?></td></tr>
		</table>
              </div><!-- /.box -->
	</div><!-- /.col-lg-6 -->
	<div class="col-lg-6">
		<div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-home"></i> Houses Occupied</h3>
			<div class="pull-right">
				<a class="btn btn-default" href="<?php echo site_url("tenancy/create/".$tenant['tenant_id']); ?>" title="Assign <?php echo $tenant['names']; ?> a house">
					<i class="fa fa-plus-square"></i> Tenancy
				</a>
			</div>
        </div>
        	
        <table class="table table-condensed table-hover">
                <tr>
					<th>Estate</th>
					<th>House/Room No</th>
					<th>Start Date</th>
					<th>Rate</th>
					<!-- If the estates owner/admin is logged in -->
					<?php if($_SESSION['role']==4||$_SESSION['role']==3){?><th colspan="2">Action</th><?php } ?>
				</tr>
				<?php foreach($houses as $house):?>
                <tr>
					<td><?php echo $house['estate_name']; ?></td>
					<td><?php echo $house['house_no']; ?></td>
					<td><?php echo mdate('%d, %M %Y', $house['start_date']); ?></td>
					<td><?php echo number_format($house['rent_rate']); ?></td>
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
	</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
	
	<div class="col-lg-12">
		<div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-credit-card"></i> Payments</h3>
			<div class="pull-right">
				<a class="btn btn-default" href="<?php echo site_url("payment/create/".$tenant['tenant_id']); ?>" title="Enter payment for <?php echo $tenant['names']; ?>">
					<i class="fa fa-plus-square"></i> Payment
				</a>
			</div>
        </div>
        	
        <table class="table table-condensed table-hover dynamicTables">
			<thead>
                <tr>
					<th>Receipt No</th><th>Payment date</th><th>Amount paid</th><th>Details</th>
					<!-- If the estates owner/admin is logged in -->
					<?php if($_SESSION['role']==4||$_SESSION['role']==3):?>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
					<?php endif;?>
				</tr>
			</thead>
			<tbody>
				<?php foreach($payments as $payment):?>
                <tr><td><a href="<?php echo site_url("payment/view/".$payment['payment_id']); ?>" title="View receipt"><?php echo $payment['payment_id']; ?></a></td><td><?php echo mdate('%d, %M %Y', $payment['payment_date']); ?></td><td><?php echo number_format($payment['amount']); ?></td><td><?php echo $payment['particulars']; ?></td>
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
			</tbody>
			<tfoot>
				<?php endforeach;?>
				<tr><th>Total</th><th colspan="3">&nbsp;</th><th><u><?php echo number_format($total_payments['amt_paid']); ?></u></th>
				</tr>
			</tfoot>
		</table>
              </div><!-- /.box -->
	</div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
	<div class="col-lg-12">
		<!--div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-table"></i> Summary</h3>
        </div>
		
        <table class="table table-condensed table-hover">
                <tr><th>Credit</th><th>Debit</th></tr>
                <tr><td><?php echo $tenant['tenant_id']; ?></td><td><?php echo $tenant['names']; ?></td></tr>
		</table>
              </div><!-- /.box -->
	</div><!-- /.col-lg-12 -->
</div><!-- /.row -->