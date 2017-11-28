<div class="row">
    <!-- left column -->
    <div class="col-md-6 col-md-offset-3">
        <!-- general form elements -->
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $sub_title; ?></h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <?php echo validation_errors("<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>", "</div>"); ?>
            <?php echo form_open(uri_string(), array('name' => 'acc_creation', 'role' => 'form')); ?>
            <div class="box-body">
                <div class="form-group">
                    <div class="col-md-4"><label for="acc_no">Account Number</label></div>
                    <div class="col-md-8"><input type="text" class="form-control" id="acc_no" name="acc_no" value="<?php echo (set_value('acc_no') != NULL) ? set_value('acc_no') : (isset($account['acc_no']) ? $account['acc_no'] : ""); ?>" placeholder="Enter account no"></div>
                </div>
                <div class="form-group">
                    <div class="col-md-4"><label for="acc_name">Account Name</label></div>
                    <div class="col-md-8"><input type="text" class="form-control" id="acc_name" name="acc_name" size="100" value="<?php echo (set_value('acc_name') != NULL) ? set_value('acc_name') : (isset($account['acc_name']) ? $account['acc_name'] : ""); ?>" placeholder="Account name"></div>
                </div>
                <div class="form-group">
                    <div class="col-md-4"><label for="bank_name">Bank</label></div>
                    <div class="col-md-8">
                        <select name="bank_name" id="bank_name" class="form-control">
                            <option>Select...</option>
                            <option value="Barclays" <?php echo (set_select('bank_name', 'Barclays') != NULL) ? "selected" : ((isset($account['bank_name']) && $account['bank_name'] == "Barclays") ? "selected" : ""); ?>>Barclays Bank</option>
                            <option value="Centenary" <?php echo (set_select('bank_name', 'Centenary') != NULL) ? "selected" : ((isset($account['bank_name']) && $account['bank_name'] == "Centenary") ? "selected" : ""); ?>>Centenary Bank</option>
                            <option value="Crane" <?php echo (set_select('bank_name', 'Crane') != NULL) ? "selected" : ((isset($account['bank_name']) && $account['bank_name'] == "Crane") ? "selected" : ""); ?>>Crane Bank</option>
                            <option value="Baroda" <?php echo (set_select('bank_name', 'Baroda') != NULL) ? "selected" : ((isset($account['bank_name']) && $account['bank_name'] == "Baroda") ? "selected" : ""); ?>>Bank of Baroda</option>
                            <option value="Stanbic" <?php echo (set_select('bank_name', 'Stanbic') != NULL) ? "selected" : ((isset($account['bank_name']) && $account['bank_name'] == "Stanbic") ? "selected" : ""); ?>>Stanbic Bank</option>
                            <option value="Finance Trust" <?php echo (set_select('bank_name', 'Finance Trust') != NULL) ? "selected" : ((isset($account['bank_name']) && $account['bank_name'] == "Finance Trust") ? "selected" : ""); ?>>Finance Trust</option>
                            <option value="Housing Finance" <?php echo (set_select('bank_name', 'Housing Finance') != NULL) ? "selected" : ((isset($account['bank_name']) && $account['bank_name'] == "Housing Finance") ? "selected" : ""); ?>>Housing Finance</option>
                            <option value="Standard Chartered" <?php echo (set_select('bank_name', 'Standard Chartered') != NULL) ? "selected" : ((isset($account['bank_name']) && $account['bank_name'] == "Standard Chartered") ? "selected" : ""); ?>>Standard Chartered</option>
                        </select>
                    </div>
                </div>
            </div><!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary"><?php echo isset($btn) ? $btn : "Submit"; ?></button>
            </div>
            </form>
        </div><!-- /.box -->

    </div><!--/.col (left) -->
</div>   <!-- /.row -->