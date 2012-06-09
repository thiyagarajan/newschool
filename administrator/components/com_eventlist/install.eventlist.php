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

defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Executes additional installation processes
 *
 * @since 0.1
 */
 
                                                                                                                                                                 
//Method to fix the admin menu creation error                                                                                                                    
 function fixadminmenu () {                                                                                                                                      
                                                                                                                                                                 
/*                                                                                                                                                               
Riccardo Zorn, Aug 29th, 2011.  Changes for Joomla 1.7!, there was an error creating the admin menu.                                                             
	In detail, the error was that the menu item for some (unresearched) reason was created with the component_id = 0                                             
	*/                                                                                                                                                           
                                                                                                                                                                 
     // Initialise variables.                                                                                                                                    
		$db		= JFactory::getDbo();                                                                                                                            
		$table	= JTable::getInstance('menu');                                                                                                                   
		$option = 'com_eventlist';                                                                                                                               
                                                                                                                                                                 
                                                                                                                                                                 
		// Try to get corrupted menu entries of Eventlist                                                                                                        
		$query	= $db->getQuery(true);                                                                                                                           
		$query->select("m.id, m.lft, m.rgt");                                                                                                                    
		$query->from("#__menu AS m");                                                                                                                            
		$query->where("m.parent_id = 1");                                                                                                                        
		$query->where("m.client_id = 1");                                                                                                                        
		$query->where("m.component_id = 0");                                                                                                                     
		$query->where("m.title = ".$db->quote('COM_EVENTLIST'));                                                                                                 
		                                                                                                                                                         
		$db->setQuery($query);                                                                                                                                   
                                                                                                                                                                 
		$componentrow = $db->loadObject();                                                                                                                       
		                                                                                                                                                         
	                                                                                                                              
		                                                                                                                             
                                                                                                                                                                 
                                                                                                                                                                 
		// Check if menu items for Eventlist items with corrupted component_id=0 exist                                                                           
		if ($componentrow) {                                                                                                                                     
		                                                                                                                                                         
		                                                                                                                                                         
                                                                                                                                                                 
			// Lets find the extension id of Eventlist                                                                                                           
			$query->clear();                                                                                                                                     
			$query->select('e.extension_id');                                                                                                                    
			$query->from('#__extensions AS e');                                                                                                                  
			$query->where('e.element = '.$db->quote($option));                                                                                                   
                                                                                                                                                                 
			$db->setQuery($query);                                                                                                                               
                                                                                                                                                                 
			$component_id = $db->loadResult();                                                                                                                   
		                                                                                                                                                         
			                                                                                                                                                     
			                                                                                                                                                     
		$query = "update #__menu set component_id=".$component_id." where"		                                                                                 
			." parent_id = 1"                                                                                                                                    
			." and client_id = 1"                                                                                                                                
			." and component_id = 0"                                                                                                                             
			." and title = ".$db->quote('COM_EVENTLIST');                                                                                                        
		                                                                                                                                                         
	                                                                                                                                                             
		                                                                                                                                                         
		$db->setQuery($query);                                                                                                                                   
	    if ($db->query())                                                                                                                                        
	    {                                                                                                                                                        
       	$erfolgsnachricht="<font color='red' size=6>Eventlist successfully fixed the Admin Menu Error</font>";                                                   
        echo $erfolgsnachricht;                                                                                                                                  
        } 	                                                                                                                                                     
        }                                                                                                                                                        
}                                                                                                                                                                
                                                                                                                                                                 
function com_install() {                                                                                                                                         
                                                                                                                                                                 
	jimport( 'joomla.filesystem.folder' );                                                                                                                       
	fixadminmenu();                                                                                                                                              
?>                                                                                                                                                               
                                                              
<center>
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
	<tr>
		<td valign="top">
    		<img src="<?php echo 'components/com_eventlist/assets/images/evlogo.png'; ?>" height="108" width="250" alt="EventList Logo" align="left">
		</td>
		<td valign="top" width="100%">
       	 	<strong>EventList</strong><br/>
        	<font class="small">by <a href="http://www.schlu.net" target="_blank">schlu.net </a><br/>
        	Released under the terms and conditions of the <a href="http://www.gnu.org/licenses/gpl-2.0.html" target="_blank">GNU General Public License</a>.
        	</font>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<code>Installation Status:<br />
			<?php
			// Check for existing /images/eventlist directory
			if ($direxists = JFolder::exists( JPATH_SITE.'/images/eventlist' )) {
				echo "<font color='green'>FINISHED:</font> Directory /images/eventlist exists. Skipping creation.<br />";
			} else {
				echo "<font color='orange'>Note:</font> The Directory /images/eventlist does NOT exist. EventList will try to create them.<br />";

				//Image folder creation 
				if ($makedir = JFolder::create( JPATH_SITE.'/images/eventlist')) {
					echo "<font color='green'>FINISHED:</font> Directory /images/eventlist created.<br />";
				} else {
					echo "<font color='red'>ERROR:</font> Directory /images/eventlist NOT created.<br />";
				}
				
                $path = "file_path";
                $mediaparams = JComponentHelper::getParams('com_media');
                if (JFolder::create(JPATH_SITE.'/'.$mediaparams->get($path, 'images').'/eventlist/categories')) {
					echo "<font color='green'>FINISHED:</font> Directory ".$mediaparams->get($path, 'images')."/eventlist/categories created.<br />";
				} else {
					echo "<font color='red'>ERROR:</font> Directory ".$mediaparams->get($path, 'images')."/eventlist/categories NOT created.<br />";
				}

				if (JFolder::create(JPATH_SITE.'/images/eventlist/events')) {
					echo "<font color='green'>FINISHED:</font> Directory /images/eventlist/events created.<br />";
				} else {
					echo "<font color='red'>ERROR:</font> Directory /images/eventlist/events NOT created.<br />";
				}
				if (JFolder::create( JPATH_SITE.'/images/eventlist/events/small')) {
					echo "<font color='green'>FINISHED:</font> Directory /images/eventlist/events/small created.<br />";
				} else {
					echo "<font color='red'>ERROR:</font> Directory /images/eventlist/events/small NOT created.<br />";
				}
				if (JFolder::create( JPATH_SITE.'/images/eventlist/venues')) {
					echo "<font color='green'>FINISHED:</font> Directory /images/eventlist/venues created.<br />";
				} else {
					echo "<font color='red'>ERROR:</font> Directory /images/eventlist/venues NOT created.<br />";
				}
				if (JFolder::create( JPATH_SITE.'/images/eventlist/venues/small')) {
					echo "<font color='green'>FINISHED:</font> Directory /images/eventlist/venues/small created.<br />";
				} else {
					echo "<font color='red'>ERROR:</font> Directory /images/eventlist/venues/small NOT created.<br />";
				}
			}
        	?>

			<br />

			<?php
			if (($direxists) || ($makedir)) {
			?>
				<font color="green"><b>Joomla! EventList Installed Successfully!</b></font><br />
				Ensure that EventList has write access to the directories shown above! Have Fun.
				</code>
			<?php
			} else {
			?>
				<font color="red">
				<b>Joomla! EventList could NOT be installed successfully!</b>
				</font>
				<br /><br />
				Please check following directories:<br />
				</code>
				<ul>
					<li>/images/eventlist</li>
					<li>/images/eventlist/categories</li>
					<li>/images/eventlist/events</li>
					<li>/images/eventlist/events/small</li>
					<li>/images/eventlist/venues</li>
					<li>/images/eventlist/venues/small</li>
				</ul>
				<br />

				<code>
					If they do not exist, create them and ensure EventList has write access to these directories.<br />
					If you don't so, you prevent EventList from functioning correctly. (You can't upload images).
				</code>
			<?php
			}
			?>
		</td>
	</tr>
</table>

</center>
<?php
}
?>