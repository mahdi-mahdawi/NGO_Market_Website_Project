<footer class="footer">
    <section class="footer-lg bg-dark-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 f-content">
                    <ul class="list-unstyled list-inline footer-links">
                        <?php if(!empty($footer_menus)): ?>
                            <?php foreach($footer_menus as $footer_menu): ?>
                                <?php if(!in_array($footer_menu['url'], $exclude_urls)): ?>
                                    <li><a href="<?php echo base_url($footer_menu['url']); ?>"><?php echo $footer_menu['name']; ?></a></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 f-content">
                    <ul class="list-unstyled f-contact-list">
                        <li><span class="ls-head"><?php echo lang('label.email'); ?> :</span><span class="ls-content"><?php echo $global_settings['contact_email']; ?></span></li>
                        <li><span class="ls-head"><?php echo lang('label.phone'); ?> :</span><span class="ls-content"><?php echo $global_settings['contact_number']; ?></span></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 f-content">
                    <ul class="list-inline f-contact-list">
                        <?php if($global_settings['url_facebook']): ?><li><a href="<?php echo $global_settings['url_facebook']; ?>" target="_blank"><i class="fa fa-facebook fa-2x icon-white"></i></a></li><?php endif; ?>
                        <?php if($global_settings['url_twitter']): ?><li><a href="<?php echo $global_settings['url_twitter']; ?>" target="_blank"><i class="fa fa-twitter fa-2x icon-white"></i></a></li><?php endif; ?>
                        <?php if($global_settings['url_youtube']): ?><li><a href="<?php echo $global_settings['url_youtube']; ?>" target="_blank"><i class="fa fa-youtube fa-2x icon-white"></i></a></li><?php endif; ?>
                        <?php if($global_settings['url_googleplus']): ?><li><a href="<?php echo $global_settings['url_googleplus']; ?>" target="_blank"><i class="fa fa-google-plus fa-2x icon-white"></i></a></li><?php endif; ?>
                        <?php if($global_settings['url_pinterest']): ?><li><a href="<?php echo $global_settings['url_pinterest']; ?>" target="_blank"><i class="fa fa-pinterest fa-2x icon-white"></i></a></li><?php endif; ?>
                        <?php if($global_settings['url_instagram']): ?><li><a href="<?php echo $global_settings['url_instagram']; ?>" target="_blank"><i class="fa fa-instagram fa-2x icon-white"></i></a></li><?php endif; ?>
                    </ul>
                </div>
            </div>
            <p><?php echo $global_settings['footer_text']; ?></p>
        </div>
    </section>
</footer>