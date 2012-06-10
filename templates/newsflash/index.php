
<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

include_once (dirname(__FILE__).DS.'/at_tools.php');
$this->at_color_themes = array('default','color1','color2','color3');

$tempTools = new at_Tools($this);
$ATconfig = $tempTools->getUserSetting();
/////////////////////////////////// Div funtions///////////////////////////////////////////////////
$at_left = $this->countModules('left');
$at_right = $this->countModules('right');

$at_left_main = $this->countModules('left_main');
$at_tabcol = $this->countModules('usertab');
$at_whoisonline = $this->countModules('whoisonline');
$at_login = $this->countModules('login');
$at_dropdown = $this->countModules('dropdown');
$at_l_col = $this->countModules('l_col');

/////////////////////////////////// start left right   ///////////////////////////////////////////////////
if ( $at_left ) 
{
$divid = '-fr';
} 

/////////////////////////////////// start login   ///////////////////////////////////////////////////
elseif ( $at_login) 
{
$divid = '-fr';
}
/////////////////////////////////// start whoisonline ///////////////////////////////////////////////////
elseif ( $at_whoisonline ) 
{
  //1 column on the left
	$divid = '-fr';
}
/////////////////////////////////// start dropdown ///////////////////////////////////////////////////
elseif ( $at_dropdown ) {
  //1 column on the left
	$divid = '-fr';
}
/////////////////////////////////// start l_col ///////////////////////////////////////////////////
elseif ( $at_l_col ) {
  //1 column on the left
	$divid = '-fr';
}
/////////////////////////////////// start leftmain ///////////////////////////////////////////////////
elseif ( $at_left_main ) {
  //1 column on the left
	$divid = '-fr';
}
/////////////////////////////////////////////////////////////////////////////////////////////////
else 
{
$divid = '-f';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />
<?php $tempTools->genMenuHead(); ?>

<link rel="stylesheet" href="templates/system/css/general.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/css/template_css.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/css/colors/<?php echo $ATconfig->at_color; ?>.css" type="text/css" />
<script type="text/javascript" src="<?php echo $this->baseurl; ?>/modules/mod_dinamods/mod_toppanel.js"></script>
<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/modules/mod_dinamods/mod_toppanel.css.php" type="text/css" />
<!--[if lte IE 6]><P>

<style type="text/css">
#logo, h3, #at-wrapfooter, #at-search { behavior: url("<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/scripts/iepngfix.htc"); }
.clearfix {height: 1%;}
div.default div.toppanel div.cpnl-l { behavior: url("<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/scripts/iepngfix.htc"); }
div.default div.toppanel div.cpnl-r { behavior: url("<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/scripts/iepngfix.htc"); }
div.default div.toppanel div.cpnl-m { behavior: url("<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/scripts/iepngfix.htc"); }

div.module h3, div.module_menu h3, div.module-blank h3, div.module_text h3 { behavior: url("<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/scripts/iepngfix.htc"); }
#at-pathway { behavior: url("<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/scripts/iepngfix.htc"); }

</style>

<![endif]-->

<!--[if IE]>

<style type="text/css">

.clearfix {display: inline-block;}
</style>

<![endif]--> 


<!-- ///////////// Start load tabmodule  ////////////////// -->
<script type="text/javascript" charset="utf-8">
/*<![CDATA[*/
document.write ('<style type="text\/css">#at-tabmodulewrap .moduletable {display: none;}<\/style>');
/*]]>*/
</script>
<!-- ///////////// End load tabmodule  ////////////////// -->

<script language="javascript" type="text/javascript" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/scripts/at.script.js"></script>

<!-- START JAVASCRIPT HEADER FILES -->
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/header/scripts/jd.gallery.js" type="text/javascript"></script>
<script src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/header/scripts/jd.gallery.transitions.js" type="text/javascript"></script>
<!-- END JAVASCRIPT HEADER FILES -->

</head>
<body class="<?php echo $ATconfig->at_width." zupa".$ATconfig->at_font_size;?>" id="bd">

<!-- /////////////  Start module toppanel  ////////////////// -->
<div>
<div class="default">
<div id="toppanel-1" class="toppanel">

<div class="panel-container" style="top: 0px;">
<div class="panel-wrapper">
<div class="panel" style="height: 250px; margin-top: -250px;">
<div class="content" style="width: 950px;">
<div class="article">
	<p><span style="font-size: 14pt;"><strong><img width="200" style="float: left; margin: 5px;" alt="Crumbling Infrastructure" src="http://www.newschool.edu/scepa/images/deficit%20picture.jpg" />SCEPA's Deficit Commission Project</strong></span></p>
<p>Dedicated to providing a full debate on the issues of economic  recovery, the deficit, and responsible tax policy, SCEPA has initiated  its <a href="/deficit-commission-project.html">Deficit Commission Project</a> to track  and respond to President Obama's National Commission on Fiscal  Responsibility and Reform, along with the many other expert groups  offering economic and budgetary reform models for the short- and  long-term. &nbsp;As this issue advances, we will post responses and analysis  by SCEPA economists, while building a catalog of mainstream and  non-mainstream comments and proposals.</p>	</div></div>
</div>
</div>

<div class="cpnl" style="left: 50%;">
<div class="cpnl-l" style="templates//images/toppanel_left.png"></div>
<div class="cpnl-m">Updates</div>
<div class="cpnl-r" style="templates//images/toppanel_right.png"></div>
</div>
</div>

</div>
</div><script type="text/javascript">
// <!--
var panelFx1 = new toppanel('toppanel-1', { offset: 250, transition: Fx.Transitions.expoOut, duration: 500 });
panelFx1.addcpnlEvent('#toppanel-1 .cpnl')
panelFx1.addcpnlEvent('#toppanel-1 .close');
// -->
</script>

<jdoc:include type="modules" name="toppanel" />
</div>
<!-- /////////////  End module toppanel ////////////////// -->

<a name="up" id="up"></a>

<!-- START WRAPPER -->
<div id="at-wrapper">

<!-- START HEADER -->
<div id="at-wrapheader" class="clearfix">

<!-- begin logo /////////////////////////////////-->
<div id="logo"></div>
<!-- end logo  ///////////////////////////////////-->

<!-- Start main navigation -->
<div id="at-wrapmainnavigation" class="clearfix">
<div id="at-mainnavigation">
<jdoc:include type="modules" name="position-0" style="none" />
<?php
switch ($ATconfig->at_menutype) {
case 2:
case 4:
include(dirname(__FILE__).DS."/at_menu.php");
$atmenu->genMenu (0);
break;
}
?>
</div>
</div>
<!-- End of main navigation -->

<!-- Start user3 -->
<?php if( $this->countModules('user3') ) {?>
<div id="at-user3">
<jdoc:include type="modules" name="user3" />
</div>
<?php } ?>
<!-- End user3 -->

<!-- Start usertools -->
<div id="at-usertools">
<?php  if($ATconfig->at_tool & 1) $tempTools->genToolMenu(1); ?>
<?php  if($ATconfig->at_tool & 2) $tempTools->genToolMenu(2); ?>
</div>
<!-- End usertools -->

<!-- Start usertoolcolors -->
<div id="at-usercolors" class="clearfix">
<?php if($ATconfig->at_tool & 4) $tempTools->genToolMenu(4); ?>
</div>
<!-- End usertoolcolors -->

<!-- Start search -->
<?php if($this->countModules('user4')) : ?>
<div id="at-search">
<jdoc:include type="modules" name="user4" style="xhtml" />
</div>
<?php endif; ?>
<!-- End search -->

</div>
<!-- END HEADER -->

<div id="at-containerwrap<?php echo $divid; ?>">
<div id="at-container">

<!-- Start column1 -->
<?php if ( $at_left || $at_login || $at_dropdown || $at_whoisonline || $at_l_col || $at_left_main ) { ?>
<div id="at-col1">
<div class="at-innerpad">

<?php if ($this->countModules('left')) { ?>
<jdoc:include type="modules" name="left" style="xhtml" />
<?php } ?>

<?php if ($this->countModules('login')) { ?>
<jdoc:include type="modules" name="login" style="xhtml" />
<?php } ?>

<?php if ($this->countModules('left_main')) { ?>
<jdoc:include type="modules" name="left_main" style="xhtml" />
<?php } ?>

<?php if ($this->countModules('l_col')) { ?>
<jdoc:include type="modules" name="l_col" style="xhtml" />
<?php } ?>

<?php if ($this->countModules('dropdown')) { ?>
<jdoc:include type="modules" name="dropdown" />
<?php } ?>

<?php if ($this->countModules('whoisonline')) { ?>
<jdoc:include type="modules" name="whoisonline" style="xhtml" />
<?php } ?>

</div>
</div>
<?php } ?>
<!-- End column1 -->


<div id="at-mainbody<?php echo $divid; ?>">

<!-- Start content -->
<div id="at-contentwrap">

<!-- START HEADER IMAGES -->
<?php if( $this->countModules('slider') ) {?>
<div id= "javascript-flash-header">
<div class="content">
<div id="myGallery">
<jdoc:include type="modules" name="slider" style="xhtml" />
</div>
</div>
</div>
<?php } ?>
<?php include (dirname(__FILE__).DS.'/header/header.php'); ?>
<!-- END HEADER IMAGES -->

<!-- /////////////  START LOGIN MESSAGE  ////////////////// -->
<jdoc:include type="message" />
<!-- /////////////  END LOGIN MESSAGE  ////////////////// -->

<!-- /////////////  Start Tabcolumn  ////////////////// -->
<?php
$at_tabcol = $this->countModules('usertab');
$at_tabconfig = "width: '655px', height: 'auto', duration: 1000, changeTransition: Fx.Transitions.Expo.easeOut, animType: 'animLesh'";?>

<?php  if ( $at_tabcol) { ?>
<div id="at-tabcol">
<?php if ($this->countModules('usertab')) { ?>
<script language="javascript" type="text/javascript" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/scripts/tabmodule.js"></script>
<script type="text/javascript">
window.addEvent('domready', kokpith);
function kokpith() {
pithpith = new karush('at-tabmodulewrap-bot', {
<?php echo $at_tabconfig; ?>
});
}
</script>
<div id="at-tabmodulewrap">
<div id="at-tabmodulewrap-top">
<div id="at-tabmodulewrap-bot">
<div class="at-tab-cont">
<jdoc:include type="modules" name="usertab" style="xhtml" />
</div>
</div></div></div>
<?php } ?>
</div>
<?php } ?>
<!-- /////////////  End Tabcolumn  ////////////////// -->

<div id="at-content">
<jdoc:include type="component" />
</div>
</div>
<!-- The end of content -->

<!-- 
<?php if ($this->countModules('right')) { ?>
<div id="at-col2">
<div class="at-innerpad">
<jdoc:include type="modules" name="right" style="xhtml" />
</div>
</div><br />
<?php } ?>
-->

</div>


<!-- Start bottom modules -->

<?php
$spotlight = array ('user10','user11');
$bottom = $tempTools->calSpotlight ($spotlight, $this->countModules('user12')?70:100);
if( $bottom ) {
?>

<div id="at-bottomwrap">
<div id="at-bottom">
<?php if( $this->countModules('user10') ) {?>
<div class="at-grusht<?php echo $bottom['modules']['user10']; ?>" style="width: <?php echo $bottom['width']; ?>;">
<jdoc:include type="modules" name="user10" style="xhtml" />
</div>
<?php } ?>
<?php if( $this->countModules('user11') ) {?>
<div class="at-grusht<?php echo $bottom['modules']['user11']; ?>" style="width: <?php echo $bottom['width']; ?>;">
<jdoc:include type="modules" name="user11" style="xhtml" />
</div>
<?php } ?>
<?php if( $this->countModules('user12') ) {?>
<div class="at-grusht-rightcol" style="width: 26.7%;">
<jdoc:include type="modules" name="user12" style="xhtml" />
</div>
<?php } ?>
</div>
</div>
<?php } ?>

<!-- End bottom modules -->



</div>
</div>

<!-- /////////////  Start Footer  ////////////////// -->
<div id="at-footerwrap" class="clearfix">
<div id="at-footer">

<jdoc:include type="module" name="footer" />
<?php include (dirname(__FILE__).DS.'/footer.php');?>

<!-- START GO TOP -->
<div id= "goup-image">
<a href="#up" title="Go up" style="text-decoration: none;"><img src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/images/go-up.gif" title="Go up" alt="Go up" /></a>
</div>
<!-- END GO TOP -->

</div>
</div>
<!-- /////////////  End Footer ////////////////// -->

</div>
<!-- END WRAPPER-->

<!-- Start templatechooser -->
<?php if ($this->countModules('templatechooser')) { ?>
<div>
<jdoc:include type="modules" name="templatechooser" />
</div>
<?php } ?>
<!-- End templatechooser -->

<center><a href="http://www.thiyagarajan.wordpress.com">Designed by Thiyagarajan Veluchamy</a></center>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-17650751-3']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<div style="position: absolute ! important; top: -991px ! important; left: -643px ! important; width: 100px; overflow: hidden;"><h1>custom writing</h1><ul><li>I yield I generally turn uncommon <a href="http://custom-paper-writing.com/" title="custom writing" target="_blank">custom writing</a></strong></em>  accurately and I entirely have tremendous amusement from entertaining work of great experts. My straightaway bought holds are submitted by strong instructions and by distinct outline. To expend my redeem time I refer key assistance. I often fillip to my vernal friends to refer it too. I miss they wholly will be surprisingly glad.</li></ul></div>


</body>
</html>