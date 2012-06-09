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
isset($this->items) or die('Items not found');
$items = $this->items;

jincimport('utility.jinchtmlhelper');
JINCHTMLHelper::hint('TAGS_VIEWER', 'TAGS_VIEWER_TITLE');

JHTML::stylesheet('administrator/components/com_jinc/assets/css/jinc_admin.css');
?>
<div id="element-box">
    <div class="t">
        <div class="t">
            <div class="t"></div>
        </div>
    </div>

    <div id="element-box">
        <div class="t">
            <div class="t">
                <div class="t"></div>
            </div>
        </div>
        <div class="m">
            <div id="editcell">
                <table class="adminlist" id="attrTable">
                    <thead>
                        <tr>
                            <th width="40%">
                                <?php echo JText::_('COM_JINC_TAGNAME'); ?>
                            </th>
                            <th width="60%">
                                <?php echo JText::_('COM_JINC_TAGDESC'); ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                $base_tags = isset($items['BASE']) ? $items['BASE'] : array();
                                foreach ($base_tags as $tag) {
                                    echo '<tr>';
                                    echo '<td>';
                                    echo '[' . $tag . ']';
                                    echo '</td>';
                                    echo '<td>';
                                    echo JText::_('COM_JINC_TAG_' . $tag);
                                    echo '</td>';
                                    echo '</tr>';
                                }

                                if (isset($items['USER'])) {
                                    echo '<tr><th colspan="2" align="center">' . JText::_('COM_JINC_USERTAGS') . ' </th></tr>';
                                    $user_tags = isset($items['USER']) ? $items['USER'] : array();
                                    foreach ($user_tags as $tag) {
                                        echo '<tr>';
                                        echo '<td>';
                                        echo '[' . $tag . ']';
                                        echo '</td>';
                                        echo '<td>';
                                        echo JText::_('COM_JINC_TAG_' . $tag);
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                }

                                if (isset($items['OPTIN'])) {
                                    echo '<tr><th colspan="2" align="center">' . JText::_('COM_JINC_OPTINTAGS') . ' </th></tr>';
                                    $optin_tags = $items['OPTIN'];
                                    foreach ($optin_tags as $tag) {
                                        echo '<tr>';
                                        echo '<td>';
                                        echo '[' . $tag . ']';
                                        echo '</td>';
                                        echo '<td>';
                                        echo JText::_('COM_JINC_TAG_' . $tag);
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="b">
            <div class="b">
                <div class="b"></div>
            </div>
        </div>
    </div>
</div>