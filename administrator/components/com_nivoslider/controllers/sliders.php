<?php

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

class NivoSliderControllerSliders extends JControllerAdmin
{
	public function getModel($name = 'Slider', $prefix = 'NivoSliderModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}
}