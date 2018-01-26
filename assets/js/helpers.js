var period_start_array = ['1st minute', 'Midnight', 'Monday', '1st of', '1st of the 1st month of'];
var period_start_array2 = ['minute', 'hour', 'day', 'day', 'day of the 1st month'];//set options value afterwards
var setOptionValue = function (propId) {
    return function (option, item) {
        if (item === undefined) {
            option.value = "";
        } else {
            option.value = item[propId];
        }
    };
};
function change_tenancy_status(element, url, tenancy) {
    var allGood = confirm('Are you sure?');
    if (allGood) {
        new_status = (tenancy.status == 2 || tenancy.status == 3 ? 1 : (get_date_diff(tenancy) > 0 ? 3 : 2));
        $.post(
                url, {tenancy_id: tenancy.tenancy_id, status: new_status},
                function (response) {
                    if (response.success) {
                        tenancy.status = new_status;
                        tenancy.exit_date = moment().format('X');
                        viewModel.tenancy(tenancy);
                        var response_text = "'active'";
                        if (new_status == 2) {
                            response_text = "'terminated without arrears'";
                        }
                        if (new_status == 3) {
                            response_text = "'terminated with arrears'";
                        }
                        showStatusMessage("Tenancy status successfully changed to " + response_text, "success");
                        setTimeout(function () {
                            dTable['tblTenants'].ajax.reload(null, true);
                        }, 2000);
                    } else {
                        showStatusMessage("Tenancy status was not changed. Reason(s):<ol>" + response.message + "</ol>", "fail");
                    }
                },
                'json').fail(function (jqXHR, textStatus, errorThrown) {
            msg = "Network error. Please check your network/internet connection or get in touch with the admin.";
            switch (jqXHR.status) {
                case 500:
                    msg = "There was a server problem.\nPlease report the following message to admin\n" + textStatus;
                    break;
                case 404:
                    msg = "Data submission was unsuccessful.\n Please report the following message to admin\n" + textStatus + "\n" + errorThrown;
                    break;
                default:
                    break;
            }
            showStatusMessage(msg, "fail");
        });
    }
}
function get_time_range_display(start_date, end_date, time_interval_id, billing_starts, label) {
    ret_val = moment(start_date, 'X').format('D-MMM-YYYY') + " - " + moment(end_date, 'X').format('D-MMM-YYYY');
    date_diff = moment(end_date, 'X').diff(moment(start_date, 'X'), label);
    switch (parseInt(time_interval_id)) {
        case 1: //hourly basis
            format = (date_diff === 1 && billing_starts == 1) ? ('h:sA D-MMM-YYYY') : ('h:sA D-MMM-YYYY');
            ret_val = (moment(start_date, 'X').format(format) + " - " + moment(end_date, 'X').format(format));
            break;
        case 2: //daily basis
            format = ('dddd, D-MMM-YYYY');
            ret_val = (moment(start_date, 'X').format(format) + " - " + moment(end_date, 'X').format(format));
            break;
        case 3: //weekly basis
            ret_val = moment(start_date, 'X').format('D-MMM-YYYY') + " - " + moment(end_date, 'X').format('D-MMM-YYYY [(W]w[)]');
            break;
        case 4: //monthly billing
            format = (date_diff === 1 && billing_starts == 1) ? ('MMMM-YYYY') : ((date_diff > 0 && billing_starts == 1) ? ('MMMM-YYYY') : ('D-MMM-YYYY'));
            ret_val = (date_diff === 1 && billing_starts == 1) ? (moment(start_date, 'X').format(format)) : (moment(start_date, 'X').format(format) + " - " + moment(end_date, 'X').format(format));
            break;
        case 5: //quarterly billing
            format = (date_diff === 1 && billing_starts == 1) ? ('Qo [quarter, ] YYYY') : ((date_diff > 0 && billing_starts == 1) ? ('Qo [quarter, ] YYYY') : ('D-MMM-YYYY'));
            ret_val = (date_diff === 1 && billing_starts == 1) ? (moment(start_date, 'X').format(format)) : (moment(start_date, 'X').format(format) + " - " + moment(end_date, 'X').format(format));
            break;
    }
    return ret_val;
}
function get_date_diff(full) {
    date_diff = 0;
    switch (parseInt(full.status)) {
        case 1:
            date_diff = moment().diff(moment(full.end_date, 'X'), full.label);
            break;
        case 2:
            //date_diff = moment(full.end_date,'X').diff(moment(full.end_date,'X'), full.label);
            break;
        case 3:
            date_diff = moment(full.exit_date, 'X').diff(moment(full.end_date, 'X'), full.label);
            break;
    }
    return date_diff;
}
function printPageSection(sectionId, cssLinkTag) {
    var printContent = document.getElementById(sectionId);
    var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
    WinPrint.document.write('<link rel="stylesheet" href="' + cssLinkTag + '">');
    WinPrint.document.write('<style>.hidden-print{display:none}</style>');
    WinPrint.document.write(printContent.innerHTML);
    WinPrint.document.close();
    WinPrint.focus();
    WinPrint.print();
    WinPrint.close();
}
function zeroFill(number, width)
{
    width -= number.toString().length;
    if (width > 0)
    {
        return new Array(width + (/\./.test(number) ? 2 : 1)).join('0') + number;
    }
    return number + ""; // always return a string
}
function confirm_delete(delValue) {
    var really = confirm("Do you really want to delete " + delValue + "?");
    return really;
}
function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}
function enableDisableButton(frm, status) {
    $(frm).find(":input[type=submit], :button[type=submit]").prop("disabled", status);
}
function edit_data(data_array, form) {
    $.each(data_array, function (key, val) {
        $.map($('#' + form + ' [name="' + key + '"]'), function (named_item) {
            if (named_item.type === 'radio' || named_item.type === 'checkbox') {
                $(named_item).prop("checked", (named_item.value == val ? true : false));
            } else {
                $(named_item).val(val).trigger('change');
            }
        });
    });
}
function curr_format(n) {
    var formatted = "";
    formatted = (n < 0) ? ("(" + numberWithCommas(n * -1) + ")") : numberWithCommas(n);
    return formatted;
}
//sum up values in an array
function array_total(arr, idx) {
    var total = 0.0;
    $.each(arr, function (key, value) {
        total += parseFloat(value[idx]);
    });
    return total;
}
//given array, get the total for the transaction type
function sumUpAmount(items, transactionType) {
    var total = 0;
    if (items) {
        $.map(items, function (item) {
            total += (parseInt(item['transactionType']) == transactionType) ? (item['amount'] ? parseInt(item['amount']) : 0) : 0;
        });
    }

    return total;
}
//Bar chart
function draw_bar_chart(url_data) {
    $("#barChart").replaceWith('<canvas id="barChart"></canvas>');
    var ctx = $("#barChart").get(0).getContext("2d");

    var barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: url_data.labels,
            datasets: url_data.datasets
        },
        options: {
            scales: {
                yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
            }
        }
    });
}
// Line chart
function draw_line_chart(url_data) {
    $("#lineChart").replaceWith('<canvas id="lineChart"></canvas>');
    var ctx = $("#lineChart").get(0).getContext("2d");

    var lineOptions = {
        scaleShowGridLines: true,
        scaleGridLineColor: "rgba(0,0,0,.05)",
        scaleGridLineWidth: 1,
        bezierCurve: true,
        bezierCurveTension: 0.4,
        pointDot: true,
        pointDotRadius: 4,
        pointDotStrokeWidth: 1,
        pointHitDetectionRadius: 20,
        datasetStroke: true,
        datasetStrokeWidth: 2,
        datasetFill: true,
        responsive: true,
    };
    var lineChart = new Chart(ctx, {
        type: 'line',
        data: url_data,
        options: lineOptions
    });
}
function draw_line_highchart(url_data) {
    Highcharts.chart('lineChart', {

        title: url_data.title,

        yAxis: url_data.yAxis,
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        xAxis: {categories: url_data.xAxis.categories},
        plotOptions: {
            line: {
                dataLabels: {enabled: true}
            }
        },
        series: url_data.datasets
    });
}
// Pie chart
function draw_pie_chart(url_data) {
    // Build the chart
    Highcharts.chart('pieChart', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: url_data.title,
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: [{
                name: url_data.series.name,
                colorByPoint: true,
                data: url_data.series.data
            }]
    });
}
/* Save function called when various buttons with .save are clicked */
function saveData() {
    var fmid = $(this).closest("form");
    var frmdata = fmid.serialize();
    var tbl_id = fmid.attr("id");
    $.ajax({
        url: "save_data.php",
        type: 'POST',
        data: frmdata,
        success: function (response) {
            if ($.trim(response) == "success") {
                fmid[0].reset();
                showStatusMessage("Successfully added new record", "success");
                setTimeout(function () {
                    var dt = dTable[tbl_id];
                    dt.ajax.reload();
                }, 2000);
            } else {//"Action not successful"
                showStatusMessage(response, "failed");
            }

        }
    });

    return false;
}
function showStatusMessage(message = '', display_type = 'success') {
    new PNotify({
        title: "Action response",
        text: message,
        type: display_type,
        styling: 'bootstrap3',
        sound: true,
        hide: true,
        buttons: {
            closer_hover: false,
        },
        confirm: {
            confirm: true,
            buttons: [{
                    text: 'Ok',
                    addClass: 'btn-primary',
                    click: function (notice) {
                        notice.remove();
                    }
                },
                null]
        },
        animate: {
            animate: true,
            in_class: 'zoomInLeft',
            out_class: 'zoomOutRight'
        },
        nonblock: {
            nonblock: true
        }

    });

}
$(".modal").on("hide.bs.modal", function () {
    // put your default event here
    if ($('form', this).length) {
        $('form', this)[0].reset();
        //the assumption is that the input element with name=id will always be the first, cause of no other better selection criteria
        //$('input[name$="id"]', this).val('');
        $('input[name$="id"]:eq(0)', this).val('');
    }
});
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    //.responsive.recalc()
});	