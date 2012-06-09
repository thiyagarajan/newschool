<?php
/**
 * @version		$Id: subsretriever.php 19-gen-2010 12.27.58 lhacky $
 * @package		JINC
 * @subpackage		Core
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
require_once 'jincobject.php';

/**
 * SubsRetriever class, retrieving subscribers info.
 *
 * Hint: it defines the abstract methods getSubscribersList() and
 * countSubscribers() within the strategy design pattern.
 *
 * @package		JINC
 * @subpackage          Core
 * @since		0.6
 */

class SubsRetriever extends JINCObject {
/**
 * The newsletter identifier
 *
 * @var		The newsletter identifier
 * @access	protected
 * @since	0.6
 */
    var $_news_id;

    /**
     * The SubsRetriever constructor.
     *
     * @access	public
     * @param   integer $news_id The newsletter identifier.
     * @return	SubsRetriever
     * @since	0.6
     * @see     Newsletter, NewsletterFactory
     */
    function SubsRetriever($news_id = 0) {
        parent::__construct();
        $this->_news_id = (int) $news_id;

    }

    /**
     * The newsletter identifier getter
     *
     * @access	public
     * @return	The newsletter identifier
     * @since	0.6
     */

    function getNewsId() {
        return $this->_news_id;
    }

    /**
     * The abstract method to obtain the TAGS to substitute in subscriber info.
     *
     * @access	public
     * @return	array Array of tags.
     * @since	0.6
     * @abstract
     */
    function getTagsList($attributes = array()) {
        die('SubsRetriever class: getTagsList() is an abstract method');
    }

    /**
     * The abstract method to obtain subscribers list
     *
     * @access	public
     * @param   integer $start_time The starting subscription time
     * @param   integer $start_id The starting subscriber identifier
     * @param   integer $multiplexer The limit multiplexer
     * @param   array $attributes The attribute list to load
     * @return	mixed   the subscribers list or false if something wrong.
     * @since	0.6
     * @abstract
     */
    function getSubscribersList($start_time = 0, $start_id = 0, $multiplexer = 1, $attributes = null) {
        die('SubsRetriever class: getSubscribersList() is an abstract method');
    }

    /**
     * The abstract method to obtain info about a single subscriber
     *
     * @access	public
     * @param   integer $id The starting subscriber identifier
     * @param   array $attributes The attribute list to load
     * @return	mixed   the subscriber or false if something wrong.
     * @since	0.9
     * @abstract
     */
    function getSubscriber($id = 0, $attributes = null) {
        die('SubsRetriever class: getSubscriber() is an abstract method');
    }

    /**
     * The abstract method to obtain the total number of subscribers
     *
     * @access	public
     * @return	integer The total number of subscribers or -1 if something wrong.
     * @since	0.6
     * @abstract
     */
    function countSubscribers() {
        die('SubsRetriever class: countSubscribers() is an abstract method');
    }
}
?>
