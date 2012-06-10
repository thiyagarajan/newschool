<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

global $mainframe;

// count instances
if (!isset($GLOBALS['toppanels'])) {
	$GLOBALS['toppanels'] = 1;
} else {
	$GLOBALS['toppanels']++;
}

// include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

// disable edit ability icon
$access = new stdClass();
$access->canEdit	= 0;
$access->canEditOwn = 0;
$access->canPublish = 0;

$list = modtoppanelHelper::getList($params, $access);

// check if any results returned
$items = count($list);
if (!$items) {
	return;
}

// init vars
$style             = $params->get('style', 'default');
$top_position      = $params->get('top_position', '137');
$left_position     = $params->get('left_position', '50');
$module_height     = $params->get('module_height', '250');
$module_width      = $params->get('module_width', '950');
$cpnl_label     = $params->get('cpnl_label', 'Toppanel');
$fx_duration       = $params->get('fx_duration', 500);
$module_base       = JURI::base() . 'modules/mod_toppanel/';

// css parameters
$toppanel_id       = 'toppanel-' . $GLOBALS['toppanels'];
$css_top_position  = 'top: ' . $top_position . 'px;';
$css_left_position = 'left: ' . $left_position . '%;';
$css_module_height = 'height: ' . $module_height . 'px; margin-top: -' . $module_height . 'px;';
$css_module_width  = 'width: ' . $module_width . 'px;';

// js parameters
$javascript_var    = 'panelFx' . $GLOBALS['toppanels'];
$javascript        = "var $javascript_var = new toppanel('$toppanel_id', { offset: $module_height, transition: Fx.Transitions.expoOut, duration: $fx_duration });";
$javascript       .= "\n$javascript_var.addcpnlEvent('#$toppanel_id .cpnl')";
$javascript       .= "\n$javascript_var.addcpnlEvent('#$toppanel_id .close');";

switch ($style) {
	case "transparent":
		require(JModuleHelper::getLayoutPath('mod_toppanel', 'transparent'));
   		break;
	case "white":
		require(JModuleHelper::getLayoutPath('mod_toppanel', 'white'));
   		break;
	default:
    	require(JModuleHelper::getLayoutPath('mod_toppanel', 'default'));
}

$document =& JFactory::getDocument();
$document->addStyleSheet($module_base . 'mod_toppanel.css.php');
$document->addScript($module_base . 'mod_toppanel.js');
echo "<script type=\"text/javascript\">\n// <!--\n$javascript\n// -->\n</script>\n";