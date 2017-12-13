<div class="row">
    <div class="col-lg-12">
        <div class="tabs-container" id="estates_page">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-1"><i class="fa fa-home"></i> Details</a></li>
                <?php if (!empty($house_tenants)): //display the tenants who've rented this room (current and past) ?>
                    <li><a data-toggle="tab" href="#tab-2" ><i class="fa fa-home"></i> Tenants</a></li>
                <?php endif; ?>
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
                <?php if (!empty($house_tenants)): //display the tenants who've rented this room (current and past) ?>
                    <!-- Tenants -->
                    <div id="tab-2" class="tab-pane">
                        <div class="box box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-home"></i> Tenants</h3>
                            </div>
                            <div class="box-body">
                                <div class="col-lg-7">
                                    <table class="table table-condensed table-hover">
                                        <tr>
                                            <th>Ref#</th>
                                            <th>Tenant</th>
                                            <th>Contacts</th>
                                            <th>Rent rate</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                        </tr>
                                        <?php foreach ($house_tenants as $house_tenant): ?>
                                            <tr>
                                                <td><a href="<?php echo site_url("tenancy/view/" . $house_tenant['tenancy_id']); ?>" title="View tenancy details"> <?php echo $house_tenant['tenancy_id']; ?></a></td>
                                                <td><a href="<?php echo site_url("tenant/view/" . $house_tenant['tenant_id']); ?>" title="View <?php echo $house_tenant['names']; ?>'s details"> <?php echo $house_tenant['names']; ?></a></td>
                                                <td><?php echo $house_tenant['phone1']; ?></td>
                                                <td><?php echo number_format($house_tenant['rent_rate']); ?></td>
                                                <td><?php echo mdate('%d, %M %Y', $house_tenant['start_date']); ?></td>
                                                <td><?php if (isset($house_tenant['end_date'])): ?><?php echo mdate('%d, %M %Y', $house_tenant['end_date']); ?><?php endif; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </div><!-- /.col-lg-7 -->
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->				
                    </div><!--- Tab-2 end Tenants pane -->
                <?php endif; ?>
            </div><!-- col-tab-content -->
        </div><!-- tabs-container -->
    </div><!-- col-lg-12 -->
</div><!-- row -->