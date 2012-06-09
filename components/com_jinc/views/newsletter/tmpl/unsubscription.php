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
isset($this->newsletter) || die('Newsletter not found');
$newsletter = $this->newsletter;
$id = $newsletter->get('id');
$news_type = $newsletter->getType();
$front_theme = $newsletter->get('front_theme') . '.css';
echo JHTML::stylesheet($front_theme, 'components/com_jinc/assets/themes/');
echo JHTML::script('components/com_jinc/assets/js/jinc.js');
jincimport('utility.parameterprovider');
$num_msg = ParameterProvider::getDefaultNumMessages();
?>
<div class="jinc_caption">
    <?php
    echo $newsletter->get('name');
    ?>
</div>
<form action="<?php echo JRoute::_('index.php'); ?>" method="post">
    <div class="jinc_frm_subscription">
        <?php
        if ($news_type == NEWSLETTER_PUBLIC_NEWS) {
            ?>
            <?php echo JText::_('COM_JINC_USERMAIL'); ?>:&nbsp;&nbsp;&nbsp;
        <input type="text" name="user_mail">
        <?php
        } else {
            echo JText::_('COM_JINC_UNSUBSCRIBE');
        }
        ?>
        <br><br>
        <input type="submit" class="btn" value="<?php echo JText::_('COM_JINC_UNSUBSCRIBE'); ?>">
        <input type="hidden" name="option" value="com_jinc">
        <input type="hidden" name="task" value="newsletter.unsubscribe">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <?php echo JHTML::_( 'form.token' ); ?>
    </div>
</form>
