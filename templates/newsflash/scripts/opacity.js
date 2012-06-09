// Browser Detect Lite  v2.1
// http://www.dithered.com/javascript/browser_detect/index.html
// modified by Chris Nott (chris@NOSPAMdithered.com - remove NOSPAM)
//
// modified by Michael Lovitt to include OmniWeb and Dreamcast

function BrowserDetectLite() {
	var ua = navigator.userAgent.toLowerCase(); 
	this.ua = ua;

	// browser name
	this.isGecko     = (ua.indexOf('gecko') != -1);
	this.isMozilla   = (this.isGecko && ua.indexOf("gecko/") + 14 == ua.length);
	this.isNS        = ( (this.isGecko) ? (ua.indexOf('netscape') != -1) : ( (ua.indexOf('mozilla') != -1) && (ua.indexOf('spoofer') == -1) && (ua.indexOf('compatible') == -1) && (ua.indexOf('opera') == -1) && (ua.indexOf('webtv') == -1) && (ua.indexOf('hotjava') == -1) ) );
	this.isIE        = ( (ua.indexOf("msie") != -1) && (ua.indexOf("opera") == -1) && (ua.indexOf("webtv") == -1) ); 
	this.isOpera     = (ua.indexOf("opera") != -1); 
	this.isKonqueror = (ua.indexOf("konqueror") != -1); 
	this.isIcab      = (ua.indexOf("icab") != -1); 
	this.isAol       = (ua.indexOf("aol") != -1); 
	this.isWebtv     = (ua.indexOf("webtv") != -1); 
	this.isOmniweb   = (ua.indexOf("omniweb") != -1);
	this.isDreamcast   = (ua.indexOf("dreamcast") != -1);
	
	// spoofing and compatible browsers
	this.isIECompatible = ( (ua.indexOf("msie") != -1) && !this.isIE);
	this.isNSCompatible = ( (ua.indexOf("mozilla") != -1) && !this.isNS && !this.isMozilla);
	
	// browser version
	this.versionMinor = parseFloat(navigator.appVersion); 
	
	// correct version number for NS6+ 
	if (this.isNS && this.isGecko) {
		this.versionMinor = parseFloat( ua.substring( ua.lastIndexOf('/') + 1 ) );
	}
	
	// correct version number for IE4+ 
	else if (this.isIE && this.versionMinor >= 4) {
		this.versionMinor = parseFloat( ua.substring( ua.indexOf('msie ') + 5 ) );
	}
	
	// correct version number for Opera 
	else if (this.isOpera) {
		if (ua.indexOf('opera/') != -1) {
			this.versionMinor = parseFloat( ua.substring( ua.indexOf('opera/') + 6 ) );
		}
		else {
			this.versionMinor = parseFloat( ua.substring( ua.indexOf('opera ') + 6 ) );
		}
	}
	
	// correct version number for Konqueror
	else if (this.isKonqueror) {
		this.versionMinor = parseFloat( ua.substring( ua.indexOf('konqueror/') + 10 ) );
	}
	
	// correct version number for iCab 
	else if (this.isIcab) {
		if (ua.indexOf('icab/') != -1) {
			this.versionMinor = parseFloat( ua.substring( ua.indexOf('icab/') + 6 ) );
		}
		else {
			this.versionMinor = parseFloat( ua.substring( ua.indexOf('icab ') + 6 ) );
		}
	}
	
	// correct version number for WebTV
	else if (this.isWebtv) {
		this.versionMinor = parseFloat( ua.substring( ua.indexOf('webtv/') + 6 ) );
	}
	
	this.versionMajor = parseInt(this.versionMinor); 
	this.geckoVersion = ( (this.isGecko) ? ua.substring( (ua.lastIndexOf('gecko/') + 6), (ua.lastIndexOf('gecko/') + 14) ) : -1 );
	
	// platform
	this.isWin   = (ua.indexOf('win') != -1);
	this.isWin32 = (this.isWin && ( ua.indexOf('95') != -1 || ua.indexOf('98') != -1 || ua.indexOf('nt') != -1 || ua.indexOf('win32') != -1 || ua.indexOf('32bit') != -1) );
	this.isMac   = (ua.indexOf('mac') != -1);
	this.isUnix  = (ua.indexOf('unix') != -1 || ua.indexOf('linux') != -1 || ua.indexOf('sunos') != -1 || ua.indexOf('bsd') != -1 || ua.indexOf('x11') != -1)
	
	// specific browser shortcuts
	this.isNS4x = (this.isNS && this.versionMajor == 4);
	this.isNS40x = (this.isNS4x && this.versionMinor < 4.5);
	this.isNS47x = (this.isNS4x && this.versionMinor >= 4.7);
	this.isNS4up = (this.isNS && this.versionMinor >= 4);
	this.isNS6x = (this.isNS && this.versionMajor == 6);
	this.isNS6up = (this.isNS && this.versionMajor >= 6);
	
	this.isIE4x = (this.isIE && this.versionMajor == 4);
	this.isIE4up = (this.isIE && this.versionMajor >= 4);
	this.isIE5x = (this.isIE && this.versionMajor == 5);
	this.isIE55 = (this.isIE && this.versionMinor == 5.5);
	this.isIE5up = (this.isIE && this.versionMajor >= 5);
	this.isIE6x = (this.isIE && this.versionMajor == 6);
	this.isIE6up = (this.isIE && this.versionMajor >= 6);
	
	this.isIE4xMac = (this.isIE4x && this.isMac);
}
var browser = new BrowserDetectLite();

// if IE5.5+ on Win32, then display PNGs with AlphaImageLoader
if ((browser.isIE55 || browser.isIE6up) && browser.isWin32) {
	var pngAlpha = true;
// else, if the browser can display PNGs normally, then do that
} else if ((browser.isGecko) ||
(browser.isIE5up && browser.isMac) ||
(browser.isOpera && browser.isWin && browser.versionMajor >= 6) ||
(browser.isOpera && browser.isUnix && browser.versionMajor >= 6) ||
(browser.isOpera && browser.isMac && browser.versionMajor >= 5) ||
(browser.isOmniweb && browser.versionMinor >= 3.1) ||
(browser.isIcab && browser.versionMinor >= 1.9) ||
(browser.isWebtv) ||
(browser.isDreamcast)) {
	var pngNormal = true;
}

//---------------------------------------------------------------
// Opacity Displayer, Version 1.0
// Copyright Michael Lovitt, 6/2002.
// Distribute freely, but please leave this notice intact.
//---------------------------------------------------------------

//---------------------------------------------------------------
// OPACITY OBJECT
//
// Instantiates the object, defines the properties and methods.
function OpacityObject(divId, strPath) {
	this.id = divId;
	this.path = strPath;
	if (ns){
		if (browserVersion>=5) {
			this.layerObject = document.getElementById(divId).style;
		} else { 
			this.layerObject = eval("document."+divId);
		}
	} else {
		this.layerObject = document.getElementById(divId).style;
	}
	this.setBackground = od_object_setBackground;
}
// Uses AlphaImageLoader filter, or the css background property,
// as appropriate, to apply a PNG or GIF as the background of the layerObject.
// La til background-repeat
function od_object_setBackground() {
	if (pngAlpha) {
		this.layerObject.background = "none";
		this.layerObject.zoom = "1";
		this.layerObject.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled = true, src='"+this.path+".png', sizingMethod='scale')";
		//~ this.layerObject.filter = "progid:DXImageTransform.Microsoft.Alpha(opacity=70)";
	} else if (pngNormal) {
		this.layerObject.backgroundImage = 'url('+this.path+'.png)';
		this.layerObject.backgroundRepeat = 'repeat';
	} else {
		this.layerObject.backgroundImage = 'url('+this.path+'.gif)';
		this.layerObject.backgroundRepeat = 'repeat';
	}
}
//---------------------------------------------------------------

//---------------------------------------------------------------
// OPACITY DISPLAY FUNCTION
// Outputs the image as a div with the AlphaImageLoader, or with
// a standard image tag.
function od_displayImage(strId, strPath, intWidth, intHeight, strClass, strAlt) {	
	if (pngAlpha) {
		document.write('<div style="height:'+intHeight+'px;width:'+intWidth+'px;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\''+strPath+'.png\', sizingMethod=\'scale\')" id="'+strId+'" class="'+strClass+'"></div>');
	} else if (pngNormal) {
		document.write('<img src="'+strPath+'.png" width="'+intWidth+'" height="'+intHeight+'" name="'+strId+'" border="0" class="'+strClass+'" alt="'+strAlt+'" />');
	} else {
		document.write('<img src="'+strPath+'.gif" width="'+intWidth+'" height="'+intHeight+'" name="'+strId+'" border="0" class="'+strClass+'" alt="'+strAlt+'" />');
	}
}
//---------------------------------------------------------------

//---------------------------------------------------------------
// global variables

// if IE5.5+ on win32, then display PNGs with AlphaImageLoader
if ((browser.isIE55 || browser.isIE6up) && browser.isWin32) {
	var pngAlpha = true;
	var strExt = ".png";
// else, if the browser can display PNGs normally, then do that. that list includes:
	//     -Gecko Engine: Netscape 6 or Mozilla, Mac or PC
	//     -IE5+ Mac (OpacityObject applies the background image at 100% opacity)
	//     -Opera 6+ PC
	//     -Opera 5+ Mac (Doesn't support dynamically-set background images)
	//     -Opera 6+ Linux 
	//     -Omniweb 3.1+ 
	//     -Icab 1.9+ 
	//     -WebTV 
	//     -Sega Dreamcast
} else if ((browser.isGecko) || (browser.isIE5up && browser.isMac) || (browser.isOpera && browser.isWin && browser.versionMajor >= 6) || (browser.isOpera && browser.isUnix && browser.versionMajor >= 6) || (browser.isOpera && browser.isMac && browser.versionMajor >= 5) || (browser.isOmniweb && browser.versionMinor >= 3.1) || (browser.isIcab && browser.versionMinor >= 1.9) || (browser.isWebtv) || (browser.isDreamcast)) {
	var pngNormal = true;
	var strExt = ".png";
	// otherwise, we use plain old GIFs
} else {
	var strExt = ".gif";
}

var ns = (document.all)?false:true;
var browserVersion = parseFloat(navigator.appVersion );
//---------------------------------------------------------------