<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.modellist');

class NivoSliderModelItems extends JModelList
{
	
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'a.id',
				'title', 'a.title',
				'alias', 'a.alias',
				'sliderid', 'a.sliderid',
				'ordering', 'a.ordering',
				'checked_out', 'a.checked_out',
				'checked_out_time', 'a.checked_out_time',
				'published', 'a.published',
				'access', 'a.access', 'access_level',
				'created', 'a.created',
				'created_by', 'a.created_by',
				'language', 'a.language'
			);
		}

		parent::__construct($config);
	}
	
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication();

		$published = $this->getUserStateFromRequest($this->context.'.filter.published', 'filter_published', '');
		$this->setState('filter.published', $published);
		
		//set sliderID
		$sliderID = JRequest::getString("sliderid");
		if(empty($sliderID))
			$sliderID = $this->getUserStateFromRequest($this->context.'.filter.slider', 'filter_sliders', '');
		if(empty($sliderID))
			$sliderID = NivoSliderHelper::getFirstSliderID();
	
		$this->setState('filter.slider', $sliderID);
		
		// List state information.
		parent::populateState('a.ordering', 'asc');
	}

	
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('filter.published');
		$id	.= ':'.$this->getState('filter.slider');
		
		return parent::getStoreId($id);
	}
	
	/**
	 * 
	 * get sliders array
	 */
	public function getArrSliders(){
		$arrSliders = NivoSliderHelper::getArrSliders();
		return($arrSliders);
	}
	
	protected function getListQuery()
	{
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.*'
			)
		);
		$query->from('#__nivoslider AS a');
		
		// Join over the categories.
		$query->select('c.title AS category_title');
		$query->join('LEFT', '#__categories AS c ON c.id = a.catid');
		
		// Join over the users for the checked out user.
		$query->select('uc.name AS editor');
		$query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');
		
		// Filter by published state
		$published = $this->getState('filter.published');
		if (is_numeric($published)) {
			$query->where('a.published = ' . (int) $published);
		}
		else if ($published === '') {
			$query->where('(a.published = 0 OR a.published = 1)');
		}
		
		// Filter by category state
		$category = $this->getState('filter.category');
		if (is_numeric($category)) {
			$query->where('a.catid = ' . (int) $category);
		}
		
		//Filter by search in title.
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('a.id = '.(int) substr($search, 3));
			}
			else {
				$search = $db->Quote('%'.$db->getEscaped($search, true).'%');
				$query->where('(a.title LIKE '.$search.' OR a.alias LIKE '.$search.')');
			}
		}
		
		$slider = $this->getState('filter.slider');
		if(!empty($slider)){
			$query->where("a.sliderid='$slider'");
		}
		
		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering');
		$orderDirn	= $this->state->get('list.direction',"asc");
		
		if ($orderCol == 'a.ordering' || $orderCol == 'category_title') {
			$orderCol = 'category_title '.$orderDirn.', a.ordering';
		}
		$query->order($db->getEscaped($orderCol.' '.$orderDirn));
		
		return $query;
	}
	
	/**
	 * get items rewrited, add slider title to slide properties
	 */
	public function getItems(){
		$items = parent::getItems();		
		$arrSlidersAssoc = NivoSliderHelper::getArrSlidersAssoc();
		
		foreach ($items as $key=>$item){
			if(!isset($arrSlidersAssoc[$item->sliderid]))
				throw new Exception("Slider with id: {$item->sliderid} not found");
			
			$slider = $arrSlidersAssoc[$item->sliderid];			
			$items[$key]->slider_name = $slider["title"];
		}
		
		return($items);
	}
	
	
}
