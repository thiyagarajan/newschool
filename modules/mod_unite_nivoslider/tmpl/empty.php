<?php
/**
 * @package   mod_nivo_slider
 * copyright Maxim Vendrov
 * @license GPL3
 */

// no direct access
defined('_JEXEC') or die;
	
/*
	$urlCssFile = $urlModuleTemplate."cp_styles.css";
	$urlJsFile = $urlModuleTemplate."cp_scripts.js";
	$urlImages = $urlModuleTemplate."images/";
*/

	$urlModuleTemplate = $urlBase."modules/{$module->module}/tmpl/";
	
	$document = JFactory::getDocument();

	$theme = $params->get("theme","default");
	
	//add css
	$document->addStyleSheet($urlModuleTemplate."css/nivo-slider.css");
	$document->addStyleSheet($urlModuleTemplate."themes/default/default.css");
	$document->addStyleSheet($urlModuleTemplate."themes/pascal/pascal.css");
	$document->addStyleSheet($urlModuleTemplate."themes/orman/orman.css");

	//add js
	$include_jquery = $params->get("include_jquery","true");
	
	if($include_jquery == "true")	
		$document->addScript("http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js");
		
		$document->addScript($urlModuleTemplate."js/jquery.nivo.slider.pack.js");
		
	$theme = $params->get("theme","light");
	
	$sliderID = "nivo_slider_".$module->id;
	
	$width = $params->get("width","618");

	$height = $params->get("height","246");
	$style = "width:{$width}px;height:{$height}px;";
	
	$strEffects = "random";
	
	$arrEffects = $params->get('effect',"");
	if(is_array($arrEffects) && !empty($arrEffects))		
		$strEffects = implode(",",$arrEffects);
	
	$themeAddStyle = "";
	if($theme == "orman" || $theme == "pascal"){
		$themeAddStyle = "style='text-align:left'";
		$style = "";
	}
	
	
?>
<!--  Begin "Unite Nivo Slider" -->
		
		<div class="slider-wrapper theme-<?echo $theme?>" <?php echo $themeAddStyle?>>
			<div class="ribbon"></div>
			<div id="<?php echo $sliderID ?>" class="nivoSlider" style="<?php echo $style?>">
				<div style="padding-top:25px;">
					<?php if(empty($sliderID)):?>					
						No slider found. Please select a "slider" in the "Unite Nivo Slider" module. 
					<?php else:?>
						No slides found, please add some slides in the "Unite Nivo Slider" component.
					
					<?php endif?>
				</div>
			</div>		
		</div>
	
<!--  End "Unite Nivo Slider" -->
