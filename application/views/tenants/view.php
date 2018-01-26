<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-lg-12">
                    <div class="tabs-container" id="estates_page">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1"><i class="fa fa-user"></i> Details</a></li>
                            <li><a data-toggle="tab" href="#tab-2" ><i class="fa fa-home"></i> Apartments/Houses</a></li>
                            <li><a data-toggle="tab" href="#tab-3"><i class="fa fa-credit-card"></i> Payments</a></li>
                        </ul>
                        <div class="tab-content">
                            <!-- Tenant Details -->
                            <div id="tab-1" class="tab-pane active">
                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><i class="fa fa-user"></i> <?php echo $sub_title; ?></h3>
                                        <?php if (empty($houses)): ?>
                                            <div class="pull-right">
                                                <a href="<?php echo site_url("tenant/del_tenant/" . $tenant['tenant_id']); ?>" class="btn btn-danger" title="Delete <?php echo $tenant['names']; ?>'s details" onclick="return confirm_delete('<?php echo "the details of tenant: " . $tenant['names']; ?>');"><i class="fa fa-trash"></i>Delete</a>
                                            </div>
                                        <?php endif; ?>
                                        <div class="pull-right">
                                            <a class="btn btn-default" href="<?php echo site_url("tenant/update/" . $tenant['tenant_id']); ?>" title="Edit <?php echo $tenant['names']; ?>'s details">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                        </div>
                                    </div><!--box-header -->
                                    <div class="box-body">
                                        <div class="col-md-6">
                                            <table class="table table-condensed">
                                                <tr><th>ID</th><td><?php echo $tenant['id_card_no']; ?></td></tr>
                                                <tr><th>Name(s)</th><td><?php echo $tenant['names']; ?></td></tr>
                                                <tr><th>Phone1</th><td><?php echo $tenant['phone1']; ?></td></tr>
                                                <?php if ($tenant['phone2'] != FALSE): ?>
                                                    <tr><th>Phone2</th><td><?php echo $tenant['phone2']; ?></td></tr>
                                                <?php endif; ?>
                                                <tr><th>Date added</th><td><?php echo mdate('%j%S %M, %Y', $tenant['date_created']); ?></td></tr>
                                                <tr><th>Home address</th><td><?php echo $tenant['home_address']; ?></td></tr>
                                                <tr><th>District</th><td><?php echo $tenant['district']; ?></td></tr>
                                            </table>
                                        </div><!-- /.col-md-6 -->
                                        <?php if (isset($tenant['passport_photo']) && $tenant['passport_photo'] != ""): ?>
                                            <div class="col-md-3"><img class="img-thumbnail img-responsive" src="<?php echo site_url("uploads/tenants/" . $tenant['passport_photo']); ?>"/></div><!--col-md-4-->
                                        <?php endif; ?>
                                        <?php if (isset($tenant['id_card_url']) && $tenant['id_card_url'] != ""): ?>
                                            <div class="col-md-3"><img class="img-thumbnail img-responsive" src="<?php echo site_url("uploads/tenants/" . $tenant['id_card_url']); ?>"/></div><!--col-md-4-->
                                        <?php endif; ?>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->

                            </div> <!-- tab-1 end Details pane -->
                            <!-- Tenant Details -->
                            <!-- Apartments/Houses -->
                            <div id="tab-2" class="tab-pane">
                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><i class="fa fa-home"></i> Houses Occupied</h3>&nbsp;&nbsp;
                                        <a class="btn btn-default" href="<?php echo site_url("tenancy/create/" . $tenant['tenant_id']); ?>" title="Assign <?php echo $tenant['names']; ?> a house">
                                            <i class="fa fa-plus-square"></i> Add
                                        </a>
                                        <div id="tenancies_dp" class="pull-right daterangepicker_div reportrange">
                                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                            <span></span> <b class="caret"></b>
                                        </div>
                                        <div class="pull-right daterangepicker_div">
                                            <strong>Entry/Date time:</strong>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <table class="table table-condensed table-hover" id="tblTenantHouses" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Phone1</th>
                                                    <th>Estate</th>
                                                    <th>House No.</th>
                                                    <th>Rate (UGX)</th>
                                                    <th>Entry Date</th>
                                                    <th>Payments made upto</th>
                                                    <th>Status</th>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                    <!-- If the estates owner/admin is logged in -->
                                                    <?php if ($_SESSION['role'] == 4 || $_SESSION['role'] == 3): ?>
                                                        <th>&nbsp;</th>
                                                    <?php endif; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                            </tfoot>
                                        </table>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->

                            </div> <!-- tab-2 end Apartments/Houses pane -->
                            <!-- Payments -->
                            <div id="tab-3" class="tab-pane">
                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><i class="fa fa-credit-card"></i> Payments</h3>
                                        <!--div class="pull-right">
                                                <a class="btn btn-default" href="<?php echo site_url("payment/create/" . $tenant['tenant_id']); ?>" title="Enter payment for <?php echo $tenant['names']; ?>">
                                                        <i class="fa fa-plus-square"></i> Add
                                                </a>
                                        </div-->
                                        <div id="payments_dp" class="pull-right daterangepicker_div reportrange">
                                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                            <span></span> <b class="caret"></b>
                                        </div>
                                        <div class="pull-right daterangepicker_div">
                                            <strong>Date of payment:</strong>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-lg-12">
                                            <table class="table table-condensed table-hover" id="tblTenantPayments" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Date of payment</th>
                                                        <th>House</th>
                                                        <th>Payment for</th>
                                                        <th>Amount (UGX)</th>
                                                        <th>Receipt</th>
                                                        <!--th>Bank account</th-->
                                                        <!-- If the estates owner/admin is logged in -->
                                                        <?php if ($_SESSION['role'] == 4 || $_SESSION['role'] == 3): ?>
                                                            <th>&nbsp;</th>
                                                            <th>&nbsp;</th>
                                                        <?php endif; ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="3">TOTAL (UGX)</th>
                                                        <th></th>
                                                        <th></th>
                                                        <!--th>&nbsp;</th-->
                                                        <!-- If the estates owner/admin is logged in -->
                                                        <?php if ($_SESSION['role'] == 4 || $_SESSION['role'] == 3) { ?>
                                                            <th colspan="2"></th>
                                                        <?php } ?>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div><!-- /.col-lg-6 -->
                                    </div><!-- /.box body-->
                                </div><!-- /.box -->
                            </div> <!-- tab-3 end Details pane -->
                            <!-- Payments -->
                        </div><!-- tab-content -->
                    </div><!-- tabs-container -->
                </div><!-- col-lg-12 -->
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<?php echo $paymentReportModal; ?>
<script>
     
    $(document).ready(function () {
        var ViewModel = function () {
            var self = this;
            self.payment_receipt = ko.observable();
            self.tenancy = ko.observable();
            self.onClick = function (tenancy, event){
                change_tenancy_status(event.target, '<?php echo site_url('tenancy/change_status'); ?>',tenancy);
            }
        };
        viewModel = new ViewModel();
        ko.applyBindings(viewModel);
        
        var dTable = {}, endDate = moment(), startDate = moment().startOf('month');
        var handleDataTableButtons = function() {
            if ($("#tblTenantHouses").length) {
                   dTable['tblTenantHouses'] = $('#tblTenantHouses').DataTable({
                        "dom": '<".col-md-7"B><".col-md-2"l><".col-md-3"f>rt<".col-md-7"i><".col-md-5"p>',
                        "order": [[4, 'desc']],
                        "buttons": [
                            'copy', 'excel', 'print'//, 'pdf'
                        ],
                        "deferRender": true,
                        "ajax": {
                            "url":"<?php echo site_url("tenant/tenantsJsonList")?>",
                            "dataType": "JSON",
                            "type": "POST",
                            "data": function(d){
                                d.tenant_id = <?php echo $tenant['tenant_id']; ?>;
                                d.start_date = startDate.format('X');
                                d.end_date = endDate.format('X');
                            }
                        },
                         "columnDefs": [ {
                         "targets": [7,8<?php if ($_SESSION['role'] == 4 || $_SESSION['role'] == 3) { ?>,9<?php } ?>],
                         "orderable": false,
                         "searchable": false
                         }],
                        columns:[
                            { data: 'phone1', render: function( data, type, full, meta ) {return '<a href="tel:'+data+'" title="call now">'+data+'</a>';}},
                            { data: 'estate_name', render: function( data, type, full, meta ) {return data?('<a href="<?php echo site_url("estate/view"); ?>/'+full.estate_id+'" title="'+data+'\'s details">'+data+'</a>'):'';}},
                            { data: 'house_no', render: function( data, type, full, meta ) {return data?('<a href="<?php echo site_url("house/view"); ?>/'+full.house_id+'" title="'+data+'s details">'+data+'</a>'):'';}},
                            { data: 'rent_rate', render: function( data, type, full, meta ) {return data?curr_format(parseInt(data)):'';}},
                            { data: 'start_date', render: function( data, type, full, meta ) {
                                    if(data){
                                        ret_val = moment(data,'X').format('D-MMM-YYYY');
                                        if(type == 'filter'){
                                        }
                                        if(type == 'sort'){
                                            return data;
                                        }
                                        return ret_val;
                                    }
                                    return '';
                                }
                            },
                            { data: 'end_date', render: function( data, type, full, meta ) {
                                    if(data){
                                        ret_val = moment(data,'X').format('D-MMM-YYYY');
                                        if(type == 'filter'){
                                        }
                                        if(type == 'sort'){
                                            return data;
                                        }
                                        return ret_val;
                                    }
                                    return '';
                                }
                            },
                            { data: 'tenancy_id', render: function( data, type, full, meta ) {
                                    if(data){
                                        button_class = "warning";
                                        title_text = "No arrears";
                                        date_diff = get_date_diff(full);
                                        
                                        complete_label = Math.abs(date_diff) + " " + (date_diff == 1 ? (full.period_desc.substr(0,full.period_desc.length-1)) : (full.period_desc) );
                                        if(date_diff < 1){
                                            button_class = "info";
                                        }
                                        if(date_diff > 0){
                                            title_text = complete_label + " arrears totalling Ugx: " + curr_format((Math.abs(date_diff)/full.billing_freq) * parseFloat(full.rent_rate)*1);
                                            complete_label = curr_format((Math.abs(date_diff)/full.billing_freq) * parseFloat(full.rent_rate)*1) + " (" + complete_label + ") ";
                                        }
                                        if(date_diff > 1){
                                            button_class = "danger";
                                        }
                                        if(full.status == 2){
                                            complete_label = "Terminated";
                                            button_class = "success";
                                        }
                                        if(full.status == 3){
                                            complete_label = "Terminated";
                                        }
                                        if(type == 'filter'){
                                            return complete_label;
                                        }
                                        if(type == 'sort'){
                                            return date_diff;
                                        }
                                        return '<a data-toggle="modal" href="#paymentReportModal" ><span class="payment_report btn btn-sm btn-'+button_class+'" title="'+title_text+'">'+complete_label+'</span></a>';
                                    }
                                    return '';
                                }
                            },
                            { data: 'names', render: function( data, type, full, meta ) {
                                    if (full.tenancy_id && (full.status == 1 || full.status == 2)){
                                        tenant_link = '<?php echo site_url("payment/create"); ?>/'+full.tenancy_id;
                                        return '<a href="'+tenant_link+'" title="Make payment for '+data+' (house no: '+full.house_no+')" ><span class="fa fa-money"></span></a>';
                                    }
                                    return '';
                                }
                            },
                            { data: 'names', render: function( data, type, full, meta ) {
                                    tenant_link = '<?php echo site_url("tenant/update"); ?>/'+full.tenant_id;
                                    if (full.tenancy_id){
                                        tenant_link = '<?php echo site_url("tenancy/update"); ?>/'+full.tenancy_id;
                                    }
                                    if (!full.tenancy_id ||(full.start_date === full.end_date)){
                                        return '<a href="'+tenant_link+'" title="Update '+data+'\'s details" ><span class="fa fa-edit"></span></a>';
                                    }
                                    return '';
                                }
                            }
                            // If the estates owner/admin is logged in 
                            <?php if ($_SESSION['role'] == 4 || $_SESSION['role'] == 3): ?>,
                            { data: 'tenant_id', render: function( data, type, full, meta ) {
                                    if (!full.tenancy_id ||(full.start_date === full.end_date)){
                                        return '<a href="<?php echo site_url("tenant/del_tenant"); ?>/'+data+'" onclick="return confirm_delete(\'the tenant ' + full.names + '\');" title="Delete"><span class="fa fa-trash text-danger"></span></a>';
                                    }
                                    return '';
                                }
                            }
                            <?php endif; ?>
                            ]
                    });
            }
            if ($("#tblTenantPayments").length) {
                   dTable['tblTenantPayments'] = $('#tblTenantPayments').DataTable({
                        "dom": '<".col-md-7"B><".col-md-2"l><".col-md-3"f>rt<".col-md-7"i><".col-md-5"p>',
                        "order": [[0, 'desc']],
                        "buttons": [
                            'copy', 'excel', 'print'//, 'pdf'
                        ],
                        "deferRender": true,
                        "ajax": {
                            "url":"<?php echo site_url("payment/paymentsJsonList")?>",
                            "dataType": "JSON",
                            "type": "POST",
                            "data": function(d){
                                d.tenant_id = <?php echo $tenant['tenant_id']; ?>;
                                d.start_date = startDate.format('X');
                                d.end_date = endDate.format('X');
                            }
                        },
                         "columnDefs": [ {
                         "targets": [4<?php if ($_SESSION['role'] == 4 || $_SESSION['role'] == 3) { ?>,5,6<?php } ?>],
                         "orderable": false,
                         "searchable": false
                         }],
			"footerCallback": function (tfoot, data, start, end, display ) {
				var api = this.api();
				var pageTotal = api.column(3, { page: 'current'}).data().sum();
				var total = api.column(3).data().sum();
                                $(api.column(3).footer()).html( curr_format(pageTotal) + ' (' + curr_format(total) + ')' );
			},
                        "columns":[
                            { data: 'payment_date', render: function( data, type, full, meta ) {
                                    if(data){
                                        ret_val = moment(data,'X').format('Do-MMM-YYYY');
                                        if(type == 'filter'){
                                        }
                                        if(type == 'sort'){
                                            return data;
                                        }
                                        return ret_val;
                                    }
                                    return '';
                                }
                            },
                            { data: 'house_no', render: function( data, type, full, meta ) {return data?('<a href="<?php echo site_url("house/view"); ?>/'+full.house_id+'" title="'+data+'s details">'+data+'</a>'):'';}},
                            { data: 'start_date', render: function( data, type, full, meta ) {
                                    if(data){
                                        get_time_range_display(data, full.end_date, full.time_interval_id, full.billing_starts, full.label);
                                        if(type == 'sort'){
                                            return data;
                                        }
                                        return ret_val;
                                    }
                                    return '';
                                }
                            },
                            { data: 'amount', render: function( data, type, full, meta ) {return data?curr_format(parseInt(data)):'';}},
                            { data: 'payment_id', render: function( data, type, full, meta ) {
                                    receipt_link = '<?php echo site_url("payment/view"); ?>/'+data;
                                        return '<a href="'+receipt_link+'" title="Display receipt" ><span class="fa fa-file-o"></span></a>';
                                }
                            }
                            // If the estates owner/admin is logged in 
                            <?php if ($_SESSION['role'] == 4 || $_SESSION['role'] == 3): ?>,
                            { data: 'payment_id', render: function( data, type, full, meta ) {
                                    tenant_link = '<?php echo site_url("payment/update"); ?>/'+data;
                                    return '<a href="'+tenant_link+'" title="Update payment details" ><span class="fa fa-edit"></span></a>';
                                }
                            },
                            { data: 'payment_id', render: function( data, type, full, meta ) {
                                    return '<a href="<?php echo site_url("payment/del_payment"); ?>/'+data+'" onclick="return confirm_delete(\'the payment Ref#' + data + '\');" title="Delete"><span class="fa fa-trash text-danger"></span></a>';
                                }
                            }
                            <?php endif; ?>
                            ]
                    });
            }
        };
        TableManageButtons = function() {
            "use strict";
            return {
                init: function() {
                    handleDataTableButtons();
                }
            };
        }();
        TableManageButtons.init();
        //clicking the update icon
        $('table tbody').on('click', '.payment_report', function () {            
            var row = $(this).closest("tr");
            var tbl = row.parent().parent();
            var dt = dTable[$(tbl).attr("id")];
            var data = dt.row(row).data();
            if (typeof (data) === 'undefined') {
                data = dt.row($(row).prev()).data();
            }
            viewModel.tenancy(data);
        });
      
        function cb(startTime, endTime) {
            $('.reportrange span').html(startTime.format('MMMM D, YYYY') + ' - ' + endTime.format('MMMM D, YYYY'));
        }

        $('.reportrange').daterangepicker({
            "showDropdowns": true, //
            "linkedCalendars": true,
            startDate: startDate,
            endDate: endDate,
            timePicker: true,
            timePickerIncrement: 10,
            "minDate": "<?php echo mdate('%d/%m/%Y', strtotime('-10 year')); ?>",
            "maxDate": "<?php echo mdate('%d/%m/%Y'); ?>",
            "locale": {
                applyLabel: 'Search',
                format: 'DD/MM/YYYY h:mm A'
            },
            //format: 'DD/MM/YYYY',
            ranges: {
                'This Month': [moment().startOf('month'), moment()],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'Past 6 Months': [moment().subtract(6, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'Past 1 Year': [moment().subtract(1, 'year').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb).on('apply.daterangepicker', function (ev, picker) {
            startDate = picker.startDate;
            endDate = picker.endDate;
            dTable['tblTenantPayments'].ajax.reload(null,true);
            dTable['tblTenantHouses'].ajax.reload(null,true);
        });
        cb(startDate, endDate);
   });
</script>