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
 * Requiring PHP libraries and defining constants
 */
require_once 'logger.php';

/**
 * LogHandler class, defining a generic log handler.
 * It implements log handler using the Observer Design Pattern.
 * LogHandler class plays the Abstract Observer role of the Observer Pattern.
 *
 * @package		JINC
 * @subpackage          Core
 * @since		0.6
 */
class LogHandler {
    /**
     * Logs a message at a defined log level.
     * This is an abstract method.
     *
     * @param String $message
     * @param integer $loglevel
     * @abstract
     */
     function update($message, $loglevel) {
        die('LogHandler class: update() is an abstract method');
    }

    /**
     * It returns the string log level related to a log level.
     *
     * @param int $loglevel
     * @return String
     */
    function getLevelString($loglevel) {
        switch ($loglevel) {
            case LOGGER_DEBUG:
                return "DEBUG";
                break;

            case LOGGER_FINER:
                return "FINER";
                break;

            case LOGGER_FINE:
                return "FINE";
                break;

            case LOGGER_INFO:
                return "INFO";
                break;

            case LOGGER_WARNING:
                return "WARNING";
                break;

            case LOGGER_SEVERE:
                return "SEVER";
                break;

            default:
                return "UNKNOWN";
                break;
        }
    }
}
?>
