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

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class JElementNewsletter extends JElement {

    var	$_name = 'newsletter';

    function fetchElement($name, $value, &$node, $control_name) {
        $db = &JFactory::getDBO();
        $query = 'SELECT news_name AS text, news_id AS value ' .
            'FROM #__jinc_newsletter ' .
            'WHERE published = 1 ' .
            'ORDER BY news_name';
        $db->setQuery( $query );
        $newsletters = $db->loadObjectList();
        return JHTML::_('select.genericlist',  $newsletters, ''.$control_name.'['.$name.']', 'class="inputbox"', 'value', 'text', $value, $control_name.$name );
    }
}
?>