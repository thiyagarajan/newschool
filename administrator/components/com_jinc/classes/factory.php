<?php
/**
 * @package		JINC
 * @subpackage          Base
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
defined('_JEXEC') or die('Restricted access');

/**
 * JINCFactory class is responsible to import classes definitions
 *
 * @package		JINC
 * @subpackage          Base
 * @since		0.6
 */
class JINCFactory {
/**
 * Import the name of the class in Java style.
 *
 * Class name sample: package.subpackage.class1
 *
 * Raise an error if class not found.
 *
 * @param String $className Name of the class to import
 */
    function jincimport($className, $component = 'com_jinc', $base = 'classes') {
        $parts = explode('.', $className); // Break apart at dots
        $newClassName = JPATH_ADMINISTRATOR.DS.'components'.DS.$component.DS;
        $newClassName .= (strlen($base) > 0)?$base.DS:'';
        $newClassName .= implode(DS,$parts); // Glue the pieces with the directory separator
        $newClassName .= '.php';
        
        if(!JFile::exists($newClassName)) {
            JError::raiseError(500, 'Class not found: '.$className);
        } else {
            require_once($newClassName);
        }
    }
}

/**
 * Import the name of the class in Java style using JINCFactory class methods.
 *
 * Class name sample: package.subpackage.class1
 *
 * Raise an error if class not found.
 *
 * @param String $className
 * @return void
 * @since 0.6
 */
function jincimport($className) {
    return JINCFactory::jincimport($className);
}

/**
 * Import the name of the class in Java style using JINCFactory class methods
 * from an external component.
 *
 * Class name sample: package.subpackage.class1
 *
 * Raise an error if class not found.
 *
 * @param String $className Class name
 * @param String $component External Component Name
 * @param String $base      Base for class searching
 *
 * @return void
 * @since 0.8
 */
function jincimportext($className, $component, $base = '') {
    return JINCFactory::jincimport($className, $component, $base);
}