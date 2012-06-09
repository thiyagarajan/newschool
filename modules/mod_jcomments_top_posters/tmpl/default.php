<?php
// no direct access
defined('_JEXEC') or die;
?>
<?php if (!empty($list)) :?>
<ul class="jcomments-top-posters<?php echo $params->get('moduleclass_sfx'); ?>">
	<?php $i = 0; ?>
	<?php foreach ($list as $item) : ?>
	<li class="<?php echo ($i % 2 ? 'even' : 'odd');?>">
		<?php if ($params->get('show_avatar')) :?>
			<?php echo $item->avatar; ?>
		<?php endif; ?>

		<div class="user<?php echo $params->get('show_avatar') ? ' avatar-indent' : '';?>">
			<div class="name">
			<?php if ($params->get('link_profile') && $item->profileLink) :?>
			<a href="<?php echo $item->profileLink; ?>"><?php echo $item->displayAuthorName; ?></a>
			<?php else : ?>
			<?php echo $item->displayAuthorName; ?>
			<?php endif; ?>
			</div>

			<?php if ($params->get('show_comments_count')) :?>
			<span><?php echo $item->commentsCount; ?></span>
			<?php endif; ?>

			<?php if ($params->get('show_votes') > 0) :?>
			(<span class="votes">
				<?php if ($params->get('show_votes') == 1) :?>
					<?php if ($item->votes < 0) :?>
					<span class="vote-poor">-<?php echo $item->votes; ?></span>
					<?php elseif ($item->votes > 0) :?>
					<span class="vote-good">+<?php echo $item->votes; ?></span>
					<?php else :?>
					<span class="vote-none"><?php echo $item->votes; ?></span>
					<?php endif; ?>
				<?php elseif ($params->get('show_votes') == 2) :?>
					<span class="vote-good">+<?php echo $item->isgood; ?></span>/<span class="vote-poor">-<?php echo $item->ispoor; ?></span>
				<?php endif; ?>
			</span>)
			<?php endif; ?>
		</div>
	</li>
	<?php $i++; ?>
	<?php endforeach; ?>
</ul>
<?php endif; ?>
