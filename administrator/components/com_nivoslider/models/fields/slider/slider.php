<?php

defined('JPATH_BASE') or die;

/**
 * Supports a modal article picker.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_content
 * @since		1.6
 */
class JFormFieldSlider_Slider extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Modal_Article';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
		require_once JPATH_ADMINISTRATOR."/components/com_nivoslider/helpers/nivoslider.php";
		$arrSliders = NivoSliderHelper::getArrSliders();
		
		
		$html = "<select id='{$this->id}_id' name='{$this->name}'>";
		foreach($arrSliders as $slider){
			$title = $slider["title"];
			$id = $slider["id"];
			$selected = "";
			$selectedID = $this->value;
			if(empty($selectedID))
				$selectedID = JRequest::getCmd("sliderid");
				
			if($id == $selectedID)
				$selected = 'selected="selected"';
			
			$html .= "<option value='$id' $selected>$title</option>";
		}		
		$html .= "</select>";
		
		return $html;
	}
	
	
}
