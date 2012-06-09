<?php
/**
 * @version		$Id: sentevent.php 4-feb-2010 10.07.00 lhacky $
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
require_once 'statisticalevent.php';

 /**
 * SentEvent class, defining an message sending statistical event.
 *
 * @package		JINC
 * @subpackage          Statistics
 * @since		0.6
 */

class SentEvent extends StatisticalEvent {
    /**
     * Constructor setting subscription type as type of statistics
     *
     * @access	protected
     */
    function __construct(& $subject) {
        parent::__construct($subject);
        $this->_type = STATISTICALEVENT_SENT_TYPE;
    }

    function jinc_sent() {
        return ;
    }
}
?>
