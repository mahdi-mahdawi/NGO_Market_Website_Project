<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo lang('editmenu.header')?></h3>
    </div>
    <div class="panel-body">
        <?php echo form_open('admin/cms/menu/load_edit_form/' . $menu_details['menu_id'], array('role' => 'form', 'id' => 'form-edit-menu')); ?>
        <div class="form-group <?php if (form_error('menu')) echo 'has-error'; ?>">
            <label for="" ><?php echo lang('name')?></label>
            <input type="text" class="form-control" name="menu" id="menu" value="<?php echo set_value('menu', $menu_details['name']) ?>">
            <?php echo form_error('menu'); ?>
        </div>
        <div class="form-group <?php if (form_error('page')) echo 'has-error'; ?>">
            <label for=""><?php echo lang('page_to_link')?></label>
            <select class="form-control select2" name="page" id="page">
                <option value="">###</option>
                <?php if ($page): ?>
                    <?php foreach ($page as $page_id => $page_name): ?>
                        <option value="<?php echo $page_id; ?>"<?php echo set_select('page', $page_id, ($menu_details['page_id'] == $page_id) ? TRUE : FALSE); ?>><?php echo $page_name; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <?php echo form_error('page'); ?>
            <p><small><?php echo lang('create_page')?> <a href="<?php echo base_url('admin/cms/page'); ?>"><?php echo lang('page_manager')?></small></a></p>
        </div>
        <div class="form-group <?php if (form_error('header_menu')) echo 'has-error'; ?>">
            <label for=""></label>
            <input type="checkbox" value="1" name="header_menu" <?php echo set_checkbox('header_menu', 1, ($menu_details['header_menu'] == 1) ? TRUE : FALSE); ?>/>
            <?php echo lang('show_navigation')?>
            <?php echo form_error('header_menu'); ?>
        </div>
        <div class="form-group  <?php if (form_error('footer_menu')) echo 'has-error'; ?>">
            <label for=""></label>
            <input type="checkbox" value="1" name="footer_menu" <?php echo set_checkbox('footer_menu', 1, ($menu_details['footer_menu'] == 1) ? TRUE : FALSE); ?> id="footer_menu" />
            <?php echo lang('show_footer')?>
            <?php echo form_error('footer_menu'); ?>
        </div>

        <button type="submit" class="btn btn-purple btn-loading" name="submit" value="SAVE">&nbsp;<?php echo lang('update')?>&nbsp;</button>
        <input type="hidden" name="submit" value="1">
        <?php echo form_close(); ?>
    </div>
</div>