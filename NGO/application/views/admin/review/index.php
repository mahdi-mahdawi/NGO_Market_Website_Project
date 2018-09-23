<div class="panel panel-default custom-panel">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo lang('review.header');?> &nbsp;&nbsp;<span class="badge"><?php echo count($list); ?></span></h3>
            <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <table class="table table-striped datatable" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="15%"><?php echo lang('customername')?></th>
                    <th width="15%"><?php echo lang('orderid')?></th>
                    <th width="35%"><?php echo lang('comment')?></th>
                    <th width="15%"><?php echo lang('rating')?></th>
                    <th width="10%"><?php echo lang('status')?></th>
                    <th width="10%"><?php echo lang('action')?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($list)): ?>
                    <?php foreach ($list as $row): ?>
                        <tr>
                            <td><?php echo $row['first_name'].$row['last_name'];?></td>
                            <td><a href="<?php echo base_url('admin/order/view/' . $row['order_reference']); ?>"><?php echo $row['order_reference']; ?></a></td>
                            <td><?php echo $row['comments'];?></td>
                            <td><?php echo $row['rating_value']; ?></td>
                            <td>
                                <input type="checkbox" data-size="mini" class="bootstrap-switch" data-on-text="Yes" data-off-text="No" data-off-color="danger" <?php echo ($row['status']) ? 'checked' : ''; ?> data-action="/review/status_update" data-id="<?php echo $row['id'] ?>" />
                            </td>
                            <td>
                                <a href="<?php echo base_url('admin/review/edit/' . $row['id']); ?>" class="btn btn-xs" data-toggle="tooltip" data-placement="bottom" title="<?php echo lang('edit')?>"><i class="glyphicon glyphicon-edit"></i> &nbsp;</a>
                                <a data-href="<?php echo 'review/delete/' . $row['id']; ?>" class="btn btn-xs btn-delete" data-toggle="tooltip" data-placement="bottom" title="<?php echo lang('delete')?>"><i class="glyphicon glyphicon-trash"></i> &nbsp;</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
