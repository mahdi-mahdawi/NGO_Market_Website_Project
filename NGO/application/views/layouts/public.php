<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $meta_description; ?>">
    <meta name="keywords" content="<?php echo $meta_keywords; ?>">
    <meta name="robots" content="<?php echo $meta_robots_index; ?>" >
    <meta name="robots" content="<?php echo $meta_robots_follow; ?>" >
    <link rel="icon" href="<?php echo $global_settings['store_favicon']; ?>" type="image/x-icon" />

    <title><?php echo $meta_title; ?></title>
    <base href="<?php echo base_url(); ?>">

    <link href="<?php echo base_url('assets/public/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/public/css/modern-business.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/public/css/bootstrap-datepicker3.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/public/css/bootstrap-timepicker.min.css'); ?>">
    <link href="<?php echo base_url('assets/public/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('assets/public/css/style.css'); ?>" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
        .list-group-item.active, .list-group-item.active:hover, .list-group-item.active:focus {
            background-color: <?php echo $global_settings['theme_color']; ?>;
            border-color: <?php echo $global_settings['theme_color']; ?>;
        }

        .navbar-inverse {
            background-color: <?php echo $global_settings['theme_color']; ?>;
            border-color: <?php echo $global_settings['theme_color']; ?>;
        }

        .product-price {
            background-color: <?php echo $global_settings['theme_color']; ?>;
        }

        .qty-spinner i.fa-plus {
            background-color: <?php echo $global_settings['theme_color']; ?>;
            border-color: <?php echo $global_settings['theme_color']; ?>;
        }
    </style>

</head>

    <body>

        <!-- Navigation -->
        <?php echo $template['partials']['header']; ?>

        <!-- Page Content -->
        <div class="container">

            <?php echo isset($template['partials']['modal_wrapper']) ? $template['partials']['modal_wrapper'] : ''; ?>

            <?php echo $template['body']; ?>

        </div>
        <!-- /.container -->

        <!-- Footer -->
        <?php echo $template['partials']['footer']; ?>


        <script type="text/javascript">
            var APP = APP || {}
            APP.csrf_token = '<?php echo $token; ?>'
            APP.base_url   = '<?php echo base_url(); ?>'
            APP.today      = '<?php echo date('d/m/Y'); ?>'
        </script>

        <script src="<?php echo base_url('assets/public/js/jquery.js'); ?>"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
        <script src="<?php echo base_url('assets/public/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/public/js/jquery.blockUI.js'); ?>"></script>
        <script src="<?php echo base_url('assets/public/js/bootstrap-datepicker.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/public/js/bootstrap-timepicker.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/public/js/bootstrap-rating.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/public/js/app.js'); ?>"></script>

        <!-- Google analytics -->
        <?php echo $global_settings['google_analytics']; ?>

        <!-- Zopim chat -->
        <?php echo $global_settings['zopim_chat']; ?>

    </body>
</html>
