<?php
/**
 * @version		$Id: openflashrenderer.php 2010-01-19 12:01:47Z lhacky $
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
require_once 'php-ofc-library/open-flash-chart.php';
/**
 * OpenFlashRenderer class, defining chart renderer using Open Flash library.
 *
 * @package		JINC
 * @subpackage          Graphics
 * @since		0.8
 */

class OpenFlashRenderer extends ChartRenderer {
/**
 * The OpenFlashRenderer constructor.
 *
 * @access	public
 * @param   array $values X-axis values.
 * @param   array $legend Y-axis values
 * @return	OpenFlashRenderer
 * @since	0.8
 */
    function OpenFlashRenderer($values, $legend) {
        parent::ChartRenderer($values, $legend);
    }

    /**
     * Method to render a statistical chart using Open Flash library.
     *
     * @return false if someting wrong
     */

    function render() {
        $values = array();
        foreach ($this->values as $number_variable => $variable) {
            $values[$number_variable] = (int)$variable;
        }

        $area = new area();
        $area->set_default_dot_style( new hollow_dot() );
        $area->set_colour( '#5B56B6' );
        $area->set_fill_alpha( 0.4 );
        $area->set_values( $values );
        $area->set_key( 'Values', 12 );

        $x_labels = new x_axis_labels();
        $x_labels->set_steps( 1 );
        $x_labels->set_vertical();
        $x_labels->set_colour( '#A2ACBA' );
        $x_labels->set_labels( $this->legend );

        $x = new x_axis();
        $x->set_colour( '#A2ACBA' );
        $x->set_grid_colour( '#D7E4A3' );
        $x->set_offset( false );
        $x->set_steps(1);
        // Add the X Axis Labels to the X Axis
        $x->set_labels( $x_labels );

        $y = new y_axis();
        $y_max = (max($values) > 0)?max($values):4;
        $y_mod = (int) (($y_max / 4) + 1);
        $y_max += ($y_mod - ($y_max % $y_mod));
        $y->set_range( 0, $y_max, $y_mod);
        $y->labels = null;
        $y->set_offset( false );

        $chart = new open_flash_chart();
        $chart->set_x_axis( $x );
        $chart->add_y_axis( $y );
        $chart->add_element( $area );

        return $chart;
    }
}

?>
