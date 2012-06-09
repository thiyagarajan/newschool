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

class JINCModelSubscriber extends JModelAdmin {

    function __construct() {
        parent::__construct();
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
    public function getForm($data = array(), $loadData = true) {
        $form = $this->loadForm('com_jinc.subscriber', 'subscriber', array('control' => 'jform', 'load_data' => false));

        return $form;
    }

    public function getInfo() {
        if ($item = parent::getItem()) {
            jincimport('core.newsletterfactory');
            $ninstance = NewsletterFactory::getInstance();
            if ($newsletter = $ninstance->loadNewsletter($item->news_id)) {
                return $newsletter->getSubscriber($item->id);
            }
        }
        return false;
    }

    /**
     * Method to test whether a record can be deleted.
     *
     * @param	object	$record	A record object.
     *
     * @return	boolean	True if allowed to change the state of the record. Defaults to the permission set in the component.
     * @since	1.6
     */
    protected function canApprove($record) {
        $user = JFactory::getUser();
        return $user->authorise('core.edit', $this->option);
    }

    /**
     * Method to approve one or more subscriptions.
     *
     * @param	array	$pks	An array of record primary keys.
     *
     * @return	boolean	True if successful, false if an error occurs.
     * @since	0.9
     */
    public function approve(&$pks) {
        $user = JFactory::getUser();
        $pks = (array) $pks;
        $table = $this->getTable();

        // Iterate the items to delete each one.
        foreach ($pks as $i => $pk) {

            if ($table->load($pk)) {
                if ($this->canApprove($table)) {
                    if (!$table->approve($pk)) {
                        $this->setError($table->getError());
                        return false;
                    }
                } else {
                    unset($pks[$i]);
                    $error = $this->getError();
                    if ($error) {
                        JError::raiseWarning(500, $error);
                    } else {
                        JError::raiseWarning(403, JText::_('COM_JINC_APPROVE_NOT_PERMITTED'));
                    }
                }
            } else {
                $this->setError($table->getError());
                return false;
            }
        }
        return true;
    }

}

?>
