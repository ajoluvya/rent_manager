<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-lg-12">
                    <div class="tabs-container" id="estates_page">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1"><i class="fa fa-money"></i> Consolidated</a></li>
                            <li><a data-toggle="tab" href="#tab-2" ><i class="fa fa-ban"></i> Assorted</a></li>
                        </ul>
                        <div class="tab-content">
                            <!-- Payments section -->
                            <div id="tab-1" class="tab-pane active">
                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><?php echo $sub_title; ?></h3>
                                        <a href="<?php echo site_url("payment/create"); ?>" class="btn btn-sm btn-default" title="Add New Payment"><i class="fa fa-edit"></i> New</a>
                                        <div id="reportrange" class="pull-right daterangepicker_div reportrange">
                                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                            <span></span> <b class="caret"></b>
                                        </div>
                                        <div class="pull-right daterangepicker_div">
                                            <strong>Date of payment:</strong>
                                        </div>
                                    </div>
                                    <table class="table table-striped table-condensed table-hover" id="tblPayments">
                                        <thead>
                                            <tr>
                                                <th>Date of payment</th>
                                                <th>Tenant</th>
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
                                                <th colspan="4">TOTAL (UGX)</th>
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
                                </div><!-- /.box -->
                            </div><!-- /.tab-1 end Consolidated Payments section-->
                            <!-- Non payments -->
                            <div id="tab-2" class="tab-pane">
                            <!-- Assorted section -->
                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><?php echo $sub_title; ?></h3>
                                        <a href="<?php echo site_url("payment/create"); ?>" class="btn btn-sm btn-default" title="Add New Payment"><i class="fa fa-edit"></i> New</a>
                                        <div id="reportrange2" class="pull-right daterangepicker_div reportrange">
                                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                            <span></span> <b class="caret"></b>
                                        </div>
                                        <div class="pull-right daterangepicker_div">
                                            <strong>Date of payment:</strong>
                                        </div>
                                    </div>
                                    <table class="table table-striped table-condensed table-hover" id="tblPaymentLines" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Date of payment</th>
                                                <th>Tenant</th>
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
                                                <th colspan="4">TOTAL (UGX)</th>
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
                                </div><!-- /.box -->
                            </div> <!-- tab-2 end Assorted Payments section -->
                        </div><!-- tab-content -->
                    </div><!-- tabs-container -->
                </div><!-- /.panel-body -->
            </div><!-- /.col-lg-12 -->
        </div><!-- /.panel -->
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<?php echo $paymentReceiptModal; ?>
<script>
     
    $(document).ready(function () {
        var ViewModel = function () {
            var self = this;
            self.payment_receipt = ko.observable();
        };
        viewModel = new ViewModel();
        ko.applyBindings(viewModel);
        
        var dTable = {}, endDate = moment(), startDate = moment().startOf('month');
        var handleDataTableButtons = function() {
            if ($("#tblPayments").length) {
                   dTable['tblPayments'] = $('#tblPayments').DataTable({
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
                                d.start_date = startDate.format('X');
                                d.end_date = endDate.format('X');
                            }
                        },
                         "columnDefs": [ {
                         "targets": [5<?php if ($_SESSION['role'] == 4 || $_SESSION['role'] == 3) { ?>,6,7<?php } ?>],
                         "orderable": false,
                         "searchable": false
                         }],
			"footerCallback": function (tfoot, data, start, end, display ) {
				var api = this.api();
				var pageTotal = api.column(4, { page: 'current'}).data().sum();
				var total = api.column(4).data().sum();
                                $(api.column(4).footer()).html( curr_format(pageTotal) + ' (' + curr_format(total) + ')' );
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
                            { data: 'names', render: function( data, type, full, meta ) { return '<a href="<?php echo site_url("tenant/view"); ?>/'+full.tenant_id+'" title="'+data+'\'s details">'+data+'</a>'; } },
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
            if ($("#tblPaymentLines").length) {
                   dTable['tblPaymentLines'] = $('#tblPaymentLines').DataTable({
                        "dom": '<".col-md-7"B><".col-md-2"l><".col-md-3"f>rt<".col-md-7"i><".col-md-5"p>',
                        "order": [[0, 'desc']],
                        "buttons": [
                            'copy', 'excel', 'print'//, 'pdf'
                        ],
                        "deferRender": true,
                        "ajax": {
                            "url":"<?php echo site_url("payment/paymentLinesJsonList")?>",
                            "dataType": "JSON",
                            "type": "POST",
                            "data": function(d){
                                d.start_date = startDate.format('X');
                                d.end_date = endDate.format('X');
                            }
                        },
                         "columnDefs": [ {
                         "targets": [5<?php if ($_SESSION['role'] == 4 || $_SESSION['role'] == 3) { ?>,6,7<?php } ?>],
                         "orderable": false,
                         "searchable": false
                         }],
			"footerCallback": function (tfoot, data, start, end, display ) {
				var api = this.api();
				var pageTotal = api.column(4, { page: 'current'}).data().sum();
				var total = api.column(4).data().sum();
                                $(api.column(4).footer()).html( curr_format(pageTotal) + ' (' + curr_format(total) + ')' );
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
                            { data: 'names', render: function( data, type, full, meta ) { return '<a href="<?php echo site_url("tenant/view"); ?>/'+full.tenant_id+'" title="'+data+'\'s details">'+data+'</a>'; } },
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
        $('table tbody').on('click', '.payment_receipt', function () {            
            var row = $(this).closest("tr");
            var tbl = row.parent().parent();
            var dt = dTable[$(tbl).attr("id")];
            var data = dt.row(row).data();
            if (typeof (data) === 'undefined') {
                data = dt.row($(row).prev()).data();
            }
            viewModel.payment_report(data);
        });
        //clicking the update icon
        $('table tbody').on('click', '.edit_me', function () {            
            var row = $(this).closest("tr");
            var tbl = row.parent().parent();
            var dt = dTable[$(tbl).attr("id")];
            var data = dt.row(row).data();
            if (typeof (data) === 'undefined') {
                data = dt.row($(row).prev()).data();
            }
            edit_data(data, 'editPaymentForm');
        });
        
        function cb(startTime, endTime) {
            $('.reportrange span').html(startTime.format('MMMM D, YYYY') + ' - ' + endTime.format('MMMM D, YYYY'));
        }

        $('.reportrange').daterangepicker({
            "showDropdowns": true, //
            "linkedCalendars": true,
            startDate: startDate,
            endDate: endDate,
            "minDate": "<?php echo mdate('%d/%m/%Y', strtotime('-10 year')); ?>",
            "maxDate": "<?php echo mdate('%d/%m/%Y'); ?>",
            "locale": {
                applyLabel: 'Search',
                format: 'DD/MM/YYYY'
            },
            ranges: {
                'This Month': [moment().startOf('month'), moment()],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'Past 6 Months': [moment().subtract(6, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'Past 1 Year': [moment().subtract(1, 'year').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb).on('apply.daterangepicker', function (ev, picker) {
            startDate = picker.startDate;
            endDate = picker.endDate;
            dTable['tblPayments'].ajax.reload(null,true);
            dTable['tblPaymentLines'].ajax.reload(null,true);
        });
        cb(startDate, endDate);

    });
</script>