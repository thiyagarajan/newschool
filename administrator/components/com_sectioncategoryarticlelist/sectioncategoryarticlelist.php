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
 
require_once( JPATH_COMPONENT.DS.'controller.php' );
 
if($controller = JRequest::getWord('controller')) {
    $path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
    if (file_exists($path)) {
        require_once $path;
    } else {
        $controller = '';
    }
}
 
$classname    = 'SectionCategoryArticleListsController'.$controller;
$controller   = new $classname( );
 
// Perform the Request task
$controller->execute( JRequest::getVar( 'task' ) );
 
// Redirect if set by the controller
$controller->redirect();
