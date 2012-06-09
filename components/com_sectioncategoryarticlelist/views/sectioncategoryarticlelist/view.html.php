<?php
/**
 * @Project    SectionCategoryArticleList
 * @author     Mathias Hortig
 * @package    SectionCategoryArticleList
 * @copyright  Copyright (C) 2011-2012 tuts4you.de . All rights reserved.
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
*/
 
// no direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport( 'joomla.application.component.view');

 
class SectionCategoryArticleListViewSectionCategoryArticleList extends JView
{
    function display($tpl = null)
    {
        $document = &JFactory::getDocument();
        $document->addStyleSheet('components'.DS.'com_sectioncategoryarticlelist'.DS.'css'.DS.'sectioncategoryarticlelist.css');
        $model = &$this->getModel();
	$menu = JSite::getMenu()->getActive();
	$params = new JParameter($menu->params);

        $this->assignRef( 'categories', $model->GetCategories() );
        $this->assignRef( 'pretext', $params->get('pretext'));
        $this->assignRef( 'posttext', $params->get('posttext'));
        $this->assignRef( 'headline', $params->get('headline'));

        parent::display($tpl);
    }
}
