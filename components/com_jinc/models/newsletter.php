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
jimport('joomla.html.pagination');

class NewslettersModelNewsletter extends JModel {

    function getMessages() {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $id = JRequest::getInt('id', 0, 'GET');
        $result = array();

        $ninstance = NewsletterFactory::getInstance();
        if ($newsletter = $ninstance->loadNewsletter($id, true)) {
            $max_msg = (int) $newsletter->get('front_max_msg');

            if ($max_msg > 0) {
                $query = 'SELECT id, subject, body, datasent, attachment ' .
                        'FROM #__jinc_message ' .
                        'WHERE news_id = ' . (int) $id . ' ' .
                        'AND UNIX_TIMESTAMP(datasent) > 0 ' .
                        'ORDER BY datasent DESC';
                $logger->debug('NewslettersModelNewsletter: Executing query: ' . $query);

                $result = $this->_getList($query, 0, $max_msg);
            }
        }

        return $result;
    }

    function getData() {
        jincimport('core.newsletterfactory');
        $id = JRequest::getInt('id', 0, 'GET');

        $ninstance = NewsletterFactory::getInstance();
        if (!($newsletter = $ninstance->loadNewsletter($id, true))) {
            $this->setError('COM_JINC_ERR017');
            return false;
        }

        $user = & JFactory::getUser();
        $canSubscribe = $user->authorise('jinc.subscribe', 'com_jinc.newsletter.' . $id);
        if (($newsletter->getType() == NEWSLETTER_PRIVATE_NEWS) && ($user->guest))
            $canSubscribe = false;

        if (!$canSubscribe) {
            $this->setError('COM_JINC_ERR017');
            return false;
        }

        return $newsletter;
    }

    function getNotice() {
        jincimport('core.newsletterfactory');
        $id = JRequest::getInt('id', 0, 'GET');

        $ninstance = NewsletterFactory::getInstance();
        if (!($newsletter = $ninstance->loadNewsletter($id, true))) {
            $this->setError('COM_JINC_ERR017');
            return false;
        }

        if (!($notice = $ninstance->loadNotice($newsletter->get('notice_id')))) {
            $this->setError('COM_JINC_ERR023');
            return false;
        }

        return $notice;
    }

    function subscribe($id, $subscriber_info, $attributes, $mod_jinc = 'false', $notices = array()) {
        $user = JFactory::getUser();
        if (!$user->authorise('jinc.subscribe', 'com_jinc.newsletter.' . $id)) {
            $this->setError('COM_JINC_ERR011');
            return false;
        }
        jincimport('core.newsletterfactory');
        $ninstance = NewsletterFactory::getInstance();
        if (!($newsletter = $ninstance->loadNewsletter($id, true))) {
            $this->setError('COM_JINC_ERR005');
            return false;
        }
        
        $notice_id = $newsletter->get('notice_id');
        if ($notice_id > 0) {
            if (!in_array($notice_id, $notices)) {
                $this->setError('COM_JINC_ERR026');
                return false;
            }
        }

        if ($newsletter->get('captcha') > CAPTCHA_NO) {
            include_once JPATH_COMPONENT . DS . 'securimage' . DS . 'securimage.php';

            $captcha_code = JRequest::getString('captcha_code', '');
            $securimage = new Securimage();
            if ($mod_jinc == 'true')
                $securimage->setSessionPrefix('mod_jinc');
            if ($securimage->check($captcha_code) == false) {
                $this->setError('COM_JINC_ERR016');
                return false;
            }
        }
        if (!($newsletter->subscribe($subscriber_info, $attributes))) {
            $this->setError($newsletter->getError());
            return false;
        }
        if ($newsletter->getType() == NEWSLETTER_PUBLIC_NEWS) {
            $this->setState('message', 'COM_JINC_INF008');
        } else {
            $this->setState('message', 'COM_JINC_INF003');
        }
        return true;
    }

    function unsubscribe($id, $subscriber_info) {
        jincimport('core.newsletterfactory');

        $ninstance = NewsletterFactory::getInstance();
        if (!($newsletter = $ninstance->loadNewsletter($id, true))) {
            $this->setError('COM_JINC_ERR017');
            return false;
        }
        if (!($newsletter->unsubscribe($subscriber_info))) {
            $this->setError('COM_JINC_ERR021');
            return false;
        }
        if ($newsletter->getType() == NEWSLETTER_PUBLIC_NEWS) {
            $this->setState('message', 'COM_JINC_INF004');
        } else {
            $this->setState('message', 'COM_JINC_INF005');
        }
        return true;
    }

    function confirm($id, $user_mail, $random) {
        jincimport('core.newsletterfactory');
        $ninstance = NewsletterFactory::getInstance();
        if (!$newsletter = $ninstance->loadNewsletter($id, true)) {
            $this->setError('COM_JINC_ERR020');
            return false;
        }

        if ($newsletter->getType() != NEWSLETTER_PUBLIC_NEWS) {
            $this->setError('COM_JINC_ERR020');
            return false;
        }

        $sub_info = array();
        $sub_info['email'] = $user_mail;
        $sub_info['waiting'] = false;
        if ($newsletter->isSubscribed($sub_info)) {
            $this->setError('COM_JINC_ERR015');
            return false;
        }

        if (!$newsletter->confirmSubscription($user_mail, $random)) {
            $this->setError('COM_JINC_ERR022');
            return false;
        }
        return true;
    }

    function delconfirm($id, $user_mail, $random) {
        jincimport('core.newsletterfactory');
        $ninstance = NewsletterFactory::getInstance();
        if (!$newsletter = $ninstance->loadNewsletter($id, true)) {
            $this->setError('COM_JINC_ERR020');
            return false;
        }

        if ($newsletter->getType() != NEWSLETTER_PUBLIC_NEWS) {
            $this->setError('COM_JINC_ERR020');
            return false;
        }

        if (!$newsletter->confirmUnsubscription($user_mail, $random)) {
            $this->setError('ERROR_FER004');
            return false;
        }
        return true;
    }

}
