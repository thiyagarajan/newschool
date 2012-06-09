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

class NewslettersControllerNewsletter extends NewslettersController {

    function __construct() {
        parent::__construct();
    }

    function subscribe() {
        JRequest::checkToken() or die('Invalid Token');
        $id = JRequest::getInt('id', 0, 'POST');        
        $mod_jinc = JRequest::getString('mod_jinc', 'false', 'POST');
        $attributes = JRequest::getVar('attrs', null, 'post', 'array');
        $notices = JRequest::getVar('notice', array(), 'POST', 'array');
        $user_mail = isset ($attributes['user_mail'])?$attributes['user_mail']:'';

        $info = array();
        $user = JFactory::getUser();
        if (!$user->guest)
            $info['user_id'] = $user->get('id');
        if (strlen($user_mail) > 0)
            $info['email'] = $user_mail;

        $model = $this->getModel('newsletter');
        $gateway =& $this->getView('gateway', 'html');
        if ($model->subscribe($id, $info, $attributes, $mod_jinc, $notices)) {
            $gateway->assignRef('msg', $model->getState('message'));
        } else {
            $gateway->assignRef('msg', $model->getError());
            $gateway->setLayout('error');
        }
        $gateway->display();
    }

    function unsubscribe() {
        JRequest::checkToken() or die('Invalid Token');
        $id = JRequest::getInt('id', 0, 'POST');
        $user_mail = JRequest::getString('user_mail', '', 'POST');
        $info = array();
        $user = JFactory::getUser();
        if (!$user->guest)
            $info['user_id'] = $user->get('id');
        if (strlen($user_mail) > 0)
            $info['email'] = $user_mail;

        $model = $this->getModel('newsletter');
        $gateway =& $this->getView('gateway', 'html');
        if ($model->unsubscribe($id, $info)) {
            $gateway->assignRef('msg', $model->getState('message'));
        } else {
            $gateway->assignRef('msg', $model->getError());
            $gateway->setLayout('error');
        }
        $gateway->display();
    }

    function confirm() {
        $id = JRequest::getInt('id', 0);
        $user_mail = JRequest::getString('user_mail', '');
        $random = JRequest::getString('random', '');

        $model = $this->getModel('newsletter');

        $model = $this->getModel('newsletter');
        $gateway =& $this->getView('gateway', 'html');
        if ($model->confirm($id, $user_mail, $random)) {
            $msg = 'COM_JINC_INF001';
            $gateway->assignRef('msg', $msg);
        } else {
            $gateway->assignRef('msg', $model->getError());
            $gateway->setLayout('error');
        }
        $gateway->display();
    }

    function delconfirm() {
        $id = JRequest::getInt('id', 0);
        $user_mail = JRequest::getString('user_mail', '');
        $random = JRequest::getString('random', '');

        $model = $this->getModel('newsletter');

        $model = $this->getModel('newsletter');
        $gateway =& $this->getView('gateway', 'html');
        if ($model->delconfirm($id, $user_mail, $random)) {
            $msg = 'COM_JINC_INF006';
            $gateway->assignRef('msg', $msg);
        } else {
            $gateway->assignRef('msg', $model->getError());
            $gateway->setLayout('error');
        }
        $gateway->display();
    }

    function multisubscribe() {
        JRequest::checkToken() or die('Invalid Token');
        $cid = JRequest::getVar('cid', array(), 'POST', 'array');
        $mod_jinc = JRequest::getString('mod_jinc', 'false', 'POST');
        $attributes = JRequest::getVar('attrs', null, 'post', 'array');
        $user_mail = isset ($attributes['user_mail'])?$attributes['user_mail']:'';
        $notices = JRequest::getVar('notice', array(), 'POST', 'array');

        $info = array();
        $user = JFactory::getUser();
        if (!$user->guest)
            $info['user_id'] = $user->get('id');
        if (strlen($user_mail) > 0)
            $info['email'] = $user_mail;

        $model = $this->getModel('newsletter');
        $mmsg = array();
        foreach ($cid as $id) {
            if ($model->subscribe($id, $info, $attributes, $mod_jinc, $notices)) {
                $mmsg[$id] = $model->getState('message');
            } else {
                $mmsg[$id] = $model->getError();
            }            
        }
        $view =& $this->getView('gateway', 'html');
        $view->setLayout('multisubscription');
        $view->assignRef('mmsg', $mmsg);
        $view->display();
    }
}
?>