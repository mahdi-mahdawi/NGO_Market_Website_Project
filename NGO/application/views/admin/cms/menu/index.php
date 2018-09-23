<div class="row">
    <div class="col-md-7">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo lang('menu.header')?></h3>
            </div>
            <div class="panel-body">
                <p class="help-block"><?php echo lang('drag')?></p>
                <?php $menus = fetchAllMenus($mlist, $access_edit, $access_delete); ?>
                <?php if ($menus): ?>
                    <div class="">
                        <div class="dd" id="nestable3">
                            <?php echo $menus; ?>
                        </div>
                    </div>
                    <div>
                        <br/>
                        <button class="btn btn-purple btn-loading" type="submit" id="UpdateMenuOrder" name="UpdateMenuOrder" value="submit" data-loading-text="Updating...">&nbsp;&nbsp;Update&nbsp;&nbsp;</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5" id='menu-add-edit-holder'><?php echo $template['partials']['add_menu_view']; ?></div>
    
</div>