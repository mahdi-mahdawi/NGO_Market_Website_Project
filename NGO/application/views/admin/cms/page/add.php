<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo lang('addpage.header')?></h3>
    </div>
    <div class="panel-body">
        <?php echo form_open(base_url('admin/cms/page/add'), array('class' => 'form-horizontal')); ?>
        <div class="form-group <?php if (form_error('name')) echo 'has-error'; ?>">
            <label for="name" class="col-sm-3 control-label"><?php echo lang('page_name')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="name" value="<?php echo set_value('name'); ?>">
                <?php echo form_error('name'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('page_title')) echo 'has-error'; ?>">
            <label for="page_title" class="col-sm-3 control-label"><?php echo lang('page_title')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="page_title" value="<?php echo set_value('page_title'); ?>">
                <?php echo form_error('page_title'); ?>
            </div>
        </div>
       <div class="form-group <?php if (form_error('page_content')) echo 'has-error'; ?>">
            <label for="page_content" class="col-sm-3 control-label"><?php echo lang('page_content')?></label>
            <div class="col-sm-8">
                <textarea class="form-control ckeditor" rows="5" name="page_content" id="editor"><?php echo set_value('page_content') ?></textarea>
                <?php echo form_error('page_content'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('page_header')) echo 'has-error'; ?>">
            <label for="page_header" class="col-sm-3 control-label"><?php echo lang('page_header')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="page_header" value="<?php echo set_value('page_header'); ?>">
                <?php echo form_error('page_header'); ?>
            </div>
        </div>

        <div class="form-group <?php if (form_error('page_url')) echo 'has-error'; ?>">
            <label for="page_url" class="col-sm-3 control-label"><?php echo lang('page_url')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="page_url" value="<?php echo set_value('page_url'); ?>">
                <?php echo form_error('page_url'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('301_redirect_url')) echo 'has-error'; ?>">
            <label for="301_redirect_url" class="col-sm-3 control-label"><?php echo lang('301_redirect')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="301_redirect_url" value="<?php echo set_value('301_redirect_url'); ?>">
                <?php echo form_error('301_redirect_url'); ?>
            </div>
        </div>

        <div class="form-group <?php if (form_error('canonical_url')) echo 'has-error'; ?>">
            <label for="canonical_url" class="col-sm-3 control-label"><?php echo lang('cannonical_url')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="canonical_url" value="<?php echo set_value('canonical_url'); ?>">
                <?php echo form_error('canonical_url'); ?>
            </div>
        </div>
       
        <div class="form-group">
            <label for="301_redirect_status" class="col-sm-3 control-label"><?php echo lang('301_status')?></label>
            <div class="col-sm-5">
                <select class="form-control select2" name="301_redirect_status">
                    <option <?php echo set_select('301_redirect_status', 1, TRUE); ?> value="1"><?php echo lang('on')?></option>
                    <option <?php echo set_select('301_redirect_status', 0); ?> value="0"><?php echo lang('off')?></option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="meta_robot_index" class="col-sm-3 control-label"><?php echo lang('meta_robot_index')?></label>
            <div class="col-sm-5">
                <select class="form-control select2" name="meta_robot_index">
                    <option <?php echo set_select('meta_robot_index', 'INDEX', TRUE); ?> value="INDEX"><?php echo lang('index')?></option>
                    <option <?php echo set_select('meta_robot_index', 'NOINDEX'); ?> value="NOINDEX"><?php echo lang('noindex')?></option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="meta_robot_follow" class="col-sm-3 control-label"><?php echo lang('meta_robot_follow')?></label>
            <div class="col-sm-5">
                <select class="form-control select2" name="meta_robot_follow">
                    <option <?php echo set_select('meta_robot_follow', 'FOLLOW', TRUE); ?> value="FOLLOW"><?php echo lang('follow')?></option>
                    <option <?php echo set_select('meta_robot_follow', 'NOFOLLOW'); ?> value="NOFOLLOW"><?php echo lang('nofollow')?></option>
                </select>
            </div>
        </div>
        <div class="form-group <?php if (form_error('meta_description')) echo 'has-error'; ?>">
            <label for="meta_description" class="col-sm-3 control-label"><?php echo lang('meta_description')?></label>
            <div class="col-sm-5">
                <textarea class="form-control" rows="3" name="meta_description" id=""><?php echo set_value('meta_description') ?></textarea>
                <?php echo form_error('meta_description'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('meta_keywords')) echo 'has-error'; ?>">
            <label for="meta_keywords" class="col-sm-3 control-label"><?php echo lang('meta_keywords')?></label>
            <div class="col-sm-5">
                <textarea class="form-control" rows="3" name="meta_keywords" id=""><?php echo set_value('meta_keywords') ?></textarea>
                <?php echo form_error('meta_keywords'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="status" class="col-sm-3 control-label"><?php echo lang('status')?></label>
            <div class="col-sm-5">
                <select class="form-control" name="status">
                    <option <?php echo set_select('status', 1, TRUE); ?> value="1"><?php echo lang('active')?></option>
                    <option <?php echo set_select('status', 0); ?> value="0"><?php echo lang('inactive')?></option>
                </select>
            </div>
        </div>
        <div class="form-group m-b-0">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-purple btn-loading" name="submit" value="ADD">&nbsp;&nbsp; <?php echo lang('create')?> &nbsp;&nbsp;</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>