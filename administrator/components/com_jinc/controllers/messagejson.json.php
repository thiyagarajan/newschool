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

jimport('joomla.application.component.controllerform');

class JINCControllerMessageJSON extends JController {

    function __construct() {
        parent::__construct();
    }

    function send() {
        header("Content-Type: text/plain; charset=UTF-8");
        $id = JRequest::getInt('id', 0);
        $client_id = JRequest::getString('client_id', '');
        $start = JRequest::getInt('start', 0);
        $model = $this->getModel('message');

        echo $model->send($id, $client_id);
    }

    function pause() {
        header("Content-Type: text/plain; charset=UTF-8");
        $id = JRequest::getInt('id', 0);
        $model = $this->getModel('message');

        echo $model->pause($id);
    }

    function stop() {
        header("Content-Type: text/plain; charset=UTF-8");
        $id = JRequest::getInt('id', 0);
        $model = $this->getModel('message');

        echo $model->stop($id);
    }

}

?>
