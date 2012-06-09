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

class JINCViewNewsletter extends JView {
    protected $state;
    protected $item;
    protected $form;
    protected $csv_format;
    protected $news_id;
    protected $canAdmin = false;

    public function display($tpl = null) {
        JHTML::stylesheet('administrator/components/com_jinc/assets/css/jinc_admin.css');

        $layout = $this->getLayout();
        if ($layout == 'uploadcsv') {
            $text = JText::_('COM_JINC_ACTION_IMPORT');
            JToolBarHelper::title(JText::_('COM_JINC_NEWSLETTER') . ': <small><small>[ ' . $text . ' ]</small></small>', 'jinc');
            if ($newsletter = $this->get('Newsletter')) {
                $this->csv_format = $newsletter->getSubscriptionInfo();
                $this->news_id = $newsletter->get('id');
                parent::display($tpl);
            } else {
                jincimport('utility.jinchtmlhelper');
                JINCHTMLHelper::showError('COM_JINC_ERR001');
            }
        } elseif ($layout == 'import') {
            $text = JText::_('COM_JINC_ACTION_IMPORT');
            JToolBarHelper::title(JText::_('COM_JINC_NEWSLETTER') . ': <small><small>[ ' . $text . ' ]</small></small>', 'jinc');
            jincimport('utility.jinchelper');
            JINCHelper::helpOnLine(68);
            parent::display($tpl);
        } else {
            $this->state = $this->get('State');
            $this->form = $this->get('Form');
            $this->item = $this->get('Item');
            $user = JFactory::getUser();
            $item = $this->item;
            $this->canAdmin = $user->authorise('core.admin', 'com_jinc.newsletter.' . $item->id);
            $this->addToolbar();
            parent::display($tpl);
        }
    }

    protected function addToolbar() {
        JRequest::setVar('hidemainmenu', true);
        $isNew = ($this->item->id == 0);
        $text = $isNew ? JText::_('NEW') : JText::_('EDIT');
        JToolBarHelper::title(JText::_('COM_JINC_NEWSLETTER') . ': <small><small>[ ' . $text . ' ]</small></small>', 'jinc');

        $bar = JToolBar::getInstance('toolbar');
        $id = JRequest::getInt('id', 0);
        $bar->appendButton('Popup', 'tags', 'COM_JINC_TAGS', 'index.php?option=com_jinc&amp;view=tags&amp;tmpl=component&news_id=' . $id, 875, 550, 0, 0, '');
        JToolBarHelper::divider();

        JToolBarHelper::apply('newsletter.apply', 'JTOOLBAR_APPLY');
        JToolBarHelper::save('newsletter.save', 'JTOOLBAR_SAVE');
        JToolBarHelper::addNew('newsletter.save2new', 'JTOOLBAR_SAVE_AND_NEW');
        if (empty($this->item->id)) {
            JToolBarHelper::cancel('newsletter.cancel', 'JTOOLBAR_CANCEL');
        } else {
            JToolBarHelper::cancel('newsletter.cancel', 'JTOOLBAR_CLOSE');
        }
        jincimport('utility.jinchelper');
        JINCHelper::helpOnLine(70);
    }

}

