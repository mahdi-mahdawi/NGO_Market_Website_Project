<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">SMS Settings</h3>
    </div>

    <div class="panel-body">
        <?php echo form_open(base_url('admin/settings/SMS'), array('class' => 'form-horizontal')); ?>
            <h3>SMS Gateway</h3>
            <div class="spacer-10"></div>

            <div class="col-md-6 col-md-offset-3">
                <div class="radio">
                    <label>
                        <input type="radio" name="sms_gateway" value="twilio" <?php echo ($settings['sms_gateway'] == 'twilio') ? 'checked' : ''; ?>>
                        Twilio <a href="https://www.twilio.com/" target="_blank">https://www.twilio.com/</a>
                    </label>
                </div>

                <div class="radio">
                    <label>
                        <input type="radio" name="sms_gateway" value="nexmo" <?php echo ($settings['sms_gateway'] == 'nexmo') ? 'checked' : ''; ?>>
                        Nexmo <a href="https://www.nexmo.com/" target="_blank">https://www.nexmo.com/</a>
                    </label>
                </div>

                <div class="radio">
                    <label>
                        <input type="radio" name="sms_gateway" value="clickatell" <?php echo ($settings['sms_gateway'] == 'clickatell') ? 'checked' : ''; ?>>
                        Clickatell <a href="https://www.clickatell.com" target="_blank">https://www.clickatell.com</a>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9" style="margin-top: 20px;">
                    <button type="submit" class="btn btn-purple btn-loading" name="submit" value="sms_gateway">&nbsp;&nbsp; <?php echo lang('update')?> &nbsp;&nbsp;</button>
                </div>
            </div>
        <?php echo form_close(); ?>
    </div>

    <hr>

    <div class="panel-body">
        <?php echo form_open(base_url('admin/settings/SMS'), array('class' => 'form-horizontal')); ?>
            <h3>Twilio</h3>
            <div class="spacer-10"></div>

            <div class="form-group <?php if (form_error('twilio_account_id')) echo 'has-error'; ?>">
                <label for="" class="col-sm-3 control-label">Twilio Account SID</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="twilio_account_id" id="twilio_account_id" value="<?php echo set_value('twilio_account_id', $settings['twilio_account_id']);?>">
                    <?php echo form_error('twilio_account_id'); ?>
                </div>
            </div>

            <div class="form-group <?php if (form_error('twilio_auth_token')) echo 'has-error'; ?>">
                <label for="" class="col-sm-3 control-label">Twilio Auth Token</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="twilio_auth_token" id="twilio_auth_token" value="<?php echo set_value('twilio_auth_token', $settings['twilio_auth_token']); ?>" >
                    <?php echo form_error('twilio_auth_token'); ?>
                </div>
            </div>
            
            <div class="form-group <?php if (form_error('twilio_from_number')) echo 'has-error'; ?>">
                <label for="" class="col-sm-3 control-label">Twilio From Number</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="twilio_from_number" id="twilio_from_number" value="<?php echo set_value('twilio_from_number', $settings['twilio_from_number']); ?>">
                    <?php echo form_error('twilio_from_number'); ?>
                </div>
            </div>
            <div class="form-group m-b-0">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-purple btn-loading" name="submit" value="settings_twilio">&nbsp;&nbsp; <?php echo lang('update')?> &nbsp;&nbsp;</button>
                </div>
            </div>
        <?php echo form_close(); ?>
    </div>

    <hr>

    <div class="panel-body">
        <?php echo form_open(base_url('admin/settings/SMS'), array('class' => 'form-horizontal')); ?>
            <h3>Nexmo</h3>
            <div class="spacer-10"></div>

            <div class="form-group <?php if (form_error('nexmo_api_key')) echo 'has-error'; ?>">
                <label for="" class="col-sm-3 control-label">Nexmo API Key  </label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="nexmo_api_key" id="nexmo_api_key" value="<?php echo set_value('nexmo_api_key', $settings['nexmo_api_key']); ?>">
                    <?php echo form_error('nexmo_api_key'); ?>
                </div>
            </div>

            <div class="form-group <?php if (form_error('nexmo_api_secret')) echo 'has-error'; ?>">
                <label for="" class="col-sm-3 control-label">Nexmo API Secret</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="nexmo_api_secret" id="nexmo_api_secret" value="<?php echo set_value('nexmo_api_secret', $settings['nexmo_api_secret']); ?>" >
                    <?php echo form_error('nexmo_api_secret'); ?>
                </div>
            </div>
            
            <div class="form-group <?php if (form_error('nexmo_from_number')) echo 'has-error'; ?>">
                <label for="" class="col-sm-3 control-label">Nexmo From Number</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="nexmo_from_number" id="nexmo_from_number" value="<?php echo set_value('nexmo_from_number', $settings['nexmo_from_number']); ?>">
                    <?php echo form_error('nexmo_from_number'); ?>
                </div>
            </div>
            <div class="form-group m-b-0">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-purple btn-loading" name="submit" value="settings_nexmo">&nbsp;&nbsp; <?php echo lang('update')?> &nbsp;&nbsp;</button>
                </div>
            </div>
        <?php echo form_close(); ?>
    </div>

    <hr>

    <div class="panel-body">
        <?php echo form_open(base_url('admin/settings/SMS'), array('class' => 'form-horizontal')); ?>
            <h3>Clickatell</h3>
            <div class="spacer-10"></div>

            <div class="form-group <?php if (form_error('clickatell_username')) echo 'has-error'; ?>">
                <label for="" class="col-sm-3 control-label">Clickatell Username</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="clickatell_username" id="clickatell_username" value="<?php echo set_value('clickatell_username', $settings['clickatell_username']);?>">
                    <?php echo form_error('clickatell_username'); ?>
                </div>
            </div>

            <div class="form-group <?php if (form_error('clickatell_password')) echo 'has-error'; ?>">
                <label for="" class="col-sm-3 control-label">Clickatell Password</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="clickatell_password" id="clickatell_password" value="<?php echo set_value('clickatell_password', $settings['clickatell_password']); ?>" >
                    <?php echo form_error('clickatell_password'); ?>
                </div>
            </div>
            
            <div class="form-group <?php if (form_error('clickatell_api_key')) echo 'has-error'; ?>">
                <label for="" class="col-sm-3 control-label">Clickatell API ID</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="clickatell_api_key" id="clickatell_api_key" value="<?php echo  set_value('clickatell_api_key', $settings['clickatell_api_key']); ?>">
                    <?php echo form_error('clickatell_api_key'); ?>
                </div>
            </div>

            <div class="form-group <?php if (form_error('clickatell_from_number')) echo 'has-error'; ?>">
                <label for="" class="col-sm-3 control-label">Clickatell From Number</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="clickatell_from_number" id="clickatell_from_number" value="<?php echo set_value('clickatell_from_number', $settings['clickatell_from_number']); ?>">
                    <?php echo form_error('clickatell_from_number'); ?>
                </div>
            </div>

            <div class="form-group m-b-0">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-purple btn-loading" name="submit" value="settings_clickatell">&nbsp;&nbsp; <?php echo lang('update')?> &nbsp;&nbsp;</button>
                </div>
            </div>
        <?php echo form_close(); ?>
    </div>

        <hr>

    <div class="panel-body">
        <div class="col-md-7">
            <?php echo form_open(base_url('admin/settings/SMS'), array('class' => 'form-horizontal')); ?>
                <h3>SMS Templates</h3>
                <div class="spacer-10"></div>

                <div class="form-group <?php if (form_error('sms_template_order_placed_to_admin')) echo 'has-error'; ?>">
                    <label for="" class="col-md-3 control-label">Order Placed <br> (To Administrator)</label>
                    <div class="col-md-9">
                        <textarea name="sms_template_order_placed_to_admin" cols="5" rows="5" class="form-control"><?php echo set_value('sms_template_order_placed_to_admin', $settings['sms_template_order_placed_to_admin']); ?></textarea>
                        <?php echo form_error('sms_template_order_placed_to_admin'); ?>
                    </div>
                </div>

                 <div class="form-group <?php if (form_error('sms_template_order_placed_to_customer')) echo 'has-error'; ?>">
                    <label for="" class="col-md-3 control-label">Order Placed <br> (To Customer)</label>
                    <div class="col-md-9">
                        <textarea name="sms_template_order_placed_to_customer" cols="5" rows="5" class="form-control"><?php echo set_value('sms_template_order_placed_to_customer', $settings['sms_template_order_placed_to_customer']); ?></textarea>
                        <?php echo form_error('sms_template_order_placed_to_customer'); ?>
                    </div>
                </div>

                <div class="form-group <?php if (form_error('sms_template_order_confirmed_to_customer')) echo 'has-error'; ?>">
                    <label for="" class="col-md-3 control-label">Order Confirmed <br> (To Customer)</label>
                    <div class="col-md-9">
                        <textarea name="sms_template_order_confirmed_to_customer" cols="5" rows="5" class="form-control"><?php echo set_value('sms_template_order_confirmed_to_customer', $settings['sms_template_order_confirmed_to_customer']); ?></textarea>
                        <?php echo form_error('sms_template_order_confirmed_to_customer'); ?>
                    </div>
                </div>

                <div class="form-group <?php if (form_error('sms_template_order_cancelled_to_customer')) echo 'has-error'; ?>">
                    <label for="" class="col-md-3 control-label">Order Cancelled <br> (To Customer)</label>
                    <div class="col-md-9">
                        <textarea name="sms_template_order_cancelled_to_customer" cols="5" rows="5" class="form-control"><?php echo set_value('sms_template_order_cancelled_to_customer', $settings['sms_template_order_cancelled_to_customer']); ?></textarea>
                        <?php echo form_error('sms_template_order_cancelled_to_customer'); ?>
                    </div>
                </div>

                <div class="form-group <?php if (form_error('sms_template_order_delivered_to_customer')) echo 'has-error'; ?>">
                    <label for="" class="col-md-3 control-label">Order Delivered <br> (To Customer)</label>
                    <div class="col-md-9">
                        <textarea name="sms_template_order_delivered_to_customer" cols="5" rows="5" class="form-control"><?php echo set_value('sms_template_order_delivered_to_customer', $settings['sms_template_order_delivered_to_customer']); ?></textarea>
                        <?php echo form_error('sms_template_order_delivered_to_customer'); ?>
                    </div>
                </div>


                <div class="form-group m-b-0">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-purple btn-loading" name="submit" value="sms_templates">&nbsp;&nbsp; <?php echo lang('update')?> &nbsp;&nbsp;</button>
                    </div>
                </div>
            <?php echo form_close(); ?>
        </div>

        <div class="col-md-5">
            <h3>Tags</h3>
            <div class="spacer-10"></div>
                <table class="table table-bordered">
                    <tr>
                        <td width="50%"><code>order_reference</code></td>
                        <td width="50%"><code>Order ID</code></td>
                    </tr>
                    <tr>
                        <td><code>tax</code></td>
                        <td><code>Tax %</code></td>
                    </tr>
                    <tr>
                        <td><code>delivery_charge</code></td>
                        <td><code>Delivery charge (If applicable)</code></td>
                    </tr>
                    <tr>
                        <td><code>subtotal</code></td>
                        <td><code>Subtotal of cart</code></td>
                    </tr>
                    <tr>
                        <td><code>payed_amount</code></td>
                        <td><code>Grand total</code></td>
                    </tr>
                    <tr>
                        <td><code>payment_mode</code></td>
                        <td><code>Payment mode (cash or card)</code></td>
                    </tr>
                    <tr>
                        <td><code>checkout_type</code></td>
                        <td><code>Checkout type (Delivery,  Carry-out, Dine-in)</code></td>
                    </tr>
                    <tr>
                        <td><code>is_preorder</code></td>
                        <td><code>Is pre-order ? (Yes or No)</code></td>
                    </tr>

                    <tr>
                        <td><code>first_name</code></td>
                        <td><code>Customer first name</code></td>
                    </tr>
                    <tr>
                        <td><code>last_name</code></td>
                        <td><code>Customer last name</code></td>
                    </tr>
                    <tr>
                        <td><code>email</code></td>
                        <td><code>Customer email</code></td>
                    </tr>
                    <tr>
                        <td><code>phone</code></td>
                        <td><code>Customer phone</code></td>
                    </tr>
                    <tr>
                        <td><code>city</code></td>
                        <td><code>Customer city</code></td>
                    </tr>
                    <tr>
                        <td><code>zipcode</code></td>
                        <td><code>Customer zipcode</code></td>
                    </tr>
                    <tr>
                        <td><code>address_line_1</code></td>
                        <td><code>Customer address line 1</code></td>
                    </tr>
                    <tr>
                        <td><code>address_line_2</code></td>
                        <td><code>Customer address line 2</code></td>
                    </tr>
                </table>
        </div>

    </div>

    <hr>

    <div class="panel-body">
        <?php echo form_open(base_url('admin/settings/SMS'), array('class' => 'form-horizontal')); ?>
            <h3>SMS Status</h3>
            <div class="spacer-10"></div>

            <div class="col-md-6 col-md-offset-3">
                <table class="table table-bordered">
                    <tr>
                        <td width="70%">Action</td>
                        <td width="15%">To Customer</td>
                        <td width="15%">To Administrator</td>
                    </tr>

                    <tr>
                        <td>Order Placed</td>
                        <td><input type="checkbox" name="sms_status_order_placed_to_customer" value="1" <?php echo ($settings['sms_status_order_placed_to_customer']) ? 'checked' : ''; ?>></td>
                        <td><input type="checkbox" name="sms_status_order_placed_to_admin" value="1" <?php echo ($settings['sms_status_order_placed_to_admin']) ? 'checked' : ''; ?>></td>
                    </tr>

                    <tr>
                        <td>Order Confirmed</td>
                        <td><input type="checkbox" name="sms_status_order_confirmed_to_customer" value="1" <?php echo ($settings['sms_status_order_confirmed_to_customer']) ? 'checked' : ''; ?>></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>Order Cancelled</td>
                        <td><input type="checkbox" name="sms_status_order_cancelled_to_customer" value="1" <?php echo ($settings['sms_status_order_cancelled_to_customer']) ? 'checked' : ''; ?>></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>Order Delivered</td>
                        <td><input type="checkbox" name="sms_status_order_delivered_to_customer" value="1" <?php echo ($settings['sms_status_order_delivered_to_customer']) ? 'checked' : ''; ?>></td>
                        <td></td>
                    </tr>
                </table>
            </div>

            <div class="form-group m-b-0">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-purple btn-loading" name="submit" value="sms_status">&nbsp;&nbsp; <?php echo lang('update')?> &nbsp;&nbsp;</button>
                </div>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>