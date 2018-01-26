<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-lg-10 col-lg-offset-1">
                    <!-- general form elements -->
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $sub_title; ?> <small>All fields with asterisks (*) are required.</small></h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <?php echo validation_errors("<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>", "</div>"); ?>
                        <?php echo form_open(uri_string(), array('name' => 'estateCreation', 'id' => 'estateCreationForm', 'data-toggle' => 'validator', 'role' => 'form')); ?>
                        <div class="box-body">
                            <fieldset>
                                <legend>Estate Details</legend>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="col-md-4"><label for="estate_name">Estate Name *</label></div>
                                        <div class="col-md-8"><input type="text" class="form-control" id="estate_name" name="estate_name" value="<?php echo (set_value('estate_name') != NULL) ? set_value('estate_name') : (isset($estate['estate_name']) ? $estate['estate_name'] : ""); ?>" placeholder="Estate name" required></div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group">
                                        <div class="col-md-4"><label for="description">Description *</label></div>
                                        <div class="col-md-8"><textarea class="form-control" id="description" name="description" rows="3" cols="80" placeholder="Brief description of the estate" required><?php echo (set_value('description') != NULL) ? set_value('description') : (isset($estate['description']) ? $estate['description'] : ""); ?></textarea></div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group">
                                        <div class="col-md-4"><label for="phone">Telephone *</label></div>
                                        <div class="col-md-8"><input type="text" pattern="^(0|\+256)[2347]([0-9]{8})" class="form-control" id="phone" name="phone" value="<?php echo (set_value('phone') != NULL) ? set_value('phone') : (isset($estate['phone']) ? $estate['phone'] : ""); ?>" placeholder="Telephone number" required></div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group">
                                        <div class="col-md-4"><label for="phone2">2nd Telephone</label></div>
                                        <div class="col-md-8"><input type="text" pattern="^(0|\+256)[2347]([0-9]{8})" class="form-control" id="phone2" name="phone2" value="<?php echo (set_value('phone2') != NULL) ? set_value('phone2') : (isset($estate['phone2']) ? $estate['phone2'] : ""); ?>" placeholder="Optional, second telephone number"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="col-md-3"><label for="address">Address *</label></div>
                                        <div class="col-md-9">
                                            <textarea class="form-control" id="address" name="address" rows="3" placeholder="Estate address" required><?php echo (set_value('address') != NULL) ? set_value('address') : (isset($estate['address']) ? $estate['address'] : ""); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3"><label for="district">District *</label></div>
                                        <div class="col-md-9">
                                            <select id="district" name="district" class="form-control select2able" required>
                                                <option>Select district...</option>
                                                <?php foreach ($districts as $district): ?>
                                                    <option value="<?php echo $district['district_id']; ?>" <?php echo (set_select('district_id', $district['district_id']) != NULL) ? "selected" : ((isset($estate['district_id']) && $estate['district_id'] == $district['district_id']) ? "selected" : ""); ?>><?php echo $district['district']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Default Tenancy Terms</legend>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="billing_freq">Billing Frequency *</label>
                                        <div class="input-group"><span class="input-group-addon">Every</span><input type="number" class="form-control" id="billing_freq" name="billing_freq" value="<?php echo (set_value('billing_freq') != NULL) ? set_value('billing_freq') : (isset($estate['billing_freq']) ? $estate['billing_freq'] : 1); ?>" required/>
                                        </div>
                                        <div class="help-block with-errors"><i>How often the bill is generated</i></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label"  for="time_interval_id">&nbsp;&nbsp;</label>
                                        <select class="form-control" id="time_interval_id" name="time_interval_id" data-bind='options:time_intervals, optionsText: "description", optionsCaption: "-- Select --", optionsAfterRender: setOptionValue("id"), value: rent_period' required></select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <!-- ko with: rent_period -->
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <div class="col-md-3"><label class="control-label" for="estate_name">Billing happens at/on*</label></div>
                                        <div class="col-md-9">
                                            <label class="radio-inline"><input type="radio" id="period_starts1" name="period_starts" value="1" <?php echo (set_value('period_starts') != NULL && set_value('period_starts') == 1) ? "checked" : (isset($estate['period_starts']) && $estate['period_starts'] == 1 ? "checked" : ""); ?> required/><span data-bind="text: period_start_array[id-1]">Start</span> billing <span data-bind="text:description.toString().slice(0,-1).toLocaleLowerCase()">Period</span></label>                               
                                            <label class="radio-inline"><input type="radio" id="period_starts2" name="period_starts" value="2"<?php echo (set_value('period_starts') != NULL && set_value('period_starts') == 2 ) ? "checked" : (isset($estate['period_starts']) && $estate['period_starts'] == 2 ? "checked" : ""); ?> required/>Specified <span data-bind="text:period_start_array2[id-1]">moment</span></label>                                
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /ko -->
                            </fieldset>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <div class="col-md-4 col-md-offset-3">
                                <button type="submit" class="btn btn-primary"><?php echo isset($btn_text) ? $btn_text : "Submit"; ?></button>
                                <button type="reset" class="btn btn-default">Reset</button>
                            </div>
                        </div>
                        </form>
                    </div><!-- /.box -->
                </div><!--/.col-lg-10 col-lg-offset-1 -->
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col-lg-12 -->
</div>   <!-- /.row -->
<script type="text/javascript">
    $(document).ready(function () {
        var EstateModel = function () {
            var self = this;
            self.rent_period = ko.observable();
            self.time_intervals = ko.observableArray(<?php echo json_encode($time_intervals);?>);
            
        };
        var estateModel = new EstateModel();
        ko.applyBindings(estateModel);
        
        $('#estateCreationForm').on('submit', function () {
            enableDisableButton(this, true);
        });
    <?php if (set_value('time_interval_id') != NULL) { ?>
            $('#time_interval_id').val(<?php echo set_value('time_interval_id'); ?>).trigger('change');
    <?php
} else {
    if (isset($estate['time_interval_id']) && is_numeric($estate['time_interval_id'])) {
        ?>
                $('#time_interval_id').val(<?php echo $estate['time_interval_id']; ?>).trigger('change');
        <?php
    }
}
?>
    });
</script>