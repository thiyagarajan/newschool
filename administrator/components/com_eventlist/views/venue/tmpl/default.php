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

  window.addEvent('domready', function() {
  
    $('map0').addEvent('click', removerequired);
    $('map1').addEvent('click', addrequired);
    
    if($('map1').checked) {
      addrequired();
    }
  
  });
  
  function addrequired() {
    $('street').addClass('required');
    $('plz').addClass('required');
    $('city').addClass('required');
    $('country').addClass('required');
  }
  
  function removerequired() {    
    $('street').removeClass('required');
    $('plz').removeClass('required');
    $('city').removeClass('required');
    $('country').removeClass('required');
  }
  
	Joomla.submitbutton = function(task)
	{
		var form = document.adminForm;
    var validator = document.formvalidator;

		var locdescription = <?php echo $this->editor->getContent( 'locdescription' ); ?>

		if (task == 'cancel') {
			submitform( task );
		} else if (validator.validate(form.venue) === false) {
			alert( "<?php echo JText::_( 'COM_EVENTLIST_ADD_VENUE' ); ?>" );
			form.venue.focus();
		} else if (validator.validate(form.city) === false){
			alert( "<?php echo JText::_( 'COM_EVENTLIST_ADD_CITY' ); ?>" );
			form.city.focus();
		} else if (validator.validate(form.street) === false){
			alert( "<?php echo JText::_( 'COM_EVENTLIST_ADD_STREET' ); ?>" );
			form.street.focus();
		} else if (validator.validate(form.plz) === false){
			alert( "<?php echo JText::_( 'COM_EVENTLIST_ADD_ZIP' ); ?>" );
			form.plz.focus();
		} else if (validator.validate(form.country) === false){
			alert( "<?php echo JText::_( 'COM_EVENTLIST_ADD_COUNTRY' ); ?>" );
			form.country.focus();
		} else {
			<?php
			echo $this->editor->save( 'locdescription' );
			?>
			submitform( task );
		}
	}
</script>

<form action="index.php" method="post" name="adminForm" id="adminForm" class="form-validate">

<table cellspacing="0" cellpadding="0" border="0" width="100%">
	<tr>
		<td valign="top">

	<table  class="adminform">
		<tr>
			<td>
				<label for="venue">
					<?php echo JText::_( 'COM_EVENTLIST_VENUE' ).':'; ?>
				</label>
			</td>
			<td>
				<input class="inputbox" name="venue" id= "venue" value="<?php echo $this->row->venue; ?>" size="40" maxlength="100" />
			</td>
			<td>
				<label for="published">
					<?php echo JText::_( 'COM_EVENTLIST_PUBLISHED' ).':'; ?>
				</label>
			</td>
			<td>
				<?php
				$html = JHTML::_('select.booleanlist', 'published', 'class="inputbox"', $this->row->published );
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
				<input class="inputbox" type="text" name="alias" id="alias" size="40" maxlength="100" value="<?php echo $this->row->alias; ?>" />
			</td>
		</tr>
	</table>
			<table class="adminform">
				<tr>
					<td>
						<?php
						echo $this->editor->display( 'locdescription',  $this->row->locdescription, '100%;', '550', '75', '20', array('pagebreak', 'readmore') ) ;
						?>
					</td>
				</tr>
				</table>
			</td>
			<td valign="top" width="320px" style="padding: 7px 0 0 5px">
		<?php
		$title = JText::_( 'COM_EVENTLIST_ADDRESS' );
		echo $this->pane->startPane('det-pane');
		echo $this->pane->startPanel( $title, 'address' );

		//Set the info image
		$infoimage = JHTML::image('components/com_eventlist/assets/images/icon-16-hint.png', JText::_( 'COM_EVENTLIST_NOTES' ) );
		?>
	<table>
		<tr>
			<td>
				<label for="street">
					<?php echo JText::_( 'COM_EVENTLIST_STREET' ).':'; ?>
				</label>
			</td>
			<td>
				<input class="inputbox" name="street" id="street" value="<?php echo $this->row->street; ?>" size="35" maxlength="50" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="plz">
					<?php echo JText::_( 'COM_EVENTLIST_ZIP' ).':'; ?>
				</label>
			</td>
			<td>
				<input class="inputbox" name="plz" id="plz" value="<?php echo $this->row->plz; ?>" size="15" maxlength="10" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="city">
					<?php echo JText::_( 'COM_EVENTLIST_CITY' ).':'; ?>
				</label>
			</td>
			<td>
				<input class="inputbox" name="city" id="city" value="<?php echo $this->row->city; ?>" size="35" maxlength="50" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="state">
					<?php echo JText::_( 'COM_EVENTLIST_STATE' ).':'; ?>
				</label>
			</td>
			<td>
				<input class="inputbox" name="state" id="state" value="<?php echo $this->row->state; ?>" size="35" maxlength="50" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="country">
					<?php echo JText::_( 'COM_EVENTLIST_COUNTRY' ).':'; ?>
				</label>
			</td>
			<td>
				<input class="inputbox" name="country" id="country" value="<?php echo $this->row->country; ?>" size="3" maxlength="2" />&nbsp;

				<span class="editlinktip hasTip" title="<?php echo JText::_( 'COM_EVENTLIST_NOTES' ); ?>::<?php echo JText::_('COM_EVENTLIST_COUNTRY_HINT'); ?>">
					<?php echo $infoimage; ?>
				</span>
			</td>
		</tr>
		<tr>
			<td>
				<label for="url">
					<?php echo JText::_( 'COM_EVENTLIST_WEBSITE' ).':'; ?>
				</label>
			</td>
			<td>
				<input class="inputbox" name="url" id="url" value="<?php echo $this->row->url; ?>" size="30" maxlength="199" />&nbsp;

				<span class="editlinktip hasTip" title="<?php echo JText::_( 'COM_EVENTLIST_NOTES' ); ?>::<?php echo JText::_('COM_EVENTLIST_WEBSITE_HINT'); ?>">
					<?php echo $infoimage; ?>
				</span>
			</td>
		</tr>
		<?php if ( $this->settings->showmapserv != 0 ) { ?>
		<tr>
			<td>
				<label for="map">
					<?php echo JText::_( 'COM_EVENTLIST_ENABLE_MAP' ).':'; ?>
				</label>
			</td>
			<td>
				<?php
          			echo JHTML::_('select.booleanlist', 'map', 'class="inputbox"', $this->row->map );
          		?>
          		&nbsp;
          		<span class="editlinktip hasTip" title="<?php echo JText::_( 'COM_EVENTLIST_NOTES' ); ?>::<?php echo JText::_('COM_EVENTLIST_ADDRESS_NOTICE'); ?>">
					<?php echo $infoimage; ?>
				</span>
			</td>
		</tr>
		<?php } ?>
	</table>
	<?php
	$title = JText::_( 'COM_EVENTLIST_IMAGE' );
	echo $this->pane->endPanel();
	echo $this->pane->startPanel( $title, 'image' );
	?>
	<table>
		<tr>
			<td>
				<label for="locimage">
					<?php echo JText::_( 'COM_EVENTLIST_CHOOSE_IMAGE' ).':'; ?>
				</label>
			</td>
			<td>
				<?php
					echo $this->imageselect;
				?>
			</td>
		</tr>
		<tr>
			<td>
			</td>
			<td>
				<img src="../media/system/images/blank.png" name="imagelib" id="imagelib" width="80" height="80" border="2" alt="Preview" />
				<script language="javascript" type="text/javascript">
				if (document.forms[0].a_imagename.value!=''){
					var imname = document.forms[0].a_imagename.value;
					jsimg='../images/eventlist/venues/' + imname;
					document.getElementById('imagelib').src= jsimg;
				}
				</script>
				<br />
				<br />
			</td>
		</tr>
	</table>
	<?php
	$title = JText::_( 'COM_EVENTLIST_METADATA_INFORMATION' );
	echo $this->pane->endPanel();
	echo $this->pane->startPanel( $title, 'metadata' );
	?>
	<table>
		<tr>
			<td>
				<label for="metadesc">
					<?php echo JText::_( 'COM_EVENTLIST_META_DESCRIPTION' ); ?>:
				</label>
				<br />
				<textarea class="inputbox" cols="40" rows="5" name="meta_description" id="metadesc" style="width:300px;"><?php echo str_replace('&','&amp;',$this->row->meta_description); ?></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<label for="metakey">
					<?php echo JText::_( 'COM_EVENTLIST_META_KEYWORDS' ); ?>:
				</label>
				<br />
				<textarea class="inputbox" cols="40" rows="5" name="meta_keywords" id="metakey" style="width:300px;"><?php echo str_replace('&','&amp;',$this->row->meta_keywords); ?></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<input type="button" class="button" value="<?php echo JText::_( 'COM_EVENTLIST_ADD_VENUE_CITY' ); ?>" onclick="f=document.adminForm;f.metakey.value=f.venue.value+', '+f.city.value+f.metakey.value;" />
			</td>
		</tr>
	</table>

		<?php
		echo $this->pane->endPanel();
		echo $this->pane->endPane();
		?>
		</td>
	</tr>
</table>

<?php
if ( $this->settings->showmapserv == 0 ) { ?>
	<input type="hidden" name="map" value="0" />
<?php
}
?>
	<?php echo JHTML::_( 'form.token' ); ?>
	<input type="hidden" name="option" value="com_eventlist" />
	<input type="hidden" name="controller" value="venues" />
	<input type="hidden" name="view" value="venue" />
	<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
	<input type="hidden" name="created" value="<?php echo $this->row->created; ?>" />
	<input type="hidden" name="author_ip" value="<?php echo $this->row->author_ip; ?>" />
	<input type="hidden" name="created_by" value="<?php echo $this->row->created_by; ?>" />
	<input type="hidden" name="task" value="" />
</form>

<p class="copyright">
	<?php echo ELAdmin::footer( ); ?>
</p>

<?php
//keep session alive while editing
JHTML::_('behavior.keepalive');
?>