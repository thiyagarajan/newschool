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
require_once 'container.php';

/**
 * GPolygon class, defining a graphical polygon.
 * It display a polygon using GD functionalities.
 *
 * @package		JINC
 * @subpackage          Graphics
 * @since		0.6
 */
class GPolygon extends Graph {
/**
 * Polygon coordinates
 *
 * @var array
 */
    var $_coordinates;

    /**
     * GPolygon constructor.
     *
     * @param array $values Polygon coordinates
     */
    function GPolygon($values = array()) {
        parent::Graph();
        $this->setCoordinates($values);
    }

    /**
     * Polygon coordinates setter.
     *
     * @param array $coordinates
     */
    function setCoordinates($coordinates) {
        $this->_coordinates = $coordinates;
    }

    /**
     * Method displaying the graphical polygon.
     *
     * @param Container $container Image in which display the element
     * @param int $x_margin left margin
     * @param int $y_margin top margin
     * @return false if something wrong
     */
    function display($container, $x_margin = 0, $y_margin = 0) {
        $image = $container->getImage();
        $color = imagecolorallocate($image, $this->_r_color, $this->_g_color, $this->_b_color);
        $x_margin =  $this->_x_margin + $x_margin;
        $y_margin =  $this->_y_margin + $y_margin;

        $values = array();
        for ($i = 0; $i < count($this->_coordinates); $i = $i + 2) {
            $values[$i] = $this->_coordinates[$i] + $x_margin;
            $values[$i+1] = $this->_coordinates[$i+1] + $y_margin;
        }
        return imagefilledpolygon($image, $values, count($values) / 2, $color);
    }
}
?>
