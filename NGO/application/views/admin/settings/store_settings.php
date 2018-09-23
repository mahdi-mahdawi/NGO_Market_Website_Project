<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo lang('store_settings.header')?></h3>
    </div>
    <div class="panel-body">
        <div class="spacer-10"></div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" <?php echo ($tab == 'basic') ? "class='active'" : ""; ?>><a href="#basic" aria-controls="basic" role="tab" data-toggle="tab"><?php echo lang('basic_info')?></a></li>
            <li role="presentation" <?php echo ($tab == 'contact') ? "class='active'" : ""; ?> ><a href="#contact" aria-controls="contact" role="tab" data-toggle="tab"><?php echo lang('contact_details')?></a></li>
            <li role="presentation" <?php echo ($tab == 'other') ? "class='active'" : ""; ?>><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab"><?php echo lang('other_settings')?></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane <?php echo ($tab == 'basic') ? 'active' : ''; ?>" id="basic">
                <?php echo form_open(base_url('admin/settings/store/basic'), array('class' => 'form-horizontal')); ?>
                <br><br>
                <div class="form-group <?php if (form_error('store_name')) echo 'has-error'; ?>">
                    <label for="name" class="col-sm-3 control-label"><?php echo lang('store_name')?></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="title" name="store_name" value="<?php echo set_value('store_name', $settings['store_name']); ?>">
                        <?php echo form_error('store_name'); ?>
                    </div>
                </div>
                <div class="form-group <?php if (form_error('file_id')) echo 'has-error'; ?>">
                    <label for="file" class="col-sm-3 control-label"><?php echo lang('store_banner')?></label>
                    <div class="col-sm-9 upload-holder">
                        <img src="<?php echo $thumb_banner_url; ?>" class="thumbnail-image" id="thumbnail-banner-preview" width="150" height="100">
                        <div class="spacer-10"></div>
                        <div id="progress"><div class="bar" style="width: 0%;"></div></div>
                        <span class="btn btn-success fileinput-button btn-sm">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span><?php echo lang('upload')?></span>
                            <input id="fileupload_banner" type="file" name="file" data-folder="<?php echo $upload_banner_folder; ?>" />
                        </span>
                        <input type="hidden" id="image-banner-id" name="store_banner" value="<?php echo set_value('store_banner', $thumb_banner_image); ?>" />
                        <input type="hidden" id="banner-type" name="banner_type" value="<?php echo set_value('banner_type', $banner_type); ?>" />
                        <?php echo form_error('file_id'); ?>
                    </div>
                </div>
                <div class="form-group m-b-0">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-purple btn-loading" name="submit" value="EDIT">&nbsp;&nbsp; <?php echo lang('update')?> &nbsp;&nbsp;</button>
                    </div>
                </div>
                
                <?php echo form_close(); ?>
            </div>
            <div role="tabpanel" class="tab-pane <?php echo ($tab == 'contact') ? 'active' : ''; ?>" id="contact">
                <br><br>
                <?php echo form_open(base_url('admin/settings/store/contact'), array('class' => 'form-horizontal')); ?>
                <div class="form-group <?php if (form_error('contact_person')) echo 'has-error'; ?>">
                    <label for="contact_person" class="col-sm-3 control-label"><?php echo lang('contact_person')?></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="contact_person" name="contact_person" value="<?php echo set_value('contact_person', $settings['contact_person']); ?>">
                        <?php echo form_error('contact_person'); ?>
                    </div>
                </div>
                <div class="form-group <?php if (form_error('contact_email')) echo 'has-error'; ?>">
                    <label for="contact_email" class="col-sm-3 control-label"><?php echo lang('contact_email')?></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="contact_email" name="contact_email" value="<?php echo set_value('contact_email', $settings['contact_email']); ?>">
                        <?php echo form_error('contact_email'); ?>
                    </div>
                </div>
                <div class="form-group <?php if (form_error('contact_number')) echo 'has-error'; ?>">
                    <label for="contact_number" class="col-sm-3 control-label"><?php echo lang('contact_number')?></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo set_value('contact_number', $settings['contact_number']); ?>">
                        <?php echo form_error('contact_number'); ?>
                    </div>
                </div>
                <div class="form-group <?php if (form_error('contact_address')) echo 'has-error'; ?>">
                    <label for="contact_address" class="col-sm-3 control-label"><?php echo lang('contact_address')?></label>
                    <div class="col-sm-5">
                        <textarea class="form-control" rows="5" name="contact_address" id="contact_address"><?php echo set_value('contact_address', $settings['contact_address']) ?></textarea>
                        <?php echo form_error('contact_address'); ?>
                    </div>
                </div>
                <div class="form-group m-b-0">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-purple btn-loading" name="submit" value="EDIT">&nbsp;&nbsp; <?php echo lang('update')?> &nbsp;&nbsp;</button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div role="tabpanel" class="tab-pane <?php echo ($tab == 'other') ? 'active' : ''; ?>" id="settings">
                <br><br>
                <?php echo form_open(base_url('admin/settings/store/other'), array('class' => 'form-horizontal')); ?>
                <div class="form-group <?php if (form_error('maintenance_mode')) echo 'has-error'; ?>">
                    <label for="file" class="col-sm-3 control-label"><?php echo lang('maintenance_mode')?></label>
                    <div class="col-sm-5">
                        <select class="form-control" name="maintenance_mode" id="maintenance_mode">
                            <option value="1"  <?php echo set_select('maintenance_mode', 1, ($settings['maintenance_mode'] == 1) ? TRUE : FALSE) ?>>ON</option>
                            <option value="0" <?php echo set_select('maintenance_mode', 0, ($settings['maintenance_mode'] == 0) ? TRUE : FALSE) ?>>OFF</option>
                        </select>
                        <?php echo form_error('maintenance_mode'); ?>
                    </div>
                </div>
                <div class="form-group <?php if (form_error('store_currency')) echo 'has-error'; ?>">
                    <label for="store_currency" class="col-sm-3 control-label"><?php echo lang('store_currency')?></label>
                    <div class="col-sm-5">
                        <select class="form-control select2" name="store_currency" id="store_currency">
                            <?php foreach ($currency as $row): ?>
                            <option value="<?php echo $row['code'] ?>" <?php echo set_select('store_currency', $row['code'], ($settings['store_currency'] == $row['code']) ? TRUE : FALSE) ?>><?php echo '(' . $row['code'] . ') ' . $row['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('store_currency'); ?>
                    </div>
                </div>
                <div class="form-group <?php if (form_error('timezone')) echo 'has-error'; ?>">
                    <label for="file" class="col-sm-3 control-label"><?php echo lang('timezone')?> <?php echo $settings['timezone']; ?></label>
                    <div class="col-sm-5">
                        <select class="form-control select2" name="timezone" id="maintenance_mode">
                            <?php foreach ($list as $key => $value): ?>
                            <option value="<?php echo $value; ?>"  <?php echo set_select('timezone', $key, ($settings['timezone'] == $value) ? TRUE : FALSE) ?>><?php echo $key . ' '. $value; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('timezone'); ?>
                    </div>
                </div>
                <div class="form-group <?php if (form_error('currency_code_position')) echo 'has-error'; ?>">
                    <label for="file" class="col-sm-3 control-label"><?php echo lang('currency_code')?></label>
                    <div class="col-sm-5">
                        <select class="form-control" name="currency_code_position" id="maintenance_mode">
                            <option value="left"  <?php echo set_select('currency_code_position', 'left', ($settings['currency_code_position'] == 'left') ? TRUE : FALSE) ?>>Left</option>
                            <option value="right" <?php echo set_select('currency_code_position', 'right', ($settings['currency_code_position'] == 'right') ? TRUE : FALSE) ?>>Right</option>
                        </select>
                        <?php echo form_error('currency_code_position'); ?>
                    </div>
                </div>
                <div class="form-group <?php if (form_error('decimal_places')) echo 'has-error'; ?>">
                    <label for="decimal_places" class="col-sm-3 control-label"><?php echo lang('decimal_places')?></label>
                    <div class="col-sm-5">
                        <select class="form-control" name="decimal_places" id="decimal_places">
                            <?php for ($i = 2; $i <= 10; $i++) { ?>
                            <option value="<?php echo $i ?>" <?php echo set_select('decimal_places', $i, ($settings['decimal_places'] == $i) ? TRUE : FALSE) ?>><?php echo $i ?></option>
                            <?php } ?>
                        </select>
                        <?php echo form_error('decimal_places'); ?>
                    </div>
                </div>
                <div class="form-group <?php if (form_error('use_thousand_seperators')) echo 'has-error'; ?>">
                    <label for="use_thousand_seperators" class="col-sm-3 control-label"><?php echo lang('use_thousand_seprators')?></label>
                    <div class="col-sm-5">
                        <select class="form-control" name="use_thousand_seperators" id="use_thousand_seperators">
                            <option value="1"  <?php echo set_select('use_thousand_seperators', 1, ($settings['use_thousand_seperators'] == 1) ? TRUE : FALSE) ?>>ON</option>
                            <option value="0" <?php echo set_select('use_thousand_seperators', 0, ($settings['use_thousand_seperators'] == 0) ? TRUE : FALSE) ?>>OFF</option>
                        </select>
                        <?php echo form_error('use_thousand_seperators'); ?>
                    </div>
                </div>
                <div class="form-group <?php if (form_error('thousand_seperators')) echo 'has-error'; ?>">
                    <label for="thousand_seperators" class="col-sm-3 control-label"><?php echo lang('thousand_seperators')?></label>
                    <div class="col-sm-5">
                        <select class="form-control" name="thousand_seperators" id="use_thousand_seperators">
                            <option value="Dot"  <?php echo set_select('thousand_seperators', 'Dot', ($settings['thousand_seperators'] == 'Dot') ? TRUE : FALSE) ?>>Dot</option>
                            <option value="Comma" <?php echo set_select('thousand_seperators', 'Comma', ($settings['thousand_seperators'] == 'Comma') ? TRUE : FALSE) ?>>Comma</option>
                        </select>
                        <?php echo form_error('thousand_seperators'); ?>
                    </div>
                </div>
                <div class="form-group <?php if (form_error('decimal_separators')) echo 'has-error'; ?>">
                    <label for="decimal_separators" class="col-sm-3 control-label"><?php echo lang('decimal_seperators')?></label>
                    <div class="col-sm-5">
                        <select class="form-control" name="decimal_separators" id="decimal_separators">
                            <option value="Dot"  <?php echo set_select('decimal_separators', 'Dot', ($settings['decimal_separators'] == 'Dot') ? TRUE : FALSE) ?>>Dot</option>
                            <option value="Comma" <?php echo set_select('decimal_separators', 'Comma', ($settings['decimal_separators'] == 'Comma') ? TRUE : FALSE) ?>>Comma</option>
                        </select>
                        <?php echo form_error('decimal_separators'); ?>
                    </div>
                </div>

                <div class="form-group <?php if (form_error('footer_text')) echo 'has-error'; ?>">
                    <label for="footer_text" class="col-sm-3 control-label">Footer Text</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="footer_text" name="footer_text" value="<?php echo set_value('footer_text', $settings['footer_text']); ?>">
                        <?php echo form_error('footer_text'); ?>
                    </div>
                </div>
                <div class="form-group <?php if (form_error('facebook_comments_plugin')) echo 'has-error'; ?>">
                    <label for="facebook_comments_plugin" class="col-sm-3 control-label">Comments Plugin App ID</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="facebook_comments_plugin" name="facebook_comments_plugin" value="<?php echo set_value('facebook_comments_plugin', $settings['facebook_comments_plugin']); ?>">
                        <?php echo form_error('facebook_comments_plugin'); ?>
                    </div>
                </div>
                <div class="form-group <?php if (form_error('google_analytics')) echo 'has-error'; ?>">
                    <label for="google_analytics" class="col-sm-3 control-label"><?php echo lang('google_analytics')?></label>
                    <div class="col-sm-5">
                        <textarea class="form-control" rows="5" name="google_analytics" id=""><?php echo set_value('google_analytics', $settings['google_analytics']) ?></textarea>
                        <?php echo form_error('google_analytics'); ?>
                    </div>
                </div>
                <div class="form-group <?php if (form_error('zopim_chat')) echo 'has-error'; ?>">
                    <label for="zopim_chat" class="col-sm-3 control-label">Zopim Chat</label>
                    <div class="col-sm-5">
                        <textarea class="form-control" rows="5" name="zopim_chat" id=""><?php echo set_value('zopim_chat', $settings['zopim_chat']) ?></textarea>
                        <?php echo form_error('zopim_chat'); ?>
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
    </div>
</div>