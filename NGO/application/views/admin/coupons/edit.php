<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo lang('editcoupon.header')?></h3>
    </div>
    <div class="panel-body">
        <?php echo validation_errors();?>
        <?php echo form_open(base_url('admin/coupons/edit/' . $details['id']), array('class' => 'form-horizontal')); ?>
        
        <div class="form-group <?php if (form_error('code')) echo 'has-error'; ?>">
            <label for="" class="col-sm-3 control-label"><?php echo lang('code')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="code" id="code" value="<?php echo set_value('code', $details['code']); ?>">
                <?php echo form_error('code'); ?>
            </div>
        </div>   

        <div class="form-group <?php if (form_error('discount_type')) echo 'has-error'; ?>">
            <label for="discount_type" class="col-sm-3 control-label"><?php echo lang('discount_type')?></label>
            <div class="col-sm-2">
                <select class="form-control" name="discount_type" id="discount_type">
                    <option <?php echo set_select('discount_type', 'percentage', ($details['discount_type'] == 'percentage') ? TRUE : FALSE); ?> value="percentage">Percentage</option>
                    <option <?php echo set_select('discount_type', 'fixed_amount', ($details['discount_type'] == 'fixed_amount') ? TRUE : FALSE); ?> value="fixed_amount">Fixed</option>
                </select>
                <?php echo form_error('discount_type'); ?>
            </div>
        </div>
        
        <div class="form-group <?php if (form_error('discount')) echo 'has-error'; ?>">
            <label for="" class="col-sm-3 control-label"><?php echo lang('discount')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="discount" id="discount"  value="<?php echo set_value('discount', $details['discount']); ?>">
                <?php echo form_error('discount'); ?>
            </div>
        </div>

        <div class="form-group <?php if (form_error('start_date')) echo 'has-error'; ?>">
            <label for="" class="col-sm-3 control-label"><?php echo lang('start_date')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control datetime-picker" name="start_date" id="start_date"  value="<?php echo set_value('start_date',date("m/d/Y", strtotime($details['start_date']))); ?>">
                <?php echo form_error('start_date'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('end_date')) echo 'has-error'; ?>">
            <label for="" class="col-sm-3 control-label"><?php echo lang('end_date')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control datetime-picker" name="end_date" id="end_date"  value="<?php echo set_value('end_date', date("m/d/Y", strtotime($details['end_date']))); ?>">
                <?php echo form_error('end_date'); ?>
            </div>
        </div>
        
        <div class="form-group <?php if (form_error('status')) echo 'has-error'; ?>">
            <label for="status" class="col-sm-3 control-label"><?php echo lang('status')?></label>
            <div class="col-sm-2">
                <select class="form-control" name="status" id="status">
                    <option <?php echo set_select('status', 1, ($details['status'] == 1) ? TRUE : FALSE); ?> value="1"><?php echo lang('active')?></option>
                    <option <?php echo set_select('status', 0, ($details['status'] == 0) ? TRUE : FALSE); ?> value="0"><?php echo lang('inactive')?></option>
                </select>
                <?php echo form_error('status'); ?>
            </div>
        </div>
        <div class="form-group m-b-0">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-purple btn-loading" name="submit" value="ADD">&nbsp;&nbsp <?php echo lang('update')?> &nbsp;&nbsp;</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>