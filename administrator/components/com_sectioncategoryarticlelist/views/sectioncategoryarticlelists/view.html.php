<?php
/**
 * @Project    SectionCategoryArticleList
 * @author     Mathias Hortig
 * @package    SectionCategoryArticleList
 * @copyright  Copyright (C) 2011-2012 tuts4you.de . All rights reserved.
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
*/
 
defined('_JEXEC') or die();
 
jimport( 'joomla.application.component.view' );
jimport( 'joomla.filesystem.file' );

class SectionCategoryArticleListsViewSectionCategoryArticleLists extends JView
{
    function display($tpl = null)
    {
        global $mainframe;
        $uri =& JFactory::getURI();
        $text = JText::_('Css Edit');
        
        JToolBarHelper::title(JText::_('SectionCategoryArticleList').': <small><small>[ ' . $text.' ]</small></small>',$icon );
        JToolBarHelper::save('saveCss');
        JToolBarHelper::cancel('cancelCss');

        $file = JPATH_COMPONENT_SITE . DS . 'css' . DS . 'sectioncategoryarticlelist.css';
        $content = JFile::read($file);
        $content = htmlspecialchars($content, ENT_COMPAT, 'UTF-8');

        $title = 

        $this->assignRef('content', $content);
        $this->assignRef('title', $title);
        $this->assignRef('filename', $file);
        $this->assignRef('action',$uri->toString());
 
        parent::display($tpl);
    }
}
