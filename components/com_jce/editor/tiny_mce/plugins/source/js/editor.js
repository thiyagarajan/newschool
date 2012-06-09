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
(function(){var tinymce=window.parent.tinymce,DOM=tinymce.DOM,Event=tinymce.dom.Event;var SourceEditor={init:function(options,content){var self=this;if(Event.domLoaded){self.container=DOM.add(document.body,'div',{style:{width:options.width||'100%',height:options.height||'100%'},'class':'container'});self._load(options,content);}else{Event.add(document,'init',function(){self.init(options,content);});}},_load:function(o,content){var self=this,ed;o.load=tinymce.is(o.load,'function')?o.load:function(){};o.change=tinymce.is(o.change,'function')?o.change:function(){};if(window.CodeMirror){ed=CodeMirror(this.container,{mode:"application/x-httpd-php",theme:o.theme||'textmate',onChange:function(){o.change.call();},indentWithTabs:true,tabMode:"indent"});var hlLine=ed.setLineClass(0,"activeline");ed.setWrap=function(s){ed.setOption('lineWrapping',s);};ed.showGutter=function(s){ed.setOption('lineNumbers',s);};ed.highlight=function(s){var c=ed.getCursor();if(s){ed.setOption('mode','application/x-httpd-php');}else{ed.setOption('mode','text/plain');}
ed.setCursor(c);};ed.resize=function(w,h){DOM.setStyles(ed.getScrollerElement(),{width:w,height:h});DOM.setStyles(ed.getGutterElement(),{height:h});};ed.showInvisibles=function(s){};ed.setContent=function(v){if(v===''){v='\u00a0';}
return ed.setValue(v);};ed.insertContent=function(v){return ed.replaceSelection(v);};ed.getContent=function(){return ed.getValue();};this.editor=ed;this._loaded(o,content);}
if(window.ace){var editor=ace.edit(this.container);editor.getSession().on('change',o.change);editor.getSession().setMode("ace/mode/html");editor.indent();editor.setShowPrintMargin(false);editor.setWrap=function(s){editor.getSession().setUseWrapMode(s);};editor.showGutter=function(s){editor.renderer.setShowGutter(s);};editor.highlight=function(s){if(s){editor.getSession().setMode("ace/mode/html");}else{editor.getSession().setMode("ace/mode/text");}};editor.insertContent=function(v){editor.insert(v);};editor.getContent=function(){return editor.getSession().getValue();};editor.setContent=function(v){return editor.getSession().setValue(v);};editor.showInvisibles=function(v){};this.editor=editor;this._loaded(o,content);}},_loaded:function(o,content){this.setContent(content);this.setWrap(!!o.wrap);this.setNumbers(!!o.numbers);this.focus();o.load.call();},setWrap:function(s){return this.editor.setWrap(s);},setNumbers:function(s){return this.editor.showGutter(s);},setHighlight:function(s){return this.editor.highlight(s);},setContent:function(v){return this.editor.setContent(v);},insertContent:function(v){return this.editor.insertContent(v);},getContent:function(){return this.editor.getContent();},showInvisibles:function(s){return this.editor.showInvisibles(s);},resize:function(w,h){return this.editor.resize(w,h);},focus:function(){return this.editor.focus();},undo:function(){return this.editor.undo();},redo:function(){return this.editor.redo();},indent:function(){},getContainer:function(){return this.container||null;}};window.SourceEditor=SourceEditor;}());