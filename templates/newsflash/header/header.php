<?php if( $this->countModules('flash_header') ) {?>
<div id= "javascript-flash-header">

<script type="text/javascript">
function startGallery() {
var myGallery = new gallery($('myGallery'), {
timed: true,
defaultTransition: "fade"
});
}
window.onDomReady(startGallery);
</script>
<div class="content">
<div id="myGallery">

<div class="imageElement">
<h3>
<!-- /////////////  Begin Module User23  ////////////////// -->
<?php if( $this->countModules('user23') ) {?>
<div id="at-user23">
<jdoc:include type="modules" name="user23" style="xhtml" />
</div>
<?php } ?>
<!-- /////////////  End Module User23 ////////////////// -->
</h3>

<a href="#" title="open image" class="open"></a>
<img src="<?php echo $this->baseurl; ?>/templates/<?php echo $ATconfig->template ?>/header/slides/header1.jpg" class="full" />
</div>

<div class="imageElement">
<h3>
<!-- /////////////  Begin User Module24  ////////////////// -->
<?php if( $this->countModules('user24') ) {?>
<div id="at-user24">
<jdoc:include type="modules" name="user24" style="xhtml" />
</div>
<?php } ?>
<!-- /////////////  End Module User24 ////////////////// -->
</h3>

<a href="#" title="open image" class="open"></a>
<img src="<?php echo $this->baseurl; ?>/templates/<?php echo $ATconfig->template ?>/header/slides/header2.jpg" class="full" />
</div>

<div class="imageElement">
<h3>
<!-- /////////////  Begin Module User25  ////////////////// -->
<?php if( $this->countModules('user25') ) {?>
<div id="at-user25">
<jdoc:include type="modules" name="user25" style="xhtml" />
</div>
<?php } ?>
<!-- /////////////  End Module User25 ////////////////// -->
</h3>

<a href="#" title="open image" class="open"></a>
<img src="<?php echo $this->baseurl; ?>/templates/<?php echo $ATconfig->template ?>/header/slides/header3.jpg" class="full" />
</div>

<div class="imageElement">
<h3>
<!-- /////////////  Begin Module User26  ////////////////// -->
<?php if( $this->countModules('user26') ) {?>
<div id="at-user26">
<jdoc:include type="modules" name="user26" style="xhtml" />
</div>
<?php } ?>
<!-- /////////////  End User Module26 ////////////////// -->
</h3>

<a href="#" title="open image" class="open"></a>
<img src="<?php echo $this->baseurl; ?>/templates/<?php echo $ATconfig->template ?>/header/slides/header4.jpg" class="full" />
</div>

<div class="imageElement">
<h3>
<!-- /////////////  Start Module User27  ////////////////// -->
<?php if( $this->countModules('user27') ) {?>
<div id="at-user27">
<jdoc:include type="modules" name="user27" style="xhtml" />
</div>
<?php } ?>
<!-- /////////////  End Module User27 ////////////////// -->
</h3>

<a href="#" title="open image" class="open"></a>
<img src="<?php echo $this->baseurl; ?>/templates/<?php echo $ATconfig->template ?>/header/slides/header5.jpg" class="full" />
</div>


</div>
</div>


</div>

<?php } ?>