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

JHTML::script('administrator/components/com_jinc/assets/js/phplivex.js');
JHTML::script('administrator/components/com_jinc/assets/js/commons.js');
$ajax_loader = JHTML::image(JURI::base() . 'components/com_jinc/assets/images/icons/simple-loader.gif', JText::_('COM_JINC_LOADING'), array("height" => 16, "width" => 16));
jincimport('utility.PHPLiveX');
jincimport('utility.jinchtmlhelper');
$msg_editor = JFactory::getEditor();
?>

<script type="text/javascript">
    function selectTemplate(id) {
        SqueezeBox.close();
        getTemplate(id);
    }

    function getTemplate(id) {
        var plx = new PHPLiveX();
        return plx.ExternalRequest({
            'content_type': 'json',
            'url': 'index.php?option=com_jinc&task=templateJSON.getTemplateInfo&format=json',
            'onFinish': function(response){
                var content = <?php echo $msg_editor->getContent('jform_body'); ?>
                var answer = true;
                if ((content != undefined) && (content.length > 0)) answer = confirm ('<?php echo addslashes(JText::_('COM_JINC_OVERWRITE_JS')); ?>');
                if (answer) {
                    document.getElementById("jform_subject").value = response.subject;
                    var editor_name = '<?php echo $msg_editor->get("name"); ?>';
                    if (!(typeof WFEditor === "undefined")) {
                      WFEditor.setContent('jform_body', response.body);
                    } else if (editor_name.match("^jce")=="jce") {
                          JContentEditor.setContent('jform_body', response.body);
                    } else {
                          <?php echo $msg_editor->setContent('jform_body', 'response.body'); ?>
                    }
                }
            },
            'params':{'id': id}
        });
    }

    function getDefaultTemplate() {
        id = document.getElementById("jform_news_id").value;
        var plx = new PHPLiveX();
        return plx.ExternalRequest({
            'content_type': 'json',
            'url': 'index.php?option=com_jinc&task=newsletterJSON.getDefaultTemplate&format=json',
            'onFinish': function(response){
                var tem_id = response.tem_id;
                if (tem_id != 0) {
                    getTemplate(tem_id);
                }
            },
            'params':{'id': id}
        });
    }
</script>

<script type="text/javascript">
    <!--
    function submitbutton(task) {
        if (task == 'message.cancel' || document.formvalidator.isValid(document.id('message-form'))) {
            submitform(task);
        }
        submitform(task);
    }
    // -->
</script>

<form action="<?php JRoute::_('index.php?option=com_jinc'); ?>" method="post" name="adminForm" id="message-form" class="form-validate">
    <div class="width-60 fltlft">

        <fieldset class="adminform">
            <legend><?php echo empty($this->item->id) ? JText::_('COM_JINC_NEW_MESSAGE') : JText::sprintf('COM_JINC_EDIT_MESSAGE', $this->item->id); ?></legend>

            <ul class="adminformlist">
                <?php
                // Extid is hidden - only for info if this is an external image (the filename field will be not required)
                $formArray = array('id', 'subject', 'news_id');
                foreach ($formArray as $value) {
                    echo '<li>' . $this->form->getLabel($value) . $this->form->getInput($value) . '</li>' . "\n";
                } ?>
            </ul>
            <?php echo $this->form->getLabel('body'); ?>
                <div class="clr"></div>
            <?php echo $this->form->getInput('body'); ?>
            </fieldset>
        </div>

        <div class="width-40 fltrt">

        <?php echo JHtml::_('sliders.start', 'jinc-sliders-' . $this->item->id, array('useCookie' => 1)); ?>

        <?php echo JHtml::_('sliders.panel', JText::_('COM_JINC_BASIC_OPTIONS'), 'basic-options'); ?>
                <fieldset class="adminform">
                    <ul class="adminformlist">
                <?php
                foreach ($this->form->getFieldset('basic_opts') as $field) {
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
        <?php echo JHtml::_('sliders.panel', JText::_('COM_JINC_ATTACHMENTS'), 'attachments'); ?>
                <fieldset class="panelform">
            <?php echo $this->loadTemplate('attachment'); ?>
            </fieldset>

        <?php echo JHtml::_('sliders.end'); ?>
            </div>

            <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
</form>