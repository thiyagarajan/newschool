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
 * Requiring PHP libraries and defining constants
 */
require_once 'graph.php';

/**
 * CompositeGraph class defining a graphical elements containing other graph
 * elements.
 *
 * It play the Composite role in Composite Design Pattern.
 *
 * @package JINC
 * @subpackage Graphics
 * @since 0.6
 */
class CompositeGraph extends Graph {
    /**
     * Array of elements composing the CompositeGraph
     *
     * @var array Elements composing the Graph
     */
    var $_elements;

    /**
     * CompositeGraph constructor.
     */
    function CompositeGraph() {
        $this->_elements = array();
    }

    /**
     * Add a graphical element
     *
     * @param Graph $element Graphical element
     */
    function addElement($element) {
        array_push($this->_elements, $element);
    }

    /**
     * Predisplay function
     *
     * @return void
     */
    function prepare() {
        return ;
    }

    /**
     * Method displaying the graphical elements contained in the CompositeGraph.
     *
     * @param Container $container Image in which display the element
     * @param int $x_margin left margin
     * @param int $y_margin top margin
     * @return false if something wrong
     */
    function display($container, $x_margin = 0, $y_margin = 0) {
        $this->prepare();
        $ret = true;
        foreach ($this->_elements as $element) {
            $x = $this->_x_margin + $x_margin;
            $y = $this->_y_margin + $y_margin;
            $ret = $ret && $element->display($container, $x, $y);
        }
        return $ret;
    }
}
?>
