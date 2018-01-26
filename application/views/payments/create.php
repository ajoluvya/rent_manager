<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-md-8 col-md-offset-2">
                    <!-- general form elements -->
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $sub_title; ?> &nbsp;<small><?php echo isset($step_text) ? "Step 3 0f 3" : ""; ?></small></h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <?php echo validation_errors("<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>", "</div>"); ?>
                        <?php echo form_open(uri_string(), array('name' => 'add_payment', 'role' => 'form', 'id' => 'payment_form')); ?>
                        <div class="box-body">
                            <div class="form-group">
                                <div class="col-md-6"><label for="acc_no">House/Apartment:</label></div>
                                <div class="col-md-6">
                                    <input type="hidden" id="house_id" name="house_id" value="<?php echo (isset($house_id)) ? $house_id : set_value('house_id'); ?>">
                                    <label class="control-label"><?php echo (isset($tenancy['house_no']) ? ("<a href=\"" . site_url("house/view/{$tenancy['house_id']}") . "\" title=\"" . $tenancy['house_no'] . " details\">" . $tenancy['house_no'] . "</a>") : ""); ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6"><label for="acc_no">Tenant:</label></div>
                                <div class="col-md-6">
                                    <input type="hidden" id="tenancy_id" name="tenancy_id" value="<?php echo (isset($tenancy['tenancy_id'])) ? $tenancy['tenancy_id'] : set_value('tenancy_id'); ?>">
                                    <label class="control-label"><?php echo (isset($tenancy['names']) ? ("<a href=\"" . site_url("tenant/view/{$tenancy['tenant_id']}") . "\" title=\"" . $tenancy['names'] . " details\">" . $tenancy['names'] . "</a>") : ""); ?></label>
                                </div>
                            </div>
                            <!--div class="form-group">
                              <div class="col-md-4"><label for="account_id">Account</label></div>
                              <div class="col-md-8">
                                                          <select id="account_id" name="account_id" class="form-control">
                                                                <option>Select...</option>
                            <?php foreach ($accounts as $account): ?>
                            <option value="<?php echo $account['acc_id']; ?>" <?php echo (set_select('account_id', $account['acc_id']) != NULL) ? "selected" : ((isset($payment['acc_id']) && $payment['acc_id'] == $account['acc_id']) ? "selected" : ""); ?>><?php echo $account['acc_no']; ?>, <?php echo $account['bank_name']; ?></option>
                            <?php endforeach; ?>
                                                          </select>
                                                  </div>
                            </div-->
                            <div class="form-group">
                                <div class="col-md-4"><label for="payment_date">Date paid</label></div>
                                <div class="col-md-8"><div class="input-group date"><input type="text" class="form-control datepicker" id="payment_date" name="payment_date" value="<?php echo (set_value('payment_date') != NULL) ? set_value('payment_date') : (isset($payment['payment_date']) ? mdate("%d-%m-%Y", $payment['payment_date']) : mdate("%d-%m-%Y")); ?>" placeholder="Enter payment date" data-validation="date" data-validation-error-msg="Not a date/missing payment date" data-validation-format="dd-mm-yyyy" data-provide="datepicker" ><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div></div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4"><label for="particulars">Particulars <small><i>(optional)</i></small></label></div>
                                <div class="col-md-8"><textarea class="form-control" id="particulars" name="particulars" rows="3" cols="80" size="100" placeholder="Enter payment particulars"><?php echo (set_value('particulars') != NULL) ? set_value('particulars') : (isset($payment['particulars']) ? $payment['particulars'] : ""); ?></textarea></div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4"><label for="rent_rate">Rate</label></div>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><strong>UGX</strong></span>
                                        <input type="text" class="form-control" value="<?php echo number_format($tenancy['rent_rate']); ?>" disabled />
                                        <input type="hidden" id="rent_rate" name="rent_rate" value="<?php echo $tenancy['rent_rate']; ?>" />
                                        <div class="input-group-addon"><strong>per</strong></div>
                                        <input type="text" class="form-control" data-bind="value: '<?php echo number_format($tenancy['billing_freq']); ?> ' + (time_intervals[<?php echo $tenancy['time_interval_id']-1; ?>]['description']).toLocaleLowerCase()" disabled />
                                    </div>
                                </div>
                            </div>
                            <?php if($tenancy['billing_starts'] == 2 ):  //billing starts on the specified week/month/hour/day ?>
                            <div class="form-group">
                                <div class="col-md-4"><label for="start_date">Payment for</label></div>
                                <div class="col-md-8">
                                    <div class="input-group input-daterange">
                                        <input type="text" placeholder="Start date" name="start_date1" id="start_date1" disabled class="form-control" data-bind="value: moment(start_date(),'X').format('DD-MMM-YYYY'+(<?php echo $tenancy['time_interval_id']-1; ?><3?' hh:mm A':''))" />
                                        <input type="hidden" name="start_date" data-bind="value: start_date" />
                                        <div class="input-group-addon"><strong>to</strong></div>
                                        <input type="text" placeholder="End date" name="end_date1" id="end_date1" disabled class="form-control" data-bind="value: end_date().format('DD-MMM-YYYY')" />
                                        <input type="hidden" name="end_date" data-bind="value: end_date().format('X')" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4"><label for="no_of_periods"><?php echo $tenancy['period_desc']; ?>/Total Amount</label></div>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="number" data-bind="textInput:no_of_periods, attr: {placeholder: 'No of '+('<?php echo $tenancy['period_desc']; ?>').toLocaleLowerCase()}" class="form-control" id="no_of_periods" name="no_of_periods" data-min="1" data-error-min="Not a number" />
                                        <span class="input-group-addon"><strong>UGX:</strong> </span>
                                        <div class="input-group-addon" data-bind="text:curr_format(total_amount())"></div>
                                        <input type="hidden" data-bind="value:total_amount" id="amount" name="amount" />
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if($tenancy['billing_starts'] == 1 ): //billing starts on the first day/minute/hour of the week/month/hour/day?>
                            <div class="form-group">
                                <div class="col-md-4"><label for="start_date">Payment for</label></div>
                                <div class="col-md-8">
                                    <div class="input-group input-daterange">
                                        <input type="text" placeholder="Start date" name="start_date1" id="start_date1" disabled class="form-control" data-bind="value: moment(start_date(),'X').format(<?php echo $tenancy['time_interval_id']; ?>===4?'MMMM-YYYY':('DD-MMM-YYYY'+(<?php echo $tenancy['time_interval_id']; ?><3?' hh:mm A':'')))" />
                                        <input type="hidden" name="start_date" data-bind="value: start_date" />
                                        <input type="hidden" name="end_date" data-bind="value: end_date().format('X')" />
                                    </div>
                                </div>
                            </div>
                            <!-- ko if:(s_date != e_date) -->
                            <div class="form-group">
                                <div class="col-md-4"><label for="no_of_periods"><?php echo $tenancy['period_desc']; ?>/Total Amount</label></div>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="number" data-bind="textInput:no_of_periods, attr: {placeholder: 'No of '+('<?php echo $tenancy['period_desc']; ?>').toLocaleLowerCase()}" class="form-control" id="no_of_periods" name="no_of_periods" min="1" data-error-min="Should be more than 0" />
                                        <span class="input-group-addon"><strong>UGX:</strong> </span>
                                        <div class="input-group-addon" data-bind="text:curr_format(total_amount())"></div>
                                        <input type="hidden" data-bind="value:total_amount" id="amount" name="amount" />
                                    </div>
                                </div>
                            </div>
                            <!-- /ko -->
                            <!-- ko if:(s_date == e_date) -->
                            <div class="form-group">
                                <div class="col-md-4"><label for="amount">Amount paid</label></div>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><strong>UGX:</strong> </span>
                                        <input type="number" class="form-control" data-bind="attr: {value:parseInt(total_amount()/<?php echo $tenancy['billing_freq']; ?>), max: parseInt(total_amount()/<?php echo $tenancy['billing_freq']; ?>), 'data-max-error':'Amount can not exceed '+ curr_format(parseInt(total_amount()/<?php echo $tenancy['billing_freq']; ?>))}" id="amount" name="amount" min="0" data-min-error="Cannot be less than 0" />
                                        <input type="hidden" data-bind="value:no_of_periods" id="amount" name="no_of_periods" />
                                        <div class="input-group-addon"><strong><?php echo $tenancy['adjective']; ?> rate</strong></div>
                                        <div class="input-group-addon" data-bind="text:curr_format(parseInt(total_amount()/<?php echo $tenancy['billing_freq']; ?>))"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- /ko -->
                            <?php endif; ?>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <div class="col-md-3 col-md-offset-4">
                                <button type="submit" class="btn btn-primary"><?php echo isset($btn_text) ? $btn_text : "Submit"; ?></button>
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
    var time_intervals = <?php echo json_encode($time_intervals); ?>;
    $(document).ready(function () {
        var PaymentModel = function () {
            var self = this;
            self.s_date = "<?php echo $tenancy['start_date']; ?>";
            self.e_date = "<?php echo $tenancy['end_date']; ?>";
            self.start_date = ko.observable("<?php echo ((isset($tenancy['end_date']) && $tenancy['end_date'] != "") ? $tenancy['end_date'] : $tenancy['start_date']); ?>");

            self.no_of_periods = ko.observable(<?php echo ((isset($payment['no_of_periods']) && is_numeric($payment['no_of_periods'])) ? $payment['no_of_periods'] : 1); ?>);
            
            if(self.s_date === self.e_date && <?php echo $tenancy['billing_starts']; ?> === 1 ){ //we can tell, at this point, that its the first payment to be made
                //based on the time interval id, the start time, we are able to push the time to the start point of the next hour/day/week/month/quarter
                switch(<?php echo $tenancy['time_interval_id']; ?>){
                    case 1: // for hourly rent rates
                        var start_time = moment(self.start_date(),'X');
                        var minutes = start_time.minute();
                        start_time.add(60-minutes,'m');
                        start_time.startOf('hour');
                        self.start_date(start_time.format('X'));
                        break;
                    case 2: // for daily rent rates
                        var start_time = moment(self.start_date(),'X');
                        var hours = start_time.hour();
                        start_time.add(24-hours,'h');
                        start_time.startOf('day');
                        self.start_date(start_time.format('X'));
                        break;
                    case 3: // for weekly rent rates
                        var start_time = moment(self.start_date(),'X');
                        var day = start_time.day();
                        start_time.add(7-day+1,'d');
                        start_time.startOf('week');
                        self.start_date(start_time.format('X'));
                        break;
                    case 4: // for monthly rent rates
                        var start_time = moment(self.start_date(),'X');
                        var date_month = start_time.date();
                        start_time.add(start_time.daysInMonth()-date_month+1,'d');
                        start_time.startOf('month');
                        self.start_date(start_time.format('X'));
                        break;
                    case 5: // for quarterly rent rates
                        var start_time = moment(self.start_date(),'X');
                        var startOf_qtr = moment(self.start_date(),'X').startOf('quarter');
                        if(startOf_qtr.isBefore(start_time, 'day')){
                            start_time.add(1,'Q');
                        }
                        start_time.startOf('quarter');
                        self.start_date(start_time.format('X'));
                        break;
                }
            }
            self.total_amount = ko.computed(function () {
                var rent_rate = <?php echo $tenancy['rent_rate']; ?>;
                if (self.no_of_periods()) {
                    return self.no_of_periods() * parseFloat(rent_rate);
                } else
                    return rent_rate;
            });

            self.end_date = ko.computed(function () {
                return moment(self.start_date(), 'X').add(self.no_of_periods()*<?php echo $tenancy['billing_freq']; ?>-1, '<?php echo $tenancy['label']; ?>').endOf('<?php echo $tenancy['period_desc']; ?>');
            });
        };
        ko.applyBindings(new PaymentModel());
        $('#payment_form').on('submit', function () {
            enableDisableButton(this, true);
        });
    });
</script>