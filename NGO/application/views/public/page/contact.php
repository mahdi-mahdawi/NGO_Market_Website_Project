<?php echo $template['partials']['page_header']; ?>

<!-- Content Row -->
<div class="row">
    <!-- Contact Details Column -->
    <div class="col-md-4">
        <h5><strong><?php echo lang('label.store_address'); ?></strong></h5>

        <p><?php echo nl2br($global_settings['contact_address']); ?></p>
        
        <p>
            <i class="fa fa-phone"></i>
            <abbr title="Phone">P</abbr>: <?php echo $global_settings['contact_number']; ?>
        </p>
        
        <p>
            <i class="fa fa-envelope-o"></i>
            <abbr title="Email">E</abbr>: <a href="mailto:<?php echo $global_settings['contact_email']; ?>"><?php echo $global_settings['contact_email']; ?></a>
        </p>

        <ul class="list-unstyled list-inline list-social-icons">
            <?php if($global_settings['url_facebook']): ?><li><a target="_blank" href="<?php echo $global_settings['url_facebook'] ?>"><i class="fa fa-facebook-square fa-2x"></i></a></li><?php endif; ?>
            <?php if($global_settings['url_twitter']): ?><li><a target="_blank" href="<?php echo $global_settings['url_twitter'] ?>"><i class="fa fa-twitter-square fa-2x"></i></a></li><?php endif; ?>
            <?php if($global_settings['url_youtube']): ?><li><a target="_blank" href="<?php echo $global_settings['url_youtube'] ?>"><i class="fa fa-youtube-square fa-2x"></i></a></li><?php endif; ?>
            <?php if($global_settings['url_googleplus']): ?><li><a target="_blank" href="<?php echo $global_settings['url_googleplus'] ?>"><i class="fa fa-google-plus-square fa-2x"></i></a></li><?php endif; ?>
            <?php if($global_settings['url_pinterest']): ?><li><a target="_blank" href="<?php echo $global_settings['url_pinterest'] ?>"><i class="fa fa-pinterest-square fa-2x"></i></a></li><?php endif; ?>
            <?php if($global_settings['url_instagram']): ?><li><a target="_blank" href="<?php echo $global_settings['url_instagram'] ?>"><i class="fa fa-instagram fa-2x"></i></a></li><?php endif; ?>
        </ul>

        <br>
        <h5><strong><?php echo lang('label.opening_hours'); ?></strong></h5>
        <div class="list-group">
            <table class="table">
                <?php foreach($opening_hours as $row): ?>
                    <tr>
                        <td><?php echo $row['day']; ?></td>
                        <td><?php echo $row['open_hour']; ?></td>
                        <td><?php echo $row['close_hour']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <div class="col-md-8">
        <?php echo form_open('', ['id' => 'contactForm']); ?>
            <div class="control-group form-group <?php echo (form_error('name')) ? 'has-error' : ''; ?>">
                <div class="controls">
                    <label><?php echo lang('label.name'); ?>:</label>
                    <input type="text" class="form-control" name="name" required value="<?php echo set_value('name'); ?>"/>
                    <?php echo form_error('name'); ?>
                </div>
            </div>
            <div class="control-group form-group <?php echo (form_error('phone')) ? 'has-error' : ''; ?>">
                <div class="controls">
                    <label><?php echo lang('label.phone'); ?>:</label>
                    <input type="text" class="form-control" name="phone"  value="<?php echo set_value('phone'); ?>" />
                    <?php echo form_error('phone'); ?>
                </div>
            </div>
            <div class="control-group form-group <?php echo (form_error('email')) ? 'has-error' : ''; ?>">
                <div class="controls">
                    <label><?php echo lang('label.email'); ?>:</label>
                    <input type="email" class="form-control" name="email" required value="<?php echo set_value('email'); ?>" />
                    <?php echo form_error('email'); ?>
                </div>
            </div>
            <div class="control-group form-group <?php echo (form_error('message')) ? 'has-error' : ''; ?>">
                <div class="controls">
                    <label><?php echo lang('label.message'); ?>:</label>
                    <textarea rows="8" cols="100" class="form-control" name="message" required maxlength="999" style="resize:none"><?php echo set_value('message'); ?></textarea>
                    <?php echo form_error('message'); ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" name="submit" value="submit"><?php echo lang('button.submit'); ?></button> <br><br>
        <?php echo form_close(); ?>
    </div>
</div>
<!-- /.row -->