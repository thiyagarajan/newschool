<?php

// No direct access.
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'item.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
			Joomla.submitform(task, document.getElementById('item-form'));
		}
	}
</script>

<?php
	 $fieldSetOptional = $this->form->getFieldset('optional');
	 
?>

<form action="<?php echo JRoute::_('index.php?option=com_nivoslider&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate">
	<div class="width-55 fltlft">
		<fieldset class="adminform">
			<legend><?php echo empty($this->item->id) ? JText::_('COM_NIVOSLIDER_NEW') : JText::sprintf('COM_NIVOSLIDER_EDIT', $this->item->id); ?></legend>
			<ul class="adminformlist" id="slide_list">
				<li>
					<?php echo $this->form->getLabel('id'); ?>
					<?php echo $this->form->getInput('id'); ?>
				</li>
				<li>
					<div>
						<?php echo $this->form->getLabel('title'); ?>
						<?php echo $this->form->getInput('title'); ?>
					</div>
				</li>
				<li>
					<div class="hidden">
						<?php echo $this->form->getLabel('alias'); ?>
						<?php echo $this->form->getInput('alias'); ?>
					</div>
				</li>
				<li>
					<?php echo $this->form->getLabel('sliderid'); ?>
					<?php echo $this->form->getInput('sliderid'); ?>
				</li>				
				<li>
					<?php echo $this->form->getLabel('published'); ?>
					<?php echo $this->form->getInput('published'); ?>
				</li>
				<li>
					<div class="clr"></div>
					<hr>
					<div class="clr"></div>
				</li>
				<li>
					<div>
						<?php echo $fieldSetOptional["jform_params_image"]->label;?> 
						<?php echo $fieldSetOptional["jform_params_image"]->input;?>
					</div>
				</li>
				
				<?php if(false): ?>
				<li>
					<div>
						<?php echo $fieldSetOptional["jform_params_thumb_url"]->label;?> 
						<?php echo $fieldSetOptional["jform_params_thumb_url"]->input;?>
					</div>
				</li>
				
				<?php endif?>
				
				<li>
					<div class="sap_vert"></div>
				</li>
				<li>
					<div>
						<?php echo $fieldSetOptional["jform_params_description"]->label;?>
						<div class="clr"></div> 
						<?php echo $fieldSetOptional["jform_params_description"]->input;?>
					</div>
				</li>
				<li>
					<div class="sap_vert"></div>
				</li>
				<li>
					<div>
						<?php echo $fieldSetOptional["jform_params_activate_link"]->label;?>
						<?php echo $fieldSetOptional["jform_params_activate_link"]->input;?>
					</div>
				</li>				
				<li>
					<div>
						<?php echo $fieldSetOptional["jform_params_link"]->label;?>
						<?php echo $fieldSetOptional["jform_params_link"]->input;?>
					</div>
				</li>
				<li>
					<div>
						<?php echo $fieldSetOptional["jform_params_link_open_in"]->label;?>
						<?php echo $fieldSetOptional["jform_params_link_open_in"]->input;?>
					</div>
				</li>
			</ul>
			
		</fieldset>
		
		<script type="text/javascript">
			$(document).ready(function(){
								
			});
		</script>
		
	</div>

	<div class="width-45 fltrt">
		<?php echo  JHtml::_('sliders.start', 'item-slider'); ?>

			<?php echo $this->loadTemplate('params'); ?>
		
		<?php echo JHtml::_('sliders.end'); ?>		
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
<div class="clr"></div>
