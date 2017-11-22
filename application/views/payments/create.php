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
                      <div class="col-md-6"><label for="acc_no">House:</label></div>
                      <div class="col-md-6">
						<input type="hidden" id="house_id" name="house_id" value="<?php echo (isset($house_id))?$house_id:set_value('house_id'); ?>">
						<label><?php echo (isset($tenancy['house_no'])?("<a href=\"".site_url("house/view/{$tenancy['house_id']}")."\" title=\"".$tenancy['house_no']." details\">".$tenancy['house_no']."</a>"):""); ?></label>
					  </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-6"><label for="acc_no">Tenant:</label></div>
                      <div class="col-md-6">
						<input type="hidden" id="tenant_id" name="tenant_id" value="<?php echo (isset($tenancy['tenant_id']))?$tenancy['tenant_id']:set_value('tenant_id'); ?>">
						<label><?php echo (isset($tenancy['names'])?("<a href=\"".site_url("tenant/view/{$tenancy['tenant_id']}")."\" title=\"".$tenancy['names']." details\">".$tenancy['names']."</a>"):""); ?></label>
					  </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4"><label for="account_id">Account</label></div>
                      <div class="col-md-8">
						  <select id="account_id" name="account_id" class="form-control">
							<option>Select...</option>
							<?php foreach($accounts as $account):?>
							<option value="<?php echo $account['acc_id']; ?>" <?php echo (set_select('account_id', $account['acc_id'])!=NULL)?"selected":((isset($payment['acc_id'])&&$payment['acc_id']==$account['acc_id'])?"selected":""); ?>><?php echo $account['acc_no']; ?>, <?php echo $account['bank_name']; ?></option>
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
                      <div class="col-md-8"><div class="input-group"><span class="input-group-addon">UGX</span><input type="text" class="form-control" disabled id="amount" name="amount" value="<?php echo (set_value('amount')!=NULL)?set_value('amount'):(isset($payment['amount']))?$payment['amount']:($tenancy['rent_rate']?$tenancy['rent_rate']:""); ?>" placeholder="Enter amount paid" data-validation="number" data-validation-error-msg="Not a number/missing amount"></div>
					  </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4"><label for="no_of_months">No of months</label></div>
                      <div class="col-md-8">
						<input type="number" class="form-control" id="no_of_months" name="no_of_months" value="<?php echo (set_value('no_of_months')!=NULL)?set_value('no_of_months'):(isset($payment['no_of_months'])?mdate("%d-%m-%Y",$payment['no_of_months']):""); ?>" placeholder="Enter number of months" data-validation="number" data-validation-error-msg="Not a number" />
					  </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4"><label for="no_of_months">Total Amount</label></div>
                      <div class="col-md-8">
						<input type="text" class="form-control" disabled id="total_amount" name="total_amount" value="<?php echo (set_value('total_amount')!=NULL)?set_value('total_amount'):(isset($payment['total_amount'])?$payment['total_amount']:""); ?>" />
					  </div>
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary"><?php echo isset($btn)?$btn:"Submit";?></button>
                  </div>
                </form>
              </div><!-- /.box -->

            </div><!--/.col (left) -->
          </div>   <!-- /.row -->