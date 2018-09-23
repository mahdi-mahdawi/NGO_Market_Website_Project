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
            <div class="list-group">
                <?php foreach($productes as $product): ?>
                        <li class="list-group-item" style="min-height:80px;">
                                                     
                            <a href="<?php echo base_url('menus/' . $product['product_id'] . '/' . $product['url_slug']) ?>" class="product-wrapper">
                                <span class="product-name no-margin"><?php echo $product['name']; ?></span>
                            </a>
                            
                            <div class="row">
                                <div class="col-md-10">
                                    <?php echo $product['description']; ?>
                                </div>

                                <div class="col-md-2">
                                    <div class="cart-action-btn-wrapper" style="float:left;">
                                        <div class="qty-spinner padding-5 item-wrapper" data-product-id="<?php echo $product['product_id']; ?>">
                                           <i class="fa fa-plus form-cart-add-product" data-productes-id="<?php echo $product['product_id']; ?>"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </li>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- /.row -->