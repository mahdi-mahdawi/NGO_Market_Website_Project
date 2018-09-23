<div class="list-group">

    <a href="<?php echo base_url('account'); ?>" class="list-group-item <?php echo ($profile_menu == 'profile') ? 'active' : ''; ?>">
        <?php echo lang('label.profile'); ?>
    </a>
    <a href="<?php echo base_url('account/orders'); ?>" class="list-group-item <?php echo ($profile_menu == 'orders') ? 'active' : ''; ?>">
        <?php echo lang('label.orders'); ?>
    </a>
    <a href="<?php echo base_url('account/password'); ?>" class="list-group-item <?php echo ($profile_menu == 'password') ? 'active' : ''; ?>">
        <?php echo lang('label.changepassword'); ?>
    </a>
    <a href="<?php echo base_url('account/logout'); ?>" class="list-group-item">
        <?php echo lang('label.logout'); ?>
    </a>
</div>