<?php echo $template['partials']['page_header']; ?>

<div class="row">
    <!-- Blog Entries Column -->
    <div class="col-md-10">
        
        <?php if(!empty($posts)): ?>
            <?php foreach($posts as $post): ?>
                <div>
                    <h3><a href="<?php echo base_url('blog/' . $post['blog_id'] . '/' . $post['url_slug']); ?>"><?php echo $post['title']; ?></a></h3>
                    <p><i class="fa fa-clock-o"></i> <?php echo lang('text.posted_on'); ?> <?php echo date('F d, Y', strtotime($post['date_created'])); ?></p>
                    <img class="img-responsive img-hover" src="<?php echo base_url('uploads/blog/' . $post['image']); ?>" alt="<?php echo $post['title']; ?>">
                    <br>
                    <p><?php echo $post['description']; ?></p>
                    <a class="btn btn-primary" href="<?php echo base_url('blog/' . $post['blog_id'] . '/' . $post['url_slug']); ?>"><?php echo lang('button.read_more'); ?> <i class="fa fa-angle-right"></i></a>
                    <hr>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    
    </div>
</div>
<!-- /.row -->