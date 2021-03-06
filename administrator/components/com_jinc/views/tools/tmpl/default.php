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
jincimport('utility.jinchtmlhelper');
JINCHTMLHelper::hint('TOOLS', 'TOOLS_TITLE');
?>

<div id="editcell">
    <table class="adminlist">
        <tr class="<?php echo "row0"; ?>">
            <td width="35%">
                <a href="index.php?option=com_jinc&task=tools.loadSampleData">
                    <?php echo JText::_('COM_JINC_LOAD_SAMPLE'); ?>
                </a>
            </td>
            <td width="65%">
                <?php
                echo JText::_('COM_JINC_LOAD_SAMPLE_DESC');
                ?>
            </td>
        </tr>
        <tr class="<?php echo "row1"; ?>">
            <td width="35%">
                <a href="index.php?option=com_jinc&task=tools.loadSampleStatisticalData">
                    <?php echo JText::_('COM_JINC_LOAD_SAMPLE_STAT'); ?>
                </a>
            </td>
            <td width="65%">
                <?php
                echo JText::_('COM_JINC_LOAD_SAMPLE_STAT_DESC');
                ?>
            </td>
        </tr>
    </table>
</div>