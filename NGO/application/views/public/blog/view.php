<?php echo $template['partials']['page_header']; ?>

<!-- Content Row -->
<div class="row">
    <!-- Blog Post Content Column -->
    <div class="col-lg-10">
        <h3><?php echo $post['title']; ?></h3>

        <!-- Date/Time -->
        <p><i class="fa fa-clock-o"></i> <?php echo date('F d, Y', strtotime($post['date_created'])); ?></p>
        
        <!-- Preview Image -->
        <img class="img-responsive" src="<?php echo base_url('uploads/blog/' . $post['image']); ?>" alt="<?php echo $post['title']; ?>">
        
        <br>
        
        <!-- Post Content -->
        <p class="lead"><?php echo $post['description']; ?></p>
    </div>
</div>
<!-- /.row -->