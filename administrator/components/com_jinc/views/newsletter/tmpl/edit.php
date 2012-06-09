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
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
jincimport('core.newsletter');
?>
<script type="text/javascript">
    Joomla.submitbutton = function(task) {
        if (task == 'newsletter.cancel' || document.formvalidator.isValid(document.id('newsletter-form'))) {

            Joomla.submitform(task, document.getElementById('newsletter-form'));
        } else {
            alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
        }
    }
    
    function onChangeType() {
        var jform_jcontact_enabled = document.getElementById('jform_jcontact_enabled');
        var jform_type = document.getElementById("jform_type");
        var news_type = jform_type.options[jform_type.selectedIndex].value;
                
        jform_jcontact_enabled.disabled = (news_type != <?php echo NEWSLETTER_PRIVATE_NEWS; ?>);        
        if (news_type != <?php echo NEWSLETTER_PRIVATE_NEWS; ?>) {
            jform_jcontact_enabled.selectedIndex = 0;
        }
    }        
</script>

<form action="<?php JRoute::_('index.php?option=com_jinc'); ?>" method="post" name="adminForm" id="newsletter-form" class="form-validate">
    <div class="width-60 fltlft">

        <fieldset class="adminform">
            <legend><?php echo empty($this->item->id) ? JText::_('COM_JINC_NEW_NEWSLETTER') : JText::sprintf('COM_JINC_EDIT_NEWSLETTER', $this->item->id); ?></legend>

            <ul class="adminformlist">
                <?php
                // Extid is hidden - only for info if this is an external image (the filename field will be not required)
                $formArray = array('id', 'name', 'type', 'on_subscription', 'jcontact_enabled', 'notify', 'default_template');
                foreach ($formArray as $value) {
                    echo '<li>' . $this->form->getLabel($value) . $this->form->getInput($value) . '</li>' . "\n";
                } ?>
            </ul>

            <?php echo $this->form->getLabel('description'); ?>
                <div class="clr"></div>
            <?php echo $this->form->getInput('description'); ?>

            </fieldset>
        </div>

        <div class="width-40 fltrt">

        <?php echo JHtml::_('sliders.start', 'jinc-sliders-' . $this->item->id, array('useCookie' => 1)); ?>

        <?php echo JHtml::_('sliders.panel', JText::_('COM_JINC_ADDRESSES'), 'publishing-details'); ?>
                <fieldset class="panelform">
                    <ul class="adminformlist">
                <?php
                foreach ($this->form->getFieldset('addresses') as $field) {
                    echo '<li>';
                    if (!$field->hidden) {
                        echo $field->label;
                    }
                    echo $field->input;
                    echo '</li>';
                }
                ?>
            </ul>
        </fieldset>

        <?php echo JHtml::_('sliders.panel', JText::_('COM_JINC_FRONTEND'), 'publishing-details'); ?>
                <fieldset class="panelform">
                    <ul class="adminformlist">
                <?php
                foreach ($this->form->getFieldset('frontend') as $field) {
                    echo '<li>';
                    if (!$field->hidden) {
                        echo $field->label;
                    }
                    echo $field->input;
                    echo '</li>';
                }
                ?>
            </ul>
        </fieldset>

        <?php echo JHtml::_('sliders.panel', JText::_('COM_JINC_SECURITY'), 'publishing-details'); ?>
                <fieldset class="panelform">
                    <ul class="adminformlist">
                <?php
                foreach ($this->form->getFieldset('security') as $field) {
                    echo '<li>';
                    if (!$field->hidden) {
                        echo $field->label;
                    }
                    echo $field->input;
                    echo '</li>';
                }
                ?>
            </ul>
        </fieldset>
            
        <?php echo JHtml::_('sliders.panel', JText::_('COM_JINC_WELCOME'), 'publishing-details'); ?>
                <fieldset class="panelform">
                    <ul class="adminformlist">
                <?php
                echo '<li>' . $this->form->getLabel('welcome_subject') . $this->form->getInput('welcome_subject') . '</li>' . "\n";
                ?>
            </ul>
            <?php echo $this->form->getLabel('welcome'); ?>
                <div class="clr"></div>
            <?php echo $this->form->getInput('welcome'); ?>
            </fieldset>

        <?php echo JHtml::_('sliders.panel', JText::_('COM_JINC_DISCLAIMER'), 'publishing-details'); ?>
                <fieldset class="panelform">
            <?php echo $this->form->getLabel('disclaimer'); ?>
                <div class="clr"></div>
            <?php echo $this->form->getInput('disclaimer'); ?>
            </fieldset>


        <?php echo JHtml::_('sliders.panel', JText::_('COM_JINC_OPTIN'), 'publishing-details'); ?>
                <fieldset class="panelform">
                    <ul class="adminformlist">
                        <li>
                    <?php echo $this->form->getLabel('optin_subject'); ?>
                    <?php echo $this->form->getInput('optin_subject'); ?>
                </li>
            </ul>
            <?php echo $this->form->getLabel('optin'); ?>
                    <div class="clr"></div>
            <?php echo $this->form->getInput('optin'); ?>
                    <div class="clr"></div>
                </fieldset>

        <?php echo JHtml::_('sliders.panel', JText::_('COM_JINC_OPTINREMOVE'), 'publishing-details'); ?>
                    <fieldset class="panelform">
                        <ul class="adminformlist">
                            <li>
                    <?php echo $this->form->getLabel('optinremove_subject'); ?>
                    <?php echo $this->form->getInput('optinremove_subject'); ?>
                </li>
            </ul>
            <?php echo $this->form->getLabel('optinremove'); ?>
                    <div class="clr"></div>
            <?php echo $this->form->getInput('optinremove'); ?>
                    <div class="clr"></div>
                </fieldset>
        <?php
                    $fieldSets = $this->form->getFieldsets('attribs');
                    foreach ($fieldSets as $name => $fieldSet) :
                        echo JHtml::_('sliders.panel', JText::_($fieldSet->label), $name . '-options');
                        if (isset($fieldSet->description) && trim($fieldSet->description)) :
                            echo '<p class="tip">' . $this->escape(JText::_($fieldSet->description)) . '</p>';
                        endif;
        ?>
                        <fieldset class="panelform">
                            <ul class="adminformlist">
                <?php foreach ($this->form->getFieldset($name) as $field) : ?>
                            <li><?php echo $field->label; ?>
                    <?php echo $field->input; ?></li>
                <?php endforeach; ?>
                        </ul>
                    </fieldset>
        <?php endforeach; ?>

        <?php echo JHtml::_('sliders.end'); ?>
                        </div>

                        <div class="clr"></div>
    <?php
    if ($this->canAdmin):
            ?>
                                <div class="width-100 fltlft">
        <?php echo JHtml::_('sliders.start', 'permissions-sliders-' . $this->item->id, array('useCookie' => 1)); ?>
        <?php echo JHtml::_('sliders.panel', JText::_('COM_JINC_PERMISSION'), 'access-rules'); ?>
                                <fieldset class="panelform">
            <?php echo $this->form->getLabel('rules'); ?>
            <?php echo $this->form->getInput('rules'); ?>
                            </fieldset>
        <?php echo JHtml::_('sliders.end'); ?>
                            </div>
    <?php endif; ?>
                                <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
                            </form>

<script type="text/javascript">
                                <!--
                                var rules_public = document.getElementById("jform_rules_jinc.subscribe_1");
<?php if (empty($this->item->id)) { ?>
                                rules_public.selectedIndex = 1;
<?php } ?>
// -->
</script>

<script type="text/javascript">
onChangeType();
</script>