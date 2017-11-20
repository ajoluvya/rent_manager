		<div class="row">
            <!-- left column -->
            <div class="col-md-6 col-md-offset-3">
              <!-- general form elements -->
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $sub_title; ?> &nbsp;<small><?php echo isset($step_text)?"Step 1 0f 3":"";?></small></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <?php echo validation_errors("<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>","</div>"); ?>
				<?php echo form_open(uri_string(),array('name' => 'create_tenant', 'role' => 'form')); ?>
                  <div class="box-body">
                    <div class="form-group">
                      <div class="col-md-4"><label for="names">Names</label></div>
                      <div class="col-md-8"><input type="text" class="form-control" id="names" name="names" size="50" value="<?php echo (set_value('names')!=NULL)?set_value('names'):(isset($tenant['names'])?$tenant['names']:""); ?>" placeholder="Enter names"></div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4"><label for="phone1">Phone1</label></div>
                      <div class="col-md-8"><input type="text" class="form-control" id="phone1" name="phone1" size="10" value="<?php echo (set_value('phone1')!=NULL)?set_value('phone1'):(isset($tenant['phone1'])?$tenant['phone1']:""); ?>" placeholder="Enter phone number1"></div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4"><label for="phone2">Phone2</label></div>
                      <div class="col-md-8"><input type="text" class="form-control" id="phone2" name="phone2" size="10" value="<?php echo (set_value('phone2')!=NULL)?set_value('phone2'):(isset($tenant['phone2'])?$tenant['phone2']:""); ?>" placeholder="Optional, phone number2"></div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4"><label for="home_address">Home address</label></div>
                      <div class="col-md-8">
							<textarea class="form-control" id="home_address" name="home_address" size="100" cols="40" rows="5" placeholder="Enter home address"><?php echo (set_value('home_address')!=NULL)?set_value('home_address'):(isset($tenant['home_address'])?$tenant['home_address']:""); ?></textarea>
					</div>
					</div>
                    <div class="form-group">
                      <div class="col-md-4"><label for="district_id">Home district</label></div>
                      <div class="col-md-8">
					  	<select name="district_id" id="district_id" class="form-control">
							<option>Select district...</option>
							<?php foreach($districts as $district):?>
							<option value="<?php echo $district['district_id']; ?>" <?php echo (set_select('district_id', $district['district_id'])!=NULL)?"selected":((isset($tenant['district_id'])&&$tenant['district_id']==$district['district_id'])?"selected":""); ?>><?php echo $district['district']; ?></option>
							<?php endforeach; ?>
						  </select>
						</div>
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary"><?php echo isset($btn_text)?$btn_text:"Submit";?></button>
                  </div>
                </form>
              </div><!-- /.box -->

            </div><!--/.col (left) -->
          </div>   <!-- /.row -->