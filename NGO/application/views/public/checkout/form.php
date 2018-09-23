<?php 
    
    $btn_checkout_status = 1;

    if(!$has_minimum_order_amount) {
        $btn_checkout_status = 0;
    }else if(!$is_store_opened && !$allow_preorder){
        $btn_checkout_status = 0;
    }
?>

<?php if(!$has_minimum_order_amount): ?>
    <div class="alert alert-warning">
        <strong>Warning!</strong> <?php echo lang('text.minimum_order_value') . "  " . $minimum_order_amount; ?>
    </div>
<?php endif; ?>

<?php if(!$is_store_opened && !$allow_preorder): ?>
    <div class="alert alert-warning">
        <strong>Warning!</strong> <?php echo lang('text.store_not_open'); ?>
    </div>
<?php endif; ?>

<?php if(!$is_store_opened && $allow_preorder): ?>
    <div class="alert alert-warning">
        <strong>Warning!</strong> <?php echo lang('text.store_not_open_but_preorder_available'); ?>
    </div>
<?php endif; ?>

<?php if (!$customer_logged_in): ?>
    <div class="checkout_login">
        <?php echo lang('text.login_already_customer'); ?> - 
        <a href="<?php echo base_url('login'); ?>"><?php echo lang('button.login'); ?></a>
    </div>

    <br>
<?php endif; ?>

<?php echo form_open(''); ?>
<div class="row">

    <div class="row" style="margin-left:0px">
        <div class="col-sm-6">
            <div class="form-group <?php echo (form_error('checkout_types')) ? 'has-error' : ''; ?>">
                <select class="form-control" name="checkout_types" id="checkout_types">
                    <?php foreach($checkout_types as $index => $row): ?>
                        <option value="<?php echo $index; ?>" <?php echo ($index == $checkout_type) ? 'selected="selected"' : ''; ?>><?php echo $row; ?></option>
                    <?php endforeach; ?>
                </select>
            <?php echo form_error('checkout_types'); ?>
            </div>
        </div>
    </div>

    <?php if($allow_preorder): ?>
        <div class="col-sm-12">
            <div class="btn-group btn-group-sm" role="group" aria-label=""> 
                <button type="button" class="btn-preorder btn btn-default <?php echo ($is_preorder == 0) ? 'active' : '';  ?>" id="preorder-btn-now"><?php echo lang('label.preorder_now'); ?></button> 
                <button type="button" class="btn-preorder btn btn-default <?php echo ($is_preorder == 1) ? 'active' : '';  ?>" id="preorder-btn-later"><?php echo lang('label.preorder_choose'); ?></button>
                <input type="hidden" name="is_preorder" value="0" id="is_preorder" />
            </div>
        </div>

        <div class="clearfix">&nbsp;</div>

        <div id="preorder-section-element" style="<?php echo !$is_preorder ? 'display:none;' : ''; ?>">
            <div class="col-sm-6">
                <div class="form-group <?php echo (form_error('preorder_date')) ? 'has-error' : ''; ?>">
                    <input type="text" class="form-control datepicker" name="preorder_date" id="preorder_date" placeholder="<?php echo lang('label.preorder_date'); ?>" value="<?php echo set_value('preorder_date'); ?>" />
                    <?php echo form_error('preorder_date'); ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group <?php echo (form_error('preorder_time')) ? 'has-error' : ''; ?>">
                    <input type="text" class="form-control timepicker" name="preorder_time" id="preorder_time" placeholder="<?php echo lang('label.preorder_time'); ?>" value="<?php echo set_value('preorder_time'); ?>" />
                    <?php echo form_error('preorder_time'); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="col-sm-6">
        <div class="form-group <?php echo (form_error('first_name')) ? 'has-error' : ''; ?>">
            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="<?php echo lang('label.first_name'); ?>" value="<?php echo set_value('first_name', $profile['first_name']); ?>" />
            <?php echo form_error('first_name'); ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group <?php echo (form_error('last_name')) ? 'has-error' : ''; ?>">
            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="<?php echo lang('label.last_name'); ?>" value="<?php echo set_value('last_name', $profile['last_name']); ?>" />
            <?php echo form_error('last_name'); ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group <?php echo (form_error('email')) ? 'has-error' : ''; ?>">
            <input type="text" class="form-control" name="email" id="email" placeholder="<?php echo lang('label.email'); ?>" value="<?php echo set_value('email', $profile['email']); ?>" />
            <?php echo form_error('email'); ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group <?php echo (form_error('mobile')) ? 'has-error' : ''; ?>">
            <input type="text" class="form-control" name="mobile" id="mobile" placeholder="<?php echo lang('label.phone'); ?>" value="<?php echo set_value('mobile', $profile['phone']); ?>"  />
            <?php echo form_error('mobile'); ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group <?php echo (form_error('city')) ? 'has-error' : ''; ?>">
            <input type="text" class="form-control" name="city" id="city" placeholder="<?php echo lang('label.city'); ?>" value="<?php echo set_value('city', $profile['city']); ?>" />
            <?php echo form_error('city'); ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group <?php echo (form_error('zipcode')) ? 'has-error' : ''; ?>">
            <input type="text" class="form-control" name="zipcode" id="zipcode" placeholder="<?php echo lang('label.zipcode'); ?>" value="<?php echo set_value('zipcode', $profile['zipcode']); ?>" />
            <?php echo form_error('zipcode'); ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group <?php echo (form_error('address_line_1')) ? 'has-error' : ''; ?>">
            <input type="text" class="form-control" name="address_line_1" id="address_line_1" placeholder="<?php echo lang('label.address_line_1'); ?>" value="<?php echo set_value('address_line_1'); ?>" />
            <?php echo form_error('address_line_1'); ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group <?php echo (form_error('address_line_2')) ? 'has-error' : ''; ?>">
            <input type="text" class="form-control" name="address_line_2" id="address_line_2" placeholder="<?php echo lang('label.address_line_2'); ?>" value="<?php echo set_value('address_line_2'); ?>" />
            <?php echo form_error('address_line_2'); ?>
        </div>
    </div>

    <div class="col-sm-12">

    <ul class="list-unstyled ul-payment">
        <?php if($global_settings['accept_cash']): ?>
            <li>
                <div class="radio">
                    <label>
                        <input type="radio" name="payment_option" id="payment-option-1" checked="checked" value="1"> <?php echo lang('text.pay_by_cash'); ?>
                        <img class="pull-right" src="<?php echo base_url('assets/public/images/cash.png') ?>" style="margin-top: -17px;">
                    </label>
                </div>
            </li>
        <?php endif; ?>

        <?php if($global_settings['stripe_payment_status']): ?>
            <li>
                <div class="radio">
                    <label>
                        <input type="radio" name="payment_option" id="payment-option-2" value="2"> <?php echo lang('text.pay_by_card'); ?>
                        <img class="pull-right" src="<?php echo base_url('assets/public/images/stripe.png') ?>" style="margin-top: -5px;">
                    </label>
                </div>
            </li>
        <?php endif; ?>
        
        <?php if($global_settings['braintree_payment_status']): ?>
            <li>
                <div class="radio">
                    <label>
                        <input type="radio" name="payment_option" id="payment-option-3" value="3"> <?php echo lang('text.pay_by_card'); ?>
                        <img class="pull-right" src="<?php echo base_url('assets/public/images/braintree.png') ?>" style="margin-top: -4px; width: 100px;">
                    </label>
                </div>
            </li>
        <?php endif; ?>
    </ul>

    </div>

    <div class="clear"></div>
    <br>

    <div class="col-sm-12">
        <div class="form-group">
            <button type="submit" name="confirm" class="btn btn-success btn-loading" value="confirm" <?php echo (!$btn_checkout_status) ? 'disabled="disabled"' : ''; ?>><?php echo lang('button.order_now'); ?></button>
        </div>
    </div>
</div>

<?php echo form_close(''); ?>