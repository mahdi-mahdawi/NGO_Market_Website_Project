<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Other  Settings</h3>
    </div>
    <div class="panel-body">
        <?php echo form_open(base_url('admin/settings/other_settings'), array('class' => 'form-horizontal')); ?>
        <div class="spacer-10"></div>
        <div class="form-group <?php if (form_error('cash_on_delivery_status')) echo 'has-error'; ?>">
            <label for="store_language" class="col-sm-3 control-label">Store Language</label>
            <div class="col-sm-5">
                <select class="form-control" name="store_language" id="cash_on_delivery_status">
                    <?php foreach($language as $row):?>
                    <option value="<?php echo $row['code']?>" <?php echo set_select('store_language',  $row['code'], ($settings['cash_on_delivery_status'] == 1) ? TRUE : FALSE) ?>>ON</option>
                    <?php endforeach;?>
                </select>
                <?php echo form_error('cash_on_delivery_status'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('paypal_payment_status')) echo 'has-error'; ?>">
            <label for="paypal_payment_status" class="col-sm-3 control-label">Paypal Status</label>
            <div class="col-sm-5">
                <select class="form-control" name="paypal_payment_status" id="paypal_payment_status">
                    <option value="1" <?php echo set_select('paypal_payment_status', 1, ($settings['paypal_payment_status'] == 1) ? TRUE : FALSE) ?>>ON</option>
                    <option value="0" <?php echo set_select('paypal_payment_status', 0, ($settings['paypal_payment_status'] == 0) ? TRUE : FALSE) ?>>OFF</option>
                </select>
                <?php echo form_error('paypal_payment_status'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('stripe_payment_status')) echo 'has-error'; ?>">
            <label for="stripe_payment_status" class="col-sm-3 control-label">Stripe Payment Status</label>
            <div class="col-sm-5 ">
                <select class="form-control" name="stripe_payment_status" id="stripe_payment_status">
                    <option value="1"  <?php echo set_select('stripe_payment_status', 1, ($settings['stripe_payment_status'] == 1) ? TRUE : FALSE) ?>>ON</option>
                    <option value="0" <?php echo set_select('stripe_payment_status', 0, ($settings['stripe_payment_status'] == 0) ? TRUE : FALSE) ?>>OFF</option>
                </select>
                <?php echo form_error('stripe_payment_status'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('credit_card_status')) echo 'has-error'; ?>">
            <label for="credit_card_status" class="col-sm-3 control-label">Credit Card</label>
            <div class="col-sm-5 ">
                <select class="form-control" name="credit_card_status" id="stripe_payment_status">
                    <option value="1"  <?php echo set_select('credit_card_status', 1, ($settings['credit_card_status'] == 1) ? TRUE : FALSE) ?>>ON</option>
                    <option value="0" <?php echo set_select('credit_card_status', 0, ($settings['credit_card_status'] == 0) ? TRUE : FALSE) ?>>OFF</option>
                </select>
                <?php echo form_error('credit_card_status'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('visa_payment_status')) echo 'has-error'; ?>">
            <label for="visa_payment_status" class="col-sm-3 control-label">Visa Payment Status</label>
            <div class="col-sm-5">
                <select class="form-control" name="visa_payment_status" id="visa_payment_status">
                    <option value="1" <?php echo set_select('visa_payment_status', 1, ($settings['visa_payment_status'] == 1) ? TRUE : FALSE) ?>>ON</option>
                    <option value="0" <?php echo set_select('visa_payment_status', 0, ($settings['visa_payment_status'] == 0) ? TRUE : FALSE) ?>>OFF</option>
                </select>
                <?php echo form_error('visa_payment_status'); ?>
            </div>
        </div>
        <div class="form-group m-b-0">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-purple btn-loading" name="submit" value="EDIT">&nbsp;&nbsp; Update &nbsp;&nbsp;</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>