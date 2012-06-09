<?php
/**
 * $ModDesc
 * 
 * @version		$Id: helper.php $Revision
 * @package		modules
 * @subpackage	$Subpackage
 * @copyright	Copyright (C) May 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>. All rights reserved.
 * @website 	htt://landofcoder.com
 * @license		GNU General Public License version 2
 */
// no direct access
defined('_JEXEC') or die;
?>
<div  class="lof-accordion-default" id="lof-accordion<?php echo $module->id;?>">
	<?php foreach( $list as $row ) : //echo '<pre>'.print_r( $row,1 ); die; ?>
    <div class="lof-toggler lof-toggler-<?php echo $module->id; ?>"><?php echo $row->subtitle;?></div>
        <div class="lof-element lof-element-<?php echo $module->id;?>">
            <?php require( $itemLayoutPath );?>
              <?php if( $params->get('show_button_link','0') ) : ?>
                  <a <?php echo $target;?>  href="<?php echo $row->link;?>" title="<?php echo $row->title;?>"><?php echo JText::_('Read more...');?></a>
             <?php endif; ?>
        </div>
    <?php endforeach; ?> 
</div>
