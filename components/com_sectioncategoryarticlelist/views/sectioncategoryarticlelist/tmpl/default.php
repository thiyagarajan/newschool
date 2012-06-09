<?php
/**
 * @Project    SectionCategoryArticleList
 * @author     Mathias Hortig
 * @package    SectionCategoryArticleList
 * @copyright  Copyright (C) 2011-2012 tuts4you.de . All rights reserved.
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
*/ 
// No direct access
 
defined('_JEXEC') or die('Restricted access');

require_once JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php';

$model = &$this->getModel();

echo '<div class="componentheading"><h1>' . $this->headline . '</h1></div>';
echo '<p>' . $this->pretext . '</p>';
echo '<ul class="articlelist">';

$curCat = -1;
foreach($this->categories as $category) 
{
  $link = '<a href="' .  JRoute::_(ContentHelperRoute::getCategoryRoute($category->id)) . '">' . $category->title . '</a>';
  echo '<li class="category' . $category->depth . '">' . $link . '</li>';

  foreach($model->GetArticles($category->id) as $article)
  {
    $link = '<a href="' .  JRoute::_(ContentHelperRoute::getArticleRoute($article->id, $article->catid)) . '">' . $article->title . '</a>';
    echo '<li class="article' . $category->depth . '">' . $link . '</li>';
  }
}
echo '</ul>';
echo '<p>' . $this->posttext . '</p>';
echo '<p  style="text-align:right;"><small>Powered By <a target="blank" href="http://tuts4you.de/">http://tuts4you.de/</a></small></p>';
