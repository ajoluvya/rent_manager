<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo $sub_title; ?> <small>All fields with asterisks (<span class="text-danger">*</span>) are required.</small></h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <?php if(!isset($estate)){echo validation_errors("<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>", "</div>");} ?>
    <?php echo form_open(uri_string(), array('name' => 'saveHouseForm', 'id' => 'saveHouseForm', 'data-toggle' => 'validator', 'role' => 'form')); ?>
    <div class="box-body">
        <fieldset>
            <legend>House/Room Particulars</legend>
            <div class="col-lg-6">
                <input type="hidden" id="house_id" name="house_id" />
                <?php if(isset($estate)):?>
                <input type="hidden" id="estate_id" name="estate_id" value="<?php echo $estate['estate_id']; ?>" />
                <?php else:?>
                <div class="form-group">
                    <label class="control-label" for="estate_id">Estate *</label>
                    <select id="estate_id" name="estate_id" class="form-control" data-bind='options:estates, optionsText: "estate_name", optionsCaption: "-- Select estate --", optionsAfterRender: setOptionValue("estate_id"), value: estate' required>
                    </select>
                    <div class="help-block with-errors"></div>
                </div>
                <?php endif;?>
                <div class="form-group">
                    <label class="control-label" for="house_no">Apartment/House/Room No *</label>
                    <input type="text" class="form-control" id="house_no" name="house_no" value="<?php echo (set_value('house_no') != NULL) ? set_value('house_no') : (isset($house['house_no']) ? $house['house_no'] : ""); ?>" placeholder="E.g Room 21" required />
                </div>
                <div class="form-group">
                    <label class="control-label" for="floor">Floor *</label>
                    <select id="floor" name="floor" class="form-control" required>
                        <?php foreach ($floors as $key => $floor): ?>
                            <option value="<?php echo $key; ?>" <?php echo (set_select('floor', $key) != NULL) ? "selected" : ((isset($house['floor']) && $key == $house['floor']) ? "selected" : ""); ?>><?php echo $floor; ?> floor</option>
                        <?php endforeach; ?>
                    </select>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="floor">Max number of occupants</label>
                    <input type="number" class="form-control" id="max_tenants" name="max_tenants" value="<?php echo (set_value('max_tenants') != NULL) ? set_value('max_tenants') : (isset($house['max_tenants']) ? $house['max_tenants'] : 1); ?>" placeholder="Maximum number of tenants at a given time" required />
                    <div class="help-block with-errors"></div>
                </div>
            </div><!--./col-lg-6 -->
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="control-label" for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="5" cols="40" placeholder="Optional, brief description for the apartment/house/room"><?php echo (set_value('description') != NULL) ? set_value('description') : (isset($house['description']) ? $house['description'] : ""); ?></textarea>
                    <div class="help-block with-errors"></div>
                </div>
            </div><!--./col-lg-6 -->
        </fieldset>
        <fieldset>
            <legend>Default Tenancy Terms</legend>
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="control-label" for="fixed_amount">Rent rate*</label>
                    <div class="input-group"><span class="input-group-addon">UGX</span><input type="number" class="form-control" id="fixed_amount" name="fixed_amount" value="<?php echo (set_value('fixed_amount') != NULL) ? set_value('fixed_amount') : (isset($house['fixed_amount']) ? $house['fixed_amount'] : ""); ?>" placeholder="Rent amount" data-required-error="Rent rate is required" required></div>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="estate_name">Billing Frequency *</label>
                    <div class="input-group"><span class="input-group-addon">Every</span><input type="number" class="form-control" id="billing_freq" name="billing_freq" value="<?php echo (set_value('billing_freq') != NULL) ? set_value('billing_freq') : (isset($house['billing_freq']) ? $house['billing_freq'] : 1); ?>" required/></div>
                </div>
                <div class="help-block with-errors"><i>How often the bill is generated</i></div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="control-label"  for="time_interval_id">&nbsp;&nbsp;</label>
                    <select class="form-control" id="time_interval_id" name="time_interval_id" data-bind='options:time_intervals, optionsText: "description", optionsCaption: "-- Select --", optionsAfterRender: setOptionValue("id"), value: time_interval' required>
                    </select>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-lg-12">
                <div class="form-group" data-bind="with: time_interval">
                    <label class="control-label col-md-3" for="period_starts">Billing happens at/on*</label>
                    <div class="col-md-9">
                        <label class="radio-inline"><input type="radio" name="period_starts" value="1" <?php echo (set_value('period_starts') != NULL && set_value('period_starts') == 1) ? "checked" : (isset($house['period_starts']) && $house['period_starts'] == 1 ? "checked" : ""); ?> required/><span data-bind="text: period_start_array[id-1]">Start</span> billing <span data-bind="text:description.toString().slice(0,-1).toLocaleLowerCase()">Period</span></label>                               
                        <label class="radio-inline"><input type="radio" name="period_starts" value="2"<?php echo (set_value('period_starts') != NULL && set_value('period_starts') == 2 ) ? "checked" : (isset($house['period_starts']) && $house['period_starts'] == 2 ? "checked" : ""); ?> required/>Specified <span data-bind="text:period_start_array2[id-1]">moment</span></label>                                
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div><!-- /.box-body -->

    <div class="box-footer">
        <div class="col-md-4 col-md-offset-4">
            <button type="submit" class="btn btn-primary"><?php echo isset($btn_text) ? $btn_text : "Submit"; ?></button>
            <button type="reset" class="btn btn-default">Reset</button>
        </div>
    </div>
</form>
</div><!-- /.box -->