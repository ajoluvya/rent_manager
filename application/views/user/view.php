<div class="row">
	<div class="col-lg-6">
	<div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $sub_title; ?></h3>
        </div>
        <div class="box-body">
		<table class="table table-striped table-condensed table-hover">
                <tr><th>UserID</th><td><?php echo $user['userId']; ?></td></tr>
                <tr><th>Firstname</th><td><?php echo $user['fname']; ?></td></tr>
                <tr><th>Lastname</th><td><?php echo $user['lname']; ?></td></tr>
                <tr><th>Mobile number</th><td><?php echo $user['phone']; ?></td></tr>
                <tr><th>Email</th><td><?php echo $user['email']; ?></td></tr>
                <tr><th>Designation</th><td><?php echo $user['role_name']; ?></td></tr>
                <?php if($_SESSION['user_id']==$user['userId']):?>
				<tr><th>&nbsp;</th><td><a href="<?php echo site_url('user/change_pass/' . $user['userId']); ?>" title="Change password"> Change password</a></td></tr>
				<?php endif; ?>
		</table>
		
        </div><!-- /.box-body -->
	</div><!-- /.box -->
	</div><!-- /.col-lg-6 -->
</div><!-- /.row -->