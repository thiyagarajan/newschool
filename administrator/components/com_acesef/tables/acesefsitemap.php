<?php
/**
* @version		1.5.0
* @package		AceSEF
* @subpackage	AceSEF
* @copyright	2009-2010 JoomAce LLC, www.joomace.net
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

// No Permission
defined('JPATH_BASE') or die('Restricted Access');

class TableAcesefSitemap extends JTable {

	var $id 	 		= null;
	var $url_sef 		= null;
	var $title 			= null;
	var $published		= null;
	var $sdate 			= null;
	var $frequency		= null;
	var $priority		= null;
	var $sparent		= null;
	var $sorder			= null;

	function __construct(&$db) {
		parent::__construct('#__acesef_sitemap', 'id', $db);
	}
}