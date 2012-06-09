<?php

/**
 * @package		mod_jinc_news_access
 * @license		GNU General Public License ver. 2.0
 *
 * This is the special installer addon created by Andrew Eddie and the team of jXtended.
 * We thank for this cool idea of extending the installation process easily
 * copyright	2005-2008 New Life in IT Pty Ltd.  All rights reserved.
 */
// no direct access
/**
 * Script file of HelloWorld component
 */
class com_jincInstallerScript {

    function postflight($type, $parent) {
        // Setting default ACL for newsletters
        /*
          $db = & JFactory::getDBO();
          $rules = '{"jinc.subscribe":{"1":1}}';
          $query = 'UPDATE `#__assets` SET rules = \'' . $rules . '\' WHERE name = \'com_jinc\'';
          $db->setQuery($query);
          $db->query();
         */
    }

    function install($parent) {
        @ini_set('max_execution_time', 0);

        $db = & JFactory::getDBO();
        $status = new JObject();
        $status->modules = array();
        $status->plugins = array();

        // ---------------------------------------------------------------------------------------------
        // MODULE INSTALLATION SECTION
        // ---------------------------------------------------------------------------------------------
        $inst_parent = $parent->getParent();
        $manifest = $inst_parent->getManifest();

        $modules = $manifest->modules;

        if (is_a($modules, 'JXMLElement') && count($modules->children())) {
            foreach ($modules->children() as $module) {
                $mname = $module->getAttribute('module');
                $mclient = JApplicationHelper::getClientInfo($module->getAttribute('client'), true);

                // Set the installation path
                if (!empty($mname)) {
                    $inst_parent->setPath('extension_root', $mclient->path . DS . 'modules' . DS . $mname);
                } else {
                    $inst_parent->abort(JText::_('Module') . ' ' . JText::_('Install') . ': ' . JText::_('No module file specified'));
                    return false;
                }

                if (file_exists($inst_parent->getPath('extension_root')) && !$inst_parent->getOverwrite()) {
                    $inst_parent->abort(JText::_('Module') . ' ' . JText::_('Install') . ': ' . JText::_('Another module is already using directory') . ': "' . $inst_parent->getPath('extension_root') . '"');
                    return false;
                }

                $created = false;
                if (!file_exists($inst_parent->getPath('extension_root'))) {
                    if (!$created = JFolder::create($inst_parent->getPath('extension_root'))) {
                        $inst_parent->abort(JText::_('Module') . ' ' . JText::_('Install') . ': ' . JText::_('Failed to create directory') . ': "' . $inst_parent->getPath('extension_root') . '"');
                        return false;
                    }
                }

                if ($created) {
                    $inst_parent->pushStep(array('type' => 'folder', 'path' => $inst_parent->getPath('extension_root')));
                }

                $element = &$module->files;
                if ($inst_parent->parseFiles($element, -1) === false) {
                    $inst_parent->abort();
                    return false;
                }

                $element = &$module->languages;
                if ($inst_parent->parseLanguages($element, $mclient->id) === false) {
                    $inst_parent->abort();
                    return false;
                }

                $element = &$module->media;
                if ($inst_parent->parseMedia($element, $mclient->id) === false) {
                    $inst_parent->abort();
                    return false;
                }

                $mtitle = $module->getAttribute('title');
                $m_modname = $module->getAttribute('name');
                $mposition = $module->getAttribute('position');
                $morder = $module->getAttribute('order');
                $published = $module->getAttribute('published');

                if ($mtitle && $mposition) {
                    $query = 'SELECT `id` FROM `#__modules` WHERE module = ' . $db->Quote($mname);
                    $db->setQuery($query);
                    if (!$db->Query()) {
                        // Install failed, roll back changes
                        $inst_parent->abort(JText::_('Module') . ' ' . JText::_('Install') . ': ' . $db->stderr(true));
                        return false;
                    }
                    $id = $db->loadResult();

                    if (!$id) {
                        $row = & JTable::getInstance('module');
                        $row->title = $mtitle;
                        $row->ordering = $morder;
                        $row->position = $mposition;
                        $row->showtitle = 0;
                        $row->access = ($mclient->id) == 1 ? 2 : 0;
                        $row->client_id = $mclient->id;
                        $row->module = $mname;
                        $row->published = ($published == "true") ? 1 : 0;
                        $row->params = '';

                        if (!$row->store()) {
                            // Install failed, roll back changes
                            $inst_parent->abort(JText::_('Module') . ' ' . JText::_('Install') . ': ' . $db->stderr(true));
                            return false;
                        }

                        $row = & JTable::getInstance('extension');
                        $row->name = $m_modname;
                        $row->ordering = $morder;
                        $row->type = 'module';
                        $row->element = $mname;
                        $row->client_id = $mclient->id;
                        $row->enabled = 1;
                        $row->access = 0;
                        $row->protected = 0;

                        if (!$row->store()) {
                            // Install failed, roll back changes
                            $inst_parent->abort(JText::_('Module') . ' ' . JText::_('Install') . ': ' . $db->stderr(true));
                            return false;
                        }
                        // Make visible evertywhere if site module
                        if ($mclient->id == 0) {
                            $query = 'REPLACE INTO `#__modules_menu` (moduleid,menuid) values (' . $db->Quote($row->extension_id) . ',0)';
                            $db->setQuery($query);
                            if (!$db->query()) {
                              // Install failed, roll back changes
                                $inst_parent->abort(JText::_('Module') . ' ' . JText::_('Install') . ': ' . $db->stderr(true));
                                return false;
                            }
                        }
                    }
                }
                $status->modules[] = array('name' => $mname, 'client' => $mclient->name);
            }
        }

        // ---------------------------------------------------------------------------------------------
        // PLUGIN INSTALLATION SECTION
        // ---------------------------------------------------------------------------------------------
        $plugins = $manifest->plugins;
        if (is_a($plugins, 'JXMLElement') && count($plugins->children())) {
            foreach ($plugins->children() as $plugin) {
                $pname = $plugin->getAttribute('plugin');
                $pgroup = $plugin->getAttribute('group');
                $porder = $plugin->getAttribute('order');

                if (!empty($pname) && !empty($pgroup)) {
                    $inst_parent->setPath('extension_root', JPATH_ROOT . DS . 'plugins' . DS . $pgroup . DS . $pname);
                } else {
                    $inst_parent->abort(JText::_('Plugin') . ' ' . JText::_('Install') . ': ' . JText::_('No plugin file specified'));
                    return false;
                }

                $created = false;
                if (!file_exists($inst_parent->getPath('extension_root'))) {
                    if (!$created = JFolder::create($inst_parent->getPath('extension_root'))) {
                        $inst_parent->abort(JText::_('Plugin') . ' ' . JText::_('Install') . ': ' . JText::_('Failed to create directory') . ': "' . $inst_parent->getPath('extension_root') . '"');
                        return false;
                    }
                }

                if ($created) {
                    $inst_parent->pushStep(array('type' => 'folder', 'path' => $inst_parent->getPath('extension_root')));
                }

                $element = &$plugin->files;
                if ($inst_parent->parseFiles($element, -1) === false) {
                    $inst_parent->abort();
                    return false;
                }

                // Copy all necessary files
                $element = &$plugin->languages;
                if ($inst_parent->parseLanguages($element, 1) === false) {
                    $inst_parent->abort();
                    return false;
                }

                // Copy media files
                $element = &$plugin->media;
                if ($inst_parent->parseMedia($element, 1) === false) {
                    // Install failed, roll back changes
                    $inst_parent->abort();
                    return false;
                }

                $db = &JFactory::getDBO();

                // Check to see if a plugin by the same name is already installed
                $query = 'SELECT `extension_id`' .
                        ' FROM `#__extensions`' .
                        ' WHERE folder = ' . $db->Quote($pgroup) .
                        ' AND element = ' . $db->Quote($pname);
                $db->setQuery($query);
                
                if (!$db->Query()) {
                    // Install failed, roll back changes
                    $inst_parent->abort(JText::_('Plugin') . ' ' . JText::_('Install') . ': ' . $db->stderr(true));                    
                    return false;
                }
                $id = $db->loadResult();

                // Was there a plugin already installed with the same name?
                if ($id) {
                    if (!$inst_parent->getOverwrite()) {
                        $inst_parent->abort(JText::_('Plugin') . ' ' . JText::_('Install') . ': ' . JText::_('Plugin') . ' "' . $pname . '" ' . JText::_('already exists!'));
                        return false;
                    }
                } else {
                    $row = & JTable::getInstance('extension');
                    $row->name = JText::_(ucfirst($pgroup)) . ' - ' . JText::_(ucfirst($pname));
                    $row->type = 'plugin';
                    $row->element = $pname;
                    $row->folder = $pgroup;
                    $row->ordering = $porder;
                    $row->client_id = 0;
                    $row->enabled = 1;
                    $row->access = 1;
                    $row->protected = 0;

                    if (!$row->store()) {
                        $inst_parent->abort(JText::_('Plugin') . ' ' . JText::_('Install') . ': ' . $db->stderr(true));
                        return false;
                    }
                }

                $status->plugins[] = array('name' => $pname, 'group' => $pgroup);
            }
        }
    }

    function uninstall($parent) {
        @ini_set('max_execution_time', 0);

        $db = & JFactory::getDBO();
        $status = new JObject();
        $status->modules = array();
        $status->plugins = array();

        // ---------------------------------------------------------------------------------------------
        // MODULE INSTALLATION SECTION
        // ---------------------------------------------------------------------------------------------
        $inst_parent = $parent->getParent();
        $manifest = $inst_parent->getManifest();

        $modules = $manifest->modules;
        if (is_a($modules, 'JXMLElement') && count($modules->children())) {

            foreach ($modules->children() as $module) {
                $mname = $module->getAttribute('module');
                $mclient = JApplicationHelper::getClientInfo($module->getAttribute('client'), true);
                $mposition = $module->getAttribute('position');

                // Set the installation path
                if (!empty($mname)) {
                    $inst_parent->setPath('extension_root', $mclient->path . DS . 'modules' . DS . $mname);
                } else {
                    $inst_parent->abort(JText::_('Module') . ' ' . JText::_('Install') . ': ' . JText::_('No module file specified'));
                    return false;
                }

                /**
                 * ---------------------------------------------------------------------------------------------
                 * Database Processing Section
                 * ---------------------------------------------------------------------------------------------
                 */
                $db = &JFactory::getDBO();

                // Lets delete all the module copies for the type we are uninstalling
                $query = 'SELECT `id`' .
                        ' FROM `#__modules`' .
                        ' WHERE module = ' . $db->Quote($mname) .
                        ' AND client_id = ' . (int) $mclient->id;
                $db->setQuery($query);
                $modules = $db->loadResultArray();

                // Do we have any module copies?
                if (count($modules)) {
                    JArrayHelper::toInteger($modules);
                    $modID = implode(',', $modules);
                    $query = 'DELETE' .
                            ' FROM #__modules_menu' .
                            ' WHERE moduleid IN (' . $modID . ')';
                    $db->setQuery($query);
                    if (!$db->query()) {
                        JError::raiseWarning(100, JText::_('Module') . ' ' . JText::_('Uninstall') . ': ' . $db->stderr(true));
                        $retval = false;
                    }
                }

                // Delete the modules in the #__modules table
                $query = 'DELETE FROM #__modules WHERE module = ' . $db->Quote($mname);
                $db->setQuery($query);
                if (!$db->query()) {
                    JError::raiseWarning(100, JText::_('Plugin') . ' ' . JText::_('Uninstall') . ': ' . $db->stderr(true));
                    $retval = false;
                }

                // Delete the modules in the #__modules table
                $query = 'DELETE FROM #__extensions WHERE element = ' . $db->Quote($mname);
                $db->setQuery($query);
                if (!$db->query()) {
                    JError::raiseWarning(100, JText::_('Plugin') . ' ' . JText::_('Uninstall') . ': ' . $db->stderr(true));
                    $retval = false;
                }

                /**
                 * ---------------------------------------------------------------------------------------------
                 * Filesystem Processing Section
                 * ---------------------------------------------------------------------------------------------
                 */
                // Remove all necessary files
                $element = &$module->files;
                if (is_a($element, 'JXMLElement') && count($element->children())) {
                    $inst_parent->removeFiles($element, -1);
                }

                // Remove all necessary files
                $element = &$module->media;
                if (is_a($element, 'JXMLElement') && count($element->children())) {
                    $inst_parent->removeFiles($element, -1);
                }

                $element = &$module->languages;
                if (is_a($element, 'JXMLElement') && count($element->children())) {
                    $inst_parent->removeFiles($element, $mclient->id);
                }

                // Remove the installation folder
                if (!JFolder::delete($inst_parent->getPath('extension_root'))) {

                }

                $status->modules[] = array('name' => $mname, 'client' => $mclient->name);
            }
        }

        // --------------------------------------------------------------------------------------------
        // PLUGIN REMOVAL SECTION
        // ---------------------------------------------------------------------------------------------

        $plugins = $manifest->plugins;
        if (is_a($plugins, 'JXMLElement') && count($plugins->children())) {
            foreach ($plugins->children() as $plugin) {
                $pname = $plugin->getAttribute('plugin');
                $pgroup = $plugin->getAttribute('group');

                // Set the installation path
                if (!empty($pname) && !empty($pgroup)) {
                    $inst_parent->setPath('extension_root', JPATH_ROOT . DS . 'plugins' . DS . $pgroup . DS . $pname);
                } else {
                    $inst_parent->abort(JText::_('Plugin') . ' ' . JText::_('Uninstall') . ': ' . JText::_('No plugin file specified'));
                    return false;
                }

                $db = &JFactory::getDBO();

                // Delete the plugins in the #__plugins table
                $query = 'DELETE FROM #__extensions WHERE element = ' . $db->Quote($pname) . ' AND folder = ' . $db->Quote($pgroup);
                $db->setQuery($query);
                if (!$db->query()) {
                    JError::raiseWarning(100, JText::_('Plugin') . ' ' . JText::_('Uninstall') . ': ' . $db->stderr(true));
                    $retval = false;
                }

                // Remove all necessary files
                $element = &$plugin->files;
                if (is_a($element, 'JXMLElement') && count($element->children())) {
                    $inst_parent->removeFiles($element, -1);
                }

                $element = &$plugin->languages;
                if (is_a($element, 'JXMLElement') && count($element->children())) {
                    $inst_parent->removeFiles($element, 1);
                }

                // If the folder is empty, let's delete it
                $files = JFolder::files($inst_parent->getPath('extension_root'));
                if (!count($files)) {
                    JFolder::delete($inst_parent->getPath('extension_root'));
                }

                $status->plugins[] = array('name' => $pname, 'group' => $pgroup);
            }
        }
    }

}