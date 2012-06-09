<?php
/**
 * @package		JINC
 * @subpackage          Utility
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
 * JSONResponse class, defining a JSON response.
 *
 * @package		JINC
 * @subpackage          Utility
 * @since		0.6
 */
class JSONResponse extends JObject {
    function __construct() {
        parent::__construct();
    }

    function array2json($arr) {
        if(function_exists('json_encode')) return json_encode($arr); //Lastest versions of PHP already has this functionality.
        // Checking if $arr is associative
        $is_assoc = false;
        foreach (array_keys($arr) as $k => $v) {
            if ($k !== $v)
                $is_assoc = true;
        }

        $parts = array();
        foreach($arr as $key=>$value) {
            if(is_array($value)) { //Custom handling for arrays
                if ($is_assoc)
                    $parts[] = '"' . $key . '":' . $this->array2json($value);
                else
                    $parts[] = $this->array2json($value);
            } else {
                $value = preg_replace("/[\n\r\t]/","",$value);
                $str = '';
                if ($is_assoc) $str = '"' . $key . '":';
                if (is_numeric($value)) $str .= $value;
                elseif ($value === false) $str .= 'false';
                elseif ($value === true) $str .= 'true';
                else $str .= '"' . addslashes($value) . '"';
                $parts[] = $str;
            }
        }
        $json = implode(',', $parts);

        if ($is_assoc) return '{' . $json . '}';
        else return '[' . $json . ']';
    }

    function toString() {
        $props = $this->getProperties();
        return $this->array2json($props);
    }
}
?>
