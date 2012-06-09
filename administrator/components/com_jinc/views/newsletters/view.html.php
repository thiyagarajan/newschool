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

class JINCViewNewsletters extends JView {
    protected $items;
    protected $pagination;
    protected $state;
    protected $tmpl;

    function display($tpl = null) {
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');

        $this->addToolbar();
        parent::display($tpl);
    }

    protected function addToolbar() {
        JHTML::stylesheet('administrator/components/com_jinc/assets/css/jinc_admin.css');
        JToolBarHelper::title(JText::_('COM_JINC_MENU_NEWSLETTERS'), 'jinc');

        $bar = JToolBar::getInstance('toolbar');
        $bar->appendButton('Popup', 'attributes', 'COM_JINC_ATTRIBUTES', 'index.php?option=com_jinc&amp;view=attributes&amp;tmpl=component', 875, 550, 0, 0, '');
        JToolBarHelper::divider();
        JToolBarHelper::addNew('newsletter.add', 'JTOOLBAR_NEW');
        JToolBarHelper::editList('newsletter.edit', 'JTOOLBAR_EDIT');
        JToolBarHelper::deleteList(JText::_('COM_JINC_WARNING_DELETE_ITEMS'), 'newsletters.delete');
        JToolBarHelper::divider();
        JToolBarHelper::custom('newsletters.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
        JToolBarHelper::custom('newsletters.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
        jincimport('utility.jinchelper');
        JINCHelper::helpOnLine(59);
    }

}

?>