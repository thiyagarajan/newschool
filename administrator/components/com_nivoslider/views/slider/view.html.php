<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.view');
class NivoSliderViewSlider extends JView
{
	protected $form;
	protected $item;
	protected $state;
	
	public function display($tpl = null)
	{
		// Initialiase variables.		
		$this->form		= $this->get('Form');
		$this->item		= $this->get('Item');
		$this->state	= $this->get('State');
		
		
		
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
		JRequest::setVar('hidemainmenu', true);
		
		$user		= JFactory::getUser();
		$userId		= $user->get('id');
		$isNew		= ($this->item->id == 0);

		$text = $isNew ? JText::_( 'COM_NIVOSLIDER_NEW' ) : JText::_( 'COM_NIVOSLIDER_EDIT' );
		JToolBarHelper::title(   JText::_( 'COM_NIVOSLIDER_SLIDER' ).': <small><small>[ ' . $text.' ]</small></small>', 'generic.png' );
		
		if ($isNew){
			// For new records, check the create permission.
				JToolBarHelper::apply('slider.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('slider.save', 'JTOOLBAR_SAVE');
				JToolBarHelper::custom('slider.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);

			JToolBarHelper::cancel('slider.cancel', 'JTOOLBAR_CANCEL');
		}
		else {

			// If checked out, we can still save
			JToolBarHelper::apply('slider.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('slider.save', 'JTOOLBAR_SAVE');
			JToolBarHelper::custom('slider.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
			JToolBarHelper::cancel('slider.cancel', 'JTOOLBAR_CLOSE');
			
		}

	}
}
