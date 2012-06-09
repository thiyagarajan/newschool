<?php

/**
 * @package		JINC
 * @subpackage          Frontend
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

/**
 * JINCInputRenderer class, providing generic methods to render an <input>
 * during subscriber information getting.
 *
 * @package		JINC
 * @subpackage          Frontend
 * @since		0.9
 */

jincimport('core.jincobject');
jincimport('core.attribute');

abstract class JINCInputRenderer extends JINCObject {
    function __construct() {
    }

    /**
     * It displays common html for this renderer
     *
     */
    public abstract function preRender();
    
    /**
     * It display the html input to get info related to an attribute
     *
     * @param Attribute $attribute Attribute to render
     * @param boolean   $mandatory Attribute cardinality
     *
     */
    public abstract function render($attribute, $mandatory = false);

    /**
     * It display the html input to get info related to an attribute in the
     * module context.
     *
     * @param Attribute $attribute Attribute to render
     * @param boolean   $mandatory Attribute cardinality
     *
     */
    public abstract function modRender($attribute, $mandatory = false);
    
    /**
     * It display the html input to get captcha
     *
     */
    public abstract function captchaRender();
    
    /**
     * It display the html input to get captcha on modules
     *
     */
    public abstract function modCaptchaRender();    
}