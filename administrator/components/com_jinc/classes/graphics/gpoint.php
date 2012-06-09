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
 * GPoint class, defining a graphical point.
 * It displays a point using GD functionalities.
 *
 * @package		JINC
 * @subpackage          Graphics
 * @since		0.6
 */
class GPoint extends Graph {
    /**
     * Point coordinate. X value.
     *
     * @var int
     */
    var $_x1;

    /**
     * Point coordinate. Y value.
     *
     * @var int
     */
    var $_y1;

    /**
     * GPoint constructor.
     */
    function GPoint() {
        parent::Graph();
        $this->_size = 7;
    }

    /**
     * Point coordinates setter.
     *
     * @param integer $x1
     * @param integer $y1
     */
    function setCoordinates($x1, $y1) {
        $this->_x1 = (int) $x1;
        $this->_y1 = (int) $y1;
    }

    /**
     * Method displaying the graphical segment.
     *
     * @param Container $container Image in which display the element
     * @param int $x_margin left margin
     * @param int $y_margin top margin
     * @return false if something wrong
     */
    function display($container, $x_margin = 0, $y_margin = 0) {
        $image = $container->getImage();
        $color = imagecolorallocate($image, $this->_r_color, $this->_g_color, $this->_b_color);
        // $white = imagecolorallocate($image, 255, 255, 255);
        $x1_margin =  $this->_x1 + $this->_x_margin + $x_margin;
        $y1_margin =  $this->_y1 + $this->_y_margin + $y_margin;

        // $ret = imagefilledellipse($image, $x1_margin, $y1_margin, $this->_size + 3, $this->_size + 3, $white);
        $ret = imagefilledellipse($image, $x1_margin, $y1_margin, $this->_size, $this->_size, $color);

        return $ret;
    }
}
?>
