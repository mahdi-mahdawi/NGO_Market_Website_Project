<div class="col-sm-3 col-md-2">
    <div class="sidebar">
        <div class="panel-group side-menu" id="accordion">
            <?php $i = 1; ?>
            <?php foreach ($menuList as $key => $menu): ?>
                <div class="panel panel-sidebar">
                    <div class="panel-heading <?php if ($parent == $key) echo ' active'; ?>">
                        <h4 class="panel-title"><a <?php echo!isset($menu['sub_menu']) ? "" : "data-parent='#accordion' data-toggle='collapse'"; ?> href="<?php echo!isset($menu['sub_menu']) ? base_url($menu['url']) : "#collapse" . $i; ?>"><span class="<?php echo "glyphicon " . $menu['css']; ?>"></span> <?php echo $menu['name']; ?></a></h4>
                    </div>               
                    <?php if (isset($menu['sub_menu'])): ?>
                        <div class="panel-collapse collapse <?php if ($parent == $key) echo 'in'; ?>" id="collapse<?php echo $i; ?>">
                            <div class="panel-body">
                                <ul class="nav nav-pills nav-stacked">
                                    <?php foreach ($menu['sub_menu'] as $key2 => $sub_menu): ?>
                                        <li class="<?php if ($child == $key2) echo 'active'; ?>"><a href="<?php echo base_url($sub_menu['url']); ?>"><?php echo $sub_menu['name']; ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <?php $i++;
            endforeach;
            ?>
        </div>
    </div>
</div>