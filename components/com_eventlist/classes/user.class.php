<?php
/**
 * @version 1.0.2 Stable $Id$
 * @package Joomla
 * @subpackage EventList
 * @copyright (C) 2005 - 2009 Christoph Lukes
 * @license GNU/GPL, see LICENSE.php
 * EventList is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License 2
 * as published by the Free Software Foundation.

 * EventList is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with EventList; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

defined('_JEXEC') or die('Restricted access');

/**
 * Holds all authentication logic
 *
 * @package Joomla
 * @subpackage EventList
 * @since 0.9
 */
class ELUser {

	/**
	 * Checks access permissions of the user regarding on the groupid
	 *
	 * @author Christoph Lukes
	 * @since 0.9
	 *
	 * @param int $recurse
	 * @param int $level
	 * @return boolean True on success
	 */
	function validate_user ( $recurse, $level )
	{
		$user 		= & JFactory::getUser();

		//only check when user is logged in
		if ( $user->get('id') ) {
			//open for superuser or registered and thats all what is needed
			//level = -1 all registered users
			//level = -2 disabled
			if ((( $level == -1 ) && ( $user->get('id') )) || (( JFactory::getUser()->authorise('core.manage') ) && ( $level == -2 ))) {
				return true;
			}
		//end logged in check
		} 
		//oh oh, user has no permissions
		return false;
	}

	/**
	 * Checks if the user is allowed to edit an item
	 *
	 * @author Christoph Lukes
	 * @since 0.9
	 *
	 * @param int $allowowner
	 * @param int $ownerid
	 * @param int $recurse
	 * @param int $level
	 * @return boolean True on success
	 */
	function editaccess($allowowner, $ownerid, $recurse, $level)
	{
		$user		= & JFactory::getUser();

		$generalaccess = ELUser::validate_user( $recurse, $level );

		if ($allowowner == 1 && ( $user->get('id') == $ownerid && $ownerid != 0 ) ) {
			return true;
		} elseif ($generalaccess == 1) {
			return true;
		}
		return false;
	}
    //Since 1.0.2
    //New admin check function
    function hasadminrights ()
    {
       if (JFactory::getUser()->authorise('core.manage')){
           return true;
       }
       return false;
    }
    
    //Since 1.0.2
    //Checks if an events�s category is maintained by a group
    function groupmaintained($checkeventid)
    {
        $db 	= JFactory::getDBO();
	    $query = 'SELECT catsid'
				. ' FROM #__eventlist_events'
				. ' WHERE id = '.$checkeventid
				;
		$db->setQuery( $query );
		$groupidofevent = $db->loadResult();

        $query = 'SELECT groupid'
				. ' FROM #__eventlist_categories'
				. ' WHERE published = 1'
				. ' AND id = '.$groupidofevent
				;
		$db->setQuery( $query );
        $groupismaintained = $db->loadResult();
        if ($groupismaintained==0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

	/**
	 * Checks if the user is a superuser
	 * A superuser will allways have access if the feature is activated
	 *
	 * @since 0.9
	 * 
	 * @return boolean True on success
	 */
	function superuser()
	{
		$user 		= & JFactory::getUser();
		
		$group_ids = array(
					24, //administrator
					25 //super administrator
					);
		return in_array($user->get('gid'), $group_ids);
	}

	/**
	 * Checks if the user has the privileges to use the wysiwyg editor
	 *
	 * We could use the validate_user method instead of this to allow to set a groupid
	 * Not sure if this is a good idea
	 *
	 * @since 0.9
	 * 
	 * @return boolean True on success
	 */
		function editoruser()
	{
		$user 		= & JFactory::getUser();
	//	jimport('joomla.access.access');
        $userGroups = JAccess::getGroupsByUser($user->id, true);

		$group_ids = array(
		// Uncomment to allow registered users to get an HTML capable editor
 				//	2, //registered -
				//	3, //author
					4, //editor
					5, //publisher
					6, //manager
					7, //administrator
				   	8, //Super Users
					);

		foreach ($userGroups as $value)	{
				if (in_array($value, $group_ids)) return true;
		}

		return false;
	}

	/**
	 * Checks if the user is a maintainer of a category
	 *
	 * @since 0.9
	 */
	function ismaintainer()
	{
		//lets look if the user is a maintainer
		$db 	= JFactory::getDBO();
		$user	= & JFactory::getUser();

		$query = 'SELECT g.group_id'
				. ' FROM #__eventlist_groupmembers AS g'
				. ' WHERE g.member = '.(int) $user->get('id')
				;
		$db->setQuery( $query );

		$catids = $db->loadResultArray();

		//no results, no maintainer
		if (!$catids) {
			return null;
		}

		$categories = implode(' OR groupid = ', $catids);

		//count the maintained categories
		$query = 'SELECT COUNT(id)'
				. ' FROM #__eventlist_categories'
				. ' WHERE published = 1'
				. ' AND groupid = '.$categories
				;
		$db->setQuery( $query );

		$maintainer = $db->loadResult();

		return $maintainer;
	}
}