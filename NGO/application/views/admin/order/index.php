<div class="panel panel-default custom-panel">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo lang('order_man.header');?></h3>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <table class="table table-striped datatable" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="10%">ID</th>
                    <th width="15%">Customer</th>
                    <th width="15%">Phone</th>
                    <th width="10%"><?php echo lang('grandtotal')?></th>
                    <th width="10%"><?php echo lang('paymentmode')?></th>
                    <th width="15%"><?php echo lang('date')?></th>
                    <th width="10%"><?php echo lang('status')?></th>
                    <th width="10%"><?php echo lang('action')?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $row): ?>
                    <tr>
                        <td>#<?php echo $row['order_reference'];?></td>
                        <td><?php echo $row['first_name'] . " " . $row['last_name'];?></td>
                        <td><?php echo $row['phone'];?></td>
                        <td><?php echo format_currency($row['payed_amount']); ?></td>
                        <td><?php echo $row['payment_mode']; ?></td>
                        <td><?php echo date('F d, Y',strtotime($row['order_date'])); ?></td>
                        <td><?php echo get_order_status($row['order_status']); ?></td>
                        <td>
                            <a href="<?php echo base_url('admin/order/view/' . $row['order_reference']); ?>" class="btn btn-xs" data-toggle="tooltip" data-placement="bottom" title="<?php echo lang('view')?>"><i class="glyphicon glyphicon-edit"></i> &nbsp;</a>
                            &nbsp;
                            <a href="<?php echo base_url('admin/order/download_receipt/' . $row['order_reference']); ?>" target="_blank" class="btn btn-xs"><i class="glyphicon glyphicon-download-alt"></i> &nbsp;</a> 
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>