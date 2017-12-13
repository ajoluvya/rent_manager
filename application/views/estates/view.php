<div class="row">'
    <div class="col-lg-12">
        <div class="tabs-container" id="estates_page">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-1"><i class="fa fa-home"></i> Details</a></li>
                <li><a data-toggle="tab" href="#tab-2" ><i class="fa fa-home"></i> Apartments/Houses</a></li>
                <?php if (!empty($estate_tenants)): //display the tenants who've rented in this estate (current and past) ?>
                    <li><a data-toggle="tab" href="#tab-3"><i class="fa fa-hotel"></i> Tenants</a></li>
                    <?php if (!empty($payments)): //display the payments for this estate (current and past) ?>
                        <li><a data-toggle="tab" href="#tab-4"><i class="fa fa-credit-card"></i> Payments</a></li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
            <div class="tab-content">
                <!-- Estate Details -->
                <div id="tab-1" class="tab-pane active">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Estate: <?php echo $sub_title; ?></h3>
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
                                    <tr><th>ID</th><td><?php echo $estate['estate_id']; ?></td></tr>
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
                            <h3 class="box-title"><i class="fa fa-home"></i> Apartments/Houses </h3>
                            <div class="pull-right">
                                <div class="btn-group">
                                    <a href="#createHouseModal" data-toggle="modal" class="btn btn-default" title="Add new apartment/house/room"><i class="fa fa-plus-square"></i> Add Apartment/House/Room</a>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="col-lg-7">
                                <table class="table table-striped table-condensed table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>House No</th>
                                            <!--th>Estate</th-->
                                            <th>Fixed amount (UGX)</th>
                                            <th>&nbsp;</th>
                                            <th>&nbsp;</th>
                                            <!-- If the estates owner/admin is logged in -->
                                            <?php if ($_SESSION['role'] == 4 || $_SESSION['role'] == 3): ?>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($estate_houses)): ?>
                                            <tr><td colspan="7">No house record in database</td></tr>
                                        <?php else: ?>
                                            <?php foreach ($estate_houses as $estate_house): ?>
                                                <tr>
                                                    <td><?php echo $estate_house['house_id']; ?></td>
                                                    <td><a href="<?php echo site_url("house/view/{$estate_house['house_id']}"); ?>" title='Estate details'><?php echo $estate_house['house_no']; ?></a></td>
                                                    <!--td><?php if (isset($estate_house['estate_name'])) { ?><a href="<?php echo site_url("estate/view/{$estate_house['estate_id']}"); ?>" title="<?php echo $estate_house['estate_name']; ?> details"><?php echo $estate_house['estate_name']; ?></a><?php } ?></td-->
                                                    <td><?php echo number_format($estate_house['fixed_amount']); ?></td>
                                                    <td>
                                                        <a href="<?php echo site_url("bill/view/{$estate_house['house_id']}"); ?>" title='View bills for this house'><span class="fa fa-dollar"></span></a>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo site_url("payment/view/{$estate_house['house_id']}"); ?>" title='View payment records'><span class="fa fa-credit-card"></span></a>
                                                    </td>
                                                    <!-- If the estates owner/admin is logged in -->
                                                    <?php if ($_SESSION['role'] == 4 || $_SESSION['role'] == 3) { ?>
                                                        <td>
                                                            <a href="<?php echo site_url("house/update/{$estate_house['house_id']}"); ?>" title='Update house'><span class="fa fa-edit"></span></a>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo site_url("house/del_house/{$estate_house['house_id']}"); ?>" onclick="return confirm_delete('<?php echo "the house " . $estate_house['house_no']; ?>');" title="Delete"><span class="fa fa-trash text-danger"></span></a>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div><!-- /.col-lg-7 -->
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
                <!-- End Apartments/Houses Pane -->
                <!-- Tenants section -->
                <div id="tab-3" class="tab-pane">
                    <?php if (!empty($estate_tenants)): //display the tenants who've rented in this estate (current and past) ?>
                        <div class="box box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-hotel"></i> Tenants</h3>
                            </div>
                            <div class="box-body">
                                <div class="col-lg-12">
                                    <table class="table table-condensed table-hover dynamicTables">
                                        <thead>
                                            <tr>
                                                <th>Ref#</th>
                                                <th>Tenant</th>
                                                <th>Contacts</th>
                                                <th>Room</th>
                                                <th>Rent rate</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($estate_tenants as $estate_tenant): ?>
                                                <tr>
                                                    <td><a href="<?php echo site_url("tenancy/view/" . $estate_tenant['tenancy_id']); ?>" title="View tenancy details"> <?php echo $estate_tenant['tenancy_id']; ?></a></td>
                                                    <td><a href="<?php echo site_url("tenant/view/" . $estate_tenant['tenant_id']); ?>" title="View <?php echo $estate_tenant['names']; ?>'s details"> <?php echo $estate_tenant['names']; ?></a></td>
                                                    <td><?php echo $estate_tenant['phone1']; ?></td>
                                                    <td><a href="<?php echo site_url("tenancy/view/" . $estate_tenant['house_id']); ?>" title="View house details"> <?php echo $estate_tenant['house_no']; ?></a></td>
                                                    <td><?php echo number_format($estate_tenant['rent_rate']); ?></td>
                                                    <td><?php echo mdate('%d, %M %Y', $estate_tenant['start_date']); ?></td>
                                                    <td><?php if (isset($estate_tenant['end_date'])): ?><?php echo mdate('%d, %M %Y', $estate_tenant['end_date']); ?><?php endif; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                        </tfoot>
                                    </table>
                                </div><!-- /.col-lg-12 -->
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    <?php endif; ?>					
                </div>
                <!-- end Tenants pane -->
                <!-- Payments section -->
                <div id="tab-4" class="tab-pane">
                    <?php if (!empty($payments)): //display the payments for this estate (current and past) ?>
                        <div class="box box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-credit-card"></i> Payments</h3>
                                <!--div class="pull-right">
                                        <a class="btn btn-default" href="<?php echo site_url("payment/create/" . $tenant['tenant_id']); ?>" title="Enter payment for <?php echo $tenant['names']; ?>">
                                                <i class="fa fa-plus-square"></i> Add
                                        </a>
                                </div-->
                            </div>
                            <div class="box-body">
                                <div class="col-lg-12">
                                    <table class="table table-condensed table-hover dynamicTables">
                                        <thead>
                                            <tr>
                                                <th>Receipt No</th>
                                                <th>House No</th>
                                                <th>Payment date</th>
                                                <th>Amount paid</th>
                                                <th>Start date</th>
                                                <th>End date</th>
                                                <!--th>Details</th-->
                                                <!-- If the estates owner/admin is logged in -->
                                                <?php if ($_SESSION['role'] == 4 || $_SESSION['role'] == 3): ?>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total_payments = 0;
                                            foreach ($payments as $payment):
                                                ?>
                                                <tr>
                                                    <td><a href="<?php echo site_url("payment/view/" . $payment['payment_id']); ?>" title="View receipt"><?php echo $payment['payment_id']; ?></a></td>
                                                    <td><a href="<?php echo site_url("house/view/" . $payment['house_id']); ?>" title="View house details"><?php echo $payment['house_no']; ?></a></td>
                                                    <td><?php echo mdate('%d, %M %Y', $payment['payment_date']); ?></td>
                                                    <td><?php
                                                        $total_payments += $payment['amount'];
                                                        echo number_format($payment['amount']);
                                                        ?></td>
                                                    <td><?php echo mdate('%d, %M %Y', strtotime($payment['start_date'])); ?></td>
                                                    <td><?php echo mdate('%d, %M %Y', strtotime($payment['end_date'])); ?></td>
                                                    <!--td><?php echo $payment['particulars']; ?></td-->
                                                    <!-- If the estates owner/admin is logged in -->
                                                    <?php if ($_SESSION['role'] == 4 || $_SESSION['role'] == 3) { ?>
                                                        <td>
                                                            <a href="<?php echo site_url("payment/update/{$payment['payment_id']}"); ?>" title="Make changes to this payment" ><span class="fa fa-edit"></span></a>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo site_url("payment/del_payment/{$payment['payment_id']}"); ?>" onclick="return confirm_delete('<?php echo "the payment Ref# " . $payment['payment_id']; ?>');" title="Delete"><span class="fa fa-trash text-danger"></span></a>
                                                        </td>
                                                    <?php } ?>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Total</th>
                                                <th colspan="2">&nbsp;</th>
                                                <th><u><?php echo number_format($total_payments); ?></u></th>
                                                <th colspan="2">&nbsp;</th>
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
                    <?php endif; ?>					
                </div>
                <!-- /.Payments pane -->
            </div><!-- /.col-tab-content -->
        </div><!-- /.tabs-container -->
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<!-- row -->
<div class="modal fade" id="createHouseModal">
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
<script type="text/javascript">
    $(document).ready(function () {
        var HouseModel = function () {
            var self = this;
            self.time_interval = ko.observable();
            self.time_intervals = ko.observableArray(<?php echo json_encode($time_intervals); ?>);
            self.estate = ko.observable(<?php echo json_encode($estate); ?>);
        };
        var houseModel = new HouseModel();
        ko.applyBindings(houseModel);

        $('#estateCreationForm').on('submit', function () {
            enableDisableButton(this, true);
        });
<?php if (set_value('time_interval_id') != NULL) { ?>
            $('#time_interval_id').val(<?php echo set_value('time_interval_id'); ?>).trigger('change');
    <?php
} else {
    if (isset($estate)) {
        ?>
                $('#time_interval_id').val(<?php echo $estate['time_interval_id']; ?>).trigger('change');
        <?php
    }
}
?>
    });
</script>
