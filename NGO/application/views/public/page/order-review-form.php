<?php echo $template['partials']['page_header']; ?>

<!-- Content Row -->
<div class="row">

    <div class="col-md-9">
        <h4>
              ORDER #<?php echo $order['order_reference']; ?> <br/>
              <small><?php echo date('F d, Y', strtotime($order['order_date'])); ?></small>
        </h4>

        <?php echo form_open('reviews/create?review_token=' . $review_token); ?>
            <div class="form-group <?php echo (form_error('comment')) ? 'has-error' : ''; ?>">
                <label for="comment"><?php echo lang('text.rate_your_experience'); ?></label>
                <textarea name="comment" id="comment" rows="5" class="form-control" required><?php echo set_value('comment'); ?></textarea>
                <?php echo form_error('comment'); ?>
            </div>
            <div class="form-group <?php echo (form_error('comment')) ? 'has-error' : ''; ?>">
                <input type="hidden" class="rating" id="rating" value="0" name="rating" />
            </div>

            <button type="submit" class="btn btn-primary" name="submit" value="submit"><?php echo lang('button.submit'); ?></button> <br><br>
        <?php echo form_close(); ?>

    </div>
</div>
<!-- /.row -->