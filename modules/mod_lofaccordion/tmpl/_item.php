<h4><?php echo $row->title; ?></h4>
<?php if( $params->get('item_content','introtext') == 'introtext'): ?>
<?php echo $row->introtext; ?>
<?php else: ?>
	 <a <?php echo $target;?>  href="<?php echo $row->link;?>" title="<?php echo $row->title;?>"><?php echo $row->mainImage; ?></a>
<p><?php echo $row->description; ?></p>
<?php endif; ?>
 <?php if( $params->get('show_button_link','0') ) : ?>
      <a <?php echo $target;?>  href="<?php echo $row->link;?>" title="<?php echo $row->title;?>"><?php echo JText::_('Read more...');?></a>
 <?php endif; ?>
<div class="clearfix clear clr"></div>

