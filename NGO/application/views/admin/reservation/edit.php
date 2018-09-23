<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo lang('editreservation.header')?></h3>
    </div>
    <div class="panel-body">
        <?php echo form_open(base_url('admin/reservation/edit/' . $reservation['id']), array('class' => 'form-horizontal')); ?>

        <div class="form-group <?php if (form_error('name')) echo 'has-error'; ?>">
            <label for="name" class="col-sm-3 control-label"><?php echo lang('name')?></label>
            <div class="col-sm-5">
                <input type="text"  class="form-control" id="name" name="name" value="<?php echo set_value('name', $reservation['name']); ?>">
                <?php echo form_error('name'); ?>
            </div>
        </div>

        <div class="form-group <?php if (form_error('email')) echo 'has-error'; ?>">
            <label for="email" class="col-sm-3 control-label"><?php echo lang('email')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="email" name="email" value="<?php echo set_value('email', $reservation['email']); ?>">
                <?php echo form_error('email'); ?>
            </div>
        </div>
        
        <div class="form-group <?php if (form_error('mobile')) echo 'has-error'; ?>">
            <label for="mobile" class="col-sm-3 control-label"><?php echo lang('mobile')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo set_value('mobile', $reservation['mobile']); ?>">
                <?php echo form_error('mobile'); ?>
            </div>
        </div>
        
        <div class="form-group <?php if (form_error('booking_date')) echo 'has-error'; ?>">
            <label for="booking_date" class="col-sm-3 control-label"><?php echo lang('booking_date')?></label>
            <div class="col-sm-2">
                <input type="text" class="form-control date datetime-picker" id="booking_date" name="booking_date" value="<?php echo set_value('booking_date', $reservation['booking_date']); ?>">
                <?php echo form_error('booking_date'); ?>
            </div>
        </div>


        <div class="form-group <?php if (form_error('booking_time')) echo 'has-error'; ?>">
            <label for="booking_time" class="col-sm-3 control-label"><?php echo lang('booking_time')?></label>
            <div class="col-md-2">
                <input type="text" class="form-control clockpicker" name= "booking_time" id="booking_time" value="<?php echo $reservation['booking_time'] ?>" data-autoclose="true">
                <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
            </div>
            <?php echo form_error('booking_time'); ?>
        </div>


        <div class="form-group <?php if (form_error('party_size')) echo 'has-error'; ?>">
            <label for="party_size" class="col-sm-3 control-label"><?php echo lang('party_size')?></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="party_size" name="party_size" value="<?php echo set_value('party_size', $reservation['party_size']); ?>">
                <?php echo form_error('party_size'); ?>
            </div>
        </div>

        <div class="form-group <?php if (form_error('extra_notes')) echo 'has-error'; ?>">
            <label for="extra_notes" class="col-sm-3 control-label"><?php echo lang('extra_notes')?></label>
            <div class="col-sm-5">
                <textarea class="form-control" rows="5" name="extra_notes" id="extra_notes"><?php echo set_value('extra_notes', $reservation['extra_notes']) ?></textarea>
                <?php echo form_error('extra_notes'); ?>
            </div>
        </div>

        <div class="form-group">
            <label for="status" class="col-sm-3 control-label"><?php echo lang('status')?></label>
            <div class="col-sm-2">
                <select class="form-control" name="status" id="status">
                    <option <?php echo set_select('status', 1, ($reservation['status'] == 1) ? TRUE : FALSE); ?> value="1"><?php echo lang('active')?></option>
                    <option <?php echo set_select('status', 0, ($reservation['status'] == 0) ? TRUE : FALSE); ?> value="0"><?php echo lang('inactive')?></option>
                </select>
                <?php echo form_error('status'); ?>
            </div>
        </div>
        
        <div class="form-group m-b-0">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-purple btn-loading" name="submit" value="EDIT">&nbsp;&nbsp; <?php echo lang('update')?> &nbsp;&nbsp;</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>