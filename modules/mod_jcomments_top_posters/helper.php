<?php
// no direct access
defined('_JEXEC') or die;

class modJCommentsTopPostersHelper
{
	static function getList( &$params )
	{
		$db = JFactory::getDBO();
		$user = JFactory::getUser();

		$date = JFactory::getDate();
		$now = $date->toMySQL();

		$where = array();

		$interval = $params->get('interval', '');
		if (!empty($interval)) {

			$timestamp = $date->toUnix();

			switch($interval) {
				case 'day':
				 	$timestamp = strtotime('-1 day', $timestamp);
					break;

				case '1-week':
				 	$timestamp = strtotime('-1 week', $timestamp);
					break;

				case '2-week':
				 	$timestamp = strtotime('-2 week', $timestamp);
					break;

				case '1-month':
				 	$timestamp = strtotime('-1 month', $timestamp);
					break;

				case '3-month':
				 	$timestamp = strtotime('-3 month', $timestamp);
					break;

				case '6-month':
				 	$timestamp = strtotime('-6 month', $timestamp);
					break;

				case 'year':
				 	$timestamp = strtotime('-1 year', $timestamp);
					break;
				default:
				 	$timestamp = NULL;
					break;
			}

			if ($timestamp !== NULL) {
				$dateFrom = JFactory::getDate($timestamp);
				$dateTo = $date;

				$where[] = 'c.date BETWEEN ' . $db->Quote($dateFrom->toMySQL()) . ' AND ' . $db->Quote($dateTo->toMySQL());
			}
		}


		switch($params->get('ordering', ''))
		{
		        case 'votes':
		        	$orderBy = 'votes DESC';
		        	break;

			case 'comments':
			default:
		        	$orderBy = 'commentsCount DESC';
				break;
		}

		$where[] = 'c.published = 1';
		$where[] = 'c.deleted = 0';

		$query = "SELECT c.userid, '' as avatar, '' as profileLink"
			. " , CASE WHEN c.userid = 0 THEN c.email ELSE u.email END AS email"
			. " , CASE WHEN c.userid = 0 THEN c.name ELSE u.name END AS name"
			. " , CASE WHEN c.userid = 0 THEN c.username ELSE u.username END AS username"
			. " , COUNT(c.userid) AS commentsCount"
			. " , SUM(c.isgood) AS isgood, SUM(c.ispoor) AS ispoor, SUM(c.isgood - c.ispoor) AS votes"
			. " FROM #__jcomments AS c"
			. " LEFT JOIN #__users AS u ON u.id = c.userid"
			. (count($where) ? ' WHERE  ' . implode(' AND ', $where) : '')
			. " GROUP BY c.userid, email, name, username, avatar, profileLink"
			. " ORDER BY " . $orderBy
			;

		$db->setQuery($query, 0, $params->get('count'));
		$list = $db->loadObjectList();

		$show_avatar = $params->get('show_avatar', 0);

		if ($show_avatar) {
			JCommentsEvent::trigger('onPrepareAvatars', array(&$list));
		}

		foreach($list as &$item) {

			$item->displayAuthorName = JComments::getCommentAuthorName($item);

			if ($show_avatar && empty($item->avatar)) {
				$gravatar = md5(strtolower($item->email));
				$item->avatar = '<img src="http://www.gravatar.com/avatar.php?gravatar_id='. $gravatar .'&amp;default=' . urlencode(JCommentsFactory::getLink('noavatar')) . '" alt="'.htmlspecialchars(JComments::getCommentAuthorName($item)).'" />';
			}
		}

		return $list;
	}
}