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
define('TIMELINE_DEF_MAX_STEP', 60);
define('TIMELINE_DEF_MIN_STEP', 7);

/**
 * TimeLine class, defining a time line.
 * A time line has a start time, an end time and several time values within.
 * The time values are calculated at constant interval time.
 * A time line must have a number of time values between a min and a max number
 * (see TIMELINE_DEF_MIN_STEP and TIMELINE_DEF_MAX_STEP constants).
 *
 *
 * @package		JINC
 * @subpackage          Graphics
 * @since		0.6
 */
class TimeLine {
    /**
     * Start time
     * @var timestamp
     */
    var $_start_time;

    /**
     * End time
     *
     * @var timestamp
     */
    var $_end_time;

    /**
     * Minumun number of time values.
     *
     * @var int
     */
    var $_min_difference;

    /**
     * Maximum number of time values.
     *
     * @var int
     */
    var $_max_difference;

    /**
     * Calculated time values.
     *
     * @var array
     */
    var $_time_values;

    /**
     * TimeLine constructor
     *
     * @param timestamp $start_time Start time
     * @param timestamp $end_time End time
     */
    function TimeLine($start_time, $end_time) {
        $this->setMaxDifference(TIMELINE_DEF_MAX_STEP);
        $this->setMinDifference(TIMELINE_DEF_MIN_STEP);
        $this->setEndTime($end_time);
        $this->setStartTime($start_time);
    }

    /**
     * Start time getter.
     *
     * @return timestamp
     */
    function getStartTime() {
        return $this->_start_time;
    }

    /**
     * End time getter.
     *
     * @return timestamp
     */
    function getEndTime() {
        return $this->_end_time;
    }

    /**
     * End time setter.
     *
     * @param timestamp $end_time
     */
    function setEndTime($end_time) {
        if ((floatval($end_time) == 0) || floatval($end_time) > time())
            $this->_end_time = time();
        else
            $this->_end_time = $end_time;
    }

    /**
     * Min number of time values getter.
     *
     * @return int
     */
    function getMinDifference() {
        return $this->_min_difference;
    }

    /**
     * Min number of time values setter.
     *
     * @param integer $diff
     */
    function setMinDifference($diff) {
        $this->_min_difference = (int) $diff;
    }

    /**
     * Max number of time values getter.
     *
     * @return int
     */
    function getMaxDifference() {
        return $this->_max_difference;
    }

    /**
     * Max number of time values setter.
     *
     * @param integer $diff 
     */
    function setMaxDifference($diff) {
        $this->_max_difference = (int) $diff;
    }

    /**
     * It gets the i-th time value
     *
     * @param int $i
     * @return timestamp
     */
    function get($i) {
        return $this->_time_values[$i];
    }

    /**
     * Number of time values.
     *
     * @return int
     */
    function count() {
        return count($this->_time_values);
    }

    /**
     * Start time setter.
     *
     * @abstract
     * @param timestamp $start_time
     */
    function setStartTime($start_time) {
        die('TimeLine class: setStartTime() is an abstract method');
    }

    /**
     * It calculates time values.
     *
     * @abstract
     */
    function calculate() {
        die('TimeLine class: calculate() is an abstract method');
    }

    /**
     * Joomla time format getter.
     *
     * @abstract
     */
    function getJFormat() {
        die('TimeLine class: getJFormat() is an abstract method');;
    }

    /**
     * MySQL time format getter.
     *
     * @abstract
     */
    function getMySQLFormat() {
        die('TimeLine class: getMySQLFormat() is an abstract method');;
    }

    /**
     * PHP time format getter
     *
     * @abstract
     */
    function getPHPFormat() {
        die('TimeLine class: getPHPFormat() is an abstract method');;
    }

    /**
     * Left PHP time limit getter.
     *
     * @abstract
     */
    function getPHPLeftLimitFormat() {
        die('TimeLine class: getPHPLeftLimitFormat() is an abstract method');;
    }

    /**
     * Right PHP time limit getter.
     *
     * @abstract
     */
    function getPHPRightLimitFormat() {
        die('TimeLine class: getPHPLeftLimitFormat() is an abstract method');;
    }
}
?>