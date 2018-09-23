<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url('admin'); ?>"><?php echo $global_settings['store_name']; ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-pad-adjust nav-notification"></li>
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <img src="<?php echo base_url('assets/admin/images/avtar.png'); ?>" alt="" class="thumb-md img-circle">
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url('admin/profile')?>">My account</a></li>
                        <li><a href="<?php echo base_url('admin/profile/change_password')?>">Change password</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?php echo base_url('admin/logout'); ?>">Log out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>