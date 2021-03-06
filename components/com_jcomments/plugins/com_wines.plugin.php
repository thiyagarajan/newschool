<?php
/**
 * JComments plugin for Wines support
 *
 * @version 2.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2012 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

class jc_com_wines extends JCommentsPlugin
{
	function getObjectTitle($id)
	{
		$db = JCommentsFactory::getDBO();
		$db->setQuery( 'SELECT imgtitle, id FROM #__wines WHERE id = ' . $id );
		return $db->loadResult();
	}

	function getObjectLink($id)
	{
		$_Itemid = self::getItemid( 'com_wines' );
		$link = sefRelToAbs( 'index.php?option=com_wines&amp;task=detail&amp;id=' . $id . '&amp;Itemid=' . $_Itemid );
		return $link;
	}
}
?>