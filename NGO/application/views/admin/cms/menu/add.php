<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo lang('addmenu.header')?></h3>
    </div>
    <div class="panel-body">
        <?php echo form_open('admin/cms/menu/add', array('role' => 'form', 'id' => 'form-add-menu')); ?>
        <div class="form-group <?php if (form_error('menu')) echo 'has-error'; ?>">
            <label for="" ><?php echo lang('name')?></label>
            <input type="text" class="form-control" name="menu" id="menu" value="<?php echo set_value('menu') ?>">
            <?php echo form_error('menu'); ?>
        </div>
        <div class="form-group <?php if (form_error('page')) echo 'has-error'; ?>">
            <label for=""><?php echo lang('page_to_link')?></label>
            <select class="form-control select2" name="page" id="page">
                <option value="">###</option>
                <?php if ($page): ?>
                    <?php foreach ($page as $page_id => $page_name): ?>
                        <option value="<?php echo $page_id; ?>"<?php echo set_select('page', $page_id, (set_value('page') == $page_id) ? TRUE : FALSE); ?>><?php echo $page_name; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <?php echo form_error('page'); ?>
            <br/><br/>
            <p><small><?php echo lang('create_page')?> <a href="<?php echo base_url('admin/cms/page/add'); ?>"><?php echo lang('page_manager')?></a></small></p>
        </div>
        <div class="form-group <?php if (form_error('header_menu')) echo 'has-error'; ?>">
            <label for=""></label>
            <input type="checkbox" value="1" name="header_menu" <?php echo set_checkbox('header_menu', 1); ?>/>
            <?php echo lang('show_navigation')?>
            <?php echo form_error('header_menu'); ?>
        </div>
        <div class="form-group  <?php if (form_error('footer_menu')) echo 'has-error'; ?>">
            <label for=""></label>
            <input type="checkbox" value="1" name="footer_menu" <?php echo set_checkbox('footer_menu', 1); ?> id="footer_menu" />
            <?php echo lang('show_footer')?>
            <?php echo form_error('footer_menu'); ?>
        </div>
        <button type="submit" class="btn btn-purple btn-loading" name="submit" value="SAVE">&nbsp;<?php echo lang('create')?>&nbsp;</button>
        <?php echo form_close(); ?>
    </div>
</div>