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
	
	//load theme css
	$document->addStyleSheet($urlModuleTemplate."themes/$theme/$theme.css");
	
	
?>
<!--  Begin "Unite Nivo Slider" -->
		
		<div class="slider-wrapper theme-<?php echo $theme?>" <?php echo $themeAddStyle?>>
			<div class="ribbon"></div>
			<div id="<?php echo $sliderID ?>" class="nivoSlider" style="<?php echo $style?>">
					<?php 
						//put slides
						foreach($arrSlides as $slide):
							$slideParams = $slide["params"];
							$slideImage = $slideParams->get("image");
							//$slideThumb = $slideParams->get("thumb_url");
							$link = $slideParams->get("link");
							
							//get boolean activate link
							$activateLink = $slideParams->get("activate_link");
							$activateLink = ($activateLink == "yes")?true:false;
							
							$linkOpenIn = $slideParams->get("link_open_in","new");
							
							$linkTarget = "";
							if($linkOpenIn == "new")
								$linkTarget = " target='_blank'";
							
							$desc = $slideParams->get("description");
							
							//set title (reference to desc)
							$title = "";
							
							if(mod_NivoSliderHelper::isDescExists($desc)){							
								$descID = "nivo_desc_".$slide["id"];
								$title = "title=\"#$descID\"";
							}
								
							?>
							
							<?php if($activateLink == true):?>
								<a href="<?php echo $link?>"<?php echo $linkTarget?>><img src="<?php echo $slideImage?>" alt="" <?php echo $title?> /></a>
							<?php else:?>
								<img src="<?php echo $slideImage?>" alt="" <?php echo $title?>/>
							<?php endif;?>
							
							<?php 
						endforeach;
						
						//put descriptions
					?>
			</div>		
					<?php

						foreach($arrSlides as $slide){
							$slideParams = $slide["params"];
							$desc = $slideParams->get("description");
							$desc = trim($desc);
							
							if(mod_NivoSliderHelper::isDescExists($desc) == false)
								continue;
							
							$descID = "nivo_desc_".$slide["id"];
							?>
				            <div id="<?php echo $descID?>" class="nivo-html-caption"><span style='text-align:left;'><?php echo $desc?></span></div>
							<?php 
						}

					?>			
		</div>
	
<script type="text/javascript">

jQuery(document).ready(function() {
	
	jQuery('#<?php echo $sliderID?>').show().nivoSlider({
			effect: '<?php echo $strEffects?>',
			slices: <?php echo $params->get("slices","15")?>,
			boxCols: <?php echo $params->get("boxCols","8")?>,
			boxRows: <?php echo $params->get("boxRows","4")?>,
			animSpeed: <?php echo $params->get("animSpeed","500")?>,
			pauseTime: <?php echo $params->get("pauseTime","3000")?>,
			startSlide: <?php echo $params->get("startSlide","0")?>,
			directionNav: <?php echo $params->get("directionNav","true")?>,
			directionNavHide: <?php echo $params->get("directionNavHide","true")?>,
			controlNav: <?php echo $params->get("controlNav","true")?>,
			controlNavThumbs: <?php echo $params->get("controlNavThumbs","false")?>,
		    controlNavThumbsFromRel: false,
			controlNavThumbsSearch: '.jpg',
			controlNavThumbsReplace: '_thumb.jpg',
			keyboardNav: <?php echo $params->get("keyboardNav","true")?>,
			pauseOnHover: <?php echo $params->get("pauseOnHover","true")?>,
			manualAdvance: <?php echo $params->get("manualAdvance","false")?>,
			captionOpacity: <?php echo $params->get("captionOpacity","0.8")?>,
			prevText: '<?php echo $params->get("prevText","Prev")?>',
			nextText: '<?php echo $params->get("nextText","Next")?>',
			randomStart: <?php echo $params->get("randomStart","false")?>,
			beforeChange: <?php echo $params->get("beforeChange","function(){}")?>,
			afterChange: <?php echo $params->get("afterChange","function(){}")?>,
			slideshowEnd: <?php echo $params->get("slideshowEnd","function(){}")?>,
		    lastSlide: <?php echo $params->get("lastSlide","function(){}")?>,
		    afterLoad: <?php echo $params->get("afterLoad","function(){}")?>
		});
	});	//ready

</script>

<!--  End "Unite Nivo Slider" -->
