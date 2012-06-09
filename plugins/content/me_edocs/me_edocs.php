<?php
######################################################################
# Edocs! - Embed Documents         	          	          	         #
# Copyright (C) 2012 by MediaEventi  	   	   	   	   	   	   	   	 #
# Homepage   : http://mediaeventi.it/en/projects/joomla/edocs		 #
# Author     : Giuseppe Gallo	    	   	   	   	   	   	   	   	 #
# Email      : webmaster@mediaeventi.it	   	   	   	   	   	   	     #
# Version    : 1.2                       	   	    	   	   		 #
# License    : http://www.gnu.org/copyleft/gpl.html GNU/GPL          #
######################################################################

// no direct access
defined('_JEXEC') or die();
 
jimport('joomla.plugin.plugin');
 
class plgContentMe_Edocs extends JPlugin {

	// MediaEventi reference parameters
	var $plugin_name				= "me_edocs";
	var $plugin_short_name			= "edocs";
	var $plugin_copyrights_start		= "\n\n<!-- MediaEventi \"Edocs!\" Plugin (v1.2) starts here -->\n";
	var $plugin_copyrights_end			= "\n<!-- MediaEventi \"Edocs\" Plugin (v1.2) ends here -->\n\n";
	
	function plgContentMe_Edocs( &$subject, $params ) {
		parent::__construct( $subject, $params );
	}
	
	// Joomla! 1.5
	public function onPrepareContent(&$row, &$params, $page = 0) {
		$this->renderMe_Edocs($row, $params, $page = 0);
	}
 
	// Joomla! 1.6/1.7/2.5
	public function onContentPrepare($context, &$row, &$params, $page = 0) {
		jimport( 'joomla.html.parameter' );
		$this->renderMe_Edocs($row, $params, $page);
	}
 

	
	function renderMe_Edocs(&$row, &$params, $page = 0) {
		/* 
		if(version_compare(JVERSION,'1.6.0','ge')) {
			$pluginLivePath = JURI::root(true).'/plugins/content/'.$this->plugin_name.'/'.$this->plugin_name;
		} else {
			$pluginLivePath = JURI::root(true).'/plugins/content/'.$this->plugin_name;
		}
		 */ 
		
		// Check if plugin is enabled
		if(JPluginHelper::isEnabled('content', $this->plugin_name) == false) 
			return;

		// Check if plugin is required into article text
		if(preg_match("#{(" . $this->plugin_short_name . ")}#s", $row->text) == false) 
			return;
		
		// Outside Parameters
		if(!$params) $params = new JParameter(null);
		$plugin = JPluginHelper::getPlugin('content',$this->plugin_name);
		$pluginParams = new JParameter( $plugin->params );
		// var_dump($pluginParams);
				
		// Plugin parameters
		$ie_compatibility = $pluginParams->get( 'ie_compatibility', '' );
		$ie_text = $pluginParams->get( 'ie_text', '' );
		$download_text = $pluginParams->get( 'download_text', 'Download' );
		$debug = $pluginParams->get( 'debug', 0 );
		$root = $pluginParams->get( 'root', '' );
		$predefined_width = $pluginParams->get( 'width', '500' );
		$predefined_height = $pluginParams->get( 'height', '400' );
		
		if ($root[0] == '/')
			$root = substr($root, 1);
		if (substr($root, -1) == '/')
			$root = substr($root, 0, -1);
			
		// Initiating some useful variables
		$isOutside = true;
		$isLocalhost = false;
		$notAvailable = false;
		$docpath = "";
		
		$LiveSite = JURI::base();
		
		
		// expression to search for
		$regex = "#{" . $this->plugin_short_name . "}(.*?){/" . $this->plugin_short_name . "}#s";
		preg_match_all($regex, $row->text, $istances, PREG_SET_ORDER);
		// var_dump($istances);
		
		foreach($istances AS $eDocument) {
			
			$matches[0] = $eDocument[0];
			$matches[1] = $eDocument[1];
			
			// Separating arguments and preparing various parameters
			if(strpos($matches[1], "=")) {
				$values = str_replace(",", "&", str_replace(array('nbsp;', ' ', '&amp;'), '', htmlspecialchars($matches[1])));
				parse_str($values);
				$version = 1;
			}
			
			// Support old version
			else {
				$arguments = explode(',',$matches[1]);
				$path = $arguments[0];
				$width = @$arguments[1];
				$height = @$arguments[2];
				$download = @$arguments[3];
				$div_id = @$arguments[4];
				$version = 0;
			}
			
			if($version == 1 && !isset($path)) {
				print '<div style="width: 100%; padding: 10px; color: red; border: solid 1px red;">Edocs warning: syntax is wrong. - You missed the "path" parameter<br />Please read the documentation. </div>';
			}
			
			
			/** PREPARING VARIABLES **/
			
			// Path
			if(!stristr($path,"http")) {
				if(!($path[0] == '/')) {
					$docpath = $root . "/" . $path;
					$path = $LiveSite . $root . '/' . $path;
				}
				else {
					$path = substr($path, 1);  
					$docpath = $path;
					$path = $LiveSite. $path;
				}
				
				$isOutside = false;
			}

			// Width
			if(!$width)
				$width = $predefined_width;	
			if(!strpos($width, "px")) {
				if(!strpos($width, "%"))
					$width = $width . "px";
			}

			// Height
			if(!$height)
				$height = $predefined_height;
			if(!strpos($height, "px")) {
				if(!strpos($height, "%"))
					$height = $height . "px";
			}
			
			// Id
			if(@$div_id)
				@$div_id = 'id="' . @$div_id . '"';
			
			// Class
			if(!@$div_class)
				@$div_class = "";
			
			// Download link
			if(@$download) {
				if(@$download != "link") {
					$pattern = "/download\s*=\s*(.*)\s*(,|{)/iU";
					preg_match($pattern, $matches[0], $risultati);
					@$download_link = '<a href="' . $path . '" target="_blank" class="edocs_link"><span class="edocs_link_text">' . $risultati[1] . '</span></a>';
				}
				else {
					if(@$download_text == "")
						@$download_text = "Download";
					@$download_link = '<a href="' . $path . '" target="_blank" class="edocs_link"><span class="edocs_link_text">' . $download_text . '</span></a>';
				}
			}
			else $download_link = "";
			
			// Code to display the embedded document
			if($ie_compatibility && ($this->ae_detect_ie())) {
				// $linkname = ucfirst(str_replace("_", " ", ShowFileExtension($path)));
				$info = pathinfo($path);
				$linkname =  ucfirst(str_replace("_", " ", basename($path,'.'.$info['extension']))) ;

				$code = '<div class="edocs_viewer ' . $div_class . '"><a href="http://docs.google.com/viewer?url=' . $path . '" target="_blank" onclick="NewWindow(this.href,\'mywin\',\''. $width . '\',\'' 
							. $height . '\',\'no\',\'center\');return false" onfocus="this.blur()">' . $linkname . ' (' . $info['extension'] . 
							') <br /><span style="font-size: 90%">' . $ie_text .'</span></a></div>';
			
			}
			else 		
				$code = '	<div class="edocs_viewer ' . @$div_class . '" '. @$div_id .'>
								<iframe 
									src="http://docs.google.com/gview?url=' . $path . '&embedded=true" 
									style="width:' . $width . '; height:' . $height . ';" frameborder="0" class="edocs_iframe">
								</iframe>
								<br /><br />
								' . $download_link . '
							</div>';


			
			//Debug mode on: print on screen the url of the document
			if($debug) {
			
				$debug_code =  '<br /><br />
							<div style="background-color:#666666; border:1px solid black; color:white; padding:10px;">
							<span style="font-size: 16px; font-weight: bold;">Debug box - Plugin Edocs</span><br /><br />';

				if($isLocalhost)
					$debug_code .=  '<span style="font-size: 12px; color: #cccccc; font-weight: bold;">WARNING!</span><br />
									<div style="font-size: 14px; font-weight: bold; color: red; background-color: orange; padding: 5px;">Please pay attention: you are working on your local computer. Google documents viewer is not able to read your local documents, so if the document you embedded resides on your local computer,
									you may expect to view an empty image instead of your document while working on your computer. <br />To test if the plugin is working for you, try to upload your document online and write the path to your online document. If it works, 
									then the plugin is working fine and you just need to check your path or other parameters</div><br />';					
							
				$debug_code .=  '<span style="font-size: 12px; color: #cccccc; font-weight: bold;">Code that you wrote to call the plugin</span><br />
							<div style="font-size: 14px; font-weight: bold; color: black; background-color: orange; padding: 5px;">{edocs}' . $matches[1] . '{/edocs}</div><br />';
				
				$debug_code .=  '<span style="font-size: 12px; color: #cccccc; font-weight: bold;">Document path you entered</span><br />
							<div style="font-size: 14px; font-weight: bold; color: black; background-color: orange; padding: 5px;"><a href="' . $path . '" target="_blank">' . $path . '</a></div><br />';
					
				$debug_code .=  '<span style="font-size: 12px; color: #cccccc; font-weight: bold;">Width</span><br />
							<div style="font-size: 14px; font-weight: bold; color: black; background-color: orange; padding: 5px;">' . $width . '</div><br />';
				
				$debug_code .=  '<span style="font-size: 12px; color: #cccccc; font-weight: bold;">Height</span><br />
							<div style="font-size: 14px; font-weight: bold; color: black; background-color: orange; padding: 5px;">' . $height . '</div><br />';
							
				$debug_code .=  '<span style="font-size: 12px; color: #cccccc; font-weight: bold;">Download link</span><br />
							<div style="font-size: 14px; font-weight: bold; color: black; background-color: orange; padding: 5px;">' . (@$download != "" ? @$download : '<span style="color: red;">download link not inserted</span>'). '</div><br />';
				
				$debug_code .=  '<span style="font-size: 12px; color: #cccccc; font-weight: bold;">Id</span><br />
							<div style="font-size: 14px; font-weight: bold; color: black; background-color: orange; padding: 5px;">' . (@$div_id != "" ? @$div_id : '<span style="color: red;">div id not inserted</span>') . '</div><br />';
							
				$debug_code .=  '<span style="font-size: 12px; color: #cccccc; font-weight: bold;">Class</span><br />
							<div style="font-size: 14px; font-weight: bold; color: black; background-color: orange; padding: 5px;">' . (@$div_class != "" ? @$div_class : '<span style="color: red;">div class not inserted</span>') . '</div><br />';
				
				$debug_code .=  '</div>';		
				
				$code .= $debug_code;
			}

			$result = $this->plugin_copyrights_start . $code . $this->plugin_copyrights_end;
		
			// Perform the replacement
			$row->text = preg_replace("#" . $matches[0] . "#s", $result , $row->text);
			
		} // End foreach
	} // End function renderMe_Edocs
	
	private function ae_detect_ie() {
		if (isset($_SERVER['HTTP_USER_AGENT']) && 
		(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
			return true;
		else
			return false;
	}
}



