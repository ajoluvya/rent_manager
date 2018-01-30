<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-lg-6 col-lg-offset-3">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $sub_title; ?> <small>All fields with asterisks (*) are required.</small></h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php echo validation_errors("<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>", "</div>"); ?>
                    <?php echo form_open(uri_string(), array('name' => 'userLogin', 'id' => 'userLoginForm', 'data-toggle' => 'validator', 'role' => 'form')); ?>
                    <div class="box-body">

                        <!-- If the estates owner/admin is logged in -->
                        <?php if ((strpos(uri_string(), "create") !== FALSE) || (strpos(uri_string(), "update") !== FALSE)): ?>
                            <div class="form-group has-feedback">
                                <input type="text" name="fname" class="form-control" value="<?php echo (set_value('fname') != NULL) ? set_value('fname') : (isset($user['fname']) ? $user['fname'] : ""); ?>" placeholder="Firstname" title="Firstname" required="">
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="text" name="lname" class="form-control" value="<?php echo (set_value('lname') != NULL) ? set_value('lname') : (isset($user['lname']) ? $user['lname'] : ""); ?>" placeholder="Lastname" title="Lastname" required="">
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="text" name="phone" id="phone" class="form-control" value="<?php echo (set_value('phone') != NULL) ? set_value('phone') : (isset($user['phone']) ? $user['phone'] : ""); ?>" placeholder="Phone number" title="Phone number" pattern="^(0|\+256)[2347]([0-9]{8})" data-pattern-error="Invalid phone number" required="">
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="text" name="uname" id="uname" class="form-control" value="<?php echo (set_value('uname') != NULL) ? set_value('uname') : (isset($user['username']) ? $user['username'] : ""); ?>" placeholder="Username" title="Username" required="">
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <select class="form-control" name="role_code" title="Role" required="">
                                    <option>Select role...</option>
                                    <?php foreach ($roles as $role): ?>
                                        <option value="<?php echo $role['role_code']; ?>" <?php echo (set_select('role_code', $role['role_code']) != NULL) ? "selected" : ((isset($user['role_code']) && $user['role_code'] == $role['role_code']) ? "selected" : ""); ?>><?php echo $role['role_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php else: ?>
                            <div class="form-group has-feedback">
                                <input type="password" class="form-control" name="cur_pwd" id="cur_pwd" placeholder="Current Password" title="Current Password" required="">
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="password" class="form-control" name="pwd" id="pwd" placeholder="New password" title="New password" required="">
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="password" class="form-control" name="retype_pwd" id="retype_pwd" placeholder="Retype new password" title="Retype new password" required="">
                                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                            </div>
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-xs-8">
                            </div><!-- /.col -->
                            <div class="col-xs-4">
                                <button type="submit" class="btn btn-primary btn-block btn-flat"><?php echo isset($btn_text) ? $btn_text : "Submit"; ?></button>
                            </div><!-- /.col -->
                        </div>
                    </div><!-- /.box-body -->
                    </form>
                </div><!-- /.box -->
                </div><!--/.col-lg-6 col-lg-offset-3 -->
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col-lg-12 -->
</div>   <!-- /.row -->

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