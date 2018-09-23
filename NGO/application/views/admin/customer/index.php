<div class="panel panel-default custom-panel">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo lang('customer_management.header');?> &nbsp;&nbsp;<span class="badge"><?php echo count($list); ?></span></h3>
            <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <table class="table table-striped datatable" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="15%"><?php echo lang('customername')?></th>
                    <th width="15%"><?php echo lang('email')?></th>
                    <th width="20%"><?php echo lang('phone')?></th>
                    <th width="10%"><?php echo lang('zipcode.column')?></th>
                    <th width="10%"><?php echo lang('city')?></th>
                    <th width="10%"><?php echo lang('status')?></th>
                    <th width="10%"><?php echo lang('action')?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($list)): ?>
                    <?php foreach ($list as $row): ?>
                        <tr>
                            <td><?php echo $row['first_name'].$row['last_name'];?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['phone'];?></td>
                            <td><?php echo $row['zipcode']; ?></td>
                            <td><?php echo $row['city']; ?></td>
                            <td>
                                <input type="checkbox" data-size="mini" class="bootstrap-switch" data-on-text="Yes" data-off-text="No" data-off-color="danger" <?php echo ($row['status']) ? 'checked' : ''; ?> data-action="/customer/status_update" data-id="<?php echo $row['customer_id'] ?>" />
                            </td>      
                                                
                            <td>
                                <a href="<?php echo base_url('admin/customer/edit/' . $row['customer_id']); ?>" class="btn btn-xs" data-toggle="tooltip" data-placement="bottom" title="<?php echo lang('edit')?>"><i class="glyphicon glyphicon-edit"></i> &nbsp;</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
