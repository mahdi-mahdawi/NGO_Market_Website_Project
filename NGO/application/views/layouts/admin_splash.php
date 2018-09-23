<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="images/favicon.ico">
        <title>Dashboard</title>

        <link href="<?php echo base_url('assets/admin/css/bootstrap.css'); ?>" rel="stylesheet">
        <?php echo $template['css']; ?>
        <link href="<?php echo base_url('assets/admin/css/style.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/admin/lib/dialog/dist/css/bootstrap-dialog.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/admin/lib/dialog/dist/css/bootstrap-dialog.min.css'); ?>" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
        <div class="container-fluid">
            <div class="splash-container">
                <?php echo isset($flashdata) ? $flashdata : ''; ?>
                <?php echo $template['body']; ?>
            </div>
        </div>

        <script type="text/javascript">
            var config = {
                admin_url: '<?php echo base_url('admin'); ?>',
                token: '<?php echo $token; ?>'
            };
        </script>

        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="<?php echo base_url('assets/admin/lib/jquery-ui/jquery-ui.js'); ?>" type="text/javascript" ></script>
        <script type="text/javascript" src="<?php echo base_url('assets/admin/js/bootstrap.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/admin/js/ie10-viewport-bug-workaround.js'); ?>"></script>
        <?php echo $template['js']; ?>
        <script type="text/javascript" src="<?php echo base_url('assets/admin/js/app.js') ?>"></script>
    </body>
</html>

