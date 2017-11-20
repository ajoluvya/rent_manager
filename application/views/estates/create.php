		<div class="row">
            <!-- left column -->
            <div class="col-md-6 col-md-offset-3">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $sub_title; ?></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
				<?php echo validation_errors("<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>","</div>"); ?>
				<?php echo form_open(uri_string(),array('name' => 'estate_creation', 'role' => 'form')); ?>
                  <div class="box-body">
                    <div class="form-group">
                      <div class="col-md-4"><label for="estate_name">Estate Name</label></div>
                      <div class="col-md-8"><input type="text" class="form-control" id="estate_name" name="estate_name" size="50" value="<?php echo (set_value('estate_name')!=NULL)?set_value('estate_name'):(isset($estate['estate_name'])?$estate['estate_name']:""); ?>" placeholder="Enter estate name"></div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4"><label for="description">Description</label></div>
                      <div class="col-md-8"><textarea class="form-control" id="description" name="description" rows="5" cols="80" size="100" placeholder="Enter decription"><?php echo (set_value('description')!=NULL)?set_value('description'):(isset($estate['description'])?$estate['description']:""); ?></textarea></div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4"><label for="phone">Telephone</label></div>
                      <div class="col-md-8"><input type="text" class="form-control" id="phone" name="phone" size="10" value="<?php echo (set_value('phone')!=NULL)?set_value('phone'):(isset($estate['phone'])?$estate['phone']:""); ?>" placeholder="Enter phone number"></div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4"><label for="phone2">Telephone2</label></div>
                      <div class="col-md-8"><input type="text" class="form-control" id="phone2" name="phone2" size="10" value="<?php echo (set_value('phone2')!=NULL)?set_value('phone2'):(isset($estate['phone2'])?$estate['phone2']:""); ?>" placeholder="Optional, second telephone number"></div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4"><label for="address">Address</label></div>
                      <div class="col-md-8">
					  <textarea class="form-control" id="address" name="address" rows="5" cols="80" size="100" placeholder="Enter address"><?php echo (set_value('address')!=NULL)?set_value('address'):(isset($estate['address'])?$estate['address']:""); ?></textarea>
					  </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4"><label for="district">District</label></div>
                      <div class="col-md-8">
					  	<select id="district" name="district" class="form-control">
							<option>Select district...</option>
							<?php foreach($districts as $district):?>
							<option value="<?php echo $district['district_id']; ?>" <?php echo (set_select('district_id', $district['district_id'])!=NULL)?"selected":((isset($estate['district_id'])&&$estate['district_id']==$district['district_id'])?"selected":""); ?>><?php echo $district['district']; ?></option>
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