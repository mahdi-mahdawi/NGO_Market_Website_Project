<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo lang('payment.header')?></h3>
    </div>
    <div class="panel-body">
        <div class="spacer-10"></div>
        <!-- Nav tabs -->
        <!--Menu for showing Tab-->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#payment" aria-controls="payment" role="tab" data-toggle="tab">Payment</a></li>
            <li role="presentation"><a href="#stripe_settings" aria-controls="stripe_settings" role="tab" data-toggle="tab">Stripe</a></li>
            <li role="presentation"><a href="#braintree_settings" aria-controls="braintree_settings" role="tab" data-toggle="tab">Braintree</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="payment">
                <br><br>
                <?php echo form_open(base_url('admin/settings/payment'), array('class' => 'form-horizontal')); ?>
                <div class="spacer-10"></div>

                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="1" name="accept_cash" id="accept_cash" <?php echo ($settings['accept_cash']) ? 'checked' : ''; ?>>
                        Accept cash
                    </label>
                </div>

                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="1" name="stripe_payment_status" id="stripe_payment_status" <?php echo ($settings['stripe_payment_status']) ? 'checked' : ''; ?>>
                        Stripe Payment Gateway
                    </label>
                </div>

                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="1" name="braintree_payment_status" id="braintree_payment_status" <?php echo ($settings['braintree_payment_status']) ? 'checked' : ''; ?>>
                        Braintree Payment Gateway
                    </label>
                </div>

                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="1" name="checkout_type_delivery" id="checkout_type_delivery" <?php echo ($settings['checkout_type_delivery']) ? 'checked' : ''; ?>>
                        Checkout - Delivery
                    </label>
                </div>

                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="1" name="checkout_type_carryout" id="checkout_type_carryout" <?php echo ($settings['checkout_type_carryout']) ? 'checked' : ''; ?>>
                        Checkout - Carry-out
                    </label>
                </div>

                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="1" name="checkout_type_dinein" id="checkout_type_dinein" <?php echo ($settings['checkout_type_dinein']) ? 'checked' : ''; ?>>
                        Checkout - Dine-in
                    </label>
                </div>

                
                <div class="form-group m-b-0">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-purple btn-loading" name="submit" value="EDIT">&nbsp;&nbsp; <?php echo lang('update')?> &nbsp;&nbsp;</button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div role="tabpanel" class="tab-pane" id="stripe_settings">
                <br><br>
                <?php echo form_open(base_url('admin/settings/payment'), array('class' => 'form-horizontal')); ?>
                    <input type="hidden" name="stripe" value="1" />
                    <div class="spacer-10"></div>

                    <div class="form-group <?php if (form_error('stripe_secret_key')) echo 'has-error'; ?>">
                        <label for="" class="col-sm-3 control-label"><?php echo lang('secret_key')?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control"   name="stripe_secret_key" id="stripe_secret_key" value="<?php echo (validation_errors()) ? set_value('stripe_secret_key') : $settings['stripe_secret_key']; ?>">
                            <?php echo form_error('stripe_secret_key'); ?>
                        </div>
                    </div>

                    <div class="form-group <?php if (form_error('stripe_publishable_key')) echo 'has-error'; ?>">
                        <label for="" class="col-sm-3 control-label"><?php echo lang('publishable_key')?></label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control"   name="stripe_publishable_key" id="stripe_publishable_key" value="<?php echo (validation_errors()) ? set_value('stripe_publishable_key') : $settings['stripe_publishable_key']; ?>">
                            <?php echo form_error('stripe_publishable_key'); ?>
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-purple btn-loading" name="submit" value="EDIT">&nbsp;&nbsp; <?php echo lang('update')?> &nbsp;&nbsp;</button>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>

            <div role="tabpanel" class="tab-pane" id="braintree_settings">
                <br><br>
                <?php echo form_open(base_url('admin/settings/payment'), array('class' => 'form-horizontal')); ?>
                    <input type="hidden" name="braintree" value="1" />
                    <div class="spacer-10"></div>

                    <div class="form-group <?php if (form_error('braintree_environment')) echo 'has-error'; ?>">
                        <label for="" class="col-sm-3 control-label">Environment</label>
                        <div class="col-sm-5">
                            <select class="form-control" name="braintree_environment" id="braintree_environment">
                                <option value="production" <?php echo set_select('braintree_environment', 'production', ($settings['braintree_environment'] == 'production') ? true : false); ?>>Production</option>
                                <option value="sandbox" <?php echo set_select('braintree_environment', 'sandbox', ($settings['braintree_environment'] == 'sandbox') ? true : false); ?>>Sandbox</option>
                            </select>
                            <?php echo form_error('braintree_environment'); ?>
                        </div>
                    </div>

                    <div class="form-group <?php if (form_error('braintree_merchant_id')) echo 'has-error'; ?>">
                        <label for="" class="col-sm-3 control-label">Merchant ID</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="braintree_merchant_id" id="braintree_merchant_id" value="<?php echo set_value('braintree_merchant_id', $settings['braintree_merchant_id']); ?>">
                            <?php echo form_error('braintree_merchant_id'); ?>
                        </div>
                    </div>

                    <div class="form-group <?php if (form_error('braintree_public_key')) echo 'has-error'; ?>">
                        <label for="" class="col-sm-3 control-label">Public Key</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="braintree_public_key" id="braintree_public_key" value="<?php echo set_value('braintree_public_key', $settings['braintree_public_key']); ?>">
                            <?php echo form_error('braintree_public_key'); ?>
                        </div>
                    </div>

                    <div class="form-group <?php if (form_error('braintree_private_key')) echo 'has-error'; ?>">
                        <label for="" class="col-sm-3 control-label">Private Key</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="braintree_private_key" id="braintree_private_key" value="<?php echo set_value('braintree_private_key', $settings['braintree_private_key']); ?>">
                            <?php echo form_error('braintree_private_key'); ?>
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
</div>