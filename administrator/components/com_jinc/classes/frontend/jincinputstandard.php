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
 * JINCInputStandard class, providing methods to render an <input>
 * during subscriber information getting in the standard way.
 *
 * @package		JINC
 * @subpackage          Frontend
 * @since		0.9
 */
require_once 'jincinputrenderer.php';

class JINCInputStandard extends JINCInputRenderer {

    public function preRender() {
        
    }

    public function render($attribute, $mandatory = false) {
        $attr_name = $attribute->get('name');
        echo '<tr>';
        echo '<td>';
        echo JText::_($attribute->get('name_i18n'));
        if ($mandatory) {
            echo '*';
        }
        echo '</td>';
        echo '<td>';

        if ($attribute->get('type') == ATTRIBUTE_TYPE_DATE) {
            echo JHTML::_('calendar', '', 'attrs[' . $attr_name . ']', $attr_name, '%Y-%m-%d', array('size' => '32', 'maxlength' => '127', 'readonly' => 'true'));
        } else {
            echo '<input type="text" id="' . $attr_name . '" name="attrs[' . $attr_name . ']" maxlength="127" size="35">';
        }

        echo '</td>';
        echo '</tr>';
    }

    public function modRender($attribute, $mandatory = false) {
        $attr_name = $attribute->get('name');
        echo '<tr>';
        echo '<td width="100%">';

        echo JText::_($attribute->get('name_i18n'));
        if ($mandatory) {
            echo '*';
        }
        echo '</td></tr>';
        echo '<tr><td>';
        if ($attribute->get('type') == ATTRIBUTE_TYPE_DATE) {
            echo JHTML::_('calendar', '', 'attrs[' . $attr_name . ']', 'mod_' . $attr_name, '%Y-%m-%d', array('size' => '10', 'maxlength' => '127', 'readonly' => 'true'));
        } else {
            echo '<input type="text" id="mod_' . $attr_name . '" name="attrs[' . $attr_name . ']" maxlength="127" size="10">';
        }
        echo '</td>';
        echo '</tr>';
    }

    public function captchaRender() {
        echo '<tr>';
        echo '    <td colspan="2" align="center">';
        echo '        <img id="captcha" src="' . JRoute::_('index.php?option=com_jinc&task=captcha.showCaptcha&format=raw') . '" alt="CAPTCHA Image" />';
        echo '    </td>';
        echo '</tr>';
        echo '<tr>';
        echo '    <td>';
        echo JText::_('COM_JINC_CAPTCHA') . '*';
        echo '</td>';
        echo '<td>';
        echo '    <input type="text" name="captcha_code" size="10" maxlength="6" />&nbsp;&nbsp;';
        echo '    <img alt="' . JText::_('COM_JINC_CAPTCHA_RELOAD') . '" width="16px" height="16px" onclick="document.getElementById(\'captcha\').src = \'index.php?option=com_jinc&task=captcha.showCaptcha&format=raw & \' + Math.random(); return false" src="components/com_jinc/securimage/images/refresh.gif" />';
        echo '</td>';
        echo '</tr>';
    }

    public function modCaptchaRender() {
        echo '<tr><td colspan="2" align="left">';
        echo '  <div style="padding: 10px 15px 0px 0px; margin: 0px 0px 0px -10px">';
        echo '      <img id="mod_captcha" src="' . JRoute::_('index.php?option=com_jinc&task=captcha.showCaptcha&format=raw&mod_jinc=true') . '" alt="CAPTCHA Image" />';
        echo '  </div>';
        echo '</td></tr>';
        echo '<tr><td>';
        echo JText::_('COM_JINC_CAPTCHA') . '*';
        echo '</td></tr>';
        echo '<tr><td>';
        echo '  <input type="text" name="captcha_code" size="10" maxlength="6" />&nbsp;&nbsp;';
        echo '  <img alt="' . JText::_('COM_JINC_CAPTCHA_RELOAD') . '" width="16px" height="16px" onclick="document.getElementById(\'mod_captcha\').src = \'index.php?option=com_jinc&task=captcha.showCaptcha&format=raw&mod_jinc=true&\' + Math.random(); return false" src="components/com_jinc/securimage/images/refresh.gif" />';
        echo '</td></tr>';
    }

}