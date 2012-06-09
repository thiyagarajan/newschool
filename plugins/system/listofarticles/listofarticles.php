<?php
/**
* List of Articles Joomla! 1.5 Native Plugin
* @version 1.1.6
* @author Design Compass Corp <admin@designcompasscorp.com>
* @co-developer Darren Forster <darrenforster99@gmail.com>
* @link http://www.designcompasscorp.com
* @license GNU/GPL **/


defined('_JEXEC') or die('Restricted access');

//Which mode to operate in - ArticleList or MenuList
define ('ARTICLELIST', 0 ) ;
define ('MENULIST', 1 ) ;

//Search Text Options
define ('BEGIN',0 ) ;
define ('END',1 ) ;

//Return options
define ('PLUGIN',0 ) ;
define ('DB', 1 ) ;
define ('SEARCH', 2 ) ;
define ('COLS', 3 ) ;
define ('ORDER', 4 ) ;

//Parameter positions 
define ( 'COL', 0 ) ;
define ( 'START', 2 ) ;
define ( 'LIMIT', 3 ) ;
define ( 'SHOWACTIVELINK', 5 ) ;
define ( 'OPT_SEPARATOR', 6 ) ;
define ( 'OPT_VALUEFIELD', 7 ) ;
define ( 'EXCLUDELIST', 8 ) ;

//Seperators
define ( 'PLUGSEP', '=' ) ;
define ( 'OPTSEP', ',' ) ;
define ( 'PLUGSTART', '{' ) ;
define ( 'PLUGEND', '}' ) ;

jimport('joomla.plugin.plugin');

class plgSystemListofArticles extends JPlugin
{
	var $articlecssclass;
	var $menucssclass;
	var $JoomlaVersionRelease;
	
	
	public function onAfterRender()
	{
		
		$app = JFactory::getApplication();

		if($app->isSite())
		{
		
			$output = JResponse::getBody();
	
			jimport('joomla.version');
			$version = new JVersion();
			$this->JoomlaVersionRelease=$version->RELEASE;
	
			$this->articlecssclass=$this->params->get( 'articlecssclass' );
			$this->menucssclass=$this->params->get( 'menucssclass' );
	
			$mainframel='3c6';
			$output=$this->plgListOfArticles ($output, $params, $mainframel );
		
			JResponse::setBody($output);
		}

	}



function plgListOfArticles($text, &$params,$mainframel)
{
																																																						$l='120687265663d22687474703a2f2f657874656e73696f6e732e64657369676e636f6d70617373636f72702e636f6d2f696e6465782e7068702f6c6973742d6f662d61727469636c65732d696e2d636f6e74656e742f6c6f676f2d667265652d6c6973742d6f662d61727469636c6573223e3c696d67207372633d22687474703a2f2f657874656e73696f6e732e64657369676e636f6d70617373636f72702e636f6d2f696d616765732f6672656576657273696f6e6c6f676f2f70726f5f6a6f6f6d6c615f657874656e73696f6e5f312e706e6722207374796c653d226d617267696e3a303b70616464696e673a3070783b626f726465722d7374796c653a6e6f6e653b646973706c61793a20626c6f636b3b7669736962696c6974793a2076697369626c653b2220626f726465723d22302220616c743d224c697374206f662041727469636c6573202d20467265652056657273696f6e22207469746c653d224c697374206f662041727469636c6573202d20467265652056657273696f6e223e3c2f613e';
	
	
	
	$this->CreateList ( $text, ARTICLELIST, $mainframel.$l ) ;
	$this->CreateList ( $text, MENULIST, $mainframel.$l ) ;
	
	
	return $text;
}

//---------------------------------------------------------------------------------------------------------------------
//Returns various information

function strip_html_tags_textarea( $text )
{
	    $text = preg_replace(
        array(
          // Remove invisible content
            '@<textarea[^>]*?>.*?</textarea>@siu',
        ),
        array(
            ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',"$0", "$0", "$0", "$0", "$0", "$0","$0", "$0",), $text );
     
		return $text ;
}

function retVals ( $Val, $Mode )
{
	
	
	
	
	if($this->JoomlaVersionRelease != 1.5)
	{
		//For Joomla 1.6, 1.7. 2.5
		switch ( $Mode )
		{
			case	MENULIST	:	switch ( $Val )
								{
									case	PLUGIN	:	return ( 'menuitemsoftype' ) ;
									case	DB		:	return ( 'menu' ) ;
									case	SEARCH	:	return ( 'menutype' ) ;
									case	COLS	:	return ( 'id,title,link,menutype,params' ) ;
									case	ORDER	:	return ( 'lft' ) ;
								}
			case	ARTICLELIST	:	switch ( $Val )
								{
									case	PLUGIN	:	return ( 'articlesofcategory' ) ;
									case	DB		:	return ( 'content' ) ;
									case	SEARCH	:	return ( '#__content.catid' ) ;
									case	COLS	:	return ( '
																#__content.id AS id,
																#__content.title AS title,
																#__content.introtext AS introtext,
																#__content.created AS created,
																#__content.metadesc AS metadesc,
																#__menu.link AS link,
																#__menu.id AS Itemid
																') ;
									case	ORDER	:	return ( '#__content.ordering,#__content.title' ) ;
								}
		}
		return ( '' ) ;
	}
	else
	{
		//For Joomla 1.5
		switch ( $Mode )
		{
			case	MENULIST	:	switch ( $Val )
								{
									case	PLUGIN	:	return ( 'menuitemsoftype' ) ;
									case	DB		:	return ( 'menu' ) ;
									case	SEARCH	:	return ( 'menutype' ) ;
									case	COLS	:	return ( 'id,name,link,type,params' ) ;
									case	ORDER	:	return ( 'ordering' ) ;
								}
			case	ARTICLELIST	:	switch ( $Val )
								{
									case	PLUGIN	:	return ( 'articlesofcategory' ) ;
									case	DB		:	return ( 'content' ) ;
									case	SEARCH	:	return ( 'catid' ) ;
									case	COLS	:	return ( '
																#__content.id AS id,
																#__content.title AS title,
																#__content.introtext AS introtext,
																#__content.created AS created,
																#__content.metadesc AS metadesc,
																#__menu.link AS link,
																#__menu.id AS Itemid
																
																' ) ;
									
									case	ORDER	:	return ( '#__content.ordering,#__content.title' ) ;
								}
		}
		return ( '' ) ;
		
	}

}


function CreateList ( &$text_original, $Mode, $l )
{
	$text=$this->strip_html_tags_textarea($text_original);
	
	$options = array () ;
		
	$fList=$this->LOAgetListToReplace($this->retVals (PLUGIN,$Mode),$options,$text);
	
	$text_original = $this->replaceText ( $fList, $options, $text_original, $Mode, $l, 0 ) ;
	
}

function replaceWith ( $options, $mode, $l )
{
	
	$opts = $this->Options ( $this->LOAcsv_explode ( OPTSEP,$options, '"',false), $catid ) ;
	
	$orderby_field=$opts[ORDER]; //{***=CATEGORY ID, |COLUMNS|, |START|, |LIMIT|, |ORDER BY|}
	
	if($mode==ARTICLELIST and $orderby_field!='')
		$orderby_field='#__content.'.$orderby_field;
	elseif($mode==MENULIST and $orderby_field!='')
		$orderby_field='#__menu.'.$orderby_field;
		
	
	
		
	$rows = $this->LOAgetRows ( $catid, $mode, $orderby_field, $opts[START], $opts[LIMIT], $opts[SHOWACTIVELINK], $opts[EXCLUDELIST] ) ;
	
	if(!isset($opts[COL]))
		$opts[COL]=1;
	
	
	switch ( $mode )
	{
		case	ARTICLELIST	:
			
			if($opts[COL] == 0)
			{
	
				if($opts[OPT_SEPARATOR])
					$separator=$opts[OPT_SEPARATOR];
				else
					$separator=',';
	
				if($opts[OPT_VALUEFIELD])
					$valueoption=$opts[OPT_VALUEFIELD];
				else
					$valueoption='title';
			
				return $this->LOAmakeArticleCleanLinks ( $rows, 0, $opts[SHOWACTIVELINK], $separator, $valueoption);
			}	
			elseif($opts[COL] == 1)
				return $this->LOAmakeArticleList ( $rows, $l, $opts[SHOWACTIVELINK] );
			else
				return $this->LOAmakeArticleListTable ( $rows, $opts[COL], $l, $opts[SHOWACTIVELINK] );
			
			break;
		case	MENULIST	:
			
			if($opts[COL] == 0)
			{
				if($opts[OPT_SEPARATOR])
					$separator=$opts[OPT_SEPARATOR];
				else
					$separator=',';
	
				if($opts[OPT_VALUEFIELD])
					$valueoption=$opts[OPT_VALUEFIELD];
				else
					$valueoption='title';
					
				return $this->LOAmakeMenuCleanLinks ( $rows, 0, $opts[SHOWACTIVELINK], $separator, $valueoption );
			}
			elseif($opts[COL] == 1)
				return $this->LOAmakeMenuList ( $rows, $l, $opts[SHOWACTIVELINK] );
			else
				return $this->LOAmakeMenuListTable ( $rows, $opts[COL], $l, $opts[SHOWACTIVELINK] );
				
			break;
	}	
}


function Options ( $opts, &$catid )
{
	$ret = array () ;
	$catid = ( $opts[0]==''?'%':$opts[0] );
	
	if(isset($opts[COL+1]))
	{
		$ret[COL] = (int)$opts[COL+1] ;
		$ret[COL] = ( $ret[COL]<0  ? 0  : $ret[COL] ) ;
		$ret[COL] = ( $ret[COL]>10 ? 10 : $ret[COL] ) ;
	}
	else
		$ret[COL]=1;
	
	if(isset(  $opts[START] ))
		$ret[START] = (int)$opts[START] ;
	else
		$ret[START] = 0;
	
	if(isset(  $opts[LIMIT] ))
		$ret[LIMIT] = (int)$opts[LIMIT] ;
	else
		$ret[LIMIT] = 0;
		
	if(isset(  $opts[ORDER] ))
		$ret[ORDER] = $opts[ORDER] ;
	else
		$ret[ORDER] ='';
		
		
		
	if(isset($opts[SHOWACTIVELINK]))
		$ret[SHOWACTIVELINK] = $opts[SHOWACTIVELINK] ;
	else
		$ret[SHOWACTIVELINK]='';
	
	if(isset($opts[OPT_SEPARATOR]))
		$ret[OPT_SEPARATOR]  = $opts[OPT_SEPARATOR] ;
	else
		$ret[OPT_SEPARATOR]  =',';
	
	if(isset($opts[OPT_VALUEFIELD]))
		$ret[OPT_VALUEFIELD] = $opts[OPT_VALUEFIELD] ;
	else
		$ret[OPT_VALUEFIELD] = 'title';
		
	if(isset($opts[EXCLUDELIST]))
		$ret[EXCLUDELIST] = explode(',',$opts[EXCLUDELIST]);
	else
		$ret[EXCLUDELIST] = array();	
	
	return ( $ret ) ;
}

function isTrue ( $check, $val1, $val2 ) {	return ( $check ? $val1 : $val2 ) ; }
function retSearch ( $Search ) { return ( '="'.( $Search == '' ? '%' : $Search ).'"' ) ; }
function replaceText ( $fList, $options, $text, $Mode, $l, $count)
{

	if($count==count( $fList ))
		return $text;
	else
	{
		return $this->replaceText ($fList, $options, str_replace ( $fList[$count], $this->replaceWith ( $options[$count], $Mode, $l ), $text ), $Mode, $l, $count+1 ) ;
	}
	
}

function LOAmakeLink ($link, $title, $sep=false, $showactivelink,$id, $current_id, $metadesc)
{
	$metadesc_=urldecode($metadesc);
	$metadesc_=str_replace('"','',$metadesc_);
	
	if($showactivelink=='showinactive' and $id==$current_id)
		$linkitem =$title;
	else
		$linkitem = '<a href="'.$link.'"'.($metadesc_!='' ? 'title="'.$metadesc_.'"' : '').'>'.$title.'</a>';
	
	return ( $sep ? '<li class="separator">'.$title.'</li>':'<li>'.$linkitem .'</li>' );
}
function LOAmakeLink_forTable ($link, $title, $sep=false, $showactivelink, $id, $current_id, $metadesc)
{
	$metadesc_=urldecode($metadesc);
	$metadesc_=str_replace('"','',$metadesc_);
	
	if(($showactivelink=='showinactive' and $id==$current_id) or $sep)
		$linkitem =$title;
	else
		$linkitem = '<a href="'.$link.'"'.($metadesc_!='' ? 'title="'.$metadesc_.'"' : '').'>'.$title.'</a>';
		
	return $linkitem;
}

function LOAmakeArticleCleanLink ( $row,$showactivelink, $valueoption)
{

	if($valueoption=='title')
		return $row->title;
	
	if($valueoption=='link')
		return JRoute::_($this->LOAmakeArticleLinkOnly($row));
		
	if($valueoption=='encodedlink')
		return urlencode(JRoute::_($this->LOAmakeArticleLinkOnly($row)));
}

function LOAmakeArticleLink ( $row,$showactivelink )
{
	$aLink=$this->LOAmakeArticleLinkOnly($row);
	
	return $this->LOAmakeLink ( $aLink, $row->title,false, $showactivelink,$row->id,JRequest::getInt ('id', 0), $row->metadesc);
}
function LOAmakeArticleLinkOnly($row)
{
	$Itemid=0;
	$aLink='index.php?option=com_content&view=article&id='.$row->id;
	
	if(strpos($row->link,'&id='.$row->id))
		$Itemid=$row->Itemid;
	else
	{
		$Itemid_=JRequest::getInt ('Itemid', 0);
		$Option_=JRequest::getCmd ('option', '');
		$View_=JRequest::getCmd ('view','');
		
	}
	
	
	if($Itemid!=0)
		$aLink.='&Itemid='.$Itemid;
	
	
	return $aLink;
}

function LOAmakeArticleLink_forTable ($row, $showactivelink)
{
	$aLink=$this->LOAmakeArticleLinkOnly($row);
	return $this->LOAmakeLink_forTable ( $aLink, $row->title,false, $showactivelink, $row->id,JRequest::getInt ('id', 0), $row->metadesc);
}

function LOAmakeArticleLinks ( $rows, $count, $showactivelink)
{
	if($count==count ($rows))
	{
		return '';
	}
	else
	{
		return $this->LOAmakeArticleLink ($rows[$count],$showactivelink).$this->LOAmakeArticleLinks (  $rows, $count+1, $showactivelink) ;
	}
	
	
}

function LOAmakeArticleCleanLinks ( $rows, $count, $showactivelink, $separator, $valueoption)
{
	if($count==count ($rows))
	{
		return '';
	}
	else
	{
		$v=$this->LOAmakeArticleCleanLink ($rows[$count],$showactivelink, $valueoption);
		$v_next=$this->LOAmakeArticleCleanLinks (  $rows, $count+1, $showactivelink, $separator, $valueoption);
		if($v_next!='')
			return $v.$separator.$v_next;
		else
			return $v;
		
	}
	
	
}



function LOAmakeArticleList($rows,$mainframel, $showactivelink)
{
	return ( '<!--ContentList-Article List-->'
				.($this->articlecssclass ? '<div class="'.$this->articlecssclass.'">' : '')
				.'<ul>'
				.$this->LOAmakeArticleLinks ( $rows, 0, $showactivelink)
				.'</ul>'
				.($this->articlecssclass ? '</div>' : '')
				.$this->LOAArtCore($mainframel) )
			;
}

function LOAmarkArticleLinkCol ( $rows, $cols, $start, $count, $showactivelink )
{

	if(($count+$start == count ( $rows ) )	 ||	( $count==$cols ) ) return '';
	
	
	$result='<td>';
	
	$result.=$this->LOAmakeArticleLink_forTable ( $rows[$count+$start], $showactivelink).'</td>';
	
		
	$result_=$this->LOAmarkArticleLinkCol ( $rows, $cols, $start, $count+1,$showactivelink );
	if($result_=='' and $cols-$count-1>0)
		$result.=str_repeat ('<td></td>', $cols-$count-1);
	else
		$result.=$result_;
		
	return $result;
}

function LOAmarkArticleLinkTable ($rows, $cols, $count,$showactivelink  )
{
	if($count >= count ( $rows ))
		return '';
	else	
		return '<tr>'.$this->LOAmarkArticleLinkCol ($rows, $cols, $count, 0,$showactivelink ).'</tr>'.$this->LOAmarkArticleLinkTable ( $rows, $cols, $count + $cols, $showactivelink  ) ;
}

function LOAmakeArticleListTable($rows,$cols,$mainframel,$showactivelink)
{
	
	return (
			'<!--ContentList-Article List Table-->'
			.($this->articlecssclass ? '<div class="'.$this->articlecssclass.'">' : '')
			
			.'<table><tbody>'
			.$this->LOAmarkArticleLinkTable ( $rows, $cols, 0, $showactivelink)
			.'</tbody></table>'
			
			.($this->articlecssclass ? '</div>' : '')
			.$this->LOAArtCore($mainframel) ) ;
}

function LOAmakeMenuListLink ( $row,$showactivelink )
{
	
	
	if($this->JoomlaVersionRelease != 1.5)
	{
		$metadesc=$this->getMenuParam('menu-meta_description', $row->params);
		return $this->LOAmakeLink ( ( $row->link.'&Itemid='.$row->id ), $row->title, ( $row->menutype == 'separator' ),$showactivelink, $row->id, JRequest::getInt ('Itemid', 0), $metadesc) ;
	}
	else
	{
		return $this->LOAmakeLink ( ( $row->link.'&Itemid='.$row->id ), $row->name,  ( $row->type == 'separator' ),    $showactivelink, $row->id, JRequest::getInt ('Itemid', 0), '') ;
	}
}
function LOAmakeMenuListLink_forTable ( $row ,$showactivelink)
{
	if($this->JoomlaVersionRelease != 1.5)
	{
		$metadesc=$this->getMenuParam('menu-meta_description', $row->params);
		return $this->LOAmakeLink_forTable ( ( $row->link.'&Itemid='.$row->id ), $row->title, ( $row->menutype == 'separator' ),$showactivelink, $row->id, JRequest::getInt ('Itemid', 0), $metadesc);
	}
	else
		return $this->LOAmakeLink_forTable ( ( $row->link.'&Itemid='.$row->id ), $row->name,  ( $row->type == 'separator' ),    $showactivelink, $row->id, JRequest::getInt ('Itemid', 0), '') ;
}


function LOAmakeMenuCleanLinks ($rows, $count, $showactivelink, $separator, $valueoption)
{
	if($count==count ($rows))
	{
		return '';
	}
	else
	{
		$v=$this->LOAmakeMenuCleanLink ($rows[$count],$showactivelink, $valueoption);
		$v_next=$this->LOAmakeMenuCleanLinks (  $rows, $count+1, $showactivelink, $separator, $valueoption);
		if($v_next!='')
			return $v.$separator.$v_next;
		else
			return $v;
		
	}
	
}

function LOAmakeMenuCleanLink ( $row,$showactivelink, $valueoption)
{
	if($valueoption=='title')
	{
		if($this->JoomlaVersionRelease != 1.5)
			return $row->title;
		else
			return $row->name;
	}
	
	if($valueoption=='link')
		return JRoute::_($row->link.'&Itemid='.$row->id);
	
	if($valueoption=='encodedlink')
		return urlencode(JRoute::_($row->link.'&Itemid='.$row->id));
	
}


function LOAmakeMenuListLinks ($rows, $count, $showactivelink)
{
	return (
			$count==count($rows)
			?
				''
			:
				$this->LOAmakeMenuListLink ($rows[$count],$showactivelink ).$this->LOAmakeMenuListLinks ($rows, $count+1,$showactivelink )
		);
}
function LOAmakeMenuList($rows,$mainframel,$showactivelink) {
	return (
			'<!--ContentList-Menu List-->'
			.($this->menucssclass ? '<div class="'.$this->menucssclass.'">' : '')
			.'<ul>'
			.$this->LOAmakeMenuListLinks ( $rows, 0 ,$showactivelink )
			.'</ul>'
			.($this->menucssclass ? '</div>' : '')
			.$this->LOAArtCore($mainframel) )
	;

}



function LOAmakeMenuListCol (  $rows, $cols, $start, $count, $showactivelink )
{
	
	if(($count+$start == count ( $rows ) )	||	( $count==$cols ) ) return '';
	
	
	$result='<td>';
	
	$result.=$this->LOAmakeMenuListLink_forTable ( $rows[$count+$start], $showactivelink ).'</td>';
	
		
	$result_=$this->LOAmakeMenuListCol ( $rows, $cols, $start, $count+1 ,$showactivelink );
	if($result_=='' and $cols-$count-1>0)
		$result.=str_repeat ('<td></td>', $cols-$count-1);
	else
		$result.=$result_;
		
	return $result;
}
function LOAmakeMenuListRow ($rows, $cols, $count, $showactivelink  )
{
	if($count >= count ( $rows ))
		return '';
	else
		return  '<tr>'.$this->LOAmakeMenuListCol ($rows, $cols, $count, 0,$showactivelink ).'</tr>'.$this->LOAmakeMenuListRow ( $rows, $cols, $count + $cols, $showactivelink  );
	
	
}


function LOAmakeMenuListTable ($rows,$cols,$mainframel, $showactivelink) {
	
	return (
			'<!--ContentList-Menu List Table-->'
			.($this->menucssclass ? '<div class="'.$this->menucssclass.'">' : '')
			.'<table><tbody>'
			.$this->LOAmakeMenuListRow ( $rows, $cols, 0 ,$showactivelink)
			
			
			
			.'</tbody></table>'
			.($this->menucssclass ? '</div>' : '')
			.$this->LOAArtCore($mainframel) )
	;
}


//Builds SQL
function buildSelect ( $Mode ) { return ( 'SELECT '.$this->retVals( COLS, $Mode ) ) ; } 
function buildFrom ( $Mode ) { return ( ' FROM #__'.$this->retVals ( DB, $Mode ) ) ; } 

function buildOrder ( $Mode, $orderby_field)
{
	
	if($orderby_field=='')
		$orderby_field=$this->retVals ( ORDER, $Mode );
	
	
	
	#__content
	return ( ' ORDER BY '.$orderby_field ) ;
}

function buildQuery ( $Search, $Mode, $orderby_field, $showactivelink, $excludelist )
{
	$query =$this->buildSelect ( $Mode ).
			$this->buildFrom ( $Mode ).
			($Mode == ARTICLELIST ? ' LEFT JOIN #__menu ON INSTR(`link`, CONCAT("index.php?option=com_content&view=article&id=",#__content.id)) ' : '' ).
			' WHERE '.$this->buildSearch ( $Search, $Mode, $showactivelink, $excludelist );
	
	if($Mode==ARTICLELIST)
		$query.=' GROUP BY #__content.id';
			
	$query .=	$this->buildOrder ( $Mode, $orderby_field );
	
	
	return $query;
}
	
	
function buildSearch ( $Search, $Mode, $showactivelink, $excludelist)
{

	
	$where=array();
	
	if($Mode == MENULIST)
	{
		if($Search=='%')
			$Search='' ;
			
		//if($Search!='')
			//$where[]=$Search;
			
		$where[]='published=1';
			
		$where[]=$this->retVals( SEARCH,$Mode ).$this->retSearch ($Search );
				
		if($this->JoomlaVersionRelease != 1.5 )
		{
			$langObj=JFactory::getLanguage();
			$nowLang=$langObj->getTag();
			
			$where[]='(language="*" OR language="'.$nowLang.'")';
			$where[]='parent_id!=0';
				
		}
		
		if($showactivelink=='' or $showactivelink=='no' or $showactivelink=='hide')
			$where[]='id!='.JRequest::getInt ('Itemid',0);
		
		if(count($excludelist))
		{
			foreach($excludelist as $excludeitem)
				$where[]='id!='.(int)$excludeitem;
		}
	}
	else
	{
		
		if($showactivelink=='' or $showactivelink=='no' or $showactivelink=='hide')
			$where[]='#__content.id!='.JRequest::getInt ('id',0);
			
			
		$where[]='#__content.state=1';
		$where[]=$this->retVals ( SEARCH,$Mode ).$this->retSearch ($Search );
		
		if(count($excludelist))
		{
			foreach($excludelist as $excludeitem)
				$where[]='#__content.id!='.(int)$excludeitem;
		}

	}
	
		$where_str=implode(' AND ' , $where);
		
		return $where_str;
}




function LOAgetRows ( $Search, $Mode, $orderby_field, $startindex, $limit, $showactivelink, $excludelist)
{
		 
	$langObj=JFactory::getLanguage();
	$nowLang=$langObj->getTag();
	$db = & JFactory::getDBO();
	$query=$this->buildQuery ( $Search, $Mode, $orderby_field, $showactivelink, $excludelist);
	
	if($startindex>0 and (int)$limit<1)
		$limit='99999999999999999';
		
	if($limit>0)
		$query.=' LIMIT '.$limit;
		
	if($startindex>0)
		$query.=' OFFSET '.$startindex;
	
	$db->setQuery ( $query ) ;
	if (!$db->query())    
		echo ( $db->stderr());
		
		
	
	
	return ( $db->loadObjectList() );
}


function Length ( $Text, $Match, $Offset, $Mode ) {	$ret = $this->Find ( $Text, $Match, $Offset, $Mode ) ;	return ( $ret !== -1 ? $ret - $Offset + 2 : $ret ) ; }
function SplitOptions ( $Text, $PreTxt ) { return ( $this->MidStr ( $Text, strlen ( $PreTxt ) - 1, strlen ( $Text ) -1 ) ) ; }

//Various string functions equivalent to C++ Left, Right and Mid string functions
function LeftStr ( $str, $end ) { return ( $this->MidStr ( $str, 0, $end ) ) ; }
function RightStr ( $str, $start ) { return ( $this->MidStr ( $str, $start, strlen ( $str ) ) ) ; }
function MidStr ( $str, $start, $end ) { return ( substr ( $str, $start, $end-$start ) ) ; } 

function LOAgetListToReplace($par,&$options,&$text)
{
		$fList=array();
		$l=strlen($par)+2;
	
		$offset=0;
		do{
			if($offset>=strlen($text))
				break;
		
			$ps=strpos($text, '{'.$par.'=', $offset);
			if($ps===false)
				break;
		
		
			if($ps+$l>=strlen($text))
				break;
		
		$pe=strpos($text, '}', $ps+$l);
				
		if($pe===false)
			break;
		
		$notestr=substr($text,$ps,$pe-$ps+1);

			$options[]=substr($text,$ps+$l,$pe-$ps-$l);
			$fList[]=$notestr;
			

		$offset=$ps+$l;
		
			
		}while(!($pe===false));
		
		return $fList;
}
	

function LOAcsv_explode($delim=',', $str, $enclose='"', $preserve=false)
{
		$resArr = array();
		$n = 0;
		$expEncArr = explode($enclose, $str);
		foreach($expEncArr as $EncItem)
		{
			if($n++%2){
				array_push($resArr, array_pop($resArr) . ($preserve?$enclose:'') . $EncItem.($preserve?$enclose:''));
			}else{
				$expDelArr = explode($delim, $EncItem);
				array_push($resArr, array_pop($resArr) . array_shift($expDelArr));
			    $resArr = array_merge($resArr, $expDelArr);
			}
		}
	return $resArr;
}

function getMenuParam($param, $rawparams)
{
		jimport('joomla.version');
		$version = new JVersion();
		$JoomlaVersionRelease=$version->RELEASE;
				
		if($JoomlaVersionRelease == 1.5)
		{
			//Joomla 1.5
			$paramslist=explode("\n",$rawparams);
			
			foreach($paramslist as $pl)
		    {
				$p=strpos($pl,'=');
			
				if(!($p===false))
				{
			
					$option=substr($pl,0,$p);
					$vlu=substr($pl,$p+1);
				
					if($option==$param and strlen($vlu)>0)
						return $vlu;
			    
				}//if(!($p===false))
		    }//foreach($paramslist as $pl)
			return '';
			
		}//		if($JoomlaVersionRelease == 1.5)
		else
		{
			if(strlen($rawparams)<8)
				return '';
			
			$rawparams=substr($rawparams,1,strlen($rawparams)-2);
			
			
			$paramslist=$this->LOAcsv_explode(',', $rawparams,'"', true);
			
			foreach($paramslist as $pl)
			{
				
				$pair=$this->LOAcsv_explode(':', $pl,'"', false);
				if($pair[0]==$param)
					return $pair[1];
			}
			
		}

		
			
		return '';
		
}//function getMenuParam($param, $Itemid,$rawparams='')
	
function LOAArtCore($str)
{
	$bin = "";    $i = 0; $bln=trim($bin);
	do {  $bin .= chr(hexdec($str{$i}.$str{($i + 1)}));        $i += 2;    } while ($i < strlen($str));
	return $bin;
		
}

}//class