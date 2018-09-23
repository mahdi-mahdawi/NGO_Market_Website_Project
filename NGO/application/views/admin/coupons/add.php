<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo lang('addcoupon.header')?></h3>
    </div>
    <div class="panel-body">
        <?php echo form_open(base_url('admin/coupons/add/'), array('class' => 'form-horizontal')); ?>
         
       
        <div class="form-group <?php if (form_error('code')) echo 'has-error'; ?>">
            <label for="" class="col-sm-3 control-label"><?php echo lang('code')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="code" id="code" value="<?php echo set_value('code'); ?>">
                <?php echo form_error('code'); ?>
            </div>
        </div>   
        
           <div class="form-group <?php if (form_error('discount_type')) echo 'has-error'; ?>">
            <label for="discount_type" class="col-sm-3 control-label"><?php echo lang('discount_type')?></label>
            <div class="col-sm-2">
                <select class="form-control" name="discount_type" id="discount_type">
                    <option <?php echo set_select('discount_type', 'percentage', TRUE); ?> value="percentage">Percentage</option>
                    <option <?php echo set_select('discount_type', 'fixed_amount'); ?> value="fixed_amount">Fixed</option>
                </select>
                <?php echo form_error('discount_type'); ?>
            </div>
        </div>
        
         <div class="form-group <?php if (form_error('discount')) echo 'has-error'; ?>">
            <label for="" class="col-sm-3 control-label"><?php echo lang('discount')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="discount" id="discount"  value="<?php echo set_value('discount'); ?>">
                <?php echo form_error('discount'); ?>
            </div>
        </div>
         <div class="form-group <?php if (form_error('usage_limit')) echo 'has-error'; ?>">
            <label for="" class="col-sm-3 control-label"><?php echo lang('usage_limit')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="usage_limit" id="usage_limit" value="<?php echo set_value('usage_limit'); ?>">
                <?php echo form_error('usage_limit'); ?>
            </div>
        </div>
         <div class="form-group <?php if (form_error('discount_applies_per_customer')) echo 'has-error'; ?>">
            <label for="" class="col-sm-3 control-label"><?php echo lang('discount_applies_per_customer')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="discount_applies_per_customer" id="discount_applies_per_customer"  value="1" data-rule-required="true" data-rule-number="true">
                <?php echo form_error('discount_applies_per_customer'); ?>
            </div>
        </div> 
        <div class="form-group <?php if (form_error('start_date')) echo 'has-error'; ?>">
            <label for="" class="col-sm-3 control-label"><?php echo lang('start_date')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control datetime-picker" name="start_date" id="start_date"  value="<?php echo set_value('start_date'); ?>">
                <?php echo form_error('start_date'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('end_date')) echo 'has-error'; ?>">
            <label for="" class="col-sm-3 control-label"><?php echo lang('end_date')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control datetime-picker" name="end_date" id="end_date"  value="<?php echo set_value('end_date'); ?>">
                <?php echo form_error('end_date'); ?>
            </div>
        </div>
       
        <div class="form-group <?php if (form_error('status')) echo 'has-error'; ?>">
            <label for="status" class="col-sm-3 control-label"><?php echo lang('status')?></label>
            <div class="col-sm-2">
                <select class="form-control" name="status" id="status">
                    <option <?php echo set_select('status', 1, TRUE); ?> value="1"><?php echo lang('active')?></option>
                    <option <?php echo set_select('status', 0); ?> value="0"><?php echo lang('inactive')?></option>
                </select>
                <?php echo form_error('status'); ?>
            </div>
        </div>
        <div class="form-group m-b-0">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-purple btn-loading" name="submit" value="ADD">&nbsp;&nbsp; <?php echo lang('create')?> &nbsp;&nbsp;</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>