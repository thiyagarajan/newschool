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

class TableSubscriber extends JTable {

    function TableSubscriber(& $db) {
        parent::__construct('#__jinc_subscriber', 'id', $db);
    }

    /**
     * Method to approve a subscription
     *
     * @param	mixed	An optional primary key value to delete.  If not set the
     * 					instance property value is used.
     * @return	boolean	True on success.
     * @since	0.9
     */
    public function approve($pk = null) {
        // Initialise variables.
        $k = $this->_tbl_key;
        $pk = (is_null($pk)) ? $this->$k : $pk;

        // If no primary key is given, return false.
        if ($pk === null) {
            $e = new JException(JText::_('JLIB_DATABASE_ERROR_NULL_PRIMARY_KEY'));
            $this->setError($e);
            return false;
        }

        // Delete the row by primary key.
        $query = 'UPDATE ' . $this->_tbl . ' SET random = \'\', datasub = now() WHERE id = ' . $this->_db->quote($pk) . ' AND ISNULL(datasub)';
        $this->_db->setQuery($query);

        // Check for a database error.
        if (!$this->_db->query()) {
            $e = new JException(JText::_('COM_JINC_ERROR_APPROVE_FAILED', get_class($this), $this->_db->getErrorMsg()));
            $this->setError($e);
            return false;
        }

        return true;
    }

}

?>