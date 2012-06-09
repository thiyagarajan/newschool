<?php

// no direct access
defined('_JEXEC') or die;

//define dmp function
if(function_exists("dmp") == false){
	function dmp($str){
		echo "<pre>";
		print_r($str);
		echo "</pre>";
	}
}

class mod_NivoSliderHelper{
	
	public static function getFirstSliderID(){
		$sliderID = NivoSliderHelper::getFirstSliderID();
		return($sliderID);
	}
	
	public static function getSlides($sliderID){
		$slides = NivoSliderHelper::getArrSlides($sliderID);
		return($slides);
	}
	
	public static function printErrorMessage($message){
		echo "<div style='color:red;'>";
		echo "Nivo Slider Error: ".$message;
		echo "</div>";
	}
	
	/**
	 * 
	 * tells if the description exists or not
	 */
	public static function isDescExists($desc){
		$descText = strip_tags($desc);
		$descText = trim($descText);
		$descText = iconv("UTF-8","UTF-8//IGNORE",$descText);
		
		if(empty($descText) || strlen($descText)<=2)
			return(false);
			
		return(true);
	}
	
}