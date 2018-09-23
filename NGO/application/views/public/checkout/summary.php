<?php echo $template['partials']['page_header']; ?>

<!-- Content Row -->
<div class="row" id="page-checkout">
    <div class="col-md-6">
        <?php echo $order['first_name'] . ' ' . $order['last_name']; ?> <br>
        <?php echo $order['city'] . ', ' . $order['zipcode']; ?> <br>
        <?php echo $order['phone']; ?> <br>
        <?php echo $order['email']; ?> <br>
        <?php echo $order['address_line_1']; ?> <br>
        <?php echo $order['address_line_2']; ?> <br><br>
    </div>

    <div class="col-md-6">
        <table class="table table-hover table-bordered table-condensed">
            <tbody>
                <tr class="active">
                    <th width="60%"><?php echo lang('th.item'); ?></th>
                    <th width="20%"><?php echo lang('th.quantity'); ?></th>
                    <th width="20%"><?php echo lang('th.total'); ?></th>
                </tr>
                <?php if(!empty($order['items'])): ?>
                    <?php foreach($order['items'] as $row): ?>
                        <tr>
                            <td>
                                <?php echo $row['name']; ?>
                                <?php if(!empty($row['sizes'])): ?>
                                    &nbsp;(<?php echo $row['sizes']; ?>)
                                <?php endif; ?><br>
                                <?php if(!empty($row['instruction'])): ?>
                                    <small><?php echo $row['instruction']; ?></small>
                                <?php endif; ?>
                                <?php if(!empty($row['options'])): ?>
                                    <ul class="choice-options">
                                        <?php foreach($row['options'] as $index => $value): ?>
                                            <?php if(!empty($value['modifier_name'])): ?>
                                                <li>
                                                    <?php echo $value['modifier_item_name']; ?>
                                                    <?php if($value['modifier_item_price']): ?>
                                                        (<?php echo format_currency($value['modifier_item_price']); ?>)
                                                    <?php endif; ?>
                                                </li>
                                            
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $row['quantity'] . " <strong>x</strong> " . format_currency($row['price']); ?></td>
                            <td><?php echo format_currency($row['subtotal']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                <tr>
                    <td colspan="2"><span class="pull-right"><?php echo lang('th.sub_total'); ?></span></td>
                    <td><?php echo format_currency($order['subtotal']); ?></td>
                </tr>
                <tr>
                    <td colspan="2"><span class="pull-right"><?php echo lang('th.tax'); ?> (<?php echo $order['tax']; ?>%)</span></td>
                    <td><?php echo format_currency($order['tax_amount']); ?></td>
                </tr>
                <tr>
                    <td colspan="2"><span class="pull-right"><?php echo lang('th.delivery_charge'); ?></span></td>
                    <td><?php echo format_currency($order['delivery_charge']); ?></td>
                </tr>

                <?php if($order['coupon_id']): ?>
                    <tr>
                        <td colspan="2"><span class="pull-right"><?php echo lang('th.coupon_applied'); ?></span></td>
                        <td> - <?php echo format_currency($order['coupon_discount']); ?></td>
                    </tr>
                <?php endif; ?>

                <tr>
                    <td colspan="2"><span class="pull-right"><?php echo lang('th.total'); ?></span></td>
                    <td><?php echo format_currency($order['payed_amount']); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- /.row -->

<hr>