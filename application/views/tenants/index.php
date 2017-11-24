<div class="row">
	<div class="col-lg-12">
	<div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $sub_title; ?></h3>
			<div class="pull-right"><a href="<?php echo site_url("tenant/create"); ?>" class="btn btn-sm btn-primary" title="Add Tenant"><i class="fa fa-edit"></i> New</a></div>
        </div>
        <table class="table table-striped table-condensed table-hover dynamicTables">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name(s)</th>
                    <th>Phone1</th>
                    <th>Estate</th>
					<th>House No.</th>
					<th>Start Date</th>
					<th>Rate (UGX)</th>
					<th>&nbsp;</th>
					<!-- If the estates owner/admin is logged in -->
					<?php if($_SESSION['role']==4||$_SESSION['role']==3):?>
					<th>&nbsp;</th>
					<?php endif;?>
                </tr>
            </thead>
            <tbody>
			<?php if(!empty($tenants)): ?>
			<?php foreach($tenants as $tenant): ?>
                <tr>
					<td><?php echo $tenant['tenant_id']; ?></td>
					<td>
					<a href="<?php echo site_url("tenant/view/{$tenant['tenant_id']}"); ?>" title="<?php echo $tenant['names']; ?> details"><?php echo $tenant['names']; ?></a></td>
					<td><?php echo $tenant['phone1']; ?></td>
					<td><?php if(isset($tenant['estate_name'])){?><a href="<?php echo site_url("house/view/{$tenant['estate_id']}"); ?>" title="<?php echo $tenant['estate_name']; ?> details"><?php echo $tenant['estate_name'];?></a><?php } ?></td>
					<td><?php if(isset($tenant['house_no'])){?><a href="<?php echo site_url("house/view/{$tenant['house_id']}"); ?>" title="<?php echo $tenant['house_no']; ?> details"><?php echo $tenant['house_no'];?></a><?php } ?></td>
					<td><?php echo isset($tenant['start_date'])?(mdate('%d, %M %Y',$tenant['start_date'])):""; ?></td>
					<td><?php echo isset($tenant['rent_rate'])?(number_format($tenant['rent_rate'])):""; ?></td>
					<td>
					<a href="<?php echo site_url("tenancy/update/{$tenant['tenancy_id']}"); ?>" title="Update <?php echo $tenant['names']; ?>'s details" ><span class="fa fa-edit"></span></a>
					</td>
					<!-- If the estates owner/admin is logged in -->
					<?php if($_SESSION['role']==4||$_SESSION['role']==3){?>
					<td>
					<a href="<?php echo site_url("tenant/del_tenant/{$tenant['tenant_id']}"); ?>" onclick="return confirm_delete('<?php echo "the tenant ".$tenant['names'] ; ?>');" title="Delete"><span class="fa fa-trash text-danger"></span></a>
					</td>
					<?php } ?>
				</tr>
			<?php endforeach; ?>
			<?php endif;?>
			</tbody>
		</table>
			<?php echo $pag_links; ?>
            </div><!-- /.box -->
	</div><!-- /.col-lg-12 -->
</div>