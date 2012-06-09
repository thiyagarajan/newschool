<?php
/**
 * @package		JINC
 * @subpackage          Utility
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

/**
 * Requiring PHP libraries and defining constants
 */
jimport('joomla.application.component.controller');
jimport( 'joomla.filesystem.folder' );
jimport( 'joomla.filesystem.file' );

define('HELP_ONLINE_BASE', 'http://lhacky.altervista.org/jextensions/');

/**
 * JINCHelper class, providing common JINC helper functions.
 *
 * @package		JINC
 * @subpackage          Utility
 * @since		0.6
 */
class JINCHelper {
    function _getXMLInfos($info) {
        $folder = JPATH_ADMINISTRATOR .DS. 'components'.DS.'com_jinc';
        if (JFolder::exists($folder)) {
            $xmlFilesInDir = JFolder::files($folder, 'com_jinc.xml');
        } else {
            $folder = JPATH_SITE .DS. 'components'.DS.'com_jinc';
            if (JFolder::exists($folder)) {
                $xmlFilesInDir = JFolder::files($folder, 'com_jinc.xml');
            } else {
                $xmlFilesInDir = null;
            }
        }

        $xml_items = '';
        if (count($xmlFilesInDir)) {
            foreach ($xmlFilesInDir as $xmlfile) {
                if ($data = JApplicationHelper::parseXMLInstallFile($folder.DS.$xmlfile)) {
                    foreach($data as $key => $value) {
                        $xml_items[$key] = $value;
                    }
                }
            }
        }

        if (isset($xml_items[$info]) && $xml_items[$info] != '' ) {
            return $xml_items[$info];
        } else {
            return '';
        }
    }

    function getJINCVersion() {
        return JINCHelper::_getXMLInfos('version');
    }

    function getJINCCopyright() {
        return JINCHelper::_getXMLInfos('copyright');
    }

    function getJINCLicense() {
        return 'GNU/GPL version 2.0';
    }

    function helpOnLine($article_id) {
        $bar = & JToolBar::getInstance( );
        $bar->appendButton( 'Link', 'help', 'help', HELP_ONLINE_BASE .  'index.php?option=com_content&view=article&id=' . $article_id);
    }
}