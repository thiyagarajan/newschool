<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.view');

class NivoSliderViewSliders extends JView
{
	protected $items;
	protected $pagination;
	protected $state;
	
	public function display($tpl = null)
	{
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		
		$this->addToolbar();		
		parent::display($tpl);
	}
	
	protected function addToolbar()
	{
		JToolBarHelper::title(JText::_('COM_NIVOSLIDER_SLIDES'), 'generic.png');

		JToolBarHelper::addNew('slider.add','JTOOLBAR_NEW');
		JToolBarHelper::editList('slider.edit','JTOOLBAR_EDIT');
		JToolBarHelper::deleteList('COM_NIVOSLIDER_SLIDER_APPROVE_DELETE', 'sliders.delete','JTOOLBAR_DELETE');
		JToolBarHelper::divider();
		JToolBarHelper::custom('sliders.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
		JToolBarHelper::custom('sliders.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
		//JToolBarHelper::divider();
		//JToolBarHelper::preferences('com_nivoslider', 300, 600);
		
	}
}