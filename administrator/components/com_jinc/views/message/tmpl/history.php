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
isset($this->history) or die('History not defined');
$history = $this->history;

jincimport('utility.jinchtmlhelper');
JINCHTMLHelper::hint('MESSAGE_HISTORY', 'MESSAGE_HISTORY_TITLE');

$nhist = count($history);
if ($nhist == 0) {
    echo '<strong>' . JText::_('COM_JINC_NO_HISTORY') . '</strong>';
}

for ($i = 0; $i < $nhist; $i++) {
    $process = $history[$i];
?>
    <div class="sending">
        <table align="center" width="55%" border=0 class="adminlist">
            <thead>
                <tr>
                    <td width="100%" colspan="4" align="center">
                        <strong><?php echo JText::_('COM_JINC_REPORT_DATA') . ' (' . ($nhist - $i) . ')'; ?></strong>
                    </td>
                </tr>
            </thead>

            <tr>
                <td width="25%" align="left">
                <?php echo JText::_('COM_JINC_START_TIME'); ?>
            </td>
            <td width="25%" align="right">
                <strong>
                    <?php echo date('r', $process->get('start_time')); ?>
                </strong>
            </td>
            <td width="25%" align="left">
                <?php echo JText::_('COM_JINC_END_TIME'); ?>
                </td>
                <td width="25%" align="right">
                    <strong>
                    <?php echo date('r', $process->get('last_update_time')); ?>
                </strong>
            </td>
        </tr>
        <tr>
            <td width="25%" align="left">
                <?php echo JText::_('COM_JINC_TOT_RECIPIENTS'); ?>
                </td>
                <td width="25%" align="right">
                    <strong>
                    <?php echo $process->get('sent_messages'); ?>
                </strong>
            </td>
            <td width="25%" align="left">
                <?php echo JText::_('COM_JINC_SENT_SUCCESS'); ?>
                </td>
                <td width="25%" align="right">
                    <strong>
                    <?php echo $process->get('sent_success'); ?>
                </strong>
            </td>
        </tr>
    </table>
</div>
<br><br>
<?php
                }
?>