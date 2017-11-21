<div class="row">
	<div class="col-lg-8">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $sub_title; ?></h3>
                </div>
				<div class="btn-group">
						<a href="<?php echo site_url("house/create"); ?>" class="btn btn-default" title="New house"><i class="fa fa-plus-square"></i> New</a>
				</div>
				<div class="btn-group">
					<a class="btn btn-default" href="<?php echo site_url("bill/view/".$house['house_id']); ?>" title="View bills for this house">
						<i class="fa fa-dollar"></i> Bills
					</a>
				</div>
				<div class="btn-group">
					<a class="btn btn-default" href="<?php echo site_url("payment/view/".$house['house_id']); ?>" title="View payment records">
						<i class="fa fa-credit-card"></i> Payments
					</a>
				</div>
				<!-- If the estates owner/admin is logged in -->
				<?php if($_SESSION['role']==4||$_SESSION['role']==3){?>
				<div class="btn-group">
					<a class="btn btn-default" href="<?php echo site_url("house/update/".$house['house_id']); ?>" title="Edit house details">
						<i class="fa fa-edit"></i> Edit
					</a>
				</div>
				<div class="btn-group">
						<a href="<?php echo site_url("house/del_house/".$house['house_id']); ?>" class="btn btn-danger" title='Delete house details' onclick="return confirm_delete('<?php echo "the details of house ".$house['house_no']; ?>');"><i class="fa fa-trash"></i> Delete</a>
				</div>
				<?php } ?>
				<div class="table">
				<table class="table table-striped table-condensed table-hover">
						<tr><th>Apartment/House/Room No</th><td><?php echo $house['house_no']; ?></td></tr>
						<tr><th>Fixed amount</th><td><?php echo number_format($house['fixed_amount']); ?></td></tr>
						<tr><th>Floor</th><td><?php echo $floor; ?> floor</td></tr>
						<tr><th>Description</th><td><?php echo $house['description']; ?></td></tr>
						<tr><th>Estate</th><td><?php echo $house['estate_name']; ?></td></tr>
				</table>
				</div>
              </div><!-- /.box -->
	</div>
</div>