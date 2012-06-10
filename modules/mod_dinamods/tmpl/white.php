<?php

// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<div class="<?php echo $style ?>">
<div id="<?php echo $toppanel_id ?>" class="toppanel">

<div class="panel-container" style="<?php echo $css_top_position ?>">
<div class="panel-wrapper">
<div class="panel" style="<?php echo $css_module_height ?>">
<div class="content" style="<?php echo $css_module_width ?>">
<?php for ($i=0; $i < $items; $i++) : ?>
<?php modtoppanelHelper::renderItem($list[$i], $params, $access); ?>
<?php endfor; ?>
</div>
</div>
</div>

<div class="cpnl" style="<?php echo $css_left_position ?>">
<div class="cpnl-l" style="<?php echo modtoppanelHelper::correctPng($module_base."styles/".$style."/images/tpnl_l.png") ?>"></div>
<div class="cpnl-m"><?php echo $cpnl_label ?></div>
<div class="cpnl-r" style="<?php echo modtoppanelHelper::correctPng($module_base."styles/".$style."/images/tpnl_r.png") ?>"></div>
</div>
</div>

</div>
</div>