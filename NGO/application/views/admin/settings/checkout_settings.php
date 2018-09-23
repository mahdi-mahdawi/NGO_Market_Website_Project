<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Checkout Settings</h3>
    </div>
    <div class="panel-body">
        <?php echo form_open(base_url('admin/settings/checkout'), array('class' => 'form-horizontal')); ?>
        <div class="spacer-10"></div>
        <div class="form-group <?php if (form_error('customer_account_status')) echo 'has-error'; ?>">
            <label for="customer_account_status" class="col-sm-3 control-label">Customer accounts</label>
            <div class="col-sm-5">
                <select class="form-control" name="customer_account_status" id="customer_account_status">
                    <option value="0" <?php echo set_select('customer_account_status', 0, ($settings['customer_account_status'] == 0) ? TRUE : FALSE) ?>>Accounts are disabled</option>
                    <option value="1" <?php echo set_select('customer_account_status', 1, ($settings['customer_account_status'] == 1) ? TRUE : FALSE) ?>>Accounts are optional</option>
                    <option value="2" <?php echo set_select('customer_account_status', 2, ($settings['customer_account_status'] == 2) ? TRUE : FALSE) ?>>Accounts are required</option>
                </select>
                <span class="help-block">Choose if you want to prompt your customer to create an account when they check out.</span>
            </div>
        </div>

        <h3 class="panel-title">Form Options</h3>
        <p>Choose whether your checkout form requires extra information from your customer.</p>

        <div class="form-group <?php if (form_error('checkout_form_field_streetname')) echo 'has-error'; ?>">
            <label for="checkout_form_field_streetname" class="col-sm-3 control-label">Street name</label>
            <div class="col-sm-5">
                <select class="form-control" name="checkout_form_field_streetname" id="checkout_form_field_streetname">
                    <option value="0" <?php echo set_select('checkout_form_field_streetname', 0, ($settings['checkout_form_field_streetname'] == 0) ? TRUE : FALSE) ?>>Hidden</option>
                    <option value="1" <?php echo set_select('checkout_form_field_streetname', 1, ($settings['checkout_form_field_streetname'] == 1) ? TRUE : FALSE) ?>>Optional</option>
                    <option value="2" <?php echo set_select('checkout_form_field_streetname', 2, ($settings['checkout_form_field_streetname'] == 2) ? TRUE : FALSE) ?>>Required</option>
                </select>
                <?php echo form_error('checkout_form_field_streetname'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('checkout_form_field_email')) echo 'has-error'; ?>">
            <label for="checkout_form_field_email" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-5 ">
                <select class="form-control" name="checkout_form_field_email" id="checkout_form_field_email">
                    <option value="0" <?php echo set_select('checkout_form_field_email', 0, ($settings['checkout_form_field_email'] == 0) ? TRUE : FALSE) ?>>Hidden</option>
                    <option value="1" <?php echo set_select('checkout_form_field_email', 1, ($settings['checkout_form_field_email'] == 1) ? TRUE : FALSE) ?>>Optional</option>
                    <option value="2" <?php echo set_select('checkout_form_field_email', 2, ($settings['checkout_form_field_email'] == 2) ? TRUE : FALSE) ?>>Required</option>
                </select>
                <?php echo form_error('checkout_form_field_email'); ?>
            </div>
        </div>
        <div class="form-group <?php if (form_error('checkout_form_field_company')) echo 'has-error'; ?>">
            <label for="checkout_form_field_company" class="col-sm-3 control-label">Compay name</label>
            <div class="col-sm-5 ">
                <select class="form-control" name="checkout_form_field_company" id="checkout_form_field_company">
                    <option value="0" <?php echo set_select('checkout_form_field_company', 0, ($settings['checkout_form_field_company'] == 0) ? TRUE : FALSE) ?>>Hidden</option>
                    <option value="1" <?php echo set_select('checkout_form_field_company', 1, ($settings['checkout_form_field_company'] == 1) ? TRUE : FALSE) ?>>Optional</option>
                    <option value="2" <?php echo set_select('checkout_form_field_company', 2, ($settings['checkout_form_field_company'] == 2) ? TRUE : FALSE) ?>>Required</option>
                </select>
                <?php echo form_error('checkout_form_field_company'); ?>
            </div>
        </div>

        <div class="form-group <?php if (form_error('checkout_form_field_floor')) echo 'has-error'; ?>">
            <label for="checkout_form_field_floor" class="col-sm-3 control-label">Floor</label>
            <div class="col-sm-5 ">
                <select class="form-control" name="checkout_form_field_floor" id="checkout_form_field_floor">
                    <option value="0" <?php echo set_select('checkout_form_field_floor', 0, ($settings['checkout_form_field_floor'] == 0) ? TRUE : FALSE) ?>>Hidden</option>
                    <option value="1" <?php echo set_select('checkout_form_field_floor', 1, ($settings['checkout_form_field_floor'] == 1) ? TRUE : FALSE) ?>>Optional</option>
                    <option value="2" <?php echo set_select('checkout_form_field_floor', 2, ($settings['checkout_form_field_floor'] == 2) ? TRUE : FALSE) ?>>Required</option>
                </select>
                <?php echo form_error('checkout_form_field_floor'); ?>
            </div>
        </div>

        <div class="form-group <?php if (form_error('checkout_form_field_address')) echo 'has-error'; ?>">
            <label for="checkout_form_field_address" class="col-sm-3 control-label">Other address info</label>
            <div class="col-sm-5 ">
                <select class="form-control" name="checkout_form_field_address" id="checkout_form_field_floor">
                    <option value="0" <?php echo set_select('checkout_form_field_address', 0, ($settings['checkout_form_field_address'] == 0) ? TRUE : FALSE) ?>>Hidden</option>
                    <option value="1" <?php echo set_select('checkout_form_field_address', 1, ($settings['checkout_form_field_address'] == 1) ? TRUE : FALSE) ?>>Optional</option>
                    <option value="2" <?php echo set_select('checkout_form_field_address', 2, ($settings['checkout_form_field_address'] == 2) ? TRUE : FALSE) ?>>Required</option>
                </select>
                <?php echo form_error('checkout_form_field_address'); ?>
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