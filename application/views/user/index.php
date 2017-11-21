<div class="row">
	<div class="col-lg-12">
	<div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $sub_title; ?></h3>
        </div>
        <table class="table table-striped table-bordered table-hover dynamicTables">
            <thead>
                <tr>
                    <th>Names</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Reg Date</th>
					<th>&nbsp;</th>
					<!-- If the estates owner/admin is logged in -->
					<?php if($_SESSION['role']==4||$_SESSION['role']==3):?>
					<th>&nbsp;</th>
					<?php endif;?>
                </tr>
            </thead>
            <tbody>
<?php foreach ($users as $user): ?>
                <tr>
					<td><a href="<?php echo site_url("user/view/{$user['userId']}"); ?>" title="View <?php echo $user['fname'] . " " . $user['lname']; ?>'s details" ><?php echo $user['fname']; ?>&nbsp;<?php echo $user['lname']; ?></a></td>
					<td><?php echo $user['username']; ?></td>
					<td><?php echo $user['role_name']; ?></td>
					<td><?php echo mdate('%d, %M %Y',$user['reg_date']); ?></td>
					<!-- If the estates owner/admin is logged in -->
					<?php if($_SESSION['role']==4||$_SESSION['role']==3){?>
					<td>
					<a href="<?php echo site_url("user/update/{$user['userId']}"); ?>" title="Update <?php echo $user['fname'] . " " . $user['lname']; ?>'s details" ><span class="fa fa-edit"></span></a>
					</td>
					<td>
					<?php if($user['userId']!=$_SESSION['user_id']):?>
					<a href="<?php echo site_url("user/del_user/{$user['userId']}"); ?>" onclick="return confirm_delete('<?php echo "the user ".$user['fname'] . " " . $user['lname']; ?>');" title="Delete <?php echo $user['fname'] . " " . $user['lname']; ?>'s details"><span class="fa fa-trash text-danger"></span></a>
					</td>
					<?php endif; } ?>
				</tr>
<?php endforeach; ?>
			</tbody>
		</table>
			<?php echo $pag_links; ?>
	</div><!-- /.box -->
	</div><!-- /.col-lg-12 -->
</div><!-- /.row -->