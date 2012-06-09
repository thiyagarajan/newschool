<?php
/**
 * @version 1.0.2 $Id$
 * @package Joomla
 * @subpackage EventList
 * @copyright (C) 2005 - 2009 Christoph Lukes
 * @copyright (C) 2011 Edmond Duggan
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
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

//TODO: Improve error handling

/**
 * EventList Component Sampledata Model
 *
 * @package Joomla
 * @subpackage EventList
 * @since		0.9
 */
class EventListModelSampledata extends JModel
{
	/**
	 * files data array
	 *
	 * @var array
	 */
	var $_filelist = array();
	
	/**
	 * Constructor
	 *
	 * @since 0.9
	 */
	function __construct()
	{
		parent::__construct();
		
		if ($this->_check()) {
		
			JError::raiseWarning('SOME ERROR CODE', JText::_('COM_EVENTLIST_DATA_ALREADY_INSTALLED'));
			return false;
		}
		
		$this->_filelist = $this->_unpack();
	}
	
	 /**
	 * Process sampledata
	 *
	 * @access public
	 * @return true on success
	 * @since 0.9
	 */
	function loaddata()
	{	
		//determine sql file
		
		foreach ($this->_filelist['files'] as $key => $file)
		{
			if (JFile::getExt($file) == 'sql') {
				$scriptfile = $file;
				unset($this->_filelist['files'][$key]);
			}
		}
		
		//load sql file
		if( !($buffer = file_get_contents($this->_filelist['folder'].DS.$scriptfile)) )
		{
			return false;
		}
		
		//extract queries out of sql file
		$queries = $this->_splitSql($buffer);

		//Process queries
		foreach ($queries as $query)
		{
			$query = trim($query);
			if ($query != '' && $query {0} != '#')
			{
				$this->_db->setQuery($query);
				$this->_db->query();
			}
		}
		
		//move images in proper directory
		$this->_moveimages();

		
		//delete temporary extraction folder
		if(!$this->_deletetmp()) {
			JError::raiseWarning('SOME ERROR CODE', JText::_('COM_EVENTLIST_UNABLE_TO_DELETE_TMP_FOLDER'));
		}
		
		return true; 
	}
	
	/**
	 * Unpack archive and build array of files
	 *
	 * @access private
	 * @return array
	 * @since 0.9
	 */
	function _unpack()
	{
		jimport('joomla.filesystem.archive');
		
		$filename	= 'sampledata.tar';
		$archive 	= JPATH_COMPONENT_ADMINISTRATOR.DS.'assets'.DS.$filename;
		
		// Temporary folder to extract the archive into
		$tmpdir = uniqid('sample_');
        
		// Clean the paths to use for archive extraction
		$extractdir = JPath::clean(JPATH_ROOT.DS.'tmp'.DS.$tmpdir);
		
		$archive 	= JPath::clean($archive);

		//extract archive
		//JArchive will not extract a tar.gz file in Joomla 1.6 RC 1 on a WAMP 2.0 server with PHP 5.3
		//Thus the archive was un .gz'd and the $filename (above) was changed accordingly. EFD 20110108
		$result = JArchive::extract( $archive, $extractdir);


		if ( $result === false ) {
			JError::raiseWarning('SOME ERROR CODE', JText::_('COM_EVENTLIST_UNABLE_TO_EXTRACT_ARCHIVE'));
			return false;
		}

		//return the files found in the extract folder and also folder name
		$files = array();
		
		if ($handle = opendir( $extractdir ))
		{
			while (false !== ($file = readdir($handle)))
			{
				if ($file != "." && $file != "..")
				{
					$files[] = $file;
					continue;
				}
			}
			closedir($handle);
		}
		
		$_filelist['files'] 	= $files;
		$_filelist['folder'] 	= $extractdir;
		
		return $_filelist; 
			 
	}
	
	/**
	 * Split sql to single queries
	 *
	 * @access private
	 * @return array
	 * @since 0.9
	 */
	function _splitsql($sql)
	{

		$sql 		= trim($sql);
		$sql 		= preg_replace("/\n\#[^\n]*/", '', "\n".$sql);
		$buffer 	= array();
		$ret 		= array();
		$in_string 	= false;

		for ($i = 0; $i < strlen($sql) - 1; $i ++) {
			if ($sql[$i] == ";" && !$in_string)
			{
				$ret[] = substr($sql, 0, $i);
				$sql = substr($sql, $i +1);
				$i = 0;
			}

			if ($in_string && ($sql[$i] == $in_string) && $buffer[1] != "\\")
			{
				$in_string = false;
			}
			elseif (!$in_string && ($sql[$i] == '"' || $sql[$i] == "'") && (!isset ($buffer[0]) || $buffer[0] != "\\"))
			{
				$in_string = $sql[$i];
			}
			if (isset ($buffer[1]))
			{
				$buffer[0] = $buffer[1];
			}
			$buffer[1] = $sql[$i];
		}

		if (!empty ($sql))
		{
			$ret[] = $sql;
		}
		return ($ret); 
	}
	
	/**
	 * Copy images into the venues/events folder
	 *
	 * @access private
	 * @return true on success
	 * @since 0.9
	 */
	function _moveimages()
	{

		$imagebase = JPATH_ROOT.DS.'images'.DS.'eventlist';

		foreach ($this->_filelist['files'] as $file)
		{
			if  (substr_count($file,"event")) 
				{
			   		JFile::copy($this->_filelist['folder'].DS.$file, $imagebase.DS.'events'.DS.$file);
				}
			if  (substr_count($file,"evthumb"))
				{
			   		JFile::copy($this->_filelist['folder'].DS.$file, $imagebase.DS.'events'.DS.'small'.DS.$file);
				}
                	
			if  (substr_count($file,"venue"))
				{
			   		JFile::copy($this->_filelist['folder'].DS.$file, $imagebase.DS.'venues'.DS.$file);
				}
			if  (substr_count($file,"vethumb"))
				{
			   		JFile::copy($this->_filelist['folder'].DS.$file, $imagebase.DS.'venues'.DS.'small'.DS.$file);
				}	
		
			if  (substr_count($file,"cat"))
				{
			   		JFile::copy($this->_filelist['folder'].DS.$file, $imagebase.DS.'categories'.DS.$file);
				} 
		}
		
		return true; 
	}
	
	/**
	 * Delete temporary folder
	 *
	 * @access private
	 * @return true on success
	 * @since 0.9
	 */
	function _deletetmp()
	{

		if ($this->_filelist['folder']) {
			if (!JFolder::delete($this->_filelist['folder'])) {
				return false;
			}
			return true;
		}
		return false; 
	}
	
	/**
	 * Checks if Data exist
	 *
	 * @access private
	 * @return void
	 * @since 0.9
	 */
	function _check()
	{
		
		$query = 'SELECT id FROM #__eventlist_categories';
		
		$this->_db->setQuery( $query );
		
		$result = $this->_db->loadResult();
		return $result; 
	}
}
?>