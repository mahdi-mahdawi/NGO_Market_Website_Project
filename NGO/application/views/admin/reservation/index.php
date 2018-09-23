<div class="panel panel-default custom-panel">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo lang('reservation.header');?> &nbsp;&nbsp;<span class="badge"><?php echo count($list); ?></span></h3>
            <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <table class="table table-striped datatable" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="15%"><?php echo lang('name')?></th>
                    <th width="20%"><?php echo lang('email')?></th>
                    <th width="15%"><?php echo lang('mobile')?></th>
                    <th width="20%"><?php echo lang('booking_date')?></th>
                    <th width="20%"><?php echo lang('booking_time')?></th>
                    <th width="10%"><?php echo lang('action')?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($list)): ?>
                    <?php foreach ($list as $row): ?>
                        <tr>
                            <td><?php echo $row['name'];?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['mobile'];?></td>
                            <td><?php echo $row['booking_date']; ?></td>
                            <td><?php echo $row['booking_time']; ?></td>
                            <td>
                                <a href="<?php echo base_url('admin/reservation/edit/' . $row['id']); ?>" class="btn btn-xs" data-toggle="tooltip" data-placement="bottom" title="<?php echo lang('edit')?>"><i class="glyphicon glyphicon-edit"></i> &nbsp;</a>
                                <a data-href="<?php echo 'reservation/delete/' . $row['id']; ?>" class="btn btn-xs btn-delete" data-toggle="tooltip" data-placement="bottom" title="<?php echo lang('delete')?>"><i class="glyphicon glyphicon-trash"></i> &nbsp;</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
