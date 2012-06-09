<?php
/**
 * @version		$Id: statsrenderer.php 2010-01-19 12:01:47Z lhacky $
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
define('STATSRENDERER_BUILTIN', 1);
define('STATSRENDERER_OPENFLASH', 0);

/**
 * StatsRenderer abstract class, defining statictical renderer. This class
 * define abstract method render() to define render a graphical statistic chart.
 *
 *
 * @package		JINC
 * @subpackage          Graphics
 * @since		0.8
 */
class ChartRenderer extends JObject {

    /**
     * Values in Y axis
     *
     * @var		Values in Y axis
     * @access	protected
     * @since	0.8
     */
    var $values;

    /**
     * Values in X axis
     *
     * @var		Values in X axis
     * @access	protected
     * @since	0.8
     */
    var $legend = '';

    /**
     * The ChartRenderer constructor.
     *
     * @access	public
     * @param   array $values X-axis values.
     * @param   array $legend Y-axis values
     * @return	StatsRenderer
     * @since	0.8
     */

    function ChartRenderer($values, $legend) {
        parent::__construct();
        $this->set('values', $values);
        $this->set('legend', $legend);
    }

    /**
     * Abstact method to render a statistical chart.
     *
     * @return false if someting wrong
     * @abstract
     */
     
    function render() {
        die('StatsRenderer class: render() is an abstract method');
    }
}

?>
