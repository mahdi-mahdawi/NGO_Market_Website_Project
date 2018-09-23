<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo lang('edituser.header')?></h3>
    </div>
    <div class="panel-body">
        <?php echo form_open(base_url('admin/user/user/edit/' . $list[0]['id']), array('class' => 'form-horizontal')); ?>
        <div class="form-group <?php if (form_error('first_name')) echo 'has-error'; ?>">
            <label for="first_name" class="col-sm-3 control-label"><?php echo lang('first_name')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo set_value('first_name', $list[0]['first_name']); ?>">
                <?php echo form_error('first_name'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('last_name')) echo 'has-error'; ?>">
            <label for="last_name" class="col-sm-3 control-label"><?php echo lang('last_name')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo set_value('last_name', $list[0]['last_name']); ?>">
                <?php echo form_error('last_name'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('email')) echo 'has-error'; ?>">
            <label for="email" class="col-sm-3 control-label"><?php echo lang('email')?></label>
            <div class="col-sm-5">
                <input type="email" class="form-control" id="email" name="email" value="<?php echo set_value('email', $list[0]['email']); ?>">
                <?php echo form_error('email'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('password')) echo 'has-error'; ?>">
            <label for="password" class="col-sm-3 control-label"><?php echo lang('password')?></label>
            <div class="col-sm-5">
                <input type="password" class="form-control" id="password" name="password" value="">
                <?php echo form_error('password'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('phone')) echo 'has-error'; ?>">
            <label for="phone" class="col-sm-3 control-label"><?php echo lang('phone')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo set_value('phone', $list[0]['phone']); ?>">
                <?php echo form_error('phone'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('language')) echo 'has-error'; ?>">
            <label for="language" class="col-sm-3 control-label"><?php echo lang('language')?></label>
            <div class="col-sm-5">
                <select class="form-control" name="language">
                    <option value="">Select</option>
                    <?php foreach ($languages as $row): ?>
                        <option  value="<?php echo $row['code'] ?>" <?php echo set_select('language', $row['code'], ($list[0]['user_language'] == $row['code']) ? TRUE : FALSE); ?>><?php echo $row['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <?php echo form_error('language'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('status')) echo 'has-error'; ?>">
            <label for="status" class="col-sm-3 control-label"><?php echo lang('status')?></label>
            <div class="col-sm-2">
                <select class="form-control" name="status" id="status">
                    <option <?php echo set_select('status', 1, ($list[0]['status'] == 1) ? TRUE : FALSE); ?> value="1"><?php echo lang('active')?></option>
                    <option <?php echo set_select('status', 0, ($list[0]['status'] == 0) ? TRUE : FALSE); ?> value="0"><?php echo lang('inactive')?></option>
                </select>
                <?php echo form_error('status'); ?>
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