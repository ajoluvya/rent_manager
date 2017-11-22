        <!-- Main content -->
        <section class="content">
		<div class="row">
            <!-- left column -->
            <div class="col-md-6 col-md-offset-3">
              <!-- general form elements -->
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $sub_title; ?> &nbsp;<small><?php echo isset($step_text)?"Step 2 0f 3":"";?></small></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <?php echo validation_errors("<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>","</div>"); ?>
				
				<?php $form_url = isset($btn_text)?uri_string():"tenancy/create";?>
				<?php echo form_open($form_url,array('name' => 'create/update_tenancy', 'role' => 'form')); ?>
                  <div class="box-body">
                    <div class="form-group">
                      <div class="col-md-12">
					  <label for="tenant_id"><a href="<?=site_url("tenant/view/".(isset($tenant_id)?$tenant_id:set_value('tenant_id')))?>" title="View <?=((isset($tenant_names))?$tenant_names:set_value('tenant_names'))?>"><i class="fa fa-angle-double-left"></i> &nbsp;<?php echo ((isset($tenant_names))?$tenant_names:set_value('tenant_names')); ?></a></label>
					  <input type="hidden" id="tenant_id" name="tenant_id" value="<?php echo (isset($tenant_id)?$tenant_id:set_value('tenant_id')); ?>">
					  <input type="hidden" id="tenant_names" name="tenant_names" value="<?php echo (isset($tenant_names))?$tenant_names:set_value('tenant_names'); ?>">
					  </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4"><label for="estate_id">Estate</label></div>
						<div class="col-md-8">
							<select name="estate_id" data-bind="options: estates, optionsText: 'estate_name', optionsCaption: 'Select estate...', value: estate, optionsAfterRender: setOptionValue('estate_id')" class="form-control"></select>
						</div>
					</div>
                    <div class="form-group">
                      <div class="col-md-4"><label for="house_id">Apartment/House/Room</label></div>
						<div class="col-md-8">
							<select name="house_id" data-bind="options: filteredHouses(), optionsText: 'house_no', optionsCaption: 'Select house...', value: house, optionsAfterRender: setOptionValue('house_id')" class="form-control"></select>
						</div>
					</div>
                    <div class="form-group" data-bind="with: house">
                      <div class="col-md-4"><label for="rent_rate">Amount</label></div>
                      <div class="col-md-8"><div class="input-group"><span class="input-group-addon">UGX</span><input type="text" class="form-control" data-bind="value: fixed_amount" id="rent_rate" name="rent_rate" value="<?php echo (set_value('rent_rate')!=NULL)?set_value('rent_rate'):(isset($tenancy['rent_rate'])?$tenancy['rent_rate']:""); ?>" placeholder="Enter rent amount for this apartment" data-validation="number" data-validation-error-msg="Not a number/missing amount"></div>
					  </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-4"><label for="start_date">Start date</label></div>
                      <div class="col-md-8"><div class="input-group"><input type="text" class="form-control datepicker" id="start_date" name="start_date" value="<?php echo (set_value('start_date')!=NULL)?set_value('start_date'):(isset($tenancy['start_date'])?mdate("%d-%m-%Y",$tenancy['start_date']):""); ?>" placeholder="Enter start date" data-validation="date" data-validation-error-msg="Not a date/missing start date" data-validation-format="dd-mm-yyyy" data-provide="datepicker" ><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div></div>
                    </div>
                    <!--div class="form-group">
                      <div class="col-md-4"><label for="start_date">End date</label></div>
                      <div class="col-md-8"><div class="input-group"><input type="text" class="form-control datepicker" id="end_date" name="end_date" value="<?php echo (set_value('end_date')!=NULL)?set_value('end_date'):(isset($tenancy['end_date'])?mdate("%d-%m-%Y",$tenancy['end_date']):""); ?>" placeholder="Optional, end date" data-validation="date" data-validation-error-msg="Not a date value" data-validation-format="dd-mm-yyyy" data-validation-optional="true" data-provide="datepicker"><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div></div>
                    </div-->
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary"><?php echo isset($btn_text)?$btn_text:"Submit";?></button>
                  </div>
                </form>
              </div><!-- /.box -->

            </div><!--/.col (left) -->
          </div>   <!-- /.row -->
<script type="text/javascript">
$(document).ready(function () {
	var ViewModel = function(){
		var self = this;
		self.estate = ko.observable();
		self.house = ko.observable();
		self.estates = ko.observable(<?php echo json_encode($estates);?>);
		self.houses = ko.observableArray(<?php echo json_encode($houses);?>);
		
		self.filteredHouses =  ko.computed(function(){
			if(self.estate()){
				return ko.utils.arrayFilter(self.houses(), function(house) {
					return (parseInt(self.estate().estate_id)==parseInt(house.estate_id));
				});
			}
		});
		//the amount is determined based on the previous selection
		self.amount = ko.observable();
		//set options value afterwards
		self.setOptionValue = function(propId) {
			return function (option, item) {
				if (item === undefined) {
					option.value = "";
				} else {
					option.value = item[propId];
				}
			}
		};
	};
	var viewModel = new ViewModel();
	ko.applyBindings(viewModel);
	
	<?php if(isset($tenancy['estate_id'])||isset($_POST['estate_id'])):?>
		var estate_id = <?=(isset($tenancy['estate_id'])?$tenancy['estate_id']:$_POST['estate_id'])?>
		//we need to set the estate object accordingly
		viewModel.estate(ko.utils.arrayFirst(viewModel.estates(), function(currentEstate){
			return (estate_id == currentEstate.estate_id);
		}));
		$('#estate_id').val(estate_id);
	<?php endif; ?>
	
	<?php if(isset($tenancy['house_id'])||isset($_POST['house_id'])):?>
		var house_id = <?=(isset($tenancy['house_id'])?$tenancy['house_id']:$_POST['house_id'])?>
		//we need to set the house object accordingly
		viewModel.house(ko.utils.arrayFirst(viewModel.houses(), function(currentHouse){
			return (house_id == currentHouse.house_id);
		}));
		$('#house_id').val(house_id);
	<?php endif; ?>
	
	<?php if((isset($tenancy['rent_rate'])&&is_numeric($tenancy['rent_rate']))||(isset($_POST['rent_rate'])&&is_numeric($_POST['rent_rate']))):?>
		var rent_rate = <?=(isset($tenancy['rent_rate'])?$tenancy['rent_rate']:$_POST['rent_rate'])?>
		//we need to set the house object accordingly
		//viewModel.house().rent_rate = rent_rate;
		$('#house_id').val(rent_rate);
	<?php endif; ?>
});

</script>