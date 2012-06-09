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
define('LOGGER_DEBUG',   0);
define('LOGGER_FINER',   1);
define('LOGGER_FINE',    2);
define('LOGGER_INFO',    3);
define('LOGGER_WARNING', 4);
define('LOGGER_SEVERE',  5);
define('LOGGER_DEFAULT', 3);

/**
 * Logger class, defining a generic logger.
 * It implements a generic logger using the Observer Design Pattern.
 * Logger class plays the Observable role of the Observer Pattern.
 *
 * @package		JINC
 * @subpackage          Core
 * @since		0.6
 */
class Logger {
/**
 * Log level
 *
 * @var int
 */
    var $_loglevel;
    /**
     * Handlers array. Array of Observers in the Observer Pattern.
     * @var array
     */
    var $_handlers;

    /**
     * Logger constructor.
     *
     * @param int $loglevel Log level
     */
    function Logger($loglevel) {
        $this->setLoglevel($loglevel);
        $this->_handlers = array();
    }

    /**
     * Log level getter.
     *
     * @return int
     */
    function getLogLevel() {
        return $this->_loglevel;
    }

    /**
     * Log level setter.
     *
     * @param int $loglevel
     */
    function setLoglevel($loglevel) {
        $level = (int) $loglevel;
        if ($level > LOGGER_SEVERE) {
            $this->_loglevel = LOGGER_SEVERE;
        } elseif ($level < LOGGER_DEBUG) {
            $this->_loglevel = LOGGER_DEBUG;
        } else {
            $this->_loglevel = $level;
        }
    }

    /**
     * Add handler: this is an observer in the Observer Pattern.
     *
     * @param LogHandler $handler
     */
    function addHandler($handler) {
        array_push($this->_handlers, $handler);
    }

    /**
     * Log a message at a log level passed as parameter.
     *
     * @param String $message
     * @param int $loglevel
     */
    function _logNotify($message, $loglevel) {
        foreach ($this->_handlers as $handler) {
            $handler->update($message, $loglevel);
        };
    }

    /**
     * It logs a message at debug log level.
     *
     * @param String $message
     */
    function debug($message) {
        if ($this->_loglevel <= LOGGER_DEBUG)
            $this->_logNotify($message, LOGGER_DEBUG);
    }

    /**
     * It logs a message at finer log level.
     *
     * @param String $message
     */
    function finer($message) {
        if ($this->_loglevel <= LOGGER_FINER)
            $this->_logNotify($message, LOGGER_FINER);
    }

    /**
     * It logs a message at fine log level.
     *
     * @param String $message
     */
    function fine($message) {
        if ($this->_loglevel <= LOGGER_FINE);
        $this->_logNotify($message, LOGGER_FINE);
    }

    /**
     * It logs a message at info log level.
     *
     * @param String $message
     */
    function info($message) {
        if ($this->_loglevel <= LOGGER_INFO);
        $this->_logNotify($message, LOGGER_INFO);
    }

    /**
     * It logs a message at warning log level.
     *
     * @param String $message
     */
    function warning($message) {
        if ($this->_loglevel <= LOGGER_WARNING);
        $this->_logNotify($message, LOGGER_WARNING);
    }

    /**
     * It logs a message at sever log level.
     *
     * @param String $message
     */
    function sever($message) {
        if ($this->_loglevel <= LOGGER_SEVERE);
        $this->_logNotify($message, LOGGER_SEVERE);
    }
}
?>
