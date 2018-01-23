</section>		
</div><!-- /.content-wrapper -->

<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
        All Rights reserved
    </div>
    <!-- Default to the left -->
    <strong><em>Copyright &copy; <?php echo mdate("%M, %Y"); ?></em> <a href="http://www.same.co.ug">SAME Estates Manager&reg;</a></strong>
</footer>

<div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->
<!-- Bootstrap Core JavaScript -->
<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>

<!-- Metis Menu Plugin JavaScript -->
<script type="text/javascript" src="<?php echo base_url("assets/js/metisMenu.min.js"); ?>"></script>
<!-- Knockout JavaScript -->
<script type="text/javascript" src="<?php echo base_url("assets/js/knockout-3.4.2.js"); ?>"></script>
<!-- Select2 JavaScript -->
<script type="text/javascript" src="<?php echo base_url("assets/js/select2.min.js"); ?>"></script>
<!-- Validator Plugin -->
<script type="text/javascript" src="<?php echo base_url("assets/js/validator.min.js"); ?>"></script>
<!-- AdminLTE App -->
<script type="text/javascript" src="<?php echo base_url("assets/js/app.min.js"); ?>"></script>
<!-- Datepicker -->
<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-datepicker.js"); ?>"></script>
<!-- Moment -->
<script type="text/javascript" src="<?php echo base_url("assets/js/moment.js"); ?>"></script>
<!-- Daterangepicker -->
<script type="text/javascript" src="<?php echo base_url("assets/js/daterangepicker.js"); ?>"></script>
<!-- Datetimepicker
<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-datetimepicker.js"); ?>"></script> -->
<!-- DataTables -->
<!--script type="text/javascript" src="<?php echo base_url("assets/js/jquery.dataTables.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/dataTables.bootstrap.min.js"); ?>"></script-->
<script type="text/javascript" src="<?php echo base_url("assets/DataTables/datatables.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/DataTables/JSZip-2.5.0/jszip.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/DataTables/pdfmake-0.1.32/vfs_fonts.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/DataTables/pdfmake-0.1.32/pdfmake.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/DataTables/DataTables-1.10.16/js/jquery.dataTables.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/DataTables/DataTables-1.10.16/js/dataTables.bootstrap.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/DataTables/Buttons-1.4.2/js/dataTables.buttons.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/DataTables/Buttons-1.4.2/js/buttons.bootstrap.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/DataTables/Buttons-1.4.2/js/buttons.flash.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/DataTables/Buttons-1.4.2/js/buttons.html5.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/DataTables/Buttons-1.4.2/js/buttons.print.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/DataTables/FixedHeader-3.1.3/js/dataTables.fixedHeader.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/DataTables/Scroller-1.4.3/js/dataTables.scroller.min.js"); ?>"></script>

<script type="text/javascript" src="<?php echo base_url("assets/js/form-validator/jquery.form-validator.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/helpers.js"); ?>"></script>
<script>
    //$.validate();
    $('.datepicker').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
        startDate: '-3d',
        endDate: '0d'
    }).on('changeDate', function (e) {
        $(e.target).trigger('change');
    });
    $(document).ready(function () {
        $('.select2able').select2();
        $('table.dynamicTables').DataTable({
            "dom": '<".col-md-7"B><".col-md-2"l><".col-md-3"f>rt<".col-md-7"i><".col-md-5"p>',
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            order: [[1, 'asc']],
            buttons: [
                'copy', 'excel', 'print'//, 'pdf'
            ]/* ,
             columnDefs: [ {
             "targets": [5],
             "orderable": false,
             "searchable": false
             }] */
        });
    });
    jQuery.fn.dataTable.Api.register('sum()', function ( ) {
        return this.flatten().reduce(function (a, b) {
            if (typeof a === 'string') {
                a = a.replace(/[^\d.-]/g, '') * 1;
            }
            if (typeof b === 'string') {
                b = b.replace(/[^\d.-]/g, '') * 1;
            }

            return a + b;
        }, 0);
    });
    /*ko.bindingHandlers.dateTimePicker = {
        init: function (element, valueAccessor, allBindingsAccessor) {
            //initialize datepicker with some optional options
            var options = allBindingsAccessor().dateTimePickerOptions || {};
            $(element).datetimepicker(options);

            //when a user changes the date, update the view model
            ko.utils.registerEventHandler(element, "dp.change", function (event) {
                var value = valueAccessor();
                if (ko.isObservable(value)) {
                    if (event.date != null && !(event.date instanceof Date)) {
                        value(event.date.toDate());
                    } else {
                        value(event.date);
                    }
                }
            });

            ko.utils.domNodeDisposal.addDisposeCallback(element, function () {
                var picker = $(element).data("DateTimePicker");
                if (picker) {
                    picker.destroy();
                }
            });
        },
        update: function (element, valueAccessor, allBindings, viewModel, bindingContext) {

            var picker = $(element).data("DateTimePicker");
            //when the view model is updated, update the widget
            if (picker) {
                var koDate = ko.utils.unwrapObservable(valueAccessor());

                //in case return from server datetime i am get in this form for example /Date(93989393)/ then fomat this
                koDate = (typeof (koDate) !== 'object') ? new Date(parseFloat(koDate.replace(/[^0-9]/g, ''))) : koDate;

                picker.date(koDate);
            }
        }
    };*/
</script>
</body>
</html>