<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo lang('change_password')?></h3>
    </div>

    <div class="panel-body">
        <?php echo form_open(base_url('admin/profile/change_password/'), array('class' => 'form-horizontal')); ?>
        <div class="form-group <?php if (form_error('old_pass')) echo 'has-error'; ?>">
            <label for="" class="col-sm-3 control-label"><?php echo lang('old_password')?></label>
            <div class="col-sm-5">
                <input type="password" class="form-control" name="old_pass" id="name"  value="<?php echo set_value('old_pass') ?>" data-rule-required="true">
                <?php echo form_error('old_pass'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('new_pass')) echo 'has-error'; ?>">
            <label for="" class="col-sm-3 control-label"><?php echo lang('new_password')?></label>
            <div class="col-sm-5">
                <input type="password" class="form-control" name="new_pass" id="email"  value="<?php echo set_value('new_pass') ?>" data-rule-required="true">
                <?php echo form_error('new_pass'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('conf_pass')) echo 'has-error'; ?>">
            <label for="" class="col-sm-3 control-label"><?php echo lang('confirm_password')?></label>
            <div class="col-sm-5">
                <input type="password" class="form-control" name="conf_pass" id="name"  value="<?php echo set_value('conf_pass') ?>" data-rule-required="true">
                <?php echo form_error('conf_pass'); ?>
            </div>
        </div>

        <div class="form-group m-b-0">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-purple btn-loading" name="submit" value="CHANGE">&nbsp;&nbsp; <?php echo lang('save.button')?> &nbsp;&nbsp;</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>