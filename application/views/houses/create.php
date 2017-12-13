<div class="row">
    <!-- left column -->
    <div class="col-md-8 col-md-offset-2">
        <!-- general form elements -->
        <?php echo $create_modal; ?>
    </div><!--/.col (left) -->
</div>   <!-- /.row -->
<script type="text/javascript">
    $(document).ready(function () {
        var EstateModel = function () {
            var self = this;
            self.rent_period = ko.observable();
            self.time_intervals = ko.observableArray(<?php echo json_encode($time_intervals); ?>);
            self.estate = ko.observable();
            self.estates = ko.observableArray(<?php echo json_encode($estates); ?>);

        };
        var estateModel = new EstateModel();
        ko.applyBindings(estateModel);

        $('#houseCreationForm').on('submit', function () {
            enableDisableButton(this, true);
        });
<?php if (set_value('time_interval_id') != NULL) { ?>
            $('#time_interval_id').val(<?php echo set_value('time_interval_id'); ?>).trigger('change');
    <?php
} else {
    if (isset($house['time_interval_id']) && is_numeric($house['time_interval_id'])) {
        ?>
                $('#time_interval_id').val(<?php echo $house['time_interval_id']; ?>).trigger('change');
        <?php
    }
}
?>
<?php if (set_value('estate_id') != NULL) { ?>
            $('#estate_id').val(<?php echo set_value('estate_id'); ?>).trigger('change');
    <?php
} else {
    if (isset($house['estate_id']) && is_numeric($house['estate_id'])) {
        ?>
                $('#estate_id').val(<?php echo $house['estate_id']; ?>).trigger('change');
        <?php
    }
}
?>
    });
</script>