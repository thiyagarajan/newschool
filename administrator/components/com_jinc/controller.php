<?php
/**
 * @copyright           Copyright (C) 2010 - Lhacky
 * @license		GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
 *   This file is part of JINC.
 *
 *   JINC is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   JINC is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with JINC.  If not, see <http://www.gnu.org/licenses/>.
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');

// Submenu view
$view	= JRequest::getVar( 'view', '', '', 'string', JREQUEST_ALLOWRAW );

if (($view == 'newsletters') || ($view == 'messages') || ($view == 'subscribers')
        || ($view == 'tools') || ($view == 'templates') || ($view == 'notices') )  {
	JSubMenuHelper::addEntry(JText::_('COM_JINC_MENU_CP'), 'index.php?option=com_jinc', true );
	JSubMenuHelper::addEntry(JText::_('COM_JINC_MENU_NEWSLETTERS'), 'index.php?option=com_jinc&view=newsletters', $view == 'newsletters');
        JSubMenuHelper::addEntry(JText::_('COM_JINC_MENU_NOTICES'), 'index.php?option=com_jinc&view=notices', $view == 'notices');
	JSubMenuHelper::addEntry(JText::_('COM_JINC_MENU_MESSAGES'), 'index.php?option=com_jinc&view=messages', $view == 'messages');
	JSubMenuHelper::addEntry(JText::_('COM_JINC_MENU_TEMPLATES'), 'index.php?option=com_jinc&view=templates', $view == 'templates' );
	JSubMenuHelper::addEntry(JText::_('COM_JINC_MENU_SUBSCRIBERS'), 'index.php?option=com_jinc&view=subscribers', $view == 'subscribers' );
	JSubMenuHelper::addEntry(JText::_('COM_JINC_MENU_TOOLS'), 'index.php?option=com_jinc&view=tools', $view == 'tools' );
}

class JINCController extends JController {
    function display() {
        parent::display();
    }
}
?>
