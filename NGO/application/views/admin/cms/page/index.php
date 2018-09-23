<div class="panel panel-default custom-panel">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo lang('page.header')?></h3>
        <div class="pull-right">
            <a href="<?php echo base_url('admin/cms/page/add'); ?>" class="btn btn-primary btn-sm">
                <span class="glyphicon glyphicon-plus"></span> <?php echo lang('addpage.button')?>
            </a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <table class="table table-striped datatable" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="20%"><?php echo lang('page.header')?></th>
                    <th width="20%"><?php echo lang('url')?></th>
                    <th width="20%"><?php echo lang('page_title')?></th>
                    <th width="20%"><?php echo lang('301_redirect')?></th>
                    <th width="10%"><?php echo lang('status_column')?></th>
                    <th width="10%"><?php echo lang('action')?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($list)): ?>
                    <?php foreach ($list as $row): ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['url']; ?></td>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['301_redirect_url']; ?></td>
                           <td>
                                <input type="checkbox" data-size="mini" class="bootstrap-switch" data-on-text="Yes" data-off-text="No" data-off-color="danger" <?php echo ($row['status']) ? 'checked' : ''; ?> data-action="/cms/page/status_update" data-id="<?php echo $row['page_id'] ?>" />
                            </td>
                            <td>
                                <a href="<?php echo base_url('admin/cms/page/edit/' . $row['page_id']); ?>" class="btn btn-xs" data-toggle="tooltip" data-placement="bottom" title="<?php echo lang('edit')?>"><i class="glyphicon glyphicon-edit"></i> &nbsp;</a>
                                <?php if ($row['type'] != 'd'): ?>
                                    <a data-href="<?php echo 'cms/page/delete/' . $row['page_id']; ?>" class="btn btn-xs btn-delete" data-toggle="tooltip" data-placement="bottom" title="<?php echo lang('delete')?>"><i class="glyphicon glyphicon-trash"></i> &nbsp;</a>
                                <?php else: ?>
                                    <a class="btn btn-xs" data-toggle="tooltip" data-placement="bottom" title="Delete disabled" href="javascript:void(0)"><i class="glyphicon glyphicon-trash disabled"></i> &nbsp;</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
