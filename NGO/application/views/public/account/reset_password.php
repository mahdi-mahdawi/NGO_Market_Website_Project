<?php echo $template['partials']['page_header']; ?>

<!-- Content Row -->
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <?php echo form_open(''); ?>

        <div class="form-group <?php echo (form_error('email')) ? 'has-error' : ''; ?>">
            <label><?php echo lang('label.email'); ?>:</label>
            <input type="email" class="form-control" name="email" value="<?php echo set_value('email'); ?>" />
            <?php echo form_error('email'); ?>
        </div>


        <button type="submit" class="btn btn-primary" name="submit" value="submit"><?php echo lang('button.forgot'); ?></button> <br><br>
       
        <?php echo form_close(); ?>
    </div>
</div>
<!-- /.row -->

<hr>