<div class="row">
    <!-- left column -->
    <div class="col-md-6 col-md-offset-3">
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
                    <div class="col-md-8"><div class="input-group"><input type="text" class="form-control datepicker" id="payment_date" name="payment_date" value="<?php echo (set_value('payment_date') != NULL) ? set_value('payment_date') : (isset($payment['payment_date']) ? mdate("%d-%m-%Y", $payment['payment_date']) : mdate("%d-%m-%Y")); ?>" placeholder="Enter payment date" data-validation="date" data-validation-error-msg="Not a date/missing payment date" data-validation-format="dd-mm-yyyy" data-provide="datepicker" ><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div></div>
                </div>
                <div class="form-group">
                    <div class="col-md-4"><label for="particulars">Particulars <small><i>(optional)</i></small></label></div>
                    <div class="col-md-8"><textarea class="form-control" id="particulars" name="particulars" rows="3" cols="80" size="100" placeholder="Enter payment particulars"><?php echo (set_value('particulars') != NULL) ? set_value('particulars') : (isset($payment['particulars']) ? $payment['particulars'] : ""); ?></textarea></div>
                </div>
                <div class="form-group">
                    <div class="col-md-4"><label for="rent_rate">Rent rate</label></div>
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon">UGX</span>
                            <input type="text" class="form-control" value="<?php echo number_format($tenancy['rent_rate']); ?>" disabled />
                            <input type="hidden" id="rent_rate" name="rent_rate" value="<?php echo $tenancy['rent_rate']; ?>" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4"><label for="start_date">Start/End Date</label></div>
                    <div class="col-md-8">
                        <div class="input-group input-daterange">
                            <input type="text" placeholder="Start date" disabled class="form-control" data-bind="value: moment(start_date(),'YYYY-MM-DD').format('DD-MMM-YYYY')" />
                            <input type="hidden" name="start_date" data-bind="value: start_date" />
                            <div class="input-group-addon">to</div>
                            <input type="text" placeholder="End date" disabled class="form-control" data-bind="value: end_date().format('DD-MMM-YYYY')" />
                            <input type="hidden" name="end_date" data-bind="value: end_date().format('YYYY-MM-DD')" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4"><label for="no_of_months">Months/Total Amount</label></div>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="number" data-bind="textInput:no_of_months" class="form-control" id="no_of_months" name="no_of_months" placeholder="No of months" data-validation="number" data-validation-min="1" data-validation-error-msg="Not a number" />
                            <span class="input-group-addon">UGX: </span>
                            <div class="input-group-addon" data-bind="text:curr_format(total_amount())"></div>
                            <input type="hidden" data-bind="value:total_amount" id="amount" name="amount" />
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary"><?php echo isset($btn) ? $btn : "Submit"; ?></button>
            </div>
            </form>
        </div><!-- /.box -->

    </div><!--/.col (left) -->
</div>   <!-- /.row -->
<script type="text/javascript">
    $(document).ready(function () {
        var PaymentModel = function () {
            var self = this;
            var s_date = "<?php echo mdate('%Y-%m-%d', $tenancy['end_date']); ?>";

            self.start_date = ko.observable('<?php echo mdate('%Y-%m-%d', ((isset($tenancy['end_date']) && $tenancy['end_date'] != "") ? $tenancy['end_date'] : $tenancy['start_date']));
                ; ?>');

            self.no_of_months = ko.observable(<?php echo ((isset($payment['no_of_months']) && is_numeric($payment['no_of_months'])) ? $payment['no_of_months'] : 1); ?>);

            self.total_amount = ko.computed(function () {
                var rent_rate = <?php echo $tenancy['rent_rate']; ?>;
                if (self.no_of_months()) {
                    return self.no_of_months() * parseFloat(rent_rate);
                } else
                    return rent_rate;
            });

            self.end_date = ko.computed(function () {
                return moment(self.start_date(), 'YYYY-MM-DD').add(self.no_of_months(), 'M');
            });
        };
        ko.applyBindings(new PaymentModel());
        $('#payment_form').on('submit', function () {
            enableDisableButton(this, true);
        });
    });
</script>