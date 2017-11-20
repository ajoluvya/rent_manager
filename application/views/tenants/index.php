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
                    <th>Phone2</th>
					<th>&nbsp;</th>
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
					<td><?php echo isset($tenant['phone2'])?$tenant['phone2']:""; ?></td>
					<td>
					<a href="<?php echo site_url("payment/view/".$tenant['tenant_id']); ?>" title="<?php echo $tenant['names']; ?>'s payments"><span class="fa fa-credit-card"></span></a>
					</td>
					<td>
					<a href="<?php echo site_url("tenant/update/{$tenant['tenant_id']}"); ?>" title="Update <?php echo $tenant['names']; ?>'s details" ><span class="fa fa-edit"></span></a>
					</td>
					<!-- If the estates owner/admin is logged in -->
					<?php if($_SESSION['role']==4||$_SESSION['role']==3){?>
					<td>
					<a href="<?php echo site_url("tenant/del_tenant/{$tenant['tenant_id']}"); ?>" onclick="return confirm_delete('<?php echo "the tenant ".$tenant['names'] ; ?>');" title="Delete"><span class="fa fa-trash"></span></a>
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