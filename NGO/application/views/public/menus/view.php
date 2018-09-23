<?php if($global_settings['facebook_comments_plugin']): ?>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.7&appId=<?php echo $global_settings['facebook_comments_plugin']; ?>";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<?php endif; ?>

<!-- Page Heading/Breadcrumbs -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $product['name']; ?></h1>
    </div>
</div>
<!-- /.row -->

<!-- Projects Row -->
<div class="row">
    <div class="col-md-3 img-portfolio">
        <a href="javascript:void(0)">
            <img class="img-responsive img-hover" src="<?php echo get_image_path($product['image'], 'product'); ?>" alt="" width="200" height="140">
        </a>
    </div>

    <div class="col-md-9 img-portfolio">
        <div style="margin-top:10px">
            <div class="qty-spinner item-wrapper" data-product-id="<?php echo $product['product_id']; ?>">
                <i class="fa fa-plus form-cart-add-product" data-productes-id="<?php echo $product['product_id']; ?>"></i>
            </div>
        </div>
        <p><?php echo $product['description']; ?></p>
    </div>
</div>
<!-- /.row -->

<?php if(!empty($related_productes)): ?>
    <div class="row">
        <h1 class="page-header"><?php echo lang('text.related_productes'); ?></h1>
        <?php foreach($related_productes as $product): ?>
            <div class="col-md-3 col-sm-4 col-xs-6">
                <div class="thumbnail product-thumbnail">
                    <a href="<?php echo base_url('menus/' . $product['product_id'] . '/' . $product['url_slug']) ?>" class="product-wrapper">
                        <img class="img-responsive img-hover" src="<?php echo get_image_path($product['image'], 'product'); ?>" alt="">
                        <div class="caption">
                            <span class="product-name"><?php echo $product['name']; ?></span>
                        </div>
                    </a>

                    <div class="cart-action-btn-wrapper">
                        <div class="qty-spinner item-wrapper" data-product-id="<?php echo $product['product_id']; ?>">
                            <i class="fa fa-plus form-cart-add-product" data-productes-id="<?php echo $product['product_id']; ?>"></i>
                        </div>
                        <br/><br/>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="fb-comments" data-href="<?php echo current_url(); ?>" data-numposts="5"></div>
