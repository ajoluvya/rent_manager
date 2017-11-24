<div class="row">
	<div class="col-lg-5">
		<div class="box box-solid">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $sub_title; ?></h3>
			</div>
			<!-- If the estates owner/admin is logged in -->
			<?php if($_SESSION['role']==4||$_SESSION['role']==3){?>
			<div class="btn-group">
				<a class="btn btn-default" href="<?php echo site_url("tenancy/update/".$tenancy['tenancy_id']); ?>" title="Edit house details">
					<i class="fa fa-edit"></i> Edit
				</a>
			</div>
			<div class="btn-group">
					<a href="<?php echo site_url("tenancy/del_tenancy/".$tenancy['tenancy_id']); ?>" class="btn btn-danger" title='Delete house details' onclick="return confirm_delete('<?php echo "this tenancy arrangement (REF#".$tenancy['tenancy_id']; ?>)');"><i class="fa fa-trash"></i> Delete</a>
			</div>
			<?php } ?>
			<div class="table-responsive">
				<table class="table table-condensed">
						<tr><th>Ref#</th><td><?php echo $tenancy['tenancy_id']; ?></td></tr>
						<tr><th>Tenant</th><td><?php echo $tenancy['names']; ?></td></tr>
						<tr><th>Phone Contacts</th><td><?php echo $tenancy['phone1']; ?><?php if(isset($tenancy['phone2'])&&!$tenancy['phone2']==""):?> , <?php echo $tenancy['phone2']; ?><?php endif; ?></td></tr>
						<tr><th>Rent rate</th><td><?php echo number_format($tenancy['rent_rate']); ?></td></tr>
						<tr><th>Start Date</th><td><?php if(isset($tenancy['start_date'])):?><?php echo mdate('%d, %M %Y', $tenancy['start_date']); ?><?php endif; ?></td></tr>
						<tr><th>End Date</th><td><?php if(isset($tenancy['end_date'])):?><?php echo mdate('%d, %M %Y', $tenancy['end_date']); ?><?php endif; ?></td></tr>
				</table>
			</div>
		  </div><!-- /.box -->
	</div><!-- /.col-lg-5 -->
	<?php $total_payments = 0; if(!empty($payments)): //display the payments to this tenancy arrangement ?>
	<div class="col-lg-7">
		<div class="box box-solid">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-home"></i> Payments</h3>
			</div>
			<table class="table table-condensed table-hover dynamicTables">
				<thead>
					<tr>
						<th>Ref No</th>
						<th title="Payment date">Date</th>
						<th>Amount</th>
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
						<td><?php echo mdate('%d, %M %Y', $payment['payment_date']); ?></td>
						<td><?php $total_payments +=$payment['amount']; echo number_format($payment['amount']); ?></td>
						<td><?php echo $payment['particulars']; ?></td>
						<!-- If the estates owner/admin is logged in -->
						<?php if($_SESSION['role']==4||$_SESSION['role']==3){?>
						<!--td>
						<a href="<?php echo site_url("payment/update/{$payment['payment_id']}"); ?>" title="Make changes to this payment" ><span class="fa fa-edit"></span></a>
						</td-->
						<td>
						<a href="<?php echo site_url("payment/del_payment/{$payment['payment_id']}"); ?>" onclick="return confirm_delete('<?php echo " payment Ref#".$payment['payment_id'] ; ?>');" title="Delete"><span class="fa fa-trash text-danger"></span></a>
						</td>
						<?php } ?>
					</tr>
					<?php endforeach;?>
				</tbody>
				<tfoot>
					<tr>
						<th>Total</th>
						<th>&nbsp;</th>
						<th><u><?php echo number_format($total_payments); ?></u></th>
						<!--th>&nbsp;</th-->
						<!-- If the estates owner/admin is logged in -->
						<?php if($_SESSION['role']==4||$_SESSION['role']==3){?>
						<th colspan="2"></th>
						<?php } ?>
					</tr>
				</tfoot>
			</table>
        </div><!-- /.box -->
	</div><!-- /.col-lg-7 -->
	<?php endif;?>
</div>