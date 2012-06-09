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
$edate = isset($this->end_time) ? $this->end_time : JFactory::getDate();
$sdate = isset($this->start_time) ? $this->start_time : JFactory::getDate();
?>
<form action="index.php" method="post" name="adminForm">
    <fieldset>
        <legend><?php echo JText::_('Time'); ?></legend>
        <table width="66%" align="center">
            <tr>
                <td width="15%">
                    <?php echo JText::_('COM_JINC_NEWS_NAME'); ?>:
                </td>
                <td width="35%">
                    <?php
                    echo JHTML::_('select.genericlist', isset($this->newsletters) ? $this->newsletters : null, 'id', '', 'id', 'name', $this->news_id);
                    ?>
                </td>
                <td width="15%">
                    <?php echo JText::_('COM_JINC_START_TIME'); ?>:
                </td>
                <td width="35%">
                    <?php
                    $time_format = isset($this->time_format) ? $this->time_format : '%Y-%m-%d';
                    echo JHTML::_('calendar', $sdate->toFormat($time_format), 'start_date', 'start_date', $time_format, array('class' => 'inputbox', 'size' => '25', 'maxlength' => '19'));
                    ?>
                </td>
            </tr>
            <tr>
                <td width="15%">
                    <?php echo JText::_('COM_JINC_TYPE'); ?>:
                </td>
                <td width="35%">
                    <?php
                    echo JHTML::_('select.genericlist', isset($this->stattypes) ? $this->stattypes : null, 'stat_type', '', 'stat_type', 'stat_descr', $this->stat_type);
                    ?>
                </td>
                <td width="15%">
                    <?php echo JText::_('COM_JINC_END_TIME'); ?>:
                </td>
                <td width="35%">
                    <?php
                    echo JHTML::_('calendar', $edate->toFormat($time_format), 'end_date', 'end_date', $time_format, array('class' => 'inputbox', 'size' => '25', 'maxlength' => '19'));
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <table width="80%" align="center">
        <tr>
            <td align="center">
                <?php
                    $timetypes = isset($this->timetypes) ? $this->timetypes : array();
                    $times = array();
                    foreach ($timetypes as $timetype) {
                        $times[] = JHTML::_('select.option', $timetype['time_type'], $timetype['time_descr']);
                    }
                    echo JHTML::_('select.radiolist', $times, 'time_type', 'onchange=\'form.submit();\'', 'value', 'text', $this->time_type);
                ?>
                </td>
            </tr>

        </table>
        <table width="80%" align="center">
            <tr>
                <td align="center" width="100%">
                    <input type="submit" value="<?php echo JText::_('COM_JINC_PERFORM_STATS'); ?>" align="center">
                </td>
            </tr>
        </table>
        <input type="hidden" name="option" value="com_jinc" />
        <input type="hidden" name="task" value="newsletter.stats">
    </form>
    <fieldset>
        <legend><?php echo JText::_('COM_JINC_PANEL_CHART'); ?></legend>
        <center>
        <?php
                    jincimport('utility.jinchtmlhelper');
                    JINCHTMLHelper::statChart();
        ?>
                </center>
            </fieldset>

            <fieldset>
                <legend><?php echo JText::_('COM_JINC_PANEL_DATA'); ?></legend>
                <table width="80%" align="center">
                    <tr>
                        <th><?php echo JText::_('COM_JINC_STATS_DATES'); ?></th>
                        <th><?php echo JText::_('COM_JINC_STATS_VALUES'); ?></th>
                    </tr>
        <?php
                    $values = $this->values;
                    $legend = $this->legend;
                    for ($i = 0; $i < count($values); $i++) {
                        echo "<tr>";
                        echo "<td width=\"50%\">" . $legend[$i] . "</td>";
                        echo "<td width=\"50%\">" . $values[$i] . "</td>";
                        echo "</tr>";
                    }
        ?>
    </table>
</fieldset>