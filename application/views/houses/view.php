<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-lg-12">
                    <div class="tabs-container" id="estates_page">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1"><i class="fa fa-list-alt"></i> Details</a></li>
                            <li><a data-toggle="tab" href="#tab-2" ><i class="fa fa-home"></i> Tenancies</a></li>
                        </ul>
                        <div class="tab-content">
                            <!-- House Details -->
                            <div id="tab-1" class="tab-pane active">
                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><?php echo $sub_title; ?></h3>
                                        <div class="pull-right">
                                            <div class="btn-group">
                                                <a href="<?php echo site_url("house/create"); ?>" class="btn btn-default" title="New house"><i class="fa fa-plus-square"></i> New</a>
                                                <!-- If the estates owner/admin is logged in -->
                                                <?php if ($_SESSION['role'] == 4 || $_SESSION['role'] == 3) { ?>
                                                    <a class="btn btn-default" href="<?php echo site_url("house/update/" . $house['house_id']); ?>" title="Edit house details">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                    <?php if (empty($house_tenants)): //display the tenants who've rented this room (current and past) ?>

                                                        <a href="<?php echo site_url("house/del_house/" . $house['house_id']); ?>" class="btn btn-danger" title='Delete house details' onclick="return confirm_delete('<?php echo "the details of house " . $house['house_no']; ?>');"><i class="fa fa-trash"></i> Delete</a>

                                                    <?php endif; ?>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-lg-6">
                                            <div class="table-responsive">
                                                <table class="table table-condensed">
                                                    <tr><th>Apartment/House/Room No</th><td><?php echo $house['house_no']; ?></td></tr>
                                                    <tr><th>Fixed amount</th><td><?php echo number_format($house['fixed_amount']); ?></td></tr>
                                                    <tr><th>Floor</th><td><?php echo $floor; ?> floor</td></tr>
                                                    <tr><th>Description</th><td><?php echo $house['description']; ?></td></tr>
                                                    <tr><th>Estate</th><td><a href="<?php echo site_url("estate/view/" . $house['estate_id']); ?>" title="View details"><?php echo $house['estate_name']; ?></a></td></tr>
                                                </table>
                                            </div><!-- /.table-responsive -->
                                        </div><!-- /.col-lg-6 -->
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div> <!-- tab-1 end Details pane -->
                            <!-- Tenants -->
                            <div id="tab-2" class="tab-pane">
                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><i class="fa fa-home"></i> Tenants</h3>
                                        <div id="reportrange" class="pull-right daterangepicker_div reportrange">
                                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                            <span></span> <b class="caret"></b>
                                        </div>
                                        <div class="pull-right daterangepicker_div">
                                            <strong>Entry/Date time:</strong>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table table-condensed table-hover" width="100%" id="tblTenants">
                                                <thead>
                                                    <tr>
                                                        <th>Name(s)</th>
                                                        <th>Phone1</th>
                                                        <th>Estate</th>
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
                                            </table>
                                        </div><!-- /.table-responsive -->
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->				
                            </div><!--- Tab-2 end Tenants pane -->
                        </div><!-- col-tab-content -->
                    </div><!-- tabs-container -->
                </div><!-- col-lg-12 -->
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col-lg-12 -->
</div><!-- row -->
    <?php echo $paymentReportModal; ?>
<script>
    var dTable = {}, viewModel = {};
    $(document).ready(function () {
        var endDate = moment(), startDate = moment().subtract(3,'years');
        var ViewModel = function () {
            var self = this;
            self.tenancy = ko.observable();
            self.onClick = function (tenancy, event){
                change_tenancy_status(event.target, '<?php echo site_url('tenancy/change_status'); ?>',tenancy);
            }
        };
        viewModel = new ViewModel();
        ko.applyBindings(viewModel);
        
        var handleDataTableButtons = function() {
            if ($("#tblTenants").length) {
                   dTable['tblTenants'] = $('#tblTenants').DataTable({
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
                                d.house_id = <?php echo $house['house_id']; ?>;
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
                            { data: 'names', render: function( data, type, full, meta ) { return '<a href="<?php echo site_url("tenant/view"); ?>/'+full.tenant_id+'" title="'+data+'\'s details">'+data+'</a>'; } },
                            { data: 'phone1', render: function( data, type, full, meta ) {return '<a href="tel:'+data+'" title="call now">'+data+'</a>';}},
                            { data: 'estate_name', render: function( data, type, full, meta ) {return data?('<a href="<?php echo site_url("estate/view"); ?>/'+full.estate_id+'" title="'+data+'\'s details">'+data+'</a>'):'';}},
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
            $('#reportrange span').html(startTime.format('MMMM D, YYYY') + ' - ' + endTime.format('MMMM D, YYYY'));
        }

        $('#reportrange').daterangepicker({
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
            dTable['tblTenants'].ajax.reload(null,true);
        });
        cb(startDate, endDate);
    });
</script>