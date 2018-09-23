<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo lang('editreview.header')?></h3>
    </div>
    <div class="panel-body">
        <?php echo form_open('', ['class' => 'form-horizontal']); ?>
            
        <div class="form-group">
            <label for="rating" class="col-sm-3 control-label"><?php echo lang('rating')?></label>
            <div class="col-sm-2">
                <select class="form-control" name="rating" id="rating">
                    <option <?php echo set_select('rating', 1, ($review['rating_value'] == 1) ? TRUE : FALSE); ?> value="1">1</option>
                    <option <?php echo set_select('rating', 2, ($review['rating_value'] == 2) ? TRUE : FALSE); ?> value="2">2</option>
                    <option <?php echo set_select('rating', 3, ($review['rating_value'] == 3) ? TRUE : FALSE); ?> value="3">3</option>
                    <option <?php echo set_select('rating', 4, ($review['rating_value'] == 4) ? TRUE : FALSE); ?> value="4">4</option>
                    <option <?php echo set_select('rating', 5, ($review['rating_value'] == 5) ? TRUE : FALSE); ?> value="5">5</option>
                </select>
                <?php echo form_error('rating'); ?>
            </div>
        </div>

        <div class="form-group <?php if (form_error('comment')) echo 'has-error'; ?>">
            <label for="comment" class="col-sm-3 control-label"><?php echo lang('comment')?></label>
            <div class="col-sm-5">
                <textarea class="form-control" rows="5" name="comment" id="comment"><?php echo set_value('comment', $review['comments']) ?></textarea>
                <?php echo form_error('comment'); ?>
            </div>
        </div>

        <div class="form-group">
            <label for="status" class="col-sm-3 control-label"><?php echo lang('status')?></label>
            <div class="col-sm-2">
                <select class="form-control" name="status" id="status">
                    <option <?php echo set_select('status', 1, ($review['status'] == 1) ? TRUE : FALSE); ?> value="1"><?php echo lang('active')?></option>
                    <option <?php echo set_select('status', 0, ($review['status'] == 0) ? TRUE : FALSE); ?> value="0"><?php echo lang('inactive')?></option>
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