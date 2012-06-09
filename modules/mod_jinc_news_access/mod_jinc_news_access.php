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
require_once JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_jinc' . DS . 'classes' . DS . 'factory.php';
jincimport('core.newsletter');

$user = & JFactory::getUser();
$query = 'SELECT n.id, n.name, n.type ' .
        'FROM #__jinc_newsletter n ' .
        'WHERE n.published = 1 ';

$dbo = JFactory::getDBO();
$dbo->setQuery($query);
$news = $dbo->loadObjectList();
echo "<br>";

if (!empty($news)) {
    foreach ($news as $row) {
        $canSubscribe = $user->authorise('jinc.subscribe', 'com_jinc.newsletter.' . $row->id);
        if (($row->type == NEWSLETTER_PRIVATE_NEWS) && ($user->guest)) {
            $canSubscribe = false;
        }

        if ($canSubscribe) {
            $link = JRoute::_('index.php?option=com_jinc&view=newsletter&id=' . $row->id);
            echo '<a href=' . $link . '>' . $row->name . '</a><br>';
        }
    }
}
?>
