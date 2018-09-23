<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo lang('social.header')?></h3>
    </div>
    <div class="panel-body">
        <?php echo form_open(base_url('admin/settings/social_media'), array('class' => 'form-horizontal')); ?>
        <div class="spacer-10"></div>
        <div class="form-group">
            <label for="" class="col-md-3 col-sm-3 control-label"><?php echo lang('facebook')?></label>
            <div class="col-md-3 col-sm-9 ">
                <input type="text" class="form-control" name="url_facebook" id="url_facebook" value="<?php echo set_value('url_facebook', $settings['url_facebook']) ?>">
            </div>
            
        </div>
        <div class="form-group ">
            <label for="" class="col-md-3 col-sm-3 control-label"><?php echo lang('twitter')?></label>
            <div class="col-md-3 col-sm-9 ">
                <input type="text" class="form-control" name="url_twitter" id="url_twitter" value="<?php echo set_value('url_twitter', $settings['url_twitter']) ?>">
            </div>
        </div>
  
        <div class="form-group ">
            <label for="" class="col-md-3 col-sm-3 control-label"><?php echo lang('youtube')?></label>
            <div class="col-md-3 col-sm-9 ">
                <input type="text" class="form-control" name="url_youtube" id="url_youtube" value="<?php echo set_value('url_youtube', $settings['url_youtube']) ?>">
            </div>
        </div>
        
        <div class="form-group ">
            <label for="" class="col-md-3 col-sm-3 control-label"><?php echo lang('google_plus')?></label>
            <div class="col-md-3 col-sm-9 ">
                <input type="text" class="form-control" name="url_googleplus" id="url_googleplus" value="<?php echo set_value('url_googleplus', $settings['url_googleplus']) ?>">
            </div>
        </div>
        
        <div class="form-group ">
            <label for="" class="col-md-3 col-sm-3 control-label"><?php echo lang('instagram')?></label>
            <div class="col-md-3 col-sm-9 ">
                <input type="text" class="form-control" name="url_instagram" id="url_instagram" value="<?php echo set_value('url_instagram', $settings['url_instagram']) ?>">
            </div>
        </div>
        
        <div class="form-group ">
            <label for="" class="col-md-3 col-sm-3 control-label"><?php echo lang('pinterest')?></label>
            <div class="col-md-3 col-sm-9 ">
                <input type="text" class="form-control" name="url_pinterest" id="url_pinterest" value="<?php echo set_value('url_pinterest', $settings['url_pinterest']) ?>">
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