<table class="noshow">
	<tr>
   		<td width="50%" valign="top">
			<table class="noshow">
      			<tr>
        			<td width="50%" valign="top">
						<fieldset class="adminform">
							<legend><?php echo JText::_( 'COM_EVENTLIST_GLOBAL_PARAMETERS' ); ?></legend>
							<table class="admintable" cellspacing="1">
								<tbody>
      								<tr>
	          							<td width="300" class="key">
											<span class="editlinktip hasTip" title="<?php echo JText::_( 'COM_EVENTLIST_EVENT_NUMBER' ); ?>::<?php echo JText::_('COM_EVENTLIST_EVENT_NUMBER_TIP'); ?>">
												<?php echo JText::_( 'COM_EVENTLIST_EVENT_NUMBER' ); ?>
											</span>
										</td>
       									<td valign="top">
        									<?php
		  									$nr = array();
											$nr[] = JHTML::_('select.option', '5', 5 );
											$nr[] = JHTML::_('select.option', '10', 10 );
											$nr[] = JHTML::_('select.option', '15', 15 );
											$nr[] = JHTML::_('select.option', '20', 20 );
											$nr[] = JHTML::_('select.option', '25', 25 );
											$nr[] = JHTML::_('select.option', '30', 30 );
											$nr[] = JHTML::_('select.option', '50', 50 );
											$nrevents = JHTML::_('select.genericlist', $nr, 'globalparams[display_num]', 'size="1" class="inputbox"', 'value', 'text', $this->globalparams->get('display_num') );
											echo $nrevents;
        									?>
       	 								</td>
      								</tr>
      								<tr>
	          							<td width="300" class="key">
											<span class="editlinktip hasTip" title="<?php echo JText::_( 'COM_EVENTLIST_CAT_DISPLAY' ); ?>::<?php echo JText::_('COM_EVENTLIST_CAT_DISPLAY_DESC'); ?>">
												<?php echo JText::_( 'COM_EVENTLIST_CAT_DISPLAY' ); ?>
											</span>
										</td>
       									<td valign="top">
											<input type="text" name="globalparams[cat_num]" value="<?php echo $this->globalparams->get('cat_num'); ?>" size="3" maxlength="3" />
       	 								</td>
      								</tr>
      								<tr>
	          							<td width="300" class="key">
											<span class="editlinktip hasTip" title="<?php echo JText::_( 'COM_EVENTLIST_FILTER' ); ?>::<?php echo JText::_('COM_EVENTLIST_FILTER_DESC'); ?>">
												<?php echo JText::_( 'COM_EVENTLIST_FILTER' ); ?>
											</span>
										</td>
       									<td valign="top">
        									<?php
											echo JHTML::_('select.booleanlist', 'globalparams[filter]', 'class="inputbox"', $this->globalparams->get('filter'), 'JSHOW', 'JHIDE' );
        									?>
       	 								</td>
      								</tr>
      								<tr>
	          							<td width="300" class="key">
											<span class="editlinktip hasTip" title="<?php echo JText::_( 'COM_EVENTLIST_DISPLAY_SELECT' ); ?>::<?php echo JText::_('COM_EVENTLIST_DISPLAY_SELECT_DESC'); ?>">
												<?php echo JText::_( 'COM_EVENTLIST_DISPLAY_SELECT' ); ?>
											</span>
										</td>
       									<td valign="top">
        									<?php
											echo JHTML::_('select.booleanlist', 'globalparams[display]', 'class="inputbox"', $this->globalparams->get('display'), 'JSHOW', 'JHIDE' );
        									?>
       	 								</td>
      								</tr>
      								<tr valign="top">
	          							<td width="300" class="key">
											<span class="editlinktip hasTip" title="<?php echo JText::_( 'COM_EVENTLIST_SHOW_ICONS' ); ?>::<?php echo JText::_('COM_EVENTLIST_SHOW_ICONS_DESC'); ?>">
												<?php echo JText::_( 'COM_EVENTLIST_SHOW_ICONS' ); ?>
											</span>
										</td>
       									<td valign="top">
		 									<?php
          									echo JHTML::_('select.booleanlist', 'globalparams[icons]', 'class="inputbox"', $this->globalparams->get('icons'), 'JSHOW', 'JHIDE' );
       										?>
       	 								</td>
      								</tr>
      								<tr valign="top">
	          							<td width="300" class="key">
											<span class="editlinktip hasTip" title="<?php echo JText::_( 'COM_EVENTLIST_PRINT_ICON' ); ?>::<?php echo JText::_('COM_EVENTLIST_PRINT_ICON_DESC'); ?>">
												<?php echo JText::_( 'COM_EVENTLIST_PRINT_ICON' ); ?>
											</span>
										</td>
       									<td valign="top">
		 									<?php
          									echo JHTML::_('select.booleanlist', 'globalparams[show_print_icon]', 'class="inputbox"', $this->globalparams->get('show_print_icon'), 'JSHOW', 'JHIDE' );
       										?>
       	 								</td>
      								</tr>
      								<tr valign="top">
	          							<td width="300" class="key">
											<span class="editlinktip hasTip" title="<?php echo JText::_( 'COM_EVENTLIST_EMAIL_ICON' ); ?>::<?php echo JText::_('COM_EVENTLIST_EMAIL_ICON_DESC'); ?>">
												<?php echo JText::_( 'COM_EVENTLIST_EMAIL_ICON' ); ?>
											</span>
										</td>
       									<td valign="top">
		 									<?php
          									echo JHTML::_('select.booleanlist', 'globalparams[show_email_icon]', 'class="inputbox"', $this->globalparams->get('show_email_icon'), 'JSHOW', 'JHIDE' );
       										?>
       	 								</td>
      								</tr>
								</tbody>
							</table>
						</fieldset>
					</td>

					<td width="50%" valign="top">
						<table class="noshow">
      						<tr>
        						<td width="50%" valign="top">
									<fieldset class="adminform">
										<legend><?php echo JText::_( 'COM_EVENTLIST_ATTENTION' ); ?></legend>
										<table class="admintable" cellspacing="1">
											<tbody>
	 											<tr>
	          										<td>
														<?php echo JText::_( 'COM_EVENTLIST_GLOBAL_PARAM_DESC' ); ?>
       	 											</td>
      											</tr>
											</tbody>
										</table>
		 							</fieldset>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>