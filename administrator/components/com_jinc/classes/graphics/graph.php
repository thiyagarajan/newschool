<?php
/**
 * @package		JINC
 * @subpackage          Graphics
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
 * Graph class, defining a graphical object and its generic object graph.
 *
 * @package		JINC
 * @subpackage          Graphics
 * @since		0.6
 */
class Graph {
/**
 * Distance from left margin
 *
 * @access private
 * @var integer X Margin
 */
    var $_x_margin;

    /**
     * Distance from top margin
     *
     * @access private
     * @var integer Y Margin
     */
    var $_y_margin;

    /**
     * Background color. Red intensity.
     *
     * @access private
     * @var integer BGColor red intensity
     */

    var $_r_color;
    /**
     * Background color. Green intensity.
     *
     * @access private
     * @var integer BGColor green intensity
     */
    var $_g_color;

    /**
     * Background color. Blue intensity.
     *
     * @access private
     * @var integer BGColor blue intensity
     */
    var $_b_color;

    /**
     * Border size.
     *
     * @access private
     * @var integer Border size
     */
    var $_size;

    /**
     * Graph class contructor
     *
     * @return Graph
     */
    function Graph() {
        $this->_x_margin = 0;
        $this->_y_margin = 0;
        $this->_r_color = 0;
        $this->_g_color = 0;
        $this->_b_color = 0;
        $this->_size = 0;
    }

    /**
     * Distance from left margin getter
     *
     * @return integer Distance from left margin
     */
    function getXMargin() {
        return $this->_x_margin;
    }

    /**
     * Distance from left margin setter
     *
     * @param integer $x Distance from left margin
     */
    function setXMargin($x) {
        $this->_x_margin = $x;
    }

    /**
     * Distance from top margin getter
     *
     * @return integer Distance from top margin
     */
    function getYMargin() {
        return $this->_y_margin;
    }

    /**
     * Distance from top margin setter
     *
     * @param integer $y Distance from top margin
     */
    function setYMargin($y) {
        $this->_y_margin = $y;
    }

    /**
     * Size getter
     *
     * @return integer size
     */
    function getSize() {
        return $this->_size;
    }

    /**
     * Border size setter
     *
     * @param integer $s border size
     */
    function setSize($s) {
        $this->_size = (int) $s;
    }

    /**
     * Background color setter
     *
     * @param integer $r Red intensity.
     * @param integer $g Green intensity.
     * @param integer $b Blue intensity.
     */
    function setColor($r, $g, $b) {
        $this->_r_color = (int) $r;
        $this->_g_color = (int) $g;
        $this->_b_color = (int) $b;
    }

    /**
     * Method to display graphical objects that inheriting class must implement.
     * This is an abstract method.
     *
     * @param Graph $container
     * @param integer $x_margin
     * @param integer $y_margin
     * @return false if something wrong
     * @abstract
     */
    function display($container, $x_margin = 0, $y_margin = 0) {
        die('Graph class: display( ... ) is an abstract method');
    }
}
?>
