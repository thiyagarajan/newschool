<?php

/**
 * @package Unite Nivo Slider Module for Joomla 1.7-2.5
 * @version 1.0.0
 * @author UniteJoomla.com
 * @copyright (C) 2012- Unite Joomla
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

// no direct access
defined('_JEXEC') or die;

	//set active menu link
	$urlBase = JURI::base();
	
	//include helpers of the component and module
	require_once JPATH_ADMINISTRATOR."/components/com_nivoslider/helpers/nivoslider.php";
	require_once dirname(__FILE__)."/helper.php";
	
	$sliderID = $params->get("sliderid");
	
	try{
		
		$arrSlides = array();
		
	if(!empty($sliderID))	//load demo
		$arrSlides = mod_NivoSliderHelper::getSlides($sliderID);
	
	if(!empty($arrSlides))	//get slider layout
		require JModuleHelper::getLayoutPath($module->module, $params->get('layout', 'default'));
	else	//get empty layout
		require dirname(__FILE__)."/tmpl/empty.php";
		
	}catch(Exception $e){
		mod_ParadigmSliderHelper::printErrorMessage($e->getMessage());
	}
	