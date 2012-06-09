<?php

/**
 * @version		$Id: newsletterfactory.php 2010-01-19 12:01:47Z lhacky $
 * @package		JINC
 * @subpackage          Core
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
/**
 * Requiring PHP libraries and defining constants
 */
require_once 'juserinforetriever.php';
require_once 'jcontactinforetriever.php';
require_once 'publicretriever.php';
require_once 'publicnewsletter.php';
require_once 'privatenewsletter.php';
require_once 'notice.php';

jimport('joomla.registry.registry');

/**
 * NewsletterFactory class, building Newsletter objects from a newsletter
 * ID and getting information from database.
 * This class implements the Factory Design Pattern.
 *
 * @package		JINC
 * @subpackage          Core
 * @since		0.6
 */
class NewsletterFactory {

    function NewsletterFactory() {

    }

    function &getInstance() {
        static $instance = null;
        if (null === $instance) {
            $instance = new NewsletterFactory();
        }
        return $instance;
    }

    /**
     * The newsletter loader. It loads a newsletter from his identifier.
     *
     * @access	public
     * @param	integer $id the newsletter identifier.
     * @param       boolean $frontend if true checks access and published
     * @return  The Newsletter object or -1 if newsletter not foud or false if something wrong.
     * @since	0.6
     * @see     Newsletter
     */
    function loadNewsletter($id, $only_published = false) {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $query = 'SELECT sendername, senderaddr, type, name, ' .
                'description, disclaimer, optin_subject, optin, ' .
                'welcome_subject, welcome, default_template, ' .
                'optinremove_subject, optinremove, on_subscription, ' .
                'jcontact_enabled, captcha, ' .
                'front_theme, front_max_msg, front_type, ' .
                'attribs, replyto_name, replyto_addr, ' .
                'notify, notice_id, input_style ' .
                'FROM #__jinc_newsletter n ' .
                'WHERE id = ' . (int) $id;
        $query .= ( $only_published) ? ' AND published = 1' : '';
        $logger->debug('NewsletterFactory: Executing query: ' . $query);
        $dbo = & JFactory::getDBO();
        $dbo->setQuery($query);
        // Loading newsletter information from database
        if ($result = $dbo->loadAssocList()) {
            if (empty($result)) {
                // Newsletter not found in database
                $logger->finer('NewsletterFactory: Newsletter not found');
                return false;
            }
            $newsletter = $result[0];
        } else {
            return false;
        }
        // Creating Newsletter based on type value
        switch ($newsletter['type']) {
            case NEWSLETTER_PUBLIC_NEWS:
                $logger->finer('NewsletterFactory: Building Public Newsletter with PublicRetriever');
                $retriever = new PublicRetriever($id);
                $newsObj = new PublicNewsletter($id, $retriever);
                $newsObj->set('optin_subject', $newsletter['optin_subject']);
                $newsObj->set('optin', $newsletter['optin']);
                $newsObj->set('optinremove_subject', $newsletter['optinremove_subject']);
                $newsObj->set('optinremove', $newsletter['optinremove']);
                break;
            default:
                $logger->finer('NewsletterFactory: Building Private Newsletter with JUserInfoRetriever');
                if ($newsletter['jcontact_enabled']) {
                    $retriever = new JContactInfoRetriever($id);
                } else {
                    $retriever = new JUserInfoRetriever($id);
                }
                $newsObj = new PrivateNewsletter($id, $retriever);
                break;
        }
        // Setting newsletter properties
        $newsObj->set('welcome', $newsletter['welcome']);
        $newsObj->set('welcome_subject', $newsletter['welcome_subject']);
        $newsObj->set('description', $newsletter['description']);
        $newsObj->set('disclaimer', $newsletter['disclaimer']);
        $newsObj->set('name', $newsletter['name']);
        $newsObj->set('senderaddr', $newsletter['senderaddr']);
        $newsObj->set('sendername', $newsletter['sendername']);
        $newsObj->set('replyto_addr', $newsletter['replyto_addr']);
        $newsObj->set('notify', $newsletter['notify']);
        $newsObj->set('replyto_name', $newsletter['replyto_name']);
        $newsObj->set('default_template', $newsletter['default_template']);
        $newsObj->set('on_subscription', $newsletter['on_subscription']);
        $newsObj->set('jcontact_enabled', $newsletter['jcontact_enabled']);
        $front_theme = ($newsletter['front_theme'] == '') ? NEWSLETTER_DEFAULT_THEME : $newsletter['front_theme'];
        $newsObj->set('front_theme', $front_theme);
        $newsObj->set('front_max_msg', $newsletter['front_max_msg']);
        $newsObj->set('front_type', $newsletter['front_type']);
        $attributes = new JRegistry('');
        $attributes->loadString($newsletter['attribs']);
        $newsObj->set('attributes', $attributes);
        $newsObj->set('captcha', $newsletter['captcha']);
        $newsObj->set('notice_id', $newsletter['notice_id']);
        $newsObj->set('input_style', $newsletter['input_style']);
        return $newsObj;
    }

    /**
     * The onSubscription newsletter list loader. A onSubscription newsletter is
     * a newsletter a user should be subscribed at subscription time
     *
     * @access	public
     * @return  array List onSubscription newsletter ids.
     * @since	0.6
     */
    function loadOnSubscriptionNewsletters() {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $ids = array();
        $query = 'SELECT id FROM #__jinc_newsletter n ' .
                'WHERE on_subscription = 1 AND published = 1';
        $logger->debug('NewsletterFactory: Executing query: ' . $query);
        $dbo = & JFactory::getDBO();
        $dbo->setQuery($query);
        // Loading newsletter information from database
        if ($result = $dbo->loadAssocList()) {
            foreach ($result as $row) {
                array_push($ids, (int) $row['id']);
            }
        } else {
            return false;
        }
        return $ids;
    }

    /**
     * The themes list loader. It produces the themes list searching for CSS
     * files into the theme directory.
     *
     * @access	public
     * @return  array List of themes.
     * @since	0.7
     */
    function loadThemes() {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $themes = array();

        $directory = JPATH_SITE . DS . 'components' . DS . 'com_jinc' . DS . 'assets' . DS . 'themes';
        $handler = opendir($directory);
        while ($file = readdir($handler)) {
            if (strtolower(substr($file, -4)) == '.css') {
                $opt = array('id' => $file, 'value' => substr($file, 0, -4));
                array_push($themes, $opt);
            }
        }
        closedir($handler);

        $logger->finer('NewsletterFactory: Found ' . count($themes) . ' themes');
        return $themes;
    }

    /**
     * The addictional attribute loader. It loads an attribute object from
     * database using the attribute name as search key
     *
     * @access	public
     * @return  Attribute the loaded attribute or false if sometring wrong.
     * @since	0.7
     */
    function loadAttribute($name) {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $query = 'SELECT id, description, type, table_name, name_i18n ' .
                'FROM #__jinc_attribute ' .
                'WHERE name = \'' . $name . '\'';
        $logger->debug('NewsletterFactory: Executing query: ' . $query);
        $dbo = & JFactory::getDBO();
        $dbo->setQuery($query);
        // Loading newsletter information from database
        if ($result = $dbo->loadAssocList()) {
            if (empty($result)) {
                // Newsletter not found in database
                $logger->finer('NewsletterFactory: Attribute not found');
                return false;
            }
            $attr = $result[0];
            $attribute = new Attribute($attr['id']);
            $attribute->set('name', $name);
            $attribute->set('description', $attr['description']);
            $attribute->set('type', $attr['type']);
            $attribute->set('table_name', $attr['table_name']);
            $attribute->set('name_i18n', $attr['name_i18n']);
            return $attribute;
        }
        return false;
    }

    /**
     * The addictional attributes list loader.
     *
     * @access	public
     * @return      array List of defined attributes or false if something wrong.
     * @since	0.7
     */
    function loadAttributesList() {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $attributes = array();
        $query = 'SELECT id, name, description, name_i18n FROM #__jinc_attribute';
        $logger->debug('NewsletterFactory: Executing query: ' . $query);
        $dbo = & JFactory::getDBO();
        $dbo->setQuery($query);
        // Loading newsletter information from database
        if ($result = $dbo->loadAssocList()) {
            foreach ($result as $row) {
                $element = array('id' => $row['id'], 'name' => $row['name'], 'description' => $row['description'], 'name_i18n' => $row['name_i18n']);
                array_push($attributes, $element);
            }
        } else {
            return false;
        }
        return $attributes;
    }

    /**
     * Load newsletter names.
     *
     * @access	public
     * @param  type 0 -> all, 1-> Private, 2-> Public
     * @return  array List of id/name pairs.
     * @since	0.7
     */
    function loadNames($type = 0) {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $query = 'SELECT id, name FROM #__jinc_newsletter';
        if ($type == 1) {
            $query .= ' WHERE type >= 1';
        }
        if ($type == 2) {
            $query .= ' WHERE type = 0';
        }

        $logger->debug('NewsletterFactory: executing query ' . $query);
        $dbo = & JFactory::getDBO();
        $dbo->setQuery($query);

        if ($result = $dbo->loadObjectList()) {
            return $result;
        }
        return false;
    }

    /**
     * The notice loader. It loads a notice from its identifier.
     *
     * @access	public
     * @param	integer $id the notice identifier.
     * @return  The notice object or false if something wrong.
     * @since	0.9
     * @see     Newsletter
     */
    function loadNotice($id) {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $query = 'SELECT name, title, bdesc, conditions ' .
                'FROM #__jinc_notice nt ' .
                'WHERE id = ' . (int) $id;
        $logger->debug('NewsletterFactory: Executing query: ' . $query);
        $dbo = & JFactory::getDBO();
        $dbo->setQuery($query);
        // Loading notice information from database
        if ($result = $dbo->loadAssocList()) {
            if (empty($result)) {
                // Newsletter not found in database
                $logger->finer('NewsletterFactory: Notice not found');
                return false;
            }
            $notice = $result[0];
        } else {
            return false;
        }

        $ntObj = new Notice($id);
        // Setting newsletter properties
        $ntObj->set('name', $notice['name']);
        $ntObj->set('title', $notice['title']);
        $ntObj->set('bdesc', $notice['bdesc']);
        $ntObj->set('conditions', $notice['conditions']);
        return $ntObj;
    }
}

?>
