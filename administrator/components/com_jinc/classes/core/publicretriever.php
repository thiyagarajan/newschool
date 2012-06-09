<?php

/**
 * @version		$Id: publicretriever.php 19-gen-2010 12.27.58 lhacky $
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
require_once 'subsretriever.php';

define('RETRIEVER_PUBLIC', 0);

/**
 * PublicRetriever class, retrieving subscribers info from public subscribers
 * table.
 *
 * @package		JINC
 * @subpackage          Core
 * @since		0.6
 */
class PublicRetriever extends SubsRetriever {

    /**
     * The PublicRetriever constructor
     *
     * @access	public
     * @param       integer $news_id The newsletter identifier.
     * @return	PublicRetriever
     * @since	0.6
     */
    function PublicRetriever($news_id) {
        parent::SubsRetriever($news_id);
    }

    /**
     * Gets TAGS to substitute in subscriber info.
     *
     * @access	public
     * @return	array Array of tags.
     * @since	0.6
     * @abstract
     */
    function getTagsList($attributes = array()) {
        $tags = array();
        array_push($tags, 'EMAIL');
        foreach ($attributes as $attr_name => $attr_cardinality) {
            array_push($tags, 'ATTR_' . strtoupper($attr_name));
        }
        return $tags;
    }

    /**
     * Retrieve subscribers list. It overrides the abstract method defined
     * in SubsRetriever Class, implementing a concrete method of the strategy
     * pattern.
     *
     * Hint: it starts to retrieve from the $start-th subscribers and returns
     * $multiplexer * $max_mails results, where $max_mails is the max number
     * of mails to send every step of a sending process
     *
     * @access	public
     * @param   integer $start_time The starting subscription time
     * @param   integer $start_id The starting subscriber identifier
     * @param   integer $multiplexer The limit multiplexer
     * @param   array $attributes array of attributes to retrieve: $attributes['attr_name'] = 0 | 1
     * @return	mixed   the subscribers list or false if something wrong.
     * @since	0.6
     */
    function getSubscribersList($start_time = 0, $start_id = 0, $multiplexer = 1, $attributes = null) {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $logger->finer('PublicRetriever: Start time ' . $start_time . ' Start id ' . $start_id . ' Multiplexer ' . $multiplexer);
        jincimport('utility.parameterprovider');
        $max_mails = ParameterProvider::getMaxXStep();

        if (is_null($attributes) || !is_array($attributes))
            $attributes = array();

        $query = 'SELECT s.email as email, ' .
                'UNIX_TIMESTAMP(s.datasub) as last_time, s.id as last_id';

        $i = 0;
        foreach ($attributes as $attr_name => $attr_value) {
            $table_name = '`#__jinc_attribute_' . $attr_name . '`';
            $table_alias = 'att' . $i;
            $query .= ', ' . $table_alias . '.value as `attr_' . $attr_name . '`';
            $i++;
        }

        $query .= ' FROM #__jinc_newsletter n ' .
                'LEFT JOIN #__jinc_subscriber s ON s.news_id = n.id ';

        $i = 0;
        foreach ($attributes as $attr_name => $attr_value) {
            $table_name = '`#__jinc_attribute_' . $attr_name . '`';
            $table_alias = 'att' . $i;
            $query .= ' LEFT JOIN ' . $table_name . ' ' . $table_alias .
                    ' ON s.id = ' . $table_alias . '.id AND n.id = ' . $table_alias . '.news_id ';
            $i++;
        }

        $query .= 'WHERE n.id = ' . (int) $this->getNewsId() . ' ' .
                'AND (s.random = \'\' OR s.random IS NULL) ' .
                'AND ( UNIX_TIMESTAMP(s.datasub) > ' . (int) $start_time . ' ' .
                'OR (UNIX_TIMESTAMP(s.datasub) = ' . (int) $start_time . ' AND s.id > ' . (int) $start_id . ') ) ' . ' ' .
                'ORDER BY s.datasub, s.id ' .
                'LIMIT 0, ' . $max_mails * $multiplexer;

        $dbo = & JFactory::getDBO();
        $dbo->setQuery($query);
        $logger->debug('PublicRetriever: executing query: ' . $query);
        return $dbo->loadAssocList();
    }

    /**
     * The method to obtain info about a single subscriber
     *
     * @access	public
     * @param   integer $id The starting subscriber identifier
     * @param   array $attributes The attribute list to load
     * @return	mixed   the subscriber or false if something wrong.
     * @since	0.9
     * @abstract
     */
    function getSubscriber($id = 0, $attributes = null) {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        if (is_null($attributes) || !is_array($attributes))
            $attributes = array();

        $query = 'SELECT random as status, s.email as email, datasub ';

        $i = 0;
        foreach ($attributes as $attr_name => $attr_value) {
            $table_name = '`#__jinc_attribute_' . $attr_name . '`';
            $table_alias = 'att' . $i;
            $query .= ', ' . $table_alias . '.value as `attr_' . $attr_name . '`';
            $i++;
        }

        $query .= ' FROM #__jinc_newsletter n ' .
                'LEFT JOIN #__jinc_subscriber s ON s.news_id = n.id ';

        $i = 0;
        foreach ($attributes as $attr_name => $attr_value) {
            $table_name = '`#__jinc_attribute_' . $attr_name . '`';
            $table_alias = 'att' . $i;
            $query .= ' LEFT JOIN ' . $table_name . ' ' . $table_alias .
                    ' ON s.id = ' . $table_alias . '.id AND n.id = ' . $table_alias . '.news_id ';
            $i++;
        }

        $query .= 'WHERE n.id = ' . (int) $this->getNewsId() . ' AND s.id = ' . (int) $id;

        $dbo = & JFactory::getDBO();
        $dbo->setQuery($query);
        $logger->debug('PublicRetriever: executing query: ' . $query);
        if ($info = $dbo->loadAssocList()) {
            return $info[0];
        }
        return false;
    }

    /**
     * Retrieve total subscribers number. It overrides the abstract method
     * defined in SubsRetriever Class, implementing a concrete method of the
     * strategy pattern.
     *
     * @access	public
     * @return	integer The total number of subscribers or -1 if something wrong.
     * @since	0.6
     */
    function countSubscribers() {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $query = 'SELECT COUNT(s.email) AS num_subs ' .
                'FROM #__jinc_newsletter n ' .
                'LEFT JOIN #__jinc_subscriber s ON n.id = s.news_id ' .
                'WHERE n.id = ' . (int) $this->getNewsId();

        $dbo = & JFactory::getDBO();
        $dbo->setQuery($query);
        $logger->debug('PublicRetriever: executing query ' . $query);
        if ($result = $dbo->loadObjectList()) {
            $nsubs = $result[0];
        } else {
            return -1;
        }
        return $nsubs->num_subs;
    }

}

?>
