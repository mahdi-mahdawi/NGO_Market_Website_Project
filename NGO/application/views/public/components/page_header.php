<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?php echo $page_header; ?></h1>
    </div>
</div>
<!-- /.row -->

<?php $flashdata = $this->session->flashdata('flashdata'); ?>

<?php if(is_array($flashdata)): ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="alert <?php echo ($flashdata['type'] == 'success') ? 'alert-success' : 'alert-danger'; ?> ">
                <?php echo $flashdata['text']; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<!-- /.row -->
