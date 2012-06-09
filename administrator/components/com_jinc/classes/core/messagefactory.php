<?php
/**
 * @version		$Id: messagefactory.php 2010-01-19 12:01:47Z lhacky $
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
require_once 'personalmessage.php';
require_once 'bulkmessage.php';
require_once 'newsletterfactory.php';
require_once 'messagetemplate.php';
require_once 'standardprocess.php';
jimport('joomla.registry.registry');

/**
 * MessageFactory class, building Message objects from a message ID and
 * getting information from database.
 * This class implements the Factory Design Pattern.
 *
 * @package		JINC
 * @subpackage          Core
 * @since		0.6
 */

class MessageFactory {
    function MessageFactory() {

    }

    function &getInstance() {
        static $instance = null;
        if (null === $instance) {
            $instance = new MessageFactory();
        }
        return $instance;
    }

    /**
     * The message loader. It loads a message from his identifier.
     *
     * @access	public
     * @param	integer $msg_id the message identifier.
     * @return      The Message object or false if something wrong.
     * @since	0.6
     * @see         Message
     */
    function loadMessage($msg_id) {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $query = 'SELECT m.id, m.body, m.subject, m.plaintext, ' .
            'm.attachment, m.bulkmail, m.news_id ' .
            'FROM #__jinc_message m ' .
            'LEFT JOIN #__jinc_newsletter n ON m.news_id = n.id ' .
            'WHERE m.id = ' . (int) $msg_id;
        $logger->debug('MessageFactory: Executing query: ' . $query);
        $dbo =& JFactory::getDBO();
        $dbo->setQuery($query);
        // Loading message information from database
        if ($result = $dbo->loadAssocList()) {
            $message = $result[0];
        } else {
            return false;
        }
        // Choosing message type to return
        if ($message['bulkmail']) {
            $logger->finer('MessageFactory: Bulk Message Building');
            $msgObj = new BulkMessage($msg_id);
        } else {
            $logger->finer('MessageFactory: Personal Message Building');
            $msgObj = new PersonalMessage($msg_id);
        }
        // Setting message properties
        $attachments = new JRegistry('');
        $attachments->loadString($message['attachment']);
        $msgObj->set('attachment', $attachments);
        $msgObj->set('body', $message['body']);
        $msgObj->set('plaintext', $message['plaintext']);
        $msgObj->set('subject', $message['subject']);
        $msgObj->set('news_id', $message['news_id']);
        return $msgObj;
    }

    /**
     * Load template from database.
     *
     * @access	public
     * @return  MessageTemplate the default template, false if something wrong.
     * @since	0.6
     */

    function loadTemplate($tem_id) {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $query = 'SELECT name, subject, body ' .
            'FROM #__jinc_template ' .
            'WHERE id = ' . (int) $tem_id;
        $logger->debug('MessageFactory: Executing query: ' . $query);
        $dbo =& JFactory::getDBO();
        $dbo->setQuery($query);
        if (!$template_list = $dbo->loadAssocList())
            return false;
        if (empty($template_list))
            return false;

        $template_info = $template_list[0];
        $template = new MessageTemplate($tem_id);
        $template->set('name', $template_info['name']);
        $template->set('subject', $template_info['subject']);
        $template->set('body', $template_info['body']);
        return $template;
    }

    /**
     * The process loader. It loads the running or pause process relative to
     * this message. If no running or pause process exist it can create a new
     * one in paused state using the $create parameter.
     *
     * @access	public
     * @param	integer $msg_id the message identifier.
     * @param   bool    $create it create a paused process if no process exists
     * @return  Process The Process object or false if something wrong.
     * @since	0.7
     * @see     Process
     */

    function loadProcess($msg_id, $create = false) {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $query = 'SELECT id, status, UNIX_TIMESTAMP(start_time) AS start_time, ' .
            'UNIX_TIMESTAMP(last_update_time) AS last_update_time, client_id, sent_messages, sent_success, ' .
            'UNIX_TIMESTAMP(last_subscriber_time) AS last_subscriber_time, last_subscriber_id ' .
            'FROM #__jinc_process ' .
            'WHERE msg_id = ' . (int) $msg_id . ' ' .
            'AND status != ' . PROCESS_STATUS_FINISHED;
        $logger->debug('MessageFactory: Executing query: ' . $query);
        $dbo =& JFactory::getDBO();
        $dbo->setQuery($query);
        // Loading message information from database
        if ($result = $dbo->loadAssocList()) {
            $info = $result[0];
        } else {
            if ($create) {
                $query = 'INSERT INTO #__jinc_process ' .
                    '(msg_id, status, start_time,  ' .
                    'last_update_time) VALUES ' .
                    '(' . $msg_id . ', ' . PROCESS_STATUS_STOPPED . ', now(), 0)';
                $logger->debug('MessageFactory: Executing query: ' . $query);
                $dbo->setQuery($query);
                if ($dbo->query()) {
                    $info = array();
                    $info['id'] = $dbo->insertid();
                    $info['msg_id'] = $msg_id;
                    $info['status'] = PROCESS_STATUS_STOPPED;
                    $info['start_time'] = 0;
                    $info['last_update_time'] = 0;
                    $info['last_subscriber_time'] = 0;
                    $info['last_subscriber_id'] = 0;
                    $info['sent_messages'] = 0;
                    $info['sent_success'] = 0;
                    $info['client_id'] = '';
                } else {
                    return false;
                }
            } else {
                return false;
            }

        }

        $process = new StandardProcess($info['id'], $msg_id);
        // Setting message properties
        $process->set('status', $info['status']);
        $process->set('client_id', $info['client_id']);
        $process->set('start_time', $info['start_time']);
        $process->set('last_update_time', $info['last_update_time']);
        $process->set('last_subscriber_time', $info['last_subscriber_time']);
        $process->set('last_subscriber_id', $info['last_subscriber_id']);
        $process->set('sent_messages', $info['sent_messages']);
        $process->set('sent_success', $info['sent_success']);
        if ($process->status == PROCESS_STATUS_STOPPED) {
            $process->set('sent_messages', 0);
            $process->set('sent_success', 0);
        }
        return $process;
    }

    /**
     * The message history loader. It returns an array of finished processes
     * related to a message.
     *
     * @access	public
     * @param	integer $msg_id the message identifier.
     * @return  array   Array of processes or false if something wrong
     * @since	0.7
     * @see     Process
     */

    function loadHistory($msg_id) {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $query = 'SELECT id, status, UNIX_TIMESTAMP(start_time) AS start_time, ' .
            'UNIX_TIMESTAMP(last_update_time) AS last_update_time, client_id, sent_messages, sent_success, ' .
            'UNIX_TIMESTAMP(last_subscriber_time) AS last_subscriber_time, last_subscriber_id ' .
            'FROM #__jinc_process ' .
            'WHERE msg_id = ' . (int) $msg_id . ' ' .
            'AND status = ' . PROCESS_STATUS_FINISHED . ' ' .
            'ORDER BY start_time DESC';
        $logger->debug('MessageFactory: Executing query: ' . $query);
        $dbo =& JFactory::getDBO();
        $dbo->setQuery($query);
        // Loading historical processes information from database
        $history = array();
        if ($result = $dbo->loadAssocList()) {
            foreach ($result as $info) {
                $process = new StandardProcess($info['id'], $msg_id);
                // Setting message properties
                $process->set('status', $info['status']);
                $process->set('client_id', $info['client_id']);
                $process->set('start_time', $info['start_time']);
                $process->set('last_update_time', $info['last_update_time']);
                $process->set('last_subscriber_time', $info['last_subscriber_time']);
                $process->set('last_subscriber_id', $info['last_subscriber_id']);
                $process->set('sent_messages', $info['sent_messages']);
                $process->set('sent_success', $info['sent_success']);
                array_push($history, $process);
            }
        } else {
            return false;
        }
        return $history;
    }

    /**
     * Load Template names.
     *
     * @access	public
     * @return  array List of tem_id/tem_name pairs.
     * @since	0.7
     */
    function loadTemplateNames() {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $query = 'SELECT tem_id, tem_name FROM #__jinc_template';
        $logger->debug('MessageFactory: executing query ' . $query);
        $dbo =& JFactory::getDBO();
        $dbo->setQuery($query);

        if ($result = $dbo->loadObjectList()) {
            return $result;
        }
        return false;
    }
}
?>
