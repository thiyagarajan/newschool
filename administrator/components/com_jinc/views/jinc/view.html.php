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
jimport( 'joomla.application.component.view' );
jincimport( 'utility.jinchelper' );

class JINCViewJINC extends JView {
    function display($tpl = null) {
        JHTML::stylesheet('administrator/components/com_jinc/assets/css/jinc_admin.css');
        JToolBarHelper::title( JText::_('COM_JINC_CPANEL_JINC'), 'jinc' );
        JToolBarHelper::preferences('com_jinc', '350');
        jincimport('utility.jinchelper');
        JINCHelper::helpOnLine(58);

        $version = JINCHelper::getJINCVersion();
        $copyright = JINCHelper::getJINCCopyright();
        $license = JINCHelper::getJINCLicense();

        $this->assignRef('version', $version);
        $this->assignRef('copyright', $copyright);
        $this->assignRef('license', $license);

        parent::display($tpl);
    }
}