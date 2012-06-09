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
jimport('joomla.application.component.modeladmin');

class JINCModelAttributes extends JModelAdmin {

    function __construct() {
        parent::__construct();
    }

    /**
     * Method to get an array of data items.
     *
     * @return	mixed	An array of data items on success, false on failure.
     * @since	1.6
     */
    public function getItems() {
        // Load the list items.
        $query = $this->getListQuery();
        $items = $this->_getList($query, 0, $this->getState('list.limit'));

        // Check for a database error.
        if ($this->_db->getErrorNum()) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        return $items;
    }

    protected function getListQuery() {
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select',
                        'id, name, description, type, name_i18n'
                )
        );
        $query->from('`#__jinc_attribute`');
        $query->group('id');

        return $query;
    }

    /**
     * Method to get the record form.
     *
     * @param	array	$data		Data for the form.
     * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
     *
     * @return	mixed	A JForm object on success, false on failure
     * @since	1.6
     */
    public function getForm($data = array(), $loadData = false) {
        $form = $this->loadForm('com_jinc.attribute', 'attribute', array('control' => 'jform', 'load_data' => false));

        if (empty($form)) {
            return false;
        }

        return $form;
    }

    function createAttribute($attr_name, $attr_description, $attr_type, $attr_name_i18n = '') {
        jincimport('utility.servicelocator');
        jincimport('utility.jsonresponse');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $response = new JSONResponse();

        if (strlen($attr_name) == 0) {
            $response->set('status', -1);
            $response->set('errcode', 'COM_JINC_ERR044');
            $response->set('errmsg', JText::_('COM_JINC_ERR044'));
            return $response->toString();
        }

        $dbo = & JFactory::getDBO();
        $attr_name_db = $dbo->getEscaped($attr_name);
        $attr_description_db = $dbo->quote($dbo->getEscaped($attr_description), false);
        $attr_name_i18n_db = $dbo->quote($dbo->getEscaped($attr_name_i18n), false);

        $attr_name_db_table = $dbo->getEscaped('' . $attr_name);

        $query = 'CREATE TABLE IF NOT EXISTS `#__jinc_attribute_' . $attr_name_db . '` (' .
                '`news_id` int(10) unsigned NOT NULL, ' .
                '`id` int(10) unsigned NOT NULL, ' .
                '`value` varchar(255), ' .
                'PRIMARY KEY  (`news_id`, `id`) )';
        $logger->debug('JINCModelAttributes: Executing query: ' . $query);
        $dbo->setQuery($query);
        if (!$dbo->query()) {
            $response->set('status', -1);
            $response->set('errcode', 'COM_JINC_ERR043');
            $response->set('errmsg', JText::_('COM_JINC_ERR043'));
            return $response->toString();
        }

        if (strlen($attr_name_i18n_db) == 0)
            $attr_name_i18n_db = $attr_name_db;
        $query = 'INSERT INTO #__jinc_attribute (name, description, type, name_i18n) ' .
                'VALUES (' . $dbo->quote($attr_name_db, false) . ', ' .
                $attr_description_db . ', ' .
                (int) $attr_type . ', ' .
                $attr_name_i18n_db . ')';

        $logger->debug('JINCModelAttributes: Executing query: ' . $query);
        $dbo->setQuery($query);

        if ($dbo->query()) {
            $response->set('status', 0);
            $response->set('attr_id', $dbo->insertid());
            $response->set('attr_name', $attr_name);
            $response->set('attr_description', $attr_description);
            $response->set('attr_type', $attr_type);
            $response->set('attr_name_i18n', $attr_name_i18n);
            $this->storeAttributeForm();
        } else {
            $response->set('status', -1);
            $response->set('errcode', 'COM_JINC_ERR043');
            $response->set('errmsg', JText::_('COM_JINC_ERR043'));
        }

        return $response->toString();
    }

    function removeAttribute($attr_name) {
        jincimport('utility.servicelocator');
        jincimport('utility.jsonresponse');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $response = new JSONResponse();
        if (strlen($attr_name) == 0) {
            $response->set('status', -1);
            $response->set('errcode', 'COM_JINC_ERR044');
            $response->set('errmsg', JText::_('COM_JINC_ERR044'));
            return $response->toString();
        }

        $dbo = & JFactory::getDBO();
        $attr_name_db = $dbo->getEscaped($attr_name);

        $query = 'SELECT name FROM #__jinc_newsletter ' .
                'WHERE attribs LIKE  ' . $dbo->quote('%' . $attr_name_db . '%', false);
        $dbo->setQuery($query);
        $logger->debug('JINCModelAttributes: Executing query: ' . $query);
        $result = $dbo->loadAssoc();
        if ($result == null) {
            $query = 'DROP TABLE IF EXISTS `#__jinc_attribute_' . $attr_name_db . '`';
            $logger->debug('JINCModelAttributes: Executing query: ' . $query);
            $dbo->setQuery($query);
            if (!$dbo->query()) {
                $response->set('status', -1);
                $response->set('errcode', 'COM_JINC_ERR046');
                $response->set('errmsg', JText::_('COM_JINC_ERR046'));
                return $response->toString();
            }
            
            $query = 'DELETE FROM #__jinc_attribute  ' .
                    'WHERE name = ' . $dbo->quote($attr_name_db, false);

            $logger->debug('JINCModelAttributes: Executing query: ' . $query);
            $dbo->setQuery($query);
            if ($dbo->query()) {
                $response->set('status', 0);
                $this->storeAttributeForm();
            } else {
                $response->set('status', -1);
                $response->set('errcode', 'COM_JINC_ERR046');
                $response->set('errmsg', JText::_('COM_JINC_ERR046'));
            }
        } else {
            $response->set('status', -1);
            $response->set('errcode', 'COM_JINC_ERR045');
            $response->set('errmsg', JText::_('COM_JINC_ERR045') . ' ' . $result['name']);
        }
        return $response->toString();
    }

    function storeAttributeForm() {
        jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');
        jincimport('utility.servicelocator');
        jincimport('utility.jsonresponse');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $dbo = $this->getDbo();
        $query = $dbo->getQuery(true);

        $query->select('name, description, type, name_i18n');
        $query->from('`#__jinc_attribute`');

        $dbo->setQuery($query);
        $logger->debug('JINCModelAttributes: Executing query: ' . $query->__toString());

        $xmlstring = '<?xml version="1.0" encoding="utf-8"?>';
        $xmlstring .= '<form>';
        $xmlstring .= '   <fields name="attribs">';
        $xmlstring .= '      <fieldset name="addictional" label="COM_JINC_ATTRIBUTES">';

        if ($attributes = $dbo->loadAssocList()) {
            foreach ($attributes as $key => $attribute) {
                $xmlstring .= '         <field name="' . $attribute['name'] . '" type="list" label="' . $attribute['name_i18n'] . '"';
                $xmlstring .= '            description="' . $attribute['description'] . '" Default="">';
                $xmlstring .= '            <option value="">COM_JINC_ATTRIBUTE_NONE</option>';
                $xmlstring .= '            <option value="1">COM_JINC_ATTRIBUTE_MANDATORY</option>';
                $xmlstring .= '            <option value="2">COM_JINC_ATTRIBUTE_OPTIONAL</option>';
                $xmlstring .= '         </field>';
                $xmlstring .= '';
            }
        }

        $xmlstring .= '      </fieldset>';
        $xmlstring .= '   </fields>';
        $xmlstring .= '</form>';

        $filename = JPATH_COMPONENT_ADMINISTRATOR . DS . 'models' . DS . 'forms' . DS . 'attributes.xml';
        if ($fh = fopen($filename, 'w+')) {
            $logger->debug('Recreating file ' . $filename);
            fwrite($fh, $xmlstring);
            fclose($fh);
        } else {
            $logger->error('Unable to write file ' . $filename);
        }
    }

}

