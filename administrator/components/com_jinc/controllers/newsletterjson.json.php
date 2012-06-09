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

class JINCControllerNewsletterJSON extends JController {

    function __construct() {
        parent::__construct();
    }

    function createAttribute() {
        header("Content-Type: text/plain; charset=UTF-8");
        $attr_name = strtolower(JRequest::getString('attr_name', ''));
        $attr_description = JRequest::getString('attr_description', '');
        $attr_type = JRequest::getInt('attr_type', 0);
        $attr_name_i18n = strtoupper(JRequest::getString('attr_name_i18n', ''));

        $model = $this->getModel('attributes');
        echo $model->createAttribute($attr_name, $attr_description, $attr_type, $attr_name_i18n);
    }

    function removeAttribute() {
        header("Content-Type: text/plain; charset=UTF-8");
        $attr_name = strtolower(JRequest::getString('attr_name', ''));

        $model = $this->getModel('attributes');
        echo $model->removeAttribute($attr_name);
    }

    function getDefaultTemplate() {
        header("Content-Type: text/plain; charset=UTF-8");
        jincimport('core.newsletterfactory');
        jincimport('utility.jsonresponse');
        jincimport('utility.jinchtmlhelper');
        $id = JRequest::getInt('id', 0);
        $tem_id = 0;
        $tag_string = '';
        $ninstance = NewsletterFactory::getInstance();
        if ($newsletter = $ninstance->loadNewsletter($id, false)) {
            $tem_id = $newsletter->get('default_template');
        }
        // Building JSON response
        $response = new JSONResponse();
        $response->set('tem_id', (int) $tem_id);
        echo $response->toString();
    }
}

?>
