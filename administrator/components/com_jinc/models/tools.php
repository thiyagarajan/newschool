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
jimport('joomla.application.component.model');

JTable::addIncludePath(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_jinc' . DS . 'tables');

class JINCModelTools extends JModel {

    function __construct() {
        parent::__construct();
    }

    function loadMessages($news_private_id, $news_public_id) {
        $msg_private = & JTable::getInstance('message', 'Table');
        $data = array();
        $data['news_id'] = $news_private_id;
        $data['subject'] = 'Secret message';
        $data['body'] = '<table style=\"height: 356px;\" align=\"center\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" width=\"530\"><tbody style=\"text-align: left;\"><tr style=\"text-align: left;\"><td style=\"text-align: left; background-color: #b09fcf; width: 644px;\"><p> </p><p style=\"text-align: center;\"><strong><em>[NEWSLETTER]</em></strong></p><p> </p></td></tr><tr style=\"text-align: left;\"><td style=\"text-align: left; background-color: #eee7f7; width: 644px;\" valign=\"top\"><p><img alt=\"articles\" src=\"images/stories/articles.jpg\" height=\"64\" width=\"526\" /></p><p> </p><p>Dear [USERNAME],</p><p> </p><p>Here is our little secret ... </p><p> </p><p> </p><p>Kind Regards,</p><p> </p><p>The staff.</p><p> </p><p> </p><p> </p></td></tr></tbody></table>';
        $data['attachment'] = '';
        $data['plaintext'] = 0;
        $data['bulkmail'] = 0;
        $data['bulkdatasentmail'] = '0000-00-00 00:00:00';

        if (!$msg_private->bind($data)) {
            return false;
        }

        if (!$msg_private->store()) {
            return false;
        }

        $msg_public = & JTable::getInstance('message', 'Table');
        $data = array();
        $data['news_id'] = $news_public_id;
        $data['subject'] = 'Hello everybody !!!';
        $data['body'] = '<div align=\"center\" style=\"font-family: Arial,Helvetica,sans-serif; font-size: 18px; background-color: #ffff33\"> </div><div align=\"center\" style=\"font-family: Arial,Helvetica,sans-serif; font-size: 18px; text-decoration: underline; background-color: #ffff33\">New Message from [NEWSLETTER]</div><div align=\"center\" style=\"font-family: Arial,Helvetica,sans-serif; font-size: 18px; background-color: #ffff33\"> </div><div align=\"center\" style=\"font-family: Arial,Helvetica,sans-serif; font-size: 14px; background-color: #ffffcc\"> </div><div style=\"font-family: Arial,Helvetica,sans-serif; font-size: 14px; background-color: #ffffcc\"> </div><div style=\"font-family: Arial,Helvetica,sans-serif; font-size: 14px; background-color: #ffffcc\">Put your message here. <br /></div><div style=\"font-family: Arial,Helvetica,sans-serif; font-size: 14px; background-color: #ffffcc\"> </div><div style=\"font-family: Arial,Helvetica,sans-serif; font-size: 14px; background-color: #ffffcc\"> </div><div align=\"center\" style=\"font-size: 9px; background-color: #ffff66\">Message sent using JINC. <br /></div><div style=\"background-color: #ffffff\"> </div>';
        $data['attachment'] = '';
        $data['plaintext'] = 0;
        $data['bulkmail'] = 1;
        $data['bulkdatasentmail'] = '0000-00-00 00:00:00';

        if (!$msg_public->bind($data)) {
            return false;
        }

        if (!$msg_public->store()) {
            return false;
        }

        return true;
    }

    function loadTemplate() {
        $template = & JTable::getInstance('template', 'Table');
        $date = JFactory::getDate();
        $now = $date->toMySQL();
        $data = array();
        $data['name'] = 'Test Template';
        $data['subject'] = 'Test Template Subject';
        $data['body'] = '<table style=\"height: 356px;\" align=\"center\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" width=\"530\"><tbody style=\"text-align: left;\"><tr style=\"text-align: left;\"><td style=\"text-align: left; background-color: #b09fcf; width: 644px;\"><p> </p><p style=\"text-align: center;\"><strong><em>[NEWSLETTER]</em></strong></p><p> </p></td></tr><tr style=\"text-align: left;\"><td style=\"text-align: left; background-color: #eee7f7; width: 644px;\" valign=\"top\"><p><img alt=\"articles\" src=\"images/stories/articles.jpg\" height=\"64\" width=\"526\" /></p><p> </p><p>Dear [USERNAME],</p><p> </p><p>Message ...</p><p> </p><p> </p><p>Kind Regards,</p><p> </p><p>The staff.</p><p> </p><p> </p><p> </p></td></tr></tbody></table>';
        if (!$template->bind($data)) {
            return false;
        }

        if (!$template->store()) {
            return false;
        }

        return $template->get('id');
    }

    function loadPrivateNewsletter($tem_id) {
        $news_private = & JTable::getInstance('newsletter', 'Table');

        $date = JFactory::getDate();
        $now = $date->toMySQL();
        $data = array();
        $data['type'] = 2;
        $data['name'] = 'Private news for elected people';
        $data['description'] = 'Private news for selected Joomla! users.';
        $data['published'] = 1;
        $data['created'] = $now;
        $data['lastsent'] = '0000-00-00 00:00:00';
        $data['sendername'] = 'Sample sender';
        $data['senderaddr'] = 'sample@sample.org';
        $data['welcome_subject'] = 'Your subscription to our newletter';
        $data['welcome'] = '<p>Dear subscriber,</p><p>your mail [EMAIL] has been subscribed to our newsletter: [NEWSLETTER]</p>Bye, The Staff.';
        $data['welcome_created'] = '<p>Dear subscriber,</p><p>your mail [EMAIL] has been subscribed to our newsletter: [NEWSLETTER]</p>Bye, The Staff.';
        $data['optin_subject'] = '';
        $data['optin'] = '';
        $data['optinremove_subject'] = '';
        $data['optinremove'] = '';
        $data['disclaimer'] = '';
        $data['default_template'] = $tem_id;

        if (!$news_private->bind($data)) {
            return false;
        }

        if (!$news_private->store()) {
            return false;
        }

        return $news_private->get('id');
    }

    function loadPublicNewsletter($tem_id) {
        $news_public = & JTable::getInstance('newsletter', 'Table');

        $date = JFactory::getDate();
        $now = $date->toMySQL();
        $data = array();
        $data['type'] = 0;
        $data['name'] = 'News for everyone !!';
        $data['description'] = 'Public newsletter accessible by everyone ... also simple guests.';
        $data['published'] = 1;
        $data['created'] = $now;
        $data['lastsent'] = '0000-00-00 00:00:00';
        $data['sendername'] = 'Sample sender';
        $data['senderaddr'] = 'sample@sample.org';
        $data['welcome_subject'] = 'Your subscription to our newletter';
        $data['welcome'] = '<p>Dear subscriber,</p><p>your mail [EMAIL] has been subscribed to our newsletter: [NEWSLETTER]</p>Bye, The Staff.';
        $data['welcome_created'] = '<p>Dear subscriber,</p><p>your mail [EMAIL] has been subscribed to our newsletter: [NEWSLETTER]</p>Bye, The Staff.';
        $data['optin_subject'] = JText::_('COM_JINC_OPTIN_SUBJECT_DEFAULT');
        $data['optin'] = JText::_('COM_JINC_OPTIN_DEFAULT');
        $data['optinremove_subject'] = JText::_('COM_JINC_OPTINREMOVE_SUBJECT_DEFAULT');
        $data['optinremove'] = JText::_('COM_JINC_OPTINREMOVE_DEFAULT');
        $data['disclaimer'] = '';
        $data['default_template'] = $tem_id;
        $rules = '{"jinc.subscribe":{"1":1},"jinc.send":[],"core.edit":[]}';
        $news_public->setRules($rules);
        
        if (!$news_public->bind($data)) {
            return false;
        }

        if (!$news_public->store()) {
            return false;
        }

        return $news_public->get('id');
    }

    function loadSampleData() {
        if (!($tem_id = $this->loadTemplate())) {
            return false;
        }

        if (!($news_private_id = $this->loadPrivateNewsletter($tem_id))) {
            return false;
        }

        if (!($news_public_id = $this->loadPublicNewsletter($tem_id))) {
            return false;
        }
        
        return $this->loadMessages($news_private_id, $news_public_id);
    }

    function loadSampleStatisticalData() {
        if (!($tem_id = $this->loadTemplate())) {
            return false;
        }

        if (!($news_private_id = $this->loadPrivateNewsletter($tem_id))) {
            return false;
        }

        if (!($news_public_id = $this->loadPublicNewsletter($tem_id))) {
            return false;
        }
        
        if (!($this->loadMessages($news_private_id, $news_public_id))) {
            return false;
        }
                
        $dbo = & $this->getDBO();
        $now = JFactory::getDate();
        for ($i = 0; $i < 60; $i++) {
            $num = (int) rand(15, 50);
            for ($j = 0; $j < $num; $j++) {
                $d = new JDate($now->toUNIX() - $i * 24 * 60 * 60 + rand(0, 24 * 60) * 60);
                $query = "INSERT INTO #__jinc_stats_event (type, date, news_id) " .
                        "VALUES (0, '" . $d->toMySQL() . "', $news_private_id)";
                $dbo->setQuery($query);
                if (!$dbo->query()) {
                    $this->setError($dbo->getErrorMsg() . ': ' . $query);
                    return false;
                }
            }
            $num = (int) rand(5, 15);
            for ($j = 0; $j < $num; $j++) {
                $d = new JDate($now->toUNIX() - $i * 24 * 60 * 60 + rand(0, 24 * 60) * 60);
                $query = "INSERT INTO #__jinc_stats_event (type, date, news_id) " .
                        "VALUES (1, '" . $d->toMySQL() . "', $news_private_id)";
                $dbo->setQuery($query);
                if (!$dbo->query()) {
                    $this->setError($dbo->getErrorMsg() . ': ' . $query);
                    return false;
                }
            }

            $num = (int) rand(15, 50);
            for ($j = 0; $j < $num; $j++) {
                $d = new JDate($now->toUNIX() - $i * 24 * 60 * 60 + rand(0, 24 * 60) * 60);
                $query = "INSERT INTO #__jinc_stats_event (type, date, news_id) " .
                        "VALUES (0, '" . $d->toMySQL() . "', $news_public_id)";
                $dbo->setQuery($query);
                if (!$dbo->query()) {
                    $this->setError($dbo->getErrorMsg() . ': ' . $query);
                    return false;
                }
            }
            $num = (int) rand(5, 15);
            for ($j = 0; $j < $num; $j++) {
                $d = new JDate($now->toUNIX() - $i * 24 * 60 * 60 + rand(0, 24 * 60) * 60);
                $query = "INSERT INTO #__jinc_stats_event (type, date, news_id) " .
                        "VALUES (1, '" . $d->toMySQL() . "', $news_public_id)";
                $dbo->setQuery($query);
                if (!$dbo->query()) {
                    $this->setError($dbo->getErrorMsg() . ': ' . $query);
                    return false;
                }
            }
        }

        return true;
    }

    function cleanRemovedData() {
        
    }

}

?>
