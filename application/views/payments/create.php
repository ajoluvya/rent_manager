<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-lg-10 col-lg-offset-1">
                    <!-- general form elements -->
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $sub_title; ?> &nbsp;<small><?php echo isset($step_text) ? "Step 3 0f 3" : ""; ?></small></h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <?php echo validation_errors("<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>", "</div>"); ?>
                        <?php echo form_open(uri_string(), array('name' => 'add_payment', 'role' => 'form', 'id' => 'payment_form')); ?>
                        <div class="box-body">
                            <?php if(isset($tenancies)): ?>
                            <div class="col-lg-12">
                                <div class="col-md-4"><label for="tenancy_id">Tenant:</label></div>
                                <div class="form-group col-md-8">
                                    <select name="tenancy_id" id="tenancy_id" data-bind="options: tenancies, optionsText: function(item){return item.names + ' (' + item.house_no + ', ' + item.estate_name + ')'}, optionsCaption: 'Select tenant...', value: tenancy, optionsAfterRender: setOptionValue('tenancy_id')" class="form-control select2able" required></select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if(isset($tenancy)): ?>
                            <div class="col-lg-12">
                                <div class="col-md-4"><label for="tenancy_id">Tenant:</label></div>
                                <div class="form-group col-md-8">
                                    <input type="hidden" id="tenancy_id" name="tenancy_id" value="<?php echo (isset($tenancy['tenancy_id'])) ? $tenancy['tenancy_id'] : set_value('tenancy_id'); ?>">
                                    <label class="control-label"><?php echo (isset($tenancy['names']) ? ("<a href=\"" . site_url("tenant/view/{$tenancy['tenant_id']}") . "\" title=\"" . $tenancy['names'] . " details\">" . $tenancy['names'] . "</a>") : ""); ?></label>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="clearfix"></div>
                            <div class="col-lg-12">
                                <div class="col-md-4"><label for="house_no">Room/House/Apartment:</label></div>
                                <div class="form-group col-md-8" data-bind="with: tenancy">
                                    <label class="control-label"><a title="View apartment/house/room details" data-bind="attr:{href:'<?php echo site_url("house/view"); ?>/'+house_id}, text: house_no + ', ' + estate_name"></a></label>
                                </div>
                            </div>
                            <div class="clearfix"></div>
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
                            <div class="col-lg-12">
                                <div class="col-md-4"><label for="payment_date">Date of payment</label></div>
                                <div class="form-group col-md-4"><div class="input-group date"><input type="text" class="form-control datepicker" id="payment_date" name="payment_date" value="<?php echo (set_value('payment_date') != NULL) ? set_value('payment_date') : (isset($payment['payment_date']) ? mdate("%d-%m-%Y", $payment['payment_date']) : mdate("%d-%m-%Y")); ?>" placeholder="Enter payment date" data-validation="date" data-validation-error-msg="Not a date/missing payment date" data-validation-format="dd-mm-yyyy" data-provide="datepicker" ><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div></div>
                            </div>
                            <!-- ko with:tenancy -->
                            <div class="col-lg-12">
                                <div class="col-md-4"><label for="rent_rate">Rate</label></div>
                                <div class="form-group col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><strong>UGX</strong></span>
                                        <input type="text" class="form-control" data-bind="value: curr_format(parseFloat(rent_rate)*1)" disabled />
                                        <input type="hidden" id="rent_rate" name="rent_rate" data-bind="value:rent_rate" />
                                        <div class="input-group-addon"><strong>per</strong></div>
                                        <input type="text" class="form-control" data-bind="value: billing_freq + ' ' + (period_desc).toLocaleString().toLocaleLowerCase()" disabled />
                                    </div>
                                </div>
                            </div>
                                <!-- ko foreach:$parent.paid_for_periods() -->
                                    <!-- ko if:$parent.billing_starts == 2 --><!--  //billing starts on the specified week/month/hour/day -->
                                    <div class="col-lg-12">
                                        <div class="col-md-4"><label for="start_date">Schedule <span data-bind="text: $index()+1"></span></label></div>
                                        <div class="form-group col-md-5">
                                            <div class="input-group input-daterange">
                                                <input type="text" placeholder="Start date" name="start_date1" disabled class="form-control" data-bind="value: $root.getEndDate($index()).format('DD-MMM-YYYY'+((parseInt($parent.time_interval_id)-1)<3?' hh:mm A':''))" />
                                                <input type="hidden" data-bind="value: $root.getEndDate($index()).format('X'), attr: {name:'payment['+$index()+'][start_date]'}" />
                                                <div class="input-group-addon"><strong>to</strong></div>
                                                <input type="text" placeholder="End date" name="end_date1" disabled class="form-control" data-bind="value: $root.getEndDate($index()+1).format('DD-MMM-YYYY'+((parseInt($parent.time_interval_id)-1)<3?' hh:mm A':''))" />
                                                <input type="hidden" data-bind="value: $root.getEndDate($index()+1).format('X'), attr: {name:'payment['+$index()+'][end_date]'}" />
                                                <input type="hidden" data-bind="value: payment_id" />
                                                <input type="hidden" data-bind="value: id" />
                                            </div>
                                        </div>
                                        <div class="col-md-2"><input type="number" class="form-control" data-bind="textInput: amount_paid, attr: {name:'payment['+$index()+'][amount]'}, visible: amount_paid(parseFloat($parent.rent_rate)*1)" /></div>
                                        <div class="col-md-1"><span class="text-danger" style="cursor: pointer" data-bind="click:$root.removePaidForPeriod, visible:$index()>0"><i class="fa fa-minus-circle"></i></span></div>
                                    </div>
                                    <!-- /ko -->
                                    <!-- ko if:$parent.billing_starts == 1 --> <!--  //billing starts on the first day/minute/hour of the week/month/hour/day -->
                                    <div class="col-lg-12">
                                        <div class="col-md-4"><label for="start_date1">Schedule <span data-bind="text: $index()+1"></span></label></div>
                                        <div class="form-group col-md-4">
                                            <input type="text" placeholder="Start date" name="start_date1" disabled class="form-control" data-bind="value: $root.getEndDate($index()).format(parseInt($parent.time_interval_id)===4?'MMMM-YYYY':('DD-MMM-YYYY'+(parseInt($parent.time_interval_id)<3?' hh:mm A':'')))" />
                                        </div>
                                        <div class="form-group col-md-3">
                                            <input type="number" class="form-control" data-bind="textInput: amount_paid, attr: {name:'payment['+$index()+'][amount]'}, visible: amount_paid(parseFloat($parent.rent_rate)*1)" /><!-- (typeof amount_paid() === 'undefined'?amount_paid(parseFloat($parent.rent_rate)*1):true)  -->
                                            <input type="hidden" data-bind="value: moment($root.start_date(),'X').format('X'), attr: {name:'payment['+$index()+'][start_date]'}" />
                                            <input type="hidden" data-bind="value: $root.getEndDate($index()+1).format('X'), attr: {name:'payment['+$index()+'][end_date]'}" />
                                            <input type="hidden" data-bind="value: payment_id" />
                                            <input type="hidden" data-bind="value: id" />
                                        </div>
                                        <div class="col-md-1"><span class="text-danger" style="cursor: pointer" data-bind="click:$root.removePaidForPeriod, visible:$index()>0"><i class="fa fa-minus-circle"></i></span></div>
                                    </div>
                                    <!-- /ko -->
                                <!-- /ko -->
                            <div class="col-lg-12">
                                <div class="col-md-4"><label>Total <span data-bind="text: period_desc"> </span>/Amount</label></div>
                                <div class="col-md-4">
                                        <span><strong data-bind="text:$parent.paid_for_periods().length*billing_freq + ' '+ (period_desc).toLocaleString().toLocaleLowerCase()"></strong></span>
                                </div>
                                <div class="col-md-3">
                                        <span><strong>UGX:</strong> <strong data-bind="text:curr_format($parent.total_amount_paid())"></strong></span>
                                        <input type="hidden" data-bind="value:$parent.total_amount_paid()" id="amount" name="amount" />
                                </div>
                                <div class="col-md-1">
                                    <span data-bind="click:$root.addPaidForPeriod, attr:{title:'Add more '+ (period_desc).toLocaleString().toLocaleLowerCase()}" class="text-primary" style="cursor: pointer"><i class="fa fa-plus-circle"></i></span>
                                </div>
                            </div>
                            <!-- /ko -->
                            <div class="col-lg-12">
                                <div class="col-md-4"><label for="particulars">Notes <small><i>(optional)</i></small></label></div>
                                <div class="form-group col-md-8"><textarea class="form-control" id="particulars" name="particulars" rows="3" cols="80" size="100" placeholder="Payment notes..."><?php echo (set_value('particulars') != NULL) ? set_value('particulars') : (isset($payment['particulars']) ? $payment['particulars'] : ""); ?></textarea></div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <div class="col-md-3 col-md-offset-4">
                                <button type="submit" class="btn btn-primary"><?php echo isset($btn_text) ? $btn_text : "Submit"; ?></button>
                            </div>
                        </div>
                        </form>
                    </div><!-- /.box -->
                </div><!--/.col-lg-8 col-lg-offset-2 -->
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col-lg-12 -->
</div>   <!-- /.row -->
<script type="text/javascript">
    var time_intervals = <?php echo json_encode($time_intervals); ?>;
    var paymentModel = {};
    $(document).ready(function () {
        var PaidForPeriod = function(payment) {
            var self = this;
            self.amount_paid = ko.observable(typeof payment != 'undefined'? payment.amount:null);
            self.db_entry = ko.observable();
            self.id = ko.observable(typeof payment != 'undefined'? payment.id:null);
            self.payment_id = ko.observable(typeof payment != 'undefined'? payment.payment_id:null);
        };
        var PaymentModel = function () {
            var self = this;
            self.tenancy = ko.observable(<?php echo isset($tenancy)?json_encode($tenancy):''; ?>);
            self.tenancies = ko.observableArray(<?php echo isset($tenancies)?json_encode($tenancies):''; ?>);
            
            self.no_of_periods = ko.observable(<?php echo ((isset($payment['no_of_periods']) && is_numeric($payment['no_of_periods'])) ? $payment['no_of_periods'] : 1); ?>);
            self.paid_for_periods = ko.observableArray([new PaidForPeriod()]);
            
            self.start_date = ko.pureComputed(function () {
                if(typeof self.tenancy()!= 'undefined' && (self.tenancy().start_date === self.tenancy().end_date && self.tenancy().billing_starts == 1) ){ //we can tell, at this point, that its the first payment to be made
                    //based on the time interval id, the start time, we are able to push the time to the start point of the next hour/day/week/month/quarter
                    switch(parseInt(self.tenancy().time_interval_id)){
                        case 1: // for hourly rent rates
                            /*var start_time = moment(self.tenancy().end_date,'X');
                            var minutes = start_time.minute();
                            if(minutes>1){
                                start_time.add(60-minutes,'m');
                            }*/
                            return moment(self.tenancy().end_date,'X').startOf('hour').format('X');
                            break;
                        case 2: // for daily rent rates
                            /*var start_time = moment(self.tenancy().end_date,'X');
                            var hours = start_time.hour();
                            if(hours>1){
                                start_time.add(24-hours,'h');
                            }*/
                            return moment(self.tenancy().end_date,'X').startOf('day').format('X');
                            break;
                        case 3: // for weekly rent rates
                            /*var start_time = moment(self.tenancy().end_date,'X');
                            var day = start_time.day();
                            if(day>1){
                                start_time.add(7-day+1,'d');
                            }*/
                            return moment(self.tenancy().end_date,'X').startOf('week').format('X');
                            break;
                        case 4: // for monthly rent rates
                            /*var start_time = moment(self.tenancy().end_date,'X');
                            var date_month = start_time.date();
                            if(date_month>1){
                                start_time.add(start_time.daysInMonth()-date_month+1,'d');
                                start_time.startOf('month');
                            }*/
                            return moment(self.tenancy().end_date,'X').startOf('month').format('X');
                            break;
                        case 5: // for quarterly rent rates
                            /*var start_time = moment(self.tenancy().end_date,'X');
                            var startOf_qtr = moment(self.tenancy().end_date,'X').startOf('quarter');
                            if(startOf_qtr.isBefore(start_time, 'day')){
                                start_time.add(1,'Q');
                            }*/
                            return moment(self.tenancy().end_date,'X').startOf('quarter').format('X');
                            break;
                    }
                }
                else if( typeof self.tenancy()!= 'undefined' && !(self.tenancy().start_date === self.tenancy().end_date && self.tenancy().billing_starts == 1) ){ 
                    return moment(self.tenancy().end_date,'X');
                }
                //else {
                //    return self.tenancy().start_date;
                //}
            });
            
            self.total_amount_paid = ko.pureComputed(function () {
                total_amount = 0;
                ko.utils.arrayForEach(self.paid_for_periods(),function(paid_for_period){
                    //console.log()
                    total_amount += parseFloat(paid_for_period.amount_paid());
                });
                return total_amount;
            });
            
            //operations
            self.addPaidForPeriod = function() { self.paid_for_periods.push(new PaidForPeriod()); };
            self.removePaidForPeriod = function(paid_for_period) { self.paid_for_periods.remove(paid_for_period); };
            self.getEndDate = function(no_of_periods) {
                start_date = moment(self.start_date(),'X');
                if(typeof self.tenancy()!= 'undefined' && (self.tenancy().start_date === self.tenancy().end_date ) ){ //we can tell, at this point, that its the first payment to be made
                    //based on the time interval id, the start time, we are able to push the time to the start point of the next hour/day/week/month/quarter
                    //console.log(start_date.format('DD-MM-YYYY'));
                    if(self.tenancy().billing_starts == 1){
                        return start_date.add(no_of_periods*parseInt(self.tenancy().billing_freq)-1, self.tenancy().label).endOf(self.tenancy().period_desc);
                    }
                    if(self.tenancy().billing_starts == 2){
                        return start_date.add(no_of_periods*parseInt(self.tenancy().billing_freq), self.tenancy().label);
                    }
                }
                else if( typeof self.tenancy()!= 'undefined' && !(self.tenancy().start_date === self.tenancy().end_date) ) { 
                    return start_date.add(no_of_periods*parseInt(self.tenancy().billing_freq), self.tenancy().label);
                }
            };
            
        };
        paymentModel = new PaymentModel();
        ko.applyBindings(paymentModel);
        $('#payment_form').validator().on('submit', function () {
            enableDisableButton(this, true);
        });
    
<?php if(isset($tenancies)):
    if (isset($_POST['tenancy_id'])): ?>
        //we need to set the tenancy object accordingly
        paymentModel.tenancy(ko.utils.arrayFirst(paymentModel.tenancies(), function (currentTenancy) {
                return (<?php echo $_POST['tenancy_id'] ?> == currentTenancy.tenancy_id);
        }));
        $('#tenancy_id').val(<?php echo $_POST['tenancy_id'] ?>).trigger('change');
<?php endif;
endif; ?>
<?php if(isset($_POST['payment']) || isset($payment_line)):?>
    var payments = <?php echo json_encode(isset($_POST['payment'])?$_POST['payment']:$payment_line)?>;
    paymentModel.paid_for_periods([]);
    ko.utils.arrayForEach(payments, function(payment){
        paymentModel.paid_for_periods.push(new PaidForPeriod(payment));
    });
<?php endif;?>
    });
</script>