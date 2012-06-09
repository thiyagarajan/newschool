<?php
class at_Tools {
	var $_tpl = null;
	var $at_color = '';
	var $at_width = '';
	var $at_font_size = '';
	var $at_color_themes = null;
	var $at_menutype = 1;
	var $at_tool = 1;
	var $template = '';

	function at_Tools ($template) {
		$this->_tpl = $template;
		$this->template = $template->template;
		$this->at_color = $this->_tpl->params->get('ColorCSS');
		$this->at_width = $this->_tpl->params->get('ScreenType');
		$this->at_font_size = $this->_tpl->params->get('FontSize');
		$this->at_tool = $this->_tpl->params->get('usertool');
		$this->at_menutype = $this->_tpl->params->get('MenuType') ;
		$this->at_color_themes = $this->_tpl->at_color_themes;
	}
	function getUserSetting(){
		
		if (isset($_COOKIE['ATTheme']) && $_COOKIE['ATTheme'] == $this->_tpl->template){
			if (($this->at_tool & 1) && isset($_COOKIE['ScreenType'])){
				$this->at_width = $_COOKIE['ScreenType'];
			}
			if (($this->at_tool & 2) && isset($_COOKIE['FontSize'])){
				$this->at_font_size = $_COOKIE['FontSize'];
			}
			if (($this->at_tool & 4) && isset($_COOKIE['ColorCSS']) && $_COOKIE['ColorCSS']){
				$this->at_color = $_COOKIE['ColorCSS'];
			}
			if (isset($_GET['MenuType'])){
				$this->at_menutype = $_GET['MenuType'];
				setcookie ('MenuType', $this->at_menutype, null, '/');
			}else{
				if (($this->at_tool & 4) && isset($_COOKIE['MenuType']) && $_COOKIE['MenuType']){
					$this->at_menutype = $_COOKIE['MenuType'];
				}
			}
		}else{
			$exp = time() + 60*60*24*355;
			setcookie ('ATTheme', $this->_tpl->template, $exp, '/');
			setcookie ('ColorCSS', $this->at_color, $exp, '/');
			setcookie ('ScreenType', $this->at_width, $exp, '/');
			setcookie ('FontSize', $this->at_font_size, $exp, '/');
		}
		
		return $this;
	}

	function getCurrentURL(){
		$cururl = JRequest::getURI();
		if(($pos = strpos($cururl, "index.php"))!== false){
			$cururl = substr($cururl,$pos);
		}
		$cururl =  JRoute::_($cururl, true, 0);
		return $cururl;
	}

	function genMenuHead(){
		$html = "";
		if ($this->at_menutype== '1') {
				$html = '<link href="templates/'.$this->_tpl->template.'/at_menu/at_splitmenu/at-splitmenu.css" rel="stylesheet" type="text/css" />';
		}else if ($this->at_menutype== '2') {
				$html = '<link href="templates/'.$this->_tpl->template.'/at_menu/at_menu/at-sosdmenu.css" rel="stylesheet" type="text/css" />';
		} else if ($this->at_menutype== '3') {
					$html = '<link href="templates/'.$this->_tpl->template.'/at_menu/at_transmenu/at-transmenuh.css" rel="stylesheet" type="text/css" />
						<script language="javascript" type="text/javascript" src="templates/'.$this->_tpl->template.'/at_menu/at_transmenu/at-transmenu.js"></script>';
		} else if ($this->at_menutype == 4) {
			$html = '<link href="templates/'.$this->_tpl->template.'/at_menu/at_menu/at-sosdmenu.css" rel="stylesheet" type="text/css" />
					<script language="javascript" type="text/javascript" src="templates/'.$this->_tpl->template.'/at_menu/at_menu/mootools.v1.1.js"></script>
						<script language="javascript" type="text/javascript" src="templates/'.$this->_tpl->template.'/at_menu/at_menu/at.menu.js"></script>';
		}

		if ($this->at_tool){
		?>
			<script type="text/javascript">
			var currentFontSize = <?php echo $this->at_font_size; ?>;
			</script>
		<?php
		}
		echo $html;
	}

	function genToolMenu($attool){
		if ($attool & 1){//show screen tools
			?>
			<ul class="at-usertools-res">
		    <li><img style="cursor: pointer;" title="Narrow screen" src="templates/<?php echo $this->_tpl->template;?>/images/gebruiker-screen1<?php echo ( ($this->at_width=="narrow") ? "-hilite" : "" ) ?>.png" alt="Narrow screen resolution" id="at-tool-narrow" onclick="changeToolHilite(curtool, this);curtool=this;setScreenType('narrow');" /></li>
		    <li><img style="cursor: pointer;" title="Wide screen" src="templates/<?php echo $this->_tpl->template;?>/images/gebruiker-screen2<?php echo ( ($this->at_width=="wide") ? "-hilite" : "" ) ?>.png" alt="Wide screen resolution" id="at-tool-wide" onclick="changeToolHilite(curtool, this);curtool=this;setScreenType('wide');" /></li>
			</ul>
	<?php }
		if ($attool & 2){//show font tools
	?>
			<ul class="at-usertools-font">
            <li><img style="cursor: pointer;" title="Decrease font size" src="templates/<?php echo $this->_tpl->template;?>/images/gebruiker-decrease.png" alt="Decrease font size" id="at-tool-decrease" onclick="changeFontSize(-1); return false;" /></li>
		    <li><img style="cursor: pointer;" title="Default size" src="templates/<?php echo $this->_tpl->template;?>/images/gebruiker-reset.png" alt="Default font size" id="at-tool-reset" onclick="revertStyles(<?php echo $this->_tpl->params->get('FontSize');?>); return false;" /></li>          
	      <li><img style="cursor: pointer;" title="Increase font size" src="templates/<?php echo $this->_tpl->template;?>/images/gebruiker-increase.png" alt="Increase font size" id="at-tool-increase" onclick="changeFontSize(1); return false;" /></li>
			</ul>
			<?php
		}
		if ($attool & 4){//show color tools
			?>
			<ul class="at-usertools-color">
		<?php
	 	foreach ($this->at_color_themes as $this->at_color_theme) {
		?>
	     	<li><img style="cursor: pointer;" src="templates/<?php echo $this->_tpl->template;?>/images/<?php echo $this->at_color_theme;?><?php echo ( ($this->at_color==$this->at_color_theme) ? "-hilite" : "" ) ?>.gif" title="<?php echo $this->at_color_theme;?> color" alt="<?php echo $this->at_color_theme;?> color" id="at-tool-<?php echo $this->at_color_theme;?>color" onclick="setActiveStyleSheet('<?php echo $this->at_color_theme;?>');return false;" /></li>
		<?php
		}
		?>
		</ul>
		<?php
		}
		?>
		<script type="text/javascript">
		var curtool = document.getElementById('<?php echo "at-tool-$this->at_width"; ?>');
		var curcolor = document.getElementById('<?php echo ( ($this->at_color=="") ? "at-tool-defaultcolor" : "at-tool-{$this->at_color}color" ) ?>');
		</script>
		<?php
	}

	function getCurrentMenuIndex(){
		//Get top menu id;
		global $Itemid;
		$database		=& JFactory::getDBO();

		$id = $Itemid;
		$menutype = 'mainmenu';
		$ordering = '0';
		while (1){
			$sql = "select parent, menutype, ordering from #__menu where id = $id limit 1";
			$database->setQuery($sql);
			//echo $database->getQuery($sql);
			$row = null;
			$row = $database->loadObject();			
			if ($row) {
				$menutype = $row->menutype;
				$ordering = $row->ordering;
				if ($row->parent > 0)
				{
					$id = $row->parent;
				}else break;
			}else break;
		}

		$user	=& JFactory::getUser();
		if (isset($user))
		{
			$aid = $user->get('aid', 0);
			$sql = "SELECT count(*) FROM #__menu AS m"
			. "\nWHERE menutype='". $menutype ."' AND published='1' AND access <= '$aid' AND parent=0 and ordering < $ordering";
		} else {
			$sql = "SELECT count(*) FROM #__menu AS m"
			. "\nWHERE menutype='". $menutype ."' AND published='1' AND parent=0 and ordering < $ordering";
		}
		$database->setQuery($sql);

		return $database->loadResult();
	}


	function calSpotlight ($spotlight,$widthSL = 99.6) {

		/********************************************
		$spotlight = array ('position1', 'position2',...)
		*********************************************/
		$modules = array();
		$modules_s = array();
		foreach ($spotlight as $position) {
			if( $this->_tpl->countModules($position) ){
				$modules_s[] = $position;
			}
			$modules[$position] = '-full';
		}

		if (!count($modules_s)) return null;

		$width = round($widthSL/count($modules_s),1) . "%";

		if (count ($modules_s) > 1){
			$modules[$modules_s[0]] = "-left";
			$modules[$modules_s[count ($modules_s) - 1]] = "-right";
			for ($i=1; $i<count ($modules_s) - 1; $i++){
				$modules[$modules_s[$i]] = "-center";
			}
		}
		return array ('modules'=>$modules, 'width'=>$width);
	}

	function getOpenMenuItems($menutype = 'mainmenu'){
		global $itemid;

		$user	=& JFactory::getUser();
		if (isset($user))
		{
			$aid = $user->get('aid', 0);
			$sql = "SELECT m.* FROM #__menu AS m"
			. "\nWHERE menutype='". $menutype ."' AND published='1' AND access <= '$aid'"
			. "\nORDER BY parent,ordering";
		} else {
			$sql = "SELECT m.* FROM #__menu AS m"
			. "\nWHERE menutype='". $menutype ."' AND published='1'"
			. "\nORDER BY parent,ordering";
		}
		$database->setQuery( $sql );
		$rows = $database->loadObjectList( 'id' );

		// establish the hierarchy of the menu
		$children = array();
		// first pass - collect children
		foreach ($rows as $v ) {
			$pt = $v->parent;
			$list = $children[$pt] ? $children[$pt] : array();
			array_push( $list, $v );
			$children[$pt] = $list;
		}

		// second pass - collect 'open' menus
		$open = array( $Itemid );
		$count = 20; // maximum levels - to prevent runaway loop
		$id = $Itemid;
		while (--$count) {
			if (isset($rows[$id]) && $rows[$id]->parent > 0) {
				$id = $rows[$id]->parent;
				$open[] = $id;
			} else {
				break;
			}
		}
	  return $open;
	}

	function setColorThemes ($colorthemes) {
		$this->at_color_themes = $colorthemes;
	}
	
	function updateParams($params) {

		$file = dirname(__FILE__).DS.'params.ini';
		$txt = $params->toString();
		jimport('joomla.filesystem.file');
		if (JFile::exists($file) && $txt)
		{
			// Try to make the params file writeable
			if (!JPath::setPermissions($file, '0755')) {
				JError::raiseNotice('SOME_ERROR_CODE', 'Could not make the template parameter file writeable');
			}

			$return = JFile::write($file, $txt);
			// Try to make the params file unwriteable
			if (!JPath::setPermissions($file, '0555')) {
				JError::raiseNotice('SOME_ERROR_CODE', 'Could not make the template parameter file unwriteable');
			}
			
			return $return;
		}
	}

}
?>