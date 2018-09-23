<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo lang('order.header')?></h3>
    </div>
    <div class="panel-body">

        <!--Form for order setting-->
        <?php echo form_open(base_url('admin/settings/order'), array('class' => 'form-horizontal')); ?>
            <div class="spacer-10"></div>

            <!--For minimum order field-->
             <div class="form-group <?php if (form_error('minimum_order')) echo 'has-error'; ?>">
                <label for="" class="col-sm-3 control-label"><?php echo lang('minimum_order')?></label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" data-rule-required="true" name="minimum_order" id="minimum_order" value="<?php echo (validation_errors()) ? set_value('minimum_order') : $settings['minimum_order'];?>">
                    <?php echo form_error('minimum_order'); ?>
                </div>
            </div>

            <!--For tax field-->
            <div class="form-group <?php if (form_error('tax')) echo 'has-error'; ?>">
                <label for="" class="col-sm-3 control-label"><?php echo lang('tax')?></label>
                <div class="col-sm-5">
                        <input type="text" class="form-control" data-rule-required="true" name="tax" id="tax" value="<?php 
                        echo (validation_errors()) ? set_value('tax') : $settings['tax']; ?>" >
                        <?php echo form_error('tax'); ?>
                 </div>
            </div>  

            <!--For delivery charge field-->
            <div class="form-group <?php if (form_error('delivery_charge')) echo 'has-error'; ?>">
                <label for="" class="col-sm-3 control-label"><?php echo lang('delivery_charges')?></label>
                <div class="col-sm-5">
                    <input type="text" class="form-control"  name="delivery_charge" id="delivery_charge" value="<?php echo (validation_errors()) ? set_value('delivery_charge') : $settings['delivery_charge']; ?>">
                    <?php echo form_error('delivery_charge'); ?>
                </div>
            </div>

                <div class="form-group <?php if (form_error('allow_preorder')) echo 'has-error'; ?>">
                    <label for="allow_preorder" class="col-sm-3 control-label">Allow Pre-orders</label>
                    <div class="col-sm-5">
                        <select class="form-control" name="allow_preorder" id="allow_preorder">
                            <option value="1"  <?php echo set_select('allow_preorder', '1', ($settings['allow_preorder'] == 1) ? TRUE : FALSE) ?>>Yes</option>
                            <option value="0" <?php echo set_select('allow_preorder', '0', ($settings['allow_preorder'] == 0) ? TRUE : FALSE) ?>>No</option>
                        </select>
                        <?php echo form_error('allow_preorder'); ?>
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