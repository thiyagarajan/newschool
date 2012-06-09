<?php
/**
 * @version		$Id: edit_metadata.php 17342 2010-05-29 06:15:59Z eddieajau $
 * @package		Joomla.Administrator
 * @subpackage	com_menus
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
?>
<?php foreach ($this->form->getGroup('attachment') as $field): ?>
<?php echo $field->label; ?>
<?php echo $field->input; ?>
<?php endforeach; ?>