/*  
 * JCE Editor                 2.1.3
 * @package                 JCE
 * @url                     http://www.joomlacontenteditor.net
 * @copyright               Copyright (C) 2006 - 2012 Ryan Demmer. All rights reserved
 * @license                 GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
 * @date                    19 May 2012
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * NOTE : Javascript files have been compressed for speed and can be uncompressed using http://jsbeautifier.org/
 */
tinyMCEPopup.requireLangPack();var AnchorDialog={init:function(ed){var n,name,id;tinyMCEPopup.restoreSelection();$('button#insert').button({icons:{primary:'ui-icon-check'}});$('button#cancel').button({icons:{primary:'ui-icon-close'}});var n=ed.selection.getNode();if(n.nodeName=='IMG'&&/mceItemAnchor/.test(n.className)){var data=tinymce.util.JSON.parse(ed.dom.getAttrib(n,'data-mce-json'));name=data.name||'';id=data.id||'';}else{n=ed.dom.getParent(n,'A');name=ed.dom.getAttrib(n,'name');id=ed.dom.getAttrib(n,'id');}
if(name||id){this.action='update';$('#insert').button('option','label',tinyMCEPopup.getLang('update','Update'));$('#anchorName').val(name);$('#anchorID').val(id);}
$('#jce').css('display','block');},update:function(){var ed=tinyMCEPopup.editor,n,name=$('#anchorName').val(),id=$('#anchorID').val();function check(s){return/^[a-z][a-z0-9\-\_:\.]*$/i.test(s);}
if(!name&&!id){tinyMCEPopup.alert('advanced_dlg.anchor_invalid');return;}
if((name&&!check(name))||(id&&!check(id))){tinyMCEPopup.alert('advanced_dlg.anchor_invalid');return;}
tinyMCEPopup.restoreSelection();if(this.action!='update'){ed.selection.collapse(1);}
var n=ed.selection.getNode(),data;if(ed.dom.is(n,'img.mceItemAnchor')){var o={};if(name){o.name=name;}
if(id){o.id=id;}
ed.dom.setAttrib(n,'data-mce-json',tinymce.util.JSON.serialize(o));}else{n=ed.dom.getParent(n,'A');var at={'class':'mceItemAnchor'};if(name){at.name=name;}
if(id){at.id=id;}
if(n){ed.dom.setAttribs(n,at);}else{ed.execCommand('mceInsertContent',0,ed.dom.createHTML('a',at,'\uFEFF'));}}
tinyMCEPopup.close();}};tinyMCEPopup.onInit.add(AnchorDialog.init,AnchorDialog);