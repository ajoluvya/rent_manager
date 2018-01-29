<div class="row">'
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-lg-12">
                    <div class="tabs-container" id="estates_page">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1"><i class="fa fa-list-alt"></i> Details</a></li>
                            <li><a data-toggle="tab" href="#tab-2" ><i class="fa fa-home"></i> Apartments/Houses</a></li>
                            <li><a data-toggle="tab" href="#tab-3"><i class="fa fa-hotel"></i> Tenancies</a></li>
                            <li><a data-toggle="tab" href="#tab-4"><i class="fa fa-credit-card"></i> Payments</a></li>
                        </ul>
                        <div class="tab-content">
                            <!-- Estate Details -->
                            <div id="tab-1" class="tab-pane active">
                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><?php echo $sub_title; ?></h3>
                                        <div class="pull-right">
                                            <div class="btn-group">
                                                <a href="<?php echo site_url("estate/create"); ?>" class="btn btn-default" title="Create new estate"><i class="fa fa-plus-square"></i> New</a>
                                                <!-- If the estates owner/admin is logged in -->
                                                <?php if ($_SESSION['role'] == 4 || $_SESSION['role'] == 3) { ?>
                                                    <a class="btn btn-default" href="<?php echo site_url("estate/update/" . $estate['estate_id']); ?>" title="Edit estate details">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                    <?php if (empty($estate_houses)): //display the houses in this estate ?>
                                                        <a href="<?php echo site_url("estate/del_estate/" . $estate['estate_id']); ?>" class="btn btn-danger" title='Delete estate details' onclick="return confirm_delete('<?php echo "the details of " . $estate['estate_name']; ?>');"><i class="fa fa-trash"></i>Delete</a>
                                                    <?php endif; ?>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-lg-6">
                                            <table class="table table-striped table-condensed">
                                                <!--tr><th>ID</th><td><?php echo $estate['estate_id']; ?></td></tr-->
                                                <tr><th>Telephone</th><td><?php echo $estate['phone']; ?></td></tr>
                                                <tr><th>Telephone2</th><td><?php echo $estate['phone2']; ?></td></tr>
                                                <tr><th>Address</th><td><?php echo $estate['address']; ?></td></tr>
                                                <tr><th>District</th><td><?php echo $estate['district']; ?></td></tr>
                                            </table>
                                        </div><!-- /.col-lg-6 -->
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div> <!-- tab-1 end Details pane -->
                            <!-- Apartments -->
                            <div id="tab-2" class="tab-pane">
                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><i class="fa fa-home"></i> Apartments/Houses </h3>&nbsp;&nbsp;
                                        <div class="pull-right">
                                            <div class="btn-group">
                                                <a href="#saveHouseModal" data-toggle="modal" data-bind="click: setFormDefaults" class="btn btn-default" title="Add new apartment/house/room"><i class="fa fa-plus-square"></i> Add Apartment/House/Room</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-lg-10">
                                            <table class="table table-striped table-condensed table-hover" width="100%" id="tblHouses">
                                                <thead>
                                                    <tr>
                                                        <th>House No</th>
                                                        <!--th>Estate</th-->
                                                        <th>Rent rate (UGX)</th>
                                                        <th>Floor</th>
                                                        <th>Max Tenants</th>
                                                        <!-- If the estates owner/admin is logged in -->
                                                        <?php $last_cols=""; if ($_SESSION['role'] == 4 || $_SESSION['role'] == 3): ?>
                                                            <th>&nbsp;</th>
                                                            <th>&nbsp;</th>
                                                        <?php $last_cols = ",4,5"; endif; ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div><!-- /.col-lg-7 -->
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div>
                            <!-- End Apartments/Houses Pane -->
                            <!-- Tenants section -->
                            <div id="tab-3" class="tab-pane">
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><i class="fa fa-hotel"></i> Tenants</h3>
                                            <div id="tenants_dp" class="pull-right daterangepicker_div reportrange">
                                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                                <span></span> <b class="caret"></b>
                                            </div>
                                            <div class="pull-right daterangepicker_div">
                                                <strong>Entry/Date time:</strong>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <div class="col-lg-12">
                                                <table class="table table-condensed table-hover" width="100%" id="tblTenants">
                                                    <thead>
                                                        <tr>
                                                            <th>Tenant Names</th>
                                                            <th>Phone1</th>
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
                                            </div><!-- /.col-lg-12 -->
                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->			
                            </div>
                            <!-- end Tenants pane -->
                            <!-- Payments section -->
                            <div id="tab-4" class="tab-pane">
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><i class="fa fa-credit-card"></i> Payments</h3>
                                            <div id="reportrange" class="pull-right daterangepicker_div reportrange">
                                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                                <span></span> <b class="caret"></b>
                                            </div>
                                            <div class="pull-right daterangepicker_div">
                                                <strong>Date of payment:</strong>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <div class="col-lg-12">
                                                <table class="table table-condensed table-hover" width="100%" id="tblEstateTenantPayments">
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
                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->		
                            </div>
                            <!-- /.Payments pane -->
                        </div><!-- /.col-tab-content -->
                    </div><!-- /.tabs-container -->
                </div><!-- /.col-lg-12 -->
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<!-- row -->
<div class="modal fade" id="saveHouseModal">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">&times;</button>
            </div>
            <div class="modal-body">
                <?php echo $create_modal; ?>
            </div>
        </div>
    </div>
</div>
    <?php echo $paymentReportModal; ?>
<script type="text/javascript">
    function setFormDefaults(){
<?php if (isset($estate)) {
        ?>
                $('#time_interval_id').val(<?php echo $estate['time_interval_id']; ?>).trigger('change');
                $('input[value="<?php echo $estate['period_starts'];?>"]').prop("checked",true);
                $('#billing_freq').val(<?php echo $estate['billing_freq']; ?>);
        <?php
    }
?>
    }
    var floors = <?php echo json_encode($floors);?>;
    $(document).ready(function () {
        var dTable = {}, endDate = moment(), startDate = moment().startOf('month');
        var HouseModel = function () {
            var self = this;
            self.time_interval = ko.observable();
            self.time_intervals = ko.observableArray(<?php echo json_encode($time_intervals); ?>);
            self.estate = ko.observable(<?php echo json_encode($estate); ?>);
            self.tenancy = ko.observable();
            self.onClick = function (tenancy, event){
                change_tenancy_status(event.target, '<?php echo site_url('tenancy/change_status'); ?>',tenancy);
            }
        };
        var houseModel = new HouseModel();
        ko.applyBindings(houseModel);

        $('#estateCreationForm').on('submit', function () {
            enableDisableButton(this, true);
        });
        var dTable = {};
        var handleDataTableButtons = function() {
            if ($("#tblHouses").length) {
                   dTable['tblHouses'] = $("#tblHouses").DataTable({
                   "dom": '<".col-md-5"B><".col-md-3"l><".col-md-4"f>rt<".col-md-9"i><".col-md-3"p>',
                   order: [[0, 'desc']],
                   deferRender: true,
                   autowidth: true,
                   responsive: true,
                   "ajax": {
                       "url":"<?php echo site_url('house/HousesJsonList/'.$estate['estate_id'])?>",
                       "dataType": "JSON"
                   },
                    columnDefs: [ {
                    "targets": [0<?php echo $last_cols; ?>],
                    "orderable": false,
                    "searchable": false
                    }],
                   columns:[ { data: 'house_no', render: function( data, type, full, meta ){return "<a href='<?php echo site_url("house/view/"); ?>/"+full.house_id+"' title='House details'>"+data+"</a>";}},
                       { data: 'fixed_amount', render: function( data, type, full, meta ) {
                               ret_val = curr_format(parseInt(data));
                               if(type == 'filter'){
                                   return data;
                               }
                               if(type == 'sort'){
                                   return data;
                               }
                               return ret_val;
                           }
                       },
                        {data: 'floor', render: function ( data, type, full, meta ) {return floors[data];}},
                        {data: 'max_tenants'}
                       // If the data estates owner/admin is logged in 
                       <?php if ($_SESSION['role'] == 4 || $_SESSION['role'] == 3): ?>,
                       //{ data: 'house_id', render: function ( data, type, full, meta ) {return '<a href="<?php echo site_url("house/update/"); ?>/'+data+'" title="Update details" ><i class="fa fa-pencil"></i></a>';}},
                       { data: 'house_id', render: function ( data, type, full, meta ) {return '<a href="#saveHouseModal" data-toggle="modal" class="edit_me" title="Update details" ><i class="fa fa-pencil"></i></a>';}},
                       { data: 'house_id', render: function ( data, type, full, meta ) {return '<a href="<?php echo site_url("house/del_house/"); ?>/'+data+'" onclick="return confirm_delete(\'this record\');" title="Delete"><span class="fa fa-trash text-danger"></span></a>';}}
                       <?php endif; ?>	
                       ],
                   buttons: [ 'copy', 'excel', 'print' ]//, 'pdf'
               });
            }
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
                                d.estate_id = d.tenant_id = <?php echo $estate['estate_id']; ?>;;
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
                                        return '<a href="'+tenant_link+'" title="Make payment for '+data+' (house no: '+full.house_no+') details" ><span class="fa fa-money"></span></a>';
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
            if ($("#tblEstateTenantPayments").length) {
                   dTable['tblEstateTenantPayments'] = $('#tblEstateTenantPayments').DataTable({
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
                                d.estate_id = <?php echo $estate['estate_id']; ?>;
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
        $('table#tblHouses tbody').on('click', '.edit_me', function () {            
            var row = $(this).closest("tr");
            var tbl = row.parent().parent();
            var dt = dTable[$(tbl).attr("id")];
            var data = dt.row(row).data();
            if (typeof (data) === 'undefined') {
                data = dt.row($(row).prev()).data();
            }
            edit_data(data, 'saveHouseForm');
            //$('input[value="'+data.period_starts+'"]').prop("checked",true);
        });
        //clicking the update icon
        $('table#tblTenants tbody').on('click', '.payment_report', function () {            
            var row = $(this).closest("tr");
            var tbl = row.parent().parent();
            var dt = dTable[$(tbl).attr("id")];
            var data = dt.row(row).data();
            if (typeof (data) === 'undefined') {
                data = dt.row($(row).prev()).data();
            }
            houseModel.tenancy(data);
        });
        $('#saveHouseForm').validator().on('submit', function (e) {
            if (e.isDefaultPrevented()) {
                // handle the invalid form...
            } else {
                e.preventDefault();
                enableDisableButton(e.target, true);
                $.post(
                        '<?php echo site_url('house/save_house'); ?>',
                        $(e.target).serialize(),
                        function (response) {
                            if (response.success) {
                                alert("Success");
                                setTimeout(function () {
                                    dTable['tblHouses'].ajax.reload(null,true);
                                    //$(e.target)[0].reset();
                                    $("#saveHouseModal").modal('hide');
                                }, 2000);
                            } else {
                                alert(response.message);
                            }
                            enableDisableButton(e.target, false);
                        },
                        'json');
            }
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
            ranges: {
                'This Month': [moment().startOf('month'), moment()],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'Past 6 Months': [moment().subtract(6, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'Past 1 Year': [moment().subtract(1, 'year').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb).on('apply.daterangepicker', function (ev, picker) {
            startDate = picker.startDate;
            endDate = picker.endDate;
            dTable['tblEstateTenantPayments'].ajax.reload(null,true);
            dTable['tblTenants'].ajax.reload(null,true);
        });
        cb(startDate, endDate);
    });
</script>
