<?php echo $template['partials']['page_header']; ?>

<!-- Content Row -->
<div class="row">

    <div class="col-md-3">
        <?php echo $template['partials']['profile_menu']; ?>
    </div>

    <div class="col-md-9">
        <?php echo form_open(''); ?>

        <div class="row">
            <div class="col-lg-6">
                <div class="form-group <?php echo (form_error('first_name')) ? 'has-error' : ''; ?>">
                    <label><?php echo lang('label.first_name'); ?>:</label>
                    <input type="text" class="form-control" name="first_name" value="<?php echo set_value('first_name', $profile['first_name']); ?>"/>
                    <?php echo form_error('first_name'); ?>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group <?php echo (form_error('last_name')) ? 'has-error' : ''; ?>">
                    <label><?php echo lang('label.last_name'); ?>:</label>
                    <input type="text" class="form-control" name="last_name" value="<?php echo set_value('last_name', $profile['last_name']); ?>"/>
                    <?php echo form_error('last_name'); ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="form-group <?php echo (form_error('city')) ? 'has-error' : ''; ?>">
                    <label><?php echo lang('label.city'); ?>:</label>
                    <input type="text" class="form-control" name="city" value="<?php echo set_value('city', $profile['city']); ?>"/>
                    <?php echo form_error('city'); ?>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group <?php echo (form_error('zipcode')) ? 'has-error' : ''; ?>">
                    <label><?php echo lang('label.zipcode'); ?>:</label>
                    <input type="text" class="form-control" name="zipcode" value="<?php echo set_value('zipcode', $profile['zipcode']); ?>"/>
                    <?php echo form_error('zipcode'); ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label><?php echo lang('label.email'); ?>:</label>
                    <input type="email" class="form-control" value="<?php echo set_value('email', $profile['email']); ?>" disabled="disabled" />
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group <?php echo (form_error('mobile')) ? 'has-error' : ''; ?>">
                    <label><?php echo lang('label.phone'); ?>:</label>
                    <input type="text" class="form-control" name="mobile" value="<?php echo set_value('mobile', $profile['phone']); ?>" />
                    <?php echo form_error('mobile'); ?>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" name="submit" value="submit"><?php echo lang('button.submit'); ?></button> <br><br>
        <?php echo form_close(); ?>
    </div>
</div>
<!-- /.row -->