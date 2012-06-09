<?php
/**
 * Element: Components
 * Displays a list of components with check boxes
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
 * Components Element
 */
class nnFieldComponents
{
	var $_version = '12.6.1';

	function getInput($name, $id, $value, $params, $children, $j15 = 0)
	{
		$this->params = $params;

		$frontend = $this->def('frontend', 1);
		$admin = $this->def('admin', 1);
		$show_content = $this->def('show_content', 0);
		$size = (int) $this->def('size');

		if (!$frontend && !$admin) {
			return '';
		}

		$components = $this->getComponents($frontend, $admin, $show_content, $j15);

		$options = array();

		foreach ($components as $component) {
			$options[] = JHtml::_('select.option', $component->element, $component->name, 'value', 'text');
		}

		require_once JPATH_PLUGINS.'/system/nnframework/helpers/html.php';
		return nnHTML::selectlist($options, $name, $value, $id, $size, 1, '', $j15);
	}

	function getComponents($frontend = 1, $admin = 1, $show_content = 0, $j15 = 0)
	{
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');

		$db = JFactory::getDBO();

		$where = array();
		$where[] = $db->nameQuote('name').' != ""';
		if ($j15) {
			$where[] = $db->nameQuote('option').' != ""';
			$where[] = $db->nameQuote('parent').' = 0';
			$where2 = array();
			if ($admin) {
				$where2[] = $db->nameQuote('admin_menu_link').' != ""';
			}
			if ($frontend) {
				$where2[] = $db->nameQuote('link').' != ""';
			}
			$where[] = '('.implode(' OR ', $where2).')';
			$query = 'SELECT '.$db->nameQuote('name').', '.$db->nameQuote('option').' AS '.$db->nameQuote('element')
				.' FROM #__components';
		} else {
			$where[] = $db->nameQuote('element').' != ""';
			$where[] = 'type = '.$db->quote('component');
			$query = 'SELECT name, '.$db->nameQuote('element')
				.' FROM #__extensions';
		}
		$query .= ' WHERE '.implode(' AND ', $where)
			.' GROUP BY '.$db->nameQuote('element')
			.' ORDER BY '.$db->nameQuote('element').', '.$db->nameQuote('name');
		$db->setQuery($query);
		$components = $db->loadObjectList();

		$comps = array();
		$lang = JFactory::getLanguage();

		foreach ($components as $i => $component) {
			// return if there is no main component folder
			if (!($frontend && JFolder::exists(JPATH_SITE.'/components/'.$component->element))
				&& !($admin && JFolder::exists(JPATH_ADMINISTRATOR.'/components/'.$component->element))
			) {
				continue;
			}
			if (!$j15) {
				// return if there is no views folder
				if (!($frontend && JFolder::exists(JPATH_SITE.'/components/'.$component->element.'/views'))
					&& !($admin && JFolder::exists(JPATH_ADMINISTRATOR.'/components/'.$component->element.'/views'))
				) {
					continue;
				}
				if (!empty($component->element)) {
					// Load the core file then
					// Load extension-local file.
					$lang->load($component->element.'.sys', JPATH_BASE, null, false, false)
						|| $lang->load($component->element.'.sys', JPATH_ADMINISTRATOR.'/components/'.$component->element, null, false, false)
						|| $lang->load($component->element.'.sys', JPATH_BASE, $lang->getDefault(), false, false)
						|| $lang->load($component->element.'.sys', JPATH_ADMINISTRATOR.'/components/'.$component->element, $lang->getDefault(), false, false);
				}
				$component->name = JText::_(strtoupper($component->name));
			}
			$comps[preg_replace('#[^a-z0-9_]#i', '', $component->name.'_'.$component->element)] = $component;
		}
		ksort($comps);

		return $comps;
	}

	private function def($val, $default = '')
	{
		return (isset($this->params[$val]) && (string) $this->params[$val] != '') ? (string) $this->params[$val] : $default;
	}
}

if (version_compare(JVERSION, '1.6.0', 'l')) {
	// For Joomla 1.5
	class JElementNN_Components extends JElement
	{
		/**
		 * Element name
		 *
		 * @access	protected
		 * @var		string
		 */
		var $_name = 'Components';

		function fetchElement($name, $value, &$node, $control_name)
		{
			$this->_nnfield = new nnFieldComponents();
			return $this->_nnfield->getInput($control_name.'['.$name.']', $control_name.$name, $value, $node->attributes(), $node->children(), 1);
		}
	}
} else {
	// For Joomla 1.6
	class JFormFieldNN_Components extends JFormField
	{
		/**
		 * The form field type
		 *
		 * @var		string
		 */
		public $type = 'Components';

		protected function getInput()
		{
			$this->_nnfield = new nnFieldComponents();
			return $this->_nnfield->getInput($this->name, $this->id, $this->value, $this->element->attributes(), $this->element->children());
		}
	}
}