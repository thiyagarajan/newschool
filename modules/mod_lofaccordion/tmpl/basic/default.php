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
<div  class="lof-accordion-basic" id="lof-accordion<?php echo $module->id;?>">
	<?php foreach( $list as $key => $row ) : //echo '<pre>'.print_r( $row,1 ); die; ?>
    <div class="lof-toggler lof-toggler-<?php echo $module->id;?>"><?php echo $row->subtitle;?></div>
        <div class="lof-element lof-element-<?php echo $module->id;?> lof-header<?php echo $key+1; ?>">
        	<div class="lof-inner">
            <?php require( $itemLayoutPath );?>
             </div>
        </div>
    <?php endforeach; ?> 
</div>
