<?php

/**
 * @version		$Id: bulkmessage.php 2010-01-19 12:01:47Z lhacky $
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
include_once 'message.php';
require_once 'newsletterfactory.php';

/**
 * BulkMessage class, defining bulk message implementation.
 * It will send a unique message with the subscribers in Blind Carbon Copy (BCC)
 *
 * @package		JINC
 * @subpackage          Core
 * @since		0.6
 */
class BulkMessage extends Message {

    /**
     * The BulkMessage constructor
     *
     * @access	public
     * @param       integer msg_id The message identifier.
     * @return	BulkMessage
     * @see         Message, MessageFactory
     * @since	0.6
     */
    function BulkMessage($msg_id = 0) {
        parent::Message($msg_id);
    }

    /**
     * Message type getter.
     *
     * @access	public
     * @return  Message type.
     * @since	0.8
     */
    function getType() {
        return MESSAGE_TYPE_MASSIVE;
    }

    /**
     * Send a bulk message. It overrides the abstract method defined in Message
     * class.
     *
     * Hint: it starts to send messages from the the $start-th subscribers of
     * the message
     *
     * @access	public
     * @param	int $start_time subscription time to begin to
     * @param	int $start_id subscriber identifier to begin to
     * @return  array containing next suscription time, subscriber id and number of sent messages
     * @since	0.6
     */
    function send($start_time = 0, $start_id = 0) {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');
        jincimport('utility.parameterprovider');

        $mailmsg = & JFactory::getMailer();
        $root_uri = JURI::root();

        $sleeptime = ParameterProvider::getMailTimeInterval();
        $max_mails = ParameterProvider::getMaxXStep();
        $max_bulk_bcc = ParameterProvider::getMailMaxBcc();
        $send_mail = ParameterProvider::getSendMail();
        $logger->finer('BulkMessage: Sleep time ' . $sleeptime . ' - Max mails ' . $max_mails . ' Max BCC ' . $max_bulk_bcc . ' Send mail ' . $send_mail);
        $last_time = $start_time;
        $last_id = $start_id;
        $nmessages = 0;
        $nsuccess = 0;

        if ($newsletter = $this->loadNewsletter()) {
            $logger->finer('BulkMessage: Newsletter loaded');
            $msg = $this->get('body') . $newsletter->get('disclaimer');
            // Newsletter info substitution in message body
            $msg = preg_replace('/\[SENDER\]/s', $newsletter->get('sendername'), $msg);
            $msg = preg_replace('/\[SENDERMAIL\]/s', $newsletter->get('senderaddr'), $msg);
            $msg = preg_replace('/\[NEWSLETTER\]/s', $newsletter->get('name'), $msg);
            $news_id = $newsletter->get('id');
            $unsub_link = JURI::root() . 'index.php?option=com_jinc&view=newsletter&layout=unsubscription&id=' . $news_id;

            $msg = preg_replace('/\[UNSUBSCRIPTIONURL\]/s', $unsub_link, $msg);
            $msg = preg_replace('#src[ ]*=[ ]*\"(?!https?://)(?:\.\./|\./|/)?#', 'src="' . $root_uri, $msg);
            $msg = preg_replace('#href[ ]*=[ ]*\"(?!https?://)(?!mailto?:)(?!tel?:)(?:\.\./|\./|/)?#', 'href="' . $root_uri, $msg);
            $msg = preg_replace('#url[ ]*\(\'(?!https?://)(?:\.\./|\./|/)?#', 'url(\'' . $root_uri, $msg);

            $subject = $this->get('subject');
            $subject = preg_replace('/\[SENDER\]/s', $newsletter->get('sendername'), $subject);
            $subject = preg_replace('/\[SENDERMAIL\]/s', $newsletter->get('senderaddr'), $subject);
            $subject = preg_replace('/\[NEWSLETTER\]/s', $newsletter->get('name'), $subject);

            // Setting message general properties
            $mailmsg->ContentType = ($this->get('plaintext')) ? "text/plain" : "text/html";
            $mailmsg->setSubject($subject);
            if (strlen($newsletter->get('senderaddr')) > 0)
                $mailmsg->setSender(array($newsletter->get('senderaddr'), $newsletter->get('sendername')));
            if (strlen($newsletter->get('replyto_addr')) > 0)
                $mailmsg->addReplyTo(array($newsletter->get('replyto_addr'), $newsletter->get('replyto_name')));

            $path_abs_root = JPATH_ROOT;
            $msg_attachment = $this->get('attachment');
            $arr_attachment = $msg_attachment->toArray();
            foreach ($arr_attachment as $key => $value) {
                $attachment = str_replace('/', DS, $value);
                if (strlen($attachment)) {
                    $logger->finer('BulkMessage: adding attachment ' . $path_abs_root . DS . $attachment);
                    $mailmsg->addAttachment($path_abs_root . DS . $attachment);
                }
            }

            $logger->finer('BulkMessage: going to add recipients');
            $recipients = $newsletter->getSubscribersList($start_time, $start_id, $max_bulk_bcc);
            $nrecips = count($recipients);
            $logger->finer('BulkMessage: found ' . $nrecips . ' subscribers');
            for ($i = 0; $i < $nrecips; $i += $max_bulk_bcc) {
                $ndest = 0;
                for ($j = 0; $j < $max_bulk_bcc && ($j + $i) < $nrecips; $j++) {
                    $current = $recipients[$j + $i];
                    $mailmsg->addBCC($current['email']);
                    $ndest = $ndest + 1;
                    $last_time = $current['last_time'];
                    $last_id = $current['last_id'];
                }
                $mailmsg->setBody($msg);
                $nmessages = $nmessages + $ndest;
                if ($send_mail) {
                    $success = $mailmsg->Send();
                    if ($success === true) {
                        $nsuccess = $nsuccess + $ndest * $success;
                        $logger->finer('BulkMessage: success sending mail.');
                    } else {
                        $logger->warning('BulkMessage: error sending mail.');
                    }
                } else {
                    $bcc_addresses = array();
                    foreach ($mailmsg->bcc as $number_variable => $variable) {
                        array_push($bcc_addresses, $mailmsg->bcc[$number_variable][0]);
                    }
                    $logger->info('BulkMessage: simulate sending mail. BCC = ' . implode(', ', $bcc_addresses));
                    $logger->info('BulkMessage: simulate sending mail. Body = ' . $msg);
                    $nsuccess = $nsuccess + $ndest;
                }
                // socket_select($read = NULL, $write = NULL, $sock = array(socket_create (AF_INET, SOCK_RAW, 0)), 0, $sleeptime);
                usleep($sleeptime);
                $mailmsg->ClearAllRecipients();
            }
        } else {
            $this->setError('COM_JINC_ERR001');
            return false;
        }

        return array('last_time' => $last_time, 'last_id' => $last_id, 'nmessages' => $nmessages, 'nsuccess' => $nsuccess);
    }

}

?>
