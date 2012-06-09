<?php

/**
 * @version		$Id: JINCSubscription.php 1-mar-2010 13.23.11 lhacky $
 * @package		plgJINCNewsSubscription
 * @subpackage
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
 * plgUserJINCSubscription class subscribing users to a newsletter at
 * registration time and unsubscribing users at unregistration time.
 *
 * @package		plgUserJINCSubscription
 * @subpackage
 * @since		0.6
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');
jimport('joomla.filesystem.file');

// Preload the JINCFactory
jimport('joomla.filesystem.file');
require_once JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_jinc' . DS . 'classes' . DS . 'factory.php';

class plgUserJINCSubscription extends JPlugin {

    /**
     * It subscribes just created user to the newsletter with on_subscription flag.
     *
     * @param array   $user   Array of user info
     * @param boolean $isnew  true if user is just created
     * @param boolean $succes true if user is created successfully
     * @param string  $msg    User creation message
     */
    public function onUserAfterSave($user, $isnew, $success, $msg) {
        if (!$success)
            return;
        if (!$isnew)
            return;

        $user_id = $user['id'];
        $user_name = $user['name'];
        $user_email = $user['email'];

        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();
        jincimport('core.newsletterfactory');
        $ninstance = NewsletterFactory::getInstance();
        if ($newslist = $ninstance->loadOnSubscriptionNewsletters()) {
            $userObj = JFactory::getUser($user_id);
            foreach ($newslist as $news_id) {
                $logger->debug('plgUserJINCSubscription: subscribing user ' . $user_id . ' to newsletter ' . $news_id);
                if ($newsletter = $ninstance->loadNewsletter($news_id, true)) {
                    if ($userObj->authorise('jinc.subscribe', 'com_jinc.newsletter.' . $news_id)) {
                        $logger->debug('plgUserJINCSubscription: subscribing user id ' . $user_id . ' to newsletter ' . $news_id);
                        $subscriber_info = array('user_id' => $user_id,
                            'email' => $user_email, 'name' => $user_name,
                            'noptin' => true);
                        $lang = JFactory::getLanguage();
                        $lang->load('plg_jinc_subscription', JPATH_ADMINISTRATOR);                        
                        $newsletter->subscribe($subscriber_info);
                    } else {
                        $logger->debug('plgUserJINCSubscription: user id ' . $user_id . ' not authorized to subscibe newsletter ' . $news_id);
                    }
                }
            }
        }
    }

    /**
     * It ussubscribes just deleted user from every newsletters.
     *
     * @param array   $user   Array of user info
     * @param boolean $succes true if user is created successfully
     * @param string  $msg    User deletion message
     */
    public function onUserAfterDelete($user, $succes, $msg) {
        if (!$succes)
            return;

        $user_id = $user['id'];
        $user_email = $user['email'];

        jincimport('core.newsletterfactory');
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $query = 'SELECT id FROM #__jinc_newsletter n ' .
                'WHERE type = ' . (int) NEWSLETTER_PRIVATE_NEWS;

        $logger->debug('plgUserJINCSubscription: Executing query: ' . $query);
        $dbo = & JFactory::getDBO();
        $dbo->setQuery($query);
        // Unsubscribing user from every JINC newsletter
        if ($result = $dbo->loadAssocList()) {
            foreach ($result as $row) {
                $news_id = (int) $row['id'];
                $ninstance = NewsletterFactory::getInstance();
                if ($newsletter = $ninstance->loadNewsletter($news_id, false)) {
                    $subscriber_info = array('user_id' => $user_id);
                    $newsletter->unsubscribe($subscriber_info);
                }
            }
        }
    }

}

?>
