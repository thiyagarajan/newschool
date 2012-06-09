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
JHTML::_('behavior.tooltip');
isset($this->newsletter) || die('Newsletter not found');
$newsletter = $this->newsletter;
$front_theme = $newsletter->get('front_theme') . '.css';

echo JHTML::stylesheet($front_theme, 'components/com_jinc/assets/themes/');
echo JHTML::script('components/com_jinc/assets/js/jinc.js');
echo JHTML::_('behavior.modal');
$id = $newsletter->get('id');
$news_type = $newsletter->getType();
$attrs = $newsletter->get('attributes');
$attrs_array = $attrs->toArray();
?>
<script language="JavaScript" type="text/javascript">
    function checkPublic( subscriptionForm ) {
        if (!isMail(subscriptionForm.user_mail.value)) {
            alert( "<?php echo JText::_('COM_JINC_ERR019_JS'); ?>" );
            subscriptionForm.user_mail.focus();
            return false;
        }
        return true;
    }

    function checkPrivate(subscriptionForm) {
        return true;
    }

    function checkAttributes() {
<?php
jincimport('core.newsletterfactory');
$ninstance = NewsletterFactory::getInstance();
foreach ($attrs_array as $attr_name => $attr_value) {
    if ($attr = $ninstance->loadAttribute($attr_name)) {
        echo 'var ' . $attr_name . '_field = document.getElementById(\'' . $attr_name . '\');';
        if ($attr_value == ATTRIBUTE_MANDATORY) {
            echo 'if(isEmpty(' . $attr_name . '_field.value)) {';
            echo 'alert("' . JText::_($attr->get('name_i18n')) . ' is a mandatory argument");';
            echo '' . $attr_name . '_field.focus();';
            echo 'return false;';
            echo '}';
        }
        if ($attr->get('type') == ATTRIBUTE_TYPE_INTEGER) {
            echo 'if ((!isEmpty(' . $attr_name . '_field.value)) && (!isInteger(' . $attr_name . '_field.value))) {';
            echo 'alert("' . JText::_($attr->get('name_i18n')) . ' must be an integer value");';
            echo '' . $attr_name . '_field.focus();';
            echo 'return false;';
            echo '}';
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

    function checkForm(subscriptionForm) {
        var notice_accept = subscriptionForm.getElementById('notice');
        if (notice_accept != undefined) {
            if (!(notice_accept.checked)) {
                alert("<?php echo JText::_('COM_JINC_ERR027_JS') ?>");
                return false;
            }
        }
        if (checkAttributes()) {

<?php
if ($news_type == NEWSLETTER_PUBLIC_NEWS)
    echo 'return checkPublic(subscriptionForm);';
else
    echo 'return checkPrivate(subscriptionForm);';
?>
        }
        return false;
    }
</script>

<div class="jinc_caption">
    <?php
    echo $newsletter->get('name');
    ?>
    <div class="jinc_commands">
    </div>
</div>

<div class="jinc_description">
    <?php
    echo $newsletter->get('description');
    ?>
</div>

<form action="<?php echo JRoute::_('index.php'); ?>" method="post" onSubmit="return checkForm(this);">
    <div class="jinc_frm_subscription">
        <table width="90%" border="0">
            <?php
            jincimport('frontend.jincinputstandard');
            jincimport('frontend.jincinputminimal');
            
            $renderer = ($newsletter->get('input_style') == INPUT_STYLE_MINIMAL)?
                    new JINCInputMinimal():new JINCInputStandard();

            $renderer->preRender();
            if ($news_type == NEWSLETTER_PUBLIC_NEWS) {
                $attribute = new Attribute(-1);
                $attribute->set('name', 'user_mail');
                $attribute->set('type', ATTRIBUTE_TYPE_EMAIL);
                $attribute->set('name_i18n', 'COM_JINC_USERMAIL');

                $renderer->render($attribute, TRUE);
            }
            foreach ($attrs_array as $attr_name => $attr_value) {
                $attr = $ninstance->loadAttribute($attr_name);
                $renderer->render($attr, $attr_value == ATTRIBUTE_MANDATORY);
            }
            ?>
            <?php
            if ($newsletter->get('captcha') > CAPTCHA_NO) {
                $renderer->captchaRender();
                }
            ?>

            <?php
                if (isset($this->notice)) {
                    $notice = $this->notice;
                    $notice_id = $notice->get('id');
            ?>
                    <tr>
                        <td colspan="2" align="left" class="jinc_notice" id="notice_accept">
                            <input type="checkbox" name="notice[]" id="notice" value="<?php echo $notice_id; ?>" />
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
                   <input type="hidden" name="task" value="newsletter.subscribe">
                   <input type="hidden" name="id" value="<?php echo $id; ?>">
        <?php echo JHTML::_('form.token'); ?>
                   </div>
               </form>
               <br>
<?php
                       if (isset($this->messages)) {
                           $messages = $this->messages;
                           if (!empty($messages)) {
                               jincimport('frontend.jincfrontendhelper');
                               JINCFrontnedHelper::listMessages($newsletter, $messages);
                           }
                       }
?>
