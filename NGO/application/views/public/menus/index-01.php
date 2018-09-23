<?php echo $template['partials']['page_header']; ?>

<!-- Content Row -->
<div class="row">
    <!-- Sidebar Column -->
    <div class="col-md-3">
        <div class="list-group">
            <?php if(!empty($categories)): ?>
                <a href="<?php echo base_url('menus'); ?>" class="list-group-item <?php echo ($category_slug == 'all') ? 'active' : ''; ?>">All</a>
                <?php foreach($categories as $category): ?>
                    <a href="<?php echo base_url('menus/category/' . $category['url_slug']); ?>" class="list-group-item <?php echo ($category_slug == $category['url_slug']) ? 'active' : ''; ?>"><?php echo $category['name']; ?></a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <!-- Content Column -->
    <div class="col-md-9">
        <?php if(!empty($productes)): ?>
            <?php foreach($productes as $product): ?>
                <div class="col-md-4 col-sm-4 col-xs-6">
                    <div class="thumbnail product-thumbnail">
                        <a href="<?php echo base_url('menus/' . $product['product_id'] . '/' . $product['url_slug']) ?>" class="product-wrapper">
                            <img class="img-responsive img-hover" src="<?php echo get_image_path($product['image'], 'product'); ?>" alt="">
                            <div class="caption">
                                <span class="product-name"><?php echo $product['name']; ?></span>
                            </div>
                        </a>

                        <div class="cart-action-btn-wrapper">
                            <div class="qty-spinner padding-5 item-wrapper" data-product-id="<?php echo $product['product_id']; ?>">
                                <i class="fa fa-plus form-cart-add-product" data-productes-id="<?php echo $product['product_id']; ?>"></i>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<!-- /.row -->