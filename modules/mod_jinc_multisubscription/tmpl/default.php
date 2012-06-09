<?php
isset($newsletter) || die('Newsletter not found');
isset($input_style) || die('Input Style not defined');

echo JHTML::script('components/com_jinc/assets/js/jinc.js');
echo JHTML::_('behavior.modal');
echo JHTML::stylesheet('multisubscription.css', 'components/com_jinc/assets/css/');
?>
<script language="JavaScript" type="text/javascript">
    function mod_checkPublic(form, alerttxt) {
        if (!mod_validate_mail(form.mod_user_mail, "<?php echo JText::_('COM_JINC_ERR019_JS'); ?>" ))
        return false;
        return true;
    }

    function mod_checkAttributes(form) {
<?php
foreach ($attributes as $attr_name => $attr_value) {
    if ($attr = $ninstance->loadAttribute($attr_name)) {
        if ($attr_value == ATTRIBUTE_MANDATORY) {
            echo 'var alert_msg = "' . JText::_($attr->get('name_i18n')) . ' is a mandatory argument";';
            echo 'if (!mod_validate_required(form.mod_' . $attr_name . ', alert_msg)) ';
            echo 'return false;';
        }
        if ($attr->get('type') == ATTRIBUTE_TYPE_INTEGER) {
            echo 'var alert_msg = "' . JText::_($attr->get('name_i18n')) . ' must be and integer value";';
            echo 'if (!mod_validate_integer(form.mod_' . $attr_name . ', alert_msg)) ';
            echo 'return false;';
        }
        if ($attr->get('type') == ATTRIBUTE_TYPE_DATE) {
            echo 'if ((!isEmpty(' . $attr_name . '_field.value)) && (!isDate(' . $attr_name . '_field.value))) {';
            echo 'alert("' . JText::_($attr->get('name_i18n')) . ' must be a date");';
            echo '' . $attr_name . '_field.focus();';
            echo 'return false;';
            echo '}';
        }
    } else {
        die('Error loading attribute');
    }
}
?>
        return true;
    }

    function mod_checkForm(form_name) {
        var form = document.forms[form_name];
        if (mod_checkAttributes(form)) {

<?php
if ($public)
    echo 'return mod_checkPublic(form);';
else
    echo 'return true;';
?>
        }
        return false;
    }
</script>
<form action="<?php echo JRoute::_('index.php'); ?>" method="post" onSubmit="return mod_checkForm('jinc_multisubscription_form');" id="jinc_multisubscription_form" name="jinc_multisubscription_form">
    <div class="jinc_mod_frm_multisubscription">
        <table width="100%" border="0">
            <?php
            $i = 0;
            foreach ($newsletters as $news_id => $newsletter) {
                ?>
                <tr>
                    <td style="padding: 3px;">
                        <input type="checkbox" checked id="cb<?php echo $i; ?>" name="cid[]" value="<?php echo $news_id; ?>" title="Checkbox for row <?php echo $i; ?>" />
                        <?php echo $newsletter->get('name'); ?>
                    </td>
                </tr>
                <?php
                $i++;
            }
            ?>


            <?php
            jincimport('frontend.jincinputstandard');
            jincimport('frontend.jincinputminimal');

            $renderer = ($input_style == INPUT_STYLE_MINIMAL) ?
                    new JINCInputMinimal() : new JINCInputStandard();

            $renderer->preRender();
            if ($public) {
                $attribute = new Attribute(-1);
                $attribute->set('name', 'user_mail');
                $attribute->set('type', ATTRIBUTE_TYPE_EMAIL);
                $attribute->set('name_i18n', 'COM_JINC_USERMAIL');

                $renderer->modRender($attribute, TRUE);
            }
            foreach ($attributes as $attr_name => $attr_value) {
                $attr = $ninstance->loadAttribute($attr_name);
                $renderer->modRender($attr, $attr_value == ATTRIBUTE_MANDATORY);
            }
            ?>

            <?php
            if ($captcha) {
                $renderer->modCaptchaRender();
            }
            ?>

            <?php
            foreach ($notices as $notice_id => $notice) {
                $notice_id = $notice->get('id');
                ?>
                <tr>
                    <td align="left" class="jinc_notice" id="notice_accept" style="padding: 3px;">
                        <input type="checkbox" name="notice[]" id="notice<?php echo $notice_id; ?>" value="<?php echo $notice_id; ?>" />
                        <a class="modal" rel="{handler: 'iframe', size: {x: 700, y: 500}, onClose: function() {}}"
                           href="<?php echo JRoute::_('index.php?option=com_jinc&view=notice&tmpl=component&id=' . $notice_id); ?>" >
                               <?php
                               echo $notice->get('title');
                               ?>
                        </a>
                        .
                        <?php
                        echo $notice->get('bdesc');
                        ?>
                    </td>
                </tr>
                <?php
            }
            ?>

        </table>
        <br><br>
        <input type="submit" class="btn" value="<?php echo JText::_('COM_JINC_SUBSCRIBE'); ?>">
        <input type="hidden" name="option" value="com_jinc">
        <input type="hidden" name="task" value="newsletter.multisubscribe">
        <input type="hidden" name="mod_jinc" value="true">
        <?php echo JHTML::_('form.token'); ?>
    </div>
</form>