<html>
<head></head>
    <body>

        <table border="0" cellpadding="1">
            <tr>
                <td align="center" style="font-size:12px;"><strong><?php echo $store_name; ?></strong></td>
            </tr>

            <tr>
                <td align="center">Phone: <?php echo $store_phone; ?></td>
            </tr>

            <tr>
                <td align="center">Address: <?php echo $store_address; ?></td>
            </tr>

            <tr>
                <td align="center"><i><strong>ORDER #<?php echo $order['order_reference']; ?></strong></i></td>
            </tr>
        </table>

        <br><br>

        <table border="1" cellpadding="3">
            <tr>
                <th width="50%" align="center"><strong>Item</strong></th>
                <th width="10%" align="center"><strong>Qty</strong></th>
                <th width="20%" align="center"><strong>Rate</strong></th>
                <th width="20%" align="center"><strong>Amount</strong></th>
            </tr>
            <?php if(!empty($order['items'])): ?>
                <?php foreach($order['items'] as $index => $item): ?>
                    <tr>
                        <td>
                            <?php echo $item['name']; ?>
                            <?php if(!empty($item['sizes'])): ?>
                                <?php echo '('.$item['sizes'].')'; ?>
                            <?php endif; ?>
                            <?php if(!empty($item['instruction'])): ?>
                                <br><small><?php echo $item['instruction']; ?></small>
                            <?php endif; ?>
                            <?php if(!empty($item['options'])): ?>
                            <ul>
                                <?php foreach($item['options'] as $key => $value): ?>
                                    <?php if(!empty($value['modifier_name'])): ?>
                                        <li><?php echo $value['modifier_item_name'].'&nbsp;('.format_currency($value['modifier_item_price']).')'; ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?> 
                        </td>
                        <td align="center"><?php echo $item['quantity']; ?></td>
                        <td align="center"><?php echo format_currency($item['price'], false); ?></td>
                        <td align="center"><?php echo format_currency($item['subtotal'], false); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            <tr>
                <td colspan="3" align="right">Tax(<?php echo $order['tax']; ?>%)</td>
                <td align="center"><?php echo format_currency($order['tax_amount'], false); ?></td>
            </tr>

            <tr>
                <td colspan="3" align="right">Delivery Charge</td>
                <td align="center"><?php echo format_currency($order['delivery_charge'], false); ?></td>
            </tr>

            <tr>
                <td colspan="3" align="right">Subtotal</td>
                <td align="center"><?php echo format_currency($order['subtotal'], false); ?></td>
            </tr>

            <tr>
                <td colspan="3" align="right">Coupon Discount</td>
                <td align="center"><?php echo format_currency($order['coupon_discount'], false); ?></td>
            </tr>

            <tr>
                <td colspan="3" align="right"><strong>Total</strong></td>
                <td align="center"><strong><?php echo format_currency($order['payed_amount'], false); ?></strong></td>
            </tr>
        </table>

        <p>********************************************************************</p>

    </body>
</html>