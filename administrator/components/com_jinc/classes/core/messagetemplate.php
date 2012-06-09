<?php
/**
 * @version		$Id: messagetemplate.php 4-feb-2010 13.23.26 lhacky $
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
 * MessageTemplate class, defining a template message.
 *
 * @package		JINC
 * @subpackage          Core
 * @since		0.6
 */

class MessageTemplate extends JObject {
    var $id = 0;
    var $name = '';
    var $subject = '';
    var $body = '';

    function MessageTemplate($tem_id) {
        parent::__construct();
        $this->id = (int) $tem_id;
    }
}
?>
