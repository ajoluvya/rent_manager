<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-lg-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $sub_title; ?></h3>
                            <div class="pull-right"><a href="<?php echo site_url("tenant/create"); ?>" class="btn btn-sm btn-default" title="Add Tenant"><i class="fa fa-edit"></i> New</a></div>
                        </div>
                        <table class="table table-striped table-condensed table-hover dynamicTables">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name(s)</th>
                                    <th>Phone1</th>
                                    <th>Estate</th>
                                    <th>House No.</th>
                                    <th>Rate (UGX)</th>
                                    <th>Start Date</th>
                                    <th>Last payment</th>
                                    <th>Status</th>
                                    <th>&nbsp;</th>
                                    <!-- If the estates owner/admin is logged in -->
                                    <?php if ($_SESSION['role'] == 4 || $_SESSION['role'] == 3): ?>
                                        <th>&nbsp;</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($tenants)): ?>
                                    <?php foreach ($tenants as $key => $tenant): ?>
                                        <tr>
                                            <td><?php echo $key + 1; ?></td>
                                            <td>
                                                <a href="<?php echo site_url("tenant/view/{$tenant['tenant_id']}"); ?>" title="<?php echo $tenant['names']; ?> details"><?php echo $tenant['names']; ?></a></td>
                                            <td><?php echo $tenant['phone1']; ?></td>
                                            <td><?php if (isset($tenant['estate_name'])) { ?><a href="<?php echo site_url("estate/view/{$tenant['estate_id']}"); ?>" title="<?php echo $tenant['estate_name']; ?> details"><?php echo $tenant['estate_name']; ?></a><?php } ?></td>
                                            <td><?php if (isset($tenant['house_no'])) { ?><a href="<?php echo site_url("house/view/{$tenant['house_id']}"); ?>" title="<?php echo $tenant['house_no']; ?> details"><?php echo $tenant['house_no']; ?></a><?php } ?></td>
                                            <td><?php echo isset($tenant['rent_rate']) ? (number_format($tenant['rent_rate'])) : ""; ?></td>
                                            <td><?php echo isset($tenant['start_date']) ? (mdate('%j %M, %Y', $tenant['start_date'])) : ""; ?></td>
                                            <td>
                                                <?php
                                                echo isset($tenant['end_date']) ? (mdate('%j %M, %Y', $tenant['end_date'])) : "";
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if (isset($tenant['tenancy_id'])) {
                                                    $button_class = "warning";
                                                    $title_text = "No arrears";
                                                    $date_diff = (int) $tenant['date_diff'];
                                                    $label_text = $date_diff . " " . ($date_diff == 1 ? (substr($tenant['period_desc'], 0, -1)) : $tenant['period_desc']);

                                                    if ($date_diff > 0) {
                                                        $button_class = "info";
                                                    }
                                                    if ($date_diff < 0) {
                                                        $button_class = "danger";
                                                        $title_text = abs($date_diff) . " " . $tenant['period_desc'] . " arrears totalling Ugx: " . number_format(abs($date_diff * $tenant['rent_rate']));
                                                    }
                                                    //if the tenant is no longer renting, then show that as well
                                                    if ($tenant['status'] == 0) {
                                                        $label_text = "Ended";
                                                        $button_class = "success";
                                                    }
                                                    ?>
                                                    <span class="btn btn-sm btn-<?php echo $button_class; ?>" title="<?php echo $title_text; ?>"><?php echo $label_text; ?></span>
                                                <?php }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $tenant_link = site_url("tenant/update/{$tenant['tenant_id']}");
                                                if (isset($tenant['tenancy_id'])) {
                                                    $tenant_link = site_url("tenancy/update/{$tenant['tenancy_id']}");
                                                }
                                                ?>
                                                <?php if (!isset($tenant['tenancy_id'])||($tenant['start_date'] === $tenant['end_date'])): ?>
                                                    <a href="<?php echo $tenant_link; ?>" title="Update <?php echo $tenant['names']; ?>'s details" ><span class="fa fa-edit"></span></a>
                                                <?php endif; ?>
                                            </td>
                                            <!-- If the estates owner/admin is logged in -->
                                            <?php if ($_SESSION['role'] == 4 || $_SESSION['role'] == 3) { ?>
                                                <td>
                                                <?php if (!isset($tenant['tenancy_id'])||($tenant['start_date'] === $tenant['end_date'])): ?>
                                                    <a href="<?php echo site_url("tenant/del_tenant/{$tenant['tenant_id']}"); ?>" onclick="return confirm_delete('<?php echo "the tenant " . $tenant['names']; ?>');" title="Delete"><span class="fa fa-trash text-danger"></span></a>
                                                <?php endif; ?>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <?php echo $pag_links; ?>
                    </div><!-- /.box -->
                </div><!-- /.col-lg-12 -->
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col-lg-12 -->
</div>