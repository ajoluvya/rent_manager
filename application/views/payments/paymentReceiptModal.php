<div class="modal fade" id="paymentReceiptModal">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="modal-content" data-bind="with: payment_receipt">
            <div class="modal-header">
                <button aria-hidden="true" class="close hidden-print" data-dismiss="modal" type="button">&times;</button>
                <h3 class="modal-title"><i class="fa fa-house"></i> <span data-bind="text: estate_name"></span> <small class="pull-right">Date: <?php echo mdate("%j%S/%M/%Y"); ?></small></h3>
                        
            </div>
            <div class="modal-body">
                <!-- info row -->
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        <address><!-- estate details -->
                            <strong data-bind="text: estate_name"> </strong><br/>
                            <span data-bind="text: address"></span><br>
                            Phone: <span data-bind="text: phone"></span><br>
                            Phone: <span data-bind="text: phone2?phone2:''"></span><br>
                            Email: <span data-bind="text: email">info@sameestates.com</span>
                        </address>
                    </div><!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        <strong>Customer:</strong>
                        <address>
                            <strong data-bind="text: names"></strong><br>
                            <span data-bind="text: address"><?php echo $tenant[0]['home_address']; ?><br>
                                Phone: <a data-bind="attr:{href:'tel:'+phone1}, text: phone1"></a><a data-bind="attr:{href:'tel:'+phone2}, text: phone2"></a><br>
                        </address>
                    </div><!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        <b>Payment Receipt #<span  data-bind="text: zeroFill(payment_id,7)"></span></b><br>
                        <br>
                        <b>House No:</b> <span data-bind="text: house_no"></span><br>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <!-- Table row -->
                <div class="row">
                    <div class="col-lg-12 table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th>Payment for:</th>
                                <td data-bind="text: get_time_range_display(start_date, end_date, time_interval_id, billing_starts, label)"></td>
                            </tr>
                            <tr>
                                <th>Amount paid:</th>
                                <td>UGX <span data-bind="text: amount"></span></td>
                            </tr>
                            <tr>
                                <th>Date Paid:</th>
                                <td data-bind="text: moment(payment_date,'X').format('Do/M/YYYY')"></td>
                            </tr>
                            <tr>
                                <th>Received By:</th>
                                <td data-bind="text: fname + ' ' + lname"></td>
                            </tr>
                        </table>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>
            <div class="modal-footer hidden-print">
                    <div class='pull-right'>
                        <a href="javascript:printPageSection('paymentReceiptModal','<?php echo base_url("assets/css/bootstrap.min.css"); ?>')" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                    </div>
            </div>
        </div>
    </div>
</div>

