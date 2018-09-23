<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo lang('addfaqs.header')?></h3>
    </div>
    <div class="panel-body">
        <?php echo form_open(base_url('admin/faqs/add'), array('class' => 'form-horizontal')); ?>
        <div class="form-group <?php if (form_error('title')) echo 'has-error'; ?>">
            <label for="title" class="col-sm-3 control-label"><?php echo lang('title')?></label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="title" name="title" value="<?php echo set_value('title'); ?>">
                <?php echo form_error('title'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('description')) echo 'has-error'; ?>">
            <label for="description" class="col-sm-3 control-label"><?php echo lang('description')?></label>
            <div class="col-sm-9">
                <textarea class="form-control" rows="5" name="description" id="description"><?php echo set_value('description') ?></textarea>
                <?php echo form_error('description'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('status')) echo 'has-error'; ?>">
            <label for="status" class="col-sm-3 control-label"><?php echo lang('status')?></label>
            <div class="col-sm-4">
                <select class="form-control" name="status" id="status">
                    <option <?php echo set_select('status', 1, TRUE); ?> value="1"><?php echo lang('active')?></option>
                    <option <?php echo set_select('status', 0); ?> value="0"><?php echo lang('inactive')?></option>
                </select>
                <?php echo form_error('status'); ?>
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