<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-lg-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $sub_title; ?></h3>&nbsp;&nbsp;
                            <a href="<?php echo site_url("tenant/create"); ?>" class="btn btn-sm btn-default" title="Add New Tenant"><i class="fa fa-edit"></i> New</a>
                            <div id="reportrange" class="pull-right daterangepicker_div">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                <span></span> <b class="caret"></b>
                            </div>
                            <div class="pull-right daterangepicker_div">
                                <strong>Regn. date:</strong>
                            </div>
                        </div>
                        <table class="table table-striped table-condensed table-hover" id="tblTenants">
                            <thead>
                                <tr>
                                    <th>Name(s)</th>
                                    <th>Phone1</th>
                                    <th>Estate</th>
                                    <th>House No.</th>
                                    <th>Rate (UGX)</th>
                                    <th>Regn. Date</th>
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
                    </div><!-- /.box -->
                </div><!-- /.col-lg-12 -->
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col-lg-12 -->
</div>
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
                        "order": [[5, 'desc']],
                        "buttons": [
                            'copy', 'excel', 'print'//, 'pdf'
                        ],
                        "deferRender": true,
                        "ajax": {
                            "url":"<?php echo site_url("tenant/tenantsJsonList")?>",
                            "dataType": "JSON",
                            "type": "POST",
                            "data": function(d){
                                d.start_date = startDate.format('X');
                                d.end_date = endDate.format('X');
                            }
                        },
                         "columnDefs": [ {
                         "targets": [8,9<?php if ($_SESSION['role'] == 4 || $_SESSION['role'] == 3) { ?>,10<?php } ?>],
                         "orderable": false,
                         "searchable": false
                         }],
                        columns:[
                            { data: 'names', render: function( data, type, full, meta ) { return '<a href="<?php echo site_url("tenant/view"); ?>/'+full.tenant_id+'" title="'+data+'\'s details">'+data+'</a>'; } },
                            { data: 'phone1', render: function( data, type, full, meta ) {return '<a href="tel:'+data+'" title="call now">'+data+'</a>';}},
                            { data: 'estate_name', render: function( data, type, full, meta ) {return data?('<a href="<?php echo site_url("estate/view"); ?>/'+full.estate_id+'" title="'+data+'\'s details">'+data+'</a>'):'';}},
                            { data: 'house_no', render: function( data, type, full, meta ) {return data?('<a href="<?php echo site_url("house/view"); ?>/'+full.house_id+'" title="'+data+'s details">'+data+'</a>'):'';}},
                            { data: 'rent_rate', render: function( data, type, full, meta ) {return data?curr_format(parseInt(data)):'';}},
                            { data: 'date_created', render: function( data, type, full, meta ) {
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
                                    else{
                                        return '<a href="<?php echo site_url("tenancy/create"); ?>/'+full.tenant_id+'" title="Assign '+data+' a house/room/apartment" ><span class="fa fa-home"></span></a>';
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
                                        return '<a href="'+tenant_link+'" title="Update '+data+'\'s tenancy details" ><span class="fa fa-edit"></span></a>';
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