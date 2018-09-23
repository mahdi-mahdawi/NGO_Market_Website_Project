<div class="panel panel-default custom-panel">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo lang('coupon.header')?></h3>
        <div class="pull-right">
            <a href="<?php echo base_url('admin/coupons/add'); ?>" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo lang('addcoupon.button')?></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <table class="table table-striped datatable" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width='15%'><?php echo lang('code')?></th>
                    <th width='15%'><?php echo lang('discount_type')?></th>
                    <th width='10%'><?php echo lang('discount')?></th>
                    <th width='10%'><?php echo lang('usage_limit')?></th>
                    <th width='15%'>Used Coupons</th>
                    <th width='15%'><?php echo lang('end_date')?></th>
                    <th width='10%'><?php echo lang('status_column')?></th>
                    <th width='10%'><?php echo lang('action')?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($list)): ?>
                    <?php foreach ($list as $row): ?>
                        <tr>
                            <td><?php echo $row['code']; ?></td>
                            <td><?php echo ($row['discount_type'] == 'fixed_amount') ? 'Fixed' : 'Percentage' ?></td>
                            <td><?php echo ($row['discount_type'] == 'percentage') ? $row['discount'] . '%' : format_currency($row['discount']); ?></td>
                            <td><?php echo $row['usage_limit'] ?></td>
                            <td><?php echo $row['used_count']; ?></td>
                            <td><?php echo date("d-M-y", strtotime($row['end_date'])); ?></td>
                            <td>
                                <input type="checkbox" data-size="mini" class="bootstrap-switch" data-on-text="Yes" data-off-text="No" data-off-color="danger" <?php echo ($row['status']) ? 'checked' : ''; ?> data-action="/coupons/status_update" data-id="<?php echo $row['id'] ?>" />
                            </td>
                            <td>
                                <a href="<?php echo base_url('admin/coupons/edit/' . $row['id']); ?>" class="btn btn-xs" data-toggle="tooltip" data-placement="bottom" title="<?php echo lang('edit')?>"><i class="glyphicon glyphicon-edit"></i> &nbsp;</a>
                                <a data-href="<?php echo 'coupons/delete/' . $row['id']; ?>" class="btn btn-xs btn-delete" data-toggle="tooltip" data-placement="bottom" title="<?php echo lang('delete')?>"><i class="glyphicon glyphicon-trash"></i> &nbsp;</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


