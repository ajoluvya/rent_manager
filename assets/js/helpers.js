var period_start_array = ['1st minute', 'Midnight', 'Monday', '1st of'];
var period_start_array2 = ['minute', 'hour', 'day', 'day'];//set options value afterwards
var setOptionValue = function (propId) {
    return function (option, item) {
        if (item === undefined) {
            option.value = "";
        } else {
            option.value = item[propId];
        }
    };
};
function confirm_delete(delValue)
{
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
            if(named_item.type === 'radio' || named_item.type === 'checkbox' ){
                $(named_item).prop("checked",(named_item.value==val?true:false));
            }
            else{
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
$(".modal").on("hide.bs.modal", function () {
    // put your default event here
    $('form', this)[0].reset();
    //the assumption is that the input element with name=id will always be the first, cause of no other better selection criteria
    //$('input[name$="id"]', this).val('');
    $('input[name$="id"]:eq(0)', this).val('');
});
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    //.responsive.recalc()
});	