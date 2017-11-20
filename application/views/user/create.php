<div class="register-box">
	<div class="register-box-body">
        <p class="login-box-msg"><?php echo $sub_title; ?></p>
		<?php echo validation_errors("<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>","</div>"); ?>
        <?php echo form_open(uri_string(),array('name' => 'userLogin')); ?>
		
		<!-- If the estates owner/admin is logged in -->
		<?php if((strpos(uri_string(), "create")!==FALSE)||(strpos(uri_string(), "update")!==FALSE)):?>
          <div class="form-group has-feedback">
            <input type="text" name="fname" class="form-control" value="<?php echo (set_value('fname')!=NULL)?set_value('fname'):(isset($user['fname'])?$user['fname']:""); ?>" placeholder="Firstname" title="Firstname">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="text" name="lname" class="form-control" value="<?php echo (set_value('lname')!=NULL)?set_value('lname'):(isset($user['lname'])?$user['lname']:""); ?>" placeholder="Lastname" title="Lastname">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="text" name="uname" id="uname" class="form-control" value="<?php echo (set_value('uname')!=NULL)?set_value('uname'):(isset($user['username'])?$user['username']:""); ?>" placeholder="Username" title="Username">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <select class="form-control" name="role_code" title="Role">
			<option>Select role...</option>
			<?php foreach($roles as $role):?>
			<option value="<?php echo $role['role_code']; ?>" <?php echo  (set_select('role_code', $role['role_code'])!=NULL)?"selected":((isset($user['role_code'])&&$user['role_code']==$role['role_code'])?"selected":""); ?>><?php echo $role['role_name']; ?></option>
			<?php endforeach; ?>
			</select>
          </div>
		  <?php else: ?>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="cur_pwd" id="cur_pwd" placeholder="Current Password" title="Current Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="pwd" id="pwd" placeholder="New password" title="New password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="retype_pwd" id="retype_pwd" placeholder="Retype new password" title="Retype new password">
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>
		  <?php endif; ?>
          <div class="row">
            <div class="col-xs-8">
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat"><?php echo isset($btn_text)?$btn_text:"Submit";?></button>
            </div><!-- /.col -->
          </div>
        </form>
      </div><!-- /.form-box -->
    </div><!-- /.register-box -->

    <!-- iCheck -->
    <script type="text/javascript" src="<?php echo base_url("assets/iCheck/icheck.min.js"); ?>"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>