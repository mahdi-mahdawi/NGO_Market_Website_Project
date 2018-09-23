<?php $days_name = array(1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday', 7 => 'Sunday'); ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo lang('working_hours.header')?></h3>
    </div>
    <?php echo form_open(base_url('admin/settings/working_hours'), array('class' => 'form-horizontal')); ?>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table-condensed table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="15%"><?php echo lang('day')?></th>
                        <th width="25%"><?php echo lang('opening')?></th>
                        <th width="25%"><?php echo lang('closing')?></th>
                        <th width="25%"><?php echo lang('off')?></th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($days as $keys => $row): ?>
                        <tr>
                            <td><?php echo $days_name[$row['day']]; ?></td>
                            <td>
                                <div class="input-group clockpicker <?php if (form_error('open_hour[' . $row['day'] . ']')) echo 'has-error'; ?>" data-placement="right" data-align="top" data-autoclose="true">
                                    <input type="text" class="form-control" name= "open_hour[<?php echo $row['day'] ?>]" value="<?php echo $row['open_hour'] ?>">

                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                                <?php echo form_error('open_hour[' . $row['day'] . ']'); ?>
                            </td>
                            <td>
                                <div class="input-group clockpicker <?php if (form_error('close_hour[' . $row['day'] . ']')) echo 'has-error'; ?>" data-placement="right" data-align="top" data-autoclose="true">
                                    <input type="text" class="form-control" name= "close_hour[<?php echo $row['day'] ?>]" value="<?php echo set_value('close_hour[' . $row['day'] . ']', $row['close_hour']) ?>">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                                <?php echo form_error('close_hour[' . $row['day'] . ']'); ?>
                            </td>
                            <td>
                                <input type="checkbox" name="status[<?php echo $row['day'] ?>]" value="1" <?php echo set_checkbox("status[" . $row['day'] . "]", 1, ($row['status'] == 1) ? false : true); ?> style="margin-left:5px;">
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div><br>
        <div class="form-group m-b-0">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-purple btn-loading" name="submit" value="EDIT">&nbsp;&nbsp; <?php echo lang('update')?> &nbsp;&nbsp;</button>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
