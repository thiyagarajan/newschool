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
require_once 'gline.php';
require_once 'gstring.php';
require_once 'gpointed.php';
require_once 'gsegment.php';

/**
 * GChart class, defining a graphical chart.
 * It display a chart using GD functionalities.
 *
 * @package		JINC
 * @subpackage          Graphics
 * @since		0.6
 */
class GChart extends CompositeGraph {
    /**
     * X Axis legend
     * 
     * @var array X-axis legend
     */
    var $_legend;

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
     * Grid color. Red intensity.
     *
     * @var int
     */
    var $_grid_r_color; 
    
    /**
     * Grid color. Green intensity.
     *
     * @var int
     */
    var $_grid_g_color;

    /**
     * Grid color. Blue intensity.
     *
     * @var int
     */
    var $_grid_b_color;

    /**
     * Chart width
     *
     * @var int
     */
    var $_width;

    /**
     * Chart height
     *
     * @var int
     */
    var $_height;

    /**
     * Max Y value for scaling purposes
     *
     * @var int
     */
    var $_max_value;

    /**
     * GChart constructor.
     *
     * @param array $legend X-axis legend values
     * @param integer $width Chart width
     * @param integer $height Chart height
     */
    function GChart($legend = array(), $width = 700, $height = 100) {
        parent::CompositeGraph();
        $this->setLegend($legend);
        $this->setWidth($width);
        $this->setHeight($height);
        $this->setBackgroundColor(230, 242, 250);
        $this->setGridColor(0, 0, 0);
        $this->_max_value = 0;
    }

    /**
     * Add a line to the chart
     *
     * @param array $values Point line Y values
     * @param integer $r Red intensity line color
     * @param integer $g Green intensity line color
     * @param integer $b Blue intensity line color
     * @param integer $size Size
     */
    function addLine($values, $r = 0, $g = 0, $b = 255, $size = 2) {
    # Line
        $gl = new GLine($values, $this->_width, $this->_height);
        $gl->setColor($r, $g, $b);
        $gl->setSize($this->getSize(), $this->getSize());
        $gl->setBackgroundColor($this->_background_r_color, $this->_background_g_color, $this->_background_b_color);
        $gl->setSize($size);
        $gl->setShowBackground(true);
        $this->addElement($gl);

        # Points
        $gp = new GPointed($values, $this->_width, $this->_height);
        $gp->setDotSize($size*3 + 1);
        $gp->setColor($r, $g, $b);
        $gp->setBackgroundColor($this->_background_r_color, $this->_background_g_color, $this->_background_b_color);
        $gp->setPrintValues(false);
        $this->addElement($gp);

        $max = max( max($values), 10 );
        $this->_max_value = ($max > $this->_max_value)? $max: $this->_max_value;
    }

    /**
     * Background color setter.
     *
     * @param integer $r Red intensity background color
     * @param integer $g Green intensity background color
     * @param integer $b Blue intensity background color
     */
    function setBackgroundColor($r, $g, $b) {
        $this->_background_r_color = $r;
        $this->_background_g_color = $g;
        $this->_background_b_color = $b;
    }

    /**
     * Grid color setter.
     *
     * @param integer $r Red intensity grid color
     * @param integer $g Green intensity grid color
     * @param integer $b Blue intensity grid color
     */
    function setGridColor($r, $g, $b) {
        $this->_grid_r_color = $r;
        $this->_grid_g_color = $g;
        $this->_grid_b_color = $b;
    }

    /**
     * Legend setter.
     *
     * @param array $legend
     */
    function setLegend($legend) {
        $this->_legend = $legend;
    }

    /**
     * Chart width setter.
     *
     * @param integer $width
     */
    function setWidth($width) {
        $this->_width = $width;
    }

    /**
     * Chart height setter.
     *
     * @param integer $height
     */
    function setHeight($height) {
        $this->_height = $height;
    }

    /**
     * Predisplay function
     *
     * @return void
     */
    function prepare() {
        $s = new GSegment();
        $s->setCoordinates(0, $this->_height, $this->_width, $this->_height);
        $s->setColor($this->_grid_r_color, $this->_grid_g_color, $this->_grid_b_color);
        $this->addElement($s);

        $s = new GSegment();
        $s->setCoordinates(0, $this->_height / 2, $this->_width, $this->_height / 2);
        $s->setColor($this->_grid_r_color, $this->_grid_g_color, $this->_grid_b_color);
        $this->addElement($s);

        $s = new GSegment();
        $s->setCoordinates(0, 0, $this->_width, 0);
        $s->setColor($this->_grid_r_color, $this->_grid_g_color, $this->_grid_b_color);
        $this->addElement($s);

        $count = count($this->_legend);
        $div = $this->_width / ($count-1);
        for ($i = 0; $i < $count-1; $i = $i + ((int) ($count / 5))) {
            $s = new GSegment();
            $s->setCoordinates($i*$div, 0, $i*$div, $this->_height);
            $s->setColor($this->_grid_r_color, $this->_grid_g_color, $this->_grid_b_color);
            $this->addElement($s);

            $str = new GString($this->_legend[$i]);
            $str->setCoordinates($i*$div, $this->_height);
            $str->setXDistance(10);
            $str->setYDistance(-5);
            $this->addElement($str);
        }

        $s = new GSegment();
        $s->setCoordinates(($count-1)*$div, 0, ($count-1)*$div, $this->_height);
        $s->setColor($this->_grid_r_color, $this->_grid_g_color, $this->_grid_b_color);
        $this->addElement($s);

        $str = new GString($this->_legend[($count-1)]);
        $str->setCoordinates(($count-1)*$div, $this->_height);
        $str->setXDistance(10);
        $str->setYDistance(-5);
        $this->addElement($str);

        $str = new GString("" . $this->_max_value);
        $str->setCoordinates(0, 0);
        $str->setDistance(15);
        $this->addElement($str);

    }
}
?>
