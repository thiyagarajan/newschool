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
$csv_format = isset($this->csv_format)? $this->csv_format : '';
$csv_string = '<br><strong>' . implode(', ', $csv_format) . '<strong>';
JINCHTMLHelper::hint('IMPORT', 'IMPORT_TITLE', '', $csv_string, true);
$news_id = isset ($this->news_id)? $this->news_id : 0;
?>

<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <table class="adminform">
        <tr>
            <th colspan="2"><?php echo JText::_( 'COM_JINC_LOAD_CSVFILE' ); ?></th>
        </tr>
        <tr>
            <td width="120">
                <label for="install_package">
                    <?php echo JText::_( 'COM_JINC_LOAD_CSVFILE' ); ?>
                </label>
            </td>
            <td>
                <input type="file" name="csvfile" id="csvfile" size="57" />
                <input type="submit" value="<?php echo JText::_('COM_JINC_LOAD'); ?>">
            </td>
        </tr>
    </table>
    <input type="hidden" name="option" value="com_jinc" />
    <input type="hidden" name="task" value="newsletter.import">
    <input type="hidden" name="id" value="<?php echo $news_id; ?>">
</form>
