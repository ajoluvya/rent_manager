		<div class="row">
            <!-- left column -->
            <div class="col-md-6 col-md-offset-3">
              <!-- general form elements -->
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $sub_title; ?> &nbsp;<small><?php echo isset($step_text)?"Step 3 0f 3":"";?></small></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <?php echo validation_errors("<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>","</div>"); ?>
				<?php echo form_open(uri_string(),array('name' => 'add_payment', 'role' => 'form')); ?>
                  <div class="box-body">
                    <div class="form-group">
                      <div class="col-md-6"><label for="acc_no">Tenant:</label></div>
                      <div class="col-md-6">
						<input type="hidden" id="tenant_id" name="tenant_id" value="<?php echo (isset($tenant_id))?$tenant_id:set_value('tenant_id'); ?>">
						<label><?php echo (isset($tenant['names'])?$tenant['names']:""); ?></label>
					  </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4"><label for="account_id">Account</label></div>
                      <div class="col-md-8">
						  <select id="account_id" name="account_id" class="form-control">
							<option>Select...</option>
							<?php foreach($accounts as $account):?>
							<option value="<?php echo $account['acc_id']; ?>" <?php echo (set_select('account_id', $account['acc_id'])!=NULL)?"selected":((isset($payment['acc_id'])&&$payment['account_id']==$account['acc_id'])?"selected":""); ?>><?php echo $account['acc_no']; ?>, <?php echo $account['bank_name']; ?></option>
							<?php endforeach; ?>
						  </select>
					  </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4"><label for="particulars">Particulars</label></div>
                      <div class="col-md-8"><textarea class="form-control" id="particulars" name="particulars" rows="5" cols="80" size="100" placeholder="Enter payment particulars"><?php echo (set_value('particulars')!=NULL)?set_value('particulars'):(isset($payment['particulars'])?$payment['particulars']:""); ?></textarea></div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4"><label for="amount">Amount</label></div>
                      <div class="col-md-8"><div class="input-group"><span class="input-group-addon">UGX</span><input type="text" class="form-control" id="amount" name="amount" value="<?php echo (set_value('amount')!=NULL)?set_value('amount'):(isset($payment['amount']))?$payment['amount']:""; ?>" placeholder="Enter amount paid" data-validation="number" data-validation-error-msg="Not a number/missing amount"></div>
					  </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4"><label for="payment_date">Date paid</label></div>
                      <div class="col-md-8"><div class="input-group"><input type="text" class="form-control datepicker" id="payment_date" name="payment_date" value="<?php echo (set_value('payment_date')!=NULL)?set_value('payment_date'):(isset($tenancy['payment_date'])?mdate("%d-%m-%Y",$tenancy['payment_date']):""); ?>" placeholder="Enter payment date" data-validation="date" data-validation-error-msg="Not a date/missing payment date" data-validation-format="dd-mm-yyyy" data-provide="datepicker" ><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div></div>
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary"><?php echo isset($btn)?$btn:"Submit";?></button>
                  </div>
                </form>
              </div><!-- /.box -->

            </div><!--/.col (left) -->
          </div>   <!-- /.row -->