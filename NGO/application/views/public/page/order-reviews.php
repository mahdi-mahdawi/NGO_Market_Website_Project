<?php echo $template['partials']['page_header']; ?>

<!-- Content Row -->
<div class="row">
    <div class="col-md-10">
        
        <?php if(!empty($reviews)): ?>
            <?php foreach($reviews as $row): ?>
                <div class="panel panel-default">
                    <div class="panel-body panel-review">
                        <?php echo nl2br($row->comments); ?>
                        <span class="review-ratings"><input type="hidden" class="rating" value="<?php echo $row->rating_value; ?>" disabled="disabled"/></span>
                        <p class="text-muted review-author">
                            <?php echo $row->customer_name; ?>
                             <span class="review-date"><?php echo date('F d, Y', strtotime($row->date_created)); ?></span>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</div>
<!-- /.row -->