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
require_once 'compositegraph.php';
require_once 'gsegment.php';
require_once 'gpolygon.php';

/**
 * GLine class, defining a graphical line.
 * It display a line using GD functionalities.
 *
 * @package		JINC
 * @subpackage          Graphics
 * @since		0.6
 */
class GLine extends CompositeGraph {
/**
 * Line Y values to show.
 *
 * @var array
 */
    var $_show_values;

    /**
     * Line values.
     *
     * @var array
     */
    var $_values;

    /**
     * Line width
     *
     * @var int
     */
    var $_width;

    /**
     * Line height
     *
     * @var int
     */
    var $_height;

    /**
     * Background color. Red intensity.
     *
     * @var int
     */
    var $_background_r_color;

    /**
     * Background color. Green intensity.
     *
     * @var int
     */
    var $_background_g_color;

    /**
     * Background color. Blue intensity.
     *
     * @var int
     */
    var $_background_b_color;

    /**
     * If true it show a background from line to X-axis.
     *
     * @var bool
     */
    var $_show_background;

    /**
     * GLine constructor.
     *
     * @param array $values line Y values
     * @param integer $width Line width
     * @param <type> $height Line height
     */
    function GLine($values = array(), $width = 250, $height = 150) {
        parent::CompositeGraph();
        $this->setValues($values);
        $this->setWidth($width);
        $this->setHeight($height);
        $this->setBackgroundColor(255, 255, 255);
        $this->setShowBackground(false);
        $this->setShowValues(true);
    }

    /**
     * Show background setter.
     *
     * @param bool $v
     */
    function setShowBackground($v) {
        $this->_show_background = $v;
    }

    /**
     * Line Y values to show setter.
     *
     * @param array $v
     */
    function setShowValues($v) {
        $this->_show_values = $v;
    }

    /**
     * Line Y values setter.
     *
     * @param array $values
     */
    function setValues($values) {
        $this->_values = $values;
    }

    /**
     * Line width setter.
     *
     * @param integer $width
     */
    function setWidth($width) {
        $this->_width = $width;
    }

    /**
     * Line height setter.
     *
     * @param integer $height
     */
    function setHeight($height) {
        $this->_height = $height;
    }

    /**
     * Background color setter.
     *
     * @param integer $r Red intensity background color
     * @param integer $g Green intensity background color
     * @param integer $b Blue intensity background color
     */
    function setBackgroundColor($r, $g, $b) {
        $this->_background_r_color = (int) $r;
        $this->_background_g_color = (int) $g;
        $this->_background_b_color = (int) $b;
    }

    /**
     * Predisplay function
     *
     * @return void
     */
    function prepare() {
        $values = $this->_values;
        $count = count($values);

        $max = max( max($values) , 10 );
        $min = min($values);
        $normalized = array();
        for ($i=0; $i < $count; $i++) {
            if ($max == 0) {
                $normalized[$i] = $this->_height;
            } else {
                $normalized[$i] = $this->_height - ($values[$i] / $max * $this->_height);
            }
        }

        $div = $this->_width / ($count-1);
        for ($i = 0 ; $i < $count-1 ; $i++) {
            $s = new GSegment();
            $s->setCoordinates($i*$div, $normalized[$i], ($i+1)*$div, $normalized[$i+1]);
            $s->setSize($this->getSize());
            $s->setColor($this->_r_color, $this->_g_color, $this->_b_color);
            $this->addElement($s);

            if ($this->_show_background) {
                $values = array($i*$div, $this->_height, $i*$div, $normalized[$i], ($i+1)*$div, $normalized[$i+1], ($i+1)*$div, $this->_height);
                $p = new GPolygon($values);
                $p->setColor($this->_background_r_color, $this->_background_g_color, $this->_background_b_color);
                $this->addElement($p);
            }
            if (($this->_show_values) && ($i%3 == 0)) {
                $str = new GString("" . $this->_values[$i]);
                $str->setCoordinates($i*$div, $normalized[$i], ($i+1)*$div, $normalized[$i+1]);
                $str->setDistance(18);
                $this->addElement($str);
            }
        }

        $str = new GString("" . $this->_values[($count-1)]);
        $str->setCoordinates(($count-1)*$div, $normalized[$count-1]);
        $str->setDistance(18);
        $this->addElement($str);
    }
}
?>