<?php

// No direct access.
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

if(!empty($this->item->id))
	$urlEdit = NivoSliderHelper::getUrlItems($this->item->id);

?>

<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'slider.cancel' || document.formvalidator.isValid(document.id('slider-form'))) {
			Joomla.submitform(task, document.getElementById('slider-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('COM_NIVOSLIDER_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_nivoslider&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="slider-form" class="form-validate">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo empty($this->item->id) ? JText::_('COM_NIVOSLIDER_NEW') : JText::sprintf('COM_NIVOSLIDER_EDIT', $this->item->id); ?></legend>
			<ul class="adminformlist">
				<li><?php echo $this->form->getLabel('title'); ?>
				<?php echo $this->form->getInput('title'); ?></li>

				<li><?php echo $this->form->getLabel('alias'); ?>
				<?php echo $this->form->getInput('alias'); ?></li>

				<li><?php echo $this->form->getLabel('catid'); ?>
				<?php echo $this->form->getInput('catid'); ?></li>

				<li><?php echo $this->form->getLabel('published'); ?>
				<?php echo $this->form->getInput('published'); ?></li>

				<li><?php echo $this->form->getLabel('image'); ?>
				<?php echo $this->form->getInput('image'); ?></li>

				<li><?php echo $this->form->getLabel('id'); ?>
				<?php echo $this->form->getInput('id'); ?></li>
			</ul>
		</fieldset>
	</div>

	<div class="width-40 fltrt">
		<?php echo  JHtml::_('sliders.start', 'item-slider'); ?>
			
			<?php echo $this->loadTemplate('params'); ?>
			
		<?php echo JHtml::_('sliders.end'); ?>		
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
	<div class='slider_edit_slides'>
		<?php
			if(!empty($this->item->id)) 
				echo JHtml::link($urlEdit, JText::_('COM_NIVOSLIDER_EDIT_SLIDES'))
		?>
	</div>
</form>
<div class="clr"></div>
