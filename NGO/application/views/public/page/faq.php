<?php echo $template['partials']['page_header']; ?>

<!-- Content Row -->
<div class="row">
    <div class="col-lg-12">
    
        <div class="panel-group" id="accordion">

            <?php if(!empty($faqs)): ?>
                <?php foreach($faqs as $key => $faq): ?>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="<?php echo '#collapse' . $key; ?>">
                                    <?php echo $faq['title']; ?>
                                </a>
                            </h4>
                        </div>
                        <div id="<?php echo 'collapse' . $key; ?>" class="panel-collapse">
                            <div class="panel-body">
                                <?php echo $faq['description']; ?>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php endif; ?>

        </div>
        <!-- /.panel-group -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->