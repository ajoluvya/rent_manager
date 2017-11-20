<div class="row">
	<div class="col-lg-12">
	<div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $sub_title; ?></h3>
        </div>
		<!-- Search form -->
		<form action="<?php echo current_url();?>" method="post">
			<div class="col-md-3"><input type="text" name="search" id="search" title="Search by the tenant names or house no" class="form-control" placeholder="Search by names or house no"/></div>
			<div class="col-md-2"><input type="text" name="start" id="start" class="datepicker form-control" placeholder="Start date"/></div>
			<div class="col-md-2"><input type="text" name="end" id="end" class="datepicker form-control" placeholder="End date"/></div>
			<div class="col-md-2">
				<select name="period" id="period" class="form-control">
					<option>Select period</option>
					<option value="30">1 month</option>
					<option value="61">2 months</option>
					<option value="183">6 months</option>
				</select></div>
			<div class="col-md-2">
				<select name="status" id="status" class="form-control">
					<option value="1">Current tenants</option>
					<option value="2">Previous tenants</option>
					<option value="3">All tenants</option>
				</select></div>
			<div class="col-md-1"><input type="submit" value="Search" class="btn"/></div>
		</form>
        <table class="table table-striped table-condensed table-hover dataTables">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name(s)</th>
                    <th>Phone1</th>
                    <th>House No.</th>
                    <th>Reg. Date</th>
                    <th>Amount (UGX)</th>
					<!-- If the estates owner/admin is logged in -->
					
                    <th colspan="<?php if($_SESSION['role']==4||$_SESSION['role']==3){ echo 5;} else echo 2; ?>">Action</th>
                </tr>
            </thead>
            <tbody>
			<?php if(empty($tenancies)): ?>
			<tr><td colspan="7">No tenancy data in database</td></tr>
			<?php else:?>
			<?php foreach($tenancies as $tenancy): ?>
                <tr>
					<td><?php echo $tenancy['tenancy_id']; ?></td>
					<td><?php echo $tenancy['names']; ?></td>
					<td><?php echo $tenancy['phone1']; ?></td>
					<td><?php echo $tenancy['house_no']; ?></td>
					<td><?php echo mdate('%d-%m-%Y', $tenancy['start_date']); ?></td>
					<td><?php echo number_format($tenancy['rent_rate']); ?></td>
					<td>
					<a href="<?php echo site_url("tenant/view/{$tenancy['tenant_id']}"); ?>" title="<?php echo $tenancy['names']; ?> details"><span class="fa fa-table"></span></a>
					</td>
					<td>
					<a href="<?php echo site_url("payment/create/".$tenancy['tenant_id']); ?>" title="Process payment for <?php echo $tenancy['names']; ?>"><span class="fa fa-credit-card"></span></a>
					</td>
					<!-- If the estates owner/admin is logged in -->
					<?php if($_SESSION['role']==4||$_SESSION['role']==3){?>
					<td>
					<a href="<?php echo site_url("tenancy/update/{$tenancy['tenancy_id']}"); ?>" title="Update <?php echo $tenancy['names']; ?>'s house details" ><span class="fa fa-hotel"></span></a>
					</td>
					<td>
					<a href="<?php echo site_url("tenant/update/{$tenancy['tenant_id']}"); ?>" title="Update <?php echo $tenancy['names']; ?>'s details" ><span class="fa fa-edit"></span></a>
					</td>
					<td>
					<a href="<?php echo site_url("tenancy/del_tenancy/{$tenancy['tenancy_id']}"); ?>" onclick="return confirm_delete('<?php echo "the tenancy record for ".$tenancy['names'] ; ?>');" title="Delete"><span class="fa fa-trash"></span></a>
					</td>
					<?php } ?>
				</tr>
			<?php endforeach; ?>
			<?php endif;?>
			</tbody>
		</table>
			<?php echo $pag_links; ?>
              </div><!-- /.box -->
	</div>
</div>