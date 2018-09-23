
<div class="row">
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
        <?php echo form_open(base_url('admin/login')); ?>
        <div class="panel panel-default login_panel">
            <div class="panel-body">
                <div class="form-group <?php echo (form_error('email')) ? 'has-error' : ''; ?>">
                    <label for="" class="control-label">Email address</label>
                    <input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo set_value('email'); ?>">
                    <?php echo form_error('email'); ?>
                </div>
                <div class="form-group <?php echo (form_error('password')) ? 'has-error' : ''; ?>">
                    <label for="" class="control-label">Password</label>
                    <input type="password" class="form-control" placeholder="Password" name="password">
                    <?php echo form_error('password'); ?>
                </div>
                <br>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" name="submit" value="LOGIN">Login</button>                  
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>