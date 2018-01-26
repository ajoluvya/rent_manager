<div class="modal fade" id="paymentReportModal">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="modal-content" data-bind="with: tenancy">
            <div class="modal-header">
                <button aria-hidden="true" class="close hidden-print" data-dismiss="modal" type="button">&times;</button>
                <h4 class="modal-title">PAYMENTS SUMMARY</h4>
            </div>
            <div class="modal-body">
                <div class="col-lg-6">
                    <div class="box box-solid">
                        <div class="box-header">
                            <h4 class="box-title">Tenant Detail</h4>
                        </div><!-- ./ box-header -->
                        <div class="box-body">
                            <div data-bind="css: {'col-md-12':!(passport_photo&&passport_photo!=''),'col-md-7':passport_photo&&passport_photo!=''}">
                                <div class="table-responsive">
                                    <table class="table table-condensed table-bordered">
                                        <tbody>
                                            <tr><th><i class="fa fa-user"></i></th><td data-bind="text: names"></td></tr>
                                            <tr><th><i class="fa fa-mobile-phone"></i></th><td><a data-bind="attr: {href:'tel:'+phone1}, text: phone1" title="Call now"></a></td></tr>
                                            <tr><th><i class="fa fa-mobile-phone"></i></th><td><a data-bind="attr: {href:'tel:'+phone2}, text: phone2" title="Call now"></a></td></tr>
                                            <tr><th><i class="fa fa-home"></i></th><td><span data-bind="text: home_address"></span></td></tr>
                                            <tr><th><i class="fa fa-map-marker"></i></th><td data-bind="text: district"></td></tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                    <span class="btn btn-sm" data-bind="css: {'btn-info':status==1,'btn-danger':(status==2||status==3)}, text:status==1?'Active':(status==2?'Ended':'Terminated with arrears')"></span>
                                                    <span class="hidden-print btn btn-sm" data-bind="css: {'btn-danger':status==1,'btn-info':(status==2||status==3)}, text:(status==2||status==3?'Reactivate':('Terminate '+(get_date_diff($data)>0?' with arrears':''))), attr:{'title': (status==2||status==3?'Reactivate tenancy agreement':('Terminate tenancy agreement'+(get_date_diff($data)>0?' (with arrears)':'')))}, click: $parent.onClick"></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div><!-- ./ table-responsive -->
                            </div><!-- ./ col-md-6 -->
                            <!-- ko if: passport_photo&&passport_photo!='' -->
                            <div class="col-md-5">
                                <img class="img-thumbnail img-lg" data-bind="attr: {src:'<?php echo site_url("uploads/tenants"); ?>/'+passport_photo}"/>
                            </div><!-- ./ col-md-6 -->
                            <!-- /ko -->
                        </div><!-- ./ box-body -->
                    </div><!-- ./ box -->
                </div><!-- ./ col-lg-6 -->
                <div class="col-lg-6">
                    <div class="box box-solid">
                        <div class="box-header">
                            <h4 class="box-title">Payment Summary</h4>
                        </div><!-- ./ box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-condensed table-bordered">
                                    <tbody>
                                        <tr><th>Estate</th><td data-bind="text: estate_name"></td></tr>
                                        <tr><th>Apartment/House No.</th><td data-bind="text: house_no"></td></tr>
                                        <tr><th>Floor</th><td data-bind="text: parseInt(floor)+1"></td></tr>
                                        <tr><th>Rent Rate (UGX)</th><td><span data-bind="text: curr_format(parseFloat(rent_rate)*1)"></span></td></tr>
                                        <tr><th>Entry date/time</th><td data-bind="text: moment(start_date,'X').format((parseInt(time_interval_id)<3?'hh:mm A':'')+'Do-MMM-YYYY')"></td></tr>
                                        <tr><th>Payments made upto</th><td data-bind="text: moment(end_date,'X').format(parseInt(time_interval_id)<3?'hh:mm A Do-MMM-YYYY':(parseInt(billing_starts)==1?'MMM-YYYY':'Do-MMM-YYYY'))"></td></tr>
                                        <!-- ko if: status > 1 -->
                                        <tr><th>End date/time </th><td><strong data-bind="text:moment(exit_date,'X').format(parseInt(time_interval_id)<3?'hh:mm A Do-MMM-YYYY':(parseInt(billing_starts)==1?'MMM-YYYY':'Do-MMM-YYYY'))"></strong></td></tr>
                                        <!-- /ko -->
                                        <!-- ko if: get_date_diff($data)>0-->
                                        <tr><th>Unpaid arrears (UGX)</th><td><strong data-bind="text:get_date_diff($data)>0?curr_format((Math.abs(get_date_diff($data))/billing_freq) * parseFloat(rent_rate)*1):0"></strong></td></tr>
                                        <!-- /ko -->
                                        <!-- ko if: get_date_diff($data)<1-->
                                        <tr><th>Remaining <span data-bind="text: period_desc.toLocaleString().toLocaleLowerCase()"></span></th><td><strong data-bind="text:Math.abs(get_date_diff($data))"></strong></td></tr>
                                        <!-- /ko -->
                                        <!-- ko if: get_date_diff($data)>0-->
                                        <tr><th>Unpaid for <span data-bind="text: period_desc.toLocaleString().toLocaleLowerCase()"></span></th><td><strong data-bind="text:get_date_diff($data)"></strong></td></tr>
                                        <!-- /ko -->
                                    </tbody>
                                </table>
                            </div><!-- ./ table-responsive -->
                        </div><!-- ./ box-body -->
                    </div><!-- ./ box -->
                </div><!-- ./ col-lg-6 -->
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer hidden-print">
                <div class='pull-right'>
                    <a href="javascript:printPageSection('paymentReportModal','<?php echo base_url("assets/css/bootstrap.min.css"); ?>')" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
        </div>
    </div>
</div>

