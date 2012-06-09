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

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldJINCNotice extends JFormField {

    protected $type = 'JINCNewsletter';

    protected function getInput() {
        $db = &JFactory::getDBO();

        $query = 'SELECT id AS value, name AS text FROM #__jinc_notice';
        $db->setQuery($query);
        $newsletters = $db->loadObjectList();

        $required = ((string) $this->element['required'] == 'true') ? TRUE : FALSE;
        $onchange = $this->element['onchange'] ? ' onchange="'.(string) $this->element['onchange'].'"' : '';

        array_unshift($newsletters, JHTML::_('select.option', '', JText::_('COM_JINC_SELECT_NOTICE'), 'value', 'text'));
        return JHTML::_('select.genericlist', $newsletters, $this->name, 'class="inputbox" ' . $onchange, 'value', 'text', $this->value, $this->id);
    }

    /**
     * Method to get the field options.
     *
     * @return	array	The field option objects.
     * @since	1.6
     */
    public function getOptions() {
        // Initialize variables.
        $options = array();

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('id AS value, name AS text');
        $query->from('#__jinc_notice AS n');
        $query->order('n.name');

        // Get the options.
        $db->setQuery($query);

        $options = $db->loadObjectList();

        // Check for a database error.
        if ($db->getErrorNum()) {
            JError::raiseWarning(500, $db->getErrorMsg());
        }

        return $options;
    }
}

?>