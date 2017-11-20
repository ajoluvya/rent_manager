<div class="row">
	<div class="col-lg-12">
        <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $sub_title; ?></h3>
        </div>
		<div class="box-body">
		<table class="table table-striped table-condensed dynamicTables">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Estate</th>
                    <th>Telephone No</th>
                    <th>Telephone No2</th>
                    <th>Address</th>
					<th>&nbsp;</th>
					<!-- If the estates owner/admin is logged in -->
					<?php if($_SESSION['role']==4||$_SESSION['role']==3):?>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
					<?php endif;?>
                </tr>
            </thead>
            <tbody>
			<?php if(empty($estates)): ?>
			<tr><td colspan="8">No estates data in database</td></tr>
			<?php else:?>
			<?php foreach($estates as $estate): ?>
                <tr>
					<td><?php echo $estate['estate_id']; ?></td>
					<td><?php echo $estate['estate_name']; ?></td>
					<td><?php echo $estate['phone']; ?></td>
					<td><?php echo isset($estate['phone2'])?$estate['phone2']:""; ?></td>
					<td><?php echo $estate['address']; ?></td>
					<td>
					<a href="<?php echo site_url("estate/view/{$estate['estate_id']}"); ?>" title='Estate details'><span class="fa fa-table"></span></a>
					</td>
					<!-- If the estates owner/admin is logged in -->
					<?php if($_SESSION['role']==4||$_SESSION['role']==3){?>
					<td>
					<a href="<?php echo site_url("estate/update/{$estate['estate_id']}"); ?>" title='Update estate'><span class="fa fa-edit"></span></a>
					</td>
					<td>
					<a href="<?php echo site_url("estate/del_estate/{$estate['estate_id']}"); ?>" onclick="return confirm_delete('<?php echo "the estate ".$estate['estate_name'] ; ?>');" title="Delete"><span class="fa fa-trash text-danger"></span></a>
					</td>
					<?php } ?>
				</tr>
			<?php endforeach; ?>
			<?php endif;?>
			</tbody>
		</table>
			<?php echo $pag_links; ?>
                  </div><!-- /.box-body -->
              </div><!-- /.box -->
	</div>
</div>