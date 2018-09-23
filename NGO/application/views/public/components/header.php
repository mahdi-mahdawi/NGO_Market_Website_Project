<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">
                <?php echo $global_settings['store_name']; ?>
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <?php if(!empty($header_menus)): ?>
                    <?php foreach($header_menus as $header_menu): ?>
                        <?php if(!in_array($header_menu['url'], $exclude_urls)): ?>
                            <li><a href="<?php echo base_url($header_menu['url']); ?>"><?php echo $header_menu['name']; ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if($customer_logged_in): ?>
                    <li><a href="<?php echo base_url('account'); ?>"><?php echo lang('label.account'); ?></a></li>
                <?php endif; ?>

                <li>
                    <a href="<?php echo base_url('checkout'); ?>">
                        <div id="cart-icon-header">
                            <i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i>
                            <span class="badge badge-red" id="cart-item-counter">0</span>
                        </div>
                    </a>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $languages[get_active_language()]; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <?php foreach($languages as $key => $row): ?>
                            <li><a href="<?php echo base_url('language/' . $key); ?>"><?php echo $row; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>

            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>