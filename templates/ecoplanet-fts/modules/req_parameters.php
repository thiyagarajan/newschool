<?php
defined( '_JEXEC' ) or die( 'Restricted access' ); 
$slogan	= $this->params->get("slogan");
$slogandisable	= $this->params->get("slogandisable");
$addthis	= $this->params->get("addthis");
$footertext	= $this->params->get("footertext");
$footerdisable	= $this->params->get("footerdisable");
$googleanalytics	= $this->params->get("googleanalytics");
$analyticsdisable	= $this->params->get("analyticsdisable");
$socialbuttons	= $this->params->get("socialbuttons");
$googletranslate	= $this->params->get("googletranslate");
$jchecker	= $this->params->get("jchecker");
$jtabs	= $this->params->get("jtabs");
$tab1	= $this->params->get("tab1");
$tab2	= $this->params->get("tab2");
$tab3	= $this->params->get("tab3");
$jscroll	= $this->params->get("jscroll");
$slidedisable	= $this->params->get("slidedisable");
$slidedesc1	= $this->params->get("slidedesc1");
$url1	= $this->params->get("url1");
$slidedesc2	= $this->params->get("slidedesc2");
$url2	= $this->params->get("url2");
$slidedesc3	= $this->params->get("slidedesc3");
$url3	= $this->params->get("url3");
$slidedesc4	= $this->params->get("slidedesc4");
$url4	= $this->params->get("url4");
JHTML::_('behavior.framework', true);  
JHTML::_('behavior.mootools'); // this will make sure mootools loads first
$document = JFactory::getDocument();

?>