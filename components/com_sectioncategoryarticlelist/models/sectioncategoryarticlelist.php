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
 
jimport('joomla.application.component.model' );
jimport('joomla.utilities.date'); 
jimport( 'joomla.html.parameter' );


class SectionCategoryArticleListModelSectionCategoryArticleList extends JModel
{



	function GetCategories()
	{
		$menu = JSite::getMenu()->getActive();
		$params = new JParameter($menu->params);

		$catids = array();
                foreach($params->get('catid') as $key => $value)
		{
			if($value != "")
			{
				$catids[] = $value;
			}
		}
		$result = $this->GetChildCategories(1,1, $catids);
		return $result;
	}
	
	function GetChildCategories($parentId, $depth, $catids)
        {

                $result = array();
        	$database =& JFactory::getDBO();
 		$database->setQuery("SELECT c.id , c.title, null as depth
				     FROM #__categories AS c
				     WHERE c.parent_id = " . $parentId . " and c.published=1 AND c.extension='com_content' 
ORDER BY c.lft");

        	$categories = $database->loadObjectList();

		foreach($categories as $category)
		{

			if(in_array($category->id,$catids) || sizeof($catids) == 0)
			{
				$category->depth = $depth;
				$result[] = $category;
				$result = array_merge($result, $this->GetChildCategories($category->id, $depth+1, $catids));

			}
			else
			{
				$result = array_merge($result, $this->GetChildCategories($category->id, $depth, $catids));
			}
		}
		return $result;
	}


    function GetArticles($id)
    {
        $date = new JDate();
        $now = $date->toMySQL();
        $database =& JFactory::getDBO();
        $nullDate = $database->getNullDate();

        $database->setQuery('SELECT title, id, catid'
            . ' FROM #__content'
            . " WHERE catid = " . $id . " AND access = 1 AND state = 1"
            . " AND ( publish_up = " . $database->Quote( $nullDate ) . " OR publish_up <= " . $database->Quote( $now ) . " )"
            . " AND ( publish_down = " . $database->Quote( $nullDate ) . " OR publish_down >= " . $database->Quote( $now ) . " )"
            . " ORDER BY created desc"

        );
        $results = $database->loadObjectList();
	
	return $results;
    }
}
