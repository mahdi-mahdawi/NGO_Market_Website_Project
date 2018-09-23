<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo lang('edit_profile.header')?></h3>
    </div>

    <div class="panel-body">
        <?php echo form_open(base_url('admin/profile/'), array('class' => 'form-horizontal')); ?>
        <div class="form-group <?php if (form_error('first_name')) echo 'has-error'; ?>">
            <label for="first_name" class="col-sm-3 control-label"><?php echo lang('first_name')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="first_name" id="first_name"  value="<?php echo set_value('first_name', $profile['first_name']) ?>" >
                <?php echo form_error('first_name'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('last_name')) echo 'has-error'; ?>">
            <label for="last_name" class="col-sm-3 control-label"><?php echo lang('last_name')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="last_name" id="last_name"  value="<?php echo set_value('last_name', $profile['last_name']) ?>" >
                <?php echo form_error('last_name'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('email')) echo 'has-error'; ?>">
            <label for="email" class="col-sm-3 control-label"><?php echo lang('email')?></label>
            <div class="col-sm-5">
                <input type="email" class="form-control" name="email" id="email"  value="<?php echo set_value('email', $profile['email']); ?>">
                <?php echo form_error('email'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('phone')) echo 'has-error'; ?>">
            <label for="phone" class="col-sm-3 control-label"><?php echo lang('phone')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="phone" id="phone"  value="<?php echo set_value('phone', $profile['phone']); ?>" />
                <?php echo form_error('phone'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('language')) echo 'has-error'; ?>">
            <label for="language " class="col-sm-3 control-label"><?php echo lang('language')?></label>
            <div class="col-sm-5">
                <select class="form-control select2" name="language" id="language">
                    <?php foreach ($language as $row): ?>
                        <option value="<?php echo $row['code'] ?>" <?php echo set_select('language', $row['code'], ($profile['user_language'] == $row['code']) ? TRUE : FALSE) ?>><?php echo $row['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <?php echo form_error('language'); ?>
            </div>
        </div>
        <div class="form-group m-b-0">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-purple btn-loading" name="submit"  value="EDIT">&nbsp;&nbsp; <?php echo lang('update')?> &nbsp;&nbsp;</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>