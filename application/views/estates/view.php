<div class="row">'
	<div class="col-lg-6">
		<div class="btn-group">
				<a href="<?php echo site_url("estate/create"); ?>" class="btn btn-default" title="Create new estate"><i class="fa fa-plus-square"></i> New</a>
		</div>
		<div class="btn-group">
			<a class="btn btn-default" href="<?php echo site_url("bill/view/".$estate['estate_id']); ?>" title="View bills for this estate">
				<i class="fa fa-dollar"></i> Bills
			</a>
		</div>
		<div class="btn-group">
			<a class="btn btn-default" href="<?php echo site_url("payment/view/".$estate['estate_id']); ?>" title="View payment records made for this estate">
				<i class="fa fa-credit-card"></i> Payments
			</a>
		</div>
		<!-- If the estates owner/admin is logged in -->
		<?php if($_SESSION['role']==4||$_SESSION['role']==3){?>
		<div class="btn-group">
			<a class="btn btn-default" href="<?php echo site_url("estate/update/".$estate['estate_id']); ?>" title="Edit estate details">
				<i class="fa fa-edit"></i> Edit
			</a>
		</div>
		<div class="btn-group">
				<a href="<?php echo site_url("estate/del_estate/".$estate['estate_id']); ?>" class="btn btn-danger" title='Delete estate details' onclick="return confirm_delete('<?php echo "the details of ".$estate['estate_name']; ?>');"><i class="fa fa-trash"></i>Delete</a>
		</div>
		<?php } ?>
		
		<div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Estate: <?php echo $sub_title; ?></h3>
        </div>
		<div class="box-body">
        <table class="table table-striped table-condensed table-hover">
                <tr><th>ID</th><td><?php echo $estate['estate_id']; ?></td></tr>
                <tr><th>Telephone</th><td><?php echo $estate['phone']; ?></td></tr>
                <tr><th>Telephone2</th><td><?php echo $estate['phone2']; ?></td></tr>
                <tr><th>Address</th><td><?php echo $estate['address']; ?></td></tr>
                <tr><th>District</th><td><?php echo $estate['district']; ?></td></tr>
		</table>
                  </div><!-- /.box-body -->
              </div><!-- /.box -->
	</div>
</div>