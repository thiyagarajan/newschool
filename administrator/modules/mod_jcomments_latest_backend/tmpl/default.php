<?php
// no direct access
defined('_JEXEC') or die;
?>
<table class="adminlist">
	<thead>
		<tr>
			<th>
				<?php echo JText::_('MOD_JCOMMENTS_LATEST_BACKEND_HEADING_COMMENT'); ?>
			</th>
			<th>
				<strong><?php echo JText::_('MOD_JCOMMENTS_LATEST_BACKEND_HEADING_AUHTOR');?></strong>
			</th>
			<th>
				<strong><?php echo JText::_('MOD_JCOMMENTS_LATEST_BACKEND_HEADING_CREATED'); ?></strong>
			</th>
			<th>
				<strong><?php echo JText::_('MOD_JCOMMENTS_LATEST_BACKEND_HEADING_STATE'); ?></strong>
			</th>
		</tr>
	</thead>
<?php if (count($list)) : ?>
	<tbody>
	<?php foreach ($list as $i=>$item) : ?>
		<tr>
			<th scope="row">
				<?php if ($item->checked_out) : ?>
					<?php if (version_compare(JVERSION, '1.6.0', 'ge')) : ?>
						<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time); ?>
					<?php endif; ?>
				<?php endif; ?>
				<?php if ($item->link) :?>
					<a href="<?php echo $item->link; ?>"><?php echo htmlspecialchars($item->comment, ENT_QUOTES, 'UTF-8');?></a>
				<?php else : ?>
					<?php echo htmlspecialchars($item->comment, ENT_QUOTES, 'UTF-8'); ?>
				<?php endif; ?>
			</th>
			<td class="center">
				<?php echo $item->author;?>
			</td>
			<td class="center">
				<?php if (version_compare(JVERSION, '1.6.0', 'ge')) : ?>
					<?php echo JHtml::_('date', $item->date, 'Y-m-d H:i:s'); ?>
				<?php else : ?>
					<?php echo JHtml::_('date', $item->date, '%Y-%m-%d %H:%M'); ?>
				<?php endif; ?>
			</td>
			<td class="center">
				<?php if (version_compare(JVERSION, '1.6.0', 'ge')) : ?>
					<?php echo JHtml::_('jgrid.published', $item->published, $i, '', false); ?>
				<?php else : ?>
					<img src="images/<?php echo $item->published ? 'tick.png' : 'publish_x.png'; ?>" border="0" alt="<?php echo $item->published ? JText::_('Published') : JText::_('Unpublished'); ?>" />
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
<?php else : ?>
	<tbody>
		<tr>
			<td colspan="4">
				<p class="noresults"><?php echo JText::_('MOD_JCOMMENTS_LATEST_BACKEND_NO_MATCHING_RESULTS');?></p>
			</td>
		</tr>
	</tbody>
<?php endif; ?>
</table>