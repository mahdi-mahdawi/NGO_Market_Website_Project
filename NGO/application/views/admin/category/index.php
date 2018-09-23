<div class="panel panel-default custom-panel">
    <div class="panel-heading">
        <h3 class="panel-title">Product Category &nbsp;&nbsp;<span class="badge"><?php echo count($list); ?></span></h3>
        <div class="pull-right">
            <a href="<?php echo base_url('admin/product_category/add'); ?>" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"></span> <?php echo lang('add_category')?></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <table class="table table-striped datatable" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="15%"><?php echo lang('name')?></th>
                    <th width="40%"><?php echo lang('description')?></th>
                    <th width="10%"><?php echo lang('status_column')?></th>
                    <th width="10%"><?php echo lang('action')?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($list)): ?>
                    <?php foreach ($list as $row): ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td>
                                <input type="checkbox" data-size="mini" class="bootstrap-switch" data-on-text="Yes" data-off-text="No" data-off-color="danger" <?php echo ($row['status']) ? 'checked' : ''; ?> data-action="/product_category/status_update" data-id="<?php echo $row['product_category_id'] ?>" />
                            </td>
                            <td>
                                <a href="<?php echo base_url('admin/product_category/edit/' . $row['product_category_id']); ?>" class="btn btn-xs" data-toggle="tooltip" data-placement="bottom" title="<?php echo lang('edit')?>"><i class="glyphicon glyphicon-edit"></i> &nbsp;</a>
                                <a data-href="<?php echo 'product_category/delete/' . $row['product_category_id']; ?>" class="btn btn-xs btn-delete" data-toggle="tooltip" data-placement="bottom" title="<?php echo lang('delete')?>"><i class="glyphicon glyphicon-trash"></i> &nbsp;</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
