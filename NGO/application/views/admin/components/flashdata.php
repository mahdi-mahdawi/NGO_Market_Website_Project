<?php $flashdata = $this->session->flashdata('flashdata'); ?>
<?php if (is_array($flashdata) && isset($flashdata['type'], $flashdata['text'])): ?>
    <?php if ($flashdata['type'] == 'error'): ?>
        <div class="alert alert-danger" role="alert">
            <button class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> <?php echo $flashdata['text']; ?>
        </div>
    <?php endif; ?>
    <?php if ($flashdata['type'] == 'success'): ?>
        <div class="alert alert-success" role="alert">
            <button class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
            <strong>Well done!</strong> <?php echo $flashdata['text']; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>



