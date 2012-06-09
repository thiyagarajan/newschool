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
 * GString class, defining a graphical string.
 * It displays a string using GD functionalities.
 *
 * @package		JINC
 * @subpackage          Graphics
 * @since		0.6
 */
class GString extends Graph {
    /**
     * String coordinate X value.
     * 
     * @var integer
     */
    var $_x1;

    /**
     * String coordinate Y value.
     *
     * @var integer
     */
    var $_y1;

    /**
     * String text.
     *
     * @var String
     */
    var $_text;

    /**
     * String font name.
     *
     * @var String
     */
    var $_font;

    /**
     * String distance from point coordinate
     *
     * @var int
     */
    var $_distance;

    /**
     * String distance from point coordinate. X value.
     *
     * @var int
     */
    var $_x_distance;

    /**
     * String distance from point coordinate. X value.
     *
     * @var int
     */
    var $_y_distance;

    /**
     * GString constructor.
     *
     * @param String $text Text of the string
     */
    function GString($text = '') {
        $this->setText($text);
        $this->setDistance(0);
        $this->setFont(2);
    }

    /**
     * String text getter.
     *
     * @return String
     */
    function getText() {
        return $this->_text;
    }

    /**
     * String text setter.
     *
     * @param String $text
     */
    function setText($text) {
        $this->_text = $text;
    }

    /**
     * Font name getter.
     *
     * @return String
     */
    function getFont() {
        return $this->_font;
    }

    /**
     * String name setter.
     *
     * @param String $font
     */
    function setFont($font) {
        $this->_font = (int) $font;
    }

    /**
     * String distance from point coordinate getter.
     *
     * @return integer
     */
    function getDistance() {
        return $this->_distance;
    }

    /**
     * String distance from point coordinate setter.
     *
     * @param integer $distance
     */
    function setDistance($distance) {
        $this->_x_distance = $distance;
        $this->_y_distance = $distance;
    }

    /**
     * String distance from point coordinate. X value getter.
     *
     * @return integer
     */
    function getXDistance() {
        return $this->_x_distance;
    }

    /**
     * String distance from point coordinate. X value setter.
     *
     * @var integer $distance
     */
    function setXDistance($distance) {
        $this->_x_distance = $distance;
    }

    /**
     * String distance from point coordinate. Y value getter.
     *
     * @return integer
     */
    function getYDistance() {
        return $this->_y_distance;
    }

    /**
     * String distance from point coordinate. Y value setter.
     *
     * @var integer $distance
     */
    function setYDistance($distance) {
        $this->_y_distance = $distance;
    }

    /**
     * String point referencing coordinate setter.
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
        $x1_margin =  $this->_x1 + $this->_x_margin + $x_margin - $this->getXDistance();
        $y1_margin =  $this->_y1 + $this->_y_margin + $y_margin - $this->getYDistance();

        return imagestring($image, $this->getFont(), $x1_margin, $y1_margin, $this->getText(), $color);
    }
}
?>
