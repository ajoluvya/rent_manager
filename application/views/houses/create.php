        <!-- Main content -->
        <section class="content">
		<div class="row">
            <!-- left column -->
            <div class="col-md-6 col-md-offset-3">
              <!-- general form elements -->
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $sub_title; ?></h3>
                </div>
				<!-- /.box-header -->
                <!-- form start -->
                <?php echo validation_errors("<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>","</div>"); ?>
				<?php echo form_open(uri_string(),array('name' => 'house_creation', 'role' => 'form')); ?>
                  <div class="box-body">
                    <div class="form-group">
                      <div class="col-md-4"><label for="estate_id">Estate</label></div>
                      <div class="col-md-8"><select id="estate_id" name="estate_id" class="form-control">
						<option>Select estate...</option>
							<?php foreach($estates as $estate):?>
							<option value="<?php echo $estate['estate_id']; ?>" <?php echo (set_select('estate_id', $estate['estate_id'])!=NULL)?"selected":((isset($house['estate_id'])&&$estate['estate_id']==$house['estate_id'])?"selected":""); ?>><?php echo $estate['estate_name']; ?></option>
							<?php endforeach; ?>
                      </select></div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4"><label for="house_no">House/room No</label></div>
                      <div class="col-md-8"><input type="text" class="form-control" id="house_no" name="house_no" value="<?php echo (set_value('house_no')!=NULL)?set_value('house_no'):(isset($house['house_no'])?$house['house_no']:""); ?>" placeholder="Enter apartment/house/room number"></div>
                    </div>
                      <div class="col-md-4"><label for="floor">Floor</label></div>
                      <div class="col-md-8">
					  <select id="floor" name="floor" class="form-control">
							<?php foreach($floors as $key => $floor):?>
							<option value="<?php echo $key; ?>" <?php echo (set_select('floor', $key+1)!=NULL)?"selected":((isset($house['floor'])&&$key==$house['floor'])?"selected":""); ?>><?php echo $floor; ?> floor</option>
							<?php endforeach; ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4"><label for="description">Description</label></div>
                      <div class="col-md-8"><textarea class="form-control" id="description" name="description" rows="3" cols="40" placeholder="Optional, brief description for apartment/house/room"><?php echo (set_value('description')!=NULL)?set_value('description'):(isset($house['description'])?$house['description']:""); ?></textarea></div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4"><label for="fixed_amount">Fixed Amount</label></div>
                      <div class="col-md-8">
					  <div class="input-group"><span class="input-group-addon">UGX</span><input type="text" class="form-control" id="fixed_amount" name="fixed_amount" value="<?php echo (set_value('fixed_amount')!=NULL)?set_value('fixed_amount'):(isset($house['fixed_amount'])?$house['fixed_amount']:""); ?>" placeholder="Enter amount"></div>
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