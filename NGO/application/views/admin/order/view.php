<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo lang('or.header')?> 
                    <?php if($order['is_preorder']): ?>
                        <span class="label label-danger">Pre order</span>
                    <?php endif; ?>

                    <p class="pull-right">
                        <a href="<?php echo base_url('admin/order/download_receipt/' . $order['order_reference']); ?>" target="_blank" class="btn btn-sm btn-danger">PDF Receipt</a>
                    </p>
                </h3>
            </div>
            <div class="panel-body">
                <div class="col-md-6 col-md-offset-3">

                    <h4>Order</h4>
                    <table class="table table-bordered">
                        <tr>
                            <td width="50%"><strong>ID</strong></td>
                            <td>#<?php echo $order['order_reference']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Date</strong></td>
                            <td><?php echo date('F d, Y',strtotime($order['order_date'])); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td><?php echo get_order_status($order['order_status']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Checkout</strong></td>
                            <td><?php echo get_checkout_type_text($order['checkout_type']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Change order status</strong></td>
                            <td>
                                <?php echo form_open(); ?>
                                    <select class="form-control" name="order_status">
                                        <option value="1" <?php echo set_select('order_status', '1', ($order['order_status'] == 1) ? true : false); ?>><?php echo lang('label.pending'); ?></option>
                                        <option value="2" <?php echo set_select('order_status', '2', ($order['order_status'] == 2) ? true : false); ?>><?php echo lang('label.confirmed'); ?></option>
                                        <option value="3" <?php echo set_select('order_status', '3', ($order['order_status'] == 3) ? true : false); ?>><?php echo lang('label.cancelled'); ?></option>
                                        <option value="4" <?php echo set_select('order_status', '4', ($order['order_status'] == 4) ? true : false); ?>><?php echo lang('label.delivered'); ?></option>
                                    </select>
                                    <br>
                                    <button type="submit" name="submit" value="submit" class="btn btn-success btn-sm">Update Order</button>

                                <?php echo form_close(); ?>
                            </td>
                        </tr>
                    </table>

                    <?php if($order['is_preorder']): ?>
                        <h4>Pre-order</h4>
                        <table class="table table-bordered">
                            <tr>
                                <td width="50%"><strong>Date</strong></td>
                                <td><?php echo date('F d, Y',strtotime($order['preorder_date'])); ?></td>
                            </tr>

                            <tr>
                                <td width="50%"><strong>Time</strong></td>
                                <td><?php echo $order['preorder_time']; ?></td>
                            </tr>
                        </table>
                    <?php endif; ?>

                    <h4>Items</h4>
                    <table class="table table-bordered">
                        <tr>
                            <td width="50%"><strong>Name</strong></td>
                            <td><strong>Quantity</strong></td>
                            <td><strong>Price</strong></td>
                            <td><strong>Subtotal</strong></td>
                        </tr>
                        <?php if(!empty($order['items'])): ?>
                        <?php foreach($order['items'] as $key => $row): ?>
                            <tr>
                                <td>
                                    <?php echo $row['name']; ?>
                                    <?php if(!empty($row['sizes'])): ?>
                                        <?php echo '('.$row['sizes'].')'; ?>
                                    <?php endif; ?><br>
                                    <?php if(!empty($row['instruction'])): ?>
                                        <small><?php echo $row['instruction']; ?></small>
                                    <?php endif; ?>
                                    <?php if(!empty($row['options'])): ?>
                                        <ul>
                                            <?php foreach($row['options'] as $index => $value): ?>
                                                <?php if(!empty($value['modifier_name'])): ?>
                                                    <li><?php echo $value['modifier_item_name'].'&nbsp;('.format_currency($value['modifier_item_price']).')'; ?></li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>
                                   <?php endif; ?>
                                </td>
                                <td><?php echo $row['quantity']; ?></td>
                                <td><?php echo format_currency($row['price']); ?></td>
                                <td><?php echo format_currency($row['subtotal']); ?></td>
                            </tr>
                        <?php endforeach; ?><?php endif; ?>
                    </table>

                    <h4>Address</h4>
                    <table class="table table-bordered">
                        <tr>
                            <td width="50%"><strong>First name</strong></td>
                            <td><?php echo $order['first_name']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Last name</strong></td>
                            <td><?php echo $order['last_name']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td><?php echo $order['email']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Phone</strong></td>
                            <td><?php echo $order['phone']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>City</strong></td>
                            <td><?php echo $order['city']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Zipcode</strong></td>
                            <td><?php echo $order['zipcode']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Address line 1</strong></td>
                            <td><?php echo nl2br($order['address_line_1']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Address line 2</strong></td>
                            <td><?php echo nl2br($order['address_line_2']); ?></td>
                        </tr>
                    </table>

                    <h4>Payment</h4>
                    <table class="table table-bordered">
                        <tr>
                            <td width="50%"><strong>Tax(<?php echo $order['tax']; ?>%)</strong></td>
                            <td><?php echo format_currency($order['tax_amount']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Delivery charge</strong></td>
                            <td><?php echo format_currency($order['delivery_charge']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Sub total</strong></td>
                            <td><?php echo format_currency($order['subtotal']); ?></td>
                        </tr>

                        <?php if($order['coupon_discount']): ?>
                            <tr>
                                <td><strong>Coupon Discount</strong></td>
                                <td><?php echo format_currency($order['coupon_discount']); ?></td>
                            </tr>
                        <?php endif; ?>

                        <tr>
                            <td><strong>Payed amount</strong></td>
                            <td><?php echo format_currency($order['payed_amount']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Payed mode</strong></td>
                            <td><?php echo $order['payment_mode']; ?></td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>