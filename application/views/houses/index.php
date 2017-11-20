<div class="row no-print">
	<div class="col-lg-6">
        <div class="btn-group">
				<a href="<?php echo site_url("house/create"); ?>" class="btn btn-app" title="Create new house"><i class="fa fa-plus-square"></i> New</a>
		</div>
	</div><!-- /.col-lg-6 -->
</div><!-- /.row -->
<div class="row">
	<div class="col-lg-8">
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
						<th>House No</th>
						<th>Estate</th>
						<th>Fixed amount (UGX)</th>
						<!-- If the estates owner/admin is logged in -->
						
						<th colspan="<?php if($_SESSION['role']==4||$_SESSION['role']==3){ echo 5; } else echo 3; ?>">Action</th>
					</tr>
				</thead>
				<tbody>
				<?php if(empty($houses)): ?>
				<tr><td colspan="7">No house record in database</td></tr>
				<?php else:?>
				<?php foreach($houses as $house): ?>
					<tr>
						<td><?php echo $house['house_id']; ?></td>
						<td><?php echo $house['house_no']; ?></td>
						<td><?php echo $house['estate_name']; ?></td>
						<td><?php echo number_format($house['fixed_amount']); ?></td>
						<td>
						<a href="<?php echo site_url("house/view/{$house['house_id']}"); ?>" title='Estate details'><span class="fa fa-table"></span></a>
						</td>
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
						<a href="<?php echo site_url("house/del_house/{$house['house_id']}"); ?>" onclick="return confirm_delete('<?php echo "the house ".$house['house_no'] ; ?>');" title="Delete"><span class="fa fa-trash"></span></a>
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