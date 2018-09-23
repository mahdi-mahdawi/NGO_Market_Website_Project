<?php echo $template['partials']['page_header']; ?>

<!-- Content Row -->
<div class="row">

    <div class="col-md-3">
        <?php echo $template['partials']['profile_menu']; ?>
    </div>

    <div class="col-md-9">
        <h4>
            <center>
              ORDER #<?php echo $order['order_reference']; ?> <br/>
              <small><?php echo date('F d, Y', strtotime($order['order_date'])); ?></small>
            </center>
        </h4>

        <table class="table table-condensed">
            <tr>
                <td width="70%"><?php echo lang('th.status'); ?></td>
                <td width="30%"><?php echo get_order_status($order['order_status']); ?></td>
            </tr>
            <tr>
                <td><?php echo lang('th.total'); ?></td>
                <td><?php echo format_currency($order['subtotal']); ?></td>
            </tr>
            <tr>
                <td><?php echo lang('th.tax'); ?> (<?php echo $order['tax'] ?>%)</td>
                <td><?php echo format_currency($order['tax_amount']); ?></td>
            </tr>
            <tr>
                <td><?php echo lang('th.delivery_charge'); ?></td>
                <td><?php echo format_currency($order['delivery_charge']); ?></td>
            </tr>
            <tr>
                <td><?php echo lang('th.payed_amount'); ?></td>
                <td><?php echo format_currency($order['payed_amount']); ?></td>
            </tr>
        </table>

        <table class="table table-condensed" style="background-color:white">
            <thead>
                <tr>
                    <th colspan="3"><?php echo lang('th.items'); ?></th>
                </tr>
            </thead>
            <tbody>
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
            </tbody>
        </table>
    </div>
</div>
<!-- /.row -->