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

class JINCModelMessage extends JModelAdmin {
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
        $form = $this->loadForm('com_jinc.message', 'message', array('control' => 'jform', 'load_data' => false));

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
            $registry->loadJSON($item->attachment);
            $item->attachment = $registry->toArray();
        }
        return $item;
    }

    function preview($id) {
        jincimport('core.messagefactory');
        jincimport('utility.jsonresponse');
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $minstance = MessageFactory::getInstance();
        if (!$message = $minstance->loadMessage($id)) {
            $this->setError('COM_JINC_ERR037');
            return false;
        }

        if (!( $result = $message->preview())) {
            $this->setError($message->getError());
            return false;
        }
        return $result;
    }

    function getProcess() {
        jincimport('core.messagefactory');
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $id = JRequest::getInt('id', 0);
        $minstance = MessageFactory::getInstance();

        return $minstance->loadProcess($id, true);
    }
    
    function getHistory() {
        jincimport('core.messagefactory');
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $id = JRequest::getInt('id', 0);
        $minstance = MessageFactory::getInstance();

        if (!($history = $minstance->loadHistory($id))) {
            $history = array();
        }
        return $history;
    }

    function getNewsletter() {
        jincimport('core.newsletterfactory');
        jincimport('core.messagefactory');
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $id = JRequest::getInt('id', 0);
        $minstance = MessageFactory::getInstance();
        $ninstance = NewsletterFactory::getInstance();

        if ($message = $minstance->loadMessage($id)) {
            $news_id = $message->get('news_id');
            if ($newsletter = $ninstance->loadNewsletter($news_id))
                return $newsletter;
        }
        return false;
    }

    function send($id, $client_id, $restart = 0) {
        jincimport('core.messagefactory');
        jincimport('utility.jsonresponse');
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $success = true;

        $minstance = MessageFactory::getInstance();
        if ($process = $minstance->loadProcess($id, true)) {
            if (!$process->play($client_id)) {
                $this->setError($process->getError());
                $success = false;
            }
        } else {
            $this->setError('COM_JINC_ERR041');
            $success = false;
        }

        $response = new JSONResponse();
        if ($success) {
            $response->set('status', $process->get('status'));
            $response->set('tot_recipients', $process->get('tot_recipients'));
            $response->set('sent_messages', $process->get('sent_messages'));
            $response->set('sent_success', $process->get('sent_success'));
            $response->set('last_subscriber_time', $process->get('last_subscriber_time'));
            $response->set('server_time', date('r', time()));
            $response->set('start_time', date('r', $process->get('start_time')));
        } else {
            $response->set('status', -1);
            $response->set('errcode', $this->getError());
            $response->set('errmsg', JText::_($this->getError()));
        }
        $logger->debug('JSON: ' . $response->toString());
        return $response->toString();
    }

    function pause($id) {
        jincimport('core.messagefactory');
        jincimport('utility.jsonresponse');
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $success = true;

        $minstance = MessageFactory::getInstance();
        if ($process = $minstance->loadProcess($id, true)) {
            if (!$process->pause()) {
                $this->setError($process->getError());
                $success = false;
            }
        } else {
            $this->setError('COM_JINC_ERR041');
            $success = false;
        }

        $response = new JSONResponse();
        if ($success) {
            $response->set('status', $process->get('status'));
        } else {
            $response->set('status', -1);
            $response->set('errcode', $this->getError());
            $response->set('errmsg', JText::_($this->getError()));
        }
        $logger->debug('JSON: ' . $response->toString());
        return $response->toString();
    }

    function stop($id) {
        jincimport('core.messagefactory');
        jincimport('utility.jsonresponse');
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $success = true;

        $minstance = MessageFactory::getInstance();
        if ($process = $minstance->loadProcess($id, true)) {
            if (!$process->stop()) {
                $this->setError($process->getError());
                $success = false;
            }
        } else {
            $this->setError('COM_JINC_ERR041');
            $success = false;
        }

        $response = new JSONResponse();
        if ($success) {
            $response->set('status', $process->get('status'));
        } else {
            $response->set('status', -1);
            $response->set('errcode', $this->getError());
            $response->set('errmsg', JText::_($this->getError()));
        }
        $logger->debug('JSON: ' . $response->toString());
        return $response->toString();
    }
}
?>