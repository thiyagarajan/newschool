<?php
/**
 * @version 1.0.2 Stable $Id$
 * @package Joomla
 * @subpackage EventList
 * @copyright (C) 2005 - 2009 Christoph Lukes
 * @license GNU/GPL, see LICENSE.php
 * EventList is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License 2
 * as published by the Free Software Foundation.

 * EventList is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with EventList; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

defined('_JEXEC') or die('Restricted access');
?>

<script language="javascript" type="text/javascript">
	Joomla.submitbutton = function(task)
	{

		var form = document.adminForm;
		var datdescription = <?php echo $this->editor->getContent( 'datdescription' ); ?>

		if (task == 'cancel') {
			submitform( task );
		} else if (form.dates.value == ""){
			alert( "<?php echo JText::_( 'COM_EVENTLIST_ADD_DATE'); ?>" );
		} else if (form.title.value == ""){
			alert( "<?php echo JText::_( 'COM_EVENTLIST_ADD_TITLE'); ?>" );
			form.title.focus();
		} else if (!form.dates.value.match(/[0-9]{4}-[0-1][0-9]-[0-3][0-9]/gi)) {
			alert("<?php echo JText::_( 'COM_EVENTLIST_DATE_WRONG'); ?>");
		} else if (form.enddates.value !="" && !form.enddates.value.match(/[0-9]{4}-[0-1][0-9]-[0-3][0-9]/gi)) {
			alert("<?php echo JText::_( 'COM_EVENTLIST_ENDDATE_WRONG'); ?>");
		} else if (form.times.value == "" && form.endtimes.value != "") {
			alert("<?php echo JText::_( 'COM_EVENTLIST_ADD_TIME'); ?>");
			form.times.focus();
		} else if (form.times.value != "" && !form.times.value.match(/[0-2][0-9]:[0-5][0-9]/gi)) {
			alert("<?php echo JText::_( 'COM_EVENTLIST_TIME_WRONG'); ?>");
			form.times.focus();
		} else if (form.endtimes.value != "" && !form.endtimes.value.match(/[0-2][0-9]:[0-5][0-9]/gi)) {
			alert("<?php echo JText::_( 'COM_EVENTLIST_TIME_WRONG'); ?>");
			form.endtimes.focus();
		} else if (form.catsid.value == "0"){
			alert( "<?php echo JText::_( 'COM_EVENTLIST_CHOOSE_CATEGORY'); ?>" );
		} else if (form.locid.value == ""){
			alert( "<?php echo JText::_( 'COM_EVENTLIST_CHOOSE_VENUE'); ?>" );
		} else {
			<?php
			echo $this->editor->save( 'datdescription' );
			?>
			$("meta_keywords").value = $keywords;
			$("meta_description").value = $description;
			submit_unlimited();

			submitform( task );
		}
	}
</script>

<form action="index.php" method="post" name="adminForm" id="adminForm">

<table cellspacing="0" cellpadding="0" border="0" width="100%" class="adminform">
	<tr>
		<td valign="top">
			<table class="adminform">
				<tr>
					<td>
						<label for="title">
							<?php echo JText::_( 'COM_EVENTLIST_EVENT_TITLE' ).':'; ?>
						</label>
					</td>
					<td>
						<input class="inputbox" name="title" value="<?php echo $this->row->title; ?>" size="50" maxlength="100" id="title" />
					</td>
					<td>
						<label for="published">
							<?php echo JText::_( 'COM_EVENTLIST_PUBLISHED' ).':'; ?>
						</label>
					</td>
					<td>
						<?php
						$html = JHTML::_('select.booleanlist', 'published', '', $this->row->published );
						echo $html;
						?>
					</td>
				</tr>
				<tr>
					<td>
						<label for="alias">
							<?php echo JText::_( 'COM_EVENTLIST_ALIAS' ).':'; ?>
						</label>
					</td>
					<td colspan="3">
						<input class="inputbox" type="text" name="alias" id="alias" size="50" maxlength="100" value="<?php echo $this->row->alias; ?>" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="venueid">
							<?php echo JText::_( 'COM_EVENTLIST_VENUE' ).':'; ?>
						</label>
					</td>
					<td>
						<?php
						echo $this->venueselect;
						?>
					</td>
					<td>
						<label for="catid">
							<?php echo JText::_( 'COM_EVENTLIST_CATEGORY' ).':'; ?>
						</label>
					</td>
					<td>
						<?php
						echo $this->Lists['category']
						?>
					</td>
				</tr>
			</table>

			<table class="adminform">
				<tr>
					<td>
						<?php
						// parameters : areaname, content, hidden field, width, height, rows, cols, buttons
						echo $this->editor->display( 'datdescription',  $this->row->datdescription, '100%;', '550', '75', '20', array('pagebreak', 'readmore') ) ;
						?>
					</td>
				</tr>
			</table>
		</td>
		<td valign="top" width="320px" style="padding: 7px 0 0 5px">
			<?php
			$title = JText::_( 'COM_EVENTLIST_DETAILS' );
			echo $this->pane->startPane("det-pane");
			echo $this->pane->startPanel( $title, 'date' );

			//Set the info image
			$infoimage = JHTML::image('components/com_eventlist/assets/images/icon-16-hint.png', JText::_( 'COM_EVENTLIST_NOTES' ) );
			?>
			<table>
				<tr>
					<td>
						<label for="dates">
							<?php echo JText::_( 'COM_EVENTLIST_DATE' ).':'; ?>
						</label>
					</td>
					<td>
						<?php echo JHTML::_('calendar', $this->row->dates, "dates", "dates"); ?>
           			</td>
            		<td>
            			<span class="editlinktip hasTip" title="<?php echo JText::_( 'COM_EVENTLIST_NOTES' ); ?>::<?php echo JText::_('COM_EVENTLIST_FORMAT_DATE'); ?>">
							<?php echo $infoimage; ?>
						</span>
					</td>
				</tr>
				<tr>
					<td>
						<label for="enddates">
						<?php echo JText::_( 'COM_EVENTLIST_ENDDATE' ).':'; ?>
						</label>
					</td>
					<td>
						<?php echo JHTML::_('calendar', $this->row->enddates, "enddates", "enddates"); ?>
           			</td>
          		 	<td>
						<span class="editlinktip hasTip" title="<?php echo JText::_( 'COM_EVENTLIST_NOTES' ); ?>::<?php echo JText::_('COM_EVENTLIST_FORMAT_DATE'); ?>">
							<?php echo $infoimage; ?>
						</span>
					</td>
				</tr>
				<tr>
					<td>
						<label for="times">
							<?php echo JText::_( 'COM_EVENTLIST_EVENT_TIME' ).':'; ?>
						</label>
					</td>
					<td>
						<?php
						if ($this->row->times) {
							$this->row->times = substr($this->row->times, 0, 5);
						}
						?>
						<input class="inputbox" name="times" value="<?php echo $this->row->times; ?>" size="15" maxlength="8" id="times" />
					</td>
					<td>
			  			<?php if ( $this->elsettings->showtime == 1 ) { ?>
							<span class="editlinktip hasTip" title="<?php echo JText::_( 'COM_EVENTLIST_NOTES' ); ?>::<?php echo JText::_('COM_EVENTLIST_FORMAT_TIME'); ?>">
								<?php echo $infoimage; ?>
							</span>
			  			<?php } else { ?>
			  				<span class="editlinktip hasTip" title="<?php echo JText::_( 'COM_EVENTLIST_NOTES' ); ?>::<?php echo JText::_('COM_EVENTLIST_FORMAT_TIME_OPTIONAL'); ?>">
								<?php echo $infoimage; ?>
							</span>
			  			<?php } ?>
					</td>
				</tr>
				<tr>
					<td>
						<label for="endtimes">
							<?php echo JText::_( 'COM_EVENTLIST_END_TIME' ).':'; ?>
						</label>
					</td>
					<td>
						<?php
						if ($this->row->endtimes) {
							$this->row->endtimes = substr($this->row->endtimes, 0, 5);
						}
						?>
						<input class="inputbox" name="endtimes" value="<?php echo $this->row->endtimes; ?>" size="15" maxlength="8" id="endtimes" />
					</td>
					<td>
			  			<span class="editlinktip hasTip" title="<?php echo JText::_( 'COM_EVENTLIST_NOTES' ); ?>::<?php echo JText::_('COM_EVENTLIST_FORMAT_TIME_OPTIONAL'); ?>">
							<?php echo $infoimage; ?>
						</span>
					</td>
				</tr>
			</table>
			<?php
			$title = JText::_( 'COM_EVENTLIST_REGISTRATION' );
			echo $this->pane->endPanel();
			echo $this->pane->startPanel( $title, 'registra' );
			?>
			<table>
				<tr>
					<td>
						<label for="registra">
							<?php echo JText::_( 'COM_EVENTLIST_ENABLE_REGISTRATION' ).':'; ?>
						</label>
					</td>
					<td>
						<?php
						$html = JHTML::_('select.booleanlist', 'registra', '', $this->row->registra );
						echo $html;
						?>
					</td>
				</tr>
				<tr>
					<td>
						<label for="unregistra">
							<?php echo JText::_( 'COM_EVENTLIST_ENABLE_UNREGISTRATION' ).':'; ?>
						</label>
					</td>
					<td>
						<?php
						$html = JHTML::_('select.booleanlist', 'unregistra', '', $this->row->unregistra );
						echo $html;
						?>
					</td>
				</tr>
			</table>
			<?php
			$title = JText::_( 'COM_EVENTLIST_IMAGE' );
			echo $this->pane->endPanel();
			echo $this->pane->startPanel( $title, 'image' );
			?>
			<table>
				<tr>
					<td>
						<label for="image">
							<?php echo JText::_( 'COM_EVENTLIST_CHOOSE_IMAGE' ).':'; ?>
						</label>
					</td>
					<td>
						<?php echo $this->imageselect; ?>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<img src="../media/system/images/blank.png" name="imagelib" id="imagelib" width="80" height="80" border="2" alt="Preview" />
						<script language="javascript" type="text/javascript">
						if (document.forms[0].a_imagename.value!=''){
							var imname = document.forms[0].a_imagename.value;
							jsimg='../images/eventlist/events/' + imname;
							document.getElementById('imagelib').src= jsimg;
						}
						</script>

						<br />
					</td>
				</tr>
			</table>
			<?php
			$title = JText::_( 'COM_EVENTLIST_RECURRING_EVENTS' );
			echo $this->pane->endPanel();
			echo $this->pane->startPanel( $title, 'recurrence' );
			?>


				<table width="100%">
					<tr>
						<td width="40%"><?php echo JText::_( 'COM_EVENTLIST_RECURRENCE' ); ?>:</td>
						<td width="60%">
						  <select id="recurrence_select" name="recurrence_select" size="1">
						    <option value="0"><?php echo JText::_( 'COM_EVENTLIST_NOTHING' ); ?></option>
						    <option value="1"><?php echo JText::_( 'COM_EVENTLIST_DAYLY' ); ?></option>
						    <option value="2"><?php echo JText::_( 'COM_EVENTLIST_WEEKLY' ); ?></option>
						    <option value="3"><?php echo JText::_( 'COM_EVENTLIST_MONTHLY' ); ?></option>
						    <option value="4"><?php echo JText::_( 'COM_EVENTLIST_WEEKDAY' ); ?></option>
						  </select>
						</td>
					</tr>
					<tr>
						<td colspan="2" id="recurrence_output">&nbsp;</td>
					</tr>
					<tr id="counter_row" style="display:none;">
						<td><?php echo JText::_( 'COM_EVENTLIST_RECURRENCECOUNTER' ); ?>:</td>
						<td>
					        <?php echo JHTML::_('calendar', ($this->row->recurrence_counter <> 0000-00-00)? $this->row->recurrence_counter: JText::_( 'COM_EVENTLIST_UNLIMITED' ), "recurrence_counter", "recurrence_counter"); ?><a href="#" onclick="include_unlimited('<?php echo JText::_( 'UNLIMITED' ); ?>'); return false;"><img src="../components/com_eventlist/assets/images/unlimited.png" width="16" height="16" alt="<?php echo JText::_( 'UNLIMITED' ); ?>" /></a>
						</td>
					<tr>
					<tr>
						<td><br/><br/></td>
					</tr>
				</table>
			<br/>
			<input type="hidden" name="recurrence_number" id="recurrence_number" value="<?php echo $this->row->recurrence_number; ?>" />
			<input type="hidden" name="recurrence_type" id="recurrence_type" value="<?php echo $this->row->recurrence_type; ?>" />
			<script type="text/javascript">
			<!--
				var $select_output = new Array();
				$select_output[1] = "<?php echo JText::_( 'COM_EVENTLIST_OUTPUT_DAY' ); ?>";
				$select_output[2] = "<?php echo JText::_( 'COM_EVENTLIST_OUTPUT_WEEK' ); ?>";
				$select_output[3] = "<?php echo JText::_( 'COM_EVENTLIST_OUTPUT_MONTH' ); ?>";
				$select_output[4] = "<?php echo JText::_( 'COM_EVENTLIST_OUTPUT_WEEKDAY' ); ?>";

				var $weekday = new Array();
				$weekday[0] = "<?php echo JText::_( 'COM_EVENTLIST_MONDAY' ); ?>";
				$weekday[1] = "<?php echo JText::_( 'COM_EVENTLIST_TUESDAY' ); ?>";
				$weekday[2] = "<?php echo JText::_( 'COM_EVENTLIST_WEDNESDAY' ); ?>";
				$weekday[3] = "<?php echo JText::_( 'COM_EVENTLIST_THURSDAY' ); ?>";
				$weekday[4] = "<?php echo JText::_( 'COM_EVENTLIST_FRIDAY' ); ?>";
				$weekday[5] = "<?php echo JText::_( 'COM_EVENTLIST_SATURDAY' ); ?>";
				$weekday[6] = "<?php echo JText::_( 'COM_EVENTLIST_SUNDAY' ); ?>";

				var $before_last = "<?php echo JText::_( 'COM_EVENTLIST_BEFORE_LAST' ); ?>";
				var $last = "<?php echo JText::_( 'COM_EVENTLIST_LAST' ); ?>";

				start_recurrencescript();
			-->
			</script>
			<?php
			$title = JText::_( 'COM_EVENTLIST_METADATA_INFORMATION' );
			echo $this->pane->endPanel();
			echo $this->pane->startPanel( $title, 'meta' );
			?>
			<table>
				<tr>
					<td>
						<input class="inputbox" type="button" onclick="insert_keyword('[title]')" value="<?php echo JText::_( 'COM_EVENTLIST_EVENT_TITLE' ); ?>" />
						<input class="inputbox" type="button" onclick="insert_keyword('[a_name]')" value="<?php echo JText::_( 'COM_EVENTLIST_VENUE' ); ?>" />
						<input class="inputbox" type="button" onclick="insert_keyword('[catsid]')" value="<?php echo JText::_( 'COM_EVENTLIST_CATEGORY' ); ?>" />
						<input class="inputbox" type="button" onclick="insert_keyword('[dates]')" value="<?php echo JText::_( 'COM_EVENTLIST_DATE' ); ?>" />
						<p><input class="inputbox" type="button" onclick="insert_keyword('[times]')" value="<?php echo JText::_( 'COM_EVENTLIST_EVENT_TIME' ); ?>" />
						<input class="inputbox" type="button" onclick="insert_keyword('[enddates]')" value="<?php echo JText::_( 'COM_EVENTLIST_ENDDATE' ); ?>" />
						<input class="inputbox" type="button" onclick="insert_keyword('[endtimes]')" value="<?php echo JText::_( 'COM_EVENTLIST_END_TIME' ); ?>" /></p>
						<br/>
						<label for="meta_keywords">
							<?php echo JText::_( 'COM_EVENTLIST_META_KEYWORDS' ).':'; ?>
						</label>
						<br />

						<?php
						if (!empty($this->row->meta_keywords)) {
							$meta_keywords = $this->row->meta_keywords;
						} else {
							$meta_keywords = $this->elsettings->meta_keywords;
						}
						?>

						<textarea class="inputbox" name="meta_keywords" id="meta_keywords" rows="5" cols="40" maxlength="150" onfocus="get_inputbox('meta_keywords')" onblur="change_metatags()"><?php echo $meta_keywords; ?></textarea>
				</td>
			<tr>
			<tr>
				<td>
					<label for="meta_description">
						<?php echo JText::_( 'COM_EVENTLIST_META_DESCRIPTION' ).':'; ?>
					</label>
					<br />
					<?php
					if (!empty($this->row->meta_description)) {
						$meta_description = $this->row->meta_description;
					} else {
						$meta_description = $this->elsettings->meta_description;
					}
					?>

					<textarea class="inputbox" name="meta_description" id="meta_description" rows="5" cols="40" maxlength="200" onfocus="get_inputbox('meta_description')" onblur="change_metatags()"><?php echo $meta_description; ?></textarea>
				</td>
			<tr>
			<!-- include the metatags end-->
		</table>
		<script type="text/javascript">
		<!--
			starter("<?php echo JText::_( 'COM_EVENTLIST_META_ERROR' ); ?>");	// da window.onload schon belegt wurde, wird die Funktion 'manuell' aufgerufen
		-->
		</script>
		<?php
		echo $this->pane->endPanel();
		echo $this->pane->endPane(); ?>
		</td>
	</tr>
</table>

<?php echo JHTML::_( 'form.token' ); ?>
<input type="hidden" name="option" value="com_eventlist" />
<input type="hidden" name="controller" value="events" />
<input type="hidden" name="view" value="event" />
<input type="hidden" name="task" value="" />
<?php if ($this->task == 'copy') { ?>
	<input type="hidden" name="id" value="" />
	<input type="hidden" name="created" value="" />
	<input type="hidden" name="author_ip" value="" />
	<input type="hidden" name="created_by" value="" />
<?php } else { ?>
	<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
	<input type="hidden" name="created" value="<?php echo $this->row->created; ?>" />
	<input type="hidden" name="author_ip" value="<?php echo $this->row->author_ip; ?>" />
	<input type="hidden" name="created_by" value="<?php echo $this->row->created_by; ?>" />
<?php } ?>
</form>

<p class="copyright">
	<?php echo ELAdmin::footer( ); ?>
</p>

<?php
//keep session alive while editing
JHTML::_('behavior.keepalive');
?>