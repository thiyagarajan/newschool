<?php
// no direct access
defined('_JEXEC') or die;
?>
<?php if (!empty($list)) :?>
<ul class="jcomments-latest-commented<?php echo $params->get('moduleclass_sfx'); ?>">
	<?php foreach ($list as $item) : ?>
	<li>
		<a href="<?php echo $item->link; ?>#comments">
			<?php if ($params->get('showCommentsCount')) :?>
				<?php echo $item->title; ?>&nbsp;(<?php echo $item->commentsCount; ?>)
			<?php else : ?>
				<?php echo $item->title; ?>
			<?php endif; ?>
		</a>
	</li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>
