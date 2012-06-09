<?php
/**
 * JComments Top Posters - Shows list of top posters
 *
 * @version 2.0
 * @package JComments
 * @author smart (smart@joomlatune.ru)
 * @copyright (C) 2006-2012 by smart (http://www.joomlatune.ru)
 * @license GNU General Public License version 2 or later; see license.txt
 *
 **/
 
// no direct access
defined('_JEXEC') or die;

$comments = JPATH_SITE . '/components/com_jcomments/jcomments.php';
if (file_exists($comments)) {
	require_once ($comments);
} else {
	return;
}

require_once (dirname(__FILE__).'/helper.php');

if ($params->get('useCSS') && !defined ('_JCOMMENTS_TOP_POSTERS_CSS')) {
	define ('_JCOMMENTS_TOP_POSTERS_CSS', 1);

	$app = JFactory::getApplication('site');
	$language = JFactory::getLanguage();

	$style = $language->isRTL() ? 'style_rtl.css' : 'style.css';
	
	$css = 'media/' . $module->module . '/css/' . $style;

	if (is_file(JPATH_SITE . DS . 'templates' . DS . $app->getTemplate() . DS . 'html' . DS . $module->module . DS . 'css' . DS . $style)) {
		$css = 'templates/' . $app->getTemplate() . '/html/' . $module->module . '/css/' . $style;
	}

	$document = JFactory::getDocument();
	$document->addStylesheet($css);

}

$list = modJCommentsTopPostersHelper::getList($params);

if (!empty($list)) {
	require (JModuleHelper::getLayoutPath('mod_jcomments_top_posters', $params->get('layout', 'default')));
}