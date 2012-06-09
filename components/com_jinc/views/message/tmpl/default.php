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
?>
<?php
JHTML::_('behavior.tooltip');
isset($this->message) || die('Message not found');
isset($this->newsletter) || die('Newsletter not found');
$newsletter = $this->newsletter;
$front_theme = $newsletter->get('front_theme') . '.css';
$message = $this->message;

echo JHTML::stylesheet($front_theme, 'components/com_jinc/assets/themes/');
echo JHTML::script('components/com_jinc/assets/js/jinc.js');

jincimport('frontend.jincfrontendhelper');
JINCFrontnedHelper::showMessage($newsletter, $message);
?>