<?php

/**
 * @package		JINC
 * @subpackage          Frontend
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

/**
 * JINCFrontnedHelper class, providing common JINC helper frontend functions.
 *
 * @package		JINC
 * @subpackage          Utility
 * @since		0.7
 */
class JINCFrontnedHelper {

    function listMessagesTitle($newsletter, $messages, $linkable) {
        $base_jinc = JURI::base() . 'components/com_jinc/assets/images/icons/';
        $options = array('height' => 16, 'width' => 16, 'title' => JText::_('COM_JINC_ATTACHMENT'));
        $attach_img = JHTML::image($base_jinc . 'attachment.png', JText::_('COM_JINC_ATTACHMENT'), $options);

        echo '<table class="tbl_oldmsg" align="center" width="95%">';
        echo '<thead><tr>';
        echo '<th width="65%" align="left">' . JText::_('COM_JINC_SUBJECT') . '</th>';
        echo '<th width="25%" align="center">' . JText::_('COM_JINC_MSGSENT') . '</th>';
        echo '<th width="10%" align="center">' . $attach_img . '</th>';
        echo '</tr></thead>';
        $i = 0;
        foreach ($messages as $message) {
            $subject = $message->subject;
            $body = $message->body . $newsletter->get('disclaimer');
            $body = preg_replace('/\[SENDER\]/s', $newsletter->get('sendername'), $body);
            $body = preg_replace('/\[SENDERMAIL\]/s', $newsletter->get('senderaddr'), $body);
            $body = preg_replace('/\[NEWSLETTER\]/s', $newsletter->get('name'), $body);
            $news_id = $newsletter->get('id');
            $unsub_link = JURI::root() . 'index.php?option=com_jinc&view=newsletter&layout=unsubscription&news_id=' . $news_id;
            $body = preg_replace('/\[UNSUBSCRIPTIONURL\]/s', $unsub_link, $body);
            $user = & JFactory::getUser();
            if (!$user->guest) {
                $user_mail = $user->get('email');
                $userid = $user->get('username');
                $username = $user->get('name');
                $current = array('usermail' => $user_mail, 'userid' => $userid, 'username' => $username);
                foreach ($current as $key => $value) {
                    $body = preg_replace('/\[' . strtoupper($key) . '\]/s', $value, $body);
                }
            }
            $datasent = $message->datasent;
            $attachment = str_replace(DS, '/', $message->attachment);
            $link_att = JRoute::_('images/' . $attachment);
            echo '<tr class="row' . ($i % 2) . '">';
            echo '<td width="50%">';
            if ($linkable) {
                echo '<a href="index.php?option=com_jinc&view=message&id=' . $message->id . '">' . $subject . '</a>';
            } else {
                echo JHTML::tooltip(substr(strip_tags($body), 0, 75) . ' ...', $subject, '', $subject);
            }
            echo '</td>';
            echo '<td width="20%" align="center">' . $datasent . '</td>';
            echo '<td width="8%" align="center">';
            if (strlen($message->attachment) > 0) {
                echo $attach_img;
            }
            echo '</td>';
            echo '</tr>';
            $i++;
        }
        echo '</table>';
    }

    function listMessagesEntire($newsletter, $messages) {
        foreach ($messages as $message) {
            JINCFrontnedHelper::showMessage($newsletter, $message);
        }
    }

    function listMessages($newsletter, $messages) {
        jincimport('core.newsletter');
        $front_type = $newsletter->get('front_type');
        if ($front_type == NEWSLETTER_FRONT_TYPE_ONLY_TITLE) {
            return JINCFrontnedHelper::listMessagesTitle($newsletter, $messages, false);
        }
        if ($front_type == NEWSLETTER_FRONT_TYPE_CLICKABLE_TITLE) {
            return JINCFrontnedHelper::listMessagesTitle($newsletter, $messages, true);
        }
        if ($front_type == NEWSLETTER_FRONT_TYPE_ENTIRE_MESSAGE) {
            return JINCFrontnedHelper::listMessagesEntire($newsletter, $messages);
        }
    }

    function showMessage($newsletter, $message) {
        jimport('joomla.registry.registry');
        if (is_subclass_of($message, 'Message')) {
            $subject = $message->get('subject');
            $body = $message->get('body');
            $attachment = $message->get('attachment');
        } else {
            $subject = $message->subject;
            $body = $message->body;
            $attachment = new JRegistry('');
            $attachment->loadString($message->attachment);
        }

        $body .= $newsletter->get('disclaimer');
        $body = preg_replace('/\[SENDER\]/s', $newsletter->get('sendername'), $body);
        $body = preg_replace('/\[SENDERMAIL\]/s', $newsletter->get('senderaddr'), $body);
        $body = preg_replace('/\[NEWSLETTER\]/s', $newsletter->get('name'), $body);
        $news_id = $newsletter->get('id');
        $unsub_link = JURI::root() . 'index.php?option=com_jinc&view=newsletter&layout=unsubscription&news_id=' . $news_id;
        $body = preg_replace('/\[UNSUBSCRIPTIONURL\]/s', $unsub_link, $body);
        $user = & JFactory::getUser();
        if (!$user->guest) {
            $user_mail = $user->get('email');
            $userid = $user->get('username');
            $username = $user->get('name');
            $current = array('usermail' => $user_mail, 'userid' => $userid, 'username' => $username);
            foreach ($current as $key => $value) {
                $body = preg_replace('/\[' . strtoupper($key) . '\]/s', $value, $body);
            }
        }

        echo '<div id="jinc_msgbox">';
        echo '<div class="top">';
        echo '<div class="content">';
        echo '<div class="jinc_msgsubject">' . $subject . '</div>';
        echo '<div class="jinc_msgbody">' . $body . '</div>';

        $arr_attachment = $attachment->toArray();
        foreach ($arr_attachment as $key => $attach) {
            $link_att = JRoute::_($attach);
            if (strlen($attach)) {
                echo '<div class="jinc_attachment">';
                echo JText::_('COM_JINC_ATTACHMENT') . ': ';
                echo '<a target="_blank" href="' . $link_att . '">' . $attach . '</a>';
                echo '</div>';
            }
        }

        echo '<div class="bottom"><div class="leftbottom">';
        echo '</div></div></div></div></div>';
    }

}