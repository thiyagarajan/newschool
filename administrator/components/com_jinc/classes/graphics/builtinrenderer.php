<?php
/**
 * @version		$Id: builtinrenderer.php 2010-01-19 12:01:47Z lhacky $
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

require_once 'chartrenderer.php';

/**
 * BuiltInRenderer class, defining chart renderer using built-in image.
 *
 * @package		JINC
 * @subpackage          Graphics
 * @since		0.8
 */

class BuiltInRenderer extends ChartRenderer {
    /**
     * The BuiltInRenderer constructor.
     *
     * @access	public
     * @param   array $values X-axis values.
     * @param   array $legend Y-axis values
     * @return	BuiltInRenderer
     * @since	0.8
     */
    function BuiltInRenderer($values, $legend) {
        parent::ChartRenderer($values, $legend);
    }

    /**
     * Method to render a statistical chart using built-in image.
     *
     * @return false if someting wrong
     */

    function render() {
        jincimport("graphics.gchart");
        jincimport("graphics.gimage");
        $chart = new GChart($this->get('legend'), 700, 200);
        $chart->addLine($this->get('values'));
        $chart->setXMargin(25);
        $chart->setYMargin(25);
        $chart->setGridColor(192, 192, 192);

        $c = new GImage(750, 250);
        $c->display($chart);
        $c->close();
    }
}

?>
