<?php
/**
 * @BuaXua Floating module
 * @package    buaxua.vn
 * @link http://www.buaxua.vn
 * @http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/

// Don't allow direct access to the file
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.module.helper');
  $maincontentw = $params->get( 'maincontentw', 1050 );
  $fspeed = $params->get( 'fspeed', 20 );
  $leftpos = $params->get( 'leftpos', 0 );
  $leftboxw = $params->get( 'leftboxw', 100 );
  $leftboxh = $params->get( 'leftboxh', 100 );
  $rightpos = $params->get( 'rightpos', 0 );
  $rightboxw = $params->get( 'rightboxw', 100 );
  $rightboxh = $params->get( 'rightboxh', 100 );
  $leftadjust = $params->get( 'leftadjust', 5 );
  $rightadjust = $params->get( 'rightadjust', 5 );
  $left_position = $params->get( 'left_position', 'buaxua_leftbox' );
  $right_position = $params->get( 'right_position', 'buaxua_rightbox' );
  $leftboxcss = $params->get( 'leftboxcss', '' );
  $rightboxcss = $params->get( 'rightboxcss', '' );
echo '<!-- Start BuaXua.vn Floating --><div id="divAdLeft" style="width:'.$leftboxw.'px; height:'.$leftboxh.'px; display: none; position: absolute; top: 0px;'.$leftboxcss.'">';
	$modules =& JModuleHelper::getModules($left_position); 
	foreach ($modules as $module) 
	{ 
		echo JModuleHelper::renderModule($module); 		
	} 
echo '</div>';
echo '<div id="divAdRight" style="width:'.$rightboxw.'px; height:'.$rightboxh.'px; display: none; position: absolute; top: 0px;'.$rightboxcss.'">';
	$modules =& JModuleHelper::getModules($right_position); 
	foreach ($modules as $module) 
	{ 
		echo JModuleHelper::renderModule($module); 		
	} 
echo '</div>';
echo "<script type=\"text/javascript\" src=\"modules/mod_buaxua_floating/buaxua_floating.js\"></script>\n";
echo "<script type=\"text/javascript\">\n";
echo "var MainContentW = $maincontentw;\n";
echo "var LeftPos = $leftpos;\n";
echo "var LeftBoxW = $leftboxw;\n";
echo "var LeftBoxH = $leftboxh;\n";
echo "var RightPos = $rightpos;\n";
echo "var RightBoxW = $rightboxw;\n";
echo "var RightBoxH = $rightboxh;\n";
echo "var LeftAdjust = $leftadjust;\n";
echo "var RightAdjust = $rightadjust;\n";
echo "var fSpeed = $fspeed;\n";
echo "ShowAdDiv();\n";
echo "window.onresize=ShowAdDiv;\n";
echo "</script><!-- End BuaXua.vn Floating -->";
?>