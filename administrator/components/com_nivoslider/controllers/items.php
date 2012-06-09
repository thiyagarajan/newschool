<?php

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

class NivoSliderControllerItems extends JControllerAdmin
{
	public function getModel($name = 'Item', $prefix = 'NivoSliderModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}
	
	public function add(){
		$sliderID = JRequest::getInt("filter_sliders");
		$view = "item";
		$layout = "edit";
		$option = JRequest::getCmd('option');
		
		$redirectUrl = JRoute::_("index.php?option=$option&view=$view&layout=$layout&sliderid=$sliderID",false);
		
		$this->setRedirect($redirectUrl);
	}
	
}