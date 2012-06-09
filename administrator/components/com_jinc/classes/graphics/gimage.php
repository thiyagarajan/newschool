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
require_once 'container.php';

/**
 * GImage class, defining a graphical image.
 * A GImage is a container with defined width and height and a background color.
 *
 * @package		JINC
 * @subpackage          Graphics
 * @since		0.6
 */
class GImage extends Container {
/**
 * Image width.
 *
 * @var int
 */
    var $_width;

    /**
     * Image height.
     *
     * @var int
     */
    var $_height;

    /**
     * GD Image
     *
     * @var GDImage
     */
    var $_image;

    /**
     * Background color. Red intensity.
     *
     * @var int
     */
    var $_r_color;

    /**
     * Background color. Green intensity.
     *
     * @var int
     */
    var $_g_color;

    /**
     * Background color. Blue intensity.
     *
     * @var int
     */
    var $_b_color;

    /**
     * GImage constructor.
     *
     * @param integer $width
     * @param integer $height
     */
    function GImage($width = 800, $height = 600) {
        $this->_width      = $width;
        $this->_height     = $height;
        $this->_image      = imagecreate($width, $height);
        $this->setColor(255, 255, 255);
    }

    /**
     * GD Image getter.
     *
     * @return GDImage
     */
    function getImage() {
        return $this->_image;
    }

    /**
     * Background color setter.
     *
     * @param integer $r Red intensity background color
     * @param integer $g Green intensity background color
     * @param integer $b Blue intensity background color
     */
    function setColor($r, $g, $b) {
        $this->_r_color = $r;
        $this->_g_color = $g;
        $this->_b_color = $b;
    }

    /**
     * GD Image closing method.
     */
    function close() {
        imagedestroy($this->_image);
    }

    /**
     * It displays a Graph element within a PNG Image using GD functionalities.
     *
     * @param Graph $graph
     * @return false if something wrong
     */
    function display($graph) {
        header("Cache-Control: no-cache");
        header("Content-type: image/png");
        $white = imagecolorallocate($this->_image, $this->_r_color, $this->_g_color, $this->_b_color);
        if (parent::display($graph)) {
            return imagepng($this->_image);
        }
        return false;
    }
}
?>
