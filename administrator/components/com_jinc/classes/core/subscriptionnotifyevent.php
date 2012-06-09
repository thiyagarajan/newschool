<?php
/**
 * @version		$Id: subscriptionnotifyevent.php 1-nov-2010 17.03.28 lhacky $
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
jimport('joomla.base.observer');
jimport('joomla.base.event');

/**
 * SubscriptionNotifyEvent class, generating and managing subscription notify
 * event.
 * It is an observer in the Observer Pattern.
 *
 * @package		JINC
 * @subpackage          Core
 * @since		0.8
 */

class SubscriptionNotifyEvent extends JEvent {
/**
 * Constructor
 *
 * @access	protected
 */
    function __construct(& $subject) {
        parent::__construct($subject);
    }

    /**
     * Update method to register subscription notify event.
     *
     * @access	public
     * @param $args['news_name'] Newsletter name refferring to the event.
     * @param $args['subs_name'] Name of the subscriber just registered.
     * @return  false if something wrong.
     * @since	0.8
     */

    function update(&$args) {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        if (isset($args['news_notify']) &&  $args['news_notify']) {
            $logger->finer('SubscriptionNotifyEvent: Notifying subscription for ' . $args['news_name']);
            if (! isset($args['subs_name']) || (! isset($args['news_name'])))
                return false;

            $news_name = $args['news_name'];
            $subs_name = $args['subs_name'];

            $dbo = & JFactory::getDBO();
            //get all super administrator

            $query = 'SELECT name, email, sendEmail FROM `#__users` u INNER JOIN ' .
                '`#__user_usergroup_map` m on u.id = m.user_id INNER JOIN ' .
                '`#__usergroups` g on m.group_id = g.id ' .
                'WHERE lower(g.title) = "super users"';

            $logger->debug('SubscriptionNotifyEvent: executing query: ' . $query);
            $dbo->setQuery( $query );
            if ($rows = $dbo->loadObjectList()) {
                // Sending notification to all administrators
                $subject = sprintf ( JText::_( 'COM_JINC_MAIL_NOTIFY_SUBJECT' ), $news_name);
                $subject = html_entity_decode($subject, ENT_QUOTES);

                foreach ( $rows as $row ) {
                    if ($row->sendEmail) {
                        $body = sprintf ( JText::_( 'COM_JINC_MAIL_NOTIFY_BODY' ), $row->name, $news_name, $subs_name);
                        $body = html_entity_decode($body, ENT_QUOTES);

                        $message = & JFactory::getMailer();
                        $message->setSubject($subject);
                        $message->setBody($body);
                        $message->addRecipient($row->email);
                        $logger->finer('SubscriptionNotifyEvent: Sending notification mail to ' . $row->email);
                        $message->send();
                    }
                }
            }
        }
        return true;
    }

    function jinc_subscribe() {
        return ;
    }
}
?>
