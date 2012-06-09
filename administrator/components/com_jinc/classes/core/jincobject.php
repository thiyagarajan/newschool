<?php
/**
 * @version		$Id: jincobject.php 25-gen-2010 13.40.56 lhacky $
 * @package		JINC
 * @subpackage          Core
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
 * jincobject class, defining JINC Objects.
 *
 * @package		JINC
 * @subpackage          Core
 * @since		0.6
 */

class JINCObject extends JObject {
    /**
     * Redefine setError method inherited from Joomla! JObject class
     *
     * @access	public
     * @since	0.6
     */

    function setError($error) {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();
        $logger->finer(get_class($this) . ': ' . JText::_($error));
        parent::setError($error);
    }

}
?>
