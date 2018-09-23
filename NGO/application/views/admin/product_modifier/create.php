<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title" id="mySmallModalLabel"><?php echo lang('header.add_product_modifier'); ?></h4>
</div>

<div class="modal-body">
    <?php $url = base_url('admin/product_modifier/create/' . $productId) ?>
                  
    <?php echo form_open($url, ['class' => 'form-horizontal', 'id' => 'form-create-product-modifier']); ?>
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label"><?php echo lang('label.modifier_title'); ?></label>
            <div class="col-sm-10">
                <input type="taxt" class="form-control" id="name" name="name" required="required">
            </div>
        </div>
        
        <div class="form-group">
            <label for="minimum" class="col-sm-2 control-label"><?php echo lang('label.modifier_minimum'); ?></label>
            <div class="col-sm-3">
                <input type="taxt" class="form-control" id="minimum" name="minimum" value="1" required="">
            </div>
            <span id="helpBlock" class="help-block"><?php echo lang('label.modifier_minimum_text'); ?></span>
        </div>

        <div class="form-group">
            <label for="maximum" class="col-sm-2 control-label"><?php echo lang('label.modifier_maximum'); ?></label>
            <div class="col-sm-3">
                <input type="taxt" class="form-control" id="maximum" name="maximum" value="1" required="required">
            </div>
            <span id="helpBlock" class="help-block"><?php echo lang('label.modifier_maximum_text'); ?></span>
        </div>

        <hr>

        <div id="item-modifiers-list">
            <a href="javascript:void(0);" class="btn-link" id="btn-add-item-modifier"><?php echo lang('label.modifier_add_more'); ?></a>

            <div class="form-group">
                <label for="" class="col-sm-2 control-label"></label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-8">
                            <input type="taxt" class="form-control" id="item_name[]" name="item_name[]" placeholder="Item name" required="required">
                        </div>

                         <div class="col-sm-3">
                            <input type="taxt" class="form-control" id="item_price[]" name="item_price[]" placeholder="Price" value="0" required="required">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group" style="margin-top:50px;">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-purple btn-loading"><?php echo lang('button.save_modifier'); ?></button>
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
                    <input type="taxt" class="form-control" id="item_name[]" name="item_name[]" placeholder="Item name" required="required">
                </div>

                <div class="col-sm-3">
                    <input type="taxt" class="form-control" id="item_price[]" name="item_price[]" placeholder="Price" value="0" required="required">
                </div>

                <div class="col-sm-1">
                    <a href="javascript:void(0);" class="btn-link btn-remove-modifier-row">Remove</a>
                </div>
            </div>
        </div>
    </div>
</script>