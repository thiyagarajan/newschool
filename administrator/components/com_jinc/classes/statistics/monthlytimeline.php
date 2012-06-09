<?php
/**
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
require_once 'timeline.php';

/**
 * MonthlyTimeLine class, defining a monthly based time line.
 *
 * @package		JINC
 * @subpackage          Graphics
 * @since		0.6
 */
class MonthlyTimeLine extends TimeLine {
/**
 * Time between time values in second.
 * In case of HourlyTimeLine is 30*24*60*60 seconds.
 *
 * @var int
 */
    var $_step;

    /**
     * MonthlyTimeLine constructor
     *
     * @param timestamp $start_time Start time
     * @param timestamp $end_time End time
     */
    function MonthlyTimeLine($start_time, $end_time) {
        parent::TimeLine($start_time, $end_time);
        $this->_step = 30*24*60*60;
    }

    /**
     * Start time setter.
     *
     * @param timestamp $start_time
     */
    function setStartTime($start_time) {
        $end_time = $this->getEndTime();
        $mindiff = $this->_min_difference * $this->_step;
        if ($end_time - $start_time < $mindiff)
            $start_time = $end_time - $mindiff;
        $this->_start_time = $start_time;
    }

    /**
     * It calculates time values.
     */
    function calculate() {
        for ($i = 0 ; $i < count($this->_time_values) ; $i++) {
            array_pop($this->_time_values);
        }
        for ($time = $this->getStartTime(), $j = 0; $time <= $this->getEndTime(); $time = $time + $this->_step) {
            $this->_time_values[$j] = $time;
            if ($j == $this->getMaxDifference()) {
                $this->setEndTime($time);
                return false;
            }
            $j++;
        }
        return true;
    }

    /**
     * MySQL time format getter.
     */
    function getMySQLFormat() {
        return '%Y-%m';
    }

    /**
     * Joomla time format getter.
     */
    function getJFormat() {
        return '%Y-%m';
    }
    
    /**
     * PHP time format getter
     */
    function getPHPFormat() {
        return 'Y-m';
    }

}
?>