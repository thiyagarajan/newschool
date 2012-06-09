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
require_once 'loghandler.php';

/**
 * FileLogger class, defining a logger writing logs within a file.
 * It is a Concrete Observer in the Observer Pattern.
 *
 * @package		JINC
 * @subpackage          Core
 * @since		0.6
 */
class FileLogger extends LogHandler {
    /**
     * Log file name
     *
     * @var String
     */
    var $_filename;

    /**
     * FileLogger constructor.
     *
     * @param String $filename Log file name
     */
    function FileLogger($filename) {
        $this->_filename = $filename;
    }

    /**
     * Logs a message at a defined log level.
     *
     * @param String $message
     * @param integer $loglevel
     */
    function update($message, $loglevel) {
        if ($fh = fopen($this->_filename, 'a')) {
            $date = date('Y-m-d H:i:s');
            $logstring = LogHandler::getLevelString($loglevel);
            fwrite($fh, "$date " . session_id(). " $logstring $message\n");
            fclose($fh);
        }
    }
}
?>
