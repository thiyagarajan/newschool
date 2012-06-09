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
 * Container class, defining a graphical container.
 * It contains a GD image and display on it graphical objects inheriting from
 * class Graph
 *
 * @package		JINC
 * @subpackage          Graphics
 * @since		0.6
 */
class Container {
    /**
     *
     * @var _images The GD image in which displaying graphical objects
     */
    var $_image;

    /**
     * Container constructor
     *
     * @param $image GD image
     */
    function Container($image) {
        $this->_image = $image;
    }

    /**
     * Displaying graphical objects
     *
     * @param Graph $graph
     * @return false if something wrong
     */
    function display($graph) {
        if (is_a ($graph, 'Graph')) {
            return $graph->display($this);
        }
        return false;
    }
    
    /**
     * Close GD image
     * 
     * @return void
     */
    function close() {
        return ;
    }

    /**
     *
     * @return GD Image in which container must display graphical objects
     */
    function getImage() {
        return $this->_image;
    }
}
?>
