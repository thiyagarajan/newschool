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
require_once 'gcircledpoint.php';
require_once 'gstring.php';

/**
 * GPointed class, defining a graphical set of points.
 * It display a list of points using GD functionalities.
 *
 * @package		JINC
 * @subpackage          Graphics
 * @since		0.6
 */
class GPointed extends CompositeGraph {
/**
 * Points Y values.
 *
 * @var array
 */
    var $_values;
    /**
     * Points set Width
     *
     * @var int
     */
    var $_width;

    /**
     * Points set Height
     *
     * @var <type>
     */
    var $_height;
    /**
     * Points size.
     *
     * @var int
     */
    var $_dot_size;

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
     * Print values
     *
     * @var boolean
     */
    var $_print;

    /**
     * GPointed constructor
     *
     * @param array $values Points Y values
     * @param integer $width Points set width
     * @param integer $height Points set height
     */
    function GPointed($values = array(), $width = 250, $height = 150) {
        parent::CompositeGraph();
        $this->setValues($values);
        $this->setWidth($width);
        $this->setHeight($height);
        $this->setBackgroundColor(255, 255, 255);
        $this->setColor(0, 0, 0);
        $this->setDotSize(7);
        $this->setPrintValues(false);
    }

    /**
     * Print values setter. It true it displays values.
     *
     * @param boolean $v
     */
    function setPrintValues($v = true) {
        $this->_print = $v;
    }

    /**
     * Point Y-values setter.
     *
     * @param array $values
     */
    function setValues($values) {
        $this->_values = $values;
    }

    /**
     * Points set width
     *
     * @param integer $width
     */
    function setWidth($width) {
        $this->_width = $width;
    }

    /**
     * Points set heigth
     *
     * @param integer $height
     */
    function setHeight($height) {
        $this->_height = $height;
    }

    /**
     * Dot size setter.
     *
     * @param integer $dotsize
     */
    function setDotSize($dotsize) {
        $this->_dot_size = $dotsize;
    }

    /**
     * Dot size getter.
     *
     * @return integer
     */
    function getDotSize() {
        return $this->_dot_size;
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

        $max = max( max($values), 10 );
        $min = min($values);
        $normalized = array();
        for ($i=0; $i < $count; $i++) {
            $normalized[$i] = $this->_height - ($values[$i] / $max * $this->_height);
        }

        $div = $this->_width / ($count-1);
        if ($this->getDotSize() > 0) {
            for ($i = 0 ; $i < $count ; $i++) {
                $p = new GCircledPoint();
                $p->setBackgroundColor($this->_background_r_color, $this->_background_g_color, $this->_background_b_color);
                $p->setCoordinates($i*$div, $normalized[$i]);
                $p->setColor($this->_r_color, $this->_g_color, $this->_b_color);
                $p->setSize($this->getDotSize());
                $this->addElement($p);
                if ($this->_print) {
                    $s = new GString("$values[$i]");
                    $s->setDistance(18);
                    $s->setCoordinates($i*$div, $normalized[$i]);
                    $this->addElement($s);
                }
            }
        }
    }
}
?>
