<?php

/**
 * @version		$Id: process.php 2010-08-08 12:01:47Z lhacky $
 * @package		JINC
 * @subpackage          Core
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
require_once 'jincobject.php';

define('PROCESS_STATUS_STOPPED', 0);
define('PROCESS_STATUS_PAUSED', 1);
define('PROCESS_STATUS_RUNNING', 2);
define('PROCESS_STATUS_FINISHED', 3);

/**
 * Process class, defining a newsletter dispatch process manager.
 *
 * @package		JINC
 * @subpackage          Core
 * @since		0.7
 */
class Process extends JINCObject {
/**
 * The process identifier
 *
 * @var		The process identifier
 * @access	protected
 * @since	0.7
 */
    var $id;
    /**
     * The message identifier
     *
     * @var		The message identifier
     * @access	protected
     * @since	0.7
     */
    var $msg_id = 0;
    /**
     * The process creation timestamp
     *
     * @var		Creation time
     * @access	protected
     * @since	0.7
     */
    var $start_time;
    /**
     * The last process update time
     *
     * @var		Last update time
     * @access	protected
     * @since	0.7
     */
    var $last_update_time;
    /**
     * The subscription time of the last subscriber contacted during last process
     * execution
     *
     * @var		Subscription time of the last subscriber
     * @access	protected
     * @since	0.7
     */
    var $last_subscriber_time;
    /**
     * The identifier of the last subscriber contacted during last process
     * execution
     *
     * @var		Subscription time of the last subscriber
     * @access	protected
     * @since	0.7
     */
    var $last_subscriber_id;
    /**
     * The number of messages sent up to now
     *
     * @var     The number of messages sent up to now
     * @access	protected
     * @since	0.7
     */
    var $sent_messages;
    /**
     * The number of messages sent successfully up to now
     *
     * @var     The number of messages sent successfully up to now
     * @access	protected
     * @since	0.7
     */
    var $sent_success;
    /**
     * The number of recipientes to contact during process
     *
     * @var     The number of messages sent up to now
     * @access	protected
     * @since	0.7
     */
    var $tot_recipients;
    /**
     * The status process.
     *
     * It can be PROCESS_STATUS_RUNNING, PROCESS_STATUS_PAUSED OR
     * PROCESS_STATUS_FINISHED
     *
     *
     * @var		The process status
     * @access	protected
     * @since	0.7
     */
    var $status = PROCESS_STATUS_STOPPED;

    /**
     * The client identifier. It is a 32 characters random string that identifies
     * the client running the process.
     *
     * @var		The client identifier
     * @access	protected
     * @since	0.7
     */
    var $client_id = '';

    /**
     * The Process constructor. A process can be constructed using the
     * constructor or using the loadProcess method from MessageFactory class.
     *
     * @access	public
     * @param   integer proc_id The process identifier.
     * @param   integer proc_id The message identifier.
     * @return	Process
     * @since	0.7
     * @see     MessageFactory
     */
    function Process($proc_id, $msg_id) {
        parent::__construct();
        $this->set('id', $proc_id);
        $this->set('msg_id', $msg_id);
    }

    /**
     * Play the process. It execute the next process step sending the message
     * to the next subscriber(s)
     *
     * @param bool $restart force process restarting
     * @return false if something wrong
     * @since 0.7
     */
    function play($client_id = '', $restart = false) {
        die('Process class: play() is an abstract method');
    }

    /**
     * Pauses the process.
     *
     * @return false if something wrong
     * @since 0.7
     */
    function pause() {
        die('Process class: pause() is an abstract method');
    }

    /**
     * Pauses the process.
     *
     * @return false if something wrong
     * @since 0.7
     */
    function stop() {
        die('Process class: stop() is an abstract method');
    }

    /**
     * The process status also in DB.
     *
     * @param $status The process status
     * @return false if something wrong
     * @since 0.7
     */
    function updateStatus($status, $client_id = '') {
        if ($this->status != PROCESS_STATUS_FINISHED) {
            jincimport('utility.servicelocator');
            $servicelocator = ServiceLocator::getInstance();
            $logger = $servicelocator->getLogger();
            $dbo = & JFactory::getDBO();

            $query = 'UPDATE #__jinc_process ' .
                'SET status = ' . $status . ' ';
            if ($client_id != '')
                $query .= ', client_id = \'' . $client_id . '\' ';

            if ($status == PROCESS_STATUS_STOPPED) {
                $query .= ', sent_success = 0 ';
                $query .= ', sent_messages = 0 ';
            }
            $query .= 'WHERE id = ' . $this->get('id');
            $dbo->setQuery($query);
            $logger->debug('Process: executing query: ' . $query);
            if (!$dbo->query()) {
                $this->setError('COM_JINC_ERR039');
                return false;
            }
            $this->status = $status;
            $this->client_id = $client_id;
            if ($status == PROCESS_STATUS_STOPPED) {
                $this->sent_messages = 0;
                $this->sent_messages = 0;
            }
            return true;
        }
        return false;
    }

    /**
     * Reload status from DB
     *
     * @param $status The process status
     * @return false if something wrong
     * @since 0.7
     */
    function reloadStatus() {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();
        $dbo = & JFactory::getDBO();
        $query = 'SELECT status FROM #__jinc_process ' .
            'WHERE id = ' . $this->get('id');
        $dbo->setQuery($query);

        if ($result = $dbo->loadAssocList()) {
            if (empty ($result)) {
                $logger->finer('Process: Error getting status process');
                return false;
            }
            $this->status = $result[0]['status'];
        } else {
            return false;
        }
        return true;
    }
}
?>
