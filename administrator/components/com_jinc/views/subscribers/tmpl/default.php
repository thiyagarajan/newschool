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
JHtml::_('behavior.modal');
jincimport('utility.jinchtmlhelper');
jincimport('core.newsletter');
JINCHTMLHelper::hint('SUBSCRIBERS_LIST', 'SUBSCRIBERS_LIST_TITLE');
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
            <select name="filter_news_id" class="inputbox" onchange="this.form.submit()">
                <option value=""><?php echo JText::_('COM_JINC_SELECT_NEWSLETTER'); ?></option>
                <?php echo JHtml::_('select.options', JFormFieldJINCNewsletter::getOptions(), 'value', 'text', $this->state->get('filter.news_id')); ?>
            </select>
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
                        echo JHTML::_('grid.sort', 'COM_JINC_LIST_MAIL', 'subs_email', $listDirn, $listOrder);
                        ?>
                    </th>
                    <th width="20%">
                        <?php
                        echo JHTML::_('grid.sort', 'COM_JINC_LIST_NEWS_NAME', 'n.name', $listDirn, $listOrder);
                        ?>
                    </th>
                    <th width="2%">
                        <?php
                        echo JHTML::_('grid.sort', 'ID', 's.id', $listDirn, $listOrder);
                        ?>
                    </th>
                </tr>
            </thead>
            <?php
                        $k = 0;
                        for ($i = 0, $n = count($this->items); $i < $n; $i++) {
                            $row = & $this->items[$i];
                            $checked = JHTML::_('grid.id', $i, $row->id);
                            $link = JRoute::_('index.php?option=com_jinc&view=newsletter&task=newsletter.edit&id=' . $row->id);
            ?>
                            <tr class="<?php echo "row$k"; ?>">
                                <td align="center">
                    <?php echo $checked; ?>
                        </td>
                        <td>
                    <?php
                            if (strlen($row->random) > 0)
                                echo "<i>";
                    ?>
                            <a class="modal" href="index.php?option=com_jinc&view=subscriber&tmpl=component&id=<?php echo $row->id; ?>" rel="{handler: 'iframe', size: {x: 875, y: 550}, onClose: function() {}}">
                        <?php echo $row->subs_email; ?>
                        </a>

                    <?php
                            if (strlen($row->random) > 0) {
                                if (is_null($row->datasub)) {
                                    echo '&nbsp;&nbsp;&nbsp;&nbsp;(' . JText::_('COM_JINC_WAITING_OPTIN') . ")</i>";
                                } else {
                                    echo '&nbsp;&nbsp;&nbsp;&nbsp;(' . JText::_('COM_JINC_WAITING_OPTIN_REMOVE') . ")</i>";
                                }
                            }
                                
                    ?>

                        </td>
                        <td>
                            <a href="<?php echo $link; ?>"><?php echo $row->name; ?></a>
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

        </div>

        <input type="hidden" name="option" value="com_jinc" />
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="view" value="subscribers" />
        <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
        <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
    <?php echo JHtml::_('form.token'); ?>
</form>