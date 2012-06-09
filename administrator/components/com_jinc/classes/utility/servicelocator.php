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
require_once 'filelogger.php';
require_once 'parameterprovider.php';

/**
 * ServiceLocator class, defining a service locator.
 * It is implemented following the ServiceLocator J2EE Pattern.
 * It is a Singleton.
 *
 * @package		JINC
 * @subpackage          Core
 * @since		0.6
 */
class ServiceLocator {
    /**
     * Logger
     *
     * @var Logger
     */
    var $_logger;

    /**
     * ServiceLocator constructor.
     */
    function ServiceLocator() {
        jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');

        $path_abs_root = JPATH_ADMINISTRATOR . DS . 'components' . DS;
        $path_rel = 'com_jinc' . DS . 'jinc.log';
        $logger = new Logger(ParameterProvider::getLogLevel());
        $loghandler = new FileLogger($path_abs_root . $path_rel);
        $logger->addHandler($loghandler);

        $this->_logger = $logger;
    }

    /**
     * ServiceLocator instance getter.
     *
     * @staticvar ServiceLocator $instance
     * @return ServiceLocator
     */
    function &getInstance() {
        static $instance = null;
        if (null === $instance) {
            $instance = new ServiceLocator();
        }
        return $instance;
    }

    /**
     * It returns the application logger.
     *
     * @return Logger
     */
    function getLogger() {
        return $this->_logger;
    }
}
?>
