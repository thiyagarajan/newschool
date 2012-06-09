<?php
/**
 * $ModDesc
 * 
 * @version		$Id: helper.php $Revision
 * @package		modules
 * @subpackage	$Subpackage.
 * @copyright	Copyright (C) Dec 2009 IceTheme.com.All rights reserved.
 * @license		GNU General Public License version 2
 * -------------------------------------
 */
// no direct access
defined('_JEXEC') or die;
// Include the syndicate functions only once
require_once dirname(__FILE__).DS.'helper.php';
$list = modLofAccordionHelper::getList( $params );

$group 			= $params->get( 'group','content' );
$tmp 		 	= $params->get( 'module_height', 'auto' );
$moduleHeight   =  ( $tmp=='auto' ) ? 'auto' : (int)$tmp.'px';
$tmp 			= $params->get( 'module_width', 'auto' );
$moduleWidth    =  ( $tmp=='auto') ? 'auto': (int)$tmp.'px';
$themeClass 	= $params->get( 'theme' , '');
$openTarget 	= $params->get( 'open_target', 'parent' );
$class 			= !$params->get( 'navigator_pos', 0 ) ? '':'ice-'.$params->get( 'navigator_pos', 0 );
$theme		    =  $params->get( 'theme', '' ); 
$target 		= $params->get('open_target','_parent') != 'modal'
							? 'class="readon" target="'.$params->get('open_target','_parent').'"'
							: 'rel="{handler:\'iframe\',size:{x:840,y:420}}" class="modal"'; 


$displayItem = $params->get('hidden_all','0')? -999:(int)$params->get( 'open_item', 0 );
// load custom theme
if( $theme && $theme != -1 ) {
	$itemLayoutPath=dirname(__FILE__).DS.'tmpl'.DS.trim($theme).DS; 
	$tmpgroup = '';
	if( !file_exists($itemLayoutPath.$group.'_item.php') ){
		$itemLayoutPath=dirname(__FILE__).DS.'tmpl'.DS;
		$tmpgroup='';
	}
	$itemLayoutPath = $itemLayoutPath.$tmpgroup.'_item.php'; 
 	$layout = trim($theme).DS.'default';
 	require( JModuleHelper::getLayoutPath($module->module, $layout ) );
} else {
	$itemLayoutPath = dirname(__FILE__).DS.'tmpl'.DS;
	$tmpgroup = $group;
	if( !file_exists($itemLayoutPath.$group.'_item.php') ){
		$tmpgroup='';
	}
	$itemLayoutPath = $itemLayoutPath.$tmpgroup.'_item.php';
	require( JModuleHelper::getLayoutPath($module->module) );	
}
modLofAccordionHelper::loadMediaFiles( $params, $module, $theme );
?>
<script type="text/javascript">
		var myAccordion = new Accordion($( 'lof-accordion<?php echo $module->id;?>'),
										   '.lof-toggler-<?php echo $module->id;?>',
										   'div.lof-element-<?php echo $module->id;?>', {
			opacity: <?php echo (int)$params->get('use_opacity',0)?>,
			trigger:'<?php echo $params->get('trigger_event','click');?>',
			display:<?php echo $displayItem;?>,
			alwaysHide:<?php echo (int)$params->get('allway_hidden',1);?>,
			transition:<?php echo $params->get('effect','1300');?>,
			duration:<?php echo $params->get( 'duration','Fx.Transitions.Sine.easeInOut' );?>,
			onActive: function(toggler, element){
				toggler.addClass('lof-active');
			},
			onBackground: function(toggler, element){
				toggler.removeClass('lof-active');
			}
		});
</script>
