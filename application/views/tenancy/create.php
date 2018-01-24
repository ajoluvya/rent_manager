    <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <!-- general form elements -->
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $sub_title; ?> &nbsp;<small><?php echo isset($step_text) ? "Step 2 0f 3" : ""; ?></small></h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php echo validation_errors("<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>", "</div>"); ?>

                    <?php $form_url = isset($btn_text) ? uri_string() : "tenancy/create"; ?>
                    <?php echo form_open($form_url, array('name' => 'create/update_tenancy', 'role' => 'form', 'data-toggle' => 'validator', 'id' => 'tenancyForm')); ?>
                    <div class="box-body">
                        <div class="col-md-8 col-md-offset-1">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label><a href="<?= site_url("tenant/view/" . (isset($tenant_id) ? $tenant_id : set_value('tenant_id'))) ?>" title="View <?php echo (isset($tenant)) ? $tenant['names'] : (isset($tenancy) ? $tenancy['names']:set_value('tenant_names')); ?> details"><i class="fa fa-angle-double-left"></i> &nbsp;<?php echo (isset($tenant)) ? $tenant['names'] : (isset($tenancy) ? $tenancy['names']:set_value('tenant_names')); ?></a></label>
                                    <input type="hidden" id="tenant_id" name="tenant_id" value="<?php echo (isset($tenant_id) ? $tenant_id : set_value('tenant_id')); ?>">
                                    <input type="hidden" id="tenant_names" name="tenant_names" value="<?php echo (isset($tenant)) ? $tenant['names'] : (isset($tenancy) ? $tenancy['names']:set_value('tenant_names')); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6"><label for="estate_id">Estate</label></div>
                                <div class="col-md-6">
                                    <select name="estate_id" data-bind="options: estates, optionsText: 'estate_name', optionsCaption: 'Select estate...', value: estate, optionsAfterRender: setOptionValue('estate_id')" class="form-control" required></select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6"><label for="house_id">Apartment/House/Room</label></div>
                                <div class="col-md-6">
                                    <select name="house_id" data-bind="options: filteredHouses(), optionsText: 'house_no', optionsCaption: 'Select house...', value: house, optionsAfterRender: setOptionValue('house_id')" class="form-control" required></select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <!-- ko with: house -->
                            <div class="form-group">
                                <div class="col-md-6"><label>Description</label></div>
                                <div class="col-md-6">
                                    <span data-bind="text: description">Billing Starts</span>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-6"><label>Billing Starts <sup><i class="fa fa-question-circle" title="An example is when a client comes in the middle of the month, and yet in the apartment it is preferred that the tenants uniformly pay at the beginning of each month. In this case, the tenant may pay an amount of money comensurate with the remaining days to the end of the month. Then the monthly billing commences effective 1st of the next month."></i></sup></label></div> 
                                <div class="col-md-6">
                                    <span data-bind="text: parseInt(period_starts)==1?(period_start_array[parseInt(time_interval_id)-1]+' the immediate full'):'Specified start'">Start</span> <span data-bind="text:parseInt(period_starts)==1?((time_intervals[parseInt(time_interval_id)-1]['description']).toString().slice(0,-1).toLocaleLowerCase()):period_start_array2[time_interval_id-1]">Period</span>
                                    <input type="hidden" data-bind="value: <?php echo (set_value('time_interval_id') != NULL) ? set_value('time_interval_id') : (isset($tenancy['time_interval_id']) ? $tenancy['time_interval_id'] : "time_interval_id"); ?>" id="time_interval_id" name="time_interval_id" />
                                    <input type="hidden" data-bind="value: <?php echo (set_value('billing_starts') != NULL) ? set_value('billing_starts') : (isset($tenancy['billing_starts']) ? $tenancy['billing_starts'] : "period_starts"); ?>" id="billing_starts" name="billing_starts" />
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <div class="col-md-6"><label for="rent_rate">Amount</label></div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><strong>UGX</strong></span>
                                        <input type="number" class="form-control" data-bind="value: fixed_amount,attr: {required:'required'}" id="rent_rate" name="rent_rate" value="<?php echo (set_value('rent_rate') != NULL) ? set_value('rent_rate') : (isset($tenancy['rent_rate']) ? $tenancy['rent_rate'] : ""); ?>" placeholder="Rent amount for this apartment" data-error="Missing amount" />
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <div class="col-md-6"><label for="billing_freq">Billing frequency</label></div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><strong>Every</strong></span>
                                        <input type="number" class="form-control" id="billing_freq" name="billing_freq" value="<?php echo (set_value('billing_freq') != NULL) ? set_value('billing_freq') : (isset($tenancy['billing_freq']) ? $tenancy['billing_freq'] : "1"); ?>" data-bind="attr: {required:'required'}" placeholder="How often the bill is generated" data-required-error="Billing frequency is required" />
                                        <span class="input-group-addon"><strong data-bind="text: (time_intervals[parseInt(time_interval_id)-1]['description']).toLocaleLowerCase()">month</strong></span>
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <!--/ko -->
                            <div class="form-group">
                                <div data-bind="css:{'col-md-3':(typeof house()=='undefined'||(typeof house()!='undefined'&&parseInt(house().time_interval_id)<3)),'col-md-6':((typeof house()!='undefined'&&parseInt(house().time_interval_id)>2))}"><label for="start_date">Entry date <sup><i class="fa fa-question-circle" title="The date and time of entry"></i></sup></label></div>
                                <div class="form-group" data-bind="css:{'col-md-3':(typeof house()=='undefined'||(typeof house()!='undefined'&&parseInt(house().time_interval_id)<3)),'col-md-6':((typeof house()!='undefined'&&parseInt(house().time_interval_id)>2))}">
                                        <input type="text" class="form-control datepicker" id="start_date" name="start_date" value="<?php echo (set_value('start_date') != NULL) ? set_value('start_date') : (isset($tenancy['start_date']) ? mdate("%d-%m-%Y", $tenancy['start_date']) : ""); ?>" placeholder="dd-mm-yyyy" data-required-error="Start date is required" data-pattern-error="Invalid format. Required format dd-mm-yyyy" pattern="^(((0[1-9]|[12]\d|3[01])-(0[13578]|1[02])-((19|[2-9]\d)\d{2}))|((0[1-9]|[12]\d|30)-(0[13456789]|1[012])-((19|[2-9]\d)\d{2}))|((0[1-9]|1\d|2[0-8])-02-((19|[2-9]\d)\d{2}))|(29-02-((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))$" data-provide="datepicker" required/>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <!-- ko if: typeof house()=='undefined'||(typeof house()!='undefined' && parseInt(house().time_interval_id)<3)-->
                                <div class="form-group col-md-2">
                                    <select class="form-control" id="hour_select" name="hour_select" data-required-error="hour is required">
                                        <option value="">-hr-</option>
                                        <?php for($i = 1; $i < 13; $i++): ?><option value="<?php echo sprintf("%02d", $i); ?>"><?php echo sprintf("%02d", $i); ?></option><?php endfor; ?>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group col-md-2">
                                    <select class="form-control" id="min_select" name="min_select" data-required-error="minute is required">
                                        <option value="">-min-</option>
                                        <?php for($i = 0; $i < 60; $i++): ?><option value="<?php echo sprintf("%02d", $i); ?>"><?php echo sprintf("%02d", $i); ?></option><?php endfor; ?>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group col-md-2">
                                    <select class="form-control" id="ampm_select" name="sec_select" data-required-error="select item">
                                        <option value="1">AM</option>
                                        <option value="2">PM</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <!-- /ko -->
                            </div>
                            <!--
                            <div class="form-group">
                                <div class="col-md-4"><label for="start_date">Entry date <sup><i class="fa fa-question-circle" title="The date and time of entry"></i></sup></label></div>
                                <div class="col-md-8">
                                    <div class="input-group date" id='datetimepicker2'>
                                        <input type="text" class="form-control" id="start_date" name="start_date" value="<?php echo (set_value('start_date') != NULL) ? set_value('start_date') : (isset($tenancy['start_date']) ? mdate("%d-%m-%Y %h:%i:%s", $tenancy['start_date']) : ""); ?>" placeholder="dd-mm-yyyy hh:mm:ss" data-required-error="Entry date is required" data-pattern-error="Invalid format. Required format dd-mm-yyyy hh:mm:ss" pattern="^(((0[1-9]|[12]\d|3[01])-(0[13578]|1[02])-((19|[2-9]\d)\d{2})\s((([01][0-9])|(2[0-3])):([0-5][0-9]):([0-5][0-9])))|((0[1-9]|[12]\d|30)-(0[13456789]|1[012])-((19|[2-9]\d)\d{2})\s((([01][0-9])|(2[0-3])):([0-5][0-9]):([0-5][0-9])))|((0[1-9]|1\d|2[0-8])-02-((19|[2-9]\d)\d{2})\s((([01][0-9])|(2[0-3])):([0-5][0-9]):([0-5][0-9])))|(29-02-((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))\s((([01][0-9])|(2[0-3])):([0-5][0-9]):([0-5][0-9]))))$" required/>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="form-group">
                              <div class="col-md-4"><label for="start_date">End date</label></div>
                              <div class="col-md-8"><div class="input-group"><input type="text" class="form-control datepicker" id="end_date" name="end_date" value="<?php echo (set_value('end_date') != NULL) ? set_value('end_date') : (isset($tenancy['end_date']) ? mdate("%d-%m-%Y", $tenancy['end_date']) : ""); ?>" placeholder="Optional, end date" data-validation="date" data-validation-error-msg="Not a date value" data-validation-format="dd-mm-yyyy" data-validation-optional="true" data-provide="datepicker"><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div></div>
                            </div>
                            -->
                        </div><!-- /.col-md-8 -->
                        <div class="col-md-2">
                            <?php if((isset($tenant['passport_photo']) && $tenant['passport_photo'] != '')||(isset($tenancy['passport_photo']) && $tenancy['passport_photo'] != '')): ?>
                            <img class="img-thumbnail img-responsive" src="<?php echo (isset($tenant)) ? (site_url("uploads/tenants").'/'.$tenant['passport_photo']) : (isset($tenancy['passport_photo']) ? (site_url("uploads/tenants").'/'.$tenancy['passport_photo']):''); ?>" />
                            <?php endif; ?>
                        </div><!--/.col-md-2 -->
                        <div class="box-footer">
                            <div class="col-md-3 col-md-offset-4">
                                <button type="submit" class="btn btn-primary"><?php echo isset($btn_text) ? $btn_text : "Submit"; ?></button>
                            </div>
                        </div>
                    </div><!--/.box-body -->
                    </form>
                </div><!-- /.box box-solid -->
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col-lg-12 -->
    </div>   <!-- /.row -->
    <script type="text/javascript">
        var time_intervals = <?php echo json_encode($time_intervals); ?>;
        $(document).ready(function () {
            var ViewModel = function () {
                var self = this;
                self.estate = ko.observable();
                self.house = ko.observable();
                self.estates = ko.observable(<?php echo json_encode($estates); ?>);
                self.houses = ko.observableArray(<?php echo json_encode($houses); ?>);

                self.filteredHouses = ko.computed(function () {
                    if (self.estate()) {
                        return ko.utils.arrayFilter(self.houses(), function (house) {
                            return (parseInt(self.estate().estate_id) == parseInt(house.estate_id));
                        });
                    }
                });
                //the amount is determined based on the previous selection
                self.amount = ko.observable();
                //set options value afterwards
                self.setOptionValue = function (propId) {
                    return function (option, item) {
                        if (item === undefined) {
                            option.value = "";
                        } else {
                            option.value = item[propId];
                        }
                    }
                };
            };
            var viewModel = new ViewModel();
            ko.applyBindings(viewModel);
            $('#tenancyForm').on('submit', function () {
                enableDisableButton(this, true);
            });

<?php if (isset($tenancy['estate_id']) || isset($_POST['estate_id'])): ?>
                var estate_id = <?= (isset($tenancy['estate_id']) ? $tenancy['estate_id'] : $_POST['estate_id']) ?>
                //we need to set the estate object accordingly
                viewModel.estate(ko.utils.arrayFirst(viewModel.estates(), function (currentEstate) {
                    return (estate_id == currentEstate.estate_id);
                }));
                $('#estate_id').val(estate_id).trigger('change');
<?php endif; ?>

<?php if (isset($tenancy['house_id']) || isset($_POST['house_id'])): ?>
                var house_id = <?= (isset($tenancy['house_id']) ? $tenancy['house_id'] : $_POST['house_id']) ?>
                //we need to set the house object accordingly
                viewModel.house(ko.utils.arrayFirst(viewModel.houses(), function (currentHouse) {
                    return (house_id == currentHouse.house_id);
                }));
                $('#house_id').val(house_id).trigger('change');
                <?php if(set_value('time_interval_id') != NULL) {?>
                     viewModel.house().time_interval_id = <?php echo set_value('time_interval_id'); ?> ;
                <?php }
                elseif(isset($tenancy['time_interval_id'])){ ?>
                     viewModel.house().time_interval_id = <?php echo $tenancy['time_interval_id']; ?>;
                <?php }
                ?>
<?php endif; ?>

<?php if ((isset($tenancy['rent_rate']) && is_numeric($tenancy['rent_rate'])) || (isset($_POST['rent_rate']) && is_numeric($_POST['rent_rate']))): ?>
                var rent_rate = <?= (isset($tenancy['rent_rate']) ? $tenancy['rent_rate'] : $_POST['rent_rate']) ?>
                //we need to set the house object accordingly
                //viewModel.house().rent_rate = rent_rate;
                $('#rent_rate').val(rent_rate);
<?php endif; ?>
        });

    </script>