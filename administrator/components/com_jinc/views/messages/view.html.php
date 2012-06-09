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
defined('_JEXEC') or die();
jimport('joomla.application.component.view');
require_once JPATH_COMPONENT . '/models/fields/jincnewsletter.php';

class JINCViewMessages extends JView {

    protected $items;
    protected $pagination;
    protected $state;
    protected $tmpl;

    function display($tpl = null) {
        jincimport('core.process');
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');

        $this->addToolbar();
        parent::display($tpl);
    }

    protected function addToolbar() {
        $state = $this->get('State');
        JHTML::stylesheet('administrator/components/com_jinc/assets/css/jinc_admin.css');
        JToolBarHelper::title(JText::_('COM_JINC_MENU_MESSAGES'), 'jinc');
        JToolBarHelper::custom('message.preview', 'jincpreview', 'jincpreview', 'COM_JINC_JTOOLBAR_PREVIEW', false);
        JToolBarHelper::custom('message.sendPage', 'jincsend', 'jincsend', 'COM_JINC_JTOOLBAR_SEND', false);
        JToolBarHelper::custom('message.history', 'jinchistory', 'jinchistory', 'COM_JINC_JTOOLBAR_HISTORY', false);
        JToolBarHelper::divider();
        JToolBarHelper::addNew('message.add', 'JTOOLBAR_NEW');
        JToolBarHelper::editList('message.edit', 'JTOOLBAR_EDIT');
        JToolBarHelper::deleteList(JText::_('COM_JINC_WARNING_DELETE_ITEMS'), 'messages.delete');
        jincimport('utility.jinchelper');
        JINCHelper::helpOnLine(65);

    }

}