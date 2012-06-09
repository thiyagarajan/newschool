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

class JINCViewMessage extends JView {

    protected $state;
    protected $item;
    protected $form;
    protected $process;
    protected $newsletter;
    protected $history;

    public function display($tpl = null) {

        $this->state = $this->get('State');
        $this->form = $this->get('Form');
        $this->item = $this->get('Item');
        JRequest::setVar('hidemainmenu', true);
        JHTML::stylesheet('administrator/components/com_jinc/assets/css/jinc_admin.css');

        $layout = $this->getLayout();
        if ($layout == 'send') {
            $this->process = $this->get('Process');
            $this->newsletter = $this->get('Newsletter');
            $this->id = JRequest::getInt('id', 0);
            JToolBarHelper::title(JText::_('COM_JINC_MESSAGE') . ': <small><small>[ ' . JText::_('COM_JINC_JTOOLBAR_SEND') . ' ]</small></small>', 'jinc');
            jincimport('utility.jinchelper');
            JINCHelper::helpOnLine(63);
        } else if ($layout == 'history') {
            $this->history = $this->get('History');

            JToolBarHelper::title(JText::_('COM_JINC_MESSAGE') . ': <small><small>[ ' . JText::_('COM_JINC_HISTORY') . ' ]</small></small>', 'jinc');
            JToolBarHelper::back();
            jincimport('utility.jinchelper');
            JINCHelper::helpOnLine(62);
        } else {
            $this->addToolbar();
        }
        parent::display($tpl);
    }

    protected function addToolbar() {
        $isNew = ($this->item->id == 0);
        $text = $isNew ? JText::_('NEW') : JText::_('EDIT');
        JToolBarHelper::title(JText::_('COM_JINC_MESSAGE') . ': <small><small>[ ' . $text . ' ]</small></small>', 'jinc');

        $bar = JToolBar::getInstance('toolbar');
        $id = JRequest::getInt('id', 0);
        $bar->appendButton('Popup', 'tags', 'COM_JINC_TAGS', 'index.php?option=com_jinc&amp;view=tags&amp;tmpl=component&msg_id=' . $id, 875, 550, 0, 0, '');
        $bar->appendButton('Popup', 'load-template', 'COM_JINC_LOAD_TEMPLATE', 'index.php?option=com_jinc&amp;view=templates&amp;layout=select&amp;tmpl=component', 875, 550, 0, 0, '');
        JToolBarHelper::divider();

        JToolBarHelper::apply('message.apply', 'JTOOLBAR_APPLY');
        JToolBarHelper::save('message.save', 'JTOOLBAR_SAVE');
        JToolBarHelper::addNew('message.save2new', 'JTOOLBAR_SAVE_AND_NEW');
        if (empty($this->item->id)) {
            JToolBarHelper::cancel('message.cancel', 'JTOOLBAR_CANCEL');
        } else {
            JToolBarHelper::cancel('message.cancel', 'JTOOLBAR_CLOSE');
        }
        jincimport('utility.jinchelper');
        JINCHelper::helpOnLine(64);
    }

}