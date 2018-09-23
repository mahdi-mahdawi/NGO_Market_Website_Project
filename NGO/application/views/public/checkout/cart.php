<table class="table table-hover table-bordered table-condensed">
    <tbody>
        <tr class="active">
            <th width="60%"><?php echo lang('th.item'); ?></th>
            <th width="20%"><?php echo lang('th.quantity'); ?></th>
            <th width="20%"><?php echo lang('th.total'); ?></th>
        </tr>
        
        <?php foreach($contents as $row): ?>
            <tr>
                <td>
                    <a href="<?php echo base_url('cart/remove/' . $row['rowid']); ?>">
                        <i class="fa fa-trash"></i>
                    </a> 
                    &nbsp;<?php echo $row['name']; ?>
                    <?php if(!empty($row['size'])): ?>
                        &nbsp;<small>(<?php echo $row['size']; ?>)</small>
                    <?php endif; ?><br>
                    <?php if(!empty($row['note'])): ?>
                        &nbsp;<small><?php echo $row['note']; ?></small>
                    <?php endif; ?>
                    <?php if(!empty($row['options'])): ?>
                        <ul class="choice-options">
                            <?php foreach($row['options'] as $option): ?>
                                <li>
                                    <?php echo $option['name']; ?>
                                    <?php if($option['price']): ?>
                                        (<?php echo format_currency($option['price']); ?>)
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </td>
                <td><?php echo $row['qty'] . " <strong>x</strong> " . format_currency($row['price']); ?></td>
                <td><?php echo format_currency($row['subtotal']); ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="2"><span class="pull-right"><?php echo lang('th.sub_total'); ?></span></td>
            <td><?php echo format_currency($sub_total); ?></td>
        </tr>
        <tr>
            <td colspan="2"><span class="pull-right"><?php echo lang('th.tax'); ?> (<?php echo $tax_text; ?>%)</span></td>
            <td><?php echo format_currency($tax); ?></td>
        </tr>
        <tr>
            <td colspan="2"><span class="pull-right"><?php echo lang('th.delivery_charge'); ?></span></td>
            <td><?php echo format_currency($delivery_charge); ?></td>
        </tr>

        <?php if($coupon_applied): ?>
            <tr>
                <td colspan="2"><span class="pull-right"><?php echo lang('th.coupon_applied'); ?></span></td>
                <td> - <?php echo format_currency($coupon_discount); ?></td>
            </tr>
        <?php endif; ?>

        <tr>
            <td colspan="2"><span class="pull-right"><?php echo lang('th.total'); ?></span></td>
            <td><?php echo format_currency($grand_total); ?></td>
        </tr>
    </tbody>
</table>

<?php if(!$coupon_applied): ?>

    <!-- Apply Coupon -->
    <?php echo form_open('cart/apply_coupon', ['class' => 'form-inline', 'id' => 'form-apply-coupon']); ?>
        <div class="form-group">
            <label class="sr-only" for="coupon_code"><?php echo lang('th.coupon'); ?></label>
            <input type="text" class="form-control" id="coupon_code" name="coupon_code" placeholder="<?php echo lang('label.coupon'); ?>" id="coupon_code" required="required">
        </div>

        <button type="submit" class="btn btn-primary" name="submit" value="submit"><?php echo lang('button.apply_coupon'); ?></button>
    <?php echo form_close(); ?>

<?php else: ?>

    <p>
        <?php echo form_open('cart/remove_coupon', ['id' => 'form-remove-coupon']); ?>
            <button type="submit" name="submit" value="submit"><i class="fa fa-trash"></i></button>
            <input type="hidden" name="operation" value="remove_coupon" />
            <?php echo $coupon_applied; ?>
        <?php echo form_close(); ?>
    </p>

<?php endif; ?>

<div class="has-error">
    <span id="error-invalid-coupon" class="help-block" style="display:none;"></span>
</div>

<p><br><a href="<?php echo base_url('menus'); ?>"><?php echo lang('button.add_more'); ?></a></p>