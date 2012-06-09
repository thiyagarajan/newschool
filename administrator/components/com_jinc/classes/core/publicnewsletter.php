<?php

/**
 * @version		$Id: publicnewsletter.php 20-gen-2010 17.06.09 lhacky $
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
include_once 'newsletter.php';

/**
 * PublicNewsletter class, defining a public newsletter.
 *
 * @package		JINC
 * @subpackage          Core
 * @since		0.6
 */
class PublicNewsletter extends Newsletter {

    /**
     * The newsletter Opt-In message subject
     *
     * @var		The newsletter Opt-In message subject
     * @access	protected
     * @since	0.6
     */
    var $optin_subject;
    /**
     * The newsletter Opt-In message
     *
     * @var		The newsletter Opt-In message
     * @access	protected
     * @since	0.6
     */
    var $optin;
    /**
     * The newsletter Opt-In remove message subject
     *
     * @var		The newsletter Opt-In message subject
     * @access	protected
     * @since	0.6
     */
    var $optinremove_subject;
    /**
     * The newsletter Opt-In remove message
     *
     * @var		The newsletter Opt-In message
     * @access	protected
     * @since	0.6
     */
    var $optinremove;

    /**
     * The PublicNewsletter constructor.
     *
     * @access	public
     * @param   integer news_id The newsletter identifier.
     * @param   SubsRetriever $subs_retriever The subscribers info retriever
     * @return	PublicNewsletter
     * @since	0.6
     * @see     Newsletter, NewsletterFactory
     */
    function PublicNewsletter($news_id, $subs_retriever = null) {
        if (is_null($subs_retriever))
            $subs_retriever = new PublicRetriever($news_id);
        parent::Newsletter($news_id, $subs_retriever);
    }

    /**
     * Method to know if a user has sufficient privileges to subscribe this
     * newsletter. Implements the parent abstract method.
     *
     * Hint: $subscriber_info must contain the 'email' field.
     * Hint: it checks the 'email' field presence and its format validity.
     *
     * @access	public
     * @param   array $subscriber_info Subscriber info based on newsletter type.
     * @return  true if can subscribe. false if not.
     * @since	0.6
     */
    function isSubscribed($subscriber_info) {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $email = $subscriber_info['email'];
        $query = 'SELECT email FROM #__jinc_subscriber ' .
                'WHERE email = \'' . $email . '\' ' .
                'AND news_id = ' . (int) $this->get('id');
        if (array_key_exists('waiting', $subscriber_info)) {
            if ($subscriber_info['waiting'] == false)
                $query .= ' AND random = \'\'';
        }
        $logger->debug('PublicNewsletter: Executing query: ' . $query);
        $dbo = & JFactory::getDBO();
        $dbo->setQuery($query);
        // Checking subscription existence
        if (($dbo->query()) && ($dbo->getNumRows() > 0)) {
            return true;
        }
        return false;
    }

    /**
     * Method to subscribe a user to the newsletter. Implements the parent
     * abstract method.
     *
     * Hint: $subscriber_info array description:
     *
     * $subscriber_info[email] - Email of the user to subscribe.
     * $subscriber_info[noptin] - If true the optin won't be sent and the user
     *                            will be directly subscribed to the newsletter.
     *
     * @access	public
     * @param   array $subscriber_info Subscriber info based on newsletter type.
     * @param   array $attributes Array of addictional attributes for subscription
     * @return  true if successfully subscribed. false if something wrong.
     * @since	0.6
     */
    function subscribe($subscriber_info, $attributes = null) {
        if (is_null($attributes) || !is_array($attributes))
            $attributes = array();

        jincimport('utility.randomizer');
        jincimport('utility.inputchecker');
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        if (!isset($subscriber_info['email'])) {
            $this->setError('COM_JINC_ERR008');
            return false;
        }

        $email = $subscriber_info['email'];
        if (!InputChecker::checkMail($email)) {
            $this->setError('COM_JINC_ERR012');
            return false;
        }

        if (!$this->checkMandatoryAttributes($attributes)) {
            $this->setError('COM_JINC_ERR048');
            return false;
        }

        if (!$this->isSubscribed($subscriber_info)) {
            $email = $subscriber_info['email'];
            $news_id = $this->get('id');
            if (isset($subscriber_info['noptin']) && $subscriber_info['noptin']) {
                $datasub = 'now()';
                $random = '';
            } else {
                jincimport('utility.randomizer');
                $datasub = 'NULL';
                $random = Randomizer::getRandomString();
            }
            $dbo = & JFactory::getDBO();
            $query = 'INSERT IGNORE INTO #__jinc_subscriber ' .
                    '(news_id , email, datasub, random) ' .
                    'VALUES (' . (int) $news_id . ', ' . $dbo->quote($email) . ', ' . $datasub .  ', ' . $dbo->quote($random) . ')';
            $logger->debug('PublicNewsletter: Executing query: ' . $query);

            $dbo->setQuery($query);
            if (!$dbo->query()) {
                $this->setError('COM_JINC_ERR013');
                return false;
            }

            $sub_id = $dbo->insertid();
            $logger->finer('PublicNewsletter: Inserting attribute addictional info: ' . $sub_id);
            $this->insertAttributeOnSubscription($sub_id, $attributes);

            if (strlen($random) > 0) {
                // Setting opt-in message
                $root_uri = JURI::root();
                $conf_url = $root_uri . 'index.php?option=com_jinc&task=newsletter.confirm&';
                $conf_url .= 'id=' . $news_id . '&';
                $conf_url .= 'random=' . urldecode($random) . '&';
                $conf_url .= 'user_mail=' . urldecode($email);
                $msg = $this->get('optin');

                $msg = preg_replace('/\[SENDER\]/s', $this->get('sendername'), $msg);
                $msg = preg_replace('/\[SENDERMAIL\]/s', $this->get('senderaddr'), $msg);
                $msg = preg_replace('/\[NEWSLETTER\]/s', $this->get('name'), $msg);
                $msg = preg_replace('/\[EMAIL\]/s', $email, $msg);
                $msg = preg_replace('/\[OPTIN_URL\]/s', $conf_url, $msg);
                foreach ($attributes as $attr_name => $attr_value) {
                    $msg = preg_replace('/\[ATTR_' . strtoupper($attr_name) . '\]/s', $attr_value, $msg);
                }

                $msg = preg_replace('#src[ ]*=[ ]*\"(?!https?://)(?:\.\./|\./|/)?#', 'src="' . $root_uri, $msg);
                $msg = preg_replace('#href[ ]*=[ ]*\"(?!https?://)(?!mailto?:)(?!tel?:)(?:\.\./|\./|/)?#', 'href="' . $root_uri, $msg);
				$msg = preg_replace('#url[ ]*\(\'(?!https?://)(?:\.\./|\./|/)?#', 'url(\'' . $root_uri, $msg);

                // Message composition
                $message = & JFactory::getMailer();
                $message->ContentType = "text/html";
                $message->setSubject($this->get('optin_subject'));
                $message->setBody($msg);
                if (strlen($this->get('senderaddr')) > 0)
                    $message->setSender(array($this->get('senderaddr'), $this->get('sendername')));
                if (strlen($this->get('replyto_addr')) > 0)
                    $message->addReplyTo(array($this->get('replyto_addr'), $this->get('replyto_name')));

                $message->addRecipient($email);
                $logger->finer('PublicNewsletter: Sending message to ' . $email . ' with body: ' . $msg);
                $result = $message->send();
                if (!$result) {
                    $this->setError(JText::_('COM_JINC_ERR001'));
                    return false;
                }
            }
        } else {
            $this->setError('COM_JINC_ERR015');
            return false;
        }
        if (isset($subscriber_info['noptin']) && $subscriber_info['noptin']) {
            $dispatcher = &JDispatcher::getInstance();
            $params = array('news_id' => $this->get('id'),
                'news_name' => $this->get('name'),
                'subs_name' => $subscriber_info['email'],
                'news_notify' => $this->get('notify'));

            $result = $dispatcher->trigger('jinc_subscribe', $params);
        }
        return true;
    }

    /**
     * Newsletter type getter.
     *
     * @access	public
     * @return  Newsletter type identifier
     * @since	0.6
     */
    function getType() {
        return NEWSLETTER_PUBLIC_NEWS;
    }

    /**
     * Returns information needed to subscribe a user to this newsletter.
     *
     * @access	public
     * @return  array() of fields necessary to subscribe a user to the newsletter
     * @since	0.6
     */
    function getSubscriptionInfo() {
        $info = array();
        array_push($info, 'email');
        $attributes = $this->attributes;
        foreach ($attributes->toArray() as $attr_name => $attr_value) {
            array_push($info, 'attr_' . $attr_name);
        }
        return $info;
    }

    /**
     * Method to unsubscribe a newsletter user.
     *
     * @access	public
     * @param   array $subscriber_info Subscriber info based on newsletter type.
     * @return  true if successfully unsubscribed. false if something wrong.
     * @since	0.6
     * @abstract
     */
    function unsubscribe($subscriber_info) {
        jincimport('utility.randomizer');
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $result = false;
        if (isset($subscriber_info['subs_id'])) {
            $id = (int) $subscriber_info['subs_id'];
            $query = 'DELETE FROM #__jinc_subscriber ' .
                    'WHERE id = ' . (int) $id . ' ' .
                    'AND news_id = ' . (int) $this->get('id');
            $logger->debug('PublicNewsletter: Executing query: ' . $query);
            $dbo = & JFactory::getDBO();
            $dbo->setQuery($query);
            if (!$dbo->query()) {
                $this->setError('COM_JINC_ERR025');
                return false;
            }
            $this->removeAttributeOnUnsubscription($id);
            // Triggering unsubscription event
            $dispatcher = &JDispatcher::getInstance();
            $params = array('news_id' => $this->get('id'));
            $result = $dispatcher->trigger('jinc_unsubscribe', $params);
            $result = true;
        }

        if (isset($subscriber_info['email'])) {
            $random = Randomizer::getRandomString();
            $email = $subscriber_info['email'];
            $news_id = $this->get('id');

            $dbo = & JFactory::getDBO();
            $query = 'UPDATE #__jinc_subscriber SET random = ' . $dbo->quote($random) . ' ' .
                    'WHERE news_id = ' . (int) $news_id . ' AND email = ' . $dbo->quote($email);
            $logger->debug('PublicNewsletter: Executing query: ' . $query);

            $dbo->setQuery($query);
            if (!$dbo->query()) {
                $this->setError('COM_JINC_ERR013');
                return false;
            }
            $root_uri = JURI::root();
            $conf_url = $root_uri . 'index.php?option=com_jinc&task=newsletter.delconfirm&';
            $conf_url .= 'id=' . $news_id . '&';
            $conf_url .= 'random=' . urldecode($random) . '&';
            $conf_url .= 'user_mail=' . urldecode($email);
            $msg = $this->get('optinremove');

            $msg = preg_replace('/\[SENDER\]/s', $this->get('sendername'), $msg);
            $msg = preg_replace('/\[SENDERMAIL\]/s', $this->get('senderaddr'), $msg);
            $msg = preg_replace('/\[NEWSLETTER\]/s', $this->get('name'), $msg);
            $msg = preg_replace('/\[EMAIL\]/s', $email, $msg);
            $msg = preg_replace('/\[OPTINREMOVE_URL\]/s', $conf_url, $msg);

            $msg = preg_replace('#src[ ]*=[ ]*\"(?!https?://)(?:\.\./|\./|/)?#', 'src="' . $root_uri, $msg);
            $msg = preg_replace('#href[ ]*=[ ]*\"(?!https?://)(?!mailto?:)(?!tel?:)(?:\.\./|\./|/)?#', 'href="' . $root_uri, $msg);
            $msg = preg_replace('#url[ ]*\(\'(?!https?://)(?:\.\./|\./|/)?#', 'url(\'' . $root_uri, $msg);

            // Message composition
            $message = & JFactory::getMailer();
            $message->ContentType = "text/html";
            $message->setSubject($this->get('optinremove_subject'));
            $message->setBody($msg);
            if (strlen($this->get('senderaddr')) > 0)
                $message->setSender(array($this->get('senderaddr'), $this->get('sendername')));
            if (strlen($this->get('replyto_addr')) > 0)
                $message->addReplyTo(array($this->get('replyto_addr'), $this->get('replyto_name')));

            $message->addRecipient($email);
            $logger->finer('PublicNewsletter: Sending message to ' . $email . ' with body: ' . $msg);
            $result = $message->send();
            if (!$result) {
                $this->setError(JText::_('COM_JINC_ERR001'));
                return false;
            }
            $result = true;
        }
        return $result;
    }

    /**
     * Gets TAGS to substitute in subscriber info for this newsletter.
     *
     * @access	public
     * @return	array Array of tags.
     * @since	0.6
     */
    function getTagsList() {
        $tags = array();
        $base_tags = array('NEWSLETTER', 'SENDER', 'SENDERMAIL', 'UNSUBSCRIPTIONURL');
        $optin_tags = array('OPTINREMOVE_URL', 'OPTIN_URL');
        $attributes = $this->attributes;
        $retriever = $this->_subs_retriever;
        $user_tags = $retriever->getTagsList($attributes->toArray());

        $tags['BASE'] = $base_tags;
        $tags['OPTIN'] = $optin_tags;
        $tags['USER'] = $user_tags;

        return $tags;
    }

    /**
     * Confirming public subscription using string sent by Opt-in
     *
     * @param string $usermail
     * @param string $optinstr
     * @return boolean true if subscription is successfully confirmed
     */
    function confirmSubscription($usermail, $optinstr) {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        $news_id = $this->get('id');
        $dbo = & JFactory::getDBO();
        $query = 'UPDATE #__jinc_subscriber SET random = \'\', datasub = now() ' .
                'WHERE email = ' . $dbo->quote($usermail) . ' ' .
                'AND news_id = ' . (int) $news_id . ' ' .
                'AND random = ' . $dbo->quote($optinstr);

        $logger->debug('PublicNewsletter: Executing query: ' . $query);
        $dbo->setQuery($query);
        $dbo->query();
        if ($dbo->getAffectedRows() > 0) {
            $query = 'SELECT s.id ';
            $i = 0;
            $news_attributes = $this->attributes;
            foreach ($news_attributes->toArray() as $attr_name => $attr_value) {
                $table_alias = 'att' . $i;
                $query .= ', ' . $table_alias . '.value as `attr_' . $attr_name . '`';
                $i++;
            }

            $query .= ' FROM #__jinc_subscriber s ';

            $i = 0;
            foreach ($news_attributes->toArray() as $attr_name => $attr_value) {
                $table_name = '`#__jinc_attribute_' . $attr_name . '`';
                $table_alias = 'att' . $i;
                $query .= ' LEFT JOIN ' . $table_name . ' ' . $table_alias .
                        ' ON s.id = ' . $table_alias . '.id AND s.news_id = ' . $table_alias . '.news_id ';
                $i++;
            }

            $query .= ' WHERE email = ' . $dbo->quote($usermail) . ' ' .
                    'AND s.news_id = ' . (int) $news_id;
            $dbo->setQuery($query);
            // Loading newsletter information from database
            if ($user_info = $dbo->loadAssoc()) {
                $user_info['email'] = $usermail;
            } else {
                $user_info = array();
            }
            $logger->debug('PublicNewsletter: Executing query: ' . $query);

            $attributes = array();
            foreach ($user_info as $attr_key => $attr_value) {
                $prefix = substr($attr_key, 0, 5);
                if ($prefix == 'attr_') {
                    $suffix = substr($attr_key, 5);
                    $attributes[$suffix] = $attr_value;
                }
            }
            
            $this->sendWelcome($user_info, $attributes);

            $logger->finer('PublicNewsletter: generating subscription event after user confirmation.');
            $dispatcher = &JDispatcher::getInstance();
            $params = array('news_id' => $this->get('id'),
                'news_name' => $this->get('name'),
                'subs_name' => $user_info['email'],
                'news_notify' => $this->get('notify'));
            $result = $dispatcher->trigger('jinc_subscribe', $params);
            return true;
        }
        return false;
    }

    /**
     * Confirming public unsubscription using string sent by Opt-in
     *
     * @param string $usermail
     * @param string $optinstr
     * @return boolean true if subscription is successfully confirmed
     */
    function confirmUnsubscription($usermail, $optinstr) {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();

        if (strlen($optinstr) == 0)
            return false;

        $news_id = $this->get('id');
        $dbo = & JFactory::getDBO();
        $query = 'DELETE FROM #__jinc_subscriber ' .
                'WHERE email = ' . $dbo->quote($usermail) . ' ' .
                'AND news_id = ' . (int) $news_id . ' AND ' .
                'random = ' . $dbo->quote($optinstr);
        $logger->debug('PublicNewsletter: Executing query: ' . $query);
        $dbo->setQuery($query);
        $dbo->query();

        if ($dbo->getAffectedRows() > 0) {
            $logger->finer('PublicNewsletter: generating unsubscription event after user confirmation.');
            // Triggering unsubscription event
            $dispatcher = &JDispatcher::getInstance();
            $params = array('news_id' => $this->get('id'));
            $result = $dispatcher->trigger('jinc_unsubscribe', $params);
            return true;
        }
        return false;
    }

}

?>
