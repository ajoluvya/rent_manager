<div class="row no-print">
	<div class="col-lg-6">
        <div class="btn-group">
				<a href="<?php echo site_url("tenant/create"); ?>" class="btn btn-app" title="Create new tenant"><i class="fa fa-plus-square"></i> New</a>
		</div>
		<div class="btn-group">
			<a class="btn btn-app" href="<?php echo site_url("tenancy/create/".$tenant['tenant_id']); ?>" title="Assign a house to <?php echo $tenant['names']; ?>">
				<i class="fa fa-home"></i> Tenancy
			</a>
		</div>
		<div class="btn-group">
			<a class="btn btn-app" href="<?php echo site_url("payment/create/".$tenant['tenant_id']); ?>" title="Enter payment for <?php echo $tenant['names']; ?>">
				<i class="fa fa-credit-card"></i> Payment
			</a>
		</div>
		<!-- If the estates owner/admin is logged in -->
		<?php if($_SESSION['role']==4||$_SESSION['role']==3){?>
		<div class="btn-group">
			<a class="btn btn-app" href="<?php echo site_url("tenant/update/".$tenant['tenant_id']); ?>" title="Edit <?php echo $tenant['names']; ?>'s details">
				<i class="fa fa-edit"></i> Edit
			</a>
		</div>
		<div class="btn-group">
				<a href="<?php echo site_url("tenant/del_tenant/".$tenant['tenant_id']); ?>" class="btn btn-app" title="Delete <?php echo $tenant['names']; ?>'s details" onclick="return confirm_delete('<?php echo "the details of tenant: ".$tenant['names']; ?>');"><i class="fa fa-trash"></i>Delete</a>
		</div>
		<?php } ?>
	</div><!-- /.col-lg-6 -->
</div><!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-user"></i> <?php echo $sub_title; ?></h3>
        </div>
		
        <table class="table table-condensed table-hover">
                <tr><th>ID</th><th>Names</th><th>Phone1</th><th>Phone2</th><th>Home address</th><th>District</th></tr>
                <tr><td><?php echo $tenant['tenant_id']; ?></td><td><?php echo $tenant['names']; ?></td><td><?php echo $tenant['phone1']; ?></td><td><?php echo $tenant['phone2']; ?></td><td><?php echo $tenant['home_address']; ?></td><td><?php echo $tenant['district']; ?></td></tr>
		</table>
              </div><!-- /.box -->
	</div><!-- /.col-lg-12 -->
</div><!-- /.row -->

<div class="row">
	<div class="col-lg-5">
		<div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-dollar"></i> Bills</h3>
        </div>
        	
        <table class="table table-condensed table-hover">
                <tr><th>Bill No</th><th>Month-Year</th><th>Room</th><th>Amount</th><!-- If the estates owner/admin is logged in -->
					<?php if($_SESSION['role']==4||$_SESSION['role']==3){?><th colspan="2">Action</th><?php } ?></tr>
				<?php foreach($bills as $bill):?>
                <tr><td><?php echo $bill['bill_id']; ?></td><td><?php echo mdate('',$bill['bill_date']); ?></td><td><?php echo $bill['house_no']; ?></td><td><?php echo $bill['amount']; ?></td>
					<!-- If the estates owner/admin is logged in -->
					<?php if($_SESSION['role']==4||$_SESSION['role']==3){?>
					<td>
					<a href="<?php echo site_url("bill/update/{$bill['bill_id']}"); ?>" title="Make changes to this bills" ><span class="fa fa-edit"></span></a>
					</td>
					<td>
					<a href="<?php echo site_url("bill/del_bill/{$bill['bill_id']}"); ?>" onclick="return confirm_delete('<?php echo "the bill for  ".$tenant['names'] ; ?>');" title="Delete"><span class="fa fa-trash"></span></a>
					</td>
					<?php } ?></tr>
				<?php endforeach;?>
				<tr><th>Sum</th><th colspan="2">&nbsp;</th><th><u><?php echo $total_bills['amount']; ?></u></th></tr>
		</table>
              </div><!-- /.box -->
	</div><!-- /.col-lg-6 -->
	
	<div class="col-lg-7">
		<div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-credit-card"></i> Payments</h3>
        </div>
        	
        <table class="table table-condensed table-hover">
                <tr><th>Receipt No</th><th>Payment date</th><th>Amount paid</th><th>Details</th><th>Receipt</th><!-- If the estates owner/admin is logged in -->
					<?php if($_SESSION['role']==4||$_SESSION['role']==3){?><th colspan="2">Action</th><?php } ?></tr>
				<?php foreach($payments as $payment):?>
                <tr><td><?php echo $payment['payment_id']; ?></td><td><?php echo mdate('%d-%m-%Y', $payment['payment_date']); ?></td><td><?php echo $payment['amount']; ?></td><td><?php echo $payment['particulars']; ?></td><td><a href="<?php echo site_url("payment/view/".$payment['payment_id']); ?>" title="View receipt">Rcpt</a></td>
					<!-- If the estates owner/admin is logged in -->
					<?php if($_SESSION['role']==4||$_SESSION['role']==3){?>
					<td>
					<a href="<?php echo site_url("payment/update/{$payment['payment_id']}"); ?>" title="Make changes to this payment" ><span class="fa fa-edit"></span></a>
					</td>
					<td>
					<a href="<?php echo site_url("payment/del_payment/{$payment['payment_id']}"); ?>" onclick="return confirm_delete('<?php echo "the payment for  ".$tenant['names'] ; ?>');" title="Delete"><span class="fa fa-trash"></span></a>
					</td>
					<?php } ?>
				</tr>
				<?php endforeach;?>
				<tr><th>Total payment</th><th colspan="3">&nbsp;</th><th><u><?php echo $total_payments['amt_paid']; ?></u></th></tr>
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