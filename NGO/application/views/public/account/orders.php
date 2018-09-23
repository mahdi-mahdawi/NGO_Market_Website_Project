<?php echo $template['partials']['page_header']; ?>

<!-- Content Row -->
<div class="row">

    <div class="col-md-3">
        <?php echo $template['partials']['profile_menu']; ?>
    </div>

    <div class="col-md-9">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>#<?php echo lang('th.id'); ?></th>
                    <th><?php echo lang('th.payed_amount'); ?></th>
                    <th><?php echo lang('th.status'); ?></th>
                    <th><?php echo lang('th.date'); ?></th>
                    <th><?php echo lang('th.actions'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($orders)): ?>
                    <?php foreach($orders as $row): ?>
                        <tr>
                            <td>#<?php echo $row['order_reference']; ?></td>
                            <td><?php echo format_currency($row['payed_amount']); ?></td>
                            <td><?php echo get_order_status($row['order_status']); ?></td>
                            <td><?php echo date('F d, Y', strtotime($row['order_date'])); ?></td>
                            <td>
                                <a href="<?php echo base_url('account/orders/' . $row['order_reference']); ?>"><?php echo lang('button.view'); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- /.row -->