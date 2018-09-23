<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo lang('editpage.header')?></h3>
    </div>

    <div class="panel-body">
        <?php echo form_open(base_url('admin/cms/page/edit/' . $page['page_id']), array('class' => 'form-horizontal')); ?>
      
        <div class="form-group <?php if (form_error('name')) echo 'has-error'; ?>">
            <label for="name" class="col-sm-3 control-label"> <?php echo lang('page_name')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="name" value="<?php echo set_value('name', $page['name']); ?>">
                <?php echo form_error('name'); ?>
            </div>
        </div>

        <div class="form-group <?php if (form_error('page_title')) echo 'has-error'; ?>">
            <label for="page_title" class="col-sm-3 control-label"> <?php echo lang('page_title')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="page_title" value="<?php echo set_value('page_title', $page['title']); ?>">
                <?php echo form_error('page_title'); ?>
            </div>
        </div>

        <div class="form-group <?php if (form_error('page_content')) echo 'has-error'; ?>">
            <label for="page_content" class="col-sm-3 control-label"><?php echo lang('page_content')?></label>
            <div class="col-sm-8">
                <textarea class="form-control ckeditor" rows="5" name="page_content" id="editor"><?php echo set_value('page_content', $page['content']) ?></textarea>
                <?php echo form_error('page_content'); ?>
            </div>
        </div>

        <div class="form-group <?php if (form_error('page_header')) echo 'has-error'; ?>">
            <label for="page_header" class="col-sm-3 control-label"><?php echo lang('page_header')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="page_header" value="<?php echo set_value('page_header', $page['page_header']); ?>">
                <?php echo form_error('page_header'); ?>
            </div>
        </div>

        <div class="form-group <?php if (form_error('page_url')) echo 'has-error'; ?>">
            <label for="page_url" class="col-sm-3 control-label"><?php echo lang('page_url')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="page_url" value="<?php echo set_value('page_url', $page['url']); ?>" <?php echo ($page['type'] == 'd') ? 'disabled="disabled"' : '' ?>>
                <?php echo form_error('page_url'); ?>
            </div>
        </div>

        <div class="form-group <?php if (form_error('301_redirect_url')) echo 'has-error'; ?>">
            <label for="301_redirect_url" class="col-sm-3 control-label"><?php echo lang('301_redirect')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="301_redirect_url" value="<?php echo set_value('301_redirect_url', $page['301_redirect_url']); ?>">
                <?php echo form_error('301_redirect_url'); ?>
            </div>
        </div>

        <div class="form-group <?php if (form_error('canonical_url')) echo 'has-error'; ?>">
            <label for="canonical_url" class="col-sm-3 control-label"><?php echo lang('cannonical_url')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="canonical_url" value="<?php echo set_value('canonical_url', $page['canonical_url']); ?>">
                <?php echo form_error('canonical_url'); ?>
            </div>
        </div>

        <div class="form-group">
            <label for="301_redirect_status" class="col-sm-3 control-label"><?php echo lang('301_status')?></label>
            <div class="col-sm-5">
                <select class="form-control select2" name="301_redirect_status">
                    <option <?php echo set_select('301_redirect_status', 1, ($page['301_redirect_status'] == 1) ? TRUE : FALSE); ?> value="1">ON</option>
                    <option <?php echo set_select('301_redirect_status', 0, ($page['301_redirect_status'] == 0) ? TRUE : FALSE); ?> value="0">OFF</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="meta_robot_index" class="col-sm-3 control-label"><?php echo lang('meta_robot_index')?></label>
            <div class="col-sm-5">
                <select class="form-control select2" name="meta_robot_index">
                    <option <?php echo set_select('meta_robot_index', 'INDEX', ($page['meta_robots_index'] == 'INDEX') ? TRUE : FALSE); ?> value="INDEX">INDEX</option>
                    <option <?php echo set_select('meta_robot_index', 'NOINDEX', ($page['meta_robots_index'] == 'NOINDEX') ? TRUE : FALSE); ?> value="NOINDEX">NOINDEX</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="meta_robot_follow" class="col-sm-3 control-label"><?php echo lang('meta_robot_follow')?></label>
            <div class="col-sm-5">
                <select class="form-control select2" name="meta_robot_follow">
                    <option <?php echo set_select('meta_robot_follow', 'FOLLOW', ($page['meta_robots_follow'] == 'FOLLOW') ? TRUE : FALSE); ?> value="FOLLOW">FOLLOW</option>
                    <option <?php echo set_select('meta_robot_follow', 'NOFOLLOW', ($page['meta_robots_follow'] == 'NOFOLLOW') ? TRUE : FALSE); ?> value="NOFOLLOW">NOFOLLOW</option>
                </select>
            </div>
        </div>

        <div class="form-group <?php if (form_error('meta_description')) echo 'has-error'; ?>">
            <label for="meta_description" class="col-sm-3 control-label"><?php echo lang('meta_description')?></label>
            <div class="col-sm-5">
                <textarea class="form-control" rows="5" name="meta_description" id=""><?php echo set_value('meta_description', $page['meta_description']) ?></textarea>
                <?php echo form_error('meta_description'); ?>
            </div>
        </div>

        <div class="form-group <?php if (form_error('meta_keywords')) echo 'has-error'; ?>">
            <label for="meta_keywords" class="col-sm-3 control-label"><?php echo lang('meta_keywords')?></label>
            <div class="col-sm-5">
                <textarea class="form-control" rows="5" name="meta_keywords" id=""><?php echo set_value('meta_keywords', $page['meta_keywords']) ?></textarea>
                <?php echo form_error('meta_keywords'); ?>
            </div>
        </div>

        <div class="form-group">
            <label for="status" class="col-sm-3 control-label"><?php echo lang('status')?></label>
            <div class="col-sm-5">
                <select class="form-control" name="status">
                    <option <?php echo set_select('status', 1, ($page['status'] == 1) ? TRUE : FALSE); ?> value="1">Active</option>
                    <option <?php echo set_select('status', 0, ($page['status'] == 0) ? TRUE : FALSE); ?> value="0">Inactive</option>
                </select>
            </div>
        </div>

        <div class="form-group m-b-0">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" id="test_desc" class="btn btn-purple btn-loading" name="submit" value="EDIT">&nbsp;&nbsp; <?php echo lang('update')?> &nbsp;&nbsp;</button>
            </div>
        </div>
        
        <?php echo form_close(); ?>
    </div>
</div>