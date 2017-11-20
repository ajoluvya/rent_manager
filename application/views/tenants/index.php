<div class="row">
	<div class="col-lg-12">
	<div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $sub_title; ?></h3>
        </div>
			<!-- Search form -->
			<form action="<?php echo current_url();?>" method="post">
				<div class="col-md-4"><input type="text" name="search" id="search" class="form-control" title="Search by house or estate" placeholder="Search by house or estate"/></div>
				<div class="col-md-1"><input type="submit" value="Search" class="btn"/></div>
			</form>
        <table class="table table-striped table-condensed table-hover dataTables">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name(s)</th>
                    <th>Phone1</th>
                    <th>Phone2</th>
					<!-- If the estates owner/admin is logged in -->
					
                    <th colspan="<?php if($_SESSION['role']==4||$_SESSION['role']==3){ echo 4; } else echo 2; ?>">Action</th>
                </tr>
            </thead>
            <tbody>
			<?php if(empty($tenants)): ?>
			<tr><td colspan="7">No tenant data in database</td></tr>
			<?php else:?>
			<?php foreach($tenants as $tenant): ?>
                <tr>
					<td><?php echo $tenant['tenant_id']; ?></td>
					<td><?php echo $tenant['names']; ?></td>
					<td><?php echo $tenant['phone1']; ?></td>
					<td><?php echo isset($tenant['phone2'])?$tenant['phone2']:""; ?></td>
					<td>
					<a href="<?php echo site_url("tenant/view/{$tenant['tenant_id']}"); ?>" title="<?php echo $tenant['names']; ?> details"><span class="fa fa-table"></span></a>
					</td>
					<!--td>
					<a href="<?php echo site_url("bill/view/{$tenant['tenant_id']}"); ?>" title="<?php echo $tenant['names']; ?>'s bills" ><span class="fa fa-dollar"></span></a>
					</td-->
					<td>
					<a href="<?php echo site_url("payment/view/".$tenant['tenant_id']); ?>" title="<?php echo $tenant['names']; ?>'s payments"><span class="fa fa-credit-card"></span></a>
					</td>
					<!-- If the estates owner/admin is logged in -->
					<?php if($_SESSION['role']==4||$_SESSION['role']==3){?>
					<td>
					<a href="<?php echo site_url("tenant/update/{$tenant['tenant_id']}"); ?>" title="Update <?php echo $tenant['names']; ?>'s details" ><span class="fa fa-edit"></span></a>
					</td>
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