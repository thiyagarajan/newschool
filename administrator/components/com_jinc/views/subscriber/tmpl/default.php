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
isset($this->info) or die('Info not defined');
$info = $this->info;

JHTML::_('behavior.tooltip');
jincimport('utility.jinchtmlhelper');
JINCHTMLHelper::hint('SUBSCRIBER_INFO', 'SUBSCRIBER_INFO_TITLE');
JHTML::stylesheet('administrator/components/com_jinc/assets/css/jinc_admin.css');
?>
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
                        <th width="35%">
                            <?php echo JText::_('COM_JINC_ATTR_NAME'); ?>
                        </th>
                        <th width="65%">
                            <?php echo JText::_('COM_JINC_ATTR_VALUE'); ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                            foreach ($info as $key => $value) {
                                echo '<tr>';
                                echo '<td>';
                                if (substr($key, 0, 5) == 'attr_') {
                                    echo JText::_('COM_JINC_TAG_' . strtoupper($key));
                                } else {
                                    echo JText::_('COM_JINC_' . strtoupper($key));
                                }
                                echo '</td>';
                                echo '<td>';
                                if ($key == 'status') {
                                    if (strlen($value) > 0)
                                        if (is_null($info['datasub'])) {
                                            echo '<i>' . JText::_('COM_JINC_WAITING_OPTIN') . '</i>';
                                        } else {
                                            echo '<i>' . JText::_('COM_JINC_WAITING_OPTIN_REMOVE') . '</i>';
                                        }
                                        
                                    else
                                        echo JText::_('COM_JINC_CONFIRMED');
                                } else {
                                    echo $value;
                                }
                                echo '</td>';
                                echo '</tr>';
                            }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
