<?php
/**
 * @version		$Id: notice.php 2010-01-19 12:01:47Z lhacky $
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
 * Requiring PHP libraries and defining constants
 */
require_once 'jincobject.php';

/**
 * Notice class, defining notice properties and methods.
 *
 * Hint: this class inherits from JINCObject in order to avoid getter and setter
 * redefinition and to use getError() and setError() methods.
 *
 * @package		JINC
 * @subpackage          Core
 * @since		0.9
 */
class Notice extends JINCObject {

    /**
     * The notice identifier
     *
     * @var	The notice identifier
     * @access	protected
     * @since	0.9
     */
    var $id;
    /**
     * The notice name
     *
     * @var	The notice name
     * @access	protected
     * @since	0.9
     */
    var $name = '';
    /**
     * The notice title
     *
     * @var	The notice title
     * @access	protected
     * @since	0.9
     */
    var $title = '';
    /**
     * The notice brief description
     *
     * @var	The notice brief description
     * @access	protected
     * @since	0.9
     */
    var $bdesc = '';
    /**
     * The notice conditions
     *
     * @var	The notice condition
     * @access	private
     * @since	0.9
     */
    var $conditions = '';

    /**
     * The Notice constructor.
     *
     * @access	public
     * @param   integer notice_id The notice identifier.
     * @return	Notice
     * @since	0.9
     * @see     Notice
     */
    function Notice($notice_id) {
        parent::__construct();
        $this->set('id', $notice_id);
    }
}

?>
