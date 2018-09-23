<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <h4 class="modal-title" id="mySmallModalLabel"><?php echo lang('header.add_product_size'); ?></h4>
</div>

<div class="modal-body">
    <?php $url = base_url('admin/product_sizes/create/' . $productId) ?>
                  
    <?php echo form_open($url, ['class' => 'form-horizontal', 'id' => 'form-create-size-modifier']); ?>
        
        <div id="product-size-list">
            
            <div class="form-group">
                <label for="" class="col-sm-2 control-label"></label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-8">
                            <select class="form-control" name="size" id="size">
                                <?php foreach ($product_sizes as $row): ?>
                                    <option  value="<?php echo $row['id'] ?>" <?php echo set_select('size', $row['id'], (set_value('size') == $row['id']) ? true : false); ?>><?php echo $row['sizes'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                         <div class="col-sm-3">
                            <input type="text" class="form-control" id="size_price" name="size_price" placeholder="Price" required="required">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group" style="margin-top:50px;">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-purple btn-loading"><?php echo lang('button.add_product_size'); ?></button>
            </div>
        </div>
    <?php echo form_close(); ?>
</div>

