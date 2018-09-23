<?php echo $template['partials']['page_header']; ?>

<!-- Content Row -->
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <?php echo form_open('', ['id' => 'contactForm']); ?>
        <div class="form-group <?php echo (form_error('name')) ? 'has-error' : ''; ?>">
            <label><?php echo lang('label.name'); ?>:</label>
            <input type="text" class="form-control" name="name" required value="<?php echo set_value('name'); ?>"/>
            <?php echo form_error('name'); ?>
        </div>
        <div class="form-group <?php echo (form_error('phone')) ? 'has-error' : ''; ?>">
            <label><?php echo lang('label.phone'); ?>:</label>
            <input type="text" class="form-control" name="phone"  required value="<?php echo set_value('phone'); ?>" />
            <?php echo form_error('phone'); ?>
        </div>
        <div class="form-group <?php echo (form_error('email')) ? 'has-error' : ''; ?>">
            <label><?php echo lang('label.email'); ?>:</label>
            <input type="email" class="form-control" name="email" required value="<?php echo set_value('email'); ?>" />
            <?php echo form_error('email'); ?>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group <?php echo (form_error('booking_date')) ? 'has-error' : ''; ?>">
                    <label><?php echo lang('label.booking_date'); ?>:</label>
                    <input type="text" class="form-control" name="booking_date" required value="<?php echo set_value('booking_date'); ?>" />
                    <?php echo form_error('booking_date'); ?>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="form-group <?php echo (form_error('booking_time')) ? 'has-error' : ''; ?>">
                    <label><?php echo lang('label.booking_time'); ?>:</label>
                    <input type="text" class="form-control" name="booking_time" required value="<?php echo set_value('booking_time'); ?>" />
                    <?php echo form_error('booking_time'); ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="form-group <?php echo (form_error('party_size')) ? 'has-error' : ''; ?>">
                    <label><?php echo lang('label.party_size'); ?>:</label>
                    <select name="party_size" class="form-control" required>
                        <option value="1">1 - 5</option>
                        <option value="2">6 - 10</option>
                        <option value="3">11 - 15</option>
                        <option value="4">16 - 20</option>
                        <option value="5">Above 20</option>
                    </select>
                    <?php echo form_error('party_size'); ?>
                </div>
            </div>
        </div>
        
        <div class="form-group <?php echo (form_error('message')) ? 'has-error' : ''; ?>">
            <label><?php echo lang('label.message'); ?>:</label>
            <textarea rows="8" cols="100" class="form-control" name="message" maxlength="999" style="resize:none"><?php echo set_value('message'); ?></textarea>
            <?php echo form_error('message'); ?>
        </div>
        <button type="submit" class="btn btn-primary" name="submit" value="submit"><?php echo lang('button.submit'); ?></button> <br><br>
        <?php echo form_close(); ?>
    </div>
</div>
<!-- /.row -->