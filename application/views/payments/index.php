<div class="row">
	<div class="col-lg-12">
	<div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $sub_title; ?></h3>
        </div>
		<!-- Search form -->
		<form action="<?php echo current_url();?>" method="post">
			<div class="col-md-3">&nbsp;</div>
			<div class="col-md-2"><input type="text" name="start" id="start" class="datepicker form-control" placeholder="Start date"/></div>
			<div class="col-md-2"><input type="text" name="end" id="end" class="datepicker form-control" placeholder="End date"/></div>
			<div class="col-md-3"><select name="period" id="period" class="form-control">
					<option>Select period</option>
					<option value="30">1 month</option>
					<option value="61">2 months</option>
					<option value="183">6 months</option>
					<option value="365">12 months</option>
				</select></div>
			<div class="col-md-2"><input type="submit" value="Search" class="btn"/></div>
		</form>
        <table class="table table-striped table-condensed table-hover dynamicTables">
            <thead>
                <tr>
                    <th>Receipt No</th>
                    <th>Date</th>
                    <th>Tenant</th>
                    <th>House</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Amount</th>
                    <!--th>Bank account</th-->
					<!-- If the estates owner/admin is logged in -->
					<?php if($_SESSION['role']==4||$_SESSION['role']==3):?>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
					<?php endif;?>
                </tr>
            </thead>
            <tbody>
			<?php 
			$total_cash = 0;
			if(!empty($payments)): ?>
			<?php
			foreach($payments as $payment): ?>
                <tr>
					<td>
					<a href="<?php echo site_url("payment/view/{$payment['payment_id']}"); ?>" title="Details"><?php echo $payment['payment_id']; ?></a>
					</td>
					<td><?php echo mdate("%d, %M %Y", $payment['payment_date']); ?></td>
					<td><a href="<?php echo site_url("tenant/view/{$payment['tenant_id']}"); ?>" title="Tenant details"><?php echo $payment['names']; ?></a></td>
					<td><a href="<?php echo site_url("house/view/{$payment['house_id']}"); ?>" title="House details"><?php echo $payment['house_no']; ?></a></td>
					<td><?php echo mdate('%d, %M %Y', strtotime($payment['start_date'])); ?></td>
					<td><?php echo mdate('%d, %M %Y', strtotime($payment['end_date'])); ?></td>
					<td><?php echo number_format($payment['amount']); $total_cash +=$payment['amount']; ?></td>
					<!--td><?php if(isset($payment['acc_id'])):?><?php echo $payment['acc_no']; ?>, <?php echo $payment['bank_name']; ?><?php endif; ?></td-->
					
					<!-- If the estates owner/admin is logged in -->
					<?php if($_SESSION['role']==4||$_SESSION['role']==3){?>
					<td>
					<a href="<?php echo site_url("payment/update/{$payment['payment_id']}"); ?>" title="Update payment details" ><span class="fa fa-edit"></span></a>
					</td>
					<td>
					<a href="<?php echo site_url("payment/del_payment/{$payment['payment_id']}"); ?>" onclick="return confirm_delete('<?php echo "the payment Ref#".$payment['payment_id'] ; ?>');" title="Delete"><span class="fa fa-trash text-danger"></span></a>
					</td>
					<?php } ?>
				</tr>
			<?php endforeach; ?>
			<?php endif;?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="6">TOTAL (UGX)</th>
					<th><?php echo number_format($total_cash); ?></th>
					<!--th>&nbsp;</th-->
					<!-- If the estates owner/admin is logged in -->
					<?php if($_SESSION['role']==4||$_SESSION['role']==3){?>
					<th colspan="2"></th>
					<?php } ?>
				</tr>
			</tfoot>
		</table>
			<?php echo $pag_links; ?>
              </div><!-- /.box -->
	</div><!-- /.col-lg-12 -->
</div><!-- /.row -->