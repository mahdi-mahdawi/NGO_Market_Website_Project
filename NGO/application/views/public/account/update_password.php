<?php echo $template['partials']['page_header']; ?>

<!-- Content Row -->
<div class="row">

    <div class="col-md-3">
      
    </div>

    <div class="col-md-9">
        <?php echo form_open(''); ?>

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
                 <button type="submit" class="btn btn-primary btn-loading" name="submit" value="CHANGE">&nbsp;&nbsp; <?php echo lang('button.change'); ?> &nbsp;&nbsp;</button>
         
        <?php echo form_close(); ?>
    </div>
</div>
<!-- /.row -->
<hr>