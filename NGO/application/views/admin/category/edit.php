<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo lang('editcategory.header')?></h3>
    </div>
    <div class="panel-body">
        <?php echo form_open(base_url('admin/product_category/edit/' . $category['product_category_id']), array('class' => 'form-horizontal')); ?>
        <div class="form-group <?php if (form_error('name')) echo 'has-error'; ?>">
            <label for="name" class="col-sm-3 control-label"><?php echo lang('name')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name', $category['name']); ?>">
                <?php echo form_error('name'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('description')) echo 'has-error'; ?>">
            <label for="description" class="col-sm-3 control-label"><?php echo lang('description')?></label>
            <div class="col-sm-5">
                <textarea class="form-control" rows="5" name="description" id="description"><?php echo set_value('description', $category['description']) ?></textarea>
                <?php echo form_error('description'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('file_id')) echo 'has-error'; ?>">
            <label for="file" class="col-sm-3 control-label"><?php echo lang('image')?></label>
            <div class="col-sm-9 upload-holder">
                <img src="<?php echo $thumb_image_url; ?>" class="thumbnail-image" id="thumbnail-preview" width="200" height="200">
                <div class="spacer-10"></div>
                <div id="progress"><div class="bar" style="width: 0%;"></div></div>
                <span class="btn btn-success fileinput-button btn-sm">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span><?php echo lang('upload')?></span>
                    <input id="fileupload" type="file" name="file" data-folder="<?php echo $upload_folder; ?>" />
                </span>
                <input type="hidden" id="image-id" name="file_id" value="<?php echo set_value('file_id', $thumb_image); ?>" />
                <input type="hidden" id="type" name="type" value="<?php echo set_value('type', $type); ?>" />
                <?php echo form_error('file_id'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="status" class="col-sm-3 control-label"><?php echo lang('status')?></label>
            <div class="col-sm-2">
                <select class="form-control" name="status">
                    <option <?php echo set_select('status', 1, ($category['status'] == 1) ? TRUE : FALSE); ?> value="1"><?php echo lang('active')?></option>
                    <option <?php echo set_select('status', 0, ($category['status'] == 0) ? TRUE : FALSE); ?> value="0"><?php echo lang('inactive')?></option>
                </select>
                <?php echo form_error('status'); ?>
            </div>
        </div>
        <div class="form-group m-b-0">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-purple btn-loading" name="submit" value="EDIT">&nbsp;&nbsp; <?php echo lang('update')?> &nbsp;&nbsp;</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>