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
 * GSegment class, defining a graphical segment.
 * It display a segment using GD functionalities.
 *
 * @package		JINC
 * @subpackage          Graphics
 * @since		0.6
 */
class GSegment extends Graph {
/**
 * First point. X value.
 *
 * @var int
 */
    var $_x1;

    /**
     * First point. Y value.
     *
     * @var int
     */
    var $_y1;
    
    /**
     * Second point. X value.
     * 
     * @var int
     */    
    var $_x2;

    /**
     * Second point. Y value.
     * @var int
     */
    var $_y2;

    /**
     * GSegment constructor.
     */
    function GSegment() {
        parent::Graph();
    }

    /**
     * Segment coordinates setter.
     *
     * @param integer $x1
     * @param integer $y1
     * @param integer $x2
     * @param integer $y2
     */
    function setCoordinates($x1, $y1, $x2, $y2) {
        $this->_x1 = (int) $x1;
        $this->_y1 = (int) $y1;
        $this->_x2 = (int) $x2;
        $this->_y2 = (int) $y2;
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
        $x1_margin =  $this->_x1 + $this->_x_margin + $x_margin;
        $y1_margin =  $this->_y1 + $this->_y_margin + $y_margin;
        $x2_margin =  $this->_x2 + $this->_x_margin + $x_margin;
        $y2_margin =  $this->_y2 + $this->_y_margin + $y_margin;

        $ret = imageline($image, $x1_margin, $y1_margin, $x2_margin, $y2_margin, $color);
        for ($i=1; $i <= $this->_size; $i++) {
            $ret = $ret && imageline($image, $x1_margin + $i, $y1_margin, $x2_margin + $i, $y2_margin, $color);
            $ret = $ret && imageline($image, $x1_margin - $i, $y1_margin, $x2_margin - $i, $y2_margin, $color);
            $ret = $ret && imageline($image, $x1_margin, $y1_margin + $i, $x2_margin, $y2_margin + $i, $color);
            $ret = $ret && imageline($image, $x1_margin, $y1_margin - $i, $x2_margin, $y2_margin - $i, $color);
        }
        return $ret;
    }
}
?>
