<?php

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

class NivoSliderModelSlider extends JModelAdmin
{
	public function getTable($type = 'Sliders', $prefix = 'NivoSliderTable', $config = array())
	{		
		
		$table = JTable::getInstance($type, $prefix, $config);
		return $table;
	}
	
	public function getForm($data = array(), $loadData = true)
	{
		
		jimport('joomla.form.form');
		
		// Get the form.
		$form = $this->loadForm('com_nivoslider.slider', 'slider', array('control' => 'jform', 'load_data' => $loadData));
				
		if (empty($form)) {
			return false;
		}
		
		/* not implemented yet
		// Modify the form based on access controls.
		if (!$this->canEditState((object) $data)) {
			// Disable fields for display.
			$form->setFieldAttribute('ordering', 'disabled', 'true');
			$form->setFieldAttribute('published', 'disabled', 'true');

			// Disable fields while saving.
			// The controller has already verified this is a record you can edit.
			$form->setFieldAttribute('ordering', 'filter', 'unset');
			$form->setFieldAttribute('published', 'filter', 'unset');
		}*/

		return $form;
	}
	
	protected function loadFormData()
	{
		// Check the session for previously entered form data.		
		$data = JFactory::getApplication()->getUserState('com_nivoslider.edit.slider.data', array());
		
		if (empty($data)) {
			$data = $this->getItem();
		}

		return $data;
	}
	
	protected function prepareTable(&$table)
	{
		jimport('joomla.filter.output');
		$date = JFactory::getDate();
		$user = JFactory::getUser();

		$table->title		= htmlspecialchars_decode($table->title, ENT_QUOTES);
		$table->alias		= JApplication::stringURLSafe($table->alias);

		if (empty($table->alias)) {
			$table->alias = JApplication::stringURLSafe($table->title);
		}

		if (empty($table->id)) {

			// Set ordering to the last item if not set
			if (empty($table->ordering)) {
				$db = JFactory::getDbo();
				$db->setQuery('SELECT MAX(ordering) FROM #__nivoslider_sliders');
				$max = $db->loadResult();

				$table->ordering = $max+1;
			}
		}
	}
	
	protected function getReorderConditions($table)
	{
		$condition = array();
		//$condition[] = 'catid = '.(int) $table->catid;

		return $condition;
	}
	
	
}
