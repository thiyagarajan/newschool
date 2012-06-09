<?php

defined('_JEXEC') or die;

//define dmp function
if(function_exists("dmp") == false){
	function dmp($str){
		echo "<pre>";
		print_r($str);
		echo "</pre>";
	}
}

abstract class NivoSliderHelper
{	
	
	const TABLE_SLIDERS = "#__nivoslider_sliders";
	const TABLE_SLIDES = "#__nivoslider";
	
	/**
	 * 
	 * get url leading to items	
	 */
	public static function getUrlItems($sliderID=null){
		$url = JURI::base()."index.php?option=com_nivoslider&view=items";
		if(!empty($sliderID))
			$url .= "&sliderid=".$sliderID;
		return($url);
	}
	
	
	/**
	 * 
	 * get sliders array small (id,title,alias)
	 */
	public static function getArrSliders(){	
		$db = &JFactory::getDBO();		
		$query = $db->getQuery(true);
		$query->select('id,title,alias');
		$query->from(self::TABLE_SLIDERS);
		
		$db->setQuery($query);
		$rows = $db->loadAssocList();
		return($rows);
	}
	
	/**
	 * 
	 * get arr sliders by id
	 */
	public static function getArrSlidersAssoc(){
		$arrSliders = self::getArrSliders();
		$arrOutput = array();
		foreach($arrSliders as $slider)
			$arrOutput[$slider["id"]] = $slider;
		
		return($arrOutput);
	}
	
	/**
	 * 
	 * get first slider id
	 */
	public static function getFirstSliderID(){
		
		$arrSliders = self::getArrSliders();
		if(empty($arrSliders))
			return("");
		
		$firstSliderID = $arrSliders[0]["id"];
		
		return($firstSliderID);
	}
	
	/**
	 * 
	 * validate that some slider exists. else throw error
	 */
	private static function validateSliderExists($sliderID){
		$arrSliders = self::getArrSlidersAssoc();
		if(array_key_exists($sliderID, $arrSliders) == false)
			throw new Exception("Slider with id: $sliderID not exists.");
	}
	
	/**
	 * 
	 * get slides array of some slider
	 * @param $sliderID
	 */
	public static function getArrSlides($sliderID){
		self::validateSliderExists($sliderID);
		
		$db = &JFactory::getDBO();		
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from(self::TABLE_SLIDES);
		$query->where("sliderid='$sliderID' and published=1");
		$query->order("ordering asc");
		
		$db->setQuery($query);		
		$rows = $db->loadAssocList();
		$urlRoot = JURI::root();
		
		//process params:
		foreach($rows as $key=>$row){
			$jsonParams = $row["params"];
			$params = new JRegistry();
			$params->loadString($jsonParams, "json");
			
			//add image full path
			$params->set("image",$urlRoot.$params->get("image"));
			$params->set("thumb_url",$urlRoot.$params->get("thumb_url"));
			$params->set("thumb_bw_url",$urlRoot.$params->get("thumb_bw_url"));
			
			$rows[$key]["params"] = $params;
		}
		
		return($rows);
	}
	
	/**
	 * 
	 * add submenu
	 */
	public static function addSubmenu($vName)
	{
		JSubMenuHelper::addEntry(
			JText::_('COM_NIVOSLIDER_SUBMENU_SLIDERS'),
			'index.php?option=com_nivoslider&view=sliders',
			$vName == 'sliders'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('COM_NIVOSLIDER_SUBMENU_SLIDES'),
			'index.php?option=com_nivoslider&view=items',
			$vName == 'items'
		);

		//no need for the categories
	/*
		
		JSubMenuHelper::addEntry(
			JText::_('COM_NIVOSLIDER_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&extension=com_nivoslider',
			$vName == 'categories'
		);
		
		if ($vName=='categories') {
			JToolBarHelper::title(
				JText::sprintf('COM_NIVOSLIDER_CATEGORIES_TITLE',JText::_('com_nivoslider')),
				'slider-categories');
		}
	*/
		
	}
	
}
?>