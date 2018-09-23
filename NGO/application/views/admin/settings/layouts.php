<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo lang('layouts.header')?></h3>
    </div>
    <div class="panel-body">
        <?php echo form_open(base_url('admin/settings/layouts/'), array('class' => 'form-horizontal')); ?>
        <div class="form-group <?php if (form_error('layouts')) echo 'has-error'; ?>">
            <label for="menu_layouts" class="col-sm-3 control-label"><?php echo lang('layouts')?></label>
            <div class="col-sm-5">
                <label class="radio">
                    <input type="radio" name="menu_layout" value="1" <?php echo set_checkbox('menu_layout', 1, ($settings['menu_layout'] == 1) ? TRUE : FALSE) ?>>Layout 1
                </label>
                <label class="radio">
                    <input type="radio" name="menu_layout" value="2" <?php echo set_checkbox('menu_layout', 2, ($settings['menu_layout'] == 2) ? TRUE : FALSE) ?>>Layout 2
                </label>
                <label class="radio">
                    <input type="radio" name="menu_layout" value="3" <?php echo set_checkbox('menu_layout', 3, ($settings['menu_layout'] == 3) ? TRUE : FALSE) ?>>Layout 3
                </label>
                <?php echo form_error('layouts'); ?>
            </div>
        </div>
        
        <div class="form-group  <?php if (form_error('theme_color')) echo 'has-error'; ?>">
            <label for="theme_color" class="col-sm-3 control-label"><?php echo lang('theme_color')?></label>
            <div class="input-group">
                <input style="width:200px;" type="text" id="cp2"  value="<?php echo (form_error('theme_color')) ? set_value('theme_color') : $settings['theme_color']; ?>" name ="theme_color" class="form-control colorpicker-component" />
            </div>
        </div>
        
        <div class="form-group m-b-0">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-purple btn-loading" name="submit" value="UPDATE">&nbsp;&nbsp; <?php echo lang('update')?> &nbsp;&nbsp;</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>