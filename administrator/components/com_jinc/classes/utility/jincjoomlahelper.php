<?php
/**
 * @version		$Id: jincjoomlahelper.php 26-gen-2010 14.39.48 lhacky $
 * @package		JINC
 * @subpackage          Utility
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
 * JINCJoomlaHelper class, providing functions to interact with Joomla!.
 *
 * @package		JINC
 * @subpackage          Utility
 * @since		0.6
 */

class JINCJoomlaHelper {
/**
 * Joomla! user creator.
 *
 * @access	public
 * @param	string $username the username used for login.
 * @param	string $name the name of the user.
 * @param	string $email the user email.
 * @return      the new user identifier or false if something wrong.
 * @since	0.6
 */
    function userCreate($username, $name, $email) {
        $user = new JUser();
        $data = array("username" => $username, "name" => $name,
            "email" => $email, "usertype" => "Registered", "gid" => 18);
        $user->bind($data);
        $user->setParam('admin_language', '');
        if ($user->save()) {
            return $user->id;
        }
        return false;
    }

    /**
     * Joomla! user existence checker.
     *
     * @access	public
     * @param	string $username the username used for login.
     * @param	string $name the name of the user.
     * @param	string $email the user email.
     * @return  the user identifier or false is user does not exists.
     * @since	0.6
     */
    function userExists($username, $name, $email) {
        $dbo =& JFactory::getDBO();
        $query = 'SELECT id FROM #__users ' .
            'WHERE username = ' . $dbo->quote($username) . ' ' .
            'AND name  = ' . $dbo->quote($name) . ' ' .
            'AND email = ' . $dbo->quote($email);
        
        $dbo->setQuery($query);
        // Checking subscription existence
        if ($user_info = $dbo->loadObjectList()) {
            if (! empty ($user_info)) {
                $user = $user_info[0];
                return $user->id;
            }
        }
        return false;
    }

        /**
     * Joomla! user information loader. Loads username, name and email from a
     * user identifier.
     *
     * @access	public
     * @param	integer $userid the user identifier.
     * @return  array Containing id, username, name and email. An empty array is
     *                something wrong.
     * @since	0.6
     */
    function getUserInfo($user_id) {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();
        
        $query = 'SELECT id, username, name, email FROM #__users ' .
            'WHERE id = ' . (int) $user_id;
        $dbo =& JFactory::getDBO();
        $dbo->setQuery($query);
        $logger->debug('JINCJoomlaHelper: executing query: ' . $query);
        $infos = array();
        if ($user_info = $dbo->loadObjectList()) {
            if (! empty ($user_info)) {
                $user = $user_info[0];                
                $infos['user_id'] = $user->id;
                $infos['username'] = $user->username;
                $infos['name'] = $user->name;
                $infos['email'] = $user->email;
            }
            return $infos;
        }
        return $infos;
    }

    /**
     * Joomla! user finder. It finds user id by username
     *
     * @access	public
     * @param	integer $username the user name.
     * @return  array Containing username, name and email. An empty array is
     *                something wrong.
     * @since	0.8
     */
    function getUserInfoByUsername($username) {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();
        
        $dbo =& JFactory::getDBO();
        $query = 'SELECT id, username, name, email FROM #__users WHERE username = ' . $dbo->quote($username);
        $dbo->setQuery($query);
        $logger->debug('JINCJoomlaHelper: executing query: ' . $query);
        $infos = array();
        if ($user_info = $dbo->loadObjectList()) {
            if (! empty ($user_info)) {
                $user = $user_info[0];
                $infos['id'] = $user->id;
                $infos['username'] = $user->username;
                $infos['name'] = $user->name;
                $infos['email'] = $user->email;
            }
        }
        return $infos;
    }

    /**
     * Joomla! user finder. It finds user id by mail address
     *
     * @access	public
     * @param	integer $usermail the user mail.
     * @return  array Containing username, name and email. An empty array is
     *                something wrong.
     * @since	0.8
     */
    function getUserInfoByUsermail($usermail) {
        jincimport('utility.servicelocator');
        $servicelocator = ServiceLocator::getInstance();
        $logger = $servicelocator->getLogger();
        
        $dbo =& JFactory::getDBO();
        $query = 'SELECT id, username, name, email FROM #__users WHERE email = ' . $dbo->quote($usermail);
        $dbo->setQuery($query);        
         $logger->debug('JINCJoomlaHelper: executing query: ' . $query);
         $infos = array();
        if ($user_info = $dbo->loadObjectList()) {
            if (! empty ($user_info)) {
                $user = $user_info[0];
                $infos['id'] = $user->id;
                $infos['username'] = $user->username;
                $infos['name'] = $user->name;
                $infos['email'] = $user->email;
            }
        }
        return $infos;
    }
}
?>
