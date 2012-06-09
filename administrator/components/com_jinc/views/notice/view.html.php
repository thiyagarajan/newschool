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

class JINCViewNotice extends JView {

    protected $state;
    protected $item;
    protected $form;

    public function display($tpl = null) {
        $this->state = $this->get('State');
        $this->form = $this->get('Form');
        $this->item = $this->get('Item');

        $this->addToolbar();
        parent::display($tpl);
    }

    protected function addToolbar() {
        JRequest::setVar('hidemainmenu', true);
        JHTML::stylesheet('administrator/components/com_jinc/assets/css/jinc_admin.css');
        $isNew = ($this->item->id == 0);
        $text = $isNew ? JText::_('NEW') : JText::_('EDIT');
        JToolBarHelper::title(JText::_('COM_JINC_NOTICE') . ': <small><small>[ ' . $text . ' ]</small></small>', 'jinc');

        JToolBarHelper::apply('notice.apply', 'JTOOLBAR_APPLY');
        JToolBarHelper::save('notice.save', 'JTOOLBAR_SAVE');
        JToolBarHelper::addNew('notice.save2new', 'JTOOLBAR_SAVE_AND_NEW');
        if (empty($this->item->id)) {
            JToolBarHelper::cancel('notice.cancel', 'JTOOLBAR_CANCEL');
        } else {
            JToolBarHelper::cancel('notice.cancel', 'JTOOLBAR_CLOSE');
        }
        jincimport('utility.jinchelper');
        JINCHelper::helpOnLine(72);
    }

}
