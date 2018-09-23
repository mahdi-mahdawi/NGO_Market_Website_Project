<?php echo $template['partials']['page_header']; ?>

<!-- Content Row -->
<div class="row">

    <div class="col-md-3">
        <?php echo $template['partials']['profile_menu']; ?>
    </div>

    <div class="col-md-9">
        <?php echo form_open('account/password/'); ?>

        <div class="row">
            <div class="col-lg-8">
                <div class="form-group <?php echo (form_error('old_pass')) ? 'has-error' : ''; ?>">
                    <label><?php echo lang('label.old_password'); ?>:</label>
                    <input type="password" class="form-control" name="old_pass"/>
                    <?php echo form_error('old_pass'); ?>
                </div>
            </div>
           
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="form-group <?php echo (form_error('new_pass')) ? 'has-error' : ''; ?>">
                    <label><?php echo lang('label.new_password'); ?>:</label>
                    <input type="password" class="form-control" name="new_pass" />
                    <?php echo form_error('new_pass'); ?>
                </div>
            </div>
 
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="form-group <?php echo (form_error('conf_pass')) ? 'has-error' : ''; ?>">
                    <label><?php echo lang('label.confirm_password'); ?>:</label>
                    <input type="password" class="form-control" name="conf_pass"/>
                    <?php echo form_error('conf_pass'); ?>
                </div>
            </div>
        </div>
        <div class="form-group m-b-0">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-primary btn-loading" name="submit" value="CHANGE">&nbsp;&nbsp; <?php echo lang('button.change'); ?> &nbsp;&nbsp;</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<!-- /.row -->
<hr>