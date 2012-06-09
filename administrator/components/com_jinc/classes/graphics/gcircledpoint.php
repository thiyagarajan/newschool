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
require_once 'gpoint.php';

/**
 * GCircledPoint class, defining a graphical circled poing.
 *
 * @package		JINC
 * @subpackage          Graphics
 * @since		0.6
 */
class GCircledPoint extends CompositeGraph {
    /**
     * X value
     *
     * @var int
     */
    var $_x1; 
    
    /**
     * Y value
     * 
     * @var int
     */
    var $_y1;

    /**
     * Point color. Red intensity
     *
     * @var int
     */
    var $_background_r_color; 
    
    /**
     * Point color. Green intensity
     * 
     * @var int
     */
    var $_background_g_color;

    /**
     * Point color. Blue intensity
     *
     * @var int
     */
    var $_background_b_color;

    /**
     * GCircledPoint constructor.
     */
    function GCircledPoint() {
        parent::CompositeGraph();
        $this->setBackgroundColor(255, 255, 255);
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
        $p1 = new GPoint();
        $p1->setCoordinates($this->_x1, $this->_y1);
        $bsize = ((int) ($this->getSize() / 3)) + 1;
        $p1->setSize($this->getSize() + $bsize);
        $p1->setColor($this->_background_r_color, $this->_background_g_color, $this->_background_b_color);
        $this->addElement($p1);
        $p2 = new GPoint();
        $p2->setCoordinates($this->_x1, $this->_y1);
        $p2->setSize($this->getSize());
        $p2->setColor($this->_r_color, $this->_g_color, $this->_b_color);
        $this->addElement($p2);
    }
}
?>
