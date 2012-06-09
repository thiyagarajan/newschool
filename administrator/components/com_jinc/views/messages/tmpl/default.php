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
defined('_JEXEC') or die;

isset($this->items) or die('Items not defined');
jincimport('utility.jinchtmlhelper');
JINCHTMLHelper::hint('MESSAGE_LIST', 'MESSAGE_LIST_TITLE');
$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
?>
<form action="<?php echo JRoute::_('index.php?option=com_jinc&view=messages'); ?>" method="post" name="adminForm" id="adminForm">
    <fieldset id="filter-bar">
        <div class="filter-search fltlft">
            <label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
            <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_JINC_FILTER_SEARCH_DESC'); ?>" />

            <button type="submit" class="btn"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
            <button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
        </div>
        <div class="filter-select fltrt">
            <select name="filter_news_id" class="inputbox" onchange="this.form.submit()">
                <option value=""><?php echo JText::_('COM_JINC_SELECT_NEWSLETTER'); ?></option>
                <?php echo JHtml::_('select.options', JFormFieldJINCNewsletter::getOptions(), 'value', 'text', $this->state->get('filter.news_id')); ?>
            </select>
        </div>
    </fieldset>
    <div class="clr"> </div>

    <table class="adminlist">
        <thead>
            <tr>
                <th width="2%">
                    <input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)" />
                </th>
                <th width="27%">
                    <?php echo JHtml::_('grid.sort', 'COM_JINC_LIST_SUBJECT', 'm.subject', $listDirn, $listOrder); ?>
                </th>
                <th width="2%">
                    <?php echo JHtml::_('grid.sort', 'COM_JINC_LIST_TYPE', 'm.bulkmail', $listDirn, $listOrder); ?>
                </th>
                <th width="2%">
                    <?php echo JText::_('COM_JINC_LIST_STATUS'); ?>
                </th>
                <th width="25%">
                    <?php echo JHtml::_('grid.sort', 'COM_JINC_LIST_NEWS_NAME', 'n.name', $listDirn, $listOrder); ?>
                </th>
                <th width="25%">
                    <?php echo JHtml::_('grid.sort', 'COM_JINC_LIST_LAST_DISPATCH', 'datasent', $listDirn, $listOrder); ?>
                </th>
                <th width="3%" class="nowrap">
                    <?php echo JHtml::_('grid.sort', 'ID', 'm.id', $listDirn, $listOrder); ?>
                </th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="15">
                    <?php echo $this->pagination->getListFooter(); ?>
                </td>
            </tr>
        </tfoot>
        <tbody>
            <?php
                    $base = JURI::base() . 'components/com_jinc/assets/images/icons/';
                    $options = array('height' => 16, 'width' => 16, 'title' => JText::_('COM_JINC_ATTACHMENT'));
                    $attach_img = JHTML::image($base . 'attachment.png',
                                    JText::_('COM_JINC_ATTACHMENT'), $options);

                    $options['title'] = JText::_('COM_JINC_BULKMAIL');
                    $bulk_img = JHTML::image($base . 'user.png',
                                    JText::_('COM_JINC_BULKMAIL'), $options);
                    $options['title'] = JText::_('COM_JINC_PERSONAL');
                    $pers_img = JHTML::image($base . 'person4_f2.png',
                                    JText::_('COM_JINC_PERSONAL'), $options);

                    foreach ($this->items as $i => $item) :
                        $status = isset($item->status) ? $item->status : 0;
                        $max_status = isset($item->max_status) ? $item->max_status : 0;
                        switch ($status) {
                            case PROCESS_STATUS_PAUSED:
                                $options['title'] = JText::_('COM_JINC_PAUSED');
                                $status_img = JHTML::image(JURI::base() . 'components/com_jinc/assets/images/icons/pause.png',
                                                JText::_('COM_JINC_PAUSED'), $options);
                                break;
                            case PROCESS_STATUS_RUNNING:
                                $options['title'] = JText::_('COM_JINC_RUNNING');
                                $status_img = JHTML::image(JURI::base() . 'components/com_jinc/assets/images/icons/running.png',
                                                JText::_('COM_JINC_RUNNING'), $options);
                                break;
                            case PROCESS_STATUS_FINISHED:
                                $options['title'] = JText::_('COM_JINC_FINISHED');
                                $status_img = JHTML::image(JURI::base() . 'components/com_jinc/assets/images/icons/finished.png',
                                                JText::_('COM_JINC_FINISHED'), $options);
                                break;
                            default:
                                if ($item->datasent == 0) {
                                    $options['title'] = JText::_('COM_JINC_STOPPED');
                                    $status_img = JHTML::image(JURI::base() . 'components/com_jinc/assets/images/icons/stop.png',
                                                    JText::_('COM_JINC_STOPPED'), $options);
                                } else {
                                    $options['title'] = JText::_('COM_JINC_FINISHED');
                                    $status_img = JHTML::image(JURI::base() . 'components/com_jinc/assets/images/icons/finished.png',
                                                    JText::_('COM_JINC_FINISHED'), $options);
                                }
                                break;
                        }
            ?>
                        <tr class="row<?php echo $i % 2; ?>">
                            <td class="center">
<?php echo JHtml::_('grid.id', $i, $item->id); ?>
                            </td>
                            <td>
                                <a href="<?php echo JRoute::_('index.php?option=com_jinc&task=message.edit&id=' . $this->escape($item->id)); ?>">
<?php echo $this->escape($item->subject); ?></a>
                    </td>
                    <td class="center">
<?php
                        echo ($this->escape($item->bulkmail)) ? $bulk_img : $pers_img;
?>
                    </td>
                    <td class="center">
<?php echo $status_img; ?>
                    </td>
                    <td class="center">
<?php echo $this->escape($item->name); ?>
                    </td>
                    <td class="center nowrap">
<?php
                        if ($item->datasent == 0) {
                            echo JText::_('COM_JINC_NEVER');
                        } else {
                            $date = JFactory::getDate($item->datasent);
                            echo $date->calendar(JText::_('DATE_FORMAT_LC2'));
                        }
?>
                    </td>
                    <td class="center">
<?php echo $this->escape($item->id); ?>
                    </td>
                </tr>
<?php endforeach; ?>
            </tbody>
        </table>

<?php
                        $legend_array = array();
                        array_push($legend_array, array('text' => 'COM_JINC_PAUSED',
                            'icon' => 'icons/pause.png'));
                        array_push($legend_array, array('text' => 'COM_JINC_RUNNING',
                            'icon' => 'icons/running.png'));
                        array_push($legend_array, array('text' => 'COM_JINC_STOPPED',
                            'icon' => 'icons/stop.png'));
                        array_push($legend_array, array('text' => 'COM_JINC_FINISHED',
                            'icon' => 'icons/finished.png'));
                        array_push($legend_array, array('text' => 'COM_JINC_PERSONAL',
                            'icon' => 'icons/person4_f2.png'));
                        array_push($legend_array, array('text' => 'COM_JINC_BULKMAIL',
                            'icon' => 'icons/user.png'));

                        JINCHTMLHelper::legend($legend_array);
?>

                        <div>

                            <input type="hidden" name="option" value="com_jinc" />
                            <input type="hidden" name="view" value="messages" />
                            <input type="hidden" name="task" value="" />
                            <input type="hidden" name="boxchecked" value="0" />
                            <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
                            <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
<?php echo JHtml::_('form.token'); ?>
    </div>
</form>