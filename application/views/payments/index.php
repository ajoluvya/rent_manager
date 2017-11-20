<div class="row">
	<div class="col-lg-12">
	<div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $sub_title; ?></h3>
        </div>
		<!-- Search form -->
		<form action="<?php echo current_url();?>" method="post">
			<div class="col-md-4"><input type="text" name="search" id="search" class="form-control" placeholder="Search by names"/></div>
			<div class="col-md-2"><input type="text" name="start" id="start" class="datepicker form-control" placeholder="Start date"/></div>
			<div class="col-md-2"><input type="text" name="end" id="end" class="datepicker form-control" placeholder="End date"/></div>
			<div class="col-md-3"><select name="period" id="period" class="form-control">
					<option>Select period</option>
					<option value="30">1 month</option>
					<option value="61">2 months</option>
					<option value="183">6 months</option>
				</select></div>
			<div class="col-md-1"><input type="submit" value="Search" class="btn"/></div>
		</form>
        <table class="table table-striped table-condensed table-hover dataTables">
            <thead>
                <tr>
                    <th>Receipt No</th>
                    <th>Date</th>
                    <th>Tenant</th>
                    <th>Particulars</th>
                    <th>Amount</th>
                    <th>Bank account</th>
					<!-- If the estates owner/admin is logged in -->
                    <th 
					<?php if($_SESSION['role']==4||$_SESSION['role']==3){ echo "colspan='3'"; } ?>>Action</th>
                </tr>
            </thead>
            <tbody>
			<?php if(empty($payments)): ?>
			<tr><td colspan="7">No recent payment data, try searching</td></tr>
			<?php else:?>
			<?php
			$total_cash = 0;
			foreach($payments as $payment): ?>
                <tr>
					<td><?php echo $payment['payment_id']; ?></td>
					<td><?php echo mdate("%d-%m-%Y", $payment['payment_date']); ?></td>
					<td><?php echo $payment['names']; ?></td>
					<td><?php echo $payment['particulars']; ?></td>
					<td><?php echo number_format($payment['amount']); $total_cash +=$payment['amount']; ?></td>
					<td><?php echo $payment['acc_no']; ?>, <?php echo $payment['bank_name']; ?></td>
					<td>
					<a href="<?php echo site_url("payment/view/{$payment['payment_id']}"); ?>" title="Details"><span class="fa fa-table"></span></a>
					</td>
					
					<!-- If the estates owner/admin is logged in -->
					<?php if($_SESSION['role']==4||$_SESSION['role']==3){?>
					<td>
					<a href="<?php echo site_url("payment/update/{$payment['payment_id']}"); ?>" title="Update payment details" ><span class="fa fa-edit"></span></a>
					</td>
					<td>
					<a href="<?php echo site_url("payment/del_payment/{$payment['payment_id']}"); ?>" onclick="return confirm_delete('<?php echo "the payment ".$payment['names'] ; ?>');" title="Delete"><span class="fa fa-trash"></span></a>
					</td>
					<?php } ?>
				</tr>
			<?php endforeach; ?>
			<tr><th colspan="4">TOTAL</th><th colspan="3">UGX <?php echo number_format($total_cash); ?></th></tr>
			<?php endif;?>
			</tbody>
		</table>
			<?php echo $pag_links; ?>
              </div><!-- /.box -->
	</div><!-- /.col-lg-12 -->
</div><!-- /.row -->