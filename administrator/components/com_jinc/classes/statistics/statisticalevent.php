<?php
/**
 * @version		$Id: statisticalevent.php 2-feb-2010 17.03.28 lhacky $
 * @package		JINC
 * @subpackage          Statistics
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

define('STATISTICALEVENT_SUB_TYPE', 0);
define('STATISTICALEVENT_UNSUB_TYPE', 1);
define('STATISTICALEVENT_SENT_TYPE', 2);

/**
 * StatisticalEvent class, generating and managing statistical events.
 * It is an observer in the Observer Pattern.
 *
 * @package		JINC
 * @subpackage          Statistics
 * @since		0.6
 */
class StatisticalEvent extends JEvent {

   /*
    * Statistical type. It could be $SENT_TYPE, $SUB_TYPE, $UNSUB_TYPE.
    *
    * @var         Message sending event
    * @access	protected
    * @since	0.6
    */
    var $_type;

    /**
     * Constructor
     *
     * @access	protected
     */
    function __construct(& $subject) {
        parent::__construct($subject);
        $this->_type = -1;
    }

    /**
     * Update method to register statistical events.
     *
     * @access	public
     * @param $args['news_id'] Newsletter identifier refferring to the event.
     * @return  false if something wrong.
     * @since	0.6
     */

    function update(&$args) {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        if (($this->_type < 0) || (! isset ($args['news_id']))) return false;

        $query = 'INSERT INTO `#__jinc_stats_event` ' .
            '(`type`, `date`, `news_id`) VALUES ' .
            '(' . (int) $this->_type . ', now(), ' . (int) $args['news_id'] . ')';
        $logger->debug('StatisticalEvent: Executing query: ' . $query);
        $dbo =& JFactory::getDBO();
        $dbo->setQuery($query);
        if ( ! $dbo->query() ) return false;
        return true;
    }
}
?>
