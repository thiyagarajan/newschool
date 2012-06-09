<?php
defined('_JEXEC') or die('Restricted access');
if (!defined ('_AT_CSS_MENU_CLASS')) {
	define ('_AT_CSS_MENU_CLASS', 1);
	require_once (dirname(__FILE__).DS."Base.class.php");
	
	class AT_CSSmenu extends AT_Base{
		function beginMenu($startlevel=0, $endlevel = 10){
		}
  
  		function beginMenuItems($pid=0, $level=0){
			if($level==0) echo "<ul id=\"at-cssmenu\" class=\"clearfix\">\n";
			else echo "<ul class=\"at-transbg\">";
		}
      
		function endMenu($startlevel=0, $endlevel = 10){
		}
        
        function hasSubMenu($level) {
            return false;
        }
        
        function beginMenuItem($row=null, $level = 0, $pos = '') {
            $active = in_array($row->id, $this->open);
            $active = ($active) ? " active" : "";
            if ($level == 0 && @$this->children[$row->id]) echo "<li class=\"havechild{$active}\">";
            else if ($level > 0 && @$this->children[$row->id]) echo "<li class=\"havesubchild{$active}\">";
            else echo "<li>";
        }
        function endMenuItem($mitem=null, $level = 0, $pos = ''){
            echo "</li> \n";
        }
		
	}
}
?>