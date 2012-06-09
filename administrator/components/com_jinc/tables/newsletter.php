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

jimport('joomla.database.tableasset');

class TableNewsletter extends JTable {

    function TableNewsletter(& $db) {
        parent::__construct('#__jinc_newsletter', 'id', $db);
    }

    /**
     * Method to compute the default name of the asset.
     * The default name is in the form `table_name.id`
     * where id is the value of the primary key of the table.
     *
     * @return	string
     * @since	1.6
     */
    protected function _getAssetName() {
        return 'com_jinc.newsletter.' . (int) $this->id;
    }

    /**
     * Method to return the title to use for the asset table.
     *
     * @return	string
     * @since	1.6
     */
    protected function _getAssetTitle() {
        return $this->name;
    }

    /**
     * Get the parent asset id for the record
     *
     * @return	int
     */
    protected function _getAssetParentId() {
        // Initialise variables.
        $assetId = null;
        $db = $this->getDbo();

        // Build the query to get the asset id for the parent category.
        $query = $db->getQuery(true);
        $query->select('id');
        $query->from('#__assets');
        $query->where('name = ' . $db->quote('com_jinc'));

        // Get the asset id from the database.
        $db->setQuery($query);
        if ($result = $db->loadResult()) {
            $assetId = (int) $result;
        }

        // Return the asset id.
        if ($assetId) {
            return $assetId;
        } else {
            return parent::_getAssetParentId();
        }
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
        if (isset($array['attribs']) && is_array($array['attribs'])) {
            $attribs = $array['attribs'];
            foreach ($attribs as $key => $value) {
              if (strlen($value) == 0) {
                unset($attribs[$key]);
              }
            }

            $registry = new JRegistry();
            $registry->loadArray($attribs);
            $array['attribs'] = (string) $registry;
        }

        // Bind the rules.
        if (isset($array['rules']) && is_array($array['rules'])) {
            $rules = new JRules($array['rules']);
            $this->setRules($rules);
        }
        return parent::bind($array, $ignore);
    }

}

?>