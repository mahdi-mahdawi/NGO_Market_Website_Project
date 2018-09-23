<?php
    $url =  base_url('admin/product/edit/' . $product['product_id']) ;
    $urlModifier = base_url('admin/product_modifier/show/' . $product['product_id']);
    $urlSize = base_url('admin/product_sizes/show/' . $product['product_id']);
?>

<div class="row">
    <div class="col-md-7">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo lang('editproduct.header')?></h3>
            </div>
            <div class="panel-body">
                    <?php echo form_open(base_url('admin/product/edit/' . $product['product_id']), array('class' => 'form-horizontal')); ?>
                    <div class="form-group <?php if (form_error('name')) { echo 'has-error'; } ?>">
                        <label for="name" class="col-sm-3 control-label"><?php echo lang('name')?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name', $product['name']); ?>">
                            <?php echo form_error('name'); ?>
                        </div>
                    </div>

                    <div class="form-group <?php if (form_error('description')) { echo 'has-error'; } ?>">
                        <label for="description" class="col-sm-3 control-label"><?php echo lang('description')?></label>
                        <div class="col-sm-8">
                            <textarea class="form-control " rows="5" name="description" id=""><?php echo set_value('description', $product['description']) ?></textarea>
                        </div>
                    </div>

                    <div class="form-group <?php if (form_error('category')) { echo 'has-error'; } ?>">
                        <label for="category" class="col-sm-3 control-label"><?php echo lang('category')?></label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="category">
                                <option value="">Select</option>
                                <?php foreach ($category as $row): ?>
                                <option  value="<?php echo $row['product_category_id'] ?>" <?php echo set_select('category', $row['product_category_id'], ($product['product_category_id'] == $row['product_category_id']) ? true : false); ?>><?php echo $row['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php echo form_error('category'); ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="featured" class="col-sm-3 control-label"><?php echo lang('featured')?></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="is_featured" id="is_featured">
                                <option <?php echo set_select('is_featured', 1, ($product['is_featured'] == 1) ? true : false); ?> value="1"><?php echo lang('yes')?></option>
                                <option <?php echo set_select('is_featured', 0, ($product['is_featured'] == 0) ? true : false); ?> value="0"><?php echo lang('no')?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group <?php if (form_error('file_id')) { echo 'has-error'; } ?>">
                        <label for="file" class="col-sm-3 control-label"><?php echo lang('image')?></label>
                        <div class="col-sm-9 upload-holder">
                            <img src="<?php echo $thumb_image_url; ?>" class="thumbnail-image" id="thumbnail-preview" width="200" height="200">
                            <div class="spacer-10"></div>
                            <div id="progress"><div class="bar" style="width: 0%;"></div></div>
                            <span class="btn btn-success fileinput-button btn-sm">
                                <i class="glyphicon glyphicon-plus"></i>
                                <span><?php echo lang('upload')?></span>
                                <input id="fileupload" type="file" name="file" data-folder="<?php echo $upload_folder; ?>" />
                            </span>
                            <input type="hidden" id="image-id" name="file_id" value="<?php echo set_value('file_id', $thumb_image); ?>" />
                            <input type="hidden" id="type" name="type" value="<?php echo set_value('type', $type); ?>" />
                            <?php echo form_error('file_id'); ?>
                        </div>
                    </div>

                    <div class="form-group <?php if (form_error('product_type')) { echo 'has-error'; } ?>">
                        <label for="product_type" class="col-sm-3 control-label"><?php echo lang('product_type')?></label>
                        <div class="col-sm-8">
                            <?php foreach ($product_type as $row): ?>
                            <label class="radio-inline"><input type="radio" name="product_type" value="<?php echo $row['ms_product_type_id'] ?>" <?php echo set_checkbox('product_type', $row['ms_product_type_id'], (($product['product_type_id'] == $row['ms_product_type_id']) ? true : false)); ?>><?php echo $row['name'] ?></label>
                            <?php endforeach; ?>
                            <?php echo form_error('product_type[]'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="different_size" class="col-sm-3 control-label">Has Different Size?</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="different_size" id="different_size">
                                <option <?php echo set_select('different_size', 1, ($product['has_different_size'] == 1) ? true : false); ?> value="1"><?php echo lang('yes')?></option>
                                <option <?php echo set_select('different_size', 0, ($product['has_different_size'] == 0) ? true : false); ?> value="0"><?php echo lang('no')?></option>
                            </select>
                            <?php echo form_error('different_size'); ?>
                        </div>
                    </div>

                    <div class="form-group <?php if (form_error('item_price')) { echo 'has-error'; } ?>" id="product_price_div" style="<?php echo ($product['has_different_size'] == 0) ? 'display:block' : 'display:none'; ?>">
                        <label for="item_price" class="col-sm-3 control-label"><?php echo lang('price')?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="item_price" name="item_price" value="<?php echo set_value('item_price', $product['price']); ?>">
                            <?php echo form_error('item_price'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status" class="col-sm-3 control-label"><?php echo lang('status')?></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="status" id="status">
                                <option <?php echo set_select('status', 1, ($product['status'] == 1) ? true : false); ?> value="1"><?php echo lang('active')?></option>
                                <option <?php echo set_select('status', 0, ($product['status'] == 0) ? true : false); ?> value="0"><?php echo lang('inactive')?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group m-b-0">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-purple btn-loading" name="submit" value="EDIT">&nbsp;&nbsp; <?php echo lang('update')?> &nbsp;&nbsp;</button>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-5 has-product-modifier">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Customize product</h3>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <a href="<?php echo $urlModifier; ?>" data-toggle="modal" data-target="#ajaxModal" class="btn btn-sm btn-primary">Add Modifier</a>
                <div id="item-all-modifiers" style="margin-top:20px;">Loading...</div>
            </div>
        </div>
    </div>
    <div class="col-md-5 has-size-modifier" id="product_different_size_div" style="<?php echo ($product['has_different_size'] != 0) ? 'display:block' : 'display:none'; ?>">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Customize product Size</h3>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                
                <a href="<?php echo $urlSize; ?>" data-toggle="modal" data-target="#ajaxModalSize" class="btn btn-sm btn-primary" id="add-product-sizes">Add Size</a>
                <div id="size-all-modifiers" style="margin-top:20px;">Loading...</div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ajaxModal">
    <div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>

<div class="modal fade" id="ajaxModalSize">
    <div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>

<?php $this->load->view('admin/product_modifier/index'); ?>
<?php $this->load->view('admin/product_sizes/index'); ?>

<script type="text/javascript">
    var product = {};
    product.productId = '<?php echo $product['product_id']; ?>'
</script>

