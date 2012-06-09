<?php
/**
 * @Project    SectionCategoryArticleList
 * @author     Mathias Hortig
 * @package    SectionCategoryArticleList
 * @copyright  Copyright (C) 2011-2012 tuts4you.de . All rights reserved.
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
*/
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 

class SectionCategoryArticleListsController extends JController
{
    function display()
    {
        parent::display();
    }
    
      function saveCSS()
  {
    JRequest::checkToken( 'request' ) or jexit( 'Invalid Token' );
    $file = JPATH_COMPONENT_SITE . DS . 'css' . DS . 'sectioncategoryarticlelist.css';
    $filecontent  = JRequest::getVar('filecontent', '', 'post', 'string', JREQUEST_ALLOWRAW);

    jimport('joomla.filesystem.file');
    if( !JFile::write($file, $filecontent)) {
      $message = "CSS File could not be saved!";
    } else {
      $message = "CSS File successfully saved!";
    }
      $link = JRoute::_('index.php?option=com_sectioncategoryarticlelist', false);
      $this->setRedirect($link, $message);

  }

    function cancelCSS()
    {
      $link = JRoute::_('index.php?option=com_sectioncategoryarticlelist', false);
      $this->setRedirect($link);
    }
 
}
