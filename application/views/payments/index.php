<div class="row">
    <div class="col-lg-12">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $sub_title; ?></h3>
                <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                    <span></span> <b class="caret"></b>
                </div>
                <?php echo form_open(uri_string(), array('id' => 'getPaymentsForm', 'name' => 'getPaymentsForm', 'role' => 'form')); ?>
                <input type="hidden" name="start" id="startDate"/>
                <input type="hidden" name="end" id="endDate"/>
                </form>
            </div>
            <table class="table table-striped table-condensed table-hover dynamicTables">
                <thead>
                    <tr>
                        <th>Receipt No</th>
                        <th>Date</th>
                        <th>Tenant</th>
                        <th>House</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Amount</th>
                        <!--th>Bank account</th-->
                        <!-- If the estates owner/admin is logged in -->
                        <?php if ($_SESSION['role'] == 4 || $_SESSION['role'] == 3): ?>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_cash = 0;
                    if (!empty($payments)):
                        ?>
                        <?php foreach ($payments as $payment): ?>
                            <tr>
                                <td>
                                    <a href="<?php echo site_url("payment/view/{$payment['payment_id']}"); ?>" title="Details"><?php echo $payment['payment_id']; ?></a>
                                </td>
                                <td><?php echo mdate("%j%S %M, %Y", $payment['payment_date']); ?></td>
                                <td><a href="<?php echo site_url("tenant/view/{$payment['tenant_id']}"); ?>" title="Tenant details"><?php echo $payment['names']; ?></a></td>
                                <td><a href="<?php echo site_url("house/view/{$payment['house_id']}"); ?>" title="House details"><?php echo $payment['house_no']; ?></a></td>
                                <td><?php echo mdate('%j%S %M, %Y', strtotime($payment['start_date'])); ?></td>
                                <td><?php echo mdate('%j%S %M, %Y', strtotime($payment['end_date'])); ?></td>
                                <td><?php
                                    echo number_format($payment['amount']);
                                    $total_cash += $payment['amount'];
                                    ?></td>
                                <!--td><?php if (isset($payment['acc_id'])): ?><?php echo $payment['acc_no']; ?>, <?php echo $payment['bank_name']; ?><?php endif; ?></td-->

                                <!-- If the estates owner/admin is logged in -->
                                <?php if ($_SESSION['role'] == 4 || $_SESSION['role'] == 3) { ?>
                                    <td>
                                        <a href="<?php echo site_url("payment/update/{$payment['payment_id']}"); ?>" title="Update payment details" ><span class="fa fa-edit"></span></a>
                                    </td>
                                    <td>
                                        <a href="<?php echo site_url("payment/del_payment/{$payment['payment_id']}"); ?>" onclick="return confirm_delete('<?php echo "the payment Ref#" . $payment['payment_id']; ?>');" title="Delete"><span class="fa fa-trash text-danger"></span></a>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="6">TOTAL (UGX)</th>
                        <th><?php echo number_format($total_cash); ?></th>
                        <!--th>&nbsp;</th-->
                        <!-- If the estates owner/admin is logged in -->
                        <?php if ($_SESSION['role'] == 4 || $_SESSION['role'] == 3) { ?>
                            <th colspan="2"></th>
                        <?php } ?>
                    </tr>
                </tfoot>
            </table>
            <?php echo $pag_links; ?>
        </div><!-- /.box -->
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<script type="text/javascript">
    $(function () {

        var start = moment(<?php echo (set_value('start') != NULL) ? (set_value("start") . ",'X')") : ").startOf('month')"; ?>;
                var end = moment(<?php echo (set_value('end') != NULL) ? set_value("end") . ",'X'" : ""; ?>);
        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportrange').daterangepicker({
            "showDropdowns": true, //
            "linkedCalendars": true,
            startDate: start,
            endDate: end,
            "minDate": "<?php echo mdate('%m/%d/%Y', strtotime('-10 year')); ?>",
            "maxDate": "<?php echo mdate('%m/%d/%Y'); ?>",
            locale: {
                applyLabel: 'Search'
            },
            //format: 'DD/MM/YYYY',
            ranges: {
                'This Month': [moment().startOf('month'), moment()],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'Past 6 Months': [moment().subtract(6, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'Past 1 Year': [moment().subtract(1, 'year').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb).on('apply.daterangepicker', function (ev, picker) {
            //do something, like clearing an input
            $("#startDate").val(picker.startDate.format('X'));
            $("#endDate").val(picker.endDate.format('X'));
            $("#getPaymentsForm").submit();
            //$.post({url:"<?php echo current_url(); ?>",data:{start:startDate,end:endDate},success:function(){location.reload();}});
        });
        cb(start, end);

    });
</script>