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
<?php isset($this->item) or die('Item is not defined'); ?>

<script type="text/javascript">
    <!--
    function submitbutton(task) {
        if (task == 'notice.cancel' || document.formvalidator.isValid(document.id('notice-form'))) {
            submitform(task);
        }
        submitform(task);
    }
    // -->
</script>

<form action="<?php JRoute::_('index.php?option=com_jinc'); ?>" method="post" name="adminForm" id="message-form" class="form-validate">
    <div class="width-60 fltlft">

        <fieldset class="adminform">
            <legend><?php echo empty($this->item->id) ? JText::_('COM_JINC_NEW_NOTICE') : JText::sprintf('COM_JINC_EDIT_NOTICE', $this->item->id); ?></legend>

            <ul class="adminformlist">
                <?php
                // Extid is hidden - only for info if this is an external image (the filename field will be not required)
                $formArray = array('name', 'title', 'bdesc');
                foreach ($formArray as $value) {
                    echo '<li>' . $this->form->getLabel($value) . $this->form->getInput($value) . '</li>' . "\n";
                } ?>
            </ul>
            <?php echo $this->form->getLabel('conditions'); ?>
                <div class="clr"></div>
            <?php echo $this->form->getInput('conditions'); ?>
            </fieldset>
        </div>

        <div class="width-40 fltrt">    
        </div>

            <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
</form>