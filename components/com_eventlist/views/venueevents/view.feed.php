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

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the Venueevents View
 *
 * @package Joomla
 * @subpackage EventList
 * @since 0.9
 */
class EventListViewVenueevents extends JView
{
	/**
	 * Creates the Event Feed of the Venue
	 *
	 * @since 0.9
	 */
	function display( )
	{
		global $app;

		$doc 		= & JFactory::getDocument();
		$elsettings = & ELHelper::config();

		// Get some data from the model
		JRequest::setVar('limit', $app->getCfg('feed_limit'));
		$rows = & $this->get('Data');

		foreach ( $rows as $row )
		{
			// strip html from feed item title
			$title = $this->escape( $row->title );
			$title = html_entity_decode( $title );

			// strip html from feed item category
			$category = $this->escape( $row->catname );
			$category = html_entity_decode( $category );

			//Format date
			$date = strftime( $elsettings->formatdate, strtotime( $row->dates ));
			if (!$row->enddates) {
				$displaydate = $date;
			} else {
				$enddate 	= strftime( $elsettings->formatdate, strtotime( $row->enddates ));
				$displaydate = $date.' - '.$enddate;
			}

			//Format time
			if ($row->times) {
				$time = strftime( $elsettings->formattime, strtotime( $row->times ));
				$time = $time.' '.$elsettings->timename;
				$displaytime = $time;
			}
			if ($row->endtimes) {
				$endtime = strftime( $elsettings->formattime, strtotime( $row->endtimes ));
				$endtime = $endtime.' '.$elsettings->timename;
				$displaytime = $time.' - '.$endtime;
			}

			// url link to article
			// & used instead of &amp; as this is converted by feed creator
			$link = 'index.php?option=com_eventlist&view=details&id='. $row->id;
			$link = JRoute::_( $link );

			// feed item description text
			$description = JText::_( 'COM_EVENTLIST_TITLE' ).': '.$title.'<br />';
			$description .= JText::_( 'COM_EVENTLIST_VENUE' ).': '.$row->venue.' / '.$row->city.'<br />';
			$description .= JText::_( 'COM_EVENTLIST_CATEGORY' ).': '.$category.'<br />';
			$description .= JText::_( 'COM_EVENTLIST_DATE' ).': '.$displaydate.'<br />';
			$description .= JText::_( 'COM_EVENTLIST_TIME' ).': '.$displaytime.'<br />';
			$description .= JText::_( 'COM_EVENTLIST_DESCRIPTION' ).': '.$row->datdescription;

			@$created = ( $row->created ? date( 'r', strtotime($row->created) ) : '' );

			// load individual item creator class
			$item = new JFeedItem();
			$item->title 		= $title;
			$item->link 		= $link;
			$item->description 	= $description;
			$item->date			= $created;
			$item->category   	= $category;

			// loads item info into rss array
			$doc->addItem( $item );
		}
	}
}
?>