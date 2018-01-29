<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="page-header">
                        <i class="fa fa-house"></i> <?php echo $house['estate_name']; ?>
                        <small class="pull-right">Date: <?php echo mdate("%j%S/%M/%Y"); ?></small>
                    </h2>
                </div><!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    <address>
                        <strong> <?php echo $house['estate_name']; ?></strong><br/>
                        <?php echo $house['address']; ?><br>
                        Phone: <?php echo $house['phone']; ?><br>
                        Phone: <?php echo isset($tenant['phone2']) ? $house['phone2'] : ""; ?><br>
                        <!-- Email: info@sameestates.com -->
                    </address>
                </div><!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <strong>Tenant:</strong>
                    <address>
                        <strong><?php echo $tenant[0]['names']; ?></strong><br>
                        <?php echo $tenant[0]['home_address']; ?><br>
                        Phone: <?php echo $tenant[0]['phone1']; ?><?php echo isset($tenant['phone2']) ? ", " . $tenant['phone2'] : ""; ?><br>
                        <!--Email: <?php echo strtolower(str_replace(" ", "", $tenant[0]['names'])); ?>@sameestates.com-->
                    </address>
                </div><!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>Payment Receipt #<?php echo sprintf("%06d", $payment['payment_id']); ?></b><br>
                    <br>
                    <b>House No:</b> <?php echo $tenant[0]['house_no']; ?><br>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-lg-12 table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>Payment for:</th>
                            <td>
                                <?php
                                $datetime1 = new DateTime(mdate("@".$payment['start_date']));
                                $datetime2 = new DateTime(mdate("@".$payment['end_date']));
                                $interval = $datetime2->diff($datetime1);
                                $date_diff = (int) $interval->format('%'.$payment['label']);
                                
                                $ret_val = mdate( "%j%S %M, %Y", $payment['start_date'] ) . " - " . mdate( "%j%S %M, %Y", $payment['end_date'] );
                                
                                switch((int)($payment['time_interval_id'])){
                                    case 1: //hourly basis
                                        $format = ($date_diff === 1 && (int)$payment['billing_starts'] == 1 )?('%h:%i%A %j-%M-%Y') : ('%h:%i%A %j-%M-%Y');
                                        $ret_val =(mdate($format, $payment['start_date']) . " - " . mdate($format, $payment['end_date']));
                                        break;
                                    case 2: //daily basis
                                        $format = ('dddd, D-MMM-YYYY');
                                        $ret_val =(mdate($format, $payment['start_date']) . " - " . mdate($format, $payment['end_date']));
                                        break;
                                    case 3: //weekly basis
                                        $ret_val = mdate('%j%S-%M-%Y', $payment['start_date']) + " - " . mdate('%j%S-%M-%Y (W%W)', $payment['end_date']);
                                        break;
                                    case 4: //monthly billing
                                        $format = (($date_diff === 1 || $date_diff === 0) && (int)$payment['billing_starts'] == 1 )?'%F-%Y' : '%j%S-%M-%Y';
                                        $ret_val =(($date_diff === 1 || $date_diff === 0) && (int)$payment['billing_starts'] == 1 )?(mdate($format, $payment['start_date'])):(mdate($format, $payment['start_date']) . " - " . mdate($format, $payment['end_date']));
                                        break;
                                    case 5: //quarterly billing
                                        //$format = ($date_diff === 1 && (int)$payment['billing_starts'] == 1 )?('Qo [quarter, ] %Y') : (($date_diff > 0 && (int)$payment['billing_starts'] == 1 )?('Qo [quarter, ] %Y') : ('%j-%M-%Y'));
                                        //$ret_val =($date_diff === 1 && (int)$payment['billing_starts'] == 1 )?(mdate($format, $payment['start_date'])):(mdate($format, $payment['start_date']) + " - " + mdate($format, $payment['end_date']));
                                        break;
                                }
                                    echo $ret_val; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Amount paid:</th>
                            <td>UGX <?php echo number_format($payment['amount']); ?></td>
                        </tr>
                        <tr>
                            <th>Payment Date:</th>
                            <td><?php echo mdate("%j%S/%M/%Y", $payment['payment_date']); ?></td>
                        </tr>
                        <tr>
                            <th>Received By:</th>
                            <td><?php echo $staff_detail['fname']; ?> <?php echo $staff_detail['lname']; ?></td>
                        </tr>
                    </table>
                </div><!-- /.col -->
            </div><!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
                <div class="col-xs-12">
                    <a href="javascript:window.print()" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                    <!-- a href="<?php echo site_url("payment/pdf/{$payment['payment_id']}"); ?>" class="btn btn-default" style="margin-right: 5px;"><i class="fa fa-file-pdf-o"></i> PDF</a-->
                </div>
            </div>
            <div class="clearfix"></div>
        </div><!-- /.panel-body -->
    </div><!-- /.panel -->
</div><!-- /.col-lg-12 -->
<div class="clearfix"></div>
