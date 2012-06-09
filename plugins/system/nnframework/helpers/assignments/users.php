<?php
/**
 * NoNumber Framework Helper File: Assignments: Users
 *
 * @package			NoNumber Framework
 * @version			12.6.1
 *
 * @author			Peter van Westen <peter@nonumber.nl>
 * @link			http://www.nonumber.nl
 * @copyright		Copyright © 2012 NoNumber All Rights Reserved
 * @license			http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined('_JEXEC') or die;

/**
 * Assignments: Users
 */
class NNFrameworkAssignmentsUsers
{
	var $_version = '12.6.1';

	/**
	 * passUserGroupLevels
	 *
	 * @param <object> $params
	 * @param <array> $selection
	 * @param <string> $assignment
	 *
	 * @return <bool>
	 */
	function passUserGroupLevels(&$main, &$params, $selection = array(), $assignment = 'all')
	{
		$user = JFactory::getUser();

		if (version_compare(JVERSION, '1.6.0', 'l')) {
			$selection = $main->makeArray($selection);
			if (in_array(29, $selection)) {
				$selection[] = 18;
				$selection[] = 19;
				$selection[] = 20;
				$selection[] = 21;
			}
			if (in_array(30, $selection)) {
				$selection[] = 23;
				$selection[] = 24;
				$selection[] = 25;
			}
			$groups = $user->get('gid');
		} else {
			if (isset($user->groups) && !empty($user->groups)) {
				$groups = array_values($user->groups);
			} else {
				$groups = $user->getAuthorisedGroups();
			}
		}

		return $main->passSimple($groups, $selection, $assignment);
	}

	/**
	 * passUsers
	 *
	 * @param <object> $params
	 * @param <array> $selection
	 * @param <string> $assignment
	 *
	 * @return <bool>
	 */
	function passUsers(&$main, &$params, $selection = array(), $assignment = 'all')
	{
		$user = JFactory::getUser();

		return $main->passSimple($user->get('id'), $selection, $assignment);
	}
}