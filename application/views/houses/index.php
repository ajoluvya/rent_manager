<div class="row">
	<div class="col-lg-12">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $sub_title; ?></h3>
				<div class="pull-right">
						<a href="<?php echo site_url("house/create"); ?>" class="btn btn-default" title="Create new house"><i class="fa fa-plus-square"></i> New</a>
				</div>
            </div>
			<table class="table table-striped table-condensed table-hover dynamicTables">
				<thead>
					<tr>
						<th>ID</th>
						<th>House No</th>
						<th>Estate</th>
						<th>Fixed amount (UGX)</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<!-- If the estates owner/admin is logged in -->
						<?php if($_SESSION['role']==4||$_SESSION['role']==3):?>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<?php endif;?>
					</tr>
				</thead>
				<tbody>
				<?php if(empty($houses)): ?>
				<tr><td colspan="7">No house record in database</td></tr>
				<?php else:?>
				<?php foreach($houses as $house): ?>
					<tr>
						<td><?php echo $house['house_id']; ?></td>
						<td><a href="<?php echo site_url("house/view/{$house['house_id']}"); ?>" title='Estate details'><?php echo $house['house_no']; ?></a></td>
						<td><?php echo $house['estate_name']; ?></td>
						<td><?php echo number_format($house['fixed_amount']); ?></td>
						<td>
						<a href="<?php echo site_url("bill/view/{$house['house_id']}"); ?>" title='View bills for this house'><span class="fa fa-dollar"></span></a>
						</td>
						<td>
						<a href="<?php echo site_url("payment/view/{$house['house_id']}"); ?>" title='View payment records'><span class="fa fa-credit-card"></span></a>
						</td>
						<!-- If the estates owner/admin is logged in -->
						<?php if($_SESSION['role']==4||$_SESSION['role']==3){?>
						<td>
						<a href="<?php echo site_url("house/update/{$house['house_id']}"); ?>" title='Update house'><span class="fa fa-edit"></span></a>
						</td>
						<td>
						<a href="<?php echo site_url("house/del_house/{$house['house_id']}"); ?>" onclick="return confirm_delete('<?php echo "the house ".$house['house_no'] ; ?>');" title="Delete"><span class="fa fa-trash text-danger"></span></a>
						<?php } ?>
						</td>
					</tr>
				<?php endforeach; ?>
				<?php endif;?>
				</tbody>
			</table>
			<?php echo $pag_links; ?>
        </div><!-- /.box -->
	</div>
</div>