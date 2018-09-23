<?php if ($this->session->flashdata('success')): ?>
    <?php echo alert_success($this->session->flashdata('success')); ?>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <?php echo alert_error($this->session->flashdata('error')); ?>
<?php endif; ?>

<?php if ($this->session->flashdata('info')): ?>
    <?php echo alert_info($this->session->flashdata('info')); ?>
<?php endif; ?>