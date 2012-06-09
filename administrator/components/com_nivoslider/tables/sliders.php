<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

class NivoSliderTableSliders extends JTable
{
	public function __construct(&$db) {
		parent::__construct('#__nivoslider_sliders', 'id', $db);
	}

	function bind($array, $ignore = '')
	{
		
		/*
		dmp($array);
		dmp($_REQUEST);
		exit();
		*/
		
		if (isset($array['params']) && is_array($array['params'])) {
			$registry = new JRegistry();
			$registry->loadArray($array['params']);
			$array['params'] = (string)$registry;
		}
		
		if(empty($array['alias'])) {
			$array['alias'] = $array['title'];
		}
		$array['alias'] = JFilterOutput::stringURLSafe($array['alias']);
		if(trim(str_replace('-','',$array['alias'])) == '') {
			$array['alias'] = JFactory::getDate()->format("Y-m-d-H-i-s");
		}
		
		return parent::bind($array, $ignore);
	}
	
	/*
	public function delete($pk = null){
		
		parent::delete($pk);
	}
	*/
	
}
