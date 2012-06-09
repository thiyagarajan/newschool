<?php
/**
 * @version		$Id: attribute.php 18-ago-2010 15.56.36 lhacky $
 * @package		JINC
 * @subpackage          Core
 * @copyright           Generic Public License ver. 2.0
 * @license		GNU/GPL ver. 2.0
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

define('ATTRIBUTE_TYPE_STRING', 0);
define('ATTRIBUTE_TYPE_INTEGER', 1);
define('ATTRIBUTE_TYPE_DATE', 2);
define('ATTRIBUTE_TYPE_EMAIL', 3);

 /**
 * Attribute class, defining an addictional attribute for public newsletter.
 *
 * @package		JINC
 * @subpackage          Core
 * @since		0.7
 */

class Attribute extends JINCObject {
    /**
     * The addictional attribute identifier
     *
     * @var		The attribute identifier
     * @access	protected
     * @since	0.7
     */
    var $id;

    /**
     * The addictional attribute name
     *
     * @var		The attribute name
     * @access	protected
     * @since	0.7
     */
    var $name;

    /**
     * The addictional attribute description
     *
     * @var		The attribute description
     * @access	protected
     * @since	0.7
     */
    var $description;

    /**
     * The addictional attribute type
     *
     * @var		The attribute type
     * @access	protected
     * @since	0.7
     */
    var $type = ATTRIBUTE_TYPE_STRING;

    /**
     * The addictional attribute table name used to store attribute values
     *
     * @var		The attribute table name
     * @access	protected
     * @since	0.7
     */
    var $table_name;

    /**
     * The addictional attribute name for internazionalitazion
     *
     * @var		The attribute i18n name
     * @access	protected
     * @since	0.7
     */
    var $name_i18n;

    /**
     * The addictional Attribute constructor.
     *
     * @access	public
     * @param   integer attr_id The attribute identifier.
     * @return	Attribute
     * @since	0.7
     * @see     NewsletterFactory
     */

    function Attribute($attr_id) {
        parent::__construct();
        $this->set('id', $attr_id);
    }
}
?>
