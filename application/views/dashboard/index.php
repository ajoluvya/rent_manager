<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab-1"><i class="fa fa-list-alt"></i> At a Glance</a></li>
                        <li><a data-toggle="tab" href="#tab-2" ><i class="fa fa-bar-chart-o"></i> Reports</a></li>
                    </ul>
                    <div class="tab-content">
                        <!-- Summary section -->
                        <div id="tab-1" class="tab-pane active">
                            <div class="col-md-12">
                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">Quick Actions</h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-md-2">
                                            <a class="btn btn-sm btn-primary" href="<?php echo site_url("tenant/create/"); ?>" title="Add new tenant"><i class="fa fa-user"></i> New Tenant</a>
                                        </div>
                                        <div class="col-md-2">
                                            <a class="btn btn-sm btn-primary" href="<?php echo site_url("tenant/"); ?>" title="View all tenants"><i class="fa fa-user"></i> Tenants</a>
                                        </div>
                                        <div class="col-md-2">
                                            <a class="btn btn-sm btn-warning" href="<?php echo site_url("payment/create/"); ?>" title="Add new payment"><i class="fa fa-usd"></i> New Payment</a>
                                        </div>
                                        <div class="col-md-2">
                                            <a class="btn btn-sm btn-warning" href="<?php echo site_url("payment"); ?>" title="View all payments"><i class="fa fa-usd"></i> Payments</a>
                                        </div>
                                        <div class="col-md-2">
                                            <a class="btn btn-sm btn-info" href="<?php echo site_url("user/create/"); ?>" title="Add new user"><i class="fa fa-user"></i> New User</a>
                                        </div>
                                        <div class="col-md-2">
                                            <a class="btn btn-sm btn-info" href="<?php echo site_url("user"); ?>" title="View all users"><i class="fa fa-users"></i> Users</a>
                                        </div>
                                    </div> <!-- /.box-body -->
                                </div><!-- /.box -->
                            </div> <!-- .col-md-12 -->
                            <div class="col-md-12">
                                <div class="col-sm-6" data-bind="with:summaries">
                                        <h4><i class="fa fa-money"></i> Total Payments</h4>
                                            <div id="payments_chart_div" style="min-width: 310px; height: 250px; margin: 0 auto"></div>
                                            <label class="col-sm-4">Total (UGX) <span data-bind="text: curr_format(parseFloat(payments.total.amt_paid)*1)"></span></label>
                                            <label class="col-sm-4">Default amount (UGX) <span data-bind="text: curr_format(parseFloat(payments.total.amt_paid)*1)"></span></label>
                                            <label class="col-sm-4">Terminated arrears (UGX) <span data-bind="text: curr_format(parseFloat(payments.total.amt_paid)*1)"></span></label>
                                </div><!-- /.col-sm-6 -->
                                <div class="col-sm-6" data-bind="with:summaries">
                                        <h4 class="box-title"><i class="fa fa-hotel"></i> Room Occupancy</h4>
                                        <div class="col-md-6">
                                            <div id="tenancies_chart_div" style="min-width: 250px; height: 250px; max-width: 300px; margin: 0 auto"></div>
                                            <label>Current/Max. Possible tenancies: <span data-bind="text: tenancy.current.count"></span>/<span data-bind="text: tenancy.max_tenancies.count"></span></label>
                                        </div> <!-- /.col-md-6 -->
                                        <div class="col-md-6">
                                            <div id="room_occupancy_chart_div" style="min-width: 250px; height: 250px; max-width: 300px; margin: 0 auto"></div>
                                            <label>Vacant/Total rooms: <span data-bind="text: tenancy.un_occupied_rooms.count"></span>/<span data-bind="text: tenancy.total.count"></span></label>
                                        </div> <!-- /.col-md-6 -->
                               </div><!-- /.col-sm-6 -->
                            </div> <!-- .col-md-8 -->
                        </div> <!-- tab-1 end Summary section -->
                    </div><!-- tab-content -->
                </div><!-- tabs-container -->
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<script type="text/javascript">
    $(document).ready(function () {
        var DashboardModel = function () {
            var self = this;
            self.summaries = ko.observable(<?php echo json_encode($summaries); ?>);
        }
        var dashboardModel = new DashboardModel();
        ko.applyBindings(dashboardModel);

        /*var tenancies_data = {
         element: "tenancies_pie",
         title: {text: "Tenancies"},
         series: {name: "Current/Maximum possible",
         data: [
         {name: "Current", y: parseInt(dashboardModel.summaries().tenancy.current.count) * 1},
         {name: "Max. Possible", y: parseInt(dashboardModel.summaries().tenancy.max_tenancies.count) * 1}
         ]
         }
         };
         draw_pie_highchart(tenancies_data);
         
         var room_occupancy_data = {
         element: "room_occupancy_pie",
         title: {text: "Room occupancy"},
         series: {name: "Vacant/Total rooms",
         data: [
         {name: "Vacant", y: parseInt(dashboardModel.summaries().tenancy.un_occupied_rooms.count) * 1},
         {name: "Total", y: parseInt(dashboardModel.summaries().tenancy.total.count) * 1}
         ]
         }
         };
         draw_pie_highchart(room_occupancy_data);*/

        var column_chart_data = {
            chart: {type: "column"},
            title: {text: "Payments/Defaults"},
            xAxis: {
                categories: ['Payments/Defaults/Arrears'],
                crosshair: true,
                title: {text: "Category"}
            },
            yAxis: {
                min: 0,
                title: {text: "Amount (UGX)", align: "high"},
                labels: {overflow: "justify"}
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },
            series: [
                {
                    name: "Paid",
                    data: [
                        parseFloat(dashboardModel.summaries().payments.total.amt_paid) * 1
                    ]
                },
                {
                    name: "Default",
                    data: [
                        parseFloat(dashboardModel.summaries().payments.total.amt_paid) * 1
                    ]
                },
                {
                    name: "Arrears",
                    data: [
                        parseFloat(dashboardModel.summaries().payments.total.amt_paid) * 1
                    ]
                }
            ]
        };
        draw_line_highchart("payments_chart_div", column_chart_data);

        var tenancies_bar_chart_data = {
            chart: {type: "column"},
            title: {text: "Current/Max. Possible Tenancies"},
            xAxis: {
                categories: ['Tenancies']
            },
            yAxis: {
                min: 0,
                title: {text: "Tenancies"}
            },
            legend: {
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [
                {
                    name: "Current",
                    data: [
                        parseInt(dashboardModel.summaries().tenancy.current.count) * 1
                    ]
                },
                {
                    name: "Max. possible",
                    data: [
                        parseInt(dashboardModel.summaries().tenancy.max_tenancies.count) * 1
                    ]
                }
            ]
        };
        draw_line_highchart("tenancies_chart_div" , tenancies_bar_chart_data);
        
        tenancies_bar_chart_data.title.text = "Vacant/Total rooms";
        tenancies_bar_chart_data.yAxis.title.text = "No. of rooms";
        tenancies_bar_chart_data.xAxis.categories = ["Category"];
        tenancies_bar_chart_data.series = [
            {name:"Vacant", data: [parseInt(dashboardModel.summaries().tenancy.un_occupied_rooms.count) * 1]},
            {name:"Total", data: [parseInt(dashboardModel.summaries().tenancy.total.count) * 1]}
        ];
        draw_line_highchart("room_occupancy_chart_div" , tenancies_bar_chart_data);
    });
</script>