<?php
/**
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
defined('_JEXEC') or die('Restricted access');

if (isset($this->newsletter)) {
    $newsletter = $this->newsletter;
    $front_theme = $newsletter->get('front_theme') . '.css';
    echo JHTML::stylesheet($front_theme, 'components/com_jinc/assets/themes/');
}

if (isset($this->title)) {
    echo '<div class="jinc_err_msg_title">' . JText::_($this->title) . '</div>';
}
if (isset($this->subtitle))
    echo '<div class="jinc_err_msg_subtitle">' . $this->subtitle . '</div>';

$msg = isset($this->msg) ? $this->msg : '';
echo '<div class="jinc_err_msg_text">' . JText::_($this->msg) . '</div>';
?>