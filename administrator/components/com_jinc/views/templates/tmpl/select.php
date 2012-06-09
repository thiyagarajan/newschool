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
isset($this->items) or die('Items not defined');
$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
?>
<form action="<?php echo JRoute::_('index.php?option=com_jinc&view=templates'); ?>" method="post" name="adminForm" id="adminForm">
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

    <table class="adminlist">
        <thead>
            <tr>
                <th width="2%">
                    <input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)" />
                </th>
                <th width="38%">
                    <?php echo JHtml::_('grid.sort', 'COM_JINC_LIST_NAME', 'name', $listDirn, $listOrder); ?>
                </th>
                <th width="58%">
                    <?php echo JHtml::_('grid.sort', 'COM_JINC_LIST_SUBJECT', 'subject', $listDirn, $listOrder); ?>
                </th>
                <th width="5%" class="nowrap">
                    <?php echo JHtml::_('grid.sort', 'ID', 'id', $listDirn, $listOrder); ?>
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
                    foreach ($this->items as $i => $item) :
            ?>
                        <tr class="row<?php echo $i % 2; ?>">
                            <td class="center">
                    <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                    </td>
                    <td>
                        <a class="pointer" onclick="if (window.parent) window.parent.selectTemplate(<?php echo $item->id; ?>);">
                            <?php echo $this->escape($item->name); ?>
                        </a>
                </td>
                <td class="center">
                    <?php echo $this->escape($item->subject); ?>
                    </td>
                    <td class="center">
                    <?php echo $this->escape($item->id); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
                    </tbody>
                </table>

                <div>

                    <input type="hidden" name="option" value="com_jinc" />
                    <input type="hidden" name="view" value="templates" />
                    <input type="hidden" name="layout" value="select" />
                    <input type="hidden" name="tmpl" value="component" />
                    <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
                    <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>