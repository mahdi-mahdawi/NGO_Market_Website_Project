<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo lang('email.header')?></h3>
    </div>
    <div class="panel-body">
        <?php echo form_open(base_url('admin/settings/email'), array('class' => 'form-horizontal')); ?>
        <div class="spacer-10"></div>
        <div class="form-group <?php if (form_error('admin_from_email')) echo 'has-error'; ?>">
            <label for="" class="col-sm-3 control-label"><?php echo lang('from_email')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" data-rule-required="true" name="admin_from_email" id="admin_from_email" value="<?php echo (validation_errors()) ? set_value('admin_from_email') : $details['admin_from_email']; ?>">
                <?php echo form_error('admin_from_email'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('admin_from_name')) echo 'has-error'; ?>">
            <label for="" class="col-sm-3 control-label"><?php echo lang('from_name')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" data-rule-required="true" name="admin_from_name" id="super_admin_from_email" value="<?php echo (validation_errors()) ? set_value('admin_from_name') : $details['admin_from_name']; ?>" >
                <?php echo form_error('admin_from_name'); ?>
            </div>
        </div>  
        <div class="form-group <?php if (form_error('smtp_host')) echo 'has-error'; ?>">
            <label for="" class="col-sm-3 control-label"><?php echo lang('smtp_host')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control"   name="smtp_host" id="smtp_host" value="<?php echo (validation_errors()) ? set_value('smtp_host') : $details['smtp_host']; ?>">
                <?php echo form_error('smtp_host'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('smtp_port')) echo 'has-error'; ?>">
            <label for="" class="col-sm-3 control-label"><?php echo lang('smtp_port')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control"  name="smtp_port" id="smtp_port" value="<?php echo (validation_errors()) ? set_value('smtp_port') : $details['smtp_port']; ?>">
                <?php echo form_error('smtp_port'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('smtp_username')) echo 'has-error'; ?>">
            <label for="" class="col-sm-3 control-label"><?php echo lang('smtp_username')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control"   name="smtp_username" id="smtp_username" value="<?php echo (validation_errors()) ? set_value('smtp_username') : $details['smtp_username']; ?>">
                <?php echo form_error('smtp_username'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('smtp_password')) echo 'has-error'; ?>">
            <label for="" class="col-sm-3 control-label"><?php echo lang('smtp_password')?></label>
            <div class="col-sm-5">
                <input type="password" class="form-control"  name="smtp_password" id="smtp_password" value="<?php echo (validation_errors()) ? set_value('smtp_password') : $details['smtp_password']; ?>">
                <?php echo form_error('smtp_password'); ?>
            </div>
        </div>
        <div class="form-group m-b-0">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-purple btn-loading" name="submit" value="EDIT">&nbsp;&nbsp; <?php echo lang('update')?> &nbsp;&nbsp;</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>