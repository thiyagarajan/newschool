<?php

/**
 * @version		$Id: process.php 2010-01-19 12:01:47Z lhacky $
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
require_once 'process.php';

/**
 * Process class, defining a newsletter dispatch process manager.
 *
 * @package		JINC
 * @subpackage          Core
 * @since		0.7
 */
class StandardProcess extends Process {
/**
 * The StandardProcess constructor. A process can be constructed using the
 * constructor or using the loadProcess method from MessageFactory class.
 *
 * @access	public
 * @param   integer proc_id The process identifier.
 * @param   integer proc_id The message identifier.
 * @return	Process
 * @since	0.7
 * @see     MessageFactory
 */
    function StandardProcess($proc_id, $msg_id) {
        parent::Process($proc_id, $msg_id);
        $this->set('last_subscriber_time', 0);
    }

    /**
     * Play the process. It execute the next process step sending the message
     * to the next subscriber(s)
     *
     * @param string $client_id Client identifier
     * @return false if something wrong
     * @since 0.7
     */
    function play($client_id = '') {
        jincimport('core.messagefactory');
        jincimport('utility.jsonresponse');
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();
        $dbo = & JFactory::getDBO();

        if ($this->status == PROCESS_STATUS_RUNNING && $this->client_id != $client_id) {
            $this->setError('COM_JINC_ERR042');
            return false;
        }

        $start_time = 0;
        if ($this->status != PROCESS_STATUS_RUNNING) {
            if ($this->client_id == '') {
                $start_time = time();
                $this->start_time = $start_time;
            }
            if ($this->status == PROCESS_STATUS_STOPPED) {
                $start_time = time();
                $this->start_time = $start_time;
                $this->last_subscriber_time = 0;
                $this->last_update_time = 0;
                $this->sent_messages = 0;
                $this->sent_success = 0;
            }
            if ($this->client_id != $client_id)
                if (! $this->updateStatus(PROCESS_STATUS_RUNNING, $client_id))
                    return false;
        }

        $msg_id = $this->msg_id;
        $minstance = MessageFactory::getInstance();
        if ($message = $minstance->loadMessage($msg_id)) {
            if ($newsletter = $message->loadNewsletter()) {
                $this->tot_recipients = $newsletter->countSubscribers();
                if ($this->tot_recipients < 0) {
                    $this->setError('COM_JINC_ERR007');
                    return false;
                }
            } else {
                $this->setError('COM_JINC_ERR001');
                return false;
            }
        } else {
            $this->setError('COM_JINC_ERR035');
            return false;
        }

        $logger->finer('Sending process: ' . $this->last_subscriber_time . ' - ' . $this->last_subscriber_id);
        $news_id = $newsletter->get('id');

        if ($send_result = $message->send($this->last_subscriber_time, $this->last_subscriber_id)) {
            $last_time = $send_result['last_time'];
            $last_id = $send_result['last_id'];
            $this->sent_messages = $this->sent_messages + $send_result['nmessages'];
            $this->sent_success = $this->sent_success + $send_result['nsuccess'];

            if ($send_result['nmessages'] == 0) {
                $this->updateStatus(PROCESS_STATUS_FINISHED);

                $logger->finer('Process: triggering message sent event');
                $dispatcher = &JDispatcher::getInstance();
                $params = array('news_id' => $news_id, 'msg_id' => $msg_id);
                $result = $dispatcher->trigger('jinc_sent', $params);
            }

            $query = 'UPDATE #__jinc_process ' .
                'SET last_subscriber_time = FROM_UNIXTIME(' . $last_time . '), ' .
                'last_update_time = NOW(), ' .
                'last_subscriber_id = ' . $last_id . ', ' .
                'sent_success = ' . $this->sent_success . ', ' .
                'sent_messages = ' . $this->sent_messages . ' ';
            if ($start_time > 0)
                $query .= ', start_time = FROM_UNIXTIME(' . $start_time . ') ';
            $query .= 'WHERE id = ' . $this->id;

            $dbo->setQuery($query);
            $logger->debug('Process: executing query: ' . $query);
            if (!$dbo->query()) {
                $this->setError('COM_JINC_ERR039');
                return false;
            }
            if (!$this->reloadStatus()) {
                $this->setError('COM_JINC_ERR039');
                return false;
            }
            $this->last_subscriber_time = $last_time;
            $this->last_subscriber_id = $last_id;
        } else {
            if ($this->updateStatus(PROCESS_STATUS_STOPPED))
                $this->setError('COM_JINC_ERR040');
            return false;
        }
        return true;
    }

    /**
     * Pauses the process.
     *
     * @return false if something wrong
     * @since 0.7
     */
    function pause() {
        if ($this->status == PROCESS_STATUS_RUNNING)
            return $this->updateStatus(PROCESS_STATUS_PAUSED);
        return true;
    }

    /**
     * Pauses the process.
     *
     * @return false if something wrong
     * @since 0.7
     */
    function stop() {
        if ($this->status == PROCESS_STATUS_RUNNING || $this->status == PROCESS_STATUS_PAUSED)
            return $this->updateStatus(PROCESS_STATUS_STOPPED);
        return true;
    }
}
?>
