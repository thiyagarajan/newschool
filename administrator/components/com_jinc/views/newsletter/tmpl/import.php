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
defined('_JEXEC') or die('Restricted access'); ?>
<?php
jincimport('utility.jinchtmlhelper');
JINCHTMLHelper::hint('IMPORT_RES', 'IMPORT_RES_TITLE');
?>

<table align="center" class="adminform">
    <tr>
        <th><?php echo JText::_( 'COM_JINC_IMPORT_SUBSCRIBER' ); ?></th>
        <th><?php echo JText::_( 'COM_JINC_IMPORT_RESULT' ); ?></th>
    </tr>

    <?php
    if (isset ($this->result)) {
        $results = $this->result;
        for ($i = 0 ; $i < count($results) ; $i++) {
            $result = $results[$i];
            echo '<tr>';
            echo '<td width=75%>';
            echo $result['data'];
            echo '</td>';
            echo '<td width=25%>';
            $value = $result['result'];
            if ($value == 'OK') {
                echo '<img src="components/com_jinc/assets/images/icons/checkin.png" alt="OK" width="16px" height="16px">';
            } else {
                echo '<img src="components/com_jinc/assets/images/icons/cancel.png" alt="OK" width="16px" height="16px">';
            }
            echo '&nbsp;&nbsp;' . JText::_($value);
            echo '</td>';

            echo '</tr>';
        }
    }
    ?>
</table>
<input type="hidden" name="task" value="import">
<input type="hidden" name="option" value="com_jinc" />
<input type="hidden" name="controller" value="newsletter" />
<input type="hidden" name="news_id" value="<?php echo $news_id; ?>">
