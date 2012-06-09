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
jimport('joomla.plugin.plugin');
jimport('joomla.filesystem.file');

// Preload the JINCFactory
jimport('joomla.filesystem.file');
require_once JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_jinc' . DS . 'classes' . DS . 'factory.php';

$lang = JFactory::getLanguage();
$lang->load('com_jinc');

jincimport('core.newsletterfactory');
$input_style = $params->get('mod_input_style', INPUT_STYLE_STANDARD);
$ninstance = NewsletterFactory::getInstance();
$user = JFactory::getUser();

$ids = $params->get('id', 0);
$notices = array();
$newsletters = array();
$attributes = array();
$public = false;
$captcha = false;
foreach ($ids as $id) {
    if ($newsletter = $ninstance->loadNewsletter($id, true)) {
        if (($newsletter->getType() == NEWSLETTER_PRIVATE_NEWS) && ($user->guest)) {
            // echo JText::_('COM_JINC_ERR005');
        } else {
            if ($user->authorise('jinc.subscribe', 'com_jinc.newsletter.' . $id)) {
                $newsletters[$id] = $newsletter;
                if ($newsletter->get('notice_id') > 0) {
                    if (($notice = $ninstance->loadNotice($newsletter->get('notice_id')))) {
                        $notice_id = (int) $newsletter->get('notice_id');
                        $notices[$notice_id] = $notice;
                    }
                }
                $attrs = $newsletter->get('attributes');
                $attrs_array = $attrs->toArray();
                foreach ($attrs_array as $attr_name => $attr_value) {
                    if (!isset ($attributes[$attr_name]) || ($attributes[$attr_name] != ATTRIBUTE_MANDATORY)) {
                        $attributes[$attr_name] = $attr_value;
                    }
                }
                if ($newsletter->getType() == NEWSLETTER_PUBLIC_NEWS)
                    $public = true;
                if ($newsletter->get('captcha') > CAPTCHA_NO)
                    $captcha = true;
            }
        }
    }
}
$layout = JModuleHelper::getLayoutPath('mod_jinc_multisubscription');
require($layout);
?>