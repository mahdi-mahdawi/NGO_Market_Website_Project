<div class="modal-content" id="modal-product-modifier">
    <div class="modal-signin">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4><center><?php echo lang('header.modal_product_choice')?></center></h4>

        <?php echo form_open(base_url('cart/add/'.$product['product_id']), ['class' => 'form-horizontal', 'id' => 'form-cart-submit-product']); ?>
            <div class="row">
                <div class="product-cust-title">
                    <div class="col-md-8" style="margin-top:3px">
                        <?php echo $product['name']; ?>
                    </div>
                     <?php if(empty($product['options'])): ?>
                    <div class="col-md-2" style="margin-top:3px">
                        <strong><?php echo format_currency($product['price']); ?></strong>
                    </div>
                    <?php endif; ?>
                    <div class="col-md-2" style="color:#000">
                        <input type="textbox" name="quantity" id="product_size" value="1" style="width:30px;">
                    </div>

                </div>
            </div>
            <div class="product-modify-group row">
                <?php if(!empty($product['options'])): ?> 
                        <h3 class="product-size-heading"><?php echo lang('label.choose_size')?></h3>
                        <?php foreach($product['options'] as $option): ?>
                            <div class="choice-wrapper-outer">
                                <div class="choice-wrapper row" style="border:0px !important;">
                                    <div class="col-md-9 clearfix">
                                        <div class="radio no-padding">
                                            <label>
                                                <input type="radio" name="size_id" id="size_id" value="<?php echo $option['size_id']; ?>" required>
                                                <?php echo $option['size']; ?>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 clearfix">
                                        <?php if($option['menu_price']): ?>
                                            <strong><?php echo format_currency($option['menu_price']); ?></strong>&nbsp;
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                <?php endif; ?>  
            </div>
  
            <?php if(!empty($modifiers)): ?>
                <?php foreach($modifiers as $modifier): ?>
                <div class="product-modify-group row">
                    <h3 class="product-modifier-heading"><?php echo $modifier['name']; ?></h3>
                        
                        <?php if(isset($errors[$modifier['id']])): ?>
                            <div class="product-modifier-error"><?php echo $errors[$modifier['id']]; ?></div>
                        <?php endif; ?>   
                        <?php foreach($modifier['items'] as $item): ?>
                        <div class="choice-wrapper-outer">
                            <div class="choice-wrapper row" style="border:0px !important;">

                                <div class="col-md-9 clearfix">
                                    <?php 
                                        $inputName = 'product[choices][' . $modifier['id'] . '][]' ;
                                        $choices = isset($_POST['product']['choices'][$modifier['id']]) ? $_POST['product']['choices'][$modifier['id']] : [];
                                    ?>

                                    <?php if($modifier['maximum'] == 1): ?>
                                        <div class="radio no-padding">
                                            <label>
                                                <input type="radio" name="<?php echo $inputName; ?>" id="<?php echo 'choice_' . $item['id']; ?>" value="<?php echo $item['id']; ?>" <?php echo (in_array($item['id'], $choices)) ? 'checked="checked"' : ''; ?> required="required">
                                                <?php echo $item['name']; ?>
                                            </label>
                                        </div>
                                    <?php else: ?>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="<?php echo $inputName; ?>" id="<?php echo 'choice_' . $item['id']; ?>" value="<?php echo $item['id']; ?>" <?php echo set_checkbox($inputName, $item['id']); ?>>
                                                <?php echo $item['name']; ?>
                                            </label>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-3 clearfix">
                                    <?php if($item['price']): ?>
                                        <span class="fa fa-plus"></span>
                                        <strong><?php echo format_currency($item['price']); ?></strong>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                <?php endforeach; ?>
            <?php endif; ?>

            <br/>
            <div class="form-group">
                <textarea class="form-control txt-area-product-modify" rows="3" name="note" id="notes" placeholder="Enter any additional information about your order." style="resize: none;"></textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success btn-block" name="submit" value="submit"><?php echo lang('button.continue')?></button>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>

