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

class JINCModelTags extends JModel {

    function __construct() {
        parent::__construct();
    }

    /**
     * Method to get an array of data items.
     *
     * @return	mixed	An array of data items on success, false on failure.
     * @since	1.6
     */
    public function getItems() {
        $items = array();

        $news_id = JRequest::getInt('news_id', 0);        
        if ($news_id != 0) {
            jincimport('core.newsletterfactory');
            $ninstance = NewsletterFactory::getInstance();
            if ($newsletter = $ninstance->loadNewsletter($news_id, false)) {
                $items = $newsletter->getTagsList();
            }
            
        }

        $msg_id = JRequest::getInt('msg_id', 0);
        if ($msg_id != 0) {
            jincimport('core.messagefactory');
            $minstance = MessageFactory::getInstance();
            if ($message = $minstance->loadMessage($msg_id)) {
                $news_id = $message->get('news_id');
                jincimport('core.newsletterfactory');
                $ninstance = NewsletterFactory::getInstance();
                if ($newsletter = $ninstance->loadNewsletter($news_id, false)) {
                    $items = $newsletter->getTagsList();
                    if ($message->getType() == MESSAGE_TYPE_MASSIVE) {
                        unset($items['USER']);
                    }
                    unset($items['OPTIN']);
                }
            }
        }

        return $items;
    }

}

