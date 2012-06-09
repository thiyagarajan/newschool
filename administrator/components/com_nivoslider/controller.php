<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;

class NivoSliderController extends JController
{
	protected $default_view = 'sliders';
	
	public function display($cachable = false, $urlparams = false)
	{
		require_once JPATH_COMPONENT.'/helpers/nivoslider.php';
		
		$urlAssets = "components/com_nivoslider/assets/";
		
		//add style
		$document = JFactory::getDocument();
		$document->addStyleSheet($urlAssets."style.css");
		$document->addScript("http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js");
		
		//TODO: remove the js func
		//$document->addScript($urlAssets."jsfunc.js");
		
		$currentView = JRequest::getCmd('view', $this->default_view);
		
		NivoSliderHelper::addSubmenu($currentView);		
		parent::display();

		return $this;
	}
	
}