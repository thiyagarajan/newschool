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

isset($this->items) or die('Items not defined');
jincimport('utility.jinchtmlhelper');
jincimport('core.newsletter');
JINCHTMLHelper::hint('NEWSLETTER_LIST', 'NEWSLETTER_LIST_TITLE');
$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
?>
<form action="index.php" method="post" name="adminForm">
    <fieldset id="filter-bar">
        <div class="filter-search fltlft">
            <label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
            <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_JINC_FILTER_SEARCH_DESC'); ?>" />

            <button type="submit" class="btn"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
            <button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
        </div>
        <div class="filter-select fltrt">
        </div>
    </fieldset>
    <div class="clr"> </div>

    <div id="editcell">
        <table class="adminlist">
            <thead>
                <tr>
                    <th width="2%">
                        <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
                    </th>
                    <th width="32%">
                        <?php
                        echo JHTML::_('grid.sort', 'COM_JINC_LIST_NEWS_NAME', 'name', $listDirn, $listOrder);
                        ?>
                    </th>
                    <th width="2%">
                        <?php
                        echo JHTML::_('grid.sort', 'COM_JINC_LIST_PUBLISHED', 'published', $listDirn, $listOrder);
                        ?>
                    </th>
                    <th width="2%">
                        <?php
                        echo JHTML::_('grid.sort', 'COM_JINC_LIST_TYPE', 'type', $listDirn, $listOrder);
                        ?>
                    </th>
                    <th width="3%">
                        <?php echo JText::_('COM_JINC_LEGEND_IMPORT'); ?>
                    </th>
                    <th width="3%">
                        <?php echo JText::_('COM_JINC_LEGEND_STATS'); ?>
                    </th>
                    <th width="17%">
                        <?php
                        echo JHTML::_('grid.sort', 'COM_JINC_LIST_CREATED', 'created', $listDirn, $listOrder);
                        ?>
                    </th>
                    <th width="17%">
                        <?php
                        echo JHTML::_('grid.sort', 'COM_JINC_LIST_SENDER_ADDRESS', 'senderaddr', $listDirn, $listOrder);
                        ?>
                    </th>
                    <th width="20%">
                        <?php
                        echo JHTML::_('grid.sort', 'COM_JINC_LIST_SENDER_NAME', 'sendername', $listDirn, $listOrder);
                        ?>
                    </th>
                    <th width="2%">
                        <?php
                        echo JHTML::_('grid.sort', 'ID', 'id', $listDirn, $listOrder);
                        ?>
                    </th>
                </tr>
            </thead>
            <?php
                        $options = array("height" => 16, "width" => 16);
                        $base_url = JURI::base() . 'components/com_jinc/assets/images/';
                        $public_img = JHTML::image($base_url . 'send_f2.png',
                                        JText::_('COM_JINC_LEGEND_PUBLIC'), $options);
                        $private_img = JHTML::image($base_url . 'security_f2.png',
                                        JText::_('COM_JINC_LEGEND_PRIVATE'), $options);
                        $import_img = JHTML::image($base_url . 'upload_f2.png',
                                        JText::_('COM_JINC_LEGEND_IMPORT'), $options);
                        $stats_img = JHTML::image($base_url . 'cpanel.png',
                                        JText::_('COM_JINC_LEGEND_STATS'), $options);
                        $k = 0;
                        for ($i = 0, $n = count($this->items); $i < $n; $i++) {
                            $row = & $this->items[$i];
                            $checked = JHTML::_('grid.id', $i, $row->id);
                            $link = JRoute::_('index.php?option=com_jinc&view=newsletter&task=newsletter.edit&id=' . $row->id);
                            $import_link = JRoute::_('index.php?option=com_jinc&view=newsletter&layout=uploadcsv&id=' . $row->id);
                            $stats_link = JRoute::_('index.php?option=com_jinc&task=newsletter.stats&id=' . $row->id);
                            $published = JHtml::_('jgrid.published', $row->published, $i, 'newsletters.', true);
            ?>
                            <tr class="<?php echo "row$k"; ?>">
                                <td>
                    <?php echo $checked; ?>
                        </td>
                        <td>
                            <a href="<?php echo $link; ?>"><?php echo $row->name; ?></a>
                        </td>
                        <td align="center">
                    <?php echo $published; ?>
                        </td>
                        <td align="center">
                    <?php
                            $type = $row->type;
                            if ($type == NEWSLETTER_PUBLIC_NEWS)
                                echo $public_img;
                            if ($type == NEWSLETTER_PRIVATE_NEWS)
                                echo $private_img;
                    ?>
                        </td>
                        <td align="center">
                            <a href="<?php echo $import_link; ?>"><?php echo $import_img; ?></a>
                        </td>
                        <td align="center">
                            <a href="<?php echo $stats_link; ?>"><?php echo $stats_img; ?></a>
                        </td>
                        <td>
                    <?php
                            $date = JFactory::getDate($row->created);
                            echo $date;
                    ?>
                        </td>
                        <td>
                    <?php echo $row->senderaddr; ?>
                        </td>
                        <td>
                    <?php echo $row->sendername; ?>
                        </td>
                        <td>
                    <?php echo $row->id; ?>
                        </td>
                    </tr>
            <?php
                            $k = 1 - $k;
                        }
            ?>
                        <tr>
                            <td colspan="10">
                    <?php echo $this->pagination->getListFooter(); ?>
                    </td>
                </tr>

            </table>

        <?php
                        $legend_array = array();
                        array_push($legend_array, array('text' => 'COM_JINC_LEGEND_PUBLIC',
                            'icon' => 'send_f2.png'));
                        array_push($legend_array, array('text' => 'COM_JINC_LEGEND_PRIVATE',
                            'icon' => 'security_f2.png'));
                        array_push($legend_array, array('text' => 'COM_JINC_LEGEND_IMPORT',
                            'icon' => 'upload_f2.png'));
                        array_push($legend_array, array('text' => 'COM_JINC_LEGEND_STATS',
                            'icon' => 'cpanel.png'));

                        JINCHTMLHelper::legend($legend_array);
        ?>
                    </div>

                    <input type="hidden" name="option" value="com_jinc" />
                    <input type="hidden" name="task" value="" />
                    <input type="hidden" name="boxchecked" value="0" />
                    <input type="hidden" name="view" value="newsletters" />
                    <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
                    <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
    <?php echo JHtml::_('form.token'); ?>
</form>