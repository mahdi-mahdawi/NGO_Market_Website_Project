
<!-- Page Heading/Breadcrumbs -->
<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header" style="border-bottom:none; margin:0px 0 20px;"></h4>
    </div>
</div>
<!-- /.row -->

<!-- Image Header -->
<div class="row">
    <div class="col-lg-12">
        <img class="img-responsive" src="<?php echo base_url('uploads/cover/' . $global_settings['store_banner']) ?>" alt="">
    </div>
</div>
<!-- /.row -->

<!-- Portfolio Section -->
<div class="row">
    <hr>
    <?php if(!empty($product_categories)): ?>
        <?php foreach($product_categories as $row): ?>
            <div class="col-md-3 col-sm-4 col-xs-6">
                <a href="<?php echo base_url('menus/category/' . $row['url_slug']); ?>">
                    <div class="thumbnail">
                        <img class="img-responsive img-portfolio img-hover" src="<?php echo get_image_path($row['image'], 'category'); ?>" alt="">
                        <div class="caption">
                            <h5><?php echo $row['name']; ?></h5>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<!-- /.row -->

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><?php echo lang('text.featured_products'); ?></h3>
    </div>
    
        <?php if(!empty($productes)): ?>
            <?php foreach($productes as $product): ?>
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <div class="thumbnail product-thumbnail">
                        <a href="<?php echo base_url('menus/' . $product['product_id'] . '/' . $product['url_slug']) ?>" class="product-wrapper">
                            <img class="img-responsive img-hover" src="<?php echo get_image_path($product['image'], 'product'); ?>" alt="">
                            <div class="caption">
                                <span class="product-name"><?php echo $product['name']; ?></span>
                                <div class="qty-spinner item-wrapper" data-product-id="<?php echo $product['product_id']; ?>">
                                    <i class="fa fa-plus form-cart-add-product" data-productes-id="<?php echo $product['product_id']; ?>"></i>
                                </div> <br/>
                            </div>
                        </a>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

</div>
<!-- /.row -->