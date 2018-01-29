<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-lg-8 col-lg-offset-2">
                    <!-- general form elements -->
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $sub_title; ?> &nbsp;<small><?php echo isset($step_text) ? "Step 1 0f 3" : ""; ?></small></h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <?php echo validation_errors("<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>", "</div>"); ?>
                        <?php echo form_open_multipart(uri_string(), array('id' => 'saveTenantForm', 'name' => 'saveTenantForm', 'data-toggle' => 'validator', 'role' => 'form')); ?>
                        <div class="box-body">
                            <div class="col-lg-12">
                                <div class="col-md-3"><label for="names">Names</label></div>
                                <div class="form-group col-md-8"><input type="text" class="form-control" id="names" name="names" value="<?php echo (set_value('names') != NULL) ? set_value('names') : (isset($tenant['names']) ? $tenant['names'] : ""); ?>" placeholder="Tenant names" required=""></div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12">
                                <div class="col-md-3"><label for="phone1">Phone Numbers</label></div>
                                <div class="form-group col-md-4"><input type="text" class="form-control" id="phone1" name="phone1" value="<?php echo (set_value('phone1') != NULL) ? set_value('phone1') : (isset($tenant['phone1']) ? $tenant['phone1'] : ""); ?>" placeholder="Primary phone number" pattern="^(0|\+256)[2347]([0-9]{8})" data-pattern-error="Invalid phone number" required=""></div>
                                <div class="form-group col-md-4"><input type="text" class="form-control" id="phone2" name="phone2" value="<?php echo (set_value('phone2') != NULL) ? set_value('phone2') : (isset($tenant['phone2']) ? $tenant['phone2'] : ""); ?>" pattern="^(0|\+256)[2347]([0-9]{8})" data-pattern-error="Invalid phone number" placeholder="Optional, second phone number"></div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12">
                                <div class="col-md-3"><label for="id_card_no">ID Card</label></div>
                                <div class="form-group col-md-4"><input type="text" class="form-control" id="id_card_no" name="id_card_no" value="<?php echo (set_value('id_card_no') != NULL) ? set_value('id_card_no') : (isset($tenant['id_card_no']) ? $tenant['id_card_no'] : ""); ?>" placeholder="Card number" required=""></div>
                                <div class="form-group col-md-4">
                                    <input type="file" class="form-control" id="id_card_url" name="id_card_url" accept=".png,.jpeg,.gif,.jpg,.pdf,image/gif,image/jpg,image/jpeg,image/pjpeg,image/png,application/pdf">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12">
                                <div class="col-md-3"><label for="passport_photo">Passport Photo</label></div>
                                <div class="form-group col-md-4">
                                    <?php if (isset($tenant['passport_photo']) && $tenant['passport_photo'] != ""): ?>
                                        <img class="img-thumbnail img-lg" src="<?php echo site_url("uploads/tenants/" . $tenant['passport_photo']); ?>"/>
                                    <?php endif; ?>
                                    <input type="file" class="form-control" id="passport_photo" name="passport_photo" accept=".png,.jpeg,.gif,.jpg,.pdf,image/gif,image/jpg,image/jpeg,image/pjpeg,image/png,application/pdf" />
                                </div>
                                <div class="form-group col-md-4">
                                    <?php if (isset($tenant['id_card_url']) && $tenant['id_card_url'] != ""): ?>
                                        <img class="img-thumbnail img-lg" src="<?php echo site_url("uploads/tenants/" . $tenant['id_card_url']); ?>"/>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12">
                                <div class="col-md-3"><label for="home_address">Home address</label></div>
                                <div class="form-group col-md-8">
                                    <textarea class="form-control" id="home_address" name="home_address" size="100" cols="40" rows="5" placeholder="Enter home address" required=""><?php echo (set_value('home_address') != NULL) ? set_value('home_address') : (isset($tenant['home_address']) ? $tenant['home_address'] : ""); ?></textarea>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12">
                                <div class="col-md-3"><label for="district_id">Home district</label></div>
                                <div class="form-group col-md-4">
                                    <select name="district_id" id="district_id" class="form-control select2able" required="" data-required-error="District is required">
                                        <option>Select district...</option>
                                        <?php foreach ($districts as $district): ?>
                                            <option value="<?php echo $district['district_id']; ?>" <?php echo (set_select('district_id', $district['district_id']) != NULL) ? "selected" : ((isset($tenant['district_id']) && $tenant['district_id'] == $district['district_id']) ? "selected" : ""); ?>><?php echo $district['district']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <div class="col-md-4 col-md-offset-3">
                                <button type="submit" class="btn btn-primary"><?php echo isset($btn_text) ? $btn_text : "Submit"; ?></button>
                                <button type="reset" class="btn btn-default">Reset</button>
                            </div>
                        </div>
                        </form>
                    </div><!-- /.box -->

                </div><!--/.col (left) -->
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col-lg-12 -->
</div>   <!-- /.row -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#saveTenantForm').on('submit', function () {
            enableDisableButton(this, true);
        });
    });

</script>