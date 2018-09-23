<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title" id="mySmallModalLabel"><?php echo lang('header.edit_product_modifier'); ?></h4>
</div>

<div class="modal-body">
    <?php $url = base_url('admin/product_modifier/update/' . $productId . '/' . $modifier['id']) ?>
    <?php echo form_open($url, ['class' => 'form-horizontal', 'id' => 'form-update-product-modifier']); ?>
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label"><?php echo lang('label.modifier_title'); ?></label>
            <div class="col-sm-10">
                <input type="taxt" class="form-control" id="name" name="name" required="required" value="<?php echo $modifier['name']; ?>">
            </div>
        </div>
        
        <div class="form-group">
            <label for="minimum" class="col-sm-2 control-label"><?php echo lang('label.modifier_minimum'); ?></label>
            <div class="col-sm-3">
                <input type="taxt" class="form-control" id="minimum" name="minimum" required="required" value="<?php echo $modifier['minimum']; ?>">
            </div>
            <span id="helpBlock" class="help-block"><?php echo lang('label.modifier_minimum_text'); ?></span>
        </div>

        <div class="form-group">
            <label for="maximum" class="col-sm-2 control-label"><?php echo lang('label.modifier_maximum'); ?></label>
            <div class="col-sm-3">
                <input type="taxt" class="form-control" id="maximum" name="maximum" required="required" value="<?php echo $modifier['maximum']; ?>">
            </div>
            <span id="helpBlock" class="help-block"><?php echo lang('label.modifier_maximum_text'); ?></span>
        </div>

        <hr>

        <div id="item-modifiers-list">
            <a href="javascript:void(0);" class="btn-link" id="btn-add-item-modifier"><?php echo lang('label.modifier_add_more'); ?></a>

            <?php foreach($modifier['items'] as $item): ?>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label"></label>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-8">
                                <input type="taxt" class="form-control" id="item_name[]" name="item_name[]" value="<?php echo $item['name']; ?>" placeholder="Item name">
                            </div>

                             <div class="col-sm-3">
                                <input type="taxt" class="form-control" id="item_price[]" name="item_price[]" value="<?php echo $item['price']; ?>" placeholder="Price" value="0">
                            </div>

                            <div class="col-sm-1">
                                <a href="javascript:void(0);" class="btn-link btn-remove-modifier-row">Remove</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="form-group" style="margin-top:50px;">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-purple btn-loading"><?php echo lang('button.edit_modifier'); ?></button>
            </div>
        </div>
    <?php echo form_close(); ?>
</div>

<!-- Item template -->
<script type="text/template" id="template-item-modifier">
    <div class="form-group">
        <label for="" class="col-sm-2 control-label"></label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-8">
                    <input type="taxt" class="form-control" id="item_name[]" name="item_name[]" placeholder="Item name">
                </div>

                <div class="col-sm-3">
                    <input type="taxt" class="form-control" id="item_price[]" name="item_price[]" placeholder="Price" value="0">
                </div>

                <div class="col-sm-1">
                    <a href="javascript:void(0);" class="btn-link btn-remove-modifier-row">Remove</a>
                </div>
            </div>
        </div>
    </div>
</script>