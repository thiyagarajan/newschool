<?php

/**
 * @version		$Id: sentmsgevent.php 2-feb-2010 17.03.28 lhacky $
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
 * SentMsgEvent class, generating and managing sending message events.
 * It is an observer in the Observer Pattern.
 *
 * @package		JINC
 * @subpackage          Core
 * @since		0.6
 */
class SentMsgEvent extends JEvent {

    /**
     * Constructor
     *
     * @access	protected
     */
    function __construct(& $subject) {
        parent::__construct($subject);
    }

    /**
     * Update method to register message sending events.
     *
     * @access	public
     * @param $args['news_id'] Newsletter identifier refferring to the event.
     * * @param $args['msg_id'] Message identifier refferring to the event.
     * @return  false if something wrong.
     * @since	0.6
     */
    function update(&$args) {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        if (!isset($args['news_id']) || (!isset($args['msg_id'])))
            return false;

        $news_id = (int) $args['news_id'];
        $msg_id = (int) $args['msg_id'];

        $dbo = & JFactory::getDBO();
        $query = 'UPDATE #__jinc_newsletter SET lastsent = now() ' .
                'WHERE id = ' . (int) $news_id;
        $dbo->setQuery($query);
        $logger->debug('SentMsgEvent: executing query: ' . $query);
        if (!$dbo->query()) {
            $logger->error('SentMsgEvent: error updating last newsletter dispatch date');
            return false;
        }

        $query = 'UPDATE #__jinc_message SET datasent = now() ' .
                'WHERE id = ' . (int) $msg_id;
        $dbo->setQuery($query);
        $logger->debug('SentMsgEvent: executing query: ' . $query);
        if (!$dbo->query()) {
            $logger->error('SentMsgEvent: error updating last message dispatch date');
            return false;
        }
        return true;
    }

    function jinc_sent() {
        return;
    }

}

?>
