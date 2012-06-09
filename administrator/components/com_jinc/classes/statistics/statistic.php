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
 * Statistic class, defining a generic statistic.
 *
 * @package		JINC
 * @subpackage          Graphics
 * @since		0.6
 */
class Statistic {
    /**
     * Statistic timeline
     *
     * @var TimeLine
     */
    var $_timeline;

    /**
     * Statistic values
     *
     * @var array
     */
    var $_values;

    /**
     * Statistic constructor
     *
     * @param TimeLine $timeline Statistic time line
     */
    function Statistic($timeline) {
        $this->_timeline = $timeline;
        $this->_values = array();
    }

    /**
     * Statistic time line getter.
     *
     * @return TimeLine
     */
    function getTimeLine() {
        return $this->_timeline;
    }

    /**
     * Statistic values getter.
     *
     * @param boolean $perform It gets values from DB again if set to true.
     * @return array
     */
    function getValues($perform = false) {
        if ($perform || count($this->_values) == 0) {
            $this->perform();
        }
        return array_values($this->_values);
    }

    /**
     * Time values getter.
     *
     * @param boolean $perform I calculates again time values if set to true.
     * @return <type>
     */
    function getTimeValues($perform = false) {
        if ($perform || count($this->_values) == 0) {
            $this->perform();
        }
        return array_keys($this->_values);
    }

    /**
     * It cleans Statistic values and Statistics time values.
     *
     * @param int $value Cleaned value
     */
    function clean($value = 0) {
        $timeline = $this->getTimeLine();
        for ($i = 0 ; $i < count($this->_values) ; $i++) {
            array_pop($this->_values);
        }

        for ($i = 0 ; $i < $timeline->count() ; $i++) {
            $time = $timeline->get($i);
            $index = date($timeline->getPHPFormat(), $time);
            $this->_values[$index] = $value;
        }
    }

    /**
     * It performs the Statistic
     *
     * @abstract
     */
    function perform() {
        die('Statistic class: perform() is an abstract method');
    }
}
?>