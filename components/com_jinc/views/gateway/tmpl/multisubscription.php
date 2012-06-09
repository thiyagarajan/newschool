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
echo JHTML::stylesheet('multisubscription.css', 'components/com_jinc/assets/css/');
?>
<div class="jinc_msg_title"><?php echo JText::_('COM_JINC_SUBSCRIPTION_TITLE'); ?></div>
<?php
if (isset($this->mmsg)) {
    $newsletters = isset($this->newsletters)? $this->newsletters : array();
    foreach ($this->mmsg as $news_id => $text) {
        echo '<div class="jinc_msg_subtitle">';
        $newsletter = isset($newsletters[$news_id])? $newsletters[$news_id] : array();
        echo $newsletter->get('name');
        echo '</div>';
        echo '<div class="jinc_msg_text">' . JText::_($text) . '</div>';
    }
    if (count($this->mmsg) == 0) {
        echo '<div class="jinc_subscription_result">' . JText::_('COM_JINC_NO_NEWSLETTER_SELECTED') . '</div>';        
    }
}
?>