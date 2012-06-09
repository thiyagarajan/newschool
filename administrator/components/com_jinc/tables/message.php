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
defined('_JEXEC') or die('Restricted access');

class TableMessage extends JTable {

    function TableMessage(& $db) {
        parent::__construct('#__jinc_message', 'id', $db);
    }

    /**
     * Overloaded bind function
     *
     * @param	array		$hash named array
     *
     * @return	null|string	null is operation was satisfactory, otherwise returns an error
     * @see		JTable:bind
     * @since	1.5
     */
    public function bind($array, $ignore = '') {
        if (isset($array['attachment']) && is_array($array['attachment'])) {
            $registry = new JRegistry();
            $registry->loadArray($array['attachment']);
            $array['attachment'] = (string) $registry;
        }

        return parent::bind($array, $ignore);
    }

}

?>
