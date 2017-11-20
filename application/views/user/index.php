<div class="row">
	<div class="col-lg-12">
	<div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $sub_title; ?></h3>
        </div>
		<!-- Search form -->
		<form action="<?php echo current_url();?>" method="post">
			<div class="col-md-4"><input type="text" name="search" id="search" class="form-control" placeholder="Search by names"/></div>
			<div class="col-md-2"><input type="text" name="start" id="start" class="datepicker form-control" placeholder="Start date"/></div>
			<div class="col-md-2"><input type="text" name="end" id="end" class="datepicker form-control" placeholder="End date"/></div>
			<div class="col-md-3"><select name="period" id="period" class="form-control">
					<option>Select period</option>
					<option value="30">1 month</option>
					<option value="61">2 months</option>
					<option value="183">6 months</option>
				</select></div>
			<div class="col-md-1"><input type="submit" value="Search" class="btn"/></div>
		</form>
        <table class="table table-striped table-bordered table-hover dataTables">
            <thead>
                <tr>
                    <th>Names</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Reg Date</th>
					<!-- If the estates owner/admin is logged in -->
					<th <?php if($_SESSION['role']==4||$_SESSION['role']==3){?>colspan="3"<?php } ?>>Action</th>
					
                </tr>
            </thead>
            <tbody>
<?php foreach ($users as $user): ?>
                <tr>
					<td><?php echo $user['fname']; ?>&nbsp;<?php echo $user['lname']; ?></td>
					<td><?php echo $user['username']; ?></td>
					<td><?php echo $user['role_name']; ?></td>
					<td><?php echo mdate('%d-%m-%Y',$user['reg_date']); ?></td>
					<td>
					<a href="<?php echo site_url("user/view/{$user['userId']}"); ?>" title="View <?php echo $user['fname'] . " " . $user['lname']; ?>'s details" ><span class="fa fa-table"></span></a>
					</td>
					<!-- If the estates owner/admin is logged in -->
					<?php if($_SESSION['role']==4||$_SESSION['role']==3){?>
					<td>
					<a href="<?php echo site_url("user/update/{$user['userId']}"); ?>" title="Update <?php echo $user['fname'] . " " . $user['lname']; ?>'s details" ><span class="fa fa-edit"></span></a>
					</td>
					<td>
					<?php if($user['userId']!=$_SESSION['user_id']):?>
					<a href="<?php echo site_url("user/del_user/{$user['userId']}"); ?>" onclick="return confirm_delete('<?php echo "the user ".$user['fname'] . " " . $user['lname']; ?>');" title="Delete <?php echo $user['fname'] . " " . $user['lname']; ?>'s details"><span class="fa fa-trash"></span></a>
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