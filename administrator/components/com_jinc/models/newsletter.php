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

class JINCModelNewsletter extends JModelAdmin {

    function __construct() {
        parent::__construct();
    }

    function import($news_id, $csvfile_name) {
        jincimport('core.newsletterfactory');
        jincimport('core.newsletterimporter');

        $ninstance = NewsletterFactory::getInstance();
        $newsletter = $ninstance->loadNewsletter($news_id, false);
        $importer = NewsletterImporter::getInstance();
        return $importer->ImportFromCSV($newsletter, $csvfile_name);
    }

    function getSubscribers() {
        jincimport('core.newsletterfactory');
        $news_id = JRequest::getInt('id', 0);

        $ninstance = NewsletterFactory::getInstance();
        if ($newsletter = $ninstance->loadNewsletter($news_id, false)) {
            if ($acl = $newsletter->loadACL()) {
                return $acl->getEntriesName(ACL_ACCESS_SUBSCRIBER);
            }
        }
        return array();
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
        $form = $this->loadForm('com_jinc.newsletter', 'newsletter', array('control' => 'jform', 'load_data' => false));
        $form->loadFile('attributes', false);

        $data = array();
        if ($loadData) {
            $data = $this->loadFormData();
        }
        $this->preprocessForm($form, $data);
        // Load the data into the form after the plugins have operated.        
        $form->bind($data);

        if (empty($form)) {
            return false;
        }
        return $form;
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return	mixed	The data for the form.
     * @since	1.6
     */
    protected function loadFormData() {
        $data = $this->getItem();
        return $data;
    }

    /**
     * Method to get a single record.
     *
     * @param	integer	The id of the primary key.
     *
     * @return	mixed	Object on success, false on failure.
     */
    public function getItem($pk = null) {
        if ($item = parent::getItem($pk)) {
            // Convert the params field to an array.
            $registry = new JRegistry;
            $registry->loadJSON($item->attribs);
            $item->attribs = $registry->toArray();
            // Setting default values for optins
            if ($item->id == 0) {
                $item->optin = JText::_('COM_JINC_OPTIN_DEFAULT');
                $item->optin_subject = JText::_('COM_JINC_OPTIN_SUBJECT_DEFAULT');
                $item->optinremove = JText::_('COM_JINC_OPTINREMOVE_DEFAULT');
                $item->optinremove_subject = JText::_('COM_JINC_OPTINREMOVE_SUBJECT_DEFAULT');
                $item->welcome = JText::_('COM_JINC_WELCOME_DEFAULT');
                $item->welcome_subject = JText::_('COM_JINC_WELCOME_SUBJECT_DEFAULT');
            }
        }
        return $item;
    }

    /**
     * Method to construct a Newsletter Object from id.
     *
     * @param	integer	The id of the primary key.
     *
     * @return	mixed	Object on success, false on failure.
     */
    public function getNewsletter($pk = null) {
        if ($item = parent::getItem($pk)) {
            jincimport('core.newsletterfactory');
            $ninstance = NewsletterFactory::getInstance();
            $newsletter = $ninstance->loadNewsletter($item->id);
            return $newsletter;
        }
        return false;
    }

}

?>
